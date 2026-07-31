<x-app-layout>
    <div class="py-6 space-y-6 min-w-0">
        <style>
            .dash-grid { display: grid; gap: 16px; }
            .kpi-card {
                background: #fff;
                border: 1px solid rgba(15,23,42,0.06);
                border-radius: 1.25rem;
                padding: 16px;
                box-shadow: 0 4px 12px rgba(15,23,42,0.03);
                transition: all .2s ease;
            }
            .kpi-card:hover { box-shadow: 0 10px 30px rgba(15,23,42,0.06); transform: translateY(-1px); }
            .section-card {
                background: #fff;
                border: 1px solid rgba(15,23,42,0.06);
                border-radius: 1.5rem;
                padding: 20px;
                box-shadow: 0 6px 20px rgba(15,23,42,0.04);
            }
            .section-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                margin-bottom: 12px;
            }
            .badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 4px 10px;
                border-radius: 999px;
                font-size: 10px;
                font-weight: 900;
                letter-spacing: 0.15em;
                text-transform: uppercase;
                border: 1px solid transparent;
            }
            .mini-table { width: 100%; border-collapse: collapse; font-size: 12px; }
            .mini-table th { text-align: left; padding: 8px; font-size: 10px; font-weight: 900; color: #64748b; text-transform: uppercase; letter-spacing: 0.15em; border-bottom: 1px solid #e5e7eb; }
            .mini-table td { padding: 8px; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: 700; }
            .mini-table tr:hover td { background: #f8fafc; }
            .progress-track { height: 8px; border-radius: 999px; background: #e5e7eb; overflow: hidden; }
            .progress-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #00ADC5, #06b6d4); }
            .trend-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 10px 12px;
                border-radius: 1rem;
                border: 1px solid #f1f5f9;
                background: #fafafa;
                transition: all .2s ease;
            }
            .trend-row:hover { background: #f0fbfd; border-color: #cffafe; }
            .chart-wrap { position: relative; width: 100%; }
            .chart-wrap canvas { width: 100% !important; max-height: 280px; }
        </style>

        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Control Center</h2>
                <p class="text-xs text-slate-500 font-semibold">System performance, user activity, and operational overview.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-full border border-emerald-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-widest">System Healthy</span>
                </div>
                <div class="text-right hidden sm:block">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Synced</p>
                    <p class="text-xs font-bold text-slate-700">{{ now()->format('M d, Y • H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- KPI Row -->
        <div class="dash-grid" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
            <div class="kpi-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Users</p>
                        <p class="text-xl font-black text-slate-900 tracking-tighter">{{ $totalUsers }}</p>
                        <p class="text-[10px] font-bold text-slate-500 mt-1">{{ $activeUsers }} active</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center border border-cyan-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sites</p>
                        <p class="text-xl font-black text-slate-900 tracking-tighter">{{ $totalSites }}</p>
                        <p class="text-[10px] font-bold text-slate-500 mt-1">{{ $activeSites }} active</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Requirements</p>
                        <p class="text-xl font-black text-slate-900 tracking-tighter">{{ $totalRequirements }}</p>
                        <p class="text-[10px] font-bold text-slate-500 mt-1">{{ number_format($totalRequestedLength, 1) }} m</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    </div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Fabrications</p>
                        <p class="text-xl font-black text-slate-900 tracking-tighter">{{ $totalFabrications }}</p>
                        <p class="text-[10px] font-bold text-slate-500 mt-1">{{ number_format($totalFabricatedLength, 1) }} m</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><line x1="20" y1="4" x2="8.12" y2="15.88"/><line x1="14.47" y1="14.48" x2="20" y2="20"/><line x1="8.12" y1="8.12" x2="12" y2="12"/></svg>
                    </div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Off-Cuts</p>
                        <p class="text-xl font-black text-slate-900 tracking-tighter">{{ $totalOffcuts }}</p>
                        <p class="text-[10px] font-bold text-slate-500 mt-1">{{ $availableOffcuts }} available</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center border border-violet-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                    </div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Recovery</p>
                        <p class="text-xl font-black text-slate-900 tracking-tighter">{{ number_format($steelSaved, 1) }} <span class="text-[10px] font-black text-slate-400 uppercase">m</span></p>
                        <p class="text-[10px] font-bold text-emerald-600 mt-1">{{ $totalOffcuts > 0 ? round(($usedOffcuts / $totalOffcuts) * 100, 1) : 0 }}% reused</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 19H4.815a1.83 1.83 0 0 1-1.57-.881 1.785 1.785 0 0 1-.004-1.784L7.196 9.5"/><path d="M11 19h6.314a1.83 1.83 0 0 0 1.57-.88 1.785 1.785 0 0 0 0-1.784L16.126 4.688"/><path d="M14.5 5.5 18 9l-6.5 6.5-3-3L5.5 9.5"/></svg>
                    </div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Scrap</p>
                        <p class="text-xl font-black text-slate-900 tracking-tighter">{{ number_format($totalScrap, 1) }} <span class="text-[10px] font-black text-slate-400 uppercase">m</span></p>
                        <p class="text-[10px] font-bold text-rose-600 mt-1">{{ $totalFabricatedLength > 0 ? round(($totalScrap / ($totalFabricatedLength + $totalScrap)) * 100, 1) : 0 }}% wastage</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts + Activity -->
        <div class="dash-grid" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">
            <div class="section-card">
                <div class="section-header">
                    <div>
                        <span class="badge" style="background:rgba(6,182,212,0.08); color:#0891b2; border-color:rgba(6,182,212,0.15);">Timeline Pulse</span>
                        <h3 class="text-base font-black text-slate-900 tracking-tight mt-2">Fabrication Trend</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Output volume and mass over the last 6 months.</p>
                    </div>
                </div>
                <div class="chart-wrap">
                    <canvas id="fabricationChart"></canvas>
                </div>
            </div>

            <div class="section-card">
                <div class="section-header">
                    <div>
                        <span class="badge" style="background:rgba(99,102,241,0.08); color:#4f46e5; border-color:rgba(99,102,241,0.15);">Load Distribution</span>
                        <h3 class="text-base font-black text-slate-900 tracking-tight mt-2">By Steel Grade</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Requested length by material grade.</p>
                    </div>
                </div>
                <div class="chart-wrap">
                    <canvas id="gradeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Users + Recent Fabrications -->
        <div class="dash-grid" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">
            <div class="section-card">
                <div class="section-header">
                    <div>
                        <span class="badge" style="background:rgba(245,158,11,0.08); color:#b45309; border-color:rgba(245,158,11,0.15);">Operators</span>
                        <h3 class="text-base font-black text-slate-900 tracking-tight mt-2">Top Fabricators</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Users with highest fabrication activity.</p>
                    </div>
                </div>
                <div class="overflow-x-auto shadow-lg hover:shadow-xl transition-all">
                    <table class="mini-table">
                        <thead>
                            <tr class="bg-[#00adc5] text-white">
                                <th class="text-white">User</th>
                                <th class="text-center text-white">Cuts</th>
                                <th class="text-right text-white">Length</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topUsers as $u)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-slate-900 text-white flex items-center justify-center text-[10px] font-black">{{ substr($u['name'], 0, 1) }}</div>
                                            <span class="text-xs font-black text-slate-900">{{ $u['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center text-xs font-bold text-slate-600">{{ $u['cut_count'] }}</td>
                                    <td class="text-right text-xs font-black text-slate-900">{{ number_format($u['total_length'], 1) }} m</td>
                                </tr>
                            @endforeach
                            @if($topUsers->isEmpty())
                                <tr><td colspan="3" class="text-center text-xs font-bold text-slate-400 py-4">No data yet</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="section-card">
                <div class="section-header">
                    <div>
                        <span class="badge" style="background:rgba(16,185,129,0.08); color:#059669; border-color:rgba(16,185,129,0.15);">Live Feed</span>
                        <h3 class="text-base font-black text-slate-900 tracking-tight mt-2">Recent Fabrications</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Latest cutting log activity across sites.</p>
                    </div>
                    <a href="{{ route('admin.rebar.cutting-logs.index') }}" class="text-[10px] font-black text-cyan-600 hover:text-cyan-700 uppercase tracking-widest">View All</a>
                </div>
                <div class="space-y-2">
                    @forelse($recentFabrications as $log)
                        <div class="trend-row">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-8 h-8 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center border border-cyan-100 shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><line x1="20" y1="4" x2="8.12" y2="15.88"/><line x1="14.47" y1="14.48" x2="20" y2="20"/><line x1="8.12" y1="8.12" x2="12" y2="12"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-black text-slate-800 truncate">Ø{{ $log->bar_diameter }}mm • {{ $log->requirement?->structural_element ?? 'Ad-hoc' }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $log->site?->site_code ?? 'N/A' }} • {{ $log->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="text-xs font-black text-slate-900">{{ number_format($log->cut_length, 2) }}m</span>
                                <span class="text-[9px] font-black text-slate-400 uppercase block tracking-wider">Cut</span>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-xs font-bold text-slate-400 uppercase tracking-widest">No recent activity</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Diameter + Quick Actions -->
        <div class="dash-grid" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">
            <div class="section-card">
                <div class="section-header">
                    <div>
                        <span class="badge" style="background:rgba(244,63,94,0.08); color:#be123c; border-color:rgba(244,63,94,0.15);">Calibration</span>
                        <h3 class="text-base font-black text-slate-900 tracking-tight mt-2">Bar Diameter Usage</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Fabrication count and length by diameter.</p>
                    </div>
                </div>
                <div class="overflow-x-auto shadow-lg hover:shadow-xl transition-all">
                    <table class="mini-table">
                        <thead>
                            <tr class="bg-[#00adc5] text-white">
                                <th class="text-white">Diameter</th>
                                <th class="text-center text-white">Cuts</th>
                                <th class="text-right text-white">Length</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($diameterDistribution as $d)
                                <tr>
                                    <td class="text-xs font-black text-slate-900">Ø{{ $d->bar_diameter }}mm</td>
                                    <td class="text-center text-xs font-bold text-slate-600">{{ $d->count }}</td>
                                    <td class="text-right text-xs font-black text-slate-900">{{ number_format($d->total_length, 1) }} m</td>
                                </tr>
                            @endforeach
                            @if($diameterDistribution->isEmpty())
                                <tr><td colspan="3" class="text-center text-xs font-bold text-slate-400 py-4">No data yet</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="section-card">
                <div class="section-header">
                    <div>
                        <span class="badge" style="background:rgba(16,185,129,0.08); color:#059669; border-color:rgba(16,185,129,0.15);">Quick Access</span>
                        <h3 class="text-base font-black text-slate-900 tracking-tight mt-2">Management Shortcuts</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Common actions and navigation.</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.rebar.sites.index') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-800 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Sites
                    </a>
                    <a href="{{ route('admin.rebar.requirements.create') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-white border border-slate-200 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest hover:border-cyan-300 hover:text-cyan-700 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        New Req
                    </a>
                    <a href="{{ route('admin.rebar.cutting-logs.create') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-white border border-slate-200 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest hover:border-cyan-300 hover:text-cyan-700 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><line x1="20" y1="4" x2="8.12" y2="15.88"/><line x1="14.47" y1="14.48" x2="20" y2="20"/><line x1="8.12" y1="8.12" x2="12" y2="12"/></svg>
                        Log Cut
                    </a>
                    <a href="{{ route('admin.rebar.offcuts.index') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-white border border-slate-200 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest hover:border-cyan-300 hover:text-cyan-700 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                        Off-Cuts
                    </a>
                    <a href="{{ route('admin.rebar.approvals.index') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-white border border-slate-200 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest hover:border-cyan-300 hover:text-cyan-700 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        Approvals
                    </a>
                    <a href="{{ route('admin.rebar.reports') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-white border border-slate-200 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest hover:border-cyan-300 hover:text-cyan-700 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            Chart.defaults.font.family = "'Inter','sans-serif'";
            Chart.defaults.color = '#94a3b8';

            const monthlyData = @json($monthlyFabrication->mapWithKeys(fn($item) => [$item->month => ['length' => $item->total_length, 'weight' => $item->total_weight]]));
            const monthLabels = Object.keys(monthlyData);
            const monthLengths = monthLabels.map(m => monthlyData[m].length ?? 0);
            const monthWeights = monthLabels.map(m => monthlyData[m].weight ?? 0);

            new Chart(document.getElementById('fabricationChart'), {
                type: 'bar',
                data: {
                    labels: monthLabels,
                    datasets: [
                        { label: 'Length (m)', data: monthLengths, backgroundColor: 'rgba(6,182,212,0.8)', borderRadius: 8, barPercentage: 0.6, yAxisID: 'y' },
                        { label: 'Weight (kg)', data: monthWeights, type: 'line', borderColor: '#0f172a', borderWidth: 2, pointBackgroundColor: '#ffffff', pointBorderColor: '#0f172a', pointBorderWidth: 2, pointRadius: 4, tension: 0.4, yAxisID: 'y1' }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: { legend: { display: true, position: 'bottom', labels: { usePointStyle: true, pointStyle: 'circle', padding: 16, font: { size: 10, weight: '900' } } } },
                    scales: {
                        x: { grid: { display: false }, border: { display: false } },
                        y: { position: 'left', grid: { borderDash: [4,4], color: '#f1f5f9' }, border: { display: false }, title: { display: true, text: 'm', font: { size: 10, weight: '900' } } },
                        y1: { position: 'right', grid: { display: false }, border: { display: false }, title: { display: true, text: 'kg', font: { size: 10, weight: '900' } } }
                    }
                }
            });

            const gradeStats = @json($gradeDistribution);
            new Chart(document.getElementById('gradeChart'), {
                type: 'doughnut',
                data: {
                    labels: gradeStats.map(s => 'Grade ' + s.steel_grade),
                    datasets: [{
                        data: gradeStats.map(s => s.total_length),
                        backgroundColor: ['#0f172a', '#334155', '#64748b', '#94a3b8'],
                        borderWidth: 0,
                        borderRadius: 6,
                        spacing: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, pointStyle: 'circle', padding: 12, font: { size: 10, weight: '900' } } } }
                }
            });
        </script>
    @endpush
</x-app-layout>
