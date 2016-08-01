<?php

namespace lukisongroup\master\models;

use Yii;

/**
 * This is the model class for table "c0016".
 *
 * @property integer $ID
 * @property string $LAYER
 * @property integer $TOTAL
 * @property string $DCRIPT
 */
class LayesClastering extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0016';
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
            [['TOTAL'], 'integer'],
            [['DCRIPT'], 'string'],
            [['LAYER'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'LAYER' => 'Layer',
            'TOTAL' => 'Total',
            'DCRIPT' => 'Dcript',
        ];
    }
}
