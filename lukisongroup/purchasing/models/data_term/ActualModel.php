<?php
namespace lukisongroup\purchasing\models\data_term;

use Yii;
use yii\base\Model;

//use lukisongroup\purchasing\models\data_term\Rtdetail;

class ActualModel extends Model{

	public $temId;
	public $investId;
	public $cusPerent;
	public $invesProgram;
	public $invoiceNo;
	public $faktureNo;
	public $invesHarga;

	 public function rules()
    {
        return [
			[['temId','investId'], 'string'],
			[['temId','investId','invesProgram'], 'required'],
			[['invesProgram','invoiceNo','faktureNo','invesHarga'], 'safe'],
        ];
    }

		public function actualmodel_saved()
		{
			# code...
			if ($this->validate()) {

						$term_header = new Requesttermheader();
						$corp =  $this->getProfile()->EMP_CORP_ID;
						$term_header->KD_RIB = Yii::$app->ambilkonci->getRedirectCode($corp);
						$term_header->TERM_ID = $this->temId;
						$term_header->CUST_ID_PARENT = $this->cusPerent;
						$term_header->ID_USER = $this->getProfile()->EMP_ID;
						$term_header->NOTE = $this->invesProgram;
					 	$term_header->save();

						$term_detail = new  Rtdetail();
					  $term_detail->KD_RIB = $term_header->KD_RIB;
						$term_detail->INVESTASI_TYPE = $this->investId;
						$term_detail->INVESTASI_PROGRAM = $this->invesProgram;
						$term_detail->HARGA = $this->invesHarga;
						$term_detail->NOMER_INVOCE =  $this->invoiceNo;
						$term_detail->NOMER_FAKTURPAJAK = $this->faktureNo;
						$term_detail->save();
						// print_r($term_detail->getErrors());
						// die();




			}
			return $term_header;
			// return null;

		}
		public function getProfile(){
			$profile=Yii::$app->getUserOpt->Profile_user();
			return $profile->emp;
		}

}


?>
