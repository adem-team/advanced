<?php

namespace lukisongroup\master\models;

use Yii;

use lukisongroup\master\models\Schedulegroup;


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
 * @property string $KD_DISTRIBUTOR
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
class Customers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	// public $tipenm;


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
			       [['CUST_NM','STT_TOKO','KD_DISTRIBUTOR','PROVINCE_ID','CITY_ID'], 'required'],
            // [['CUST_NM','CUST_KTG','JOIN_DATE','KD_DISTRIBUTOR','PROVINCE_ID','CITY_ID','NPWP', 'TLP1','STT_TOKO'], 'required'],
            [['CUST_TYPE','CUST_KTG', 'TLP1', 'TLP2', 'FAX', 'STT_TOKO', 'STATUS','PROVINCE_ID','SCDL_GROUP'], 'integer'],
            [['JOIN_DATE', 'CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['ALAMAT', 'NOTE'], 'string'],
            [['CUST_KD', 'CUST_KD_ALIAS', 'CUST_GRP', 'MAP_LAT', 'MAP_LNG', 'NPWP','KD_DISTRIBUTOR','CITY_ID'], 'string', 'max' => 50],
            [['CUST_NM', 'PIC', 'EMAIL', 'WEBSITE', 'DATA_ALL'], 'string', 'max' => 255],
            [['CAB_ID', 'CORP_ID'], 'string', 'max' => 6],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100]
        ];
    }

	public function getCus()
	{
		return $this->hasOne(Kategoricus::className(), ['CUST_KTG' => 'CUST_KTG']);

	}

	public function getCustype()
	{
		return $this->hasOne(Kategoricus::className(), ['CUST_KTG' => 'CUST_TYPE']);

	}

	public function getCustgrp(){
		return $this->hasOne(Schedulegroup::className(), ['ID'=>'SCDL_GROUP']);		
	}

	public function getGrp_nm()
    {
        return $this->custgrp->SCDL_GROUP_NM;
    }
	
	
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CUST_KTG_NM' => 'Kategori Customers',
            'PARENT' => 'Parent Customer',
            'CITY_ID' => 'KOTA',
            'PROVINCE_ID' => 'PROVINCE',
            'CUST_KD' => 'Kode Customers',
            'CUST_KD_ALIAS' => 'Kode Customers Alias',
            'CUST_NM' => 'Nama Customer',
            'CUST_GRP' => 'Cust  Grp',
            'CUST_KTG' => 'Category',
            'cus.CUST_KTG_NM' => 'Category',
            'CUST_TYPE' => 'Type',

            'JOIN_DATE' => 'Tanggal Gabung',
            'MAP_LAT' => 'Map  Lat',
            'MAP_LNG' => 'Map  Lng',
            'KD_DISTRIBUTOR' => 'Nama Distributor',
            'PIC' => 'PIC Customer',
            'ALAMAT' => 'Alamat',
            'TLP1' => ' Nomer Telepon 1',
            'TLP2' => 'Nomer Telepon 2',
            'FAX' => 'Fax',
            'EMAIL' => 'Email',
            'WEBSITE' => 'Website',
            'NOTE' => 'Note',
            'NPWP' => 'NPWP',
            'STT_TOKO' => 'Status Toko',
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
