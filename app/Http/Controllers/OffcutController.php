<?php

namespace App\Http\Controllers;

use App\Models\Offcut;
use App\Http\Requests\StoreOffcutRequest;
use App\Http\Requests\UpdateOffcutRequest;
use Illuminate\Http\Request;

class OffcutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Offcut::with('site');

        if (request('status')) {
            $query->where('status', request('status'));
        }
        if (request('diameter')) {
            $query->where('bar_diameter', request('diameter'));
        }
        if (request('site_id')) {
            $query->where('site_id', request('site_id'));
        }
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('offcut_code', 'like', "%{$search}%")
                    ->orWhere('storage_location', 'like', "%{$search}%");
            });
        }

        $offcuts = $query->latest()->paginate(10)->withQueryString();
        $sites = \App\Models\ProjectSite::orderBy('site_name')->get();

        // Stats for cards
        $availableCount = Offcut::where('status', 'Available')->count();
        $usedCount = Offcut::where('status', 'Used')->count();

        return view('admin.rebar.offcuts.index', compact('offcuts', 'availableCount', 'usedCount', 'sites'));
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
        return view('admin.rebar.offcuts.create');
    }

    public function store(StoreOffcutRequest $request)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSiteEngineer()) {
            abort(403);
        }

        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        Offcut::create($validated);
        return redirect()->route('admin.rebar.offcuts.index')->with('success', 'Off-cut registered manually.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Offcut $offcut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offcut $offcut)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSiteEngineer()) {
            abort(403);
        }
        if (!$user->isAdmin() && $offcut->user_id !== $user->id) {
            abort(403);
        }
        return view('admin.rebar.offcuts.edit', compact('offcut'));
    }

    public function update(UpdateOffcutRequest $request, Offcut $offcut)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSiteEngineer()) {
            abort(403);
        }
        if (!$user->isAdmin() && $offcut->user_id !== $user->id) {
            abort(403);
        }

        $offcut->update($request->validated());
        return redirect()->route('admin.rebar.offcuts.index')->with('success', 'Off-cut updated.');
    }

    public function destroy(Offcut $offcut)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSiteEngineer()) {
            abort(403);
        }
        if (!$user->isAdmin() && $offcut->user_id !== $user->id) {
            abort(403);
        }

        $offcut->delete();
        return redirect()->route('admin.rebar.offcuts.index')->with('success', 'Off-cut deleted.');
    }

    public function updateStatus(Request $request, Offcut $offcut)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSiteEngineer()) {
            abort(403);
        }
        if (!$user->isAdmin() && $offcut->user_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:Available,Used,Scrap'
        ]);

        $offcut->update(['status' => $request->status]);

        return back()->with('success', 'Off-cut status updated to ' . $request->status);
    }
}

