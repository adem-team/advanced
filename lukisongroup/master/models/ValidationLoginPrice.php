<?php
namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use lukisongroup\hrd\models\Employe;

/**
 * Login validation Setting Price Items Barang Prodak
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
 */
class ValidationLoginPrice extends Model
{
    public $empNm;
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
	public function Validationlogin(){
		if ($this->validate()) {			
			$empid = $this->getEmpid();
			//setting coocies
			return $empid;
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
}
