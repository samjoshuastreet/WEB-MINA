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
</style>
@endsection
@section('content')
<div id="map" class="relative w-full h-[calc(100vh-50px)] mt-[50px]">
    @include('home.layouts.popups')
</div>

<div id="directions-cont" class="fixed py-8 top-0 left-[-30%] w-[30%] h-full bg-upsdell-900 z-30">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" id="directions-close-btn" fill="white" class="bi bi-x-circle-fill absolute top-[2.5%] right-[5%] hover:cursor-pointer" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
    </svg>
    <h1 class="text-white font-poppins-regular p-2 text-center">Directions Here</h1>
</div>
@endsection
@section('more_scripts')
<script>
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
        var target = $(this).attr('display-marker');
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

            }
        })

    });
    // End of Building Information Functions

    // Dijkstra's Algorithm
    var directionsBtn = document.getElementById('popup-directions-btn');

    function renderDirection(route) {
        console.log(route);
        for (let i = 0; i < route.length - 1; i++) {
            var response = renderPath(route[i], route[i + 1]);
            console.log(response);
        }
        $('.popup-sample-btn').click();
    }

    function renderPath(a, b) {
        $.ajax({
            url: '{{ route("paths.find") }}',
            data: {
                'a': a,
                'b': b,
                'single_search': true
            },
            success: function(response) {
                const lineCoordinates = [
                    [response.path.wp_a_lng, response.path.wp_a_lat],
                    [response.path.wp_b_lng, response.path.wp_b_lat]
                ]
                map.addLayer({
                    'id': response.path.id.toString(),
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
            error: function(error) {
                console.log(error);
            }
        })
    }
    directionsBtn.addEventListener('click', function(e) {
        var data = {
            'origin': 'A',
            'destination': 'ss'
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
    // End of Dijkstra's Algorithm
</script>
@endsection