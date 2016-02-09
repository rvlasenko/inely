common\components\formatter\FormatterComponent
===============






* Class name: FormatterComponent
* Namespace: common\components\formatter
* Parent class: yii\i18n\Formatter







Methods
-------


### isToday

    boolean common\components\formatter\FormatterComponent::isToday(string $date)

Возвращает true, если принятая дата является сегодняшним днем.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $date **string** - &lt;p&gt;Unix timestamp&lt;/p&gt;



### wasYesterday

    boolean common\components\formatter\FormatterComponent::wasYesterday(string $date)

Возвращает true, если принятая дата является вчерашним днем.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $date **string** - &lt;p&gt;Unix timestamp&lt;/p&gt;



### asRelativeDate

    string common\components\formatter\FormatterComponent::asRelativeDate(\DateTime $value, \DateTime $referenceTime)

Форматирование значения как интервал времени между датой и настоящим временем в читабельной форме.

Если интервал дней составляет больше 7 то указывается абсолютная дата '6 окт.' иначе выставляется
относительный формат eg. 'через 3 дня' для улучшенной читаемости.
В случаях с годом и месяцем указывается только абсолютная дата.

* Visibility: **public**


#### Arguments
* $value **DateTime** - &lt;p&gt;значение, которое нужно отформатировать.&lt;/p&gt;
* $referenceTime **DateTime** - &lt;p&gt;значение, которое будет использоваться вместо настоящего времени.&lt;/p&gt;



### dateLeft

    string common\components\formatter\FormatterComponent::dateLeft(\DateTime|\DateInterval $value, \DateTime $referenceTime)

Форматирование значения как оставшийся интервал времени в читабельной форме.



* Visibility: **public**


#### Arguments
* $value **DateTime|DateInterval** - &lt;p&gt;значение, которое нужно отформатировать.&lt;/p&gt;
* $referenceTime **DateTime** - &lt;p&gt;значение, которое будет использоваться вместо настоящего времени.&lt;/p&gt;



### timeInWords

    string common\components\formatter\FormatterComponent::timeInWords(string $dateTime)

Возвращает либо относительную дату либо дату, отформатированную в зависимости
от разницы между текущим временем и принятой датой.

$dateTime должен быть в формате, подобному типу данных datetime в MySQL.

* Visibility: **public**


#### Arguments
* $dateTime **string** - &lt;p&gt;Datetime строка&lt;/p&gt;


