<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function index(Request $request)
    {
        $query = Resident::latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('first_name',     'like', "%$s%")
                  ->orWhere('last_name',    'like', "%$s%")
                  ->orWhere('resident_code','like', "%$s%");
            });
        }

        if ($request->filled('zone')) {
            $query->where('purok_zone', $request->zone);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('status')) {
            match($request->status) {
                'voter'       => $query->where('is_voter', 1),
                'senior'      => $query->where('is_senior_citizen', 1),
                'pwd'         => $query->where('is_pwd', 1),
                'solo_parent' => $query->where('is_solo_parent', 1),
                'inactive'    => $query->where('is_active', 0),
                default       => $query->where('is_active', 1),
            };
        } else {
            $query->where('is_active', 1);
        }

        $residents = $query->paginate(15)->withQueryString();
        $total     = Resident::where('is_active', 1)->count();

        return view('admin.residents.index', compact('residents', 'total'));
    }

    public function create()
    {
        return view('admin.residents.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'       => 'required|string|max:80',
            'middle_name'      => 'nullable|string|max:80',
            'last_name'        => 'required|string|max:80',
            'suffix'           => 'nullable|string|max:10',
            'birthdate'        => 'required|date|before:today',
            'gender'           => 'required|in:male,female,other',
            'civil_status'     => 'required|in:single,married,widowed,separated',
            'purok_zone'       => 'required|string|max:100',
            'address'          => 'required|string|max:500',
            'contact_number'   => 'nullable|string|max:20',
            'email'            => 'nullable|email|max:150',
            'profile_picture'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Auto-generate resident code
        $data['resident_code'] = 'BRY-' . date('Y') . '-' .
            str_pad(Resident::count() + 1, 4, '0', STR_PAD_LEFT);

        // Checkboxes — unchecked = absent from request
        foreach (['is_voter','is_senior_citizen','is_pwd','is_solo_parent'] as $flag) {
            $data[$flag] = $request->boolean($flag) ? 1 : 0;
        }

        $data['is_active'] = 1;

        // Profile picture upload
        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request
                ->file('profile_picture')
                ->store('profiles', 'public');
        }

        $resident = Resident::create($data);

        ActivityLog::record('created', "Added new resident: {$resident->full_name}", $resident);

        return redirect()
            ->route('admin.residents.show', $resident)
            ->with('success', "Resident {$resident->full_name} added successfully.");
    }

    public function show(Resident $resident)
    {
        $resident->load('documentRequests.documentType');
        return view('admin.residents.show', compact('resident'));
    }

    public function edit(Resident $resident)
    {
        return view('admin.residents.edit', compact('resident'));
    }

    public function update(Request $request, Resident $resident)
    {
        $data = $request->validate([
            'first_name'       => 'required|string|max:80',
            'middle_name'      => 'nullable|string|max:80',
            'last_name'        => 'required|string|max:80',
            'suffix'           => 'nullable|string|max:10',
            'birthdate'        => 'required|date|before:today',
            'gender'           => 'required|in:male,female,other',
            'civil_status'     => 'required|in:single,married,widowed,separated',
            'purok_zone'       => 'required|string|max:100',
            'address'          => 'required|string|max:500',
            'contact_number'   => 'nullable|string|max:20',
            'email'            => 'nullable|email|max:150',
            'profile_picture'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        foreach (['is_voter','is_senior_citizen','is_pwd','is_solo_parent'] as $flag) {
            $data[$flag] = $request->boolean($flag) ? 1 : 0;
        }

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request
                ->file('profile_picture')
                ->store('profiles', 'public');
        }

        $resident->update($data);

        ActivityLog::record('updated', "Updated resident: {$resident->full_name}", $resident);

        return redirect()
            ->route('admin.residents.show', $resident)
            ->with('success', 'Resident updated successfully.');
    }

    public function destroy(Resident $resident)
    {
        $resident->update(['is_active' => 0]);

        ActivityLog::record('deactivated', "Deactivated resident: {$resident->full_name}", $resident);

        return redirect()
            ->route('admin.residents.index')
            ->with('success', "{$resident->full_name} has been deactivated.");
    }

    public function reactivate(Resident $resident)
    {
        $resident->update(['is_active' => 1]);

        ActivityLog::record('reactivated', "Reactivated resident: {$resident->full_name}", $resident);

        return redirect()
            ->route('admin.residents.show', $resident)
            ->with('success', "{$resident->full_name} has been reactivated.");
    }
}