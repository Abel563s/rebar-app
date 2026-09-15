<x-app-layout>
    <div class="py-6 space-y-6 min-w-0">
        <div class="section-card">
            <div class="p-5 md:p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-black text-slate-900 tracking-tight">Import Off-Cuts</h2>
                        <p class="text-xs text-slate-500 font-semibold">Upload an Excel file to bulk-import off-cuts into the register.</p>
                    </div>
                    <a href="{{ route('admin.rebar.offcuts.index') }}"
                        class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Cancel
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/60">
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-3">Step 1: Download Template</h3>
                        <p class="text-xs text-slate-500 mb-4">Use our standardized template to ensure correct column mapping and validation.</p>
                        <a href="{{ route('admin.rebar.offcuts.import-template') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-800 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download Template
                        </a>
                    </div>

                    <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/60">
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-3">Step 2: Upload & Import</h3>
                        <p class="text-xs text-slate-500 mb-4">Select the filled template and import off-cuts into the system.</p>

                        @if($errors->any())
                            <div class="mb-4 p-3 bg-rose-50 border border-rose-100 rounded-xl">
                                <p class="text-xs font-black text-rose-600">Please fix the following errors:</p>
                                <ul class="mt-2 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li class="text-[11px] font-bold text-rose-500">• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.rebar.offcuts.import') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Excel File</label>
                                <input type="file" name="file" required accept=".xlsx,.xls"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-700 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/10">
                            </div>
                            <button type="submit"
                                class="w-full py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:scale-[1.01] transition-all">
                                Import Off-Cuts
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-4 p-4 rounded-2xl border border-amber-100 bg-amber-50/60">
                    <h4 class="text-[10px] font-black text-amber-700 uppercase tracking-widest mb-2">Template Columns</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-[11px] font-bold text-slate-600">
                        <div><span class="text-amber-600">offcut_code</span> — Unique ID (optional, auto-generated)</div>
                        <div><span class="text-amber-600">site_id</span> — Project Site ID</div>
                        <div><span class="text-amber-600">bar_diameter</span> — 8, 10, 12, etc.</div>
                        <div><span class="text-amber-600">length</span> — Length in mm</div>
                        <div><span class="text-amber-600">quantity</span> — Pieces (default 1)</div>
                        <div><span class="text-amber-600">storage_location</span> — Warehouse / Location</div>
                        <div><span class="text-amber-600">status</span> — Available, Used, Scrap</div>
                        <div><span class="text-amber-600">remarks</span> — Optional notes</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
