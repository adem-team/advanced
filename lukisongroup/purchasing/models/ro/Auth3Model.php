<?php
namespace lukisongroup\purchasing\models\ro;

use Yii;
use yii\base\Model;
use lukisongroup\hrd\models\Employe;
use lukisongroup\purchasing\models\ro\Requestorder;

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
			[['password'], 'required'],
			['password', 'number','numberPattern' => '/^[0-9]*$/i'],
			['password', 'string', 'min' => 8,  'message'=> 'Please enter 8 digit'],
			['password', 'findPasswords'],	
			['status', 'required'],
			['status', 'integer'],
			[['kdro'], 'required'],
			[['kdro','empNm'], 'string']		
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
			 $roHeaderCheck = Requestorder::find()->where(['KD_RO' =>$this->kdro])->one();
			if (!$empid || !$empid->validateOldPasswordCheck($this->password)) {
                $this->addError($attribute, 'Incorrect password.');				
            }elseif($this->status!=103 || $empid->DEP_ID!=$roHeaderCheck->KD_DEP){				
				 $this->addError($attribute, 'Wrong Permission,the undersigned is checked by a head of the department');		
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
			$roHeader = Requestorder::find()->where(['KD_RO' =>$this->kdro])->one();
			$roSignStt = Requestorderstatus::find()->where(['KD_RO'=>$this->kdro,'ID_USER'=>$this->getProfile()->EMP_ID])->one();				
				$roHeader->STATUS = $this->status;					
				$roHeader->SIG3_SVGBASE64 = $this->getProfile()->SIGSVGBASE64;
				$roHeader->SIG3_SVGBASE30 = $this->getProfile()->SIGSVGBASE30;
				$roHeader->SIG3_NM = $this->getProfile()->EMP_NM . ' ' . $this->getProfile()->EMP_NM_BLK;
				$roHeader->SIG3_ID = $this->getProfile()->EMP_ID;
				$roHeader->SIG3_TGL = date('Y-m-d');		
			if ($roHeader->save()) {
					if (!$roSignStt){
						/*Status Notify*/
						$roHeaderStt = new Requestorderstatus;						
						$roHeaderStt->KD_RO = $this->kdro;
						$roHeaderStt->ID_USER = $this->getProfile()->EMP_ID;
						//$roHeaderStt->TYPE
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
