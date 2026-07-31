<x-app-layout>
    <div class="py-6 space-y-6 min-w-0">
        <style>
            .report-grid {
                display: grid;
                gap: 16px;
            }
            .chart-wrap {
                position: relative;
                width: 100%;
            }
            .chart-wrap canvas {
                width: 100% !important;
                max-height: 280px;
            }
            .kpi-card {
                background: #fff;
                border: 1px solid rgba(15,23,42,0.06);
                border-radius: 1.25rem;
                padding: 16px;
                box-shadow: 0 4px 12px rgba(15,23,42,0.03);
                transition: all .2s ease;
            }
            .kpi-card:hover {
                box-shadow: 0 10px 30px rgba(15,23,42,0.06);
                transform: translateY(-1px);
            }
            .section-card {
                background: #fff;
                border: 1px solid rgba(15,23,42,0.06);
                border-radius: 1.5rem;
                padding: 20px;
                box-shadow: 0 6px 20px rgba(15,23,42,0.04);
            }
            .section-card .section-header {
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
            table.report-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 12px;
            }
            table.report-table th {
                text-align: left;
                padding: 10px 8px;
                font-size: 10px;
                font-weight: 900;
                color: #fff;
                text-transform: uppercase;
                letter-spacing: 0.15em;
                border-bottom: 1px solid #e5e7eb;
            }
            table.report-table td {
                padding: 10px 8px;
                border-bottom: 1px solid #f1f5f9;
                color: #0f172a;
                font-weight: 700;
            }
            table.report-table tr:hover td {
                background: #f8fafc;
            }
            .progress-track {
                height: 8px;
                border-radius: 999px;
                background: #e5e7eb;
                overflow: hidden;
            }
            .progress-fill {
                height: 100%;
                border-radius: 999px;
                background: linear-gradient(90deg, #00ADC5, #06b6d4);
            }
            .trend-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 12px;
                border-radius: 1rem;
                border: 1px solid #f1f5f9;
                background: #fafafa;
                transition: all .2s ease;
            }
            .trend-row:hover {
                background: #f0fbfd;
                border-color: #cffafe;
            }
            .mini-bar {
                height: 10px;
                border-radius: 999px;
                background: #e5e7eb;
                overflow: hidden;
            }
            .mini-bar > i {
                display: block;
                height: 100%;
                border-radius: 999px;
            }
        </style>

        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Operational Intelligence</h2>
                <p class="text-xs text-slate-500 font-semibold">Fabrication, steel grade analytics, inventory, and resource recovery.</p>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="window.print()" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 14h12v8H6z"/></svg>
                    Export PDF
                </button>
                <div class="text-right hidden sm:block">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Report Cycle</p>
                    <p class="text-xs font-bold text-slate-700">{{ now()->format('F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- KPI Row -->
        <div class="report-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
            <div class="kpi-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Global Load</p>
                        <p class="text-xl font-black text-slate-900 tracking-tighter">{{ number_format($global['total_req_length'], 1) }} <span class="text-[10px] font-black text-slate-400 uppercase">m</span></p>
                        <p class="text-[10px] font-bold text-slate-500 mt-1">{{ number_format($global['total_req_weight'], 1) }} kg</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center border border-cyan-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15 15 0 0 1 0 20 15 15 0 0 1 0-20"/></svg>
                    </div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Fabrication</p>
                        <p class="text-xl font-black text-slate-900 tracking-tighter">{{ number_format($global['total_fab_length'], 1) }} <span class="text-[10px] font-black text-slate-400 uppercase">m</span></p>
                        <p class="text-[10px] font-bold text-slate-500 mt-1">{{ number_format($global['total_fab_weight'], 1) }} kg</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3v18"/><path d="M6 9h12"/><path d="M6 15h12"/><path d="M18 9v12"/></svg>
                    </div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Recovery & Re-use</p>
                        <p class="text-xl font-black text-slate-900 tracking-tighter">{{ number_format($global['total_reused_length'], 1) }} <span class="text-[10px] font-black text-slate-400 uppercase">m</span></p>
                        <p class="text-[10px] font-bold text-emerald-600 mt-1">{{ $global['reuse_rate_pct'] }}% of cuts</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 19H4.815a1.83 1.83 0 0 1-1.57-.881 1.785 1.785 0 0 1-.004-1.784L7.196 9.5"/><path d="M11 19h6.314a1.83 1.83 0 0 0 1.57-.88 1.785 1.785 0 0 0 0-1.784L16.126 4.688"/><path d="M14.5 5.5 18 9l-6.5 6.5-3-3L5.5 9.5"/><path d="M14.5 5.5 18 9"/><path d="M3 21l6.5-6.5"/><path d="M3 21l6.5-6.5"/></svg>
                    </div>
                </div>
            </div>

            <div class="kpi-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">System Scrap</p>
                        <p class="text-xl font-black text-slate-900 tracking-tighter">{{ number_format($global['total_scrap_length'], 1) }} <span class="text-[10px] font-black text-slate-400 uppercase">m</span></p>
                        <p class="text-[10px] font-bold text-rose-600 mt-1">{{ $global['wastage_pct'] }}% wastage</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Offcut Reserve + Fabrication Trend -->
        <div class="report-grid" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">
            <div class="section-card">
                <div class="section-header">
                    <div>
                        <span class="badge" style="background:rgba(0,81,95,0.08); color:#00515f; border-color:rgba(0,81,95,0.15);">Active Off-Cut Reserve</span>
                        <h3 class="text-base font-black text-slate-900 tracking-tight mt-2">Recycled Material Asset Registry</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Available reusable metal resource assets.</p>
                    </div>
                </div>
                <div class="flex items-center gap-6 rounded-xl p-4 border border-slate-100 bg-slate-50/60">
                    <div class="text-center flex-1">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Available Count</p>
                        <p class="text-2xl font-black text-slate-900">{{ number_format($global['total_avail_count']) }} <span class="text-xs font-bold text-slate-500">pcs</span></p>
                    </div>
                    <div class="w-px h-10 bg-slate-200"></div>
                    <div class="text-center flex-1">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Total Length</p>
                        <p class="text-2xl font-black text-slate-900">{{ number_format($global['total_avail_length'], 1) }} <span class="text-xs font-bold text-slate-500">m</span></p>
                    </div>
                    <div class="w-px h-10 bg-slate-200"></div>
                    <div class="text-center flex-1">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Asset Weight</p>
                        <p class="text-2xl font-black text-slate-900">{{ number_format($global['total_avail_weight'], 1) }} <span class="text-xs font-bold text-slate-500">kg</span></p>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <div class="section-header">
                    <div>
                        <span class="badge" style="background:rgba(6,182,212,0.08); color:#0891b2; border-color:rgba(6,182,212,0.15);">Timeline Pulse</span>
                        <h3 class="text-base font-black text-slate-900 tracking-tight mt-2">Monthly Output Flow</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Fabricated length and mass flow over time.</p>
                    </div>
                </div>
                <div class="chart-wrap">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Site Performance + Steel Grade -->
        <div class="report-grid" style="grid-template-columns: repeat(auto-fit, minmax(420px, 1fr));">
            <div class="section-card">
                <div class="section-header">
                    <div>
                        <span class="badge" style="background:rgba(16,185,129,0.08); color:#059669; border-color:rgba(16,185,129,0.15);">Live Syncing</span>
                        <h3 class="text-base font-black text-slate-900 tracking-tight mt-2">Multi-Site Hub Performance</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Load, fabrication, recovery, and inventory by site.</p>
                    </div>
                </div>
                <div class="overflow-x-auto shadow-lg hover:shadow-xl transition-all">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th class="text-white">Site</th>
                                <th class="text-center text-white">Req</th>
                                <th class="text-center text-white">Fabricated</th>
                                <th class="text-center text-white">Scrap</th>
                                <th class="text-right text-white">Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siteStats as $site)
                            <tr class="bg-[#00adc5] text-white">
                                    <td>
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black text-cyan-600 uppercase tracking-widest">{{ $site['code'] }}</span>
                                            <a href="{{ route('admin.rebar.sites.show', $site['id']) }}" class="text-xs font-black text-slate-900 hover:text-cyan-600 transition-colors">{{ $site['name'] }}</a>
                                        </div>
                                    </td>
                                    <td class="text-center text-xs font-bold text-slate-600">{{ $site['requirements_count'] }}</td>
                                    <td class="text-center">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-black text-emerald-600">{{ number_format($site['total_fabricated_length'], 1) }} m</span>
                                            <span class="text-[9px] font-bold text-slate-400">{{ number_format($site['total_fabricated_weight'], 1) }} kg</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-rose-500">{{ number_format($site['scrap_length'], 1) }} m</span>
                                            <span class="text-[9px] font-bold text-slate-400">{{ number_format($site['scrap_weight'], 1) }} kg</span>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <div class="w-24 space-y-1">
                                                <div class="flex justify-between text-[9px] font-black uppercase">
                                                    <span class="text-slate-400">Progress</span>
                                                    <span class="text-cyan-600">{{ $site['progress'] }}%</span>
                                                </div>
                                                <div class="progress-track">
                                                    <div class="progress-fill" style="width: {{ $site['progress'] }}%"></div>
                                                </div>
                                            </div>
                                            <a href="{{ route('admin.rebar.sites.show', $site['id']) }}" class="inline-flex items-center justify-center w-7 h-7 bg-white border border-slate-200 rounded-lg text-slate-500 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="section-card">
                <div class="section-header">
                    <div>
                        <span class="badge" style="background:rgba(99,102,241,0.08); color:#4f46e5; border-color:rgba(99,102,241,0.15);">Strength Distribution</span>
                        <h3 class="text-base font-black text-slate-900 tracking-tight mt-2">Fabrication by Steel Grade</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Production loads segmented by material grade.</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3 mb-4">
                    @foreach($gradeStats as $stat)
                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl border border-slate-100 bg-slate-50">
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Grade {{ $stat->steel_grade }}</span>
                            <span class="text-xs font-black text-slate-900">{{ number_format($stat->req_length, 1) }}m</span>
                            <span class="text-[10px] font-bold text-slate-500">{{ number_format($stat->progress, 1) }}%</span>
                        </div>
                    @endforeach
                </div>
                <div class="chart-wrap">
                    <canvas id="gradeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Diameter Distribution + Recent Highlights -->
        <div class="report-grid" style="grid-template-columns: repeat(auto-fit, minmax(420px, 1fr));">
            <div class="section-card">
                <div class="section-header">
                    <div>
                        <span class="badge" style="background:rgba(245,158,11,0.08); color:#b45309; border-color:rgba(245,158,11,0.15);">Load by Diameter</span>
                        <h3 class="text-base font-black text-slate-900 tracking-tight mt-2">Bar Diameter Calibration</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Calibration volumes, weight, and reuse metrics.</p>
                    </div>
                </div>
                <div class="chart-wrap">
                    <canvas id="diameterChart"></canvas>
                </div>
            </div>

            <div class="section-card">
                <div class="section-header">
                    <div>
                        <span class="badge" style="background:rgba(244,63,94,0.08); color:#be123c; border-color:rgba(244,63,94,0.15);">Site Activities</span>
                        <h3 class="text-base font-black text-slate-900 tracking-tight mt-2">Operational Stream</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Latest 5 fabrications completed.</p>
                    </div>
                </div>
                <div class="space-y-3">
                    @forelse($recentLogs as $logIdx => $log)
                        <div class="trend-row">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center border @if($log->reused_offcut_id) bg-emerald-50 text-emerald-600 border-emerald-100 @else bg-cyan-50 text-cyan-600 border-cyan-100 @endif">
                                    @if($log->reused_offcut_id)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 19H4.815a1.83 1.83 0 0 1-1.57-.881 1.785 1.785 0 0 1-.004-1.784L7.196 9.5"/><path d="M11 19h6.314a1.83 1.83 0 0 0 1.57-.88 1.785 1.785 0 0 0 0-1.784L16.126 4.688"/><path d="M14.5 5.5 18 9l-6.5 6.5-3-3L5.5 9.5"/></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><line x1="20" y1="4" x2="8.12" y2="15.88"/><line x1="14.47" y1="14.48" x2="20" y2="20"/><line x1="8.12" y1="8.12" x2="12" y2="12"/></svg>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-black text-slate-800 truncate">Cut {{ $log->quantity_cut }}x Ø{{ $log->bar_diameter }}mm @if($log->reused_offcut_id) from off-cut @else from standard @endif</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">Site: {{ $log->site?->site_code ?? 'N/A' }} • {{ $log->requirement?->structural_element ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-black text-slate-900">{{ number_format($log->cut_length, 2) }}m</span>
                                <span class="text-[9px] font-black text-slate-400 uppercase block tracking-wider">Length</span>
                            </div>
                        </div>
                    @empty
                        <div class="py-10 text-center text-slate-400 text-xs font-bold uppercase tracking-widest">No recent activity.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            Chart.defaults.font.family = "'Inter','sans-serif'";
            Chart.defaults.color = '#94a3b8';

            const monthlyData = @json($monthlyTrend);
            const monthLabels = Object.keys(monthlyData);
            const monthLengths = Object.values(monthlyData);
            const monthWeights = monthLabels.map(m => monthlyData[m].total_weight ?? 0);

            new Chart(document.getElementById('monthlyChart'), {
                type: 'bar',
                data: {
                    labels: monthLabels,
                    datasets: [
                        {
                            label: 'Length (m)',
                            data: monthLengths,
                            backgroundColor: 'rgba(6,182,212,0.8)',
                            borderRadius: 8,
                            barPercentage: 0.6,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Weight (kg)',
                            data: monthWeights,
                            type: 'line',
                            borderColor: '#0f172a',
                            borderWidth: 2,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#0f172a',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            tension: 0.4,
                            yAxisID: 'y1'
                        }
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

            const gradeStats = @json($gradeStats);
            new Chart(document.getElementById('gradeChart'), {
                type: 'doughnut',
                data: {
                    labels: gradeStats.map(s => 'Grade ' + s.steel_grade),
                    datasets: [{
                        data: gradeStats.map(s => s.req_length),
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
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, pointStyle: 'circle', padding: 12, font: { size: 10, weight: '900' } } }
                    }
                }
            });

            const diameterStats = @json($diameterStats);
            const diaLabels = diameterStats.map(s => 'Ø' + s.bar_diameter + 'mm');
            const diaReq = diameterStats.map(s => s.req_length);
            const diaFab = diameterStats.map(s => s.fab_length);
            const diaReuse = diameterStats.map(s => s.reused_length);

            new Chart(document.getElementById('diameterChart'), {
                type: 'bar',
                data: {
                    labels: diaLabels,
                    datasets: [
                        { label: 'Requested', data: diaReq, backgroundColor: 'rgba(15,23,42,0.8)', borderRadius: 6, barPercentage: 0.5 },
                        { label: 'Fabricated', data: diaFab, backgroundColor: 'rgba(6,182,212,0.8)', borderRadius: 6, barPercentage: 0.5 },
                        { label: 'Reused', data: diaReuse, backgroundColor: 'rgba(16,185,129,0.8)', borderRadius: 6, barPercentage: 0.5 }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, pointStyle: 'circle', padding: 12, font: { size: 10, weight: '900' } } } },
                    scales: {
                        x: { grid: { display: false }, border: { display: false } },
                        y: { grid: { borderDash: [4,4], color: '#f1f5f9' }, border: { display: false } }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
