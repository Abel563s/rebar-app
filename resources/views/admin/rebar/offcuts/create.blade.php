<x-app-layout>
    <div class="min-w-0 space-y-4 py-5">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-black text-slate-900 tracking-tight">
                Register Manual Off-cut
            </h2>
            <a href="{{ route('admin.rebar.offcuts.index') }}"
                class="text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">
                &larr; Back to List
            </a>
        </div>

        <div class="section-card">
            <div class="mb-4 p-3 bg-amber-50 rounded-lg border border-amber-100 flex gap-2.5">
                <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                <p class="text-xs text-amber-800">
                    <strong>Note:</strong> Usually off-cuts are automatically generated when recording a <a
                        href="{{ route('admin.rebar.cutting-logs.create') }}"
                        class="underline font-bold hover:text-amber-900">Cutting Log</a>. Only use this form for initial
                    inventory setup or finding untracked pieces.
                </p>
            </div>

            <form action="{{ route('admin.rebar.offcuts.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Bar Diameter -->
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Bar
                            Diameter (mm) <span class="text-rose-500">*</span></label>
                        <select name="bar_diameter" required
                            class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-[#00ADC5] focus:border-[#00ADC5] text-sm">
                            <option value="" disabled selected>Select Diameter</option>
                            @foreach([8, 10, 12, 16, 20, 25, 32] as $d)
                                <option value="{{ $d }}" {{ old('bar_diameter') == $d ? 'selected' : '' }}>{{ $d }}mm</option>
                            @endforeach
                        </select>
                        @error('bar_diameter') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Length -->
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Length (mm)
                            <span class="text-rose-500">*</span></label>
                        <input type="number" name="length" value="{{ old('length') }}" required min="1"
                            class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-[#00ADC5] focus:border-[#00ADC5] text-sm">
                        @error('length') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Quantity
                            <span class="text-rose-500">*</span></label>
                        <input type="number" name="quantity" value="{{ old('quantity', 1) }}" required min="1"
                            class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-[#00ADC5] focus:border-[#00ADC5] text-sm">
                        @error('quantity') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Storage
                            Location</label>
                        <input type="text" name="storage_location" value="{{ old('storage_location') }}"
                            placeholder="e.g. Rack A-3"
                            class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-[#00ADC5] focus:border-[#00ADC5] text-sm">
                        @error('storage_location') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status
                            <span class="text-rose-500">*</span></label>
                        <select name="status" required
                            class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-[#00ADC5] focus:border-[#00ADC5] text-sm">
                            <option value="Available" selected>Available</option>
                            <option value="Used">Used</option>
                            <option value="Scrap">Scrap</option>
                        </select>
                        @error('status') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Remarks -->
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Remarks</label>
                    <textarea name="remarks" rows="2"
                        class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-[#00ADC5] focus:border-[#00ADC5] text-sm">{{ old('remarks') }}</textarea>
                </div>

                <div class="flex items-center justify-end pt-3 border-t border-slate-100 gap-3">
                    <a href="{{ route('admin.rebar.offcuts.index') }}"
                        class="px-4 py-2 text-slate-600 font-bold hover:bg-slate-50 rounded-lg transition-all text-sm">Cancel</a>
                    <button type="submit"
                        class="px-4 py-2 bg-[#00ADC5] text-white rounded-lg font-bold shadow-lg shadow-cyan-500/20 hover:bg-[#0098ad] transition-all text-sm">
                        Register Off-cut
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>