<?php

namespace lukisongroup\marketing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\marketing\models\SalesPromo;

/**
 * SalesPromoSearch represents the model behind the search form about `lukisongroup\marketing\models\SalesPromo`.
 */
class SalesPromoSearch extends SalesPromo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'OVERDUE', 'STATUS'], 'integer'],
            [['CUST_ID', 'CUST_NM', 'PROMO', 'TGL_START', 'TGL_END', 'MEKANISME', 'KOMPENSASI', 'KETERANGAN', 'CREATED_BY', 'CREATED_AT', 'UPDATED_BY', 'UPDATED_AT'], 'safe'],
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
        $query = SalesPromo::find();

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
            'TGL_START' => $this->TGL_START,
            'TGL_END' => $this->TGL_END,
            'OVERDUE' => $this->OVERDUE,
            'STATUS' => $this->STATUS,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
        ]);

        $query->andFilterWhere(['like', 'CUST_ID', $this->CUST_ID])
            ->andFilterWhere(['like', 'CUST_NM', $this->CUST_NM])
            ->andFilterWhere(['like', 'PROMO', $this->PROMO])
            ->andFilterWhere(['like', 'MEKANISME', $this->MEKANISME])
            ->andFilterWhere(['like', 'KOMPENSASI', $this->KOMPENSASI])
            ->andFilterWhere(['like', 'KETERANGAN', $this->KETERANGAN])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProvider;
    }
}
