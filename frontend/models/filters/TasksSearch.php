<?php

namespace frontend\models\filters;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\tables\Tasks;

/**
 * TasksSearch represents the model behind the search form of `app\models\tables\Tasks`.
 */
class TasksSearch extends Tasks
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'creator_id', 'responsible_id', 'status_id'], 'integer'],
            [['name', 'description', 'deadline'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Tasks::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'creator_id' => $this->creator_id,
            'deadline' => $this->deadline,
            'responsible_id' => $this->responsible_id,
            'status_id' => $this->status_id,
        ]);

        $month = $_GET['TasksSearch']['month'];

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(["MONTH(deadline)" => $month]);

        return $dataProvider;
    }

    public function getMonth()
    {
        $dataProvider = Tasks::find()->where("MONTH(deadline) = 2");
        return $dataProvider;

//        findBySql("SELECT * from tasks WHERE MONTH(deadline) = 2");
    }
}
