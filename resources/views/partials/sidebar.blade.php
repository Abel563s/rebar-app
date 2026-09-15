<aside id="sidebar"
    class="w-64 transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] flex flex-col z-40 relative group/sidebar overflow-visible border-r border-white/10"
    style="background: linear-gradient(180deg, #00ADC5 0%, #000000 100%) !important;">

    <div
        class="h-16 flex items-center justify-between px-6 border-b border-white/10 shrink-0 overflow-hidden relative z-10 transition-all duration-500">
        <div class="flex items-center gap-3">
            <div
                class="w-9 h-9 bg-white/10 rounded-xl flex items-center justify-center shrink-0 border border-white/20 shadow-sm transition-transform hover:scale-110 active:scale-95 duration-300">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-6 h-6 object-contain">
            </div>
            <div class="flex flex-col leading-none sidebar-text animate-pop-in">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white/90">EEC Rebar</span>
                <span class="text-sm font-black tracking-tighter mt-0.5 text-white">Management</span>
            </div>
        </div>
    </div>

    <!-- Floating External Toggle -->
    <button id="sidebarToggle"
        class="absolute -right-4 top-10 w-8 h-8 flex items-center justify-center rounded-full bg-white text-black hover:bg-[#00ADC5] hover:text-white hover:scale-110 active:scale-90 transition-all duration-300 z-[60] group/toggle">
        <i data-lucide="chevron-left"
            class="w-4 h-4 sidebar-toggle-icon transition-transform duration-500 group-hover/toggle:translate-x-[-2px]"></i>
        <i data-lucide="chevron-right"
            class="w-4 h-4 sidebar-toggle-icon hidden transition-transform duration-500 group-hover/toggle:translate-x-[2px]"></i>
    </button>

    <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scrollbar relative z-10 font-inter">
        @php
            $menu = [];
            $user = Auth::user();
            $isRebarSection = $user && request()->routeIs('admin.rebar.*');

            if ($user) {
                if ($user->isAdmin()) {
                    $menu[] = ['label' => 'Dashboard', 'icon' => 'layout-dashboard', 'route' => 'admin.dashboard', 'active' => request()->routeIs('admin.dashboard')];
                } elseif ($user->hasRebarAccess()) {
                    $menu[] = ['label' => 'Dashboard', 'icon' => 'layout-dashboard', 'route' => 'admin.rebar.dashboard', 'active' => request()->routeIs('admin.rebar.dashboard')];
                } else {
                    $menu[] = ['label' => 'Dashboard', 'icon' => 'layout-dashboard', 'route' => 'dashboard', 'active' => request()->routeIs('dashboard')];
                }

                if ($user->isAdmin()) {
                    $menu[] = ['label' => 'Project Sites', 'icon' => 'building-2', 'route' => 'admin.rebar.sites.index', 'active' => request()->routeIs('admin.rebar.sites.*')];
                    $menu[] = ['label' => 'Fabrication History', 'icon' => 'scissors', 'route' => 'admin.rebar.cutting-logs.index', 'active' => request()->routeIs('admin.rebar.cutting-logs.*')];
                    $menu[] = ['label' => 'Off-Cut Register', 'icon' => 'package-2', 'route' => 'admin.rebar.offcuts.index', 'active' => request()->routeIs('admin.rebar.offcuts.*')];
                    $menu[] = ['label' => 'Approvals', 'icon' => 'check-square', 'route' => 'admin.rebar.approvals.index', 'active' => request()->routeIs('admin.rebar.approvals.*')];
                    $menu[] = ['label' => 'Reports', 'icon' => 'line-chart', 'route' => 'admin.rebar.reports', 'active' => request()->routeIs('admin.rebar.reports')];
                    $menu[] = ['label' => 'Roles', 'icon' => 'users-2', 'route' => 'admin.users.index', 'active' => request()->routeIs('admin.users.*')];
                } elseif ($user->hasRebarAccess()) {
                    if ($user->isSiteEngineer() || $user->isSrSiteEngineer() || $user->isApprovalOfficer() || $user->isCostControl() || $user->isStoreKeeper()) {
                        $menu[] = ['label' => 'Project Sites', 'icon' => 'building-2', 'route' => 'admin.rebar.sites.index', 'active' => request()->routeIs('admin.rebar.sites.*')];
                    }

                    if ($user->isSiteEngineer() || $user->isSrSiteEngineer() || $user->isApprovalOfficer() || $user->isCostControl() || $user->isQuantitySurveyor() || $user->isStoreKeeper()) {
                        $menu[] = ['label' => 'Fabrication History', 'icon' => 'scissors', 'route' => 'admin.rebar.cutting-logs.index', 'active' => request()->routeIs('admin.rebar.cutting-logs.*')];
                        $menu[] = ['label' => 'Off-Cut Register', 'icon' => 'package-2', 'route' => 'admin.rebar.offcuts.index', 'active' => request()->routeIs('admin.rebar.offcuts.*')];
                    }

                    if ($user->isApprovalOfficer() || $user->isManager() || $user->isCostControl() || $user->isStoreKeeper()) {
                        $menu[] = ['label' => 'Approvals', 'icon' => 'check-square', 'route' => 'admin.rebar.approvals.index', 'active' => request()->routeIs('admin.rebar.approvals.*')];
                    }

                    if ($user->isApprovalOfficer() || $user->isCostControl() || $user->isQuantitySurveyor() || $user->isStoreKeeper()) {
                        $menu[] = ['label' => 'Reports', 'icon' => 'line-chart', 'route' => 'admin.rebar.reports', 'active' => request()->routeIs('admin.rebar.reports')];
                    }
                }

                if ($user->isManager() && !$user->isAdmin()) {
                    $menu[] = ['label' => 'Approvals', 'icon' => 'check-square', 'route' => 'admin.rebar.approvals.index', 'active' => request()->routeIs('admin.rebar.approvals.*')];
                }
            }
        @endphp

        @foreach ($menu as $item)
            <a href="{{ route($item['route']) }}"
                class="flex items-center gap-3.5 p-3 rounded-xl transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)] group/item relative {{ $item['active'] ? 'bg-white/20 text-white scale-[1.02] shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white hover:scale-[1.02]' }}">

                @if($item['active'])
                    <div
                        class="absolute inset-y-2.5 left-0 w-1 bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,0.4)]">
                    </div>
                @endif

                <i data-lucide="{{ $item['icon'] }}"
                    class="w-5 h-5 shrink-0 transition-all duration-500 {{ $item['active'] ? 'stroke-[2.5px] text-white' : 'opacity-70 group-hover/item:opacity-100 group-hover/item:scale-110 group-hover/item:rotate-3' }}"></i>

                <span
                    class="sidebar-text font-semibold text-sm whitespace-nowrap tracking-tight transition-all duration-500">{{ $item['label'] }}</span>

                @if(isset($item['unread']) && $item['unread'] > 0)
                    <span
                        class="ml-auto bg-white text-[#00ADC5] text-[10px] font-black px-2 py-0.5 rounded-lg shadow-sm sidebar-text animate-pulse">
                        {{ $item['unread'] }}
                    </span>
                @endif
            </a>
        @endforeach
    </nav>
</aside>

<style>
    @keyframes pop-in {
        0% {
            opacity: 0;
            transform: scale(0.9) translateX(-10px);
        }

        100% {
            opacity: 1;
            transform: scale(1) translateX(0);
        }
    }

    .animate-pop-in {
        animation: pop-in 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    #sidebar.w-20 .sidebar-text {
        display: none !important;
    }

    #sidebar.w-20 .h-16 {
        justify-content: center;
        padding: 0;
    }

    /* Fixed logo center in collapsed mode */
    #sidebar.w-20 .h-16 .flex.items-center.gap-3 {
        gap: 0;
    }

    #sidebar.w-20 nav {
        padding-left: 0;
        padding-right: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #sidebar.w-20 nav a {
        justify-content: center;
        width: 48px;
        height: 48px;
        padding: 0;
        margin: 0 auto;
    }

    #sidebar.w-20 .p-6 {
        padding: 1.5rem 0;
        display: flex;
        justify-content: center;
    }

    #sidebar.w-20 .p-6 .flex.items-center.gap-4 {
        gap: 0;
        justify-content: center;
        width: 100%;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.25);
    }

    #sidebar {
        background: linear-gradient(180deg, #00ADC5 0%, #000000 100%) !important;
    }
</style>