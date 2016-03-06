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
	public $TerminalID;
	public $EMP_NM;
	
    /**
     * @inheritdoc	
     */
    public function rules()
    {
        return [
            [['EMP_NM','TerminalID'], 'safe'],
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
	public function dailyFieldTglRange(){
		$dailyAbsensi= Yii::$app->db2->createCommand("CALL absensi_calender('bulan','2016-03-23')")->queryAll();  
		$aryData= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$dailyAbsensi,			
			'pagination' => [
				'pageSize' => 50,
			]
		]);
		$attributeField=$aryData->allModels[0];
		
		return $attributeField;
	}	
    public function searchDailyTglRange($params){
		$dailyAbsensi= Yii::$app->db2->createCommand("CALL absensi_calender('bulan','2016-03-23')")->queryAll();  
		$dataProvider= new ArrayDataProvider([
			//'key' => 'ID',
			'allModels'=>$dailyAbsensi,			
			'pagination' => [
				'pageSize' => 500,
			]
		]);
		if (!($this->load($params) && $this->validate())) {
 			return $dataProvider;
 		}
		
		$filter = new Filter();
 		$this->addCondition($filter, 'TerminalID', true);
 		$this->addCondition($filter, 'EMP_NM', true);	
 		$dataProvider->allModels = $filter->filter($dailyAbsensi);
		
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
