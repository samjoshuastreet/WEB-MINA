@forelse($types as $type)
<tr>
    <td class="text-bold">{{ $loop->iteration }}</td>
    <td>{{ $type->name }}</td>
    <td style="background-color: {{ $type->color }};" class="text-center text-bold">{{ $type->color }}</td>
    <td>{{ $type->name }}</td>
    <td>
        <a href="" class="btn btn-sm btn-warning ml-1">Edit</a>
        <a data-id="{{ $type->id }}" class="btn btn-sm btn-danger ml-1 delete-types-btn">Delete</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">No Records Found</td>
</tr>
@endforelse