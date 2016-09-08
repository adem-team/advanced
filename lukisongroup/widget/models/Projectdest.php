<?php

namespace lukisongroup\widget\models;

use Yii;

/**
 * This is the model class for table "sc0001a".
 *
 * @property integer $ID
 * @property integer $TYPE
 */
class Projectdest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sc0001a';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_widget');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TYPE'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TYPE' => 'Type',
        ];
    }
}
