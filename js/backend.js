var BackEnd = {
    init: function() {
        Util.setActiveMenuItem();
    },

    myAccount: function() {

        jQuery('#success-container').hide();
        jQuery('#errors-container').hide();

        jQuery('html, body').animate({
            scrollTop: 0
        }, 250);

        if(jQuery('#inputName').val().length <= 4) {
            // log in failed
            jQuery('#errors-container').show();
            Util.animate('#errors-container', 'shake');
        } else {
            // successfully logged in
            jQuery('#success-container').show();
        }
    },

    addTicket: function() {

        jQuery('#success-container').hide();
        jQuery('#errors-container').hide();

        jQuery('html, body').animate({
            scrollTop: 0
        }, 250);

        if(jQuery('#inputMessage').val().length <= 10) {
            // log in failed
            jQuery('#errors-container').show();
            Util.animate('#errors-container', 'shake');
        } else {
            // successfully logged in
            var ticket_id = Math.floor((Math.random() * 100) + 1).toString();
            window.location.href = '/group4/secure/ticket.php?tickets_id=' + ticket_id;
        }
    },

    updateTicket: function() {

        jQuery('#success-container').hide();
        jQuery('#errors-container').hide();

        if(jQuery('#inputMessage').val().length <= 10) {
            // log in failed
            jQuery('#errors-container').show();
            Util.animate('#errors-container', 'shake');
        } else {
            // successfully logged in
            var ticket_id = Math.floor((Math.random() * 100) + 1).toString();
            window.location.href = '/group4/secure/ticket.php?tickets_id=' + ticket_id;
        }
    },

    logOutWait: function(seconds) {
        setInterval(function() {
            if(seconds == 0) {
                window.location.href = '/group4/';
            } else {
                seconds--;
                jQuery('#seconds-left').html(seconds);
            }
        }, 1000);
    },

    openTicket: function(tickets_id) {
        window.location.href = '/group4/secure/ticket.php?tickets_id='+tickets_id;
    },

    sortTickets: function(order_by) {
        // ajax load in the list ordered appropriately
        console.log('Sorting table by ' + order_by + '...');
    },

    searchTickets: function(search_term) {
        // ajax load in the list by key term
        console.log('Searching table by ' + search_term + '...');
    }
};

BackEnd.init();
