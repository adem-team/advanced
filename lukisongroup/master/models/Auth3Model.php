<?php
namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use lukisongroup\hrd\models\Employe;
use lukisongroup\purchasing\models\ro\Requestorder;
use lukisongroup\purchasing\models\ro\Rodetail;
use lukisongroup\purchasing\models\ro\Requestorderstatus;
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
    public $id;
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
			[['id'], 'required'],
			[['id','empNm'], 'string']
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
			//  $roHeaderCheck = Requestorder::find()->where(['KD_RO' =>$this->kdro])->one();
			//  $roAuth1Check = Requestorderstatus::find()->where(['KD_RO' =>$this->kdro,'TYPE'=>101])->one();
			//  $roAuth1CheckStt=$roAuth1Check!=''?$roAuth1Check->TYPE:0;
			//  $roAuth2Check = Requestorderstatus::find()->where(['KD_RO' =>$this->kdro,'TYPE'=>102])->one();
			//   $roAuth2CheckStt=$roAuth2Check!=''?$roAuth2Check->TYPE:0;
			if (!$empid || !$empid->validateOldPasswordCheck($this->password)) {
                $this->addError($attribute, 'Incorrect password.');
			}
       }
   	}

	/*
	 * Check validation
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
  public function auth3_saved(){
		if ($this->validate()) {
			$model = Termcustomers::find()->where(['ID_TERM' =>$this->id])->one();
			// $poSignStt = Statuspo::find()->where(['KD_PO'=>$this->kdpo,'ID_USER'=>$this->getProfile()->EMP_ID])->one();
				$model->STATUS = $this->status;
				$model->SIG3_SVGBASE64 = $this->getProfile()->SIGSVGBASE64;
				$model->SIG3_SVGBASE30 = $this->getProfile()->SIGSVGBASE30;
				$model->SIG3_NM = $this->getProfile()->EMP_NM . ' ' . $this->getProfile()->EMP_NM_BLK;
				$model->SIG3_TGL = date('Y-m-d');
		    $model->save();

			return $model;
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

	/*
	 * Declaration Componen User Permission
	 * Function getPermission
	 * Modul Name[1=RO]
	*/
	// function getPermission(){
	// 	if (Yii::$app->getUserOpt->Modul_akses(1)){
	// 		return Yii::$app->getUserOpt->Modul_akses(1);
	// 	}else{
	// 		return false;
	// 	}
	// }

}
