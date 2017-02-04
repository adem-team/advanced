<?php

namespace lukisongroup\warehouse\models;

use Yii;

/**
 * This is the model class for table "so_0003".
 *
 * @property integer $ID
 * @property string $TGL
 * @property string $KD_SJ
 * @property string $KD_SO
 * @property string $KD_INVOICE
 * @property string $KD_FP
 * @property string $ETD
 * @property string $ETA
 * @property string $KD_BARANG
 * @property string $NM_BARANG
 * @property string $QTY_UNIT
 * @property string $QTY_PCS
 * @property string $HARGA
 * @property double $DISCOUNT
 * @property string $PAJAK
 * @property string $DELIVERY_COST
 * @property string $NOTE
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class HeaderDetailRcvd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'so_0003Header';
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
            [['ID'], 'required'],
            [['ID'], 'integer'],
            [['TGL', 'ETD', 'ETA', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['QTY_UNIT', 'QTY_PCS', 'HARGA', 'DISCOUNT', 'PAJAK', 'DELIVERY_COST'], 'number'],
            [['NOTE','TYPE'], 'string'],
            [['KD_SJ', 'KD_SO', 'KD_INVOICE', 'KD_FP', 'KD_BARANG', 'CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 50],
            [['NM_BARANG'], 'string', 'max' => 255],
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
            'TYPE' => 'TYPE',
            'KD_SJ' => 'Kd  Sj',
            'KD_SO' => 'Kd  So',
            'KD_INVOICE' => 'Kd  Invoice',
            'KD_FP' => 'Kd  Fp',
            'ETD' => 'Etd',
            'ETA' => 'Eta',
            'KD_BARANG' => 'Kd  Barang',
            'NM_BARANG' => 'Nm  Barang',
            'QTY_UNIT' => 'Qty  Unit',
            'QTY_PCS' => 'Qty  Pcs',
            'HARGA' => 'Harga',
            'DISCOUNT' => 'Discount',
            'PAJAK' => 'Pajak',
            'DELIVERY_COST' => 'Delivery  Cost',
            'NOTE' => 'Note',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
