@extends('layouts.backend.app')

@section('meta')
    <title>Complaints List | Admin</title>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h4 class="text-primary">
                        <i class="fas fa-building"></i> Complaints List
                    </h4>
                </div>
            </div>

            <!-- Filter Form -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.complaints') }}" class="row g-3 align-items-end">

                        {{-- <div class="col-md-2">
                            <label class="form-label">Month</label>
                            <select name="month" class="form-select">
                                <option value="">-- Select Month --</option>
                                @foreach (range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Year</label>
                            <select name="year" class="form-select">
                                <option value="">-- Select Year --</option>
                                @foreach (range(date('Y'), date('Y') - 5) as $y)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="col-md-3">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">To Date</label>
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">-- All --</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="complete" {{ request('status') == 'complete' ? 'selected' : '' }}>Complete
                                </option>
                            </select>
                        </div>

                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                            <a href="{{ route('admin.complaints') }}" class="btn btn-secondary w-100">Reset</a>
                        </div>
                    </form>
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
                                <th>Department</th>
                                <th>Remark</th>
                                <th>Download</th>
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
                                    <td>{{ $complaint->rooms->name ?? '-' }}
                                        [{{ $complaint->rooms->floors->name ?? '-' }}][{{ $complaint->rooms->buildings->name ?? '-' }}]
                                    </td>
                                    <td>{{ $complaint->user->departments->name ?? '-' }}</td>
                                    <td>{{ $complaint->complaint_details }}</td>
                                    <td>
                                        @php
                                            // Handle both array or JSON string
                                            $docs = is_array($complaint->document)
                                                ? $complaint->document
                                                : json_decode($complaint->document, true) ?? [];
                                        @endphp

                                        @if (!empty($docs))
                                            <a href="{{ route('admin.complaints.download', $complaint->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.statusToggle', $complaint->id) }}">
                                            @csrf
                                            <select name="status" onchange="updateSelectStyle(this); this.form.submit()"
                                                class="form-select {{ $complaint->status == 'pending' ? 'border border-danger text-danger' : '' }}
                                                {{ $complaint->status == 'complete' ? 'border border-success text-success' : '' }}">
                                                <option value="pending" class="text-danger"
                                                    {{ $complaint->status == 'pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>
                                                <option value="complete" class="text-success"
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

    <script>
        function updateSelectStyle(selectElement) {
            // Remove old status classes
            selectElement.classList.remove('border-danger', 'text-danger', 'border-success', 'text-success');

            // Add new classes based on selected value
            if (selectElement.value === 'pending') {
                selectElement.classList.add('border', 'border-danger', 'text-danger');
            } else if (selectElement.value === 'complete') {
                selectElement.classList.add('border', 'border-success', 'text-success');
            }
        }
    </script>
@endsection
