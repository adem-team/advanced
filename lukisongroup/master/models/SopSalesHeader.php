<?php

namespace lukisongroup\master\models;

use Yii;
use lukisongroup\master\models\SopSalesType;

/**
 * This is the model class for table "c0021a".
 *
 * @property integer $ID
 * @property string $TGL
 * @property integer $STT_DEFAULT
 * @property integer $SOP_TYPE
 * @property string $KATEGORI
 * @property double $BOBOT_PERCENT
 * @property double $TARGET_MONTH
 * @property double $TARGET_DAY
 * @property integer $TTL_DAYS
 * @property string $TARGET_UNIT
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 */
class SopSalesHeader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $parent_kategori;
   
    public static function tableName()
    {
        return 'c0021a';
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
            [['TGL', 'CREATE_AT'], 'safe'],
            [['STT_DEFAULT', 'SOP_TYPE', 'TTL_DAYS'], 'integer'],
            [['BOBOT_PERCENT', 'TARGET_MONTH', 'TARGET_DAY'], 'number'],
            [['KATEGORI', 'TARGET_UNIT', 'CREATE_BY'], 'string', 'max' => 50],
        ];
    }


    public function getSopTypeTbl()
    {
        return $this->hasOne(SOPSalesTYPE::className(), ['SOP_TYPE' => 'SOP_TYPE']);

    }

    public function getSopNm(){
        return $this->sopTypeTbl != '' ? $this->sopTypeTbl->SOP_NM : 'none';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TGL' => 'Tgl',
            'STT_DEFAULT' => 'Stt  Default',
            'SOP_TYPE' => 'Sop  Type',
            'KATEGORI' => 'Kategori',
            'BOBOT_PERCENT' => 'Bobot  Percent',
            'TARGET_MONTH' => 'Target  Month',
            'TARGET_DAY' => 'Target  Day',
            'TTL_DAYS' => 'Ttl  Days',
            'TARGET_UNIT' => 'Target  Unit',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
        ];
    }
}
