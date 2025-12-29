<div class="vertical-menu sidebar-light custom-sidebar">
    <div data-simplebar class="h-100 px-3 pt-3">
        <!-- Sidebar Menu -->
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="menu-title text-muted">Main</li>

                <li>
                    <a href="{{ url(auth()->user()->role_id == 1 ? '/admin/index' : '/user/index') }}"
                        class="waves-effect d-flex align-items-center">
                        <i class="bx bx-home-circle me-2 fs-5"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if (auth()->user()->role_id == 1)
                    <li class="menu-title text-muted">Admin Panel</li>

                    <!-- Buildings -->
                    <li class="mt-2">
                        <a href="/admin/buildings" class="waves-effect d-flex align-items-center">
                            <i class="bx bx-building-house me-2 fs-5"></i>
                            <span>Buildings</span>
                        </a>
                    </li>

                    <!-- Departments -->
                    <li class="mt-2">
                        <a href="/admin/departments" class="waves-effect d-flex align-items-center">
                            <i class="bx bx-building me-2 fs-5"></i>
                            <span>Departments</span>
                        </a>
                    </li>

                    <!-- Users -->
                    <li class="mt-2">
                        <a href="/admin/users" class="waves-effect d-flex align-items-center">
                            <i class="bx bx-user me-2 fs-5"></i>
                            <span>All Users</span>
                        </a>
                    </li>



                    <!-- Floors -->
                    <li class="mt-2">
                        <a href="/admin/floors" class="waves-effect d-flex align-items-center">
                            <i class="bx bx-layer me-2 fs-5"></i>
                            <span>Floors</span>
                        </a>
                    </li>

                    {{-- <!-- Departments -->
                    <li class="mt-2">
                        <a href="/admin/categories" class="waves-effect d-flex align-items-center">
                            <i class="bx bx-category me-2 fs-5"></i>
                            <span>Categories</span>
                        </a>
                    </li> --}}

                    <!-- Rooms -->
                    <li class="mt-2">
                        <a href="/admin/rooms" class="waves-effect d-flex align-items-center">
                            <i class="bx bx-home me-2 fs-5"></i>
                            <span>Rooms</span>
                        </a>
                    </li>

                    <li class="menu-title text-muted">Overview</li>

                    <!-- All Feedbacks -->
                    <li class="mt-2">
                        <a href="/admin/feedbacks" class="waves-effect d-flex align-items-center">
                            <i class="bx bx-message-detail me-2 fs-5"></i>
                            <span>All Feedbacks</span>
                        </a>
                    </li>

                    <!-- All Complaints -->
                    <li class="mt-2">
                        <a href="/admin/complaints" class="waves-effect d-flex align-items-center">
                            <i class="bx bx-error me-2 fs-5"></i>
                            <span>All Complaints</span>
                        </a>
                    </li>
                @else
                    <!-- User-only links -->
                    <li class="mt-2">
                        <a href="/complaint/complaints" class="waves-effect">
                            <i class="bx bx-error me-2 fs-5"></i>
                            <span key="t-chat">Complaints</span>
                        </a>
                    </li>
                    <li class="mt-2">
                        <a href="/complaint/history" class="waves-effect">
                            <i class="bx bx-history me-2 fs-5"></i>
                            <span key="t-chat">Complaint History</span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
        <!-- End Sidebar Menu -->
    </div>
</div>
