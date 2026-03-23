<x-app-layout>
    <div class="py-6 space-y-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex-1">
                <div class="flex items-center gap-4 mb-2">
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                        Project Sites
                    </h2>
                    <div class="flex items-center gap-2">
                        <span
                            class="px-4 py-1.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-full font-black text-sm shadow-lg shadow-cyan-500/20">
                            {{ $sites->total() }} Total
                        </span>
                        <span
                            class="px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-full font-black text-sm border border-emerald-100">
                            {{ \App\Models\ProjectSite::where('status', 'Active')->count() }} Active
                        </span>
                    </div>
                </div>
                <p class="text-sm text-slate-500 font-medium">Manage and track rebar fabrication across physical
                    construction sites</p>
            </div>
            <a href="{{ route('admin.rebar.sites.create') }}"
                class="flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-cyan-500/20 hover:scale-[1.02] hover:shadow-cyan-500/30 transition-all active:scale-95">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Add New Site
            </a>
        </div>

        <!-- Sites Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($sites as $site)
                <div
                    class="bg-white rounded-[2rem] shadow-sm border border-slate-200/60 overflow-hidden group hover:shadow-xl hover:shadow-slate-100 transition-all duration-300">
                    <div class="p-8 space-y-6">
                        <!-- Site Info -->
                        <div class="flex items-start justify-between">
                            <div class="space-y-1">
                                <span
                                    class="text-[10px] font-black text-cyan-500 uppercase tracking-[0.2em]">{{ $site->site_code }}</span>
                                <h3
                                    class="text-xl font-black text-slate-900 leading-tight group-hover:text-cyan-600 transition-colors">
                                    {{ $site->site_name }}
                                </h3>
                                <p class="text-sm font-bold text-slate-400">{{ $site->project_name }}</p>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <span
                                    class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-full {{ $site->status === 'Active' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $site->status }}
                                </span>
                                <a href="{{ route('admin.rebar.sites.edit', $site) }}" 
                                   class="p-2 text-slate-400 hover:text-cyan-600 hover:bg-cyan-50 rounded-xl transition-all"
                                   title="Edit Site">
                                    <i data-lucide="settings" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 text-slate-500">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center">
                                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                                </div>
                                <span class="text-sm font-medium">{{ $site->location }}</span>
                            </div>
                            @if($site->sector)
                                <div class="flex items-center gap-3 text-slate-500">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center">
                                        <i data-lucide="building-2" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-sm font-medium">{{ $site->sector }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- CTA -->
                        <div class="pt-6 border-t border-slate-50">
                            <a href="{{ route('admin.rebar.sites.show', $site) }}"
                                class="w-full flex items-center justify-center gap-2 px-6 py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-cyan-600 transition-all group/btn shadow-lg shadow-slate-200">
                                Manage Rebar
                                <i data-lucide="arrow-right"
                                    class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-[2rem] border-2 border-dashed border-slate-200 p-20 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="building-2" class="w-10 h-10 text-slate-300"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-2">No Project Sites Found</h3>
                    <p class="text-slate-400 font-medium mb-8">Start by creating your first construction site to manage
                        rebar requirements.</p>
                    <a href="{{ route('admin.rebar.sites.create') }}"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-slate-900 text-white rounded-2xl font-black text-sm uppercase tracking-widest hover:scale-105 transition-all">
                        Create First Site
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $sites->links() }}
        </div>
    </div>
</x-app-layout>