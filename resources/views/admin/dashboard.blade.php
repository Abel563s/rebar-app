<x-app-layout>
    <div class="py-6 space-y-8 max-w-7xl mx-auto">
        <!-- Premium Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-1">
                <h2 class="text-4xl font-black text-slate-900 tracking-tight font-outfit">Control Center</h2>
                <p class="text-slate-500 font-medium font-inter">System performance and infrastructure overview.</p>
            </div>

            <div
                class="flex items-center gap-4 bg-white p-2 rounded-2xl border border-slate-100 shadow-sm shadow-slate-200/50">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="pulse" class="w-5 h-5 animate-pulse"></i>
                </div>
                <div class="pr-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">System Load
                    </p>
                    <p class="text-xs font-bold text-slate-700 mt-1">Optimal Performance</p>
                </div>
            </div>
        </div>

        <!-- Matrix KPI Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $metrics = [
                    ['label' => 'Strategic Steel Load', 'value' => \App\Models\RebarRequirement::count(), 'desc' => 'Active requirement nodes', 'icon' => 'construction', 'color' => 'cyan'],
                    ['label' => 'Off-cut Reservoir', 'value' => \App\Models\Offcut::where('status', 'Available')->count(), 'desc' => 'Available for deployment', 'icon' => 'database', 'color' => 'emerald'],
                    ['label' => 'Fabrication Logs', 'value' => \App\Models\RebarCuttingLog::count(), 'desc' => 'Verified cut protocols', 'icon' => 'activity', 'color' => 'amber'],
                ];
            @endphp

            @foreach($metrics as $m)
                <div class="premium-card p-8 group cursor-default">
                    <div class="flex items-start justify-between mb-6">
                        <div
                            class="w-14 h-14 rounded-2xl bg-{{ $m['color'] }}-50 text-{{ $m['color'] }}-600 flex items-center justify-center border border-{{ $m['color'] }}-100 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                            <i data-lucide="{{ $m['icon'] }}" class="w-7 h-7"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $m['label'] }}</p>
                            <h3 class="text-4xl font-black text-slate-900 tracking-tighter mt-1">{{ $m['value'] }}</h3>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 pt-4 border-t border-slate-50">
                        <span class="w-2 h-2 rounded-full bg-{{ $m['color'] }}-400 animate-pulse"></span>
                        <p class="text-xs font-bold text-slate-500">{{ $m['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- System Integrity Graph -->
            <div class="lg:col-span-8 premium-card p-10 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-[0.03]">
                    <i data-lucide="activity" class="w-48 h-48 text-slate-900"></i>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-10">
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight font-outfit">Fabrication
                                Volume</h3>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Global steel
                                demand
                                and fabrication baseline</p>
                        </div>
                        <div class="px-4 py-2 bg-slate-50 rounded-xl border border-slate-100 flex items-center gap-2">
                            <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                            <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Live
                                Sync</span>
                        </div>
                    </div>

                    <div class="h-80 w-full">
                        <canvas id="integrityChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Management Fast-Track -->
            <div class="lg:col-span-4 space-y-6">
                <div class="premium-card p-8 bg-slate-900 text-white relative overflow-hidden group border-none">
                    <div class="absolute -top-20 -right-20 w-48 h-48 bg-cyan-500/20 rounded-full blur-3xl"></div>
                    <div class="relative z-10">
                        <h3 class="text-lg font-black tracking-tight mb-2">Requirement Engine</h3>
                        <p class="text-xs font-medium text-slate-400 mb-6">Manage high-precision rebar requirements
                            across active project sites.</p>

                        <a href="{{ route('admin.rebar.requirements.create') }}"
                            class="w-full py-4 bg-white/10 hover:bg-white/20 border border-white/10 rounded-2xl flex items-center justify-center gap-3 transition-all duration-300 group/btn active:scale-95">
                            <span class="text-sm font-black uppercase tracking-widest">New Protocol</span>
                            <i data-lucide="plus-circle"
                                class="w-4 h-4 transition-transform group-hover/btn:scale-110"></i>
                        </a>
                    </div>
                </div>

                <div
                    class="premium-card p-8 bg-gradient-to-br from-[#00ADC5] to-[#007A8A] text-white relative overflow-hidden group border-none">
                    <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <h3 class="text-lg font-black tracking-tight mb-2">Fabrication Pulse</h3>
                        <p class="text-xs font-medium text-cyan-50 mb-6">Monitor fabrication logs, wastage ratios, and
                            reusable off-cut inventory.</p>

                        <a href="{{ route('admin.rebar.cutting-logs.create') }}"
                            class="w-full py-4 bg-black/20 hover:bg-black/30 border border-white/10 rounded-2xl flex items-center justify-center gap-3 transition-all duration-300 group/btn active:scale-95">
                            <span class="text-sm font-black uppercase tracking-widest">Log Cut</span>
                            <i data-lucide="scissors"
                                class="w-4 h-4 transition-transform group-hover/btn:rotate-12"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('integrityChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Interactions',
                        data: [65, 59, 80, 81, 56, 95],
                        borderColor: '#00ADC5',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        backgroundColor: (context) => {
                            const ctx = context.chart.ctx;
                            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                            gradient.addColorStop(0, 'rgba(0, 173, 197, 0.1)');
                            gradient.addColorStop(1, 'rgba(0, 173, 197, 0)');
                            return gradient;
                        },
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#00ADC5',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [4, 4], color: '#f1f5f9' },
                            border: { display: false }
                        },
                        x: {
                            grid: { display: false },
                            border: { display: false }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>