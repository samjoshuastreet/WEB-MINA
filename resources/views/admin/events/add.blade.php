@extends('admin.layouts.layout')
@section('more_links')
<style>
    .initial {
        max-height: 100%;
        overflow-y: scroll;
        /* Hide scrollbar for Firefox */
        scrollbar-width: none;
        /* Hide scrollbar for IE, Edge, and Chrome */
        -ms-overflow-style: none;
        border-radius: 15px;
    }

    /* Hide scrollbar for Chrome, Safari, and Opera */
    .initial::-webkit-scrollbar {
        display: none;
    }
</style>
@endsection
@section('title', 'Admin - Add an Event')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Events</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Admin</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid" style="position: relative;">
            <div class="row">
                <div id="map" style="height: 100vh; width: 100vw; position: relative;"></div>
            </div>
            <div id="map-nav" class="bg-light rounded mt-2 ml-2 p-2 d-flex justify-content-center align-items-center border" style="position: absolute; z-index: 2; top: 0; left: 0;">
                <small class="m-0 mr-2">
                    <span id="navbar-instructions" class="text-bold">Step 2: Select a building for this procedure's waypoint destination/s.</span>
                </small>
                <small class="m-0 mr-2 text-primary ml-1">
                    <span id="bldg-name-hover"></span>
                </small>
                <button id="cancel-btn" type="button" class="btn btn-sm btn-danger ml-1">Cancel</button>
            </div>
            <div id="event-form-container" class="rounded" style="position: absolute; top: 50%; left: 50%; transform:translate(-50%, -50%); z-index: 5; height: 95%; width: 75%; background-color: transparent;">
                <div class="modal-content initial" style="max-height: 100%; overflow-y: scroll;">
                    <form id="event-form" action="">
                        <div class="modal-header">
                            <h5 class="modal-title waypoint-modal-title">Add an Event</h5>
                        </div>
                        <div class="modal-body">
                            <h6 class="ms-3">Event Name</h6>
                            <div class="input-group flex-nowrap">
                                <div class="form-floating input-group">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-alphabet-uppercase" viewBox="0 0 16 16">
                                            <path d="M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83" />
                                        </svg>
                                    </span>
                                    <input type="text" id="event_name" name="event_name" class="form-control" placeholder="Add a name for this event" aria-label="Username" aria-describedby="addon-wrapping">
                                </div>
                            </div>
                            <small id="event_name_error" class="form-text ml-5 mb-3 text-danger error-field"></small>
                            <h6 class="ms-3">Event Description</h6>
                            <div class="input-group flex-nowrap">
                                <div class="form-floating input-group">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-alphabet-uppercase" viewBox="0 0 16 16">
                                            <path d="M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83" />
                                        </svg>
                                    </span>
                                    <textarea id="event_description" name="event_description" type="text" rows="3" class="form-control" placeholder="Add a description for this event" aria-label="Username" aria-describedby="addon-wrapping"></textarea>
                                </div>
                            </div>
                            <small id="event_description_error" class="form-text ml-5 mb-3 text-danger error-field"></small>
                            <h6 class="ms-3">Instructions</h6>
                            <div class="input-group flex-nowrap">
                                <div class="form-floating input-group">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-alphabet-uppercase" viewBox="0 0 16 16">
                                            <path d="M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83" />
                                        </svg>
                                    </span>
                                    <textarea id="instructions" name="instructions" type="text" rows="5" class="form-control" placeholder="Add a set of instructions/requirements for the user with regards to this event." aria-label="Username" aria-describedby="addon-wrapping"></textarea>
                                </div>
                            </div>
                            <small id="instructions_error" class="form-text ml-5 mb-3 text-danger error-field"></small>
                            <h6 class="ms-3">Access Level</h6>
                            <div class="input-group flex-nowrap">
                                <div class="input-group">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1" />
                                        </svg>
                                    </span>
                                    <select id="access_level" name="access_level" class="form-control" aria-label="Default select example">
                                        <option selected>Select an accessibility level for this procedure</option>
                                        <option value=1>Guest Level</option>
                                        <option value=2>Student Level</option>
                                        <option value=3>Staff Level</option>
                                        <option value=4>Faculty Level</option>
                                    </select>
                                </div>
                            </div>
                            <small id="access_level_error" class="form-text ml-5 mb-3 text-danger error-field"></small>
                            <h6 class="ms-3">Event Start Date</h6>
                            <div class="input-group flex-nowrap">
                                <div class="form-floating input-group">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-alphabet-uppercase" viewBox="0 0 16 16">
                                            <path d="M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83" />
                                        </svg>
                                    </span>
                                    <input class="form-control" type="datetime-local" name="start_date" value="" id="start_date">
                                </div>
                            </div>
                            <small id="start_date_error" class="form-text ml-5 mb-3 text-danger error-field"></small>
                            <h6 class="ms-3">Event End Date</h6>
                            <div class="input-group flex-nowrap">
                                <div class="form-floating input-group">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-alphabet-uppercase" viewBox="0 0 16 16">
                                            <path d="M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83" />
                                        </svg>
                                    </span>
                                    <input class="form-control" type="datetime-local" name="end_date" value="" id="end_date">
                                </div>
                            </div>
                            <small id="end_date_error" class="form-text ml-5 mb-3 text-danger error-field"></small>
                            <h6 class="ms-3">Location</h6>
                            <div class="input-group flex-nowrap">
                                <div class="form-floating input-group">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-alphabet-uppercase" viewBox="0 0 16 16">
                                            <path d="M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83" />
                                        </svg>
                                    </span>
                                    <input type="text" id="building_id" name="building_id" class="form-control" placeholder="Where is this event located?" aria-label="Username" aria-describedby="addon-wrapping" style="cursor: context-menu;" readonly>
                                    <button type="button" id="building-btn" class="btn btn-primary btn-sm">Open Map</button>
                                </div>
                            </div>
                            <small id="building_id_error" class="form-text ml-5 mb-3 text-danger error-field"></small>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('more_scripts')
<script>
    // Toastr Initializations
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    // End of Toastr Initializations

    // Universal Variables

    // End of Universal Variables

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
    // End of Map Initializations

    // Modal Functions
    function closeForm() {
        $('#event-form-container').animate({
            left: '150%'
        }, function() {
            $(this).css('display', 'none');
        });
    }

    function openForm() {
        $('#event-form-container').show();
        $('#event-form-container').animate({
            left: '50%'
        });
    }

    $('#event-form').submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        var bldg_id = $('#building_id').attr('building_id');
        data += `&bldg_id=${bldg_id}}`;
        $.ajax({
            url: '{{ route("events.add.validate") }}',
            data: data,
            success: (response) => {
                var errorFields = document.querySelectorAll('.error-field');
                errorFields.forEach(function(errorField) {
                    errorField.innerText = '';
                });
                if (response.success == true) {
                    Toast.fire({
                        icon: 'success',
                        title: `${response.event} was successfully added.`
                    });
                    $('#event-form')[0].reset();
                } else if (response.success == false) {
                    var errors = response.msg;
                    displayValidationErrors(errors);
                }
            },
            error: (error) => {
                console.log(error);
            }
        })
    })

    function displayValidationErrors(errors) {
        for (let key in errors) {
            if (key == 'access_level') {
                $('#access_level_error').text('The access level field is required.');
            } else {
                $(document).find(`#${key}_error`).text(errors[key]);
            }
        }
    }
    // End of Modal Funcions

    // Button Listeners
    $('#building-btn').click(function() {
        step = 2;
    })
    $('#cancel-btn').click(function() {
        step = 1;
    })
    // End of Button Listeners

    // Step Listeners
    var _step = 0;
    Object.defineProperty(window, 'step', {
        get: function() {
            return _step;
        },
        set: function(value) {
            if (value === 1) {
                $('#map-nav').css('visibility', 'hidden');
                openForm();
                _step = value;
            } else if (value === 2) {
                $('#map-nav').css('visibility', 'visible');
                closeForm();
                _step = value;
            } else if (value === 3) {
                $('#map-nav').css('visibility', 'hidden');
                openForm();
                _step = value;
            }
        }
    });
    step = 1;
    // End of Step Listeners

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
            if (boundary == 'name_included') {
                data['boundary_with_name'] = true;
            }
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
                if (boundary) {
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
                                'fill-color': '#fcff40',
                                'fill-opacity': 1
                            }
                        }, 'waterway-label');
                        map.on('mouseenter', `polygon-display-${boundary.id}`, function() {
                            if (_step == 2) {
                                map.setPaintProperty(`polygon-display-${boundary.id}`, 'fill-color', '#40fff9');
                                map.getCanvas().style.cursor = 'pointer';
                                $('#bldg-name-hover').text(boundary.building.building_name);
                            }
                        });
                        map.on('mouseleave', `polygon-display-${boundary.id}`, function() {
                            if (_step == 2) {
                                map.setPaintProperty(`polygon-display-${boundary.id}`, 'fill-color', '#fcff40');
                                map.getCanvas().style.cursor = '';
                                $('#bldg-name-hover').text('');
                            }
                        });
                        map.on('click', `polygon-display-${boundary.id}`, function() {
                            if (_step == 2) {
                                step = 3;
                                $('#building_id').val(boundary.building.building_name).attr('building_id', boundary.building.id);
                            }
                        });
                    })
                }
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
    renderElements(false, true, false, 'name_included');
    // End of Element Rendering
</script>
@endsection