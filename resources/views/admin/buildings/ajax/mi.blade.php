<div class="form-group d-flex flex-column justify-content-center align-items-center">
    <img id='mi-preview' src="{{ asset('storage/' . $target->buildingMarker->marker_image) }}" alt="{{ $target->building_name }}" class='img-thumbnail' width="150px" style='border-radius: 100%;'>
    <button type="button" id='remove-mi-btn' class='btn btn-danger btn-sm mt-2'>Remove Image</button>
    <button type="button" id='change-img-btn' class='btn btn-warning btn-sm mt-2'>Change Image</button>
    <input type="file" id='change-img-input' class='mt-3 form-control p-1' style='display: none;' name="marker_image" id="">
</div>