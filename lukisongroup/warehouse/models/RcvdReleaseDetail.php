<?php

namespace lukisongroup\warehouse\models;

use lukisongroup\warehouse\models\RcvdReleaseHeader;
use Yii;

class RcvdReleaseDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'so_0003Detail';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm','db1');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['ID'], 'integer'],
            [['DISCOUNT','HARGA','PAJAK','ID_HEADER','TGL', 'DTL_ETD', 'DTL_ETA', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['DTL_QTY_UNIT', 'DTL_QTY_PCS',  'DELIVERY_COST'], 'number'],
            [['NOTE'], 'string'],
            [['KD_SJ','KD_INVOICE','KD_FP','KD_BARANG', 'CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 50],
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
            'KD_SJ' => 'Kd  Sj',
            'KD_INVOICE' => 'Kd  Invoice',
            'KD_FP' => 'Kd  Fp',
            'DTL_ETD' => 'Etd',
            'DTL_ETA' => 'Eta',
            'KD_BARANG' => 'Kd  Barang',
            'NM_BARANG' => 'Nm  Barang',
            'DTL_QTY_UNIT' => 'Qty  Unit',
            'DTL_QTY_PCS' => 'Qty  Pcs',
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
	
	public function getHeaderTbl()
	{
		return $this->hasOne(RcvdReleaseHeader::className(), ['ID' => 'ID_HEADER']);
	}
	
	public function getTypeSrcDesTbl()
    {
        return $this->hasOne(TypeSrcDes::className(), ['TYPE' => 'TYPE','SRC_DEST'=>'TYPE_KTG'])->via('headerTbl');
    }
	
	public function getSrcNm()
	{
		return $this->typeSrcDesTbl->TYPE_NM;
	}	
	
	public function getTypeNote()
	{
		return $this->headerTbl->TYPE_NOTE;
	}	
	
	public function fields()
	{
		return [
			'TGL'=>function () {
				return $this->TGL;
			},
			'ID_BARANG'=>function () {
				return $this->NM_BARANG;
			},	
			'NM_BARANG'=>function () {
				return $this->NM_BARANG;
			},	
			'DTL_QTY_UNIT'=>function () {
				return $this->DTL_QTY_UNIT;
			},
			'DTL_QTY_PCS'=>function () {
				return $this->DTL_QTY_PCS;
			},
			'KD_RCVD'=>function () {
				return $this->headerTbl->KD_RCVD;
			},
			'TYPE_KTG'=>function () {
				return $this->headerTbl->TYPE_KTG;
			},
			'TYPE_KTG_NM'=>function () {
				return $this->typeSrcDesTbl->TYPE_NM;
			},
		];
	} 
}
