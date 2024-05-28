@extends('admin.layouts.layout')
@section('title', 'Edit ' . $target->building_name)
@section('more_links')
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="{{ asset('assets/admin/plugins/cropperjs/cropper.min.css') }}" />
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit {{ $target->building_name }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('buildings.index') }}">Manage Buildings</a></li>
                        <li class="breadcrumb-item active">Edit {{ $target->building_name }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" id="bd-form">
                                    @csrf
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Building Details</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="bp-cont">
                                            @include('admin.buildings.ajax.bp')
                                        </div>
                                        <div class='d-flex justify-content-center mb-2'>
                                            <button id='bldg-d-btn' class='btn btn-sm btn-dark' type="submit" disabled>Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12">
                                <form action="" id="mi-form" enctype="multipart/form-data">
                                    <div class="card card-danger">
                                        @csrf
                                        <input type="text" name="id" id="" value='{{ $target->id }}' hidden>
                                        <div class="card-header">
                                            <h3 class="card-title">Marker Image</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body" id='mi-cont'>
                                            @include('admin.buildings.ajax.mi')
                                        </div>
                                        <div class='d-flex justify-content-center mb-2'>
                                            <button id='mi-btn' class='btn btn-sm btn-dark' type="submit" disabled>Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col md-12">
                                <form action="" id='bt-form'>
                                    <div class="card card-secondary">
                                        <div class="card-header">
                                            <h3 class="card-title">Building Type</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body" id='bt-cont'>
                                            @include('admin.buildings.ajax.bt')
                                        </div>
                                        <div class='d-flex justify-content-center mb-2'>
                                            <button id='bt-btn' class='btn btn-sm btn-dark' type="submit" disabled>Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    function toggleInput(state) {
        state ? $('#change-img-input').hide() : $('#change-img-input').show();
        return state;
    }

    function changeColor(id) {
        $.ajax({
            url: '{{ route("buildings.find") }}',
            data: {
                'type-color': true,
                'id': id
            },
            success: (response) => {
                $('#bldg-icon').attr('stroke', response.color)
            },
            error: (error) => {
                console.log(error)
            }
        })
    }
    var id = $('#b-type-select').val();
    changeColor(id)

    function attachListeners() {
        $('#change-img-btn').click(function() {
            var currentState = $('#change-img-input').css('display') == 'none';
            toggleInput(!currentState);
        });
        $('#b-type-select').change(function() {
            var idd = $(this).val();
            changeColor(idd)
        })
    }
    attachListeners();

    function toggleDBtn(state) {
        if (state) {
            $('#bldg-d-btn').attr('disabled', false).addClass('btn-primary').removeClass('btn-dark');
        } else {
            $('#bldg-d-btn').attr('disabled', true).removeClass('btn-primary').addClass('btn-dark');
        }
    }

    function toggleMIBtn(state) {
        if (state) {
            $('#mi-btn').attr('disabled', false).addClass('btn-primary').removeClass('btn-dark');
        } else {
            $('#mi-btn').attr('disabled', true).removeClass('btn-primary').addClass('btn-dark');
        }
    }

    function toggleBTBtn(state) {
        if (state) {
            $('#bt-btn').attr('disabled', false).addClass('btn-primary').removeClass('btn-dark');
        } else {
            $('#bt-btn').attr('disabled', true).removeClass('btn-primary').addClass('btn-dark');
        }
    }

    function checkSimilarity(section) {
        if (section == 'bd') {
            $('#bldg-name').val() == currBldgName && $('#bldg-desc').val() == currBldgDesc ? toggleDBtn(false) : toggleDBtn(true)
        } else if (section == 'bt') {
            $('#b-type-select').val() == currBT ? toggleBTBtn(false) : toggleBTBtn(true)
        }
    }

    let currMI = $('#mi-preview').attr('src');
    let toUpload = '';
    let currBldgName = $('#bldg-name').val();
    let currBldgDesc = $('#bldg-desc').val();
    let currBT = $('#b-type-select').val();

    function renderBD() {
        currBldgName = $('#bldg-name').val();
        currBldgDesc = $('#bldg-desc').val();
        toggleDBtn(false)
    }

    function renderMI() {
        currMI = $('#mi-preview').attr('src');
        toggleMIBtn(false)
        removeImageUploadBtn.click()
        toggleInput(true)
    }

    function renderBT() {
        currBT = $('#b-type-select').val()
        toggleBTBtn(false)
    }

    $('#bldg-name').keyup(function() {
        checkSimilarity('bd')
    })
    $('#bldg-desc').keyup(function() {
        checkSimilarity('bd')
    })
    $('#change-img-input').change(function() {
        checkSimilarity('mi')
    })
    $('#b-type-select').change(function() {
        checkSimilarity('bt')
    })

    $('#bd-form').submit(function(e) {
        e.preventDefault()
        var formData = $(this).serialize()
        formData += '&bd=true';
        $.ajax({
            url: '{{ route("buildings.edit.submit") }}',
            data: formData,
            success: (response) => {
                renderBD()
                Toast.fire({
                    title: 'Building details successfully updated!',
                    icon: 'success'
                })
            },
            error: (error) => {
                console.log(error)
            }
        })
    })

    $('#mi-form').submit(function(e) {
        e.preventDefault()
        var formData = new FormData();
        var formArray = $(this).serializeArray()

        $.each(formArray, function(i, field) {
            formData.append(field.name, field.value)
        })

        formData.append('mi', true);
        formData.append('marker_image', document.getElementById('change-img-input').files[0]);
        $.ajax({
            url: '{{ route("buildings.edit.submit.mi") }}',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            success: (response) => {
                renderMI()
                Toast.fire({
                    title: "Marker image successfully updated!",
                    icon: 'success'
                })
            },
            error: (error) => {
                console.log(error)
            }
        })
    })

    $('#bt-form').submit(function(e) {
        e.preventDefault()
        var data = $(this).serialize()
        data += '&bt=true'
        console.log(data)
        $.ajax({
            url: '{{ route("buildings.edit.submit") }}',
            data: data,
            success: (response) => {
                renderBT()
                Toast.fire({
                    title: 'Building type successfully updated!',
                    icon: 'success'
                })
            },
            error: (error) => {
                console.log(error)
            }
        })
    })

    $(document).ready(function() {
        var tID = $('#b-type-id').val();
        $.ajax({
            url: '{{ route("buildings.find") }}',
            data: {
                'type-color': true,
                'id': tID
            },
            success: (response) => {
                $('#b-type-select').val(response.id).change();
                currBT = $('#b-type-select').val();
                toggleBTBtn(false)
                $('#bldg-icon').attr('stroke', response.color)
            },
            error: (error) => {
                console.log(error)
            }
        })
    })

    // Cropper Js
    let cropper;
    const imageInput = document.getElementById('change-img-input');
    const cropperCont = document.getElementById('photo-cropper');
    const cropBtn = document.getElementById('cropper-crop-btn');
    const cancelCropTopBtn = document.getElementById('cropper-cancel-top-btn');
    const cancelCropBotBtn = document.getElementById('cropper-cancel-bot-btn');
    const removeImageUploadBtn = document.getElementById('remove-mi-btn');
    $('#remove-mi-btn').hide();

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
        imageInput.value = '';
        $('#remove-mi-btn').hide();
        $('#mi-preview').attr('src', currMI)
        toggleMIBtn(false)
        toUpload = '';
    })
    cancelCropTopBtn.addEventListener('click', () => {
        $('#cropper-modal').modal('toggle');
        toUpload == '' ? $('#change-img-input').val('') : document.getElementById('change-img-input').files = toUpload
    })
    cancelCropBotBtn.addEventListener('click', () => {
        $('#cropper-modal').modal('toggle');
        toUpload == '' ? $('#change-img-input').val('') : document.getElementById('change-img-input').files = toUpload
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

        document.getElementById('change-img-input').files = dataTransfer.files;
        toUpload = dataTransfer.files;

        // Display the cropped image in the preview
        $('#remove-mi-btn').show();
        document.getElementById('mi-preview').src = croppedDataUrl;

        // Close the modals
        $('#cropper-modal').modal('toggle');
        toggleMIBtn(true)
    })
    // End of Cropper Js
</script>
@endsection