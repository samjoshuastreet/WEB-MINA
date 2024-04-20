@forelse($buildings as $building)
<tr>
    <td>
        @if($building->buildingMarker->marker_image !== NULL)
        <img src="{{ asset('storage/' . $building->buildingMarker->marker_image) }}" alt="" width="100%" class="rounded">
        @else
        <img src="{{ asset('assets/images/users/user-default.jpg') }}" alt="" width="100%" class="rounded">
        @endif
    </td>
    <td>{{ $building->building_name }}</td>
    <td> <span class="badge" style="background-color: {{ $building->buildingDetails->buildingType->color }}">{{ $building->buildingDetails->buildingType->name }}</span></td>
    <td>
        @if($building->status == 'active')
        <span class="badge bg-success">{{ ucfirst($building->status) }}</span>
        @elseif($building->status == 'inactive')
        <span class="badge bg-warning">{{ ucfirst($building->status) }}</span>
        @endif
    </td>
    <td>
        @if($building->connection_count > 0)
        <span class="badge bg-success">{{ $building->connection_count }}</span>
        @else
        <span class="badge bg-warning">0</span>
        @endif
    </td>
    <td>
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