<?php

namespace lukisongroup\master\models;

use Yii;

class Nmperusahaan extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'dbc002.lg1001';
    }

    public static function getDb()
    {
        return Yii::$app->get('db_esm'); /*HRD database dbm002*/
    }
    

    public function rules()
    {
        return [
			[['ID','CORP','TYPE'],'required'],
			[['CORP'],'string'],
            [['ID','TYPE'],'integer'],
            [['NM_ALAMAT', 'ALAMAT_LENGKAP', 'KOTA','TLP', 'FAX', 'CP'], 'string'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CORP' => 'CORP',
            'TYPE' => 'TYPE BUILDING',           
            'NM_ALAMAT' => 'Alamat',
            'ALAMAT_LENGKAP' => 'Alamat Lengkap',
			'KKOTA' => 'Kota',
            'TLP' => 'Telephone',
            'FAX' => 'FAX',
            'CP' => 'Contact Person'
        ];
    }
}
