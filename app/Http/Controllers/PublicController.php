<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Official;
use App\Models\Resident;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $announcements = Announcement::published()->take(3)->get();
        $residentCount = Resident::where('is_active', 1)->count();

        return view('public.home', compact('announcements', 'residentCount'));
    }

    public function officials()
    {
        $all = Official::active()->get();

        // Split by position — the seeder/admin determines these labels
        $captain    = $all->first(fn($o) => str_contains($o->position, 'Captain'));
        $councilors = $all->filter(fn($o) => str_contains($o->position, 'Kagawad')
                                      || str_contains($o->position, 'Councilor'));
        $sk         = $all->first(fn($o) => str_contains($o->position, 'SK'));
        $secretary  = $all->first(fn($o) => str_contains($o->position, 'Secretary'));
        $treasurer  = $all->first(fn($o) => str_contains($o->position, 'Treasurer'));

        $adminCore  = $all->filter(fn($o) =>
            str_contains($o->position, 'Secretary') ||
            str_contains($o->position, 'Treasurer')
        );

        return view('public.officials', compact(
            'captain', 'councilors', 'sk', 'adminCore'
        )); 
    }

    public function announcements(Request $request)
    {
        $featured = Announcement::published()->latest()->first();

        $announcements = Announcement::published()
            ->when($request->filled('search'), fn($q) =>
                $q->where('title', 'like', '%'.$request->search.'%')
            )
            ->when(
                $request->filled('category') && $request->category !== 'all',
            fn($q) => $q->where('category', $request->category)
            )
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('public.announcements', compact('featured', 'announcements'));
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function storeInquiry(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:150',
            'email'   => 'required|email',
            'purpose' => 'nullable|string|max:100',
            'message' => 'required|string|max:2000',
        ]);

        Inquiry::create($request->only('name', 'email', 'purpose', 'message'));

        return back()->with('success', 'Your message has been sent. We will get back to you shortly.');
    }

    public function about()
    {
        return view('public.about');
    }
}