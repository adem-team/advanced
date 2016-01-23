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
class Auth2Model extends Model
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
			$roHeaderCheck = Requestorder::find()->where(['KD_RO' =>$this->kdro])->one();
			$empid = $this->getEmpid(Yii::$app->user->identity->EMP_ID);
			$roAuth1Check = Requestorderstatus::find()->where(['KD_RO' =>$this->kdro,'TYPE'=>101])->one();
			$roAuth1CheckStt=$roAuth1Check!=''?$roAuth1Check->TYPE:0;
			if (!$empid || !$empid->validateOldPasswordCheck($this->password)) {
                $this->addError($attribute, 'Incorrect password.');				
            }elseif((!$roAuth1CheckStt==101)){	
				 $this->addError($attribute, 'Needed Signature created, then signature approved Available'.$roAuth1CheckStt);
			}elseif(!$this->getPermission()->BTN_SIGN2==1 || $roHeaderCheck->USER_CC!=$this->getProfile()->EMP_ID){
				 $getUserCc=Employe::find()->where(['EMP_ID' => $roHeaderCheck->USER_CC])->one();
				 $this->addError($attribute, 'Wrong Permission,the undersigned is checked by '.$getUserCc->EMP_NM. ' '.$getUserCc->EMP_NM_BLK);		
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
			$roHeader = Requestorder::find()->where(['KD_RO' =>$this->kdro])->one();
			$roSignStt = Requestorderstatus::find()->where(['KD_RO'=>$this->kdro,'ID_USER'=>$this->getProfile()->EMP_ID])->one();			
				$roHeader->STATUS = $this->status;					
				$roHeader->SIG2_SVGBASE64 = $this->getProfile()->SIGSVGBASE64;
				$roHeader->SIG2_SVGBASE30 = $this->getProfile()->SIGSVGBASE30;
				$roHeader->SIG2_NM = $this->getProfile()->EMP_NM . ' ' . $this->getProfile()->EMP_NM_BLK;
				$roHeader->SIG2_ID = $this->getProfile()->EMP_ID;
				$roHeader->SIG2_TGL = date('Y-m-d');		
			if ($roHeader->save()) {
					if (!$roSignStt){
						$roHeaderStt = new Requestorderstatus;						
						$roHeaderStt->KD_RO = $this->kdro;
						$roHeaderStt->ID_USER = $this->getProfile()->EMP_ID;
						$roHeaderStt->TYPE=102;
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
    public function getEmpid($empIdIdentity)
    {
        if ($this->_empid === false) {
            $this->_empid = Employe::find()->where(['EMP_ID' => $empIdIdentity])->one();
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
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses(1)){
			return Yii::$app->getUserOpt->Modul_akses(1);
		}else{		
			return false;
		}	 
	}
}
