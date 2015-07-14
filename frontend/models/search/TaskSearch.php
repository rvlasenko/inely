<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Task;

/**
 * TaskSearch represents the model behind the search form about `frontend\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'isDone'], 'integer'],
            [['name', 'priority', 'time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
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

        if (!$this->validate())
            return $dataProvider;

        if ($catId != false)
            $query->andFilterWhere(['category' => $id]);

        $query->andFilterWhere(['isDone' => $this->isDone]);

        $query->andFilterWhere(['author' => Yii::$app->user->id]);

        $query->andFilterWhere(['like', 'name', $this->name])
              ->andFilterWhere(['like', 'time', $this->time]);

        return $dataProvider;
    }
}
