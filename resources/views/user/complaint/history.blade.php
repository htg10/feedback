@extends('layouts.backend.app')

@section('meta')
    <title>Complaints History | User</title>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h4 class="text-primary">
                        <i class="fas fa-building"></i> Complaints History
                    </h4>
                </div>
            </div>

            <!-- Table -->
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Mobile No.</th>
                                <th>Room</th>
                                <th>Remark</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($complaints as $index => $complaint)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $complaint->name }}</td>
                                    <td>{{ $complaint->mobile }}</td>
                                    <td>{{ $complaint->rooms->name ?? '-'}} [{{ $complaint->rooms->floors->name }}][{{ $complaint->rooms->buildings->name }}]</td>
                                    <td>{{ $complaint->complaint_details }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('user.statusToggle', $complaint->id) }}">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" class="form-select">
                                                <option value="pending"
                                                    {{ $complaint->status == 'pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>
                                                <option value="complete"
                                                    {{ $complaint->status == 'complete' ? 'selected' : '' }}>
                                                    Complete
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{ $complaint->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No Complaints found.</td>
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
        $(document).ready(function() {
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
