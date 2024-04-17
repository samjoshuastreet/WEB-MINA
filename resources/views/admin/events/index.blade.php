@extends('admin.layouts.layout')
@section('more_links')
@endsection
@section('title')
@section('title', 'Admin - Event Manager')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manange Events</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Events</li>
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
                                <a href="{{ route('events.add') }}"><button type="button" class="btn btn-success btn-sm mb-3">Add an Event</button></a>
                            </div>
                            <div id="event-list">
                                @include('admin.events.ajax.list')
                            </div>
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
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    function renderList() {
        $.ajax({
            url: '{{ route("events.all") }}',
            data: '',
            success: (html) => {
                $('#event-list').html(html);
            },
            error: (error) => {
                console.log(error);
            }
        })
    }
    const deleteBtns = document.querySelectorAll('.event-delete-btn');
    deleteBtns.forEach(function(delBtn) {
        delBtn.addEventListener('click', function() {
            Swal.fire({
                title: `Are you sure you want to delete the event '${$(this).attr('name')}'?`,
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).attr('identifier');
                    $.ajax({
                        url: '{{ route("events.delete") }}',
                        data: {
                            id: id
                        },
                        success: (response) => {
                            Toast.fire({
                                icon: 'success',
                                title: `${response.name} has been deleted successfully!`
                            });
                            renderList();
                        },
                        error: (error) => {
                            console.log(error);
                        }
                    })
                }
            });
        })
    });
</script>
@endsection