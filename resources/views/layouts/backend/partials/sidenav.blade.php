<div class="vertical-menu sidebar-light custom-sidebar">
    <div data-simplebar class="h-100 px-3 pt-3">
        <!-- Sidebar Menu -->
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="menu-title text-muted">Main</li>

                <li>
                    <a href="{{ url(
                        auth()->user()->role_id == 1 ? '/admin/index' : (auth()->user()->role_id == 2 ? '/user/index' : '/reception/index'),
                    ) }}"
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

                    <!-- Rooms -->
                    <li class="mt-2">
                        <a href="/admin/rooms" class="waves-effect d-flex align-items-center">
                            <i class="bx bx-home me-2 fs-5"></i>
                            <span>Rooms</span>
                        </a>
                    </li>

                    <li class="menu-title text-muted">Overview</li>

                    <!-- Feedbacks Dropdown -->
                    <li class="mt-2">
                        <a href="javascript:void(0);" class="waves-effect d-flex align-items-center"
                            style="background-color:rgb(127, 49, 204); color: white;">

                            <i class="bx bx-message-detail me-2 fs-5"></i>
                            <span>Feedbacks</span>
                            <i class="bx bx-chevron-down ms-auto"></i>
                        </a>

                        <!-- Sub Menu -->
                        <ul class="list-unstyled ps-4">
                            <li class="mt-2">
                                <a href="{{ route('admin.feedbacks', ['list_type' => 'effective']) }}"
                                    class="waves-effect">
                                    Effective Feedbacks
                                </a>
                            </li>
                            <li class="mt-2">
                                <a href="{{ route('admin.feedbacks', ['list_type' => 'exclude']) }}"
                                    class="waves-effect">
                                    Exclude Feedbacks
                                </a>
                            </li>
                        </ul>
                    </li>


                    <!-- All Complaints -->
                    <li class="mt-2">
                        <a href="/admin/complaints" class="waves-effect d-flex align-items-center">
                            <i class="bx bx-error me-2 fs-5"></i>
                            <span>All Complaints</span>
                        </a>
                    </li>
                @elseif (auth()->user()->role_id == 2)
                    <!-- User-only links -->
                    <li class="mt-2">
                        <a href="{{ route('user.complaints', ['status' => 'pending']) }}"
                            class="btn btn-outline-warning {{ request('status') == 'pending' ? 'active' : '' }}">
                            Pending
                        </a>
                    </li>

                    <li class="mt-2">
                        <a href="{{ route('user.complaints', ['status' => 'complete']) }}"
                            class="btn btn-outline-success {{ request('status') == 'complete' ? 'active' : '' }}">
                            Resolved
                        </a>
                    </li>

                    <li class="mt-2">
                        <a href="{{ route('user.complaints') }}"
                            class="btn btn-outline-primary {{ request('status') == null ? 'active' : '' }}">
                            All
                        </a>
                    </li>
                @elseif (auth()->user()->role_id == 3)
                    <!-- Buildings -->
                    <li class="mt-2">
                        <a href="/reception/feedbacks" class="waves-effect d-flex align-items-center">
                            <i class="bx bx-building-house me-2 fs-5"></i>
                            <span>Feedbacks</span>
                        </a>
                    </li>

                    <!-- Departments -->
                    <li class="mt-2">
                        <a href="/reception/complaints" class="waves-effect d-flex align-items-center">
                            <i class="bx bx-building me-2 fs-5"></i>
                            <span>Complaints</span>
                        </a>
                    </li>
                @else
                    <p>No role assigned</p>
                @endif

            </ul>
        </div>
        <!-- End Sidebar Menu -->
    </div>
</div>
