<?php

namespace lukisongroup\master\models;

use Yii;

/**
 * This is the model class for table "c0007_temp".
 *
 * @property integer $ID
 * @property string $SCDL_GROUP_NM
 * @property string $KETERANGAN
 * @property string $CENTER_LAT
 * @property string $CENTER_LONG
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class GeografiGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0007_temp';
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
            [['KETERANGAN'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['SCDL_GROUP_NM'], 'string', 'max' => 10],
            [['CENTER_LAT', 'CENTER_LONG'], 'string', 'max' => 50],
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
            'SCDL_GROUP_NM' => 'Scdl  Group  Nm',
            'KETERANGAN' => 'Keterangan',
            'CENTER_LAT' => 'Center  Lat',
            'CENTER_LONG' => 'Center  Long',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
