<?php

namespace lukisongroup\purchasing\models\salesmanorder;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\debug\components\search\Filter;
use yii\debug\components\search\matchers;
use lukisongroup\purchasing\models\salesmanorder\SoT2;
/**
 * Salesman Order Header.
 * @uthor piter novian [ptr.nov@gmail.com].
 */
class SoDetailSearch extends SoT2
{	
	public $TGL;
	public $CUST_KD;
	public $KD_BARANG;
	public $USER_ID;
	public $SUBMIT_QTY;
	public $ID;
	
    /**
     * @inheritdoc	
     */
    public function rules()
    {
        return [
            [['TGL','CUST_KD','KD_BARANG','USER_ID','TerminalID','SUBMIT_QTY','ID'], 'safe'],
        ];
    }

   	/*
	 * Search Manual Query
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 *
	*/
	public function searchDetail($params){
		$soQueryJoin= Yii::$app->db_esm->createCommand("
			SELECT x1.ID,x1.TGL,x1.WAKTU_INPUT_INVENTORY,x1.CUST_KD,x1.CUST_NM,x1.KD_BARANG,x1.NM_BARANG,x1.SO_QTY,x1.SO_TYPE,x1.POS,x1.STATUS,x1.ID_GROUP,
				x1.HARGA_PABRIK,x1.HARGA_DIS,x1.HARGA_LG,x1.HARGA_SALES,
				x1.KODE_REF,x1.USER_ID,x2.username,x3.NM_FIRST,x1.SUBMIT_QTY,x1.SUBMIT_PRICE,x1.NOTED,x4.ISI_MESSAGES,x5.CHECKIN_TIME,x5.CHECKOUT_TIME,
				x6.PIC,x6.TLP1,x6.KTP,x6.NPWP,x6.SIUP,x6.ALAMAT,x6.JOIN_DATE,x6.TLP1,x6.TLP2,x8.NM_UNIT,x8.QTY AS UNIT_QTY,x7.HARGA_SALES,
				(x1.SO_QTY/x8.QTY) AS UNIT_BRG,
				(x1.SO_QTY * x7.HARGA_SALES) as SUB_TOTAL,
				(x1.SUBMIT_QTY * x1.SUBMIT_PRICE) as SUBMIT_SUB_TOTAL,
				x1.KODE_REF,x9.USER_SIGN1,x9.TGL_SIGN2,x9.USER_SIGN2,x9.TGL_SIGN3,x9.USER_SIGN3
			FROM so_t2 x1 
				LEFT JOIN dbm001.user x2 ON x2.id=x1.USER_ID
				LEFT JOIN dbm_086.user_profile x3 ON x3.ID_USER=x2.id
				LEFT JOIN c0014 x4 on x4.TGL=x1.TGL AND x4.ID_USER=x1.USER_ID
				LEFT JOIN c0002scdl_detail x5 on x5.TGL=x1.TGL AND x5.CUST_ID=x1.CUST_KD
				LEFT JOIN c0001 x6 on x6.CUST_KD=x1.CUST_KD
				LEFT JOIN b0001 x7 on x7.KD_BARANG=x1.KD_BARANG
				LEFT JOIN ub0001 x8 on x8.KD_UNIT=x7.KD_UNIT
				LEFT JOIN so_0001 x9 on x9.KD_SO=x1.KODE_REF
			WHERE x1.SO_TYPE=10 AND x1.TGL='".$this->TGL."' AND x1.CUST_KD='".$this->CUST_KD."';
			#CUS.2016.000638,CUS.2016.000619		
		")->queryAll();  
		
		$dataProvider= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$soQueryJoin,			
			'pagination' => [
				'pageSize' => 50,
			]
		]);
		
		if (!($this->load($params) && $this->validate())) {
 			return $dataProvider;
 		}
		
		$filter = new Filter();
 		$this->addCondition($filter, 'TGL', true);
 		$this->addCondition($filter, 'CUST_KD', true);	
 		$this->addCondition($filter, 'KD_BARANG', true);	
 		$this->addCondition($filter, 'USER_ID', true);	
 		$dataProvider->allModels = $filter->filter($soQueryJoin);
		
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
