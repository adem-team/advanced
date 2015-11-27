<?php

namespace lukisongroup\sales\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\sales\models\Salesorder;

use lukisongroup\hrd\models\Employe;
/**
 * RequestorderSearch represents the model behind the search form about `app\models\esm\ro\Requestorder`.
 */
class SalesorderSearch extends Salesorder
{
	
	public $nmemp;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS'], 'integer'],
            [['KD_RO', 'NOTE', 'ID_USER', 'KD_CORP', 'KD_CAB', 'KD_DEP', 'CREATED_AT', 'UPDATED_ALL', 'DATA_ALL'], 'safe'],
            [['nmemp'], 'safe'],
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
		$empId = Yii::$app->user->identity->EMP_ID;
		$dt = Employe::find()->where(['EMP_ID'=>$empId])->all();
		$crp = $dt[0]['EMP_CORP_ID'];
		$depId = $dt[0]['DEP_ID'];
		
		if($dt[0]['GF_ID'] == '3'){
			$query = Salesorder::find()->where("s0001.status <> 3 and s0001.KD_CORP = '$crp' and s0001.KD_DEP = '$depId' ");
		} else {
			$query = Salesorder::find()->where("s0001.status <> 3 and s0001.KD_CORP = '$crp' and s0001.ID_USER = '$empId'  and s0001.KD_DEP = '$depId' ");
		}
		
		$query->joinWith(['employe' => function ($q) {
			$q->where('a0001.EMP_NM LIKE "%' . $this->nmemp . '%"');
		}]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

		 $dataProvider->setSort([
			'attributes' => [
			'KD_RO',
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
		->andFilterWhere(['like', 'KD_RO', $this->KD_RO])
		->andFilterWhere(['like', 'KD_CORP', $this->KD_CORP]);
        return $dataProvider;
    }

    public function cari($params)
    {
        $empId = Yii::$app->user->identity->EMP_ID;
        $dt = Employe::find()->where(['EMP_ID'=>$empId])->all();
        $crp = $dt[0]['EMP_CORP_ID'];
        
        if($dt[0]['JAB_ID'] == 'MGR'){
            $query = Salesorder::find()->where("s0001.status <> 3 and s0001.status <> 0 and s0001.KD_CORP = '$crp' ");
        } else {
            $query = Salesorder::find()->where("s0001.status <> 3 and s0001.status <> 0 and s0001.KD_CORP = '$crp' and s0001.ID_USER = '$empId' ");
        }
        
        $query->joinWith(['employe' => function ($q) {
            $q->where('a0001.EMP_NM LIKE "%' . $this->nmemp . '%"');
        }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         $dataProvider->setSort([
            'attributes' => [
            'KD_RO',
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
        ->andFilterWhere(['like', 'KD_RO', $this->KD_RO])
        ->andFilterWhere(['like', 'KD_CORP', $this->KD_CORP]);
        return $dataProvider;
    }
    
    public function caripo($params)
    {
        $query = Salesorder::find()->where("s0001.status <> 3 and s0001.status <> 0");
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         $dataProvider->setSort([
            'attributes' => [
            'KD_RO',        
            ]
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        $query->andFilterWhere(['like', 'KD_RO', $this->KD_RO]);
        return $dataProvider;
    }
    
}
