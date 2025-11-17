<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Railway Rest House Feedback</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">
            <h3 class="text-center">Railway Rest House Feedback/Complaint</h3>
            <h4 class="text-center mb-4">[{{ $building->name }}]</h4>

            <!-- OTP Form -->
            <form method="POST" action="/send-otp" class="mb-3">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Mobile Number:</label>
                    <div class="d-flex gap-2">
                        <input type="text" name="mobile" id="mobile" class="form-control" required
                            placeholder="Enter mobile number" maxlength="10" pattern="\d{10}" inputmode="numeric">
                        <button type="submit" class="btn btn-primary" style="font-size: 14px; width: 100px;">Send
                            OTP</button>
                    </div>

                    @if (session('otp_sent_success'))
                        <p class="text-success mt-2">{{ session('otp_sent_success') }}</p>
                    @endif
                    @if (session('otp_sent_error'))
                        <p class="text-danger mt-2">{{ session('otp_sent_error') }}</p>
                    @endif
                </div>
            </form>

            <!-- Verify OTP -->
            <form method="POST" action="/verify-otp" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Enter OTP:</label>
                    <div class="d-flex gap-2">
                        <input type="text" name="otp" class="form-control" required>
                        <button type="submit" class="btn btn-success" style="font-size: 14px; width: 110px;">Verify
                            OTP</button>
                    </div>
                    @if (session('otp_verify_success'))
                        <p class="text-success">{{ session('otp_verify_success') }}</p>
                    @endif
                    @if (session('otp_verify_error'))
                        <p class="text-danger">{{ session('otp_verify_error') }}</p>
                    @endif
                </div>
            </form>

            <!-- Section shown only AFTER OTP verify -->
            @if (session('otp_verify_success'))
                <div id="post-otp-section">

                    <!-- Radio buttons -->
                    <div class="mb-3">
                        <label class="form-label">Choose Type:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="feedbackRadio"
                                value="feedback">
                            <label class="form-check-label" for="feedbackRadio">Feedback</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="complaintRadio"
                                value="complaint">
                            <label class="form-check-label" for="complaintRadio">Complaint</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="trackRadio"
                                value="track">
                            <label class="form-check-label" for="trackRadio">Track Complaint</label>
                        </div>
                    </div>

                    <!-- Feedback Form (hidden by default) -->
                    <div id="feedbackForm" class="d-none">
                        <form method="POST" action="/submit-feedback" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="mobile" value="{{ session('mobile') }}">
                            <input type="hidden" name="type" value="feedback">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Your Name"
                                    required>
                            </div>

                            {{-- <div class="mb-3">
                                <label class="form-label">Room</label>
                                <select name="room" class="form-select select2" required>
                                    <option value="">-- Select Room --</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}
                                            [{{ $room->floors->name }}] [{{ $room->buildings->name }}]
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="mb-3">
                                <label class="form-label">Room</label>
                                <select name="room" class="form-select select2" required>
                                    <option value="">-- Select Room --</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">
                                            {{ $room->name }} [{{ $room->floors->name }}]
                                            [{{ $room->buildings->name }}]
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- @php
                            $fields = [
                                'food_quality' => 'Food Quality',
                                'hygiene_services' => 'Cleanliness & Hygiene & Services',
                                'ambience' => 'Ambience & Facilities',
                                'suit_condition' => 'Suits Condition    ',
                                'bathroom_utilities' => 'Bathroom & Utinues',
                                'housekeeping_service' => 'Housekeeping Services',
                                'surroundings_cleanliness' => 'Surroundings Cleanliness',
                                'common_area_cleanliness' => 'Common Areas Cleanliness',
                                'dustbin_condition' => 'Housekeeping ar d Maintenance',
                            ];
                        @endphp

                        @foreach ($fields as $key => $label)
                            <div class="mb-3">
                                <label>{{ $label }}</label>
                                <select name="feedback_data[{{ $key }}]" class="form-control">
                                    <option value="">--Select Rating--</option>
                                    <option value="3">3 - Excellent</option>
                                    <option value="2">2 - Good</option>
                                    <option value="1">1 - Average</option>
                                    <option value="0">0 - Poor</option>
                                </select>
                            </div>
                        @endforeach --}}

                            @php
                                $feedbackSections = [
                                    'A. Dining Hall Feedback' => [
                                        'food_quality' => 'Food Quality',
                                        'hygiene_services' => 'Cleanliness & Hygiene & Services',
                                        'ambience' => 'Ambience & Facilities',
                                    ],
                                    'B. Suits Condition' => [
                                        'suit_condition' => 'Suits Condition',
                                        'bathroom_utilities' => 'Bathroom & Utilities',
                                        'housekeeping_service' => 'Housekeeping Services',
                                    ],
                                    'C. Rest House Surroundings & Common Areas Cleanliness Feedback' => [
                                        'surroundings_cleanliness' => 'Surroundings Cleanliness',
                                        'common_area_cleanliness' => 'Common Areas Cleanliness',
                                        'dustbin_condition' => 'Dustbin & Waste Management',
                                        'frequency_availability' => 'Frequency & Availability',
                                        'responsiveness' => 'Responsiveness',
                                    ],
                                ];
                            @endphp

                            @foreach ($feedbackSections as $sectionTitle => $fields)
                                <h6 class="mt-4"><strong>{{ $sectionTitle }}</strong></h6>
                                @foreach ($fields as $key => $label)
                                    <div class="mb-3">
                                        <label>{{ $label }}</label>
                                        <select name="feedback_data[{{ $key }}]" class="form-control">
                                            <option value="">--Select Rating--</option>
                                            <option value="3">3 - Excellent</option>
                                            <option value="2">2 - Good</option>
                                            <option value="1">1 - Average</option>
                                            <option value="0">0 - Poor</option>
                                        </select>
                                    </div>
                                @endforeach
                            @endforeach

                            <div class="mb-3">
                                <label class="form-label">Additional Comments</label>
                                <textarea class="form-control" name="comments" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <input type="file" class="form-control" name="document[]" multiple>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Submit Feedback</button>
                        </form>
                    </div>

                    <!-- Complaint Form (hidden by default) -->
                    <div id="complaintForm" class="d-none">
                        <form method="POST" action="/submit-feedback" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="mobile" value="{{ session('mobile') }}">
                            <input type="hidden" name="type" value="complaint">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Enter Your Name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Room</label>
                                <select name="room" class="form-select select2" required>
                                    <option value="">-- Select Room --</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}
                                            [{{ $room->floors->name }}] [{{ $room->buildings->name }}]
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Complaint Type</label>
                                <select name="complaint_type" class="form-select" required>
                                    <option value="">-- Select Complaint --</option>
                                    @foreach ($users as $user)
                                        @if ($user->departments)
                                            <option value="{{ $user->id }}">
                                                {{ $user->departments->name ?? null }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Complaint Details</label>
                                <textarea class="form-control" name="complaint_details" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <input type="file" class="form-control" name="document[]" multiple>
                            </div>

                            <button type="submit" class="btn btn-danger w-100">Submit Complaint</button>
                        </form>
                    </div>

                    <!-- Track Form (hidden by default) -->
                    <div id="trackForm" class="d-none">
                        <form method="POST" action="/track-complaint">
                            @csrf
                            <input type="hidden" name="mobile" value="{{ session('mobile') }}">

                            <div class="mb-3">
                                <label class="form-label">Enter Mobile or Complaint ID</label>
                                <input type="text" name="track_input" class="form-control"
                                    placeholder="Enter Mobile or Complaint ID" required>
                            </div>

                            <button type="submit" class="btn btn-info w-100">Track Status</button>
                        </form>
                    </div>

                </div>
            @endif

            @if (session('track_status'))
                <div class="alert {{ session('track_alert_class') }} mt-3">
                    {{ session('track_status') }}
                </div>
            @endif

            @if (session('track_error'))
                <div class="alert alert-danger mt-3">
                    {{ session('track_error') }}
                </div>
            @endif

            <!-- ✅ Success / Error Messages (after form submit) -->
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <!-- jQuery (required by Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const feedbackRadio = document.getElementById('feedbackRadio');
            const complaintRadio = document.getElementById('complaintRadio');
            const feedbackForm = document.getElementById('feedbackForm');
            const complaintForm = document.getElementById('complaintForm');

            if (feedbackRadio && complaintRadio) {
                feedbackRadio.addEventListener('change', function() {
                    if (this.checked) {
                        feedbackForm.classList.remove('d-none');
                        complaintForm.classList.add('d-none');
                    }
                });

                complaintRadio.addEventListener('change', function() {
                    if (this.checked) {
                        complaintForm.classList.remove('d-none');
                        feedbackForm.classList.add('d-none');
                    }
                });
            }
        });
    </script> --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const feedbackRadio = document.getElementById('feedbackRadio');
            const complaintRadio = document.getElementById('complaintRadio');
            const trackRadio = document.getElementById('trackRadio');

            const feedbackForm = document.getElementById('feedbackForm');
            const complaintForm = document.getElementById('complaintForm');
            const trackForm = document.getElementById('trackForm');

            function hideAll() {
                feedbackForm.classList.add('d-none');
                complaintForm.classList.add('d-none');
                trackForm.classList.add('d-none');
            }

            feedbackRadio.addEventListener('change', function() {
                hideAll();
                feedbackForm.classList.remove('d-none');
            });

            complaintRadio.addEventListener('change', function() {
                hideAll();
                complaintForm.classList.remove('d-none');
            });

            trackRadio.addEventListener('change', function() {
                hideAll();
                trackForm.classList.remove('d-none');
            });

        });
    </script>

    <script>
        document.getElementById('mobile').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "-- Select Room --",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
</body>

</html>
