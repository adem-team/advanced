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

    public function getCustgeo()
    {
        return $this->hasOne(DraftGeo::className(), ['GEO_ID' => 'GEO_ID']);

    }

     public function getCustlayer()
    {
        return $this->hasOne(DraftLayer::className(), ['LAYER_ID' => 'LAYER_ID']);

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CUST_KD'], 'required'],
            [['GEO_ID', 'LAYER_ID', 'DAY_ID', 'DAY_VALUE', 'STATUS','ODD_EVEN'], 'integer'],
            [['CREATED_AT','IdDinamikScdl', 'UPDATED_AT'], 'safe'],
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
            'GEO_ID' => 'Geo  ID',
            'LAYER_ID' => 'Layer  ID',
            'DAY_ID' => 'Day  ID',
            'DAY_VALUE' => 'Day  Value',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_AT' => 'Updated  At',
        ];
    }
	
	/*ID DISPLY NAMEOF THE DAY*/
	Public function getDayNm(){
		if ($this->DAY_ID==1){
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
			return "None";
		}
	}
	
	/*
	 * ID DINAMIK SCHEDULING
	 * FORMULA SCHEDULE ID | MAPING BY [GEO,subGEO,DAY,LAYER]
	 * @author ptrnov [ptr.nov@gmail.com] @since 1.0.0, 1.5.0,
	 * @author wawan [wawan@gmail.com] @since 1.3.0
	*/
	public function getIdDinamikScdl(){
		$geo=$this->custgeo->GEO_NM;
		$subGeo=1;
		$pekanGanjilGenap=$this->ODD_EVEN;	
		$dayNilai=$this->DAY_VALUE;		
		$layerStt='n';
		if ($geo!=''){// GEO = check semua customer dalam group GEO
			if ($subGeo!=''){// Check SubGeo Validation scenario  jika jumlah customer dalam (GEO+HARI) Full, harus new SubGeo.
				if ($pekanGanjilGenap!=''){// Check hari of week[ganjil/genap] Validation scenario jumlah customer sesuai max default/max MIX
					if ($dayNilai!=''){// Check Layer B=u  or A,B,C,D=m
						if ($layerStt!=''){// Check Layer B=u  or A,B,C,D=m
							$valueFormua= $geo .'.'.$subGeo.'.'.$pekanGanjilGenap.'.'.$dayNilai.'.'.$layerStt;   
						}else{
							$valueFormua= "NotSet";
						}
					}else{
						$valueFormua= "NotSet";
					}
				}else{
					$valueFormua= "NotSet";
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
