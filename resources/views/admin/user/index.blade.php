@extends('layouts.backend.app')

@section('meta')
    <title>Users | Admin</title>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Breadcrumb and Title -->
        <div class="row mb-3">
            <div class="col-md-8">
                <h4 class="mb-0">All Users</h4>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('admin.register') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-1"></i> Add New User
                </a>
            </div>
        </div>

        <!-- Search Form -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('admin.users') }}" method="GET">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-4">
                            <div class="input-group">
                                <input type="text" name="name" id="name" class="form-control"
                                       placeholder="Search by Name..." value="{{ request('name') }}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- User Table -->
        <div class="card border shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">User List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile No.</th>
                                <th>Department</th>
                                <th style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><strong>{{ $user->name }}</strong></td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile }}</td>
                                    <td>{{ $user->departments->name ?? '-'}}</td>
                                    <td>
                                        <a href="{{ url('admin/user/' . $user->id . '/edit') }}"
                                            class="btn btn-info btn-sm me-1">
                                            <i class="bx bx-pencil"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                           class="btn btn-sm btn-danger sa-delete"
                                           data-id="{{ $user->id }}"
                                           data-link="/admin/user/delete/"
                                           data-bs-toggle="tooltip"
                                           title="Delete User">
                                           <i class="bx bx-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Optional Pagination --}}
                <div class="mt-3">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
