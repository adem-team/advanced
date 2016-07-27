<?php

namespace lukisongroup\master\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \DateTime;
use yii\helpers\Json;
use yii\web\Request;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Scheduleheader;
use lukisongroup\master\models\Scheduledetail;
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Schedulegroup;
use lukisongroup\master\models\ScheduleheaderSearch;
use lukisongroup\hrd\models\Employe;
use lukisongroup\sistem\models\Userlogin;
use lukisongroup\sistem\models\UserloginSearch;
use crm\sistem\models\Userprofile;
use yii\data\ArrayDataProvider;
use DateInterval;
use DatePeriod;

/**
 * ScheduleHeaderController implements the CRUD actions for Scheduleheader model.
 */
class ScheduleHeaderController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

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
     * Lists all Scheduleheader models.
     * @return mixed
     */
    public function actionIndex()
    {

		$aryDataProviderRptScdl= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL ERP_CUSTOMER_VISIT_SchaduleReport('2016-06-30')")->queryAll(),
			 'pagination' => [
				'pageSize' => 50,
			]
		]);
		    $attributeField=$aryDataProviderRptScdl->allModels[0]; //get label Array 0

		
        $searchModel = new ScheduleheaderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModel1 = new ScheduleheaderSearch();
        $dataProvider1 = $searchModel->searchid(Yii::$app->request->queryParams);

        $searchModelUser = new UserloginSearch();
        $dataProviderUser = $searchModelUser->searchCustGroup(Yii::$app->request->queryParams);

        $model = new Scheduleheader();

        // data select2 for SCDL_GROUP
        $query = Schedulegroup::find()->all();
        $datagroup = ArrayHelper::map($query, 'ID', 'SCDL_GROUP_NM');

        // data select2 for SCDL_GROUP_NM
        $query = Schedulegroup::find()->all();
        $datagroup_nm = ArrayHelper::map($query, 'SCDL_GROUP_NM', 'SCDL_GROUP_NM');

        // data select2 for USER_ID where CRM and STATUS 10(active)
        $query1 = Userlogin::find()->where('POSITION_SITE = "CRM" AND STATUS = 10')->all();
        $datauser = ArrayHelper::map($query1, 'id', 'username');

        //componen user option
        $profile=Yii::$app->getUserOpt->Profile_user()->emp;
        $id = $profile->EMP_ID;

        $user_profile = Employe::find()->where(['EMP_ID'=>$id])->one();

        return $this->render('index', [
			     'dataProviderUser'=>$dataProviderUser,
		        'searchModelUser'=>$searchModelUser,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel1' => $searchModel1,
            'dataProvider1' => $dataProvider1,
            'model'=>$model,
            'datagroup'=>$datagroup,
            'datauser'=>$datauser,
      			'aryDataProviderRptScdl'=>$aryDataProviderRptScdl,
      			'attributeField'=>$attributeField,
            'user_profile'=>$user_profile,
            'datagroup_nm'=>$datagroup_nm
        ]);
    }

     // action depdrop
   public function actionSubGroup($tgl) {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $id = $parents[0];
            if($id == 1)
            {
              $model = Schedulegroup::find()->asArray()->all();
            

              foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['ID'],'name'=> $value['SCDL_GROUP_NM']];
               }

            }else{
               // data select2 for SCDL_GROUP
              $connection = \Yii::$app->db_esm;
              $query = $connection->createCommand('SELECT * from c0007 where ID NOT IN (SELECT DISTINCT(SCDL_GROUP) FROM c0002scdl_detail  WHERE TGL="'.$tgl.'")');
              $model = $query->queryAll();

              foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['ID'],'name'=> $value['SCDL_GROUP_NM']];
               }

            }

            

               echo json_encode(['output'=>$out, 'selected'=>'']);
               return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
   }


   // action depdrop
   public function actionSubUser($tgl) {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $id = $parents[0];
            if($id == 1)
            {

                $connection = \Yii::$app->db_esm;
                $querycariuser = 'SELECT * FROM dbm001.user where POSITION_SITE = "CRM" AND STATUS = 10';
                $model = $connection->createCommand($querycariuser)->queryAll();
            

              foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['id'],'name'=> $value['username']];
               }

            }else{
               // data select2 for User
            
              $connection = \Yii::$app->db_esm;
              $querycariuser = 'SELECT * FROM dbm001.user  where id  NOT IN (SELECT DISTINCT(USER_ID) from dbc002.c0002scdl_detail WHERE TGL="'.$tgl.'") AND POSITION_SITE = "CRM" AND STATUS = 10';
              $model = $connection->createCommand($querycariuser)->queryAll();

              foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['id'],'name'=> $value['username']];
               }

            }

            

               echo json_encode(['output'=>$out, 'selected'=>'']);
               return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
   }




    /**
     * Displays a single Scheduleheader model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single Scheduleheader model.
     * @param integer $id
     * @return mixed
     */
    public function actionGetData($id)
    {
        $model = Userlogin::find()->where(['id'=>$id])->asArray()->one();

    
      // $out[];
          // $out  = "<table class='table table-hover'> 
          //         <tbody> 
          //             <tr> 
          //             <td>username <td> 
          //             <td>email</td></tr> 
          //             <tr>
          //             <td>".$model['username']."</td> 
          //             <td>".$model['status']." </td>
          //             </tr>
          //             </tbody>
          //             </table>";
           

               echo json_encode($model);
             
    }

    /**
     * Creates a new Scheduleheader model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Scheduleheader();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


  /**
    * Creates a new schedule header and schedule detail.
    * If creation is successful, bacth insert to schedule detail.
    * usage save ajax ver 1.1 author : wawan
 */
    public function actionCreateGroup($tgl1,$tgl2)
    {
        

        $ary= [
      ['id' => 0, 'UBAH_NM' => 'permanen'],      
      ['id' => 1, 'UBAH_NM' => 'Update'],
          ];  
          $val = ArrayHelper::map($ary, 'id', 'UBAH_NM');

          $post = Yii::$app->request->post();
          $post['Scheduleheader']['STT_UBAH'];
          // if equal 1 then update else save
         if($post['Scheduleheader']['STT_UBAH'] == 1)
         {
            $model = Scheduleheader::find()->where(['TGL1'=>$tgl1])->one();
          

             if ($model->load(Yii::$app->request->post())) {

                $model->TGL1 = $tgl1;
                $model->TGL2 = $tgl2;
                // cari group nama
                $cari_groupName = Schedulegroup::find()->where(['ID'=>$model->SCDL_GROUP])->asArray()->one();
                  /* split array author : wawan*/
                  $temp = explode(" ",$cari_groupName['SCDL_GROUP_NM']);
                  $result = '';
                  foreach($temp as $t)
                  {
                    $result .= $t[0];
                  }
                $model->NOTE = $result;
                $model->save();
                return $this->redirect(['index']);
                }else{

              return $this->renderAjax('_formschedule', [
                'model' => $model,
                'datagroup'=>$datagroup,
                'datauser'=>$datauser,
                'val'=>$val,
                'tgl1'=>$tgl1

            ]);
                }

         }else{

          $model = new Scheduleheader();
           // data select2 for USER_ID where CRM and STATUS 10(active)
        $connection = \Yii::$app->db_esm;
        $querycariuser = 'SELECT * FROM dbm001.user  where id  NOT IN (SELECT DISTINCT(USER_ID) from dbc002.c0002scdl_detail WHERE TGL="'.$tgl1.'") AND POSITION_SITE = "CRM" AND STATUS = 10';
        $user = $connection->createCommand($querycariuser)->queryAll();
        $datauser = ArrayHelper::map($user, 'id', 'username');

        // data select2 for SCDL_GROUP
        $connection = \Yii::$app->db_esm;
        $model1 = $connection->createCommand('SELECT * from c0007 where ID NOT IN (SELECT DISTINCT(SCDL_GROUP) FROM c0002scdl_detail  WHERE TGL="'.$tgl1.'")');
        $query = $model1->queryAll();
        $datagroup = ArrayHelper::map($query, 'ID', 'SCDL_GROUP_NM');

         
        //componen user option
        $profile=Yii::$app->getUserOpt->Profile_user();
        $usercreate = $profile->username;
        //proses save
        if ($model->load(Yii::$app->request->post())) {

          $model->TGL1 = $tgl1;
          $model->TGL2 = $tgl2;
          // cari group nama
          $cari_groupName = Schedulegroup::find()->where(['ID'=>$model->SCDL_GROUP])->asArray()->one();
            /* split array author : wawan*/
            $temp = explode(" ",$cari_groupName['SCDL_GROUP_NM']);
            $result = '';
            foreach($temp as $t)
            {
              $result .= $t[0];
            }
          //$model->NOTE = $result;
          $model->NOTE = $cari_groupName['SCDL_GROUP_NM'];  /*Update by ptr.nov*/
          $model->CREATE_BY = $usercreate;
          $model->CREATE_AT = date("Y-m-d H:i:s");
           if($model->save())
           {
             // foreach date :author wawan
               for ($date = strtotime($tgl1); $date <= strtotime($tgl2); $date = strtotime("+1 day", $date)) {
                         $tgl =  date("Y-m-d", $date);
                         //batch insert customers author :wawan
                         $Customers = Customers::find()->where(['SCDL_GROUP'=>$model->SCDL_GROUP])->asArray()->all();
                         foreach ($Customers as $key => $value) {
                           # code...
                           $connection = Yii::$app->db_esm;
                           $connection->createCommand()->batchInsert('c0002scdl_detail',['TGL','CUST_ID','SCDL_GROUP','USER_ID'],[[$tgl,$value['CUST_KD'],$model->SCDL_GROUP,$model->USER_ID]])->execute();
                         }
                   }
           }
         
            return $this->redirect(['index']);

        } else {
            return $this->renderAjax('_formschedule', [
                'model' => $model,
                'datagroup'=>$datagroup,
                'datauser'=>$datauser,
                'val'=>$val,
                'tgl1'=>$tgl1
            ]);
        }
      }
    }


    /**
     * Creates a new User Login.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * quthor wawan
     */

    public function actionCreateUser()
    {
        $model = new Userlogin();
        $user_profile = new UserProfile();
        //componen user option
        $profile=Yii::$app->getUserOpt->Profile_user();
        $usercreate = $profile->username;

        $model->scenario = 'createuser';
        if ($model->load(Yii::$app->request->post())  ) {
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
          if($model->save())
          {
            $user_profile->ID = $model->id;
            $user_profile->NM_FIRST = $model->username;
            $user_profile->CREATED_BY = $usercreate;
            $user_profile->CREATED_AT = date("Y-m-d H:i:s");
            $user_profile->save();
           
          }
           return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

     public function actionViewUserCrm($id)
    {
       
          $model = Userlogin::find()->where(['id'=>$id])->one();
       
        if ($model->load(Yii::$app->request->post())){
          $model->UPDATED_AT = date("Y-m-d H:i:s");
          $model->UPDATED_BY =  Yii::$app->user->identity->username;
           
      if($model->save()){
       
        
        return $this->redirect(['/master/schedule-header/index']);
         
      };
    }else{
      return $this->renderAjax('view_user_crm', [
            'model' => $model,
        ]);
    }
    }

    /**
     * Updates an existing Scheduleheader model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing Scheduleheader model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Scheduleheader model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Scheduleheader the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Scheduleheader::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


	 /**
     * [actionJsoncalendar description]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @param  [type] $_     [description]
     * @return [type]        [description]
     */
     /*SHOW JSON*/
       public function actionJsoncalendar($start=NULL,$end=NULL,$_=NULL){
       //public function actionJsoncalendar(){
           $events = array();

           /*array dataprovider from ScheduleDetail author :wawan*/
           $AryDataProviderVal= new ArrayDataProvider([
    			'allModels'=>Yii::$app->db_esm->createCommand("SELECT DISTINCT
    					TGL as start, (SELECT SCDL_GROUP_NM FROM c0007 WHERE ID=SCDL_GROUP) as title
    					FROM c0002scdl_detail;")->queryAll(),
    			 'pagination' => [
    				'pageSize' => 100,
    			]
    			]);
           /*event calender from ScheduleDetail author :wawan*/
    			$eventCalendar=$AryDataProviderVal->getModels();
           //Demo
           $Event = new \yii2fullcalendar\models\Event();
   		//FIELD HARUS [id,start,end,title]
           header('Content-type: application/json');
           echo Json::encode($eventCalendar);
           Yii::$app->end();
       }

  /**
    * Creates a new schedule header and schedule detail.
    * If creation is successful, bacth insert to schedule detail.
    * not in use again save ajax ver 1.0 author : wawan
  */

	//  public function actionJsoncalendar_add(){
   //
	// 	if (Yii::$app->request->isAjax) {
	// 		$request= Yii::$app->request;
	// 		$model =  new Scheduleheader();
  //     $profile=Yii::$app->getUserOpt->Profile_user();
  //     $usercreate = $profile->username;
	// 		$end=$request->post('tgl2');
  //     $start=$request->post('tgl1');
	// 		$scdl_group=$request->post('scdl_group');
  //     $user_id = $request->post('user_id');
  //     $note = $request->post('note');
	// 		$model->TGL1 = $start;
  //     $model->TGL2 = $end;
  //     $model->CREATE_BY = $usercreate;
  //     $model->CREATE_AT = date("Y-m-d H:i:s");
  //     $model->NOTE = $note;
  //     $model->SCDL_GROUP = $scdl_group;
	// 		$model->USER_ID = $user_id;
  //     $carisdl = Scheduleheader::find()->where(['TGL1'=>$model->TGL1,'SCDL_GROUP'=>$scdl_group])->one();

      // if exist data customers
  //     if($carisdl)
  //     {
  //       echo 2;
  //     }
  //     else{
   //
	// 		if($model->save())
  //     {
   //
  //       // foreach date :author wawan
  //         for ($date = strtotime($start); $date < strtotime($end); $date = strtotime("+1 day", $date)) {
  //                   $tgl =  date("Y-m-d", $date);
  //                   $Customers = Customers::find()->where(['SCDL_GROUP'=>$scdl_group])->asArray()->all();
  //                   foreach ($Customers as $key => $value) {
  //                     # code...
  //                     $connection = Yii::$app->db_esm;
  //                     $connection->createCommand()->batchInsert('c0002scdl_detail',['TGL','CUST_ID','SCDL_GROUP','USER_ID'],[[$tgl,$value['CUST_KD'],$scdl_group,$user_id]])->execute();
  //                   }
  //             }
  //       }
  //   }
   //
	// 	}
	// 	return true;
   //
	//  }
}
