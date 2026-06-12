<x-app-layout>
    <div class="py-6 space-y-8 max-w-7xl mx-auto" x-data="{ 
        pwModal: false, 
        createModal: false,
        selectedUser: {id: null, name: '', email: '', role: '', is_active: 1},
        openPwModal(user) {
            this.selectedUser = user;
            this.pwModal = true;
        }
    }">
        <!-- Header Section -->
        <div class="space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-1">
                    <h2 class="text-4xl font-black text-slate-900 tracking-tight font-outfit">Access Control</h2>
                    <p class="text-slate-500 font-medium font-inter italic">Manage system identities and secure protocol permissions.</p>
                </div>
                
                <button @click="createModal = true" 
                        class="flex items-center justify-center gap-3 px-8 py-4 bg-slate-900 text-white rounded-[1.5rem] text-xs font-black uppercase tracking-[0.2em] shadow-2xl shadow-slate-200 hover:bg-[#00ADC5] hover:shadow-[#00ADC5]/20 transition-all active:scale-95 group">
                    <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-colors">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                    </div>
                    Create User
                </button>
            </div>

            <!-- Modern Search & Filter Bar -->
            <div class="bg-white border border-slate-200/60 rounded-[2rem] p-3 shadow-[0_10px_30px_rgba(0,0,0,0.03)] flex flex-col lg:flex-row lg:items-center gap-4">
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col lg:flex-row lg:items-center gap-4 w-full">
                    <!-- Search Input -->
                    <div class="relative group flex-1">
                        <i data-lucide="search" class="w-4 h-4 absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#00ADC5] transition-colors"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email protocol..."
                            class="w-full pl-12 pr-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 placeholder-slate-400 focus:ring-4 focus:ring-[#00ADC5]/10 transition-all outline-none">
                    </div>

                    <!-- Role Filter -->
                    <div class="flex items-center gap-2 px-5 py-2 bg-slate-50 rounded-2xl border border-transparent focus-within:border-[#00ADC5]/20 transition-all">
                        <i data-lucide="shield-check" class="w-4 h-4 text-slate-400"></i>
                        <select name="role" onchange="this.form.submit()"
                            class="bg-transparent border-none text-[11px] font-black text-slate-600 uppercase tracking-widest focus:ring-0 cursor-pointer py-2">
                            <option value="">All Tiers</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Root (Admin)</option>
                            <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Lead (Manager)</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Standard (User)</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="flex items-center gap-2 px-5 py-2 bg-slate-50 rounded-2xl border border-transparent focus-within:border-[#00ADC5]/20 transition-all">
                        <i data-lucide="activity" class="w-4 h-4 text-slate-400"></i>
                        <select name="status" onchange="this.form.submit()"
                            class="bg-transparent border-none text-[11px] font-black text-slate-600 uppercase tracking-widest focus:ring-0 cursor-pointer py-2">
                            <option value="">All States</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Operational</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Offline</option>
                        </select>
                    </div>

                    <!-- Reset Button (Only if filters active) -->
                    @if(request()->anyFilled(['search', 'role', 'status']))
                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center justify-center p-4 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-2xl transition-all" title="Clear All Filters">
                            <i data-lucide="filter-x" class="w-5 h-5"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Identity Matrix -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-100 border border-slate-200/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">User</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Role</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50/50 transition-all duration-300 group">
                                <td class="px-10 py-5">
                                    <div class="flex items-center gap-5">
                                        <div class="relative shrink-0">
                                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-500 font-black text-sm shadow-inner transition-transform group-hover:scale-110 group-hover:rotate-3 duration-500">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white {{ $user->is_active ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-black text-slate-900 tracking-tight">{{ $user->name }}</span>
                                            <span class="text-xs font-bold text-slate-400">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-10 py-5 text-center">
                                    @php
                                        $roleStyles = match($user->role) {
                                            'admin' => 'bg-emerald-100/50 text-emerald-600 border-emerald-200',
                                            'manager' => 'bg-indigo-100/50 text-indigo-600 border-indigo-200',
                                            default => 'bg-slate-100/50 text-slate-500 border-slate-200'
                                        };
                                    @endphp
                                    <span class="px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-[0.15em] border {{ $roleStyles }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-10 py-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="text-[10px] font-black uppercase tracking-widest {{ $user->is_active ? 'text-emerald-500' : 'text-slate-400' }}">
                                            {{ $user->is_active ? 'Operational' : 'Decommissioned' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-10 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click="openPwModal({id: {{ $user->id }}, name: '{{ $user->name }}', email: '{{ $user->email }}', role: '{{ $user->role }}', is_active: {{ $user->is_active ? 1 : 0 }}})" 
                                           class="p-2.5 text-slate-400 hover:text-[#00ADC5] hover:bg-cyan-50 rounded-xl transition-all" title="Update Security Key">
                                            <i data-lucide="key-round" class="w-4 h-4"></i>
                                        </button>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="p-2.5 text-slate-400 hover:text-indigo-500 hover:bg-indigo-50 rounded-xl transition-all" title="Modify Protocol">
                                            <i data-lucide="user-cog" class="w-4 h-4"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Initiate user node decommission?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2.5 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all" title="Purge Node">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-10 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-16 h-16 rounded-3xl bg-slate-50 flex items-center justify-center text-slate-200">
                                            <i data-lucide="user-x" class="w-8 h-8"></i>
                                        </div>
                                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">No matching identity nodes detected.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="px-10 py-8 border-t border-slate-50 bg-slate-50/30">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        <!-- Create New Identity Modal -->
        <div x-show="createModal" 
             style="display: none;"
             class="fixed inset-0 z-[100] flex items-center justify-center p-6"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md" @click="createModal = false"></div>
            
            <!-- Modal Content -->
            <div class="relative bg-white rounded-[3rem] w-full max-w-2xl shadow-[0_30px_100px_rgba(0,0,0,0.2)] border border-white/20 p-1 md:p-1.5 overflow-hidden">
                <div class="bg-slate-50/50 rounded-[2.8rem] p-8 md:p-12 space-y-10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-[#00ADC5] text-white flex items-center justify-center shadow-xl shadow-cyan-200 transform -rotate-3">
                                <i data-lucide="user-plus" class="w-7 h-7"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight font-outfit">Create New User</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-0.5">Deployment Protocol v2.4</p>
                            </div>
                        </div>
                        <button @click="createModal = false" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-900 shadow-sm transition-all active:scale-95">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            <!-- Name -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Full Legal Name</label>
                                <input type="text" name="name" required placeholder="Johnathan Doe"
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 placeholder-slate-300 focus:border-[#00ADC5] focus:ring-4 focus:ring-[#00ADC5]/10 transition-all outline-none">
                            </div>

                            <!-- Email -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Digital Protocol (Email)</label>
                                <input type="email" name="email" required placeholder="name@company.com"
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 placeholder-slate-300 focus:border-[#00ADC5] focus:ring-4 focus:ring-[#00ADC5]/10 transition-all outline-none">
                            </div>

                            <!-- Role -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Role</label>
                                <select name="role" required
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:border-[#00ADC5] focus:ring-4 focus:ring-[#00ADC5]/10 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="user">User</option>
                                    <option value="manager">Manager</option>
                                    <option value="admin">Admin(Level 3)</option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Status</label>
                                <select name="is_active" required
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:border-[#00ADC5] focus:ring-4 focus:ring-[#00ADC5]/10 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <!-- Password -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Security Key (Password)</label>
                                <input type="password" name="password" required placeholder="Minimum 8 characters"
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 placeholder-slate-300 focus:border-[#00ADC5] focus:ring-4 focus:ring-[#00ADC5]/10 transition-all outline-none">
                            </div>

                            <!-- Confirm -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Confirm Password</label>
                                <input type="password" name="password_confirmation" required placeholder="Re-enter security key"
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 placeholder-slate-300 focus:border-[#00ADC5] focus:ring-4 focus:ring-[#00ADC5]/10 transition-all outline-none">
                            </div>
                        </div>

                        <div class="pt-10 flex flex-col sm:flex-row gap-4">
                            <button type="button" @click="createModal = false" 
                                    class="flex-1 py-4 bg-slate-100 text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="flex-[2] py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl shadow-slate-200 hover:bg-[#00ADC5] hover:shadow-[#00ADC5]/20 transition-all active:scale-95">
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
             class="fixed inset-0 z-[100] flex items-center justify-center p-6"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md" @click="pwModal = false"></div>
            
            <!-- Modal Content -->
            <div class="relative bg-white rounded-[3rem] w-full max-w-md shadow-[0_30px_100px_rgba(0,0,0,0.2)] border border-white/20 p-1 md:p-1.5 overflow-hidden">
                <div class="bg-slate-50/50 rounded-[2.8rem] p-8 md:p-10 space-y-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center shadow-xl shadow-amber-200">
                                <i data-lucide="key-round" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900 tracking-tight font-outfit">Reset Key</h3>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-0.5">Security Protocol Update</p>
                            </div>
                        </div>
                        <button @click="pwModal = false" class="p-3 text-slate-400 hover:text-slate-900 transition-colors">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <form :action="`/admin/users/${selectedUser.id}`" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Hidden profile data to prevent overwriting during partial update -->
                        <input type="hidden" name="name" :value="selectedUser.name">
                        <input type="hidden" name="email" :value="selectedUser.email">
                        <input type="hidden" name="role" :value="selectedUser.role">
                        <input type="hidden" name="is_active" :value="selectedUser.is_active">

                        <div class="p-6 bg-white border border-slate-100 rounded-[1.5rem] shadow-sm">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Target Identity</p>
                            <p class="text-lg font-black text-slate-900 tracking-tight" x-text="selectedUser.name"></p>
                        </div>

                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">New Security Key</label>
                                <input type="password" name="password" required placeholder="••••••••"
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 transition-all focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none">
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Confirm Identity Key</label>
                                <input type="password" name="password_confirmation" required placeholder="••••••••"
                                    class="w-full px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 transition-all focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none">
                            </div>
                        </div>

                        <div class="pt-4 flex gap-3">
                            <button type="button" @click="pwModal = false" 
                                    class="flex-1 py-4 bg-slate-100 text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-slate-200 transition-all">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="flex-[2] py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl shadow-slate-200 hover:bg-amber-600 hover:shadow-amber-200 transition-all active:scale-95">
                                Update Security Node
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
