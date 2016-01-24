<?php
namespace lukisongroup\purchasing\models\ro;

use Yii;
use yii\base\Model;
use lukisongroup\purchasing\models\ro\Rodetail;
use lukisongroup\master\models\Barang;

	/*
	 * DESCRIPTION FORM AddItem -> Model Additem validation
	 * Form Add Items Hanya ada pada Form Edit | ACTION addItem
	 * Items Barang tidak bisa di input Duplicated. | Unix by KD_RO dan KD_BARANG
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	
	/*
	 * FIELD RECOMENDED FROM Model | Rodetail
		CREATED_AT  value  date('Y-m-d H:i:s');
		KD_RO 
		KD_BARANG
		NM_BARANG 
		UNIT 		
		RQTY
		NOTE 
		STATUS 
	* @author ptrnov  <piter@lukison.com>
	* @since 1.1
	*/
	
class AddNewitemValidation extends Model
{
    public $kD_RO;
	public $kD_CORP;
	public $kD_TYPE;
	public $kD_KATEGORI;
	public $kD_BARANG;	
	public $nM_BARANG;
	public $hARGA;	
	public $uNIT;
	public $rQTY;
	public $nOTE;
	public $sTATUS;
	public $cREATED_AT;
	public $kD_SUPPLIER;
	
	public function rules()
    {
        return [			
			[['kD_RO','nM_BARANG','kD_KATEGORI','kD_SUPPLIER','kD_TYPE','uNIT','rQTY','hARGA'], 'required'],				
			[['nOTE'], 'string'],			
        	['sTATUS','integer'],			
        	[['rQTY','cREATED_AT','kD_KATEGORI','kD_TYPE','hARGA','kD_SUPPLIER'], 'safe'],			
			[['kD_CORP'], 'safe'],			
		];
    }
	
	/**
     * Saved Data Rodetail
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function addnewitem_saved()
    {
		if ($this->validate()) {
			$barangNew= new Barang();
				$this->kD_BARANG= Yii::$app->esmcode->kdbarangUmum(0,$this->kD_CORP,$this->kD_TYPE,$this->kD_KATEGORI,$this->uNIT);
				$barangNew->KD_BARANG =$this->kD_BARANG;
				$barangNew->NM_BARANG = $this->nM_BARANG;
				$barangNew->KD_UNIT = $this->uNIT;
				$barangNew->HARGA_SPL = $this->hARGA;
				$barangNew->PARENT = 0;
				$barangNew->KD_CORP = $this->kD_CORP;
				$barangNew->KD_TYPE = $this->kD_TYPE;
				$barangNew->KD_KATEGORI = $this->kD_KATEGORI;
				$barangNew->KD_SUPPLIER = $this->kD_SUPPLIER;	
				$barangNew->STATUS = 1;	
				$barangNew->CREATED_BY = Yii::$app->user->identity->username;
				$barangNew->CREATED_AT = date('Y-m-d H:i:s');
				$barangNew->UPDATED_BY = Yii::$app->user->identity->username;
				if($barangNew->validate()){
					$barangNew->save();
					$rodetail = new Rodetail();
					$rodetail->CREATED_AT = date('Y-m-d H:i:s');
					$rodetail->KD_RO = $this->kD_RO; //required
					$rodetail->PARENT_ROSO=0; // RO=1 //required
					$rodetail->KD_BARANG = $this->kD_BARANG;
					$rodetail->NM_BARANG = $this->nM_BARANG;
					$rodetail->UNIT = $this->uNIT;
					$rodetail->RQTY = $this->rQTY;
					$rodetail->SQTY = $this->rQTY;
					$rodetail->NOTE = $this->nOTE;
					$rodetail->HARGA= $this->hARGA;
					$rodetail->STATUS = 0;
					if ($rodetail->save()) {
						return $rodetail;
					} 
				}
		}		
		return null;	
	}
	
	public function attributeLabels()
    {
        return [
            'uNIT' => 'Satuan Barang',
            'kD_RO' => 'Kode Request Order',
            'kD_BARANG' => 'Nama  Barang',
			'kD_KATEGORI' => 'Kategori Barang',
			// 'NM_BARANG' => 'Nm  Barang',
            'rQTY' => 'Request Quantity',
         //   'SQTY' => 'Submit Quantity',
           // 'NO_URUT' => 'No  Urut',
            'nOTE' => 'Notes',
            'sTATUS' => 'Status',
            'cREATED_AT' => 'Created  At',
            //'UPDATED_AT' => 'Updated  At',
        ];
    }
	
}
