<x-app-layout>
    <div class="py-6 space-y-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Premium Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-1">
                <h2 class="text-4xl font-black text-slate-900 tracking-tight font-outfit">Operational Intelligence</h2>
                <p class="text-slate-500 font-medium font-inter italic">Comprehensive multi-site fabrication and
                    resource analytics.</p>
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $totalRequested = $siteStats->sum('total_requested');
                $totalFabricated = $siteStats->sum('total_fabricated');
                $totalSavings = $siteStats->sum('savings');
                $totalWastage = $siteStats->sum('wastage');

                $cards = [
                    ['label' => 'Global Load', 'value' => number_format($totalRequested, 1), 'unit' => 'm', 'icon' => 'globe', 'color' => 'cyan'],
                    ['label' => 'Total Fabrication', 'value' => number_format($totalFabricated, 1), 'unit' => 'm', 'icon' => 'scissors', 'color' => 'blue'],
                    ['label' => 'Steel Recovery', 'value' => number_format($totalSavings, 1), 'unit' => 'm', 'icon' => 'recycle', 'color' => 'emerald'],
                    ['label' => 'System Wastage', 'value' => number_format($totalWastage, 1), 'unit' => 'm', 'icon' => 'trash-2', 'color' => 'rose'],
                ];
            @endphp

            @foreach($cards as $card)
                <div class="premium-card p-6 overflow-hidden relative group">
                    <div
                        class="absolute -right-4 -top-4 w-24 h-24 bg-{{ $card['color'] }}-50 rounded-full blur-2xl group-hover:bg-{{ $card['color'] }}-100 transition-colors">
                    </div>
                    <div class="relative z-10 flex flex-col gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-600 flex items-center justify-center border border-{{ $card['color'] }}-100">
                            <i data-lucide="{{ $card['icon'] }}" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">
                                {{ $card['label'] }}</p>
                            <div class="flex items-baseline gap-1">
                                <span
                                    class="text-3xl font-black text-slate-900 tracking-tighter">{{ $card['value'] }}</span>
                                <span class="text-[10px] font-black text-slate-400 uppercase">{{ $card['unit'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Analytics Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- 1. Site Efficiency Table -->
            <div class="lg:col-span-8 premium-card p-0 overflow-hidden shadow-xl shadow-slate-200/50 border-none">
                <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight font-outfit">Site Node Performance
                        </h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Real-time
                            status across construction hubs</p>
                    </div>
                    <div
                        class="flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[9px] font-black uppercase tracking-widest tracking-widest">Live Sync</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Site Node</th>
                                <th
                                    class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">
                                    Load (m)</th>
                                <th
                                    class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">
                                    Fab (m)</th>
                                <th
                                    class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">
                                    Growth</th>
                                <th
                                    class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($siteStats as $site)
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-[10px] font-black text-cyan-500 uppercase tracking-widest leading-none mb-1">{{ $site['code'] }}</span>
                                            <span
                                                class="text-sm font-black text-slate-900 group-hover:text-cyan-600 transition-colors">{{ $site['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center text-sm font-bold text-slate-700">
                                        {{ number_format($site['total_requested'], 1) }}
                                    </td>
                                    <td class="px-8 py-6 text-center text-sm font-black text-emerald-600">
                                        {{ number_format($site['total_fabricated'], 1) }}
                                    </td>
                                    <td class="px-8 py-6 min-w-[150px]">
                                        <div class="space-y-2">
                                            <div class="flex justify-between items-center text-[9px] font-black uppercase">
                                                <span class="text-slate-400">Progress</span>
                                                <span class="text-cyan-600">{{ $site['progress'] }}%</span>
                                            </div>
                                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden p-[1px]">
                                                <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full transition-all duration-1000 shadow-[0_0_8px_rgba(6,182,212,0.4)]"
                                                    style="width: {{ $site['progress'] }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <a href="{{ route('admin.rebar.sites.show', $site['id']) }}"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all active:scale-95 shadow-sm">
                                            Manage Node
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 2. Diameter Distribution -->
            <div class="lg:col-span-4 flex flex-col gap-8">
                <div
                    class="premium-card p-8 bg-slate-900 border-none relative overflow-hidden flex-1 shadow-[0_20px_50px_rgba(15,23,42,0.2)]">
                    <div class="absolute -top-32 -right-32 w-80 h-80 bg-cyan-500/10 rounded-full blur-[100px]"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="mb-10">
                            <h3 class="text-xl font-black text-white tracking-tight font-outfit">Bar Distribution</h3>
                            <p class="text-xs font-bold text-cyan-400/60 uppercase tracking-widest mt-1 italic italic">
                                Strategic load by diameter</p>
                        </div>

                        <div class="flex-1 space-y-6">
                            @foreach($diameterStats as $stat)
                                @php $p = $totalRequested > 0 ? ($stat->volume / $totalRequested) * 100 : 0; @endphp
                                <div class="space-y-2 group">
                                    <div class="flex justify-between items-end">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-2 h-2 rounded-full @if($stat->bar_diameter >= 16) bg-rose-500 @elseif($stat->bar_diameter >= 12) bg-amber-500 @else bg-cyan-500 @endif group-hover:scale-150 transition-transform">
                                            </div>
                                            <span
                                                class="text-[11px] font-black text-slate-300 uppercase tracking-widest">Ø{{ $stat->bar_diameter }}mm</span>
                                        </div>
                                        <span
                                            class="text-[11px] font-black text-white">{{ number_format($stat->volume, 1) }}m</span>
                                    </div>
                                    <div class="h-1 bg-white/5 rounded-full overflow-hidden">
                                        <div class="h-full @if($stat->bar_diameter >= 16) bg-rose-500 @elseif($stat->bar_diameter >= 12) bg-amber-500 @else bg-cyan-500 @endif transition-all duration-1000"
                                            style="width: {{ $p }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-10 pt-6 border-t border-white/5">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Total
                                    Nodes Scan</span>
                                <span class="text-sm font-black text-white">{{ $diameterStats->count() }}
                                    Variants</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Trend Insight Card -->
                <div
                    class="premium-card p-8 border-none bg-gradient-to-br from-cyan-600 to-blue-700 text-white relative overflow-hidden">
                    <div
                        class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(255,255,255,0.1),transparent)] opacity-50">
                    </div>
                    <div class="relative z-10 space-y-6">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-md">
                                <i data-lucide="zap" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-black tracking-tighter leading-tight">Monthly Growth Pulse</h4>
                                <p class="text-[10px] font-black uppercase tracking-widest opacity-60">System health
                                    overview</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            @foreach($monthlyTrend->reverse()->take(3) as $trend)
                                <div class="flex items-center justify-between group">
                                    <span
                                        class="text-xs font-bold text-cyan-50 group-hover:translate-x-1 transition-transform">{{ $trend->month }}</span>
                                    <div class="flex flex-col items-end">
                                        <span class="text-xs font-black">{{ number_format($trend->total, 1) }}m</span>
                                        <div
                                            class="w-8 h-0.5 bg-white/20 rounded-full mt-1 group-hover:w-full transition-all">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>