<x-app-layout>
    <div class="py-6 space-y-6 max-w-4xl mx-auto" x-data="{ 
        requiredLength: {{ old('required_length', 0) }}, 
        quantity: {{ old('quantity', 0) }},
        totalLength() {
            return (this.requiredLength * this.quantity).toLocaleString();
        }
    }">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                    New Rebar Requirement
                </h2>
                <p class="text-sm text-slate-500 font-medium">
                    @if(isset($site_id))
                        Adding requirement to site
                    @else
                        Create and track structural steel requirements
                    @endif
                </p>
            </div>
            @if(isset($site_id) && $site_id)
                @php
                    $site = \App\Models\ProjectSite::find($site_id);
                @endphp
                <a href="{{ route('admin.rebar.sites.show', $site_id) }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all shadow-sm">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to {{ $site?->site_name ?? 'Site' }}
                </a>
            @else
                <a href="{{ route('admin.rebar.sites.index') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all shadow-sm">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to All Sites
                </a>
            @endif
        </div>

        <div
            class="bg-white rounded-[2rem] shadow-xl shadow-slate-100 border border-slate-200/60 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-cyan-400 to-blue-500"></div>

            <form action="{{ route('admin.rebar.requirements.store') }}" method="POST" class="p-8 md:p-10 space-y-8">
                @csrf

                @if(isset($site_id) && $site_id)
                    <input type="hidden" name="site_id" value="{{ $site_id }}">
                    @php $currentSite = $sites->where('id', $site_id)->first(); @endphp
                    <div class="bg-cyan-50 border border-cyan-100 rounded-2xl p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-cyan-600 shadow-sm border border-cyan-100">
                                <i data-lucide="building-2" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-cyan-500 uppercase tracking-widest">Selected Site</p>
                                <p class="text-sm font-black text-slate-800">{{ $currentSite->site_name ?? 'Unknown Site' }}
                                </p>
                            </div>
                        </div>
                        <span
                            class="text-[10px] font-black text-cyan-400 uppercase tracking-widest bg-white px-3 py-1 rounded-full border border-cyan-100 italic">Attached</span>
                    </div>
                @else
                    <div class="col-span-2">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Project Site
                            <span class="text-rose-500">*</span></label>
                        <select name="site_id" required
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700">
                            <option value="" disabled selected>Select Site</option>
                            @foreach($sites as $site)
                                <option value="{{ $site->id }}" {{ old('site_id') == $site->id ? 'selected' : '' }}>
                                    {{ $site->site_code }} - {{ $site->site_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('site_id') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Structural Element -->
                    <div class="col-span-2 md:col-span-1">
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Structural
                            Element <span class="text-rose-500">*</span></label>
                        <select name="structural_element" required
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700">
                            <option value="" disabled selected>Select Element</option>
                            @foreach(['BEAM', 'Slab', 'Columons', 'Shear Wall', 'Footing', 'Retaining Wall'] as $elem)
                                <option value="{{ $elem }}" {{ old('structural_element') == $elem ? 'selected' : '' }}>
                                    {{ $elem }}
                                </option>
                            @endforeach
                        </select>
                        @error('structural_element') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bar Diameter -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Bar
                            Diameter <span class="text-rose-500">*</span></label>
                        <select name="bar_diameter" required
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700">
                            <option value="" disabled selected>Select Diameter</option>
                            @php
                                $diameters = [
                                    ['val' => 8, 'label' => 'Ø8mm'],
                                    ['val' => 10, 'label' => 'Ø10mm'],
                                    ['val' => 12, 'label' => 'Ø12mm'],
                                    ['val' => 14, 'label' => 'Ø14mm'],
                                    ['val' => 16, 'label' => 'Ø16mm'],
                                    ['val' => 18, 'label' => 'Ø18mm'],
                                    ['val' => 20, 'label' => 'Ø20mm'],
                                    ['val' => 24, 'label' => 'Ø24mm'],
                                    ['val' => 32, 'label' => 'Ø32mm'],
                                ];
                            @endphp
                            @foreach($diameters as $d)
                                <option value="{{ $d['val'] }}" {{ old('bar_diameter') == $d['val'] ? 'selected' : '' }}>
                                    {{ $d['label'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('bar_diameter') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Required Length -->
                    <div class="space-y-2">
                        <label
                            class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Required
                            Length (m) <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="number" step="0.01" name="required_length" x-model.number="requiredLength"
                                required min="0.1" placeholder="e.g. 6.0"
                                class="w-full bg-slate-50 border-slate-100 rounded-2xl py-4 pr-12 font-bold text-slate-700 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 transition-all shadow-sm">
                            <span
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase">m</span>
                        </div>
                        @error('required_length') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Quantity
                            <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="quantity" x-model.number="quantity" required min="1"
                                placeholder="0"
                                class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700">
                            <div
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase">
                                PCS</div>
                        </div>
                        @error('quantity') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Total Length (Calculated) -->
                    <div class="col-span-2">
                        <div
                            class="bg-gradient-to-br from-slate-50 to-white border border-slate-100 rounded-2xl p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Total Length -->
                                <div class="text-center">
                                    <span
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-1">Total
                                        Length</span>
                                    <div class="flex items-baseline gap-2 justify-center">
                                        <span class="text-3xl font-black text-cyan-500" x-text="totalLength()">0</span>
                                        <span class="text-sm font-black text-slate-400 uppercase">m</span>
                                    </div>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1 italic">(Required Length ×
                                        Quantity)</p>
                                </div>

                                <!-- Bars Needed -->
                                <div class="text-center border-l border-r border-slate-100">
                                    <span
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-1">Standard
                                        Bars (12m)</span>
                                    <div class="flex items-baseline gap-2 justify-center">
                                        <span class="text-3xl font-black text-blue-600"
                                            x-text="Math.ceil((requiredLength * quantity) / 12)">0</span>
                                        <span class="text-sm font-black text-slate-400 uppercase">pcs</span>
                                    </div>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1 italic">12m bars needed</p>
                                </div>

                                <!-- Wastage -->
                                <div class="text-center">
                                    <span
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-1">Estimated
                                        Wastage</span>
                                    <div class="flex items-baseline gap-2 justify-center">
                                        <span class="text-3xl font-black text-rose-500" x-text="(() => {
                                                const totalNeeded = requiredLength * quantity;
                                                const barsNeeded = Math.ceil(totalNeeded / 12);
                                                const totalAvailable = barsNeeded * 12;
                                                const wastage = totalAvailable - totalNeeded;
                                                return wastage > 0 ? wastage.toFixed(2) : '0';
                                            })()">0</span>
                                        <span class="text-sm font-black text-slate-400 uppercase">m</span>
                                    </div>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1 italic">
                                        <span x-text="(() => {
                                            const totalNeeded = requiredLength * quantity;
                                            const barsNeeded = Math.ceil(totalNeeded / 12);
                                            const totalAvailable = barsNeeded * 12;
                                            const wastage = totalAvailable - totalNeeded;
                                            const percentage = totalAvailable > 0 ? ((wastage / totalAvailable) * 100).toFixed(1) : 0;
                                            return percentage + '%';
                                        })()">0%</span> waste ratio
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Drawing Reference -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Drawing
                            Reference</label>
                        <input type="text" name="drawing_reference" value="{{ old('drawing_reference') }}"
                            placeholder="e.g. ST-05 Rev.2"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700">
                        @error('drawing_reference') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remarks -->
                    <div class="col-span-2 md:col-span-1">
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Remarks</label>
                        <input type="text" name="remarks" value="{{ old('remarks') }}"
                            placeholder="Optional additional notes"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3.5 px-4 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700">
                        @error('remarks') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end pt-8 border-t border-slate-100">
                    <button type="submit"
                        class="px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-cyan-500/20 hover:scale-[1.02] hover:shadow-cyan-500/30 transition-all active:scale-95">
                        Create Rebar Log
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>