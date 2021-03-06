<?php

namespace dashboard\efenbi\models;

use Yii;

/**
 * This is the model class for table "so_t2".
 *
 * @property string $ID
 * @property string $TGL
 * @property string $CUST_KD_ALIAS
 * @property string $KD_DIS
 * @property string $USER_ID
 * @property string $KD_BARANG_ALIAS
 * @property string $NM_BARANG
 * @property string $UNIT_BARANG
 * @property string $UNIT_QTY
 * @property string $UNIT_BERAT
 * @property integer $SO_TYPE
 * @property string $SO_QTY
 * @property string $HARGA_PABRIK
 * @property string $HARGA_DIS
 * @property string $HARGA_SALES
 * @property string $NOTED
 * @property string $HARGA_LG
 */
class SoT2 extends \yii\db\ActiveRecord
{
	 /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'so_t2';
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
            [['TGL'], 'safe'],
            [['UNIT_QTY', 'UNIT_BERAT', 'SO_QTY', 'HARGA_PABRIK', 'HARGA_DIS', 'HARGA_SALES', 'HARGA_LG'], 'number'],
            [['SO_TYPE'], 'integer'],
            [['NOTED'], 'string'],
            [['CUST_KD_ALIAS', 'KD_DIS', 'USER_ID', 'UNIT_BARANG'], 'string', 'max' => 50],
            [['KD_BARANG_ALIAS'], 'string', 'max' => 30],
            [['NM_BARANG'], 'string', 'max' => 255]
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
            'CUST_KD_ALIAS' => 'Cust  Kd  Alias',
            'KD_DIS' => 'Kd  Dis',
            'USER_ID' => 'User  ID',
            'KD_BARANG_ALIAS' => 'Kd  Barang  Alias',
            'NM_BARANG' => 'Nm  Barang',
            'UNIT_BARANG' => 'Unit  Barang',
            'UNIT_QTY' => 'Unit  Qty',
            'UNIT_BERAT' => 'Unit  Berat',
            'SO_TYPE' => 'So  Type',
            'SO_QTY' => 'So  Qty',
            'HARGA_PABRIK' => 'Harga  Pabrik',
            'HARGA_DIS' => 'Harga  Dis',
            'HARGA_SALES' => 'Harga  Sales',
            'NOTED' => 'Noted',
            'HARGA_LG' => 'Harga  Lg',
        ];
    }
}
