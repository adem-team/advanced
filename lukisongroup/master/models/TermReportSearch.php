<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\debug\components\search\Filter;
use yii\debug\components\search\matchers;

/**
 * PersonallogSearch represents the model behind the search form about `lukisongroup\hrd\models\Personallog`.
 */
class TermReportSearch extends Model
{	
	public $ID_TERM;
	public $CUST_KD;
	public $INVES_TYPE;
	public $BUDGET_SOURCE;
	public $STATUS;
	public $BUDGET_PLAN;
	public $BUDGET_ACTUAL;
	public $NM_TERM;
	public $CUST_NM;
	
    /**
     * @inheritdoc	
     */
    public function rules()
    {
        return [
            [['ID_TERM','CUST_KD','INVES_TYPE','BUDGET_SOURCE','BUDGET_PLAN','BUDGET_ACTUAL','CUST_NM','STATUS','NM_TERM'], 'safe'],
        ];
    }

   	public function getScripts(){
		return Yii::$app->db2->createCommand("CALL absensi_log('bulan','2016-03-23');")->queryAll();             
	}
		
	/*
	 * REKAP DAILY DATA ABSENSI
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 *
	*/
	/*public function dailyFieldTglRange(){
	 	$dailyAbsensi= Yii::$app->esm->createCommand("CALL ESM_SALES_term_report()")->queryAll();  
		$aryData= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$dailyAbsensi,			
			'pagination' => [
				'pageSize' => 50,
			]
		]);
		$attributeField=$aryData->allModels[0];
		
		return $attributeField;
	}	 */
    public function searchTermRpt($params){
		$termRpt= Yii::$app->db_esm->createCommand("CALL ESM_SALES_term_report()")->queryAll();  
		$dataProvider= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$termRpt,			
			'pagination' => [
				'pageSize' => 500,
			]
		]);
		if (!($this->load($params) && $this->validate())) {
 			return $dataProvider;
 		}
		
		$filter = new Filter();
 		$this->addCondition($filter,'CUST_NM',true);
 		$this->addCondition($filter, 'STATUS', true);	
 		$dataProvider->allModels = $filter->filter($termRpt); 
		
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
