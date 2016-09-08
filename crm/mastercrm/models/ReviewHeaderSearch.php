<?php

namespace crm\mastercrm\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\debug\components\search\Filter;
use yii\debug\components\search\matchers;


class ReviewHeaderSearch extends Model 
{
	
	public $TGL;
	public $USER_ID;
	/*public $USER_NM;
	public $SCDL_GROUP;
	public $SCDL_GRP_NM;
	public $TIME_DAYSTART;
	public $TIME_DAYEND; */
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TGL','USER_ID','USER_NM','SCDL_GROUP','SCDL_GRP_NM','TIME_DAYSTART', 'TIME_DAYEND','HP'], 'safe'],
        ];
    }

    public function searchHeaderReview($params){
		$sqlData=Yii::$app->db_esm->createCommand("
				SELECT  x1.TGL AS TGL,x1.USER_ID AS USER_ID,CONCAT(x6.USER_NM,'-',x6.SALES_NM) as USER_NM,x1.SCDL_GROUP,x7.SCDL_GRP_NM,x6.SALES_NM,x6.HP,
					date_format(x4.WAKTU_MASUK,'%H:%i:%s')AS TIME_DAYSTART,date_format(x4.WAKTU_KELUAR,'%H:%i:%s') AS TIME_DAYEND,
					COMPONEN_selisih_waktu_time(date_format(x4.WAKTU_MASUK,'%H:%i:%s'),date_format(x4.WAKTU_KELUAR,'%H:%i:%s')) AS TTL_TIME,
					x4.LATITUDE_MASUK AS LAT_DAYSTART,x4.LONG_MASUK AS LONG_DAYSTART,
					COMPONEN_radius_distance(x5.LATITUDE,x5.LONG,x4.LATITUDE_MASUK,x4.LONG_MASUK) as DISTANCE_DAYSTART,
					x4.LATITUDE_KELUAR AS LAT_DAYEND,x4.LONG_KELUAR AS LONG_DAYEND,
					COMPONEN_radius_distance(x5.LATITUDE,x5.LONG,x4.LATITUDE_KELUAR,x4.LONG_KELUAR) as DISTANCE_DAYEND					
				FROM c0002scdl_detail x1 LEFT JOIN c0009 x2 on (x2.TGL like x1.TGL AND x2.USER_ID=x1.USER_ID)
				LEFT JOIN c0001 x3 ON x3.CUST_KD=x1.CUST_ID
				LEFT JOIN c0015 x4 ON x4.TGL=x1.TGL AND x4.USER_ID=x1.USER_ID
				LEFT JOIN d0001 x5 on x5.KD_DISTRIBUTOR=x3.KD_DISTRIBUTOR
				LEFT JOIN (	SELECT u1.id as USER_ID, u1.username as  USER_NM, u2.NM_FIRST as SALES_NM,u2.HP
						FROM dbm001.user u1 
						LEFT JOIN dbm_086.user_profile u2 on u2.ID_USER=u1.id
						WHERE u1.POSITION_SITE='CRM' AND u1.POSITION_LOGIN=1 AND u1.POSITION_ACCESS=2
					) x6 on x6.USER_ID=x1.USER_ID
				LEFT JOIN (
						SELECT g1.GEO_ID,GEO_SUB,CONCAT(g1.GEO_DCRIP,'-',g2.GEO_DCRIP) AS SCDL_GRP_NM 
						FROM c0002scdl_geo g1 INNER JOIN c0002scdl_geo_sub g2 on g2.GEO_ID=g1.GEO_ID
						WHERE g1.GEO_ID IS NOT NULL AND g2.GEO_SUB IS NOT NULL
					) x7 on (x7.GEO_ID=LEFT(x1.SCDL_GROUP,1) AND x7.GEO_SUB=RIGHT(x1.SCDL_GROUP,1))
				#WHERE x1.TGL='".$this->TGL."'
				GROUP BY x1.TGL,x1.USER_ID
				ORDER BY x1.USER_ID			
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
}
