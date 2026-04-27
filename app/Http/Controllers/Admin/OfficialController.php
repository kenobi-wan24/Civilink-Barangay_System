<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Official;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class OfficialController extends Controller
{
    public function index()
    {
        $officials = Official::orderBy('sort_order')->get();
        return view('admin.officials.index', compact('officials'));
    }

    public function create()
    {
        return view('admin.officials.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:150',
            'position'   => 'required|string|max:100',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')
                ->store('officials', 'public');
        }

        $data['is_active']   = 1;
        $data['sort_order']  = $data['sort_order'] ?? Official::max('sort_order') + 1;

        Official::create($data);

        ActivityLog::record('created', "Added official: {$data['name']}");

        return redirect()->route('admin.officials.index')
            ->with('success', 'Official added successfully.');
    }

    public function edit(Official $official)
    {
        return view('admin.officials.edit', compact('official'));
    }

    public function update(Request $request, Official $official)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:150',
            'position'   => 'required|string|max:100',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')
                ->store('officials', 'public');
        }

        $official->update($data);

        ActivityLog::record('updated', "Updated official: {$official->name}");

        return redirect()->route('admin.officials.index')
            ->with('success', 'Official updated.');
    }

    public function destroy(Official $official)
    {
        $official->delete();

        ActivityLog::record('deleted', "Removed official: {$official->name}");

        return redirect()->route('admin.officials.index')
            ->with('success', 'Official removed.');
    }
}