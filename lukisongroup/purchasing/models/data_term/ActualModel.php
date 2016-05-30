<?php
namespace lukisongroup\purchasing\models\data_term;

use Yii;
use yii\base\Model;

//use lukisongroup\purchasing\models\data_term\Rtdetail;

class ActualModel extends Model{
	
	public $temId;
	public $investId; 
	public $kdRIB;
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
}

?>