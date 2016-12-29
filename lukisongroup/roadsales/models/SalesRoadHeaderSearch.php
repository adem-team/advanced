<?php

namespace lukisongroup\roadsales\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\debug\components\search\Filter;
use yii\debug\components\search\matchers;

use lukisongroup\roadsales\models\SalesRoadHeader;

/**
 * SalesRoadHeaderSearch represents the model behind the search form about `lukisongroup\roadsales\models\SalesRoadHeader`.
 */
class SalesRoadHeaderSearch extends SalesRoadHeader
{
	//public $TGL;
	public function attributes()
	{
		/*Author -ptr.nov- add related fields to searchable attributes */
		//return array_merge(parent::attributes(), ['TGL','Username']);
		return array_merge(parent::attributes(), ['Username']);
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
            'LAG' => $this->LAG,
			'TGL'=>$this->TGL
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
        $query = SalesRoadHeader::find()->groupBy(['USER_ID','TGL'])->orderBy(['TGL'=>SORT_DESC]);
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
	
	
	/**
     * HEADER SEARCH.
     * @return ActiveDataProvider.
     */
    public function searchGroupChart($params)
    {
        //$query = SalesRoadHeader::find()->groupBy(date_format(date_create('CREATED_AT'),"Y-m-d"));
		// $query = SalesRoadHeader::find()->groupBy(['USER_ID','date(CREATED_AT)'])->orderBy(['date(CREATED_AT)'=>SORT_DESC]);
		$sql = "SELECT CREATED_BY AS USER_ID,DATE_FORMAT(CREATED_AT,'%Y-%m-%d') AS CREATED_AT,group_concat(CASE_NM) AS CASE_NM,group_concat(CASE_ID) AS CASE_ID
				FROM c0022Header
				GROUP BY CREATED_BY,date(CREATED_AT)";
		$query = SalesRoadHeader::findBySql($sql);  

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


        return $dataProvider;
    }
	
	public function searchAryChart($params){
		$queryChart= Yii::$app->db_esm->createCommand("
				SELECT USER_ID AS USER_ID,DATE_FORMAT(CREATED_AT,'%Y-%m-%d') AS CREATED_AT,group_concat(CASE_NM) AS CASE_NM,group_concat(CASE_ID) AS CASE_ID
				FROM c0022Header
				GROUP BY CREATED_BY,date(CREATED_AT)
		")->queryAll();
		
		$dataProvider= new ArrayDataProvider([
			//'key' => 'ID',
			'allModels'=>$queryChart,
			'pagination' => [
				'pageSize' => 500,
			]
		]);
				
		if (!($this->load($params) && $this->validate())) {
 			return $dataProvider;
 		}

		$filter = new Filter();
 		$this->addCondition($filter, 'USER_ID', true);
 		//$this->addCondition($filter, 'EMP_NM', true);
 		$dataProvider->allModels = $filter->filter($queryChart);
		
		return $dataProvider;
	}
	/**
	 * CHART DATA
	*/
	public function searchChartData($params){
		$query= Yii::$app->db_esm->createCommand("
			SELECT x1.CREATED_BY AS USER_ID, x1.TGL, x1.CASE_ID, x2.CASE_NAME as label, COUNT(x1.CASE_ID) as VALUE
			FROM c0022Rpt x1 LEFT JOIN c0022List x2 on x2.ID=x1.CASE_ID
			GROUP BY x1.TGL,x1.CREATED_BY,x1.CASE_ID
			ORDER BY x1.TGL DESC;
		")->queryAll();
		
		$dataProvider= new ArrayDataProvider([
			//'key' => 'ID',
			'allModels'=>$query,
			'pagination' => [
				'pageSize' => 500,
			]
		]);
				
		if (!($this->load($params) && $this->validate())) {
 			return $dataProvider;
 		}

		$filter = new Filter();
 		$this->addCondition($filter, 'USER_ID', true);
 		//$this->addCondition($filter, 'EMP_NM', true);
 		$dataProvider->allModels = $filter->filter($query);
		
		return $dataProvider;
	}
	
	
	
	
	
	
	public function addCondition(Filter $filter, $attribute, $partial = false)
    {
        $value = $this->$attribute;

        if (mb_strpos($value, '>') !== false) {
            $value = intval(str_replace('>', '', $value));
            $filter->addMatcher($attribute, new matchers\GreaterThan(['value' => $value]));

        } elseif (mb_strpos($value, '<') !== false) {
            $value = intval(str_replace('<', '', $value));
            $filter->addMatcher($attribute, new matchers\LowerThan(['value' => $value]));
        } else {
            $filter->addMatcher($attribute, new matchers\SameAs(['value' => $value, 'partial' => $partial]));
        }
    }
}
