<!-- [ Main Header ] start -->
<header id="page-topbar">
    <div class="navbar-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <!-- Logo -->
            <div class="navbar-brand-box">
                <a href="{{ url(auth()->user()->role_id == 1 ? '/admin/index' : '/user/index') }}" class="logo d-flex align-items-center">
                    <img src="{{ asset('assets/images/images.jpeg') }}" alt="Logo" class="circular-logo me-2">
                    <span class="fs-5 fw-bold text-dark">Northern&nbsp;Railway</span>
                </a>
            </div>

            <!-- Toggle Sidebar -->
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex align-items-center">
            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ asset('assets/admin/images/avatar.png') }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ url('admin/logout') }}">
                        <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- [ Main Header ] end -->
