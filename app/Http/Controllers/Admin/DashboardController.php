<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RebarRequirement;
use App\Models\RebarCuttingLog;
use App\Models\Offcut;
use App\Models\ProjectSite;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $totalSites = ProjectSite::count();
        $activeSites = ProjectSite::where('status', 'Active')->count();
        $totalRequirements = RebarRequirement::count();
        $totalFabrications = RebarCuttingLog::count();
        $availableOffcuts = Offcut::where('status', 'Available')->count();
        $usedOffcuts = Offcut::where('status', 'Used')->count();
        $scrapOffcuts = Offcut::where('status', 'Scrap')->count();
        $totalOffcuts = Offcut::count();
        $steelSaved = Offcut::where('status', 'Used')->sum('length');
        $totalScrap = Offcut::where('status', 'Scrap')->sum('length');
        $totalRequestedLength = RebarRequirement::sum('total_length');
        $totalFabricatedLength = RebarCuttingLog::sum(DB::raw('cut_length * quantity_cut'));
        $recentFabrications = RebarCuttingLog::with(['requirement', 'site'])
            ->latest()
            ->limit(8)
            ->get();

        $monthlyFabrication = RebarCuttingLog::selectRaw('DATE_FORMAT(created_at, "%b %Y") as month, SUM(cut_length * quantity_cut) as total_length, SUM(weight_kg) as total_weight')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->get();

        $topUsers = RebarCuttingLog::select('user_id', DB::raw('COUNT(*) as cut_count'), DB::raw('SUM(cut_length * quantity_cut) as total_length'))
            ->groupBy('user_id')
            ->orderByDesc('cut_count')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $user = User::find($item->user_id);
                return [
                    'name' => $user?->name ?? 'Unknown',
                    'cut_count' => $item->cut_count,
                    'total_length' => $item->total_length,
                ];
            });

        $diameterDistribution = RebarCuttingLog::select('bar_diameter', DB::raw('COUNT(*) as count'), DB::raw('SUM(cut_length * quantity_cut) as total_length'))
            ->groupBy('bar_diameter')
            ->orderByDesc('count')
            ->limit(6)
            ->get();

        $gradeDistribution = RebarRequirement::select('steel_grade', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_length) as total_length'))
            ->groupBy('steel_grade')
            ->orderByDesc('total_length')
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'activeUsers', 'totalSites', 'activeSites',
            'totalRequirements', 'totalFabrications',
            'availableOffcuts', 'usedOffcuts', 'scrapOffcuts', 'totalOffcuts',
            'steelSaved', 'totalScrap', 'totalRequestedLength', 'totalFabricatedLength',
            'recentFabrications', 'monthlyFabrication', 'topUsers',
            'diameterDistribution', 'gradeDistribution'
        ));
    }
}
