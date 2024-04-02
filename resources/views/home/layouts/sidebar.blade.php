<head>
    <link href="{{ asset('assets/css/sidebar.css') }}" rel="stylesheet">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>

<div id="sidebar" class="fixed top-0 left-[-20%] w-[20%] h-full bg-upsdell-900 flex flex-col gap-2">
    <!-- Title -->
    <h1 class="text-white font-poppins-regular p-2 text-center">Directions</h1>

    <div class="line"></div>
    <!-- Locator -->
    <div class="locator">
        <!-- Starting point form -->
        <form id="sidebar-searchbar" class="flex flex-col items-center">
            <label for="starting-point"></label>
            <div class="input-wrapper">
                <box-icon name='walk' class='walk-icon'></box-icon>
                <input id="starting-point" name="origin" type="search" placeholder="Choose starting point..." autocomplete="off" autofocus required />
            </div>


            <!-- Divider -->
            <div class="icon-divider">
                <box-icon name='dots-vertical-rounded' class='divider-icon'></box-icon>
            </div>

            <!-- Destination form -->
            <label for="destination"></label>
            <div class="input-wrapper">
                <box-icon name='map' class='map-icon'></box-icon>
                <input id="destination" name="destination" type="search" placeholder="Choose destination..." autocomplete="off" required />
            </div>

            <!-- Current location button -->
            <button type="button" id="current-location" class="button">
                <box-icon name='current-location' class="current-icon"></box-icon>
                <span class="location">Your Location</span>
            </button>

            <!-- Current location button -->
            <button type="submit" id="get-directions-btn" class="button">
                <box-icon type='solid' name='direction-right'></box-icon>
                <span>Directions</span>
            </button>
        </form>
    </div>

    <div class="line2"></div>

    <!-- Buttons -->
    <div id="buttons-container" class="buttons-container">
        <a href="#" id="procedures-btn" class="procedures btn2"><span class="spn2">Procedures</span></a>
        <a href="#" id="events-btn" class="events btn2"><span class="spn2">Events</span></a>
    </div>

    <!-- Report button -->
    <button id="report" class="report">
        <box-icon name='bug' class="bug-icon"></box-icon>
        <span class="report-bug">Report a bug</span>
    </button>
</div>