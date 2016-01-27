<?php

namespace lukisongroup\purchasing\models\pr;

use Yii;
use lukisongroup\master\models\Unitbarang;

/**
 * This is the model class for table "p0002".
 *
 * @property integer $ID
 * @property integer $KD_PO
 * @property string $KD_RO
 * @property integer $ID_DET_RO
 * @property integer $QTY
 * @property string $UNIT
 * @property integer $STATUS
 * @property string $STATUS_DATE
 * @property string $NOTE
 */
class Purchasedetail extends \yii\db\ActiveRecord
{
	public $KD_KATEGORI;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p0002';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

	
	public function getCunit()
    {
        return $this->hasOne(Unitbarang::className(), ['KD_UNIT' => 'UNIT']);
    }
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_PO','KD_RO','KD_BARANG','NM_BARANG','UNIT'], 'required'],
            [['STATUS'], 'integer'],
            [['KD_PO', 'KD_RO','KD_BARANG','NM_BARANG','UNIT','NM_UNIT','NOTE'], 'string'],
			[['ID','UNIT_QTY','UNIT_WIGHT', 'HARGA','QTY','STATUS_DATE'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_PO' => 'Kode PO',
            'KD_RO' => 'Kode RO',
            'QTY' => 'Qty',
            'UNIT' => 'Unit',
			'NM_UNIT'=>'Unit Name',
			'UNIT_WIGHT'=>'Unit Wight',
            'STATUS' => 'Status',
            'STATUS_DATE' => 'Status  Date',
            'NOTE' => 'Note',
        ];
    }
}
