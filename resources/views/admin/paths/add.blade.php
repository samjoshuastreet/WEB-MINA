@extends('admin.layouts.layout')
@section('title', 'Add a Path')
@section('more_links')
<style>
    .marker {
        background-color: black;
        width: 10px;
        height: 10px;
        border-radius: 100%;
        cursor: pointer;
        z-index: 20;
    }

    .display-marker {
        background-image: url('{{ asset("assets/logos/logo-only.png") }}');
        background-size: cover;
        width: 30px;
        height: 30px;
        border-radius: 100%;
        cursor: pointer;
        z-index: 40;
    }

    .entry {
        background-color: green;
        width: 10px;
        height: 10px;
        border-radius: 100%;
        cursor: pointer;
        z-index: 30;
    }

    .marker:hover {
        background-color: red;
        width: 10px;
        height: 10px;
        border-radius: 100%;
        cursor: pointer;
        transition: 500ms;
    }

    .entry:hover {
        background-color: red;
        width: 10px;
        height: 10px;
        border-radius: 100%;
        cursor: pointer;
        transition: 500ms;
    }

    .marker-label {
        text-transform: capitalize;
        position: absolute;
        top: -20px;
        left: 50%;
        transform: translateX(-50%);
    }

    .entry-label {
        text-transform: capitalize;
        position: absolute;
        top: -20px;
        left: 50%;
        transform: translateX(-50%);
    }
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add a Path</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Add Path</a></li>
                        <li class="breadcrumb-item active">Admin</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content">
        <div>
            <div class="container-fluid" style="position: relative;">
                <div class="row">
                    <div id="map" style="height: 100vh; width: 100vw; position: relative;"></div>
                </div>
                <div id="coordinates-cont" class="bg-light rounded mt-2 ml-2 p-2 d-flex justify-content-center align-items-center border" style="position: absolute; z-index: 2; top: 0; left: 0;">
                    <small class="m-0 mr-2"><span id="instructions" class="text-bold">Step 1: Make a waypoint or choose an existing endpoint.</span> Coordinates: <span id="coordinates-lat" class="text-success"></span>, <span id="coordinates-long" class="text-info"></span>.
                        <input id="wp-a-code" name="wp_a_code" type="text" placeholder="Code Name" style="width: 100px" maxlength="3">
                        <input id="wp-b-code" name="wp_b_code" type="text" placeholder="Code Name" style="width: 100px" maxlength="3">
                        <input id="landmark" name="landmark" type="text" placeholder="State the nearest landmark for directions guide" style="width: 500px; display: none;">
                        <select id='path-type-select' name='type' style='display: none;'>
                            <option value=''>Select a path type</option>
                            <option value='indoor'>Indoor</option>
                            <option value='outdoor'>Outdoor</option>
                            <option value='pedestrian lane'>Pedestrian Lane</option>
                            <option value='road'>Road</option>
                        </select>
                        <label for='cardinal-direction' id='cardinal-direction-label' style='display:none;'>Facing: </label>
                        <input type="text" name="cardinal-direction" id="cardinal-direction" style="display: none;" readonly>
                        <!-- <label for='path-exit-select' id='path-exit-select-label' style='display:none;'>One Way: </label>
                        <select id='path-exit-select' name='isOneWay' style='display: none;'>
                            <option value='false'>False</option>
                            <option value='true'>True</option>
                        </select> -->
                    </small>
                    <button id="wp-a-save-btn" type="button" class="btn btn-sm btn-primary">Save</button>
                    <button id="wp-b-save-btn" type="button" class="btn btn-sm btn-primary" style="display: none;">Save</button>
                    <button id="landmark-save-btn" type="button" class="btn btn-sm btn-primary" style="display: none;">Save</button>
                    <button id="add-path-btn" type="button" class="btn btn-sm btn-primary" style="display: none;">Add</button>
                    <button id="cancel-coordinates-btn" type="button" class="btn btn-sm btn-danger ml-1">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->

    <!-- End of Modals -->

</div>
@endsection
@section('more_scripts')
<script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
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

    function renderBoundaries() {
        $.ajax({
            url: '{{ route("buildings.get") }}',
            data: {
                'entrypoint': true,
                'boundary': true,
            },
            success: function(response) {
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
                response.entrypoints.forEach(entry => {
                    var temp = JSON.parse(entry.entrypoints);
                    var temp = JSON.parse(temp);
                    for (let key in temp) {
                        var coordinates = [temp[key].lng, temp[key].lat];
                        const el = document.createElement('div');
                        const codeValue = temp[key].code;
                        el.className = 'entry';
                        el.setAttribute('entry', entry.id);
                        el.innerHTML = `<span class="entry-label">${codeValue}</span>`;
                        el.setAttribute('code', `entry-code-${codeValue}`);
                        el.setAttribute('lng', temp[key].lng);
                        el.setAttribute('lat', temp[key].lat);
                        var thisMarker = new mapboxgl.Marker(el)
                            .setLngLat(coordinates)
                            .addTo(map);
                    }
                });
            },
            error: function(error) {

            }
        });
    }
    renderBoundaries();
    renderPaths();

    var marker;
    var wp_a;
    var wp_b;
    var wp_distance;
    var buildingConnection = false;
    var buildingConnectionA = null;
    var buildingConnectionB = null;
    var coordinatesCont = document.getElementById('coordinates-cont');
    var saveBtn = document.getElementById('save-coordinates-btn');
    var cancelBtn = document.getElementById('cancel-coordinates-btn');
    var latCoordinate = document.getElementById('coordinates-lat');
    var longCoordinate = document.getElementById('coordinates-long');
    $('#wp-a-code').hide();
    $('#wp-b-code').hide();

    map.on('click', function(e) {
        resetMarkerColors();
        if (marker) {
            marker.remove();
        }

        if (!wp_a) {
            $('#wp-a-code').show();
        } else {
            $('#wp-b-code').show();
        }

        if (!wp_a || !wp_b) {
            const el = document.createElement('div');
            el.className = 'marker';
            marker = new mapboxgl.Marker(el)
                .setLngLat(e.lngLat)
                .addTo(map);

            const [lng, lat] = e.lngLat.toArray();
            latCoordinate.innerText = `${lat}`;
            longCoordinate.innerText = `${lng}`;
        }
        var features = map.queryRenderedFeatures(e.point);
        if (features.length > 0) {
            // Loop through the features
            features.forEach(function(feature) {
                // Check if the feature belongs to the boundary layer
                if (feature.layer.id === 'boundary-latest-19j3o8') {
                    // Log "out of bounds" to the console

                    if (marker) {
                        marker.remove();
                        Toast.fire({
                            icon: 'error',
                            title: `Area out of bounds!`
                        });
                    }
                }
            });
        }
    });

    function resetMarkerColors() {
        $(document).find('.marker').css('background-color', 'black');
        $(document).find('.entry').css('background-color', 'green');
        if (!wp_a) {
            $('#wp-a-code').val('');
            document.getElementById('wp-a-code').readOnly = false;
        } else {
            $('#wp-b-code').val('');
            document.getElementById('wp-b-code').readOnly = false;
        }
    }

    $(document).on('click', '.entry', function() {
        if (marker) {
            marker.remove();
        }
        var target = $(this).attr('code');
        var lng = $(this).attr('lng');
        var lat = $(this).attr('lat');
        resetMarkerColors();
        $(this).css('background-color', 'red');
        target = target.replace('entry-code-', '');
        if (!buildingConnectionA) {
            buildingConnectionA = this.getAttribute('entry');
        } else {
            buildingConnectionB = this.getAttribute('entry');
        }

        buildingConnection = true;
        if (!wp_a) {
            marker = new mapboxgl.Marker()
                .setLngLat([lng, lat]);
            latCoordinate.innerText = lat;
            longCoordinate.innerText = lng;
            document.getElementById('wp-a-code').value = target;
            document.getElementById('wp-a-code').readOnly = true;
        } else {
            marker = new mapboxgl.Marker()
                .setLngLat([lng, lat]);
            latCoordinate.innerText = lat;
            longCoordinate.innerText = lng;
            document.getElementById('wp-b-code').value = target;
            document.getElementById('wp-b-code').readOnly = true;
        }
    })

    $(document).on('click', '.marker', function() {
        if (marker) {
            marker.remove();
        }
        var target = $(this).attr('code');
        resetMarkerColors();
        $(this).css('background-color', 'red');
        target = target.replace('marker-code-', '');
        $.ajax({
            url: '{{ route("paths.find") }}',
            data: {
                'target': target
            },
            success: function(response) {
                if (!wp_a) {
                    $('#wp-a-code').show();
                    if (response.waypoint == true) {
                        marker = new mapboxgl.Marker()
                            .setLngLat([response.path.wp_a_lng, response.path.wp_a_lat]);
                        latCoordinate.innerText = `${response.path.wp_a_lat}`;
                        longCoordinate.innerText = `${response.path.wp_a_lng}`;
                        document.getElementById('wp-a-code').value = response.path.wp_a_code;
                        document.getElementById('wp-a-code').readOnly = true;
                    } else {
                        marker = new mapboxgl.Marker()
                            .setLngLat([response.path.wp_b_lng, response.path.wp_b_lat]);
                        latCoordinate.innerText = `${response.path.wp_b_lat}`;
                        longCoordinate.innerText = `${response.path.wp_b_lng}`;
                        document.getElementById('wp-a-code').value = response.path.wp_b_code;
                        document.getElementById('wp-a-code').readOnly = true;
                    }
                } else {
                    $('#wp-b-code').show();
                    if (response.waypoint == true) {
                        marker = new mapboxgl.Marker()
                            .setLngLat([response.path.wp_a_lng, response.path.wp_a_lat]);
                        latCoordinate.innerText = `${response.path.wp_a_lat}`;
                        longCoordinate.innerText = `${response.path.wp_a_lng}`;
                        document.getElementById('wp-b-code').value = response.path.wp_a_code;
                        document.getElementById('wp-b-code').readOnly = true;
                    } else {
                        marker = new mapboxgl.Marker()
                            .setLngLat([response.path.wp_b_lng, response.path.wp_b_lat]);
                        latCoordinate.innerText = `${response.path.wp_b_lat}`;
                        longCoordinate.innerText = `${response.path.wp_b_lng}`;
                        document.getElementById('wp-b-code').value = response.path.wp_b_code;
                        document.getElementById('wp-b-code').readOnly = true;
                    }
                }
            },
            error: function(response) {
                console.log(response);
            }
        })
    })

    function renderPaths() {
        $.ajax({
            url: '{{ route("paths.get") }}',
            data: '',
            success: function(data) {
                data.paths.forEach(path => {
                    const lineCoordinates = [
                        [path.wp_a_lng, path.wp_a_lat],
                        [path.wp_b_lng, path.wp_b_lat]
                    ]
                    const paint = {
                        'line-width': 4
                    }
                    if (path.type == 'outdoor') {
                        paint['line-color'] = 'blue';
                    } else if (path.type == 'indoor') {
                        paint['line-color'] = '#FC0FC0';
                    } else if (path.type == 'pedestrian lane') {
                        paint['line-color'] = 'yellow';
                    } else if (path.type == 'road') {
                        paint['line-color'] = 'black';
                    }
                    map.addLayer({
                        'id': path.id.toString(),
                        'type': 'line',
                        'source': {
                            'type': 'geojson',
                            'data': {
                                'type': 'Feature',
                                'properties': {},
                                'geometry': {
                                    'type': 'LineString',
                                    'coordinates': lineCoordinates
                                }
                            }
                        },
                        'layout': {
                            'line-join': 'round',
                            'line-cap': 'round'
                        },
                        'paint': paint
                    }, 'waterway-label');
                    const ael = document.createElement('div');
                    ael.className = 'marker';
                    ael.setAttribute('code', `marker-code-${path.wp_a_code}`);
                    const aLngLat = [path.wp_a_lng, path.wp_a_lat];
                    const aCodeValue = path.wp_a_code;
                    ael.innerHTML = `<span class="marker-label">${aCodeValue}</span>`;
                    var waypointa = new mapboxgl.Marker(ael)
                        .setLngLat(aLngLat)
                        .addTo(map);
                    const bel = document.createElement('div');
                    bel.className = 'marker';
                    bel.setAttribute('code', `marker-code-${path.wp_b_code}`);
                    const bLngLat = [path.wp_b_lng, path.wp_b_lat];
                    const bCodeValue = path.wp_b_code;
                    bel.innerHTML = `<span class="marker-label">${bCodeValue}</span>`;
                    var waypointb = new mapboxgl.Marker(bel)
                        .setLngLat(bLngLat)
                        .addTo(map);
                });
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    cancelBtn.addEventListener('click', function() {
        if (marker) {
            marker.remove();
            marker = null;
        }
        if (wp_a) {
            wp_a.remove();
            wp_a = null;
        }
        if (wp_b) {
            wp_b.remove();
            wp_b = null;
        }
        if (map.getLayer('temporary-path')) {
            map.removeLayer('temporary-path');
        }
        if (map.getSource('temporary-path')) {
            map.removeSource('temporary-path');
        }

        $('#wp-a-save-btn').show();
        $('#wp-b-save-btn').hide();
        $('#add-path-btn').hide();
        $('#instructions').text('Step 1: Make a waypoint or choose an existing endpoint.');
        $('#coordinates-lat').text('');
        $('#coordinates-long').text('');
        $('#wp-a-code').val('').hide();
        $('#wp-b-code').val('').hide();
        $('#landmark').val('').hide();
        $('#landmark-save-btn').hide();
        $('#path-type-select').val('').hide();
        $('#cardinal-direction').hide();
        //    $('#path-exit-select').hide();
        //     $('#path-exit-select-label').hide();
        $('#cardinal-direction-label').hide();
        resetMarkerColors();
        buildingConnection = false;
        buildingConnectionA = null;
        buildingConnectionB = null;
    })

    $(document).on('click', '#wp-a-save-btn', function() {
        if (!marker) {
            Toast.fire({
                icon: 'error',
                title: 'Please declare a waypoint first!'
            })
        } else if ($('#wp-a-code').val() == '') {
            Toast.fire({
                icon: 'error',
                title: 'Please declare a codename for your waypoint!'
            })
        } else {
            var redMarkers = $('div.marker[style*="background-color: red"]').length > 0;
            $.ajax({
                url: '{{ route("paths.add.validator") }}',
                data: {
                    'code': $('#wp-a-code').val().toUpperCase(),
                    'redMarkers': redMarkers,
                    'buildingConnection': buildingConnection
                },
                success: function(response) {
                    if (response.success == true) {
                        var connection = false;
                        if (response.connection) {
                            connection = true;
                        }
                        var validationData = response.decodedEntries;
                        var decodedValidationData = [];
                        var codes = [];
                        for (let key in validationData) {
                            var temp = decodedValidationData.push(JSON.parse(validationData[key]));
                        }
                        for (let key in decodedValidationData) {
                            if (decodedValidationData.hasOwnProperty(key)) {
                                let entry = decodedValidationData[key];
                                for (let prop in entry) {
                                    if (entry.hasOwnProperty(prop)) {
                                        codes.push(entry[prop].code);
                                    }
                                }
                            }
                        }
                        $.ajax({
                            url: '{{ route("paths.add.validator") }}',
                            data: {
                                'code': $('#wp-a-code').val().toUpperCase(),
                                'codes': codes,
                                'entrypoint_validation': true,
                                'connection': connection
                            },
                            success: function(response) {
                                if (response.success == false) {
                                    Toast.fire({
                                        icon: 'error',
                                        title: `The code name ${response.code} already exists!`
                                    })
                                } else {
                                    $('#wp-a-save-btn').hide();
                                    $('#wp-b-save-btn').show();
                                    $('#instructions').text('Step 2: Mark the path\'s endpoint.');
                                    $('#coordinates-lat').text('');
                                    $('#coordinates-long').text('');
                                    const lngLat = marker.getLngLat();
                                    const el = document.createElement('div');
                                    el.className = 'marker';
                                    const codeValue = document.getElementById('wp-a-code').value;
                                    el.innerHTML = `<span class="marker-label">${codeValue.toUpperCase()}</span>`;
                                    wp_a = new mapboxgl.Marker(el)
                                        .setLngLat(lngLat)
                                        .addTo(map);
                                    marker.remove();
                                    marker = null;
                                    $('#wp-a-code').hide();
                                    $('#wp-b-code').show();
                                    document.getElementById('wp-b-code').readOnly = false;
                                }
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        })
                    } else if (response.success == false) {
                        Toast.fire({
                            icon: 'error',
                            title: `The code name ${response.code} already exists!`
                        })
                    }
                },
                error: function(response) {
                    console.log(response);
                }
            })
        }
    });

    $(document).on('click', '#wp-b-save-btn', function() {
        if (!marker) {
            Toast.fire({
                icon: 'error',
                title: 'Please declare an endpoint first!'
            })
        } else if ($('#wp-b-code').val() == '') {
            Toast.fire({
                icon: 'error',
                title: 'Please declare a codename for your endpoint!'
            })
        } else {
            var redMarkers = $('div.marker[style*="background-color: red"]').length > 0;
            $.ajax({
                url: '{{ route("paths.add.validator") }}',
                data: {
                    'code': $('#wp-b-code').val().toUpperCase(),
                    'redMarkers': redMarkers,
                    'buildingConnection': buildingConnection
                },
                success: function(response) {
                    if (response.success == true) {
                        var connection = false;
                        if (response.connection) {
                            connection = true;
                        }
                        if ($('#wp-b-code').val() !== $('#wp-a-code').val()) {
                            var validationData = response.decodedEntries;
                            var decodedValidationData = [];
                            var codes = [];
                            for (let key in validationData) {
                                var temp = decodedValidationData.push(JSON.parse(validationData[key]));
                            }
                            for (let key in decodedValidationData) {
                                if (decodedValidationData.hasOwnProperty(key)) {
                                    let entry = decodedValidationData[key];
                                    for (let prop in entry) {
                                        if (entry.hasOwnProperty(prop)) {
                                            codes.push(entry[prop].code);
                                        }
                                    }
                                }
                            }
                            $.ajax({
                                url: '{{ route("paths.add.validator") }}',
                                data: {
                                    'code': $('#wp-b-code').val().toUpperCase(),
                                    'codes': codes,
                                    'entrypoint_validation': true,
                                    'connection': connection
                                },
                                success: function(response) {
                                    if (response.success == false) {
                                        Toast.fire({
                                            icon: 'error',
                                            title: `The code name ${response.code} already exists!`
                                        })
                                    } else {
                                        const aLngLat = wp_a.getLngLat();
                                        const bLngLat = marker.getLngLat();
                                        const lineCoordinates = [
                                            [aLngLat.lng, aLngLat.lat],
                                            [bLngLat.lng, bLngLat.lat]
                                        ]
                                        const el = document.createElement('div');
                                        el.className = 'marker';
                                        const codeValue = document.getElementById('wp-b-code').value; // Get value from input field
                                        el.innerHTML = `<span class="marker-label">${codeValue.toUpperCase()}</span>`;
                                        wp_b = new mapboxgl.Marker(el)
                                            .setLngLat(bLngLat)
                                            .addTo(map);
                                        marker.remove();

                                        map.addLayer({
                                            'id': 'temporary-path',
                                            'type': 'line',
                                            'source': {
                                                'type': 'geojson',
                                                'data': {
                                                    'type': 'Feature',
                                                    'properties': {},
                                                    'geometry': {
                                                        'type': 'LineString',
                                                        'coordinates': lineCoordinates
                                                    }
                                                }
                                            },
                                            'layout': {
                                                'line-join': 'round',
                                                'line-cap': 'round'
                                            },
                                            'paint': {
                                                'line-color': 'blue',
                                                'line-width': 8
                                            }
                                        }, 'waterway-label');
                                        $('#instructions').text('Step 3: Provide a landmark for navigation guide (optional). And declare the path type.');
                                        $('#wp-b-save-btn').hide();
                                        $('#wp-b-code').hide();
                                        $('#landmark').show();
                                        $('#path-type-select').show();
                                        $('#landmark-save-btn').show();
                                        $('#cardinal-direction').show();
                                        // $('#path-exit-select').show();
                                        // $('#path-exit-select-label').show();
                                        $('#cardinal-direction').show();
                                        $('#cardinal-direction-label').show();
                                        $('#cardinal-direction').val(getCardinalDirection(
                                            turf.bearing(
                                                turf.point([aLngLat.lng, aLngLat.lat]),
                                                turf.point([bLngLat.lng, bLngLat.lat])
                                            )
                                        ));
                                        const {
                                            lineDistance
                                        } = turf;

                                        const line = turf.lineString(lineCoordinates);
                                        const distance = lineDistance(line, {
                                            units: 'meters'
                                        });
                                        wp_distance = distance;
                                    }
                                },
                                error: function(error) {
                                    console.log(error);
                                }
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: "Waypoint and endpoint cannot be the same!"
                            })
                        }
                    } else if (response.success == false) {
                        Toast.fire({
                            icon: 'error',
                            title: `The code name ${response.code} already exists!`
                        })
                    }
                },
                error: function(response) {
                    console.log(resposne);
                }
            })
        }
    });

    $(document).on('click', '#landmark-save-btn', () => {
        $.ajax({
            url: '{{ route("paths.add.validator") }}',
            data: {
                'landmark': $('#landmark').val(),
                'type': $('#path-type-select').val(),
                'landmarkWithType': true
            },
            success: (response) => {
                console.log(response)
                if (response.success === true) {
                    $('#instructions').text('Step 4: Recheck if you are satistied with the path.');
                    $('#landmark').hide();
                    $('#path-type-select').hide();
                    $('#landmark-save-btn').hide();
                    $('#cardinal-direction-label').hide();
                    $('#cardinal-direction').hide();
                    $('#add-path-btn').show();
                    // $('#path-exit-select').hide();
                    // $('#path-exit-select-label').hide();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Path type is required.'
                    });
                }
            },
            error: (error) => {
                console.log(error);
            }
        })
    })

    $(document).on('click', '#add-path-btn', () => {
        $.ajax({
            url: '{{ route("paths.add.submit") }}',
            data: {
                'wp_a_lng': wp_a.getLngLat().lng,
                'wp_a_lat': wp_a.getLngLat().lat,
                'wp_a_code': $('#wp-a-code').val(),
                'wp_b_lng': wp_b.getLngLat().lng,
                'wp_b_lat': wp_b.getLngLat().lat,
                'wp_b_code': $('#wp-b-code').val(),
                'weight': wp_distance,
                'landmark': $('#landmark').val(),
                'type': $('#path-type-select').val(),
                // 'isOneWay': $('#path-exit-select').val(),
                'cardinal_direction': $('#cardinal-direction').val(),
                'building_connection': buildingConnection,
                'buildingConnectionA': buildingConnectionA,
                'buildingConnectionB': buildingConnectionB
            },
            success: function(data) {
                Toast.fire({
                    icon: 'success',
                    title: 'Path created successfully!'
                });
                $('#cancel-coordinates-btn').click();
                $('#wp-a-code').hide();
                $('#wp-b-code').hide();
                renderPaths();
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    function getCardinalDirection(bearing) {
        const cardinals = ['North', 'Northeast', 'East', 'Southeast', 'South', 'Southwest', 'West', 'Northwest', 'North'];
        console.log(bearing)
        const index = (Math.round(bearing / 45) + 8) % 8;
        console.log(index)
        return cardinals[index];
    }
</script>
@endsection