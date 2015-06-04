<?php
    $city = "Alatyr'";
    $key = "0313908bbc748d05";
    $url = "http://api.wunderground.com/api/$key/geolookup/conditions/forecast/lang:RU/q/Russia/$city.json";
    $num = 1;
    $object = 0;
    $forecastDays = [];
    $arrayForecast = [];

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
    $iconUrl = $parsedСonditions->{'icon_url'};

    $week = [
        "Sunday" => "воскресенье",
        "Monday" => "понедельник",
        "Tuesday" => "вторник",
        "Wednesday" => "среду",
        "Thursday" => "четверг",
        "Friday" => "пятницу",
        "Saturday" => "субботу"
    ];

    $month = [
        1 => "января",
        2 => "февраля",
        3 => "марта",
        4 => "апреля",
        5 => "мая",
        6 => "июня",
        7 => "июля",
        8 => "августа",
        9 => "сентября",
        10 => "октября",
        11 => "ноября",
        12 => "декабря",
    ];

    $forecastDays = $parsedJson->{'forecast'}->{'simpleforecast'}->{'forecastday'};
    foreach ($forecastDays as $forecastDay) {
        $arrayForecast[$object]['weekday'] = $forecastDay->{'date'}->{'weekday'};
        $arrayForecast[$object]['day'] = $forecastDay->{'date'}->{'day'} . " " . $month[$forecastDay->{'date'}->{'month'}];
        $arrayForecast[$object]['temp_high'] = $forecastDay->{'high'}->{'celsius'};
        $arrayForecast[$object]['temp_low'] = $forecastDay->{'low'}->{'celsius'};
        $arrayForecast[$object]['icon_url'] = $forecastDay->{'icon_url'};
        $object++;
    }

    $forecasts = $parsedJson->{'forecast'}->{'txt_forecast'}->{'forecastday'};
    foreach ($forecasts as $forecast) {
        $period = $forecast->{'period'};
        if ($period % 2) {
            $objectNum = intval(($period - 1) / 2);
            $arrayForecast[$objectNum]['text_night'] = $forecast->{'fcttext_metric'};
            $arrayForecast[$objectNum]['icon_url_night'] = $forecast->{'icon_url'};
        } else {
            $objectNum = intval(($period) / 2);
            $arrayForecast[$objectNum]['text_day'] = $forecast->{'fcttext_metric'};
            $arrayForecast[$objectNum]['icon_url_day'] = $forecast->{'icon_url'};
        }
    }


?>

<div class="panel panel-white">
    <div class="panel-header">
        <h3><i class="icon-umbrella"></i>
            <strong>Weather</strong></h3>
        <div class="control-btn">
            <a href="#" class="panel-reload"><i class="icon-reload"></i></a>
        </div>
    </div>
    <div class="panel-body p-10 p-b-0">
        <div class="weather-widget">
            <div class="row">
                <div class="col-md-12">
                    <div class="weather-top">
                        <div class="weather-current pull-left">
                            <img class="weather-icon" src="<?= $iconUrl ?>">
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
                <div class="main col-md-12">
                    <p class="desc">
                        <?= $arrayForecast[0]['weekday'] ?>, <?= $arrayForecast[0]['day'] ?>
                    </p>
                    <p>
                        <img class="weather-icon" src="<?= $arrayForecast[0]['icon_url_day'] ?>">
                        <?= $arrayForecast[0]['text_day'] ?>
                    </p>
                    <p>
                        <img class="weather-icon" src="<?= $arrayForecast[0]['icon_url_night'] ?>">
                        <?= $arrayForecast[0]['text_night'] ?>
                    </p>
                </div>
                    <?php foreach ($arrayForecast as $forecastObj): ?>

                    <div id="day-<?= $num++ ?>" style="display: none">

                        <p class="desc">
                            <?= $forecastObj['weekday'] ?>, <?= $forecastObj['day'] ?>
                        </p>
                        <p>
                            <img class="weather-icon" src="<?= $forecastObj['icon_url_day'] ?>">
                            <?= $forecastObj['text_day'] ?>
                        </p>
                        <p>
                            <img class="weather-icon" src="<?= $forecastObj['icon_url_night'] ?>">
                            <?= $forecastObj['text_night'] ?>
                        </p>

                    </div>

                    <?php endforeach; ?>
                <div class="col-md-12">
                    <ul class="list-unstyled weather-days row">
                        <?php unset($num); foreach ($arrayForecast as $forecastObj): ?>

                        <li class="col-xs-4 col-sm-2">
                            <span><?= $forecastObj['weekday'] ?></span>
                            <a href="#day-<?= ++$num ?>" class="day"><img class="weather-icon" src="<?= $forecastObj['icon_url'] ?>"></a>
                            <span><?= $forecastObj['temp_low'] ?><sup>&deg;</sup> &ndash; <?= $forecastObj['temp_high'] ?><sup>&deg;</sup></span>
                        </li>

                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>