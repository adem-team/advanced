<?php

namespace lukisongroup\esm\models;

use Yii;

/**
 * This is the model class for table "c0001g2".
 *
 * @property integer $CITY_ID
 * @property string $PROVINCE_ID
 * @property string $PROVINCE
 * @property string $TYPE
 * @property string $CITY_NAME
 * @property integer $POSTAL_CODE
 */
class Kota extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0001g2';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db3');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CITY_ID'], 'required'],
            [['CITY_ID', 'POSTAL_CODE'], 'integer'],
            [['PROVINCE_ID', 'PROVINCE', 'TYPE', 'CITY_NAME'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CITY_ID' => 'City  ID',
            'PROVINCE_ID' => 'Province  ID',
            'PROVINCE' => 'Province',
            'TYPE' => 'Type',
            'CITY_NAME' => 'City  Name',
            'POSTAL_CODE' => 'Postal  Code',
        ];
    }
}
