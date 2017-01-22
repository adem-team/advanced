<?php

namespace lukisongroup\dashboard\models;

use Yii;

/**
 * This is the model class for table "Tab_Val".
 *
 * @property integer $Id
 * @property string $Val_Nm
 * @property integer $Val_1
 * @property string $UPDT
 * @property string $Val_Json
 */
class Foodtown extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Tab_Val';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_ft');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Val_1'], 'integer'],
            [['UPDT'], 'safe'],
            [['Val_Json'], 'safe'],
            [['Val_Nm'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Val_Nm' => 'Val  Nm',
            'Val_1' => 'Val 1',
            'UPDT' => 'Updt',
            'Val_Json' => 'Val  Json',
        ];
    }
}
