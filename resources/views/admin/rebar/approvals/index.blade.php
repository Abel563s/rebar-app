<x-app-layout>
    <div class="py-6 space-y-6 max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Approvals</h2>
                <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mt-1">
                    <span>Admin</span>
                    <li class="list-none p-1 rounded-full bg-slate-100"><i data-lucide="chevron-right" class="w-2.5 h-2.5"></i></li>
                    <li class="list-none text-[#00ADC5]">Approvals</li>
                </nav>
            </div>
            <button type="button" onclick="openApprovalModal()" class="flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-cyan-500/20 hover:scale-[1.02] hover:shadow-cyan-500/30 transition-all active:scale-95">
                <i data-lucide="plus" class="w-5 h-5"></i>
                New Request
            </button>
        </div>

        <div class="bg-gradient-to-br from-white via-white to-slate-50/30 rounded-[2rem] shadow-xl shadow-slate-100 border border-slate-200/60 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-500 via-blue-500 to-blue-600"></div>
            <div class="overflow-x-auto overflow-y-visible">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-50 to-white border-b-2 border-slate-100">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Site</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Offcut</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Requested By</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Approver</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($approvals as $a)
                            <tr class="hover:bg-cyan-50/30 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-slate-900">{{ $a->site->site_name ?? 'N/A' }}</span>
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $a->site?->site_code ?? '' }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-black text-slate-700">{{ $a->offcut?->code ?? '—' }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-black text-slate-900">{{ $a->requester?->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-black text-slate-900">{{ $a->approver?->name ?? 'Unassigned' }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-black text-slate-800">{{ ucfirst($a->status) }}</div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    @if($a->status === 'pending' && (auth()->user()->isAdmin() || auth()->id() === $a->approver_id))
                                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                            <form method="POST" action="{{ route('admin.rebar.approvals.approve', $a) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="px-4 py-2 bg-emerald-600 text-white rounded-xl font-bold text-sm">Approve</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.rebar.approvals.reject', $a) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="px-4 py-2 bg-rose-600 text-white rounded-xl font-bold text-sm">Reject</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-4">
                                            <i data-lucide="search-x" class="w-10 h-10 text-slate-300"></i>
                                        </div>
                                        <h3 class="text-lg font-black text-slate-900">No approval requests</h3>
                                        <p class="text-sm text-slate-500 max-w-xs mx-auto">We couldn't find any approval requests matching your search or filters.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($approvals->hasPages())
                <div class="px-8 py-5 border-t border-slate-50 bg-slate-50/30">
                    {{ $approvals->links() }}
                </div>
            @endif
        </div>

        <!-- Modal -->
        <x-modal name="approvalModal">
            <div class="w-full" style="max-width:700px; margin:0 auto;">
                <div style="border-top:4px solid #00515F;" class="bg-white p-8">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-[#00515F] text-white flex items-center justify-center shadow-sm">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black">New Approval Request</h3>
                                <p class="text-sm text-slate-500">Create a transfer approval request</p>
                            </div>
                        </div>
                        <button x-on:click="$dispatch('close-modal','approvalModal')" class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-rose-500 hover:text-white transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <div class="mb-4">
                        <div class="bg-blue-50 text-blue-700 rounded-md p-3 text-sm flex items-start gap-3">
                            <div class="mt-0.5">ℹ</div>
                            <div>Approval requests will be sent to the selected manager for review.</div>
                        </div>
                    </div>

                    <form id="approvalModalForm" action="{{ route('admin.rebar.approvals.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[13px] font-semibold text-slate-600 mb-1">From Site</label>
                                <select name="site_id" id="modal_site_id" class="w-full h-12 rounded-lg border border-[#DCE3E8] bg-[#FAFBFC] px-4 text-sm focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/12 outline-none">
                                    @foreach(\App\Models\ProjectSite::all() as $s)
                                        <option value="{{ $s->id }}">{{ $s->site_name }} ({{ $s->site_code }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[13px] font-semibold text-slate-600 mb-1">Target Site</label>
                                <select name="target_site_id" class="w-full h-12 rounded-lg border border-[#DCE3E8] bg-[#FAFBFC] px-4 text-sm focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/12 outline-none">
                                    @foreach(\App\Models\ProjectSite::all() as $s)
                                        <option value="{{ $s->id }}">{{ $s->site_name }} ({{ $s->site_code }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[13px] font-semibold text-slate-600 mb-1">Offcut (optional)</label>
                                <select name="offcut_id" class="w-full h-12 rounded-lg border border-[#DCE3E8] bg-[#FAFBFC] px-4 text-sm focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/12 outline-none">
                                    <option value="">-- Select Offcut --</option>
                                    @foreach($offcuts as $o)
                                        <option value="{{ $o->id }}">{{ $o->code }} — {{ $o->length }}m (Site: {{ $o->site?->site_code ?? 'N/A' }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[13px] font-semibold text-slate-600 mb-1">Approver (Manager)</label>
                                <select name="approver_id" class="w-full h-12 rounded-lg border border-[#DCE3E8] bg-[#FAFBFC] px-4 text-sm focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/12 outline-none">
                                    @foreach(\App\Models\User::where('role','manager')->get() as $m)
                                        <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->email }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2 mt-1">
                                <h4 class="text-sm font-semibold text-slate-600">Approval Details</h4>
                                <div class="h-px bg-slate-100 my-3"></div>
                                <label class="block text-[13px] font-semibold text-slate-600 mb-1">Note</label>
                                <textarea name="note" rows="4" class="w-full rounded-lg border border-[#DCE3E8] bg-[#FAFBFC] px-4 py-3 text-sm focus:border-[#00515F] focus:ring-4 focus:ring-[#00515F]/12 outline-none"></textarea>
                            </div>

                            <div class="md:col-span-2 flex items-center justify-end gap-3 mt-2">
                                <button type="button" x-on:click="$dispatch('close-modal','approvalModal')" class="px-5 py-3 bg-[#F3F4F6] rounded-lg hover:bg-[#E5E7EB]">Cancel</button>
                                <button type="submit" class="px-5 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-lg font-black hover:scale-[1.02] shadow-lg shadow-cyan-500/20 transition-all">Submit Request</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </x-modal>

        <script>
            function openApprovalModal() {
                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'approvalModal' }));
            }
            function closeApprovalModal() {
                window.dispatchEvent(new CustomEvent('close-modal', { detail: 'approvalModal' }));
            }
        </script>
    </div>
</x-app-layout>