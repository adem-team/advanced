<?php

namespace lukisongroup\purchasing\models\pr;

use Yii;


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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_PO', 'QTY', 'UNIT', 'STATUS', 'STATUS_DATE'], 'required'],
            [['STATUS'], 'integer'],
            [['KD_PO', 'RO','KD_BARANG','NM_BARANG','UNIT','NM_UNIT','NOTE'], 'string'],
            [['STATUS_DATE'], 'safe'],
			[['UNIT_QTY','UNIT_WIGHT', 'HARGA','QTY',], 'safe']
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
