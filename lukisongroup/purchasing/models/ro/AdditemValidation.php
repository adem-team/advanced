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

class AdditemValidation extends Model
{
    public $kD_RO;
	public $kD_CORP;
	public $kD_TYPE;
	public $kD_KATEGORI;
	public $kD_BARANG;
	public $hARGA;
	//public $nmBarang;
	public $uNIT;
	public $rQTY;
	//public $submitQty; //Kondisi Approved
	public $nOTE;
	public $sTATUS;
	public $cREATED_AT;
  public $nM_BARANG;
  public $addnew;

    public function rules()
    {
        return [
			[['kD_BARANG','addnew'], 'findcheck'],
			[['kD_RO','uNIT','rQTY','addnew'], 'required'],
			//[['nmBarang','nOTE'], 'string'],
        	[['nOTE','nM_BARANG'], 'string'],
        	['sTATUS','integer'],
        	[['rQTY','cREATED_AT','kD_KATEGORI','kD_TYPE','hARGA'], 'safe'],
			[['kD_CORP'], 'safe'],
		];
    }

	/**
     * Check KD_RO dan KD_BARANG
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function findcheck($attribute, $params)
    {
      $groupradio = $this->addnew;

      // print_r($barang);
      // die();
      if(  $groupradio == 2)
      {
        if (!$this->hasErrors()) {
          //  $kondisiTrue = Rodetail::find()->where(['KD_RO' => $this->kD_RO, 'KD_BARANG' => $this->kD_BARANG ])->one();
           $kondisiTrue = Rodetail::find()->where("KD_RO='".$this->kD_RO. "' AND KD_BARANG='".$this->kD_BARANG."' AND STATUS<>3")->one();
          if ($kondisiTrue) {
                    $this->addError($attribute, 'Duplicated Items Barang !, Better (-/+) Request.Qty ');
                }
           }

      }

    }


	/**
     * Saved Data Rodetail
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */

	public function additem_saved()
    {
      // $groupradio = $this->addnew;
      // if($groupradio == 2)
      // {
        if ($this->validate()) {
          $rodetail = new Rodetail();
          $rodetail->CREATED_AT = date('Y-m-d H:i:s');
          $rodetail->KD_RO = $this->kD_RO; 		//required
          $rodetail->KD_CORP = $this->kD_CORP; 	//required
          $rodetail->PARENT_ROSO=0; // RO=1 		//required
          $rodetail->KD_BARANG = $this->kD_BARANG;
          $rodetail->NM_BARANG = $this->valuesBarang($this->kD_BARANG)->NM_BARANG;
          $rodetail->UNIT = $this->uNIT;
          $rodetail->RQTY = $this->rQTY;
          $rodetail->SQTY = $this->rQTY;
          $rodetail->NOTE = $this->nOTE;
          $rodetail->HARGA= $this->valuesBarang($this->kD_BARANG)->HARGA_SPL;
          $rodetail->STATUS = 0;
          if ($rodetail->save()) {
                    return $rodetail;
                }
          return $rodetail;
        }
      // }
      // else{
      //   if ($this->validate()) {
      //     $barangNew= new Barang();
      //       $this->kD_BARANG= Yii::$app->esmcode->kdbarangUmum(0,$this->kD_CORP,$type,$kat,$unit);
      //       $barangNew->KD_BARANG =$this->kD_BARANG;
      //       $barangNew->NM_BARANG = $this->nM_BARANG;
      //       $barangNew->KD_UNIT = $this->uNIT;
      //       $barangNew->HARGA_SPL = $this->hARGA;
      //       $barangNew->PARENT = 0;
      //       $barangNew->KD_CORP = $this->kD_CORP;
      //       $barangNew->KD_TYPE = $this->kD_TYPE;
      //       $barangNew->KD_KATEGORI = $this->kD_KATEGORI;
      //       $barangNew->KD_SUPPLIER = $this->kD_SUPPLIER;
      //       $barangNew->STATUS = 1;
      //       $barangNew->CREATED_BY = Yii::$app->user->identity->username;
      //       $barangNew->CREATED_AT = date('Y-m-d H:i:s');
      //       $barangNew->UPDATED_BY = Yii::$app->user->identity->username;
      //       if($barangNew->validate()){
      //         $barangNew->save();
      //         $rodetail = new Rodetail();
      //         $rodetail->CREATED_AT = date('Y-m-d H:i:s');
      //         $rodetail->KD_RO = $this->kD_RO; 		//required
      //         $rodetail->KD_CORP = $this->kD_CORP; 	//required
      //         $rodetail->PARENT_ROSO=0; // RO=1 		//required
      //         $rodetail->KD_BARANG = $this->kD_BARANG;
      //         $rodetail->NM_BARANG = $this->nM_BARANG;
      //         $rodetail->UNIT = $this->uNIT;
      //         $rodetail->RQTY = $this->rQTY;
      //         $rodetail->SQTY = $this->rQTY;
      //         $rodetail->NOTE = $this->nOTE;
      //         $rodetail->HARGA= $this->hARGA;
      //         $rodetail->STATUS = 0;
      //         if ($rodetail->save()) {
      //
      //           // print_r($rodetail->geterrors());
      //           return $rodetail;
      //         }
      //       }
          // }

      // }

		return null;
	}

  public function addnewitem_saved()
    {
    if ($this->validate()) {
      $barangNew= new Barang();
        $kategori = 39;
        $type = 30;
        $this->kD_BARANG= Yii::$app->esmcode->kdbarangUmum(0,$this->kD_CORP,$type,$kategori,$this->uNIT);
        $barangNew->KD_BARANG =$this->kD_BARANG;
        $barangNew->NM_BARANG = $this->nM_BARANG;
        $barangNew->KD_UNIT = $this->uNIT;
        $barangNew->HARGA_SPL = $this->hARGA;
        $barangNew->PARENT = 0;
        $barangNew->KD_CORP = $this->kD_CORP;
        $barangNew->KD_TYPE = 30;
        $barangNew->KD_KATEGORI =39;
        $barangNew->KD_SUPPLIER ="SPL.LG.0000";
        $barangNew->STATUS = 1;
        $barangNew->CREATED_BY = Yii::$app->user->identity->username;
        $barangNew->CREATED_AT = date('Y-m-d H:i:s');
        $barangNew->UPDATED_BY = Yii::$app->user->identity->username;
        if($barangNew->validate()){
          $barangNew->save();
          $rodetail = new Rodetail();
          $rodetail->CREATED_AT = date('Y-m-d H:i:s');
          $rodetail->KD_RO = $this->kD_RO; 		//required
          $rodetail->KD_CORP = $this->kD_CORP; 	//required
          $rodetail->PARENT_ROSO=0; // RO=1 		//required
          $rodetail->KD_BARANG = $this->kD_BARANG;
          $rodetail->NM_BARANG = $this->nM_BARANG;
          $rodetail->UNIT = $this->uNIT;
          $rodetail->RQTY = $this->rQTY;
          $rodetail->SQTY = $this->rQTY;
          $rodetail->NOTE = $this->nOTE;
          $rodetail->HARGA= $this->hARGA;
          $rodetail->STATUS = 0;
          if ($rodetail->save()) {

            // print_r($rodetail->geterrors());
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

	protected function valuesBarang($kdBarang){
		$valuesBarang = Barang::findOne(['KD_BARANG' => $kdBarang]);
		return $valuesBarang;
	}
}
