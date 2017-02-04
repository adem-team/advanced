<?php

namespace lukisongroup\warehouse\models;

use Yii;

/**
 * This is the model class for table "so_0003".
 *
 * @property integer $ID
 * @property string $TGL
 * @property string $KD_SJ
 * @property string $KD_SO
 * @property string $KD_INVOICE
 * @property string $KD_FP
 * @property string $ETD
 * @property string $ETA
 * @property string $KD_BARANG
 * @property string $NM_BARANG
 * @property string $QTY_UNIT
 * @property string $QTY_PCS
 * @property string $HARGA
 * @property double $DISCOUNT
 * @property string $PAJAK
 * @property string $DELIVERY_COST
 * @property string $NOTE
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class MssqlRcvd extends \yii\db\ActiveRecord
{
	/**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('mssql_ft');
    }
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        //return 'sss.db_test';
        return 'sss.db_test';
    }
   

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['ID'], 'required'],
            [['ID'], 'integer'],
            [['NAMA'], 'string']            
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NAMA' => 'Nama'
        ];
    }
}
