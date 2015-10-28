var Util = {
    animate: function (selector, animation) {
        jQuery(selector)
            .removeClass()
            .addClass(animation + ' animated')
            .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',
            function () {
                jQuery(selector).removeClass();
            }
        );
    },

    setActiveMenuItem: function () {
        var pathname = window.location.pathname;

        if (pathname.indexOf('.php', pathname.length - '.php'.length) === -1) {
            pathname += 'index.php';
        }

        jQuery('a[href="' + pathname + '"]')
            .parents('li,ul')
            .addClass('active');
    },

    initPictureUploads: function (data) {
        var src = jQuery("#profile-picture-container").data('src');

        jQuery("#profile-picture-container").PictureCut({
            InputOfImageDirectory: "profile-picture",
            PluginFolderOnServer: "/~group4/vendor/picture-cut/",
            ActionToSubmitUpload: "/~group4/secure/ajax/update-profile-picture.php",
            FolderOnServer: "/~group4/images/uploads/",
            DefaultImageButton: src,
            EnableCrop: false,
            DataPost: data
        });
    }
};
