<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::latest('created_at')->paginate(15);
        $unreadCount = Inquiry::where('is_read', 0)->count();

        return view('admin.inquiries.index', compact('inquiries', 'unreadCount'));
    }

    public function show(Inquiry $inquiry)
    {
        if (!$inquiry->is_read) {
            $inquiry->update(['is_read' => 1]);
        }

        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function update(Inquiry $inquiry)
    {
        $inquiry->update(['is_read' => !$inquiry->is_read]);

        return back()->with('success',
            $inquiry->is_read ? 'Marked as read.' : 'Marked as unread.');
    }
}