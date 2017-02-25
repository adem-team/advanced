<?php

namespace lukisongroup\efenbi\models;

use Yii;

/**
 * This is the model class for table "Item_group".
 *
 * @property integer $ID_DTL_ITEM
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 * @property integer $STATUS
 * @property integer $TYPE
 * @property string $TYPE_NM
 * @property integer $ID_STORE
 * @property integer $ID_ITEM
 * @property string $PERSEN_MARGIN
 */
class ItemGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Item_group';
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
            [['STATUS', 'TYPE', 'ID_STORE', 'ID_ITEM'], 'integer'],
            [['PERSEN_MARGIN'], 'number'],
            [['CREATE_BY', 'UPDATE_BY', 'TYPE_NM'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_DTL_ITEM' => Yii::t('app', 'ID'),
            'CREATE_BY' => Yii::t('app', 'CREATE BY'),
            'CREATE_AT' => Yii::t('app', 'CREATE AT'),
            'UPDATE_BY' => Yii::t('app', 'UPDATE_BY'),
            'UPDATE_AT' => Yii::t('app', 'UPDATE_AT'),
            'STATUS' => Yii::t('app', 'STATUS'),
            'TYPE' => Yii::t('app', 'TYPE'),
            'TYPE_NM' => Yii::t('app', 'TYPE.NM'),
            'ID_STORE' => Yii::t('app', 'STORE_ID'),
            'ID_ITEM' => Yii::t('app', 'ITEM_ID'),
            'PERSEN_MARGIN' => Yii::t('app', 'MARGIN'),
        ];
    }
}
