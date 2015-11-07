<?php

namespace crm\salespromo\models;

use Yii;

/**
 * This is the model class for table "{{%sp001}}".
 *
 * @property integer $ID
 * @property string $WAKTU
 * @property string $CUST_KD
 * @property string $CUST_NM
 * @property string $KD_BARANG
 * @property string $NM_BARANG
 * @property integer $STOCK_SOLD_OUT
 * @property integer $PRODAK_LINE
 * @property string $CORP_ID
 * @property string $KD_DISTRIBUTOR
 * @property string $KD_SUBDIST
 * @property string $CREATED_BY
 * @property string $UPDATED_BY
 * @property string $UPDATED_TIME
 * @property integer $STATUS
 */
class Penjualan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sp001}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['WAKTU', 'UPDATED_TIME'], 'safe'],
            [['STOCK_SOLD_OUT', 'PRODAK_LINE', 'STATUS'], 'integer'],
            [['UPDATED_BY'], 'required'],
            [['CUST_KD', 'KD_BARANG', 'KD_DISTRIBUTOR', 'KD_SUBDIST', 'CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 50],
            [['CUST_NM', 'NM_BARANG'], 'string', 'max' => 255],
            [['CORP_ID'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'WAKTU' => 'Waktu',
            'CUST_KD' => 'Cust  Kd',
            'CUST_NM' => 'Cust  Nm',
            'KD_BARANG' => 'Kd  Barang',
            'NM_BARANG' => 'Nm  Barang',
            'STOCK_SOLD_OUT' => 'Stock  Sold  Out',
            'PRODAK_LINE' => 'Prodak  Line',
            'CORP_ID' => 'Corp  ID',
            'KD_DISTRIBUTOR' => 'Kd  Distributor',
            'KD_SUBDIST' => 'Kd  Subdist',
            'CREATED_BY' => 'Created  By',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_TIME' => 'Updated  Time',
            'STATUS' => 'Status',
        ];
    }
}
