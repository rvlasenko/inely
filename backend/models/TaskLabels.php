<?php

/**
 * Эта модель является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace backend\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;

/**
 * Класс модели для таблицы "task_labels".
 *
 * @property integer $labelId
 * @property integer $ownerId
 * @property string $labelName
 * @property string $badgeColor
 */
class TaskLabels extends ActiveRecord
{
    public static function tableName()
    {
        return 'task_labels';
    }

    public function rules()
    {
        return [
            [['ownerId'], 'default', 'value' => Yii::$app->user->id],
            [['ownerId'], 'integer'],
            [['taskId'], 'integer'],
            [['labelName', 'badgeColor'], 'string']
        ];
    }

    /**
     * Установка к задаче контекстной метки во внешнюю таблицу, при наличии.
     *
     * @param array $data Атрибуты для метки, ID задачи и название метки
     *
     * @return bool если сохранение завершилось успешно
     * @throws Exception при ошибке сохранения и валидации данных
     */
    public function setLabel(array $data)
    {
        $labelModel = new TaskLabels();

        $labelData = [
            'ownerId'    => Yii::$app->user->id,
            'taskId'     => $data['taskPK'],
            'labelName'  => $data['labelName'],
            'badgeColor' => 'first'
        ];

        if ($labelModel->load($labelData) && !$labelModel->insert()) {
            throw new Exception('Невозможно сохранить данные');
        }
    }

    /**
     * Запись данных в модель. Метод перегружен от базового класса Model.
     * @param array|boolean $data массив данных.
     * @param string $formName имя формы, использующееся для записи данных в модель.
     * @return boolean если `$data` содержит некие данные, которые связываются с атрибутами модели.
     */
    public function load($data, $formName = '')
    {
        $scope = $formName === null ? $this->formName() : $formName;
        if ($scope === '' && !empty($data)) {
            $this->setAttributes($data);

            return true;
        } elseif (isset($data[$scope])) {
            $this->setAttributes($data[$scope]);

            return true;
        } else {
            return false;
        }
    }
}
