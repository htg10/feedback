@extends('layouts.backend.app')

@section('meta')
    <title>Dashboard | User</title>
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
                <div class="col-md-6 col-lg-4">
                    <div class="card card-users shadow-lg text-white border-0">
                        <a href="{{ route('user.complaints') }}" class="text-decoration-none text-white">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="fw-semibold fs-6 mb-1">Total Complaints</p>
                                        <h3 class="mb-0 fw-bold">{{ $usercomplaints }}</h3>
                                    </div>
                                    <div class="card-icon display-6">
                                        <i class="bx bx-user" style="color: navy"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Total Buildings -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-businesses shadow-lg text-white border-0">
                        <a href="{{ route('user.complaints', ['status' => 'pending']) }}"
                            class="text-decoration-none text-white">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="fw-semibold fs-6 mb-1">Pending Complaints</p>
                                        <h3 class="mb-0 fw-bold">{{ $pendingcomplaints }}</h3>
                                    </div>
                                    <div class="card-icon display-6">
                                        <i class="bx bx-building-house" style="color: navy"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                <!-- Total Floors -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-reviews shadow-lg text-white border-0">
                        <a href="{{ route('user.complaints', ['status' => 'complete']) }}"
                            class="text-decoration-none text-white">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="fw-semibold fs-6 mb-1">Resolved Complaints</p>
                                        <h3 class="mb-0 fw-bold">{{ $resolvedcomplaints }}</h3>
                                    </div>
                                    <div class="card-icon display-6">
                                        <i class="bx bx-layer" style="color: navy"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div> <!-- end row -->

        </div>
    </div>
@endsection
