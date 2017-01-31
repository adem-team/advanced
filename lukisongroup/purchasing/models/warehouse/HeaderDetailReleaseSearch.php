<?php

namespace lukisongroup\purchasing\models\warehouse;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\purchasing\models\warehouse\HeaderDetailRelease;

/**
 * HeaderDetailReleaseSearch represents the model behind the search form about `lukisongroup\purchasing\models\warehouse\HeaderDetailRelease`.
 */
class HeaderDetailReleaseSearch extends HeaderDetailRelease
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'integer'],
            [['TYPE','TGL', 'KD_SJ', 'KD_SO', 'KD_INVOICE', 'KD_FP', 'ETD', 'ETA', 'KD_BARANG', 'NM_BARANG', 'NOTE', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT'], 'safe'],
            [['QTY_UNIT', 'QTY_PCS', 'HARGA', 'DISCOUNT', 'PAJAK', 'DELIVERY_COST'], 'number'],
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
        $query = HeaderDetailRelease::find();

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
            'ETD' => $this->ETD,
            'ETA' => $this->ETA,
            'QTY_UNIT' => $this->QTY_UNIT,
            'QTY_PCS' => $this->QTY_PCS,
            'HARGA' => $this->HARGA,
            'DISCOUNT' => $this->DISCOUNT,
            'PAJAK' => $this->PAJAK,
            'DELIVERY_COST' => $this->DELIVERY_COST,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'KD_SJ', $this->KD_SJ])
            ->andFilterWhere(['like', 'KD_SO', $this->KD_SO])
            ->andFilterWhere(['like', 'KD_INVOICE', $this->KD_INVOICE])
            ->andFilterWhere(['like', 'KD_FP', $this->KD_FP])
            ->andFilterWhere(['like', 'KD_BARANG', $this->KD_BARANG])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }
}
