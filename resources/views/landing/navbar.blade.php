<nav id="navbar" class="bg-upsdell-900 fixed w-full z-20 top-0 start-0 lg:h-[50px] transition duration-500 opacity-0">
    <div class="flex justify-between items-center h-full">
        <a href="https://flowbite.com/" class="bg-white rounded-xl p-2 flex items-center lg:ml-6 lg:h-[75%]">
            <img src="{{ asset('assets/logos/logo-full.png') }}" class="lg:h-8 lg:mr-1" alt="Flowbite Logo">
        </a>
        <div class="flex justify-center items-center h-full w-full">
            <ul class="flex gap-12 lg:mr-6">
                <li class="text-white font-poppins-ultra lg:text-md lg:px-2 lg:py-1 group relative overflow-hidden hover:cursor-pointer">
                    <a href="#">
                        <span class="relative z-10">Get Started</span>
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-white origin-center transform scale-x-0 transition-transform group-hover:scale-x-100"></span>
                    </a>
                </li>
                <li class="text-white font-poppins-ultra lg:text-md lg:px-2 lg:py-1 group relative overflow-hidden hover:cursor-pointer">
                    <a id="about-btn">
                        <span class="relative z-10">About Us</span>
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-white origin-center transform scale-x-0 transition-transform group-hover:scale-x-100"></span>
                    </a>
                </li>
                <li class="text-white font-poppins-ultra lg:text-md lg:px-2 lg:py-1 group relative overflow-hidden hover:cursor-pointer">
                    <a id="contact-btn">
                        <span class="relative z-10">Contacts</span>
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-white origin-center transform scale-x-0 transition-transform group-hover:scale-x-100"></span>
                    </a>
                </li>
            </ul>
        </div>
        <div id="navbar-login-btn-cont" class="bg-white text-raisin-900 rounded-2xl flex items-center lg:px-3 lg:py-1 lg:mr-6 hover:bg-minion-900 hover:cursor-pointer transition opacity-0">
            <h1 id="navbar-login-btn" class="font-gordita-ultra text-raisin-900 lg:text-sm login-btn">Login</h1>
        </div>
    </div>

</nav>