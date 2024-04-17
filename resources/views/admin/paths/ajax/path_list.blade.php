@forelse($paths as $path)
<tr>
    <td style="width: 5%;">{{ $path->id }}</td>
    <td style="width: 16%;">{{ $path->wp_a_code }}</td>
    <td style="width: 16%;"><span class="badge bg-primary">{{ $path->wp_a_lng }}</span> <span class="badge bg-success">{{ $path->wp_a_lat }}</span></td>
    <td style="width: 16%;">{{ $path->wp_b_code }}</td>
    <td style="width: 16%;"><span class="badge bg-primary">{{ $path->wp_b_lng }}</span> <span class="badge bg-success">{{ $path->wp_b_lat }}</span></td>
    <td style="width: 16%;">{{ $path->weight }} km</td>
    <td style="width: 15%;">
        <div class="d-flex">
            <a href="" class="btn btn-sm btn-outline-dark">View</a>
            <a href="" class="btn btn-sm btn-outline-warning ml-1">Edit</a>
            <a data-id="" class="btn btn-sm btn-outline-danger ml-1 delete-building-btn">Delete</a>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center">No Records Found</td>
</tr>
@endforelse