<x-app-layout>
    <div class="py-6 max-w-4xl mx-auto px-4">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-black">New Approval Request</h2>
            <a href="{{ route('admin.rebar.approvals.index') }}" class="px-4 py-2 bg-slate-100 rounded-xl">Back</a>
        </div>

        <form action="{{ route('admin.rebar.approvals.store') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-100">
            @csrf
            <div class="grid grid-cols-1 gap-4">
                <label class="block text-xs font-black text-slate-500">Site</label>
                <select name="site_id" required class="w-full p-3 border rounded-lg">
                    @foreach($sites as $s)
                        <option value="{{ $s->id }}">{{ $s->site_name }} ({{ $s->site_code }})</option>
                    @endforeach
                </select>

                <label class="block text-xs font-black text-slate-500">Offcut (optional)</label>
                <select name="offcut_id" class="w-full p-3 border rounded-lg">
                    <option value="">-- Select Offcut --</option>
                    @foreach($offcuts as $o)
                        <option value="{{ $o->id }}">{{ $o->code }} — {{ $o->length }}m</option>
                    @endforeach
                </select>

                <label class="block text-xs font-black text-slate-500">Approver (Manager)</label>
                <select name="approver_id" required class="w-full p-3 border rounded-lg">
                    @foreach($managers as $m)
                        <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->email }})</option>
                    @endforeach
                </select>

                <label class="block text-xs font-black text-slate-500">Note</label>
                <textarea name="note" rows="3" class="w-full p-3 border rounded-lg"></textarea>

                <div class="flex items-center justify-end">
                    <button type="submit" class="px-5 py-3 bg-cyan-600 text-white rounded-lg font-bold">Request</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>