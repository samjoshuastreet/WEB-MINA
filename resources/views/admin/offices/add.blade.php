@extends('admin.layouts.layout')
@section('more_links')
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/cropperjs/cropper.min.css') }}" />
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
@section('title', 'Admin - Add an Office')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Office</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Add Office</li>
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
                    <span id="navbar-instructions" class="text-bold">Step 2: Which building is this office located?</span>
                </small>
                <small class="m-0 mr-2 text-primary ml-1">
                    <span id="bldg-name-hover"></span>
                </small>
                <button id="cancel-btn" type="button" class="btn btn-sm btn-danger ml-1">Cancel</button>
            </div>
            <div id="event-form-container" class="rounded" style="position: absolute; top: 50%; left: 50%; transform:translate(-50%, -50%); z-index: 5; height: 95%; width: 75%; background-color: transparent;">
                <div class="modal-content initial" style="max-height: 100%; overflow-y: scroll;">
                    <form id="event-form" action="">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title waypoint-modal-title">Add an Office</h5>
                        </div>
                        <div class="modal-body">
                            <h6 class="ms-3">Office Name</h6>
                            <div class="input-group flex-nowrap">
                                <div class="form-floating input-group">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-alphabet-uppercase" viewBox="0 0 16 16">
                                            <path d="M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83" />
                                        </svg>
                                    </span>
                                    <input type="text" id="event_name" name="office_name" class="form-control" placeholder="Add a name for this event" aria-label="Username" aria-describedby="addon-wrapping">
                                </div>
                            </div>
                            <small id="office_name_error" class="form-text ml-5 mb-3 text-danger error-field"></small>
                            <h6 class="ms-3">Office Description</h6>
                            <div class="input-group flex-nowrap">
                                <div class="form-floating input-group">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-alphabet-uppercase" viewBox="0 0 16 16">
                                            <path d="M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83" />
                                        </svg>
                                    </span>
                                    <textarea id="event_description" name="office_description" type="text" rows="3" class="form-control" placeholder="Add a description for this event" aria-label="Username" aria-describedby="addon-wrapping"></textarea>
                                </div>
                            </div>
                            <small id="office_description_error" class="form-text ml-5 mb-3 text-danger error-field"></small>
                            <h6 class="ms-3">Office Photo</h6>
                            <div class="input-group flex-nowrap">
                                <div class="form-floating input-group">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-alphabet-uppercase" viewBox="0 0 16 16">
                                            <path d="M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83" />
                                        </svg>
                                    </span>
                                    <div>
                                        <input type="file" class="form-control-file ml-2" id="input-office-image" name="office_image">
                                        <img class="img-thumbnail rounded-circle mt-2" id="cropper-result" height="100" width="100" alt="200x200" src="" data-holder-rendered="true">
                                        <button type="button" id="remove-marker-image-btn" class="btn btn-danger btn-sm ml-2">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <small id="office_image_error" class="form-text ml-5 mb-3 text-danger error-field"></small>
                            <h6 class="ms-3">Location</h6>
                            <div class="input-group flex-nowrap">
                                <div class="form-floating input-group">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-alphabet-uppercase" viewBox="0 0 16 16">
                                            <path d="M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83" />
                                        </svg>
                                    </span>
                                    <input type="text" id="building_id" name="building_id" class="form-control" placeholder="Where is this office located?" aria-label="Username" aria-describedby="addon-wrapping" style="cursor: context-menu;" readonly>
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

    function removeValidations() {
        $('#office_name_error, #office_description_error, #office_image_error, #building_id_error').text('')
    }

    $('#event-form').submit(function(e) {
        e.preventDefault();
        var bldg_id = $('#building_id').attr('building_id');

        var formData = new FormData();
        var formArray = $(this).serializeArray();

        $.each(formArray, function(i, field) {
            console.log(field.name)
            if (field.name == 'building_id') {
                formData.append(field.name, bldg_id);
            } else {
                formData.append(field.name, field.value);
            }
        });
        formData.append('office_image', document.getElementById('input-office-image').files[0])
        $.ajax({
            url: '{{ route("offices.add.validate") }}',
            data: formData,
            contentType: false,
            processData: false,
            type: 'post',
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
                    removeImageUploadBtn.click();
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
            } else if (key == 'building_id') {
                $(document).find(`#${key}_error`).text('You must select a building.');
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

    // Cropper Js
    let cropper;
    const imageInput = document.getElementById('input-office-image');
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

        document.getElementById('input-office-image').files = dataTransfer.files;

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