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
@endphp


<span class="badge {{ $badgeClass }}" style="font-size: 14px; padding: 5px;"
      data-bs-toggle="modal" data-bs-target="#ratingModal{{ $feedback->id }}">
    {{ number_format($rating, 2) }}%
</span>
<strong class="text-muted">({{ $label }})</strong>


@php
    $data = json_decode($feedback->feedback_data, true) ?? [];
@endphp

<!-- Rating Modal -->
<div class="modal fade" id="ratingModal{{ $feedback->id }}" tabindex="-1"
     aria-labelledby="ratingModalLabel{{ $feedback->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Feedback Ratings ({{ $feedback->name }})</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach ($ratingModel as $key => $max)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-capitalize">{{ str_replace('_', ' ', $key) }}</span>
                            <span>
                                {{ $data[$key] ?? 'N/A' }} / {{ $max }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
 