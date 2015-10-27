var FrontEnd = {
    init: function() {
        Util.setActiveMenuItem();
    },

    logIn: function() {
        var data = {
            email: jQuery('#inputEmail').val(),
            password: jQuery('#inputPassword').val()
        };

        jQuery.post(
            "/~group4/ajax/log-in.php",
            data,
            function(response) {
            if(response.success) {
                // successfully logged in
                window.location.href = '/~group4/secure/dashboard.php';
            } else {
                // log in failed
                jQuery('#errors-container .alert').html(response.error);
                jQuery('#errors-container').show();
                Util.animate('#errors-container', 'shake');
            }
        }, "json");
    },

    signUp: function() {
        if(jQuery('#inputPassword').val() != 'test1234') {
            // log in failed
            jQuery('#errors-container').show();
            Util.animate('#errors-container', 'shake');
        } else {
            // successfully logged in
            window.location.href = '/~group4/sign-up-thanks.php';
        }
    },

    contactUs: function() {

        var data = {
            name: jQuery('#inputName').val(),
            email: jQuery('#inputEmail').val(),
            message: jQuery('#inputMessage').val()
        };

        jQuery.post(
            "/~group4/ajax/contact-us.php",
            data,
            function(response) {
                if(response.success) {
                    // message successfully sent
                    window.location.href = '/~group4/contact-us-thanks.php';
                } else {
                    // log in failed
                    jQuery('#errors-container .alert').html(response.error);
                    jQuery('#errors-container').show();
                    Util.animate('#errors-container', 'shake');
                }
            }, "json");
    }
};

FrontEnd.init();
