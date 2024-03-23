@extends('admin.layouts.layout')
@section('title', 'Path Manager')
@section('more_links')
<style>

</style>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manange Paths</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Paths</a></li>
                        <li class="breadcrumb-item active">Admin</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('paths.add') }}"><button type="button" class="btn btn-primary btn-md mb-3">Add a Path</button></a>
                                <a href="{{ route('paths.edit') }}"><button type="button" class="btn btn-primary btn-md mb-3 ml-1">Path Editor</button></a>
                                <button id="view-modal-btn" type="button" class="btn btn-warning btn-md mb-3 ml-1" data-toggle="modal" data-target="#view-modal">View Map</button>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">Path ID</th>
                                        <th style="width: 16%;">Waypoint A Code Name</th>
                                        <th style="width: 16%;">Waypoint A Coordinates</th>
                                        <th style="width: 16%;">Waypoint B Code Name</th>
                                        <th style="width: 16%;">Waypoint B Coordinates</th>
                                        <td style="width: 16%;">Distance</td>
                                        <th style="width: 15%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="building-list">
                                    @include('admin.paths.ajax.path_list')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="view-modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add a Building</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @csrf
            <div class="modal-body">
                <div id="map" style="width: 100%; height: 400px;"></div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection
@section('more_scripts')
<script>
    // Initializing Map
    mapboxgl.accessToken = 'pk.eyJ1Ijoic2Ftc3RyZWV0IiwiYSI6ImNsczRxb29mdTE1ZmkybHBjcHBhcG9xN2kifQ.SpJ2sxffT8PRfQjFtYgg6Q';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/samstreet/clto5jp0h01cg01ptc2idfbdk',
        zoom: 17,
        minZoom: 16,
        center: [124.2438547179179, 8.2414298468554],
        bearing: -95,
        maxBounds: [
            [124.23616973647256, 8.233619024568284], // Southwest bound
            [124.25301604017682, 8.248537110726303] // Northeast bound
        ]
    });
</script>
@endsection