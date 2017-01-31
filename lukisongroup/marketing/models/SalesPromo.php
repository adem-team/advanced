<?php

namespace lukisongroup\marketing\models;

use Yii;

/**
 * This is the model class for table "c0023".
 *
 * @property integer $ID
 * @property string $CUST_ID
 * @property string $CUST_NM
 * @property string $PROMO
 * @property string $TGL_START
 * @property string $TGL_END
 * @property integer $OVERDUE
 * @property string $MEKANISME
 * @property string $KOMPENSASI
 * @property string $KETERANGAN
 * @property integer $STATUS
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_AT
 */
class SalesPromo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0023';
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
            [['PROMO', 'MEKANISME', 'KOMPENSASI', 'KETERANGAN'], 'string'],
            [['TGL_START', 'TGL_END', 'CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['OVERDUE', 'STATUS'], 'integer'],
            [['CUST_ID'], 'string', 'max' => 50],
            [['CUST_NM'], 'string', 'max' => 255],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CUST_ID' => 'Customer.ID',
            'CUST_NM' => 'Customer',
            'PROMO' => 'Promotion',
            'TGL_START' => 'Periode.Start',
            'TGL_END' => 'Periode.End',
            'OVERDUE' => 'Overdue',
            'MEKANISME' => 'Mekanisme',
            'KOMPENSASI' => 'Mechanism',
            'KETERANGAN' => 'Description',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_AT' => 'Updated  At',
        ];
    }
}
