<div id="popup-sample" class="absolute top-[7.5%] right-[-100%] translate-x-[-7.5%] translate-y-[7.5%] bg-upsdell-900 z-20 h-[75%] w-[75%] lg:h-[75%] lg:w-[75%] flex items-center justify-center rounded-lg transition duration-500">
    <div class="w-[97.5%] h-[95%] bg-white rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#A41C20" class="bi bi-x-circle-fill absolute top-[5%] right-[2.5%] hover:cursor-pointer popup-sample-close-btn" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
        </svg>
        <h1 id="popup-building-name" class="font-upsdell-900 lg:w-full w-full lg:h-fit h-[7.5%] font-poppins-regular text-[0.75rem] lg:text-3xl text-center p-3 lg:p-6">Sample Popup</h1>
        <div class="w-[100%] h-[92.5%] lg:h-fit lg:overflow-hidden overflow-scroll bg-transparent flex justify-center items-center">
            <div class="w-[85%] h-full shadow-[rgba(0,_0,_0,_0.24)_0px_3px_8px] rounded-lg flex flex-col lg:flex-row">
                <figure class="max-w-lg w-full lg:w-[40%] h-fit p-4">
                    <img id="popup-image" class="lg:w-full lg:h-auto max-w-full rounded-lg" src="" alt="">
                </figure>
                <div class="details w-full lg:w-[60%] h-fit p-4 flex flex-col">
                    <p id="popup-building-description" class="font-poppins-light mb-2"></p>
                    <button id="popup-directions-btn" type="button" class="px-2 mt-4 lg:mt-0 lg:px-3 py-1 lg:py-2 text-xs font-poppins-light text-center inline-flex items-center text-white bg-green-500 rounded-lg hover:bg-green-600">
                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #fff;">
                            <path d="m2.295 12.707 8.978 9c.389.39 1.025.391 1.414.002l9.021-9a1 1 0 0 0 0-1.416l-9.021-9a.999.999 0 0 0-1.414.002l-8.978 9a.998.998 0 0 0 0 1.412zm6.707-2.706h5v-2l3 3-3 3v-2h-3v4h-2v-6z"></path>
                        </svg>
                        Directions
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="popup-procedure" class="absolute top-[7.5%] right-[-100%] translate-x-[-7.5%] translate-y-[7.5%] bg-upsdell-900 z-20 w-[75%] h-[75%] lg:h-[75%] lg:w-[75%] flex items-center justify-center rounded-lg transition duration-500">
    <div class="procedure-contents w-[97.5%] h-[95%] bg-white rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#A41C20" class="bi bi-x-circle-fill absolute top-[5%] right-[2.5%] hover:cursor-pointer popup-procedure-close-btn" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
        </svg>
        <h1 id="popup-procedure-name" class="font-upsdell-900 font-poppins-regular text-3xl text-center p-6">Sample Popup</h1>
        <div class="w-[100%] bg-transparent flex justify-center items-center">
            <div class="w-[85%] shadow-[rgba(0,_0,_0,_0.24)_0px_3px_8px] rounded-lg flex">
                <div class="details w-[100%] p-4 flex flex-col">
                    <p class="font-poppins mb-2">Procedure #<span id="procedure_id"></span></p>
                    <p id="popup-procedure-description" class="font-poppins-light mb-5"></p>
                    <button type="button" class="popup-procedure-btn px-3 py-2 text-xs font-poppins-light text-center inline-flex items-center text-white bg-green-500 rounded-lg hover:bg-green-600">
                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #fff;">
                            <path d="m2.295 12.707 8.978 9c.389.39 1.025.391 1.414.002l9.021-9a1 1 0 0 0 0-1.416l-9.021-9a.999.999 0 0 0-1.414.002l-8.978 9a.998.998 0 0 0 0 1.412zm6.707-2.706h5v-2l3 3-3 3v-2h-3v4h-2v-6z"></path>
                        </svg>
                        Directions
                    </button>
                </div>
            </div>
        </div>
        <h1 class="font-upsdell-900 font-poppins-regular text-lg text-center p-6">Procedure Timeline</h1>
        <div id="timeline" class="w-full h-fit"></div>
        <div class="w-full flex justify-center">
            <button type="button" class="popup-procedure-btn px-3 py-2 text-xs font-poppins-light text-center mb-4 inline-flex items-center text-white bg-green-500 rounded-lg hover:bg-green-600">
                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #fff;">
                    <path d="m2.295 12.707 8.978 9c.389.39 1.025.391 1.414.002l9.021-9a1 1 0 0 0 0-1.416l-9.021-9a.999.999 0 0 0-1.414.002l-8.978 9a.998.998 0 0 0 0 1.412zm6.707-2.706h5v-2l3 3-3 3v-2h-3v4h-2v-6z"></path>
                </svg>
                Directions
            </button>
        </div>
    </div>
</div>

<div id="popup-event" class="absolute top-[7.5%] right-[-100%] translate-x-[-7.5%] translate-y-[7.5%] bg-upsdell-900 z-20 h-[75%] w-[75%] lg:h-[75%] lg:w-[75%] flex items-center justify-center rounded-lg transition duration-500">
    <div class="w-[97.5%] h-[95%] bg-white rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#A41C20" class="bi bi-x-circle-fill absolute top-[5%] right-[2.5%] hover:cursor-pointer popup-event-close-btn" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
        </svg>
        <h1 id="popup-event-name" class="font-upsdell-900 font-poppins-regular text-3xl text-center p-6">Sample Popup</h1>
        <div class="w-[100%] bg-transparent flex justify-center items-center">
            <div class="w-[85%] shadow-[rgba(0,_0,_0,_0.24)_0px_3px_8px] rounded-lg flex">
                <figure class="max-w-lg w-[40%] p-4">
                    <img id="popup-event-image" class="w-full h-auto max-w-full rounded-lg" alt="">
                </figure>
                <div class="details w-[60%] p-4 flex flex-col">
                    <p id="popup-event-description" class="font-poppins-light mb-2"></p>
                    <button id="popup-events-directions-btn" type="button" class="px-3 py-2 text-xs font-poppins-light text-center inline-flex items-center text-white bg-green-500 rounded-lg hover:bg-green-600">
                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #fff;">
                            <path d="m2.295 12.707 8.978 9c.389.39 1.025.391 1.414.002l9.021-9a1 1 0 0 0 0-1.416l-9.021-9a.999.999 0 0 0-1.414.002l-8.978 9a.998.998 0 0 0 0 1.412zm6.707-2.706h5v-2l3 3-3 3v-2h-3v4h-2v-6z"></path>
                        </svg>
                        Directions
                    </button>
                </div>
            </div>
        </div>
        <input type="text" name="event_id" id="event-id" style="visibility: hidden;">
    </div>
</div>