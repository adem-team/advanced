<?php

namespace lukisongroup\roadsales\models;

use Yii;
use lukisongroup\roadsales\models\SalesRoadHeader;

/**
 * This is the model class for table "c0022Image".
 *
 * @property integer $ID
 * @property string $ID_ROAD
 * @property string $IMGBASE64
 * @property string $IMG_NAME
 * @property integer $STATUS
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 */
class SalesRoadImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0022Image';
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
            [['IMGBASE64', 'IMG_NAME'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATED_AT'], 'safe'],
            [['ID_ROAD', 'CREATED_BY'], 'string', 'max' => 50],
        ];
    }

     public function getRoadTbl(){
        return $this->hasOne(SalesRoadHeader::className(), ['ROAD_D' => 'ID_ROAD']);
    }

    public function getJudulRoad(){
        return $this->roadTbl != '' ? $this->roadTbl->JUDUL : 'none';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ID_ROAD' => 'Id  Road',
            'IMGBASE64' => 'Imgbase64',
            'IMG_NAME' => 'Img  Name',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
        ];
    }
}
