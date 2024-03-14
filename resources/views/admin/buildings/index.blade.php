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
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('buildings.add') }}"><button type="button" class="btn btn-primary btn-md mb-3">Add a Building</button></a>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">Image</th>
                                        <th style="width: 30%;">Name</th>
                                        <th style="width: 20%;">Longitude</th>
                                        <th style="width: 20%;">Latitude</th>
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
    $(document).on('click', '.delete-building-btn', function(e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        $.ajax({
            url: '{{ route("buildings.delete") }}',
            data: {
                'id': id
            },
            success: function(html) {
                $('#building-list').html(html);
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
</script>
@endsection