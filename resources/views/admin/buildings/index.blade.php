@extends('admin.layouts.layout')
@section('title', 'Building Manager')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manange Buildings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Manage Buildings</li>
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
                                <a href="{{ route('buildings.add') }}"><button type="button" class="btn btn-primary btn-md mb-3">Add a Building</button></a>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">Image</th>
                                        <th style="width: 25%;">Name</th>
                                        <th style="width: 15%;">Type</th>
                                        <th style="width: 15%;">Status</th>
                                        <th style="width: 15%;">Active Entrance</th>
                                        <th style="width: 15%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="building-list">
                                    @include('admin.buildings.ajax.building_list')
                                </tbody>
                            </table>
                        </div>
                    </div>
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

    // Universal Functions
    function reloadList() {
        $.ajax({
            url: '{{ route("buildings.reload") }}',
            data: '',
            success: (html) => {
                $('#building-list').html(html);
            },
            error: (error) => {
                console.log(error);
            }
        })
    }
    // End of Universal Functions
    $(document).on('click', '.delete-building-btn', function(e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        $.ajax({
            url: '{{ route("buildings.delete.validator") }}',
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
                        title: "Are you aware that deleting this building will result in its complete removal from the database?",
                        showDenyButton: true,
                        confirmButtonText: "Yes",
                        denyButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route("buildings.delete") }}',
                                data: {
                                    'id': id,
                                },
                                success: (response) => {
                                    Toast.fire({
                                        icon: 'success',
                                        title: `${response.bldg_name} has been deleted successfully!`
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
</script>
@endsection