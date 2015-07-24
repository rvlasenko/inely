/****  Variables Initiation  ****/
var doc = document;
var docEl = document.documentElement;
var $body = $('body');
var $sidebar = $('.sidebar');
var $sidebarFooter = $('.sidebar .sidebar-footer');
var $topbar = $('.topbar');
var $logopanel = $('.logopanel');
var $sidebarWidth = $(".sidebar").width();
var content = document.querySelector('.page-content');
var windowHeight = $(window).height();
var start = delta = end = 0;
$(window).load(function () {
    "use strict";
    setTimeout(function () {
        $('.loader-overlay').addClass('loaded');
        $('body > section').animate({
            opacity: 1
        }, 400);
    }, 500);
});

/* ==========================================================*/
/* LAYOUTS API                                                */
/* ========================================================= */

/* Create Sidebar Fluid / Remove Sidebar Fixed */
function handleSidebarFluid() {
    $('#switch-sidebar').prop('checked', false);
    if ($('body').hasClass('sidebar-hover')) {
        removeSidebarHover();
        $('#switch-sidebar-hover').prop('checked', false);
    }
    $('body').removeClass('fixed-sidebar');
    handleboxedLayout();
    destroySideScroll();
    $.removeCookie('fixed-sidebar');
    $.removeCookie('fixed-sidebar', {
        path: '/'
    });
    $.cookie('fluid-sidebar', 1);
    $.cookie('fluid-sidebar', 1);
    $.cookie('fluid-sidebar', 1, {
        path: '/'
    });
    $.cookie('fluid-sidebar', 1, {
        path: '/'
    });
}

/* Toggle Sidebar Fixed / Fluid */
function toggleSidebar() {
    if ($('body').hasClass('fixed-sidebar')) handleSidebarFluid();
    else handleSidebarFixed();
}

/* Create Sidebar Fixed */
function handleSidebarFixed() {
    // removeSidebarHover();
    $('#switch-sidebar').prop('checked', true);
    $('#switch-submenu').prop('checked', false);
    $.removeCookie('submenu-hover');
    if ($('body').hasClass('sidebar-top')) {
        $('body').removeClass('fixed-topbar').addClass('fixed-topbar');
        $.removeCookie('fluid-topbar');
        $('#switch-topbar').prop('checked', true);
    }
    $('body').removeClass('fixed-sidebar').addClass('fixed-sidebar');
    $('.sidebar').height('');
    handleboxedLayout();
    //if (!$('body').hasClass('sidebar-collapsed')) removeSubmenuHover();
    createSideScroll();
    $.removeCookie('fluid-sidebar');
    $.removeCookie('fluid-sidebar', {path: '/'});
    $.cookie('fixed-sidebar', 1);
    $.cookie('fixed-sidebar', 1, {
        path: '/'
    });
}

/* Toggle Sidebar Fixed / Fluid */
function toggleSidebar() {
    if ($('body').hasClass('fixed-sidebar')) handleSidebarFluid();
    else handleSidebarFixed();
}

/* Create Sidebar only visible on Hover */
function createSidebarHover() {
    $('body').addClass('sidebar-hover');
    $('body').removeClass('fixed-sidebar').addClass('fixed-sidebar');
    $('.main-content').css('margin-left', '').css('margin-right', '');
    $('.topbar').css('left', '').css('right', '');
    $('body').removeClass('sidebar-top');
    //removeSubmenuHover();
    //removeBoxedLayout();
    removeCollapsedSidebar();
    sidebarHover();
    handleSidebarFixed();
    $('#switch-sidebar-hover').prop('checked', true);
    $('#switch-sidebar').prop('checked', true);
    $('#switch-sidebar-top').prop('checked', false);
    $('#switch-boxed').prop('checked', false);
    $.removeCookie('fluid-topbar');
    $.removeCookie('sidebar-top');
    $.removeCookie('fluid-topbar', {
        path: '/'
    });
    $.removeCookie('sidebar-top', {
        path: '/'
    });
    $.cookie('sidebar-hover', 1);
    $.cookie('sidebar-hover', 1, {
        path: '/'
    });
}

/* Remove Sidebar on Hover */
function removeSidebarHover() {
    $('#switch-sidebar-hover').prop('checked', false);
    $('body').removeClass('sidebar-hover');
    if (!$('body').hasClass('boxed')) $('.sidebar, .sidebar-footer').attr('style', '');
    $('.logopanel2').remove();
    $.removeCookie('sidebar-hover');
    $.removeCookie('sidebar-hover', {
        path: '/'
    });
}

/* Adjust margin of content for boxed layout */
function handleboxedLayout() {
    if ($('body').hasClass('builder-admin')) return;
    $logopanel.css('left', '').css('right', '');
    $topbar.css('width', '');
    $sidebar.css('margin-left', '').css('margin-right', '');
    $sidebarFooter.css('left', '').css('right', '');
    if ($('body').hasClass('boxed')) {
        var windowWidth = $(window).width();
        //var container = 1200;
        var margin = (windowWidth - 1200) / 2;
        if (!$('body').hasClass('sidebar-top')) {
            if ($('body').hasClass('rtl')) {
                $logopanel.css('right', margin);
                if ($('body').hasClass('sidebar-collapsed')) {
                    $topbar.css('width', 1200);
                }
                else {
                    if ($('body').hasClass('fixed-sidebar')) {
                        $sidebar.css('margin-right', margin);
                        var topbarWidth = (1200 - $sidebarWidth);
                        $('.topbar').css('width', topbarWidth);
                    }
                    $sidebarFooter.css('right', margin);
                    $topbar.css('width', 960);
                }
            }
            else {
                $logopanel.css('left', margin);
                if ($('body').hasClass('sidebar-collapsed')) {
                    $topbar.css('width', 1200);
                }
                else {
                    if ($('body').hasClass('fixed-sidebar')) {
                        $sidebar.css('margin-left', margin);
                        topbarWidth = (1200 - $sidebarWidth);
                        $('.topbar').css('width', topbarWidth);
                    }
                    $sidebarFooter.css('left', margin);
                    $topbar.css('width', 960);
                }
            }
        }
        $.backstretch(["images/gallery/bg1.jpg", "images/gallery/bg2.jpg", "images/gallery/bg3.jpg", "images/gallery/bg4.jpg"], {
            fade: 3000,
            duration: 4000
        });
    }
}

/* Toggle Sidebar Collapsed */
function collapsedSidebar() {
    if ($body.css('position') != 'relative') {
        if (!$body.hasClass('sidebar-collapsed')) {
            createCollapsedSidebar()
        }
        else {
            removeCollapsedSidebar()
        }
    } else {
        if ($body.hasClass('sidebar-show')) $body.removeClass('sidebar-show');
        else $body.addClass('sidebar-show');
    }
    handleboxedLayout();
}

function createCollapsedSidebar() {
    $body.addClass('sidebar-collapsed');
    $('.sidebar').css('width', '').resizable().resizable('destroy');
    $('.nav-sidebar ul').attr('style', '');
    $(this).addClass('menu-collapsed');
    destroySideScroll();
    $('#switch-sidebar').prop('checked');
    $.cookie('sidebar-collapsed', 1);
    $.cookie('sidebar-collapsed', 1, {
        path: '/'
    });
}

function removeCollapsedSidebar() {
    $body.removeClass('sidebar-collapsed');
    if (!$body.hasClass('submenu-hover')) $('.nav-sidebar li.active ul').css({
        display: 'block'
    });
    $(this).removeClass('menu-collapsed');
    if ($body.hasClass('sidebar-light') && !$body.hasClass('sidebar-fixed')) {
        $('.sidebar').height('');
    }
    createSideScroll();
    $.removeCookie('sidebar-collapsed');
    $.removeCookie('sidebar-collapsed', {
        path: '/'
    });
}
$('[data-toggle]').on('click', function (event) {
    event.preventDefault();
    var toggleLayout = $(this).data('toggle');
    //if (toggleLayout == 'rtl') toggleRTL();
    if (toggleLayout == 'sidebar-behaviour') toggleSidebar();
    //if (toggleLayout == 'submenu') toggleSubmenuHover();
    if (toggleLayout == 'sidebar-collapsed') collapsedSidebar();
    if (toggleLayout == 'sidebar-top') toggleSidebarTop();
    if (toggleLayout == 'sidebar-hover') toggleSidebarHover();
    //if (toggleLayout == 'boxed') toggleboxedLayout();
    if (toggleLayout == 'topbar') toggleTopbar();
});

/* Reset to Default Style, remove all cookie and custom layouts */
function resetStyle() {
    $('#reset-style').on('click', function (event) {
        event.preventDefault();
        //removeBoxedLayout();
        removeSidebarTop();
        removeSidebarHover();
        //removeSubmenuHover();
        removeCollapsedSidebar();
        //disableRTL();
        $.removeCookie('main-color');
        $.removeCookie('main-name');
        $.removeCookie('theme');
        $.removeCookie('bg-name');
        $.removeCookie('bg-color');
        $.removeCookie('submenu-hover');
        $.removeCookie('sidebar-collapsed');
        $.removeCookie('app-language');
        $.removeCookie('app-language', {path: '/'});
        $.removeCookie('main-color', {
            path: '/'
        });
        $.removeCookie('main-name', {
            path: '/'
        });
        $.removeCookie('theme', {
            path: '/'
        });
        $.removeCookie('bg-name', {
            path: '/'
        });
        $.removeCookie('bg-color', {
            path: '/'
        });
        $.removeCookie('submenu-hover', {
            path: '/'
        });
        $.removeCookie('sidebar-collapsed', {
            path: '/'
        });
        $('body').removeClass(function (index, css) {
            return (css.match(/(^|\s)bg-\S+/g) || []).join(' ');
        });
        $('body').removeClass(function (index, css) {
            return (css.match(/(^|\s)color-\S+/g) || []).join(' ');
        });
        $('body').removeClass(function (index, css) {
            return (css.match(/(^|\s)theme-\S+/g) || []).join(' ');
        });
        $('body').addClass('theme-sdtl').addClass('color-default');
        $('.builder .theme-color').removeClass('active');
        $('.theme-color').each(function () {
            if ($(this).data('color') == '#319DB5') $(this).addClass('active');
        });
        $('.builder .theme').removeClass('active');
        $('.builder .theme-default').addClass('active');
        $('.builder .sp-replacer').removeClass('active');
    });
}


/******************** END LAYOUT API  ************************/
/* ========================================================= */
/****  Full Screen Toggle  ****/
function toggleFullScreen() {
    if (!doc.fullscreenElement && !doc.msFullscreenElement && !doc.webkitIsFullScreen && !doc.mozFullScreenElement) {
        if (docEl.requestFullscreen) {
            docEl.requestFullscreen();
        } else if (docEl.webkitRequestFullScreen) {
            docEl.webkitRequestFullscreen();
        } else if (docEl.webkitRequestFullScreen) {
            docEl.webkitRequestFullScreen();
        } else if (docEl.msRequestFullscreen) {
            docEl.msRequestFullscreen();
        } else if (docEl.mozRequestFullScreen) {
            docEl.mozRequestFullScreen();
        }
    } else {
        if (doc.exitFullscreen) {
            doc.exitFullscreen();
        } else if (doc.webkitExitFullscreen) {
            doc.webkitExitFullscreen();
        } else if (doc.webkitCancelFullScreen) {
            doc.webkitCancelFullScreen();
        } else if (doc.msExitFullscreen) {
            doc.msExitFullscreen();
        } else if (doc.mozCancelFullScreen) {
            doc.mozCancelFullScreen();
        }
    }
}
$('.toggle_fullscreen').click(function () {
    toggleFullScreen();
});

/**** PANEL ACTIONS ****/
function handlePanelAction() {
    /* Create Portlets Controls automatically */
    function handlePanelControls() {
        $('.panel-controls').each(function () {
            var controls_html = '<div class="control-btn">' + '<a href="#" class="panel-reload"><i class="icon-reload"></i></a>' + '<a href="#" class="panel-maximize"><i class="icon-size-fullscreen"></i></a>' + '<a href="#" class="panel-toggle"><i class="fa fa-angle-down"></i></a>' + '</div>';
            $(this).append(controls_html);
        });
    }

    handlePanelControls();
    // Toggle Panel Content
    $(document).on("click", ".panel-header .panel-toggle", function (event) {
        event.preventDefault();
        $(this).toggleClass("closed").parents(".panel:first").find(".panel-content").slideToggle();
    });
}

/****  Custom Scrollbar  ****/
/* Create Custom Scroll for elements like Portlets or Dropdown menu */
function customScroll() {
    if ($.fn.mCustomScrollbar) {
        $('.withScroll').each(function () {
            $(this).mCustomScrollbar("destroy");
            var scroll_height = $(this).data('height') ? $(this).data('height') : 'auto';
            var data_padding = $(this).data('padding') ? $(this).data('padding') : 0;
            if ($(this).data('height') == 'window') {
                thisHeight = $(this).height();
                windowHeight = $(window).height() - data_padding - 50;
                if (thisHeight < windowHeight) scroll_height = thisHeight;
                else scroll_height = windowHeight;
            }
            $(this).mCustomScrollbar({
                scrollButtons: {
                    enable: false
                },
                autoHideScrollbar: $(this).hasClass('show-scroll') ? false : true,
                scrollInertia: 150,
                theme: "light",
                set_height: scroll_height,
                advanced: {
                    updateOnContentResize: true
                }
            });
        });
    }
}

/* Create custom scroll for sidebar used for fixed sidebar */
function createSideScroll() {
    if ($.fn.mCustomScrollbar) {
        destroySideScroll();
        if (!$('body').hasClass('sidebar-collapsed') && !$('body').hasClass('sidebar-collapsed') && !$('body').hasClass('submenu-hover') && $('body').hasClass('fixed-sidebar')) {
            $('.sidebar-inner').mCustomScrollbar({
                scrollButtons: {
                    enable: false
                },
                autoHideScrollbar: true,
                scrollInertia: 150,
                theme: "light-thin",
                advanced: {
                    updateOnContentResize: true
                }
            });
        }
        if ($('body').hasClass('sidebar-top')) {
            destroySideScroll();
        }
    }
}

/* Destroy sidebar custom scroll */
function destroySideScroll() {
    $('.sidebar-inner').mCustomScrollbar("destroy");
}

// Check if sidebar is collapsed
if ($('body').hasClass('sidebar-collapsed')) $('.nav-sidebar .children').css({
    display: ''
});
// Handles form inside of dropdown 
$('.dropdown-menu').find('form').click(function (e) {
    e.stopPropagation();
});
/***** Scroll to top button *****/
function scrollTop() {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });
    $('.scrollup').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 1000);
        return false;
    });
}

function sidebarBehaviour() {
    windowWidth = $(window).width();
    windowHeight = $(window).height() - $('.topbar').height();
    sidebarMenuHeight = $('.nav-sidebar').height();
    if (windowWidth < 1024) {
        $('body').removeClass('sidebar-collapsed');
    }
    if ($('body').hasClass('sidebar-collapsed') && sidebarMenuHeight > windowHeight) {
        $('body').removeClass('fixed-sidebar');
        destroySideScroll();
    }
}

/* ==========================================================*/
/* HOVER SCRIPTS                                             */
/* ========================================================= */

/* Sidebar Hover */
function sidebarHover(){

    if($('.logopanel2').length == 0){
        $('.topnav').prepend('<div class="logopanel2"><h1><a href="dashboard.html"></a></h1></div>');
    }

    if($('body').hasClass('rtl')) {
        $sidebar.css('margin-left', '').css('margin-right', '');
        $('.sidebar .sidebar-footer').css('left', '').css('right', '');
        $('html').on('mouseenter', 'body.rtl.sidebar-hover .sidebar', function(){
            TweenMax.to($sidebar, 0.35, { css: {marginRight: 0,opacity:1},ease: Circ.easeInOut,delay: 0});
            TweenMax.to($('.sidebar .sidebar-footer'), 0.35, {css: {right: 0,opacity:1},ease: Circ.easeInOut,delay: 0 });
        });
        $('html').on('mouseleave', 'body.rtl.sidebar-hover .sidebar', function(){
            if($body.hasClass('sidebar-condensed')) {
                TweenMax.to($sidebar, 0.35, {css: {marginRight: -170,opacity:0}, ease: Circ.easeInOut,delay: 0});
                TweenMax.to($('.sidebar .sidebar-footer'), 0.35, {css: {right: -170,opacity:0},ease: Circ.easeInOut,delay: 0});
            }
            else if($body.hasClass('sidebar-light')) {
                TweenMax.to($sidebar, 0.35, {css: {marginRight: -220,opacity:0}, ease: Circ.easeInOut,delay: 0});
                TweenMax.to($('.sidebar .sidebar-footer'), 0.35, {css: {right: -220,opacity:0},ease: Circ.easeInOut,delay: 0});
            }
            else{
                TweenMax.to($sidebar, 0.35, {css: {marginRight: -220,opacity:0}, ease: Circ.easeInOut,delay: 0});
                TweenMax.to($('.sidebar .sidebar-footer'), 0.35, {css: {right: -220,opacity:0},ease: Circ.easeInOut,delay: 0});
            }
        });
    }

    if(!$('body').hasClass('rtl'))  {
        $('html').on('mouseenter', 'body:not(.rtl).sidebar-hover .sidebar', function(){
            TweenMax.to($sidebar, 0.35, { css: {marginLeft: 0,opacity:1},ease: Circ.easeInOut,delay: 0});
            TweenMax.to($('.sidebar .sidebar-footer'), 0.35, {css: {left: 0,opacity:1},ease: Circ.easeInOut,delay: 0 });
        });
        $('html').on('mouseleave', 'body:not(.rtl).sidebar-hover .sidebar', function(){
            if($body.hasClass('sidebar-condensed')) {
                TweenMax.to($sidebar, 0.35, {css: {marginLeft: -170,opacity:0}, ease: Circ.easeInOut,delay: 0});
                TweenMax.to($('.sidebar .sidebar-footer'), 0.35, {css: {left: -170,opacity:0},ease: Circ.easeInOut,delay: 0});
            }
            else if($body.hasClass('sidebar-light')) {
                TweenMax.to($sidebar, 0.35, {css: {marginLeft: -220,opacity:0}, ease: Circ.easeInOut,delay: 0});
                TweenMax.to($('.sidebar .sidebar-footer'), 0.35, {css: {left: -220,opacity:0},ease: Circ.easeInOut,delay: 0});
            }
            else{
                TweenMax.to($sidebar, 0.35, {css: {marginLeft: -220,opacity:0}, ease: Circ.easeInOut,delay: 0});
                TweenMax.to($('.sidebar .sidebar-footer'), 0.35, {css: {left: -220,opacity:0},ease: Circ.easeInOut,delay: 0});
            }
        });
    }

};

function detectIE() {
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf('MSIE ');
    var trident = ua.indexOf('Trident/');
    var edge = ua.indexOf('Edge/');
    if (msie > 0 || trident > 0 || edge > 0) {
        $('html').addClass('ie-browser');
    }
}

/****  Initiation of Main Functions  ****/
$(document).ready(function () {
    createSideScroll();
    customScroll();
    handlePanelAction();
    scrollTop();
    sidebarBehaviour();
    detectIE();
    setTimeout(function () {
        handleboxedLayout();
    }, 100);
});
/****  Resize Event Functions  ****/

$(window).resize(function () {
    setTimeout(function () {
        customScroll();
        //reposition_topnav();
        if (!$('body').hasClass('fixed-sidebar') && !$('body').hasClass('builder-admin')) sidebarBehaviour();
        handleboxedLayout();
    }, 100);
});

