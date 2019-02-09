kosmetyczneMorze.frontPageNavigation = (function($) {

    'use strict'

    var init = function(wrapper) {
        var $wrapper = $(wrapper);

        // hover over hero menu items
        $wrapper.find('li').on('hover', function() {
            var level = parseInt(jQuery(this).closest('nav').data('level'));
            var thisId = parseInt(jQuery(this).data('id'));

            $(this).siblings().removeClass('active');
            $(this).addClass('active');

            // get direct submenu
            var subMenu = jQuery('.heroContainer nav[data-parent="' + (thisId).toString() +'"]');

            // hide all menus of next levels
            for (var i = level+1; i < 3; i++) {
                jQuery('.heroContainer nav[data-level="' + i.toString() + '"] li').removeClass('active');
                jQuery('.heroContainer nav[data-level="' + i.toString() + '"]').addClass('hidden');
            }

            if (subMenu.length > 0) {
                // show submenu
                subMenu.removeClass('hidden');
            }
        });

        // mouse leaves hero section, close all menus except from the primary one
        $wrapper.on('mouseleave', function() {
            jQuery('.heroContainer nav:not([data-level="0"])').addClass('hidden');
        });
    }

    return init;

})(jQuery);
