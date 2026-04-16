<div class="nav-header">
    <a href="{{ route('dashboard') }}" class="brand-logo" aria-label="SARPRAS">
        <img class="logo-abbr" src="{{ asset('evanto/assets/images/camera.svg') }}" alt="logo-abbr">
        <img class="brand-title" src="{{ asset('evanto/assets/images/Logo Baju Pusdatin.png') }}" alt="logo-title">
    </a>

    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>

<header class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between sarpras-header-collapse">
                <div class="header-left sarpras-header-left">
                    <div class="dashboard_bar">{{ trim($__env->yieldContent('title', 'Dashboard')) }}</div>
                    @if(!empty($systemModeMeta))
                        <span class="badge bg-{{ $systemModeMeta['badge'] ?? 'secondary' }} ms-2">Mode: {{ $systemModeMeta['label'] ?? 'Unknown' }}</span>
                    @endif
                </div>
                <ul class="navbar-nav header-right sarpras-header-right">
                    <li class="nav-item">
                        @php
                            $isUsersPage = request()->is('users') || request()->is('users/*') || request()->routeIs('users.*');
                            $isLoansPage = request()->is('loans') || request()->is('loans/*') || request()->routeIs('loans.*');
                            $isReportsPage = request()->is('reports') || request()->is('reports/*') || request()->routeIs('reports.*');
                            $isLoanableAssetPage = request()->is('assets/loanable') || request()->routeIs('assets.loanable');
                            $isDashboardPage = request()->is('dashboard') || request()->is('home') || request()->routeIs('dashboard') || request()->routeIs('home');

                            $searchRoute = 'assets.index';
                            $searchPlaceholder = 'Cari kode, nama, atau deskripsi';
                            $isAssetGlobalSearch = true;

                            if ($isUsersPage || $isDashboardPage) {
                                $searchRoute = 'users.index';
                                $searchPlaceholder = 'Cari nama, email, atau role anggota';
                                $isAssetGlobalSearch = false;
                            } elseif ($isLoansPage) {
                                $searchRoute = 'loans.index';
                                $searchPlaceholder = 'Cari peminjam, kode, atau nama barang';
                                $isAssetGlobalSearch = false;
                            } elseif ($isReportsPage) {
                                $searchRoute = 'reports.index';
                                $searchPlaceholder = 'Cari peminjam, kode, atau nama barang';
                                $isAssetGlobalSearch = false;
                            } elseif ($isLoanableAssetPage) {
                                $searchRoute = 'assets.loanable';
                                $searchPlaceholder = 'Cari kode, nama, atau deskripsi';
                                $isAssetGlobalSearch = false;
                            }
                        @endphp
                        <form method="GET" action="{{ route($searchRoute) }}">
                            @if($isAssetGlobalSearch)
                                <input type="hidden" name="global_search" value="1">
                            @endif
                            @if($isReportsPage && request()->filled('type'))
                                <input type="hidden" name="type" value="{{ request('type') }}">
                            @endif
                            <div class="input-group search-area d-lg-inline-flex d-none me-3">
                                <div class="input-group-append">
                                    <button class="input-group-text rounded-0 rounded-start pe-2 border-0" type="submit" aria-label="Cari">
                                        <i class="flaticon-381-search-2"></i>
                                    </button>
                                </div>
                                <input type="text" name="q" value="{{ request('q') }}" class="form-control ps-2 border-0" placeholder="{{ $searchPlaceholder }}" aria-label="Search" autocomplete="off">
                            </div>
                        </form>
                    </li>
                    <!-- theme mode toggle -->
                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link bell dz-theme-mode" href="javascript:void(0);" aria-label="theme-mode">
                            <i id="icon-light" class="fas fa-sun"></i>
                            <i id="icon-dark" class="fas fa-moon"></i>
                        </a>
                    </li>
                    <!-- notifications bell -->
                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link ai-icon" href="javascript:void(0)" aria-label="bell" role="button" data-bs-toggle="dropdown">
                            <!-- bell svg copied from demo -->
                            <svg width="22" height="22" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.75 15.8385V13.0463C22.7471 10.8855 21.9385 8.80353 20.4821 7.20735C19.0258 5.61116 17.0264 4.61555 14.875 4.41516V2.625C14.875 2.39294 14.7828 2.17038 14.6187 2.00628C14.4546 1.84219 14.2321 1.75 14 1.75C13.7679 1.75 13.5454 1.84219 13.3813 2.00628C13.2172 2.17038 13.125 2.39294 13.125 2.625V4.41534C10.9736 4.61572 8.97429 5.61131 7.51794 7.20746C6.06159 8.80361 5.25291 10.8855 5.25 13.0463V15.8383C4.26257 16.0412 3.37529 16.5784 2.73774 17.3593C2.10019 18.1401 1.75134 19.1169 1.75 20.125C1.75076 20.821 2.02757 21.4882 2.51969 21.9803C3.01181 22.4724 3.67904 22.7492 4.375 22.75H9.71346C9.91521 23.738 10.452 24.6259 11.2331 25.2636C12.0142 25.9013 12.9916 26.2497 14 26.2497C15.0084 26.2497 15.9858 25.9013 16.7669 25.2636C17.548 24.6259 18.0848 23.738 18.2865 22.75H23.625C24.321 22.7492 24.9882 22.4724 25.4803 21.9803C25.9724 21.4882 26.2492 20.821 26.25 20.125C26.2486 19.117 25.8998 18.1402 25.2622 17.3594C24.6247 16.5786 23.7374 16.0414 22.75 15.8385ZM7 13.0463C7.00232 11.2113 7.73226 9.45223 9.02974 8.15474C10.3272 6.85726 12.0863 6.12732 13.9212 6.125H14.0788C15.9137 6.12732 17.6728 6.85726 18.9703 8.15474C20.2677 9.45223 20.9977 11.2113 21 13.0463V15.75H7V13.0463ZM14 24.5C13.4589 24.4983 12.9316 24.3292 12.4905 24.0159C12.0493 23.7026 11.7160 23.2604 11.5363 22.75H16.4637C16.2840 23.2604 15.9507 23.7026 15.5095 24.0159C15.0684 24.3292 14.5411 24.4983 14 24.5Z" fill="#0B2A97"/>
                            </svg>
                            <div class="pulse-css"></div>
                        </a>
                        <div class="dropdown-menu rounded dropdown-menu-end">
                            <!-- import demo notifications markup if desired -->
                            <div id="DZ_W_Notification1" class="widget-media dz-scroll p-3 height380">
                                <ul class="timeline">
                                    <li><div class="timeline-panel"><div class="media me-2"><img alt="image" width="50" src="{{ asset('evanto/assets/images/avatar/small/avatar1.webp') }}"></div><div class="media-body"><h6 class="mb-1">Contoh notifikasi</h6><small class="d-block">Now</small></div></div></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown">
                            <img src="{{ asset('evanto/assets/images/avatar/small/avatar1.webp') }}" width="20" alt="user">
                            <div class="header-info">
                                <span class="name text-black">{{ auth()->user()->name ?? 'User' }}</span>
                                <small>{{ auth()->user()?->role_label ?? 'Pengguna' }}</small>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a href="{{ route('dashboard') }}" class="dropdown-item">
                                    <i class="fa fa-home text-primary"></i><span class="ms-2">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" class="dropdown-item"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out-alt text-danger"></i><span class="ms-2 text-danger">Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

