<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\DraftPlan;

/**
 * DraftPlanSearch represents the model behind the search form about `lukisongroup\master\models\DraftPlan`.
 */
class DraftPlanSearch extends DraftPlan
{
    /**
     * @inheritdoc
     */
    public $GanjilGenap;
    public $LayerNm;
    public $DayNm;
    public $GeoNm;
    public $CustNm;
    public function rules()
    {
        return [
            [['ID','GEO_ID', 'LAYER_ID', 'DAY_ID', 'DAY_VALUE', 'STATUS','GanjilGenap'], 'integer'],
            [['CUST_KD', 'CREATED_BY','DayNm','CREATED_AT', 'UPDATED_BY','GeoNm','UPDATED_AT','ODD_EVEN','YEAR','LayerNm','CustNm'], 'safe'],
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
        $query = DraftPlan::find();

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
            'GEO_ID' => $this->GeoNm,
            'LAYER_ID' => $this->LayerNm,
            'DAY_ID' => $this->DAY_ID,
            'DAY_VALUE' => $this->DayNm,
            'STATUS' => $this->STATUS,
            'YEAR' => $this->YEAR,
            'ODD_EVEN'=>$this->GanjilGenap,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
            'CUST_KD' => $this->CUST_KD
        ]);

        $query->andFilterWhere(['like', 'CUST_KD', $this->CustNm])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProvider;
    }
}
