<div class="row">
    @forelse($events as $event)
    <div class="col-xl-4 col-sm-6">
        <div class="card" style="height: 450px;">
            <div class="card-body" style="height: 100%;">
                <div class="d-flex" style="height: 100%;">
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="text-truncate text-center text-bold font-size-15"><a href="javascript: void(0);" class="text-dark">{{ $event->event_name }}</a></h5>
                        <hr>
                        <p class="text-muted text-justify mb-4" style="text-indent: 1.50rem;">{{ $event->event_description }}</p>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 border-top">
                <ul class="list-inline mb-0 d-flex justify-content-between">
                    <li class="list-inline-item me-3">
                        <span style="pointer-events:none;" class="btn btn-xs font-bold {{ $event->access_level == '1' ? 'btn-outline-primary' : ($event->access_level == '2' ? 'btn-outline-success' : 'btn-outline-warning') }}">{{ $event->accessLevel() }} Access</span>
                    </li>
                    <div>
                        <li class=" list-inline-item me-3">
                            <span class="btn btn-sm btn-danger">Delete</span>
                        </li>
                        <li class="list-inline-item me-3">
                            <span class="btn btn-sm btn-primary">View</span>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
    </div>
    @empty
    @endforelse
</div>