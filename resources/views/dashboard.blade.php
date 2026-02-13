<x-app-layout>
    <div class="py-6 space-y-6">
        <!-- Dashboard Header -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div
                class="px-8 py-10 flex flex-col md:flex-row md:items-center justify-between gap-8 bg-gradient-to-br from-white to-slate-50/50">
                <div class="space-y-2">
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                        Welcome, <span class="text-[#00ADC5]">{{ Auth::user()->name }}</span>
                    </h2>
                    <p class="text-slate-500 font-medium">
                        You are logged in as {{ ucfirst(Auth::user()->role) }}. This is your starter dashboard.
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <div
                        class="bg-white border border-slate-200 rounded-2xl px-5 py-3 shadow-sm flex flex-col items-end">
                        <span
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">System
                            Time</span>
                        <span class="text-lg font-bold text-slate-700">{{ now()->format('h:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Example Widget 1 -->
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-black text-slate-800">Module Placeholder</h3>
                </div>
                <p class="text-sm text-slate-500 leading-relaxed">
                    This area is ready for your custom application widgets. Extend this layout to build your specific
                    features.
                </p>
            </div>

            <!-- Example Widget 2 -->
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <i data-lucide="activity" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-black text-slate-800">System Activity</h3>
                </div>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Track user engagement or system events here. Use charts or lists to visualize data.
                </p>
            </div>

            <!-- User Info -->
            <div class="bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden shadow-xl">
                <div class="relative z-10 space-y-4">
                    <h3 class="font-black text-white/50 uppercase tracking-widest text-xs">Profile</h3>
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center font-black text-xl">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-lg">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-white/50">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
                <!-- Decor -->
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-[#00ADC5]/20 rounded-full blur-3xl"></div>
            </div>
        </div>
    </div>
</x-app-layout>