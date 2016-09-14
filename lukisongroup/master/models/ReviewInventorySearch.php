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
	public $TGL7; //Dimulai Senen On week
	public $USER_ID;
	public $SO_TYPE;
	public $KD_BARANG;
	public $CUST_ID;
	public $SALES_NM;
	public $CUST_NM;
	public $SCDL_GRP_NM;
	public $SCDL_GROUP;
	public $NM_BARANG;
	public $SO_QTY;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USER_ID','SCDL_GROUP','TGL7','TGL','CUST_ID','CUST_NM','KD_BARANG','NM_BARANG','SO_TYPE','SO_QTY'], 'safe'],
            [['SALES_NM','CUST_NM','SCDL_GRP_NM'], 'string'],
        ];
    }
	/**
	 * SEARCEH FILTER DAILY
	 * @author Piter Novian [ptr.nov@gmail.com]
	*/
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
	 * SEARCEH FILTER WEEKLY
	 * @author Piter Novian [ptr.nov@gmail.com]
	*/
	public function searchWeekly($params,$defaultTglStart,$defaultTglEnd){
		$sqlData1=Yii::$app->db_esm->createCommand("
				SELECT x1.TGL,x1.USER_ID,x5.SALES_NM,x6.SCDL_GRP_NM,x1.SCDL_GROUP,x1.CUST_ID,x3.CUST_NM,x2.KD_BARANG ,x4.NM_BARANG,x2.SO_TYPE, x2.SO_QTY
				FROM c0002scdl_detail x1 INNER JOIN so_t2 x2 ON  x2.TGL=x1.TGL AND x2.CUST_KD=x1.CUST_ID 
				LEFT JOIN c0001 x3 on x3.CUST_KD=x1.CUST_ID
				LEFT JOIN b0001 x4 on x4.KD_BARANG=x2.KD_BARANG
				LEFT JOIN (	SELECT u1.id as USER_ID, u1.username as  USER_NM, u2.NM_FIRST as SALES_NM,u2.HP
					FROM dbm001.user u1 
					LEFT JOIN dbm_086.user_profile u2 on u2.ID_USER=u1.id
					WHERE u1.POSITION_SITE='CRM' AND u1.POSITION_LOGIN=1 AND u1.POSITION_ACCESS=2
				) x5 on x5.USER_ID=x1.USER_ID
				LEFT JOIN (
					SELECT g1.GEO_ID,g2.GEO_SUB,CONCAT(g1.GEO_NM,'.',g2.GEO_SUB) AS SCDL_GRP_NM,
								 g2.START_LAT,g2.START_LONG
					FROM c0002scdl_geo g1 INNER JOIN c0002scdl_geo_sub g2 on g2.GEO_ID=g1.GEO_ID
					WHERE g1.GEO_ID IS NOT NULL AND g2.GEO_SUB IS NOT NULL
				) x6 on (x6.GEO_ID=LEFT(x1.SCDL_GROUP,1) AND x6.GEO_SUB=RIGHT(x1.SCDL_GROUP,1))
				WHERE x1.STATUS<>3 AND x1.TGL BETWEEN '".$defaultTglStart."' and '".$defaultTglEnd."'
				GROUP BY x1.TGL,x1.CUST_ID,x2.KD_BARANG,x1.USER_ID
				ORDER BY x1.TGL,x1.USER_ID, x2.KD_BARANG
		")->queryAll();
			
		$dataProvider1= new ArrayDataProvider([
			'allModels'=>$sqlData1, 
			'pagination' => [
				'pageSize' => 1000,
			]
		]);
		
		if ($this->load($params)) {
			if (!$this->validate()) {
				return $dataProvider1;
			}
 			//return $dataProvider1;
 		}

		$filter = new Filter();
 		$this->addCondition($filter, 'TGL', true);
 		$this->addCondition($filter, 'KD_BARANG', true);
 		$this->addCondition($filter, 'CUST_ID', true);
 		$this->addCondition($filter, 'SALES_NM', true);
 		$this->addCondition($filter, 'USER_ID', true);
 		$this->addCondition($filter, 'SO_TYPE', true);
 		$this->addCondition($filter, 'SCDL_GROUP', true);
 		$dataProvider1->allModels = $filter->filter($sqlData1);

		return $dataProvider1;
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
