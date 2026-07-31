<x-app-layout>
    <div class="py-6 space-y-4 min-w-0 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                    Edit Project Site
                </h2>
                <p class="text-sm text-slate-500 font-medium">Update site information for {{ $site->site_code }}</p>
            </div>
            <a href="{{ route('admin.rebar.sites.show', $site) }}"
                class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to Site Hub
            </a>
        </div>

        <div
            class="section-card">
            <form action="{{ route('admin.rebar.sites.update', $site) }}" method="POST" class="p-5 md:p-6 space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Site Code (Read-Only) -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Site
                            Code</label>
                        <input type="text" value="{{ $site->site_code }}" disabled
                            class="w-full bg-slate-100 border-slate-200 rounded-xl py-2 px-3 font-black text-slate-500 cursor-not-allowed text-sm">
                        <p class="text-[10px] text-slate-400 mt-2 italic">Site code cannot be changed</p>
                    </div>

                    <!-- Status -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Status
                            <span class="text-rose-500">*</span></label>
                        <select name="status" required
                            class="w-full bg-slate-50 border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm">
                            <option value="Active" {{ old('status', $site->status) == 'Active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="Completed" {{ old('status', $site->status) == 'Completed' ? 'selected' : '' }}>
                                Completed</option>
                        </select>
                        @error('status') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Steel Grade -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Steel Grade
                            <span class="text-rose-500">*</span></label>
                        <select name="steel_grade" required
                            class="w-full bg-slate-50 border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm">
                            <option value="">-- Select Grade --</option>
                            @foreach([300, 400, 500, 600] as $grade)
                                <option value="{{ $grade }}" {{ old('steel_grade', $site->steel_grade) == $grade ? 'selected' : '' }}>Grade {{ $grade }}</option>
                            @endforeach
                        </select>
                        @error('steel_grade') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Project Name -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Project
                            Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="project_name" value="{{ old('project_name', $site->project_name) }}"
                            required placeholder="e.g. Grand Residence Towers"
                            class="w-full bg-slate-50 border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm">
                        @error('project_name') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Site Name -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Site Name
                            <span class="text-rose-500">*</span></label>
                        <input type="text" name="site_name" value="{{ old('site_name', $site->site_name) }}" required
                            placeholder="e.g. Phase 1 - North Wing"
                            class="w-full bg-slate-50 border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm">
                        @error('site_name') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Location -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Location
                            <span class="text-rose-500">*</span></label>
                        <input type="text" name="location" value="{{ old('location', $site->location) }}" required
                            placeholder="e.g. Downtown, Dubai"
                            class="w-full bg-slate-50 border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm">
                        @error('location') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Sector -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Sector
                            (Optional)</label>
                        <input type="text" name="sector" value="{{ old('sector', $site->sector) }}"
                            placeholder="e.g. Residential / Commercial"
                            class="w-full bg-slate-50 border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm">
                        @error('sector') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Diameter Amount Needed (KG) -->
                    <div class="col-span-2 pt-4">
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-3 flex items-center gap-2">
                            <div class="w-6 h-6 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m-6 4h6m-6 4h4m5-9v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2h5.372a2 2 0 011.612.98l2.628 1.562A2 2 0 0115 6.627V5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-.586 1.414l-2 2.586A2 2 0 0117 10.828V12a2 2 0 01-2 2H7"></path></svg>
                            </div>
                            Steel Requirement (Qty Needed in PCS)
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                            @foreach(['08', '10', '12', '14', '16', '18', '20', '24', '28', '32'] as $d)
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Ø{{ $d }}mm</label>
                                    <div class="relative">
                                        <input type="number" name="amount_needed_{{ $d }}" 
                                            value="{{ old('amount_needed_'.$d, $site->{'amount_needed_'.$d} ?? 0) }}" 
                                            class="w-full bg-slate-50 border-slate-200 rounded-lg py-1.5 px-2 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-bold text-slate-700 text-sm">
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[9px] font-black text-slate-300">PCS</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="col-span-2">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Site Manager (Assign)</label>
                        <select name="manager_id" class="w-full bg-slate-50 border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm mb-3">
                            <option value="">-- No Manager --</option>
                            @foreach(\App\Models\User::where('role','manager')->get() as $m)
                                <option value="{{ $m->id }}" {{ old('manager_id', $site->manager_id) == $m->id ? 'selected' : '' }}>{{ $m->name }} ({{ $m->email }})</option>
                            @endforeach
                        </select>
                        
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Notes</label>
                        <textarea name="notes" rows="3" placeholder="Additional details about the site..."
                            class="w-full bg-slate-50 border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm">{{ old('notes', $site->notes) }}</textarea>
                        @error('notes') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                    <button type="button" 
                        onclick="if(confirm('Are you sure you want to delete this site? All associated requirements will also be deleted.')) document.getElementById('delete-site-form').submit();"
                        class="px-4 py-2 bg-rose-50 text-rose-600 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-rose-100 transition-all">
                        Delete Site
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow hover:scale-[1.02] transition-all active:scale-95">
                        Update Project Site
                    </button>
                </div>
            </form>

            <form id="delete-site-form" action="{{ route('admin.rebar.sites.destroy', $site) }}" method="POST" class="hidden">
                 @csrf
                 @method('DELETE')
            </form>
        </div>
    </div>
</x-app-layout>