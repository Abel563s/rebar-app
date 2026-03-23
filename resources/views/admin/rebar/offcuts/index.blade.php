<x-app-layout>
    <div class="py-6 space-y-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Off-Cut Register</h2>
                <nav
                    class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mt-1">
                    <span>Global Registry</span>
                    <li class="list-none p-1 rounded-full bg-slate-100"><i data-lucide="chevron-right"
                            class="w-2.5 h-2.5"></i></li>
                    <li class="list-none text-[#00ADC5]">Cross-Site Inventory</li>
                </nav>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-5 py-3 bg-white border border-slate-200 rounded-2xl shadow-sm flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-xs font-black text-slate-600 uppercase tracking-widest">Live Inventory</span>
                </div>
                <a href="{{ route('admin.rebar.sites.index') }}"
                    class="flex items-center gap-2 px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                    <i data-lucide="building-2" class="w-4 h-4"></i>
                    View by Site
                </a>
            </div>
        </div>

        <!-- Info Banner -->
        <div
            class="bg-gradient-to-r from-cyan-50 to-blue-50 border border-cyan-200 rounded-2xl p-6 flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-cyan-500 flex items-center justify-center flex-shrink-0">
                <i data-lucide="info" class="w-5 h-5 text-white"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider mb-1">Read-Only Inventory View
                </h3>
                <p class="text-sm text-slate-600 font-medium leading-relaxed">
                    This page displays all off-cuts across all project sites for monitoring purposes.
                    To <strong>change status or manage off-cuts</strong>, navigate to the specific <strong>Site
                        Hub</strong> by clicking "View Site" on any off-cut.
                </p>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-200/60">
            <form method="GET" action="{{ route('admin.rebar.offcuts.index') }}"
                class="grid grid-cols-1 md:grid-cols-5 gap-6">
                <div>
                    <label
                        class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search code..."
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
                    <label
                        class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Status</label>
                    <select name="status"
                        class="w-full bg-slate-50 border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600">
                        <option value="">All Statuses</option>
                        <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available
                        </option>
                        <option value="Used" {{ request('status') == 'Used' ? 'selected' : '' }}>Used</option>
                        <option value="Scrap" {{ request('status') == 'Scrap' ? 'selected' : '' }}>Wastage</option>
                    </select>
                </div>
                <div>
                    <label
                        class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Diameter</label>
                    <select name="diameter"
                        class="w-full bg-slate-50 border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600">
                        <option value="">All Sizes</option>
                        @foreach([10, 12, 16, 20, 25, 32] as $d)
                            <option value="{{ $d }}" {{ request('diameter') == $d ? 'selected' : '' }}>{{ $d }}mm</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit"
                        class="flex-1 py-2.5 bg-slate-900 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all">Filter</button>
                    <a href="{{ route('admin.rebar.offcuts.index') }}"
                        class="p-2.5 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all">
                        <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-100 border border-slate-200/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Off-Cut Code</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Specifications</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Site/Location</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Last
                                Updated</th>
                            <th
                                class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($offcuts as $offcut)
                            <tr class="hover:bg-slate-50/50 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center text-cyan-600">
                                            <i data-lucide="hash" class="w-5 h-5"></i>
                                        </div>
                                        <span class="text-sm font-black text-slate-900">{{ $offcut->offcut_code }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-slate-400 uppercase">Diameter</span>
                                            <span
                                                class="text-sm font-bold text-slate-700">Ø{{ $offcut->bar_diameter }}mm</span>
                                        </div>
                                        <div class="w-px h-8 bg-slate-100"></div>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-slate-400 uppercase">Length</span>
                                            <span
                                                class="text-sm font-black text-slate-900">{{ number_format($offcut->length, 2) }}m</span>
                                        </div>
                                        <div class="w-px h-8 bg-slate-100"></div>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-cyan-500 uppercase tracking-widest leading-none">Weight</span>
                                            <span class="text-sm font-black text-slate-900">{{ number_format($offcut->weight_kg, 2) }}kg</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @if($offcut->status === 'Available')
                                        <div
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100">
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                            <span class="text-[10px] font-black uppercase tracking-wider">Available</span>
                                        </div>
                                    @elseif($offcut->status === 'Used')
                                        <div
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-full border border-blue-100">
                                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div>
                                            <span class="text-[10px] font-black uppercase tracking-wider">Used</span>
                                        </div>
                                    @else
                                        <div
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-rose-50 text-rose-600 rounded-full border border-rose-100">
                                            <div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div>
                                            <span class="text-[10px] font-black uppercase tracking-wider">Wastage</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2 mb-1">
                                            <i data-lucide="building-2" class="w-3.5 h-3.5 text-cyan-500"></i>
                                            <span
                                                class="text-sm font-black text-slate-900 group-hover:text-cyan-600 transition-colors">
                                                {{ $offcut->site?->site_name ?? 'Global' }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2 text-slate-400">
                                            <i data-lucide="map-pin" class="w-3 h-3"></i>
                                            <span
                                                class="text-[10px] font-bold uppercase tracking-wider line-clamp-1 italic">
                                                {{ $offcut->storage_location ?? 'General Storage' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-bold text-slate-700">{{ $offcut->updated_at->format('M d, Y') }}</span>
                                        <span
                                            class="text-[10px] text-slate-400 font-medium">{{ $offcut->updated_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                        @if($offcut->status === 'Available')
                                            <form action="{{ route('admin.rebar.offcuts.update-status', $offcut) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Used">
                                                <button type="submit"
                                                    class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition-all"
                                                    title="Mark as Used">
                                                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.rebar.offcuts.update-status', $offcut) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Scrap">
                                                <button type="submit"
                                                    class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg transition-all"
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
                                                    class="p-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-lg transition-all"
                                                    title="Restore to Available">
                                                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if($offcut->site_id)
                                            <a href="{{ route('admin.rebar.sites.show', $offcut->site_id) }}"
                                                class="flex items-center gap-2 px-4 py-2 text-cyan-600 bg-cyan-50 hover:bg-cyan-100 rounded-xl transition-all font-bold text-xs"
                                                title="View Site Hub">
                                                <i data-lucide="external-link" class="w-4 h-4"></i>
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
                                <td colspan="6" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-4">
                                            <i data-lucide="package-x" class="w-10 h-10 text-slate-300"></i>
                                        </div>
                                        <h3 class="text-lg font-black text-slate-900">No off-cuts matched</h3>
                                        <p class="text-sm text-slate-500 max-w-xs mx-auto">Try adjusting your filters or
                                            check back later.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($offcuts->hasPages())
                <div class="px-8 py-5 border-t border-slate-50 bg-slate-50/30">
                    {{ $offcuts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>