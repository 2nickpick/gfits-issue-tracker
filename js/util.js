var Util = {
    animate: function(selector, animation) {
        jQuery(selector)
            .removeClass()
            .addClass(animation + ' animated')
            .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',
                function(){
                    jQuery(selector).removeClass();
                }
            );
    },

    setActiveMenuItem: function() {
        var pathname = window.location.pathname;

        if(pathname.indexOf('.php', pathname.length - '.php'.length) === -1) {
            pathname += 'index.php';
        }

        jQuery('a[href="' + pathname + '"]')
            .parents('li,ul')
            .addClass('active');
    }
};
