<div id="loginform" class="absolute w-[100%] h-[calc(100vh-50px)] top-0 right-[-100%] z-40 bg-white flex flex-col justify-center items-center gap-12 transition duration-500">
    <div class="flex justify-center items-end"><img src="{{ asset('assets/images/landing/cover.png') }}" alt="MSU-IIT Map Logo" class="h-[80px]"></div>
    <form action="" class="w-[820px] flex flex-col justify-center" method="post">
        <div class="flex flex-col mx-auto justify-center items-center gap-4 w-[50%] h-fit py-8 rounded-3xl bg-upsdell-900">
            <input class="bg-white rounded-2xl w-[75%] h-[2.5rem] text-sm px-3 font-poppins-regular" autocomplete="new-password" placeholder="Email or username" type="text" name="" id="">
            <input class="bg-white rounded-2xl w-[75%] h-[2.5rem] text-sm px-3 font-poppins-regular" autocomplete="new-password" placeholder="Password" type="password" name="" id="">
        </div>
        <div class="flex justify-center items-start mt-5 gap-6">
            <button class="bg-upsdell-900 font-poppins-regular text-white text-sm py-1 px-6 rounded-lg" type="submit">Login</button>
            <button id="back-btn" class="bg-raisin-500 font-poppins-regular text-white text-sm py-1 px-6 rounded-lg" type="button">Back</button>
        </div>
    </form>
</div>
<div id="registrationform" class="absolute w-[100%] h-[calc(100vh-50px)] left-[-100%] z-40 top-0 bg-white flex flex-col justify-center items-center gap-12 transition duration-500">
    <div class="flex justify-center items-end"><img src="{{ asset('assets/images/landing/cover.png') }}" alt="MSU-IIT Map Logo" class="h-[80px]"></div>
    <form action="" class="w-[820px] flex flex-col justify-center" method="post">
        <div class="flex flex-col mx-auto justify-center items-center gap-4 w-[50%] h-fit py-6 rounded-3xl bg-upsdell-900">
            <input class="bg-white rounded-2xl w-[75%] h-[2.5rem] text-sm px-3 font-poppins-regular" autocomplete="new-password" placeholder="First Name" type="text" name="" id="">
            <input class="bg-white rounded-2xl w-[75%] h-[2.5rem] text-sm px-3 font-poppins-regular" autocomplete="new-password" placeholder="Last Name" type="text" name="" id="">
            <input class="bg-white rounded-2xl w-[75%] h-[2.5rem] text-sm px-3 font-poppins-regular" autocomplete="new-password" placeholder="Email" type="email" name="" id="">
            <input class="bg-white rounded-2xl w-[75%] h-[2.5rem] text-sm px-3 font-poppins-regular" autocomplete="new-password" placeholder="Password" type="password" name="" id="">
            <input class="bg-white rounded-2xl w-[75%] h-[2.5rem] text-sm px-3 font-poppins-regular" autocomplete="new-password" placeholder="Verify Password" type="password" name="" id="">
        </div>
        <div class="flex justify-center items-start mt-5 gap-6">
            <button class="bg-upsdell-900 font-poppins-regular text-white text-sm py-1 px-6 rounded-lg" type="submit">Register</button>
            <button id="reg-back-btn" class="bg-raisin-500 font-poppins-regular text-white text-sm py-1 px-6 rounded-lg" type="button">Back</button>
        </div>
    </form>
</div>