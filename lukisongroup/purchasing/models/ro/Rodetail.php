<?php

namespace lukisongroup\purchasing\models\ro;

use Yii;
use lukisongroup\purchasing\models\ro\Requestorder;
use lukisongroup\master\models\Unitbarang;
/**
 * This is the model class for table "r0003".
 *
 * @property string $ID
 * @property string $KD_RO
 * @property string $KD_BARANG
 * @property string $NM_BARANG
 * @property integer $QTY
 * @property string $NO_URUT
 * @property string $NOTE
 * @property integer $STATUS
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 */
class Rodetail extends \yii\db\ActiveRecord
{
	public $KD_KATEGORI;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r0003';
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
 //         [['ID','KD_RO', 'KD_BARANG', 'NM_BARANG', 'QTY', 'NO_URUT', 'NOTE', 'STATUS', 'CREATED_AT', 'UPDATED_AT'], 'required'],
			[['KD_RO','RQTY','UNIT','KD_BARANG'], 'required'],
			//[['KD_RO','RQTY','SQTY','UNIT','KD_BARANG'], 'safe'],
            [['STATUS'], 'integer'],
            [['NOTE','UNIT','KD_BARANG'], 'string'],
            [['RQTY','SQTY','CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['KD_RO', 'KD_BARANG'], 'string', 'max' => 50],
            [['NM_BARANG', 'NO_URUT'], 'string', 'max' => 255]
        ];
    }
	
/* 	public static function primaryKey()
    {
      return ['ID'];
    } */
	
	public function getParentro()
    {
        return $this->hasOne(Requestorder::className(), ['KD_RO' => 'KD_RO']);
    }
	
	public function getCunit()
    {
        return $this->hasOne(Unitbarang::className(), ['KD_UNIT' => 'UNIT']);
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'UNIT' => 'Satuan Barang',
            'KD_RO' => 'Kd  Ro',
            'KD_BARANG' => 'Kode  Barang',
            'NM_BARANG' => 'Nm  Barang',
            'RQTY' => 'Request Quantity',
            'SQTY' => 'Submit Quantity',
            'NO_URUT' => 'No  Urut',
            'NOTE' => 'Catatan',
            'STATUS' => 'Status',
            'CREATED_AT' => 'Created  At',
            'UPDATED_AT' => 'Updated  At',
        ];
    }
}
