;(function($) {

    $.fn.openWeather  = function(options) {
    
    	//return if no element was bound
		//so chained events can continue
		if(!this.length) { 
			return this; 
		}

		//define default parameters
        var defaults = {
        	descriptionTarget: null,
        	maxTemperatureTarget: null,
        	minTemperatureTarget: null,
        	windSpeedTarget: null,
            windDegTarget: null,
        	humidityTarget: null,
        	sunriseTarget: null,
        	sunsetTarget: null,
        	placeTarget: null,
        	iconTarget: null,
            cloudTarget: null,
        	customIcons: null,
            pressureTarget: null,
            dewTarget: null,
            city: null,
            lat: null,
            lng: null,
            key: null,
            lang: 'ru',
            success: function() {},
            error: function(message) {} 
        }

        //define plugin
        var plugin = this;

        //define element
        var el = $(this);
        
        //api URL
        var weatherURL;

        //define settings
        plugin.settings = {}
 
        //merge defaults and options
        plugin.settings = $.extend({}, defaults, options);
        
        //define settings namespace
        var s = plugin.settings;
        
        //define basic api endpoint
        weatherURL = 'http://api.wunderground.com/api/' + s.key + '/geolookup/forecast/lang:RU/q/Russia/' + s.city + '.json';
        
        $.ajax({
	        type: 'GET',
	        url: weatherURL,
	        dataType: 'jsonp',
	        success: function(data) {
	        	
	        	//define temperature as celsius
		        var temperature = Math.round(data.main.temp) + '<sup>°C</sup>';
		        	
	        	//set temperature
	        	el.html(temperature);
	        	
	        	//set weather description
	        	$(s.descriptionTarget).text(data.weather[0].description);
	        	
	        	//if iconTarget and default weather icon aren't null
			    if(s.iconTarget != null && data.weather[0].icon != null) {
	        	
		        	//if customIcons isn't null
		        	if(s.customIcons == null) {
		        	
		        		//define the default icon name
		        		var defaultIconFileName = data.weather[0].icon;
		        		
		        		var iconName;
		        		
		        		var timeOfDay;
		        		
		        		// if icon is clear sky
		        		if (defaultIconFileName == '01d')
		        			iconName = 'wi wi-day-sunny weather-icon';
                        
                        // if icon is clear night
                        if (defaultIconFileName == '01n')
                            iconName = 'wi wi-night-clear weather-icon';
		        		
		        		// if icon is clouds
		        		if (defaultIconFileName == '02d' || defaultIconFileName == '03d' || defaultIconFileName == '03n' || defaultIconFileName == '04d' || defaultIconFileName == '04n')
		        			//iconName = 'wi wi-cloudy weather-icon';
                            iconName = 'cloudy';
                        
                        if (defaultIconFileName == '02n')
                            iconName = 'wi wi-night-cloudy weather-icon';
                            
		        		
		        		// if icon is rain
		        		if (defaultIconFileName == '09d' || defaultIconFileName == '09n' || defaultIconFileName == '10d' || defaultIconFileName == '10n')
		        			iconName = 'wi wi-rain weather-icon';
		        		
		        		// if icon is thunderstorm
		        		if (defaultIconFileName == '11d' || defaultIconFileName == '11n')
		        			iconName = 'wi wi-thunderstorm weather-icon';
		        		
		        		// if icon is snow
		        		if (defaultIconFileName == '13d' || defaultIconFileName == '13n')
		        			iconName = 'wi wi-snow weather-icon';
			        		
		        		// if icon is mist
		        		if (defaultIconFileName == '50d' || defaultIconFileName == '50n')
		        			iconName = 'wi wi-fog weather-icon';
		        		
		        	}
                    
		        	// set iconTarget src attribute as iconURL
			        $(s.iconTarget).attr('src', iconName);
		        		
		        }
	        	
	        	// if placeTarget isn't null
	        	if (s.placeTarget != null) {
		        	
		        	// set humidity
		        	$(s.placeTarget).text(data.name + ', ' + data.sys.country);
	        	}
	        	
	        	//run success callback
	        	s.success.call(this);
		        
	        },
	        
        });//ajax
        
        
    }//fn

})(jQuery);