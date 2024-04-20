@extends('admin.layouts.layout')
@section('title', 'Building Types Manager')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manange Building Types</h1>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <button type="button" id="types-add-btn" class="btn btn-primary btn-md mb-3">Add a Building Type</button>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;" class="text-center">#</th>
                                        <th style="width: 35%;" class="text-center">Name</th>
                                        <th style="width: 15%;" class="text-center">Color</th>
                                        <th style="width: 15%;" class="text-center">Total Instances</th>
                                        <th style="width: 15%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="types-list">
                                    @include('admin.buildings.ajax.types_list')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-type-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Add a Building Type</h4>
                </div>
                <form action="" id="add-submit">
                    <div class="modal-body">
                        <label for="input-name">Name</label>
                        <input type="text" name="name" class='form-control' id="input-name" placeholder="Add a name for this building type">
                        <small id="name_error" class="error-msg form-text ml-1 mb-3 text-danger"></small>
                        <label for="input-color" class='mt-4'>Set Color</label>
                        <input type="color" name="color" class="form-control form-control-color" id="input-color" value="#A41C20" title="Choose your color">
                        <small id="color_error" class="error-msg form-text ml-1 mb-3 text-danger"></small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id='add-type-modal-close-btn' class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
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

    // Universal Functions
    function reloadList() {
        $.ajax({
            url: '{{ route("buildings.types.reload") }}',
            data: '',
            success: (html) => {
                $('#types-list').html(html);
            },
            error: (error) => {
                console.log(error);
            }
        })
    }
    // End of Universal Functions
    $(document).on('click', '.delete-types-btn', function(e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        $.ajax({
            url: '{{ route("buildings.types.delete") }}',
            data: {
                'id': id
            },
            success: function(response) {
                if (response.success == false) {
                    if (response.count > 1) {
                        Toast.fire({
                            icon: 'error',
                            title: `${response.bldg_name} is active. Please delete all ${response.count} connected paths.`
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: `${response.bldg_name} is active. Please delete the connected path.`
                        });
                    }
                } else if (response.success == true) {
                    Swal.fire({
                        title: `Are you sure you want to delete ${response.name}?`,
                        showDenyButton: true,
                        confirmButtonText: "Yes",
                        denyButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route("buildings.types.delete") }}',
                                data: {
                                    'id': id,
                                    'confirm': true
                                },
                                success: (response) => {
                                    Toast.fire({
                                        icon: 'success',
                                        title: `${response.name} has been deleted successfully!`
                                    });
                                    reloadList();
                                },
                                error: (error) => {
                                    console.log(error);
                                }
                            })
                        }
                    });
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    });

    $(document).on('click', '#types-add-btn', function() {
        $('#add-type-modal').modal('toggle');
    })

    $('#add-type-modal-close-btn').click(function() {
        $('#add-type-modal').modal('toggle');
    })

    $('#add-submit').submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url: '{{ route("buildings.types.add") }}',
            data: data,
            success: (response) => {
                if (response.success === false) {
                    clearValidations();
                    printValidations(response.msg);
                } else if (response.success === true) {
                    clearValidations();
                    resetForm();
                    Toast.fire({
                        icon: 'success',
                        title: `${response.name} has successfully been added!`
                    })
                    reloadList();
                }
            },
            error: (error) => {
                console.log(error);
            }
        })
    })

    function resetForm() {
        $('#add-submit')[0].reset();
    }


    function clearValidations() {
        var validationsContainer = document.querySelectorAll('.error-msg');
        validationsContainer.forEach(function(item) {
            item.innerText = '';
        })
    }

    function printValidations(errors) {
        for (let key in errors) {
            if (errors[key]) {
                $(document).find(`#${key}_error`).text(errors[key]);
            }
        }
    }
</script>
@endsection