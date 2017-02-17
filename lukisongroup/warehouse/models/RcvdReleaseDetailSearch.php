<?php

namespace lukisongroup\warehouse\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\purchasing\models\warehouse\HeaderDetailRcvd;

/**
 * HeaderDetailRcvdSearch represents the model behind the search form about `lukisongroup\purchasing\models\warehouse\HeaderDetailRcvd`.
 */
class RcvdReleaseDetailSearch extends RcvdReleaseDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
       return [
            [['ID'], 'required'],
            [['ID'], 'integer'],
            [['DISCOUNT','HARGA','PAJAK','ID_HEADER','TGL', 'DTL_ETD', 'DTL_ETA', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['DTL_QTY_UNIT', 'DTL_QTY_PCS',  'DELIVERY_COST'], 'number'],
            [['NOTE'], 'string'],
            [['KD_SJ','KD_INVOICE','KD_FP','KD_BARANG', 'CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 50],
            [['NM_BARANG'], 'string', 'max' => 255]
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
        $query = RcvdReleaseDetail::find();

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
            'DTL_ETD' => $this->ETD,
            'DTL_ETA' => $this->ETA,
            'DTL_QTY_UNIT' => $this->QTY_UNIT,
            'DTL_QTY_PCS' => $this->QTY_PCS,
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
