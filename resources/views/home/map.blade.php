@extends('home.layouts.layout')
@section('title', 'MSU-IIT Map - Home')
@section('more_links')
<style>
    .display-marker {
        background-image: url('{{ asset("assets/logos/logo-only.png") }}');
        background-size: cover;
        width: 20px;
        height: 20px;
        border-radius: 100%;
        cursor: pointer;
    }

    .ui-autocomplete::-webkit-scrollbar {
        width: 0;
    }

    .ui-autocomplete {
        max-height: 200px;
        max-width: 15%;
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 1000;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    }

    .ui-state-focus {
        background-color: #f0f0f0;
    }

    .ui-menu-item {
        padding: 12px 8px;
        cursor: pointer;
        list-style-type: none;
        width: 100%;
        font-family: poppins-regular;
        font-size: 0.80rem;
    }

    .ui-menu-item:hover {
        background-color: #EDEDED;
    }

    .ui-autocomplete-loading {
        background: white url('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js') right center no-repeat;
    }

    #popup-procedure {
        overflow-y: scroll;
        scrollbar-width: none;
        -ms-overflow-style: none;
        max-height: 100%;
    }

    #popup-procedure::-webkit-scrollbar {
        display: none;
    }

    .procedure-contents {
        overflow-y: scroll;
        scrollbar-width: none;
        -ms-overflow-style: none;
        max-height: 100%;
    }

    .procedure-contents::-webkit-scrollbar {
        display: none;
    }
</style>
@endsection
@section('content')
<div id="map" class="relative w-full h-[calc(100vh-50px)] mt-[50px]">
    @include('home.layouts.popups')
    <div id="map-navbar" class="absolute top-1 left-[50%] translate-x-[-50%] z-50 bg-transparent rounded-md text-white-900 text-white font-poppins-light w-[80%] h-[35px] p-1 flex justify-between" style="display: none;">
        <div class="bg-upsdell-900 text-white rounded-full py-1 px-3">
            <span class="font-poppins-ultra">Procedure:</span>
            <spam id="map-navbar-name"></span>
        </div>
        <div class="bg-upsdell-900 text-white rounded-full py-1 px-3">
            Step No. <span id="map-navbar-step"></span>
        </div>
        <div class="bg-upsdell-900 text-white rounded-full py-1 px-3">
            <span class="font-poppins-ultra">Destination:</span> <span id="map-navbar-destination"></span>
        </div>
    </div>
</div>

<div id="directions-cont" class="fixed py-8 top-0 left-[-30%] w-[30%] h-full z-30">
    <h1 class="text-white font-poppins-regular p-2 text-center">Directions Here</h1>
    <div class="flex flex-col items-center gap-2 w-full h-full">
        <div class="w-[80%] h-[80%] rounded-lg bg-white p-2" style="overflow-y: auto;">
            <div id="initial-instructions-cont" class="font-poppins-light text-[0.80rem]"></div>
            <div id="instructions-cont" class="font-poppins-light text-[0.80rem]"></div>
        </div>
        <div class="w-[80%] bg-transparent flex justify-between">
            <button type="button" class="shine bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-12 font-poppins-regular flex justify-center items-center text-[0.75rem]" id="procedure-prev-btn">Prev</button>
            <button type="button" class="shine bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-12 font-poppins-regular flex justify-center items-center text-[0.75rem]" id="procedure-end-btn">End</button>
            <button type="button" class="shine bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-12 font-poppins-regular flex justify-center items-center text-[0.75rem]" id="procedure-next-btn">Next</button>
        </div>
    </div>
</div>

<div id="procedures-cont" class="fixed py-8 top-0 left-[-20%] w-[20%] h-full bg-upsdell-900 z-30">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" id="procedures-close-btn" fill="white" class="bi bi-x-circle-fill absolute top-[2.5%] right-[5%] hover:cursor-pointer" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
    </svg>
    <h1 class="text-white font-gordita-regular p-2 text-center">Procedures</h1>
    <div class="flex justify-center mt-2">
        <ul class="w-[90%] text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @if(count($procedures) > 1)
            @foreach($procedures as $procedure)
            @if ($loop->first)
            <li procedure_id='{{ $procedure->id }}' class="procedure-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600">{{ $procedure->procedure_name }}</li>
            @elseif ($loop->last)
            <li procedure_id='{{ $procedure->id }}' class="procedure-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light px-4 py-2 border-t border-gray-200 rounded-b-lg dark:border-gray-600">{{ $procedure->procedure_name }}</li>
            @else
            <li procedure_id='{{ $procedure->id }}' class="procedure-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light border px-4 py-2">{{ $procedure->procedure_name }}</li>
            @endif
            @endforeach
            @elseif(count($procedures) == 1)
            <li procedure_id='{{ $procedures[0]->id }}' class="procedure-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light px-4 py-2 rounded-lg border-gray-200 dark:border-gray-600">{{ $procedures[0]->procedure_name }}</li>
            @else
            <li class="w-full font-poppins-light px-4 py-2 border-b rounded-lg border-gray-200 dark:border-gray-600">No Records Found</li>
            @endif
        </ul>
    </div>
</div>

<div id="events-cont" class="fixed py-8 top-0 left-[-20%] w-[20%] h-full bg-upsdell-900 z-30">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" id="events-close-btn" fill="white" class="bi bi-x-circle-fill absolute top-[2.5%] right-[5%] hover:cursor-pointer" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
    </svg>
    <h1 class="text-white font-poppins-regular p-2 text-center">Events</h1>
    <div class="flex justify-center mt-2">
        <ul class="w-[90%] text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @if(count($events) > 1)
            @foreach($events as $event)
            @if ($loop->first)
            <li event_id='{{ $event->id }}' class="event-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600">{{ $event->event_name }}</li>
            @elseif ($loop->last)
            <li event_id='{{ $event->id }}' class="event-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light px-4 py-2 border-t border-gray-200 rounded-b-lg dark:border-gray-600">{{ $event->event_name }}</li>
            @else
            <li event_id='{{ $event->id }}' class="event-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light border px-4 py-2">{{ $event->event_name }}</li>
            @endif
            @endforeach
            @elseif(count($events) == 1)
            <li event_id='{{ $events[0]->id }}' class="event-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light px-4 py-2 rounded-lg border-gray-200 dark:border-gray-600">{{ $events[0]->event_name }}</li>
            @else
            <li class="w-full font-poppins-light px-4 py-2 border-b rounded-lg border-gray-200 dark:border-gray-600">No Records Found</li>
            @endif
        </ul>
    </div>
</div>
@endsection
@section('more_scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>
<script>
    $(document).ready(function() {
        // Map Initialization
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2Ftc3RyZWV0IiwiYSI6ImNsczRxb29mdTE1ZmkybHBjcHBhcG9xN2kifQ.SpJ2sxffT8PRfQjFtYgg6Q';
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/samstreet/clu2rl1ub024601oigzn6960q',
            zoom: 17,
            minZoom: 16,
            center: [124.2438547179179, 8.2414298468554],
            bearing: -95,
            maxBounds: [
                [124.23616973647256, 8.233619024568284], // Southwest bound
                [124.25301604017682, 8.248537110726303] // Northeast bound
            ]
        });
        map.addControl(new mapboxgl.NavigationControl());

        // Initialize the GeolocateControl.
        const geolocate = new mapboxgl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true
            },
            trackUserLocation: true
        });
        // Add the control to the map.
        map.addControl(geolocate);
        // Set an event listener that fires
        // when a geolocate event occurs.
        geolocate.on('geolocate', (response) => {
            console.log(response.coords.longitude);
            console.log(response.coords.latitude);
        });
        // End of Map Initialization

        // Element Rendering
        function renderElements(building = null, marker = null, entrypoint = null, boundary = null) {
            var data = {};
            if (building) {
                data['building'] = true;
            }
            if (marker) {
                data['marker'] = true;
            }
            if (entrypoint) {
                data['entrypoint'] = true;
            }
            if (boundary) {
                data['boundary'] = true;
            }
            $.ajax({
                url: '{{ route("buildings.get") }}',
                data: data,
                success: function(response) {
                    if (building) {
                        console.log(response.buildings);
                    }
                    if (marker) {
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
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }
        renderElements(false, true, false, false);
        // End of Element Rendering

        // Map Elements Optimizations
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
        // End of Map Elements Optimizations

        // Building Information Functions
        $(document).on('click', '.display-marker', function() {
            var samplePopup = $('#popup-sample');
            if (samplePopupStatus == 0) {
                samplePopup.animate({
                    right: '7.5%'
                }, 500)
                samplePopupStatus = 1;
            } else {
                samplePopup.animate({
                    right: '-100%'
                }, 500)
                samplePopupStatus = 0;
            }
            var target = $(this).attr('display-marker');
            $('.popup-sample-btn').click();
            $('#popup-image').attr('src', '');
            $('#popup-building-description').text('');
            $('#popup-building-name').text('');
            $.ajax({
                url: '{{ route("buildings.find") }}',
                data: {
                    'target': target
                },
                success: function(response) {
                    $('.popup-sample-btn').click();
                    $('#popup-building-name').text(response.building.building_name);
                    var imageSourceA = 'storage/';
                    var imageSourceB = response.marker.marker_image;
                    $('#popup-image').attr('src', imageSourceA + imageSourceB);
                    $('#popup-building-description').text(response.details.building_description);
                },
                error: function(error) {
                    console.log(error);
                }
            })

        });
        // End of Building Information Functions

        // Dijkstra's Algorithm
        var directionsBtn = document.getElementById('popup-directions-btn');
        var origin = null;
        var destination = null;
        var gps_json = {};
        var npl_json = {};

        function renderDirection(route, gps_origin) {
            var allDisplayBoundaries = map.getStyle().layers.filter(function(layer) {
                return layer.id.startsWith('route-path-');
            });
            allDisplayBoundaries.forEach(function(layer) {
                map.removeLayer(layer.id);
            });
            allDisplayBoundaries.forEach(function(layer) {
                if (map.getSource(layer.source)) {
                    map.removeSource(layer.source);
                }
            });
            for (let i = 0; i < route.length - 1; i++) {
                if (i == 0 && route[i] == "GPS") {
                    renderPath([gps_json.coordinates], [npl_json.coordinates], 'full');
                } else if (i == 1 && route[i] == "NPL") {
                    renderPath([npl_json.coordinates], route[i + 1], 'half');
                } else {
                    renderPath(route[i], route[i + 1]);
                }
            }
            gpsSuccess({
                coords: {
                    longitude: 124.24450695486951,
                    latitude: 8.239895989653476
                }
            })
            var samplePopup = $('#popup-sample');
            samplePopup.animate({
                right: '-100%'
            }, 500)
        }

        function renderPath(a, b, raw = false) {
            if (raw === false) {
                $.ajax({
                    url: '{{ route("paths.find") }}',
                    data: {
                        'a': a,
                        'b': b,
                        'single_search': true
                    },
                    success: function(response) {
                        if (!response.skip) {
                            const lineCoordinates = [
                                [response.path.wp_a_lng, response.path.wp_a_lat],
                                [response.path.wp_b_lng, response.path.wp_b_lat]
                            ];
                            map.addLayer({
                                'id': `route-path-${response.path.id.toString()}`,
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
                                    'line-width': 4
                                }
                            }, 'waterway-label');

                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                })
            } else if (raw === true) {
                var tempLine = [
                    a,
                    b
                ];
                if (map.getSource('temporary-line')) {
                    map.removeLayer('temporary-line');
                    map.removeSource('temporary-line');
                }
                map.addLayer({
                    'id': `temporary-line`,
                    'type': 'line',
                    'source': {
                        'type': 'geojson',
                        'data': {
                            'type': 'Feature',
                            'properties': {},
                            'geometry': {
                                'type': 'LineString',
                                'coordinates': tempLine
                            }
                        }
                    },
                    'layout': {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    'paint': {
                        'line-color': 'blue',
                        'line-width': 4
                    }
                }, 'waterway-label');
            } else if (raw == 'full') {
                const lineCoordinates = [
                    a[0],
                    b[0]
                ];
                map.addLayer({
                    'id': `route-path-gps`,
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
                        'line-width': 4
                    }
                }, 'waterway-label');
                var thisMarker = new mapboxgl.Marker({
                        className: 'gps-marker'
                    })
                    .setLngLat(a[0], a[1])
                    .addTo(map);
            } else if (raw == 'half') {
                $.ajax({
                    url: '{{ route("paths.find") }}',
                    data: {
                        'code': b,
                        'half': true
                    },
                    success: (response) => {
                        const lineCoordinates = [
                            a[0],
                            response.result_path
                        ];
                        map.addLayer({
                            'id': `route-path-gps-half`,
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
                                'line-width': 4
                            }
                        }, 'waterway-label');
                    },
                    error: (error) => {
                        console.log(error)
                    }
                })
            }
        }
        directionsBtn.addEventListener('click', function(e) {
            var data = {
                'origin': 'A',
                'destination': 'ED'
            }
            $.ajax({
                url: '{{ route("directions.get") }}',
                data: data,
                success: (response) => {
                    renderDirection(response.route);
                },
                error: (error) => {
                    console.log(error);
                }
            })
        });

        function multipleCalculations(origin_points, destination_points, additionalData = null) {
            var shortestRoute = null;
            var totalRequests = origin_points.length * destination_points.length;
            var completedRequests = 0;
            origin_points.forEach(function(origin) {
                destination_points.forEach(function(destination) {
                    if (_gps === false) {
                        var data = {
                            'origin': origin,
                            'destination': destination,
                            'single_search': true,
                            'weight': true
                        }
                    } else {
                        var data = {
                            'origin': origin,
                            'destination': destination,
                            'single_search': true,
                            'weight': true,
                            'gps': true,
                            'nearest_path_id': additionalData.nearestPathId,
                            'GPSNPL': additionalData.GPSNPL,
                            'NPLA': additionalData.NPLA,
                            'NPLB': additionalData.NPLB
                        }
                    }
                    $.ajax({
                        url: '{{ route("directions.get") }}',
                        data: data,
                        success: function(response) {
                            if (!shortestRoute || response.weight < shortestRoute[1]) {
                                shortestRoute = [response.route, response.weight];
                            }
                            completedRequests++;

                            // Check if all requests are completed
                            if (completedRequests === totalRequests) {
                                renderDirection(shortestRoute[0]);
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            completedRequests++;

                            // Check if all requests are completed
                            if (completedRequests === totalRequests) {
                                renderDirection(shortestRoute ? shortestRoute[0] : []);
                            }
                        }
                    });
                });

            });
        }
        // End of Dijkstra's Algorithm

        // Searchbar Functions
        var building_names = [];

        $.ajax({
            url: '{{ route("buildings.get") }}',
            data: {
                'names': true
            },
            success: (response) => {
                building_names = response.names;
                $('#starting-point').autocomplete({
                    source: building_names
                });
                $('#destination').autocomplete({
                    source: building_names
                });
            },
            error: (error) => {
                console.log(error);
            }
        });

        $('#sidebar-searchbar').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            data += '&sidebar=true';
            console.log(data);
            if (_gps === false) {
                $.ajax({
                    url: '{{ route("directions.get.polarpoints") }}',
                    data: data,
                    success: (response) => {
                        var origin_decoded = JSON.parse(JSON.parse(response.target_origin.entrypoints));
                        var destination_decoded = JSON.parse(JSON.parse(response.target_destination.entrypoints));
                        var origin_points = [];
                        var destination_points = [];
                        for (let key in origin_decoded) {
                            origin_points.push(origin_decoded[key].code);
                        }
                        for (let key in destination_decoded) {
                            destination_points.push(destination_decoded[key].code);
                        }
                        multipleCalculations(origin_points, destination_points);
                    },
                    error: (error) => {
                        console.log(error);
                    }
                })
            } else {
                var currentLocationSample = [124.24333777347061, 8.240546148594902];
                nearestLine(currentLocationSample);
            }
        });
        // End of Searchbar Functions

        // Realtime Origin Point
        function gpsSuccess(position) {
            var coords = position.coords;
            map.easeTo({
                center: [coords.longitude, coords.latitude],
                zoom: 22,
                duration: 2000,
                pitch: 75,
                bearing: 0
            });
        }
        var originPointInput = document.getElementById('starting-point');
        var currentLocBtn = document.getElementById('current-location');
        var _gps = false;
        Object.defineProperty(window, 'gps', {
            get: function() {
                return _gps;
            },
            set: function(value) {
                if (value === true) {
                    disableOriginInput();
                    _gps = true;
                } else if (value === false) {
                    enableOriginInput();
                    removeGpsMarker();
                    _gps = false;
                }
            }
        });

        function removeGpsMarker() {
            var gpsMarkers = document.querySelectorAll('.gps-marker');
            gpsMarkers.forEach(function(gpsMarker) {
                gpsMarker.remove();
            })
        }

        currentLocBtn.addEventListener('click', function() {
            if (_gps === true) {
                gps = false
            } else if (_gps === false) {
                gps = true
            }
        });

        function disableOriginInput() {
            originPointInput.setAttribute('readonly', '');
            originPointInput.value = 'Your Location';
            originPointInput.style.backgroundColor = '#ffea82';
        }

        function enableOriginInput() {
            originPointInput.removeAttribute('readonly');
            originPointInput.value = '';
            originPointInput.style.backgroundColor = 'white';
            if (map.getSource('temporary-line')) {
                map.removeLayer('temporary-line');
                map.removeSource('temporary-line');
            }
            var allDisplayBoundaries = map.getStyle().layers.filter(function(layer) {
                return layer.id.startsWith('route-path-');
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

        function locateUser() {
            var thisLine = [
                [124.24372302907886, 8.242335593748535],
                [124.24354731894357, 8.242714235990405]
            ]
            map.addLayer({
                'id': `route-path`,
                'type': 'line',
                'source': {
                    'type': 'geojson',
                    'data': {
                        'type': 'Feature',
                        'properties': {},
                        'geometry': {
                            'type': 'LineString',
                            'coordinates': thisLine
                        }
                    }
                },
                'layout': {
                    'line-join': 'round',
                    'line-cap': 'round'
                },
                'paint': {
                    'line-color': 'blue',
                    'line-width': 4
                }
            }, 'waterway-label');
        }
        map.on('click', (e) => {
            console.log(e.lngLat);
        });

        function nearestLine(currentLoc, returnValue = null) {
            var point = turf.point(currentLoc);
            $.ajax({
                url: '{{ route("paths.get") }}',
                data: '',
                success: (response) => {
                    const lineStrings = [];
                    var results = response.paths;
                    results.forEach(function(path, index) {
                        // Construct GeoJSON features for each LineString
                        const lineStringFeature = turf.lineString([
                            [path.wp_a_lng, path.wp_a_lat],
                            [path.wp_b_lng, path.wp_b_lat]
                        ], {
                            id: path.id
                        });
                        lineStrings.push(lineStringFeature);
                    });

                    let nearestLineString;
                    let minDistance = Infinity;
                    // Iterate through each LineString to find the nearest one
                    lineStrings.forEach(lineString => {
                        const distance = turf.pointToLineDistance(point, lineString, {
                            units: 'meters'
                        });

                        // Update the nearest LineString if a closer one is found
                        if (distance < minDistance) {
                            minDistance = distance;
                            nearestLineString = lineString;
                        }
                    });
                    nearestPointOnLine(currentLoc, nearestLineString.properties.id);
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }

        function nearestLineNew(currentLoc, returnValue = null) {
            return new Promise((resolve, reject) => {
                var point = turf.point(currentLoc);
                $.ajax({
                    url: '{{ route("paths.get") }}',
                    data: '',
                    success: (response) => {
                        const lineStrings = [];
                        var results = response.paths;
                        results.forEach(function(path, index) {
                            // Construct GeoJSON features for each LineString
                            const lineStringFeature = turf.lineString([
                                [path.wp_a_lng, path.wp_a_lat],
                                [path.wp_b_lng, path.wp_b_lat]
                            ], {
                                id: path.id
                            });
                            lineStrings.push(lineStringFeature);
                        });

                        let nearestLineString;
                        let minDistance = Infinity;
                        // Iterate through each LineString to find the nearest one
                        lineStrings.forEach(lineString => {
                            const distance = turf.pointToLineDistance(point, lineString, {
                                units: 'meters'
                            });

                            // Update the nearest LineString if a closer one is found
                            if (distance < minDistance) {
                                minDistance = distance;
                                nearestLineString = lineString;
                            }
                        });
                        if (returnValue) {
                            resolve(nearestLineString.properties.id);
                        } else {
                            resolve(nearestPointOnLine(currentLoc, nearestLineString.properties.id));
                        }
                    },
                    error: (error) => {
                        reject(error);
                    }
                });
            });
        }

        function nearestPointOnLine(currentLoc, nearestLine, procedure = null) {
            const {
                nearestPointOnLine
            } = turf;
            $.ajax({
                url: '{{ route("paths.find") }}',
                data: {
                    'id_search': true,
                    'id': nearestLine
                },
                success: (response) => {
                    var path = response.path;
                    var point = turf.point(currentLoc);
                    var line = turf.lineString([
                        [path.wp_a_lng, path.wp_a_lat],
                        [path.wp_b_lng, path.wp_b_lat]
                    ]);
                    var snapped = turf.nearestPointOnLine(line, point, {
                        units: 'miles'
                    });

                    var nearestPoint = [snapped.geometry.coordinates[0], snapped.geometry.coordinates[1]];
                    if (procedure) {
                        temporaryPoints(currentLoc, nearestPoint, path, procedure);
                    } else {
                        temporaryPoints(currentLoc, nearestPoint, path);
                    }
                },
                error: (error) => {
                    console.log(error);
                }
            })
        }

        function temporaryPoints(GPS, NPL, path, procedure = null) {
            gps_json = {};
            gps_json = {
                'coordinates': GPS
            }
            npl_json = {};
            npl_json = {
                'coordinates': NPL
            };
            var GPSNPL = turf.distance(turf.point(GPS), turf.point(NPL), {
                units: 'meters'
            })
            var NPLA = turf.distance(turf.point(NPL), turf.point([path.wp_a_lng, path.wp_a_lat]), {
                units: 'meters'
            });
            var NPLB = turf.distance(turf.point(NPL), turf.point([path.wp_b_lng, path.wp_b_lat]), {
                units: 'meters'
            });
            if (procedure) {
                var destination = document.getElementById('map-navbar-destination').innerText;
            } else {
                var destination = document.getElementById('destination').value;
            }
            $.ajax({
                url: '{{ route("directions.get.polarpoints") }}',
                data: {
                    'destination': destination
                },
                success: (response) => {
                    var destination_points = [];
                    var destination_decoded = JSON.parse(JSON.parse(response.target_destination.entrypoints));
                    for (let key in destination_decoded) {
                        destination_points.push(destination_decoded[key].code);
                    }
                    multipleCalculations(
                        GPS,
                        destination_points, {
                            'nearestPathId': path.id,
                            'GPSNPL': GPSNPL,
                            'NPLA': NPLA,
                            'NPLB': NPLB
                        }
                    );
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }
        // End of Realtime Origin Point
        var polygonData = {
            'type': 'FeatureCollection',
            'features': [{
                'type': 'Feature',
                'properties': {
                    'description': 'School of Engineering Technology'
                },
                'geometry': {
                    'type': 'Polygon',
                    'coordinates': [
                        [
                            [124.24394963376335, 8.240492844326639],
                            [124.24443740131852, 8.24040243975439],
                            [124.24453083874386, 8.24122316165223],
                            [124.24406612293791, 8.24128212387022]
                        ]
                    ]
                }
            }]
        };
        map.on('load', function() {
            map.addSource('polygon', {
                'type': 'geojson',
                'data': polygonData
            });

            map.addLayer({
                'id': 'polygon-labels',
                'type': 'symbol',
                'source': 'polygon',
                'layout': {
                    'text-field': ['get', 'description'],
                    'text-size': 12,
                    'text-anchor': 'top',
                    'symbol-placement': 'point', // Set symbol placement to 'point'
                    'text-offset': [0, -2] // Adjust text offset to position it above the building
                },
                'paint': {
                    'text-color': '#000000' // Adjust text color as needed
                }
            });
        });

        // Procedures Functions
        var procedurePopupStatus = 0;
        $('.procedure-item').click(function() {
            var procedurePopup = $('#popup-procedure');
            if (procedurePopupStatus == 0) {
                displayProcedureTimeline($(this).attr('procedure_id'));
                procedurePopup.animate({
                    right: '7.5%'
                }, 500)
                procedurePopupStatus = 1;
            } else {
                procedurePopup.animate({
                    right: '-100%'
                }, 500)
                procedurePopupStatus = 0;
            }
        });
        $('.popup-procedure-close-btn').on('click', function() {
            var procedurePopup = $('#popup-procedure');
            procedurePopup.animate({
                right: '-100%'
            }, 500)
            procedurePopupStatus = 0;
        });

        function displayProcedureTimeline(id) {
            $.ajax({
                url: '{{ route("procedures.get") }}',
                data: {
                    'id': id
                },
                success: (response) => {
                    $('#popup-procedure-name').text(response.target_procedure.procedure_name);
                    $('#popup-procedure-description').text(response.target_procedure.procedure_description);
                    $('#procedure_id').text(response.target_procedure.id);
                    var timeline = document.getElementById('timeline');
                    timeline.innerHTML = ``;
                    var waypoints = response.waypoints;
                    for (let key in waypoints) {
                        timeline.innerHTML += `
                    <div class="w-[100%] bg-transparent flex justify-center items-center mb-5">
                        <div class="w-[80%] py-6 shadow-[rgba(0,_0,_0,_0.24)_0px_3px_8px] rounded-lg flex justify-center">
                            <a href="#" class="flex flex-col w-[100%] items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="${decodeURIComponent('{{ asset("storage/") }}' + "/" + waypoints[key].photo)}" alt="">
                                <div class="flex flex-col justify-between p-4 leading-normal">
                                    <h1>Step ${waypoints[key].step_no}</h1>
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">${waypoints[key].building.building_name}</h5>
                                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">${waypoints[key].instructions}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    `;
                    }
                },
                error: (error) => {
                    console.log(error);
                }
            })
        }

        var procedureDirectionBtns = document.querySelectorAll('.popup-procedure-btn');
        procedureDirectionBtns.forEach(function(button) {
            button.addEventListener('click', function() {
                var pro_id = document.getElementById('procedure_id').innerText;
                $.ajax({
                    url: '{{ route("procedures.get") }}',
                    data: {
                        'id': pro_id
                    },
                    success: (response) => {
                        beginProcedureNagivation(response);
                    },
                    error: (error) => {
                        console.log(error)
                    }
                })
            })
        })

        var _procedure_step = 0;
        var totalWaypoints = 0;
        var response_json = {};

        function beginProcedureNagivation(json) {
            $('#sidebar-btn').hide();
            var procedures = $('#procedures-cont');
            procedures.animate({
                left: '-20%'
            }, 500)
            var procedurePopup = $('#popup-procedure');
            procedurePopup.animate({
                right: '-100%'
            }, 500)
            procedurePopupStatus = 0;
            var waypoints = json.waypoints;
            var procedureLoop = true;
            totalWaypoints = Object.keys(waypoints).length - 1;
            response_json = json;
            procedure_step = 0;
        }

        Object.defineProperty(window, 'procedure_step', {
            get: function() {
                return _procedure_step;
            },
            set: function(value) {
                beginStep(value, (totalWaypoints), response_json);
                _procedure_step = value;
                $('#procedure-next-btn').css('visibility', 'visible');
                $('#procedure-prev-btn').css('visibility', 'visible');
                if (value == 0) {
                    $('#procedure-prev-btn').css('visibility', 'hidden');
                } else if (value == totalWaypoints) {
                    $('#procedure-next-btn').css('visibility', 'hidden');
                }
            }
        });

        document.querySelector('#procedure-next-btn').addEventListener('click', function() {
            if (_procedure_step !== (totalWaypoints)) {
                beginStep(procedure_step = _procedure_step + 1, totalWaypoints, json);
            }
        });

        document.querySelector('#procedure-prev-btn').addEventListener('click', function() {
            if (_procedure_step > 0) {
                beginStep(procedure_step = _procedure_step - 1, totalWaypoints, json);
            }
        });
        document.querySelector('#procedure-end-btn').addEventListener('click', function() {
            endProcedureNavigation();
        });

        function beginStep(index, totalWaypoints, json) {
            if (index == 0) {
                displayRoute(json.waypoints[index].building_id);
                displaySidebar(json.waypoints[index].instructions, json.target_procedure.initial_instructions);
            } else {
                displayRoute(json.waypoints[index].building.building_name, json.waypoints[index - 1].building.building_name);
                displaySidebar(json.waypoints[index].instructions);
            }
            displayProcedureNavbar(json.target_procedure.procedure_name, json.waypoints[index].step_no, json.waypoints[index].building.building_name); // procedure name, step name, destination name
        }

        function displayRoute(destination, origin = null) {
            if (!origin) {
                var gps_point = locateUser();
                nearestLineNew(gps_point, true)
                    .then(nearestLineId => {
                        var nearestPointOnLineCoords = nearestPointOnLine(gps_point, nearestLineId, destination);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            } else {
                gps = false;
                $.ajax({
                    url: '{{ route("directions.get.polarpoints") }}',
                    data: {
                        'origin': origin,
                        'destination': destination,
                        'sidebar': true
                    },
                    success: (response) => {
                        var origin_decoded = JSON.parse(JSON.parse(response.target_origin.entrypoints));
                        var destination_decoded = JSON.parse(JSON.parse(response.target_destination.entrypoints));
                        var origin_points = [];
                        var destination_points = [];
                        for (let key in origin_decoded) {
                            origin_points.push(origin_decoded[key].code);
                        }
                        for (let key in destination_decoded) {
                            destination_points.push(destination_decoded[key].code);
                        }
                        multipleCalculations(origin_points, destination_points);
                    },
                    error: (error) => {
                        console.log(error);
                    }
                })
                // get destination (building) entrypoints
                // get origin (building) entrypoints
                // directions.get
                // display route
                // display walking distance
            }
        }

        function locateUser() {
            var currentLocationSample = [124.24333777347061, 8.240546148594902];
            _gps = true;
            return currentLocationSample;
        }

        function displayProcedureNavbar(name, step, destination) {
            $('#map-navbar').show();
            $('#map-navbar-name').text(name);
            $('#map-navbar-step').text(step);
            $('#map-navbar-destination').text(destination);
        }

        function hideProcedureNavbar() {
            $('#map-navbar').hide();
        }

        function displaySidebar(instructions, initial = null) {
            instructionsSidebar(true);
            $('#initial-instructions-cont').text('');
            if (initial) {
                $('#initial-instructions-cont').text(initial);
            }
            $('#instructions-cont').text(instructions);
        }

        function endProcedureNavigation() {
            // delete all map styles
            // delete all map sources
            $('#sidebar-btn').show();
            var procedures = $('#procedures-cont');
            procedures.animate({
                left: '0%'
            }, 500)
            procedurePopupStatus = 0;
            hideProcedureNavbar();
            instructionsSidebar(false);
            response_json = {};
            totalWaypoints = 0;
            var allDisplayBoundaries = map.getStyle().layers.filter(function(layer) {
                return layer.id.startsWith('route-path-');
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

        // End of Procedures Functions
        function instructionsSidebar(state) {
            var directions = $('#directions-cont');
            var navbar = $('#navbar');
            var map = $('#map');
            var sidebar = $('#sidebar');

            if (state) {
                directions.animate({
                    left: '0%'
                }, 500)
                navbar.animate({
                    width: '70%',
                    marginLeft: '30%'
                }, 500);
                map.animate({
                    width: '70%',
                    marginLeft: '30%'
                }, 500)

                if (sidebarStatus == 1) {
                    sidebar.animate({
                        left: "-20%"
                    }, 500)

                    sidebarStatus = 0;
                }
            } else {
                directions.animate({
                    left: '-30%'
                }, 500)
                navbar.animate({
                    width: '80%',
                    marginLeft: '20%'
                }, 500);
                map.animate({
                    width: '80%',
                    marginLeft: '20%'
                }, 500)
            }

        }
    });

    // Events Functions
    document.querySelectorAll('.event-item').forEach(function(element) {
        element.addEventListener('click', function() {
            var eventID = $(this).attr('event_id');
            getEvent(eventID);
        })
    })

    function getEvent(id) {
        $.ajax({
            url: '{{ route("events.get") }}',
            data: {
                'id': id
            },
            success: (response) => {
                console.log(response);
                return openEventModal(response.target_event);
            },
            error: (error) => {
                console.log(error);
            }
        })
    }

    function openEventModal(json) {
        console.log(json)
        $('#popup-event-name').text(json.event_name);
        $('#popup-event-description').text(json.event_description);
        if (json.building.building_marker.marker_image) {
            var marker_image = decodeURIComponent('{{ asset("storage/") }}' + "/" + json.building.building_marker.marker_image); // Decode URL
            $('#popup-event-image').attr('src', marker_image);
        }
        var eventPopup = $('#popup-event');
        if (eventPopupStatus == 0) {
            eventPopup.animate({
                right: '7.5%'
            }, 500)
            eventPopupStatus = 1;
        } else {
            eventPopup.animate({
                right: '-100%'
            }, 500)
            eventPopupStatus = 0;
        }
    }
    // End of Events Functions
</script>
@endsection