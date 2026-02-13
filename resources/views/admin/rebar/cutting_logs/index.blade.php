<x-app-layout>
    <div class="py-6 space-y-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Cutting Log History</h2>
                <nav
                    class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mt-1">
                    <span>Global Registry</span>
                    <li class="list-none p-1 rounded-full bg-slate-100"><i data-lucide="chevron-right"
                            class="w-2.5 h-2.5"></i></li>
                    <li class="list-none text-[#00ADC5]">Cross-Site Fabrication Log</li>
                </nav>
            </div>
            <a href="{{ route('admin.rebar.sites.index') }}"
                class="flex items-center gap-2 px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                <i data-lucide="building-2" class="w-4 h-4"></i>
                View by Site
            </a>
        </div>

        <!-- Info Banner -->
        <div
            class="bg-gradient-to-r from-cyan-50 to-blue-50 border border-cyan-200 rounded-2xl p-6 flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-cyan-500 flex items-center justify-center flex-shrink-0">
                <i data-lucide="info" class="w-5 h-5 text-white"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider mb-1">Read-Only Fabrication
                    History</h3>
                <p class="text-sm text-slate-600 font-medium leading-relaxed">
                    This page displays all cutting logs across all project sites for monitoring purposes.
                    To <strong>record new cuts</strong>, navigate to the specific <strong>Site Hub</strong> by clicking
                    "View Site" on any log entry.
                </p>
            </div>
            <a href="{{ route('admin.rebar.offcuts.index') }}"
                class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-black text-xs uppercase tracking-widest shadow-lg shadow-emerald-500/20 hover:scale-105 hover:shadow-emerald-500/30 transition-all whitespace-nowrap">
                <i data-lucide="recycle" class="w-4 h-4"></i>
                View Available Off-Cuts
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-200/60">
            <form method="GET" action="{{ route('admin.rebar.cutting-logs.index') }}"
                class="grid grid-cols-1 md:grid-cols-5 gap-6">
                <div class="md:col-span-1">
                    <label
                        class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ID or Element..."
                        class="w-full bg-slate-50 border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Project
                        Site</label>
                    <select name="site_id"
                        class="w-full bg-slate-50 border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600">
                        <option value="">All Sites</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}" {{ request('site_id') == $site->id ? 'selected' : '' }}>
                                {{ $site->site_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Bar
                        Diameter</label>
                    <select name="diameter"
                        class="w-full bg-slate-50 border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600">
                        <option value="">All Sizes</option>
                        @foreach([8, 10, 12, 14, 16, 18, 20, 24, 32] as $d)
                            <option value="{{ $d }}" {{ request('diameter') == $d ? 'selected' : '' }}>{{ $d }}mm</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Filter by
                        Date</label>
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="w-full bg-slate-50 border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600">
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit"
                        class="flex-1 py-2.5 bg-slate-900 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all">Filter</button>
                    <a href="{{ route('admin.rebar.cutting-logs.index') }}"
                        class="p-2.5 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all"
                        title="Reset">
                        <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Container -->
        <div
            class="bg-gradient-to-br from-white via-white to-slate-50/30 rounded-[2rem] shadow-xl shadow-slate-100 border border-slate-200/60 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-500 via-blue-500 to-blue-600"></div>
            <div class="overflow-x-auto overflow-y-visible">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-50 to-white border-b-2 border-slate-100">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Log
                                Info</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Project Site</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Requirement Reference</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Cutting Geometry</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Off-Cut / Reusable</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Usage/Location</th>
                            <th
                                class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($logs as $log)
                            <tr class="hover:bg-cyan-50/30 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-slate-100 flex flex-col items-center justify-center border border-slate-200 group-hover:bg-white group-hover:border-cyan-200 transition-all">
                                            <span
                                                class="text-[9px] font-black text-slate-400 uppercase leading-none">{{ \Carbon\Carbon::parse($log->date)->format('M') }}</span>
                                            <span
                                                class="text-sm font-black text-slate-700 leading-tight">{{ \Carbon\Carbon::parse($log->date)->format('d') }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-900">
                                                #LOG-{{ str_pad($log->id, 5, '0', STR_PAD_LEFT) }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase">
                                                {{ $log->user->name ?? 'System' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-black text-slate-900 group-hover:text-cyan-600 transition-colors">
                                            {{ $log->site?->site_name ?? 'N/A' }}
                                        </span>
                                        <span
                                            class="text-[9px] font-bold text-slate-400 uppercase tracking-widest italic">Global
                                            Node</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @if($log->requirement)
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-black text-cyan-600 hover:text-cyan-700 transition-colors cursor-pointer">
                                                {{ $log->requirement->tracking_id }}
                                            </span>
                                            <span
                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $log->requirement->structural_element }}</span>
                                        </div>
                                    @else
                                        <span class="text-rose-500 text-xs font-black italic">Archived</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-slate-400 uppercase">Original</span>
                                            <span
                                                class="text-sm font-bold text-slate-700">{{ number_format($log->original_length, 2) }}m</span>
                                        </div>
                                        <i data-lucide="arrow-right" class="w-3 h-3 text-slate-300"></i>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-rose-400 uppercase">Used</span>
                                            <span
                                                class="text-sm font-black text-rose-500">{{ number_format($log->cut_length, 2) }}m</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @if($log->offcut)
                                        <div class="space-y-2">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="px-3 py-1.5 bg-gradient-to-r from-emerald-500 to-green-600 border border-emerald-200 rounded-xl shadow-sm">
                                                    <span
                                                        class="text-[10px] font-black text-white">{{ $log->offcut->offcut_code }}</span>
                                                </div>
                                                <span
                                                    class="px-2 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-[9px] font-black uppercase">
                                                    {{ $log->offcut->status }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-sm font-black text-emerald-600">{{ number_format($log->remaining_length, 2) }}m</span>
                                                    <span class="text-[8px] font-bold text-slate-400 uppercase">Length</span>
                                                </div>
                                                <div class="w-px h-8 bg-slate-200"></div>
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-sm font-black text-blue-600">{{ $log->offcut->quantity ?? 1 }}
                                                        pcs</span>
                                                    <span class="text-[8px] font-bold text-slate-400 uppercase">Available</span>
                                                </div>
                                            </div>
                                            @if($log->offcut->status === 'Available')
                                                <div class="flex items-center gap-1 text-cyan-600">
                                                    <i data-lucide="recycle" class="w-3 h-3"></i>
                                                    <span class="text-[9px] font-bold">Reusable for other sites</span>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="px-3 py-1 bg-rose-50 text-rose-600 rounded-lg text-[10px] font-black uppercase tracking-widest">Wastage</span>
                                            <span class="text-[9px] text-slate-400 italic">(< 0.3m)</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-sm font-bold text-slate-600 truncate max-w-[150px]">
                                        {{ $log->used_for ?? 'N/A' }}
                                    </p>
                                    @if($log->remarks)
                                        <p class="text-[10px] text-slate-400 italic">{{ Str::limit($log->remarks, 20) }}</p>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right">
                                    @if($log->requirement && $log->requirement->site_id)
                                        <div
                                            class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                            <a href="{{ route('admin.rebar.sites.show', $log->requirement->site_id) }}"
                                                class="flex items-center gap-2 px-4 py-2 text-cyan-600 bg-cyan-50 hover:bg-cyan-100 rounded-xl transition-all font-bold text-xs">
                                                <i data-lucide="building-2" class="w-4 h-4"></i>
                                                View Site
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-[10px] font-black text-slate-300 uppercase">No Site</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-4">
                                            <i data-lucide="search-x" class="w-10 h-10 text-slate-300"></i>
                                        </div>
                                        <h3 class="text-lg font-black text-slate-900">No cutting logs</h3>
                                        <p class="text-sm text-slate-500 max-w-xs mx-auto">We couldn't find any cutting
                                            records matching your search or filters.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <div class="px-8 py-5 border-t border-slate-50 bg-slate-50/30">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>