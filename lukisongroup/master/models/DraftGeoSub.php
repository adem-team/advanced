<?php

namespace lukisongroup\master\models;

use Yii;

/**
 * This is the model class for table "c0002scdl_geo_sub".
 *
 * @property string $ID
 * @property string $GEO_SUB
 * @property string $GEO_ID
 * @property string $GEO_DCRIP
 * @property integer $CUST_MAX_NORMAL
 * @property integer $CUST_MAX_LAYER
 * @property string $START_LAT
 * @property string $START_LONG
 * @property string $CITY_ID
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class DraftGeoSub extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002scdl_geo_sub';
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
            [['GEO_SUB', 'GEO_ID', 'CUST_MAX_NORMAL', 'CUST_MAX_LAYER', 'STATUS'], 'integer'],
            [['GEO_DCRIP'], 'string'],
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['START_LAT', 'START_LONG'], 'string', 'max' => 50],
            [['CITY_ID'], 'string', 'max' => 20],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'GEO_SUB' => 'Geo  Sub',
            'GEO_ID' => 'Geo  ID',
            'GEO_DCRIP' => 'Geo  Dcrip',
            'CUST_MAX_NORMAL' => 'Cust  Max  Normal',
            'CUST_MAX_LAYER' => 'Cust  Max  Layer',
            'START_LAT' => 'Start  Lat',
            'START_LONG' => 'Start  Long',
            'CITY_ID' => 'City  ID',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }

        public function getGeoTbl()
    {
        return $this->hasOne(DraftGeo::className(), ['GEO_ID' => 'GEO_ID']);
    }

     public function getGeo_nm()
    {
        return $this->geoTbl->GEO_NM;
    }

}
