<?php

namespace lukisongroup\purchasing\models\salesmanorder;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\purchasing\models\salesmanorder\SoT2;

/**
 * SoT2Search represents the model behind the search form about `lukisongroup\purchasing\models\salesmanorder\SoT2`.
 */
class SoT2Search extends SoT2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'SO_TYPE', 'STATUS'], 'integer'],
            [['TGL', 'CUST_KD', 'CUST_KD_ALIAS', 'CUST_NM', 'KD_BARANG', 'KD_BARANG_ALIAS', 'NM_BARANG', 'POS', 'KD_DIS', 'NM_DIS', 'USER_ID', 'UNIT_BARANG', 'NOTED', 'WAKTU_INPUT_INVENTORY', 'ID_GROUP', 'KODE_REF'], 'safe'],
            [['SO_QTY', 'UNIT_QTY', 'UNIT_BERAT', 'HARGA_PABRIK', 'HARGA_DIS', 'HARGA_SALES', 'HARGA_LG', 'SUBMIT_QTY', 'SUBMIT_PRICE'], 'number'],
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
        $query = SoT2::find();

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
            'SO_QTY' => $this->SO_QTY,
            'SO_TYPE' => $this->SO_TYPE,
            'UNIT_QTY' => $this->UNIT_QTY,
            'UNIT_BERAT' => $this->UNIT_BERAT,
            'HARGA_PABRIK' => $this->HARGA_PABRIK,
            'HARGA_DIS' => $this->HARGA_DIS,
            'HARGA_SALES' => $this->HARGA_SALES,
            'HARGA_LG' => $this->HARGA_LG,
            'STATUS' => $this->STATUS,
            'WAKTU_INPUT_INVENTORY' => $this->WAKTU_INPUT_INVENTORY,
            'SUBMIT_QTY' => $this->SUBMIT_QTY,
            'SUBMIT_PRICE' => $this->SUBMIT_PRICE,
        ]);

        $query->andFilterWhere(['like', 'CUST_KD', $this->CUST_KD])
            ->andFilterWhere(['like', 'CUST_KD_ALIAS', $this->CUST_KD_ALIAS])
            ->andFilterWhere(['like', 'CUST_NM', $this->CUST_NM])
            ->andFilterWhere(['like', 'KD_BARANG', $this->KD_BARANG])
            ->andFilterWhere(['like', 'KD_BARANG_ALIAS', $this->KD_BARANG_ALIAS])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'POS', $this->POS])
            ->andFilterWhere(['like', 'KD_DIS', $this->KD_DIS])
            ->andFilterWhere(['like', 'NM_DIS', $this->NM_DIS])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'UNIT_BARANG', $this->UNIT_BARANG])
            ->andFilterWhere(['like', 'NOTED', $this->NOTED])
            ->andFilterWhere(['like', 'ID_GROUP', $this->ID_GROUP])
            ->andFilterWhere(['like', 'KODE_REF', $this->KODE_REF]);

        return $dataProvider;
    }
}
