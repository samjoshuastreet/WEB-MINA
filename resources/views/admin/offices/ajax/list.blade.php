@forelse($offices as $office)
<tr>
    <td class='d-flex justify-content-center'>
        <img src="{{ asset('storage/' . $office->office_image) }}" class='img-thumbnail rounded' alt="" width="150px">
    </td>
    <td>{{ $office->office_name }}</td>
    <td>{{ $office->building->building_name }}</td>
    <td><span class='badge {{ $office->badgeColor() }}'>{{ ucfirst($office->status) }}</span></td>
    <td>
        <button data-id='{{ $office->id }}' class='btn btn-sm btn-warning' type="button">Edit</button>
        <button data-id='{{ $office->id }}' class='del-btn btn btn-sm btn-danger' type="button">Delete</button>
    </td>
</tr>
@empty
<tr>
    <td colspan="4" class="text-center">No Records Found</td>
</tr>
@endforelse