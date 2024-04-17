@extends('admin.layouts.layout')
@section('title', 'Path Editor')
@section('more_links')
<style>
    .marker {
        background-color: black;
        width: 10px;
        height: 10px;
        border-radius: 100%;
        cursor: pointer;
    }

    .marker-label {
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
                    <h1 class="m-0">Path Editor</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Path Editor</a></li>
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
                    <small class="m-0 mr-2"><span id="instructions" class="text-bold">Select a Path to Modify.</span>
                    </small>
                    <small id="path-codes-cont" type="button" class="m-0 mr-2" style="display: none;">Path <span id="path-codes"></span> selected.</small>
                    <button id="edit-btn" type="button" class="btn btn-sm btn-warning ml-1" style="display: none;">Edit</button>
                    <button id="delete-btn" type="button" class="btn btn-sm btn-danger ml-1" style="display: none;">Delete</button>
                    <button id="edit-move-btn" type="button" class="btn btn-sm btn-primary ml-1" style="display: none;">Move</button>
                    <button id="edit-save-btn" type="button" class="btn btn-sm btn-primary ml-1" style="display: none;">Save Changes</button>
                    <button id="edit-cancel-btn" type="button" class="btn btn-sm btn-secondary ml-1" style="display: none;">Cancel</button>
                    <button id="deselect-btn" type="button" class="btn btn-sm btn-secondary ml-1" style="display: none;">Deselect</button>
                </div>
                <a href="{{ route('paths.add') }}" class="btn btn-sm btn-primary mt-2 mr-2 py-2 px-4" style="position: absolute; z-index: 20; top: 0; right: 0;">Add Path</a>
                <a id="path-reset-btn" class="btn btn-sm btn-danger mb-2 mr-2 py-1 px-1" style="position: absolute; z-index: 20; bottom: 0; right: 0;">Reset Paths</a>
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
    renderPaths();

    var marker;
    var wp_distance;
    var selectedPath;
    var selectedMarker;
    var originalLineColor = 'blue';
    var editMode = false;
    var moveMode = false;
    var deselectBtn = document.getElementById('deselect-btn');
    var editBtn = document.getElementById('edit-btn');
    var deleteBtn = document.getElementById('delete-btn');
    var editMoveBtn = document.getElementById('edit-move-btn');
    var editSaveBtn = document.getElementById('edit-save-btn');
    var editCancelBtn = document.getElementById('edit-cancel-btn');

    function pathSelected(target) {
        if (editMode == false) {
            $('#instructions').text('Select an action.');
            selectedPath = target;
            map.getStyle().layers.forEach(function(layer) {
                if (layer.id.startsWith('path-')) {
                    if (layer.id !== `path-${target}`) {
                        map.removeLayer(layer.id);
                    }
                }
            });
            Object.keys(map.getStyle().sources).forEach(function(sourceID) {
                if (sourceID !== `path-${target}`) {
                    map.removeSource(sourceID);
                }
            });
            document.querySelectorAll('.marker').forEach(function(marker) {
                if (marker.getAttribute('marker-id') !== target.toString()) {
                    marker.remove();
                }
            });
            $('#path-codes-cont').show();
            $.ajax({
                url: '{{ route("paths.find") }}',
                data: {
                    'target': target,
                    'editor': 'true'
                },
                success: function(response) {
                    $('#path-codes').text(response.codes.toUpperCase());
                },
                error: function(response) {
                    console.log(response);
                }
            });
            deselectBtn.style.display = '';
            // editBtn.style.display = '';
            deleteBtn.style.display = '';
        }
    }

    function pathDeselected() {
        selectedPath = null;
        renderPaths();
        originalLineColor = 'blue';
        deselectBtn.style.display = 'none';
        // editBtn.style.display = 'none';
        deleteBtn.style.display = 'none';
        $('#path-codes-cont').hide();
        $('#path-codes').text('');
        $('#instructions').text('Select a Path to Modify.');
    }

    deselectBtn.addEventListener('click', function() {
        pathDeselected();
    });

    function removeMarkersByPathId(pathId) {
        const markerElements = document.querySelectorAll('.marker');
        markerElements.forEach(markerElement => {
            const markerId = markerElement.getAttribute('marker-id');
            if (markerId === pathId.toString()) {
                markerElement.remove();
            }
        });
    }

    $(document).on('click', '.marker', function() {
        if (editMode == true) {
            var target = $(this).attr('code');
            target = target.replace('marker-code-', '');
            if (selectedMarker) {
                const temp = document.querySelector(`[code="marker-code-${selectedMarker}"]`);
                temp.style.backgroundColor = 'black';
            }
            selectedMarker = target;
            $(this).css('background-color', 'red');
            editMoveBtn.style.display = '';
        }
    });

    var temporaryMarker;

    editMoveBtn.addEventListener('click', function() {
        moveMode = true;
        renderPaths();
        const temp = document.querySelector(`[code="marker-code-${selectedMarker}"]`);
        temp.style.backgroundColor = 'red';
        editMoveBtn.style.display = 'none';
        $('#instructions').text('Select a new location to move.');
    });

    map.on('click', function(e) {
        if (moveMode == true) {
            if (temporaryMarker) {
                temporaryMarker.remove();
                temporaryMarker = null;
            }
            const el = document.createElement('div');
            el.className = 'marker';
            temporaryMarker = marker = new mapboxgl.Marker(el)
                .setLngLat(e.lngLat)
                .addTo(map);
        }
    });

    editCancelBtn.addEventListener('click', function() {
        editCancelBtn.style.display = 'none';
        editSaveBtn.style.display = 'none';
        editMoveBtn.style.display = 'none';
        deleteBtn.style.display = '';
        deselectBtn.style.display = '';
        // editBtn.style.display = '';
        originalLineColor = 'blue';
        map.setPaintProperty(`path-${selectedPath}`, 'line-color', 'blue');
        $('#instructions').text('Select an action.');
        editMode = false;
        moveMode = false;
        const temp = document.querySelector(`[code="marker-code-${selectedMarker}"]`);
        temp.style.backgroundColor = 'black';
        selectedMarker.remove();
        selectedMarker = null;
        temporaryMarker.remove();
        temporaryMarker = null;
    })

    editBtn.addEventListener('click', function() {
        $('#instructions').text('Select and endpoint to move.');
        originalLineColor = 'red';
        deleteBtn.style.display = 'none';
        deselectBtn.style.display = 'none';
        editBtn.style.display = 'none';
        map.setPaintProperty(`path-${selectedPath}`, 'line-color', 'red');
        editCancelBtn.style.display = '';
        editMode = true;
    })

    deleteBtn.addEventListener('click', function() {
        Swal.fire({
            title: "Are you sure you want to delete this path?",
            showDenyButton: true,
            confirmButtonText: "Yes",
            denyButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("paths.delete") }}',
                    data: {
                        'target': selectedPath
                    },
                    success: function(response) {
                        console.log('success');
                        Toast.fire({
                            icon: 'success',
                            title: `Path ${response.codes} has been deleted!`
                        })
                        map.removeLayer(`path-${selectedPath}`);
                        map.removeSource(`path-${selectedPath}`);
                        removeMarkersByPathId(selectedPath);
                        pathDeselected();
                    },
                    error: function(reponse) {
                        console.log(reponse);
                        console.log('error');
                    }
                });
            }
        });
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
                    const pathId = `path-${path.id.toString()}`;
                    var lineColor;
                    if (path.type == 'outdoor') {
                        lineColor = 'blue';
                    } else if (path.type == 'indoor') {
                        lineColor = '#FC0FC0';
                    } else if (path.type == 'pedestrian lane') {
                        lineColor = 'yellow';
                    } else if (path.type == 'road') {
                        lineColor = 'black';
                    }
                    map.addLayer({
                        'id': `path-${path.id.toString()}`,
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
                            'line-color': lineColor,
                            'line-width': [
                                'interpolate',
                                ['linear'],
                                ['zoom'],
                                16, 2,
                                17, 3,
                                18, 4,
                                19, 5,
                                20, 6,
                                21, 7,
                                22, 8
                            ]
                        }
                    }, 'waterway-label');

                    map.on('mouseenter', pathId, function() {
                        if (moveMode == false) {
                            map.setPaintProperty(pathId, 'line-color', 'red');
                            map.getCanvas().style.cursor = 'pointer';
                        }
                    });

                    map.on('mouseleave', pathId, function() {
                        if (moveMode == false) {
                            map.setPaintProperty(pathId, 'line-color', lineColor);
                            map.getCanvas().style.cursor = '';
                        }
                    });

                    map.on('click', pathId, function() {
                        pathSelected(path.id);
                    });

                    const ael = document.createElement('div');
                    ael.className = 'marker';
                    ael.setAttribute('code', `marker-code-${path.wp_a_code}`);
                    ael.setAttribute('marker-id', path.id);
                    const aLngLat = [path.wp_a_lng, path.wp_a_lat];
                    const aCodeValue = path.wp_a_code;
                    ael.innerHTML = `<span class="marker-label">${aCodeValue}</span>`;
                    var waypointa = new mapboxgl.Marker(ael)
                        .setLngLat(aLngLat)
                        .addTo(map);
                    const bel = document.createElement('div');
                    bel.className = 'marker';
                    bel.setAttribute('code', `marker-code-${path.wp_b_code}`);
                    bel.setAttribute('marker-id', path.id);
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

    $('#path-reset-btn').click(function() {
        Swal.fire({
            title: 'Resetting the path network means deleting all the existing paths in the database. Are you sure you want to reset the network of paths?',
            showDenyButton: true,
            confirmButtonText: 'Reset Paths',
            denyButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("paths.reset") }}',
                    data: '',
                    success: (response) => {
                        Toast.fire({
                            icon: 'success',
                            title: 'The network of paths has successfully been reset!'
                        })
                        renderPaths()
                    },
                    error: (error) => {
                        console.log(error);
                    }
                })
            }
        })
    });
</script>
@endsection