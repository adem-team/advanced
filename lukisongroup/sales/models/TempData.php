<?php

namespace lukisongroup\sales\models;

use Yii;

/**
 * This is the model class for table "so_t2_tmp_file".
 *
 * @property string $ID
 * @property string $TGL
 * @property string $CUST_KD
 * @property string $CUST_KD_ALIAS
 * @property string $CUST_NM
 * @property string $CUST_NM_ALIAS
 * @property string $ITEM_ID
 * @property string $ITEM_ID_ALIAS
 * @property string $ITEM_NM
 * @property string $ITEM_NM_ALIAS
 * @property string $QTY_PCS
 * @property string $QTY_UNIT
 * @property string $DIS_KD
 * @property string $DIS_NM
 * @property integer $SO_TYPE
 * @property string $POS
 * @property string $USER_ID
 * @property string $NOTED
 * @property integer $STATUS
 */
class TempData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'so_t2_tmp_file';
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
            [['TGL'], 'safe'],
            [['QTY_PCS', 'QTY_UNIT'], 'number'],
            [['SO_TYPE', 'STATUS'], 'integer'],
            [['NOTED'], 'string'],
            [['CUST_KD', 'CUST_KD_ALIAS', 'ITEM_ID_ALIAS', 'DIS_KD', 'USER_ID'], 'string', 'max' => 50],
            [['CUST_NM', 'CUST_NM_ALIAS', 'ITEM_NM', 'ITEM_NM_ALIAS', 'DIS_NM', 'POS'], 'string', 'max' => 255],
            [['ITEM_ID'], 'string', 'max' => 30],
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
            'CUST_KD' => 'Cust  Kd',
            'CUST_KD_ALIAS' => 'Cust  Kd  Alias',
            'CUST_NM' => 'Cust  Nm',
            'CUST_NM_ALIAS' => 'Cust  Nm  Alias',
            'ITEM_ID' => 'Item  ID',
            'ITEM_ID_ALIAS' => 'Item  Id  Alias',
            'ITEM_NM' => 'Item  Nm',
            'ITEM_NM_ALIAS' => 'Item  Nm  Alias',
            'QTY_PCS' => 'Qty  Pcs',
            'QTY_UNIT' => 'Qty  Unit',
            'DIS_KD' => 'Dis  Kd',
            'DIS_NM' => 'Dis  Nm',
            'SO_TYPE' => 'So  Type',
            'POS' => 'Pos',
            'USER_ID' => 'User  ID',
            'NOTED' => 'Noted',
            'STATUS' => 'Status',
        ];
    }
}
