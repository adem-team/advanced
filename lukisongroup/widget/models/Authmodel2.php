<?php
namespace lukisongroup\widget\models;

use Yii;
use yii\base\Model;
use lukisongroup\hrd\models\Employe;
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
class Authmodel2 extends Model
{
      public $empNm;
      public $NotuID;
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
			[['NotuID'], 'required'],
			[['NotuID','empNm'], 'string']
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
       		 $id = $this->NotuID;
   
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
	public function auth2_saved(){
		if ($this->validate()) {
			   $NotulenModul = NotulenModul::find()->where(['NOTULEN_ID' =>$this->NotuID])->one();
			   $NotulenModul->SIGN_STT2 = 1;
			   $NotulenModul->SIG2_ID = $this->getProfile()->EMP_ID;
			   $NotulenModul->SIG2_NM = $this->getProfile()->EMP_NM . ' ' . $this->getProfile()->EMP_NM_BLK;
			   $NotulenModul->save();
			 
					
			return $NotulenModul;
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
