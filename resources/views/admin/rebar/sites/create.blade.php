<x-app-layout>
    <div class="py-6 space-y-4 min-w-0 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                    New Project Site
                </h2>
                <p class="text-sm text-slate-500 font-medium">Define a new physical site for rebar management</p>
            </div>
            <a href="{{ route('admin.rebar.sites.index') }}"
                class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to List
            </a>
        </div>

        <div class="section-card">
            <form action="{{ route('admin.rebar.sites.store') }}" method="POST" class="p-5 md:p-6 space-y-5">
                @csrf

                <!-- Basic Information Section -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 space-y-4">
                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <div class="w-5 h-5 rounded-md bg-cyan-50 flex items-center justify-center text-cyan-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        Basic Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Project Name -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Project
                                Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="project_name" value="{{ old('project_name') }}" required
                                placeholder="e.g. Grand Residence Towers"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm">
                            @error('project_name') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Site Name -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Site Name
                                <span class="text-rose-500">*</span></label>
                            <input type="text" name="site_name" value="{{ old('site_name') }}" required
                                placeholder="e.g. Phase 1 - North Wing"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm">
                            @error('site_name') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Location -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Location
                                <span class="text-rose-500">*</span></label>
                            <input type="text" name="location" value="{{ old('location') }}" required
                                placeholder="e.g. Downtown, Dubai"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm">
                            @error('location') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Sector -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Sector
                                (Optional)</label>
                            <input type="text" name="sector" value="{{ old('sector') }}"
                                placeholder="e.g. Residential / Commercial"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm">
                            @error('sector') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Status
                                <span class="text-rose-500">*</span></label>
                                <select name="status" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm">
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed
                                    </option>
                                    <option value="Terminated" {{ old('status') == 'Terminated' ? 'selected' : '' }}>Terminated
                                    </option>
                                </select>
                            @error('status') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Steel Grade -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Steel Grade
                                <span class="text-rose-500">*</span></label>
                            <select name="steel_grade" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm">
                                <option value="">-- Select Grade --</option>
                                @foreach([300, 400, 500, 600] as $grade)
                                    <option value="{{ $grade }}" {{ old('steel_grade') == $grade ? 'selected' : '' }}>Grade {{ $grade }}</option>
                                @endforeach
                            </select>
                            @error('steel_grade') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Manager Assignment -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Assign Manager (optional)</label>
                            <select name="manager_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm">
                                <option value="">-- No Manager --</option>
                                @foreach(\App\Models\User::where('role','manager')->get() as $m)
                                    <option value="{{ $m->id }}" {{ old('manager_id') == $m->id ? 'selected' : '' }}>{{ $m->name }} ({{ $m->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Steel Requirement Section -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 space-y-4">
                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <div class="w-5 h-5 rounded-md bg-blue-50 flex items-center justify-center text-blue-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m-6 4h6m-6 4h4m5-9v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2h5.372a2 2 0 011.612.98l2.628 1.562A2 2 0 0115 6.627V5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-.586 1.414l-2 2.586A2 2 0 0117 10.828V12a2 2 0 01-2 2H7"></path></svg>
                        </div>
                        Steel Requirement (Qty Needed in PCS)
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @foreach(['08', '10', '12', '14', '16', '20', '24', '32'] as $d)
                            @php $price = [12,18.5,26,35.5,46,72,105,185][$loop->index]; @endphp
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Ø{{ $d }}mm</label>
                                <div class="relative">
                                    <input type="number" name="amount_needed_{{ $d }}"
                                        value="{{ old('amount_needed_'.$d, 0) }}"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-lg py-1.5 px-2 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-bold text-slate-700 text-sm"
                                        oninput="updatePrice(this)">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[9px] font-black text-slate-300">PCS</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="text-[9px] font-black text-slate-400">Price:</span>
                                    <input type="number" name="price_{{ $d }}" value="{{ old('price_'.$d) }}" step="0.01" placeholder="0.00"
                                        class="w-full bg-white border border-slate-200 rounded-md py-1 px-1.5 text-[10px] font-black text-slate-700 focus:ring-1 focus:ring-cyan-500/20 focus:border-cyan-500"
                                        oninput="updatePrice(this)">
                                </div>
                                <div class="text-right text-[10px] font-black text-emerald-600 price-row">
                                    &nbsp;
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 p-4 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Steel Cost</span>
                        <span class="text-lg font-black text-slate-900" id="total-steel-cost">0.00</span>
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 space-y-4">
                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <div class="w-5 h-5 rounded-md bg-amber-50 flex items-center justify-center text-amber-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        Additional Notes
                    </h3>
                    <div>
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Notes</label>
                        <textarea name="notes" rows="3" placeholder="Additional details about the site..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all font-bold text-slate-700 text-sm">{{ old('notes') }}</textarea>
                        @error('notes') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-slate-100">
                    <button type="submit"
                        class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow hover:scale-[1.02] transition-all active:scale-95">
                        Create Project Site
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
function updatePrice(input) {
    const row = input.closest('.space-y-2');
    const qtyInput = row.querySelector('input[name^="amount_needed_"]');
    const priceInput = row.querySelector('input[name^="price_"]');
    const priceDisplay = row.querySelector('.price-row');
    if (priceInput && qtyInput && priceDisplay) {
        const price = parseFloat(priceInput.value) || 0;
        const qty = parseInt(qtyInput.value) || 0;
        if (price > 0) {
            priceDisplay.textContent = '= ' + (price * qty).toFixed(2) + ' (' + qty + ' × ' + price.toFixed(2) + ')';
        } else {
            priceDisplay.innerHTML = '&nbsp;';
        }
    }
    calculateTotal();
}

function calculateTotal() {
    const rows = document.querySelectorAll('.space-y-2');
    let total = 0;
    rows.forEach(row => {
        const priceInput = row.querySelector('input[name^="price_"]');
        const qtyInput = row.querySelector('input[name^="amount_needed_"]');
        if (priceInput && qtyInput) {
            const price = parseFloat(priceInput.value) || 0;
            const qty = parseInt(qtyInput.value) || 0;
            total += price * qty;
        }
    });
    document.getElementById('total-steel-cost').textContent = total.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
});
</script>