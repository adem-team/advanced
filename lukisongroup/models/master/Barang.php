<?php

namespace lukisongroup\models\esm;

use Yii;

/**
 * This is the model class for table "b0001".
 *
 * @property string $id
 * @property string $KD_BARANG
 * @property string $NM_BARANG
 * @property string $KD_SUPPLIER
 * @property string $KD_DISTRIBUTOR
 * @property string $HPP
 * @property integer $harga
 * @property integer $barcode
 * @property integer $note
 * @property integer $status
 * @property integer $createdBy
 * @property integer $createdAt
 * @property integer $updateAt
 * @property string $data_all
 */
class Barang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b0001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }
	
	public function getUnitb()
    {
        return $this->hasOne(Unitbarang::className(), ['ID' => 'KD_UNIT']);
    }
	
	public function getDbtr()
    {
        return $this->hasOne(Distributor::className(), ['KD_DISTRIBUTOR' => 'KD_DISTRIBUTOR']);
    }
	
	public function getBrg()
    {
        return $this->hasOne(Barangmaxi::className(), ['KD_BARANG' => 'NM_BARANG']);
    }
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_BARANG', 'NM_BARANG', 'HPP', 'HARGA', 'BARCODE', 'NOTE', 'STATUS','KD_UNIT','KD_DISTRIBUTOR'], 'required'],
            [['HPP', 'HARGA', 'BARCODE'], 'integer'],
            [['CREATED_BY', 'UPDATED_AT', 'KD_SUPPLIER', 'KD_DISTRIBUTOR'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_BARANG' => 'Kode Barang',
            'NM_BARANG' => 'Nama Barang',
            'KD_UNIT' => 'Kode Unit',
            'KD_SUPPLIER' => 'Kode Supplier',
            'KD_DISTRIBUTOR' => 'Kode Distributor',
            'HPP' => 'HPP',
            'HARGA' => 'Harga Jual',
            'BARCODE' => 'Barcode',
            'NOTE' => 'Note',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created By',
            'CREATED_AT' => 'Created At',
            'UPDATED_AT' => 'Update At',
            'DATAA_ALL' => 'Data All',
        ];
    }
}
