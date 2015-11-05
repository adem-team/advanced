<?php

namespace lukisongroup\models\esm\po;

use Yii;

/**
 * This is the model class for table "p0021".
 *
 * @property integer $ID
 * @property string $KD_PO
 * @property string $KD_RO
 * @property integer $ID_DET_RO
 * @property integer $QTY
 * @property string $UNIT
 */
class Podetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p0021';
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
            [['KD_PO', 'KD_RO', 'ID_DET_RO', 'QTY', 'UNIT'], 'safe'],
            [['ID_DET_RO', 'QTY'], 'integer'],
            [['KD_PO', 'KD_RO', 'UNIT'], 'string', 'max' => 50]
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
            'KD_RO' => 'Kd  Ro',
            'ID_DET_RO' => 'Id  Det  Ro',
            'QTY' => 'Qty',
            'UNIT' => 'Unit',
        ];
    }
}
