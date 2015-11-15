<?php

namespace crm\salespromo\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use crm\salespromo\models\Stock_promo;

/**
 * Stock_promoSearch represents the model behind the search form about `crm\salespromo\models\Stock_promo`.
 */
class Stock_promoSearch extends Stock_promo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STOCK_PROMO', 'PRODAK_LINE', 'STATUS'], 'integer'],
            [['WAKTU', 'CUST_KD', 'CUST_NM', 'KD_BARANG', 'NM_BARANG', 'CORP_ID', 'KD_DISTRIBUTOR', 'KD_SUBDIST', 'CREATED_BY', 'UPDATED_BY', 'UPDATED_TIME'], 'safe'],
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
        $query = Stock_promo::find();

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
            'ID' => $this->ID,
            'WAKTU' => $this->WAKTU,
            'STOCK_PROMO' => $this->STOCK_PROMO,
            'PRODAK_LINE' => $this->PRODAK_LINE,
            'UPDATED_TIME' => $this->UPDATED_TIME,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'CUST_KD', $this->CUST_KD])
            ->andFilterWhere(['like', 'CUST_NM', $this->CUST_NM])
            ->andFilterWhere(['like', 'KD_BARANG', $this->KD_BARANG])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'CORP_ID', $this->CORP_ID])
            ->andFilterWhere(['like', 'KD_DISTRIBUTOR', $this->KD_DISTRIBUTOR])
            ->andFilterWhere(['like', 'KD_SUBDIST', $this->KD_SUBDIST])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProvider;
    }
}
