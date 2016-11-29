<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\SopSalesDetail;

/**
 * SopSalesDetailSearch represents the model behind the search form about `lukisongroup\master\models\SopSalesDetail`.
 */
class SopSalesDetailSearch extends SopSalesDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'SOP_ID'], 'integer'],
            [['TGL', 'CREATE_BY', 'CREATE_AT'], 'safe'],
            [['SCORE_RSLT', 'SCORE_PERCENT_MIN', 'SCORE_PERCENT_MAX'], 'number'],
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
        $query = SopSalesDetail::find()->where(['SOP_ID'=>$this->SOP_ID]);

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
            'SOP_ID' => $this->SOP_ID,
            'SCORE_RSLT' => $this->SCORE_RSLT,
            'SCORE_PERCENT_MIN' => $this->SCORE_PERCENT_MIN,
            'SCORE_PERCENT_MAX' => $this->SCORE_PERCENT_MAX,
            'CREATE_AT' => $this->CREATE_AT,
        ]);

        $query->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY]);

        return $dataProvider;
    }
}
