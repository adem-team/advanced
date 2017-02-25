<?php

namespace lukisongroup\salesmd\models;

use Yii;

/**
 * This is the model class for table "Item".
 *
 * @property integer $ID_ITEM
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 * @property integer $STATUS
 * @property string $KD_BARCODE
 * @property string $ITEM_NM
 * @property string $HPP
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Item';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_efenbi');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['STATUS'], 'integer'],
            [['HPP'], 'number'],
            [['CREATE_BY', 'UPDATE_BY', 'KD_BARCODE'], 'string', 'max' => 50],
            [['ITEM_NM'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_ITEM' => Yii::t('app', 'Id  Item'),
            'CREATE_BY' => Yii::t('app', 'USER CREATED'),
            'CREATE_AT' => Yii::t('app', 'Tanggal dibuat'),
            'UPDATE_BY' => Yii::t('app', 'USER UPDATE'),
            'UPDATE_AT' => Yii::t('app', 'Tanggal di update'),
            'STATUS' => Yii::t('app', 'Status'),
            'KD_BARCODE' => Yii::t('app', 'Kd  Barcode'),
            'ITEM_NM' => Yii::t('app', 'Item  Nm'),
            'HPP' => Yii::t('app', 'HARGA POKOK PENJUALAN, harga dasar sebelum margin keuntungan'),
        ];
    }
}
