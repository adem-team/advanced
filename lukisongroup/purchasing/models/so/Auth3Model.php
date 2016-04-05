<?php
namespace lukisongroup\purchasing\models\so;

use Yii;
use yii\base\Model;
use lukisongroup\hrd\models\Employe;
use lukisongroup\purchasing\models\so\Salesorder;
use lukisongroup\purchasing\models\so\Sodetail;
use lukisongroup\purchasing\models\so\Salesorderstatus;
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
			 $roHeaderCheck = Salesorder::find()->where(['KD_RO' =>$this->kdro])->one();
			 $roAuth1Check = Salesorderstatus::find()->where(['KD_RO' =>$this->kdro,'TYPE'=>101])->one();
			 $roAuth1CheckStt=$roAuth1Check!=''?$roAuth1Check->TYPE:0;
			 $roAuth2Check = Salesorderstatus::find()->where(['KD_RO' =>$this->kdro,'TYPE'=>102])->one();
			  $roAuth2CheckStt=$roAuth2Check!=''?$roAuth2Check->TYPE:0;
			if (!$empid || !$empid->validateOldPasswordCheck($this->password)) {
                $this->addError($attribute, 'Incorrect password.');	
			}
			// elseif((!$roAuth1CheckStt==101)){	
				 // $this->addError($attribute, 'Needed Signature created, then signature approved Available'.$roAuth1CheckStt);
			// }elseif(($roAuth2CheckStt!=102)){		
				 // $this->addError($attribute, 'Wait Signature Checked first, then signature approved Available');						 
            // }elseif($roAuth1CheckStt!=101 and $roAuth2CheckStt!=102){
				  // $this->addError($attribute, 'Wait Signature Created and Checked first, then signature approved Available');		
			// }elseif(!$this->getPermission()->BTN_SIGN3==1 || $empid->DEP_ID!=$roHeaderCheck->KD_DEP){			
				 // $this->addError($attribute, 'Wrong Permission,the undersigned is checked by a head of the department');		
			// } 
       }
   	} 
	
	/*
	 * Check validation
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	public function auth3_saved(){
		if ($this->validate()) {			
			$roHeader = Salesorder::find()->where(['KD_RO' =>$this->kdro])->one();
			$roSignStt = Salesorderstatus::find()->where(['KD_RO'=>$this->kdro,'ID_USER'=>$this->getProfile()->EMP_ID,'TYPE'=>$this->status])->one();				
				$roHeader->STATUS = $this->status;
				if($this->status==103){ //
					$roHeader->SIG3_SVGBASE64 = $this->getProfile()->SIGSVGBASE64;
					$roHeader->SIG3_SVGBASE30 = $this->getProfile()->SIGSVGBASE30;
				}
				$roHeader->SIG3_NM = $this->getProfile()->EMP_NM . ' ' . $this->getProfile()->EMP_NM_BLK;
				$roHeader->SIG3_ID = $this->getProfile()->EMP_ID;
				$roHeader->SIG3_TGL = date('Y-m-d');		
			if ($roHeader->save()) {
					/* Status Item RO Details 0 menjadi 1 */
					if($this->status==103){
						/* Direct SQL command and execcute update */
						$cons = \Yii::$app->db_esm;	
						$command = $cons->createCommand("Update r0003 Set STATUS=1 WHERE KD_RO='".$this->kdro."' AND STATUS=0");
						$command->execute();
					}elseif($this->status==4){
						$cons = \Yii::$app->db_esm;	
						$command = $cons->createCommand("Update r0003 Set STATUS=4 WHERE KD_RO='".$this->kdro."' AND STATUS=0");
						$command->execute();
					}
					/*Status Auth Signature*/
					if (!$roSignStt and ($this->status==101 or $this->status==102)){
						/*Status Notify*/
						$roHeaderStt = new Salesorderstatus;						
						$roHeaderStt->KD_RO = $this->kdro;
						$roHeaderStt->ID_USER = $this->getProfile()->EMP_ID;
						$roHeaderStt->TYPE=$this->status;
						$roHeaderStt->STATUS = 1;
						$roHeaderStt->UPDATED_AT = date('Y-m-d H:m:s');
						if ($roHeaderStt->save()) {
							
						}
					}else{
						$roSignSttAuth3 = Salesorderstatus::find()->where("(KD_RO='".$this->kdro."' AND ID_USER='".$this->getProfile()->EMP_ID."' AND TYPE=103) OR
																			 (KD_RO='".$this->kdro."' AND ID_USER='".$this->getProfile()->EMP_ID."' AND TYPE=4) OR
																			 (KD_RO='".$this->kdro."' AND ID_USER='".$this->getProfile()->EMP_ID."' AND TYPE=5)")
																	->one();
						if (!$roSignSttAuth3){
							/*Status Notify*/
							$roHeaderStt = new Salesorderstatus;						
							$roHeaderStt->KD_RO = $this->kdro;
							$roHeaderStt->ID_USER = $this->getProfile()->EMP_ID;
							$roHeaderStt->TYPE=$this->status;
							$roHeaderStt->STATUS = 1;
							$roHeaderStt->UPDATED_AT = date('Y-m-d H:m:s');
							$roHeaderStt->save();
						}else{							
							$cons = \Yii::$app->db_esm;	
							$command = $cons->createCommand("Update r0002 Set TYPE='".$this->status."' WHERE KD_RO='".$this->kdro."' AND ID_USER='".$this->getProfile()->EMP_ID."' AND (TYPE=103 or TYPE=4 or TYPE=5)");
							$command->execute();							
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
