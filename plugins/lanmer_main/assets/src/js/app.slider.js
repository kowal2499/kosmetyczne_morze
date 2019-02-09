kosmetyczneMorze.slider = (function($) {

    'use strict'

    var init = function(wrapper) {
        var $wrapper = $(wrapper);
        var navigationId = 'slide-navigation';

        if ($wrapper.length === 0) {
            return;
        }

        $wrapper.slick({
            autoplay: true,
            autoplaySpeed: 5000,
            slidesToScroll: 1,
            fade: true,
            arrows: false,
            dots: true,
            pauseOnHover: false,
            pauseOnFocus: false,
            cssEase: 'linear',
            appendDots: $('#' + navigationId),
            customPaging: function(slider, i) {
                return '<a>' + (i+1) + '</a>';
            },
        });

        $wrapper.on('click', function(e) {
            e.preventDefault();
        })

        $wrapper.on('afterChange', function(event, slick, direction) {
            $('.slide-img').removeClass('anim-right');
            var currentSlideId = ($wrapper.slick('slickCurrentSlide'));
            var currentSlideElm = $wrapper.find('.slide[data-id="' + currentSlideId + '"]')

            // attach animation classes
            currentSlideElm.find('.slide-img').addClass('anim-right');
        });
    }

    return init;

})(jQuery);
