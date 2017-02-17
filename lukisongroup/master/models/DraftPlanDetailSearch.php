<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\DraftPlanDetail;

/**
 * DraftPlanDetailSearch represents the model behind the search form about `lukisongroup\master\models\DraftPlanDetail`.
 */
class DraftPlanDetailSearch extends DraftPlanDetail
{
    /**
     * @inheritdoc
     */
    public $custNm;
    public $custlayernm;
    public $SalesNm;
    public $UseridNm;
    public $weekofDate;
    public $dayofDate;
    
    public function rules()
    {
        return [
            [['ID','STATUS'], 'integer'],
            [['TGL', 'CUST_ID','NOTE', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT','ODD_EVEN','custNm','SCDL_GROUP','custlayernm','SalesNm','UseridNm'], 'safe'],
            [['LAT', 'LAG', 'RADIUS'], 'number'],
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
        //$query = DraftPlanDetail::find()->orderBy(['TGL'=>SORT_ASC,'SCDL_GROUP'=>SORT_ASC,]);
        $query = DraftPlanDetail::find()->where('STATUS<>2 AND STATUS<>3 AND YEAR(TGL)=2017')->groupBy(['TGL','SCDL_GROUP','CUST_ID'])->orderBy(['TGL'=>SORT_ASC,'SCDL_GROUP'=>SORT_ASC]);
        //$query = DraftPlanDetail::find()->where('STATUS<>2')->orderBy(['TGL'=>SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
              //'sort' =>false,
			'pagination'=>[
				'pageSize'=>1000,
			]
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
            'SCDL_GROUP' => $this->SCDL_GROUP,
            'LAT' => $this->LAT,
            'CUST_ID' => $this->custlayernm,
            'LAG' => $this->LAG,
            'RADIUS' => $this->RADIUS,
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
            'ODD_EVEN' => $this->weekofDate
        ]);

        $query->andFilterWhere(['like', 'CUST_ID', $this->custNm])
           // ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            //->andFilterWhere(['like', 'TGL', '%2016'])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);

             //	$query->orderby(['CUST_ID'=>SORT_ASC]); //SORT PENTING UNTUK RECURSIVE BIAR TREE BISA URUTAN, save => (IF (PATENT =0) {SORT=ID}, ELSE {SORT=PATENT}, note Parent=ID header

        return $dataProvider;
    }
	/*
	 * EMPTY CONDITION (SPEED LOAD CONTROLLER)
	 * LOAD BY TAB.
	*/
	public function searchEmpty($params)
    {
		 $query = DraftPlanDetail::find()->where('STATUS=100');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination'=>[
				'pageSize'=>0,
			]           
        ]);
        return $dataProvider;
    }
}
