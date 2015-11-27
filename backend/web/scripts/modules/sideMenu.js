var sideMenu = (function () {
    'use strict';

    var Body = $("body");
    var rescale    = function() { sbOnResize(); };
    var lazyLayout = _.debounce(rescale, 300);

    // SideBar Left Toggle Function
    var sidebarLeftToggle = function() {

        // We check to see if the the user has closed the entire
        // leftside menu. If true we reopen it, this will result
        // in the menu resetting itself back to a minified state.
        // A second click will fully expand the menu.
        if (Body.hasClass('sb-l-c') && 'sb-l-m' === "sb-l-m") {
            Body.removeClass('sb-l-c');
        }

        // Toggle sidebar state(open/close)
        Body.toggleClass('sb-l-m');
        triggerResize();
    };

    // SideBar Right Toggle Function
    var sidebarRightToggle = function() {

        // toggle sidebar state(open/close)
        if (!Body.hasClass('mobile-view') && Body.hasClass('sb-r-o')) {
            Body.toggleClass('sb-r-o sb-r-c');
        }
        else {
            Body.toggleClass('sb-r-o sb-r-c');
        }

        setTimeout(function () {
            if (!Body.hasClass("sb-r-o")) {
                localStorage.setItem("inspect", "hide");
            } else {
                localStorage.setItem("inspect", "show");
                Body.removeClass("sb-r-c").addClass("sb-r-o");
            }
        }, 100);
        triggerResize();
    };

    // Check window size on load
    // Adds or removes "mobile-view" class based on window size
    var sbOnLoadCheck = function() {

        if (Body.hasClass('sb-l-m')) {
            Body.addClass('sb-l-disable-animation');
        } else {
            Body.removeClass('sb-l-disable-animation');
        }

        // If window is < 1080px wide collapse both sidebars and add ".mobile-view" class
        if ($(window).width() < 1080) {
            Body.removeClass('sb-r-o').addClass('mobile-view sb-l-m sb-r-c');
        }
    };

    // Check window size on resize
    // Adds or removes "mobile-view" class based on window size
    var sbOnResize = function() {

        // If window is < 1080px wide collapse both sidebars and add ".mobile-view" class
        if ($(window).width() < 1080 && !Body.hasClass('mobile-view')) {
            Body.removeClass('sb-r-o').addClass('mobile-view sb-l-m');
        } else if ($(window).width() > 1080) {
            Body.removeClass('mobile-view');
        }
    };

    // Most CSS menu animations are set to 300ms. After this time
    // we trigger a single global window resize to help catch any 3rd
    // party plugins which need the event to resize their given elements
    var triggerResize = function() {
        setTimeout(function() {
            $(window).trigger('resize');

            if (Body.hasClass('sb-l-m')) {
                Body.addClass('sb-l-disable-animation');
            } else {
                Body.removeClass('sb-l-disable-animation');
            }
        }, 300);
    };

    return {

        init: function () {
            sbOnLoadCheck();

            this.events();
        },

        // Общие обработчики событий
        events: function () {
            $("#toggle_sidemenu_l").on('click', sidebarLeftToggle);
            $("#toggle_sidemenu_r").on('click', sidebarRightToggle);

            // Attach debounced resize handler
            $(window).resize(lazyLayout);
        }

    };

})();