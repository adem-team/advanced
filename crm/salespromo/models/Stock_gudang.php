<?php

namespace crm\salespromo\models;

use Yii;

/**
 * This is the model class for table "{{%sp005}}".
 *
 * @property integer $ID
 * @property string $WAKTU
 * @property string $CUST_KD
 * @property string $CUST_NM
 * @property string $KD_BARANG
 * @property string $NM_BARANG
 * @property integer $STOCK_GUDANG
 * @property string $PRODAK_LINE
 * @property string $CORP_ID
 * @property string $KD_DISTRIBUTOR
 * @property string $KD_SUBDIST
 * @property string $CREATED_BY
 * @property string $UPDATED_BY
 * @property string $UPDATED_TIME
 * @property integer $STATUS
 */
class Stock_gudang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sp005}}';
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
            [['STOCK_GUDANG', 'STATUS'], 'integer'],
            [['UPDATED_BY'], 'required'],
            [['CUST_KD', 'KD_BARANG', 'KD_DISTRIBUTOR', 'KD_SUBDIST', 'CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 50],
            [['CUST_NM', 'NM_BARANG', 'PRODAK_LINE'], 'string', 'max' => 255],
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
            'WAKTU' => 'Tanggal',
            'CUST_KD' => 'Customer',
            'CUST_NM' => 'Cust  Nm',
            'KD_BARANG' => 'Items',
            'NM_BARANG' => 'Nm  Barang',
            'STOCK_GUDANG' => 'Stock.Gudang',
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
