@extends('admin.layouts.layout')
@section('more_links')
@endsection
@section('title')
@section('title', 'Admin - Feedback Reports')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manange Feedback Reports</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Feedback Reports</li>
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
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center bg-dark">
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 20%;">Name</th>
                                        <th style="width: 40%;">Message</th>
                                        <th style="width: 20%;">Status</th>
                                        <th style="width: 15%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="feedback-list">
                                    @include('admin.feedbacks.ajax.list')
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
    $(document).ready(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        function renderList() {
            $.ajax({
                url: '{{ route("feedbacks.all") }}',
                data: '',
                success: (html) => {
                    $('#feedback-list').html(html);
                    const beginBtns = document.querySelectorAll('.begin-btn');
                    const pauseBtns = document.querySelectorAll('.pause-btn');
                    const resolveBtns = document.querySelectorAll('.resolve-btn');
                    const deleteBtns = document.querySelectorAll('.delete-btn');
                    beginBtns.forEach(function(beginBtn) {
                        beginBtn.addEventListener('click', function() {
                            Swal.fire({
                                title: `Do you intend to start working on this feedback?`,
                                showDenyButton: true,
                                confirmButtonText: 'Yes',
                                denyButtonText: 'No'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var id = $(this).attr('data-id');
                                    $.ajax({
                                        url: '{{ route("feedbacks.edit") }}',
                                        data: {
                                            'id': id,
                                            'begin': true
                                        },
                                        success: (response) => {
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
                    pauseBtns.forEach(function(pauseBtn) {
                        pauseBtn.addEventListener('click', function() {
                            Swal.fire({
                                title: `Do you intend to pause your progress on this feedback?`,
                                showDenyButton: true,
                                confirmButtonText: 'Yes',
                                denyButtonText: 'No'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var id = $(this).attr('data-id');
                                    $.ajax({
                                        url: '{{ route("feedbacks.edit") }}',
                                        data: {
                                            'id': id,
                                            'pause': true
                                        },
                                        success: (response) => {
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
                    resolveBtns.forEach(function(resolveBtn) {
                        resolveBtn.addEventListener('click', function() {
                            Swal.fire({
                                title: `Do you intend to resolve this feedback?`,
                                showDenyButton: true,
                                confirmButtonText: 'Yes',
                                denyButtonText: 'No'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var id = $(this).attr('data-id');
                                    $.ajax({
                                        url: '{{ route("feedbacks.edit") }}',
                                        data: {
                                            'id': id,
                                            'resolve': true
                                        },
                                        success: (response) => {
                                            renderList();
                                            Toast.fire({
                                                icon: 'success',
                                                title: 'The feedback report was resolved!'
                                            })
                                        },
                                        error: (error) => {
                                            console.log(error);
                                        }
                                    })
                                }
                            });
                        })
                    });
                    deleteBtns.forEach(function(deleteBtn) {
                        deleteBtn.addEventListener('click', function() {
                            Swal.fire({
                                title: `Do you intend to delete this feedback?`,
                                showDenyButton: true,
                                confirmButtonText: 'Yes',
                                denyButtonText: 'No'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var id = $(this).attr('data-id');
                                    $.ajax({
                                        url: '{{ route("feedbacks.delete") }}',
                                        data: {
                                            'id': id,
                                            'begin': true
                                        },
                                        success: (response) => {
                                            renderList();
                                            Toast.fire({
                                                icon: 'success',
                                                title: 'The feedback report was deleted successfully!'
                                            })
                                        },
                                        error: (error) => {
                                            console.log(error);
                                        }
                                    })
                                }
                            });
                        })
                    });
                },
                error: (error) => {
                    console.log(error);
                }
            })
        }
        renderList()
    });
</script>
@endsection