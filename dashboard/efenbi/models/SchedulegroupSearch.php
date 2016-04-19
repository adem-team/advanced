<?php

namespace  dashboard\efenbi\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use dashboard\efenbi\models\Schedulegroup;
use dashboard\efenbi\modelss\Customers;

/**
 * SchedulegroupSearch represents the model behind the search form about `lukisongroup\master\models\Schedulegroup`.
 */
class SchedulegroupSearch extends Schedulegroup
{
    /**
     * @inheritdoc
     */
	
    public function rules()
    {
        return [
            [['ID', 'STATUS'], 'integer'],
            [['SCDL_GROUP_NM', 'KETERANGAN', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT'], 'safe'],
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
        $query = Schedulegroup::find();

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
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'SCDL_GROUP_NM', $this->SCDL_GROUP_NM])
            ->andFilterWhere(['like', 'KETERANGAN', $this->KETERANGAN])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }

	// public function searchListCust($params)
    // {
        // $query = Schedulegroup::find()
        // $query = Customers::find()
				// ->joinWith('Schedulegroup',true,'JOIN')
				// ->where('c0001.STATUS <> 3 AND c0007.STATUS <> 3');;

        // $dataProvider = new ActiveDataProvider([
            // 'query' => $query,
        // ]);

		// $modelTmp = $dataProviderTmp->cust();

		// $dataProvider = new ActiveDataProvider([
           // 'query' => $modelTmp,
       // ]);



        // $this->load($params);

        // if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            // return $dataProvider;
        // }

        // $query->andFilterWhere([
            // 'ID' => $this->ID,
            // 'STATUS' => $this->STATUS,
            // 'CREATE_AT' => $this->CREATE_AT,
            // 'UPDATE_AT' => $this->UPDATE_AT,
        // ]);

        // $query->andFilterWhere(['like', 'SCDL_GROUP_NM', $this->SCDL_GROUP_NM])
            // ->andFilterWhere(['like', 'KETERANGAN', $this->KETERANGAN])
            // ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            // ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        // return $dataProvider;
    // }
}
