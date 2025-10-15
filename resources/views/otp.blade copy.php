<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Railway Rest House Feedback</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">
            <h3 class="text-center mb-4">Railway Rest House Feedback</h3>

            <!-- OTP Form -->
            <form method="POST" action="/send-otp" class="mb-3">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Mobile Number:</label>

                    {{-- Flex row for input and button --}}
                    <div class="d-flex gap-2">
                        <input type="text" name="mobile" class="form-control" required
                            placeholder="Enter mobile number">
                        <button type="submit" class="btn btn-primary" style="font-size: 14px; width: 100px;">Send
                            OTP</button>
                    </div>

                    {{-- Messages --}}
                    @if (session('otp_sent_success'))
                        <p class="text-success mt-2">{{ session('otp_sent_success') }}</p>
                    @endif

                    @if (session('otp_sent_error'))
                        <p class="text-danger mt-2">{{ session('otp_sent_error') }}</p>
                    @endif
                </div>
            </form>

            <form method="POST" action="/verify-otp" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Enter OTP:</label>
                    <div class="d-flex gap-2">
                        <input type="text" name="otp" class="form-control" required>
                        <button type="submit" class="btn btn-success" style="font-size: 14px; width: 110px;">Verify OTP</button>
                    </div>
                    @if (session('otp_verify_success'))
                        <p class="text-success">{{ session('otp_verify_success') }}</p>
                    @endif

                    @if (session('otp_verify_error'))
                        <p class="text-danger">{{ session('otp_verify_error') }}</p>
                    @endif

                </div>
            </form>


            @php
                // Custom services array (you can replace this with DB fetch later)
                $services = [
                    'Dining Hall Feedback' => [
                        'Food Quality',
                        'Cleanliness & Hygiene & Services',
                        'Ambience & Facilities',
                    ],
                    'Suits Feedback' => ['Suits Condition', 'Bathroom & Utilities', 'Housekeeping Services'],
                    'Rest House Surroundings & Common Areas Cleanliness Feedback' => [
                        'Excellent Lighting',
                        'Comfortable',
                        'Average',
                        'Needs Improvement',
                    ],
                    'Suits Condition' => ['All Good', 'Minor Issues', 'Average', 'Bad Condition'],
                    'Bathroom & Utilities' => ['Well Equipped', 'Basic', 'Needs Repair', 'Poor'],
                    'Housekeeping Services' => ['On Time', 'Sometimes Late', 'Rarely Available', 'Not Available'],
                    'Surroundings Cleanliness' => ['Very Clean', 'Moderate', 'Average', 'Dirty'],
                    'Common Areas Cleanliness' => ['Excellent', 'Good', 'Average', 'Poor'],
                    'Housekeeping and Maintenance' => ['Responsive', 'Average', 'Slow', 'No Response'],
                ];
            @endphp

            <!-- Complaint/Feedback Form -->
            <form method="POST" action="/submit-feedback">
                @csrf
                <div class="mb-3">
                    @foreach ($services as $service => $options)
                        <div class="mb-3">
                            <label class="form-label">{{ $service }}</label>
                            <select class="form-select" name="feedback[{{ $service }}]" required>
                                <option value="">-- Select --</option>
                                @foreach ($options as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <select class="form-select" name="rating" required>
                        <option value="">-- Select Rating --</option>
                        <option value="3">Excellent (3)</option>
                        <option value="2">Good (2)</option>
                        <option value="1">Average (1)</option>
                        <option value="0">Poor (0)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Additional Comments</label>
                    <textarea class="form-control" name="comments" rows="3" placeholder="Write your feedback..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Submit Feedback</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
