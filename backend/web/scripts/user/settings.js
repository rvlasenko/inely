/**
 * @author hirootkit <admiralexo@gmail.com>
 */

var settings = (function() {
    'use strict';

    return {

        init: function() {
            this.events();
        },

        events: function() {
            $('.profile').click(function() {
                $.magnificPopup.open({
                    removalDelay: 300,
                    items: { src: '#user-settings' },
                    callbacks: {
                        beforeOpen: function() {
                            this.st.mainClass = 'mfp-zoomIn';
                        }
                    }
                });

                $('.chart').easyPieChart({
                    easing: 'easeOutBounce',
                    trackColor: 'rgba(0,0,0,0.3)',
                    scaleColor: 'transparent',
                    barColor: '#1c9ccd',
                    lineWidth: 6,
                    animate: 1300,
                    size: 176,
                    onStep: function(from, to, percent) {
                        $(this.el).find('.percent2').text(Math.round(percent));
                    }
                });
            });

            // Данные профиля заполняются по окончанию загрузки страницы
            $.get('/profile', function(data) {
                $('#user-settings').html(data);
            });

            // Сериализованные объекты ActiveForm. Альтернатива PJAX
            $(document).on('click', '#send-profile', function(e) {
                e.preventDefault();

                var profileData = $('form#user-settings').serializeArray();
                var accountData = $('form#account-settings').serializeArray();

                $.post('/user/profile', profileData).done(function() {
                    $.post('/user/account', accountData).done(function() {
                        noty({
                            text: 'Настройки были успешно сохранены!',
                            layout: 'topRight',
                            theme: 'relax',
                            type: 'success',
                            animation: {
                                open:  'animated fadeIn',
                                close: 'animated fadeOut'
                            }
                        });
                    });
                });
            });
        }
    };
})();