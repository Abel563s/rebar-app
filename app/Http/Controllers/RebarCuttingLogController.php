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
        $query = RebarCuttingLog::with('requirement', 'offcut', 'site', 'reusedOffcut');

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
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSiteEngineer()) {
            abort(403);
        }
        $requirements = \App\Models\RebarRequirement::with('site')->latest()->limit(50)->get();
        $availableOffcuts = \App\Models\Offcut::where('status', 'Available')->where('quantity', '>', 0)->get();
        return view('admin.rebar.cutting_logs.create', compact('requirements', 'availableOffcuts'));
    }

    public function store(StoreRebarCuttingLogRequest $request)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSiteEngineer()) {
            abort(403);
        }
        $validated = $request->validated();
        $requirement = \App\Models\RebarRequirement::findOrFail($validated['rebar_requirement_id']);

        $log = RebarCuttingLog::create(array_merge($validated, [
            'site_id' => $requirement->site_id,
        ]));

        // Decrease the requirement quantity by the amount cut
        $requirement->quantity -= $validated['quantity_cut'];
        $requirement->save();

        // Automatically decrease reused offcut quantity
        if (!empty($validated['reused_offcut_id'])) {
            $sourceOffcut = \App\Models\Offcut::findOrFail($validated['reused_offcut_id']);
            $sourceOffcut->quantity = max(0, $sourceOffcut->quantity - $validated['quantity_cut']);
            if ($sourceOffcut->quantity == 0) {
                $sourceOffcut->status = 'Used';
            }
            $sourceOffcut->save();
        }

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
        if (!empty($validated['reused_offcut_id'])) {
            $message .= ' Reused off-cut(s) deducted from inventory registry.';
        }

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
        if ($cuttingLog->user_id !== auth()->id()) {
            abort(403, 'Unauthorized. You can only delete cutting logs you created.');
        }
        // Restore reused offcut if applicable
        if ($cuttingLog->reused_offcut_id) {
            $sourceOffcut = \App\Models\Offcut::find($cuttingLog->reused_offcut_id);
            if ($sourceOffcut) {
                $sourceOffcut->quantity += $cuttingLog->quantity_cut;
                if ($sourceOffcut->status === 'Used' && $sourceOffcut->quantity > 0) {
                    $sourceOffcut->status = 'Available';
                }
                $sourceOffcut->save();
            }
        }

        // If there is an associated auto-generated offcut from this cutting activity, delete it or set status to Scrap
        if ($cuttingLog->offcut_id) {
            $generatedOffcut = \App\Models\Offcut::find($cuttingLog->offcut_id);
            if ($generatedOffcut && $generatedOffcut->status === 'Available') {
                $generatedOffcut->delete();
            }
        }

        $cuttingLog->delete();
        return redirect()->back()->with('success', 'Cutting log deleted and inventory adjusted.');
    }
}

