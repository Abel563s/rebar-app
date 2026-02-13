<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RebarDashboardController extends Controller
{
    public function index()
    {
        // 1. Total Rebar Requirements
        $totalRequirements = \App\Models\RebarRequirement::count();

        // 2. Total Steel Requested (meters)
        $totalRequestedLength = \App\Models\RebarRequirement::sum('total_length');

        // 3. Available Off-Cuts
        $availableOffcuts = \App\Models\Offcut::where('status', 'Available')->count();

        // 4. Steel Saved Using Off-Cuts (meters)
        // Calculated by summing the cut_length of logs where offcut_id IS NOT NULL (meaning it was cut for a new purpose) 
        // OR simply summing the length used from offcuts. 
        // Wait, cutting logs tracks usage. If used_for is populated or linked to requirement?
        // Let's assume 'used' offcuts contribute to saved steel.
        // Or if we track 'cut_length' in cutting logs where source was an offcut?
        // Current cutting log model: has 'offcut_id' but it foreign keys to the offcut PRODUCED.

        // Actually, if we use an offcut, we should update its status to 'Used'.
        // We probably need a way to track WHEN an offcut is used.
        // For now, let's just sum the length of 'Used' offcuts as "Saved Steel".
        $steelSaved = \App\Models\Offcut::where('status', 'Used')->sum('length');

        // 5. Total Scrap (m)
        $totalScrap = \App\Models\Offcut::where('status', 'Scrap')->sum('length');

        // 6. Recent Fabrications
        $recentFabrications = \App\Models\RebarCuttingLog::with('requirement')
            ->latest()
            ->limit(5)
            ->get();

        // 7. Top 5 Structural Elements
        $topElements = \App\Models\RebarRequirement::selectRaw('structural_element, sum(total_length) as volume')
            ->groupBy('structural_element')
            ->orderByDesc('volume')
            ->limit(5)
            ->get();

        // Status Pie
        $offcutStats = \App\Models\Offcut::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Usage Trend (Last 6 months of requirements)
        $usageTrend = \App\Models\RebarRequirement::selectRaw('DATE_FORMAT(created_at, "%b %Y") as month, sum(total_length) as total')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->pluck('total', 'month')
            ->toArray();

        return view('admin.rebar.dashboard', compact(
            'totalRequirements',
            'totalRequestedLength',
            'availableOffcuts',
            'steelSaved',
            'totalScrap',
            'recentFabrications',
            'topElements',
            'offcutStats',
            'usageTrend'
        ));
    }
}
