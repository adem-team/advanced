<?php

namespace lukisongroup\roadsales\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\roadsales\models\SalesRoadHeader;

/**
 * SalesRoadHeaderSearch represents the model behind the search form about `lukisongroup\roadsales\models\SalesRoadHeader`.
 */
class SalesRoadHeaderSearch extends SalesRoadHeader
{
	
	public function attributes()
	{
		/*Author -ptr.nov- add related fields to searchable attributes */
		return array_merge(parent::attributes(), ['TGL','Username']);
	}
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ROAD_D'], 'integer'],
            [['USER_ID','JUDUL','CUSTOMER','CASE_ID','CASE_NM', 'CASE_NOTE', 'CREATED_BY', 'CREATED_AT','TGL','Username'], 'safe'],
            [['LAT', 'LAG'], 'number'],
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
    public function searchDetail($params)
    {
		
        $query = SalesRoadHeader::find();
		// $sql = 'SELECT *, date(CREATED_AT) as TGL FROM c0022Header ORDER BY date(CREATED_AT) DESC';
		// $query = SalesRoadHeader::findBySql($sql);  
		
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ROAD_D' => $this->ROAD_D,
            'LAT' => $this->LAT,
            'LAG' => $this->LAG
        ]);

        $query->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'CREATED_AT', $this->CREATED_AT])
            ->andFilterWhere(['like', 'JUDUL', $this->JUDUL])
            ->andFilterWhere(['like', 'CUSTOMER', $this->CUSTOMER])
            ->andFilterWhere(['like', 'CASE_ID', $this->CASE_ID])
            ->andFilterWhere(['like', 'CASE_NM', $this->CASE_NM])
            ->andFilterWhere(['like', 'CASE_NOTE', $this->CASE_NOTE])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY]);
        return $dataProvider;
    }
	
	/**
     * HEADER SEARCH.
     * @return ActiveDataProvider.
     */
    public function searchGroup($params)
    {
        //$query = SalesRoadHeader::find()->groupBy(date_format(date_create('CREATED_AT'),"Y-m-d"));
        $query = SalesRoadHeader::find()->groupBy(['USER_ID','date(CREATED_AT)'])->orderBy(['date(CREATED_AT)'=>SORT_DESC]);
		//$sql = 'SELECT *, date(CREATED_AT) as TGL FROM c0022Header GROUP BY USER_ID,date(CREATED_AT) ORDER BY date(CREATED_AT) DESC';
		//$query = SalesRoadHeader::findBySql($sql);  

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ROAD_D' => $this->ROAD_D,
            'LAT' => $this->LAT,
            'LAG' => $this->LAG
        ]);

        $query->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'CREATED_AT', $this->TGL])
            ->andFilterWhere(['like', 'JUDUL', $this->JUDUL])
            ->andFilterWhere(['like', 'CUSTOMER', $this->CUSTOMER])
            ->andFilterWhere(['like', 'CASE_ID', $this->CASE_ID])
            ->andFilterWhere(['like', 'CASE_NM', $this->CASE_NM])
            ->andFilterWhere(['like', 'CASE_NOTE', $this->CASE_NOTE])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY]);

        return $dataProvider;
    }
}
