@extends('admin.layouts.layout')
@section('title', 'Offices Manager')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manange Offices</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Offices Manager</li>
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
                        <div class="card-header d-flex justify-content-end">
                            <button onclick="addOffice()" type="button" class='btn btn-md btn-primary'>Add Office</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">Image</th>
                                        <th style="width: 25%;">Name</th>
                                        <th>Location</th>
                                        <th style="width: 15%;">Status</th>
                                        <th style="width: 15%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="office-list">
                                    @include('admin.offices.ajax.list')
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
    function addOffice() {
        window.location.href = '/offices/add';
    }

    function renderList() {
        $.ajax({
            url: '{{ route("offices.render") }}',
            data: '',
            success: (html) => {
                $('#office-list').html(html)
                attachListeners()
            },
            error: (error) => {
                console.log(error)
            }
        })
    }

    function attachListeners() {
        const delBtns = document.querySelectorAll('.del-btn');
        delBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Do you intend to delete this office?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("offices.delete") }}',
                            data: {
                                'id': $(this).attr('data-id')
                            },
                            success: (response) => {
                                renderList()
                                Toast.fire({
                                    title: `${response.office} has been deleted successfully!`,
                                    icon: 'success'
                                })
                            },
                            error: (error) => {
                                console.log(error)
                            }
                        })
                    }
                })
            })
        })
    }
    attachListeners()
</script>
@endsection