<x-app-layout>
    <div class="py-6 space-y-6 max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                    New Project Site
                </h2>
                <p class="text-sm text-slate-500 font-medium">Define a new physical site for rebar management</p>
            </div>
            <a href="{{ route('admin.rebar.sites.index') }}"
                class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to List
            </a>
        </div>

        <div
            class="bg-white rounded-[2rem] shadow-xl shadow-slate-100 border border-slate-200/60 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-cyan-400 to-blue-500"></div>

            <form action="{{ route('admin.rebar.sites.store') }}" method="POST" class="p-8 md:p-10 space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Project Name -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Project
                            Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="project_name" value="{{ old('project_name') }}" required
                            placeholder="e.g. Grand Residence Towers"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700">
                        @error('project_name') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Site Name -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Site Name
                            <span class="text-rose-500">*</span></label>
                        <input type="text" name="site_name" value="{{ old('site_name') }}" required
                            placeholder="e.g. Phase 1 - North Wing"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700">
                        @error('site_name') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Location -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Location
                            <span class="text-rose-500">*</span></label>
                        <input type="text" name="location" value="{{ old('location') }}" required
                            placeholder="e.g. Downtown, Dubai"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700">
                        @error('location') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Sector -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Sector
                            (Optional)</label>
                        <input type="text" name="sector" value="{{ old('sector') }}"
                            placeholder="e.g. Residential / Commercial"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700">
                        @error('sector') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Status
                            <span class="text-rose-500">*</span></label>
                        <select name="status" required
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700">
                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed
                            </option>
                        </select>
                        @error('status') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Notes -->
                    <div class="col-span-2">
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Notes</label>
                        <textarea name="notes" rows="4" placeholder="Additional details about the site..."
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700">{{ old('notes') }}</textarea>
                        @error('notes') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end pt-8 border-t border-slate-100">
                    <button type="submit"
                        class="px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-cyan-500/20 hover:scale-[1.02] hover:shadow-cyan-500/30 transition-all active:scale-95">
                        Create Project Site
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>