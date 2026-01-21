@extends('layouts.backend.app')

@section('meta')
    <title>Complaints List | Admin</title>
@endsection

@section('style')
    <style>

    </style>
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

                        <div class="col-md-2">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">To Date</label>
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Building</label>
                            <select name="building_id" class="form-select">
                                <option value="">-- All --</option>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}"
                                        {{ request('building_id') == $building->id ? 'selected' : '' }}>
                                        {{ $building->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Department</label>
                            <select name="department_id" class="form-select">
                                <option value="">-- All --</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }} | {{ $department->building->name ?? null }}
                                    </option>
                                @endforeach
                            </select>
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

            <!-- Export Buttons -->
            <div class="d-flex justify-content-end mb-3 gap-2">
                <a href="{{ route('admin.complaints.export.excel', request()->query()) }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>

                <a href="{{ route('admin.complaints.export.pdf', request()->query()) }}" class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
            </div>

            <!-- Table -->
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Unique Id</th>
                                <th>Name</th>
                                <th>Mobile No.</th>
                                <th>Room</th>
                                <th>Department</th>
                                <th>Comment</th>
                                <th>Download</th>
                                <th>Status</th>
                                <th>Remark</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($complaints as $index => $complaint)
                                <tr>
                                    <td>{{ $complaint->unique_id }}</td>
                                    <td>{{ $complaint->name }}</td>
                                    <td>{{ $complaint->mobile }}</td>
                                    <td><strong>Room: {{ $complaint->rooms->name ?? '-' }}</strong>
                                        [{{ $complaint->rooms->floors->name ?? '-' }}][{{ $complaint->rooms->buildings->name ?? '-' }}]
                                    </td>
                                    <td>{{ $complaint->user->departments->name ?? '-' }}</td>
                                    <td>
                                        <span class="comment-short">
                                            {{ Str::limit($complaint->complaint_details, 60) }}
                                        </span>

                                        @if (strlen($complaint->complaint_details) > 60)
                                            <span class="comment-full d-none">
                                                {{ $complaint->complaint_details }}
                                            </span>

                                            <a href="javascript:void(0)" class="read-more text-primary fw-semibold"
                                                onclick="toggleComment(this)">
                                                Read more
                                            </a>
                                        @endif
                                    </td>
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
                                    <td>{{ $complaint->user_remark }}</td>
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
                    ordering: false,
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

    {{-- Read More Button --}}
    <script>
        function toggleComment(el) {
            let td = el.closest('td');
            let shortText = td.querySelector('.comment-short');
            let fullText = td.querySelector('.comment-full');

            if (fullText.classList.contains('d-none')) {
                shortText.classList.add('d-none');
                fullText.classList.remove('d-none');
                el.innerText = 'Read less';
            } else {
                fullText.classList.add('d-none');
                shortText.classList.remove('d-none');
                el.innerText = 'Read more';
            }
        }
    </script>
@endsection
