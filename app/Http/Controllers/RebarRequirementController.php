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
        // Redirect to sites index - cutting logs page handles cross-site view
        return redirect()->route('admin.rebar.sites.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $site_id = request('site_id');
        $sites = \App\Models\ProjectSite::all();
        return view('admin.rebar.requirements.create', compact('site_id', 'sites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRebarRequirementRequest $request)
    {
        $requirement = RebarRequirement::create($request->validated());

        return redirect()->route('admin.rebar.sites.show', $requirement->site_id)
            ->with('success', 'Rebar requirement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RebarRequirement $requirement)
    {
        // Parameter name mismatch in resource controller generation, fixing to match model binding
        return view('admin.rebar.requirements.show', compact('requirement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RebarRequirement $requirement)
    {
        return view('admin.rebar.requirements.edit', compact('requirement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRebarRequirementRequest $request, RebarRequirement $requirement)
    {
        $requirement->update($request->validated());

        // Recalculate total length in case dimensions changed
        $requirement->total_length = ($requirement->required_length * $requirement->quantity);
        $requirement->save();

        return redirect()->route('admin.rebar.requirements.index')
            ->with('success', 'Rebar requirement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RebarRequirement $requirement)
    {
        $requirement->delete();

        return redirect()->route('admin.rebar.requirements.index')
            ->with('success', 'Rebar requirement deleted successfully.');
    }
}

