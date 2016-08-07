<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\DraftPlanProses;

/**
 * DraftPlanProsesSearch represents the model behind the search form about `lukisongroup\master\models\DraftPlanProses`.
 */
class DraftPlanProsesSearch extends DraftPlanProses
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PROSES_ID'], 'integer'],
            [['PROSES_NM', 'DCRIPT'], 'safe'],
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
        $query = DraftPlanProses::find();

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
            'PROSES_ID' => $this->PROSES_ID,
        ]);

        $query->andFilterWhere(['like', 'PROSES_NM', $this->PROSES_NM])
            ->andFilterWhere(['like', 'DCRIPT', $this->DCRIPT]);

        return $dataProvider;
    }
}
