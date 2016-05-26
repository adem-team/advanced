<?php
namespace lukisongroup\purchasing\models\rqt;

use Yii;
use yii\base\Model;
use lukisongroup\hrd\models\Employe;
use lukisongroup\purchasing\models\rqt\Requestterm;
use lukisongroup\purchasing\models\rqt\Requesttermstatus;
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
	public $empID;
    public $kdro;
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
			[['password','empID'], 'required'],
			['password', 'number','numberPattern' => '/^[0-9]*$/i'],
			['password', 'string', 'min' => 8,  'message'=> 'Please enter 8 digit'],
			['password', 'findPasswords'],
			['status', 'required'],
			['status', 'integer'],
			[['kdro'], 'required'],
			[['kdro','empNm','empID'], 'string'],
      [['empID'], 'self']
        ];
    }

    public function self($model)
    {
      # code...
      $profile=Yii::$app->getUserOpt->Profile_user();
      $data = $profile->emp->EMP_ID;
      $dif = $this->empID;
      $ro = Requestterm::find()->where(['ID_USER'=>$data])->asArray()
                                                           ->one();
       $id = $ro['ID_USER'];

       if($id == $dif)
       {
          $this->addError($model, 'Sorry You not CC to self');
       }
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
			 $emp_data = $this->getEmpid(Yii::$app->user->identity->EMP_ID);
			if (!$emp_data || !$emp_data->validateOldPasswordCheck($this->password)) {
                $this->addError($attribute, 'Incorrect password.');
            } elseif($this->getPermission()->BTN_SIGN1!=1){
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
			$roHeader = Requestterm::find()->where(['KD_RO' =>$this->kdro])->one();
			$empAuth2= Employe::find()->where(['EMP_ID' =>$this->empID])->one();
			$roSignStt = Requesttermstatus::find()->where(['KD_RO'=>$this->kdro,'ID_USER'=>$this->getProfile()->EMP_ID])->one();
				//Auth1|Create Destination
				$roHeader->STATUS = $this->status;
				$roHeader->SIG1_SVGBASE64 = $this->getProfile()->SIGSVGBASE64;
				$roHeader->SIG1_SVGBASE30 = $this->getProfile()->SIGSVGBASE30;
				$roHeader->SIG1_NM = $this->getProfile()->EMP_NM . ' ' . $this->getProfile()->EMP_NM_BLK;
				$roHeader->SIG1_ID = $this->getProfile()->EMP_ID;
				$roHeader->SIG1_TGL = date('Y-m-d');
				//Auth2|Checked Destination
				$roHeader->USER_CC = $this->empID;
				$roHeader->SIG2_NM = $empAuth2->EMP_NM . ' ' . $empAuth2->EMP_NM_BLK;

			if ($roHeader->save()) {
					if (!$roSignStt){
						$roHeaderStt = new Requesttermstatus;
						$roHeaderStt->KD_RO = $this->kdro;
						$roHeaderStt->ID_USER = $this->getProfile()->EMP_ID;
						$roHeaderStt->TYPE=101;
						$roHeaderStt->STATUS = 1;
						$roHeaderStt->UPDATED_AT = date('Y-m-d H:m:s');
						if ($roHeaderStt->save()) {

						}
					}
                return $roHeader;
            }
			return $roHeader;
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
    public function getEmpid($empIdIdentity)
    {
        if ($this->_empid === false) {
            $this->_empid = Employe::find()->where(['EMP_ID' =>$empIdIdentity])->one();
        }
        return $this->_empid;
    }

	public function getProfile(){
		$profile=Yii::$app->getUserOpt->Profile_user();
		return $profile->emp;
	}
	/*
	 * Declaration Componen User Permission
	 * Function getPermission
	 * Modul Name[1=RO]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses(1)){
			return Yii::$app->getUserOpt->Modul_akses(1);
		}else{
			return false;
		}
	}
}
