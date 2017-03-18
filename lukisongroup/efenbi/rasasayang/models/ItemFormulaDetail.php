<?php

namespace lukisongroup\efenbi\rasasayang\models;

use Yii;

/**
 * This is the model class for table "Item_formula".
 *
 * @property integer $ID_DTL_FORMULA
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 * @property integer $STATUS
 * @property integer $TYPE
 * @property string $TYPE_NM
 * @property integer $ID_STORE
 * @property integer $ID_ITEM
 * @property string $DISCOUNT_PESEN
 * @property string $DISCOUNT_WAKTU
 * @property integer $DISCOUNT_HARI
 */
class ItemFormulaDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Item_formula_detail';
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
            [['CREATE_AT', 'UPDATE_AT', 'DISCOUNT_WAKTU1','DISCOUNT_WAKTU2','DISCOUNT_VALUE'], 'safe'],
            [['STATUS','DISCOUNT_QTY'], 'integer'],
            //[['DISCOUNT_VALUE'], 'number'],
            [['CREATE_BY', 'UPDATE_BY','PARENT_ID','DISCOUNT_HARI'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'CREATE_BY' => Yii::t('app', 'CREATE_BY'),
            'CREATE_AT' => Yii::t('app', 'CREATE_AT'),
            'UPDATE_BY' => Yii::t('app', 'UPDATE_BY'),
            'UPDATE_AT' => Yii::t('app', 'UPDATE_AT'),
            'STATUS' => Yii::t('app', 'STATUS'),           
            'PARENT_ID' => Yii::t('app', 'PARENT_ID'),               
            'DISCOUNT_WAKTU1' => Yii::t('app', 'TIME1'),
            'DISCOUNT_WAKTU2' => Yii::t('app', 'TIME2'),
            'DISCOUNT_HARI' => Yii::t('app', 'DAY'),
            'DISCOUNT_QTY' => Yii::t('app', 'MAX.QTY'),
			'DISCOUNT_VALUE' => Yii::t('app', 'PERCENT VALUE')
        ];
    }
}
