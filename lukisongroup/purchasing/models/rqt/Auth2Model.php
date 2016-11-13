<?php
namespace lukisongroup\purchasing\models\rqt;

use Yii;
use yii\base\Model;
use lukisongroup\hrd\models\Employe;
use lukisongroup\purchasing\models\rqt\Requesttermheader;
use lukisongroup\purchasing\models\rqt\Requesttermstatus;
use common\components\Notification;
use common\models\MessageNotify;

/**
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
 *
 * SignatureForm | Static Model get form Employe Model
 * Check Oldpassword -> field [Employe->SIGPASSWORD]
 * set Oldpassword -> field [Employe->SIGPASSWORD]
 * Identity -> field [Employe->EMP_ID] | Session Yii::$app->user->identity->EMP_ID
 * depends [lukisongroup\hrd\models\Employe] | setPassword_signature() | validateOldPasswordCheck()
 * depends [lukisongroup\sistem\controllers\UserProfileController] | actionPasswordSignatureForm() | actionPasswordSignatureSaved()
 */
class Auth2Model extends Model
{
    public $empNm;
    public $kdrib;
  	public $status;
  	public $password;

  	//public $findPasswords; // @property Digunakan jika Form Attribute di gunakan
  	private $_empid = false;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['password'], 'required'],
			['password', 'number','numberPattern' => '/^[0-9]*$/i'],
			['password', 'string', 'min' => 8,  'message'=> 'Please enter 8 digit'],
			['password', 'findPasswords'],
			['status', 'required'],
			['status', 'integer'],
			[['kdrib'], 'required'],
			[['kdrib','empNm'], 'string']
        ];
    }

	/**
     * Password Find Oldpassword for validation
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */

	public function findPasswords($attribute, $params)
    {
		/*
		 * @author ptrnov  <piter@lukison.com>
		 * @since 1.1
		*/
		if (!$this->hasErrors()) {
			 $empid = $this->getEmpid();
       $pocheckdep =  $this->getProfile()->DEP_ID;
       $pocheckgf =  $this->getProfile()->GF_ID;
       $kdrib = $this->kdrib;
       $checkstatus = Requesttermheader::find()->where(['KD_RIB'=> $kdrib])->asArray()
                                                                     ->one();
       $status = $checkstatus['STATUS'];

			if (!$empid || !$empid->validateOldPasswordCheck($this->password)) {
                $this->addError($attribute, 'Incorrect password.');
            }
      elseif( $pocheckdep !='ACT' &&  $pocheckgf == 3 || $pocheckgf == 4 ){
              $this->addError($attribute, 'Sorry Only  Acounting');
      }
       }
    }



	/*
	 * Check validation
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	public function auth2_saved(){
		if ($this->validate()) {
			$rtHeader_2 = Requesttermheader::find()->where(['KD_RIB' =>$this->kdrib])->one(); #header
			$rtdetail = Rtdetail::find()->where(['KD_RIB'=>$this->kdrib])->one();#detail
			$poSignStt = Requesttermstatus::find()->where(['KD_RIB'=>$this->kdrib,'ID_USER'=>$this->getProfile()->EMP_ID])->one();
				$profile=Yii::$app->getUserOpt->Profile_user();
				$rtHeader_2->STATUS = $this->status;
				$rtHeader_2->SIG2_SVGBASE64 = $profile->emp->SIGSVGBASE64;
				$rtHeader_2->SIG2_SVGBASE30 = $profile->emp->SIGSVGBASE30;
				$rtHeader_2->SIG2_NM = $profile->emp->EMP_NM . ' ' . $profile->emp->EMP_NM_BLK;
				$rtHeader_2->SIG2_TGL = date('Y-m-d');
			if ($rtHeader_2->save()) {
				$rtdetail->STATUS = 101;
				$rtdetail->save();
					if (!$poSignStt){
						$rtHeader_2Stt = new Requesttermstatus;
						$rtHeader_2Stt->KD_RIB = $this->kdrib;
						$rtHeader_2Stt->ID_USER = $this->getProfile()->EMP_ID;
						//$rtHeader_2Stt->TYPE
						$rtHeader_2Stt->STATUS = 101;
						$rtHeader_2Stt->UPDATED_AT = date('Y-m-d H:m:s');
						if ($rtHeader_2Stt->save()) {




							// Notification::notify(Notification::KEY_NEW_MESSAGE, 23,Yii::$app->user->identity->id,$this->kdrib);
              //
							// $msgNotify = new MessageNotify;
							// $msgNotify->USER_CREATE=Yii::$app->user->identity->id; 				//integer
							// $msgNotify->USER_FROM_ID= $this->getProfile()->EMP_ID;
							// $msgNotify->USER_FROM= $this->getProfile()->EMP_NM; 			//varchar 50
							// $msgNotify->USER_TO='Stephen'; 			//varchar 50
							// $msgNotify->SUBJECT='PO'; 				//varchar 10
							// $msgNotify->CREATE_AT=date('Y-m-d H:m:s'); 		//varchar 10
							// $msgNotify->IMG=''; 						//TEXT
							// $msgNotify->REF = $this->kdrib; 				//TEXT
							// $msgNotify->save();
						}
					}
                return $rtHeader_2;
            }
			return $rtHeader_2;
		}
		return null;
	}

	/**
     * Finds record by EMP_ID
     * @return EMP_ID|null
	 * Also can use | $model = Employe::find()->where(['EMP_ID' => Yii::$app->user->identity->EMP_ID])->one();
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
    public function getEmpid()
    {
        if ($this->_empid === false) {
            $this->_empid = Employe::find()->where(['EMP_ID' => Yii::$app->user->identity->EMP_ID])->one();
        }
        return $this->_empid;
    }

	public function getProfile(){
		$profile=Yii::$app->getUserOpt->Profile_user();
		return $profile->emp;
	}
}
