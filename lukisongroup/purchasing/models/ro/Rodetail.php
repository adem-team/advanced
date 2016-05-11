<?php

namespace lukisongroup\purchasing\models\ro;

use Yii;
use lukisongroup\purchasing\models\ro\Requestorder;
use lukisongroup\master\models\Unitbarang;
//use lukisongroup\master\models\Barang; /* Barang Pembelian untuk Operatioal | Inventaris*/
use lukisongroup\master\models\Barang; /* Barang Pembelian/barang Produksi untuk dijual kembali*/
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
	public $KD_TYPE;
	public $STT_SEND_PO;
	public $PQTY=0;
	public $NEW;

	//Public $PQTY;
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
			[['KD_RO','PARENT_ROSO','RQTY','UNIT','NEW'], 'required','message' => 'Maaf Tolong Diisi','on'=>'simpan'],
			[['KD_RO','PARENT_ROSO','RQTY','UNIT'], 'required'],
			[['KD_BARANG'], 'required','when' => function ($attribute) {
					return $attribute->NEW == 2; },
					'whenClient' => "function (attribute, value) {
							return $('#radiochek:checked').val() == '2';
					}"
					],
			[['NM_BARANG','HARGA'], 'required','when' => function ($attribute) {
					return $attribute->NEW == 1; },
					'whenClient' => "function (attribute, value) {
							return $('#radiochek:checked').val() == '1';
					}"
					],
            [['PQTY','HARGA'], 'safe'],
						['HARGA','default', 'value'=>0.00],
						[['STATUS','PARENT_ROSO'], 'integer'],
            [['NOTE','UNIT','KD_BARANG'], 'string'],
            [['RQTY','SQTY','CREATED_AT', 'UPDATED_AT','TMP_CK','HARGA','KD_CORP'], 'safe'],
            [['KD_RO','KD_CORP', 'KD_BARANG'], 'string', 'max' => 50],
            [['NM_BARANG', 'NO_URUT'], 'string', 'max' => 255]
        ];
    }

	/* public function getPQTY()
    {
        return 10;
    } */




	public function getParentro()
    {
        return $this->hasOne(Requestorder::className(), ['KD_RO' => 'KD_RO']);
    }

	public function getCunit()
    {
        return $this->hasOne(Unitbarang::className(), ['KD_UNIT' => 'UNIT']);
    }

	public function getBarangumum()
    {
        return $this->hasOne(Barang::className(), ['KD_BARANG' => 'KD_BARANG']);
    }

	/* public function getBrgproduksi()
    {
        return $this->hasOne(Barang::className(), ['KD_BARANG' => 'KD_BARANG']);
    } */
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
					'NEW'=>'',
            'ID' => 'ID',
            'UNIT' => 'Satuan Barang',
            'KD_RO' => 'Kd  Ro',
            'KD_BARANG' => 'Kode  Barang',
            // 'NM_BARANG' => 'Nm  Barang',
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
