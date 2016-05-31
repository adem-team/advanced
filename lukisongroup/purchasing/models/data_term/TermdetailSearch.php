<?php

namespace lukisongroup\purchasing\models\data_term;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

/**
 * TermdetailSearch represents the model behind the search form about `lukisongroup\master\models\Termdetail`.
 */
class TermdetailSearch extends Termdetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS'], 'integer'],
            [['CUST_KD_PARENT','TERM_ID', 'INVES_TYPE', 'BUDGET_SOURCE', 'PERIODE_START', 'PERIODE_END', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT'], 'safe'],
            [['BUDGET_PLAN','BUDGET_ACTUAL'], 'number'],
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
        $query = Termdetail::find();

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
            'TERM_ID' => $this->TERM_ID,
            'BUDGET_PLAN' => $this->BUDGET_PLAN,
            'BUDGET_ACTUAL' => $this->BUDGET_ACTUAL,
            'PERIODE_START' => $this->PERIODE_START,
            'PERIODE_END' => $this->PERIODE_END,
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'CUST_KD_PARENT', $this->CUST_KD_PARENT])
            ->andFilterWhere(['like', 'INVES_TYPE', $this->INVES_TYPE])
            ->andFilterWhere(['like', 'BUDGET_SOURCE', $this->BUDGET_SOURCE])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }

    public function searchbudget($params,$id)
    {

      // Customers::find()->joinWith('cus',true,'JOIN')
      //           ->where('c0001.STATUS <> 3');
        $query = Termdetail::find()->where(['TERM_ID'=>$id]);

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
			'BUDGET_PLAN' => $this->BUDGET_PLAN,
            'BUDGET_ACTUAL' => $this->BUDGET_ACTUAL,
            'PERIODE_END' => $this->PERIODE_END,
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'CUST_KD_PARENT', $this->CUST_KD_PARENT])
            ->andFilterWhere(['like', 'INVES_TYPE', $this->INVES_TYPE])
            ->andFilterWhere(['like', 'BUDGET_SOURCE', $this->BUDGET_SOURCE])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

        return $dataProvider;
    }
}