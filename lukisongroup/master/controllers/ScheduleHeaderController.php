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
use lukisongroup\sistem\models\Userlogin;
use lukisongroup\sistem\models\UserloginSearch;
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

        $searchModel = new ScheduleheaderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModelUser = new UserloginSearch();
        $dataProviderUser = $searchModelUser->searchCustGroup(Yii::$app->request->queryParams);

        $model = new Scheduleheader();

        // data select2 for SCDL_GROUP
        $query = Schedulegroup::find()->all();
        $datagroup = ArrayHelper::map($query, 'ID', 'SCDL_GROUP_NM');

        // data select2 for USER_ID where CRM and STATUS 10(active)
        $query1 = Userlogin::find()->where('POSITION_SITE = "CRM" AND STATUS = 10')->all();
        $datauser = ArrayHelper::map($query1, 'id', 'username');

        return $this->render('index', [
			       'dataProviderUser'=>$dataProviderUser,
			       'searchModelUser'=>$searchModelUser,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
            'datagroup'=>$datagroup,
            'datauser'=>$datauser
        ]);
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
     * Creates a new User Login.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * quthor wawan
     */

    public function actionCreateUser()
    {
        $model = new Userlogin();
        $model->scenario = 'createuser';
        if ($model->load(Yii::$app->request->post())  ) {
          $post = Yii::$app->request->post();
          $datapostion = $post['Userlogin']['POSITION_LOGIN'];
          if($datapostion == 1)
          {
              $auth = "SALESMAN";// auth key untuk salesmen
          }
          else{
            $auth = "SALES PROMOTION";// auth key untuk sales promotion
          }
          $model->POSITION_LOGIN = $datapostion;
          $model->POSITION_SITE = "CRM"; // untuk login crm
          $pass = $model->password_hash;
          $security = Yii::$app->security->generatePasswordHash($pass);
          $authkey =  Yii::$app->security->generatePasswordHash($auth);
          $model->password_hash = $security;
          $model->auth_key = $authkey;
          $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
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
   		$eventCalendar= Scheduleheader::find()->all();
   		//print_r($eventCalendar);
   		//die();
           //Demo
           $Event = new \yii2fullcalendar\models\Event();
   		//FIELD HARUS [id,start,end,title]
           header('Content-type: application/json');
           echo Json::encode($eventCalendar);
           Yii::$app->end();
       }

  //   public function getDatesFromRange($start, $end) {
  //          $interval = new DateInterval('P1D');
  //          $realEnd = new DateTime($end);
  //          $realEnd->add($interval);
  //          $period = new DatePeriod(
  //          new DateTime($start),
  //          $interval,
  //          $realEnd
  //      );
  //    foreach($period as $date) {
  //      $array[] = $date->format('Y-m-d');
  //    }
  //      return $array;
  //  }

// save using ajax: author wawan

	 public function actionJsoncalendar_add(){

		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$model =  new Scheduleheader();
      $profile=Yii::$app->getUserOpt->Profile_user();
      $usercreate = $profile->username;
			$end=$request->post('tgl2');
      $start=$request->post('tgl1');
			$scdl_group=$request->post('scdl_group');
      $user_id = $request->post('user_id');
      $note = $request->post('note');
			$model->TGL1 = $start;

      $model->TGL2 = $end;
      $model->CREATE_BY = $usercreate;
      $model->CREATE_AT = date("Y-m-d H:i:s");
      $model->NOTE = $note;
      $model->SCDL_GROUP = $scdl_group;
			$model->USER_ID = $user_id;
      // print_r($model->TGL1);
      // die();
      $carisdl = ScheduleDetail::find()->where(['TGL'=>$model->TGL1])->count();
      if($carisdl >0)
      {
        echo 2;
      }
      else{

			if($model->save())
      {

        // Call the function
        // $dates = $this->getDatesFromRange($start, $end);
        // print_r($dates);
        // die();
          $Customers = Customers::find()->where(['SCDL_GROUP'=>$scdl_group])->asArray()->all();
          foreach ($Customers as $key => $value) {
            # code...
            $connection = Yii::$app->db_esm;
            $connection->createCommand()->batchInsert('c0002scdl_detail',['TGL','CUST_ID','SCDL_GROUP','USER_ID'],[[$start,$value['CUST_KD'],$scdl_group,$user_id]])->execute();
          }
      }
    }

		}
		return true;

	 }
}
