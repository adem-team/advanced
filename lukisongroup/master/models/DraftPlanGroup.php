<?php

namespace lukisongroup\master\models;

use Yii;
use lukisongroup\sistem\models\Userlogin;
use lukisongroup\sistem\models\CrmUserprofile;
use lukisongroup\master\models\DraftGeo;

/**
 * This is the model class for table "c0002scdl_plan_group".
 *
 * @property string $SCDL_GROUP
 * @property string $TGL_START
 * @property string $SCL_NM
 * @property string $GEO_ID
 * @property string $LAYER_ID
 * @property integer $DAY_ID
 * @property integer $DAY_VALUE
 * @property string $USER_ID
 * @property integer $STATUS
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_AT
 */
class DraftPlanGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    /*check validation */
    const SCENARIO_EXIST_GROP = 'exist_group';

    const SCENARIO_EXIST_USER = 'exist_user';

    public static function tableName()
    {
        return 'c0002scdl_plan_group';
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
            [['TGL_START', 'CREATED_AT','SUB_GEO', 'UPDATED_AT','SCDL_GROUP','GROUP_PRN','ODD_EVEN','PROSES_ID'], 'safe'],
            [['GEO_ID'], 'existgeosub_plangroup','on'=>self::SCENARIO_EXIST_GROP],
             [['SCL_NM','USER_ID'], 'exist_plan_user','on'=>self::SCENARIO_EXIST_USER],
            [['GEO_ID', 'DAY_ID', 'DAY_VALUE', 'STATUS'], 'integer'],
            [['SCL_NM', 'USER_ID'], 'string', 'max' => 50],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc	
     */
    public function attributeLabels()
    {
        return [
            'SCDL_GROUP' => 'GROUP',
            'GROUP_PRN' => 'PARENT',
            'TGL_START' => 'Tgl  Start',
            'SCL_NM' => 'Scl  Nm',
            'GEO_ID' => 'Geo  ID',
            'DAY_ID' => 'Day  ID',
            'DAY_VALUE' => 'Day  Value',
            'USER_ID' => 'User  ID',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_AT' => 'Updated  At',
        ];
    }
	
	/* JOIN Model DraftPlanHeader */
	public function getUserloginTbl()
    {
        return $this->hasOne(Userlogin::className(), ['id' => 'USER_ID']);
    }
	public function getUseridNm() 
    {
        return $this->userloginTbl!=''?$this->userloginTbl->username:'none';
    }
	
	/* JOIN Model CrmUserprofile | CRM PROFILE */
	public function getCrmUserprofileTbl()
    {
        return $this->hasOne(CrmUserprofile::className(), ['ID' => 'USER_ID']);
    }
	public function getSalesNm() 
    {
        return $this->crmUserprofileTbl!=''?$this->crmUserprofileTbl->NM_FIRST:'none';
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

     public function existgeosub_plangroup($model)
    {
        if(self::getCountgeosub() != 0)
        {
             $this->addError($model, 'Duplicate Group');
        }
    }

    public function getCountgeosub()
    {
        $count = DraftPlanGroup::find()->where(['GEO_ID'=>$this->GEO_ID,'STATUS'=>1])->count();

        return $count;
    }

    public function exist_plan_user($model)
    {

        if(self::getCountuser() != 0)
        {
             $this->addError($model, 'User Aleardy taken');
        }
    }

     public function getCountuser()
    {
        $count = DraftPlanGroup::find()->where(['USER_ID'=>$this->USER_ID,'STATUS'=>1])->count();

        return $count;
    }

    /*ID DISPLY NAMEOF THE DAY*/
    Public function getDayNm(){
        if ($this->DAY_VALUE==1){
            return "Senin";
        }elseif ($this->DAY_VALUE==2){
            return "Selasa";
        }elseif ($this->DAY_VALUE==3){
            return "Rabu";
        }elseif ($this->DAY_VALUE==4){
            return "Kamis";
        }elseif ($this->DAY_VALUE==5){
            return "Jumat";
        }elseif ($this->DAY_VALUE==6){
            return "Sabtu";
        }elseif ($this->DAY_VALUE==7){
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


}
