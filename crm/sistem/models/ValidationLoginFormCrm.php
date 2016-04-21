<?php
namespace crm\sistem\models;

use Yii;
use yii\base\Model;
use lukisongroup\sistem\models\Userlogin;

/**
 * @author wawan
 * @since 1.0
 *
 * SignatureForm | Static Model get form Employe Model
 * Check Oldpassword -> field [Employe->SIGPASSWORD]
 * set Oldpassword -> field [Employe->SIGPASSWORD]
 * Identity -> field [Employe->EMP_ID] | Session Yii::$app->user->identity->EMP_ID
 * depends [lukisongroup\hrd\models\Employe] | setPassword_signature() | validateOldPasswordCheck()
 * depends [lukisongroup\sistem\controllers\UserProfileController] | actionPasswordSignatureForm() | actionPasswordSignatureSaved()
 */
class ValidationLoginFormCrm extends Model
{
    public $password;
	public $repassword;
	public $oldpassword;
	public $findPasswords;
	public $checkRePasswords;
	private $_userid = false;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['oldpassword'], 'required'],
			['oldpassword', 'string'],//,'numberPattern' => '/^[0-9]*$/i'],
			//['oldpassword', 'string', 'min' => 8,  'message'=> 'Please enter 8 digit'],
			['oldpassword', 'findPasswords'],
			[['password','repassword'], 'required'],
			[['password','repassword'], 'string'],//,'numberPattern' => '/^[0-9]*$/i'],
           // [['password','repassword'], 'string', 'min' => 8,'message'=> 'Please enter 8 digit'],
			['password', 'checkRePasswords'],


        ];
    }

	/**
     * PASSWORD CHECK | NEW PASSWORD * RE-PASSWORD
	 * @author wawan
	 * @since 1.0
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
     * FIND PASSWORD | Oldpassword for validation
	 * @author wawan
	 * @since 1.0
     */
	public function findPasswords($attribute, $params)
    {
		if (!$this->hasErrors()) {
			 $userid = $this->getUserid();
			 //echo 'test'.($empid->validateOldPasswordCheck($this->oldpassword));
			if (!$userid || !$userid->validateOldPassword($this->oldpassword)) {
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
			$model = Userlogin::find()->where(['id' => Yii::$app->user->identity->id])->one();
            $model->setPassword_login($this->password);
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
    public function getUserid()
    {
        if ($this->_userid === false) {
            $this->_userid = Userlogin::find()->where(['id' => Yii::$app->user->identity->id])->one();
        }
        return $this->_userid;
    }
}
