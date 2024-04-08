@extends('admin.layouts.layout')
@section('title', 'Add Procedure')
@section('more_links')
<style>
    .display-marker {
        background-image: url('{{ asset("assets/logos/logo-only.png") }}');
        background-size: cover;
        width: 20px;
        height: 20px;
        border-radius: 100%;
        cursor: pointer;
    }

    .initial {
        max-height: 100%;
        overflow-y: scroll;
        /* Hide scrollbar for Firefox */
        scrollbar-width: none;
        /* Hide scrollbar for IE, Edge, and Chrome */
        -ms-overflow-style: none;
    }

    /* Hide scrollbar for Chrome, Safari, and Opera */
    .initial::-webkit-scrollbar {
        display: none;
    }

    .review {
        max-height: 100%;
        overflow-y: scroll;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .review::-webkit-scrollbar {
        display: none;
    }

    body {
        background-color: #eee;
    }

    .mt-70 {
        margin-top: 70px;
    }

    .mb-70 {
        margin-bottom: 70px;
    }

    .card {
        box-shadow: 0 0.46875rem 2.1875rem rgba(4, 9, 20, 0.03), 0 0.9375rem 1.40625rem rgba(4, 9, 20, 0.03), 0 0.25rem 0.53125rem rgba(4, 9, 20, 0.05), 0 0.125rem 0.1875rem rgba(4, 9, 20, 0.03);
        border-width: 0;
        transition: all .2s;
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(26, 54, 126, 0.125);
        border-radius: .25rem;
    }

    .card-body {
        flex: 1 1 auto;
        padding: 0.50rem;
    }

    .vertical-timeline {
        width: 100%;
        position: relative;
        padding: 1.5rem 0 1rem;
    }

    .vertical-timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 67px;
        height: 100%;
        width: 4px;
        background: #e9ecef;
        border-radius: .25rem;
    }

    .vertical-timeline-element {
        position: relative;
        margin: 0 0 1rem;
    }

    .vertical-timeline--animate .vertical-timeline-element-icon.bounce-in {
        visibility: visible;
        animation: cd-bounce-1 .8s;
    }

    .vertical-timeline-element-icon {
        position: absolute;
        top: 0;
        left: 60px;
    }

    .vertical-timeline-element-icon .badge-dot-xl {
        box-shadow: 0 0 0 5px #fff;
    }

    .badge-dot-xl {
        width: 18px;
        height: 18px;
        position: relative;
    }

    .badge:empty {
        display: none;
    }


    .badge-dot-xl::before {
        content: '';
        width: 10px;
        height: 10px;
        border-radius: .25rem;
        position: absolute;
        left: 50%;
        top: 50%;
        margin: -5px 0 0 -5px;
        background: #fff;
    }

    .vertical-timeline-element-content {
        position: relative;
        margin-left: 90px;
        font-size: .8rem;
    }

    .vertical-timeline-element-content .timeline-title {
        font-size: .8rem;
        text-transform: uppercase;
        margin: 0 0 .5rem;
        padding: 2px 0 0;
        font-weight: bold;
    }

    .vertical-timeline-element-content .vertical-timeline-element-date {
        display: block;
        position: absolute;
        left: -90px;
        top: 0;
        padding-right: 10px;
        text-align: right;
        color: #adb5bd;
        font-size: .7619rem;
        white-space: nowrap;
    }

    .vertical-timeline-element-content:after {
        content: "";
        display: table;
        clear: both;
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
                    <h1 class="m-0">Add a Procedure</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Add Procedure</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div>
            <div class="container-fluid" style="position: relative;">
                <div class="row">
                    <div id="map" style="height: 100vh; width: 100vw; position: relative;"></div>
                </div>
                <div id="map-nav" class="bg-light rounded mt-2 ml-2 p-2 d-flex justify-content-center align-items-center border" style="position: absolute; z-index: 2; top: 0; left: 0;">
                    <small class="m-0 mr-2">
                        <span id="instructions" class="text-bold">Step 2: Select a building for this procedure's waypoint destination/s.</span>
                    </small>
                    <small class="m-0 mr-2 text-primary ml-1">
                        <span id="bldg-name-hover"></span>.
                    </small>
                    <button id="next-btn" type="button" class="btn btn-sm btn-primary ml-1">Next</button>
                    <button id="cancel-btn" type="button" class="btn btn-sm btn-danger ml-1">Cancel</button>
                </div>
                <button id="reset-btn" class="btn btn-sm btn-danger rounded" style="position: absolute; z-index: 20; top: 2%; right: 1%;">Reset</button>
                <div id="initial-form" class="rounded" style="position: absolute; top: 50%; left: 50%; transform:translate(-50%, -50%); z-index: 5; height: 95%; width: 75%; background-color: transparent;">
                    <div class="modal-content initial" style="max-height: 100%; overflow-y: scroll;">
                        <form id="add-procedure-form" action="">
                            <div class="modal-header">
                                <h5 class="modal-title">Step 1: Fill in the details below to proceed.</h5>
                            </div>
                            <div class="modal-body">
                                <h6 class="ms-3">Name</h6>
                                <div class="input-group flex-nowrap">
                                    <div class="form-floating input-group">
                                        <span class="input-group-text" id="addon-wrapping">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-alphabet-uppercase" viewBox="0 0 16 16">
                                                <path d="M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83" />
                                            </svg>
                                        </span>
                                        <input type="text" id="input-procedure-name" name="procedure_name" class="form-control" placeholder="Add a name for this procedure" aria-label="Username" aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <small id="procedure_name_error" class="form-text ml-5 mb-3 text-danger"></small>
                                <h6 class="ms-3">Description</h6>
                                <div class="input-group flex-nowrap">
                                    <div class="input-group">
                                        <span class="input-group-text" id="addon-wrapping">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-postcard" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm7.5.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zM2 5.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1H2.5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1H2.5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1H2.5a.5.5 0 0 1-.5-.5M10.5 5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM13 8h-2V6h2z" />
                                            </svg>
                                        </span>
                                        <textarea id="input-procedure-description" name="procedure_description" type="text" rows="3" class="form-control" placeholder="Add a description for this procedure" aria-label="Username" aria-describedby="addon-wrapping"></textarea>
                                    </div>
                                </div>
                                <small id="procedure_description_error" class="form-text ml-5 mb-3 text-danger"></small>
                                <h6 class="ms-3">Initial Instructions</h6>
                                <div class="input-group flex-nowrap">
                                    <div class="input-group">
                                        <span class="input-group-text" id="addon-wrapping">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-square" viewBox="0 0 16 16">
                                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                                            </svg>
                                        </span>
                                        <textarea id="input-initial-instructions" name="initial_instructions" type="text" rows="5" class="form-control" placeholder="Write the first set of instructions the user will read here" aria-label="Username" aria-describedby="addon-wrapping"></textarea>
                                    </div>
                                </div>
                                <small id="initial_instructions_error" class="form-text ml-5 mb-3 text-danger"></small>
                                <h6 class="ms-3">Access Level</h6>
                                <div class="input-group flex-nowrap">
                                    <div class="input-group">
                                        <span class="input-group-text" id="addon-wrapping">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1" />
                                            </svg>
                                        </span>
                                        <select id="input-access-level" name="access_level" class="form-control" aria-label="Default select example">
                                            <option selected>Select an accessibility level for this procedure</option>
                                            <option value=1>Guest Level</option>
                                            <option value=2>Student Level</option>
                                            <option value=3>Staff Level</option>
                                            <option value=4>Faculty Level</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <small id="access_level_error" class="form-text ml-5 pl-3 mb-3 text-danger"></small>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="waypoint-modal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form id="waypoint-form" action="">
                    <div class="modal-header">
                        <h5 class="modal-title waypoint-modal-title">Add a Procedure</h5>
                    </div>
                    <div class="modal-body">
                        <img src="" id="waypoint-building-image" class="img-fluid mb-2 p-2" alt="Building Image">
                        <h6 class="ms-3">Waypoint Number</h6>
                        <div class="input-group flex-nowrap">
                            <div class="form-floating input-group">
                                <span class="input-group-text" id="addon-wrapping">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                        <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                        <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                    </svg>
                                </span>
                                <input type="text" id="input-step-no" name="step_no" class="form-control" aria-label="Username" aria-describedby="addon-wrapping" disabled>
                            </div>
                        </div>
                        <small id="step_no_error" class="form-text ml-5 mb-3 text-danger"></small>
                        <h6 class="ms-3">Waypoint Instructions</h6>
                        <div class="input-group flex-nowrap">
                            <div class="input-group">
                                <span class="input-group-text" id="addon-wrapping">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-map" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.5.5 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103M10 1.91l-4-.8v12.98l4 .8zm1 12.98 4-.8V1.11l-4 .8zm-6-.8V1.11l-4 .8v12.98z" />
                                    </svg>
                                </span>
                                <textarea id="input-waypoint-instructions" name="instructions" type="text" rows="5" class="form-control" placeholder="Write the set of instructions the user will once they reach this waypoint." aria-label="Username" aria-describedby="addon-wrapping"></textarea>
                            </div>
                        </div>
                        <small id="instructions_error" class="form-text ml-5 mb-3 text-danger"></small>
                        <input type="text" id="input-building-id" value="" hidden>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="waypoint-cancel-btn" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Waypoint</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade review" id="review-modal">
        <div class="modal-dialog modal-lg">
            <form id="review-form" action="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Final Review</h5>
                    </div>
                    <div class="modal-body">

                        <div class="row d-flex justify-content-center mt-70 mb-70">
                            <div class="col-md-6">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                            <div class="vertical-timeline-item vertical-timeline-element">
                                                <div>
                                                    <span class="vertical-timeline-element-icon bounce-in">
                                                        <i class="badge badge-dot badge-dot-xl badge-success"></i>
                                                    </span>
                                                    <div class="vertical-timeline-element-content bounce-in">
                                                        <h4 id="timeline-initial-procedure" class="timeline-title"></h4>
                                                        <p><a href="#review-procedure-details" id="timeline-initial-instructions" data-abc="true"></a></p>
                                                        <span class="vertical-timeline-element-date"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="procedure-timeline"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 id="review-procedure-details" class="ms-3 mt-3 border-top pt-2 text-center">Procedure Details</h4>

                        <h6 id="review-procedure-details" class="ms-3">Name</h6>
                        <div class="input-group flex-nowrap">
                            <div class="form-floating input-group">
                                <span class="input-group-text" id="addon-wrapping">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-alphabet-uppercase" viewBox="0 0 16 16">
                                        <path d="M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83" />
                                    </svg>
                                </span>
                                <input type="text" id="review-input-procedure-name" name="review_procedure_name" class="form-control" placeholder="Add a name for this procedure" aria-label="Username" aria-describedby="addon-wrapping">
                            </div>
                        </div>
                        <small id="review_procedure_name_error" class="form-text ml-5 mb-3 text-danger"></small>
                        <h6 class="ms-3">Description</h6>
                        <div class="input-group flex-nowrap">
                            <div class="input-group">
                                <span class="input-group-text" id="addon-wrapping">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-postcard" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm7.5.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zM2 5.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1H2.5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1H2.5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1H2.5a.5.5 0 0 1-.5-.5M10.5 5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM13 8h-2V6h2z" />
                                    </svg>
                                </span>
                                <textarea id="review-input-procedure-description" name="review_procedure_description" type="text" rows="3" class="form-control" placeholder="Add a description for this procedure" aria-label="Username" aria-describedby="addon-wrapping"></textarea>
                            </div>
                        </div>
                        <small id="review_procedure_description_error" class="form-text ml-5 mb-3 text-danger"></small>
                        <h6 class="ms-3">Initial Instructions</h6>
                        <div class="input-group flex-nowrap">
                            <div class="input-group">
                                <span class="input-group-text" id="addon-wrapping">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-square" viewBox="0 0 16 16">
                                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                                    </svg>
                                </span>
                                <textarea id="review-input-initial-instructions" name="review_initial_instructions" type="text" rows="5" class="form-control" placeholder="Write the first set of instructions the user will read here" aria-label="Username" aria-describedby="addon-wrapping"></textarea>
                            </div>
                        </div>
                        <small id="review_initial_instructions_error" class="form-text ml-5 mb-3 text-danger"></small>
                        <h6 class="ms-3">Access Level</h6>
                        <div class="input-group flex-nowrap">
                            <div class="input-group">
                                <span class="input-group-text" id="addon-wrapping">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1" />
                                    </svg>
                                </span>
                                <select id="review-input-access-level" name="review_access_level" class="form-control" aria-label="Default select example">
                                    <option value="" selected>Select an accessibility level for this procedure</option>
                                    <option value=1>Guest Level</option>
                                    <option value=2>Student Level</option>
                                    <option value=3>Staff Level</option>
                                    <option value=4>Faculty Level</option>
                                </select>
                            </div>
                        </div>
                        <small id="review_access_level_error" class="form-text ml-5 pl-3 mb-3 text-danger"></small>

                        <h4 id="review-procedure-details" class="ms-3 mt-5 border-top pt-2 text-center">Waypoint Details</h4>
                        <div id="waypoints-review-container">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save to Database</button>
                    </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Modals -->
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

    // Universal Variables
    var _step = 1;
    var instructions = document.getElementById('instructions');
    var nextBtn = document.getElementById('next-btn');
    var cancelBtn = document.getElementById('cancel-btn');
    var waypointCount = 0;
    var waypoints = {};
    // End of Universal Variables

    // Map Initializations
    mapboxgl.accessToken = 'pk.eyJ1Ijoic2Ftc3RyZWV0IiwiYSI6ImNsczRxb29mdTE1ZmkybHBjcHBhcG9xN2kifQ.SpJ2sxffT8PRfQjFtYgg6Q';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/samstreet/clto5jp0h01cg01ptc2idfbdk',
        zoom: 18,
        minZoom: 16,
        center: [124.2438547179179, 8.2414298468554],
        bearing: -95,
        maxBounds: [
            [124.23616973647256, 8.233619024568284], // Southwest bound
            [124.25301604017682, 8.248537110726303] // Northeast bound
        ]
    });
    document.getElementById('map-nav').style.left = '100%';
    instructions.style.display = 'none';
    nextBtn.style.display = 'none';
    cancelBtn.style.display = 'none';
    $('#reset-btn').click(function(e) {
        step = 1;
    });
    // End of Map Initializations

    // Element Rendering
    function renderElements(building = null, marker = null, entrypoint = null, boundary = null) {
        var data = {};
        if (building) {
            data['building'] = true;
        }
        if (marker) {
            data['marker'] = true;
        }
        if (entrypoint) {
            data['entrypoint'] = true;
        }
        if (boundary) {
            if (boundary == 'name_included') {
                data['boundary_with_name'] = true;
            }
            data['boundary'] = true;
        }
        $.ajax({
            url: '{{ route("buildings.get") }}',
            data: data,
            success: function(response) {
                if (building) {
                    console.log(response.buildings);
                }
                if (marker) {
                    response.markers.forEach(marker => {
                        var temp = JSON.parse(marker.markers);
                        var coordinates = [temp.lng, temp.lat];
                        const el = document.createElement('div');
                        el.className = 'display-marker';
                        el.setAttribute('display-marker', marker.id);
                        if (marker.marker_image) {
                            var marker_image = decodeURIComponent('{{ asset("storage/") }}' + "/" + marker.marker_image); // Decode URL
                            el.style.backgroundImage = `url('${marker_image}')`;
                        }
                        var thisMarker = new mapboxgl.Marker(el)
                            .setLngLat(coordinates)
                            .addTo(map);
                    });
                }
                if (boundary) {
                    response.boundaries.forEach(boundary => {
                        var temp = JSON.parse(boundary.corners);
                        var boundaryCoordinates = [];
                        for (let key in temp) {
                            if (temp.hasOwnProperty(key)) {
                                boundaryCoordinates.push([temp[key].lng, temp[key].lat]);
                            }
                        }
                        map.addLayer({
                            id: `polygon-display-${boundary.id}`,
                            type: 'fill',
                            source: {
                                type: 'geojson',
                                data: {
                                    type: 'Feature',
                                    geometry: {
                                        type: 'Polygon',
                                        coordinates: [boundaryCoordinates]
                                    }
                                }
                            },
                            layout: {},
                            paint: {
                                'fill-color': '#fcff40',
                                'fill-opacity': 1
                            }
                        }, 'waterway-label');
                        map.on('mouseenter', `polygon-display-${boundary.id}`, function() {
                            if (_step == 2) {
                                map.setPaintProperty(`polygon-display-${boundary.id}`, 'fill-color', '#40fff9');
                                map.getCanvas().style.cursor = 'pointer';
                                $('#bldg-name-hover').text(boundary.building.building_name);
                            }
                        });
                        map.on('mouseleave', `polygon-display-${boundary.id}`, function() {
                            if (_step == 2) {
                                map.setPaintProperty(`polygon-display-${boundary.id}`, 'fill-color', '#fcff40');
                                map.getCanvas().style.cursor = '';
                                $('#bldg-name-hover').text('');
                            }
                        });
                        map.on('click', `polygon-display-${boundary.id}`, function() {
                            if (_step == 2) {
                                openWaypointModal(boundary.building);
                            }
                        });
                    })
                }
            },
            error: function(error) {
                console.log(error);
            }
        })
    }
    renderElements(false, true, false, 'name_included');
    // End of Element Rendering

    // Step Listeners 
    Object.defineProperty(window, 'step', {
        get: function() {
            return _step;
        },
        set: function(value) {
            if (value === 1) {
                $('#map-nav').animate({
                    left: '100%'
                });
                $('#initial-form').css('display', '');
                $('#initial-form').animate({
                    left: '50%'
                });
                $('#add-procedure-form')[0].reset();
                $('#waypoint-form')[0].reset();
                $('#review-form')[0].reset();
                waypointCount = 0;
                instructions.innerText = `Select a destination for waypoint ${waypointCount}.`;
                document.getElementById('waypoints-review-container').innerHTML = '';
                document.getElementById('procedure-timeline').innerHTML = '';
                waypoints = {};
                _step = value;
            } else if (value === 2) {
                $('#map-nav').animate({
                    left: '0%'
                });
                waypointCount += 1;
                instructions.style.display = '';
                instructions.innerText = `Select a destination for waypoint ${waypointCount}.`;
                nextBtn.style.display = 'none';
                cancelBtn.style.display = 'none';
                _step = value;
            } else if (value === 3) {
                _step = value;
            } else {
                _step = 1;
            }
        }
    });
    // End of Step Listeners 

    // Step 1 Functions
    $('#add-procedure-form').submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url: '{{ route("procedures.add.validate") }}',
            data: data,
            success: (response) => {
                document.querySelectorAll('[id$="_error"]').forEach((element) => {
                    element.innerText = '';
                });
                if (response.success == true) {
                    $.ajax({
                        url: '{{ route("procedures.add.submit") }}',
                        data: data,
                        success: (response) => {
                            if (response.success == true) {
                                $('#initial-form').animate({
                                    left: '150%'
                                }, function() {
                                    $(this).css('display', 'none');
                                });
                                step = 2;
                            }
                        },
                        error: (error) => {
                            Toast.fire({
                                icon: 'error',
                                title: `Something went wrong.`
                            });
                        }
                    })
                } else if (response.success == false) {
                    var errors = response.msg;
                    for (let key in errors) {
                        var field = key;
                        $(document).find(`#${key}_error`).text(errors[key][0]);
                        if (key == 'access_level') {
                            $(document).find(`#${key}_error`).text('Please select an accessibilty level.');
                        }
                    }
                }
            },
            error: (error) => {
                console.log(error);
            }
        })
    })
    // End of Step 1 Functions

    // Step 2 Functions
    function openWaypointModal(building) {
        $('.waypoint-modal-title').text(`Waypoint ${waypointCount}: ${building.building_name}`);
        $('#input-step-no').val(waypointCount);
        $('#input-building-id').val(building.id).attr('name', building.building_name);
        if (building.marker_photo !== null) {
            var marker_photo = decodeURIComponent('{{ asset("storage/") }}' + "/" + building.building_marker.marker_image);
            $('#waypoint-building-image').attr('src', marker_photo);
        }
        $('#waypoint-modal').modal('toggle');
    }

    $('#waypoint-cancel-btn').click(function() {
        $('#waypoint-modal').modal('toggle');
    })

    $('#waypoint-form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("procedures.add.validate") }}',
            data: {
                'step_no': $('#input-step-no').val(),
                'instructions': $('#input-waypoint-instructions').val(),
                'building_id': $('#input-building-id').val(),
                'waypoint': true
            },
            success: (response) => {
                document.querySelectorAll('[id$="_error"]').forEach((element) => {
                    element.innerText = '';
                });
                if (response.success == true) {
                    Toast.fire({
                        icon: 'success',
                        title: `Waypoint information has been temporarily saved.`
                    });
                    Swal.fire({
                        title: "Do you want to add another waypoint?",
                        showDenyButton: true,
                        confirmButtonText: "Yes",
                        denyButtonText: "No"
                    }).then((result) => {
                        $('#waypoint-modal').modal('toggle');
                        waypoints[$('#input-step-no').val()] = {
                            'step_no': $('#input-step-no').val(),
                            'instructions': $('#input-waypoint-instructions').val(),
                            'building_id': $('#input-building-id').val(),
                            'building_name': $('#input-building-id').attr('name'),
                            'image_src': $('#waypoint-building-image').attr('src')
                        }
                        if (result.isConfirmed) {
                            $('#input-waypoint-instructions').val('');
                            console.log(waypoints);
                            waypointCount += 1;
                            instructions.innerText = `Select a destination for waypoint ${waypointCount}.`;
                        } else {
                            finalReview()
                        }
                    })
                } else if (response.success == false) {
                    var errors = response.msg;
                    for (let key in errors) {
                        var field = key;
                        $(document).find(`#${key}_error`).text(errors[key][0]);
                        if (key == 'step_no') {
                            $(document).find(`#${key}_error`).text('Something went wrong, kindly reload this page.');
                        }
                    }
                }
            },
            error: (error) => {
                console.log(error);
            }
        })
    })
    // End of Step 2 Functions

    // Step 3 Functions
    function finalReview() {
        $('#review-modal').modal('toggle');
        for (let key in waypoints) {
            $('#timeline-initial-procedure').text($('#input-procedure-name').val());
            $('#timeline-initial-instructions').text($('#input-initial-instructions').val());
            var timeline = document.getElementById('procedure-timeline');
            timeline.innerHTML += `
            <div class="vertical-timeline-item vertical-timeline-element">
                <div>
                    <span class="vertical-timeline-element-icon bounce-in">
                        <i class="badge badge-dot badge-dot-xl badge-warning"> </i>
                    </span>
                    <div class="vertical-timeline-element-content bounce-in">
                        <p>${waypoints[key].building_name}</p>
                        <p><span class="text-success"><a href="#${waypoints[key].step_no}-review">${waypoints[key].instructions}</a></span></p>
                        <span class="vertical-timeline-element-date text-dark">Step #${waypoints[key].step_no}</span>
                    </div>
                </div>
            </div>
            `;
        }
        $('#review-input-procedure-name').val($('#input-procedure-name').val());
        $('#review-input-procedure-description').val($('#input-procedure-description').val());
        $('#review-input-initial-instructions').val($('#input-initial-instructions').val());
        $('#review-input-access-level').val($('#input-access-level').val());
        for (let key in waypoints) {
            var waypointsReviewContainer = document.getElementById('waypoints-review-container');
            waypointsReviewContainer.innerHTML += `
            <div id="${waypoints[key].step_no}-review" class="d-flex justify-content-center mt-5">
            <img src="${waypoints[key].image_src}" class="img-fluid mb-2 p-2" alt="Building Image" style="height: 250px;">
            </div>
            <h6 class="ms-3">Waypoint Number ${waypoints[key].step_no}: ${waypoints[key].building_name}</h6>
            <div class="input-group flex-nowrap">
                <div class="form-floating input-group">
                    <span class="input-group-text" id="addon-wrapping">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                            <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/>
                            <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        </svg>
                    </span>
                    <input type="text" id="${waypoints[key].step_no}-review-input-step-no" placeholder="Add a name for this procedure" name="${waypoints[key].step_no}_review_step_no" value="${waypoints[key].step_no}" class="form-control" aria-label="Username" aria-describedby="addon-wrapping" style="cursor: context-menu;" readonly>
                    <input type="number" name="${waypoints[key].step_no}_review_building_id" value=${waypoints[key].building_id} hidden>
                </div>
            </div>
            <small id="review_step_no_error" class="form-text ml-5 mb-3 text-danger"></small>
            <h6 class="ms-3">Waypoint Instructions</h6>
            <div class="input-group flex-nowrap">
                <div class="input-group">
                    <span class="input-group-text" id="addon-wrapping">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-map" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.5.5 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103M10 1.91l-4-.8v12.98l4 .8zm1 12.98 4-.8V1.11l-4 .8zm-6-.8V1.11l-4 .8v12.98z" />
                        </svg>
                    </span>
                    <textarea id="${waypoints[key].step_no}-review-input-waypoint-instructions" name="${waypoints[key].step_no}_review_instructions" type="text" rows="5" class="form-control" placeholder="Write the set of instructions the user will once they reach this waypoint." aria-label="Username" aria-describedby="addon-wrapping">${waypoints[key].instructions}</textarea>
                </div>
            </div>
            <small id="${waypoints[key].step_no}_review_instructions_error" class="form-text ml-5 mb-3 text-danger"></small>
            <input type="text" id="${waypoints[key].step_no}-review-input-building-id" value="${waypoints[key].building_id}" hidden>
            `;
        }
    }

    $('#review-form').submit(function(e) {
        e.preventDefault();

        var data = $(this).serialize();
        data += '&final=true';
        $.ajax({
            url: '{{ route("procedures.add.submit") }}',
            data: data,
            success: (response) => {
                document.querySelectorAll('[id$="_error"]').forEach((element) => {
                    element.innerText = '';
                });
                if (response.success == true) {
                    Toast.fire({
                        icon: 'success',
                        title: `${response.procedure_name} has been successfully added to the database!`
                    });
                    $('#review-modal').modal('toggle');
                    step = 1;
                } else if (response.success == false) {
                    var errors = response.msg;
                    for (let key in errors) {
                        if (key == 'review_procedure_name') {
                            if (errors[key] == "The review procedure name has already been taken.") {
                                $(document).find(`#${key}_error`).text('This name has already been taken.');
                            } else {
                                $(document).find(`#${key}_error`).text('This field is required.');
                            }
                        } else if (key == 'review_access_level') {
                            $(document).find(`#${key}_error`).text('Please select an accessibilty level.');
                        } else {
                            $(document).find(`#${key}_error`).text('This field is required.');
                        }
                    }
                }
            },
            error: (error) => {
                console.log(error);
            }
        })
    })
    // End of Step 3 Functions
</script>
@endsection