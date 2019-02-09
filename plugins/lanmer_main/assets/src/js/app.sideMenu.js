kosmetyczneMorze.sideMenu = (function($) {

    'use strict';

    var init = function(wrapper) {
        var $wrapper = $(wrapper);

        var $main = $wrapper.find('#page');
        var $side = $wrapper.find('#side');
        var $top = $wrapper.find('.mobile-side-menu-toggler')
        var $toggleButton = $wrapper.find('a#toggle')

        $toggleButton.on('click', function(e) {
            e.preventDefault();
            $main.toggleClass('expanded');
            $side.toggleClass('expanded');
            $top.toggleClass('expanded');
        })
    };

    return init;

})(jQuery);
