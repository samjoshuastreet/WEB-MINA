<div class="form-group">
    <input id='b-type-id' hidden value='{{ $target->buildingDetails->buildingType->id }}'>
    <input id='b-id' name='id' hidden value='{{ $target->id }}'>
    <label for="inputEstimatedBudget">Building Type</label>
    <select type="number" id="b-type-select" name='type' class="form-control">
        @forelse($types as $type)
        <option value="{{ $type->id }}">{{ $type->name }}</option>
        @empty
        <option value=0>No Records Found</option>
        @endforelse
    </select>
</div>
<div class="form-group">
    <label for="inputSpentBudget">Building Color</label>
    <div style='width: 30%;'>
        <svg id='bldg-icon' xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
        </svg>
    </div>
</div>