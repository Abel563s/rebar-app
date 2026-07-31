<?php

namespace App\Http\Controllers;

use App\Models\RebarRequirement;
use App\Http\Requests\StoreRebarRequirementRequest;
use App\Http\Requests\UpdateRebarRequirementRequest;

class RebarRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->isQuantitySurveyor()) {
            abort(403);
        }

        $query = RebarRequirement::with('site');

        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('tracking_id', 'like', "%{$search}%")
                  ->orWhere('structural_element', 'like', "%{$search}%")
                  ->orWhere('drawing_reference', 'like', "%{$search}%");
            });
        }

        if (request('diameter')) {
            $query->where('bar_diameter', request('diameter'));
        }

        if (request('steel_grade')) {
            $query->where('steel_grade', request('steel_grade'));
        }

        if (request('element')) {
            $query->where('structural_element', 'like', '%' . request('element') . '%');
        }

        $totalRequirements = $query->count();
        $requirements = $query->latest()->paginate(15);

        return view('admin.rebar.requirements.index', compact('requirements', 'totalRequirements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSiteEngineer()) {
            abort(403);
        }
        $site_id = request('site_id');
        $sites = \App\Models\ProjectSite::all();
        return view('admin.rebar.requirements.create', compact('site_id', 'sites'));
    }

    public function store(StoreRebarRequirementRequest $request)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSiteEngineer()) {
            abort(403);
        }

        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        $requirement = RebarRequirement::create($validated);

        return redirect()->route('admin.rebar.sites.show', $requirement->site_id)
            ->with('success', 'Rebar requirement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RebarRequirement $requirement)
    {
        $user = auth()->user();
        if ($user->isQuantitySurveyor()) {
            abort(403);
        }

        // Parameter name mismatch in resource controller generation, fixing to match model binding
        return view('admin.rebar.requirements.show', compact('requirement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RebarRequirement $requirement)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSiteEngineer()) {
            abort(403);
        }
        if (!$user->isAdmin() && $requirement->user_id !== $user->id) {
            abort(403);
        }
        return view('admin.rebar.requirements.edit', compact('requirement'));
    }

    public function update(UpdateRebarRequirementRequest $request, RebarRequirement $requirement)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSiteEngineer()) {
            abort(403);
        }
        if (!$user->isAdmin() && $requirement->user_id !== $user->id) {
            abort(403);
        }

        $requirement->update($request->validated());

        $requirement->total_length = ($requirement->required_length * $requirement->quantity);
        $requirement->save();

        return redirect()->route('admin.rebar.requirements.index')
            ->with('success', 'Rebar requirement updated successfully.');
    }

    public function destroy(RebarRequirement $requirement)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSiteEngineer()) {
            abort(403);
        }
        if (!$user->isAdmin() && $requirement->user_id !== $user->id) {
            abort(403);
        }

        $requirement->delete();

        return redirect()->route('admin.rebar.requirements.index')
            ->with('success', 'Rebar requirement deleted successfully.');
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\RebarRequirementTemplateExport(),
            'rebar_requirements_template.xlsx'
        );
    }

    public function importForm()
    {
        $site_id = request('site_id');
        return view('admin.rebar.requirements.import', compact('site_id'));
    }

    public function import(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
            'site_id' => 'nullable|exists:project_sites,id',
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(
                new \App\Imports\RebarRequirementImport($request->site_id, auth()->id()),
                $request->file('file')
            );

            return redirect()->back()->with('success', 'Rebar requirements imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage())->withInput();
        }
    }
}

