
<div class="container">
    <h2>Cleaning Feedback Form - Railway Officers Rest House</h2>
    <form method="POST" action="">
        @csrf

        <div class="mb-3">
            <label>Occupant Name</label>
            <input type="text" name="occupant_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mobile No.</label>
            <input type="text" name="mobile_no" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Room No.</label>
            <input type="text" name="room_no" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Date of Occupancy</label>
            <input type="date" name="date_of_occupancy" class="form-control" required>
        </div>

        <hr>
        <h5>Rate Each Section (0=Poor, 1=Average, 2=Good, 3=Excellent)</h5>

        @php
            $fields = [
                'food_quality' => 'Taste of food & variety of dishes',
                'utensil_hygiene' => 'Cleanliness & hygiene of utensils',
                'ambience' => 'Seating & lighting arrangements',
                'suit_condition' => 'Cleanliness of room, linen, ACs, etc.',
                'bathroom_utilities' => 'Cleanliness & toiletries availability',
                'housekeeping_service' => 'Timeliness of housekeeping',
                'surroundings_cleanliness' => 'Cleanliness of outdoor surroundings',
                'common_area_cleanliness' => 'Corridors, lounge, lobby, reception',
                'dustbin_condition' => 'Dustbins & waste management',
                'cleaning_frequency' => 'Cleaning frequency & staff availability',
                'complaint_response' => 'Responsiveness to complaints',
            ];
        @endphp

        @foreach($fields as $key => $label)
            <div class="mb-3">
                <label>{{ $label }}</label>
                <select name="{{ $key }}" class="form-control" required>
                    <option value="">--Select Rating--</option>
                    <option value="3">3 - Excellent</option>
                    <option value="2">2 - Good</option>
                    <option value="1">1 - Average</option>
                    <option value="0">0 - Poor</option>
                </select>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Submit Feedback</button>
    </form>
</div>

{{-- ==  Second Format --}}

<form method="POST" action="">
                @csrf

                <div class="mb-3">
                    <label>Occupant Name</label>
                    <input type="text" name="occupant_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Mobile No.</label>
                    <input type="text" name="mobile_no" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Room No.</label>
                    <input type="text" name="room_no" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Date of Occupancy</label>
                    <input type="date" name="date_of_occupancy" class="form-control" required>
                </div>

                <hr>
                <h5>Rate Each Section (0=Poor, 1=Average, 2=Good, 3=Excellent)</h5>

                @php
                    $fields = [
                        'food_quality' => 'Taste of food & variety of dishes',
                        'utensil_hygiene' => 'Cleanliness & hygiene of utensils',
                        'ambience' => 'Seating & lighting arrangements',
                        'suit_condition' => 'Cleanliness of room, linen, ACs, etc.',
                        'bathroom_utilities' => 'Cleanliness & toiletries availability',
                        'housekeeping_service' => 'Timeliness of housekeeping',
                        'surroundings_cleanliness' => 'Cleanliness of outdoor surroundings',
                        'common_area_cleanliness' => 'Corridors, lounge, lobby, reception',
                        'dustbin_condition' => 'Dustbins & waste management',
                        'cleaning_frequency' => 'Cleaning frequency & staff availability',
                        'complaint_response' => 'Responsiveness to complaints',
                    ];
                @endphp

                @foreach ($fields as $key => $label)
                    <div class="mb-3">
                        <label>{{ $label }}</label>
                        <select name="{{ $key }}" class="form-control" required>
                            <option value="">--Select Rating--</option>
                            <option value="3">3 - Excellent</option>
                            <option value="2">2 - Good</option>
                            <option value="1">1 - Average</option>
                            <option value="0">0 - Poor</option>
                        </select>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-primary">Submit Feedback</button>
            </form>
