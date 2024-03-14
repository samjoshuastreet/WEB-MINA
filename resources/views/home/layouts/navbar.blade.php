<body class="lg:w-[100%] lg:h-[100%] bg-upsdell-900">
    <nav id="navbar" class="bg-upsdell-900 fixed w-full z-20 top-0 start-0 lg:h-[50px] transition duration-500">
        <div class="flex justify-between items-center h-full">
            <div class="flex justify-center items-center mx-6 h-[100%]">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" id="sidebar-btn" class="bi bi-list hover:cursor-pointer" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                </svg>
                <a href="https://flowbite.com/" class="bg-white rounded-xl p-2 flex items-center lg:ml-6 lg:h-[75%]">
                    <img src="{{ asset('assets/logos/logo-full.png') }}" class="lg:h-8 lg:mr-1" alt="MSU-IIT Map Logo">
                </a>
            </div>

            <div class="bg-white rounded-full w-[400px] h-[60%] flex justify-between items-center px-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search w-[15%]" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
                <input type="text" name="" id="" placeholder="Search..." class="bg-transparent w-[85%] px-2">
            </div>

            <div class="mx-6">
                <ul class="flex justify-end items-center gap-4">
                    @auth
                    <li class="bg-white rounded-2xl font-gordita-ultra text-raisin-900 lg:text-sm hover:bg-minion-900 hover:cursor-pointer lg:px-3 lg:py-1 transition duration-500">Help</li>
                    <a href="{{ route('logout_user') }}">
                        <li class="bg-white rounded-2xl font-gordita-ultra text-raisin-900 lg:text-sm hover:bg-minion-900 hover:cursor-pointer lg:px-3 lg:py-1 transition duration-500">Logout</li>
                    </a>
                    @else
                    <li class="bg-white rounded-2xl font-gordita-ultra text-raisin-900 lg:text-sm hover:bg-minion-900 hover:cursor-pointer lg:px-3 lg:py-1 transition duration-500">Help</li>
                    <li id="login-btn" class="bg-white rounded-2xl font-gordita-ultra text-raisin-900 lg:text-sm hover:bg-minion-900 hover:cursor-pointer lg:px-3 lg:py-1 transition duration-500">Login</li>
                    <li id="register-btn" class="bg-white rounded-2xl font-gordita-ultra text-raisin-900 lg:text-sm hover:bg-minion-900 hover:cursor-pointer lg:px-3 lg:py-1 transition duration-500">Register</li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>