<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('build_admin/images/logo-sm-dark.png') }}" alt="" height="20">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('build_admin/images/logo-dark.png') }}" alt="" height="18">
                    </span>
                </a>

                <a href="index" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('build_admin/images/logo-sm-dark.png') }}" alt="" height="20">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('build_admin/images/logo-light.png') }}" alt="" height="18">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div class="topnav">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard"
                                    role="button">
                                    Dashboard <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-dashboard">
                                    <a href="index" class="dropdown-item">Dashboard 1</a>
                                    <a href="index-2" class="dropdown-item">Dashboard 2</a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-ui-element"
                                    role="button">
                                    UI Elements <div class="arrow-down"></div>
                                </a>

                                <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl"
                                    aria-labelledby="topnav-ui-element">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div>
                                                <a href="ui-alerts" class="dropdown-item">Alerts</a>
                                                <a href="ui-buttons" class="dropdown-item">Buttons</a>
                                                <a href="ui-cards" class="dropdown-item">Cards</a>
                                                <a href="ui-carousel" class="dropdown-item">Carousel</a>
                                                <a href="ui-dropdowns" class="dropdown-item">Dropdowns</a>
                                                <a href="ui-grid" class="dropdown-item">Grid</a>
                                                <a href="ui-images" class="dropdown-item">Images</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div>
                                                <a href="ui-lightbox" class="dropdown-item">Lightbox</a>
                                                <a href="ui-modals" class="dropdown-item">Modals</a>
                                                <a href="ui-rangeslider" class="dropdown-item">Range Slider</a>
                                                <a href="ui-session-timeout" class="dropdown-item">Session
                                                    Timeout</a>
                                                <a href="ui-progressbars" class="dropdown-item">Progress Bars</a>
                                                <a href="ui-sweet-alert" class="dropdown-item">Sweet-Alert</a>
                                                <a href="ui-tabs-accordions" class="dropdown-item">Tabs &
                                                    Accordions</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div>
                                                <a href="ui-typography" class="dropdown-item">Typography</a>
                                                <a href="ui-video" class="dropdown-item">Video</a>
                                                <a href="ui-general" class="dropdown-item">General</a>
                                                <a href="ui-colors" class="dropdown-item">Colors</a>
                                                <a href="ui-rating" class="dropdown-item">Rating</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-app-pages"
                                    role="button">
                                    Apps <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-app-pages">

                                    <a href="calendar" class="dropdown-item">Calendar</a>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Email <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-email">
                                            <a href="email-inbox" class="dropdown-item">Inbox</a>
                                            <a href="email-read" class="dropdown-item">Read Email</a>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-task"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Tasks <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-task">
                                            <a href="tasks-list" class="dropdown-item">Task List</a>
                                            <a href="tasks-kanban" class="dropdown-item">Kanban Board</a>
                                            <a href="tasks-create" class="dropdown-item">Create Task</a>
                                        </div>
                                    </div>

                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components"
                                    role="button">
                                    Components <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-components">

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Forms <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="form-elements" class="dropdown-item">Form Elements</a>
                                            <a href="form-validation" class="dropdown-item">Form Validation</a>
                                            <a href="form-advanced" class="dropdown-item">Form Advanced</a>
                                            <a href="form-editors" class="dropdown-item">Form Editors</a>
                                            <a href="form-uploads" class="dropdown-item">Form File Upload</a>
                                            <a href="form-xeditable" class="dropdown-item">Form Xeditable</a>
                                            <a href="form-repeater" class="dropdown-item">Form Repeater</a>
                                            <a href="form-wizard" class="dropdown-item">Form Wizard</a>
                                            <a href="form-mask" class="dropdown-item">Form Mask</a>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-table"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Tables <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-table">
                                            <a href="tables-basic" class="dropdown-item">Basic Tables</a>
                                            <a href="tables-datatable" class="dropdown-item">Data Tables</a>
                                            <a href="tables-responsive" class="dropdown-item">Responsive Table</a>
                                            <a href="tables-editable" class="dropdown-item">Editable Table</a>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Charts <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                            <a href="charts-apex" class="dropdown-item">Apex charts</a>
                                            <a href="charts-chartjs" class="dropdown-item">Chartjs Chart</a>
                                            <a href="charts-flot" class="dropdown-item">Flot Chart</a>
                                            <a href="charts-knob" class="dropdown-item">Jquery Knob Chart</a>
                                            <a href="charts-sparkline" class="dropdown-item">Sparkline Chart</a>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-icons"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Icons <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-icons">
                                            <a href="icons-boxicons" class="dropdown-item">Boxicons</a>
                                            <a href="icons-materialdesign" class="dropdown-item">Material Design</a>
                                            <a href="icons-dripicons" class="dropdown-item">Dripicons</a>
                                            <a href="icons-fontawesome" class="dropdown-item">Font awesome</a>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-map"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Maps <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-map">
                                            <a href="maps-google" class="dropdown-item">Google Maps</a>
                                            <a href="maps-vector" class="dropdown-item">Vector Maps</a>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layouts"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Layouts <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-layouts">
                                            <div class="dropdown">
                                                <a class="dropdown-item dropdown-toggle arrow-none" href="#"
                                                    id="topnav-vertical" role="button" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    Vertical <div class="arrow-down"></div>

                                                </a>

                                                <div class="dropdown-menu" aria-labelledby="topnav-vertical">
                                                    <a href="layouts-compact-sidebar" class="dropdown-item">Compact
                                                        Sidebar</a>
                                                    <a href="layouts-icon-sidebar" class="dropdown-item">Icon
                                                        Sidebar</a>
                                                    <a href="layouts-boxed" class="dropdown-item">Boxed Layout</a>
                                                    <a href="layouts-preloader" class="dropdown-item">Preloader</a>
                                                </div>
                                            </div>

                                            <div class="dropdown">
                                                <a class="dropdown-item dropdown-toggle arrow-none" href="#"
                                                    id="topnav-horizontal" role="button" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    Horizontal<div class="arrow-down"></div>

                                                </a>

                                                <div class="dropdown-menu" aria-labelledby="topnav-horizontal">
                                                    <a href="layouts-horizontal"
                                                        class="dropdown-item">Horizontal</a>
                                                    <a href="layouts-hori-topbarlight" class="dropdown-item">Topbar
                                                        Light</a>
                                                    <a href="layouts-hori-boxed" class="dropdown-item">Boxed
                                                        Layout</a>
                                                    <a href="layouts-hori-preloader"
                                                        class="dropdown-item">Preloader</a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                                    Pages <div class="arrow-down"></div>
                                </a>

                                <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-lg dropdown-menu-right"
                                    aria-labelledby="topnav-pages">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div>

                                                <a href="pages-login" class="dropdown-item">Login</a>
                                                <a href="pages-register" class="dropdown-item">Register</a>
                                                <a href="pages-recoverpw" class="dropdown-item">Recover
                                                    Password</a>
                                                <a href="pages-lock-screen" class="dropdown-item">Lock Screen</a>
                                                <a href="pages-starter" class="dropdown-item">Starter Page</a>
                                                <a href="pages-invoice" class="dropdown-item">Invoice</a>
                                                <a href="pages-profile" class="dropdown-item">Profile</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>

                                                <a href="pages-maintenance" class="dropdown-item">Maintenance</a>
                                                <a href="pages-comingsoon" class="dropdown-item">Coming Soon</a>
                                                <a href="pages-timeline" class="dropdown-item">Timeline</a>
                                                <a href="pages-faqs" class="dropdown-item">FAQs</a>
                                                <a href="pages-pricing" class="dropdown-item">Pricing</a>
                                                <a href="pages-404" class="dropdown-item">Error 404</a>
                                                <a href="pages-500" class="dropdown-item">Error 500</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <div class="d-flex">
            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..."
                                    aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <img class="" src="{{ URL::asset('build_admin/images/flags/us.jpg') }}" alt="Header Language" height="16">
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('build_admin/images/flags/spain.jpg') }}" alt="user-image" class="me-1" height="12"> <span
                            class="align-middle">Spanish</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('build_admin/images/flags/germany.jpg') }}" alt="user-image" class="me-1" height="12"> <span
                            class="align-middle">German</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('build_admin/images/flags/italy.jpg') }}" alt="user-image" class="me-1" height="12"> <span
                            class="align-middle">Italian</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('build_admin/images/flags/russia.jpg') }}" alt="user-image" class="me-1" height="12"> <span
                            class="align-middle">Russian</span>
                    </a>
                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" aria-label="bell">
                    <i class="mdi mdi-bell-outline"></i>
                    @if(($overdueLoanNotificationCount ?? 0) > 0)
                        <span class="badge bg-danger rounded-pill">{{ $overdueLoanNotificationCount }}</span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Notifikasi Keterlambatan </h6>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('loans.index', ['overdue' => 1]) }}" class="small">Lihat Semua</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        @forelse(($overdueLoanNotifications ?? []) as $notification)
                            <a href="{{ route('loans.index', ['overdue' => 1]) }}" class="text-reset notification-item">
                                <div class="d-flex align-items-start">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-warning rounded-circle font-size-16">
                                            <i class="mdi mdi-alert-outline"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <h6 class="mt-0 mb-1">{{ $notification['asset_name'] }}</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">{{ $notification['borrower_name'] }}{{ $notification['unit'] ? ' - '.$notification['unit'] : '' }}</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> Terlambat {{ $notification['late_days'] }} hari (rencana kembali {{ $notification['due_date'] ?? '-' }})</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center text-muted px-3 py-4">
                                Tidak ada pinjaman yang melewati rencana kembali.
                            </div>
                        @endforelse
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="{{ route('loans.index', ['overdue' => 1]) }}">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> Lihat Data Peminjaman
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ URL::asset('build_admin/images/users/avatar-2.jpg') }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">Patrick</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                        Profile</a>
                    <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle me-1"></i> My
                        Wallet</a>
                    <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">11</span><i
                            class="bx bx-wrench font-size-16 align-middle me-1"></i> Settings</a>
                    <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i>
                        Lock screen</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    <i class="mdi mdi-settings-outline"></i>
                </button>
            </div>
        </div>
    </div>
</header>
