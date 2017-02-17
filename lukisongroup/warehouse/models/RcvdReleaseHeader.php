<?php

namespace lukisongroup\warehouse\models;
use lukisongroup\warehouse\models\TypeSrcDes;

use Yii;

class RcvdReleaseHeader extends \yii\db\ActiveRecord
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
            [['QTY_UNIT', 'QTY_PCS',  'DELIVERY_COST'], 'number'],
            [['NOTE','TYPE','TYPE_KTG','TYPE_NOTE'], 'string'],
            [['CUST_KD','KD_RCVD','KD_SO', 'CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 50],
            [['CUST_NM'], 'string', 'max' => 255]
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
	
	public function getTypeSrcDesTbl()
	{
		return $this->hasOne(TypeSrcDes::className(), ['TYPE' => 'TYPE','SRC_DEST'=>'TYPE_KTG']);
	}
	
	public function getSrcNm()
	{
		return $this->typeSrcDesTbl->TYPE_NM;
	}	
}
