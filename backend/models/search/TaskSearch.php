<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Task;

/**
 * TaskSearch represents the model behind the search form about `frontend\models\Task`.
 */
class TaskSearch extends Task
{
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param bool $catId
     *
     * @return ActiveDataProvider
     */
    public function search($params, $catId = false)
    {
        $query = Task::find();

        $dataProvider = new ActiveDataProvider(['query' => $query]);

        $this->load($params);

        if ($catId !== false)
            $query->andFilterWhere(['list' => $catId]);

        $query->andFilterWhere(['author' => Yii::$app->user->id]);

        return $dataProvider;
    }
}
