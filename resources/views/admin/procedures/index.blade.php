@extends('admin.layouts.layout')
@section('title', 'Procedure Manager')
@section('more_links')
<style>
    .intro {
        height: 100%;
    }

    table td,
    table th {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }

    thead th {
        color: #fff;
    }

    .card {
        border-radius: .5rem;
    }

    .table-scroll {
        border-radius: .5rem;
    }

    .table-scroll table thead th {
        font-size: 1.25rem;
    }

    thead {
        top: 0;
        position: sticky;
    }
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
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
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
                    <div class="card p-2">
                        <div class="card-body">
                            <div id="procedures-list" class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px">
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
@endsection