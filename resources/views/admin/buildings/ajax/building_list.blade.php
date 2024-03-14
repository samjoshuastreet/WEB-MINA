@forelse($buildings as $building)
<tr>
    <td style="width: 15%;">
        @if($building->marker_photo !== NULL)
        <img src="{{ asset('storage/' . $building->marker_photo) }}" alt="" width="100%" class="rounded">
        @else
        <img src="{{ asset('assets/images/users/user-default.jpg') }}" alt="" width="100%" class="rounded">
        @endif
    </td>
    <td style="width: 30%;">{{ $building->building_name }}</td>
    <td style="width: 20%;"><span class="badge bg-primary">{{ $building->longitude }}</span></td>
    <td style="width: 20%;"><span class="badge bg-success">{{ $building->latitude }}</span></td>
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
    <td colspan="5" class="text-center">No Records Found</td>
</tr>
@endforelse