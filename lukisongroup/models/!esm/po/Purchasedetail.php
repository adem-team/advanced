<?php

namespace lukisongroup\models\esm\po;

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
            [['KD_PO', 'QTY', 'UNIT', 'STATUS', 'STATUS_DATE', 'NOTE'], 'required'],
            [['KD_PO', 'QTY', 'STATUS'], 'integer'],
            [['STATUS_DATE','KD_BARANG'], 'safe'],
            [['NOTE'], 'string'],
            [['UNIT'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_PO' => 'Kd  Po',
            'QTY' => 'Qty',
            'UNIT' => 'Unit',
            'STATUS' => 'Status',
            'STATUS_DATE' => 'Status  Date',
            'NOTE' => 'Note',
        ];
    }
}
