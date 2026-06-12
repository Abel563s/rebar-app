<x-app-layout>
    <div class="py-6 space-y-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <style>
            .responsive-cards-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
                gap: 24px;
            }

            .timeline-card {
                border-left: 4px solid #00515f;
                transition: background .18s ease;
            }

            .timeline-card:hover {
                background: #f8fafc;
            }

            /* Ensure premium cards have consistent spacing */
            .premium-card { margin-bottom: 24px; }
        </style>
        <!-- Premium Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-1">
                <h2 class="text-4xl font-black text-slate-900 tracking-tight font-outfit">Operational Intelligence</h2>
                <p class="text-slate-500 font-medium font-inter italic">Comprehensive multi-site fabrication, steel grade analytics, and resource recovery.</p>
            </div>

            <div class="flex items-center gap-3">
                <button onclick="window.print()"
                    class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 transition-all active:scale-95 shadow-sm">
                    <i data-lucide="printer" class="w-4 h-4"></i>
                    Export PDF
                </button>
                <div class="h-10 w-px bg-slate-200 mx-2"></div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Report Cycle</p>
                    <p class="text-xs font-bold text-slate-700">{{ now()->format('F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Global Performance Cards -->
        <div class="responsive-cards-grid mb-8">
            <!-- Card 1: Global Load -->
            <div class="premium-card p-6 overflow-hidden relative group bg-white rounded-3xl border border-slate-100 shadow-sm transition-all hover:shadow-md">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-cyan-50 rounded-full blur-2xl group-hover:bg-cyan-100 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-4">
                    <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center border border-cyan-100">
                        <i data-lucide="globe" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Global Load</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-black text-slate-900 tracking-tighter">{{ number_format($global['total_req_length'], 1) }}</span>
                            <span class="text-[10px] font-black text-slate-400 uppercase">m</span>
                        </div>
                        <p class="text-[10px] font-bold text-slate-500 mt-1">Total Weight: {{ number_format($global['total_req_weight'], 1) }} kg</p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Fabrication -->
            <div class="premium-card p-6 overflow-hidden relative group bg-white rounded-3xl border border-slate-100 shadow-sm transition-all hover:shadow-md">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full blur-2xl group-hover:bg-blue-100 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                        <i data-lucide="scissors" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Fabrication</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-black text-slate-900 tracking-tighter">{{ number_format($global['total_fab_length'], 1) }}</span>
                            <span class="text-[10px] font-black text-slate-400 uppercase">m</span>
                        </div>
                        <p class="text-[10px] font-bold text-slate-500 mt-1">Total Weight: {{ number_format($global['total_fab_weight'], 1) }} kg</p>
                    </div>
                </div>
            </div>

            <!-- Card 3: Steel Recovery -->
            <div class="premium-card p-6 overflow-hidden relative group bg-white rounded-3xl border border-slate-100 shadow-sm transition-all hover:shadow-md">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                        <i data-lucide="recycle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Recovery & Re-use</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-black text-slate-900 tracking-tighter">{{ number_format($global['total_reused_length'], 1) }}</span>
                            <span class="text-[10px] font-black text-slate-400 uppercase">m</span>
                        </div>
                        <p class="text-[10px] font-bold text-emerald-600 mt-1">Recovery Rate: {{ $global['reuse_rate_pct'] }}% of cuts</p>
                    </div>
                </div>
            </div>

            <!-- Card 4: System Wastage -->
            <div class="premium-card p-6 overflow-hidden relative group bg-white rounded-3xl border border-slate-100 shadow-sm transition-all hover:shadow-md">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-50 rounded-full blur-2xl group-hover:bg-rose-100 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-4">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-100">
                        <i data-lucide="trash-2" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">System Scrap</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-black text-slate-900 tracking-tighter">{{ number_format($global['total_scrap_length'], 1) }}</span>
                            <span class="text-[10px] font-black text-slate-400 uppercase">m</span>
                        </div>
                        <p class="text-[10px] font-bold text-rose-600 mt-1">Wastage Rate: {{ $global['wastage_pct'] }}% of volume</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory Off-cuts Summary Card -->
        <div class="premium-card p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <span class="inline-block text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full" style="background: rgba(0,81,95,0.1); color: #00515f;">Active Off-Cut Reserve</span>
                    <h3 class="text-2xl font-black tracking-tight font-outfit mt-3" style="color:#0f172a; font-weight:700;">Recycled Material Asset Registry</h3>
                    <p class="text-xs mt-1" style="color:#64748b;">Currently holding reusable metal resource assets across multiple yards.</p>
                </div>

                <div class="flex items-center gap-8 rounded-2xl p-4" style="border:1px solid #e5e7eb;">
                    <div class="text-center">
                        <p class="text-[9px] font-black uppercase tracking-widest" style="color:#64748b;">Available Count</p>
                        <p class="text-2xl font-black text-slate-900">{{ number_format($global['total_avail_count']) }} <span class="text-xs font-bold text-slate-500">pcs</span></p>
                    </div>
                    <div class="w-px h-10 bg-slate-200"></div>
                    <div class="text-center">
                        <p class="text-[9px] font-black uppercase tracking-widest" style="color:#64748b;">Total Length</p>
                        <p class="text-2xl font-black text-slate-900">{{ number_format($global['total_avail_length'], 1) }} <span class="text-xs font-bold text-slate-500">m</span></p>
                    </div>
                    <div class="w-px h-10 bg-slate-200"></div>
                    <div class="text-center">
                        <p class="text-[9px] font-black uppercase tracking-widest" style="color:#64748b;">Asset Weight</p>
                        <p class="text-2xl font-black text-slate-900">{{ number_format($global['total_avail_weight'], 1) }} <span class="text-xs font-bold text-slate-500">kg</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Grid -->
        <style>
            /* Stack major analytics sections vertically for readability */
            .analytics-layout { display: grid; gap:24px; grid-template-columns: 1fr; }

            /* The left column previously forced multi-column layouts; keep its children full-width */
            .analytics-left { display: block; }
            .analytics-left > .premium-card { width:100%; display:block; }
            .analytics-right { display:block; }
        </style>

        <div class="analytics-layout mb-8">
            <div class="analytics-left">
            <!-- 1. Site Node Performance -->
            <div class="lg:col-span-12 premium-card p-0 overflow-hidden shadow-xl shadow-slate-200/50 border border-slate-100 bg-white rounded-3xl">
                <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight font-outfit">Multi-Site Hub Performance Metrics</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Real-time load, fabrication, recovery, and active inventory status</p>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100 self-start md:self-auto">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[9px] font-black uppercase tracking-widest">Live Syncing</span>
                    </div>
                </div>
                <div>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Site Node</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Grade</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Requirements</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Requested Load</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Fabricated</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Scrap / Wastage</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Active Off-cuts</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Progress</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($siteStats as $site)
                                <tr class="hover:bg-slate-50/55 transition-colors group">
                                    <!-- Site Name & Code -->
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black text-cyan-500 uppercase tracking-widest leading-none mb-1">{{ $site['code'] }}</span>
                                            <a href="{{ route('admin.rebar.sites.show', $site['id']) }}" class="text-sm font-black text-slate-900 hover:text-cyan-600 transition-colors">{{ $site['name'] }}</a>
                                        </div>
                                    </td>
                                    <!-- Steel Grade -->
                                    <td class="px-6 py-6 text-center">
                                        <span class="text-xs font-black px-2 py-1 bg-slate-100 text-slate-700 rounded-md border border-slate-200">
                                            Grade {{ $site['steel_grade'] ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <!-- Requirements count -->
                                    <td class="px-6 py-6 text-center text-sm font-bold text-slate-600">
                                        {{ $site['requirements_count'] }}
                                    </td>
                                    <!-- Requested Load -->
                                    <td class="px-6 py-6 text-center">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-700">{{ number_format($site['total_requested_length'], 1) }} m</span>
                                            <span class="text-[9px] font-bold text-slate-400 uppercase mt-0.5">{{ number_format($site['total_requested_weight'], 1) }} kg</span>
                                        </div>
                                    </td>
                                    <!-- Fabricated -->
                                    <td class="px-6 py-6 text-center">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-emerald-600">{{ number_format($site['total_fabricated_length'], 1) }} m</span>
                                            <span class="text-[9px] font-bold text-emerald-500 uppercase mt-0.5">{{ number_format($site['total_fabricated_weight'], 1) }} kg</span>
                                        </div>
                                    </td>
                                    <!-- Scrap / Wastage -->
                                    <td class="px-6 py-6 text-center">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-rose-500">{{ number_format($site['scrap_length'], 1) }} m</span>
                                            <span class="text-[9px] font-bold text-rose-400 uppercase mt-0.5">{{ number_format($site['scrap_weight'], 1) }} kg</span>
                                        </div>
                                    </td>
                                    <!-- Active Off-cuts in Inventory -->
                                    <td class="px-6 py-6 text-center">
                                        <div class="flex flex-col items-center">
                                            <span class="text-xs font-black text-slate-800 bg-emerald-50 border border-emerald-100 rounded-lg px-2.5 py-1">
                                                {{ $site['available_count'] }} pcs
                                            </span>
                                            <span class="text-[9px] font-bold text-slate-500 uppercase mt-1">{{ number_format($site['available_length'], 1) }}m | {{ number_format($site['available_weight'], 1) }}kg</span>
                                        </div>
                                    </td>
                                    <!-- Progress Bar & Action -->
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4 justify-end">
                                            <div class="w-36 space-y-1.5">
                                                <div class="flex justify-between items-center text-[9px] font-black uppercase">
                                                    <span class="text-slate-400">Progress</span>
                                                    <span class="text-cyan-600">{{ $site['progress'] }}%</span>
                                                </div>
                                                <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden p-[1px]">
                                                    <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full transition-all duration-1000 shadow-[0_0_8px_rgba(6,182,212,0.4)]"
                                                        style="width: {{ $site['progress'] }}%"></div>
                                                </div>
                                            </div>
                                            <a href="{{ route('admin.rebar.sites.show', $site['id']) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 bg-white border border-slate-200 rounded-lg text-slate-500 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all active:scale-95 shadow-sm">
                                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 2. Steel Grade Analysis (Enhanced Multi-dimensional Card) -->
            <div class="lg:col-span-12 premium-card bg-white border border-slate-100 shadow-xl shadow-slate-200/50 rounded-3xl p-8">
                <div class="mb-8">
                    <span class="text-[9px] font-black uppercase text-cyan-600 bg-cyan-50 border border-cyan-100 px-2.5 py-1 rounded-md">Strength distribution</span>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight font-outfit mt-3">Fabrication by Steel Grade</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Production loads segmented by material yield strength</p>
                </div>

                <div class="space-y-6">
                    @foreach($gradeStats as $stat)
                        <div class="bg-slate-50/70 border border-slate-100 rounded-2xl p-4 space-y-4 hover:border-cyan-200 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black text-xs font-outfit">
                                        G{{ $stat->steel_grade }}
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider">Grade {{ $stat->steel_grade }} Steel</h4>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase mt-0.5">Requested Load: {{ number_format($stat->req_length, 1) }}m ({{ number_format($stat->req_weight, 1) }}kg)</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-black text-slate-800">{{ $stat->progress }}% completed</span>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-slate-800 to-slate-900 rounded-full transition-all duration-1000" style="width: {{ $stat->progress }}%"></div>
                                </div>
                                <div class="flex justify-between items-center text-[9px] font-bold text-slate-500">
                                    <span>Fabricated: {{ number_format($stat->fab_length, 1) }}m</span>
                                    <span>Scrap generated: {{ number_format($stat->scrap_length, 1) }}m</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 3. Monthly Fabrication Trend -->
            <div class="lg:col-span-12 premium-card bg-white border border-slate-100 shadow-xl shadow-slate-200/50 rounded-3xl p-8">
                <div class="mb-8">
                    <span class="text-[9px] font-black uppercase text-blue-600 bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-md">Timeline Pulse</span>
                    <h3 class="text-xl font-black tracking-tight font-outfit mt-3" style="color:#0f172a; font-weight:700;">Monthly Output Flow</h3>
                    <p class="text-xs font-bold uppercase tracking-widest mt-1 italic" style="color:#64748b;">Fabricated length and structural mass flow over the last 12 months</p>
                </div>

                <div class="space-y-4">
                    @foreach($monthlyTrend as $trend)
                        <div class="flex items-center justify-between timeline-card bg-slate-50/50 border border-slate-100 rounded-2xl p-4 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <i data-lucide="calendar" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-black text-slate-800 font-outfit">{{ $trend->month }}</h4>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase mt-0.5">Average output weight: {{ number_format($trend->total_weight, 1) }} kg</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-black text-blue-600 font-outfit">{{ number_format($trend->total_length, 1) }} m</span>
                                <span class="text-[9px] font-black text-slate-400 uppercase block tracking-wider mt-0.5">Processed</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 4. Bar Diameter Distribution Analysis -->
            <div class="lg:col-span-12 premium-card bg-slate-900 border-none relative overflow-hidden shadow-2xl shadow-slate-950/20 rounded-3xl p-8 text-white">
                <div class="absolute -top-32 -right-32 w-80 h-80 bg-cyan-500/10 rounded-full blur-[100px]"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="mb-8">
                        <span class="text-[9px] font-black uppercase text-cyan-400 bg-cyan-950/40 border border-cyan-800/30 px-2.5 py-1 rounded-md">Load by diameter</span>
                        <h3 class="text-xl font-black text-white tracking-tight font-outfit mt-3">Bar Diameter Calibration</h3>
                        <p class="text-xs font-bold text-cyan-400/60 uppercase tracking-widest mt-1 italic">Calibration volumes, weight, and reuse metrics</p>
                    </div>

                    <div class="flex-1 space-y-5">
                        @foreach($diameterStats as $stat)
                            @php $p = $global['total_req_length'] > 0 ? ($stat->req_length / $global['total_req_length']) * 100 : 0; @endphp
                            <div class="bg-white/5 border border-white/5 rounded-2xl p-4 space-y-3 group hover:bg-white/10 transition-all">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2.5 h-2.5 rounded-full @if($stat->bar_diameter >= 16) bg-rose-500 @elseif($stat->bar_diameter >= 12) bg-amber-500 @else bg-cyan-400 @endif group-hover:scale-125 transition-transform"></div>
                                        <span class="text-xs font-black text-slate-200 tracking-wider">Ø{{ $stat->bar_diameter }}mm</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-black text-white">{{ number_format($stat->req_length, 1) }}m</span>
                                        <span class="text-[9px] font-bold text-slate-400 block">{{ number_format($stat->req_weight, 1) }} kg</span>
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <div class="h-1.5 bg-white/10 rounded-full overflow-hidden">
                                        <div class="h-full @if($stat->bar_diameter >= 16) bg-rose-500 @elseif($stat->bar_diameter >= 12) bg-amber-500 @else bg-cyan-400 @endif transition-all duration-1000"
                                            style="width: {{ $p }}%"></div>
                                    </div>
                                    <div class="flex justify-between items-center text-[9px] font-bold text-slate-400">
                                        <span>Fabricated: {{ number_format($stat->fab_length, 1) }}m ({{ number_format($stat->fab_weight, 1) }}kg)</span>
                                        <span class="text-emerald-400">Reused: {{ number_format($stat->reused_length, 1) }}m</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 pt-6 border-t border-white/10">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Active Diameter Variants</span>
                            <span class="text-sm font-black text-white">{{ $diameterStats->count() }} Sizes</span>
                        </div>
                    </div>
                </div>
            </div>

            

            <!-- 5. Recent Operational Highlights -->
            <div class="premium-card bg-white border border-slate-100 shadow-xl shadow-slate-200/50 rounded-3xl p-8 font-inter">
                <div class="mb-8">
                    <span class="text-[9px] font-black uppercase text-amber-600 bg-amber-50 border border-amber-100 px-2.5 py-1 rounded-md">Site Activities</span>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight font-outfit mt-3">Operational Stream</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Latest 5 fabrications completed in the yards</p>
                </div>

                <div class="flow-root">
                    <ul class="-mb-8">
                        @foreach($recentLogs as $logIdx => $log)
                            <li>
                                <div class="relative pb-8">
                                    @if($logIdx !== $recentLogs->count() - 1)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-100" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full flex items-center justify-center text-xs font-black @if($log->reused_offcut_id) bg-emerald-50 text-emerald-600 border border-emerald-100 @else bg-cyan-50 text-cyan-600 border border-cyan-100 @endif">
                                                @if($log->reused_offcut_id)
                                                    <i data-lucide="recycle" class="w-4 h-4"></i>
                                                @else
                                                    <i data-lucide="scissors" class="w-4 h-4"></i>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-black text-slate-800 font-outfit">
                                                Cut {{ $log->quantity_cut }}x Ø{{ $log->bar_diameter }}mm @if($log->reused_offcut_id) from off-cut @else from standard @endif
                                            </p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase mt-0.5">
                                                Site: {{ $log->site?->site_code ?? 'N/A' }} | Element: {{ $log->requirement?->structural_element ?? 'N/A' }}
                                            </p>
                                            <div class="mt-2 flex items-center gap-2">
                                                <span class="text-[9px] font-black px-1.5 py-0.5 bg-slate-100 text-slate-500 rounded uppercase tracking-wider">
                                                    {{ $log->cut_length }}m length
                                                </span>
                                                @if($log->reused_offcut_id)
                                                    <span class="text-[9px] font-black px-1.5 py-0.5 bg-emerald-100 text-emerald-700 rounded uppercase tracking-wider">
                                                        Recycled
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="text-[8px] font-bold text-slate-400 block mt-2 uppercase tracking-wide">
                                                {{ $log->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            </div>

            
        </div>
    </div>
</x-app-layout>