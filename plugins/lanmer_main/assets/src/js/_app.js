
(function($) {
    'use strict'

    window.kosmetyczneMorze = window.kosmetyczneMorze || {};

    kosmetyczneMorze.init = function() {

        kosmetyczneMorze.sideMenu('body');
        kosmetyczneMorze.slider('.heroContainer #slider');
        // kosmetyczneMorze.sliderStaff('.staff, .staff2');
        kosmetyczneMorze.sliderTreatment('.sub-treatments.slider');

        kosmetyczneMorze.frontPageNavigation('.heroContainer');
        kosmetyczneMorze.lightbox('a.gallery');
        kosmetyczneMorze.contactForm('.js-footer-form');
    };

    jQuery(document).ready(function() {
        kosmetyczneMorze.init();

        setInterval(function() {
            // courtain down
            $(document).find('.courtain').fadeOut();
        }, 800);
    });
})(jQuery);

