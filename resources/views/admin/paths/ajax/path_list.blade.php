@forelse($paths as $path)
<tr>
    <td style="width: 5%;">{{ $path->id }}</td>
    <td style="width: 16%;">{{ $path->wp_a_code }}</td>
    <td style="width: 16%;"><span class="badge bg-primary">{{ $path->wp_a_lng }}</span> <span class="badge bg-success">{{ $path->wp_a_lat }}</span></td>
    <td style="width: 16%;">{{ $path->wp_b_code }}</td>
    <td style="width: 16%;"><span class="badge bg-primary">{{ $path->wp_b_lng }}</span> <span class="badge bg-success">{{ $path->wp_b_lat }}</span></td>
    <td style="width: 16%;">{{ $path->weight }} km</td>
    <td>
        @if($path->type =='disabled')
        <button data-id='{{ $path->id }}' class="enable-btn btn btn-sm btn-success">Enable</button>
        @else
        <button data-id='{{ $path->id }}' class="disable-btn btn btn-sm btn-danger">Disable</button>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center">No Records Found</td>
</tr>
@endforelse