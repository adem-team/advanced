<?php

namespace lukisongroup\master\models;

use Yii;
use lukisongroup\master\models\DraftGeo;
use lukisongroup\master\models\DraftLayer;
Use ptrnov\salesforce\Jadwal;

/**
 * This is the model class for table "c0002scdl_plan".
 *
 * @property string $ID
 * @property string $CUST_KD
 * @property string $GEO_ID
 * @property string $LAYER_ID
 * @property integer $DAY_ID
 * @property integer $DAY_VALUE
 * @property integer $STATUS
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_AT
 */
 
class DraftPlan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
   
	public $displyGeoId;
	public $displyGeoNm;
    public static function tableName()
    {
        return 'c0002scdl_plan';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }
	/* JOIN Model Customers*/
	public function getCustTbl()
    {
        return $this->hasOne(Customers::className(), ['CUST_KD' => 'CUST_KD']);
    }	
	public function getCustNm() 
    {
        return $this->custTbl!=''?$this->custTbl->CUST_NM:'none';
    }	
	/*JOIN GEO*/
    public function getGeoTbl()
    {
        return $this->hasOne(DraftGeo::className(), ['GEO_ID' => 'GEO_ID']);

    }
	public function getGeoNm() 
    {
        return $this->geoTbl!=''?$this->geoTbl->GEO_NM:'NotSet';
    }
	public function getGeoDcrip() 
    {
        return $this->geoTbl!=''?$this->geoTbl->GEO_DCRIP:'';
    }

	/*JOIN GEO SUB*/
    public function getGeoSubTbl()
    {
        //return $this->hasOne(DraftGeoSub::className(), ['GEO_ID' => $this->geoTbl->GEO_ID,'GEO_SUB' => 'GEO_SUB']);
        return $this->hasOne(DraftGeoSub::className(), ['GEO_ID' =>'GEO_ID','GEO_SUB' => 'GEO_SUB']);

    }
	public function getGeoSub() 
    {
        return $this->geoSubTbl!=''?$this->geoSubTbl->GEO_SUB:'NotSet';
    }
	
	/*JOIN LAYER*/
    public function getLayerTbl()
    {
        return $this->hasOne(DraftLayer::className(), ['LAYER_ID' => 'LAYER_ID']);

    }	
	public function getLayerNm() 
    {
        return $this->layerTbl!=''?$this->layerTbl->LAYER_NM:'NotSet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CUST_KD'], 'required'],
            [['GEO_ID', 'GEO_SUB','LAYER_ID', 'DAY_ID', 'DAY_VALUE', 'STATUS','PROSES_ID','YEAR'], 'integer'],
            //[['ODD_EVEN','CREATED_AT','IdDinamikScdl', 'UPDATED_AT','displyGeoId','displyGeoNm'], 'safe'],
            [['ODD_EVEN','CREATED_AT','IdDinamikScdl', 'UPDATED_AT','displyGeoId','displyGeoNm'], 'safe'],
            [['CUST_KD'], 'string', 'max' => 50],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CUST_KD' => 'Cust  Kd',
            'GEO_ID' => 'GEO',
            'GEO_SUB' => 'GEO_SUB',
            'LAYER_ID' => 'Layer  ID',
            'DAY_ID' => 'Day  ID',
            'DAY_VALUE' => 'Day  Value',
            'ODD_EVEN' => 'ODD EVEN',
            'PROSES_ID' => 'PROSES',
            'YEAR' => 'YEAR',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_AT' => 'Updated  At',
        ];
    }
	
	/*ID DISPLY NAMEOF THE DAY*/
	Public function getDayNm(){
		if ($this->DAY_VALUE==1){
			return "Senin";
		}elseif ($this->DAY_ID==2){
			return "Selasa";
		}elseif ($this->DAY_ID==3){
			return "Rabu";
		}elseif ($this->DAY_ID==4){
			return "Kamis";
		}elseif ($this->DAY_ID==5){
			return "Jumat";
		}elseif ($this->DAY_ID==6){
			return "Sabtu";
		}elseif ($this->DAY_ID==7){
			return "Minggu";
		}else{
			return "NotSet";
		}
	}
	
	public function getGanjilGenap(){
		$a=$this->ODD_EVEN;
		if($a!=''){
			if($a % 2==0){
				$rslt='Genap';
			}elseif($a % 2!=0){
				$rslt='Ganjil';
			}else{
				$rslt='NotSet';
			}
		}else{
			$rslt='NotSet';
		}
		return $rslt;
	}
	/*
	 * ID DINAMIK SCHEDULING
	 * FORMULA SCHEDULE | MAPING BY [GEO,subGEO,ODD_EVEN,DAY,PROSES_ID]
	 * @author ptrnov [ptr.nov@gmail.com] @since 1.0.0, 1.5.0,
	 * @author wawan [wawan@gmail.com] @since 1.3.0
	*/
	public function getIdDinamikScdl(){
		$geo=$this->GEO_ID; 					//GET FROM CUSTOMER GEO
		$subGeo=$this->GEO_SUB;					//SET BY FORM GUI
		$pekanGanjilGenap=$this->ODD_EVEN;		//SET BY FORM GUI
		$dayNilai=$this->DAY_VALUE;				//SET BY FORM GUI		
		$proses=$this->PROSES_ID;				//SET BY FORM GUI DEFAULT =1 (ACTIVE CALL)
		if ($geo!=''){							// GEO = check semua customer dalam group GEO
			if ($subGeo!=''){					// Check SubGeo Validation scenario  jika jumlah customer dalam (GEO+HARI) Full, harus new SubGeo.
				if ($pekanGanjilGenap!=''){		// Check hari of week[ganjil/genap] Validation scenario jumlah customer sesuai max default/max MIX
					if ($dayNilai!=''){			// Check Layer B=u  or A,B,C,D=m
						if ($proses!=''){		// Check Layer B=u  or A,B,C,D=m
							$valueFormua= $geo .'.'.$subGeo.'.'.$pekanGanjilGenap.'.'.$dayNilai.'.'.$proses;   
						}else{
							$valueFormua= "NotSet";
						}
					}else{
						$valueFormua= "NotSet";
					}
				}else{
					if ($dayNilai!=''){			// Check Layer B=u  or A,B,C,D=m
						if ($proses!=''){		// Check Layer B=u  or A,B,C,D=m
							$valueFormua= $geo .'.'.$subGeo.'.0.'.$dayNilai.'.'.$proses;   
						}else{
							$valueFormua= "NotSet";
						}
					}else{
						$valueFormua= "NotSet";
					}
				}
			}else{
				$valueFormua= "NotSet";	
			}			
		}else{
			$valueFormua= "NotSet";
		}
		return $valueFormua;
	}

	

}
