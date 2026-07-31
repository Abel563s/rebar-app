<x-app-layout>
    <div class="py-4 space-y-4 min-w-0 px-4">
        <div class="flex items-center justify-between gap-3">
            <h2 class="text-xl font-black">New Approval Request</h2>
            <a href="{{ route('admin.rebar.approvals.index') }}" class="px-4 py-2 bg-slate-100 rounded-xl text-xs font-bold">Back</a>
        </div>

        <div class="section-card">
            <form action="{{ route('admin.rebar.approvals.store') }}" method="POST" class="space-y-3">
                @csrf
                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-0.5">Site</label>
                        <select name="site_id" required class="w-full h-10 rounded-lg border border-slate-200 bg-[#FAFBFC] px-3 text-sm">
                            @foreach($sites as $s)
                                <option value="{{ $s->id }}">{{ $s->site_name }} ({{ $s->site_code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-0.5">Offcut (optional)</label>
                        <select name="offcut_id" class="w-full h-10 rounded-lg border border-slate-200 bg-[#FAFBFC] px-3 text-sm">
                            <option value="">-- Select Offcut --</option>
                            @foreach($offcuts as $o)
                                <option value="{{ $o->id }}">{{ $o->code }} — {{ $o->length }}m</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-0.5">Approver (Manager)</label>
                        <select name="approver_id" required class="w-full h-10 rounded-lg border border-slate-200 bg-[#FAFBFC] px-3 text-sm">
                            @foreach($managers as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-0.5">Note</label>
                        <textarea name="note" rows="3" class="w-full rounded-lg border border-slate-200 bg-[#FAFBFC] px-3 py-2 text-sm"></textarea>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="px-4 py-2 bg-cyan-600 text-white rounded-lg font-bold text-sm">Request</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>