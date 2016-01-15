<?php
namespace lukisongroup\sistem\models;

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
class SignatureForm extends Model
{
    public $password;
	public $repassword;
	public $oldpassword;
	public $findPasswords;
	public $checkRePasswords;
	private $_empid = false;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [            
			[['oldpassword'], 'required'],
			['oldpassword', 'number','numberPattern' => '/^[0-9]*$/i'],
			['oldpassword', 'string', 'min' => 8,  'message'=> 'Please enter 8 digit'],
			['oldpassword', 'findPasswords'],			
			[['password','repassword'], 'required'],
			[['password','repassword'], 'number','numberPattern' => '/^[0-9]*$/i'],
            [['password','repassword'], 'string', 'min' => 8,'message'=> 'Please enter 8 digit'],
			['password', 'checkRePasswords'],	
			
			
        ];
    }
	
	/**
     * Password Find Oldpassword for validation
     */
	public function checkRePasswords($attribute, $params)
    {  
		if (!$this->hasErrors()) {
			if ($this->password!=$this->repassword) {
                $this->addError($attribute, 'New password Not Same, please correct password.');				
            } 
       }
	} 
	
	/**
     * Password Find Oldpassword for validation
     */
	public function findPasswords($attribute, $params)
    {        
		if (!$this->hasErrors()) {
			 $empid = $this->getEmpid();
			 //echo 'test'.($empid->validateOldPasswordCheck($this->oldpassword));
			if (!$empid || !$empid->validateOldPasswordCheck($this->oldpassword)) {
                $this->addError($attribute, 'Incorrect old password.');				
            } 
       }
    }
	
    /**
     * Signs Signature Password Setting Update.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function addpassword()
    {
		if ($this->validate()) {
			$model = Employe::find()->where(['EMP_ID' => Yii::$app->user->identity->EMP_ID])->one();
            $model->setPassword_signature($this->password);				
			if ($model->save()) {
				return true;
			}
        }
        return false;
    }
	
	/**
     * Finds record by [[EMP_ID]]
     *
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
