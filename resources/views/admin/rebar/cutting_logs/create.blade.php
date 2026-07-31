<x-app-layout>
    <div class="py-4 space-y-4 min-w-0 mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Fabrication Entry</h2>
                <nav class="flex">
                    <ol class="flex items-center gap-1.5 text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">
                        <li>Cutting Log</li>
                        <li class="p-0.5 rounded-full bg-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </li>
                        <li class="text-cyan-500">Record Activity</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.rebar.cutting-logs.index') }}" class="flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg> Back to History
            </a>
        </div>

        <div class="section-card overflow-hidden">
            <form action="{{ route('admin.rebar.cutting-logs.store') }}" method="POST" class="p-4 md:p-5 space-y-4">
                @csrf

                <!-- Section: Reference -->
                <div class="space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-cyan-50 flex items-center justify-center text-cyan-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        </div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Requirement Link</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Select Requirement <span class="text-rose-500">*</span></label>
                            <select name="rebar_requirement_id" id="requirement_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                                <option value="">-- Choose active requirement --</option>
                                @foreach($requirements as $req)
                                    <option value="{{ $req->id }}"
                                        data-diameter="{{ $req->bar_diameter }}"
                                        data-length="{{ $req->required_length }}"
                                        data-quantity="{{ $req->quantity }}"
                                        data-grade="{{ $req->steel_grade }}"
                                        data-site-id="{{ $req->site_id }}"
                                        {{ (old('rebar_requirement_id') ?? request('requirement_id')) == $req->id ? 'selected' : '' }}>
                                        {{ $req->tracking_id }} | {{ $req->structural_element }} | Ø{{ $req->bar_diameter }}mm | {{ $req->steel_grade ? 'Grade '.$req->steel_grade.' |' : '' }} Qty: {{ $req->quantity }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rebar_requirement_id') <p class="text-rose-500 text-[10px] font-bold mt-0.5 ml-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Quantity Being Cut <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <input type="number" name="quantity_cut" id="quantity_cut" value="{{ old('quantity_cut', 1) }}" required min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase pointer-events-none">BARS</span>
                            </div>
                            <p class="text-[9px] font-bold text-slate-400 ml-1" id="quantity_remaining_hint">This will reduce the requirement quantity</p>
                            @error('quantity_cut') <p class="text-rose-500 text-[10px] font-bold mt-0.5 ml-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Section: Geometry -->
                <div class="space-y-3 pt-3 border-t border-slate-50">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><line x1="20" x2="6" y1="4" y2="4"/><line x1="20" x2="6" y1="10" y2="10"/><line x1="20" x2="6" y1="16" y2="16"/></svg>
                        </div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Cutting Parameters</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Production Date</label>
                            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                            @error('date') <p class="text-rose-500 text-[10px] font-bold mt-0.5 ml-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Bar Diameter (Auto)</label>
                            <div class="relative">
                                <input type="number" name="bar_diameter" id="bar_diameter" value="{{ old('bar_diameter') }}" readonly required class="w-full bg-slate-100 border border-slate-200 rounded-xl py-2.5 font-bold text-slate-400 focus:ring-0 focus:border-slate-200 cursor-not-allowed text-xs">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase pointer-events-none">mm</span>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Steel Grade <span class="text-rose-500">*</span></label>
                            <select name="steel_grade" id="steel_grade" required class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                                <option value="">-- Select Grade --</option>
                                @foreach([300, 400, 500, 600] as $grade)
                                    <option value="{{ $grade }}" {{ old('steel_grade') == $grade ? 'selected' : '' }}>Grade {{ $grade }}</option>
                                @endforeach
                            </select>
                            @error('steel_grade') <p class="text-rose-500 text-[10px] font-bold mt-0.5 ml-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Source Material <span class="text-rose-500">*</span></label>
                            <select name="source_type" id="source_type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                                <option value="standard">Standard Bar (12m)</option>
                                <option value="offcut">Re-use Off-cut from Inventory</option>
                            </select>
                        </div>
                        <div class="space-y-1.5 hidden" id="offcut_selector_container">
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Select Reusable Off-cut <span class="text-rose-500">*</span></label>
                            <select name="reused_offcut_id" id="reused_offcut_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                                <option value="">-- Choose available off-cut --</option>
                                @foreach($availableOffcuts as $off)
                                    <option value="{{ $off->id }}"
                                        data-site-id="{{ $off->site_id }}"
                                        data-diameter="{{ $off->bar_diameter }}"
                                        data-length="{{ $off->length }}"
                                        data-quantity="{{ $off->quantity }}">
                                        {{ $off->offcut_code }} | L: {{ number_format($off->length, 2) }}m | Ø{{ $off->bar_diameter }}mm | Qty: {{ $off->quantity }} pcs | Loc: {{ $off->storage_location ?? 'On Site' }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-[9px] font-bold text-emerald-600 ml-1" id="offcut_hint">Select an off-cut matching the requirement diameter</p>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Original Bar Length (m)</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="original_length" id="original_length" value="{{ old('original_length', 12) }}" required min="0.1" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase pointer-events-none">m</span>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Required Cut Length (m)</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="cut_length" id="cut_length" value="{{ old('cut_length') }}" required min="0.1" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase pointer-events-none">m</span>
                            </div>
                        </div>
                        <div class="lg:col-span-2 bg-slate-800 rounded-xl p-3 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center text-cyan-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" x2="16" y1="6" y2="6"/><line x1="8" x2="8" y1="12" y2="12"/><line x1="12" x2="12" y1="10" y2="12"/></svg>
                                </div>
                                <div>
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.15em] block">Generated Off-Cut</span>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-2xl font-black text-white tracking-tighter" id="remainder_preview">0</span>
                                        <span class="text-[10px] font-black text-cyan-400 uppercase">m</span>
                                    </div>
                                </div>
                            </div>
                            <div id="status_indicator" class="flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500/10 border border-emerald-500/20 rounded-full">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">Valid Geometry</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Context -->
                <div class="space-y-3 pt-3 border-t border-slate-50">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V21z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                        </div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Usage Context</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Usage / Location</label>
                            <input type="text" name="used_for" placeholder="e.g. Slab Beam B12, Floor 12" value="{{ old('used_for') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Additional Remarks</label>
                            <input type="text" name="remarks" placeholder="Optional notes for fabrication team" value="{{ old('remarks') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-600 text-xs">
                        </div>
                    </div>
                </div>

                <div class="pt-2 flex flex-col md:flex-row items-center gap-2 justify-between border-t border-slate-50">
                    <div class="flex items-center gap-2 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                        <p class="text-[9px] font-bold uppercase tracking-widest">Off-cut will be automatically added to inventory</p>
                    </div>
                    <button type="submit" class="w-full md:w-auto px-4 py-2 bg-slate-900 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Finalize & Record Cut
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>            document.addEventListener('DOMContentLoaded', function () {
                const reqSelect = document.getElementById('requirement_id');
                const diameterInput = document.getElementById('bar_diameter');
                const steelGradeSelect = document.getElementById('steel_grade');
                const cutLengthInput = document.getElementById('cut_length');
                const originalLengthInput = document.getElementById('original_length');
                const quantityCutInput = document.getElementById('quantity_cut');
                const remainderPreview = document.getElementById('remainder_preview');
                const statusIndicator = document.getElementById('status_indicator');
                const quantityHint = document.getElementById('quantity_remaining_hint');

                const sourceTypeSelect = document.getElementById('source_type');
                const offcutSelectorContainer = document.getElementById('offcut_selector_container');
                const reusedOffcutSelect = document.getElementById('reused_offcut_id');
                const offcutHint = document.getElementById('offcut_hint');

                let maxQuantity = 0;

                function updateDetails() {
                    const selectedOption = reqSelect.options[reqSelect.selectedIndex];
                    if (selectedOption.value) {
                        diameterInput.value = selectedOption.dataset.diameter;
                        if (selectedOption.dataset.grade) {
                            steelGradeSelect.value = selectedOption.dataset.grade;
                        }
                        cutLengthInput.value = selectedOption.dataset.length;
                        maxQuantity = parseInt(selectedOption.dataset.quantity) || 0;
                        quantityCutInput.max = maxQuantity;
                        
                        filterOffcuts(selectedOption.dataset.diameter, selectedOption.dataset.siteId);
                        updateQuantityHint();
                    } else {
                        diameterInput.value = '';
                        steelGradeSelect.value = '';
                        cutLengthInput.value = '';
                        maxQuantity = 0;
                        quantityHint.textContent = 'This will reduce the requirement quantity';
                        resetOffcutFilter();
                    }
                    calculateRemainder();
                }

                function filterOffcuts(diameter, siteId) {
                    let matchCount = 0;
                    const offcutOptions = reusedOffcutSelect.options;
                    for (let i = 0; i < offcutOptions.length; i++) {
                        const opt = offcutOptions[i];
                        if (!opt.value) continue;
                        const optDiameter = opt.dataset.diameter;
                        const optSiteId = opt.dataset.siteId;
                        if (String(optDiameter) === String(diameter) && String(optSiteId) === String(siteId)) {
                            opt.style.display = '';
                            matchCount++;
                        } else {
                            opt.style.display = 'none';
                        }
                    }
                    reusedOffcutSelect.value = '';
                    if (matchCount > 0) {
                        sourceTypeSelect.options[1].disabled = false;
                        sourceTypeSelect.options[1].textContent = `Re-use Off-cut from Inventory (${matchCount} available)`;
                        offcutHint.innerHTML = `<span class="text-emerald-600">✓ Found ${matchCount} matching off-cuts for Ø${diameter}mm on this site.</span>`;
                    } else {
                        sourceTypeSelect.value = 'standard';
                        sourceTypeSelect.options[1].disabled = true;
                        sourceTypeSelect.options[1].textContent = `Re-use Off-cut from Inventory (None available)`;
                        offcutSelectorContainer.classList.add('hidden');
                        reusedOffcutSelect.required = false;
                        originalLengthInput.readOnly = false;
                        originalLengthInput.classList.remove('bg-slate-100', 'cursor-not-allowed', 'text-slate-400');
                        offcutHint.innerHTML = `<span class="text-amber-600">⚠ No matching available off-cuts for Ø${diameter}mm on this site.</span>`;
                    }
                }

                function resetOffcutFilter() {
                    const offcutOptions = reusedOffcutSelect.options;
                    for (let i = 0; i < offcutOptions.length; i++) {
                        offcutOptions[i].style.display = '';
                    }
                    reusedOffcutSelect.value = '';
                    sourceTypeSelect.value = 'standard';
                    sourceTypeSelect.options[1].disabled = false;
                    sourceTypeSelect.options[1].textContent = 'Re-use Off-cut from Inventory';
                    offcutSelectorContainer.classList.add('hidden');
                    reusedOffcutSelect.required = false;
                    originalLengthInput.readOnly = false;
                    originalLengthInput.classList.remove('bg-slate-100', 'cursor-not-allowed', 'text-slate-400');
                    offcutHint.textContent = 'Please select a matching off-cut';
                }

                function handleSourceTypeChange() {
                    if (sourceTypeSelect.value === 'offcut') {
                        offcutSelectorContainer.classList.remove('hidden');
                        reusedOffcutSelect.required = true;
                        originalLengthInput.readOnly = true;
                        originalLengthInput.classList.add('bg-slate-100', 'cursor-not-allowed', 'text-slate-400');
                        handleOffcutSelectChange();
                    } else {
                        offcutSelectorContainer.classList.add('hidden');
                        reusedOffcutSelect.required = false;
                        reusedOffcutSelect.value = '';
                        originalLengthInput.readOnly = false;
                        originalLengthInput.classList.remove('bg-slate-100', 'cursor-not-allowed', 'text-slate-400');
                        originalLengthInput.value = '12';
                        quantityCutInput.max = maxQuantity;
                        updateQuantityHint();
                        calculateRemainder();
                    }
                }

                function handleOffcutSelectChange() {
                    const selectedOffcut = reusedOffcutSelect.options[reusedOffcutSelect.selectedIndex];
                    if (selectedOffcut && selectedOffcut.value) {
                        const offcutLen = parseFloat(selectedOffcut.dataset.length);
                        const offcutQty = parseInt(selectedOffcut.dataset.quantity);
                        originalLengthInput.value = offcutLen.toFixed(2);
                        const limitQty = Math.min(maxQuantity, offcutQty);
                        quantityCutInput.max = limitQty;
                        if (parseInt(quantityCutInput.value) > limitQty) {
                            quantityCutInput.value = limitQty;
                        }
                        offcutHint.innerHTML = `<span class="text-emerald-600">Selected off-cut length: ${offcutLen}m (${offcutQty} pieces available)</span>`;
                    } else {
                        originalLengthInput.value = '';
                        quantityCutInput.max = maxQuantity;
                        offcutHint.textContent = 'Please choose an off-cut from the dropdown list';
                    }
                    updateQuantityHint();
                    calculateRemainder();
                }

                function updateQuantityHint() {
                    const cutQty = parseInt(quantityCutInput.value) || 0;
                    const remaining = maxQuantity - cutQty;
                    if (cutQty > maxQuantity) {
                        quantityHint.innerHTML = `<span class="text-rose-500">⚠ Exceeds available quantity (${maxQuantity} bars)</span>`;
                        quantityCutInput.classList.add('border-rose-500', 'bg-rose-50');
                    } else if (remaining === 0) {
                        quantityHint.innerHTML = `<span class="text-emerald-500">✓ This will complete the requirement</span>`;
                        quantityCutInput.classList.remove('border-rose-500', 'bg-rose-50');
                    } else {
                        quantityHint.innerHTML = `<span class="text-cyan-600">${remaining} bars will remain in requirement</span>`;
                        quantityCutInput.classList.remove('border-rose-500', 'bg-rose-50');
                    }
                }

                function calculateRemainder() {
                    const original = parseFloat(originalLengthInput.value) || 0;
                    const cut = parseFloat(cutLengthInput.value) || 0;
                    const remainder = original - cut;
                    remainderPreview.innerText = remainder > 0 ? remainder.toFixed(2) : '0';
                    if (remainder < 0) {
                        statusIndicator.classList.remove('bg-emerald-500/10', 'border-emerald-500/20');
                        statusIndicator.classList.add('bg-rose-500/10', 'border-rose-500/20');
                        statusIndicator.innerHTML = `<div class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></div><span class="text-[9px] font-black text-rose-400 uppercase tracking-widest">Invalid: Cut > Source</span>`;
                        remainderPreview.classList.add('text-rose-400');
                    } else {
                        statusIndicator.classList.remove('bg-rose-500/10', 'border-rose-500/20');
                        statusIndicator.classList.add('bg-emerald-500/10', 'border-emerald-500/20');
                        statusIndicator.innerHTML = `<div class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div><span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">Valid Geometry</span>`;
                        remainderPreview.classList.remove('text-rose-400');
                    }
                }

                reqSelect.addEventListener('change', updateDetails);
                originalLengthInput.addEventListener('input', calculateRemainder);
                cutLengthInput.addEventListener('input', calculateRemainder);
                quantityCutInput.addEventListener('input', updateQuantityHint);
                sourceTypeSelect.addEventListener('change', handleSourceTypeChange);
                reusedOffcutSelect.addEventListener('change', handleOffcutSelectChange);
                if (reqSelect.value) { updateDetails(); }
            });
        </script>
    @endpush
</x-app-layout>