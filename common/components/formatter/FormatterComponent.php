<?php

namespace common\components\formatter;

use DateInterval;
use DateTime;
use DateTimeZone;
use Yii;
use yii\i18n\Formatter;

class FormatterComponent extends Formatter
{
    /**
     * Возвращает true, если принятая дата является сегодняшним днем.
     *
     * @param string $date Unix timestamp
     *
     * @return boolean true, если сегодня
     */
    public static function isToday($date)
    {
        return date('Y-m-d', $date) == date('Y-m-d', time());
    }

    /**
     * Возвращает true, если принятая дата является вчерашним днем.
     *
     * @param string $date Unix timestamp
     *
     * @return boolean true, если вчера
     */
    public static function wasYesterday($date)
    {
        return date('Y-m-d', $date) == date('Y-m-d', strtotime('yesterday'));
    }

    /**
     * Форматирование значения как интервал времени между датой и настоящим временем в читабельной форме.
     *
     * Если интервал дней составляет больше 7 то указывается абсолютная дата '6 окт.' иначе выставляется
     * относительный формат eg. 'через 3 дня' для улучшенной читаемости.
     * В случаях с годом и месяцем указывается только абсолютная дата.
     *
     * @param DateTime $value         значение, которое нужно отформатировать.
     * @param DateTime $referenceTime значение, которое будет использоваться вместо настоящего времени.
     *
     * @return string отформатированная строка.
     * @throws InvalidParamException если входное значение не может быть оценено как значение даты.
     */
    public function asRelativeDate($value, $referenceTime = null)
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof DateInterval) {
            $interval = $value;
        } else {
            $timestamp = $this->normalizeDatetimeValue($value);

            if ($timestamp === false) {
                try {
                    $interval = new DateInterval($value);
                } catch (\Exception $e) {
                    return $this->nullDisplay;
                }
            } else {
                $timeZone = new DateTimeZone($this->timeZone);

                if ($referenceTime === null) {
                    $dateNow = new DateTime('now', $timeZone);
                } else {
                    $dateNow = $this->normalizeDatetimeValue($referenceTime);
                    $dateNow->setTimezone($timeZone);
                }

                $dateThen = $timestamp->setTimezone($timeZone);

                $interval = $dateThen->diff($dateNow);
            }
        }

        if ($interval->invert) {
            if ($interval->y >= 1) {
                return Yii::$app->formatter->asDate($value, 'd MMM');
            }
            if ($interval->m >= 1) {
                return Yii::$app->formatter->asDate($value, 'd MMM');
            }
            if ($interval->d <= 7) {
                return Yii::t('backend', '{delta, plural, =1{a day} other{in # days}}', ['delta' => $interval->d], $this->locale);
            }
            elseif ($interval->d >= 1) {
                return Yii::$app->formatter->asDate($value, 'd MMM');
            }
            if ($interval->s == 0) {
                return Yii::t('backend', 'today', [], $this->locale);
            }
            return Yii::t('yii', 'in {delta, plural, =1{a second} other{# seconds}}', ['delta' => $interval->s], $this->locale);
        } else {
            if ($interval->y >= 1) {
                return Yii::t('yii', '{delta, plural, =1{a year} other{# years}} ago', ['delta' => $interval->y], $this->locale);
            }
            if ($interval->m >= 1) {
                return Yii::t('yii', '{delta, plural, =1{a month} other{# months}} ago', ['delta' => $interval->m], $this->locale);
            }
            if ($interval->d >= 1) {
                return Yii::t('backend', '{delta, plural, =1{yesterday} other{in # days}} ago', ['delta' => $interval->d], $this->locale);
            }
            if ($interval->s == 0) {
                return Yii::t('backend', 'today', [], $this->locale);
            }
            return Yii::t('yii', '{delta, plural, =1{a second} other{# seconds}} ago', ['delta' => $interval->s], $this->locale);
        }
    }

    /**
     * Форматирование значения как оставшийся интервал времени в читабельной форме.
     *
     * @param DateTime|DateInterval $value         значение, которое нужно отформатировать.
     * @param DateTime              $referenceTime значение, которое будет использоваться вместо настоящего времени.
     *
     * @return string отформатированная строка.
     * @throws InvalidParamException если входное значение не может быть оценено как значение даты.
     */
    public function dateLeft($value, $referenceTime = null)
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof DateInterval) {
            $interval = $value;
        } else {
            $timestamp = $this->normalizeDatetimeValue($value);

            if ($timestamp === false) {
                try {
                    $interval = new DateInterval($value);
                } catch (\Exception $e) {
                    return $this->nullDisplay;
                }
            } else {
                $timeZone = new DateTimeZone($this->timeZone);

                if ($referenceTime === null) {
                    $dateNow = new DateTime('now', $timeZone);
                } else {
                    $dateNow = $this->normalizeDatetimeValue($referenceTime);
                    $dateNow->setTimezone($timeZone);
                }

                $dateThen = $timestamp->setTimezone($timeZone);

                $interval = $dateThen->diff($dateNow);
            }
        }

        if ($interval->invert) {
            if ($interval->y >= 1) {
                return Yii::t('yii', 'in {delta, plural, =1{a year} other{# years}}', ['delta' => $interval->y], $this->locale);
            }
            if ($interval->m >= 1) {
                return Yii::t('yii', 'in {delta, plural, =1{a month} other{# months}}', ['delta' => $interval->m], $this->locale);
            }
            if ($interval->d <= 7) {
                return Yii::$app->formatter->asDate($value, 'd MMM');
            }
            elseif ($interval->d >= 1) {
                return Yii::t('yii', 'in {delta, plural, =1{a day} other{# days}}', ['delta' => $interval->d], $this->locale);
            }
            if ($interval->s == 0) {
                return Yii::t('yii', 'just now', [], $this->locale);
            }
            return Yii::t('yii', 'in {delta, plural, =1{a second} other{# seconds}}', ['delta' => $interval->s], $this->locale);
        } else {
            if ($interval->y >= 1) {
                return Yii::t('yii', '{delta, plural, =1{a year} other{# years}} ago', ['delta' => $interval->y], $this->locale);
            }
            if ($interval->m >= 1) {
                return Yii::t('yii', '{delta, plural, =1{a month} other{# months}} ago', ['delta' => $interval->m], $this->locale);
            }
            if ($interval->d >= 1) {
                return Yii::t('yii', '{delta, plural, =1{a day} other{# days}} ago', ['delta' => $interval->d], $this->locale);
            }
            if ($interval->s == 0) {
                return Yii::t('yii', 'just now', [], $this->locale);
            }
            return Yii::t('yii', '{delta, plural, =1{a second} other{# seconds}} ago', ['delta' => $interval->s], $this->locale);
        }
    }

    /**
     * Возвращает либо относительную дату либо дату, отформатированную в зависимости
     * от разницы между текущим временем и принятой датой.
     * $dateTime должен быть в формате, подобному типу данных datetime в MySQL.
     *
     * @param string $dateTime Datetime строка
     *
     * @return string Относительное время
     */
    public function timeInWords($dateTime)
    {
        $now    = time();
        $future = null;
        $past   = null;

        if (is_int($dateTime)) {
            $inSeconds = $dateTime;
        } else {
            $inSeconds = strtotime($dateTime);
        }

        $backwards = ($inSeconds > $now);
        $end       = '+1 month';

        if ($backwards) {
            $futureTime = $inSeconds;
            $pastTime   = $now;
        } else {
            $futureTime = $now;
            $pastTime   = $inSeconds;
        }
        $diff = $futureTime - $pastTime;

        // Если более чем неделя, значит нужно учитывать длину месяцев
        if ($diff >= 604800) {

            list($future['H'], $future['i'], $future['s'], $future['d'], $future['m'], $future['Y']) = explode('/', date('H/i/s/d/m/Y', $futureTime));

            list($past['H'], $past['i'], $past['s'], $past['d'], $past['m'], $past['Y']) = explode('/', date('H/i/s/d/m/Y', $pastTime));
            $years = $weeks = $minutes = 0;

            if ($future['Y'] == $past['Y'] && $future['m'] == $past['m']) {
                $months = 0;
                $years  = 0;
            } else {
                if ($future['Y'] == $past['Y']) {
                    $months = $future['m'] - $past['m'];
                } else {
                    $years  = $future['Y'] - $past['Y'];
                    $months = $future['m'] + ((12 * $years) - $past['m']);

                    if ($months >= 12) {
                        $years  = floor($months / 12);
                        $months = $months - ($years * 12);
                    }

                    if ($future['m'] < $past['m'] && $future['Y'] - $past['Y'] == 1) {
                        $years--;
                    }
                }
            }

            if ($future['d'] >= $past['d']) {
                $days = $future['d'] - $past['d'];
            } else {
                $daysInPastMonth   = date('t', $pastTime);
                $daysInFutureMonth = date('t', mktime(0, 0, 0, $future['m'] - 1, 1, $future['Y']));

                if (!$backwards) {
                    $days = ($daysInPastMonth - $past['d']) + $future['d'];
                } else {
                    $days = ($daysInFutureMonth - $past['d']) + $future['d'];
                }

                if ($future['m'] != $past['m']) {
                    $months--;
                }
            }

            if ($months == 0 && $years >= 1 && $diff < ($years * 31536000)) {
                $months = 11;
                $years--;
            }

            if ($months >= 12) {
                $years  = $years + 1;
                $months = $months - 12;
            }

            if ($days >= 7) {
                $weeks = floor($days / 7);
                $days  = $days - ($weeks * 7);
            }
        } else {
            $years = $months = $weeks = 0;
            $days  = floor($diff / 86400);

            $diff = $diff - ($days * 86400);

            $hours = floor($diff / 3600);
            $diff  = $diff - ($hours * 3600);

            $minutes = floor($diff / 60);
        }
        $relativeDate = '';
        $diff         = $futureTime - $pastTime;

        if ($diff > abs($now - strtotime($end))) {
            $relativeDate = 'future';
        } else {
            if (self::isToday($inSeconds)) {
                $relativeDate = 'today';
                $backwards    = true;
            } elseif (self::wasYesterday($inSeconds)) {
                $relativeDate = 'last';
                $backwards    = true;
            } elseif ($years > 0 || abs($months) > 0 || abs($weeks) > 0 || abs($days) > 0 || abs($minutes) > 0) {
                $relativeDate = 'future';
            }

            if (!$backwards) {
                $relativeDate = 'last';
            }
        }

        return $relativeDate;
    }
}
