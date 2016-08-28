<?php
namespace lukisongroup\purchasing\models\pr;

use Yii;
use yii\base\Model;
use lukisongroup\hrd\models\Employe;
use lukisongroup\purchasing\models\pr\Purchaseorder;
use lukisongroup\purchasing\models\pr\Statuspo;
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
class Auth1Model extends Model
{
    public $empNm;
    public $kdpo;
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
			[['kdpo'], 'required'],
			[['kdpo','empNm'], 'string']
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
       $id = $this->kdpo;
       $data = Purchasedetail::find()->where('STATUS<>3 AND KD_PO="'.$id.'"')->count();

			if (!$empid || !$empid->validateOldPasswordCheck($this->password)) {
                $this->addError($attribute, 'Incorrect password.');
            }
            elseif($data == 0)
            {
              $this->addError($attribute, 'Sorry data PO '.$data);
            }
        elseif($this->getPermission()->BTN_SIGN1!=1)
        {
            $this->addError($attribute, 'Wrong Permission');
        }
       }
    }

	/*
	 * Check validation
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	public function auth1_saved(){
		if ($this->validate()) {
			$poHeader = Purchaseorder::find()->where(['KD_PO' =>$this->kdpo])->one();
			$poSignStt = Statuspo::find()->where(['KD_PO'=>$this->kdpo,'ID_USER'=>$this->getProfile()->EMP_ID])->one();
				$poHeader->STATUS = $this->status;
				$poHeader->SIG1_SVGBASE64 = $this->getProfile()->SIGSVGBASE64;
				$poHeader->SIG1_SVGBASE30 = $this->getProfile()->SIGSVGBASE30;
				$poHeader->SIG1_NM = $this->getProfile()->EMP_NM . ' ' . $this->getProfile()->EMP_NM_BLK;
				$poHeader->SIG1_TGL = date('Y-m-d');
			if ($poHeader->save()) {
					if (!$poSignStt){
						$poHeaderStt = new Statuspo;
						$poHeaderStt->KD_PO = $this->kdpo;
						$poHeaderStt->ID_USER = $this->getProfile()->EMP_ID;
						//$poHeaderStt->TYPE
						$poHeaderStt->STATUS = 100;
						$poHeaderStt->UPDATE_AT = date('Y-m-d H:m:s');
						if ($poHeaderStt->save()) {

							//Notification::notify(Notification::KEY_NEW_MESSAGE, $id_Pengirim, $id_penerima(user_login),$ref_kode);
							Notification::notify(Notification::KEY_NEW_MESSAGE, 25,Yii::$app->user->identity->id,$this->kdpo);

							$msgNotify = new MessageNotify;
							$msgNotify->USER_CREATE=Yii::$app->user->identity->id; 				//integer
							$msgNotify->USER_FROM_ID= $this->getProfile()->EMP_ID;
							$msgNotify->USER_FROM= $this->getProfile()->EMP_NM; 			//varchar 50
							$msgNotify->USER_TO='Melissa'; 			//varchar 50 catatan multi name user permission purchasing sign3 harus di revisi
							$msgNotify->USER_TO_ID='LG.2016.000010'; // catatan multi name EMP_ID permission purchasing sign3 harus di revisi
							$msgNotify->SUBJECT='PO'; 				//varchar 10
							$msgNotify->CREATE_AT=date('Y-m-d H:m:s'); 		//varchar 10
							$msgNotify->IMG=''; 						//TEXT
							$msgNotify->REF = $this->kdpo; 				//TEXT
							$msgNotify->save();

						}
					}
                return $poHeader;
            }
			return $poHeader;
		}
		return null;
	}

  function getPermission(){
    if (Yii::$app->getUserOpt->Modul_akses(3)){
      return Yii::$app->getUserOpt->Modul_akses(3);
    }else{
      return false;
    }
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
