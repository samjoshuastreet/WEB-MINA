@extends('admin.layouts.layout')
@section('title', 'Add Building')
@section('more_links')
<link href="https://api.mapbox.com/mapbox-gl-js/v3.2.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.2.0/mapbox-gl.js"></script>
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/toastr/toastr.min.css') }}">
<style>
    #longitude-table:focus {
        outline: none;
        border: none;
    }
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <div>
        <div class="container-fluid" style="position: relative;">
            <div class="row">
                <div id="map" style="height: 100vh; width: 100vw;"></div>
            </div>
            <div id="coordinates-cont" class="bg-light rounded mt-4 ml-4 p-2 d-flex justify-content-center align-items-center border" style="position: absolute; visibility: hidden; z-index: 2; top: 0; left: 0;">
                <small class="m-0 mr-2">Coordinates: <span id="coordinates-lat" class="text-success"></span>, <span id="coordinates-long" class="text-info"></span></small>
                <button id="save-coordinates-btn" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add-modal">Save</button>
                <button id="cancel-coordinates-btn" type="button" class="btn btn-sm btn-danger ml-1">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- MODALS -->
<div class="modal fade" id="add-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add a Building</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="building-add-form">
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="font-weight-bold" style="width: 20%">Latitude</td>
                                <td>
                                    <input type="text" name="latitude" id="latitude-table" style="border: none;" onmouseover="this.style.cursor='context-menu'" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold" style="width: 25%">Longitude</td>
                                <td>
                                    <input type="text" name="longitude" id="longitude-table" style="border: none;" onmouseover="this.style.cursor='context-menu'" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold" style="width: 25%">Name</td>
                                <td>
                                    <input type="text" name="building_name" id="building_name" placeholder="Enter a name" style="border: none; width: 100%;">
                                    <small id="building_name_error" class="text-danger field_errors"></small>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold" style="width: 25%">Marker Image</td>
                                <td>
                                    <input type="file" name="marker_image" id="marker_image-table">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection
@section('more_scripts')
<script src="{{ asset('assets/admin/plugins/sweetalert2/sweetalert2.min.js') }}">
</script>
<script src="{{ asset('assets/admin/plugins/toastr/toastr.min.js') }}"></script>
<script>
    // Initializing Sweet Alert Toastr
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

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
    loadMarkers();

    // Loading Markers
    function loadMarkers() {
        $.ajax({
            url: '{{ route("buildings.get") }}',
            data: '',
            success: function(data) {
                data.buildings.forEach(function(building) {
                    var coordinates = [building.longitude, building.latitude];
                    var marker = new mapboxgl.Marker()
                        .setLngLat(coordinates)
                        .setPopup(new mapboxgl.Popup().setHTML('<h3>' + building.building_name + '</h3>'))
                        .addTo(map);
                });
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    var marker;
    var coordinatesCont = document.getElementById('coordinates-cont');
    var saveBtn = document.getElementById('save-coordinates-btn');
    var cancelBtn = document.getElementById('cancel-coordinates-btn');
    var latCoordinate = document.getElementById('coordinates-lat');
    var longCoordinate = document.getElementById('coordinates-long');

    function clear_validations() {
        $(document).find('.field_errors').text('');
    }

    function printValidationErrorMsg(msg) {
        clear_validations();
        $.each(msg, function(field_name, error) {
            $(document).find('#' + field_name + '_error').text(error);
        });
    }

    cancelBtn.addEventListener('click', function() {
        marker.remove();
        coordinatesCont.style.visibility = 'hidden';
    });

    saveBtn.addEventListener('click', function() {
        document.getElementById('latitude-table').value = latCoordinate.innerText;
        document.getElementById('longitude-table').value = longCoordinate.innerText;
    });

    map.on('click', function(e) {
        // Remove the existing marker if it exists
        if (marker) {
            marker.remove();
        }

        // Create a new marker at the clicked location
        marker = new mapboxgl.Marker()
            .setLngLat(e.lngLat)
            .addTo(map);

        const [lng, lat] = e.lngLat.toArray();
        latCoordinate.innerText = `${lat}`;
        longCoordinate.innerText = `${lng}`;

        coordinatesCont.style.visibility = 'visible';
    });

    $('#building-add-form').submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: '{{ route("buildings.add.submit") }}',
            data: formData,
            success: function(data) {
                if (data.success == true) {
                    $('#building-add-form')[0].reset();
                    $('#add-modal').modal('toggle');
                    Toast.fire({
                        icon: 'success',
                        title: data.new_building + ' has been added successfully!'
                    })
                    marker.remove();
                    clear_validations();
                    coordinatesCont.style.visibility = 'hidden';
                    loadMarkers();
                } else if (data.success == false) {
                    printValidationErrorMsg(data.msg);
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
</script>
@endsection