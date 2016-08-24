<?php

namespace lukisongroup\master\models;


use Yii;
use lukisongroup\master\models\DraftPlanGroup;
use lukisongroup\master\models\DraftPlanHeader;
/**
 * This is the model class for table "c0002scdl_plan_detail".
 *
 * @property string $ID
 * @property string $TGL
 * @property string $CUST_ID
 * @property string $USER_ID
 * @property string $SCDL_GROUP
 * @property string $NOTE
 * @property double $LAT
 * @property double $LAG
 * @property double $RADIUS
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class DraftPlanDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     const SCENARIO_APROVE = 'approve';

    public $tglactual;
    public static function tableName()
    {
        return 'c0002scdl_plan_detail';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TGL', 'CREATE_AT', 'UPDATE_AT','ODD_EVEN','SCDL_GROUP','SCDL_GROUP_NM'], 'safe'],
            [['STATUS'], 'integer'],
            [['NOTE'], 'string'],
            [['LAT', 'LAG', 'RADIUS'], 'number'],
            [['CUST_ID'], 'string', 'max' => 50],
             [['CUST_ID'], 'required','on'=>'delete'],
              [['CUST_ID'], 'required','on'=>self::SCENARIO_APROVE],
               [['CUST_ID'], 'exist','on'=>self::SCENARIO_APROVE],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TGL' => 'Tgl',
            'CUST_ID' => 'Cust  ID',
            'ODD_EVEN' => 'OddEven',
            'SCDL_GROUP' => 'Scdl  Group',
            'NOTE' => 'Note',
            'LAT' => 'Lat',
            'LAG' => 'Lag',
            'RADIUS' => 'Radius',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
            'CHECKIN_TIME' => 'Checkin  Time',
            'CHECKOUT_LAT' => 'Checkout  Lat',
            'CHECKOUT_LAG' => 'Checkout  Lag',
            'CHECKOUT_TIME' => 'Checkout  Time',
        ];
    }

    public function exist($model)
    {
     
        $cari_user = DraftPlanGroup::find()->where(['SCL_NM'=>$this->SCDL_GROUP_NM])->one();
        if($cari_user->USER_ID == '')
        {
            $this->addError($model, 'User Pada Customers ini Belum Di Setting Group');
        }
    }
	
	/* JOIN Model Customers*/
	public function getCustTbl()
    {
        return $this->hasOne(Customers::className(), ['CUST_KD' => 'CUST_ID']);
    }	
	
	public function getTbllayer()
    {
        return $this->hasOne(DraftLayer::className(), ['LAYER_ID' => 'LAYER'])->via('custTbl');
    }
	
	public function getCustNm() 
    {
        return $this->custTbl!=''?$this->custTbl->CUST_NM:'none';
    }	
	public function getCustlayernm() 
    {
        return $this->custTbl!=''?$this->custTbl->layerNm:'none';
    }
	
	/* JOIN Model DraftPlanGroup */
	public function getDraftPlanGroupTbl()
    {
        return $this->hasOne(DraftPlanGroup::className(), ['SCDL_GROUP' => 'SCDL_GROUP']);
    }
	public function getUseridNm() 
    {
        return $this->draftPlanGroupTbl!=''?$this->draftPlanGroupTbl->useridNm:'none';
    }
	public function getSalesNm() 
    {
        return $this->draftPlanGroupTbl!=''?$this->draftPlanGroupTbl->SalesNm:'none';
    }
	
	public function getDayofDate(){
		//return date('D', strtotime($this->TGL)); Day Name
		//return date('l', strtotime($this->TGL)); Day Name
		//return date('N', strtotime($this->TGL)); Day value 
		$x=date('N', strtotime($this->TGL));
		
		if ($x==1){
			return "Senin";
		}elseif ($x==2){
			return "Selasa";
		}elseif ($x==3){
			return "Rabu";
		}elseif ($x==4){
			return "Kamis";
		}elseif ($x==5){
			return "Jumat";
		}elseif ($x==6){
			return "Sabtu";
		}elseif ($x==7){
			return "Minggu";
		}else{
			return "None";
		};
		
	}

    
	
	public function getWeekofDate(){
		$a=date('W', strtotime($this->TGL));
		if($a % 2==0){
			$rslt='Genap';
		}elseif($a % 2!=0){
			$rslt='Ganjil';
		}else{
			$rslt='not set';
		}
		return $rslt;
	}
}
