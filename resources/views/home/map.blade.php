@extends('home.layouts.layout')
@section('title', 'MSU-IIT Map - Home')
@section('more_links')
<style>
    .custom-marker {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #808080;
        color: #ffffff;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        line-height: 20px;
    }

    .display-marker {
        background-image: url('{{ asset("assets/logos/logo-only.png") }}');
        background-size: cover;
        width: 40px;
        height: 40px;
        border-radius: 100%;
        cursor: pointer;
        border: white 2px solid;
    }

    .display-label {
        color: #fff;
        font-size: 10px;
        width: fit-content;
        height: 20px;
        border-radius: 10px;
        background-color: #202020;
        font-weight: bold;
        padding: 2.5px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        line-height: 20px;
    }

    .ui-autocomplete::-webkit-scrollbar {
        width: 0;
    }

    .ui-autocomplete {
        max-height: 200px;
        max-width: 15%;
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 1000;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    }

    @media only screen and (max-width: 767px) {
        .ui-autocomplete {
            max-height: 200px;
            max-width: 67.5%;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }
    }

    .modal {
        transition: opacity 0.25s ease;
    }

    body.modal-active {
        overflow-x: hidden;
        overflow-y: visible !important;
    }

    .ui-state-focus {
        background-color: #f0f0f0;
    }

    .ui-menu-item {
        padding: 12px 8px;
        cursor: pointer;
        list-style-type: none;
        width: 100%;
        font-family: poppins-regular;
        font-size: 0.80rem;
    }

    .ui-menu-item:hover {
        background-color: #EDEDED;
    }

    .ui-autocomplete-loading {
        background: white url('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js') right center no-repeat;
    }

    #popup-procedure {
        overflow-y: scroll;
        scrollbar-width: none;
        -ms-overflow-style: none;
        max-height: 100%;
    }

    #popup-procedure::-webkit-scrollbar {
        display: none;
    }

    .procedure-contents {
        overflow-y: scroll;
        scrollbar-width: none;
        -ms-overflow-style: none;
        max-height: 100%;
    }

    .procedure-contents::-webkit-scrollbar {
        display: none;
    }
</style>
@endsection
@section('content')
<div id="map" class="relative w-full h-[calc(100vh-50px)] mt-[50px]">
    @include('home.layouts.popups')
    @include('home.layouts.sidebar_right')
    <button class="modal-open bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full" style='display: none;'>Open Modal</button>
    <div id="map-navbar" class="absolute top-1 left-[50%] translate-x-[-50%] z-50 bg-transparent rounded-md text-white-900 text-white font-poppins-light w-[80%] h-[35px] ml-10 p-1 flex gap-2 justify-start" style="display: none;">
        <div class="bg-upsdell-900 text-white rounded-full py-1 px-3">
            <span class="font-poppins-ultra"><span id="navbar-mode">"Procedure</span>:</span>
            <spam id="map-navbar-name"></span>
        </div>
        <div id="map-navbar-step-cont" class="bg-upsdell-900 text-white rounded-full py-1 px-3">
            Step No. <span id="map-navbar-step"></span>
        </div>
        <div class="bg-upsdell-900 text-white rounded-full py-1 px-3">
            <span class="font-poppins-ultra">Destination:</span> <span id="map-navbar-destination"></span>
        </div>
    </div>
    <button id="marker-toggle" type="button" class="absolute bottom-10 right-4 z-[100] text-upsdell-900 border bg-white border-[#7e7e7e] hover:bg-[#bbbbbb] hover:text-white focus:ring-4 focus:outline-none focus:ring-upsdell-900 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-upsdell-900 dark:text-upsdell-900 dark:hover:text-white dark:focus:ring-upsdell-900 dark:hover:bg-upsdell-900">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-tags" viewBox="0 0 16 16">
            <path d="M3 2v4.586l7 7L14.586 9l-7-7zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586z" />
            <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1z" />
        </svg>
        <span class="sr-only">Icon description</span>
    </button>
    <div id="currently-facing-cont" class="absolute top-2 left-2 z-50 bg-transparent px-1 py-2 rounded-md font-poppins-regular text-black outline-offset-1" style='display: none;'>Facing: <span id="currently-facing" class="font-bold bg-green-500 rounded-md text-black px-1 py-1"></span></div>
</div>

<div id="directions-cont" class="fixed py-8 top-0 w-[30%] left-[-30%] lg:left-[-30%] lg:w-[30%] h-full z-50">
    <h1 class="text-white font-poppins-regular p-1 text-center">Procedure Process Flow</h1>
    <div class="flex flex-row items-center justify-center gap-1 px-1 w-full h-full">
        <button type="button" class="shine bg-blue-500 hover:bg-blue-600 text-white font-bold py-5 px-1 rounded focus:outline-none focus:shadow-outline w-[7.5%] font-poppins-regular flex justify-center items-center text-[1rem]" id="procedure-prev-btn">&lt;</button>
        <div class="w-[80%] h-[90%] rounded-lg bg-white p-2 flex flex-col flex-between" style="overflow-y: auto;">
            <div class="h-[95%]" id="procedure-timeline" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">
                <!-- Timeline -->
                <div>
                    <div id='procedure-timeline-navbar'>
                        <div class="grow pt-0.5 pb-2">
                            <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#1f9597" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M3 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5H15v-18a.75.75 0 0 0 0-1.5H3ZM6.75 19.5v-2.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-.75.75h-3a.75.75 0 0 1-.75-.75ZM6 6.75A.75.75 0 0 1 6.75 6h.75a.75.75 0 0 1 0 1.5h-.75A.75.75 0 0 1 6 6.75ZM6.75 9a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75ZM6 12.75a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 0 1.5h-.75a.75.75 0 0 1-.75-.75ZM10.5 6a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75Zm-.75 3.75A.75.75 0 0 1 10.5 9h.75a.75.75 0 0 1 0 1.5h-.75a.75.75 0 0 1-.75-.75ZM10.5 12a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75ZM16.5 6.75v15h5.25a.75.75 0 0 0 0-1.5H21v-12a.75.75 0 0 0 0-1.5h-4.5Zm1.5 4.5a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Zm.75 2.25a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75v-.008a.75.75 0 0 0-.75-.75h-.008ZM18 17.25a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd"></path>
                                </svg>
                                <span id="procedure-name"></span>
                            </h3>
                            <p id='procedure-description' class="mt-2 indent-4 text-justify text-sm text-gray-600 dark:text-neutral-400">
                            </p>
                            <div class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 text-xs rounded-lg border border-transparent text-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400">
                                Number of Waypoints: <span id="procedure-waypoint-count" class="font-bold text-black"></span>
                            </div>
                        </div>
                        <hr class="mb-2">
                        <h1 class='text-center font-gordita-ultra mb-2'>Timeline Starts Here</h1>
                    </div>
                    <div id="timeline-body">
                    </div>
                    <div id="timeline-footer mb-2">
                        <div class="w-[100%] h-[5%] bg-transparent flex justify-center">
                            <button type="button" class="shine bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-12 font-poppins-regular flex justify-center items-center text-[0.75rem]" id="procedure-end-btn">End</button>
                            <button type="button" class="shine bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-12 font-poppins-regular flex justify-center items-center text-[0.75rem]" id="event-end-btn">End</button>
                        </div>
                    </div>
                </div>
                <!-- End Timeline -->
                <!-- <div id="initial-instructions-cont" class="font-poppins-light text-[0.80rem]"></div>
                <div id="instructions-cont" class="font-poppins-light text-[0.80rem]"></div> -->
            </div>
        </div>
        <button type="button" class="shine bg-blue-500 hover:bg-blue-600 text-white font-bold py-5 px-1 rounded focus:outline-none focus:shadow-outline w-[7.5%] font-poppins-regular flex justify-center items-center text-[1rem]" id="procedure-next-btn">></button>
    </div>
</div>

<div id="procedures-cont" class="fixed py-8 top-0 left-[-100%] lg:left-[-20%] w-full lg:w-[20%] h-full bg-upsdell-900 z-50">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" id="procedures-close-btn" fill="white" class="bi bi-x-circle-fill absolute top-[2.5%] right-[5%] hover:cursor-pointer" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
    </svg>
    <h1 class="text-white font-gordita-regular p-2 text-center">Procedures</h1>
    <div class="flex justify-center mt-2">
        <ul class="w-[90%] text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @if(count($procedures) > 1)
            @foreach($procedures as $procedure)
            @if ($loop->first)
            <li procedure_id='{{ $procedure->id }}' class="procedure-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600">{{ $procedure->procedure_name }}</li>
            @elseif ($loop->last)
            <li procedure_id='{{ $procedure->id }}' class="procedure-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light px-4 py-2 border-t border-gray-200 rounded-b-lg dark:border-gray-600">{{ $procedure->procedure_name }}</li>
            @else
            <li procedure_id='{{ $procedure->id }}' class="procedure-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light border px-4 py-2">{{ $procedure->procedure_name }}</li>
            @endif
            @endforeach
            @elseif(count($procedures) == 1)
            <li procedure_id='{{ $procedures[0]->id }}' class="procedure-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light px-4 py-2 rounded-lg border-gray-200 dark:border-gray-600">{{ $procedures[0]->procedure_name }}</li>
            @else
            <li class="w-full font-poppins-light px-4 py-2 border-b rounded-lg border-gray-200 dark:border-gray-600">No Records Found</li>
            @endif
        </ul>
    </div>
</div>

<div id="events-cont" class="fixed py-8 top-0 left-[-100%] w-full lg:left-[-20%] lg:w-[20%] h-full bg-upsdell-900 z-30">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" id="events-close-btn" fill="white" class="bi bi-x-circle-fill absolute top-[2.5%] right-[5%] hover:cursor-pointer" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
    </svg>
    <h1 class="text-white font-poppins-regular p-2 text-center">Events</h1>
    <div class="flex justify-center mt-2">
        <ul class="w-[90%] text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @if(count($events) > 1)
            @foreach($events as $event)
            @if ($loop->first)
            <li event_id='{{ $event->id }}' class="event-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600">{{ $event->event_name }}</li>
            @elseif ($loop->last)
            <li event_id='{{ $event->id }}' class="event-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light px-4 py-2 border-t border-gray-200 rounded-b-lg dark:border-gray-600">{{ $event->event_name }}</li>
            @else
            <li event_id='{{ $event->id }}' class="event-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light border px-4 py-2">{{ $event->event_name }}</li>
            @endif
            @endforeach
            @elseif(count($events) == 1)
            <li event_id='{{ $events[0]->id }}' class="event-item hover:cursor-pointer hover:bg-gray-300 w-full font-poppins-light px-4 py-2 rounded-lg border-gray-200 dark:border-gray-600">{{ $events[0]->event_name }}</li>
            @else
            <li class="w-full font-poppins-light px-4 py-2 border-b rounded-lg border-gray-200 dark:border-gray-600">No Records Found</li>
            @endif
        </ul>
    </div>
</div>

<!-- Modals -->
<div id="origin-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Choose a Starting Point
                </h3>
                <button type="button" id="origin-modal-close" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <div>
                    <label for="custom-starting-point" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Building Select</label>
                    <input type="search" name="origin" id="custom-starting-point" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Choose starting point..." required autocomplete="off" autofocus required />
                </div>

                <button type="button" id="custom-starting-point-btn" class="mt-1 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Get Directions</button>
            </div>
        </div>
    </div>
</div>
<div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

        <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
            <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
            </svg>
            <span class="text-sm">(Esc)</span>
        </div>

        <!-- Add margin if you want to see some of the overlay behind the modal-->
        <div class="modal-content py-4 text-left px-6">
            <!--Title-->
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold">Report a Bug or Give Feedbacks</p>
                <div class="modal-close cursor-pointer z-50">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </div>
            </div>

            <!--Body-->
            <form id="report-form" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Name (Optional)
                    </label>
                    <input id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Username">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Message
                    </label>
                    <textarea id="message" name="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 " placeholder="Write your feedback here..."></textarea>
                </div>


                <!--Footer-->
                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2">Submit</button>
                    <button type="button" class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>
<div id="map-legend" class="absolute top-[50%] left-[-100%] translate-x-[-50%] translate-y-[-50%] z-[105]" style="visibility: hidden;">
    <div class="relative flex flex-col mt-6 text-gray-700 bg-white shadow-md bg-clip-border rounded-xl w-96">
        <div class="p-6">
            <h5 class="text-center block mb-2 font-sans text-xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                MAP LEGEND
            </h5>
            <h6 class="text-lg font-sans mb-2 font-bold">Buildings</h6>
            @foreach($building_types as $bType)
            <div class='w-full flex gap-2'>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $bType->color }}" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M3 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5H15v-18a.75.75 0 0 0 0-1.5H3ZM6.75 19.5v-2.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-.75.75h-3a.75.75 0 0 1-.75-.75ZM6 6.75A.75.75 0 0 1 6.75 6h.75a.75.75 0 0 1 0 1.5h-.75A.75.75 0 0 1 6 6.75ZM6.75 9a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75ZM6 12.75a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 0 1.5h-.75a.75.75 0 0 1-.75-.75ZM10.5 6a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75Zm-.75 3.75A.75.75 0 0 1 10.5 9h.75a.75.75 0 0 1 0 1.5h-.75a.75.75 0 0 1-.75-.75ZM10.5 12a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75ZM16.5 6.75v15h5.25a.75.75 0 0 0 0-1.5H21v-12a.75.75 0 0 0 0-1.5h-4.5Zm1.5 4.5a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Zm.75 2.25a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75v-.008a.75.75 0 0 0-.75-.75h-.008ZM18 17.25a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd" />
                </svg>
                <p>{{ $bType->name }}</p>
            </div>
            @endforeach
            <h6 class="text-lg font-sans mb-2 mt-4 font-bold">Paths</h6>
            <div class='w-full flex gap-3 ml-2'>
                <svg width="10.560498" height="20.144857" viewBox="0 0 2.7941318 5.3299935" version="1.1" id="svg1" xml:space="preserve" inkscape:export-filename="bitmap.svg" inkscape:export-xdpi="96" inkscape:export-ydpi="96" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
                    <sodipodi:namedview id="namedview1" pagecolor="#505050" bordercolor="#eeeeee" borderopacity="1" inkscape:showpageshadow="0" inkscape:pageopacity="0" inkscape:pagecheckerboard="0" inkscape:deskcolor="#505050" inkscape:document-units="mm" />
                    <defs id="defs1" />
                    <g inkscape:label="Layer 1" inkscape:groupmode="layer" id="layer1" transform="translate(-1.7779341,-0.54758489)">
                        <path style="fill:#e81e63" d="M 1.7779341,3.2125818 V 0.54758489 H 2.3713115 2.964689 v 0.0676659 0.0676659 H 3.175 3.385311 V 0.61525083 0.54758489 H 3.9786885 4.572066 V 3.2125818 5.8775786 H 3.9786885 3.385311 V 5.8099127 5.7422467 H 3.175 2.964689 v 0.067666 0.067666 H 2.3713115 1.7779341 Z M 3.385311,4.8990251 V 4.6179512 H 3.175 2.964689 V 4.8990251 5.180099 H 3.175 3.385311 Z m 0,-1.1242956 V 3.4936556 H 3.175 2.964689 V 3.7747295 4.0558034 H 3.175 3.385311 Z m 0,-1.1242955 V 2.3693601 H 3.175 2.964689 V 2.650434 2.9315079 H 3.175 3.385311 Z m 0,-1.1242956 V 1.2450645 H 3.175 2.964689 V 1.5261384 1.8072123 H 3.175 3.385311 Z" id="path1" />
                    </g>
                </svg>
                <p>Indoor</p>
            </div>
            <div class='w-full flex gap-3 ml-2'>
                <svg width="10.560498" height="20.144857" viewBox="0 0 2.7941318 5.3299935" version="1.1" id="svg1" xml:space="preserve" inkscape:export-filename="bitmap.svg" inkscape:export-xdpi="96" inkscape:export-ydpi="96" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
                    <sodipodi:namedview id="namedview1" pagecolor="#505050" bordercolor="#eeeeee" borderopacity="1" inkscape:showpageshadow="0" inkscape:pageopacity="0" inkscape:pagecheckerboard="0" inkscape:deskcolor="#505050" inkscape:document-units="mm" />
                    <defs id="defs1" />
                    <g inkscape:label="Layer 1" inkscape:groupmode="layer" id="layer1" transform="translate(-1.7779341,-0.54758489)">
                        <path style="fill:blue" d="M 1.7779341,3.2125818 V 0.54758489 H 2.3713115 2.964689 v 0.0676659 0.0676659 H 3.175 3.385311 V 0.61525083 0.54758489 H 3.9786885 4.572066 V 3.2125818 5.8775786 H 3.9786885 3.385311 V 5.8099127 5.7422467 H 3.175 2.964689 v 0.067666 0.067666 H 2.3713115 1.7779341 Z M 3.385311,4.8990251 V 4.6179512 H 3.175 2.964689 V 4.8990251 5.180099 H 3.175 3.385311 Z m 0,-1.1242956 V 3.4936556 H 3.175 2.964689 V 3.7747295 4.0558034 H 3.175 3.385311 Z m 0,-1.1242955 V 2.3693601 H 3.175 2.964689 V 2.650434 2.9315079 H 3.175 3.385311 Z m 0,-1.1242956 V 1.2450645 H 3.175 2.964689 V 1.5261384 1.8072123 H 3.175 3.385311 Z" id="path1" />
                    </g>
                </svg>
                <p>Outdoor</p>
            </div>
            <div class='w-full flex gap-3 ml-2'>
                <svg width="10.560498" height="20.144857" viewBox="0 0 2.7941318 5.3299935" version="1.1" id="svg1" xml:space="preserve" inkscape:export-filename="bitmap.svg" inkscape:export-xdpi="96" inkscape:export-ydpi="96" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
                    <sodipodi:namedview id="namedview1" pagecolor="#505050" bordercolor="#eeeeee" borderopacity="1" inkscape:showpageshadow="0" inkscape:pageopacity="0" inkscape:pagecheckerboard="0" inkscape:deskcolor="#505050" inkscape:document-units="mm" />
                    <defs id="defs1" />
                    <g inkscape:label="Layer 1" inkscape:groupmode="layer" id="layer1" transform="translate(-1.7779341,-0.54758489)">
                        <path style="fill:yellow" d="M 1.7779341,3.2125818 V 0.54758489 H 2.3713115 2.964689 v 0.0676659 0.0676659 H 3.175 3.385311 V 0.61525083 0.54758489 H 3.9786885 4.572066 V 3.2125818 5.8775786 H 3.9786885 3.385311 V 5.8099127 5.7422467 H 3.175 2.964689 v 0.067666 0.067666 H 2.3713115 1.7779341 Z M 3.385311,4.8990251 V 4.6179512 H 3.175 2.964689 V 4.8990251 5.180099 H 3.175 3.385311 Z m 0,-1.1242956 V 3.4936556 H 3.175 2.964689 V 3.7747295 4.0558034 H 3.175 3.385311 Z m 0,-1.1242955 V 2.3693601 H 3.175 2.964689 V 2.650434 2.9315079 H 3.175 3.385311 Z m 0,-1.1242956 V 1.2450645 H 3.175 2.964689 V 1.5261384 1.8072123 H 3.175 3.385311 Z" id="path1" />
                    </g>
                </svg>
                <p>Pedestrian Lane</p>
            </div>
            <div class='w-full flex gap-3 ml-2'>
                <svg width="10.560498" height="20.144857" viewBox="0 0 2.7941318 5.3299935" version="1.1" id="svg1" xml:space="preserve" inkscape:export-filename="bitmap.svg" inkscape:export-xdpi="96" inkscape:export-ydpi="96" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
                    <sodipodi:namedview id="namedview1" pagecolor="#505050" bordercolor="#eeeeee" borderopacity="1" inkscape:showpageshadow="0" inkscape:pageopacity="0" inkscape:pagecheckerboard="0" inkscape:deskcolor="#505050" inkscape:document-units="mm" />
                    <defs id="defs1" />
                    <g inkscape:label="Layer 1" inkscape:groupmode="layer" id="layer1" transform="translate(-1.7779341,-0.54758489)">
                        <path style="fill:black" d="M 1.7779341,3.2125818 V 0.54758489 H 2.3713115 2.964689 v 0.0676659 0.0676659 H 3.175 3.385311 V 0.61525083 0.54758489 H 3.9786885 4.572066 V 3.2125818 5.8775786 H 3.9786885 3.385311 V 5.8099127 5.7422467 H 3.175 2.964689 v 0.067666 0.067666 H 2.3713115 1.7779341 Z M 3.385311,4.8990251 V 4.6179512 H 3.175 2.964689 V 4.8990251 5.180099 H 3.175 3.385311 Z m 0,-1.1242956 V 3.4936556 H 3.175 2.964689 V 3.7747295 4.0558034 H 3.175 3.385311 Z m 0,-1.1242955 V 2.3693601 H 3.175 2.964689 V 2.650434 2.9315079 H 3.175 3.385311 Z m 0,-1.1242956 V 1.2450645 H 3.175 2.964689 V 1.5261384 1.8072123 H 3.175 3.385311 Z" id="path1" />
                    </g>
                </svg>
                <p>Road</p>
            </div>
        </div>
        <div class="p-6 pt-0">
            <a href="#" class="inline-block">
                <button class="flex items-center gap-2 px-4 py-2 font-sans text-xs font-bold text-center text-gray-900 uppercase align-middle transition-all rounded-lg select-none disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none hover:bg-gray-900/10 active:bg-gray-900/20" type="button">
                    Learn More
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                    </svg>
                </button>
            </a>
        </div>
    </div>
</div>
<!-- Open the modal using ID.showModal() method -->

<!-- End of Modals -->
@endsection
@section('more_scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>
<script>
    $(document).ready(function() {
        // Map Initialization
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2Ftc3RyZWV0IiwiYSI6ImNsczRxb29mdTE1ZmkybHBjcHBhcG9xN2kifQ.SpJ2sxffT8PRfQjFtYgg6Q';
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/samstreet/clu2rl1ub024601oigzn6960q',
            zoom: 17,
            minZoom: 16,
            center: [124.2438547179179, 8.2414298468554],
            bearing: -95,
            maxBounds: [
                [124.23616973647256, 8.233619024568284], // Southwest bound
                [124.25301604017682, 8.248537110726303] // Northeast bound
            ]
        });
        map.addControl(new mapboxgl.NavigationControl())


        // Initialize the GeolocateControl.
        const geolocate = new mapboxgl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true
            },
            trackUserLocation: true
        });
        // Add the control to the map.
        map.addControl(geolocate);
        // Set an event listener that fires
        // when a geolocate event occurs.
        geolocate.on('geolocate', (response) => {
            console.log(response.coords.longitude);
            console.log(response.coords.latitude);
        });
        // End of Map Initialization

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
                data['boundary'] = true;
                data['boundary_with_name'] = true;
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
                            const ell = document.createElement('div');
                            ell.textContent = marker.building.building_name;
                            ell.className = 'display-label';
                            ell.style.display = 'none';
                            var labelMarker = new mapboxgl.Marker(ell)
                                .setLngLat(coordinates)
                                .addTo(map);
                        });
                    }
                    if (boundary) {
                        var boundaries = response.boundaries;
                        boundaries.forEach(boundary => {
                            const fillColor = boundary.building_details.color;
                            var temp = JSON.parse(boundary.corners);
                            var boundaryCoordinates = [];
                            for (let key in temp) {
                                if (temp.hasOwnProperty(key)) {
                                    boundaryCoordinates.push([temp[key].lng, temp[key].lat]);
                                }
                            }
                            map.addLayer({
                                id: `polygon-display-${boundary.id}`,
                                type: 'fill-extrusion',
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
                                    'fill-extrusion-color': fillColor,
                                    'fill-extrusion-height': 4,
                                    'fill-extrusion-opacity': 0.8
                                }
                            }, 'boundary-latest-19j3o8');
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }
        map.on('style.load', function() {
            renderElements(false, true, false, true);
        });

        function showMapLayers() {
            map.getStyle().layers.forEach(function(layer) {
                console.log(layer.id);
            });
        }
        // End of Element Rendering

        // Map Elements Optimizations
        map.on('zoom', function() {
            const zoom = map.getZoom();
            const markers = document.querySelectorAll('.display-marker');

            markers.forEach(marker => {
                if (zoom >= 20) {
                    marker.style.width = '130px';
                    marker.style.height = '130px';
                } else if (zoom >= 19 && zoom < 20) {
                    marker.style.width = '90px';
                    marker.style.height = '90px';
                } else if (zoom >= 18 && zoom < 20) {
                    marker.style.width = '60px';
                    marker.style.height = '60px';
                } else if (zoom >= 17 && zoom < 18) {
                    marker.style.width = '40px';
                    marker.style.height = '40px';
                } else {
                    marker.style.width = '10px';
                    marker.style.height = '10px';
                }
            });
        });
        // End of Map Elements Optimizations

        // Building Information Functions
        $(document).on('click', '.display-marker', function() {
            var samplePopup = $('#popup-sample');
            if (window.innerWidth <= 767) {
                samplePopup.animate({
                    right: '7.5%'
                }, 500)
            } else {
                samplePopup.animate({
                    right: '7.5%'
                }, 500)
            }
            var target = $(this).attr('display-marker');
            $('.popup-sample-btn').click();
            $('#popup-image').attr('src', '');
            $('#popup-building-description').text('');
            $('#popup-building-name').text('');
            $.ajax({
                url: '{{ route("buildings.find") }}',
                data: {
                    'target': target
                },
                success: function(response) {
                    $('.popup-sample-btn').click();
                    $('#popup-building-name').text(response.building.building_name);
                    var imageSourceA = 'storage/';
                    var imageSourceB = response.marker.marker_image;
                    $('#popup-image').attr('src', imageSourceA + imageSourceB);
                    $('#popup-building-description').text(response.details.building_description);
                },
                error: function(error) {
                    console.log(error);
                }
            })

        });
        // End of Building Information Functions

        // Dijkstra's Algorithm
        var directionsBtn = document.getElementById('popup-directions-btn');
        var origin = null;
        var destination = null;
        var gps_json = {};
        var npl_json = {};

        function renderRoute(route, non_raw = null, gpsMode = null) {
            var allDisplayBoundaries = map.getStyle().layers.filter(function(layer) {
                return layer.id.startsWith('route-path-');
            });
            allDisplayBoundaries.forEach(function(layer) {
                map.removeLayer(layer.id);
            });
            allDisplayBoundaries.forEach(function(layer) {
                if (map.getSource(layer.source)) {
                    map.removeSource(layer.source);
                }
            });
            for (let i = 0; i < route.length - 1; i++) {
                if (i == 0 && route[i] == "GPS") {
                    renderPath([gps_json.coordinates], [npl_json.coordinates], 'full');
                } else if (i == 1 && route[i] == "NPL") {
                    renderPath([npl_json.coordinates], route[i + 1], 'half');
                } else {
                    if (i == 0) {
                        renderPath(route[i], route[i + 1], false, true);
                    } else if (i == route.length - 2) {
                        renderPath(route[i], route[i + 1]);
                    } else {
                        renderPath(route[i], route[i + 1]);
                    }
                }
            }
            var samplePopup = $('#popup-sample');
            samplePopup.animate({
                right: '-100%'
            }, 500)
            if (non_raw) {
                getDirections(route, true);
            } else {
                if (gpsMode) {
                    getDirections(route, false, true);
                } else {
                    getDirections(route);
                }
            }
        }

        function customRound(number) {
            var decimalPart = number - Math.floor(number);
            if (decimalPart >= 0.5) {
                return Math.ceil(number);
            } else {
                return Math.floor(number);
            }
        }

        async function getDirections(route, non_raw = null, gpsMode = null) {
            $('#procedure-end-btn').show();
            console.log(route)
            try {
                var paths = await getPathsFromRoute(route)
                console.log(paths)
                var facing;
                var weight;
                var directions = [];
                var prevCode = route[0];
                // Assuming your array is named 'pathsArray'
                paths.forEach(function(item, loopNumber) {
                    if (item.path) {
                        var wp_a = [item.path.wp_a_lng, item.path.wp_a_lat];
                        var wp_b = [item.path.wp_b_lng, item.path.wp_b_lat];
                        // Create a custom HTML element for the marker
                        var el = document.createElement('div');
                        el.className = 'custom-marker';
                        el.textContent = loopNumber + 1; // Display loopNumber with an offset of 1
                        if (prevCode == 'NPL') {
                            if (route[2] == paths[2].path.wp_a_code) {
                                wp_a = [paths[2].path.wp_a_lng, paths[2].path.wp_a_lat];
                                wp_b = [paths[2].path.wp_b_lng, paths[2].path.wp_b_lat];
                            } else {
                                wp_a = [paths[2].path.wp_b_lng, paths[2].path.wp_b_lat];
                                wp_b = [paths[2].path.wp_a_lng, paths[2].path.wp_a_lat];
                            }
                            prevCode = route[3];
                            var marker = new mapboxgl.Marker(el)
                                .setLngLat(wp_b) // Assuming these are the coordinates of the point
                                .addTo(map);
                            weight = customRound(turf.distance(
                                turf.point(wp_a),
                                turf.point(wp_b), {
                                    units: 'meters'
                                }
                            ));
                            directions.push(`Head ${weight}m ${facing}`);
                        } else {
                            // Create the marker and set its position
                            if (prevCode == item.path.wp_a_code) {
                                var marker = new mapboxgl.Marker(el)
                                    .setLngLat([item.path.wp_b_lng, item.path.wp_b_lat]) // Assuming these are the coordinates of the point
                                    .addTo(map);
                                facing = getCardinalDirection(
                                    turf.bearing(
                                        turf.point([item.path.wp_a_lng, item.path.wp_a_lat]),
                                        turf.point([item.path.wp_b_lng, item.path.wp_b_lat])
                                    )
                                );
                                prevCode = item.path.wp_b_code;
                            } else {
                                var marker = new mapboxgl.Marker(el)
                                    .setLngLat([item.path.wp_a_lng, item.path.wp_a_lat]) // Assuming these are the coordinates of the point
                                    .addTo(map);
                                facing = getCardinalDirection(
                                    turf.bearing(
                                        turf.point([item.path.wp_b_lng, item.path.wp_b_lat]),
                                        turf.point([item.path.wp_a_lng, item.path.wp_a_lat])
                                    )
                                );
                                prevCode = item.path.wp_a_code
                            }
                            weight = customRound(item.path.weight);
                            if (item.path.landmark) {
                                directions.push(`Head ${weight}m ${facing} near ${item.path.landmark}`);
                            } else {
                                if (loopNumber < paths.length - 1) {
                                    if (item.path.type == 'indoor') {
                                        directions.push(`<span class="font-bold text-[#e81e63]">Indoor:</span> Head ${weight}m ${facing}`);
                                    } else if (item.path.type == 'pedestrian lane') {
                                        directions.push(`<span class="font-bold text-[#f0ad4e]">You are crossing the road!</span> Look left and right, then head ${weight}m ${facing}`);
                                    } else {
                                        directions.push(`Head ${weight}m ${facing}`);
                                    }
                                } else if (loopNumber == paths.length - 1) {
                                    directions.push(`Head ${weight}m ${facing} and head inside your <span class="font-bold text-[#5cb85c]">destination</span>`);
                                } else {
                                    directions.push(`Head ${weight}m ${facing}`);
                                }
                            }
                        }
                    } else {
                        var el = document.createElement('div');
                        el.className = 'custom-marker';
                        el.textContent = loopNumber + 1;
                        if (loopNumber == 0 && route[0] == 'GPS') {
                            el.style.zIndex = '100';
                            wp_a = [gps_json.coordinates[0], gps_json.coordinates[1]];
                            wp_b = [npl_json.coordinates[0], npl_json.coordinates[1]];
                            var marker = new mapboxgl.Marker(el)
                                .setLngLat(wp_b) // Assuming these are the coordinates of the point
                                .addTo(map);
                            facing = getCardinalDirection(
                                turf.bearing(
                                    turf.point(wp_a),
                                    turf.point(wp_b)
                                )
                            );
                            prevCode = 'GPS';
                            weight = customRound(turf.distance(
                                turf.point(wp_a),
                                turf.point(wp_b), {
                                    units: 'meters'
                                }
                            ));
                            directions.push(`Head ${weight}m ${facing}`);
                        } else if (loopNumber == 1 && route[1] == 'NPL' && route.length > 3) {
                            wp_a = [npl_json.coordinates[0], npl_json.coordinates[1]];
                            if (route[2] == paths[2].path.wp_a_code) {
                                wp_b = [paths[2].path.wp_a_lng, paths[2].path.wp_a_lat];
                            } else {
                                wp_b = [paths[2].path.wp_b_lng, paths[2].path.wp_b_lat];
                            }
                            var marker = new mapboxgl.Marker(el)
                                .setLngLat(wp_b) // Assuming these are the coordinates of the point
                                .addTo(map);
                            facing = getCardinalDirection(
                                turf.bearing(
                                    turf.point(wp_a),
                                    turf.point(wp_b)
                                )
                            );
                            prevCode = 'NPL';
                            weight = customRound(turf.distance(
                                turf.point(wp_a),
                                turf.point(wp_b), {
                                    units: 'meters'
                                }
                            ));
                            directions.push(`Head ${weight}m ${facing}`);
                        } else if (loopNumber == 1 && route[1] == 'NPL' && route.length === 3) {
                            $.ajax({
                                url: '{{ route("paths.find") }}',
                                data: {
                                    'half': true,
                                    'code': route[2]
                                },
                                success: (response) => {
                                    return response.result_path;
                                },
                                error: (error) => {
                                    console.log(error)
                                }
                            }).then((result) => {
                                wp_a = [npl_json.coordinates[0], npl_json.coordinates[1]];
                                wp_b = result.result_path;
                                var marker = new mapboxgl.Marker(el)
                                    .setLngLat(wp_b) // Assuming these are the coordinates of the point
                                    .addTo(map);
                                facing = getCardinalDirection(
                                    turf.bearing(
                                        turf.point(wp_a),
                                        turf.point(wp_b)
                                    )
                                );
                                weight = customRound(turf.distance(
                                    turf.point(wp_a),
                                    turf.point(wp_b), {
                                        units: 'meters'
                                    }
                                ));
                                directions.push(`Head ${weight}m ${facing}`);
                            })
                        }
                    }
                });
                printDirections(directions);
                if (non_raw) {
                    openRightSidebar(true);
                } else {
                    openRightSidebar();
                }
            } catch (error) {
                console.log(error);
            }
        }

        function printDirections(directions) {
            directions.forEach(function(thisDirections, loopNumber) {
                if (loopNumber === directions.length - 1) {
                    // This is the last iteration
                    document.getElementById('directions-step-cont').innerHTML += `
                        <div class="direction-group relative">
                            <span id="step-no" class="text-[0.75rem] bg-metallicGold-900 rounded-full font-bold mr-2 h-5 w-5 flex items-center justify-center absolute top-0 left-0">${loopNumber + 1}</span>
                            <p class="indent-6">${thisDirections}</p>
                        </div>
                    `;
                } else {
                    // Not the last iteration
                    document.getElementById('directions-step-cont').innerHTML += `
                        <div class="direction-group relative">
                            <span id="step-no" class="text-[0.75rem] bg-metallicGold-900 rounded-full font-bold mr-2 h-5 w-5 flex items-center justify-center absolute top-0 left-0">${loopNumber + 1}</span>
                            <p class="indent-6">${thisDirections}</p>
                        </div>
                        <hr class="my-2 border-[rgb(0,0,0,0.5)]">
                    `;
                }
            });
        }

        async function getPathsFromRoute(route) {
            var pathInstances = [];
            var loopEnd = route.length - 1;

            for (let loopNumber = 0; loopNumber < loopEnd; loopNumber++) {
                var data = {
                    'a': route[loopNumber],
                    'b': route[loopNumber + 1],
                    'single_search': true
                };
                if (loopNumber === 0) {
                    data['first'] = true;
                } else if (loopNumber === loopEnd - 1) {
                    data['last'] = true;
                }

                try {
                    var value = await findPath(data);
                    pathInstances.push(value);
                } catch (error) {
                    console.log(error);
                }
            }
            return pathInstances;
        }


        async function findPath(data) {
            try {
                var response = await $.ajax({
                    url: '{{ route("paths.find") }}',
                    data: data,
                });
                return response;
            } catch (error) {
                console.log(error);
                throw error;
            }
        }


        function renderPath(a, b, raw = false, first = false) {
            if (raw === false) {
                var data = {
                    'a': a,
                    'b': b,
                    'single_search': true
                }
                if (first) {
                    if (first == 'last') {
                        data['last'] = true;
                    } else {
                        data['first'] = true;
                    }
                }
                $.ajax({
                    url: '{{ route("paths.find") }}',
                    data: data,
                    success: function(response) {
                        if (!response.skip) {
                            const lineCoordinates = [
                                [response.path.wp_a_lng, response.path.wp_a_lat],
                                [response.path.wp_b_lng, response.path.wp_b_lat]
                            ];
                            if (first) {
                                gpsSuccess([response.path.wp_a_lng, response.path.wp_a_lat],
                                    [response.path.wp_b_lng, response.path.wp_b_lat]);
                                if (first) {
                                    var markerCoordinates;
                                    if (response.aFirst) {
                                        markerCoordinates = [response.path.wp_a_lng, response.path.wp_a_lat];
                                    } else {
                                        markerCoordinates = [response.path.wp_b_lng, response.path.wp_b_lat];
                                    }
                                    var marker = new mapboxgl.Marker({
                                            color: 'red'
                                        })
                                        .setLngLat(markerCoordinates)
                                        .addTo(map);
                                    var markerElement = marker.getElement();
                                    markerElement.className += ' start-marker';
                                }
                            }
                            var pathColor;
                            if (response.path.type == 'indoor') {
                                pathColor = 'pink';
                            } else if (response.path.type == 'outdoor') {
                                pathColor = 'blue';
                            } else if (response.path.type == 'pedestrian lane') {
                                pathColor = 'yellow';
                            } else if (response.path.type == 'road') {
                                pathColor = 'black';
                            }
                            map.addLayer({
                                'id': `route-path-${response.path.id.toString()}`,
                                'type': 'line',
                                'source': {
                                    'type': 'geojson',
                                    'data': {
                                        'type': 'Feature',
                                        'properties': {},
                                        'geometry': {
                                            'type': 'LineString',
                                            'coordinates': lineCoordinates
                                        }
                                    }
                                },
                                'layout': {
                                    'line-join': 'round',
                                    'line-cap': 'round'
                                },
                                'paint': {
                                    'line-color': pathColor,
                                    'line-width': 4
                                }
                            }, 'boundary-latest-19j3o8');
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                })
            } else if (raw === true) {
                var tempLine = [
                    a,
                    b
                ];
                if (map.getSource('temporary-line')) {
                    map.removeLayer('temporary-line');
                    map.removeSource('temporary-line');
                }
                map.addLayer({
                    'id': `temporary-line`,
                    'type': 'line',
                    'source': {
                        'type': 'geojson',
                        'data': {
                            'type': 'Feature',
                            'properties': {},
                            'geometry': {
                                'type': 'LineString',
                                'coordinates': tempLine
                            }
                        }
                    },
                    'layout': {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    'paint': {
                        'line-color': 'blue',
                        'line-width': 4
                    }
                }, 'waterway-label');
            } else if (raw == 'full') {
                const lineCoordinates = [
                    a[0],
                    b[0]
                ];
                const el = document.createElement('div');
                el.className = 'start-marker';
                el.style.color = 'green';
                var marker = new mapboxgl.Marker(el)
                    .setLngLat(a[0])
                    .addTo(map);
                map.addLayer({
                    'id': `route-path-gps`,
                    'type': 'line',
                    'source': {
                        'type': 'geojson',
                        'data': {
                            'type': 'Feature',
                            'properties': {},
                            'geometry': {
                                'type': 'LineString',
                                'coordinates': lineCoordinates
                            }
                        }
                    },
                    'layout': {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    'paint': {
                        'line-color': 'blue',
                        'line-width': 4
                    }
                }, 'waterway-label');
                var thisMarker = new mapboxgl.Marker({
                        className: 'gps-marker'
                    })
                    .setLngLat(a[0], a[1])
                    .addTo(map);
                gpsSuccess(a[0], b[0]);
            } else if (raw == 'half') {
                $.ajax({
                    url: '{{ route("paths.find") }}',
                    data: {
                        'code': b,
                        'half': true
                    },
                    success: (response) => {
                        const lineCoordinates = [
                            a[0],
                            response.result_path
                        ];
                        map.addLayer({
                            'id': `route-path-gps-half`,
                            'type': 'line',
                            'source': {
                                'type': 'geojson',
                                'data': {
                                    'type': 'Feature',
                                    'properties': {},
                                    'geometry': {
                                        'type': 'LineString',
                                        'coordinates': lineCoordinates
                                    }
                                }
                            },
                            'layout': {
                                'line-join': 'round',
                                'line-cap': 'round'
                            },
                            'paint': {
                                'line-color': 'blue',
                                'line-width': 4
                            }
                        }, 'waterway-label');
                    },
                    error: (error) => {
                        console.log(error)
                    }
                })
            }
        }
        directionsBtn.addEventListener('click', function(e) {
            var data = {
                'origin': 'A',
                'destination': 'ED'
            }
            $.ajax({
                url: '{{ route("directions.get") }}',
                data: data,
                success: (response) => {
                    renderRoute(response.route);
                },
                error: (error) => {
                    console.log(error);
                }
            })
        });

        function multipleCalculations(origin_points, destination_points, additionalData = null, non_raw = null) {
            var shortestRoute = null;
            var totalRequests = origin_points.length * destination_points.length;
            var completedRequests = 0;
            origin_points.forEach(function(origin) {
                destination_points.forEach(function(destination) {
                    if (_gps === false) {
                        var data = {
                            'origin': origin,
                            'destination': destination,
                            'single_search': true,
                            'weight': true
                        }
                    } else {
                        var data = {
                            'origin': origin,
                            'destination': destination,
                            'single_search': true,
                            'weight': true,
                            'gps': true,
                            'nearest_path_id': additionalData.nearestPathId,
                            'GPSNPL': additionalData.GPSNPL,
                            'NPLA': additionalData.NPLA,
                            'NPLB': additionalData.NPLB
                        }
                    }
                    $.ajax({
                        url: '{{ route("directions.get") }}',
                        data: data,
                        success: function(response) {
                            if (!shortestRoute || response.weight < shortestRoute[1]) {
                                shortestRoute = [response.route, response.weight];
                            }
                            completedRequests++;

                            // Check if all requests are completed
                            if (completedRequests === totalRequests) {
                                if (non_raw) {
                                    renderRoute(shortestRoute[0], true);
                                } else {
                                    if (additionalData) {
                                        renderRoute(shortestRoute[0], false, true);
                                    } else {
                                        renderRoute(shortestRoute[0]);
                                    }
                                }
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            });
        }
        async function determineOriginPoint() {
            let determineOriginPointPromise = new Promise(function(myResolve, myReject) {
                Swal.fire({
                    title: "Do you want to use you current location as your starting point?",
                    showDenyButton: true,
                    confirmButtonText: "Yes, I'll use GPS for my starting point",
                    denyButtonText: "No, I'll specify my starting point"
                }).then((result) => {
                    if (result.isConfirmed) {
                        myResolve(true);
                    } else {
                        myResolve(false);
                    }
                });
            });
            return await determineOriginPointPromise;
        }

        async function getOriginPoint() {
            let getOriginPointPromise = new Promise(function(myResolve, myReject) {
                var customStartingPointBtn = document.getElementById('custom-starting-point-btn');
                customStartingPointBtn.addEventListener('click', function() {
                    var originPointResult = document.getElementById('custom-starting-point').value;
                    if (originPointResult) {
                        myResolve(originPointResult);
                    } else {
                        myReject(false);
                    }
                })
            })
            return await getOriginPointPromise;
        }

        $('#origin-modal-close').click(function() {
            var modal = $('#origin-modal');
            modal.removeClass('modal-open');
            setTimeout(function() {
                modal.hide();
            }, 200);
            endProcedureNavigation();
        });
        // End of Dijkstra's Algorithm

        // Searchbar Functions
        var building_names = [];

        $.ajax({
            url: '{{ route("buildings.get") }}',
            data: {
                'names': true,
                'active': true
            },
            success: (response) => {
                building_names = response.names;
                console.log(building_names)
                $('#starting-point').autocomplete({
                    source: building_names
                });
                $('#destination').autocomplete({
                    source: building_names
                });
                $('#custom-starting-point').autocomplete({
                    source: building_names
                });
                // Function to set max-width of .ui-autocomplete to match the input's width
                function setAutocompleteWidth() {
                    var inputWidth = $('#starting-point').outerWidth();
                    $('.ui-autocomplete').css('max-width', inputWidth);
                }

                // Call the function initially
                setAutocompleteWidth();

                // Recalculate and set the width whenever the window is resized
                $(window).resize(function() {
                    setAutocompleteWidth();
                });
            },
            error: (error) => {
                console.log(error);
            }
        });

        $('#sidebar-searchbar').submit(function(e) {
            removeGpsMarker();
            e.preventDefault();
            var data = $(this).serialize();
            data += '&sidebar=true';
            if (window.innerWidth <= 767) {
                sidebarToggle(false);
            }
            if (_gps === false) {
                $.ajax({
                    url: '{{ route("directions.get.polarpoints") }}',
                    data: data,
                    success: (response) => {
                        var origin_decoded = JSON.parse(JSON.parse(response.target_origin.entrypoints));
                        var destination_decoded = JSON.parse(JSON.parse(response.target_destination.entrypoints));
                        var origin_points = [];
                        var destination_points = [];
                        for (let key in origin_decoded) {
                            origin_points.push(origin_decoded[key].code);
                        }
                        for (let key in destination_decoded) {
                            destination_points.push(destination_decoded[key].code);
                        }
                        multipleCalculations(origin_points, destination_points);
                    },
                    error: (error) => {
                        console.log(error);
                    }
                })
            } else {
                var currentLocationSample = [124.24436541380965, 8.23990409574499];
                nearestLine(currentLocationSample);
            }
        });
        // End of Searchbar Functions

        // Realtime Origin Point
        function gpsSuccess(position, initial) {
            var point1 = turf.point(position);
            var point2 = turf.point(initial);
            var bearing = turf.bearing(point1, point2);
            map.easeTo({
                center: position,
                zoom: 20,
                duration: 2000,
                pitch: 60,
                bearing: bearing
            });
        }

        var originPointInput = document.getElementById('starting-point');
        var currentLocBtn = document.getElementById('current-location');
        var _gps = false;
        Object.defineProperty(window, 'gps', {
            get: function() {
                return _gps;
            },
            set: function(value) {
                if (value === true) {
                    disableOriginInput();
                    _gps = true;
                } else if (value === false) {
                    enableOriginInput();
                    removeGpsMarker();
                    _gps = false;
                }
            }
        });

        function removeGpsMarker() {
            var gpsMarkers = document.querySelectorAll('.gps-marker');
            var startMarkers = document.querySelectorAll('.start-marker');
            var customMarkers = document.querySelectorAll('.custom-marker');
            gpsMarkers.forEach(function(gpsMarker) {
                gpsMarker.remove();
            })
            startMarkers.forEach(function(startMarker) {
                startMarker.remove();
            })
            customMarkers.forEach(function(customMarker) {
                customMarker.remove();
            });
        }

        function resetMap() {
            map.easeTo({
                zoom: 17,
                center: [124.2438547179179, 8.2414298468554],
                duration: 2000,
                pitch: 0,
                bearing: -95
            });
        }

        currentLocBtn.addEventListener('click', function() {
            if (_gps === true) {
                gps = false
            } else if (_gps === false) {
                gps = true
            }
        });

        function disableOriginInput() {
            originPointInput.setAttribute('readonly', '');
            originPointInput.value = 'Your Location';
            originPointInput.style.backgroundColor = '#ffea82';
        }

        function enableOriginInput() {
            originPointInput.removeAttribute('readonly');
            originPointInput.value = '';
            originPointInput.style.backgroundColor = 'white';
            if (map.getSource('temporary-line')) {
                map.removeLayer('temporary-line');
                map.removeSource('temporary-line');
            }
            var allDisplayBoundaries = map.getStyle().layers.filter(function(layer) {
                return layer.id.startsWith('route-path-');
            });
            allDisplayBoundaries.forEach(function(layer) {
                map.removeLayer(layer.id);
            });
            allDisplayBoundaries.forEach(function(layer) {
                if (map.getSource(layer.source)) {
                    map.removeSource(layer.source);
                }
            });
        }

        map.on('click', (e) => {
            console.log(e.lngLat);
        });

        function nearestLine(currentLoc, returnValue = null) {
            var point = turf.point(currentLoc);
            $.ajax({
                url: '{{ route("paths.get") }}',
                data: '',
                success: (response) => {
                    const lineStrings = [];
                    var results = response.paths;
                    results.forEach(function(path, index) {
                        // Construct GeoJSON features for each LineString
                        const lineStringFeature = turf.lineString([
                            [path.wp_a_lng, path.wp_a_lat],
                            [path.wp_b_lng, path.wp_b_lat]
                        ], {
                            id: path.id
                        });
                        lineStrings.push(lineStringFeature);
                    });

                    let nearestLineString;
                    let minDistance = Infinity;
                    // Iterate through each LineString to find the nearest one
                    lineStrings.forEach(lineString => {
                        const distance = turf.pointToLineDistance(point, lineString, {
                            units: 'meters'
                        });

                        // Update the nearest LineString if a closer one is found
                        if (distance < minDistance) {
                            minDistance = distance;
                            nearestLineString = lineString;
                        }
                    });
                    nearestPointOnLine(currentLoc, nearestLineString.properties.id);
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }

        function nearestLineNew(currentLoc, returnValue = null) {
            return new Promise((resolve, reject) => {
                var point = turf.point(currentLoc);
                $.ajax({
                    url: '{{ route("paths.get") }}',
                    data: '',
                    success: (response) => {
                        const lineStrings = [];
                        var results = response.paths;
                        results.forEach(function(path, index) {
                            // Construct GeoJSON features for each LineString
                            const lineStringFeature = turf.lineString([
                                [path.wp_a_lng, path.wp_a_lat],
                                [path.wp_b_lng, path.wp_b_lat]
                            ], {
                                id: path.id
                            });
                            lineStrings.push(lineStringFeature);
                        });

                        let nearestLineString;
                        let minDistance = Infinity;
                        // Iterate through each LineString to find the nearest one
                        lineStrings.forEach(lineString => {
                            const distance = turf.pointToLineDistance(point, lineString, {
                                units: 'meters'
                            });

                            // Update the nearest LineString if a closer one is found
                            if (distance < minDistance) {
                                minDistance = distance;
                                nearestLineString = lineString;
                            }
                        });
                        if (returnValue) {
                            resolve(nearestLineString.properties.id);
                        } else {
                            resolve(nearestPointOnLine(currentLoc, nearestLineString.properties.id));
                        }
                    },
                    error: (error) => {
                        reject(error);
                    }
                });
            });
        }

        function nearestPointOnLine(currentLoc, nearestLine, procedure = null) {
            const {
                nearestPointOnLine
            } = turf;
            $.ajax({
                url: '{{ route("paths.find") }}',
                data: {
                    'id_search': true,
                    'id': nearestLine
                },
                success: (response) => {
                    var path = response.path;
                    var point = turf.point(currentLoc);
                    var line = turf.lineString([
                        [path.wp_a_lng, path.wp_a_lat],
                        [path.wp_b_lng, path.wp_b_lat]
                    ]);
                    var snapped = turf.nearestPointOnLine(line, point, {
                        units: 'miles'
                    });

                    var nearestPoint = [snapped.geometry.coordinates[0], snapped.geometry.coordinates[1]];
                    if (procedure) {
                        temporaryPoints(currentLoc, nearestPoint, path, procedure);
                    } else {
                        temporaryPoints(currentLoc, nearestPoint, path);
                    }
                },
                error: (error) => {
                    console.log(error);
                }
            })
        }

        function temporaryPoints(GPS, NPL, path, procedure = null) {
            gps_json = {};
            gps_json = {
                'coordinates': GPS
            }
            npl_json = {};
            npl_json = {
                'coordinates': NPL
            };
            var GPSNPL = turf.distance(turf.point(GPS), turf.point(NPL), {
                units: 'meters'
            })
            var NPLA = turf.distance(turf.point(NPL), turf.point([path.wp_a_lng, path.wp_a_lat]), {
                units: 'meters'
            });
            var NPLB = turf.distance(turf.point(NPL), turf.point([path.wp_b_lng, path.wp_b_lat]), {
                units: 'meters'
            });
            if (procedure) {
                var destination = document.getElementById('map-navbar-destination').innerText;
            } else {
                var destination = document.getElementById('destination').value;
            }
            $.ajax({
                url: '{{ route("directions.get.polarpoints") }}',
                data: {
                    'destination': destination
                },
                success: (response) => {
                    var destination_points = [];
                    var destination_decoded = JSON.parse(JSON.parse(response.target_destination.entrypoints));
                    for (let key in destination_decoded) {
                        destination_points.push(destination_decoded[key].code);
                    }
                    if (procedure) {
                        multipleCalculations(
                            GPS,
                            destination_points, {
                                'nearestPathId': path.id,
                                'GPSNPL': GPSNPL,
                                'NPLA': NPLA,
                                'NPLB': NPLB
                            },
                            true
                        );
                    } else {
                        multipleCalculations(
                            GPS,
                            destination_points, {
                                'nearestPathId': path.id,
                                'GPSNPL': GPSNPL,
                                'NPLA': NPLA,
                                'NPLB': NPLB
                            },
                            false
                        );
                    }
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }

        function removeGpsMarkers() {
            var allGpsMarkers = document.querySelectorAll('.gps-marker');
            allGpsMarkers.forEach(function(gpsMarker) {
                gpsMarker.remove();
            })
        }

        function removeRenderedPaths() {
            var allDisplayBoundaries = map.getStyle().layers.filter(function(layer) {
                return layer.id.startsWith('route-path-');
            });
            allDisplayBoundaries.forEach(function(layer) {
                map.removeLayer(layer.id);
            });
            allDisplayBoundaries.forEach(function(layer) {
                if (map.getSource(layer.source)) {
                    map.removeSource(layer.source);
                }
            });
        }

        // Procedures Functions
        var procedurePopupStatus = 0;
        $('.procedure-item').click(function() {
            var procedurePopup = $('#popup-procedure');
            var proceduresCont = $('#procedures-cont');
            var navbar = $('#navbar');
            var map = $('#map');
            if (procedurePopupStatus == 0) {
                displayProcedureTimeline($(this).attr('procedure_id'));
                if (window.innerWidth <= 767) {
                    proceduresCont.animate({
                        left: '-100%'
                    }, 500)
                    navbar.animate({
                        width: '100%',
                        marginLeft: '0%'
                    }, 500);
                    map.animate({
                        width: '100%',
                        marginLeft: '0%'
                    }, 500)
                }
                procedurePopup.animate({
                    right: '7.5%'
                }, 500)
                procedurePopupStatus = 1;
            } else {
                if (window.innerWidth <= 767) {
                    proceduresCont.animate({
                        left: '0%'
                    }, 500)
                } else {
                    procedurePopup.animate({
                        right: '-100%'
                    }, 500)
                    procedurePopupStatus = 0;
                }
            }
        });
        $('.popup-procedure-close-btn').on('click', function() {
            var procedurePopup = $('#popup-procedure');
            procedurePopup.animate({
                right: '-100%'
            }, 500)
            procedurePopupStatus = 0;
        });

        function displayProcedureTimeline(id) {
            $.ajax({
                url: '{{ route("procedures.get") }}',
                data: {
                    'id': id
                },
                success: (response) => {
                    $('#popup-procedure-name').text(response.target_procedure.procedure_name);
                    $('#popup-procedure-description').text(response.target_procedure.procedure_description);
                    $('#procedure_id').text(response.target_procedure.id);
                    var timeline = document.getElementById('timeline');
                    timeline.innerHTML = ``;
                    var waypoints = response.waypoints;
                    for (let key in waypoints) {
                        timeline.innerHTML += `
                    <div class="w-[100%] bg-transparent flex justify-center items-center mb-5">
                        <div class="w-[80%] py-6 shadow-[rgba(0,_0,_0,_0.24)_0px_3px_8px] rounded-lg flex justify-center">
                            <a href="#" class="flex flex-col w-[100%] items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="${decodeURIComponent('{{ asset("storage/") }}' + "/" + waypoints[key].photo)}" alt="">
                                <div class="flex flex-col justify-between p-4 leading-normal">
                                    <h1>Step ${waypoints[key].step_no}</h1>
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">${waypoints[key].building.building_name}</h5>
                                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">${waypoints[key].instructions}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    `;
                    }
                },
                error: (error) => {
                    console.log(error);
                }
            })
        }

        var procedureDirectionBtns = document.querySelectorAll('.popup-procedure-btn');
        procedureDirectionBtns.forEach(function(button) {
            button.addEventListener('click', function() {
                var pro_id = document.getElementById('procedure_id').innerText;
                $.ajax({
                    url: '{{ route("procedures.get") }}',
                    data: {
                        'id': pro_id
                    },
                    success: (response) => {
                        beginProcedureNagivation(response);
                    },
                    error: (error) => {
                        console.log(error)
                    }
                })
            })
        })

        var _procedure_step = 0;
        var totalWaypoints = 0;
        var response_json = {};

        function setSidebarTimeline(json) {
            console.log(json)
            $('#procedure-name').text(json.target_procedure.procedure_name);
            $('#procedure-description').text(json.target_procedure.procedure_description);
            $('#procedure-waypoint-count').text(json.waypoints.length.toString());
            var timelineBody = document.getElementById('timeline-body');
            timelineBody.innerHTML = ``;
            json.waypoints.forEach(function(waypoint, loopNumber) {
                timelineBody.innerHTML += `
                <!-- Item -->
                    <div class="flex gap-x-2" id="timeline-step-item-${loopNumber + 1}">
                        <!-- Left Content -->
                        <div class="w-16 text-end">
                            <span id="timeline-step-all-${loopNumber + 1}" class="text-xs text-black dark:text-neutral-400">Step <span id="timeline-step-${loopNumber + 1}"></span>${loopNumber + 1}</span>
                        </div>
                        <!-- End Left Content -->

                        <!-- Icon -->
                        <div id="timeline-step-${loopNumber + 1}-line" class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-gray-700">
                            <div class="relative z-10 size-7 flex justify-center items-center">
                                <div id="timeline-step-${loopNumber + 1}-circle" class="size-2 rounded-full bg-gray-400 dark:bg-gray-600"></div>
                            </div>
                        </div>
                        <!-- End Icon -->

                        <!-- Right Content -->
                        <div class="grow pt-0.5 pb-8">
                            <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
                                <p>Destination:<br><span id="timeline-step-destination">${waypoint.building.building_name}</span></p>
                            </h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
                            ${waypoint.instructions}
                            </p>
                        </div>
                        <!-- End Right Content -->
                    </div>
                <!-- End Item -->
            `;
            })
        }


        function updateSidebar(index, totalWaypoints) {
            var loopNumber = index + 1;
            var totalLoop = totalWaypoints + 1;
            const container = document.getElementById('procedure-timeline');
            const element = document.getElementById(`timeline-step-item-${loopNumber}`);
            const yCoordinate = element.offsetTop - container.offsetTop;
            if (loopNumber > 1) {
                container.scrollTo({
                    top: yCoordinate,
                    behavior: 'smooth'
                });
            }
            if (loopNumber > 0) {
                for (var x = totalLoop; x >= 0; x--) {
                    console.log(x)
                    if (x > loopNumber) {
                        $(document).find(`#timeline-step-${x}-circle`).addClass('bg-gray-400').removeClass('bg-green-400').removeClass('bg-yellow-400')
                        $(document).find(`#timeline-step-${x}-line`).addClass('after:bg-gray-200').removeClass('after:bg-green-200').removeClass('after:bg-yellow-200')
                        $(document).find(`#timeline-step-all-${x}`).addClass('text-black').removeClass('text-green-400').removeClass('text  -yellow-400')
                    } else if (x === loopNumber) {
                        $(document).find(`#timeline-step-${x}-circle`).removeClass('bg-gray-400').addClass('bg-yellow-400')
                        $(document).find(`#timeline-step-${x}-line`).removeClass('after:bg-gray-200').addClass('after:bg-yellow-200')
                        $(document).find(`#timeline-step-all-${x}`).removeClass('text-black').addClass('text-yellow-400')
                    } else {
                        $(document).find(`#timeline-step-${x}-circle`).removeClass('bg-gray-400').removeClass('bg-yellow-400').addClass('bg-green-400')
                        $(document).find(`#timeline-step-${x}-line`).removeClass('after:bg-gray-200').removeClass('after:bg-yellow-200').addClass('after:bg-green-200')
                        $(document).find(`#timeline-step-all-${x}`).removeClass('text-black').removeClass('text-yellow-400').addClass('text-green-400')
                    }
                }
            } else {
                $(document).find(`#timeline-step-${loopNumber}-circle`).removeClass('bg-gray-400').addClass('bg-green-400')
                $(document).find(`#timeline-step-${loopNumber}-line`).removeClass('after:bg-gray-200').addClass('after:bg-green-200')
                $(document).find(`#timeline-step-all-${loopNumber}`).removeClass('text-black').addClass('text-green-400')
            }
        }

        function beginProcedureNagivation(json) {
            $('#sidebar-btn').hide();
            setSidebarTimeline(json);
            var procedures = $('#procedures-cont');
            if (window.innerWidth > 767) {
                procedures.animate({
                    left: '-20%'
                }, 500)
            } else {
                $('#popup-event').hide();
            }
            var procedurePopup = $('#popup-procedure');
            procedurePopup.animate({
                right: '-100%'
            }, 500)
            procedurePopupStatus = 0;
            var waypoints = json.waypoints;
            var procedureLoop = true;
            totalWaypoints = Object.keys(waypoints).length - 1;
            response_json = json;
            procedure_step = 0;
        }

        Object.defineProperty(window, 'procedure_step', {
            get: function() {
                return _procedure_step;
            },
            set: function(value) {
                beginStep(value, (totalWaypoints), response_json);
                _procedure_step = value;
                $('#procedure-prev-btn').prop('disabled', false).removeClass('bg-gray-900').addClass('bg-blue-500').addClass('hover:bg-blue-600');
                $('#procedure-next-btn').prop('disabled', false).removeClass('bg-gray-900').addClass('bg-blue-500').addClass('hover:bg-blue-600');
                if (value == 0) {
                    $('#procedure-prev-btn').prop('disabled', true).removeClass('bg-blue-500').removeClass('hover:bg-blue-600').addClass('bg-gray-900');
                } else if (value == totalWaypoints) {
                    $('#procedure-next-btn').prop('disabled', true).removeClass('bg-blue-500').removeClass('hover:bg-blue-600').addClass('bg-gray-900');
                }
            }
        });

        document.querySelector('#procedure-next-btn').addEventListener('click', function() {
            if (_procedure_step !== (totalWaypoints)) {
                beginStep(procedure_step = _procedure_step + 1, totalWaypoints, json);
            }
        });

        document.querySelector('#procedure-prev-btn').addEventListener('click', function() {
            if (_procedure_step > 0) {
                beginStep(procedure_step = _procedure_step - 1, totalWaypoints, json);
            }
        });
        document.querySelector('#procedure-end-btn').addEventListener('click', function() {
            endProcedureNavigation();
        });
        document.querySelector('#event-end-btn').addEventListener('click', function() {
            endEventNavigation();
        });

        function beginStep(index, totalWaypoints, json) {
            $('#directions-step-cont').empty();
            if (index == 0) {
                determineOriginPoint().then(
                    function(value) {
                        var originModeResults = value;
                        if (originModeResults) {
                            displayRoute(json.waypoints[index].building_id);
                            displaySidebar(json.waypoints[index].instructions, json.target_procedure.initial_instructions, 'first');
                        } else {
                            $('#origin-modal').show();
                            getOriginPoint().then(
                                function(value) {
                                    displayRoute(json.waypoints[index].building.building_name, value);
                                    displaySidebar(json.waypoints[index].instructions, json.target_procedure.initial_instructions, 'first');
                                    $('#origin-modal').hide();
                                },
                                function(error) {
                                    console.log(error)
                                }
                            )
                        }
                    },
                    function(error) {
                        console.log(error)
                    }
                );
            } else {
                displayRoute(json.waypoints[index].building.building_name, json.waypoints[index - 1].building.building_name);
                displaySidebar(json.waypoints[index].instructions, null, true);
            }
            updateSidebar(index, totalWaypoints);
        }

        function displayRoute(destination, origin = null) {
            if (!origin) {
                var gps_point = locateUser();
                nearestLineNew(gps_point, true)
                    .then(nearestLineId => {
                        var nearestPointOnLineCoords = nearestPointOnLine(gps_point, nearestLineId, destination);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            } else {
                gps = false;
                $.ajax({
                    url: '{{ route("directions.get.polarpoints") }}',
                    data: {
                        'origin': origin,
                        'destination': destination,
                        'sidebar': true
                    },
                    success: (response) => {
                        var origin_decoded = JSON.parse(JSON.parse(response.target_origin.entrypoints));
                        var destination_decoded = JSON.parse(JSON.parse(response.target_destination.entrypoints));
                        var origin_points = [];
                        var destination_points = [];
                        for (let key in origin_decoded) {
                            origin_points.push(origin_decoded[key].code);
                        }
                        for (let key in destination_decoded) {
                            destination_points.push(destination_decoded[key].code);
                        }
                        multipleCalculations(origin_points, destination_points, null, true);
                    },
                    error: (error) => {
                        console.log(error);
                    }
                })
            }
        }

        function locateUser() {
            var currentLocationSample = [124.2446572386292, 8.2412528560357];
            _gps = true;
            return currentLocationSample;
        }

        function displayProcedureNavbar(name, step, destination) {
            $('#map-navbar-step-cont').show();
            $('#map-navbar').show();
            $('#map-navbar-name').text(name);
            if (step) {
                $('#navbar-mode').text('Procedure');
                $('#map-navbar-step').text(step);
            } else {
                $('#navbar-mode').text('Event');
                $('#map-navbar-step-cont').hide();
            }
            $('#map-navbar-destination').text(destination);
        }

        function hideProcedureNavbar() {
            $('#map-navbar').hide();
        }

        function displaySidebar(instructions, initial = null, procedure) {
            instructionsSidebar(true);
            $('#initial-instructions-cont').text('');
            // if (initial) {
            //     $('#initial-instructions-cont').text(initial);
            //     $('#initial-instructions-cont').addClass('mb-8');
            // } else {
            //     $('#initial-instructions-cont').removeClass('mb-8');
            // }
            // $('#instructions-cont').text(instructions);
            if (procedure) {
                $('#procedure-end-btn').show();
                $('#event-end-btn').hide();
                if (procedure == 'first') {
                    $('#procedure-prev-btn').css('visibility', 'invisible');
                } else {
                    $('#procedure-prev-btn').css('visibility', 'visible');
                }
                $('#procedure-next-btn').css('visibility', 'visible');
            } else {
                $('#procedure-end-btn').hide();
                $('#event-end-btn').show();
                $('#procedure-next-btn').css('visibility', 'hidden');
                $('#procedure-prev-btn').css('visibility', 'hidden');
            }
        }

        function endProcedureNavigation() {
            $('#sidebar-btn').show();
            var procedures = $('#procedures-cont');
            var sidebar = $('#sidebar');
            procedures.animate({
                left: '0%'
            }, 500)
            sidebar.animate({
                left: '-20%'
            }, 500);
            procedurePopupStatus = 0;
            instructionsSidebar(false);
            response_json = {};
            totalWaypoints = 0;
            removeRenderedPaths();
            removeGpsMarker();
            resetMap();
            $('#directions-end-btn').click().show();
            sidebarToggle(false);
        }

        function sidebarToggle(state) {
            var sidebar = $('#sidebar');
            var navbar = $('#navbar');
            var map = $('#map');
            if (state) {
                if (window.innerWidth <= 767) {
                    sidebar.animate({
                        left: '100%'
                    }, 500);
                } else {
                    sidebar.animate({
                        left: '20%'
                    }, 500);
                }
            } else {
                if (window.innerWidth <= 767) {
                    navbar.animate({
                        width: '100%',
                        marginLeft: '0%'
                    }, 500);
                    map.animate({
                        width: '100%',
                        marginLeft: '0%'
                    }, 500)
                    sidebar.animate({
                        left: '-100%'
                    }, 500);
                } else {
                    sidebar.animate({
                        left: '-20%'
                    }, 500);
                }
            }
        }

        // End of Procedures Functions
        function instructionsSidebar(state) {
            var directions = $('#directions-cont');
            var navbar = $('#navbar');
            var map = $('#map');
            var sidebar = $('#sidebar');

            if (state) {
                directions.animate({
                    left: '0%'
                }, 500)
                navbar.animate({
                    width: '70%',
                    marginLeft: '30%'
                }, 500);
                map.animate({
                    width: '70%',
                    marginLeft: '30%'
                }, 500)

                if (sidebarStatus == 1) {
                    sidebar.animate({
                        left: "-20%"
                    }, 500)

                    sidebarStatus = 0;
                }
            } else {
                directions.animate({
                    left: '-30%'
                }, 500)
                navbar.animate({
                    width: '80%',
                    marginLeft: '20%'
                }, 500);
                map.animate({
                    width: '80%',
                    marginLeft: '20%'
                }, 500)
            }

        }

        // Events Functions
        document.querySelectorAll('.event-item').forEach(function(element) {
            element.addEventListener('click', function() {
                var eventID = $(this).attr('event_id');
                getEvent(eventID);
            })
        })

        function getEvent(id) {
            $.ajax({
                url: '{{ route("events.get") }}',
                data: {
                    'id': id
                },
                success: (response) => {
                    return openEventPopup(response.target_event);
                },
                error: (error) => {
                    console.log(error);
                }
            })
        }

        function openEventPopup(json) {
            $('#popup-event-name').text(json.event_name);
            $('#popup-event-description').text(json.event_description);
            $('#event-id').val(json.id);
            if (json.building.building_marker.marker_image) {
                var marker_image = decodeURIComponent('{{ asset("storage/") }}' + "/" + json.building.building_marker.marker_image); // Decode URL
                $('#popup-event-image').attr('src', marker_image);
            }
            var eventPopup = $('#popup-event');
            if (eventPopupStatus == 0) {
                if (window.innerWidth <= 767) {
                    $('#events-cont').animate({
                        left: "-100%"
                    }, 500);
                    $('#map').animate({
                        width: '100%',
                        marginLeft: '0%'
                    }, 500)
                    $('#navbar').animate({
                        width: '100%',
                        marginLeft: '0%'
                    }, 500);
                }
                eventPopup.animate({
                    right: '7.5%'
                }, 500)
                eventPopupStatus = 1;
            } else {
                eventPopup.animate({
                    right: '-100%'
                }, 500)
                eventPopupStatus = 0;
            }
        }

        function beginEventNavigation(json) {
            displayProcedureNavbar(json.event_name, null, json.building.building_name);

            determineOriginPoint().then(
                function(value) {
                    var originModeResults = value;
                    if (originModeResults) {
                        displaySidebar(json.event_instructions, json.event_description, false);
                        displayRoute(json.building.building_name);
                    } else {
                        $('#origin-modal').show();
                        getOriginPoint().then(
                            function(value) {
                                displaySidebar(json.event_instructions, json.event_description, false);
                                displayRoute(json.building.building_name, value);
                                $('#origin-modal').hide();
                            },
                            function(error) {
                                console.log(error)
                            }
                        )
                    }
                },
                function(error) {
                    console.log(error)
                }
            );
        }

        function endEventNavigation() {
            $('#sidebar-btn').show();
            var procedures = $('#events-cont');
            procedures.animate({
                left: '0%'
            }, 500)
            procedurePopupStatus = 0;
            hideProcedureNavbar();
            instructionsSidebar(false);
            response_json = {};
            totalWaypoints = 0;
            removeRenderedPaths();
            removeGpsMarkers();
            resetMap();
        }

        var eventDirectionsButton = document.querySelector('#popup-events-directions-btn');
        eventDirectionsButton.addEventListener('click', function() {
            $.ajax({
                url: '{{ route("events.get") }}',
                data: {
                    'id': $('#event-id').val()
                },
                success: function(response) {
                    var eventPopup = $('#popup-event');
                    eventPopup.animate({
                        right: '-100%'
                    }, 500)
                    eventPopupStatus = 0;
                    var events = $('#events-cont');
                    var navbar = $('#navbar');
                    var map = $('#map');
                    events.animate({
                        left: '-20%'
                    }, 500)
                    navbar.animate({
                        width: '70%',
                        marginLeft: '30%'
                    }, 500);
                    map.animate({
                        width: '70%',
                        marginLeft: '30%'
                    }, 500)
                    beginEventNavigation(response.target_event);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
        // End of Events Functions

        // Smaller Screen
        if (window.innerWidth <= 767) {
            $('#procedure-next-btn').hide();
            $('#procedure-prev-btn').hide();
            $('#procedure-end-btn').hide();
            $('#event-end-btn').hide();
        }
        // End of Smaller Screens

        // Marker Toggle
        var markerToggleStatus = 1;
        var markerToggleButton = document.getElementById('marker-toggle');
        markerToggleButton.addEventListener('click', function() {
            var displayMarkersElements = document.querySelectorAll('.display-marker');
            var displayLabelsElements = document.querySelectorAll('.display-label');
            displayMarkersElements.forEach(function(displayMarkersElement) {
                if (markerToggleStatus) {
                    displayMarkersElement.style.display = 'none';
                } else {
                    displayMarkersElement.style.display = '';
                }
            });
            displayLabelsElements.forEach(function(displayLabelsElement) {
                if (markerToggleStatus) {
                    displayLabelsElement.style.display = '';
                } else {
                    displayLabelsElement.style.display = 'none';
                }
            });
            markerToggleStatus = markerToggleStatus ? 0 : 1;
        })
        // End of Marker Toggle

        // Custom Starting Point
        $('#custom-origin-form').submit(function() {

        });
        // End of Custom Starting Point

        // Right Sidebar
        $('#directions-end-btn').click(function() {
            closeRightSidebar();
            var directionsStepCont = $('#directions-step-cont');
            directionsStepCont.empty();
            var sidebar = $('#sidebar');
            var navbar = $('#navbar');
            var map = $('#map');
            sidebar.animate({
                left: "0%"
            }, 500);
            navbar.animate({
                width: '80%',
                marginLeft: '20%'
            }, 500);
            map.animate({
                width: '80%',
                marginLeft: '20%'
            }, 500)
            removeGpsMarker();
            removeRenderedPaths();
        })

        function openRightSidebar(non_raw = null) {
            $('#right-sidebar').show();
            $('#right-sidebar').animate({
                right: '0'
            });
            var sidebar = $('#sidebar');
            var navbar = $('#navbar');
            var map = $('#map');
            if (!non_raw) {
                sidebar.animate({
                    left: "-30%"
                }, 500);
                navbar.animate({
                    width: '100%',
                    marginLeft: '0%'
                }, 500);
                map.animate({
                    width: '100%',
                    marginLeft: '0%',
                }, 500)
            } else {
                $('#directions-end-btn').hide();
            }
        }

        function closeRightSidebar() {
            $('#right-sidebar').animate({
                right: '0%'
            }, function() {
                $('#right-sidebar').hide();
            });
        }

        function getCardinalDirection(bearing) {
            const cardinals = ['North', 'Northeast', 'East', 'Southeast', 'South', 'Southwest', 'West', 'Northwest', 'North'];
            const index = (Math.round(bearing / 45) + 8) % 8;
            return cardinals[index];
        }

        map.on('rotate', function() {
            $('#currently-facing-cont').show();
            var currentBearing = map.getBearing();
            var result = getCardinalDirection(currentBearing);
            $('#currently-facing').text(result);
        });

        // Modals

        var openmodal = document.querySelectorAll('.modal-open')
        for (var i = 0; i < openmodal.length; i++) {
            openmodal[i].addEventListener('click', function(event) {
                event.preventDefault()
                toggleModal()
            })
        }

        const overlay = document.querySelector('.modal-overlay')
        overlay.addEventListener('click', toggleModal)

        var closemodal = document.querySelectorAll('.modal-close')
        for (var i = 0; i < closemodal.length; i++) {
            closemodal[i].addEventListener('click', toggleModal)
        }

        document.onkeydown = function(evt) {
            evt = evt || window.event
            var isEscape = false
            if ("key" in evt) {
                isEscape = (evt.key === "Escape" || evt.key === "Esc")
            } else {
                isEscape = (evt.keyCode === 27)
            }
            if (isEscape && document.body.classList.contains('modal-active')) {
                toggleModal()
            }
        };


        function toggleModal() {
            const body = document.querySelector('body')
            const modal = document.querySelector('.modal')
            modal.classList.toggle('opacity-0')
            modal.classList.toggle('pointer-events-none')
            body.classList.toggle('modal-active')
        }

        // End of Modals

        // Bug reports
        $('#report').click(function() {
            $('.modal-open').click();
        })
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $('#report-form').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            console.log(data);
            $.ajax({
                url: '{{ route("home.feedback.validate") }}',
                data: data,
                success: (response) => {
                    if (response.success === true) {
                        $.ajax({
                            url: '{{ route("home.feedback.submit") }}',
                            data: data,
                            success: (response) => {
                                $('.modal-close').click();
                                $('#name').val('');
                                $('#message').val('');
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Your message has been sent! We appreciate your feedback.'
                                })
                            },
                            error: (error) => {
                                console.log(error)
                            }
                        })
                    } else if (response.success === false) {
                        Toast.fire({
                            icon: 'error',
                            title: 'The Message Field is Required!'
                        })
                    }
                },
                error: (error) => {
                    console.log(error)
                }
            })
        })
        // End of bug reports

        // Legend
        $('#legend-btn').click(function() {
            if ($('#map-legend').css('visibility') == 'visible') {
                $('#map-legend').animate({
                    'left': '-0%'
                }, 250, function() {
                    $('#map-legend').css('visibility', 'hidden');
                })
            } else {
                $('#map-legend').css('visibility', 'visible').animate({
                    'left': '50%'
                }, 250);
            }
        })
        // End of Legend

    });
</script>
@endsection