<?php

namespace lukisongroup\purchasing\models\rqt;

use Yii;
use lukisongroup\purchasing\models\rqt\Requestterm;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\master\models\Terminvest;
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
class Rtdetail extends \yii\db\ActiveRecord
{

	//Public $PQTY;
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 't0001detail';
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
						[['KD_RIB'], 'required'],
            [['INVESTASI_PROGRAM','HARGA'], 'safe'],
						['HARGA','default', 'value'=>0.00],
						[['STATUS','INVESTASI_TYPE'], 'integer'],
            [['UNIT'], 'string'],
            [['RQTY','SQTY','CREATED_AT', 'UPDATED_AT','HARGA'], 'safe'],
            [['KD_RIB','UNIT', 'NOMER_INVOCE','NOMER_FAKTURPAJAK'], 'string', 'max' => 50],
        ];
    }

	/* public function getPQTY()
    {
        return 10;
    } */






	public function getCunit()
    {
        return $this->hasOne(Unitbarang::className(), ['KD_UNIT' => 'UNIT']);
    }

		public function getInvest()
			{
					return $this->hasOne(Terminvest::className(), ['ID' => 'INVESTASI_TYPE']);
			}

			public function getNminvest(){
				return $this->invest->INVES_TYPE;
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
