<x-app-layout>
    <div class="py-6 space-y-4 min-w-0 px-4 sm:px-6 lg:px-8">
        <!-- Back Navigation -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.rebar.sites.index') }}"
                class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:border-cyan-500 hover:text-cyan-600 hover:bg-cyan-50 transition-all shadow-sm group">
                <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                Back to All Sites
            </a>
            <div class="flex items-center gap-2">
                <span class="px-4 py-2 bg-slate-50 text-slate-600 rounded-xl font-bold text-xs border border-slate-200">
                    <i data-lucide="calendar" class="w-3 h-3 inline mr-1"></i>
                    Last Updated: {{ $site->updated_at->format('M d, Y') }}
                </span>
            </div>
        </div>

<script>
    function toggleSteelEdit(enable) {
        const view = document.getElementById('steel-analysis-view');
        const edit = document.getElementById('steel-analysis-edit');
        if (!view || !edit) return;
        if (enable) {
            view.classList.add('hidden');
            edit.classList.remove('hidden');
            // focus first input
            const first = edit.querySelector('input'); if (first) first.focus();
        } else {
            edit.classList.add('hidden');
            view.classList.remove('hidden');
        }
    }
</script>

        <!-- Site Header Hub -->
        <div class="section-card">
            <div class="p-5 md:p-6">
                    <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                    <!-- Left: Site Identity -->
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span
                                    class="px-3 py-1 bg-cyan-50 text-[#00adc5] text-[10px] font-black uppercase tracking-widest rounded-full">
                                {{ $site->site_code }}
                            </span>
                            <span
                                class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-full">
                                {{ $site->status }}
                            </span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-black text-slate-900 tracking-tight leading-tight">
                                {{ $site->site_name }}
                            </h1>
                            <p class="text-base font-bold text-slate-400 mt-1">{{ $site->project_name }}</p>
                            @if($site->manager)
                                <p class="text-xs text-slate-500 mt-1">Manager: <span class="font-bold text-slate-700">{{ $site->manager->name }}</span></p>
                            @endif
                        </div>
                        <div class="flex flex-wrap gap-4 pt-1">
                            <div class="flex items-center gap-2 text-slate-500">
                                <i data-lucide="map-pin" class="w-5 h-5 text-slate-300"></i>
                                <span class="font-bold">{{ $site->location }}</span>
                            </div>
                            @if($site->sector)
                                <div class="flex items-center gap-2 text-slate-500">
                                    <i data-lucide="building-2" class="w-5 h-5 text-slate-300"></i>
                                    <span class="font-bold">{{ $site->sector }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right: Quick Actions -->
                    <div class="flex flex-wrap gap-2">
                        @if(auth()->user()->isAdmin() || auth()->user()->isSiteEngineer())
                        <a href="{{ route('admin.rebar.requirements.create', ['site_id' => $site->id]) }}"
                            class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-[#00adc5] to-cyan-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:scale-[1.02] transition-all group">
                            <i data-lucide="plus" class="w-3.5 h-3.5 group-hover:rotate-90 transition-transform"></i>
                            Add Requirement
                        </a>
                        @endif
                        @if(auth()->user()->isAdmin() || auth()->user()->isSiteEngineer())
                        <a href="{{ route('admin.rebar.requirements.import-form', ['site_id' => $site->id]) }}"
                            class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-50 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Import
                        </a>
                        @endif
                        @if(auth()->user()->isAdmin() || auth()->user()->isSiteEngineer())
                        <form action="{{ route('admin.rebar.cutting-plan.generate', $site) }}" method="POST"
                            class="inline">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-slate-900 to-slate-800 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:scale-[1.02] transition-all group">
                                <i data-lucide="zap" class="w-3.5 h-3.5 text-yellow-400"></i>
                                Generate Cutting Plan
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                <!-- Central Metrics Hub -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mt-6 pb-4 border-b border-slate-100">
                    <div class="kpi-card text-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Total
                            Steel Length</span>
                        <div class="flex items-baseline justify-center gap-1">
                            <span class="text-xl font-black text-slate-900">{{ number_format($totalLength, 1) }}</span>
                            <span class="text-[10px] font-black text-slate-400">m</span>
                        </div>
                    </div>
                    <div class="kpi-card text-center">
                        <span
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Estimated
                            Tonnage</span>
                        <div class="flex items-baseline justify-center gap-1">
                            <span class="text-xl font-black text-slate-900">{{ number_format($tonnage, 2) }}</span>
                            <span class="text-[10px] font-black text-slate-400">T</span>
                        </div>
                    </div>
                    <div class="kpi-card text-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Total
                            Bars Needed</span>
                        <div class="flex items-baseline justify-center gap-1">
                            <span class="text-xl font-black text-slate-900">{{ number_format($totalBars) }}</span>
                            <span class="text-[10px] font-black text-slate-400">PCS</span>
                        </div>
                    </div>
                    <div class="kpi-card text-center">
                        <span class="text-[10px] font-black {{ $totalPcsNeeded > 0 ? 'text-cyan-500' : 'text-slate-400' }} uppercase tracking-widest block mb-1">Budgeted Material</span>
                        <div class="flex items-baseline justify-center gap-1">
                            <span class="text-xl font-black text-slate-900">{{ number_format($totalPcsNeeded) }}</span>
                            <span class="text-[10px] font-black text-slate-400">PCS</span>
                        </div>
                    </div>
                    <div class="kpi-card text-center">
                        <span class="text-[10px] font-black {{ $totalKgCut > 0 ? 'text-emerald-500' : 'text-slate-400' }} uppercase tracking-widest block mb-1">Total KG Cut</span>
                        <div class="flex items-baseline justify-center gap-1">
                            <span class="text-xl font-black text-slate-900">{{ number_format($totalKgCut, 1) }}</span>
                            <span class="text-[10px] font-black text-slate-400">KG</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Steel Requirement Analysis -->
        <div class="section-card">
            <div class="p-5 md:p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white">
                            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-lg font-black text-slate-900 tracking-tight">Steel Requirement Analysis</h3>
                                <button id="steel-edit-btn" type="button" onclick="toggleSteelEdit(true)" class="p-1.5 text-slate-500 hover:bg-slate-100 rounded-lg transition-all" title="Edit plan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                            </div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-0.5">Comparison of Plan vs. Actual Fabrication</p>
                        </div>
                    </div>
                </div>

                <div id="steel-analysis-view">
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                        @foreach(['08', '10', '12', '14', '16', '18', '20', '24', '28', '32'] as $d)
                            @php
                                $diameter = (int)$d;
                                $needed = (int)($site->{'amount_needed_'.$d} ?? 0);
                                $usage = $usageByDiameter[$diameter] ?? null;
                                $actual = $usage->total_pieces ?? 0;
                                $actualWeight = $usage->total_weight ?? 0;
                                $diff = $needed - $actual;
                                $statusColor = $diff > 0 ? 'text-amber-500' : ($diff < 0 ? 'text-rose-500' : 'text-emerald-500');
                                $bgColor = $diff > 0 ? 'bg-amber-50/30' : ($diff < 0 ? 'bg-rose-50/30' : 'bg-emerald-50/30');
                                $borderColor = $diff > 0 ? 'border-amber-100' : ($diff < 0 ? 'border-rose-100' : 'border-emerald-100');
                            @endphp
                            <div class="p-4 rounded-2xl border {{ $borderColor }} {{ $bgColor }} transition-all group">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-[11px] font-black text-slate-900 shadow-sm group-hover:border-cyan-200 group-hover:text-cyan-600 transition-all font-mono tracking-tighter">Ø{{ $d }}mm</span>
                                    @if($actual > 0)
                                        <div class="flex items-center gap-1 px-1.5 py-0.5 bg-white border border-emerald-100 rounded-md shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            <span class="text-[8px] font-black text-emerald-600 uppercase tracking-tighter">FABRICATED</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="space-y-2">
                                    <div class="flex justify-between items-end">
                                        <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Plan (Needed)</span>
                                        <span class="text-[10px] font-black text-slate-800">{{ number_format($needed) }} PCS</span>
                                    </div>
                                    <div class="flex justify-between items-end">
                                        <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Actual (Used)</span>
                                        <span class="text-[10px] font-black text-cyan-600">{{ number_format($actual) }} PCS</span>
                                    </div>
                                    <div class="flex justify-between items-end">
                                        <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Total Weight</span>
                                        <span class="text-[10px] font-black text-slate-600">{{ number_format($actualWeight, 1) }} kg</span>
                                    </div>
                                    <div class="h-px bg-slate-200/50 my-1.5"></div>
                                    <div class="flex justify-between items-end">
                                        <span class="text-[8px] font-black {{ $statusColor }} uppercase tracking-widest">Difference</span>
                                        <div class="flex flex-col items-end">
                                            <span class="text-xs font-black {{ $statusColor }}">{{ number_format($diff) }} PCS</span>
                                            <span class="text-[7px] font-bold text-slate-400 uppercase tracking-tighter">{{ number_format($actual) }} Pieces Recorded</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <form id="steel-analysis-edit" class="hidden" method="POST" action="{{ route('admin.rebar.sites.update', $site) }}">
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                        @foreach(['08', '10', '12', '14', '16', '18', '20', '24', '28', '32'] as $d)
                            @php $val = old('amount_needed_'.$d, $site->{'amount_needed_'.$d} ?? 0); @endphp
                            <div class="p-3 rounded-xl border border-slate-100 bg-slate-50">
                                <label class="block text-[10px] font-black text-slate-600 mb-1">Ø{{ $d }}mm Plan</label>
                                <input name="amount_needed_{{ $d }}" type="number" min="0" step="1" value="{{ $val }}" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 bg-white text-sm font-bold" />
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 flex items-center gap-2">
                        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-2xl font-black text-xs shadow hover:scale-[1.02] transition-all">Save</button>
                        <button type="button" onclick="toggleSteelEdit(false)" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-2xl font-bold border border-slate-200 text-xs">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="space-y-4">
            <!-- Requirements Table (Full Width) -->
            <div class="section-card">
                <div class="flex items-center justify-between p-5 pb-3">
                    <h3 class="text-base font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#00adc5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        Fabrication Requirements
                    </h3>
                    <span class="text-[10px] font-bold text-slate-400">{{ $requirements->total() }} items</span>
                </div>

                    <div class="overflow-x-auto shadow-lg hover:shadow-xl transition-all">
                    <table class="w-full text-left border-collapse">
                        <thead>
                                <tr class="bg-[#00adc5] text-white">
                                <th
                                    class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest border-b border-slate-100">
                                    Tracking ID</th>
                                <th
                                    class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest border-b border-slate-100">
                                    Element / Ref</th>
                                <th
                                    class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest border-b border-slate-100 text-center">
                                    Diameter</th>
                                <th
                                    class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest border-b border-slate-100 text-center">
                                    Length (m)</th>
                                <th
                                    class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest border-b border-slate-100 text-center">
                                    Qty</th>
                                <th
                                    class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest border-b border-slate-100 text-right">
                                    Total (m)</th>
                                <th
                                    class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest border-b border-slate-100 text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($requirements as $req)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-4 py-2.5">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 font-black text-[8px] border border-slate-200 group-hover:bg-cyan-500 group-hover:text-white transition-all">
                                                ID
                                            </div>
                                            <div>
                                                <p class="text-[11px] font-black text-slate-900">{{ $req->tracking_id }}</p>
                                                <p class="text-[9px] font-bold text-slate-400">
                                                    {{ $req->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2.5">
                                        <div class="font-black text-slate-700 text-sm">{{ $req->structural_element }}</div>
                                        <div
                                            class="text-[9px] font-bold text-slate-400 tracking-wider flex items-center gap-1 mt-0.5">
                                            @if($req->drawing_reference)
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                {{ $req->drawing_reference }}
                                            @else
                                                <span class="italic">NO REF</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-2.5 text-center">
                                        <span
                                            class="px-2.5 py-1 bg-slate-100 rounded-lg font-black text-[11px] text-slate-600">
                                            Ø{{ $req->bar_diameter }}mm
                                        </span>
                                    </td>
                                    <td class="px-4 py-2.5 text-center font-bold text-slate-600 text-sm">
                                        {{ number_format($req->required_length, 2) }}m
                                    </td>
                                    <td class="px-4 py-2.5 text-center font-black text-slate-900 text-sm">
                                        {{ $req->quantity }}
                                    </td>
                                    <td class="px-4 py-2.5 text-right font-black text-[#00adc5] text-sm">
                                        {{ number_format($req->total_length, 2) }}
                                    </td>
                                    <td class="px-4 py-2.5">
                                        <div
                                            class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-all">
                                            @if(auth()->user()->isAdmin() || auth()->user()->isSiteEngineer())
                                            <a href="{{ route('admin.rebar.cutting-logs.create', ['requirement_id' => $req->id]) }}"
                                                class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all"
                                                title="Record Cut">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0a3 3 0 10-4.243 4.243L3 21l1.121-3.121a3 3 0 014.243-4.243L12 12z"></path></svg>
                                            </a>
                                            @endif
                                            @if(auth()->user()->isAdmin() || (auth()->user()->isSiteEngineer() && $req->user_id === auth()->id()))
                                            <a href="{{ route('admin.rebar.requirements.edit', $req) }}"
                                                class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                                title="Edit">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('admin.rebar.requirements.destroy', $req) }}"
                                                method="POST" onsubmit="return confirm('Archive this requirement?');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition-all"
                                                    title="Remove">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-slate-400 font-medium text-sm">
                                        No requirements entered for this site yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($requirements->hasPages())
                    <div class="px-4 py-3 border-t border-slate-50">
                        {{ $requirements->links() }}
                    </div>
                @endif
            </div>

                <!-- Off-cuts Inventory Section -->
                <div class="section-card mt-4">
                    <div class="flex items-center justify-between p-5 pb-3">
                        <div>
                            <h3 class="text-base font-black text-slate-900 tracking-tight">Available Off-cuts</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Reusable
                                Inventory Assets</p>
                        </div>
                        <div
                            class="px-3 py-1.5 bg-white border border-slate-200 rounded-xl shadow-sm text-[10px] font-black text-slate-600 uppercase tracking-widest">
                            {{ $offcuts->count() }} Items Detected
                        </div>
                    </div>

                <div class="overflow-x-auto shadow-lg hover:shadow-xl transition-all">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                    <tr class="bg-[#00adc5] text-white">
                                    <th
                                        class="px-4 py-2 text-[9px] font-black text-white uppercase tracking-widest">
                                        Code</th>
                                    <th
                                        class="px-4 py-2 text-[9px] font-black text-white uppercase tracking-widest text-center">
                                        Specifications</th>
                                    <th
                                        class="px-4 py-2 text-[9px] font-black text-white uppercase tracking-widest text-center">
                                        Status</th>
                                    <th
                                        class="px-4 py-2 text-[9px] font-black text-white uppercase tracking-widest">
                                        Location</th>
                                    <th
                                        class="px-4 py-2 text-[9px] font-black text-white uppercase tracking-widest text-right">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($offcuts as $offcut)
                                    <tr class="hover:bg-slate-50/50 transition-all group">
                                        <td class="px-4 py-2.5">
                                            <span
                                                class="text-[11px] font-black text-slate-900">{{ $offcut->offcut_code }}</span>
                                        </td>
                                        <td class="px-4 py-2.5">
                                            <div class="flex items-center justify-center gap-2">
                                                <span
                                                    class="text-[11px] font-bold text-slate-600 px-2 py-0.5 bg-slate-100 rounded-md">Ø{{ $offcut->bar_diameter }}mm</span>
                                                <span class="text-[11px] font-black text-slate-900">{{ number_format($offcut->length, 2) }}m</span>
                                                <span class="px-2 py-0.5 bg-cyan-50 text-cyan-600 rounded text-[9px] font-black border border-cyan-100">{{ number_format($offcut->weight_kg, 2) }}kg</span>
                                                <span class="px-2 py-0.5 bg-slate-50 text-slate-600 rounded text-[9px] font-black border border-slate-200">{{ $offcut->quantity }} pcs</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2.5 text-center">
                                            @if($offcut->status === 'Available')
                                                <span
                                                    class="text-[9px] font-black uppercase tracking-wider px-2 py-1 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100">Available</span>
                                            @elseif($offcut->status === 'Used')
                                                <span
                                                    class="text-[9px] font-black uppercase tracking-wider px-2 py-1 bg-blue-50 text-blue-600 rounded-full border border-blue-100">Used</span>
                                            @else
                                                <span
                                                    class="text-[9px] font-black uppercase tracking-wider px-2 py-1 bg-rose-50 text-rose-600 rounded-full border border-rose-100">Wastage</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2.5">
                                            <span
                                                class="text-[10px] font-bold text-slate-500 uppercase italic">{{ $offcut->storage_location ?? 'On Site' }}</span>
                                        </td>
                                        <td class="px-4 py-2.5 text-right">
                                            <div
                                                class="flex items-center justify-end gap-1.5 opacity-0 group-hover:opacity-100 transition-all">
                                                @if($offcut->status === 'Available')
                                                    <form action="{{ route('admin.rebar.offcuts.update-status', $offcut) }}"
                                                        method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="Used">
                                                        <button type="submit"
                                                            class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                                            title="Mark as Used">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.rebar.offcuts.update-status', $offcut) }}"
                                                        method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="Scrap">
                                                        <button type="submit"
                                                            class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition-all"
                                                            title="Mark as Wastage">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.rebar.offcuts.update-status', $offcut) }}"
                                                        method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="Available">
                                                        <button type="submit"
                                                            class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all"
                                                            title="Restore to Available">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="px-4 py-8 text-center text-slate-400 text-xs font-medium italic">
                                            No reusable off-cuts detected for this site.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>