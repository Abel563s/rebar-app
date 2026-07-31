<x-app-layout>
    <div class="min-w-0 space-y-4 py-5">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Off-Cut Register</h2>
                <nav class="flex items-center gap-1.5 text-[9px] font-black uppercase tracking-widest text-slate-400 mt-0.5">
                    <span>Global Registry</span>
                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 18l6-6-6-6"/></svg>
                    <li class="list-none text-[#00ADC5]">Cross-Site Inventory</li>
                </nav>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg flex items-center gap-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Live Inventory</span>
                </div>
                <a href="{{ route('admin.rebar.sites.index') }}"
                    class="flex items-center gap-1.5 px-4 py-2 bg-slate-100 text-slate-700 rounded-lg font-bold text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18v-8a2 2 0 00-2-2H5a2 2 0 00-2 2v8z M9 9V3a2 2 0 012-2h2a2 2 0 012 2v6 M9 21V9"/></svg>
                    View by Site
                </a>
            </div>
        </div>

        <!-- Info Banner -->
        <div class="bg-cyan-50/50 border border-cyan-200 rounded-xl p-4 flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-cyan-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z M12 16v-4 M12 8h.01"/></svg>
            </div>
            <div class="flex-1">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider mb-0.5">Read-Only Inventory View
                </h3>
                <p class="text-xs text-slate-600 font-medium leading-relaxed">
                    This page displays all off-cuts across all project sites for monitoring purposes.
                    To <strong>change status or manage off-cuts</strong>, navigate to the specific <strong>Site
                        Hub</strong> by clicking "View Site" on any off-cut.
                </p>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="section-card shadow-lg hover:shadow-xl transition-all bg-white/90 backdrop-blur-sm border border-slate-200/60">
            <form method="GET" action="{{ route('admin.rebar.offcuts.index') }}"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label
                        class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search code..."
                        class="w-full bg-slate-50 border-slate-200 rounded-lg py-2 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-sm">
                </div>
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Project
                        Site</label>
                    <select name="site_id"
                        class="w-full bg-slate-50 border-slate-200 rounded-lg py-2 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-sm">
                        <option value="">All Sites</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}" {{ request('site_id') == $site->id ? 'selected' : '' }}>
                                {{ $site->site_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label
                        class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status</label>
                    <select name="status"
                        class="w-full bg-slate-50 border-slate-200 rounded-lg py-2 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-sm">
                        <option value="">All Statuses</option>
                        <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available
                        </option>
                        <option value="Used" {{ request('status') == 'Used' ? 'selected' : '' }}>Used</option>
                        <option value="Scrap" {{ request('status') == 'Scrap' ? 'selected' : '' }}>Wastage</option>
                    </select>
                </div>
                <div>
                    <label
                        class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Diameter</label>
                    <select name="diameter"
                        class="w-full bg-slate-50 border-slate-200 rounded-lg py-2 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-sm">
                        <option value="">All Sizes</option>
                        @foreach([10, 12, 16, 20, 25, 32] as $d)
                            <option value="{{ $d }}" {{ request('diameter') == $d ? 'selected' : '' }}>{{ $d }}mm</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit"
                        class="flex-1 py-2 bg-slate-900 text-white rounded-lg font-black text-[10px] uppercase tracking-widest hover:bg-slate-800 transition-all">Filter</button>
                    <a href="{{ route('admin.rebar.offcuts.index') }}"
                        class="p-2 bg-slate-100 text-slate-500 rounded-lg hover:bg-slate-200 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-6.219-8.707"/></svg>
                    </a>
                </div>
            </form>
        </div>

        <div class="section-card">
            <div class="overflow-x-auto shadow-lg hover:shadow-xl transition-all">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#00adc5] text-white">
                            <th class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest">
                                Off-Cut Code</th>
                            <th class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest">
                                Specifications</th>
                            <th class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest">
                                Status</th>
                            <th class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest">
                                Site/Location</th>
                            <th class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest">Last
                                Updated</th>
                            <th
                                class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($offcuts as $offcut)
                            <tr class="hover:bg-slate-50/50 transition-all group">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-cyan-50 flex items-center justify-center text-cyan-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9h16 M4 15h16 M10 3L8 21 M16 3l-2 18"/></svg>
                                        </div>
                                        <span class="text-xs font-black text-slate-900">{{ $offcut->offcut_code }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex flex-col">
                                            <span class="text-[8px] font-black text-slate-400 uppercase">Diameter</span>
                                            <span
                                                class="text-xs font-bold text-slate-700">Ø{{ $offcut->bar_diameter }}mm</span>
                                        </div>
                                        <div class="w-px h-6 bg-slate-100"></div>
                                        <div class="flex flex-col">
                                            <span class="text-[8px] font-black text-slate-400 uppercase">Length</span>
                                            <span
                                                class="text-xs font-black text-slate-900">{{ number_format($offcut->length, 2) }}m</span>
                                        </div>
                                        <div class="w-px h-6 bg-slate-100"></div>
                                        <div class="flex flex-col">
                                            <span class="text-[8px] font-black text-slate-400 uppercase">Pieces</span>
                                            <span class="text-xs font-black text-slate-900">{{ $offcut->quantity }} pcs</span>
                                        </div>
                                        <div class="w-px h-6 bg-slate-100"></div>
                                        <div class="flex flex-col">
                                            <span class="text-[8px] font-black text-cyan-500 uppercase tracking-widest leading-none">Weight</span>
                                            <span class="text-xs font-black text-slate-900">{{ number_format($offcut->weight_kg, 2) }}kg</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($offcut->status === 'Available')
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2 py-1 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100">
                                            <div class="w-1 h-1 rounded-full bg-emerald-500"></div>
                                            <span class="text-[9px] font-black uppercase tracking-wider">Available</span>
                                        </div>
                                    @elseif($offcut->status === 'Used')
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2 py-1 bg-blue-50 text-blue-600 rounded-full border border-blue-100">
                                            <div class="w-1 h-1 rounded-full bg-blue-500"></div>
                                            <span class="text-[9px] font-black uppercase tracking-wider">Used</span>
                                        </div>
                                    @else
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2 py-1 bg-rose-50 text-rose-600 rounded-full border border-rose-100">
                                            <div class="w-1 h-1 rounded-full bg-rose-500"></div>
                                            <span class="text-[9px] font-black uppercase tracking-wider">Wastage</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-1.5 mb-0.5">
                                            <svg class="w-3.5 h-3.5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18v-8a2 2 0 00-2-2H5a2 2 0 00-2 2v8z M9 9V3a2 2 0 012-2h2a2 2 0 012 2v6 M9 21V9"/></svg>
                                            <span
                                                class="text-xs font-black text-slate-900 group-hover:text-cyan-600 transition-colors">
                                                {{ $offcut->site?->site_name ?? 'Global' }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-slate-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z M12 10a2 2 0 100-4 2 2 0 000 4z"/></svg>
                                            <span
                                                class="text-[9px] font-bold uppercase tracking-wider line-clamp-1 italic">
                                                {{ $offcut->storage_location ?? 'General Storage' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-xs font-bold text-slate-700">{{ $offcut->updated_at->format('M d, Y') }}</span>
                                        <span
                                            class="text-[9px] text-slate-400 font-medium">{{ $offcut->updated_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                        @if($offcut->status === 'Available')
                                            <form action="{{ route('admin.rebar.offcuts.update-status', $offcut) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Used">
                                                <button type="submit"
                                                    class="p-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-md transition-all"
                                                    title="Mark as Used">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 11.08V12a10 10 0 11-5.93-9.14 M22 4L12 14.01l-3-3"/></svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.rebar.offcuts.update-status', $offcut) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Scrap">
                                                <button type="submit"
                                                    class="p-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-md transition-all"
                                                    title="Mark as Wastage">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18 M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6 M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2 M10 11v6 M14 11v6"/></svg>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.rebar.offcuts.update-status', $offcut) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Available">
                                                <button type="submit"
                                                    class="p-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-md transition-all"
                                                    title="Restore to Available">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-6.219-8.707"/></svg>
                                                </button>
                                            </form>
                                        @endif

                                        @if($offcut->site_id)
                                            <a href="{{ route('admin.rebar.sites.show', $offcut->site_id) }}"
                                                class="flex items-center gap-1.5 px-3 py-1.5 text-cyan-600 bg-cyan-50 hover:bg-cyan-100 rounded-lg transition-all font-bold text-[10px]"
                                                title="View Site Hub">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6 M15 3h6v6 M10 14L21 3"/></svg>
                                                Site Hub
                                            </a>
                                        @else
                                            <span class="text-[10px] font-black text-slate-300 uppercase">No Site</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-12 h-12 bg-slate-50 rounded-lg flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 9.5l-9-5L3 7v6.1l4 2.2 4-2.2V7l4.5 2.5z M16.5 9.5L21 7v10l-4.5-2.5V9.5z M2 17l10 5 10-5 M12 12v9"/></svg>
                                        </div>
                                        <h3 class="text-base font-black text-slate-900">No off-cuts matched</h3>
                                        <p class="text-xs text-slate-500 max-w-xs mx-auto">Try adjusting your filters or
                                            check back later.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($offcuts->hasPages())
                <div class="px-4 py-3 border-t border-slate-50 bg-slate-50/30">
                    {{ $offcuts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>