<?php
namespace lukisongroup\purchasing\models\rqt;

use Yii;
use yii\base\Model;
use lukisongroup\hrd\models\Employe;
use lukisongroup\purchasing\models\rqt\Requestterm;
use lukisongroup\purchasing\models\rqt\Rtdetail;
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
class Auth3Model extends Model
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
       //
      //  print_r($pocheckdep);
      //  die();
       $empID =  $this->getProfile()->EMP_ID->GF_ID;
       $kdrib = $this->kdrib;
       $checkstatus =  Requesttermheader::find()->where(['KD_RIB'=> $kdrib])->asArray()
                                                                ->one();
       $status = $checkstatus['STATUS'];
			if (!$empid || !$empid->validateOldPasswordCheck($this->password)) {
                $this->addError($attribute, 'Incorrect password.');
            }
       }
    }

	/*
	 * Check validation
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
   * if purchaseoder header equal 4 then SIG3_SVGBASE64 equal null and SIG3_SVGBASE30 equal null
   * if purchaseoder header equal 4 then purchaseoderstatus STATUS equal 4
	*/
	public function auth3_saved(){
		if ($this->validate()) {
			$rtHeader_3 = Requesttermheader::find()->where(['KD_RIB' =>$this->kdrib])->one();
			$rtSignStt_3 = Requesttermstatus::find()->where(['KD_RIB'=>$this->kdrib,'ID_USER'=>$this->getProfile()->EMP_ID])->one();
				$profile=Yii::$app->getUserOpt->Profile_user();
				$rtHeader_3->STATUS = $this->status;
        if($rtHeader_3->STATUS == 4)
        {
          $rtHeader_3->SIG3_SVGBASE64 = "";
  				$rtHeader_3->SIG3_SVGBASE30 = "";
        }else{
          $rtHeader_3->SIG3_SVGBASE64 = $profile->emp->SIGSVGBASE64;
          $rtHeader_3->SIG3_SVGBASE30 = $profile->emp->SIGSVGBASE30;
        }
				$rtHeader_3->SIG3_NM = $profile->emp->EMP_NM . ' ' . $profile->emp->EMP_NM_BLK;
				$rtHeader_3->SIG3_TGL = date('Y-m-d');
			if ($rtHeader_3->save()) {
					if (!$rtSignStt_3){
						$rtHeaderStt_3 = new Requesttermstatus;
						$rtHeaderStt_3->KD_RIB = $this->kdrib;
						$rtHeaderStt_3->ID_USER = $this->getProfile()->EMP_ID;
            if($rtHeader_3->STATUS == 4)
            {
              $rtHeaderStt_3->STATUS = 4;
            }else{
              $rtHeaderStt_3->STATUS = 102;
            }
						$rtHeaderStt_3->UPDATE_AT = date('Y-m-d H:m:s');
						if ($rtHeaderStt_3->save()) {



						}
					}
                return $rtHeader_3;
            }
			return $rtHeader_3;
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
