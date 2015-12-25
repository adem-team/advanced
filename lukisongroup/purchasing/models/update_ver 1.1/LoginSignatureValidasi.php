<?php
namespace lukisongroup\purchasing\models;

use Yii;
use lukisongroup\hrd\models\Employe;
use yii\base\Model;
/**
 * LoginSignatureValidasi
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1    	
 */
class LoginSignatureValidasi extends Model
{
    public $username;
    public $password;
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['employee_id', 'sig_password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['sig_password', 'validatePassword']
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->EMP_ID();
            if (!$user || !$user->validatePassword($this->sig_password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

	/**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            //return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
			return true;
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getEmpid()
    {
        if ($this->Employe === false) {
            $this->Employe = Employe::findByUsername($this->EMP_ID);
        }

        return $this->_user;
    }
	
	/**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
