@extends('admin.layouts.layout')
@section('title', 'Add Building')
@section('more_links')
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/cropperjs/cropper.min.css') }}" />
<style>
    #longitude-table:focus {
        outline: none;
        border: none;
    }

    .marker {
        background-image: url('{{ asset("assets/logos/logo-only.png") }}');
        background-size: cover;
        width: 30px;
        height: 30px;
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
            <form id="building-add-form" enctype="multipart/form-data">
                @csrf
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
                                    <img class="img-thumbnail rounded-circle mt-2" id="cropper-result" height="100" width="100" alt="200x200" src="" data-holder-rendered="true">
                                    <button type="button" id="remove-marker-image-btn" class="btn btn-danger btn-sm ml-2">Remove</button>
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

<div class="modal fade" id="cropper-modal">
    <div class="modal-dialog modal-md">
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
<!-- /.modal -->
@endsection
@section('more_scripts')
<script src="{{ asset('assets/admin/plugins/cropperjs/cropper.min.js') }}"></script>
// CropperJs Scripts
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const imageInput = document.getElementById('marker_image-table');
        const cropperCont = document.getElementById('photo-cropper');
        const cropBtn = document.getElementById('cropper-crop-btn');
        const cancelCropTopBtn = document.getElementById('cropper-cancel-top-btn');
        const cancelCropBotBtn = document.getElementById('cropper-cancel-bot-btn');
        const removeImageUploadBtn = document.getElementById('remove-marker-image-btn');
        $('#cropper-result').hide();
        $('#remove-marker-image-btn').hide();
        let cropper;

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
                $('#add-modal').modal('toggle');
            }
        });
        removeImageUploadBtn.addEventListener('click', () => {
            document.getElementById('cropper-result').src = "";
            imageInput.value = '';
            $('#cropper-result').hide();
            $('#remove-marker-image-btn').hide();
        })
        cancelCropTopBtn.addEventListener('click', () => {
            $('#add-modal').modal('toggle');
            $('#cropper-modal').modal('toggle');
            $('#marker_image-table').val('');
        })
        cancelCropBotBtn.addEventListener('click', () => {
            $('#add-modal').modal('toggle');
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
            $('#add-modal').modal('toggle');
        })
    });
</script>
// End of CropperJS Scripts
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

    function loadModal() {
        $('#cropper-modal').modal('toggle');
    }

    $('#building-add-form').submit(function(e) {
        e.preventDefault();
        let formData = new FormData();

        // Append form data using serializeArray
        $.each($(this).serializeArray(), function(i, field) {
            formData.append(field.name, field.value);
        });

        // Append file inputs
        formData.append('marker_image', $('#marker_image-table')[0].files[0]);

        $.ajax({
            url: '{{ route("buildings.add.submit") }}',
            data: formData,
            type: 'POST',
            contentType: false, // Set contentType to false when using FormData
            processData: false,
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