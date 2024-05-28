<div class="card-body">
    <input type="text" name="id" id="" value='{{ $target->id }}' hidden>
    <div class="form-group">
        <label for="bldg-name">Building Name</label>
        <input type="text" name='building_name' id="bldg-name" class="form-control" value="{{ $target->building_name }}">
    </div>
    <div class="form-group">
        <label for="bldg-desc">Building Description</label>
        <textarea id="bldg-desc" name='building_description' class="form-control" rows="4">{{ $target->buildingDetails->building_description }}</textarea>
    </div>
</div>