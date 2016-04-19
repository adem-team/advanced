<?php

namespace crm\salesman\models;

use Yii;
use crm\salesman\models\Schedulegroup;
use crm\salesman\models\Customers;
use lukisongroup\sistem\models\Userlogin;
/**
 * This is the model class for table "c0002scdl_detail".
 *
 * @property integer $ID
 * @property string $TGL
 * @property string $CUST_ID
 * @property string $USER_ID
 * @property integer $SCDL_GROUP
 * @property double $LAT
 * @property double $LAG
 * @property double $RADIUS
 * @property string $NOTE
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class Scheduledetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002scdl_detail';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

	public function getGroup_scdl()
    {
        return $this->hasOne(Schedulegroup::className(), ['ID' => 'SCDL_GROUP']);
    }
	public function getNmgroup()
    {
        return $this->group_scdl->SCDL_GROUP_NM;
    }

	public function getUser()
    {
        return $this->hasOne(Userlogin::className(), ['id' => 'USER_ID']);
    }
	public function getNmuser()
    {
        return $this->user->username;
    }

	public function getCust()
    {
        return $this->hasOne(Customers::className(), ['CUST_KD' => 'CUST_ID']);
    }
	public function getNmcust()
    {
        return $this->cust->CUST_NM;
    }

	public function getSttKoordinat()
    {
        $radius =  $this->RADIUS * 1000;

		if ($radius<=30){
			$stt_Chekin=1;
		}elseif ($radius>30 AND $radius <=60){
			$stt_Chekin=2;
		}elseif($radius>60){
			$stt_Chekin=3;
		};

		return $stt_Chekin;
    }

	public function getRadiusMeter()
    {
		return $this->RADIUS * 1000;;
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TGL', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['SCDL_GROUP', 'STATUS'], 'integer'],
            [['LAT', 'LAG', 'RADIUS'], 'number'],
            [['NOTE'], 'string'],
            [['CUST_ID', 'USER_ID'], 'string', 'max' => 50],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100]
        ];
    }

	/* public function fields()
	{
		return [
			'STATUS'=>function($model){
							return '44';
					},
		];
	}
	 */

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
            'SCDL_GROUP' => 'Scdl  Group',
            'LAT' => 'Lat',
            'LAG' => 'Lag',
            'RADIUS' => 'Radius',
            'NOTE' => 'Note',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
