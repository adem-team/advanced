<?php

namespace lukisongroup\purchasing\models\stck;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\purchasing\models\stck\StockRcvd;

/**
 * StockRcvdSearch represents the model behind the search form about `lukisongroup\purchasing\models\stck\StockRcvd`.
 */
class StockRcvdSearch extends StockRcvd
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'TYPE', 'STATUS'], 'integer'],
            [['TGL', 'KD_PO', 'KD_REF', 'KD_SPL', 'ID_BARANG', 'NM_BARANG', 'UNIT', 'UNIT_NM', 'NOTE', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT'], 'safe'],
            [['UNIT_QTY', 'UNIT_WIGHT', 'QTY'], 'number'],
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
        $query = StockRcvd::find();

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
            'TYPE' => $this->TYPE,
            'UNIT_QTY' => $this->UNIT_QTY,
            'UNIT_WIGHT' => $this->UNIT_WIGHT,
            'QTY' => $this->QTY,
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'KD_PO', $this->KD_PO])
            ->andFilterWhere(['like', 'KD_REF', $this->KD_REF])
            ->andFilterWhere(['like', 'KD_SPL', $this->KD_SPL])
            ->andFilterWhere(['like', 'ID_BARANG', $this->ID_BARANG])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'UNIT', $this->UNIT])
            ->andFilterWhere(['like', 'UNIT_NM', $this->UNIT_NM])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }
}
