<?php

namespace App\Http\Controllers;

use App\Models\ProjectSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectSiteController extends Controller
{
    public function index()
    {
        $sites = ProjectSite::latest()->paginate(12);
        return view('admin.rebar.sites.index', compact('sites'));
    }

    public function create()
    {
        return view('admin.rebar.sites.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
            'site_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'sector' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Completed',
            'steel_grade' => 'required|string|in:300,400,500,600',
            'notes' => 'nullable|string',
            'manager_id' => 'nullable|exists:users,id',
            'amount_needed_08' => 'nullable|numeric|min:0',
            'amount_needed_10' => 'nullable|numeric|min:0',
            'amount_needed_12' => 'nullable|numeric|min:0',
            'amount_needed_14' => 'nullable|numeric|min:0',
            'amount_needed_16' => 'nullable|numeric|min:0',
            'amount_needed_18' => 'nullable|numeric|min:0',
            'amount_needed_20' => 'nullable|numeric|min:0',
            'amount_needed_24' => 'nullable|numeric|min:0',
            'amount_needed_28' => 'nullable|numeric|min:0',
            'amount_needed_32' => 'nullable|numeric|min:0',
        ]);

        ProjectSite::create($validated);

        return redirect()->route('admin.rebar.sites.index')
            ->with('success', 'Project site created successfully.');
    }

    public function show(ProjectSite $site)
    {
        $requirements = $site->requirements()->latest()->paginate(10);
        $offcuts = $site->offcuts()->latest()->get();

        // Metrics calculation
        $totalLength = $site->requirements()->sum('total_length');
        $totalBars = $site->requirements()->sum('quantity');
        $tonnage = $site->requirements()->sum('weight_kg') / 1000; // KG to Tons

        $usageByDiameter = DB::table('rebar_cutting_logs')
            ->where('site_id', $site->id)
            ->select('bar_diameter', DB::raw('SUM(weight_kg) as total_weight'), DB::raw('SUM(quantity_cut) as total_pieces'))
            ->groupBy('bar_diameter')
            ->get()
            ->keyBy('bar_diameter');

        $totalPcsNeeded = 0;
        foreach (['08', '10', '12', '14', '16', '18', '20', '24', '28', '32'] as $d) {
            $totalPcsNeeded += (int)($site->{'amount_needed_'.$d} ?? 0);
        }
        $totalKgCut = $usageByDiameter->sum('total_weight');

        return view('admin.rebar.sites.show', compact('site', 'requirements', 'offcuts', 'totalLength', 'totalBars', 'tonnage', 'usageByDiameter', 'totalPcsNeeded', 'totalKgCut'));
    }

    public function edit(ProjectSite $site)
    {
        return view('admin.rebar.sites.edit', compact('site'));
    }

    public function update(Request $request, ProjectSite $site)
    {
        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
            'site_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'sector' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Completed',
            'steel_grade' => 'required|string|in:300,400,500,600',
            'notes' => 'nullable|string',
            'manager_id' => 'nullable|exists:users,id',
            'amount_needed_08' => 'nullable|numeric|min:0',
            'amount_needed_10' => 'nullable|numeric|min:0',
            'amount_needed_12' => 'nullable|numeric|min:0',
            'amount_needed_14' => 'nullable|numeric|min:0',
            'amount_needed_16' => 'nullable|numeric|min:0',
            'amount_needed_18' => 'nullable|numeric|min:0',
            'amount_needed_20' => 'nullable|numeric|min:0',
            'amount_needed_24' => 'nullable|numeric|min:0',
            'amount_needed_28' => 'nullable|numeric|min:0',
            'amount_needed_32' => 'nullable|numeric|min:0',
        ]);

        $site->update($validated);

        return redirect()->route('admin.rebar.sites.index')
            ->with('success', 'Project site updated successfully.');
    }

    public function destroy(ProjectSite $site)
    {
        $site->delete();
        return redirect()->route('admin.rebar.sites.index')
            ->with('success', 'Project site deleted successfully.');
    }

    public function generateCuttingPlan(ProjectSite $site)
    {
        // Get all requirements for this site
        $requirements = $site->requirements()->where('quantity', '>', 0)->get();

        if ($requirements->isEmpty()) {
            return redirect()->back()
                ->with('error', 'No active requirements found for this site. Please add requirements first.');
        }

        // Basic cutting plan logic - group by diameter
        $plan = [];
        foreach ($requirements as $req) {
            $diameter = $req->bar_diameter;
            if (!isset($plan[$diameter])) {
                $plan[$diameter] = [
                    'total_length_needed' => 0,
                    'total_bars_needed' => 0,
                    'requirements' => []
                ];
            }

            $plan[$diameter]['total_length_needed'] += ($req->required_length * $req->quantity);
            $plan[$diameter]['total_bars_needed'] += $req->quantity;
            $plan[$diameter]['requirements'][] = $req;
        }

        // Store the plan in session for display
        session(['cutting_plan' => $plan, 'cutting_plan_site' => $site->id]);

        return redirect()->route('admin.rebar.sites.show', $site)
            ->with('success', 'Cutting plan generated successfully! Review the optimized cutting strategy below.');
    }
}
