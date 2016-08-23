<?php

namespace crm\mastercrm\models;

use Yii;

use lukisongroup\sistem\models\Userlogin;
use lukisongroup\sistem\models\CrmUserprofile;
/**
 * This is the model class for table "c0002scdl_plan_header".
 *
 * @property string $ID
 * @property string $TGL
 * @property string $SCDL_GROUP
 * @property string $NOTE
 * @property string $USER_ID
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property integer $STT_UBAH
 * @property string $UPDATE_AT
 */
class DraftPlanHeader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002scdl_plan_header';
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
            [['TGL', 'CREATE_AT', 'UPDATE_AT','SCDL_GROUP'], 'safe'],
            [[ 'STATUS', 'STT_UBAH'], 'integer'],
            [['NOTE'], 'string'],
            [['USER_ID'], 'string', 'max' => 50],
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
            'SCDL_GROUP' => 'Scdl  Group',
            'NOTE' => 'Note',
            'USER_ID' => 'User  ID',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'STT_UBAH' => 'Stt  Ubah',
            'UPDATE_AT' => 'Update  At',
        ];
    }
	
	/* JOIN Model Sistem/Userlogin */
	public function getUserloginTbl()
    {
        return $this->hasOne(Userlogin::className(), ['id' => 'USER_ID']);
    }
	public function getUseridNm() 
    {
        return $this->userloginTbl!=''?$this->userloginTbl->username:'none';
    }
	
	/* JOIN Model sistem/CrmUserprofile | CRM PROFILE */
	public function getCrmUserprofileTbl()
    {
        return $this->hasOne(CrmUserprofile::className(), ['ID' => 'USER_ID']);
    }
	public function getSalesNm() 
    {
        return $this->crmUserprofileTbl!=''?$this->crmUserprofileTbl->NM_FIRST:'none';
    }
}
