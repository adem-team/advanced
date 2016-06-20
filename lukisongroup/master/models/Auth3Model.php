<?php
namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use lukisongroup\hrd\models\Employe;
use lukisongroup\purchasing\models\ro\Requestorder;
use lukisongroup\purchasing\models\ro\Rodetail;
use lukisongroup\purchasing\models\ro\Requestorderstatus;
use lukisongroup\purchasing\models\data_term\Termheader;
use lukisongroup\purchasing\models\data_term\Termdetail;
use lukisongroup\master\models\Termbudget;
use lukisongroup\purchasing\models\rqt\Requesttermheader;
use lukisongroup\purchasing\models\rqt\Rtdetail;
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
    public $id;
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
			[['id'], 'required'],
			[['id','empNm'], 'string']
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
			//  $roHeaderCheck = Requestorder::find()->where(['KD_RO' =>$this->kdro])->one();
			//  $roAuth1Check = Requestorderstatus::find()->where(['KD_RO' =>$this->kdro,'TYPE'=>101])->one();
			//  $roAuth1CheckStt=$roAuth1Check!=''?$roAuth1Check->TYPE:0;
			//  $roAuth2Check = Requestorderstatus::find()->where(['KD_RO' =>$this->kdro,'TYPE'=>102])->one();
			//   $roAuth2CheckStt=$roAuth2Check!=''?$roAuth2Check->TYPE:0;
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
  public function auth3_saved(){
		if ($this->validate()) {
			$model = Termcustomers::find()->where(['ID_TERM' =>$this->id])->one();
			$termSignStt = Statusterm::find()->where(['ID_TERM'=>$this->id,'ID_USER'=>$this->getProfile()->EMP_ID])->one();
				$model->STATUS = $this->status;
				$model->SIG3_SVGBASE64 = $this->getProfile()->SIGSVGBASE64;
				$model->SIG3_SVGBASE30 = $this->getProfile()->SIGSVGBASE30;
				$model->SIG3_NM = $this->getProfile()->EMP_NM . ' ' . $this->getProfile()->EMP_NM_BLK;
				$model->SIG3_TGL = date('Y-m-d');
		    if($model->save())
        {

          if(!$termSignStt)
          {
            $statusterm = new Statusterm();
            $statusterm->STATUS = $this->status; //required
            $statusterm->ID_TERM = $this->id; //required
            $statusterm->ID_USER = $this->getProfile()->EMP_ID; //required
            $statusterm->UPDATE_AT =  date('Y-m-d H:m:s');
            $statusterm->save();

            //header t0000header
            $copy_term = new Termheader();
            $copy_term->TERM_ID = Yii::$app->ambilkonci->getkdTermData();
            $copy_term->TERM_REF = $model->ID_TERM;
            $copy_term->STATUS = 0;
            $copy_term->CUST_KD_PARENT = $model->CUST_KD;
            $copy_term->PRINCIPAL_KD = $model->PRINCIPAL_KD;
            $copy_term->DIST_KD = $model->DIST_KD;
            $copy_term->PERIOD_START = $model->PERIOD_START;
            $copy_term->PERIOD_END = $model->PERIOD_END;
            $copy_term->SIG1_ID = $model->SIG1_ID;
            $copy_term->SIG1_NM = $model->SIG1_NM;
            $copy_term->SIG1_TGL = $model->SIG1_TGL;
            $copy_term->SIG1_SVGBASE64 = $model->SIG1_SVGBASE64;
            $copy_term->SIG2_ID = $model->SIG2_ID;
            $copy_term->SIG2_NM = $model->SIG2_NM;
            $copy_term->SIG2_TGL = $model->SIG2_TGL;
            $copy_term->SIG2_SVGBASE64 = $model->SIG2_SVGBASE64;
            $copy_term->SIG3_ID = $model->SIG3_ID;
            $copy_term->SIG3_NM = $model->SIG3_NM;
            $copy_term->SIG3_TGL = $model->SIG3_TGL;
            $copy_term->SIG3_SVGBASE64 = $model->SIG3_SVGBASE64;
            $copy_term->CREATED_BY = $model->CREATED_BY;
            $copy_term->save();



              // t0001header
            $copy_budget = new Requesttermheader();
            $copy_budget->TERM_ID = $copy_term->TERM_ID;
            $copy_budget->KD_RIB = Yii::$app->ambilkonci->getRaCode($this->getProfile()->EMP_CORP_ID);
            $copy_budget->ID_USER = $this->getProfile()->EMP_ID;
            $copy_budget->CUST_ID_PARENT = $model->CUST_KD;
            $copy_budget->STATUS = 102;
            $copy_budget->save();
          


            // detail
            $budget_detail = Termbudget::find()->where(['ID_TERM'=>$model->ID_TERM])->all();

            foreach ($budget_detail as $key => $value) {
              # code...
             

              //t0000detail
              $connection = Yii::$app->db_esm;
              $connection->createCommand()->batchInsert('t0000detail',['TERM_ID','CUST_KD_PARENT','INVES_ID','BUDGET_SOURCE','BUDGET_PLAN','BUDGET_ACTUAL','PERIODE_START','PERIODE_END','PPH23','PPN','PROGRAM'],[[$copy_term->TERM_ID,$copy_term->CUST_KD_PARENT,$value->INVES_TYPE,$value->BUDGET_SOURCE,$value->BUDGET_PLAN,$value->BUDGET_ACTUAL,$value->PERIODE_START,$value->PERIODE_END,$value->PPH23,$value->PPN,$value->PROGRAM]])->execute();
              
               //t0001detail
              $connection->createCommand()->batchInsert('t0001detail',['KD_RIB','TERM_ID','ID_INVEST','HARGA'],[[$copy_budget->KD_RIB,$copy_budget->TERM_ID,$value->INVES_TYPE,$value->BUDGET_PLAN]])->execute();
             
            }


          }

        }


			return $model;
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
	// function getPermission(){
	// 	if (Yii::$app->getUserOpt->Modul_akses(1)){
	// 		return Yii::$app->getUserOpt->Modul_akses(1);
	// 	}else{
	// 		return false;
	// 	}
	// }

}
