<?php

namespace crm\salesman\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use crm\salesman\models\Sot2;

/**
 * Sot2Search represents the model behind the search form about `lukisongroup\sales\models\Sot2`.
 */
class Sot2Search extends Sot2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'SO_TYPE'], 'integer'],
            [['TGL', 'CUST_KD_ALIAS', 'KD_DIS', 'USER_ID', 'KD_BARANG_ALIAS', 'NM_BARANG', 'UNIT_BARANG', 'NOTED'], 'safe'],
            [['UNIT_QTY', 'UNIT_BERAT', 'SO_QTY', 'HARGA_PABRIK', 'HARGA_DIS', 'HARGA_SALES', 'HARGA_LG'], 'number'],
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
        $query = Sot2::find();

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
            'TGL' => $this->TGL,
            'UNIT_QTY' => $this->UNIT_QTY,
            'UNIT_BERAT' => $this->UNIT_BERAT,
            'SO_TYPE' => $this->SO_TYPE,
            'SO_QTY' => $this->SO_QTY,
            'HARGA_PABRIK' => $this->HARGA_PABRIK,
            'HARGA_DIS' => $this->HARGA_DIS,
            'HARGA_SALES' => $this->HARGA_SALES,
            'HARGA_LG' => $this->HARGA_LG,
        ]);

        $query->andFilterWhere(['like', 'CUST_KD_ALIAS', $this->CUST_KD_ALIAS])
            ->andFilterWhere(['like', 'KD_DIS', $this->KD_DIS])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'KD_BARANG_ALIAS', $this->KD_BARANG_ALIAS])
            ->andFilterWhere(['like', 'NM_BARANG', $this->NM_BARANG])
            ->andFilterWhere(['like', 'UNIT_BARANG', $this->UNIT_BARANG])
            ->andFilterWhere(['like', 'NOTED', $this->NOTED]);

        return $dataProvider;
    }
}
