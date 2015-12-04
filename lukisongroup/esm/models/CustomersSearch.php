<?php

namespace lukisongroup\esm\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\esm\models\Customers;

/**
 * CustomersSearch represents the model behind the search form about `lukisongroup\esm\models\Customers`.
 */
class CustomersSearch extends Customers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CUST_KD', 'CUST_KD_ALIAS', 'CUST_NM', 'CUST_GRP', 'JOIN_DATE', 'MAP_LAT', 'MAP_LNG', 'KD_DISTRIBUTOR', 'PIC', 'ALAMAT', 'EMAIL', 'WEBSITE', 'NOTE', 'NPWP', 'DATA_ALL', 'CAB_ID', 'CORP_ID', 'CREATED_BY', 'CREATED_AT', 'UPDATED_BY', 'UPDATED_AT'], 'safe'],
            [['CUST_KTG', 'TLP1', 'TLP2', 'FAX', 'STT_TOKO', 'STATUS'], 'integer'],
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
    public function searchcus($params)
    {
        $query = Customers::find()->where('STATUS <> 3');

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
            'CUST_KTG' => $this->CUST_KTG,
            'JOIN_DATE' => $this->JOIN_DATE,
            'TLP1' => $this->TLP1,
            'TLP2' => $this->TLP2,
            'FAX' => $this->FAX,
            'STT_TOKO' => $this->STT_TOKO,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
            'STATUS' => $this->STATUS,
        ]);

        $query->andFilterWhere(['like', 'CUST_KD', $this->CUST_KD])
            ->andFilterWhere(['like', 'CUST_KD_ALIAS', $this->CUST_KD_ALIAS])
            ->andFilterWhere(['like', 'CUST_NM', $this->CUST_NM])
            ->andFilterWhere(['like', 'CUST_GRP', $this->CUST_GRP])
            ->andFilterWhere(['like', 'MAP_LAT', $this->MAP_LAT])
            ->andFilterWhere(['like', 'MAP_LNG', $this->MAP_LNG])
            ->andFilterWhere(['like', 'PIC', $this->PIC])
            ->andFilterWhere(['like', 'ALAMAT', $this->ALAMAT])
            ->andFilterWhere(['like', 'EMAIL', $this->EMAIL])
            ->andFilterWhere(['like', 'WEBSITE', $this->WEBSITE])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'NPWP', $this->NPWP])
            ->andFilterWhere(['like', 'DATA_ALL', $this->DATA_ALL])
            ->andFilterWhere(['like', 'CAB_ID', $this->CAB_ID])
            ->andFilterWhere(['like', 'CORP_ID', $this->CORP_ID])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY]);

        return $dataProvider;
    }
}
