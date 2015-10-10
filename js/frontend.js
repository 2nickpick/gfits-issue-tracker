var FrontEnd = {
    init: function() {
        Util.setActiveMenuItem();
    },

    logIn: function() {
        if(jQuery('#inputPassword').val() != 'test1234') {
            // log in failed
            jQuery('#errors-container').show();
            Util.animate('#errors-container', 'shake');
        } else {
            // successfully logged in
            window.location.href = '/group4/secure/dashboard.php';
        }
    },

    signUp: function() {
        if(jQuery('#inputPassword').val() != 'test1234') {
            // log in failed
            jQuery('#errors-container').show();
            Util.animate('#errors-container', 'shake');
        } else {
            // successfully logged in
            window.location.href = '/group4/sign-up-thanks.php';
        }
    },

    contactUs: function() {
        if(jQuery('#inputMessage').val().length <= 5) {
            // log in failed
            jQuery('#errors-container').show();
            Util.animate('#errors-container', 'shake');
        } else {
            // successfully logged in
            window.location.href = '/group4/contact-us-thanks.php';
        }
    }
};

FrontEnd.init();
