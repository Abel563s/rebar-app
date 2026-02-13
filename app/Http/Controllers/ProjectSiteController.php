<?php

namespace App\Http\Controllers;

use App\Models\ProjectSite;
use Illuminate\Http\Request;

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
            'notes' => 'nullable|string',
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
        $totalLength = $site->requirements()->sum(\DB::raw('required_length * quantity')); // in meters
        $totalBars = $site->requirements()->sum('quantity');

        // Estimated tonnage (assuming roughly)
        // Weight (kg) = (d^2 / 162) * length(m)
        // For simplicity we can just sum weights if we had a weight column or a helper.
        // Let's assume a default diameter of 12 for estimation if not specified, 
        // but it's better to sum per diameter.

        $tonnage = $site->requirements()->get()->sum(function ($req) {
            // Weight formula: d^2 / 162 * length (meters)
            return (($req->bar_diameter * $req->bar_diameter) / 162) * ($req->required_length * $req->quantity);
        }) / 1000; // to tonnes

        return view('admin.rebar.sites.show', compact('site', 'requirements', 'offcuts', 'totalLength', 'totalBars', 'tonnage'));
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
            'notes' => 'nullable|string',
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
