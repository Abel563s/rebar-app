<x-app-layout>
    <div class="py-4 space-y-4 min-w-0 px-4">
        <div class="flex items-center justify-between gap-3">
            <div>
                <nav class="flex text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-1">
                    <a href="{{ route('admin.users.index') }}" class="hover:text-[#00ADC5]">Access Control</a>
                    <span class="mx-2 text-slate-200">/</span>
                    <span class="text-slate-600">Modify User</span>
                </nav>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Modify Identity: {{ $user->name }}</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start">
            <div class="lg:col-span-8">
                <div class="section-card">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full rounded-lg border border-slate-200 bg-[#FAFBFC] px-3 py-2.5 font-bold text-sm text-slate-700 focus:border-[#00ADC5] focus:ring-2 focus:ring-[#00ADC5]/10 transition-all outline-none">
                                <x-input-error :messages="$errors->get('name')" />
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full rounded-lg border border-slate-200 bg-[#FAFBFC] px-3 py-2.5 font-bold text-sm text-slate-700 focus:border-[#00ADC5] focus:ring-2 focus:ring-[#00ADC5]/10 transition-all outline-none">
                                <x-input-error :messages="$errors->get('email')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Role</label>
                                <select name="role" required
                                    class="w-full rounded-lg border border-slate-200 bg-[#FAFBFC] px-3 py-2.5 font-bold text-sm text-slate-700 focus:border-[#00ADC5] focus:ring-2 focus:ring-[#00ADC5]/10 transition-all outline-none cursor-pointer">
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="department_attendance_user" {{ $user->role === 'department_attendance_user' ? 'selected' : '' }}>Department Attendance User</option>
                                    <option value="site_engineer" {{ $user->role === 'site_engineer' ? 'selected' : '' }}>Site Engineer</option>
                                    <option value="approval_officer" {{ $user->role === 'approval_officer' ? 'selected' : '' }}>Approval Officer</option>
                                    <option value="cost_control" {{ $user->role === 'cost_control' ? 'selected' : '' }}>Cost Control</option>
                                    <option value="quantity_surveyor" {{ $user->role === 'quantity_surveyor' ? 'selected' : '' }}>Quantity Surveyor</option>
                                    <option value="store_keeper" {{ $user->role === 'store_keeper' ? 'selected' : '' }}>Store Keeper</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <x-input-error :messages="$errors->get('role')" />
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</label>
                                <select name="is_active" required
                                    class="w-full rounded-lg border border-slate-200 bg-[#FAFBFC] px-3 py-2.5 font-bold text-sm focus:border-[#00ADC5] focus:ring-2 focus:ring-[#00ADC5]/10 transition-all outline-none cursor-pointer">
                                    <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <x-input-error :messages="$errors->get('is_active')" />
                            </div>
                        </div>

                        <div class="p-4 bg-amber-50 rounded-xl border border-amber-100 space-y-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600">
                                    <i data-lucide="shield-alert" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h4 class="text-[10px] font-black text-amber-900 uppercase tracking-widest leading-none">Access Key Override</h4>
                                    <p class="text-[10px] font-bold text-amber-600 mt-0.5">Leave blank to keep current credentials.</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black text-amber-700/60 uppercase tracking-widest">New Key</label>
                                    <input type="password" name="password" placeholder="••••••••"
                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 font-bold text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 transition-all outline-none">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black text-amber-700/60 uppercase tracking-widest">Confirm New Key</label>
                                    <input type="password" name="password_confirmation" placeholder="••••••••"
                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 font-bold text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 transition-all outline-none">
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" />
                        </div>

                        <div class="flex items-center gap-2 pt-2 border-t border-slate-50">
                            <button type="submit"
                                class="px-4 py-2 bg-[#00ADC5] rounded-lg text-xs font-black text-white uppercase tracking-widest shadow-md hover:bg-[#007A8A] transition-all active:scale-95">
                                Update User
                            </button>
                            <a href="{{ route('admin.users.index') }}"
                                class="px-4 py-2 bg-slate-100 border border-slate-200 rounded-lg text-xs font-black text-slate-500 uppercase tracking-widest hover:bg-slate-200 transition-all">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-4 bg-slate-900 rounded-2xl p-5 text-white relative overflow-hidden shadow-lg">
                <div class="relative z-10 space-y-5">
                    <h3 class="text-[10px] font-black text-white/30 uppercase tracking-widest">Security Protocol</h3>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                                <i data-lucide="id-card" class="w-4 h-4 text-cyan-400"></i>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black uppercase tracking-widest mb-0.5 text-cyan-400">Identify Node</h4>
                                <p class="text-[11px] text-white/60 font-medium leading-relaxed">Updating the primary email will require the user to sign in with new credentials immediately.</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                                <i data-lucide="key" class="w-4 h-4 text-[#00ADC5]"></i>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black uppercase tracking-widest mb-0.5 text-[#00ADC5]">Key Override</h4>
                                <p class="text-[11px] text-white/60 font-medium leading-relaxed">Authority-level resets bypass session verification but trigger a core sync security alert.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>