<?php

namespace lukisongroup\esm\models;

use Yii;

/**
 * This is the model class for table "c0001".
 *
 * @property string $CUST_KD
 * @property string $CUST_KD_ALIAS
 * @property string $CUST_NM
 * @property string $CUST_GRP
 * @property integer $CUST_KTG
 * @property string $JOIN_DATE
 * @property string $MAP_LAT
 * @property string $MAP_LNG
 * @property string $PIC
 * @property string $ALAMAT
 * @property integer $TLP1
 * @property integer $TLP2
 * @property integer $FAX
 * @property string $EMAIL
 * @property string $WEBSITE
 * @property string $NOTE
 * @property string $NPWP
 * @property integer $STT_TOKO
 * @property string $DATA_ALL
 * @property string $CAB_ID
 * @property string $CORP_ID
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_AT
 * @property integer $STATUS
 */
class Customerskat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	  public $parent;
    public static function tableName()
    {
        return 'c0001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db3');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CUST_KD', 'CUST_NM','STATUS'], 'required'],
            [['CUST_KTG', 'TLP1', 'TLP2', 'FAX', 'STT_TOKO', 'STATUS'], 'integer'],
            [['JOIN_DATE', 'CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['ALAMAT', 'NOTE'], 'string'],
            [['CUST_KD', 'CUST_KD_ALIAS', 'CUST_GRP', 'MAP_LAT', 'MAP_LNG', 'NPWP','KD_DISTRIBUTOR','PROVINCE_ID','CITY_ID'], 'string', 'max' => 50],
            [['CUST_NM', 'PIC', 'EMAIL', 'WEBSITE', 'DATA_ALL'], 'string', 'max' => 255],
            [['CAB_ID', 'CORP_ID'], 'string', 'max' => 6],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CUST_KD' => 'Cust  Kd',
            'CUST_KD_ALIAS' => 'Cust  Kd  Alias',
            'CUST_NM' => 'Cust  Nm',
            'CUST_GRP' => 'Cust  Grp',
            'CUST_KTG' => 'Cust  Ktg',
            'JOIN_DATE' => 'Join  Date',
            'MAP_LAT' => 'Map  Lat',
            'MAP_LNG' => 'Map  Lng',
            'PIC' => 'Pic',
            'ALAMAT' => 'Alamat',
            'TLP1' => 'Tlp1',
            'TLP2' => 'Tlp2',
            'FAX' => 'Fax',
            'EMAIL' => 'Email',
            'WEBSITE' => 'Website',
            'NOTE' => 'Note',
            'NPWP' => 'Npwp',
            'STT_TOKO' => 'Stt  Toko',
            'DATA_ALL' => 'Data  All',
            'CAB_ID' => 'Cab  ID',
            'CORP_ID' => 'Corp  ID',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_AT' => 'Updated  At',
            'STATUS' => 'Status',
        ];
    }
}
