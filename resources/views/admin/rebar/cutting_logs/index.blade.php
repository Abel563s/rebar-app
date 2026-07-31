<x-app-layout>
    <div class="py-4 space-y-4 min-w-0 mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Cutting Log History</h2>
                <nav class="flex items-center gap-2 text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 mt-1">
                    <span>Global Registry</span>
                    <li class="list-none p-0.5 rounded-full bg-slate-100"><i data-lucide="chevron-right" class="w-2.5 h-2.5"></i></li>
                    <li class="list-none text-[#00ADC5]">Cross-Site Fabrication Log</li>
                </nav>
            </div>
            <a href="{{ route('admin.rebar.sites.index') }}" class="flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21c3 0 7-1 7-8V5a2 2 0 0 1 2-2h4c1.25 0 2 .75 2 1.972V11c0 1.25-.75 2-2 2s-1 .008-1 1.031V21z"/><path d="M15 21c3 0 7-1 7-8V5a2 2 0 0 1-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3"/></svg> View by Site
            </a>
        </div>

        <!-- Info Banner -->
        <div class="bg-cyan-50/60 border border-cyan-200 rounded-xl p-4 flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-cyan-500 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider mb-0.5">Read-Only Fabrication History</h3>
                <p class="text-xs text-slate-600 font-medium leading-relaxed">
                    This page displays all cutting logs across all project sites for monitoring purposes. To <strong class="font-black">record new cuts</strong>, navigate to the specific <strong class="font-black">Site Hub</strong> by clicking "View Site" on any log entry.
                </p>
            </div>
            <a href="{{ route('admin.rebar.offcuts.index') }}" class="flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white rounded-xl font-black text-xs uppercase tracking-widest shadow-md hover:bg-emerald-600 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 19H4.815a1.83 1.83 0 0 1-1.57-.881 1.785 1.785 0 0 1-.004-1.784L7.196 9.5"/><path d="M12 12V3"/><path d="M20 7v4a2 2 0 0 1-2 2H6.5"/><path d="M7 19h13.5a1.5 1.5 0 0 0 1.5-1.5V5.5A1.5 1.5 0 0 0 20 3.5"/></svg> View Available Off-Cuts
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="section-card shadow-lg hover:shadow-xl transition-all bg-white/90 backdrop-blur-sm border border-slate-200/60">
            <form method="GET" action="{{ route('admin.rebar.cutting-logs.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-3">
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ID or Element..." class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                </div>
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Project Site</label>
                    <select name="site_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                        <option value="">All Sites</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}" {{ request('site_id') == $site->id ? 'selected' : '' }}>{{ $site->site_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Bar Diameter</label>
                    <select name="diameter" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                        <option value="">All Sizes</option>
                        @foreach([8, 10, 12, 14, 16, 18, 20, 24, 32] as $d)
                            <option value="{{ $d }}" {{ request('diameter') == $d ? 'selected' : '' }}>{{ $d }}mm</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Steel Grade</label>
                    <select name="steel_grade" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                        <option value="">All Grades</option>
                        @foreach([300, 400, 500, 600] as $grade)
                            <option value="{{ $grade }}" {{ request('steel_grade') == $grade ? 'selected' : '' }}>Grade {{ $grade }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Min Len</label>
                        <input type="number" step="0.01" name="min_length" value="{{ request('min_length') }}" placeholder="0.0" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Max Len</label>
                        <input type="number" step="0.01" name="max_length" value="{{ request('max_length') }}" placeholder="12.0" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                    </div>
                </div>
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Date</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 py-2 px-4 bg-slate-900 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all">Filter</button>
                    <a href="{{ route('admin.rebar.cutting-logs.index') }}" class="p-2 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all" title="Reset">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg>
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Container -->
        <div class="section-card shadow-lg hover:shadow-xl transition-all">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[#00adc5]/20 bg-[#00adc5]">
                            <th class="px-4 py-2.5 text-[10px] font-black text-white uppercase tracking-[0.2em]">Log Info</th>
                            <th class="px-4 py-2.5 text-[10px] font-black text-white uppercase tracking-[0.2em]">Project Site</th>
                            <th class="px-4 py-2.5 text-[10px] font-black text-white uppercase tracking-[0.2em]">Requirement Reference</th>
                            <th class="px-4 py-2.5 text-[10px] font-black text-white uppercase tracking-[0.2em]">Cutting Geometry</th>
                            <th class="px-4 py-2.5 text-[10px] font-black text-white uppercase tracking-[0.2em]">Off-Cut / Reusable</th>
                            <th class="px-4 py-2.5 text-[10px] font-black text-white uppercase tracking-[0.2em]">Usage / Location</th>
                            <th class="px-4 py-2.5 text-[10px] font-black text-white uppercase tracking-[0.2em] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($logs as $log)
                            <tr class="hover:bg-cyan-50/20 transition-all group">
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-9 h-9 rounded-lg bg-slate-100 flex flex-col items-center justify-center border border-slate-200 group-hover:bg-white group-hover:border-cyan-200 transition-all">
                                            <span class="text-[8px] font-black text-slate-400 uppercase leading-none">{{ \Carbon\Carbon::parse($log->date)->format('M') }}</span>
                                            <span class="text-xs font-black text-slate-700 leading-tight">{{ \Carbon\Carbon::parse($log->date)->format('d') }}</span>
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-slate-900">#LOG-{{ str_pad($log->id, 5, '0', STR_PAD_LEFT) }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $log->user->name ?? 'System' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-2.5">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-black text-slate-900 group-hover:text-cyan-600 transition-colors">{{ $log->site?->site_name ?? 'N/A' }}</span>
                                        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest italic">Global Node</span>
                                    </div>
                                </td>
                                <td class="px-4 py-2.5">
                                    @if($log->requirement)
                                        <div class="flex flex-col">
                                            <span class="text-xs font-black text-cyan-600 hover:text-cyan-700 transition-colors cursor-pointer">{{ $log->requirement->tracking_id }}</span>
                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $log->requirement->structural_element }}</span>
                                        </div>
                                    @else
                                        <span class="text-rose-500 text-[11px] font-black italic">Archived</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <div class="flex flex-col">
                                            <span class="text-[8px] font-black text-slate-400 uppercase">Original</span>
                                            <span class="text-xs font-bold text-slate-700">{{ number_format($log->original_length, 2) }}m</span>
                                            @if($log->reusedOffcut)
                                                <span class="text-[8px] font-black bg-emerald-50 text-emerald-600 rounded px-1 py-0.5 border border-emerald-100 uppercase tracking-tight mt-0.5 inline-block w-fit" title="Reused Off-cut: {{ $log->reusedOffcut->offcut_code }}">Reused Offcut</span>
                                            @endif
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3 text-slate-300"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                        <div class="flex flex-col">
                                            <span class="text-[8px] font-black text-rose-400 uppercase">Used</span>
                                            <span class="text-xs font-black text-rose-500">{{ number_format($log->cut_length, 2) }}m</span>
                                        </div>
                                        <div class="w-px h-6 bg-slate-100 mx-1"></div>
                                        <div class="flex flex-col">
                                            <span class="text-[8px] font-black text-cyan-500 uppercase">Weight</span>
                                            <span class="text-xs font-black text-slate-800">{{ number_format($log->weight_kg, 2) }}kg</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-2.5">
                                    @if($log->offcut)
                                        <div class="space-y-1.5">
                                            <div class="flex items-center gap-1.5">
                                                <span class="inline-flex px-2 py-0.5 bg-emerald-500 text-white rounded text-[9px] font-black">{{ $log->offcut->offcut_code }}</span>
                                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded text-[9px] font-black uppercase">{{ $log->offcut->status }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-black text-emerald-600">{{ number_format($log->remaining_length, 2) }}m</span>
                                                    <span class="text-[8px] font-bold text-slate-400 uppercase">Length</span>
                                                </div>
                                                <div class="w-px h-6 bg-slate-200"></div>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-black text-blue-600">{{ $log->offcut->quantity ?? 1 }} pcs</span>
                                                    <span class="text-[8px] font-bold text-slate-400 uppercase">Available</span>
                                                </div>
                                            </div>
                                            @if($log->offcut->status === 'Available')
                                                <div class="flex items-center gap-1 text-cyan-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-2.5 h-2.5"><path d="M7 19H4.815a1.83 1.83 0 0 1-1.57-.881 1.785 1.785 0 0 1-.004-1.784L7.196 9.5"/><path d="M12 12V3"/><path d="M20 7v4a2 2 0 0 1-2 2H6.5"/><path d="M7 19h13.5a1.5 1.5 0 0 0 1.5-1.5V5.5A1.5 1.5 0 0 0 20 3.5"/></svg>
                                                    <span class="text-[9px] font-bold">Reusable for other sites</span>
                                                </div>
                                            @endif
                                        </div>
                                    @elseif($log->remaining_length == 0)
                                        <div class="flex items-center gap-1.5">
                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded text-[9px] font-black uppercase tracking-wider">No Wastage</span>
                                            <span class="text-[9px] text-slate-400 italic">(0.00m)</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1.5">
                                            <span class="px-2 py-0.5 bg-rose-50 text-rose-600 rounded text-[9px] font-black uppercase tracking-wider">Wastage</span>
                                            <span class="text-[9px] text-slate-400 italic">({{ number_format($log->remaining_length, 2) }}m)</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-2.5">
                                    <p class="text-xs font-bold text-slate-600 truncate max-w-[100px]">{{ $log->used_for ?? 'N/A' }}</p>
                                    @if($log->remarks)
                                        <p class="text-[9px] text-slate-400 italic">{{ Str::limit($log->remarks, 20) }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-2.5 text-right">
                                    <div class="flex items-center justify-end gap-1.5 opacity-0 group-hover:opacity-100 transition-all">
                                        @if($log->requirement && $log->requirement->site_id)
                                            <a href="{{ route('admin.rebar.sites.show', $log->requirement->site_id) }}" class="px-4 py-2 bg-cyan-50 text-cyan-600 rounded-xl font-bold text-xs hover:bg-cyan-100 transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M20 7V5a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v19a1 1 0 0 0 1.06.89"/><path d="M14 13h1.5a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.5-.5H14v7.5z"/><path d="M2 10h10"/></svg> View Site
                                            </a>
                                        @endif
                                        @if($log->user_id === auth()->id())
                                            <form action="{{ route('admin.rebar.cutting-logs.destroy', $log) }}" method="POST" onsubmit="return confirm('Delete this cutting log? This will also adjust inventory accordingly.')" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-rose-50 text-rose-600 rounded-xl font-bold text-xs hover:bg-rose-100 transition-all">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-slate-300"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><path d="M8 11h6"/></svg>
                                        </div>
                                        <h3 class="text-base font-black text-slate-900">No cutting logs</h3>
                                        <p class="text-xs text-slate-500 max-w-xs mx-auto">We couldn't find any cutting records matching your search or filters.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
                <div class="px-4 py-3 border-t border-slate-50 bg-slate-50/30">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>