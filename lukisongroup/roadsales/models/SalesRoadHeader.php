<?php

namespace lukisongroup\roadsales\models;

use Yii;

/**
 * This is the model class for table "c0022Header".
 *
 * @property integer $ROAD_D
 * @property string $USER_ID
 * @property string $CASE_ID
 * @property string $CASE_NOTE
 * @property double $LAT
 * @property double $LAG
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 */
class SalesRoadHeader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0022Header';
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
            [['CASE_ID', 'CASE_NOTE'], 'string'],
            [['LAT', 'LAG'], 'number'],
            [['CREATED_AT'], 'safe'],
            [['USER_ID'], 'string', 'max' => 50],
            [['CREATED_BY'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ROAD_D' => 'Road  D',
            'USER_ID' => 'User  ID',
            'CASE_ID' => 'Case  ID',
            'CASE_NOTE' => 'Case  Note',
            'LAT' => 'Lat',
            'LAG' => 'Lag',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
        ];
    }
}
