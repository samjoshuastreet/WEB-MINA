<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@yield('more_scripts')
<script>
    var sidebarStatus = 0;
    var loginFormStatus = 0;
    var regFormStatus = 0;
    var samplePopupStatus = 0;
    var procedurePopupStatus = 0;

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
        console.log('clicked')
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

    $('.popup-procedure-btn').on('click', function() {
        var procedurePopup = $('#popup-procedure');
        if (procedurePopupStatus == 0) {
            procedurePopup.animate({
                right: '7.5%'
            }, 500)
            procedurePopupStatus = 1;
        } else {
            samplePopup.animate({
                right: '-100%'
            }, 500)
            procedurePopupStatus = 0;
        }
    });
    $('.popup-procedure-close-btn').on('click', function() {
        var procedurePopup = $('#popup-procedure');
        procedurePopup.animate({
            right: '-100%'
        }, 500)
        procedurePopupStatus = 0;
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

    $('#procedures-btn').on('click', function() {
        var procedures = $('#procedures-cont');
        var navbar = $('#navbar');
        var map = $('#map');
        var sidebar = $('#sidebar');

        procedures.animate({
            left: '0%'
        }, 500)
        navbar.animate({
            width: '80%',
            marginLeft: '20%'
        }, 500);
        map.animate({
            width: '80%',
            marginLeft: '20%'
        }, 500)

        if (sidebarStatus == 1) {
            sidebar.animate({
                left: "-20%"
            }, 500)

            sidebarStatus = 0;
        }
    });

    $('#events-btn').on('click', function() {
        var events = $('#events-cont');
        var navbar = $('#navbar');
        var map = $('#map');
        var sidebar = $('#sidebar');

        events.animate({
            left: '0%'
        }, 500)
        navbar.animate({
            width: '80%',
            marginLeft: '20%'
        }, 500);
        map.animate({
            width: '80%',
            marginLeft: '20%'
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

    $('#procedures-close-btn').on('click', function() {
        var procedures = $('#procedures-cont');
        var navbar = $('#navbar');
        var map = $('#map');
        var sidebar = $('#sidebar'); // Add this line

        procedures.animate({
            left: '-20%'
        }, 500)
        navbar.animate({
            width: '80%',
            marginLeft: '20%'
        }, 500);
        map.animate({
            width: '80%',
            marginLeft: '20%'
        }, 500)

        sidebar.animate({ // Add this block
            left: '0%'
        }, 500);
        sidebarStatus = 1;
    });

    $('#events-close-btn').on('click', function() {
        var events = $('#events-cont');
        var navbar = $('#navbar');
        var map = $('#map');
        var sidebar = $('#sidebar'); // Add this line

        events.animate({
            left: '-20%'
        }, 500)
        navbar.animate({
            width: '80%',
            marginLeft: '20%'
        }, 500);
        map.animate({
            width: '80%',
            marginLeft: '20%'
        }, 500)

        sidebar.animate({ // Add this block
            left: '0%'
        }, 500);
        sidebarStatus = 1;
    });
</script>
</div>
</body>

</html>