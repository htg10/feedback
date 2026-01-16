@extends('layouts.backend.app')

@section('meta')
    <title>Dashboard | Admin</title>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Breadcrumb -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-22 text-primary fw-bold">📊 Dashboard Overview</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active text-info">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4">

                <!-- Total Users -->
                {{-- <div class="col-md-6 col-lg-4">
                    <div class="card card-users shadow-lg text-white border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="fw-semibold fs-6 mb-1">Total Users</p>
                                    <h3 class="mb-0 fw-bold"><a href="/admin/users"
                                            style="color: white">{{ $users }}</a></h3>
                                </div>
                                <div class="card-icon display-6">
                                    <i class="bx bx-user" style="color: navy"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-6 col-lg-4">
                    <a href="/admin/users" class="card-link">
                        <div class="card card-users shadow-lg text-white border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="fw-semibold fs-6 mb-1">Total Users</p>
                                        <h3 class="mb-0 fw-bold">{{ $users }}</h3>
                                    </div>
                                    <div class="card-icon display-6">
                                        <i class="bx bx-user" style="color: navy"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


                <!-- Total Buildings -->
                <div class="col-md-6 col-lg-4">
                    <a href="/admin/buildings" class="card-link">
                        <div class="card card-businesses shadow-lg text-white border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="fw-semibold fs-6 mb-1">Total Buildings</p>
                                        <h3 class="mb-0 fw-bold">{{ $buildings }}</h3>
                                    </div>
                                    <div class="card-icon display-6">
                                        <i class="bx bx-building-house" style="color: navy"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Total Floors -->
                <div class="col-md-6 col-lg-4">
                    <a href="/admin/floors" class="card-link">
                        <div class="card card-reviews shadow-lg text-white border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="fw-semibold fs-6 mb-1">Total Floors</p>
                                        <h3 class="mb-0 fw-bold">{{ $floors }}</h3>
                                    </div>
                                    <div class="card-icon display-6">
                                        <i class="bx bx-layer" style="color: navy"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Total Rooms -->
                <div class="col-md-6 col-lg-4">
                    <a href="/admin/rooms" class="card-link">
                        <div class="card card-users shadow-lg text-white border-0"
                            style="background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="fw-semibold fs-6 mb-1">Total Rooms</p>
                                        <h3 class="mb-0 fw-bold">{{ $rooms }}</h3>
                                    </div>
                                    <div class="card-icon display-6">
                                        <i class="bx bx-category" style="color: navy"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Total Feedbacks -->
                <div class="col-md-6 col-lg-4">
                    <a href="/admin/feedbacks" class="card-link">
                        <div class="card card-feedbacks shadow-lg text-white border-0"
                            style="background: linear-gradient(135deg, #7055d4 0%, #ffd200 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="fw-semibold fs-6 mb-1">Total Feedbacks</p>
                                        <h3 class="mb-0 fw-bold">{{ $feedbacks }}</h3>
                                    </div>
                                    <div class="card-icon display-6">
                                        <i class="bx bx-message-dots" style="color: navy"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Total Complaints -->
                <div class="col-md-6 col-lg-4">
                    <a href="/admin/complaints" class="card-link">
                        <div class="card card-complaints shadow-lg text-white border-0"
                            style="background: linear-gradient(135deg, #cb2d3e 0%, #ef473a 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="fw-semibold fs-6 mb-1">Total Complaints</p>
                                        <h3 class="mb-0 fw-bold">{{ $complaints }}</h3>
                                    </div>
                                    <div class="card-icon display-6">
                                        <i class="bx bx-error" style="color: navy"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Pending Complaints -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-pending shadow-lg text-white border-0"
                        style="background: linear-gradient(135deg, #f857a6 0%, #ff5858 100%);">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="fw-semibold fs-6 mb-1">Pending Complaints</p>
                                    <h3 class="mb-0 fw-bold">{{ $totalpendingcomplaints }}</h3>
                                </div>
                                <div class="card-icon display-6">
                                    <i class="bx bx-time-five" style="color: navy"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resolved Complaints -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-resolved shadow-lg text-white border-0"
                        style="background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="fw-semibold fs-6 mb-1">Resolved Complaints</p>
                                    <h3 class="mb-0 fw-bold">{{ $totalcompleteomplaints }}</h3>
                                </div>
                                <div class="card-icon display-6">
                                    <i class="bx bx-check-circle" style="color: navy"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- end row -->

        </div>
    </div>
@endsection
