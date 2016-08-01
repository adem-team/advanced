<?php

namespace lukisongroup\master\models;

use Yii;

/**
 * This is the model class for table "c0002scdl_dayname".
 *
 * @property integer $DAY_ID
 * @property string $DAY_NM
 * @property integer $DAY_VALUE
 * @property integer $OPT
 * @property string $DCRIPT
 */
class DayName extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002scdl_dayname';
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
            [['DAY_VALUE', 'OPT'], 'integer'],
            [['DCRIPT'], 'string'],
            [['DAY_NM'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DAY_ID' => 'Day  ID',
            'DAY_NM' => 'Day  Nm',
            'DAY_VALUE' => 'Day  Value',
            'OPT' => 'Opt',
            'DCRIPT' => 'Dcript',
        ];
    }
}
