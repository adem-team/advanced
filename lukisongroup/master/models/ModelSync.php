<?php
namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use lukisongroup\hrd\models\Employe;

class ModelSync extends Model
{
    public $empNm;
    public $tanggal1;
    public $tanggal2;
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
			[['tanggal1','tanggal2'], 'required'],
			[['tanggal1','tanggal2'], 'date','format' => 'yyyy-mm-dd'],
			//[['tanggal1','tanggal2'], 'safe'],
			[['tanggal2'], 'findcheck_tgl'],
			[['password'], 'required'],
			['password', 'number','numberPattern' => '/^[0-9]*$/i'],
			['password', 'string', 'min' => 8,  'message'=> 'Please enter 8 digit'],
			['password', 'findPasswords'],
			// ['status', 'required'],
			// ['status', 'integer'],
			
			[['empNm'], 'string'],
        ];
    }

	/**
     * Check tanggal Schedule, 7 hari
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function findcheck_tgl($attribute, $params)
    {         
		if (!$this->hasErrors()) {
			if (strtotime(\Yii::$app->formatter->asDate($this->tanggal1,'Y-M-d')) > strtotime(\Yii::$app->formatter->asDate($this->tanggal2,'Y-M-d'))) {
                 $this->addError($attribute,'Date-End, should be higher or Equal than the Start-Date');				
            } 
       }
    }
	
	/**
     * Password Find Oldpassword for validation
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function findPasswords($attribute, $params)
    {
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
	public function auth_validate(){
		if ($this->validate()) {
			//query sync
			return true;
		}else{
			return false;
		}
	}

	/* function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses(3)){
		  return Yii::$app->getUserOpt->Modul_akses(3);
		}else{
		  return false;
		}
	} */

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
