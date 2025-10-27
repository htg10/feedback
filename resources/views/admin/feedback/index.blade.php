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
            @if (!empty($feedbacks) && $feedbacks->count() > 0)
                @php
                    $avg = number_format($averageRating, 2);
                    $label = '-';
                    $badgeClass = 'bg-secondary';

                    if ($avg >= 85) {
                        $label = 'Excellent';
                        $badgeClass = 'bg-success';
                    } elseif ($avg >= 70) {
                        $label = 'Good';
                        $badgeClass = 'bg-primary';
                    } elseif ($avg >= 50) {
                        $label = 'Average';
                        $badgeClass = 'bg-warning text-dark';
                    } elseif ($avg > 0) {
                        $label = 'Poor';
                        $badgeClass = 'bg-danger';
                    }
                @endphp

                <div class="alert-light border mb-4">
                    <strong>Overall Average Rating:</strong>
                    <span class="badge {{ $badgeClass }}" style="font-size:14px;">
                        {{ $avg }}%
                    </span>
                    <span class="text-muted">({{ $label }})</span>
                    <small class="text-muted float-end">
                        {{ $feedbacks->count() }} records found
                    </small>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table id="feedbackTable" class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Mobile No.</th>
                                <th>Room</th>
                                <th>Rating Average</th>
                                <th>Remark</th>
                                <th>Image</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $allModals = ''; @endphp

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

                                    @php
                                        $ratingModel = [
                                            'food_quality' => 10,
                                            'hygiene_services' => 10,
                                            'ambience' => 5,
                                            'suit_condition' => 10,
                                            'bathroom_utilities' => 10,
                                            'housekeeping_service' => 10,
                                            'surroundings_cleanliness' => 10,
                                            'common_area_cleanliness' => 10,
                                            'dustbin_condition' => 10,
                                            'frequency_availability' => 5,
                                            'responsiveness' => 10,
                                        ];

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

                                    <td>
                                        <span class="badge {{ $badgeClass }}"
                                            style="font-size: 14px; padding: 5px; cursor: pointer;" data-bs-toggle="modal"
                                            data-bs-target="#ratingModal{{ $feedback->id }}">
                                            {{ number_format($rating, 2) }}%
                                        </span>
                                        <strong class="text-muted">({{ $label }})</strong>
                                    </td>

                                    <td>{{ $feedback->comments ?? '-' }}</td>
                                    <td>
                                        @php
                                            $docs = is_array($feedback->document)
                                                ? $feedback->document
                                                : json_decode($feedback->document, true) ?? [];
                                        @endphp

                                        @if (!empty($docs))
                                            <a href="{{ route('admin.feedbacks.download', $feedback->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $feedback->created_at->format('d-m-Y H:i') }}</td>
                                </tr>

                                {{-- Collect modals to render after table --}}
                                @php
                                    ob_start();
                                @endphp
                                <div class="modal fade" id="ratingModal{{ $feedback->id }}" tabindex="-1"
                                    aria-labelledby="ratingModalLabel{{ $feedback->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Feedback Ratings ({{ $feedback->name }})</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @php
                                                    $feedbackData = is_array($feedback->feedback_data)
                                                        ? $feedback->feedback_data
                                                        : json_decode($feedback->feedback_data, true) ?? [];
                                                @endphp
                                                <ul class="list-group">
                                                    @foreach ($ratingModel as $key => $max)
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            <span
                                                                class="text-capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                                            <span>{{ $feedbackData[$key] ?? 'N/A' }} /
                                                                3</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $allModals .= ob_get_clean();
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No feedback found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Render all modals outside the table --}}
            {!! $allModals !!}


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
        $(document).ready(function() {
            $('#feedbackTable').DataTable();
        });
    </script>
@endsection
