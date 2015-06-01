$(document).ready(function () {

    var city = "Alatyr'";
    var key = '0313908bbc748d05';
    var url = 'http://api.wunderground.com/api/' + key + '/geolookup/conditions/forecast/lang:RU/q/Russia/' + city + '.json';
    
    $.ajax({
        url: url,
        dataType: "jsonp",
        success: function (data) {
            
            var location = data['location']['city'];
            var temperature = Math.round(data['current_observation']['temp_c']) + '&deg;';
            if (temperature != 0) temperature = '+' + temperature;
            
            var pressure = Math.round(data['current_observation']['pressure_mb'] * 0.7500637554192)  + ' мм.';
            var wind = Math.round(data['current_observation']['wind_kph'] / 3.6) + ' м/с';
            var humidity = data['current_observation']['relative_humidity'];
            var visibility = data['current_observation']['visibility_km'] + ' км';
            var desc = data['current_observation']['weather'];
            var icon = data['current_observation']['icon_url'];
            var day = (data['current_observation']['observation_epoch'] * 1000);
            var date = 'По данным на ' + day;

            var arrayForecast = {};
            var days = data['forecast']['simpleforecast']['forecastday'];
            var objectNum = 0;
            var object = 0;
            var forecasts = data['forecast']['txt_forecast']['forecastday'];

            days.forEach(function(item, i, arr) {
                arrayForecast['weekday'] = arr['date']['weekday'];
                arrayForecast['day'] = arr['date']['day'] + ' ' + arr['date']['month'];
                object++;
            });

            forecasts.forEach(function(item, i, arr) {
                var period = arr['period'];

                if (period % 2) {
                    objectNum = ((period - 1) / 2);
                    arrayForecast[objectNum]['text_night'] = arr['fcttext_metric'];
                    arrayForecast[objectNum]['icon_url_night'] = arr['icon_url'];
                } else {
                    objectNum = ((period) / 2);
                    arrayForecast[objectNum]['text_day'] = arr['fcttext_metric'];
                    arrayForecast[objectNum]['icon_url_day'] = arr['icon_url'];
                }
            });

            arrayForecast.forEach(function(item, i, arr) {
                var conditions = arr['weekday'];

                var text_night = arr['text_night'];
                var text_day = arr['text_day'];
            });
            
            $('.weather-pressure').text(pressure);
            $('.weather-humidity').text(humidity);
            $('.weather-wind').text(wind);
            $('.weather-date').text(date);
            $('.weather-temp').html(temperature);
            $('.weather-vis').html(visibility);
            
            $('.weather-place').text(location);
            $('.weather-desc').text(desc);
            $('.weather-icon').attr('src', icon);
            
            //$('img.weather-icon').attr('title', conditions);

        }
    });
    
    $('.day1').click(function() {
        $.ajax({
            url: url,
            dataType: "jsonp",
            success: function (data) {
                alert('ok');
            }
        });
    });
    
    var targets = $( '[rel~=tooltip]' ),
        target  = false,
        tooltip = false,
        title   = false;
 
    targets.bind( 'mouseenter', function()
    {
        target  = $( this );
        tip     = target.attr( 'title' );
        tooltip = $( '<div id="tooltip"></div>' );
 
        if( !tip || tip == '' )
            return false;
 
        target.removeAttr( 'title' );
        tooltip.css( 'opacity', 0 )
               .html( tip )
               .appendTo( 'body' );
 
        var init_tooltip = function()
        {
            if( $( window ).width() < tooltip.outerWidth() * 1.5 )
                tooltip.css( 'max-width', $( window ).width() / 2 );
            else
                tooltip.css( 'max-width', 340 );
 
            var pos_left = target.offset().left + ( target.outerWidth() / 2 ) - ( tooltip.outerWidth() / 2 ),
                pos_top  = target.offset().top - tooltip.outerHeight() - 20;
 
            if( pos_left < 0 )
            {
                pos_left = target.offset().left + target.outerWidth() / 2 - 20;
                tooltip.addClass( 'left' );
            }
            else
                tooltip.removeClass( 'left' );
 
            if( pos_left + tooltip.outerWidth() > $( window ).width() )
            {
                pos_left = target.offset().left - tooltip.outerWidth() + target.outerWidth() / 2 + 20;
                tooltip.addClass( 'right' );
            }
            else
                tooltip.removeClass( 'right' );
 
            if( pos_top < 0 )
            {
                var pos_top  = target.offset().top + target.outerHeight();
                tooltip.addClass( 'top' );
            }
            else
                tooltip.removeClass( 'top' );
 
            tooltip.css( { left: pos_left, top: pos_top } )
                   .animate( { top: '+=10', opacity: 1 }, 50 );
        };
 
        init_tooltip();
        $( window ).resize( init_tooltip );
 
        var remove_tooltip = function()
        {
            tooltip.animate( { top: '-=10', opacity: 0 }, 50, function()
            {
                $( this ).remove();
            });
 
            target.attr( 'title', tip );
        };
 
        target.bind( 'mouseleave', remove_tooltip );
        tooltip.bind( 'click', remove_tooltip );
    });
});