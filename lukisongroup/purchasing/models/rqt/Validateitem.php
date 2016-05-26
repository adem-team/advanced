<?php
namespace lukisongroup\purchasing\models\rqt;

use Yii;
use yii\base\Model;
use lukisongroup\purchasing\models\rqt\Rtdetail;
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

class Validateitem extends Model
{
  public $NEW;
  public $kD_BARANG;
  public $Nm_BARANG;
  public $RqTY;
  public $NoTE;
  public $KD_cORP;



    public function rules()
    {
        return [
			[['NEW'], 'required'],
			//[['nmBarang','nOTE'], 'string'],
        	[['NoTE','kD_BARANG','Nm_BARANG','KD_cORP'], 'string'],
        	['NEW','integer'],
        	[['RqTY','KD_cORP'], 'safe'],
			// [['kD_CORP'], 'safe'],
		];
    }

	/**
     * Check KD_RO dan KD_BARANG
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1


	/**
     * Saved Data Rodetail
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
    //
	// public function newsaved()
  //   {
  //     $corp = $this->KD_cORP;
  //     $GneratekodeRo=\Yii::$app->ambilkonci->getRoCode($corp);
  //     $profile= Yii::$app->getUserOpt->Profile_user();
  //     // print_r($this->NEW);
  //     // die();
  //         if($this->NEW == 2)
  //         {
  //           if ($this->validate()) {
  //             $rodetail = new Rodetail();
  //             $rodetail->CREATED_AT = date('Y-m-d H:i:s');
  //             $rodetail->KD_RO = $GneratekodeRo; 		//required
  //             $rodetail->KD_CORP = $this->KD_cORP; 	//required
  //             $rodetail->PARENT_ROSO=0; // RO=1 		//required
  //             $rodetail->KD_BARANG = $this->kD_BARANG;
  //             $rodetail->NM_BARANG = $this->valuesBarang($this->kD_BARANG)->NM_BARANG;
  //             $rodetail->UNIT = 'none';
  //             $rodetail->RQTY = $this->RqTY;
  //             $rodetail->SQTY = $this->RqTY;
  //             $rodetail->NOTE = $this->NoTE;
  //             $rodetail->HARGA= $this->valuesBarang($this->kD_BARANG)->HARGA_SPL;
  //             $rodetail->STATUS = 0;
  //         if($rodetail->validate()){
  //             $rodetail->save();
  //             $roHeader = new Requestorder();
  //             $roHeader->PARENT_ROSO=0; // RO=0
  //             $roHeader->KD_RO =$GneratekodeRo;
  //             $roHeader->CREATED_AT = date('Y-m-d H:i:s');
  //             $roHeader->TGL = date('Y-m-d');
  //             $roHeader->ID_USER = $profile->emp->EMP_ID;
  //             $roHeader->EMP_NM = $profile->emp->EMP_NM .' ' .$profile->emp->EMP_NM_BLK;
  //             $roHeader->KD_CORP = $this->KD_cORP;
  //             $roHeader->KD_DEP = $profile->emp->DEP_ID;
  //             $roHeader->STATUS = 0;
  //             $roHeader->PARENT_ROSO=0; // RO=0
  //             $roHeader->KD_RO =$GneratekodeRo;
  //             $roHeader->CREATED_AT = date('Y-m-d H:i:s');
  //             $roHeader->TGL = date('Y-m-d');
  //             $roHeader->ID_USER = $profile->emp->EMP_ID;
  //             $roHeader->EMP_NM = $profile->emp->EMP_NM .' ' .$profile->emp->EMP_NM_BLK;
  //             $roHeader->KD_DEP = $profile->emp->DEP_ID;
  //             $roHeader->STATUS = 0;
  //             if ($roHeader->save()) {
  //               return $roHeader;
  //             }
  //             }
  //           }
  //       }elseif($this->NEW == 1)
  //       {
  //       if ($this->validate()) {
  //         $BARANG = new Barang();
  //         $kdType = Yii::$app->esmcode->kdTipe();
  //         $kdUnit = Yii::$app->esmcode->kdUnit();
  //         $nw1 = Yii::$app->esmcode->kdKategori();
  //         $kdKategori = $nw1;
  //         $kdPrn = 0;
  //         $kdbrg =  Yii::$app->esmcode->kdbarangUmum($kdPrn,$corp,$kdType,$kdKategori,$kdUnit);
  //     // print_r($kdbrg);
  //     // die();
  //         $BARANG->KD_BARANG = $kdbrg;
  //         $BARANG->NM_BARANG = $this->Nm_BARANG ;
  //         $BARANG->STATUS = 0;
  //         if($BARANG->validate())
  //         {
  //           $BARANG->save();
  //         //   print_r(  $BARANG);
  //         //  die();
  //         $rodetail = new Rodetail();
  //         $rodetail->KD_RO = $GneratekodeRo;
  //         $rodetail->PARENT_ROSO=0;
  //         $rodetail->KD_CORP =$corp;
  //         $rodetail->CREATED_AT = date('Y-m-d H:i:s');
  //         $rodetail->NM_BARANG = $this->Nm_BARANG;
  //         $rodetail->UNIT = 'none';
  //         $rodetail->RQTY = $this->RqTY;
  //         $rodetail->SQTY = $this->RqTY;
  //         $rodetail->NOTE = $this->NoTE;
  //         $rodetail->HARGA= 0.00;
  //         $rodetail->STATUS = 0;
  //         if($rodetail->validate())
  //         {
  //             $rodetail->save();
  //             //   print_r( $rodetail);
  //             //  die();
  //       $roHeader = new Requestorder();
  //       $roHeader->PARENT_ROSO=0; // RO=0
  //       $roHeader->CREATED_AT = date('Y-m-d H:i:s');
  //       $roHeader->TGL = date('Y-m-d');
  //       $roHeader->ID_USER = $profile->emp->EMP_ID;
  //       $roHeader->KD_CORP = $corp;
  //       $roHeader->KD_DEP = $profile->emp->DEP_ID;
  //       $roHeader->STATUS = 0;
  //       $roHeader->PARENT_ROSO=0; // RO=0
  //       $roHeader->KD_RO =$GneratekodeRo;
  //       $roHeader->CREATED_AT = date('Y-m-d H:i:s');
  //       $roHeader->TGL = date('Y-m-d');
  //       $roHeader->ID_USER = $profile->emp->EMP_ID;
  //       $roHeader->EMP_NM = $profile->emp->EMP_NM .' ' .$profile->emp->EMP_NM_BLK;
  //       $roHeader->STATUS = 0;
  //       if($roHeader->validate())
  //       {
  //           $roHeader->save();
  //           return $roHeader;
  //       }
  //     }
  //   }
  //
  //   }
  // }
  //
	// 	return null;
	// }


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

	// protected function valuesBarang($kdBarang){
	// 	$valuesBarang = Barang::findOne(['KD_BARANG' => $kdBarang]);
	// 	return $valuesBarang;
	// }
}
