<?php
namespace lukisongroup\purchasing\models;

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
class LoginForm extends Model
{
    public $password;
	public $kdro;
	public $empNm;
	//public $findPasswords;
	private $_empid = false;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [						
			['password', 'required'],
			['password', 'number','numberPattern' => '/^[0-9]*$/i'],
			['password', 'string', 'min' => 8,  'message'=> 'Please enter 8 digit'],
			['password', 'findPasswords'],	
			[['kdro'], 'required'],
			[['kdro','empNm'], 'string'],			
        ];
    }
	
	/**
     * Password Find Oldpassword for validation
     */
	public function findPasswords($attribute, $params)
    {        
		if (!$this->hasErrors()) {
			 $empid = $this->getEmpid();
			if (!$empid || !$empid->validateOldPasswordCheck($this->password)) {
                $this->addError($attribute, 'Incorrect old password.');				
            } 
       }
    }
	
	public function loginSig()
    {
		if ($this->validate()) {
			//return true;
			return $this->kdro;
		}		
		return false;
		
	}
		
	/**
     * Finds record by EMP_ID
     * @return EMP_ID|null
	 * Also can use | $model = Employe::find()->where(['EMP_ID' => Yii::$app->user->identity->EMP_ID])->one();
     */
    public function getEmpid()
    {
        if ($this->_empid === false) {
            $this->_empid = Employe::find()->where(['EMP_ID' => Yii::$app->user->identity->EMP_ID])->one();
        }
        return $this->_empid;
    }	
}
