<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\DraftPlanDetail;

/**
 * DraftPlanDetailSearch represents the model behind the search form about `lukisongroup\master\models\DraftPlanDetail`.
 */
class DraftPlanDetailSearch extends DraftPlanDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'SCDL_GROUP', 'STATUS'], 'integer'],
            [['TGL', 'CUST_ID', 'USER_ID', 'NOTE', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT', 'CHECKIN_TIME', 'CHECKOUT_TIME'], 'safe'],
            [['LAT', 'LAG', 'RADIUS', 'CHECKOUT_LAT', 'CHECKOUT_LAG'], 'number'],
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
        $query = DraftPlanDetail::find();

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
            'ID' => $this->ID,
            'TGL' => $this->TGL,
            'SCDL_GROUP' => $this->SCDL_GROUP,
            'LAT' => $this->LAT,
            'LAG' => $this->LAG,
            'RADIUS' => $this->RADIUS,
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
            'CHECKIN_TIME' => $this->CHECKIN_TIME,
            'CHECKOUT_LAT' => $this->CHECKOUT_LAT,
            'CHECKOUT_LAG' => $this->CHECKOUT_LAG,
            'CHECKOUT_TIME' => $this->CHECKOUT_TIME,
        ]);

        $query->andFilterWhere(['like', 'CUST_ID', $this->CUST_ID])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }
}
