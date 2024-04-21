@forelse($feedback_reports as $report)
<tr>
    <td>
        {{ $loop->iteration }}
    </td>
    <td>
        {{ $report->name }}
    </td>
    <td>
        {{ $report->message }}
    </td>
    <td class="text-center">
        <div class="rounded {{ $report->status == 'New' ? 'bg-primary' : ($report->status == 'In Progress' ? 'bg-warning' : ($report->status == 'Paused' ? 'bg-danger' : 'bg-success')) }}">{{ $report->status }}</div>
    </td>
    <td class="text-center">
        @if($report->status == 'New')
        <a data-id="{{ $report->id }}" class="begin-btn btn btn-sm btn-outline-dark">Begin</a>
        @elseif($report->status == 'Paused')
        <a data-id="{{ $report->id }}" class="begin-btn btn btn-sm btn-outline-dark">Resume</a>
        <a data-id="{{ $report->id }}" class="delete-btn btn btn-sm btn-outline-danger ml-1 delete-building-btn">Delete</a>
        @elseif($report->status == 'Resolved')
        <a data-id="{{ $report->id }}" class="delete-btn btn btn-sm btn-outline-danger ml-1 delete-building-btn">Delete</a>
        @else
        <a data-id="{{ $report->id }}" class="pause-btn btn btn-sm btn-outline-dark">Pause</a>
        <a data-id="{{ $report->id }}" class="resolve-btn btn btn-sm btn-outline-success ml-1">Resolve</a>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">No Records Found</td>
</tr>
@endforelse