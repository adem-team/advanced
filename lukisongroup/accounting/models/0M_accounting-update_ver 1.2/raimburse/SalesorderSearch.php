<?php

namespace lukisongroup\accounting\models\raimburse;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SalesorderSearch extends Salesorder
{
	
	public $nmemp;
	//public $detsa=[];
	
	public function attributes()
	{
		/*Author -ptr.nov- add related fields to searchable attributes */
		return array_merge(parent::attributes(), ['detsa.KD_SA','detsa.NM_BARANG','detsa.RQTY','detsa.SQTY','dept.DEP_NM']);
	}
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STATUS'], 'integer'],
            [['KD_SA', 'NOTE', 'ID_USER', 'KD_CORP', 'KD_CAB', 'KD_DEP', 'CREATED_AT', 'UPDATED_ALL', 'DATA_ALL'], 'safe'],
            [['detsa'], 'safe'],
			[['detsa.KD_SA','detsa.NM_BARANG','detsa.RQTY','detsa.SQTY','dept.DEP_NM','EMP_NM',], 'safe'],
			[['SIG2_NM'], 'string', 'max' => 255],
			[['SIG1_SVGBASE64','SIG1_SVGBASE30','SIG2_SVGBASE64','SIG2_SVGBASE30','SIG2_TGL'], 'safe'],
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

	public function searchSa($params)
    {
		$profile=Yii::$app->getUserOpt->Profile_user();
        //$query = Pilotproject::find()->Where('sc0001.STATUS<>3 AND DEP_ID="'.$profile->emp->DEP_ID .'"');
		
		if($profile->emp->JOBGRADE_ID == 'M' OR $profile->emp->JOBGRADE_ID == 'SM' ){
			$query = Salesorder::find()
						->JoinWith('dept',true,'left JOIN')	
						->where("(sa0001.STATUS <> 3 and sa0001.KD_CORP = '" .$profile->emp->EMP_CORP_ID ."' and sa0001.ID_USER = '".$profile->emp->EMP_ID."') OR (sa0001.status <> 3 and sa0001.KD_CORP = '" .$profile->emp->EMP_CORP_ID ."' and sa0001.KD_DEP = '".$profile->emp->DEP_ID."')");
        }else{
			$query = Salesorder::find()
					->JoinWith('dept',true,'left JOIN')	
					->where("sa0001.STATUS <> 3 and sa0001.KD_CORP = '" .$profile->emp->EMP_CORP_ID ."' and sa0001.ID_USER = '".$profile->emp->EMP_ID."'");
		}
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

		$this->load($params);
		if (!$this->validate()) {
			//return $dataProvider;
			//$dataProvider->query->where('0=1');
			return $dataProvider;
		} 
			
		$query->andFilterWhere(['like', 'KD_SA', $this->KD_SA])
			  ->andFilterWhere(['like', 'EMP_NM', $this->EMP_NM])
			  ->andFilterWhere(['like', 'u0002a.DEP_NM', $this->getAttribute('dept.DEP_NM')]);
			  
			
		if($this->CREATED_AT!=''){
            $date_explode = explode(" - ", $this->CREATED_AT);
            $date1 = trim($date_explode[0]);
            $date2= trim($date_explode[1]);
            $query->andFilterWhere(['between','CREATED_AT', $date1,$date2]);
        } 
		
		return $dataProvider;
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
		$empId = Yii::$app->user->identity->EMP_ID;
		$dt = Employe::find()->where(['EMP_ID'=>$empId])->all();
		$crp = $dt[0]['EMP_CORP_ID'];
		$depId = $dt[0]['DEP_ID'];
		
		if($dt[0]['GF_ID'] == '3'){
			$query = Salesorder::find()->where("sa0001.status <> 3 and sa0001.KD_CORP = '$crp' and sa0001.KD_DEP = '$depId' ");
		} else {
			$query = Salesorder::find()->where("sa0001.status <> 3 and sa0001.KD_CORP = '$crp' and sa0001.ID_USER = '$empId'  and sa0001.KD_DEP = '$depId' ");
		}
		
		$query->joinWith(['employe' => function ($q) {
			$q->where('a0001.EMP_NM LIKE "%' . $this->nmemp . '%"');
		}]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

		 $dataProvider->setSort([
			'attributes' => [
			'KD_SA',
			'KD_CORP',
			
			'nmemp' => [
				'asc' => ['a0001.EMP_NM' => SORT_ASC],
				'desc' => ['a0001.EMP_NM' => SORT_DESC],
				'label' => 'Pembuat',
			],			
			]
		]);
		
		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}
		
        $query->andFilterWhere(['like', 'a0001.EMP_NM', $this->EMP_NM])
		->andFilterWhere(['like', 'KD_SA', $this->KD_SA])
		->andFilterWhere(['like', 'KD_CORP', $this->KD_CORP]);
        return $dataProvider;
    }

    public function cari($params)
    {
        $empId = Yii::$app->user->identity->EMP_ID;
        $dt = Employe::find()->where(['EMP_ID'=>$empId])->all();
        $crp = $dt[0]['EMP_CORP_ID'];
        
        if($dt[0]['JAB_ID'] == 'MGR'){
            $query = Salesorder::find()->where("sa0001.status <> 3 and sa0001.status <> 0 and sa0001.KD_CORP = '$crp' ");
        } else {
            $query = Salesorder::find()->where("sa0001.status <> 3 and sa0001.status <> 0 and sa0001.KD_CORP = '$crp' and sa0001.ID_USER = '$empId' ");
        }
        
        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->nmemp . '%"');
        }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         $dataProvider->setSort([
            'attributes' => [
            'KD_SA',
            'KD_CORP',
            
            'nmemp' => [
                'asc' => ['a0001.EMP_NM' => SORT_ASC],
                'desc' => ['a0001.EMP_NM' => SORT_DESC],
                'label' => 'Pembuat',
            ],          
            ]
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        $query->andFilterWhere(['like', 'a0001.EMP_NM', $this->EMP_NM])
        ->andFilterWhere(['like', 'KD_SA', $this->KD_SA])
        ->andFilterWhere(['like', 'KD_CORP', $this->KD_CORP]);
        return $dataProvider;
    }
    
    public function carisa($params)
    {
        $query = Salesorder::find()->where("sa0001.status <> 3 and sa0001.status <> 0");
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         $dataProvider->setSort([
            'attributes' => [
            'KD_SA',        
            ]
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        $query->andFilterWhere(['like', 'KD_SA', $this->KD_SA]);
        return $dataProvider;
    }
    
}
