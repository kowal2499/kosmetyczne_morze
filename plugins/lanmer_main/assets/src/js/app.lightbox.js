kosmetyczneMorze.lightbox = (function($) {

    'use strict';

    var init = function(wrapper) {
        var $wrapper = $(wrapper);

        // find all gallery links and get its ids
        var galleryIds = [];
        $wrapper.each(function (i, item) {
            var id = $(item).data('galleryid');
            if (galleryIds.indexOf(id) === -1) {
                if (id) {
                    galleryIds.push(id);
                }
            }
        });

        // use collected ids to launch simpleLightbox per each gallery
        galleryIds.forEach(function (id) {
            $('a.gallery[data-galleryid="' + id + '"]').simpleLightbox();
        });

        // common gallery if no ids specifed
        if (galleryIds.length === 0) {
            $('a.gallery').simpleLightbox();
        }
    };

    return init;

})(jQuery);
