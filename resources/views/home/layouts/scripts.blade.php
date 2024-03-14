@yield('more_scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    var sidebarStatus = 0;
    var loginFormStatus = 0;
    var regFormStatus = 0;
    var samplePopupStatus = 0;

    $('#login-btn').on('click', function() {
        var loginForm = $('#loginform');

        loginForm.animate({
            right: '0%'
        }, 500)
    })
    $('#back-btn').on('click', function() {
        var loginForm = $('#loginform');

        loginForm.animate({
            right: '-100%'
        }, 500)
    })

    $('#register-btn').on('click', function() {
        var regForm = $('#registrationform');

        regForm.animate({
            left: '0%'
        }, 500)
    })
    $('#reg-back-btn').on('click', function() {
        var regForm = $('#registrationform');

        regForm.animate({
            left: '-100%'
        }, 500)
    })

    $('#sidebar-btn').on('click', function() {
        var sidebar = $('#sidebar');
        var navbar = $('#navbar');
        var map = $('#map');

        if (sidebarStatus == 0) {
            sidebar.animate({
                left: "0%"
            }, 500);

            sidebarStatus = 1;

            navbar.animate({
                width: '80%',
                marginLeft: '20%'
            }, 500);
            map.animate({
                width: '80%',
                marginLeft: '20%'
            }, 500)
        } else if (sidebarStatus == 1) {
            sidebar.animate({
                left: "-20%"
            }, 500);

            sidebarStatus = 0;

            navbar.animate({
                width: '100%',
                marginLeft: '0%'
            }, 500);
            map.animate({
                width: '100%',
                marginLeft: '0%'
            }, 500)
        }
    });

    $('.popup-sample-btn').on('click', function() {
        var samplePopup = $('#popup-sample');
        if (samplePopupStatus == 0) {
            samplePopup.animate({
                right: '7.5%'
            }, 500)
            samplePopupStatus = 1;
        } else {
            samplePopup.animate({
                right: '-100%'
            }, 500)
            samplePopupStatus = 0;
        }
    });
    $('.popup-sample-close-btn').on('click', function() {
        var samplePopup = $('#popup-sample');
        samplePopup.animate({
            right: '-100%'
        }, 500)
        samplePopupStatus = 0;
    });

    $('#directions-btn').on('click', function() {
        var directions = $('#directions-cont');
        var navbar = $('#navbar');
        var map = $('#map');
        var sidebar = $('#sidebar');

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
    });

    $('#directions-close-btn').on('click', function() {
        var directions = $('#directions-cont');
        var navbar = $('#navbar');
        var map = $('#map');
        directions.animate({
            left: '-30%'
        }, 500)
        navbar.animate({
            width: '100%',
            marginLeft: '0%'
        }, 500);
        map.animate({
            width: '100%',
            marginLeft: '0%'
        }, 500)
    });
</script>
<script>
    mapboxgl.accessToken = 'pk.eyJ1Ijoic2Ftc3RyZWV0IiwiYSI6ImNsczRxb29mdTE1ZmkybHBjcHBhcG9xN2kifQ.SpJ2sxffT8PRfQjFtYgg6Q';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/samstreet/clto5jp0h01cg01ptc2idfbdk',
        zoom: 17,
        minZoom: 16,
        center: [124.2438547179179, 8.2414298468554],
        bearing: -95,
        maxBounds: [
            [124.23616973647256, 8.233619024568284], // Southwest bound
            [124.25301604017682, 8.248537110726303] // Northeast bound
        ]
    });
    // Loading Markers
    function loadMarkers() {
        $.ajax({
            url: '{{ route("buildings.get") }}',
            data: '',
            success: function(data) {
                data.buildings.forEach(function(building) {
                    var coordinates = [building.longitude, building.latitude];
                    var marker = new mapboxgl.Marker()
                        .setLngLat(coordinates)
                        .setPopup(new mapboxgl.Popup().setHTML('<h3>' + building.building_name + '</h3>'))
                        .addTo(map);
                });
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    loadMarkers();
</script>
</div>
</body>

</html>