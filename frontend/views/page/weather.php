<?php
    $city = "Alatyr'";
    $key = "0313908bbc748d05";
    $url = "http://api.wunderground.com/api/$key/geolookup/conditions/forecast/lang:RU/q/Russia/$city.json";

    $jsonString = file_get_contents($url);
    $parsedJson = json_decode($jsonString);
    $location = $parsedJson->{'location'}->{'city'};
    $parsedСonditions = $parsedJson->{'current_observation'};

    $temp = intval($parsedСonditions->{'temp_c'}) . '&deg;';
    if ($temp != 0) $temp = "+$temp";
    $pressure = round(intval($parsedСonditions->{'pressure_mb'}) * 0.7500637554192) . ' мм.';
    $wind = round(intval($parsedСonditions->{'wind_kph'}) / 3.6) . ' м/с';
    $humidity = $parsedСonditions->{'relative_humidity'};
    $visibility = $parsedСonditions->{'visibility_km'} . ' км';
    $desc = $parsedСonditions->{'weather'};
    $icon_url = $parsedСonditions->{'icon_url'};
?>

<div class="panel panel-white">
    <div class="panel-header">
        <h3><i class="icon-umbrella"></i>
            <strong>Weather</strong></h3>
        <div class="control-btn">
            <a href="#" class="panel-reload"><i class="icon-reload"></i></a>
        </div>
    </div>
    <div class="panel-body p-15 p-b-0">
        <div class="weather-widget">
            <div class="row">
                <div class="col-md-12">
                    <div class="weather-top">
                        <div class="weather-current pull-left">
                            <img class="weather-icon" src="<?= $icon_url ?>">
                            <p><span><?= $temp ?></span></p>
                        </div>
                        <h2 class="pull-right"><span><?= $location ?></span><br>
                            <small><?= $desc ?></small>
                        </h2>
                    </div>
                </div>
                <p class="weather-date"></p>
                <div class="col-md-6">
                    <ul class="list-unstyled weather-info">
                        <li>Видимость
                            <span class="pull-right"><b><?= $visibility ?></b></span>
                        </li>
                        <li>Давление
                            <span class="pull-right"><b><?= $pressure ?></b></span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled weather-info">
                        <li>Ветер
                            <span class="pull-right"><b><?= $wind ?></b></span>
                        </li>
                        <li>Влажность
                            <span class="pull-right"><b><?= $humidity ?></b></span>
                        </li>
                    </ul>
                </div>
                <p class="desc"></p>
                <div class="col-md-12">
                    <ul class="list-unstyled weather-days row">
                        <a href="#" class="day1">
                            <li class="col-xs-4 col-sm-2"><span>12:00</span>
                                <i class="wi wi-day-cloudy"></i><span>82<sup>°F</sup></span>
                            </li>
                        </a>
                        <a href="#" class="day2">
                            <li class="col-xs-4 col-sm-2"><span>13:00</span>
                                <i class="wi wi-day-cloudy"></i><span>82<sup>°F</sup></span>
                            </li>
                        </a>
                        <a href="#" class="day3">
                            <li class="col-xs-4 col-sm-2"><span>14:00</span>
                                <i class="wi wi-day-cloudy"></i><span>82<sup>°F</sup></span>
                            </li>
                        </a>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>