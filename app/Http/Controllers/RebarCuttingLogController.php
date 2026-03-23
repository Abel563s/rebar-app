<?php

namespace App\Http\Controllers;

use App\Models\RebarCuttingLog;
use App\Http\Requests\StoreRebarCuttingLogRequest;
use App\Http\Requests\UpdateRebarCuttingLogRequest;

class RebarCuttingLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = RebarCuttingLog::with('requirement', 'offcut', 'site');

        if (request('site_id')) {
            $query->where('site_id', request('site_id'));
        }

        if (request('diameter')) {
            $query->where('bar_diameter', request('diameter'));
        }

        if (request('steel_grade')) {
            $query->where('steel_grade', request('steel_grade'));
        }

        if (request('min_length')) {
            $query->where('cut_length', '>=', request('min_length'));
        }

        if (request('max_length')) {
            $query->where('cut_length', '<=', request('max_length'));
        }

        if (request('date')) {
            $query->whereDate('date', request('date'));
        }

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('requirement', function ($rq) use ($search) {
                    $rq->where('tracking_id', 'like', "%{$search}%")
                        ->orWhere('structural_element', 'like', "%{$search}%");
                })->orWhere('used_for', 'like', "%{$search}%");
            });
        }

        $logs = $query->latest()->paginate(10)->withQueryString();
        $sites = \App\Models\ProjectSite::orderBy('site_name')->get();

        return view('admin.rebar.cutting_logs.index', compact('logs', 'sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Typically created from the requirement view, but can exist standalone
        $requirements = \App\Models\RebarRequirement::latest()->limit(50)->get();
        return view('admin.rebar.cutting_logs.create', compact('requirements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRebarCuttingLogRequest $request)
    {
        $validated = $request->validated();
        $requirement = \App\Models\RebarRequirement::findOrFail($validated['rebar_requirement_id']);

        $log = RebarCuttingLog::create(array_merge($validated, [
            'site_id' => $requirement->site_id,
        ]));

        // Decrease the requirement quantity by the amount cut
        $requirement->quantity -= $validated['quantity_cut'];
        $requirement->save();

        // Smart Automation: Create Off-cut if remaining length is NOT wastage
        $rebarService = app(\App\Services\RebarService::class);
        if ($log->remaining_length > 0 && !$rebarService->isWastage($log->bar_diameter, $log->remaining_length)) {
            $offcut = \App\Models\Offcut::create([
                'site_id' => $requirement->site_id,
                'bar_diameter' => $log->bar_diameter,
                'length' => $log->remaining_length,
                'quantity' => $validated['quantity_cut'], // Create offcuts matching the quantity cut
                'storage_location' => 'Generated from Cutting Log #' . $log->id,
                'status' => 'Available',
                'remarks' => 'Auto-generated off-cut from requirement ' . $requirement->tracking_id,
            ]);

            // Link back
            $log->offcut_id = $offcut->id;
            $log->save();
        }

        $message = 'Cutting log recorded successfully. ';
        $message .= $validated['quantity_cut'] . ' bar(s) cut. ';
        $message .= 'Remaining quantity: ' . $requirement->quantity . '. ';
        $message .= $log->offcut_id ? 'Off-cut(s) auto-generated.' : '';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(RebarCuttingLog $rebarCuttingLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RebarCuttingLog $rebarCuttingLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRebarCuttingLogRequest $request, RebarCuttingLog $rebarCuttingLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RebarCuttingLog $cuttingLog)
    {
        // If there's an associated offcut that is still 'Available', we should perhaps delete it or warn?
        // For now, let's correct parameter name and just delete.
        $cuttingLog->delete();
        return redirect()->back()->with('success', 'Cutting log deleted.');
    }
}

