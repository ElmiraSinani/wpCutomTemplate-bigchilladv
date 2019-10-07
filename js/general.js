// scroll to top
(function (jQuery) {
    jQuery.fn.UItoTop = function (options) {
        var defaults = {
            text: 'To Top',
            min: 200,
            inDelay: 500,
            outDelay: 400,
            containerID: 'toTop',
            containerHoverID: 'toTopHover',
            scrollSpeed: 800,
            easingType: 'linear'
        };

        var settings = jQuery.extend(defaults, options);
        var containerIDhash = '#' + settings.containerID;
        var containerHoverIDHash = '#' + settings.containerHoverID;

        jQuery('body').append('<a href="#" id="' + settings.containerID + '">' + settings.text + '</a>');
        jQuery(containerIDhash).hide().click(function () {
            jQuery('html,body,document').animate({scrollTop: 0}, settings.scrollSpeed, settings.easingType);
            jQuery('#' + settings.containerHoverID, this).stop().animate({'opacity': 0}, settings.inDelay, settings.easingType);
            return false;
        })
                .prepend('<span id="' + settings.containerHoverID + '"></span>')
                .hover(function () {
                    jQuery(containerHoverIDHash, this).stop().animate({
                        'opacity': 1
                    }, 600, 'linear');
                }, function () {
                    jQuery(containerHoverIDHash, this).stop().animate({
                        'opacity': 0
                    }, 700, 'linear');
                });

        jQuery(window).scroll(function () {
            var sd = jQuery(window).scrollTop();
            if (typeof document.body.style.maxHeight === "undefined") {
                jQuery(containerIDhash).css({
                    'position': 'absolute',
                    'top': jQuery(window).scrollTop() + jQuery(window).height() - 50
                });
            }
            if (sd > settings.min)
                jQuery(containerIDhash).fadeIn(settings.inDelay);
            else
                jQuery(containerIDhash).fadeOut(settings.Outdelay);
        });

    };
})(jQuery);

/*** START Front Top Slider **/
jQuery(document).ready(function () {
    jQuery('.header_slider').slides({
        generatePagination: false,
        generateNextPrev: true,
        play: 7500,
        //pause: 3500,
        hoverPause: false,
        //effect: 'slide',
        crossfade: true,
        preload: true,
        preloadImage: 'wp-content/themes/bigchilladv/images/loading.gif'
    });
});
/*** END Front Top Slider **/

jQuery(document).ready(function () {
    jQuery('.form_message .close').on('click', function () {
        jQuery(this).parent().remove();
    });
});


// Pause autoscrolling on carousel hover.
function mycarousel_initCallback(carousel) {
    carousel.clip.hover(function () {
        carousel.stopAuto();
    }, function () {
        carousel.startAuto();
    });
}
;

jQuery(document).ready(function (jQuery) {

    // Top Search
    jQuery("#searchForm").hoverIntent({
        sensitivity: 5,
        interval: 100,
        over: function () {
            jQuery(this).stop().animate({width: '250px'}, 700, 'easeOutCubic');
            jQuery("#stext").stop().show().animate({width: '200px'}, 800, 'easeOutCubic');
        },
        timeout: 2000,
        out: function () {
            jQuery('#stext').stop().animate({width: '0px'}, 600, 'easeInCubic', function () {
                jQuery(this).hide();
            });
            jQuery(this).stop().animate({width: '29px'}, 700, 'easeInCubic');
        }
    });


    // Top Slider Links
    var mainWidth = jQuery(".header_slider .slides_container").width();
    var pageInner = jQuery(".header_slider .pagination_inner")
    var pageContent = jQuery(".header_slider .pagination");
    var pageItem = jQuery(".header_slider .pagination li");
    var pageInnerWidth = pageInner.width();
    var pageWidth = pageContent.width();
    var pageCount = pageItem.size();
    pageItem.css("width", pageWidth / pageCount - 48);
    pageInner.css("width", mainWidth);

    // Remove links outline in IE 7
    jQuery("a").attr("hideFocus", "true").css("outline", "none");

    // style Select, Radio, Checkboxe
    if (jQuery("select").hasClass("select_styled")) {
        cuSel({changedEl: ".select_styled", visRows: 15, scrollArrows: true});
    }
    //jQuery('.input_styled input').customInput();



    //jQuery(".dropdown li ul.submenu-1").css({'position':'absolute','visibility':'visible','display':'none'});



    var screenRes = jQuery(window).width();
    if (screenRes < 900) {
        jQuery("li.mega-nav").removeClass("mega-nav");
    }
    if (screenRes > 700) {
        mega_show();
        jQuery().UItoTop({easingType: 'easeOutQuart'});
    }
    if (screenRes > 960) {
        mega_show();

    }

    // centering dropdown list
    jQuery(".dropdown > li").hover(function () {
        var dropDown = jQuery(this).children("ul");
        var dropDownLi = jQuery(this).children().children("li").width();
        var posLeft = ((dropDownLi - jQuery(this).width()) / 2);
        dropDown.css("left", -posLeft);
    });
    // dropdown menu	
    jQuery('.dropdown .mega-nav > ul.submenu-1').each(function () {
        var liItems = jQuery(this);
        var Sum = 0;
        var liHeight = 0;
        if (liItems.children('li').length > 1) {
            jQuery(this).children('li').each(function (i, e) {
                Sum += jQuery(e).outerWidth(true);
            });
            jQuery(this).width(Sum);
            liHeight = jQuery(this).innerHeight();
            if (jQuery.browser.mozilla) {
                jQuery(this).children('li').css({"height": liHeight - 60});
            } else {
                jQuery(this).children('li').css({"height": liHeight - 40});
            }
        }
    });

    function mega_show() {
        jQuery('.dropdown li').hoverIntent({
            sensitivity: 5,
            interval: 100,
            over: subm_show,
            timeout: 100,
            out: subm_hide
        });
    }
    function subm_show() {
        jQuery(this).children("ul.submenu-1").fadeIn(400);
    }
    function subm_hide() {
        jQuery(this).children("ul.submenu-1").fadeOut(150);
    }


    jQuery(".dropdown ul").parent("li").addClass("parent");
    jQuery(".dropdown li:first-child, .pricing_box li:first-child, .sidebar .widget-container:first-child").addClass("first");
    jQuery(".dropdown li:last-child, .pricing_box li:last-child, .sidebar_inner > .widget-container:last-child, .widget_twitter .tweet_item:last-child").addClass("last");
    jQuery(".dropdown li:only-child").removeClass("last").addClass("only");
    jQuery(".sidebar .current-menu-item, .sidebar .current-menu-ancestor").prev().addClass("current-prev");

// tabs		
    if (jQuery("ul").hasClass("tabs")) {
        jQuery("ul.tabs").tabs("> .tabcontent", {tabs: 'li', effect: 'fade'});
    }
    if (jQuery("ul").is(".tabs.linked")) {
        jQuery("ul.tabs").tabs("> .tabcontent");
    }

    /* if (jQuery("ul").hasClass("linked")) {
     jQuery("ul.tabs").tabs("> .tabcontent");
     } elseif (jQuery("ul").hasClass("tabs")) {
     jQuery("ul.tabs").tabs("> .tabcontent", {tabs: 'li', effect: 'fade'});	
     } */

// odd/even
    jQuery("ul.recent_posts > li:odd, ul.popular_posts > li:odd, .styled_table table>tbody>tr:odd, .boxed_list > .boxed_item:odd").addClass("odd");
    jQuery(".widget_recent_comments ul > li:even, .widget_recent_entries li:even, .widget_twitter .tweet_item:even, .widget_archive ul > li:even, .widget_categories ul > li:even, .widget_nav_menu ul > li:even, .widget_links ul > li:even, .widget_meta ul > li:even, .widget_pages ul > li:even").addClass("even");

// cols
    jQuery(".row .col:first-child").addClass("alpha");
    jQuery(".row .col:last-child").addClass("omega");

// toggle content
    jQuery(".toggle_content").hide();
    jQuery(".toggle").toggle(function () {
        jQuery(this).addClass("active");
    }, function () {
        jQuery(this).removeClass("active");
    });

    jQuery(".toggle").click(function () {
        jQuery(this).next(".toggle_content").slideToggle(300, 'easeInQuad');
    });

// pricing
    jQuery(".price_col_body ul").each(function () {
        jQuery(this).find("li").removeClass("even").filter(":even").addClass("even");
    });
    jQuery(".pricing_box li.price_col").css('width', jQuery(".pricing_box ul").width() / jQuery(".pricing_box li.price_col").size());

// buttons	
    jQuery(".button_link, .button_styled, .btn-share, .btn, .contact-social img, .btn-submit, .social_content img, .social_content a, .post-share a").hover(function () {
        jQuery(this).stop().animate({"opacity": 0.85});
    }, function () {
        jQuery(this).stop().animate({"opacity": 1});
    });

// input labels
    if (jQuery(".row").hasClass("infieldlabel")) {
        jQuery(".infieldlabel label").inFieldLabels({fadeOpacity: 0.3});
    }

// preload images
    var cache = [];
    jQuery.preLoadImages = function () {
        var args_len = arguments.length;
        for (var i = args_len; i--; ) {
            var cacheImage = document.createElement('img');
            cacheImage.src = arguments[i];
            cache.push(cacheImage);
        }
        // list of images to preload. Need the full path to the image
        jQuery.preLoadImages("../images/dropdown_bg.png", "../images/dropdown_sub_arrow.png");
    }

// Topmenu <ul> replace to <select>
    jQuery(function () {
        if (screenRes < 470) {

            /* Clone our navigation */
            var mainNavigation = jQuery('.topmenu').clone();

            /* Replace unordered list with a "select" element to be populated with options, and create a variable to select our new empty option menu */
            jQuery('.topmenu').html('<select class="select_styled" id="topm-select"></select>');
            var selectMenu = jQuery('#topm-select');

            /* Navigate our nav clone for information needed to populate options */
            jQuery(mainNavigation).children('ul').children('li').each(function () {

                /* Get top-level link and text */
                var href = jQuery(this).children('a').attr('href');
                var text = jQuery(this).children('a').text();

                /* Append this option to our "select" */


                if (jQuery(this).is(".current-menu-item")) {
                    jQuery(selectMenu).append('<option value="' + href + '" selected>' + text + '</option>');
                } else {
                    jQuery(selectMenu).append('<option value="' + href + '">' + text + '</option>');
                }

                /* Check for "children" and navigate for more options if they exist */
                if (jQuery(this).children('ul').length > 0) {
                    jQuery(this).children('ul').children('li').each(function () {

                        /* Get child-level link and text */
                        var href2 = jQuery(this).children('a').attr('href');
                        var text2 = jQuery(this).children('a').text();

                        /* Append this option to our "select" */
                        if (jQuery(this).is(".current-menu-item")) {
                            jQuery(selectMenu).append('<option value="' + href2 + '" class="select-current" selected>' + text2 + '</option>');
                        } else {
                            jQuery(selectMenu).append('<option value="' + href2 + '"> &nbsp;|-- ' + text2 + '</option>');
                        }

                        /* Check for "children" and navigate for more options if they exist */
                        if (jQuery(this).children('ul').length > 0) {
                            jQuery(this).children('ul').children('li').each(function () {

                                /* Get child-level link and text */
                                var href3 = jQuery(this).children('a').attr('href');
                                var text3 = jQuery(this).children('a').text();

                                /* Append this option to our "select" */
                                if (jQuery(this).is(".current-menu-item")) {
                                    jQuery(selectMenu).append('<option value="' + href3 + '" class="select-current" selected>' + text3 + '</option>');
                                } else {
                                    jQuery(selectMenu).append('<option value="' + href3 + '"> &nbsp;&nbsp;&nbsp;&nbsp;|-- ' + text3 + '</option>');
                                }

                            });
                        }

                    });
                }

            });
        }

        /* When our select menu is changed, change the window location to match the value of the selected option. */
        jQuery(selectMenu).change(function () {
            location = this.options[this.selectedIndex].value;
        });
    });

});


