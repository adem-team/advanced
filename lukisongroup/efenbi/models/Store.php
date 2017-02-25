<?php

namespace lukisongroup\efenbi\models;

use Yii;

/**
 * This is the model class for table "store".
 *
 * @property integer $ID
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 * @property integer $STATUS
 * @property integer $TYPE
 * @property string $TYPE_NM
 * @property string $KD_BARCODE
 * @property string $STORE_NM
 * @property string $ALAMAT
 * @property string $PIC
 * @property string $TLP
 */
class Store extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'store';
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
            [['STATUS', 'TYPE'], 'integer'],
            [['ALAMAT'], 'string'],
            [['CREATE_BY', 'UPDATE_BY', 'KD_BARCODE', 'TLP'], 'string', 'max' => 50],
            [['TYPE_NM', 'STORE_NM', 'PIC'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'CREATE_BY' => Yii::t('app', 'CREATE BY'),
            'CREATE_AT' => Yii::t('app', 'CREATE AT'),
            'UPDATE_BY' => Yii::t('app', 'UPDATE BY'),
            'UPDATE_AT' => Yii::t('app', 'UPDATE AT'),
            'STATUS' => Yii::t('app', 'STATUS'),
            'TYPE' => Yii::t('app', 'TYPE'),
            'TYPE_NM' => Yii::t('app', 'TYPE.NM'),
            'KD_BARCODE' => Yii::t('app', 'BARCODE'),
            'STORE_NM' => Yii::t('app', 'STORE'),
            'ALAMAT' => Yii::t('app', 'ALAMAT'),
            'PIC' => Yii::t('app', 'PIC'),
            'TLP' => Yii::t('app', 'PHONE'),
        ];
    }
}
