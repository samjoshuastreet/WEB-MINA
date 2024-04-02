@extends('admin.layouts.layout')
@section('title', 'Add Building')
@section('more_links')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/cropperjs/cropper.min.css') }}" />
<style>
    .marker {
        background-image: url('{{ asset("assets/logos/logo-only.png") }}');
        background-size: cover;
        width: 30px;
        height: 30px;
        border-radius: 100%;
        cursor: pointer;
    }

    .display-marker {
        background-image: url('{{ asset("assets/logos/logo-only.png") }}');
        background-size: cover;
        width: 30px;
        height: 30px;
        border-radius: 100%;
        cursor: pointer;
    }

    .corner {
        background-color: black;
        width: 10px;
        height: 10px;
        border-radius: 100%;
        cursor: pointer;
    }

    .entrypoint {
        background-color: green;
        width: 10px;
        height: 10px;
        border-radius: 100%;
        cursor: pointer;
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
            <div id="coordinates-cont" class="bg-light rounded mt-4 ml-4 py-2 px-3 d-flex justify-content-center align-items-center border" style="position: absolute; visibility: visible; z-index: 2; top: 0; left: 0;">
                <small class="m-0 mr-2"><span id="instructions" class="text-primary text-bold">Create a polygon as a boundary for the building.</span></small>
                <button id="save-btn" type="button" class="btn btn-sm btn-primary">Save</button>
                <button id="cancel-btn" type="button" class="btn btn-sm btn-danger ml-1">Cancel</button>
            </div>
            <button id="reset-btn" class="btn btn-sm btn-danger rounded" style="position: absolute; z-index: 20; top: 2%; right: 1%;">Reset</button>
        </div>
    </div>
</div>
<div class="modal fade" id="submission-modal" style="overflow-y:auto;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add a Building</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="building-add-form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="2" class="text-bold text-center">Boundary Details</td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-bold">Boundary Coordinates</td>
                                <td class="" id="boundary-coordinates"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-bold text-center">Entry Point Details</td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-bold">Entry Point Coordinates</td>
                                <td class="" id="entrypoint-coordinates"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-bold text-center">Marker Details</td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-bold">Marker Coordinates</td>
                                <td class="" id="marker-coordinates"></td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-bold">Marker Photo</td>
                                <td class="" id="entrypoint-coordinates">
                                    <input type="file" class="form-control-file" id="marker_image-table" name="marker_image">
                                    <img class="img-thumbnail rounded-circle mt-2" id="cropper-result" height="100" width="100" alt="200x200" src="" data-holder-rendered="true">
                                    <button type="button" id="remove-marker-image-btn" class="btn btn-danger btn-sm ml-2">Remove</button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-bold text-center">Building Details</td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-bold">Building Name</td>
                                <td class="">
                                    <input type="text" id="building_name" class="form-control" name="building_name" placeholder="Name this building">
                                    <small class="text-danger ml-1 field_errors" id="building_name_error"></small>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 25%" class="text-bold">Building Description</td>
                                <td class=""><textarea id="building_description" name="building_description" class="form-control" rows="4" cols="50" placeholder="Give this building a description."></textarea></td>
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
<div class="modal fade" id="cropper-modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Crop Image</h4>
                <button type="button" id="cropper-cancel-top-btn" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="d-flex justify-content-center align-items-center">
                    <img id="photo-cropper" alt="Upload an Image" />
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button id="cropper-cancel-bot-btn" type="button" class="btn btn-default">Cancel</button>
                <button id="cropper-crop-btn" type="button" class="btn btn-primary">Crop</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection
@section('more_scripts')
<script src="{{ asset('assets/admin/plugins/cropperjs/cropper.min.js') }}"></script>
<script>
    // Toastr Initializations
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    // End of Toastr Initializations

    // Universal Variables and Elements
    let _step = 1;
    const saveBtn = document.getElementById('save-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const resetBtn = document.getElementById('reset-btn');
    const instructions = document.getElementById('instructions');
    saveBtn.style.display = 'none';
    cancelBtn.style.display = 'none';
    // End of Universal Variables and Elements

    // Map Initializations
    mapboxgl.accessToken = 'pk.eyJ1Ijoic2Ftc3RyZWV0IiwiYSI6ImNsczRxb29mdTE1ZmkybHBjcHBhcG9xN2kifQ.SpJ2sxffT8PRfQjFtYgg6Q';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/samstreet/clto5jp0h01cg01ptc2idfbdk',
        zoom: 18,
        minZoom: 16,
        center: [124.2438547179179, 8.2414298468554],
        bearing: -95,
        maxBounds: [
            [124.23616973647256, 8.233619024568284], // Southwest bound
            [124.25301604017682, 8.248537110726303] // Northeast bound
        ]
    });

    map.on('zoom', function() {
        const zoom = map.getZoom();
        const markers = document.querySelectorAll('.display-marker');

        markers.forEach(marker => {
            if (zoom >= 20) {
                marker.style.width = '100px';
                marker.style.height = '100px';
            } else if (zoom >= 19 && zoom < 20) {
                marker.style.width = '50px';
                marker.style.height = '50px';
            } else if (zoom >= 18 && zoom < 20) {
                marker.style.width = '35px';
                marker.style.height = '35px';
            } else if (zoom >= 17 && zoom < 18) {
                marker.style.width = '20px';
                marker.style.height = '20px';
            } else {
                marker.style.width = '10px';
                marker.style.height = '10px';
            }
        });
    });

    map.on('zoom', function() {
        const zoom = map.getZoom();
        const markers = document.querySelectorAll('.marker');

        markers.forEach(marker => {
            if (zoom >= 20) {
                marker.style.width = '75px';
                marker.style.height = '75px';
            } else if (zoom >= 19 && zoom < 20) {
                marker.style.width = '50px';
                marker.style.height = '50px';
            } else if (zoom >= 18 && zoom < 20) {
                marker.style.width = '35px';
                marker.style.height = '35px';
            } else if (zoom >= 17 && zoom < 18) {
                marker.style.width = '20px';
                marker.style.height = '20px';
            } else {
                marker.style.width = '10px';
                marker.style.height = '10px';
            }
        });
    });

    function loadMarkers() {
        $.ajax({
            url: '{{ route("buildings.get") }}',
            data: '',
            success: function(data) {
                data.buildings.forEach(function(building) {
                    var coordinates = [building.longitude, building.latitude];
                    const el = document.createElement('div');
                    el.className = 'marker';
                    if (building.marker_photo !== null) {
                        var marker_photo = decodeURIComponent('{{ asset("storage/") }}' + "/" + building.marker_photo); // Decode URL
                        el.style.backgroundImage = `url('${marker_photo}')`;
                    }
                    var marker = new mapboxgl.Marker(el)
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
    loadMarkers();
    // End of Map Initializations

    // Rendering Current Map Elements
    function renderCurrentMapElements() {
        $.ajax({
            url: '{{ route("buildings.get") }}',
            data: {
                'building': true,
                'marker': true,
                'boundary': true,
            },
            success: function(response) {
                response.markers.forEach(marker => {
                    var temp = JSON.parse(marker.markers);
                    var coordinates = [temp.lng, temp.lat];
                    const el = document.createElement('div');
                    el.className = 'display-marker';
                    el.setAttribute('display-marker', marker.id);
                    if (marker.marker_image) {
                        var marker_image = decodeURIComponent('{{ asset("storage/") }}' + "/" + marker.marker_image); // Decode URL
                        el.style.backgroundImage = `url('${marker_image}')`;
                    }
                    var thisMarker = new mapboxgl.Marker(el)
                        .setLngLat(coordinates)
                        .addTo(map);
                });
                response.boundaries.forEach(boundary => {
                    var temp = JSON.parse(boundary.corners);
                    var boundaryCoordinates = [];
                    for (let key in temp) {
                        if (temp.hasOwnProperty(key)) {
                            boundaryCoordinates.push([temp[key].lng, temp[key].lat]);
                        }
                    }
                    map.addLayer({
                        id: `polygon-display-${boundary.id}`,
                        type: 'fill',
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
                            'fill-color': '#87ceeb',
                            'fill-opacity': 1
                        }
                    }, 'waterway-label');
                    map.on('click', `polygon-display-${boundary.id}`, function(e) {
                        if (step === 1) {
                            Toast.fire({
                                icon: 'error',
                                title: `You cannot overlap a building inside an existing building!`
                            });

                            // Get all elements with class "corner"
                            var cornerElements = document.getElementsByClassName('corner');

                            var highestCount = -1;
                            var elementWithHighestCount = null;

                            for (var i = 0; i < cornerElements.length; i++) {
                                var element = cornerElements[i];
                                var cornerId = element.getAttribute('corner-id');

                                // Extract the count from the corner-id attribute
                                var count = parseInt(cornerId.split('-')[1]);

                                // Check if the current count is higher than the highest count found so far
                                if (!isNaN(count) && count > highestCount) {
                                    highestCount = count;
                                    elementWithHighestCount = element;
                                }
                            }

                            delete corners[`corner${highestCount}`];
                            elementWithHighestCount.remove();
                        }
                    })
                })
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
    renderCurrentMapElements();
    // End of Rendering Current Map Elements

    // Removing Current Map Elements
    function removeCurrentMapElements() {
        var allDisplayMarkers = document.querySelectorAll('.display-marker');
        allDisplayMarkers.forEach(displayMarker => {
            displayMarker.remove();
        });
        var allDisplayBoundaries = map.getStyle().layers.filter(function(layer) {
            return layer.id.startsWith('polygon-display-');
        });
        allDisplayBoundaries.forEach(function(layer) {
            map.removeLayer(layer.id);
        });

        allDisplayBoundaries.forEach(function(layer) {
            if (map.getSource(layer.source)) {
                map.removeSource(layer.source);
            }
        });
    }
    // End of Removing Current Map Elements

    // Step Listeners 
    Object.defineProperty(window, 'step', {
        get: function() {
            return _step;
        },
        set: function(value) {
            if (value === 1) {
                _step = value;
                saveBtn.style.display = 'none';
                cancelBtn.style.display = 'none';
                instructions.innerText = "Create a polygon as a boundary for the building.";
                var allDisplayBoundaries = map.getStyle().layers.filter(function(layer) {
                    return layer.id.startsWith('polygon-display-');
                });
                allDisplayBoundaries.forEach(boundary => {
                    map.setPaintProperty(boundary.id, 'fill-color', '#87ceeb');
                })
            } else if (value === 2) {
                _step = value;
                instructions.innerText = "Click a point/s on the edge of the building boundary to create an entry point/s, then click save to proceed to the next step.";
                saveBtn.style.display = 'none';
                cancelBtn.style.display = 'none';
                var allDisplayBoundaries = map.getStyle().layers.filter(function(layer) {
                    return layer.id.startsWith('polygon-display-');
                });
                allDisplayBoundaries.forEach(boundary => {
                    map.setPaintProperty(boundary.id, 'fill-color', '#C7BDB9');
                })
                step2();
            } else if (value === 2.5) {
                _step = value;
                saveBtn.style.display = '';
                cancelBtn.style.display = '';
            } else if (value === 3) {
                _step = value;
                instructions.innerText = "Choose a location for the marker of the building. It is recommended that you place the marker at the center.";
                saveBtn.style.display = 'none';
                cancelBtn.style.display = 'none';
            } else if (value === 3.5) {
                _step = value;
                instructions.innerText = "Do you want to save this marker location?";
                saveBtn.style.display = '';
                cancelBtn.style.display = '';
            } else {
                _step = 1;
                saveBtn.style.display = 'none';
                cancelBtn.style.display = 'none';
            }
        }
    });
    // End of Step Listeners 

    // Cancel, Reset, and Save Button Listeners
    cancelBtn.addEventListener('click', function() {
        if (_step === 1 || _step === 1.5) {
            if (_step === 1) {
                const allCorners = document.querySelectorAll('.corner');
                allCorners.forEach(marker => marker.remove());
            } else {
                map.removeLayer('polygon-new');
                map.removeSource('polygon-new');
            }
            cancelBtn.style.display = 'none';
            saveBtn.style.display = 'none';
            corners = {};
            mapCorners = null;
            step = 1;
        } else if (_step === 2.5) {
            const allEntryPoints = document.querySelectorAll('.entrypoint');
            if (allEntryPoints.length > 0) {
                allEntryPoints.forEach(entry => entry.remove());
            }
            cancelBtn.style.display = 'none';
            saveBtn.style.display = 'none';
            entrypoints = {};
            _step = 2;
        } else if (_step === 3.5) {
            if (marker) {
                marker.remove();
            }
            document.getElementById('building-add-form').reset();
            document.getElementById('marker_image-table').value = '';
            $('#cropper-result').hide();
            $('#remove-marker-image-btn').hide();
            $('.entry_input').remove();
            step = 3;
        }
    });
    resetBtn.addEventListener('click', function() {
        if (map.getLayer('polygon-new')) {
            map.removeLayer('polygon-new');
            map.removeSource('polygon-new');
        }
        const allCorners = document.querySelectorAll('.corner');
        if (allCorners.length > 0) {
            allCorners.forEach(marker => marker.remove());
        }
        if (map.getLayer('polygon-new-edge')) {
            map.removeLayer('polygon-new-edge');
            map.removeSource('polygon-new-edge');
        }
        const allEntryPoints = document.querySelectorAll('.entrypoint');
        if (allEntryPoints.length > 0) {
            allEntryPoints.forEach(entry => entry.remove());
        }
        if (marker) {
            marker.remove();
        }
        document.getElementById('building-add-form').reset();
        document.getElementById('marker_image-table').value = '';
        document.getElementById('cropper-result').style.display = 'none';
        document.getElementById('remove-marker-image-btn').style.display = 'none';
        cancelBtn.style.display = 'none';
        saveBtn.style.display = 'none';
        corners = {};
        entrypoints = {};
        mapCorners = null;
        step = 1;
    });
    saveBtn.addEventListener('click', function() {
        if (_step === 1.5) {
            step = 2;
        } else if (_step === 2.5) {
            step = 3;
        } else if (_step === 3.5) {
            toggleModal();
        }
    })
    // Cancel, Reset, and Save Button Listeners

    // Step 1 Functions
    var corners = {};
    var mapCorners;
    map.on('click', function(e) {
        if (_step === 1) {
            var count = Object.keys(corners).length;
            corners[`corner${count}`] = {
                lng: e.lngLat.lng,
                lat: e.lngLat.lat
            }
            const el = document.createElement('div');
            el.className = 'corner';
            el.setAttribute('corner-id', `corner-${count}`)
            if ((count) == 0) {
                cancelBtn.style.display = '';
                el.addEventListener('click', function() {
                    setTimeout(polygonComplete, 100);
                })
            } else {
                el.style.pointerEvents = 'none';
                el.style.cursor = 'default';
            }
            if (_step !== 1.5) {
                var temporaryMarker = new mapboxgl.Marker(el)
                    .setLngLat(e.lngLat)
                    .addTo(map);
            }
            var features = map.queryRenderedFeatures(e.point);

            // Check if any features are present
            if (features.length > 0) {
                // Loop through the features
                features.forEach(function(feature) {
                    // Check if the feature belongs to the boundary layer
                    if (feature.layer.id === 'boundary-latest-19j3o8') {
                        // Log "out of bounds" to the console

                        if (Object.keys(corners).length > 0) {
                            // Get the key of the latest added corner
                            var latestCornerKey = `corner${Object.keys(corners).length - 1}`;
                            // Delete the latest added corner from the corners object
                            delete corners[latestCornerKey];
                            // Remove the latest added marker from the map
                            temporaryMarker.remove();
                            Toast.fire({
                                icon: 'error',
                                title: `Area out of bounds!`
                            });
                        }
                    }
                });
            }
        }
    });

    function polygonComplete() {
        _step = 1.5;
        instructions.innerText = "Do you want to save these building boundaries?";
        var count = Object.keys(corners).length;
        corners[`corner${count - 1}`] = corners['corner0'];
        var boundaryCoordinates = [];
        for (let key in corners) {
            if (corners.hasOwnProperty(key)) {
                boundaryCoordinates.push([corners[key].lng, corners[key].lat]);
            }
        }
        map.addLayer({
            id: 'polygon-new',
            type: 'fill',
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
                'fill-color': '#DED7D3',
                'fill-opacity': 1
            }
        }, 'waterway-label');
        map.on('click', 'polygon-new', function(e) {
            if (_step === 3 || _step === 3.5) {
                const el = document.createElement('div');
                el.className = 'marker';
                if (marker) {
                    marker.remove();
                }
                marker = new mapboxgl.Marker(el)
                    .setLngLat(e.lngLat)
                    .addTo(map);
                step = 3.5;
            }
        });
        const allCorners = document.querySelectorAll('.corner');
        allCorners.forEach(marker => marker.remove());
        saveBtn.style.display = '';
    }
    // End of Step 1 Functions

    // Step 2 Function
    const {
        nearestPointOnLine
    } = turf;
    var entrypoints = {};

    map.on('click', 'polygon-new-edge', function(e) {
        var boundaryCoordinates = [];
        for (let key in corners) {
            if (corners.hasOwnProperty(key)) {
                boundaryCoordinates.push([corners[key].lng, corners[key].lat]);
            }
        }
        if (_step === 2 || _step === 2.5) {
            const lngLat = e.lngLat;

            const nearestPoint = nearestPointOnLine({
                type: 'Feature',
                properties: {},
                geometry: {
                    type: 'LineString',
                    coordinates: boundaryCoordinates
                }
            }, lngLat.toArray());

            const el = document.createElement('div');
            el.className = 'entrypoint';
            var marker = new mapboxgl.Marker(el)
                .setLngLat(nearestPoint.geometry.coordinates)
                .addTo(map);

            var count = Object.keys(entrypoints).length;
            entrypoints[`entry${count}`] = {
                lng: nearestPoint.geometry.coordinates[0],
                lat: nearestPoint.geometry.coordinates[1]
            }

            step = 2.5;
        }
    });

    function step2() {
        var boundaryCoordinates = [];
        for (let key in corners) {
            if (corners.hasOwnProperty(key)) {
                boundaryCoordinates.push([corners[key].lng, corners[key].lat]);
            }
        }
        map.addLayer({
            id: 'polygon-new-edge',
            type: 'line',
            source: {
                type: 'geojson',
                data: {
                    type: 'Feature',
                    geometry: {
                        type: 'LineString',
                        coordinates: boundaryCoordinates
                    }
                }
            },
            layout: {
                'line-join': 'round',
                'line-cap': 'round'
            },
            paint: {
                'line-color': '#C7BDB9',
                'line-width': 4
            }
        }, 'waterway-label');
        map.on('mouseenter', 'polygon-new', function() {
            map.getCanvas().style.cursor = 'pointer';
        });

        map.on('mouseleave', 'polygon-new', function() {
            map.getCanvas().style.cursor = '';
        });
    }
    // End of Step 2 Functions

    // Step 3 Functions
    var marker;

    function toggleModal() {
        $('#submission-modal').modal('toggle');
        // Rendering Boundary Coordinates on Form
        var formBoundaryCoordinatesColumn = document.getElementById('boundary-coordinates');
        var boundaryCoordinatesForm = [];
        for (let key in corners) {
            if (corners.hasOwnProperty(key)) {
                boundaryCoordinatesForm.push(`Longitude: ${corners[key].lng} Latitude: ${corners[key].lat}`);
                boundaryCoordinatesForm.push('<hr>');
            }
        }
        boundaryCoordinatesForm.pop();
        formBoundaryCoordinatesColumn.innerHTML = boundaryCoordinatesForm.join('');
        // Rendering Entry Point Coordinates on Form
        var formEntryPointColumn = document.getElementById('entrypoint-coordinates');
        var entryPointCoordinatesForm = [];
        for (let key in entrypoints) {
            if (entrypoints.hasOwnProperty(key)) {
                entryPointCoordinatesForm.push(`Longitude: ${entrypoints[key].lng} Latitude: ${entrypoints[key].lat}`);
                entryPointCoordinatesForm.push(`<input class="form-control input-sm mt-1 px-2 py-1" name="${key}" maxlength="3" id="input-${key}" type="text" placeholder="Provide a Code Name for this Entrypoint">`)
                entryPointCoordinatesForm.push(`<small class="text-danger ml-1 field_errors entry_input" id="${key}_error"></small>`)
                entryPointCoordinatesForm.push('<hr>');
            }
        }
        entryPointCoordinatesForm.pop();
        formEntryPointColumn.innerHTML = entryPointCoordinatesForm.join('');
        // Rendering Marker Details
        var markerCoordinates = document.getElementById('marker-coordinates');
        markerCoordinates.innerHTML = `Longitude: ${marker.getLngLat().lng}, Latitude: ${marker.getLngLat().lat}`;

    }
    $('#submission-modal').submit(function(e) {
        e.preventDefault();
        var formData = new FormData();
        for (let key in entrypoints) {
            if (entrypoints.hasOwnProperty(key)) {
                entrypoints[key].code = document.getElementById(`input-${key}`).value;
                var entryValue = document.getElementById(`input-${key}`).value;
                formData.append(key, entryValue);
            }
        }
        var markers = {
            lng: marker.getLngLat().lng,
            lat: marker.getLngLat().lat
        }
        var fileInput = document.getElementById('marker_image-table');
        formData.append('corners', JSON.stringify(corners));
        formData.append('entrypoints', JSON.stringify(entrypoints));
        formData.append('markers', JSON.stringify(markers));
        formData.append('building_name', document.getElementById('building_name').value);
        formData.append('status', 'inactive');
        formData.append('building_description', document.getElementById('building_description').value);
        formData.append('marker_image', fileInput.files[0]);
        $.ajax({
            url: '{{ route("buildings.add.submit") }}',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(response) {
                if (response.success == true) {
                    Toast.fire({
                        icon: 'success',
                        title: `${response.building} has been added successfully!`
                    });
                    $('#submission-modal').modal('toggle');
                    removeCurrentMapElements();
                    renderCurrentMapElements();
                    resetBtn.click();
                } else if (response.success == false) {
                    console.log(response);
                    printValidationErrorMsg(response.msg, response.entryErrors);
                }
            },
            error: function(error) {
                if (error.status == 413) {
                    Toast.fire({
                        icon: 'error',
                        title: `Image Size Too Large!`
                    });
                }
                console.log(error);
            }
        })
    });

    function clear_validations() {
        $(document).find('.field_errors').text('');
    }

    function printValidationErrorMsg(msg, entryErrors = null) {
        clear_validations();

        if (typeof msg === 'object' && msg !== null) {
            for (const [fieldName, error] of Object.entries(msg)) {
                $(`#${fieldName}_error`).text(error);
            }
        }

        if (typeof entryErrors === 'object' && entryErrors !== null) {
            for (let key in entryErrors) {
                if (key.endsWith('_error')) {
                    $(`#${key}`).text(entryErrors[key]);
                }
            }
        }
    }

    function logData() {


        console.log(markers);
    }

    // End of Step 3 Functions

    // Cropper Js
    let cropper;
    const imageInput = document.getElementById('marker_image-table');
    const cropperCont = document.getElementById('photo-cropper');
    const cropBtn = document.getElementById('cropper-crop-btn');
    const cancelCropTopBtn = document.getElementById('cropper-cancel-top-btn');
    const cancelCropBotBtn = document.getElementById('cropper-cancel-bot-btn');
    const removeImageUploadBtn = document.getElementById('remove-marker-image-btn');
    $('#remove-marker-image-btn').hide();
    $('#cropper-result').hide();

    function dataURLtoBlob(dataURL) {
        const parts = dataURL.split(';base64,');
        const contentType = parts[0].split(':')[1];
        const raw = window.atob(parts[1]);
        const rawLength = raw.length;
        const uint8Array = new Uint8Array(rawLength);

        for (let i = 0; i < rawLength; ++i) {
            uint8Array[i] = raw.charCodeAt(i);
        }

        return new Blob([uint8Array], {
            type: contentType
        });
    }
    imageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = (e) => {
                cropperCont.src = e.target.result;

                // Destroy the previous Cropper instance if it exists
                if (cropper) {
                    cropper.destroy();
                }

                // Initialize a new Cropper instance on the updated image
                cropper = new Cropper(cropperCont, {
                    aspectRatio: 1,
                    viewMode: 1
                });
            };

            reader.readAsDataURL(file);

            // Use Bootstrap methods to toggle modal visibility
            $('#cropper-modal').modal('toggle');
        }
    });
    removeImageUploadBtn.addEventListener('click', () => {
        document.getElementById('cropper-result').src = "";
        imageInput.value = '';
        $('#cropper-result').hide();
        $('#remove-marker-image-btn').hide();
    })
    cancelCropTopBtn.addEventListener('click', () => {
        $('#cropper-modal').modal('toggle');
        $('#marker_image-table').val('');
    })
    cancelCropBotBtn.addEventListener('click', () => {
        $('#cropper-modal').modal('toggle');
        $('#marker_image-table').val('');
    })
    cropBtn.addEventListener('click', () => {
        const croppedDataUrl = cropper.getCroppedCanvas().toDataURL();

        // Create a new Blob from the data URL
        const blob = dataURLtoBlob(croppedDataUrl);

        // Create a new File object from the Blob
        const croppedFile = new File([blob], 'cropped_image.jpg', {
            type: 'image/jpeg'
        });

        // Create a new DataTransfer object
        const dataTransfer = new DataTransfer();

        // Add the new File object to the DataTransfer object
        dataTransfer.items.add(croppedFile);

        document.getElementById('marker_image-table').files = dataTransfer.files;

        // Display the cropped image in the preview
        $('#remove-marker-image-btn').show();
        $('#cropper-result').show();
        document.getElementById('cropper-result').src = croppedDataUrl;

        // Close the modals
        $('#cropper-modal').modal('toggle');
    })
    // End of Cropper Js
</script>
@endsection