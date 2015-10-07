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
    }
};
