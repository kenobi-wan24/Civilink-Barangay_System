<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'    => 'required|string|max:200',
            'category' => 'required|string|max:50',
            'content'  => 'required|string',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('announcements', 'public');
        }

        $data['posted_by']    = auth()->id();
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;

        $ann = Announcement::create($data);

        ActivityLog::record('created', "Posted announcement: {$ann->title}");

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement saved.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title'    => 'required|string|max:200',
            'category' => 'required|string|max:50',
            'content'  => 'required|string',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('announcements', 'public');
        }

        $wasPublished       = $announcement->is_published;
        $data['is_published'] = $request->boolean('is_published');

        if ($data['is_published'] && !$wasPublished) {
            $data['published_at'] = now();
        } elseif (!$data['is_published']) {
            $data['published_at'] = null;
        }

        $announcement->update($data);

        ActivityLog::record('updated', "Updated announcement: {$announcement->title}");

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        ActivityLog::record('deleted', "Deleted announcement: {$announcement->title}");

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted.');
    }
}