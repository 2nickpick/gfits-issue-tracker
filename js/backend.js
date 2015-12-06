var BackEnd = {
    init: function () {
        Util.setActiveMenuItem();

        Util.initPictureUploads({users_id: jQuery('#hiddenUsersId').val()});

        jQuery('#search-users').on('change keyup', function (e) {
            BackEnd.searchUsers(this.value);
        });

        jQuery('#search-tickets').on('change keyup', function (e) {
            BackEnd.searchTickets(this.value);
        });
    },

    myAccount: function () {

        jQuery('#success-container').hide();
        jQuery('#errors-container').hide();

        jQuery('html, body').animate({
            scrollTop: 0
        }, 250);

        var first_name = jQuery('#inputFName').val();
        var last_name = jQuery('#inputLName').val();
        var phone_number = jQuery('#inputCell').val();
        var cell_phone_carrier_id = jQuery('#inputCellCarrier').val();
        var email_address = jQuery('#inputEmail').val();
        var password = jQuery('#inputPassword').val();
        var password_again = jQuery('#inputPasswordConfirm').val();
        var formData = new FormData(jQuery('form').get(0));

        jQuery.ajax({
            url: "/~group4/secure/ajax/my-account.php",
            data: formData,
            type: 'POST',
            enctype: "multipart/form-data",
            processData: false,
            cache: false,
            contentType: false,
            xhr: function() {  // Custom XMLHttpRequest
                var myXhr = jQuery.ajaxSettings.xhr();
                if(myXhr.upload){ // Check if upload property exists
                    myXhr.upload.addEventListener('progress', function() {return true;} , false); // For handling the progress of the upload
                }
                return myXhr;
            },
            success: function (response)
            {
                if(response.success) {
                    jQuery('#success-container').show();
                } else {
                    jQuery('#errors-container .alert').html(response.error);
                    jQuery('#errors-container').show();
                    Util.animate('#errors-container', 'shake');
                }
                jQuery('#throbber').hide();
            }
        }, 'json');

    },

    addTicket: function () {

        jQuery('#success-container').hide();
        jQuery('#errors-container').hide();

        jQuery('html, body').animate({
            scrollTop: 0
        }, 250);

        var title = jQuery('#inputTitle').val();
        var message = jQuery('#inputMessage').val();

        jQuery.post(
            "/~group4/secure/ajax/add-ticket.php",
            {
                'title': title,
                'message': message
            },
            function (response) {
                if(response.success) {
                    window.location.href = '/~group4/secure/ticket.php?tickets_id=' + response.tickets_id;
                } else {
                    jQuery('#errors-container .alert').html(response.error);
                    jQuery('#errors-container').show();
                    Util.animate('#errors-container', 'shake');
                }
                jQuery('#throbber').hide();
            },
            'json'
        );
    },

    updateTicket: function () {

        jQuery('#success-container').hide();
        jQuery('#errors-container').hide();

        jQuery('html, body').animate({
            scrollTop: 0
        }, 250);

        var message = jQuery('#inputMessage').val();
        var tickets_id = jQuery('#inputTicketsId').val();

        jQuery.post(
            "/~group4/secure/ajax/edit-ticket.php",
            {
                'tickets_id': tickets_id,
                'message': message
            },
            function (response) {
                if(response.success) {
                    window.location.href = '/~group4/secure/ticket.php?tickets_id=' + response.tickets_id;
                } else {
                    jQuery('#errors-container .alert').html(response.error);
                    jQuery('#errors-container').show();
                    Util.animate('#errors-container', 'shake');
                }
                jQuery('#throbber').hide();
            },
            'json'
        );
    },

    logOutWait: function (seconds) {
        setInterval(function () {
            if (seconds == 0) {
                window.location.href = '/~group4/';
            } else {
                seconds--;
                jQuery('#seconds-left').html(seconds);
            }
        }, 1000);
    },

    openTicket: function (tickets_id) {
        window.location.href = '/~group4/secure/ticket.php?tickets_id=' + tickets_id;
    },

    sortTickets: function (order_by) {
        BackEnd.searchTickets(jQuery('#ticket-search').val(), order_by);
    },

    searchTickets: function (search_term, order_by) {

        if (!order_by) {
            order_by = '';
        }

        jQuery('#throbber').show();
        jQuery.post(
            "/~group4/secure/ajax/search-ticket.php",
            {
                'search': search_term,
                'order_by': order_by,
                'verb': 'search'
            },
            function (tickets) {
                jQuery('#ticket_count').text(tickets.length);

                var tbody = jQuery('.tickets tbody');
                tbody.empty();

                var tr, check;
                jQuery.each(tickets, function (i, ticket) {
                    tr = jQuery('<tr>');
                    check = '';

                    if (!ticket.open) {
                        tr.addClass('success');
                        check = '<span class="glyphicon glyphicon-ok" title="Ticket is closed!"></span> ';
                    }

                    tr.on('click', function () {
                        BackEnd.openTicket(ticket.id);
                    })
                        .append(
                        jQuery('<td>').html(check + ticket.id),
                        jQuery('<td>').text(ticket.title),
                        jQuery('<td>').text(ticket.opened_by),
                        jQuery('<td>').html(ticket.date_opened),
                        jQuery('<td>').text(ticket.last_reply)
                    ).appendTo(tbody);

                });

                jQuery('#throbber').hide();
            },
            'json'
        );
    },

    addUserForm: function () {
        window.location.href = '/~group4/secure/add-user.php';
    },

    addUser: function () {

        jQuery('#success-container').hide();
        jQuery('#errors-container').hide();

        jQuery('html, body').animate({
            scrollTop: 0
        }, 250);

        var data = {
            first_name: jQuery('#inputFirstName').val(),
            last_name: jQuery('#inputLastName').val(),
            email_address: jQuery('#inputEmailAddress').val(),
            phone_number: jQuery('#inputPhoneNumber').val(),
            type_id: jQuery('#selectLoginType').val(),
            cell_phone_carrier_id: jQuery('#selectPhoneCarrier').val(),
            password: jQuery('#inputPassword').val(),
            password_again: jQuery('#inputPasswordAgain').val()
        };

        jQuery.post(
            "/~group4/secure/ajax/add-user.php",
            data,
            function (response) {
                if (response.success) {
                    // added user successfully
                    window.location.href = '/~group4/secure/user.php?users_id=' + response.users_id;
                } else {
                    // add user failed
                    jQuery('#errors-container .alert').html(response.error);
                    jQuery('#errors-container').show();
                    Util.animate('#errors-container', 'shake');
                }
            }, "json");
    },

    openUser: function (users_id) {
        window.location.href = '/~group4/secure/user.php?users_id=' + users_id;
    },

    updateUser: function () {

        jQuery('#success-container').hide();
        jQuery('#errors-container').hide();

        jQuery('html, body').animate({
            scrollTop: 0
        }, 250);

        var data = {
            users_id: jQuery('#hiddenUsersId').val(),
            first_name: jQuery('#inputFirstName').val(),
            last_name: jQuery('#inputLastName').val(),
            email_address: jQuery('#inputEmailAddress').val(),
            phone_number: jQuery('#inputPhoneNumber').val(),
            type_id: jQuery('#selectLoginType').val(),
            cell_phone_carrier_id: jQuery('#selectPhoneCarrier').val(),
            password: jQuery('#inputPassword').val(),
            password_again: jQuery('#inputPasswordAgain').val()
        };

        jQuery.post(
            "/~group4/secure/ajax/edit-user.php",
            data,
            function (response) {
                if (response.success) {
                    // updated user successfully
                    window.location.href = '/~group4/secure/users.php';
                } else {
                    // update user failed
                    jQuery('#errors-container .alert').html(response.error);
                    jQuery('#errors-container').show();
                    Util.animate('#errors-container', 'shake');
                }
            }, "json");
    },

    deleteUser: function () {
        if (confirm('Are you sure you want to delete this user?')) {

            jQuery('#success-container').hide();
            jQuery('#errors-container').hide();

            jQuery('html, body').animate({
                scrollTop: 0
            }, 250);

            var data = {
                users_id: jQuery('#hiddenUsersId').val()
            };

            jQuery.post(
                "/~group4/secure/ajax/delete-user.php",
                data,
                function (response) {
                    if (response.success) {
                        // updated user successfully
                        window.location.href = '/~group4/secure/users.php';
                    } else {
                        // update user failed
                        jQuery('#errors-container .alert').html(response.error);
                        jQuery('#errors-container').show();
                        Util.animate('#errors-container', 'shake');
                    }
                }, "json");
        }
    },

    sortUsers: function (order_by) {
        BackEnd.searchUsers(jQuery('#user-search').val(), order_by);
    },

    searchUsers: function (search_term, order_by) {

        if (!order_by) {
            order_by = '';
        }

        jQuery('#throbber').show();
        jQuery.post(
            "/~group4/secure/ajax/search-user.php",
            {
                'search': search_term,
                'order_by': order_by,
                'verb': 'search'
            },
            function (users) {
                jQuery('#user_count').text(users.length);

                var tbody = jQuery('.users tbody');
                tbody.empty();

                var email_address = '';
                var phone_number = '';
                jQuery.each(users, function (i, user) {

                    email_address = '';
                    if (user.email_address != null) {
                        email_address = '<a href="' + user.email_address + '">' + user.email_address + '</a>';
                    }

                    phone_number = '';
                    if (user.phone_number != null) {
                        phone_number = user.phone_number;
                    }

                    jQuery('<tr>')
                        .on('click', function () {
                            BackEnd.openUser(user.id);
                        })
                        .append(
                        jQuery('<td>').text(user.id),
                        jQuery('<td>').text(user.first_name + ' ' + user.last_name),
                        jQuery('<td>').text(user.role),
                        jQuery('<td>').html(email_address),
                        jQuery('<td>').text(phone_number)
                    ).appendTo(tbody);
                });

                jQuery('#throbber').hide();
            },
            'json'
        );
    }
};

BackEnd.init();
