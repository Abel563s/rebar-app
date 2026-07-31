<x-app-layout>
    <div class="min-w-0 space-y-4 py-5">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-black text-slate-900 tracking-tight">
                Edit Off-cut <span class="text-slate-400">#{{ $offcut->offcut_code }}</span>
            </h2>
            <a href="{{ route('admin.rebar.offcuts.index') }}"
                class="text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">
                &larr; Back to List
            </a>
        </div>

        <div class="section-card">
            <form action="{{ route('admin.rebar.offcuts.update', $offcut) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Read Only Info -->
                <div class="grid grid-cols-2 gap-4 bg-slate-50 p-3 rounded-lg border border-slate-100">
                    <div>
                        <label
                            class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Diameter</label>
                        <p class="font-black text-slate-800 text-sm">Ø{{ $offcut->bar_diameter }}mm</p>
                    </div>
                    <div>
                        <label
                            class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Length</label>
                        <p class="font-black text-slate-800 text-sm">{{ $offcut->length }}mm</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Status -->
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status
                            <span class="text-rose-500">*</span></label>
                        <select name="status" required
                            class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-[#00ADC5] focus:border-[#00ADC5] text-sm">
                            <option value="Available" {{ $offcut->status === 'Available' ? 'selected' : '' }}>Available
                            </option>
                            <option value="Used" {{ $offcut->status === 'Used' ? 'selected' : '' }}>Used</option>
                            <option value="Scrap" {{ $offcut->status === 'Scrap' ? 'selected' : '' }}>Scrap</option>
                        </select>
                        @error('status') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Storage
                            Location</label>
                        <input type="text" name="storage_location"
                            value="{{ old('storage_location', $offcut->storage_location) }}" placeholder="e.g. Rack A-3"
                            class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-[#00ADC5] focus:border-[#00ADC5] text-sm">
                        @error('storage_location') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Remarks -->
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Remarks</label>
                    <textarea name="remarks" rows="3"
                        class="w-full bg-slate-50 border-slate-200 rounded-lg focus:ring-[#00ADC5] focus:border-[#00ADC5] text-sm">{{ old('remarks', $offcut->remarks) }}</textarea>
                </div>

                <div class="flex items-center justify-end pt-3 border-t border-slate-100 gap-3">
                    <a href="{{ route('admin.rebar.offcuts.index') }}"
                        class="px-4 py-2 text-slate-600 font-bold hover:bg-slate-50 rounded-lg transition-all text-sm">Cancel</a>
                    <button type="submit"
                        class="px-4 py-2 bg-[#00ADC5] text-white rounded-lg font-bold shadow-lg shadow-cyan-500/20 hover:bg-[#0098ad] transition-all text-sm">
                        Update Off-cut
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>