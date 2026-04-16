<div class="deznav">
    <div class="deznav-scroll">
        @php
            $pageToggles = array_merge(
                \App\Models\SiteSetting::defaultPageToggles(),
                $adminPageToggles ?? []
            );
            $roleAccessMap = array_replace_recursive(
                \App\Models\SiteSetting::defaultRolePageAccess(),
                $rolePageAccessMap ?? []
            );
            $currentRole = auth()->user()?->role;
            $isSuperAdmin = auth()->user()?->role === \App\Models\User::ROLE_SUPER_ADMIN;
            $canSee = static function (string $key) use ($isSuperAdmin, $pageToggles, $roleAccessMap, $currentRole): bool {
                if ($isSuperAdmin) {
                    return true;
                }

                if (!($pageToggles[$key] ?? true)) {
                    return false;
                }

                if (!$currentRole) {
                    return true;
                }

                return (bool) ($roleAccessMap[$key][$currentRole] ?? true);
            };
        @endphp
        <ul class="metismenu sarpras-menu-list" id="menu">
            <li class="menu-title sarpras-menu-title">UTAMA</li>
            <li class="{{ request()->routeIs('dashboard') || request()->routeIs('home') ? 'mm-active' : '' }}">
                <a href="{{ route('dashboard') }}" class="ai-icon sarpras-menu-link {{ request()->routeIs('dashboard') || request()->routeIs('home') ? 'active' : '' }}" data-menu-label="Dashboard">
                    <i class="fas fa-gauge-high"></i>
                    <span class="nav-text"><span class="sarpras-menu-label">Dashboard</span></span>
                    <i class="fa fa-angle-right sarpras-menu-arrow"></i>
                </a>
            </li>

            <li class="menu-title sarpras-menu-title">PENGATURAN</li>
            @if($canSee('assets_loanable'))
                <li class="{{ request()->routeIs('assets.loanable') ? 'mm-active' : '' }}">
                    <a href="{{ route('assets.loanable') }}" class="ai-icon sarpras-menu-link {{ request()->routeIs('assets.loanable') ? 'active' : '' }}" data-menu-label="Data Barang">
                        <i class="fas fa-boxes-stacked"></i>
                        <span class="nav-text">
                            <span class="sarpras-menu-label">Data Barang</span>
                            @if($isSuperAdmin && !($pageToggles['assets_loanable'] ?? true))
                                <span class="sarpras-menu-state">Nonaktif</span>
                            @endif
                        </span>
                        <i class="fa fa-angle-right sarpras-menu-arrow"></i>
                    </a>
                </li>
            @endif
            @if($canSee('assets_inventory'))
                <li class="{{ request()->routeIs('assets.index') ? 'mm-active' : '' }}">
                    <a href="{{ route('assets.index') }}" class="ai-icon sarpras-menu-link {{ request()->routeIs('assets.index') ? 'active' : '' }}" data-menu-label="Data Aset">
                        <i class="fas fa-cubes"></i>
                        <span class="nav-text">
                            <span class="sarpras-menu-label">Data Aset</span>
                            @if($isSuperAdmin && !($pageToggles['assets_inventory'] ?? true))
                                <span class="sarpras-menu-state">Nonaktif</span>
                            @endif
                        </span>
                        <i class="fa fa-angle-right sarpras-menu-arrow"></i>
                    </a>
                </li>
            @endif

            <li class="menu-title sarpras-menu-title">OPERASIONAL</li>
            @if($canSee('loans'))
                <li class="{{ request()->routeIs('loans.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('loans.index') }}" class="ai-icon sarpras-menu-link {{ request()->routeIs('loans.*') ? 'active' : '' }}" data-menu-label="Peminjaman">
                        <i class="fas fa-handshake"></i>
                        <span class="nav-text">
                            <span class="sarpras-menu-label">Peminjaman</span>
                            @if($isSuperAdmin && !($pageToggles['loans'] ?? true))
                                <span class="sarpras-menu-state">Nonaktif</span>
                            @endif
                        </span>
                        <i class="fa fa-angle-right sarpras-menu-arrow"></i>
                    </a>
                </li>
            @endif
            @if($canSee('reports'))
                <li class="{{ request()->routeIs('reports.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('reports.index') }}" class="ai-icon sarpras-menu-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" data-menu-label="Laporan">
                        <i class="fas fa-chart-column"></i>
                        <span class="nav-text">
                            <span class="sarpras-menu-label">Laporan</span>
                            @if($isSuperAdmin && !($pageToggles['reports'] ?? true))
                                <span class="sarpras-menu-state">Nonaktif</span>
                            @endif
                        </span>
                        <i class="fa fa-angle-right sarpras-menu-arrow"></i>
                    </a>
                </li>
            @endif

            <li class="menu-title sarpras-menu-title">ADMINISTRASI</li>
            @if($canSee('users'))
                <li class="{{ request()->routeIs('users.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('users.index') }}" class="ai-icon sarpras-menu-link {{ request()->routeIs('users.*') ? 'active' : '' }}" data-menu-label="Daftar Anggota">
                        <i class="fas fa-users-gear"></i>
                        <span class="nav-text">
                            <span class="sarpras-menu-label">Daftar Anggota</span>
                            @if($isSuperAdmin && !($pageToggles['users'] ?? true))
                                <span class="sarpras-menu-state">Nonaktif</span>
                            @endif
                        </span>
                        <i class="fa fa-angle-right sarpras-menu-arrow"></i>
                    </a>
                </li>
            @endif
            @if($isSuperAdmin)
                <li class="{{ request()->routeIs('settings.admin-menu*') ? 'mm-active' : '' }}">
                    <a href="{{ route('settings.admin-menu') }}" class="ai-icon sarpras-menu-link {{ request()->routeIs('settings.admin-menu*') ? 'active' : '' }}" data-menu-label="Pengaturan Super Admin">
                        <i class="fas fa-shield-halved"></i>
                        <span class="nav-text"><span class="sarpras-menu-label">Pengaturan Super Admin</span></span>
                        <i class="fa fa-angle-right sarpras-menu-arrow"></i>
                    </a>
                </li>
            @endif
        </ul>

        <div class="deznav-footer">
            <h6 class="sarpras-menu-title mb-3">LOGOUT</h6>
            <a href="{{ route('logout') }}" class="btn sarpras-logout-btn w-100"
               onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                <i class="flaticon-381-turn-off me-2"></i> Keluar
            </a>
            <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>
