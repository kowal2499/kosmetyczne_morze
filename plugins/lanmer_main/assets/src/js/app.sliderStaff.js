kosmetyczneMorze.sliderStaff = (function($) {

    'use strict'

    var init = function(wrapper) {
        var $wrapper = $(wrapper).find('#slider, #slider2');

        var navigationId = $(wrapper).find('#navigation');

        if ($wrapper.length === 0) {
            return;
        }

        var names = $wrapper.data('names');

        $wrapper.slick({
            arrows: false,
            dots: true,
            slidesToScroll: 1,
            pauseOnHover: false,
            pauseOnFocus: false,
            appendDots: navigationId,
            customPaging: function(slider, i) {
                return '<a>' + names[i] + '</a>';
            },
        });
    }

    return init;

})(jQuery);
