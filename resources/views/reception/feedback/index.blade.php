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
                    <form method="GET" action="{{ route('reception.feedbacks') }}" class="row g-3 align-items-end">


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
                            <a href="{{ route('reception.feedbacks') }}" class="btn btn-secondary w-100">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            @if ($feedbacks->count() > 0)
                @php
                    $avg = $averageRating; // already rounded or null
                    $label = 'N/A';
                    $badgeClass = 'bg-secondary';

                    if ($avg !== null) {
                        if ($avg >= 85) {
                            $label = 'Excellent';
                            $badgeClass = 'bg-success';
                        } elseif ($avg >= 70) {
                            $label = 'Good';
                            $badgeClass = 'bg-primary';
                        } elseif ($avg >= 50) {
                            $label = 'Average';
                            $badgeClass = 'bg-warning text-dark';
                        } else {
                            $label = 'Poor';
                            $badgeClass = 'bg-danger';
                        }
                    }
                @endphp

                <div class="alert-light border mb-4">
                    <strong>Overall Average Rating:</strong>

                    <span class="badge {{ $badgeClass }}" style="font-size:14px;">
                        {{ $avg !== null ? number_format($avg, 2) . '%' : 'N/A' }}
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
                                <th>Unique Id</th>
                                <th>Name</th>
                                <th>Mobile No.</th>
                                <th>Room</th>
                                <th>Rating Average</th>
                                <th>Comment</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $allModals = ''; @endphp

                            @forelse ($feedbacks as $index => $feedback)
                                <tr>
                                    <td>{{ $feedback->unique_id }}</td>
                                    <td>{{ $feedback->name }}</td>
                                    <td>{{ $feedback->mobile }}</td>
                                    <td>
                                        <strong>Room: {{ $feedback->rooms->name ?? '-' }}</strong>
                                        [{{ $feedback->rooms->floors->name ?? '-' }}]
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

                                    <td>
                                        <span class="comment-short">
                                            {{ Str::limit($feedback->comments, 60) }}
                                        </span>

                                        @if (strlen($feedback->comments) > 60)
                                            <span class="comment-full d-none">
                                                {{ $feedback->comments }}
                                            </span>

                                            <a href="javascript:void(0)" class="read-more text-primary fw-semibold"
                                                onclick="toggleComment(this)">
                                                Read more
                                            </a>
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
                                                            {{-- <span>{{ $feedbackData[$key] ?? 'N/A' }} /3</span> --}}
                                                            {{ array_key_exists($key, $feedbackData) && $feedbackData[$key] !== null
                                                                ? $feedbackData[$key] . ' / 3'
                                                                : 'NULL' }}
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
                                {{-- <tr>
                                    <td colspan="8" class="text-center text-muted">No feedback found.</td>
                                </tr> --}}
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
        $(document).ready(function() {
            $('#feedbackTable').DataTable();
        });
    </script>

    {{-- Move feedbacks --}}
    <script>
        function moveFeedbacks(type) {
            let checked = document.querySelectorAll('.feedback-checkbox:checked');

            if (checked.length === 0) {
                alert('Please select at least one feedbacks');
                return;
            }

            document.getElementById('moveTo').value = type;
            document.getElementById('moveForm').submit();
        }

        document.getElementById('selectAll').addEventListener('change', function() {
            document.querySelectorAll('.feedback-checkbox')
                .forEach(cb => cb.checked = this.checked);

            toggleMoveBox();
        });

        document.querySelectorAll('.feedback-checkbox')
            .forEach(cb => cb.addEventListener('change', toggleMoveBox));

        function toggleMoveBox() {
            let anyChecked = document.querySelectorAll('.feedback-checkbox:checked').length > 0;
            document.getElementById('moveActions')
                .classList.toggle('d-none', !anyChecked);
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
