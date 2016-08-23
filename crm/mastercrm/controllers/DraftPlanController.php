<?php

namespace crm\mastercrm\controllers;

use Yii;
use crm\mastercrm\models\DraftPlan;
use crm\mastercrm\models\DraftPlanSearch;
use crm\mastercrm\models\Customers;
use crm\mastercrm\models\DraftGeo;
use crm\mastercrm\models\DayName;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\helpers\Json;
use yii\web\Request;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
Use ptrnov\ salesforce\Jadwal;

use crm\mastercrm\models\DraftPlanGroup;
use crm\mastercrm\models\DraftPlanHeader;
use crm\mastercrm\models\DraftPlanDetailSearch;
use crm\mastercrm\models\DraftPlanDetail;
use crm\mastercrm\models\DraftPlanGroupSearch;
use lukisongroup\sistem\models\UserloginSearch;
use crm\sistem\models\Userprofile;


use crm\mastercrm\models\DraftGeoSub;
use crm\mastercrm\models\DraftLayer;
use crm\mastercrm\models\DraftPlanProses;
use lukisongroup\sistem\models\Userlogin;
use yii\widgets\ActiveForm;
/**
 * DraftPlanController implements the CRUD actions for DraftPlan model.
 */
class DraftPlanController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Before Action Index
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
    public function beforeAction(){
            if (Yii::$app->user->isGuest)  {
                 Yii::$app->user->logout();
                   $this->redirect(array('/site/login'));  //
            }
            // Check only when the user is logged in
            if (!Yii::$app->user->isGuest)  {
               if (Yii::$app->session['userSessionTimeout']< time() ) {
                   // timeout
                   Yii::$app->user->logout();
                   $this->redirect(array('/site/login'));  //
               } else {
                   //Yii::$app->user->setState('userSessionTimeout', time() + Yii::app()->params['sessionTimeoutSeconds']) ;
                   Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
                   return true;
               }
            } else {
                return true;
            }
    }

  /** 
    *@return  connection db_esm
  */
    public function conn_esm()
    {
        return Yii::$app->db_esm;
    }


    
    public function get_arycusdetail()
    {
        return ArrayHelper::map(DraftPlanDetail::find()->where('STATUS<>1 AND STATUS<>2')->all(),'CUST_ID','custNm');
    }

     public function get_aryUserCrmSales()
    {
      $sql = Userlogin::find()->with('crmUserprofileTbl')->where('POSITION_SITE="CRM" AND POSITION_ACCESS = 2 AND status <>1')->all();
      return ArrayHelper::map($sql,'id',function ($sql, $defaultValue) {
        return $sql->username . ' - ' . $sql->crmUserprofileTbl->NM_FIRST; });
    }


     public function get_arygeo()
    {
        return ArrayHelper::map(DraftGeo::find()->where('GEO_ID<>1 AND STATUS<>3')->all(),'GEO_ID','GEO_NM');
    }

     public function get_aryProses()
    {
        return ArrayHelper::map(DraftPlanProses::find()->all(),'PROSES_ID','DCRIPT');
    }


      public function get_aryYearDetail()
    {
        $ary = self::conn_esm()->CreateCommand('SELECT LEFT(TGL,4) as TGL FROM c0002scdl_plan_detail where STATUS <>1 AND STATUS<>2')->queryAll();
        return ArrayHelper::map($ary,'TGL','TGL');
    }

     public function get_aryYearDetailJadwal()
    {
        $ary = self::conn_esm()->CreateCommand('SELECT LEFT(TGL,4) as TGL FROM c0002scdl_plan_detail where STATUS = 1 AND STATUS<>0 AND STATUS<>2')->queryAll();
        return ArrayHelper::map($ary,'TGL','TGL');
    }


     public function get_aryYearCustomers($tgl)
    {
        $ary = self::conn_esm()->CreateCommand('SELECT distinct(pd.CUST_ID),c1.CUST_NM FROM c0002scdl_plan_detail pd LEFT JOIN  c0001 c1 on pd.CUST_ID = c1.CUST_KD where pd.STATUS <>1 AND pd.STATUS<>2 AND LEFT(pd.TGL,4) ="'.$tgl.'"')->queryAll();

        return $ary;
    }

    public function get_aryYearCustomersJadwal($tgl)
    {
        $ary = self::conn_esm()->CreateCommand('SELECT distinct(pd.CUST_ID),c1.CUST_NM FROM c0002scdl_plan_detail pd LEFT JOIN  c0001 c1 on pd.CUST_ID = c1.CUST_KD where pd.STATUS = 1 AND pd.STATUS<>2 AND pd.STATUS<>0 AND LEFT(pd.TGL,4) ="'.$tgl.'"')->queryAll();

        return $ary;
    }


    public function ary_day($id)
    {
        $day_value = DayName::find()->where(['DAY_ID'=>$id])->one();

        return $day_value;
    }

     public function ary_subgeo($id)
    {
        $geo_id = DraftGeo::find()->where(['GEO_ID'=>$id])->one();

        return $geo_id;
    }

     public function ary_customers()
    {
      
        return ArrayHelper::map(Customers::find()->where(['STATUS'=>1])->all(),'CUST_KD','CUST_NM');
    }

    public function get_arygeoplangroup()
    {
        $sql ='SELECT DISTINCT(left(SCL_NM,4)) as scl_nm FROM `c0002scdl_plan_group` where STATUS = 1';
        $rslt = self::conn_esm()->CreateCommand($sql)->queryAll();
        return ArrayHelper::map($rslt,'scl_nm','scl_nm');
    }

    public function get_arygeoplandetail2()
    {
        $sql ='SELECT DISTINCT left(SCDL_GROUP_NM,4) as scdl_group_nm,SCDL_GROUP  FROM `c0002scdl_plan_detail` where STATUS <>2';
        $rslt = self::conn_esm()->CreateCommand($sql)->queryAll();
        return ArrayHelper::map($rslt,'SCDL_GROUP','scdl_group_nm');
    }

    // public function get_arygeo_sub()
    // {
    //    return ArrayHelper::map(DraftGeoSub::find()->where(['STATUS'=>1])->all(),'GEO_SUB','geo_nm');
    // }

     public function get_execute_plan($scl_nm,$user_id)
    {
        /*draftplangroup*/
       $this->conn_esm()->CreateCommand('UPDATE c0002scdl_plan_group SET USER_ID="'.$user_id.'" WHERE left(SCL_NM,4) ="'.$scl_nm.'" AND STATUS = 1')->execute();

       // /*draftplanheader*/
       $this->conn_esm()->CreateCommand('UPDATE c0002scdl_plan_header SET USER_ID="'.$user_id.'" WHERE left(NOTE,4) ="'.$scl_nm.'"')->execute();
    }

    public function ary_layer()
    {
      return ArrayHelper::map(DraftLayer::find()->all(),'LAYER_ID','LAYER_NM');
    }

     public function layer_nm()
    {
      return ArrayHelper::map(DraftLayer::find()->all(),'cus_kd','LAYER_NM');
    }

    // public function ary_detail($scdl_nm)
    // {
    //     $detail = DraftPlanDetail::find()->distinct()->where(['SCDL_GROUP_NM'=>$scdl_nm])->one()
    // }





	
	/**
     * finds draftplan models.
     * @var $dynamick draftplan.
     * @var $data converting obejct to array.
     * save c0002scdl_plan_group via batch insert.
     * if success redirect page index
     * @return mixed
     * @author wawan 
     * @since 1.2.0
	 * @author ptrnov 
     * @since 1.2.1
     */
	// public function actionSendDraft()
 //    {   
 //         /*model draftplan*/
 //        $data_draft = DraftPlan::find()->all();
 //        //$dynamick =  new DraftPlan();

 //         /*converting obejct to array*/
 //        $data = ArrayHelper::toArray($data_draft, [
	// 		'crmmastercrm\models\DraftPlan' => [
	// 			// 'SCDL_GROUP' => function ($dynamick) {
	// 					// return $dynamick->IdDinamikScdl;
	// 				// },
	// 			'IdDinamikScdl',//SCDL_GROUP
	// 			'GEO_ID',
	// 			'LayerNm',	
	// 			'DAY_ID',
	// 			'DAY_VALUE',
	// 			'CUST_KD',
	// 			'ODD_EVEN'
	// 		],
	// 	]);


	// 	//print_r($data);
		
	// 	/* GET ROW DATE OF WEEK*/
	// 	foreach ($data as $key => $value) {
 //            if($value['IdDinamikScdl'] != 'NotSet'){

              
	// 			//$aryScdlPlan = Jadwal::getArrayDateCust('2018',$value['LayerNm'],$value['ODD_EVEN'],$value['DAY_VALUE'],$value['IdDinamikScdl'],$value['CUST_KD'],'');
	// 			$aryScdlPlan = Jadwal::getArrayDateCust($value['YEAR'],$value['LayerNm'],$value['ODD_EVEN'],$value['DAY_VALUE'],$value['IdDinamikScdl'],$value['CUST_KD'],'');
			

		
	// 			//INSERT BIT To TABEL c0002scdl_plan_detail |MODEL DraftPlanDetail
	// 			foreach ($aryScdlPlan as $val) {
	// 				$this->conn_esm()->CreateCommand()->batchInsert('c0002scdl_plan_detail', 
	// 							['CUST_ID','TGL','SCDL_GROUP','ODD_EVEN'], 
	// 							[[$val['custId'],$val['tg'],$val['scdlGrp'],$val['currenWeek']]
	// 				])->execute();
	// 			}
			
	// 			/*INSERT GROUP To TABEL c0002scdl_plan_header | MODEL DraftPlanHeader */
	// 			$this->conn_esm()->CreateCommand("
	// 							INSERT INTO c0002scdl_plan_header (
	// 								SELECT NULL,TGL,SCDL_GROUP,NOTE,NULL,0,NULL,NULL,NULL,NULL,NULL FROM c0002scdl_plan_detail
	// 								GROUP BY SCDL_GROUP,TGL
	// 							)		
	// 			")->execute(); 
			
	// 		}
	// 	}	
		
 //      return $this->redirect(['index?tab=1']); 
 //    }


  
	
	
	/**
     * finds draftplan models.
     * @var $dataField converting obejct to array.
     * save c0002scdl_plan_group via batch insert.
     * if success redirect page index
     * @return mixed
	   * @author ptrnov 
     * @since 1.4.0
     */
	public static function sendMaintain($id)
    {   
         /*model draftplan*/
        $dataDraftMaintain = self::findModel($id);

         /*converting obejct to array*/
        $dataField = ArrayHelper::toArray($dataDraftMaintain, [
  			'crmmastercrm\models\DraftPlan' => [
  				'IdDinamikScdl',//SCDL_GROUP
  				'GEO_ID',
  				'LayerNm',	
  				'DAY_ID',
  				'DAY_VALUE',
  				'CUST_KD',
  				'ODD_EVEN',
  				'YEAR',
  				'GEO_SUB',

  			],
  		]);

         $geo_nm = self::ary_subgeo($dataField['GEO_ID']);


         $geo_Id = $dataField['GEO_ID'].'.'.$dataField['GEO_SUB'];
        
		
  		/* GET ROW DATE OF WEEK*/
      if($dataField['IdDinamikScdl'] != 'NotSet'){

  		$scdl_group_nm = self::code_scdl_group_nm($geo_nm['GEO_NM'],$dataField['GEO_SUB'],$dataField['ODD_EVEN'],$dataField['DAY_VALUE'],1); //code scdl_group_nm


  		$aryScdlPlan = Jadwal::getArrayDateCust($dataField['YEAR'],$dataField['LayerNm'],$dataField['ODD_EVEN'],$dataField['DAY_VALUE'],$dataField['IdDinamikScdl'],$dataField['CUST_KD'],$geo_nm->GEO_NM.'.'.$dataField['GEO_SUB']);

  		
          $ary_scdlplndetail = self::findCount($dataField['CUST_KD'],$dataField['YEAR']);
  				//INSERT BIT To TABEL c0002scdl_plan_detail |MODEL DraftPlanDetail
  		if($ary_scdlplndetail == 0)
  		{
  			foreach ($aryScdlPlan as $val) {
  				self::conn_esm()->CreateCommand()->batchInsert('c0002scdl_plan_detail', 
  							['CUST_ID','TGL','SCDL_ID','ODD_EVEN','SCDL_GROUP_NM','GEO_SUB','SCDL_GROUP','CREATE_AT','CREATE_BY'], 
  							[[$val['custId'],$val['tg'],$val['scdlGrp'],$val['currenWeek'],$scdl_group_nm,$dataField['GEO_SUB'],$geo_Id,date("Y-m-d H:i:s"),Yii::$app->user->identity->username]
  				])->execute();
  			}			
  		}

      // approve validasi
      if(self::findCountStatus($dataField['CUST_KD'],$dataField['YEAR']) != 0)
      {
         self::ApproveValidasi($dataField['CUST_KD'],$dataField['YEAR']);
      }


      $transaction = DraftPlan::getDb()->beginTransaction();
                    try {
                       //DELETE TABEL c0002scdl_plan_header
                        self::conn_esm()->CreateCommand("
                                DELETE FROM c0002scdl_plan_header  where SCDL_ID='".$dataField['IdDinamikScdl']."'
                        ")->execute();

                          //INSERT GROUP To TABEL c0002scdl_plan_header | MODEL DraftPlanHeader 
                          self::conn_esm()->CreateCommand("
                                  INSERT INTO c0002scdl_plan_header (
                                    SELECT NULL,a.TGL,a.SCDL_ID,a.SCDL_GROUP,a.SCDL_GROUP_NM,(SELECT USER_ID FROM c0002scdl_plan_group WHERE SCL_NM=a.SCDL_GROUP_NM LIMIT 1),0
                                         ,NULL,NULL,NULL,NULL,NULL FROM c0002scdl_plan_detail a
                                          where a.SCDL_ID='".$dataField['IdDinamikScdl']."'
                                        GROUP BY a.TGL,a.SCDL_ID
                                  )       
                          ")->execute();    

                        
                        // ...other DB operations...
                        $transaction->commit();
                    } catch(\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
   
		
		

	
	}
	
  	/* //DELETE TABEL c0002scdl_plan_header
  	self::conn_esm()->CreateCommand("
  					DELETE FROM c0002scdl_plan_header  where STATUS=0
  	")->execute();

  	//INSERT GROUP To TABEL c0002scdl_plan_header | MODEL DraftPlanHeader 
  	self::conn_esm()->CreateCommand("
  					INSERT INTO c0002scdl_plan_header (
  						SELECT NULL,a.TGL,a.SCDL_ID,a.SCDL_GROUP,a.SCDL_GROUP_NM,(SELECT USER_ID FROM c0002scdl_plan_group WHERE SCL_NM=a.SCDL_GROUP_NM LIMIT 1),0
  							   ,NULL,NULL,NULL,NULL,NULL FROM c0002scdl_plan_detail a
  							   GROUP BY a.TGL,a.SCDL_ID where a.STATUS<>1
  					)       
  	")->execute();  */
  	
  		
        //return $this->redirect(['index?tab=0']); 
      return 'index';
    }


    /*validation ajax*/
    public function actionValid()
    {
      # code...
      $model = new DraftPlan();
      $model->scenario = DraftPlan::SCENARIO_EXIST;
    if(Yii::$app->request->isAjax && $model->load($_POST))
    {
      Yii::$app->response->format = 'json';
      return ActiveForm::validate($model);
      }
    }


    /*validation ajax*/
    public function actionValidGroup()
    {
      # code...
      $model = new DraftPlanGroup();
      $model->scenario = DraftPlanGroup::SCENARIO_EXIST_GROP;

    if(Yii::$app->request->isAjax && $model->load($_POST))
    {
      Yii::$app->response->format = 'json';
      return ActiveForm::validate($model);
      }
    }

    /*validation ajax*/
    public function actionValidUser()
    {
      # code...
      $model = new DraftPlanDetail();
      $model->scenario = DraftPlanDetail::SCENARIO_APROVE;

    if(Yii::$app->request->isAjax && $model->load($_POST))
    {
      Yii::$app->response->format = 'json';
      return ActiveForm::validate($model);
      }
    }


      public function actionCreatePlanGroup()
    {
        $model = new DraftPlanGroup();


        if ($model->load(Yii::$app->request->post())) {

           // $day_nilai =  self::ary_day($model->DAY_ID);
           
           $geo_nm = self::ary_subgeo($model->GEO_ID);

           $jeda_geosub =  array(1, 2); //array week 

           $hari =  array(1, 2,3,4,5,6,7); //aray hari

           // $model->DAY_VALUE = $day_nilai->DAY_VALUE;

           $model->GROUP_PRN = $model->GEO_ID;


           foreach ($jeda_geosub as $key => $value) {
               # code...
            foreach ($hari as $key => $val) {
                # code...
            $model->SCL_NM = $geo_nm->GEO_NM.'.'.$model->SUB_GEO.'.'.$value.'.'.$val;

            $model->SCDL_GROUP  = self::generatecode($model->GEO_ID,$model->SUB_GEO,$value,$val,1);

            self::conn_esm()->CreateCommand()->batchInsert('c0002scdl_plan_group', 
                    ['SCDL_GROUP','GROUP_PRN','SCL_NM','GEO_ID','SUB_GEO','DAY_ID','PROSES_ID','DAY_VALUE','ODD_EVEN'], 
                    [[$model->SCDL_GROUP,$model->GROUP_PRN,$model->SCL_NM,$model->GEO_ID,$model->SUB_GEO,$value,1,$val,$value],
                    ])->execute();
            

                };
            
            };

          
           return $this->redirect(['index?tab=2']);
        } else {
            return $this->renderAjax('_plangroup', [
                'model' => $model,
                'geo'=>$this->get_arygeo(),
                'proses'=>self::get_aryProses()
            ]);
        }
    }


    /**
     * delete using ajax.
     * @author wawan
     * @since 1.1.0
     * @return true
     */
   public function actionDeletePlan(){

            if (Yii::$app->request->isAjax) {

                Yii::$app->response->format = Response::FORMAT_JSON;
                $request= Yii::$app->request;
                $dataKeySelect=$request->post('keysSelect');
                foreach ($dataKeySelect as $key => $value) {
              
                   // self::conn_esm()->createCommand()->update('c0002scdl_plan',['STATUS'=>3],'ID="'.$value.'"')->execute();
                   // DraftPlan::updateAll(['status' =>3], ['like', 'ID', $value]);

                  $transaction = DraftPlan::getDb()->beginTransaction();
                    try {
                         self::conn_esm()->createCommand()->update('c0002scdl_plan',['STATUS'=>3],'ID="'.$value.'"')->execute(); 
                        // ...other DB operations...
                        $transaction->commit();
                    } catch(\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }

                   
             }
             
         }
         
      return true;

      // return $this->redirect(['index']);
   
    }

    public function actionDeleteSchedule($id)
    {
      
        $model = self::Schdelete($id);
        if($model)
        {
          echo 1;
          // echo 'master/draft-plan/set-scdl-fday?id='.$id.'';
        }
    }


    /**
     * Creates a new User Login.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * author wawan
     */

    public function actionCreateUser()
    {
        $model = new Userlogin();
        $user_profile = new UserProfile();
        //componen user option
        $profile=Yii::$app->getUserOptcrm->Profile_user();
        $usercreate = $profile->username;

        $model->scenario = Userlogin::SCENARIO_USER;
        if ($model->load(Yii::$app->request->post())&&$user_profile->load(Yii::$app->request->post())) {
          $post = Yii::$app->request->post();
          $datapostion = $post['Userlogin']['POSITION_LOGIN'];
          if($datapostion == 1)
          {
              $auth = "SALESMAN";// auth key untuk salesmen
          }
          elseif($datapostion == 2){
            $auth = "SALES PROMOTION";// auth key untuk sales promotion
          }elseif($datapostion == 3){
            $auth = "CUSTOMER";// auth key untuk Customers
          }elseif($datapostion == 4){
            $auth = "DISTRIBUTOR";// auth key untuk Customers
          }elseif($datapostion == 5){
            $auth = "FACTORY PABRIK";// auth key untuk Customers
          }elseif($datapostion == 6){
            $auth = "OUTSOURCE";// auth key untuk Customers
          }
          $model->POSITION_LOGIN = $datapostion;
          $model->POSITION_SITE = "CRM"; // untuk login crm
          $pass = $model->password_hash;
          $security = Yii::$app->security->generatePasswordHash($pass);
          $authkey =  Yii::$app->security->generatePasswordHash($auth);
          $model->password_hash = $security;
          $model->auth_key = $authkey;
          $model->save();
          $user_profile->ID_USER = $model->id;
          $user_profile->CREATED_BY = $usercreate;
          $user_profile->CREATED_AT = date("Y-m-d H:i:s");
          $user_profile->save();
          
           return $this->redirect(['index?tab=2']);
        } else {
            return $this->renderAjax('_usercreate', [
                'model' => $model,
                'user_profile'=>$user_profile
            ]);
        }
    }



    public function actionPlanUser()
    {
        $model = new DraftPlanGroup();


        if ($model->load(Yii::$app->request->post())) {


            $ary = self::get_execute_plan($model->SCL_NM,$model->USER_ID);
            

             return $this->redirect(['index?tab=2']);
        } else {
            return $this->renderAjax('_pilihuser', [
                'model' => $model,
                'geo'=>$this->get_arygeoplangroup(),
                'user'=>self::get_aryUserCrmSales(),
                // 'scl_nm'=>$SCL_NM
            ]);
        }
    }

     /*
     * SCDL_GROUP_NM
     * @author wawan [wawan@gmail.com] 
     * @since 1.1.0
    */

      public function code_scdl_group_nm($geonm,$subGeo,$pekanGanjilGenap,$dayNilai,$proses)
    {
          if ($geonm!=''){                          // GEO_NM = check semua customer dalam group GEO_NM
            if ($subGeo!=''){                   // Check SubGeo Validation scenario  jika jumlah customer dalam (GEO+HARI) Full, harus new SubGeo.
                if ($pekanGanjilGenap!=''){     // Check hari of week[ganjil/genap] Validation scenario jumlah customer sesuai max default/max MIX
                    if ($dayNilai!=''){         // Check Layer B=u  or A,B,C,D=m
                        if ($proses!=''){       // Check Layer B=u  or A,B,C,D=m
                            $valueFormua= $geonm .'.'.$subGeo.'.'.$pekanGanjilGenap.'.'.$dayNilai;   
                        }else{
                            $valueFormua= "NotSet";
                        }
                    }else{
                        $valueFormua= "NotSet";
                    }
                }else{
                    if ($dayNilai!=''){         // Check Layer B=u  or A,B,C,D=m
                        if ($proses!=''){       // Check Layer B=u  or A,B,C,D=m
                            $valueFormua= $geonm .'.'.$subGeo.'.0.'.$dayNilai;   
                        }else{
                            $valueFormua= "NotSet";
                        }
                    }else{
                        $valueFormua= "NotSet";
                    }
                }
            }else{
                $valueFormua= "NotSet"; 
            }           
        }else{
            $valueFormua= "NotSet";
        }
        return $valueFormua;
    }


    /*
     * SCDL_GROUP DINAMIK PLAN GROUP
     * FORMULA PLAN GROUP | MAPING BY [GEO,subGEO,ODD_EVEN,DAY,PROSES_ID]
     * @author wawan [wawan@gmail.com] @since 1.3.0
    */
    public function generatecode($geo,$subGeo,$pekanGanjilGenap,$dayNilai,$proses){
        // $geo=$model->GEO_ID;                     //GET FROM CUSTOMER GEO
        // $subGeo=$model->GEO_SUB;                 //SET BY FORM GUI
        // $pekanGanjilGenap=$model->ODD_EVEN;      //SET BY FORM GUI
        // $dayNilai=$model->DAY_VALUE;             //SET BY FORM GUI       
        // $proses=$this->PROSES_ID;               //SET BY FORM GUI DEFAULT =1 (ACTIVE CALL)
        if ($geo!=''){                          // GEO = check semua customer dalam group GEO
            if ($subGeo!=''){                   // Check SubGeo Validation scenario  jika jumlah customer dalam (GEO+HARI) Full, harus new SubGeo.
                if ($pekanGanjilGenap!=''){     // Check hari of week[ganjil/genap] Validation scenario jumlah customer sesuai max default/max MIX
                    if ($dayNilai!=''){         // Check Layer B=u  or A,B,C,D=m
                        if ($proses!=''){       // Check Layer B=u  or A,B,C,D=m
                            $valueFormua= $geo .'.'.$subGeo.'.'.$pekanGanjilGenap.'.'.$dayNilai.'.'.$proses;   
                        }else{
                            $valueFormua= "NotSet";
                        }
                    }else{
                        $valueFormua= "NotSet";
                    }
                }else{
                    if ($dayNilai!=''){         // Check Layer B=u  or A,B,C,D=m
                        if ($proses!=''){       // Check Layer B=u  or A,B,C,D=m
                            $valueFormua= $geo .'.'.$subGeo.'.0.'.$dayNilai.'.'.$proses;   
                        }else{
                            $valueFormua= "NotSet";
                        }
                    }else{
                        $valueFormua= "NotSet";
                    }
                }
            }else{
                $valueFormua= "NotSet"; 
            }           
        }else{
            $valueFormua= "NotSet";
        }
        return $valueFormua;
    }

    


	
  /**
     * finds draftplan models.
     * @var $dynamick draftplan.
     * @var $data converting obejct to array.
     * save c0002scdl_plan_group via batch insert.
     * if success redirect page index
     * @return mixed
     * @author wawan 
     * @since 1.2.0
     */

    public function actionSendDraftX()
    {   
         /*model draftplan*/
        $data_draft = DraftPlan::find()->all();
        $dynamick =  new DraftPlan();

         /*converting obejct to array*/
        $data = ArrayHelper::toArray($data_draft, [
        'crmmastercrm\models\DraftPlan' => [
            'ID' => function ($dynamick) {
                return $dynamick->IdDinamikScdl;
            },
            'GEO_ID',
            'LAYER_ID',
            'DAY_ID',
            'DAY_VALUE',
            'CUST_KD',
            'ODD_EVEN'
        ],
    ]);

        // $dua = Jadwal::getArrayDateCust('2016','A','1','1','1','c00.1','66');

        // print_r($dua);
        // die();


 // foreach ($data as $value) {
 //          # code...
 //          // echo $value['ID'];
           
            
 //        }


        /*batch insert*/

        foreach ($data as $key => $value) {
            # code...
             if($value['ID'] == 'NotSet')
                {

                }else{
            $dua = Jadwal::getArrayDateCust('2016',$value->custlayer->LAYER_NM,$value['ODD_EVEN'],$value['DAY_ID'],$value['GEO_ID'],$value['CUST_KD'],'66');
        }
        
             foreach ($dua as $val) {
               
            # code...
             $this->conn_esm()->CreateCommand()
                            ->batchInsert('c0002scdl_plan_detail', ['CUST_ID','TGL','SCDL_GROUP'], [
                    [$val['custId'],$val['tg'],$val['scdlGrp']]
                ])->execute();
                        }
        }

        
       
        
        /*batch insert*/
        // foreach ($data as $val) {
        //     # code...
        //       $dua = Jadwal::getArrayDateCust('2016','C','1','1','',$val['ID'],'66');
        //        $array_nilai_uniq = array_unique($dua);
        //       foreach ($array_nilai_uniq as  $value) {
        //           # code...

        //     // $this->conn_esm()->CreateCommand()
        //     //                 ->batchInsert('c0002scdl_plan_group', ['SCDL_GROUP', 'GEO_ID','LAYER_ID','DAY_ID','DAY_VALUE'], [
        //     //         [$value['ID'],$value['GEO_ID'],$value['LAYER_ID'],$value['DAY_ID'],$value['DAY_VALUE']]
        //     //     ])->execute();
        //     //                     }
        //     $this->conn_esm()->CreateCommand()
        //                     ->batchInsert('c0002scdl_plan_group', ['SCDL_GROUP','TGL_START'], [
        //             [$value['custId'],$value['tg']]
        //         ])->execute();
        //     }
        // }
            // $array_nilai_uniq = array_unique($dua);

            // foreach ($array_nilai_uniq as $key => $val1) {
            //     # code...
            //    print_r($key);
            // die();
            //     // $this->conn_esm()->CreateCommand()
            //     //             ->batchInsert('c0002scdl_plan_group', ['SCDL_GROUP','TGL_START'], [
            //     //     [$val1['custId'],$val1['tg']]
            //     // ])->execute();
            // }
            



        return $this->redirect(['index']);

    }


    /**
     * Lists all DraftPlan models.
     * @return mixed
     */
    public function actionIndex()
    {
		    $tab=Yii::$app->getRequest()->getQueryParam('tab');

        $SCL_NM=Yii::$app->getRequest()->getQueryParam('SCL_NM');
		
        $aryStt= [
          ['STATUS' => 0, 'STT_NM' => 'Draft'],
          ['STATUS' => 1, 'STT_NM' => 'Approve'],
        ];

        $valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');

         $arySttAct= [
          ['STATUS' => 10, 'STT_NM' => 'Active'],
          ['STATUS' => 1, 'STT_NM' => 'InActive'],
        ];

        $Stt = ArrayHelper::map($arySttAct, 'STATUS', 'STT_NM');


		/*PLAN DRAFT*/
        $searchModel = new DraftPlanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		/*PLAN MAINTAIN*/
		$searchModelMaintain = new DraftPlanDetailSearch();
        $dataProviderMaintain = $searchModelMaintain->search(Yii::$app->request->queryParams);
		
		/*GROUP SETTING*/
		$searchModelGrp = new DraftPlanGroupSearch();
        $dataProviderGrp = $searchModelGrp->search(Yii::$app->request->queryParams);

		/*GROUP USER*/
		$searchModelUser = new UserloginSearch();
        $dataProviderUser = $searchModelUser->searchgroupplan(Yii::$app->request->queryParams);

       
        return $this->render('index', [
			    'tab'=>$tab,
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'valStt'=>$valStt,
    			'searchModelMaintain'=>$searchModelMaintain,
    			'dataProviderMaintain'=>$dataProviderMaintain,
    			'searchModelGrp'=>$searchModelGrp,
    			'dataProviderGrp'=>$dataProviderGrp,
         	'searchModelUser'=>$searchModelUser,
    			'dataProviderUser'=>$dataProviderUser,
          'dropcus'=>self::ary_customers(),
          'drop'=>self::get_arygeo(),
          'SCL_NM'=>$SCL_NM,
          'pekan'=>self::getPekan(),
          'layer'=>self::ary_layer(),
          'layer_nm'=>self::layer_nm(),
          'Stt'=>$Stt,
          'user'=>self::get_aryUserCrmSales(),
          'scdl_group'=>self::get_arygeoplandetail2()
        ]);
    }

    /**
     * Displays a single DraftPlan model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function getPekan()
    {
        $ary= [
              ['ID' => 1, 'OPT' => 'Pekan Ganjil'],
              ['ID' => 2, 'OPT' => 'Pekan Genap'],
            ];
         $opt = ArrayHelper::map($ary, 'ID', 'OPT');

       return $opt;
    }


 /**
    *link modal export.
    *@param int flag
    *@return mixed

 **/
 public function actionExportModal($flag)
 {

      $model = new DraftPlanDetail();

      $link_ajax = $flag != 0 ? '_export_plan' : '_export_actual';

      return $this->renderAjax($link_ajax, [
            'model'=>$model,
        ]);
 }


	/*
	 * SETUP CUSTOMER SCHEDULE FIRST DAY
	*/
    public function actionSetScdlFday($id)
    {
        //$view_info = Customers::find()->where(['CUST_KD'=>$id])->one();

        $model =  $this->findModel($id);

		    $view_info = $model->custTbl; 
       
	      $model_day = new DayName();
      

        $post = Yii::$app->request->post();

        $odd_even = $post['DayName']['OPT'];
         if ($model->load(Yii::$app->request->post())) {

            $day_value = DayName::find()->where(['DAY_ID'=>$model->DAY_ID])->one();

            $model->DAY_VALUE = $day_value->DAY_VALUE; //THE REAL DAY VALUE

            $model->ODD_EVEN = $odd_even;

            $model->save();
            $rslt=self::sendMaintain($id);
			//print_r(self::sendMaintain(248));
            //return $this->redirect(['index']);
            return $this->redirect(['index?tab=1']); 
            // return $this->redirect([$rslt]);
         }else{

          //return $this->renderAjax('_setScheduleFirstDay', [
          return $this->renderAjax('_setScheduleFirstDay', [
            'view_info' => $view_info,
            'model'=>$model,
            'model_day'=>$model_day,
            'opt'=>self::getPekan()
        ]);
      }
    }


    /*
     * Delete DrafplanDetail Customers
    */
    // public function actionPilihDelete()
    // {
    //    $model = new DraftPlanDetail();
    //    $model->scenario = 'delete';

    //      if ($model->load(Yii::$app->request->post())) {

    //         self::DeleteDetailHeader($model->CUST_ID,$model->TGL);

    //         return $this->redirect(['index?tab=1']); 

    //      }else{
    //       return $this->renderAjax('_pilihdelete', [
    //         'model'=>$model,
    //         'year'=>self::get_aryYearDetail()
    //     ]);
    //   }
    // }

 public function actionPilihDelete()
    {
      if (Yii::$app->request->isAjax) {

                Yii::$app->response->format = Response::FORMAT_JSON;
                $request= Yii::$app->request;
                $dataKeySelect=$request->post('keysSelect');
                  foreach ($dataKeySelect as $key => $value) {
                
                    $model = DraftPlanDetail::find()->where(['LIKE', 'ID', $value])->one();

                    $scdl_group_nm = $model->SCDL_GROUP_NM;

                    $cus_id = $model->CUST_ID;


                     $transaction = DraftPlan::getDb()->beginTransaction();
                    try {
                        self::conn_esm()->createCommand()->update('c0002scdl_plan_detail',['STATUS'=>3],'CUST_ID LIKE"'.$cus_id.'"')->execute();

                        self::conn_esm()->createCommand()->update('c0002scdl_plan_header',['STATUS'=>3],'NOTE="'.$scdl_group_nm.'"')->execute(); 
                        // ...other DB operations...
                        $transaction->commit();
                    } catch(\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
              
                      // self::conn_esm()->createCommand()->update('c0002scdl_plan_detail',['STATUS'=>3],'CUST_ID LIKE"'.$cus_id.'"')->execute();

                      //   self::conn_esm()->createCommand()->update('c0002scdl_plan_header',['STATUS'=>3],'NOTE="'.$scdl_group_nm.'"')->execute();

                  }
               
           }
           
        return true;

    }

    public function actionVal($id)
    {
        $data = DraftPlanDetail::find()->where(['CUST_ID'=>$id])->one();

        $data_id = $data->SCDL_GROUP_NM;

        echo json_encode($data_id);
    }

    /*
     * Approve DrafplanDetail Customers
    */
    public function actionPilihApprove()
    {
       $model = new DraftPlanDetail();
       $model->scenario = 'approve';

         if ($model->load(Yii::$app->request->post())) {

            $user = self::getuser($model->SCDL_GROUP_NM);
            if(self::findCountStatus($model->CUST_ID,$model->TGL) == 0)
            {
              foreach ($model as $key => $value) {
                # code...
                self::Approve($value->CUST_ID,$value->TGL,$user);
              }
                
            }else{
                self::ApproveValidasi($model->CUST_ID,$model->TGL);
                self::Approve($model->CUST_ID,$model->TGL,$user);
            }

            return $this->redirect(['index?tab=1']); 

         }else{
          return $this->renderAjax('_pilihapprove', [
            'model'=>$model,
            // 'cus'=>self::get_arycusdetail(),
            'year'=>self::get_aryYearDetail(),
            // 'geo'=>self::get_arygeo_sub()
        ]);
      }
    }

    public function getuser($scl_nm)
    {
         $user = DraftPlanGroup::find()->where(['SCL_NM'=>$scl_nm])->one();
         return $user->USER_ID;
    }


    public function actionLisday() {

         $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $opt = $parents[0];
             $model = DayName::find()->asArray()->where(['OPT'=>$opt])
                                                    ->all();
           foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['DAY_ID'],'name'=> $value['DAY_NM']];
               }

               echo json_encode(['output'=>$out, 'selected'=>'']);
               return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
             
   }

   /*AJAX GEO SUB*/
   public function actionLisGeoSub() {

         $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $parentGeo = $parents[0];
			  $model = DraftGeoSub::find()->asArray()->where(['GEO_ID'=>$parentGeo])->all();
           foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['GEO_SUB'],'name'=> $value['GEO_SUB'].' - '.$value['GEO_DCRIP']];
               }

               echo json_encode(['output'=>$out, 'selected'=>'']);
               return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
             
   }


   /*AJAX Customers Plan Detail*/
   public function actionLisCusPlan() {

         $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $id = $parents[0];
              $model = self::get_aryYearCustomers($id);

           foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['CUST_ID'],'name'=> $value['CUST_NM']];
               }

               echo json_encode(['output'=>$out, 'selected'=>'']);
               return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
             
   }

   public function actionApproveAll()
  {
       if (Yii::$app->request->isAjax) {

                Yii::$app->response->format = Response::FORMAT_JSON;
                $request= Yii::$app->request;
                $dataKeySelect=$request->post('keysSelect');
                foreach ($dataKeySelect as $key => $value) {
                  
                    $model = DraftPlanDetail::find()->where(['LIKE', 'ID', $value])->one();

                    $scdl_group_nm = $model->SCDL_GROUP_NM;

                    $cus_id = $model->CUST_ID;
              
                    $cari_user = DraftPlanGroup::find()->where(['SCL_NM'=>$scdl_group_nm])->one();

                   
                    
                  if($cari_user->USER_ID != ''){

                      $transaction = DraftPlanDetail::getDb()->beginTransaction();
                    try {
                         self::conn_esm()->createCommand()->update('c0002scdl_plan_detail',['STATUS'=>1],'ID LIKE"'.$value.'" AND  STATUS = 0')->execute();

                          self::conn_esm()->createCommand()->update('c0002scdl_plan_header',['STATUS'=>1,'USER_ID'=>$cari_user->USER_ID],'NOTE="'.$scdl_group_nm.'" AND STATUS = 0')->execute();

                          self::conn_esm()->createCommand()->update('c0002scdl_plan',['STATUS'=>1],'CUST_KD="'.$cus_id.'" AND STATUS = 0')->execute(); 
                        // ...other DB operations...
                        $transaction->commit();
                    } catch(\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
                      // self::conn_esm()->createCommand()->update('c0002scdl_plan_detail',['STATUS'=>1,'CUST_ID'=>$cus_id],'ID LIKE"'.$value.'" AND  STATUS = 0')->execute();

                      //   self::conn_esm()->createCommand()->update('c0002scdl_plan_header',['STATUS'=>1,'USER_ID'=>$cari_user->USER_ID],'NOTE="'.$scdl_group_nm.'" AND STATUS = 0')->execute();

                      //     self::conn_esm()->createCommand()->update('c0002scdl_plan',['STATUS'=>1],'CUST_KD="'.$model->CUST_ID.'" AND STATUS = 0')->execute();
                    }
                }
              

      return true;
  }
  return $this->redirect(['index?tab=1']);
}

  

   /*AJAX Ganti Jadwal*/
   public function actionLisGanti() {

         $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $id = $parents[0];
              $model = self::get_aryYearCustomersJadwal($id);

           foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['CUST_ID'],'name'=> $value['CUST_NM']];
               }

               echo json_encode(['output'=>$out, 'selected'=>'']);
               return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
             
   }

   public function actionGantiJadwal()
   {
       $model = new DraftPlanDetail();
       $model->scenario = 'approve'; //scenario approve same

         if ($model->load(Yii::$app->request->post())) {

           self::GantiDetailHeader($model->CUST_ID,$model->TGL);
           self::GantiJadwalPlan($model->CUST_ID,$model->TGL);

            return $this->redirect(['index?tab=1']); 

         }else{
          return $this->renderAjax('_gantijadwal', [
            'model'=>$model,
            // 'cus'=>self::get_arycusdetail(),
            'year'=>self::get_aryYearDetailJadwal()
        ]);
      }

   }

   
    /**
     * Creates a new DraftPlan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DraftPlan();


        if ($model->load(Yii::$app->request->post())) {
			$hsl = \Yii::$app->request->post();	
			$tahun = $hsl['DraftPlan']['YEAR'];

            // $model->save();
            $check_exist = DraftPlan::find()->where(['GEO_ID'=>$model->GEO_ID,'YEAR'=>$tahun])->one();

            /*get customers*/
            $get_customers = Customers::find()->where(['GEO'=>$model->GEO_ID])->all();

        //     if(count($check_exist) != 0)
        //     {
        //        /*delete plan*/
        //         self::DeletePlan($model->GEO_ID);

        //         /*batch insert*/
        //         foreach ($get_customers as $key => $value) {
        //             # code...
        //               $batch = self::conn_esm()->CreateCommand()->batchInsert('c0002scdl_plan', ['CUST_KD', 'GEO_ID','LAYER_ID','YEAR'], [
        //             [$value->CUST_KD,$value->GEO,$value->LAYER,$tahun],
        //         ])->execute();
        //         }
        //     }else{

        //     /*batch insert*/
        //     foreach ($get_customers as $key => $value) {
        //         # code...
        //           $batch = self::conn_esm()->CreateCommand()->batchInsert('c0002scdl_plan', ['CUST_KD', 'GEO_ID','LAYER_ID','YEAR'], [
        //         [$value->CUST_KD,$value->GEO,$value->LAYER,$tahun],
        //     ])->execute();
        //     }
        // }

             if(count($check_exist) == 0)
            {
               
                /*batch insert*/
                foreach ($get_customers as $key => $value) {
                    # code...
                      $batch = self::conn_esm()->CreateCommand()->batchInsert('c0002scdl_plan', ['CUST_KD', 'GEO_ID','LAYER_ID','YEAR'], [
                    [$value->CUST_KD,$value->GEO,$value->LAYER,$tahun],
                ])->execute();
                }
            }
        
          
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'geo'=>$this->get_arygeo(),
            ]);
        }
    }

    /**
     * Updates an existing DraftPlan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

   

  /**
     * Finds the DraftPlandetail   model based on its CUST_KD value AND STATUS equal 0.
     * @param string $CUST_KD
     * @return @var ary_scdlplndetail
     */
    protected function finddetailary_cus($custId)
    {
       $ary_scdlplndetail = DraftPlanDetail::find()->distinct()->where(['CUST_ID'=>$custId,'STATUS' => 0])->one();

       return $ary_scdlplndetail;
    }


     /**
     * Finds the DraftPlandetail count  model based on its CUST_KD value AND STATUS equal 0.
     * @param string $CUST_KD
     * @return @var ary_scdlplndetail
     */
    protected function findCount($custId,$tgl)
    {
        // $ary = self::finddetailary_cus($custId);
        // $tahun = substr($ary->TGL,0,4);
       // $ary_scdlplndetail = DraftPlanDetail::find()->where(['CUST_ID'=>$custId,'STATUS' => 0])->count();
        $ary_scdlplndetail = DraftPlanDetail::find()->where('LEFT(TGL,4) ="'.$tgl.'" AND CUST_ID="'.$custId.'" AND STATUS = 0 ')->count();

        // print_r($ary_scdlplndetail);
        // die();

       return $ary_scdlplndetail;
    }


     /**
     * Finds the DraftPlandetail count  model based on its CUST_KD value AND    STATUS equal 1.
     * @param string $CUST_KD
     * @return @var ary_scdlplndetail
     */
    protected function findCountStatus($custId,$tgl)
    {
         

       // $ary_scdlplndetail = DraftPlanDetail::find()->where(['CUST_ID'=>$custId,'STATUS' => 1])->count();
         $ary_scdlplndetail = DraftPlanDetail::find()->where('LEFT(TGL,4) ="'.$tgl.'" AND CUST_ID="'.$custId.'" AND STATUS = 1')->count();

       return $ary_scdlplndetail;
    }


      /**
     * Delete All
     * @param string $custId
     */
    protected function DeleteDetailHeader($custId,$tgl)
    {
        // DraftPlanDetail::deleteAll(['CUST_ID'=>$custId,'STATUS'=>0]);
        DraftPlanDetail::deleteAll('LEFT(TGL,4) ="'.$tgl.'" AND CUST_ID="'.$custId.'" AND STATUS = 0');

        DraftPlanHeader::deleteAll('LEFT(TGL,4) ="'.$tgl.'" AND STATUS = 0');

        $this->conn_esm()->CreateCommand('UPDATE c0002scdl_plan SET STATUS=0 WHERE YEAR ="'.$tgl.'" AND CUST_KD="'.$custId.'" AND STATUS = 1')->execute();

    }

      /**
     * Delete All
     * @param string $custId
     */
    protected function GantiDetailHeader($custId,$tgl)
    {
        // DraftPlanDetail::deleteAll(['CUST_ID'=>$custId,'STATUS'=>0]);
        DraftPlanDetail::deleteAll('LEFT(TGL,4) ="'.$tgl.'" AND CUST_ID="'.$custId.'" AND STATUS = 1');

         DraftPlanDetail::deleteAll('LEFT(TGL,4) ="'.$tgl.'" AND CUST_ID="'.$custId.'" AND STATUS = 0');

        DraftPlanHeader::deleteAll('LEFT(TGL,4) ="'.$tgl.'" AND STATUS = 1');
    }


     /**
     * update STATUS 0
     * @param string $custId
     */
    protected function GantiJadwalPlan($custId,$tgl)
    {
    
        $this->conn_esm()->CreateCommand('UPDATE c0002scdl_plan SET STATUS=0 WHERE YEAR ="'.$tgl.'" AND CUST_KD="'.$custId.'" AND STATUS = 1')->execute();
       
    }


    /**
     * Delete All DraftPlan
     * @param string $geoId
     */
    // protected function DeletePlan($geoId)
    // {
    //      /*delete data if exist */
    //      self::conn_esm()->CreateCommand('DELETE FROM c0002scdl_plan WHERE GEO_ID='.$geoId.'')->execute();
    // }


     /**
     * update STATUS 1
     * @param string $custId
     */
    // protected function Approve($custId,$tgl,$user_id)
    // {
    //    $this->conn_esm()->CreateCommand('UPDATE c0002scdl_plan_detail SET STATUS=1 WHERE LEFT(TGL,4) ="'.$tgl.'" AND CUST_ID="'.$custId.'" AND STATUS = 0')->execute();

    //     $this->conn_esm()->CreateCommand('UPDATE c0002scdl_plan SET STATUS=1 WHERE YEAR ="'.$tgl.'" AND CUST_KD="'.$custId.'" AND STATUS = 0')->execute();

    //     $this->conn_esm()->CreateCommand('UPDATE c0002scdl_plan_header SET STATUS=1,USER_ID ="'.$user_id.'" WHERE LEFT(TGL,4) ="'.$tgl.'" AND STATUS = 0')->execute();
       
    // }

     protected function Approve($custId,$tgl,$user_id)
    {
       $this->conn_esm()->CreateCommand('UPDATE c0002scdl_plan_detail SET STATUS=1 WHERE LEFT(TGL,4) ="'.$tgl.'" AND CUST_ID="'.$custId.'" AND STATUS = 0')->execute();

        $this->conn_esm()->CreateCommand('UPDATE c0002scdl_plan SET STATUS=1 WHERE YEAR ="'.$tgl.'" AND CUST_KD="'.$custId.'" AND STATUS = 0')->execute();

        $this->conn_esm()->CreateCommand('UPDATE c0002scdl_plan_header SET STATUS=1,USER_ID ="'.$user_id.'" WHERE LEFT(TGL,4) ="'.$tgl.'" AND STATUS = 0')->execute();
       
    }


    /**
     * update STATUS 2
     * @param string $custId
     */
    protected function ApproveValidasi($custId,$tgl)
    {
            # code...
        self::conn_esm()->CreateCommand('UPDATE c0002scdl_plan_detail SET STATUS=2 WHERE LEFT(TGL,4) ="'.$tgl.'" AND CUST_ID="'.$custId.'" And STATUS = 1')->execute();
       
        self::conn_esm()->CreateCommand('UPDATE c0002scdl_plan_header SET STATUS=2 WHERE LEFT(TGL,4) ="'.$tgl.'" AND STATUS = 1')->execute();

         $this->conn_esm()->CreateCommand('UPDATE c0002scdl_plan SET STATUS=0 WHERE YEAR ="'.$tgl.'" AND CUST_KD="'.$custId.'" AND STATUS = 1')->execute();
    }

    public function Schdelete($id)
    {
        $model = DraftPlanDetail::deleteAll('CUST_ID = :cus_id', [':cus_id' => $id]);

        $this->conn_esm()->CreateCommand('UPDATE c0002scdl_plan SET STATUS=0 WHERE  CUST_KD="'.$id.'" AND STATUS = 1')->execute();

        return true;
    }

	
	/*
	 * @author piter [ptr.nov@gmail.com]
	*/
	public function actionJsoncalendarPlan($start=NULL,$end=NULL,$_=NULL){
		$calendarPlan= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("
				SELECT a1.ID as id, a1.TGL as start,a1.TGL as end, concat(a1.NOTE,'-',a2.NM_FIRST) as title  
FROM c0002scdl_plan_header a1
LEFT JOIN dbm_086.user_profile a2 on a2.ID_USER=a2.ID_USER GROUP BY NOTE,TGL
			")->queryAll(),
		]);
		//FIELD HARUS [id,start,end,title]        
		$eventCalendarPlan=$calendarPlan->allModels; 
		//print_r($eventCalendarPlan);
		//die();
		header('Content-type: application/json');		
        echo Json::encode($eventCalendarPlan);
        Yii::$app->end();
    }
	

    /**
     * Finds the DraftPlan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DraftPlan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DraftPlan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
