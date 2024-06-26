<body class="lg:w-[100%] lg:h-[100%] bg-upsdell-900">
    <nav id="navbar" class="flex justify-between items-center px-4 bg-upsdell-900 fixed w-full z-20 top-0 start-0 h-[50px] lg:h-[50px] transition duration-500">

        <svg xmlns="http://www.w3.org/2000/svg" fill="white" id="sidebar-btn" class="bi bi-list h-[25px] lg:h-[30px] hover:cursor-pointer" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
        </svg>
        <div class="flex justify-end items-center h-full w-full">
            <ul class="flex gap-1 md:gap-8 lg:gap-5 lg:mr-6">
                <li class="text-white font-poppins-ultra text-[0.65rem] md:text-[0.90rem] lg:text-[1rem] px-1 py-0 lg:px-2 lg:py-1 group relative overflow-hidden hover:cursor-pointer">
                    <button id="legend-btn">
                        <span class="relative z-10">Legend</span>
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-white origin-center transform scale-x-0 transition-transform group-hover:scale-x-100"></span>
                    </button>
                </li>
                <!-- <li class="text-white font-poppins-ultra text-[0.65rem] md:text-[0.90rem] lg:text-[1rem] px-1 py-0 lg:px-2 lg:py-1 group relative overflow-hidden hover:cursor-pointer">
                    <a href="{{ route('home') }}">
                        <span class="relative z-10">Help</span>
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-white origin-center transform scale-x-0 transition-transform group-hover:scale-x-100"></span>
                    </a>
                </li> -->
            </ul>
        </div>
        <a href="{{ route('landing') }}" class="bg-white rounded-xl p-1 flex items-center lg:ml-6 lg:h-[75%]">
            <img src="{{ asset('assets/logos/logo-full.png') }}" class="h-6 lg:h-8 lg:mr-1" alt="MSU-IIT Map Logo">
        </a>

        <!-- 
            <div class="bg-white rounded-full w-[400px] h-[60%] flex justify-between items-center px-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search w-[15%]" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
                <input type="text" name="" id="" placeholder="Search..." class="bg-transparent w-[85%] px-2">
            </div> -->



    </nav>