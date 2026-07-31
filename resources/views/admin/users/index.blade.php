<x-app-layout>
    <div class="py-4 space-y-4 min-w-0 px-4" x-data="{ 
        pwModal: false, 
        createModal: false,
        selectedUser: {id: null, name: '', email: '', role: '', is_active: 1},
        openPwModal(user) {
            this.selectedUser = user;
            this.pwModal = true;
        }
    }">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Access Control</h2>
                <p class="text-xs text-slate-500 font-medium">Manage system identities and secure protocol permissions.</p>
            </div>
            
            <button @click="createModal = true" 
                    class="flex items-center justify-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg hover:bg-[#00ADC5] hover:shadow-md transition-all active:scale-95 group">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Create User
            </button>
        </div>

<div class="section-card shadow-lg hover:shadow-xl transition-all bg-white/90 backdrop-blur-sm border border-slate-200/60 p-3 flex flex-col lg:flex-row lg:items-center gap-3">
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col lg:flex-row lg:items-center gap-3 w-full">
                    <div class="relative flex-1">
                        <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 placeholder-slate-400 focus:border-[#00ADC5] focus:ring-2 focus:ring-[#00ADC5]/10 transition-all outline-none">
                    </div>

                    <div class="flex items-center gap-2 px-3 py-2 bg-slate-50 rounded-xl border border-slate-100">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-slate-400"></i>
                        <select name="role" onchange="this.form.submit()"
                            class="bg-transparent border-none text-[10px] font-black text-slate-600 uppercase tracking-widest focus:ring-0 cursor-pointer py-0.5">
                            <option value="">All Tiers</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Root (Admin)</option>
                            <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Lead (Manager)</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Standard (User)</option>
                            <option value="department_attendance_user" {{ request('role') == 'department_attendance_user' ? 'selected' : '' }}>Department Attendance User</option>
                            <option value="site_engineer" {{ request('role') == 'site_engineer' ? 'selected' : '' }}>Site Engineer</option>
                            <option value="approval_officer" {{ request('role') == 'approval_officer' ? 'selected' : '' }}>Approval Officer</option>
                            <option value="cost_control" {{ request('role') == 'cost_control' ? 'selected' : '' }}>Cost Control</option>
                            <option value="quantity_surveyor" {{ request('role') == 'quantity_surveyor' ? 'selected' : '' }}>Quantity Surveyor</option>
                            <option value="store_keeper" {{ request('role') == 'store_keeper' ? 'selected' : '' }}>Store Keeper</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2 px-3 py-2 bg-slate-50 rounded-xl border border-slate-100">
                        <i data-lucide="activity" class="w-3.5 h-3.5 text-slate-400"></i>
                        <select name="status" onchange="this.form.submit()"
                            class="bg-transparent border-none text-[10px] font-black text-slate-600 uppercase tracking-widest focus:ring-0 cursor-pointer py-0.5">
                            <option value="">All States</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Operational</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Offline</option>
                        </select>
                    </div>

                    @if(request()->anyFilled(['search', 'role', 'status']))
                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center justify-center p-2.5 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all" title="Clear All Filters">
                            <i data-lucide="filter-x" class="w-4 h-4"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>

<div class="section-card shadow-lg hover:shadow-xl transition-all bg-white/90 backdrop-blur-sm border border-slate-200/60">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#00adc5] text-white border-b border-[#00adc5]">
                     <th class="px-5 py-3 text-[10px] font-black text-white uppercase tracking-[0.15em]">User</th>
                     <th class="px-5 py-3 text-[10px] font-black text-white uppercase tracking-[0.15em] text-center">Role</th>
                     <th class="px-5 py-3 text-[10px] font-black text-white uppercase tracking-[0.15em] text-center">Status</th>
                     <th class="px-5 py-3 text-[10px] font-black text-white uppercase tracking-[0.15em] text-right">Actions</th>
                 </tr>
             </thead>
             <tbody class="divide-y divide-slate-50">
                 @forelse($users as $user)
                     <tr class="hover:bg-slate-50/50 transition-all group">
                         <td class="px-5 py-3">
                             <div class="flex items-center gap-3">
                                 <div class="relative shrink-0">
                                     <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-500 font-black text-sm">
                                         {{ substr($user->name, 0, 1) }}
                                     </div>
                                     <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 rounded-full border-2 border-white {{ $user->is_active ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
                                 </div>
                                 <div class="flex flex-col min-w-0">
                                     <span class="font-bold text-slate-900 tracking-tight text-sm truncate">{{ $user->name }}</span>
                                     <span class="text-xs font-bold text-slate-400 truncate">{{ $user->email }}</span>
                                 </div>
                             </div>
                         </td>

                                <td class="px-5 py-3 text-center">
                                    @php
                                        $roleStyles = match($user->role) {
                                            'admin' => 'bg-emerald-100/50 text-emerald-600 border-emerald-200',
                                            'manager' => 'bg-indigo-100/50 text-indigo-600 border-indigo-200',
                                            'site_engineer' => 'bg-cyan-100/50 text-cyan-600 border-cyan-200',
                                            'approval_officer' => 'bg-amber-100/50 text-amber-600 border-amber-200',
                                            'cost_control' => 'bg-violet-100/50 text-violet-600 border-violet-200',
                                            'quantity_surveyor' => 'bg-teal-100/50 text-teal-600 border-teal-200',
                                            'store_keeper' => 'bg-orange-100/50 text-orange-600 border-orange-200',
                                            'department_attendance_user' => 'bg-pink-100/50 text-pink-600 border-pink-200',
                                            default => 'bg-slate-100/50 text-slate-500 border-slate-200'
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-[0.12em] border {{ $roleStyles }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span class="text-[10px] font-black uppercase tracking-widest {{ $user->is_active ? 'text-emerald-500' : 'text-slate-400' }}">
                                            {{ $user->is_active ? 'Operational' : 'Decommissioned' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button @click="openPwModal({id: {{ $user->id }}, name: '{{ $user->name }}', email: '{{ $user->email }}', role: '{{ $user->role }}', is_active: {{ $user->is_active ? 1 : 0 }}})" 
                                           class="p-2 text-slate-400 hover:text-[#00ADC5] hover:bg-cyan-50 rounded-lg transition-all" title="Update Security Key">
                                            <i data-lucide="key-round" class="w-4 h-4"></i>
                                        </button>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="p-2 text-slate-400 hover:text-indigo-500 hover:bg-indigo-50 rounded-lg transition-all" title="Modify Protocol">
                                            <i data-lucide="user-cog" class="w-4 h-4"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Initiate user node decommission?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all" title="Purge Node">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center">
                                            <i data-lucide="user-x" class="w-6 h-6 text-slate-300"></i>
                                        </div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">No matching identity nodes detected.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="px-4 py-3 border-t border-slate-50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        <!-- Create New Identity Modal -->
        <div x-show="createModal" 
             style="display: none;"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="createModal = false"></div>
            
            <!-- Modal Content -->
            <div class="relative bg-white rounded-2xl w-full max-w-xl shadow-xl border border-slate-200 overflow-hidden">
                <div class="p-5 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#00ADC5] text-white flex items-center justify-center">
                                <i data-lucide="user-plus" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-900 tracking-tight">Create New User</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Deployment Protocol</p>
                            </div>
                        </div>
                        <button @click="createModal = false" class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-all active:scale-95">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Full Legal Name</label>
                                <input type="text" name="name" required placeholder="Johnathan Doe"
                                    class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-lg text-sm font-bold text-slate-700 placeholder-slate-300 focus:border-[#00ADC5] focus:ring-2 focus:ring-[#00ADC5]/10 transition-all outline-none">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Email</label>
                                <input type="email" name="email" required placeholder="name@company.com"
                                    class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-lg text-sm font-bold text-slate-700 placeholder-slate-300 focus:border-[#00ADC5] focus:ring-2 focus:ring-[#00ADC5]/10 transition-all outline-none">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Role</label>
                                <select name="role" required
                                    class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-lg text-sm font-bold text-slate-700 focus:border-[#00ADC5] focus:ring-2 focus:ring-[#00ADC5]/10 transition-all outline-none cursor-pointer">
                           
                                <option value="manager">Manager</option>
                                <option value="site_engineer">Site Engineer</option>
                                <option value="cost_control">Cost Control</option>
                                <option value="quantity_surveyor">Quantity Surveyor</option>
                                <option value="store_keeper">Store Keeper</option>
                                <option value="admin">Admin</option>
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</label>
                                <select name="is_active" required
                                    class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-lg text-sm font-bold text-slate-700 focus:border-[#00ADC5] focus:ring-2 focus:ring-[#00ADC5]/10 transition-all outline-none cursor-pointer">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Password</label>
                                <input type="password" name="password" required placeholder="Minimum 8 characters"
                                    class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-lg text-sm font-bold text-slate-700 placeholder-slate-300 focus:border-[#00ADC5] focus:ring-2 focus:ring-[#00ADC5]/10 transition-all outline-none">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Confirm Password</label>
                                <input type="password" name="password_confirmation" required placeholder="Re-enter password"
                                    class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-lg text-sm font-bold text-slate-700 placeholder-slate-300 focus:border-[#00ADC5] focus:ring-2 focus:ring-[#00ADC5]/10 transition-all outline-none">
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-2">
                            <button type="button" @click="createModal = false" 
                                    class="px-4 py-2 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-slate-900 text-white rounded-lg text-[10px] font-black uppercase tracking-widest shadow-lg hover:bg-[#00ADC5] transition-all active:scale-95">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<!-- Password Update Modal -->
        <div x-show="pwModal" 
             style="display: none;"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="pwModal = false"></div>
            
            <!-- Modal Content -->
            <div class="relative bg-white rounded-2xl w-full max-w-sm shadow-xl border border-slate-200 overflow-hidden">
                <div class="p-5 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center">
                                <i data-lucide="key-round" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-900 tracking-tight">Reset Key</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Security Protocol Update</p>
                            </div>
                        </div>
                        <button @click="pwModal = false" class="p-2 text-slate-400 hover:text-slate-900 transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <form :action="`/admin/users/${selectedUser.id}`" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        
                        <input type="hidden" name="name" :value="selectedUser.name">
                        <input type="hidden" name="email" :value="selectedUser.email">
                        <input type="hidden" name="role" :value="selectedUser.role">
                        <input type="hidden" name="is_active" :value="selectedUser.is_active">

                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Target Identity</p>
                            <p class="text-sm font-black text-slate-900 tracking-tight" x-text="selectedUser.name"></p>
                        </div>

                        <div class="space-y-3">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">New Security Key</label>
                                <input type="password" name="password" required placeholder="••••••••"
                                    class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-lg text-sm font-bold text-slate-700 transition-all focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Confirm Identity Key</label>
                                <input type="password" name="password_confirmation" required placeholder="••••••••"
                                    class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-lg text-sm font-bold text-slate-700 transition-all focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 outline-none">
                            </div>
                        </div>

                        <div class="flex gap-2 pt-1">
                            <button type="button" @click="pwModal = false" 
                                    class="flex-1 py-2 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="flex-[2] py-2 bg-slate-900 text-white rounded-lg text-[10px] font-black uppercase tracking-widest shadow-lg hover:bg-amber-600 transition-all active:scale-95">
                                Update Security Node
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
