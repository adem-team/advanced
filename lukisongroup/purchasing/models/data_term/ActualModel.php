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
	public $pph23;
	public $ppn;
	public $periode_start;
	public $periode_end;

	 public function rules()
    {
        return [
			[['temId','investId','cusPerent'], 'string'],
			[['pph23','ppn','invesHarga'], 'default','value'=>0.00],
			[['pph23','ppn','invesHarga'], 'number'],
			[['temId','investId','invesProgram'], 'required'],
			[['invesProgram','invoiceNo','faktureNo','invesHarga','pph23','ppn','periode_start','periode_end'], 'safe'],
        ];
    }



		public function actualmodel_saved()
		{
			# code...
			if ($this->validate()) {
						/*header term */
						$term_header = new Requesttermheader();
						$corp =  $this->getProfile()->EMP_CORP_ID;
						$dep = $this->getProfile()->DEP_ID;
						$term_header->KD_RIB = Yii::$app->ambilkonci->getRedirectCode($corp);
						$term_header->TERM_ID = $this->temId;
						$term_header->CUST_ID_PARENT = $this->cusPerent;
						$term_header->ID_USER = $this->getProfile()->EMP_ID;
						$term_header->NOTE = $this->invesProgram;
						$term_header->PPH23 = $this->pph23;
						$term_header->PPN = $this->ppn;
						$term_header->KD_CORP = $corp;
						$term_header->KD_CAB = $corp;
						$term_header->KD_DEP = $dep;
					 	if($term_header->save())
					 	{
					 		/*detail term */
							$term_detail = new Rtdetail();
							$term_detail->TERM_ID = $term_header->TERM_ID;
							$term_detail->INVESTASI_TYPE = $this->investId;
						  	$term_detail->KD_RIB = $term_header->KD_RIB;
							$term_detail->ID_INVEST = $this->investId;
							$term_detail->INVESTASI_PROGRAM = $this->invesProgram;
							$term_detail->HARGA =$this->invesHarga;
							$term_detail->PPH23 = $this->pph23;
							$term_detail->PPN = $this->ppn;
							$term_detail->NOMER_INVOCE =  $this->invoiceNo;
							$term_detail->NOMER_FAKTURPAJAK = $this->faktureNo;
							$term_detail->PERIODE_START = $this->periode_start;
							$term_detail->PERIODE_END = $this->periode_end;
							$term_detail->STATUS = 102;
							$term_detail->save();
					 	}

							

			}
			return $term_header;
		}

		public function getProfile(){
			$profile=Yii::$app->getUserOpt->Profile_user();
			return $profile->emp;
		}

}


?>
