jQuery(document).ready(function(jQuery) {
    
    var onMouseOutOpacity = 0.67;
    jQuery('#thumbs ul.thumbs li').opacityrollover({
            mouseOutOpacity:   onMouseOutOpacity,
            mouseOverOpacity:  1.0,
            fadeSpeed:         'fast',
            exemptionSelector: '.selected'
    });
    var captionOpacity = 0.70;
    // Initialize Advanced Galleriffic Gallery
    var gallery = jQuery('#thumbs').galleriffic({
            delay:                     2500,
            numThumbs:                 9,
            preloadAhead:              3,
            enableTopPager:            false,
            enableBottomPager:         true,
            maxPagesToShow:            7,
            imageContainerSel:         '#slideshow',
            controlsContainerSel:      '#controls',
            captionContainerSel:       '#caption',
            loadingContainerSel:       '#loading',
            renderSSControls:          true,
            renderNavControls:         true,
            playLinkText:              'Play',
            pauseLinkText:             'Pause',
            prevLinkText:              '&lsaquo; Previous',
            nextLinkText:              'Next &rsaquo;',
            nextPageLinkText:          'Next &rsaquo;',
            prevPageLinkText:          '&lsaquo; Prev',
            enableHistory:             false,
            autoStart:                 false,
            syncTransitions:           true,
            defaultTransitionDuration: 900,
            onSlideChange:             function(prevIndex, nextIndex) {
                    // 'this' refers to the gallery, which is an extension of jQuery('#thumbs')
                    this.find('ul.thumbs').children()
                            .eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
                            .eq(nextIndex).fadeTo('fast', 1.0);
            },
            onTransitionOut:           function(slide, caption, isSync, callback) {
                    slide.fadeTo(this.getDefaultTransitionDuration(isSync), 0.0, callback);
                    caption.fadeTo(this.getDefaultTransitionDuration(isSync), 0.0);
            },
            onTransitionIn:            function(slide, caption, isSync) {
                    var duration = this.getDefaultTransitionDuration(isSync);
                    slide.fadeTo(duration, 1.0);

                    // Position the caption at the bottom of the image and set its opacity
                    var slideImage = slide.find('img');
                    caption.width(slideImage.width())
                            .css({
                                    'bottom' : Math.floor((slide.height() - slideImage.outerHeight()) / 2),
                                    'left' : Math.floor((slide.width() - slideImage.width()) / 2) + slideImage.outerWidth() - slideImage.width()
                            })
                            .fadeTo(duration, captionOpacity);
                    jQuery('#caption a[data-rel]').each(function() {
                            jQuery(this).attr('rel', jQuery(this).data('rel'));
                    });
                    jQuery("#caption a[rel^='prettyPhoto']").prettyPhoto({social_tools:false});
            },
            onPageTransitionOut:       function(callback) {
                    this.fadeTo('fast', 0.0, callback);
            },
            onPageTransitionIn:        function() {
                    this.fadeTo('fast', 1.0);
            }
    });
});