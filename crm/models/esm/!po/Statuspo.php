<?php

namespace lukisongroup\models\esm\po;

use Yii;

/**
 * This is the model class for table "p0003".
 *
 * @property string $ID
 * @property string $KD_PO
 * @property string $ID_USER
 * @property integer $STATUS
 * @property string $UPDATE_AT
 */
class Statuspo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p0003';
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
            [['KD_PO', 'ID_USER', 'STATUS'], 'required'],
            [['STATUS'], 'integer'],
            [['UPDATE_AT'], 'safe'],
            [['KD_PO', 'ID_USER'], 'string', 'max' => 255]
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
            'ID_USER' => 'Id  User',
            'STATUS' => 'Status',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
