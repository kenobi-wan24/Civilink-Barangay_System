<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class PortalController extends Controller
{
    public function requestForm()
    {
        // If account not linked to a resident profile yet
        if (!auth()->user()->resident_id) {
            return view('resident.pending');
        }

        $documentTypes = DocumentType::active()->get();

        // Check for existing pending requests (for soft warning)
        $pendingTypes = DocumentRequest::where('resident_id', auth()->user()->resident_id)
            ->where('status', 'pending')
            ->pluck('document_type_id')
            ->toArray();

        return view('resident.request',
            compact('documentTypes', 'pendingTypes'));
    }

    public function submitRequest(Request $request)
    {
        // Guard — must be linked
        if (!auth()->user()->resident_id) {
            return redirect()->route('resident.request.form');
        }

        $request->validate([
            'document_type_id' => 'required|exists:document_types,id',
            'purpose'          => 'required|string|min:5|max:500',
        ], [
            'document_type_id.required' => 'Please select a document type.',
            'purpose.required'          => 'Please state your purpose.',
            'purpose.min'               => 'Purpose must be at least 5 characters.',
        ]);

        $requestCode = 'REQ-' . date('Y') . '-' .
            str_pad(DocumentRequest::count() + 1, 4, '0', STR_PAD_LEFT);

        DocumentRequest::create([
            'request_code'     => $requestCode,
            'resident_id'      => auth()->user()->resident_id,
            'document_type_id' => $request->document_type_id,
            'purpose'          => $request->purpose,
            'status'           => 'pending',
            'requested_at'     => now(),
        ]);

        return redirect()->route('resident.my-requests')
            ->with('success', 'Your request has been submitted successfully. We will process it within 1-2 working days.');
    }

    public function myRequests()
    {
        if (!auth()->user()->resident_id) {
            return view('resident.pending');
        }

        $requests = DocumentRequest::with('documentType')
            ->where('resident_id', auth()->user()->resident_id)
            ->latest('requested_at')
            ->get();

        return view('resident.my-requests', compact('requests'));
    }

    public function viewDocument(DocumentRequest $documentRequest)
    {
        // Security: must belong to this resident
        if ($documentRequest->resident_id !== auth()->user()->resident_id) {
            abort(403, 'Unauthorized.');
        }

        // Security: must be released
        if ($documentRequest->status !== 'released') {
            abort(403, 'Document is not yet available for download.');
        }

        $documentRequest->load(['resident', 'documentType', 'approvedBy']);

        $template = $documentRequest->documentType->template_path;

        $pdf = Pdf::loadView($template, ['req' => $documentRequest])
            ->setPaper('a4', 'portrait');

        return $pdf->stream(
            Str::slug($documentRequest->documentType->name) . '-' .
            $documentRequest->request_code . '.pdf'
        );
    }
}