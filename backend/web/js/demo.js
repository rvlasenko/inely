'use strict';
/*! main.js - v0.1.1
 * http://admindesigns.com/
 * Copyright (c) 2013 Admin Designs;*/

/* Demo theme functions. Required for
 * Settings Pane and misc functions */
var Demo = function () {

    // Demo Header Functions
    var runDemoTopbar = function () {

        // Init jQuery Multi-Select
        if ($("#topbar-multiple").length) {
            $('#topbar-multiple').multiselect({
                buttonClass: 'btn btn-default btn-sm ph15',
                dropRight  : true
            });
        }

    };

    // DEMO FUNCTIONS - primarily trash
    var runDemoSettings = function () {

        if ($('#skin-toolbox').length) {

            // Toggles Theme Settings Tray
            $('#skin-toolbox .panel-heading').on('click', function () {
                $('#skin-toolbox').toggleClass('toolbox-open');
            });
            // Disable text selection
            $('#skin-toolbox .panel-heading').disableSelection();

            // Cache component elements
            var Header = $('.navbar');
            var Branding = Header.children('.navbar-branding');

            // Possible Component Skins
            var headerSkins = "bg-primary bg-success bg-info bg-warning bg-alert bg-system bg-dark bg-light";

            // Theme Settings
            var settingsObj = {
                'headerSkin': 'bg-light'
            };

            // Local Storage Theme Key
            var themeKey = 'admin-settings';

            // Local Storage Theme Get
            var themeGet = localStorage.getItem(themeKey);

            // Set new key if one doesn't exist
            if (themeGet === null) {
                localStorage.setItem(themeKey, JSON.stringify(settingsObj));
                themeGet = localStorage.getItem(themeKey);
            }

            // Restore Theme Settings from Local Storage Key
            (function () {

                var settingsParse = JSON.parse(themeGet);
                settingsObj = settingsParse;

                $.each(settingsParse, function (i, e) {
                    switch (i) {
                        case 'headerSkin':
                            Header.removeClass(headerSkins).addClass(e);
                            Branding.removeClass(headerSkins).addClass(e + ' dark');

                            // if (settingsObj['headerTone'] === true) {
                            // 	Branding.addClass('dark');
                            // }

                            if (e === "bg-light") {
                                Branding.removeClass(headerSkins);
                            }
                            else {
                                Branding.removeClass(headerSkins).addClass(e);
                            }

                            $('#toolbox-header-skin input[value="bg-light"]').prop('checked', false);
                            $('#toolbox-header-skin input[value="' + e + '"]').prop('checked', true);
                            break;
                    }
                });

            })();
        }

    };

    var runDemoCache = function () {

        $(window).load(function () {

            // List of all available JS files. We're going to attempt to
            // cache them all after the first page has finished loading.
            // This is for DEMO purposes ONLY
            var scripts = {

                // HIGH PRIORITY - Images
                image1: 'assets/img/stock/1.jpg',
                image2: 'assets/img/stock/2.jpg',
                image3: 'assets/img/stock/3.jpg',
                image4: 'assets/img/stock/4.jpg',
                image5: 'assets/img/stock/5.jpg',

                bg1       : 'assets/img/patterns/backgrounds/1.jpg',

                // HIGH PRIORITY - Admin Tools Assets
                adminform : 'assets/admin-tools/admin-forms/css/admin-forms.css',
                adminpanel: 'assets/admin-tools/admin-plugins/admin-panels/adminpanels.css',
                adminmodal: 'assets/admin-tools/admin-plugins/admin-modal/adminmodal.css',
                admindock : 'assets/admin-tools/admin-plugins/admin-dock/dockmodal.css'

            };

            var cacheCheck = function (o) {

                // Local Storage Theme Key
                var cacheKey = 'cache-observes';

                // Local Storage Theme Get
                var cacheGet = localStorage.getItem(cacheKey);

                // Set new key if one doesn't exist
                if (cacheGet === null) {
                    localStorage.setItem(cacheKey, "");
                    cacheGet = localStorage.getItem(cacheKey);
                }

                // Parse LocalStorage data
                // var checkedCache = JSON.parse(cacheGet);

                // Do something with returned data
                // console.log('Key contains: ', cacheGet);

                $.each(o, function (i, p) {

                    if (localStorage.getItem(i) !== 'cached') {
                        $.ajax({
                            url    : p,
                            cache  : true,
                            success: function (data) {
                                localStorage.setItem(i, 'cached');
                                console.log(localStorage.getItem(i));
                            }
                        });

                    } else {
                    }
                });
            };
            // DISABLED BY DEFAULT
            // cacheCheck(scripts);
        });
    };

    var runFullscreenDemo = function () {

        // Fullscreen Functionality
        var screenCheck = $.fullscreen.isNativelySupported();

        // Attach handler to navbar fullscreen button
        $('.request-fullscreen').click(function () {

            // Check for fullscreen browser support
            if (screenCheck) {
                if ($.fullscreen.isFullScreen()) {
                    $.fullscreen.exit();
                } else {
                    $('html').fullscreen({
                        overflow: 'visible'
                    });
                }
            } else {
                alert('Your browser does not support fullscreen mode.')
            }
        });

    };

    return {
        init: function () {
            runDemoSettings();
            runDemoCache();
            runFullscreenDemo();
        }
    }
}();
