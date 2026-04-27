<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use App\Models\DocumentType;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = DocumentRequest::with(['resident', 'documentType'])->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('resident', function ($q) use ($s) {
                $q->where('first_name', 'like', "%$s%")
                  ->orWhere('last_name',  'like', "%$s%");
            })->orWhere('request_code', 'like', "%$s%");
        }

        $requests  = $query->paginate(10)->withQueryString();

        $counts = [
            'pending'  => DocumentRequest::where('status', 'pending')->count(),
            'approved' => DocumentRequest::where('status', 'approved')->count(),
            'released' => DocumentRequest::where('status', 'released')->count(),
            'rejected' => DocumentRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.document-requests.index',
            compact('requests', 'counts'));
    }

    public function show(DocumentRequest $documentRequest)
    {
        $documentRequest->load([
            'resident',
            'documentType',
            'approvedBy',
            'releasedBy',
        ]);

        return view('admin.document-requests.show',
            compact('documentRequest'));
    }

    public function approve(Request $request, DocumentRequest $documentRequest)
    {
        if ($documentRequest->status !== 'pending') {
            return back()->withErrors(['error' => 'Only pending requests can be approved.']);
        }

        $documentRequest->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        ActivityLog::record(
            'approved',
            "Approved {$documentRequest->documentType->name} for {$documentRequest->resident->full_name}",
            $documentRequest
        );

        return back()->with('success', 'Request approved successfully.');
    }

    public function reject(Request $request, DocumentRequest $documentRequest)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ], [
            'admin_notes.required' => 'Please provide a reason for rejection.',
        ]);

        if (!in_array($documentRequest->status, ['pending', 'approved'])) {
            return back()->withErrors(['error' => 'This request cannot be rejected.']);
        }

        $documentRequest->update([
            'status'      => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        ActivityLog::record(
            'rejected',
            "Rejected {$documentRequest->documentType->name} for {$documentRequest->resident->full_name}",
            $documentRequest
        );

        return back()->with('success', 'Request rejected.');
    }

    public function release(DocumentRequest $documentRequest)
    {
        if ($documentRequest->status !== 'approved') {
            return back()->withErrors(['error' => 'Only approved requests can be released.']);
        }

        $documentRequest->update([
            'status'      => 'released',
            'released_by' => auth()->id(),
            'released_at' => now(),
        ]);

        ActivityLog::record(
            'released',
            "Released {$documentRequest->documentType->name} for {$documentRequest->resident->full_name}",
            $documentRequest
        );

        return back()->with('success', 'Document released successfully.');
    }

    public function preview(DocumentRequest $documentRequest)
    {
        $documentRequest->load(['resident', 'documentType', 'approvedBy']);

        $template = $documentRequest->documentType->template_path;

        $pdf = Pdf::loadView($template, ['req' => $documentRequest])
            ->setPaper('a4', 'portrait');

        return $pdf->stream(
            Str::slug($documentRequest->documentType->name) . '-' .
            $documentRequest->request_code . '.pdf'
        );
    }

    // Returns the raw HTML certificate for iframe embedding
    public function inline(DocumentRequest $documentRequest)
    {
        $documentRequest->load(['resident', 'documentType', 'approvedBy']);

        $template = $documentRequest->documentType->template_path;

        return response()->view($template, ['req' => $documentRequest])
            ->header('Content-Type', 'text/html');
    }
}