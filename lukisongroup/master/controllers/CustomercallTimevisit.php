<?php

namespace lukisongroup\master\models;

use Yii;

/**
 * This is the model class for table "c0002rpt_cc_time".
 *
 * @property string $ID
 * @property string $TGL
 * @property integer $STS
 * @property string $CUST_ID
 * @property string $CUST_NM
 * @property string $USER_ID
 * @property string $USER_NM
 * @property string $SCDL_GROUP
 * @property string $SCDL_GRP_NM
 * @property string $ABSEN_MASUK
 * @property string $ABSEN_KELUAR
 * @property string $ABSEN_TOTAL
 * @property string $GPS_GRP_LAT
 * @property string $GPS_GRP_LONG
 * @property string $ABSEN_MASUK_LAT
 * @property string $ABSEN_MASUK_LONG
 * @property string $ABSEN_MASUK_DISTANCE
 * @property string $ABSEN_KELUAR_LAT
 * @property string $ABSEN_KELUAR_LONG
 * @property string $ABSEN_KELUAR_DISTANCE
 * @property string $CUST_CHKIN
 * @property string $CUST_CHKOUT
 * @property string $LIVE_TIME
 * @property string $JRK_TEMPUH
 * @property string $JRK_TEMPUH_PULANG
 * @property string $GPS_CUST_LAT
 * @property string $GPS_CUST_LAG
 * @property string $LAT_CHEKIN
 * @property string $LONG_CHEKIN
 * @property string $DISTANCE_CHEKIN
 * @property string $LAT_CHEKOUT
 * @property string $LONG_CHEKOUT
 * @property string $DISTANCE_CHEKOUT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class CustomercallTimevisit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002rpt_cc_time';
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
            [['TGL', 'ABSEN_MASUK', 'ABSEN_KELUAR', 'ABSEN_TOTAL', 'CUST_CHKIN', 'CUST_CHKOUT', 'LIVE_TIME', 'JRK_TEMPUH', 'JRK_TEMPUH_PULANG', 'UPDATE_AT'], 'safe'],
            [['STS'], 'integer'],
            [['CUST_ID', 'USER_ID', 'SCDL_GRP_NM', 'GPS_GRP_LAT', 'GPS_GRP_LONG', 'ABSEN_MASUK_LAT', 'ABSEN_MASUK_LONG', 'ABSEN_MASUK_DISTANCE', 'ABSEN_KELUAR_LAT', 'ABSEN_KELUAR_LONG', 'ABSEN_KELUAR_DISTANCE', 'GPS_CUST_LAT', 'GPS_CUST_LAG', 'LAT_CHEKIN', 'LONG_CHEKIN', 'DISTANCE_CHEKIN', 'LAT_CHEKOUT', 'LONG_CHEKOUT', 'DISTANCE_CHEKOUT'], 'string', 'max' => 50],
            [['CUST_NM'], 'string', 'max' => 255],
            [['USER_NM', 'UPDATE_BY'], 'string', 'max' => 100],
            [['SCDL_GROUP'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TGL' => 'Tgl',
            'STS' => 'Sts',
            'CUST_ID' => 'Cust  ID',
            'CUST_NM' => 'Cust  Nm',
            'USER_ID' => 'User  ID',
            'USER_NM' => 'User  Nm',
            'SCDL_GROUP' => 'Scdl  Group',
            'SCDL_GRP_NM' => 'Scdl  Grp  Nm',
            'ABSEN_MASUK' => 'Absen  Masuk',
            'ABSEN_KELUAR' => 'Absen  Keluar',
            'ABSEN_TOTAL' => 'Absen  Total',
            'GPS_GRP_LAT' => 'Gps  Grp  Lat',
            'GPS_GRP_LONG' => 'Gps  Grp  Long',
            'ABSEN_MASUK_LAT' => 'Absen  Masuk  Lat',
            'ABSEN_MASUK_LONG' => 'Absen  Masuk  Long',
            'ABSEN_MASUK_DISTANCE' => 'Absen  Masuk  Distance',
            'ABSEN_KELUAR_LAT' => 'Absen  Keluar  Lat',
            'ABSEN_KELUAR_LONG' => 'Absen  Keluar  Long',
            'ABSEN_KELUAR_DISTANCE' => 'Absen  Keluar  Distance',
            'CUST_CHKIN' => 'Cust  Chkin',
            'CUST_CHKOUT' => 'Cust  Chkout',
            'LIVE_TIME' => 'Live  Time',
            'JRK_TEMPUH' => 'Jrk  Tempuh',
            'JRK_TEMPUH_PULANG' => 'Jrk  Tempuh  Pulang',
            'GPS_CUST_LAT' => 'Gps  Cust  Lat',
            'GPS_CUST_LAG' => 'Gps  Cust  Lag',
            'LAT_CHEKIN' => 'Lat  Chekin',
            'LONG_CHEKIN' => 'Long  Chekin',
            'DISTANCE_CHEKIN' => 'Distance  Chekin',
            'LAT_CHEKOUT' => 'Lat  Chekout',
            'LONG_CHEKOUT' => 'Long  Chekout',
            'DISTANCE_CHEKOUT' => 'Distance  Chekout',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
