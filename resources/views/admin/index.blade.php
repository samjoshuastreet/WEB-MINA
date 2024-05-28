@extends('admin.layouts.layout')
@section('title', 'Admin - Dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Map View</h3>
                        </div>
                        <div class="card-body" style='height: 300px; width: 100%;'>
                            <div id="map" style='height: 100%; width: 100%;'></div>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Map Elements and Procedures</h3>
                                </div>
                                <div class="card-body">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1"><i class="fa fa-building"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Number of Buildings</span>
                                            <span class="info-box-number">
                                                {{ $building_count }}
                                                <small>buildings</small>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-door-open"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Number of Offices</span>
                                            <span class="info-box-number">
                                                {{ $office_count }}
                                                <small>offices</small>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="info-box">
                                        <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-road"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Number of Paths</span>
                                            <span class="info-box-number">
                                                {{ $path_count }}
                                                <small>created paths</small>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="info-box">
                                        <span class="info-box-icon bg-dark elevation-1"><i class="fas fa-route"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Number of Procedures</span>
                                            <span class="info-box-number">
                                                {{ $procedure_count }}
                                                <small>procedures</small>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">Events</h3>
                                </div>
                                <div class="card-body">
                                    <h6>On Going Events</h6>
                                    <ul class="products-list product-list-in-card pl-2 pr-2 shadow-lg rounded-lg">
                                        @forelse($onGoingEvents as $event)
                                        <li class="item">
                                            <div class="product-img">
                                                <img src="{{ asset('storage/' . $event->building->buildingMarker->marker_image) }}" alt="Product Image" class="img-size-50">
                                            </div>
                                            <div class="product-info">
                                                <a href="javascript:void(0)" class="product-title">{{ $event->event_name }}</a>
                                                <br>
                                                <a class="badge badge-success">{{ $event->building->building_name }}</a>
                                                <span class="product-description">
                                                    {{ $event->event_description }}
                                                </span>
                                            </div>
                                        </li>
                                        @empty
                                        <li class="item">
                                            <span class="text-muted">There are currently no on going events.</span>
                                        </li>
                                        @endforelse
                                        @if(count($onGoingEvents) === 3)
                                        <li class='item text-center'><a href="{{ route('events.index') }}">See all</a></li>
                                        @endif
                                    </ul>
                                    <hr>
                                    <h6>Upcoming Events</h6>
                                    <ul class="products-list product-list-in-card pl-2 pr-2 shadow-lg rounded-lg">
                                        @forelse($upcomingEvents as $event)
                                        <li class="item">
                                            <div class="product-img">
                                                <img src="{{ asset('storage/' . $event->building->buildingMarker->marker_image) }}" alt="Product Image" class="img-size-50">
                                            </div>
                                            <div class="product-info">
                                                <a href="javascript:void(0)" class="product-title">{{ $event->event_name }}</a>
                                                <br>
                                                <a class="badge badge-warning">{{ $event->building->building_name }}</a>
                                                <span class="product-description">
                                                    {{ $event->event_description }}
                                                </span>
                                            </div>
                                        </li>
                                        @empty
                                        <li class="item">
                                            <span class="text-muted">There are currently no on going events.</span>
                                        </li>
                                        @endforelse
                                        @if(count($upcomingEvents) === 3)
                                        <li class='item text-center'><a href="{{ route('events.index') }}">See all</a></li>
                                        @endif
                                    </ul>
                                    <hr>
                                    <h6>Ended Events</h6>
                                    <ul class="products-list product-list-in-card pl-2 pr-2 shadow-lg rounded-lg">
                                        @forelse($endedEvents as $event)
                                        <li class="item">
                                            <div class="product-img">
                                                <img src="{{ asset('storage/' . $event->building->buildingMarker->marker_image) }}" alt="Product Image" class="img-size-50">
                                            </div>
                                            <div class="product-info">
                                                <a href="javascript:void(0)" class="product-title">{{ $event->event_name }}</a>
                                                <br>
                                                <a class="badge badge-danger">{{ $event->building->building_name }}</a>
                                                <span class="product-description">
                                                    {{ $event->event_description }}
                                                </span>
                                            </div>
                                        </li>
                                        @empty
                                        <li class="item">
                                            <span class="text-muted">There are currently no on going events.</span>
                                        </li>
                                        @endforelse
                                        @if(count($endedEvents) === 3)
                                        <li class='item text-center'><a href="{{ route('events.index') }}">See all</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h3 class="card-title">Feedbacks</h3>
                                </div>
                                <div class="card-body">
                                    <div class="info-box mb-3 bg-primary">
                                        <span class="info-box-icon"><i class="fas fa-envelope"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">New</span>
                                            <span class="info-box-number">{{ $fIP }}</span>
                                        </div>
                                    </div>
                                    <div class="info-box mb-3 bg-warning">
                                        <span class="info-box-icon"><i class="fas fa-spinner"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Pending</span>
                                            <span class="info-box-number">{{ $fp }}</span>
                                        </div>
                                    </div>
                                    <div class="info-box mb-3 bg-dark">
                                        <span class="info-box-icon"><i class="fas fa-pause"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Paused</span>
                                            <span class="info-box-number">{{ $fr }}</span>
                                        </div>
                                    </div>
                                    <div class="info-box mb-3 bg-success">
                                        <span class="info-box-icon"><i class="fas fa-check"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Resolved</span>
                                            <span class="info-box-number">{{ $fn }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('more_scripts')
<script>
    $(document).ready(function() {
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2Ftc3RyZWV0IiwiYSI6ImNsczRxb29mdTE1ZmkybHBjcHBhcG9xN2kifQ.SpJ2sxffT8PRfQjFtYgg6Q';
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/samstreet/clu2rl1ub024601oigzn6960q',
            zoom: 16.30,
            minZoom: 16.30,
            maxZoom: 17,
            center: [124.2438547179179, 8.2414298468554],
            bearing: -95,
            pitch: 45,
            maxBounds: [
                [124.23616973647256, 8.233619024568284], // Southwest bound
                [124.25301604017682, 8.248537110726303] // Northeast bound
            ],
            interactive: false
        });
        map.on('style.load', function() {
            $.ajax({
                url: '{{ route("buildings.get") }}',
                data: {
                    'boundary': true
                },
                success: function(response) {
                    var boundaries = response.boundaries;
                    boundaries.forEach(boundary => {
                        const fillColor = boundary.building_details.color;
                        var temp = JSON.parse(boundary.corners);
                        var boundaryCoordinates = [];
                        for (let key in temp) {
                            if (temp.hasOwnProperty(key)) {
                                boundaryCoordinates.push([temp[key].lng, temp[key].lat]);
                            }
                        }
                        map.addLayer({
                            id: `polygon-display-${boundary.id}`,
                            type: 'fill-extrusion',
                            source: {
                                type: 'geojson',
                                data: {
                                    type: 'Feature',
                                    geometry: {
                                        type: 'Polygon',
                                        coordinates: [boundaryCoordinates]
                                    }
                                }
                            },
                            layout: {},
                            paint: {
                                'fill-extrusion-color': fillColor,
                                'fill-extrusion-height': 4,
                                'fill-extrusion-opacity': 0.8
                            }
                        }, 'boundary-latest-19j3o8');
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            })
        })
    });
</script>
@endsection