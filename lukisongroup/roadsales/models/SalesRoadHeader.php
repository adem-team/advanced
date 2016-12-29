<?php

namespace lukisongroup\roadsales\models;

use Yii;
use lukisongroup\sistem\models\Userlogin;
use lukisongroup\hrd\models\Employe;

/**
 * This is the model class for table "c0022Header".
 *
 * @property integer $ROAD_D
 * @property string $USER_ID
 * @property string $CASE_ID
 * @property string $CASE_NOTE
 * @property double $LAT
 * @property double $LAG
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 */
class SalesRoadHeader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0022Header';
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
            [['JUDUL','CASE_ID','CASE_NM', 'CASE_NOTE','CUSTOMER'], 'string'],
            [['LAT', 'LAG'], 'number'],
            [['CREATED_AT','TGL'], 'safe'],
            [['USER_ID'], 'string', 'max' => 50],
            [['CREATED_BY'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ROAD_D' => 'Road.ID',
            'USER_ID' => 'User.ID',
            'JUDUL' => 'Judul',
            'CASE_ID' => 'Case.ID',
            'CUSTOMER' => 'Customer',
            'CASE_NM' => 'Case Name',
            'CASE_NOTE' => 'Note',
            'LAT' => 'Lat',
            'LAG' => 'Lag',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'TGL' => 'Date',
        ];
    }
	
	// public function getTGL(){
		// return Yii::$app->formatter->asDate($this->CREATED_AT,'php:Y-m-d');
	// }
	
	public function getUserTbl()
    {
        return $this->hasOne(Userlogin::className(), ['id' => 'USER_ID']);
	}
	
	public function getUsername(){
		return $this->userTbl!=''?$this->userTbl->username:'';
	}	
	
	public function getEmpTbl()
    {
		return $this->hasOne(Employe::className(), ['EMP_ID' => 'EMP_ID'])->via('userTbl');
    }
	public function getEmployeNm(){
		 return $this->empTbl!=''?$this->empTbl->EMP_NM:'';
	}	
	
	
}
