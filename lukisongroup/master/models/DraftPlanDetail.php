<?php

namespace lukisongroup\master\models;

use Yii;

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
 * @property string $CHECKIN_TIME
 * @property double $CHECKOUT_LAT
 * @property double $CHECKOUT_LAG
 * @property string $CHECKOUT_TIME
 */
class DraftPlanDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
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
            [['TGL', 'CREATE_AT', 'UPDATE_AT', 'CHECKIN_TIME', 'CHECKOUT_TIME','ODD_EVEN'], 'safe'],
            [['SCDL_GROUP', 'STATUS'], 'integer'],
            [['NOTE'], 'string'],
            [['LAT', 'LAG', 'RADIUS', 'CHECKOUT_LAT', 'CHECKOUT_LAG'], 'number'],
            [['CUST_ID', 'USER_ID'], 'string', 'max' => 50],
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
            'USER_ID' => 'User  ID',
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
	
	/* DEPATMENT JOIN | GET NAME */
	public function getCustTbl()
    {
        return $this->hasOne(Customers::className(), ['CUST_KD' => 'CUST_ID']);
    }
	public function getCustNm() //DetailView Value Name
    {
        return $this->custTbl!=''?$this->custTbl->CUST_NM:'none';
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
