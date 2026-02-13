<?php

namespace App\Http\Controllers;

use App\Models\ProjectSite;
use App\Models\RebarRequirement;
use App\Models\RebarCuttingLog;
use App\Models\Offcut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RebarReportController extends Controller
{
    public function index()
    {
        // 1. Site-wise Statistics
        $siteStats = ProjectSite::withCount(['requirements', 'cuttingLogs', 'offcuts'])
            ->get()
            ->map(function ($site) {
                $totalRequested = RebarRequirement::where('site_id', $site->id)->sum('total_length');
                $totalFabricated = RebarCuttingLog::where('site_id', $site->id)->sum('cut_length');

                $wastage = Offcut::where('site_id', $site->id)
                    ->where('status', 'Scrap')
                    ->sum('length');

                $savings = Offcut::where('site_id', $site->id)
                    ->where('status', 'Used')
                    ->sum('length');

                return [
                    'id' => $site->id,
                    'name' => $site->site_name,
                    'code' => $site->site_code,
                    'requirements_count' => $site->requirements_count,
                    'total_requested' => $totalRequested,
                    'total_fabricated' => $totalFabricated,
                    'wastage' => $wastage,
                    'savings' => $savings,
                    'progress' => $totalRequested > 0 ? round(($totalFabricated / $totalRequested) * 100, 1) : 0,
                ];
            });

        // 2. Monthly Trend (Total Fabrication)
        $monthlyTrend = RebarCuttingLog::selectRaw('DATE_FORMAT(date, "%b %Y") as month, SUM(cut_length) as total')
            ->groupBy('month')
            ->orderByRaw('MIN(date)')
            ->limit(12)
            ->get();

        // 3. Diameter Distribution
        $diameterStats = RebarRequirement::selectRaw('bar_diameter, SUM(total_length) as volume')
            ->groupBy('bar_diameter')
            ->orderBy('bar_diameter')
            ->get();

        return view('admin.rebar.reports', compact('siteStats', 'monthlyTrend', 'diameterStats'));
    }
}
