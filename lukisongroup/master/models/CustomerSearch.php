<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `lukisongroup\models\master\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CUST_KD', 'CUST_NM', 'ALAMAT', 'PIC', 'EMAIL', 'WEBSITE', 'NOTE', 'NPWP', 'CREATED_BY', 'CREATED_AT', 'UPDATED_AT', 'UPDATED_BY', 'DATA_ALL'], 'safe'],
            [['TLP1', 'TLP2', 'FAX', 'STATUS', 'STT_TOKO'], 'integer'],
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
        $query = Customer::find()->where('STATUS <> 3');

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
            'TLP1' => $this->TLP1,
            'TLP2' => $this->TLP2,
            'FAX' => $this->FAX,
            'STATUS' => $this->STATUS,
            'STT_TOKO' => $this->STT_TOKO,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
        ]);

//        $query->andFilterWhere(['like', 'CUST_KD', $this->CUST_KD])
//            ->andFilterWhere(['like', 'CUST_NM', $this->CUST_NM])
//            ->andFilterWhere(['like', 'ALAMAT', $this->ALAMAT])
//            ->andFilterWhere(['like', 'PIC', $this->PIC])
//            ->andFilterWhere(['like', 'EMAIL', $this->EMAIL])
//            ->andFilterWhere(['like', 'WEBSITE', $this->WEBSITE])
//            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
//            ->andFilterWhere(['like', 'NPWP', $this->NPWP])
//            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
//            ->andFilterWhere(['like', 'UPDATED_BY', $this->UPDATED_BY])
//            ->andFilterWhere(['like', 'DATA_ALL', $this->DATA_ALL]);

        return $dataProvider;
    }
}
