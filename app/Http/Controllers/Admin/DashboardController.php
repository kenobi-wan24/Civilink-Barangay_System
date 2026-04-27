<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\DocumentRequest;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_residents' => Resident::where('is_active', 1)->count(),
            'pending'         => DocumentRequest::where('status', 'pending')->count(),
            'approved'        => DocumentRequest::where('status', 'approved')->count(),
            'released'        => DocumentRequest::where('status', 'released')->count(),
            'total_requests'  => DocumentRequest::count(),
            'new_this_month'  => Resident::where('is_active', 1)
                                    ->whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count(),
        ];

        // Monthly resident growth for chart (last 7 months)
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartData[] = [
                'month' => $month->format('M'),
                'count' => Resident::where('is_active', 1)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
            ];
        }

        // Recent activity
        $recentActivity = ActivityLog::with('user')
            ->latest('created_at')
            ->take(5)
            ->get();

        // Recent document requests
        $recentRequests = DocumentRequest::with(['resident', 'documentType'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'chartData', 'recentActivity', 'recentRequests'
        ));
    }
}