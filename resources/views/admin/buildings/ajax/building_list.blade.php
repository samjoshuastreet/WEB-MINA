@forelse($buildings as $building)
<tr>
    <td style="width: 15%;">
        @if($building->buildingMarker->marker_image !== NULL)
        <img src="{{ asset('storage/' . $building->buildingMarker->marker_image) }}" alt="" width="100%" class="rounded">
        @else
        <img src="{{ asset('assets/images/users/user-default.jpg') }}" alt="" width="100%" class="rounded">
        @endif
    </td>
    <td style="width: 20%;">{{ $building->building_name }}</td>
    <td style="width: 30%;">@if(isset($building->buildingDetails->building_description)){{ $building->buildingDetails->building_description }}@endif</td>
    <td style="width: 10%;">
        @if($building->status == 'active')
        <span class="badge bg-success">{{ ucfirst($building->status) }}</span>
        @elseif($building->status == 'inactive')
        <span class="badge bg-warning">{{ ucfirst($building->status) }}</span>
        @endif
    </td>
    <td style="width: 10%;">
        @if($building->connection_count > 0)
        <span class="badge bg-success">{{ $building->connection_count }}</span>
        @else
        <span class="badge bg-warning">0</span>
        @endif
    </td>
    <td style="width: 15%;">
        <div class="d-flex">
            <a href="{{ route('buildings.view', ['id' => $building->id]) }}" class="btn btn-sm btn-outline-dark">View</a>
            <a href="{{ route('buildings.edit', ['id' => $building->id]) }}" class="btn btn-sm btn-outline-warning ml-1">Edit</a>
            <a data-id="{{ $building->id }}" class="btn btn-sm btn-outline-danger ml-1 delete-building-btn">Delete</a>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">No Records Found</td>
</tr>
@endforelse