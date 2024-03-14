@section('title', 'MSU-IIT Navigation Aid')
@include('landing.head')

<body id="top" class="overflow-y-auto overflow-x-hidden">
    @include('landing.navbar')

    <div id="content">

        <div id="cover" class="h-screen w-screen flex justify-center items-center flex-col">
            <div class="h-[62.5%] w-[100%] relative">
                <img src="{{ asset('assets/images/landing/cover.png') }}" alt="MSU-IIT Map Logo" class="lg:h-[200px] bottom-[15%] left-[50%] translate-x-[-50%] absolute">
            </div>
            <div class="h-[37.5%] w-[100%] text-center">
                <ul class="flex flex-row justify-center items-start gap-24">
                    <a href="{{ route('home') }}">
                        <li class=" bg-upsdell-900 text-white text-sm font-poppins-regular w-[120px] py-1.5 px-1 rounded-2xl transition duration-500 hover:cursor-pointer hover:bg-minion-900">Get Started</li>
                    </a>
                    <li class="login-btn bg-upsdell-900 text-white text-sm font-poppins-regular w-[120px] py-1.5 px-2 rounded-2xl transition duration-500 hover:cursor-pointer hover:bg-minion-900">Login</li>
                    <li class="register-btn bg-upsdell-900 text-white text-sm font-poppins-regular w-[120px] py-1.5 px-2 rounded-2xl transition duration-500 hover:cursor-pointer hover:bg-minion-900">Register</li>
                </ul>
            </div>
            <div id="loginform" class="absolute w-[100%] h-[calc(100vh-50px)] top-0 right-[-100%] bg-white flex flex-col justify-center items-center gap-12 transition duration-500">
                <div class="flex justify-center items-end"><img src="{{ asset('assets/images/landing/cover.png') }}" alt="MSU-IIT Map Logo" class="h-[80px]"></div>
                <form id="login-form" action="" class="w-[820px] flex flex-col justify-center" method="post">
                    <div class="flex flex-col mx-auto justify-center items-center gap-4 w-[50%] h-fit py-8 rounded-3xl bg-upsdell-900">
                        <div class="flex flex-col w-full justify-center items-center">
                            <input class="fields bg-white rounded-2xl w-[75%] h-[2.5rem] text-sm px-3 font-poppins-regular" autocomplete="new-password" placeholder="Enter your email" type="email" name="login_email" id="login_email">
                            <small id="login_email_error" class="field_errors text-white font-poppins-light text-xs"></small>
                        </div>
                        <div class="flex flex-col w-full justify-center items-center">
                            <input class="fields bg-white rounded-2xl w-[75%] h-[2.5rem] text-sm px-3 font-poppins-regular" autocomplete="new-password" placeholder="Enter your password" type="password" name="login_password" id="login_password">
                            <small id="login_password_error" class="field_errors text-white font-poppins-light text-xs"></small>
                        </div>
                    </div>
                    <div class="flex justify-center items-start mt-5 gap-6">
                        <button class="bg-upsdell-900 font-poppins-regular text-white text-sm py-1 px-6 rounded-lg" type="submit">Login</button>
                        <button id="back-btn" class="bg-raisin-500 font-poppins-regular text-white text-sm py-1 px-6 rounded-lg" type="button">Back</button>
                    </div>
                </form>
            </div>
            <div id="registrationform" class="absolute w-[100%] h-[calc(100vh-50px)] left-[-100%] top-0 bg-white flex flex-col justify-center items-center gap-12 transition duration-500">
                <div class="flex justify-center items-end"><img src="{{ asset('assets/images/landing/cover.png') }}" alt="MSU-IIT Map Logo" class="h-[80px]"></div>
                <form id="registration-form" class="w-[820px] flex flex-col justify-center" method="post">
                    <div class="flex flex-col mx-auto justify-center items-center gap-4 w-[50%] h-fit py-6 rounded-3xl bg-upsdell-900">
                        <div class="flex flex-col w-full justify-center items-center">
                            <input class="fields bg-white rounded-2xl w-[75%] h-[2.5rem] text-sm px-3 font-poppins-regular" autocomplete="new-password" placeholder="First Name" type="text" name="first_name" id="first_name">
                            <small id="first_name_error" class="field_errors text-white font-poppins-light text-xs"></small>
                        </div>
                        <div class="flex flex-col w-full justify-center items-center">
                            <input class="fields bg-white rounded-2xl w-[75%] h-[2.5rem] text-sm px-3 font-poppins-regular" autocomplete="new-password" placeholder="Last Name" type="text" name="last_name" id="last_name">
                            <small id="last_name_error" class="field_errors text-white font-poppins-light text-xs"></small>
                        </div>
                        <div class="flex flex-col w-full justify-center items-center">
                            <input class="fields bg-white rounded-2xl w-[75%] h-[2.5rem] text-sm px-3 font-poppins-regular" autocomplete="new-password" placeholder="Email" type="email" name="email" id="email">
                            <small id="email_error" class="field_errors text-white font-poppins-light text-xs"></small>
                        </div>
                        <div class="flex flex-col w-full justify-center items-center">
                            <input class="fields bg-white rounded-2xl w-[75%] h-[2.5rem] text-sm px-3 font-poppins-regular" autocomplete="new-password" placeholder="Password" type="password" name="password" id="password">
                            <small id="password_error" class="field_errors text-white font-poppins-light text-xs"></small>
                        </div>
                        <div class="flex flex-col w-full justify-center items-center">
                            <input class="fields bg-white rounded-2xl w-[75%] h-[2.5rem] text-sm px-3 font-poppins-regular" autocomplete="new-password" placeholder="Verify Password" type="password" name="password_confirmation" id="password_confirmation">
                        </div>
                    </div>
                    <div class="flex justify-center items-start mt-5 gap-6">
                        <button class="bg-upsdell-900 font-poppins-regular text-white text-sm py-1 px-6 rounded-lg" type="submit">Register</button>
                        <button id="reg-back-btn" class="bg-raisin-500 font-poppins-regular text-white text-sm py-1 px-6 rounded-lg" type="button">Back</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="about" class="bg-upsdell-900 w-screen h-screen">
            <h1></h1>
        </div>

        <div id="contact" class="w-screen h-screen">
            <h1></h1>
        </div>

        <div class="fixed bottom-5 right-5" id="scroll-top-cont">
            <svg xmlns="http://www.w3.org/2000/svg" id="scroll-top-btn" width="32" height="32" fill="black" class="bi bi-caret-up-square-fill hover:cursor-pointer" viewBox="0 0 16 16">
                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm4 9h8a.5.5 0 0 0 .374-.832l-4-4.5a.5.5 0 0 0-.748 0l-4 4.5A.5.5 0 0 0 4 11" />
            </svg>
        </div>

    </div>

    @include('landing.footer')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function clear_validations() {
            $(document).find('.field_errors').text('');
            $(document).find('.fields').removeClass('border-solid').removeClass('border-yellow-400').removeClass('border-3');
        }

        function printValidationErrorMsg(msg) {
            clear_validations();
            $.each(msg, function(field_name, error) {
                $(document).find('#' + field_name).addClass('border-solid').addClass('border-yellow-400').addClass('border-3');
                $(document).find('#' + field_name + '_error').text(error);
            });
        }
        $('#login-form').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: '{{ route("login_user") }}',
                data: formData,
                success: function(data) {
                    if (data.success == true) {
                        console.log("logged in successfully!");
                        $('#login-form')[0].reset();
                        clear_validations();
                        window.location.href = '{{ route("home") }}';
                    } else if (data.success == false) {
                        printValidationErrorMsg(data.msg);
                    }
                },
                error: function(error) {
                    console.error("Error adding user:", error);
                }
            });
        });
        $('#registration-form').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: '{{ route("register_user") }}',
                data: formData,
                success: function(data) {
                    if (data.success == true) {
                        console.log("user added!");
                        $('#registration-form')[0].reset();
                        $('#registrationform').animate({
                            left: "-100%"
                        })
                        $('#loginform').animate({
                            left: "0%"
                        })
                        clear_validations();
                    } else if (data.success == false) {
                        printValidationErrorMsg(data.msg);
                    }
                },
                error: function(error) {
                    console.error("Error adding user:", error);
                }
            });
        });
    </script>
    <script>
        // Navbar Animation
        window.addEventListener('scroll', function() {
            var navbar = document.getElementById('navbar');
            var contentContainer = document.getElementById('content');
            var navbarLogin = document.getElementById('navbar-login-btn-cont');
            var topCont = document.getElementById('scroll-top-cont');

            if (window.scrollY > 0) {
                navbar.classList.remove('opacity-0');
                navbar.classList.add('opacity-100');
                navbarLogin.classList.remove('opacity-0');
                navbarLogin.classList.add('opacity-100');
                topCont.classList.add('opacity-100');
                topCont.classList.remove('opacity-0');
            } else {
                navbar.classList.remove('opacity-100');
                navbar.classList.add('opacity-0');
                navbarLogin.classList.remove('opacity-0');
                navbarLogin.classList.add('opacity-100');
                topCont.classList.remove('opacity-100');
                topCont.classList.add('opacity-0');
            }
        });
        // End of Navbar Animation

        // Login Form Animation
        $('.login-btn').on('click', function() {
            $('#loginform').animate({
                left: "0%"
            })
        });
        $('#back-btn').on('click', function() {
            $('#loginform').animate({
                left: "100%"
            })
        });
        $('#navbar-login-btn').on('click', function() {
            $('html, body').animate({
                scrollTop: 0
            }, 300);
        });
        // End of Login Form Animation

        // Registration Form Animation
        $('.register-btn').on('click', function() {
            $('#registrationform').animate({
                left: "0%"
            })
        });
        $('#reg-back-btn').on('click', function() {
            $('#registrationform').animate({
                left: "-100%"
            })
        });
        // End of Registration Form Animation

        // Internal Navigation Animations
        $('#about-btn').on('click', function() {
            $('html, body').animate({
                scrollTop: $('#about').offset().top
            }, 300);
        });
        $('#contact-btn').on('click', function() {
            $('html, body').animate({
                scrollTop: $('#contact').offset().top
            }, 300);
        });
        $('#scroll-top-btn').on('click', function() {
            $('html, body').animate({
                scrollTop: $('#top').offset().top
            }, 300);
        });
        // End of Internal Navigation Animations
    </script>
</body>

</html>