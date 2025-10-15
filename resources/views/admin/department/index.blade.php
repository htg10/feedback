@extends('layouts.backend.app')

@section('meta')
    <title>Department List | Admin</title>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h4 class="text-primary">
                        <i class="fas fa-department"></i> Department List
                    </h4>
                    <a href="{{ route('admin.department.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Add New Department
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Department Name</th>
                                <th>Created At</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($departments as $index => $department)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ $department->created_at->format('d M Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.department.edit', $department->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-danger sa-delete"
                                            data-id="{{ $department->id }}" data-link="/admin/department/delete/"
                                            data-bs-toggle="tooltip" title="Delete User">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        {{-- <form action="{{ route('admin.department.destroy', $department->id) }}" method="POST"
                                            style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form> --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No departments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables + Bootstrap 5 JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    {{-- <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "language": {
                    "paginate": {
                        "previous": "<i class='fas fa-angle-left'></i>",
                        "next": "<i class='fas fa-angle-right'></i>"
                    }
                }
            });
        });
    </script> --}}
    <script>
    $(document).ready(function () {
        // Only apply DataTables if there's at least one data row
        const rowCount = $('.table tbody tr').length;
        const isEmpty = $('.table tbody tr td').first().attr('colspan') == 4;

        if (rowCount > 0 && !isEmpty) {
            $('.table').DataTable({
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'></i>",
                        next: "<i class='fas fa-angle-right'></i>"
                    }
                }
            });
        }
    });
</script>
@endsection
