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
        // 1. Site-wise Detailed Statistics
        $siteStats = ProjectSite::withCount(['requirements', 'cuttingLogs', 'offcuts'])
            ->get()
            ->map(function ($site) {
                // Total length and weight of rebar requested
                $totalRequestedLength = RebarRequirement::where('site_id', $site->id)->sum('total_length') ?: 0;
                $totalRequestedWeight = RebarRequirement::where('site_id', $site->id)->get()->sum('total_weight') ?: 0;

                // Total length and weight fabricated
                $totalFabricatedLength = RebarCuttingLog::where('site_id', $site->id)
                    ->selectRaw('SUM(cut_length * quantity_cut) as total')
                    ->value('total') ?: 0;
                $totalFabricatedWeight = RebarCuttingLog::where('site_id', $site->id)->sum('weight_kg') ?: 0;

                // Wastage (Scrap status)
                $scrapLength = Offcut::where('site_id', $site->id)
                    ->where('status', 'Scrap')
                    ->selectRaw('SUM(length * quantity) as total')
                    ->value('total') ?: 0;
                $scrapWeight = Offcut::where('site_id', $site->id)
                    ->where('status', 'Scrap')
                    ->get()
                    ->sum('weight_kg') ?: 0;

                // Reused (Used status)
                $reusedLength = Offcut::where('site_id', $site->id)
                    ->where('status', 'Used')
                    ->selectRaw('SUM(length * quantity) as total')
                    ->value('total') ?: 0;
                $reusedWeight = Offcut::where('site_id', $site->id)
                    ->where('status', 'Used')
                    ->get()
                    ->sum('weight_kg') ?: 0;

                // Available Offcuts
                $availableLength = Offcut::where('site_id', $site->id)
                    ->where('status', 'Available')
                    ->selectRaw('SUM(length * quantity) as total')
                    ->value('total') ?: 0;
                $availableWeight = Offcut::where('site_id', $site->id)
                    ->where('status', 'Available')
                    ->get()
                    ->sum('weight_kg') ?: 0;
                $availableCount = Offcut::where('site_id', $site->id)
                    ->where('status', 'Available')
                    ->sum('quantity') ?: 0;

                return [
                    'id' => $site->id,
                    'name' => $site->site_name,
                    'code' => $site->site_code,
                    'steel_grade' => $site->steel_grade,
                    'requirements_count' => $site->requirements_count,
                    'total_requested_length' => $totalRequestedLength,
                    'total_requested_weight' => $totalRequestedWeight,
                    'total_fabricated_length' => $totalFabricatedLength,
                    'total_fabricated_weight' => $totalFabricatedWeight,
                    'scrap_length' => $scrapLength,
                    'scrap_weight' => $scrapWeight,
                    'reused_length' => $reusedLength,
                    'reused_weight' => $reusedWeight,
                    'available_length' => $availableLength,
                    'available_weight' => $availableWeight,
                    'available_count' => $availableCount,
                    'progress' => $totalRequestedLength > 0 ? round(($totalFabricatedLength / $totalRequestedLength) * 100, 1) : 0,
                ];
            });

        // 2. Monthly Trend (Total Fabrication Length & Weight)
        if (config('database.default') === 'sqlite') {
            $monthlyTrend = RebarCuttingLog::selectRaw('strftime("%m-%Y", date) as month, SUM(cut_length * quantity_cut) as total_length, SUM(weight_kg) as total_weight')
                ->groupBy('month')
                ->orderByRaw('MIN(date)')
                ->limit(12)
                ->get();
        } else {
            $monthlyTrend = RebarCuttingLog::selectRaw('DATE_FORMAT(date, "%b %Y") as month, SUM(cut_length * quantity_cut) as total_length, SUM(weight_kg) as total_weight')
                ->groupBy('month')
                ->orderByRaw('MIN(date)')
                ->limit(12)
                ->get();
        }

        // 3. Diameter Distribution (Volume, Weight, Reused, Scrap)
        $diameterStats = RebarRequirement::selectRaw('bar_diameter, SUM(total_length) as req_length')
            ->groupBy('bar_diameter')
            ->orderBy('bar_diameter')
            ->get()
            ->map(function ($stat) {
                $dia = $stat->bar_diameter;

                $reqWeight = RebarRequirement::where('bar_diameter', $dia)->get()->sum('total_weight') ?: 0;
                
                $fabLength = RebarCuttingLog::where('bar_diameter', $dia)
                    ->selectRaw('SUM(cut_length * quantity_cut) as total')
                    ->value('total') ?: 0;
                $fabWeight = RebarCuttingLog::where('bar_diameter', $dia)->sum('weight_kg') ?: 0;

                $scrapLength = Offcut::where('bar_diameter', $dia)
                    ->where('status', 'Scrap')
                    ->selectRaw('SUM(length * quantity) as total')
                    ->value('total') ?: 0;

                $reusedLength = Offcut::where('bar_diameter', $dia)
                    ->where('status', 'Used')
                    ->selectRaw('SUM(length * quantity) as total')
                    ->value('total') ?: 0;

                return (object) [
                    'bar_diameter' => $dia,
                    'req_length' => $stat->req_length,
                    'req_weight' => $reqWeight,
                    'fab_length' => $fabLength,
                    'fab_weight' => $fabWeight,
                    'scrap_length' => $scrapLength,
                    'reused_length' => $reusedLength,
                ];
            });

        // 4. Steel Grade Statistics (Grade 300, 400, 500, 600)
        $gradeStats = collect([300, 400, 500, 600])->map(function ($grade) {
            $reqLength = RebarRequirement::where('steel_grade', $grade)->sum('total_length') ?: 0;
            $reqWeight = RebarRequirement::where('steel_grade', $grade)->get()->sum('total_weight') ?: 0;

            $fabLength = RebarCuttingLog::where('steel_grade', $grade)
                ->selectRaw('SUM(cut_length * quantity_cut) as total')
                ->value('total') ?: 0;
            $fabWeight = RebarCuttingLog::where('steel_grade', $grade)->sum('weight_kg') ?: 0;

            $scrapLength = Offcut::whereHas('site', function($q) use ($grade) {
                    $q->where('steel_grade', $grade);
                })
                ->where('status', 'Scrap')
                ->selectRaw('SUM(length * quantity) as total')
                ->value('total') ?: 0;

            return (object) [
                'steel_grade' => $grade,
                'req_length' => $reqLength,
                'req_weight' => $reqWeight,
                'fab_length' => $fabLength,
                'fab_weight' => $fabWeight,
                'scrap_length' => $scrapLength,
                'progress' => $reqLength > 0 ? round(($fabLength / $reqLength) * 100, 1) : 0,
            ];
        });

        // 5. Global Metrics
        $global = [
            'total_req_length' => $siteStats->sum('total_requested_length'),
            'total_req_weight' => $siteStats->sum('total_requested_weight'),
            'total_fab_length' => $siteStats->sum('total_fabricated_length'),
            'total_fab_weight' => $siteStats->sum('total_fabricated_weight'),
            'total_scrap_length' => $siteStats->sum('scrap_length'),
            'total_scrap_weight' => $siteStats->sum('scrap_weight'),
            'total_reused_length' => $siteStats->sum('reused_length'),
            'total_reused_weight' => $siteStats->sum('reused_weight'),
            'total_avail_length' => $siteStats->sum('available_length'),
            'total_avail_weight' => $siteStats->sum('available_weight'),
            'total_avail_count' => $siteStats->sum('available_count'),
        ];
        
        // Recycled/Re-use rate: percentage of cutting logs that used offcuts
        $totalCuts = RebarCuttingLog::sum('quantity_cut') ?: 1;
        $reusedCuts = RebarCuttingLog::whereNotNull('reused_offcut_id')->sum('quantity_cut') ?: 0;
        $global['reuse_rate_pct'] = round(($reusedCuts / $totalCuts) * 100, 1);
        
        // Average wastage percentage
        $global['wastage_pct'] = $global['total_fab_length'] > 0 
            ? round(($global['total_scrap_length'] / ($global['total_fab_length'] + $global['total_scrap_length'])) * 100, 1)
            : 0;

        // 6. Recent highlights (events)
        $recentLogs = RebarCuttingLog::with('requirement', 'site', 'reusedOffcut')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.rebar.reports', compact('siteStats', 'monthlyTrend', 'diameterStats', 'gradeStats', 'global', 'recentLogs'));
    }
}
