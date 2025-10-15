@extends('layouts.backend.app')

@section('meta')
    <title>Feedbacks List | Admin</title>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h4 class="text-primary">
                        <i class="fas fa-building"></i> Feedbacks List
                    </h4>
                </div>
            </div>
            <!-- Filter Form -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.feedbacks') }}" class="row g-3 align-items-end">

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
                                        {{ $y }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="col-md-3">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">To Date</label>
                            <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
                        </div>

                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                            <a href="{{ route('admin.feedbacks') }}" class="btn btn-secondary w-100">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            {{-- @if (isset($averageRating))
                <div class="alert-info mb-4">
                    <strong>Average Rating:</strong>
                    {{ round(($averageRating / 3) * 5, 2) }} / 5
                </div>
            @endif --}}

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
                                <th>Rating Average</th> <!-- now shows both % and label -->
                                <th>Remark</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($feedbacks as $index => $feedback)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $feedback->name }}</td>
                                    <td>{{ $feedback->mobile }}</td>
                                    <td>
                                        <strong>Room: {{ $feedback->rooms->name ?? '-' }}</strong>
                                        [{{ $feedback->rooms->floors->name ?? '-' }}]
                                        [{{ $feedback->rooms->buildings->name ?? '-' }}]
                                    </td>
                                    <td>
                                        @php
                                            $rating = $feedback->rating;
                                            $label = $feedback->rating_label ?? '-';

                                            if ($rating >= 85) {
                                                $badgeClass = 'bg-success';
                                            } elseif ($rating >= 70) {
                                                $badgeClass = 'bg-primary';
                                            } elseif ($rating >= 50) {
                                                $badgeClass = 'bg-warning text-dark';
                                            } else {
                                                $badgeClass = 'bg-danger';
                                            }
                                        @endphp

                                        <span class="badge {{ $badgeClass }}" style="font-size: 14px; padding: 5px;">
                                            {{ number_format($rating, 2) }}%
                                        </span>
                                        <strong class="text-muted">({{ $label }})</strong>
                                    </td>
                                    <td>{{ $feedback->comments ?? '-' }}</td>
                                    <td>{{ $feedback->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No feedback found.</td>
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
