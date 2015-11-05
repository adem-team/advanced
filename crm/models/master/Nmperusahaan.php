<?php

namespace lukisongroup\models\master;

use Yii;

class Nmperusahaan extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'dbm000.p1001';
    }

    public static function getDb()
    {
        return Yii::$app->get('db4');
    }
    

    public function rules()
    {
        return [
            [['NM_ALAMAT', 'ALAMAT_LENGKAP', 'TLP', 'FAX', 'CP'], 'safe'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NM_ALAMAT' => 'Alamat',
            'ALAMAT_LENGKAP' => 'Alamat Lengkap',
            'TLP' => 'Telephone',
            'FAX' => 'FAX',
            'CP' => 'Contact Person'
        ];
    }
}
