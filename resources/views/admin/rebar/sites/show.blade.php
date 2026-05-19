<x-app-layout>
    <div class="py-6 space-y-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Navigation -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.rebar.sites.index') }}"
                class="flex items-center gap-2 px-6 py-3 bg-white border-2 border-slate-200 text-slate-700 rounded-2xl font-black text-xs uppercase tracking-widest hover:border-cyan-500 hover:text-cyan-600 hover:bg-cyan-50 transition-all shadow-sm hover:shadow-md group">
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

        <!-- Site Header Hub -->
        <div
            class="bg-gradient-to-br from-white via-white to-cyan-50/30 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-200/60 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#00adc5] via-blue-500 to-blue-600">
            </div>
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-cyan-500/5 to-transparent rounded-full blur-3xl">
            </div>

            <div class="p-8 md:p-12 relative">
                <div class="flex flex-col md:flex-row justify-between items-start gap-8">
                    <!-- Left: Site Identity -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span
                                class="px-4 py-1.5 bg-cyan-50 text-[#00adc5] text-[11px] font-black uppercase tracking-widest rounded-full">
                                {{ $site->site_code }}
                            </span>
                            <span
                                class="px-4 py-1.5 bg-emerald-50 text-emerald-600 text-[11px] font-black uppercase tracking-widest rounded-full">
                                {{ $site->status }}
                            </span>
                        </div>
                        <div>
                            <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-tight">
                                {{ $site->site_name }}
                            </h1>
                            <p class="text-xl font-bold text-slate-400 mt-1">{{ $site->project_name }}</p>
                        </div>
                        <div class="flex flex-wrap gap-6 pt-2">
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
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.rebar.requirements.create', ['site_id' => $site->id]) }}"
                            class="flex items-center gap-2 px-6 py-4 bg-gradient-to-r from-[#00adc5] to-cyan-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-cyan-500/30 hover:scale-105 hover:shadow-cyan-500/40 transition-all group">
                            <i data-lucide="plus" class="w-4 h-4 group-hover:rotate-90 transition-transform"></i>
                            Add Requirement
                        </a>
                        <form action="{{ route('admin.rebar.cutting-plan.generate', $site) }}" method="POST"
                            class="inline">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 px-6 py-4 bg-gradient-to-r from-slate-900 to-slate-800 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-slate-300 hover:scale-105 hover:shadow-slate-400 transition-all group">
                                <i data-lucide="zap" class="w-4 h-4 text-yellow-400 group-hover:animate-pulse"></i>
                                Generate Cutting Plan
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Central Metrics Hub -->
                <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mt-12 pb-4 border-b border-slate-100">
                    <div
                        class="bg-gradient-to-br from-slate-50 to-white rounded-3xl p-6 text-center border border-slate-100 hover:shadow-lg hover:scale-105 transition-all">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Total
                            Steel Length</span>
                        <div class="flex items-baseline justify-center gap-1">
                            <span class="text-2xl font-black text-slate-900">{{ number_format($totalLength, 1) }}</span>
                            <span class="text-xs font-black text-slate-400">m</span>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-slate-50 to-white rounded-3xl p-6 text-center border border-slate-100 hover:shadow-lg hover:scale-105 transition-all">
                        <span
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Estimated
                            Tonnage</span>
                        <div class="flex items-baseline justify-center gap-1">
                            <span class="text-2xl font-black text-slate-900">{{ number_format($tonnage, 2) }}</span>
                            <span class="text-xs font-black text-slate-400">T</span>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-slate-50 to-white rounded-3xl p-6 text-center border border-slate-100 hover:shadow-lg hover:scale-105 transition-all">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Total
                            Bars Needed</span>
                        <div class="flex items-baseline justify-center gap-1">
                            <span class="text-2xl font-black text-slate-900">{{ number_format($totalBars) }}</span>
                            <span class="text-xs font-black text-slate-400">PCS</span>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-slate-50 to-white rounded-3xl p-6 text-center border border-slate-100 hover:shadow-lg hover:scale-105 transition-all">
                        <span class="text-[10px] font-black {{ $totalPcsNeeded > 0 ? 'text-cyan-500' : 'text-slate-400' }} uppercase tracking-widest block mb-1">Budgeted Material</span>
                        <div class="flex items-baseline justify-center gap-1">
                            <span class="text-2xl font-black text-slate-900">{{ number_format($totalPcsNeeded) }}</span>
                            <span class="text-xs font-black text-slate-400">PCS</span>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-slate-50 to-white rounded-3xl p-6 text-center border border-slate-100 hover:shadow-lg hover:scale-105 transition-all">
                        <span class="text-[10px] font-black {{ $totalKgCut > 0 ? 'text-emerald-500' : 'text-slate-400' }} uppercase tracking-widest block mb-2">Total KG Cut</span>
                        <div class="flex items-baseline justify-center gap-1">
                            <span class="text-2xl font-black text-slate-900">{{ number_format($totalKgCut, 1) }}</span>
                            <span class="text-xs font-black text-slate-400">KG</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Steel Requirement Analysis -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-200/60 overflow-hidden relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-50/50 rounded-full blur-3xl opacity-50"></div>
            <div class="p-8 md:p-10 relative">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white shadow-lg">
                            <i data-lucide="bar-chart-3" class="w-6 h-6 text-cyan-400"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">Steel Requirement Analysis</h3>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">Comparison of Plan vs. Actual Fabrication</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                    @foreach(['08', '10', '12', '14', '16', '18', '20', '24', '28', '32'] as $d)
                        @php
                            $diameter = (int)$d;
                            $needed = $site->{'amount_needed_'.$d} ?? 0;
                            $usage = $usageByDiameter[$diameter] ?? null;
                            $actual = $usage->total_pieces ?? 0;
                            $actualWeight = $usage->total_weight ?? 0;
                            $diff = $needed - $actual;
                            $statusColor = $diff > 0 ? 'text-amber-500' : ($diff < 0 ? 'text-rose-500' : 'text-emerald-500');
                            $bgColor = $diff > 0 ? 'bg-amber-50/30' : ($diff < 0 ? 'bg-rose-50/30' : 'bg-emerald-50/30');
                            $borderColor = $diff > 0 ? 'border-amber-100' : ($diff < 0 ? 'border-rose-100' : 'border-emerald-100');
                        @endphp
                        <div class="p-6 rounded-3xl border {{ $borderColor }} {{ $bgColor }} transition-all hover:shadow-lg group">
                            <div class="flex items-center justify-between mb-5">
                                <span class="px-4 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-black text-slate-900 shadow-sm group-hover:border-cyan-200 group-hover:text-cyan-600 transition-all font-mono tracking-tighter">Ø{{ $d }}mm</span>
                                @if($actual > 0)
                                    <div class="flex items-center gap-1.5 px-2 py-1 bg-white border border-emerald-100 rounded-lg shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <span class="text-[8px] font-black text-emerald-600 uppercase tracking-tighter">FABRICATED</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between items-end">
                                    <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Plan (Needed)</span>
                                    <span class="text-[11px] font-black text-slate-800">{{ number_format($needed) }} PCS</span>
                                </div>
                                <div class="flex justify-between items-end">
                                    <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Actual (Used)</span>
                                    <span class="text-[11px] font-black text-cyan-600">{{ number_format($actual) }} PCS</span>
                                </div>
                                <div class="flex justify-between items-end">
                                    <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Total Weight</span>
                                    <span class="text-[11px] font-black text-slate-600">{{ number_format($actualWeight, 1) }} kg</span>
                                </div>
                                <div class="h-px bg-slate-200/50 my-2"></div>
                                <div class="flex justify-between items-end">
                                    <span class="text-[8px] font-black {{ $statusColor }} uppercase tracking-widest">Difference</span>
                                    <div class="flex flex-col items-end">
                                        <span class="text-sm font-black {{ $statusColor }}">{{ number_format($diff) }} PCS</span>
                                        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter">{{ number_format($actual) }} Pieces Recorded</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 gap-8">
            <!-- Requirements Table (Full Width) -->
            <div class="space-y-6">
                <div class="flex items-center justify-between px-2">
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-wider flex items-center gap-3">
                        <i data-lucide="list-checks" class="w-6 h-6 text-[#00adc5]"></i>
                        Fabrication Requirements
                    </h3>
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-slate-400">{{ $requirements->total() }} items</span>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th
                                        class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                        Tracking ID</th>
                                    <th
                                        class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                        Element / Ref</th>
                                    <th
                                        class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">
                                        Diameter</th>
                                    <th
                                        class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">
                                        Length (m)</th>
                                    <th
                                        class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">
                                        Qty</th>
                                    <th
                                        class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">
                                        Total (m)</th>
                                    <th
                                        class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($requirements as $req)
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 font-black text-[9px] border border-slate-200 group-hover:bg-cyan-500 group-hover:text-white transition-all">
                                                    ID
                                                </div>
                                                <div>
                                                    <p class="text-xs font-black text-slate-900">{{ $req->tracking_id }}</p>
                                                    <p class="text-[9px] font-bold text-slate-400">
                                                        {{ $req->created_at->format('M d, Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="font-black text-slate-700">{{ $req->structural_element }}</div>
                                            <div
                                                class="text-[10px] font-bold text-slate-400 tracking-wider flex items-center gap-1 mt-1">
                                                @if($req->drawing_reference)
                                                    <i data-lucide="blueprint" class="w-3 h-3"></i>
                                                    {{ $req->drawing_reference }}
                                                @else
                                                    <span class="italic">NO REF</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <span
                                                class="px-3 py-1 bg-slate-100 rounded-lg font-black text-xs text-slate-600">
                                                Ø{{ $req->bar_diameter }}mm
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-center font-bold text-slate-600">
                                            {{ number_format($req->required_length, 2) }}m
                                        </td>
                                        <td class="px-6 py-5 text-center font-black text-slate-900">
                                            {{ $req->quantity }}
                                        </td>
                                        <td class="px-6 py-5 text-right font-black text-[#00adc5]">
                                            {{ number_format($req->total_length, 2) }}
                                        </td>
                                        <td class="px-6 py-5">
                                            <div
                                                class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0">
                                                <a href="{{ route('admin.rebar.cutting-logs.create', ['requirement_id' => $req->id]) }}"
                                                    class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all"
                                                    title="Record Cut">
                                                    <i data-lucide="scissors" class="w-4 h-4"></i>
                                                </a>
                                                <a href="{{ route('admin.rebar.requirements.edit', $req) }}"
                                                    class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                                    title="Edit">
                                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                                </a>
                                                <form action="{{ route('admin.rebar.requirements.destroy', $req) }}"
                                                    method="POST" onsubmit="return confirm('Archive this requirement?');"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-all"
                                                        title="Remove">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-slate-400 font-medium">
                                            No requirements entered for this site yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($requirements->hasPages())
                        <div class="px-6 py-4 border-t border-slate-50">
                            {{ $requirements->links() }}
                        </div>
                    @endif
                </div>

                <!-- Off-cuts Inventory Section -->
                <div class="mt-8">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">Available Off-cuts</h3>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Reusable
                                Inventory Assets</p>
                        </div>
                        <div
                            class="px-4 py-2 bg-white border border-slate-200 rounded-xl shadow-sm text-xs font-black text-slate-600 uppercase tracking-widest">
                            {{ $offcuts->count() }} Items Detected
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-200/60 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/50 border-b border-slate-100">
                                        <th
                                            class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                            Code</th>
                                        <th
                                            class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">
                                            Specifications</th>
                                        <th
                                            class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">
                                            Status</th>
                                        <th
                                            class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                            Location</th>
                                        <th
                                            class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($offcuts as $offcut)
                                        <tr class="hover:bg-slate-50/50 transition-all group">
                                            <td class="px-6 py-4">
                                                <span
                                                    class="text-xs font-black text-slate-900">{{ $offcut->offcut_code }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center justify-center gap-3">
                                                    <span
                                                        class="text-xs font-bold text-slate-600 px-2 py-1 bg-slate-100 rounded-md">Ø{{ $offcut->bar_diameter }}mm</span>
                                                    <span class="text-xs font-black text-slate-900">{{ number_format($offcut->length, 2) }}m</span>
                                                    <span class="px-2 py-0.5 bg-cyan-50 text-cyan-600 rounded text-[9px] font-black border border-cyan-100">{{ number_format($offcut->weight_kg, 2) }}kg</span>
                                                    <span class="px-2 py-0.5 bg-slate-50 text-slate-600 rounded text-[9px] font-black border border-slate-200">{{ $offcut->quantity }} pcs</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
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
                                            <td class="px-6 py-4">
                                                <span
                                                    class="text-[10px] font-bold text-slate-500 uppercase italic">{{ $offcut->storage_location ?? 'On Site' }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div
                                                    class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                                    @if($offcut->status === 'Available')
                                                        <form action="{{ route('admin.rebar.offcuts.update-status', $offcut) }}"
                                                            method="POST">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="status" value="Used">
                                                            <button type="submit"
                                                                class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                                                title="Mark as Used">
                                                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.rebar.offcuts.update-status', $offcut) }}"
                                                            method="POST">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="status" value="Scrap">
                                                            <button type="submit"
                                                                class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition-all"
                                                                title="Mark as Wastage">
                                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
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
                                                                <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5"
                                                class="px-6 py-10 text-center text-slate-400 text-xs font-medium italic">
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
        </div>
</x-app-layout>