<x-app-layout>
    <div class="py-6 space-y-4 min-w-0 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex-1">
                <div class="flex items-center gap-4 mb-2">
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">
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
            @if(auth()->user()->isAdmin() || auth()->user()->isSiteEngineer())
            <a href="{{ route('admin.rebar.sites.create') }}"
                class="flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow hover:scale-[1.02] transition-all active:scale-95">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Add New Site
            </a>
            @endif
        </div>

        <!-- Sites Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/10" style="background: linear-gradient(180deg, #00ADC5 0%, #000000 100%);">
                            <th class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest text-center">#</th>
                            <th class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest">Site Code</th>
                            <th class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest">Site Name</th>
                            <th class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest">Project</th>
                            <th class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest">Location</th>
                            <th class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest">Sector</th>
                            <th class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest text-center">Grade</th>
                            <th class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest text-center">Status</th>
                            <th class="px-4 py-2.5 text-[9px] font-black text-white uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($sites as $site)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-4 py-3 text-center text-[10px] font-black text-slate-400">{{ ($sites->currentPage() - 1) * $sites->perPage() + $loop->iteration }}</td>
                                <td class="px-4 py-3">
                                    <span class="text-xs font-black text-cyan-600">{{ $site->site_code }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-black text-slate-900 text-sm">{{ $site->site_name }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-xs font-medium text-slate-600">{{ $site->project_name }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-1.5 text-slate-500">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span class="text-xs font-medium">{{ $site->location }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-xs font-medium text-slate-600">{{ $site->sector ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2.5 py-1 bg-slate-100 rounded-lg font-black text-[11px] text-slate-600">
                                        Grade {{ $site->steel_grade }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2.5 py-1 rounded-full font-black text-[10px] uppercase tracking-wider {{ $site->status === 'Active' ? 'bg-emerald-50 text-emerald-600' : ($site->status === 'Terminated' ? 'bg-rose-50 text-rose-600' : 'bg-slate-100 text-slate-500') }}">
                                        {{ $site->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2 flex-wrap">
                                        <a href="{{ route('admin.rebar.sites.show', $site) }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-cyan-50 text-cyan-600 rounded-full transition-all font-bold text-[10px] uppercase tracking-wider hover:bg-cyan-100">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                            Manage
                                        </a>
                                        @if(auth()->user()->isAdmin() || (auth()->user()->isSiteEngineer() && $site->user_id === auth()->id()))
                                        <a href="{{ route('admin.rebar.sites.edit', $site) }}"
                                            class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                            title="Edit Site">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-8 text-center text-slate-400 font-medium text-sm">
                                    No project sites found. Create your first site to get started.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($sites->hasPages())
                <div class="px-4 py-3 border-t border-slate-50 bg-slate-50/30 rounded-b-2xl">
                    {{ $sites->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
