kosmetyczneMorze.sliderTreatment = (function($) {

    'use strict';

    var init = function(wrapper) {
        var $wrapper = $(wrapper);

        if ($wrapper.length === 0) {
            return;
        }

        $wrapper.slick({
            arrows: true,
            dots: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            pauseOnHover: false,
            pauseOnFocus: false,
            centerMode: true,
            centerPadding: '60px',

            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        centerPadding: null
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        centerPadding: null,
                        dots: false
                    }
                }
            ]
        });
    }

    return init;

})(jQuery);
