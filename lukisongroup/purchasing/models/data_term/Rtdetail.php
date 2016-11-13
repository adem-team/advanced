<?php

namespace lukisongroup\purchasing\models\data_term;

use Yii;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\master\models\Terminvest;
use lukisongroup\master\models\Customers;
//use lukisongroup\master\models\Barang; /* Barang Pembelian untuk Operatioal | Inventaris*/
use lukisongroup\master\models\Barang; /* Barang Pembelian/barang Produksi untuk dijual kembali*/
use lukisongroup\purchasing\models\data_term\Requesttermheader;

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
     public $total;
     public $temr_Id;
     public $cus_Perent;

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
            [['INVESTASI_PROGRAM','HARGA','PERIODE_START','PERIODE_END','PPN','PPH23','STORE_ID'], 'safe'],
			['HARGA','default', 'value'=>0.00],
      ['PPN','default', 'value'=>0],
       ['PPH23','default', 'value'=>0],
			[['STATUS','INVESTASI_TYPE'], 'integer'],
            //[['UNIT'], 'string'],
            [['UNIT','label'], 'string'],
            [['RQTY','SQTY','CREATED_AT', 'UPDATED_AT','HARGA'], 'safe'],
            [['KD_RIB','UNIT', 'NOMER_INVOCE','NOMER_FAKTURPAJAK'], 'string', 'max' => 50],
        ];
    }

	public function getLabel(){
		return $this->KD_RIB;
	}

	/* public function fields()
	{
		return [
			'label'=>function($model){
							return 'Actual';
					}
		];
	} */

 
  public function getTotals(){
      $total_pp23 = ($this->HARGA*$this->PPH23)/100;
      $total_ppn =  ($this->HARGA*$this->PPN)/100;
      $total = ($total_ppn + $this->HARGA)-$total_pp23 ;

      return number_format($total,2);
  }

  public function getHrga()
  {
    return number_format($this->HARGA,2);
  }

 




	public function getCunit()
    {
        return $this->hasOne(Unitbarang::className(), ['KD_UNIT' => 'UNIT']);
    }

	public function getInvest()
	{
		return $this->hasOne(Terminvest::className(), ['ID' => 'INVESTASI_TYPE']);
	}

    public function getCus(){
    return $this->hasOne(Customers::className(), ['CUST_KD' => 'STORE_ID']);
  }

   public function getNmcus(){

    return $this->cus->CUST_NM;
   
  }

	public function getNminvest(){
    return $this->invest->INVES_TYPE;
	}

	public function getRetermheader(){
		return $this->hasOne(Requesttermheader::className(), ['KD_RIB' => 'KD_RIB']);
	}
  public function getTermdet(){
		return $this->hasOne(Termdetail::className(), ['INVES_ID' => 'INVESTASI_TYPE']);
	}
  public function getPph()
  {
    return $this->retermheader->PPH23;
  }

  public function getPpn()
  {
    return $this->retermheader->PPN;
  }

  public function getPeriode(){
		return $this->retermheader->TGL;
	}

	// public function getTermid(){
	// 	return $this->retermheader->TERM_ID;
	// }

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
