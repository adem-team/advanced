<?php

namespace lukisongroup\master\models;

use Yii;

/**
 * This is the model class for table "gp0001".
 *
 * @property integer $ID
 * @property double $LAT
 * @property double $LAG
 * @property double $RADIUS
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $CUST_ID
 */
class Map extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gp0001';
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
            [['LAT', 'LAG', 'RADIUS'], 'number'],
            [['CREATED_AT'], 'safe'],
            [['CREATED_BY'], 'string', 'max' => 20],
            [['CUST_ID'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'LAT' => 'Lat',
            'LAG' => 'Lag',
            'RADIUS' => 'Radius',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'CUST_ID' => 'Cust  ID',
        ];
    }
}
