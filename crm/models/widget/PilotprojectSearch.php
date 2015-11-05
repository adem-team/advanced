<?php

namespace lukisongroup\models\widget;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\system\user\UserloginSearch;
use lukisongroup\models\widget\Pilotproject;

class PilotprojectSearch extends Pilotproject
{
    
	
    public function rules()
    {
        return [
            [['ID', 'PARENT','PILOT_ID','STATUS','SORT','BOBOT'], 'integer'],
            [['PILOT_NM','PLAN_DATE1', 'PLAN_DATE2','ACTUAL_DATE1', 'ACTUAL_DATE2', 'CORP_ID', 'DEP_ID'], 'safe'],
			[['DESTINATION_TO'], 'string', 'max' => 50]
        ];
    }

    
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
	  * PilotprojectSearch searchDept
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	*/
    public function searchDept($params)
    {
		$profile=Yii::$app->getUserOpt->Profile_user();
        $query = Pilotproject::find()->Where('sc0001.STATUS<>3 AND DEP_ID="'.$profile->emp->DEP_ID .'"');

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
            'PARENT' => $this->PARENT,
			'SORT' => $this->SORT,
			'PILOT_ID' => $this->PILOT_ID,
			'PILOT_NM' => $this->PILOT_NM,
			'DSCRP' => $this->DSCRP,			
            'PLAN_DATE1' => $this->PLAN_DATE1,
            'PLAN_DATE2' => $this->PLAN_DATE2,
            'ACTUAL_DATE1' => $this->ACTUAL_DATE1,
            'ACTUAL_DATE2' => $this->ACTUAL_DATE2,
			'DESTINATION_TO'=>$this->DESTINATION_TO,
			'BOBOT'=>$this->BOBOT,
            'STATUS' => $this->STATUS,				
        ]);

        $query->andFilterWhere(['like', 'PILOT_NM', $this->PILOT_NM])
            ->andFilterWhere(['like', 'CORP_ID', $this->CORP_ID])
            ->andFilterWhere(['like', 'DEP_ID', $this->DEP_ID]);
		
		$query->orderby(['SORT'=>SORT_ASC]); //SORT PENTING UNTUK RECURSIVE BIAR TREE BISA URUTAN, save => (IF (PATENT =0) {SORT=ID}, ELSE {SORT=PATENT}, note Parent=ID header
			
        return $dataProvider;
    }
	
	/**
	  * PilotprojectSearch searchEmp
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	*/
    public function searchEmp($params)
    {
		/*COMPONENT USER OPTION */
		$profile=Yii::$app->getUserOpt->Profile_user();
		
        //$query = Pilotproject::find()->Where('sc0001.STATUS<>3 AND CREATED_BY='. Yii::$app->user->identity->id .' AND DEP_ID="'.$this->gtDeptid() .'"');
		//$query = Pilotproject::find()->Where('sc0001.STATUS<>3 AND CREATED_BY='. Yii::$app->user->identity->id .' AND DEP_ID="'.$this->getOptUser()->emp->DEP_ID .'"');
		//$query = Pilotproject::find()->Where('sc0001.STATUS<>3 AND CREATED_BY='. Yii::$app->user->identity->id .' AND DEP_ID="'.Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID .'"');
		$query = Pilotproject::find()
				->andWhere('sc0001.STATUS<>3 AND DEP_ID="'.$profile->emp->DEP_ID .'" AND CREATED_BY='. Yii::$app->user->identity->id)
				->orWhere('DESTINATION_TO='.$profile->id);
		

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
            'PARENT' => $this->PARENT,
			'SORT' => $this->SORT,
			'PILOT_ID' => $this->PILOT_ID,
			'PILOT_NM' => $this->PILOT_NM,
			'DSCRP' => $this->DSCRP,			
            'PLAN_DATE1' => $this->PLAN_DATE1,
            'PLAN_DATE2' => $this->PLAN_DATE2,
            'ACTUAL_DATE1' => $this->ACTUAL_DATE1,
            'ACTUAL_DATE2' => $this->ACTUAL_DATE2,
			'DESTINATION_TO'=>$this->DESTINATION_TO,
			'BOBOT'=>$this->BOBOT,
            'STATUS' => $this->STATUS,				
        ]);

        $query->andFilterWhere(['like', 'PILOT_NM', $this->PILOT_NM])
            ->andFilterWhere(['like', 'CORP_ID', $this->CORP_ID])
            ->andFilterWhere(['like', 'DEP_ID', $this->DEP_ID]);
		
		$query->orderby(['SORT'=>SORT_ASC]); //SORT PENTING UNTUK RECURSIVE BIAR TREE BISA URUTAN, save => (IF (PATENT =0) {SORT=ID}, ELSE {SORT=PATENT}, note Parent=ID header
			
        return $dataProvider;
    }
	
	/**
	  * GetDEP_ID from UserID UserloginSearch()
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	*/
	//protected function gtDeptid(){
	//	$UserloginSearch = new UserloginSearch();	
	//	$ModelUser = UserloginSearch::findUserAttr(Yii::$app->user->identity->id)->one();
	//	if (count($ModelUser)<>0){ /*RECORD TIDAK ADA*/
	//		$deptid=$ModelUser->emp->DEP_ID;			
	//		return $deptid;
	//	} else{
	//		return 0;
	//	}
	//}
	
	/**
	  * GetDEP_ID from UserID UserloginSearch()
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	*/
	
	protected function getOptUser(){
		$UserloginSearch = new UserloginSearch();	
		$ModelUser = UserloginSearch::findUserAttr(Yii::$app->user->identity->id)->one();
		if (count($ModelUser)<>0){ /*RECORD TIDAK ADA*/
			//$deptid=$ModelUser->user->id;			
			//$deptid=$ModelUser->emp->DEP_ID;			
			return $ModelUser;
		} else{
			return 0;
		}
		
	}
}
