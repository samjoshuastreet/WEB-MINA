@extends('admin.layouts.layout')
@section('title', 'Admin - Edit Procedure')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Procedure</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('procedures.index') }}">Procedures</a></li>
                        <li class="breadcrumb-item active">Edit Procedure</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <form action="" id='pro-form'>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Procedure Details</h3>
                            </div>
                            <div class="card-body">
                                <input type="text" name="id" prev-value="{{ $target->id }}" value="{{ $target->id }}" id="" hidden>
                                <div class="d-flex">
                                    <label for="procedure-name" class='col-2'>Name</label>
                                    <input type="text" class='form-control col-10' name="procedure_name" prev-value='{{ $target->procedure_name }}' value='{{ $target->procedure_name }}' id="procedure-name">
                                </div>
                                <div class="d-flex mt-2">
                                    <label for="procedure-description" class='col-2'>Desctiption</label>
                                    <textarea type="text" class='form-control col-10' name="procedure_description" prev-value='{{ $target->procedure_description }}' rows='5' id="procedure-description">{{ $target->procedure_description }}</textarea>
                                </div>
                                <div class="d-flex mt-2">
                                    <label for="initial-instructions" class='col-2'>Initial Instructions</label>
                                    <textarea name="initial_instructions" id="initial-instructions" prev-value='{{ $target->initial_instructions }}' class='form-control' rows="5">{{ $target->initial_instructions }}</textarea>
                                </div>
                                <div class="d-flex mt-2">
                                    <label for="access-level" class='col-2'>Access Level</label>
                                    <select name="access_level" prev-value='{{ $target->access_level }}' class='form-control' id="access-level">
                                        <option value="{{ $target->access_level }}" selected>None Selected</option>
                                        <option value="9">Disabled</option>
                                        <option value="1">Guest Level</option>
                                        <option value="2">Student Level</option>
                                        <option value="3">Faculty Level</option>
                                        <option value="4">Admin Level</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" id='pro-save' class='btn btn-sm btn-primary' disabled>Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <form action="" id='wp-form'>
                        <div class="card card-dark">
                            <div class="card-header">
                                <h3 class="card-title">Waypoints</h3>
                            </div>
                            <div class="card-body">
                                @foreach($target->waypoints as $wp)
                                @if($loop->first)
                                <div page='{{ $loop->iteration }}' class='page'>
                                    <div class="d-flex">
                                        <label for="step-no" class='col-4'>Step Number</label>
                                        <input type="text" class='form-control col-8 bg-light' name="step_no" value='{{ $wp->step_no }}' readonly>
                                    </div>
                                    <div class="d-flex">
                                        <label for="building-id" class='col-4'>Destination</label>
                                        <input type="text" class='form-control col-8 bg-light' name="building-id" value='{{ $wp->building->building_name }}' readonly>
                                    </div>
                                    <div class="d-flex mt-2">
                                        <label class='col-4' for="instructions">Instructions</label>
                                        <textarea name="instructions" class='form-control col-8 instructions' prev-value='{{ $wp->instructions }}' rows="10">{{ $wp->instructions }}</textarea>
                                    </div>
                                    <div class='d-flex justify-content-between mt-4'>
                                        <button type='button' class='btn btn-prev btn-sm btn-warning' disabled>Prev</button>
                                        <button type='submit' class='wp-save btn btn-sm btn-primary' disabled>Save</button>
                                        <button type='button' class='btn btn-next btn-sm btn-success'>Next</button>
                                    </div>
                                </div>
                                @elseif($loop->last)
                                <div page='{{ $loop->iteration }}' class='page' style='display: none;'>
                                    <div class="d-flex">
                                        <label for="step-no" class='col-4'>Step Number</label>
                                        <input type="text" class='form-control col-8 bg-light' name="step_no" value='{{ $wp->step_no }}' readonly>
                                    </div>
                                    <div class="d-flex">
                                        <label for="building-id" class='col-4'>Destination</label>
                                        <input type="text" class='form-control col-8 bg-light' name="building-id" value='{{ $wp->building->building_name }}' readonly>
                                    </div>
                                    <div class="d-flex mt-2">
                                        <label class='col-4' for="instructions">Instructions</label>
                                        <textarea name="instructions" class='form-control col-8 instructions' prev-value='{{ $wp->instructions }}' rows="10">{{ $wp->instructions }}</textarea>
                                    </div>
                                    <div class='d-flex justify-content-between mt-4'>
                                        <button type='button' class='btn btn-prev btn-sm btn-warning'>Prev</button>
                                        <button type='submit' class='wp-save btn btn-sm btn-primary' disabled>Save</button>
                                        <button type='button' class='btn btn-next btn-sm btn-success' disabled>Next</button>
                                    </div>
                                </div>
                                @else
                                <div page='{{ $loop->iteration }}' class='page' style='display: none;'>
                                    <div class="d-flex">
                                        <label for="step-no" class='col-4'>Step Number</label>
                                        <input type="text" class='form-control col-8 bg-light' name="step_no" value='{{ $wp->step_no }}' readonly>
                                    </div>
                                    <div class="d-flex">
                                        <label for="building-id" class='col-4'>Destination</label>
                                        <input type="text" class='form-control col-8 bg-light' name="building-id" value='{{ $wp->building->building_name }}' readonly>
                                    </div>
                                    <div class="d-flex mt-2">
                                        <label class='col-4' for="instructions">Instructions</label>
                                        <textarea name="instructions" class='form-control col-8 instructions' prev-value='{{ $wp->instructions }}' rows="10">{{ $wp->instructions }}</textarea>
                                    </div>
                                    <div class='d-flex justify-content-between mt-4'>
                                        <button type='button' class='btn btn-prev btn-sm btn-warning'>Prev</button>
                                        <button type='submit' class='wp-save btn btn-sm btn-primary' disabled>Save</button>
                                        <button type='button' class='btn btn-next btn-sm btn-success'>Next</button>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.col-md-6 -->
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
    function next(page) {
        $(`.page[page='${page}']`).hide()
        $(`.page[page='${parseInt(page) + 1}']`).show()
    }

    function prev(page) {
        $(`.page[page='${page}']`).hide()
        $(`.page[page='${parseInt(page) - 1}']`).show()
    }

    function attachListeners() {
        const nextBtns = $('.btn-next');
        const prevBtns = $('.btn-prev');
        nextBtns.each(function() {
            $(this).on('click', function() {
                next($(this).parent().parent().attr('page'));
            });
        });
        prevBtns.each(function() {
            $(this).on('click', function() {
                prev($(this).parent().parent().attr('page'));
            });
        });
    }
    attachListeners();

    function compare(section) {
        var changes = false;
        if (section == 'pro') {
            $('#pro-form input, #pro-form textarea, #pro-form select').each(function() {
                $(this).attr('prev-value') == $(this).val() ? changes = changes : changes = true
            });
            changes ? $('#pro-save').attr('disabled', false) : $('#pro-save').attr('disabled', true)
        } else if (section == 'wp') {
            $('.page').each(function(i, page) {
                $(page).find('textarea').each(function(j, input) {
                    input.getAttribute('prev-value') == input.value ? changes = changes : changes = true
                })
            })
            changes ? $('.wp-save').attr('disabled', false) : $('.wp-save').attr('disabled', true)
        }
    }

    function submitted(section) {
        if (section == 'pro') {
            $('#pro-form input, #pro-form textarea, #pro-form select').each(function() {
                $(this).attr('prev-value', $(this).val())
            });
            compare('pro')
        }
    }

    $('#procedure-name, #procedure-description, #initial-instructions').keyup(function() {
        compare('pro')
    })
    $('#access-level').change(function() {
        compare('pro')
    })
    $('.instructions').keyup(function() {
        compare('wp')
    })

    $('#pro-form').submit(function(e) {
        e.preventDefault()
        var data = $(this).serialize();
        data += '&pro=true'
        $.ajax({
            url: '{{ route("procedures.edit.submit") }}',
            data: data,
            success: (response) => {
                if (response.success === true) {
                    Toast.fire({
                        title: 'Procedure details has been updated',
                        icon: 'success'
                    })
                    submitted('pro')
                } else {
                    Toast.fire({
                        title: 'Something went wrong',
                        icon: 'error'
                    })
                }
            },
            error: (error) => {
                console.log(error)
            }
        })
    })

    $('#wp-save').submit(function(e) {
        e.preventDefault()
        var data = '';
        $.ajax({
            url: '{{ route("procedures.edit.submit") }}',
            data: data,
            success: (response) => {

            },
            error: (error) => {
                console.log(error)
            }
        })
    })
</script>
@endsection