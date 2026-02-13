<x-app-layout>
    <div class="py-6 space-y-8 max-w-5xl mx-auto" x-data="{ tab: 'config' }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-4xl font-black text-slate-900 tracking-tight font-outfit">System Settings
                </h2>
                <p class="text-slate-500 font-medium font-inter italic">Manage application configuration and your
                    personal profile.</p>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex items-center p-1.5 bg-slate-100 rounded-[1.5rem] w-fit border border-slate-200/50">
            <button @click="tab = 'config'"
                :class="tab === 'config' ? 'bg-white text-slate-900 shadow-xl shadow-slate-200/50' : 'text-slate-500 hover:text-slate-700'"
                class="px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">
                Config
            </button>
            <button @click="tab = 'profile'"
                :class="tab === 'profile' ? 'bg-white text-slate-900 shadow-xl shadow-slate-200/50' : 'text-slate-500 hover:text-slate-700'"
                class="px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">
                Profile
            </button>
            <button @click="tab = 'security'"
                :class="tab === 'security' ? 'bg-white text-slate-900 shadow-xl shadow-slate-200/50' : 'text-slate-500 hover:text-slate-700'"
                class="px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">
                Security
            </button>
        </div>

        <div class="grid grid-cols-1 gap-8">
            <!-- Global Configuration Tab -->
            <div x-show="tab === 'config'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div
                    class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/40 border border-slate-200/60 overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#00ADC5] to-cyan-400"></div>
                    <div class="p-8 md:p-12">
                        <div class="flex items-center gap-4 mb-10">
                            <div
                                class="w-14 h-14 rounded-2xl bg-cyan-50 flex items-center justify-center text-[#00ADC5] border border-cyan-100">
                                <i data-lucide="settings-2" class="w-7 h-7"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight font-outfit">Protocol
                                    Parameters</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Global Environment
                                    Variables</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                @foreach($settings as $setting)
                                    <div class="space-y-2 group">
                                        <label
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 group-focus-within:text-[#00ADC5] transition-colors">{{ $setting->label }}</label>
                                        <div class="relative">
                                            <input type="text" name="settings[{{ $setting->key }}]"
                                                value="{{ $setting->value }}"
                                                class="w-full rounded-2xl border-none bg-slate-50 p-5 font-bold text-slate-700 focus:ring-4 focus:ring-[#00ADC5]/10 transition-all text-sm outline-none {{ $setting->key === 'employee_id_prefix' ? 'border-l-4 border-l-[#00ADC5] pl-6' : '' }}">
                                            @if($setting->key === 'employee_id_prefix')
                                                <div
                                                    class="absolute right-4 top-1/2 -translate-y-1/2 px-3 py-1 bg-cyan-100/50 rounded-lg border border-cyan-200">
                                                    <span class="text-[9px] font-black text-[#00ADC5] uppercase">Preview:
                                                        {{ $setting->value }}-0001</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="pt-8 border-t border-slate-50 flex justify-end">
                                <button type="submit"
                                    class="px-10 py-5 bg-[#00ADC5] text-white rounded-[2rem] font-black text-[10px] uppercase tracking-widest shadow-2xl shadow-cyan-200 hover:bg-[#007A8A] transition-all hover:scale-[1.02] active:scale-95">
                                    Apply System Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Profile Information Tab -->
            <div x-show="tab === 'profile'" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div
                    class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-200/60 overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-cyan-400 to-blue-500"></div>
                    <div class="p-8 md:p-12">
                        <div class="flex items-center gap-4 mb-8">
                            <div
                                class="w-12 h-12 rounded-2xl bg-cyan-50 flex items-center justify-center text-cyan-600">
                                <i data-lucide="user" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900 tracking-tight">Personal Information</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Update your name &
                                    email address</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.settings.profile.update') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PATCH')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Full
                                        Name</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full rounded-2xl border-slate-200 bg-slate-50 p-4 font-bold text-slate-700 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 transition-all text-sm">
                                    @error('name') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}
                                    </p> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Email
                                        Address</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                        class="w-full rounded-2xl border-slate-200 bg-slate-50 p-4 font-bold text-slate-700 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 transition-all text-sm">
                                    @error('email') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}
                                    </p> @enderror
                                </div>
                            </div>
                            <div class="pt-6 border-t border-slate-100 flex justify-end">
                                <button type="submit"
                                    class="px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-cyan-500/20 hover:scale-[1.02] transition-all active:scale-95">
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Security Tab -->
            <div x-show="tab === 'security'" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div
                    class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-200/60 overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-rose-400 to-rose-600"></div>
                    <div class="p-8 md:p-12">
                        <div class="flex items-center gap-4 mb-8">
                            <div
                                class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600">
                                <i data-lucide="lock" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900 tracking-tight">Security & Password</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Keep your account
                                    safe with a strong password</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.settings.password.update') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 gap-6">
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Current
                                        Password</label>
                                    <input type="password" name="current_password" required
                                        class="w-full rounded-2xl border-slate-200 bg-slate-50 p-4 font-bold text-slate-700 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all text-sm">
                                    @error('current_password', 'updatePassword') <p
                                    class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">New
                                            Password</label>
                                        <input type="password" name="password" required
                                            class="w-full rounded-2xl border-slate-200 bg-slate-50 p-4 font-bold text-slate-700 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all text-sm">
                                        @error('password', 'updatePassword') <p
                                            class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Confirm
                                            New Password</label>
                                        <input type="password" name="password_confirmation" required
                                            class="w-full rounded-2xl border-slate-200 bg-slate-50 p-4 font-bold text-slate-700 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all text-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="pt-6 border-t border-slate-100 flex justify-end">
                                <button type="submit"
                                    class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-slate-900/20 hover:bg-slate-800 transition-all active:scale-95">
                                    Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Edit Modal -->