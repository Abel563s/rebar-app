<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Offcut;
use App\Models\ProjectSite;
use App\Models\User;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            $approvals = Approval::with(['site','offcut','requester','approver'])->latest()->paginate(20);
        } elseif ($user->isManager()) {
            // show approvals where approver is this manager or requested_by is this manager
            $approvals = Approval::with(['site','offcut','requester','approver'])
                ->where(function($q) use ($user) {
                    $q->where('approver_id', $user->id)->orWhere('requested_by', $user->id);
                })->latest()->paginate(20);
        } else {
            abort(403);
        }

        // Provide available offcuts to the index page (used by the inline modal)
        if (method_exists(\App\Models\Offcut::class, 'available')) {
            $offcuts = \App\Models\Offcut::available()->get();
        } else {
            $offcuts = \App\Models\Offcut::all();
        }

        return view('admin.rebar.approvals.index', compact('approvals', 'offcuts'));
    }

    public function create()
    {
        $sites = ProjectSite::all();
        if (method_exists(Offcut::class, 'available')) {
            $offcuts = Offcut::available()->get();
        } else {
            $offcuts = Offcut::all();
        }
        $managers = User::where('role','manager')->get();
        return view('admin.rebar.approvals.create', compact('sites','offcuts','managers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'site_id' => 'required|exists:project_sites,id',
            'target_site_id' => 'required|exists:project_sites,id',
            'offcut_id' => 'nullable|exists:offcuts,id',
            'approver_id' => 'required|exists:users,id',
            'note' => 'nullable|string',
        ]);

        $data['requested_by'] = auth()->id();
        $approval = Approval::create($data);

        return redirect()->route('admin.rebar.approvals.index')->with('success','Request created.');
    }

    public function approve(Approval $approval)
    {
        $user = auth()->user();
        if (!$user->isManager() && !$user->isAdmin()) abort(403);
        if ($approval->approver_id && $approval->approver_id !== $user->id && !$user->isAdmin()) abort(403);

        $approval->status = 'approved';
        $approval->approver_id = $user->id;
        $approval->save();

        // If approval includes an offcut transfer, move the offcut to the target site
        if ($approval->offcut) {
            $off = $approval->offcut;
            $off->site_id = $approval->target_site_id ?? $approval->site_id;
            $off->save();
        }

        return redirect()->back()->with('success','Approved.');
    }

    public function reject(Approval $approval)
    {
        $user = auth()->user();
        if (!$user->isManager() && !$user->isAdmin()) abort(403);
        if ($approval->approver_id && $approval->approver_id !== $user->id && !$user->isAdmin()) abort(403);

        $approval->status = 'rejected';
        $approval->approver_id = $user->id;
        $approval->save();

        return redirect()->back()->with('success','Request rejected.');
    }
}
