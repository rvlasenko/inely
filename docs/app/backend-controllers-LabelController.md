backend\controllers\LabelController
===============

Class LabelController




* Class name: LabelController
* Namespace: backend\controllers
* Parent class: yii\web\Controller







Methods
-------


### behaviors

    mixed backend\controllers\LabelController::behaviors()





* Visibility: **public**




### actionEdit

    boolean backend\controllers\LabelController::actionEdit()

Валидация принятых атрибутов и добавление их значений в соответствующие поля базы данных.

В случае несоответствия формату, поле игнорируется и выбрасывается исключение.

* Visibility: **public**




### actionCreate

    array backend\controllers\LabelController::actionCreate()

Создание новой метки.



* Visibility: **public**




### actionDelete

    boolean backend\controllers\LabelController::actionDelete()

Удаление существующей метки.



* Visibility: **public**




### findModel

    \backend\controllers\модель backend\controllers\LabelController::findModel(integer $id)

Поиск модели пользователя по его PK.

Если модель не найдена, будет сгенерировано исключение.

* Visibility: **protected**


#### Arguments
* $id **integer**


