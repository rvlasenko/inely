<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Task;

/**
 * TaskSearch represents the model behind the search form about `frontend\modules\user\models\Task`.
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Task::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'isDone' => $this->isDone,
        ]);

        $query->andFilterWhere([
            'author' => Yii::$app->user->id
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'time', $this->time]);

        return $dataProvider;
    }

    public function searchByCat($id)
    {
        $query = Task::find();

        $dataProvider = new ActiveDataProvider(['query' => $query]);

        $query
            ->andFilterWhere(['author' => Yii::$app->user->id])
            ->andFilterWhere(['category' => $id]);

        return $dataProvider;
    }
}
