<?php

namespace lukisongroup\models\esm;

use Yii;

/**
 * This is the model class for table "c0001".
 *
 * @property string $CUST_KD
 * @property string $CUST_NM
 * @property string $ALAMAT
 * @property string $PIC
 * @property string $TLP1
 * @property string $TLP2
 * @property string $FAX
 * @property string $EMAIL
 * @property string $WEBSITE
 * @property string $NOTE
 * @property integer $STATUS
 * @property string $NPWP
 * @property integer $STT_TOKO
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 * @property string $UPDATED_BY
 * @property string $DATA_ALL
 * @property string $EMP_ID
 * @property string $PARRENT
 * @property string $GEO_KOORDINAT
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0001';
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
            [['CUST_KD', 'CUST_NM', 'ALAMAT', 'PIC', 'EMAIL','NOTE', 'STATUS','CREATED_BY', 'CREATED_AT'], 'required'],
            [['ALAMAT', 'NOTE'], 'string'],
            [['TLP1', 'TLP2', 'FAX', 'STATUS', 'STT_TOKO'], 'integer'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['CUST_KD', 'NPWP', 'GEO_KOORDINAT'], 'string', 'max' => 50],
            [['CUST_NM', 'PIC', 'EMAIL', 'WEBSITE', 'CREATED_BY', 'UPDATED_BY', 'DATA_ALL'], 'string', 'max' => 255],
            [['EMP_ID', 'PARRENT'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CUST_KD' => 'Cust  Kd',
            'CUST_NM' => 'Cust  Nm',
            'ALAMAT' => 'Alamat',
            'PIC' => 'Pic',
            'TLP1' => 'Tlp1',
            'TLP2' => 'Tlp2',
            'FAX' => 'Fax',
            'EMAIL' => 'Email',
            'WEBSITE' => 'Website',
            'NOTE' => 'Note',
            'STATUS' => 'Status',
            'NPWP' => 'Npwp',
            'STT_TOKO' => 'Stt  Toko',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_AT' => 'Updated  At',
            'UPDATED_BY' => 'Updated  By',
            'DATA_ALL' => 'Data  All',
            'EMP_ID' => 'Emp  ID',
            'PARRENT' => 'Parrent',
            'GEO_KOORDINAT' => 'Geo  Koordinat',
        ];
    }
}
