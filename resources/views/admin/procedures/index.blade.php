@extends('admin.layouts.layout')
@section('title', 'Procedure Manager')
@section('more_links')
<style>
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manange Procedures</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Procedures</li>
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
                                <a href="{{ route('procedures.add') }}"><button type="button" class="btn btn-success btn-sm mb-3">Add a Procedure</button></a>
                            </div>
                            <div id="procedure-list">
                                @include('admin.procedures.ajax.list')
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
            url: '{{ route("procedures.all") }}',
            data: '',
            success: (html) => {
                $('#procedure-list').html(html);
            },
            error: (error) => {
                console.log(error);
            }
        })
    }
    const deleteBtns = document.querySelectorAll('.procedure-delete-btn');
    deleteBtns.forEach(function(delBtn) {
        delBtn.addEventListener('click', function() {
            Swal.fire({
                title: `Are you sure you want to delete the procedure '${$(this).attr('name')}'?`,
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).attr('identifier');
                    $.ajax({
                        url: '{{ route("procedures.delete") }}',
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