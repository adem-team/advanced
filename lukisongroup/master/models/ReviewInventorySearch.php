<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\debug\components\search\Filter;
use yii\debug\components\search\matchers;


class ReviewInventorySearch extends Model 
{
	
	public $TGL;
	public $USER_ID;
	public $SO_TYPE;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USER_ID','SCDL_GROUP','TGL','CUST_ID','CUST_NM','KD_BARANG','NM_BARANG','SO_TYPE','SO_QTY'], 'safe'],
        ];
    }

    public function search($params){
		$sqlData=Yii::$app->db_esm->createCommand("
				SELECT x1.USER_ID,x1.SCDL_GROUP,x1.TGL,x1.CUST_ID,x3.CUST_NM,x2.KD_BARANG ,x4.NM_BARANG,x2.SO_TYPE, x2.SO_QTY
				FROM c0002scdl_detail x1 INNER JOIN so_t2 x2 ON  x2.TGL=x1.TGL AND x2.CUST_KD=x1.CUST_ID 
				LEFT JOIN c0001 x3 on x3.CUST_KD=x1.CUST_ID
				LEFT JOIN b0001 x4 on x4.KD_BARANG=x2.KD_BARANG
				WHERE x1.STATUS<>3 AND x1.TGL='".$this->TGL."'
				ORDER BY x1.USER_ID, x1.TGL,x2.KD_BARANG
			")->queryAll();
			
		$dataProvider= new ArrayDataProvider([
			'allModels'=>$sqlData, 
			'pagination' => [
				'pageSize' => 50,
			]
		]);
		
		if ($this->load($params)) {
 			return $dataProvider;
 		}

		$filter = new Filter();
 		$this->addCondition($filter, 'TGL', true);
 		$this->addCondition($filter, 'USER_ID', true);
 		$this->addCondition($filter, 'SO_TYPE', true);
 		$dataProvider->allModels = $filter->filter($sqlData);

		return $dataProvider;
	}
	
	
	/**
	 * SEARCEH FILTER
	 * @author Piter Novian [ptr.nov@gmail.com]
	*/
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
	
	public function attributeLabels()
    {
        return [
            'CUST_ID'=>'CUSTMER.ID',
			'CUST_NM'=> 'CUSTMER'
        ];
    }
}
