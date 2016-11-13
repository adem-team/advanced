<?php

namespace lukisongroup\widget\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;
use yii\filters\ContentNegotiator;
use yii\data\ActiveDataProvider;

use api\modules\chart\models\Cnfweek; 
use api\modules\chart\models\Cnfmonth;
use lukisongroup\widget\models\Pilotproject;
use lukisongroup\widget\models\PilotEvent;
use lukisongroup\hrd\models\Employe;
use lukisongroup\esm\models\Kategoricus;
use lukisongroup\widget\models\PilotprojectSearch;
use lukisongroup\widget\models\PilotprojectParent;

/**
 * PilotprojectController implements the CRUD actions for Pilotproject model.
 */
class PilotprojectController extends Controller
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
			'bootstrap'=> [
				'class' => ContentNegotiator::className(),
				'formats' => [
					'application/json' => Response::FORMAT_JSON,'charset' => 'UTF-8',
				],
				'languages' => [
					'en',
					'de',
				],
			],		
        ];
		
    }
   

    /**
     * Lists all Pilotproject models.
     * @return mixed
     */
     public function beforeAction($action){
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

    public function actionIndex()
    {
        $searchModel = new PilotprojectSearch();
        $dataProviderDept = $searchModel->searchDept(Yii::$app->request->queryParams);
		    $dataProviderEmp = $searchModel->searchEmp(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProviderDept' => $dataProviderDept,
			'dataProviderEmp' => $dataProviderEmp,
			'actionChartGrantPilotproject'=>$this->actionChartGrantPilotproject(),
		  ]);
    }

    /**
     * Displays a single Pilotproject model.
     * @param string $id
     * @return mixed
     */
    //public function actionView($ID,$PILOT_ID)
    //{
    //    return $this->render('view', [
    //        'model' => $this->findModel($ID,$PILOT_ID),
    //    ]);
    //}
    public function actionView($id,$PILOT_ID)
    {
		$model = $this->findModel($id,$PILOT_ID);
		if ($model->load(Yii::$app->request->post())){
			$model->UPDATED_BY=Yii::$app->user->identity->username;
			if($model->validate()){
				if($model->save()){					
					return $this->redirect(['index']);					
				} 
			}
		}else {
            return $this->renderAjax('_view', [
            //return $this->render('_view', [
                'model' => $model,
            ]);
        }
    }


    public function actionClose($id,$parent,$sort)
    {
        if($parent == 0)
        {
            Pilotproject::updateAll(['STATUS' =>1], ['SORT'=>$sort]);
        }else{
            $model =  $this->findModel($id);
            $model->STATUS = 1;
            $model->save();
        }
         return $this->redirect('index');
       
    }
    /**
     * Creates a new Pilotproject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     
     public function actionActualclose($ID,$PILOT_ID){
         
          $model = $this->findModel($ID,$PILOT_ID);
         
         if($model->load(Yii::$app->request->post()))
         {
            
              $model->save();
              return $this->redirect('index');
         }
         
         else {
            return $this->renderAjax('actual', [
                'model' => $model,
            ]);
        }
         
     }

     public function actionDetailPilot($id)
     {
        $model = self::findModel($id);

         $post =Yii::$app->request->post();
         $val = $post['Pilotproject']['parentpilot'];

        if ($model->load(Yii::$app->request->post())){


          if($val != 0 || $val == '')
          {
             $model->SORT = $id;
             $model->PARENT = 0;
          }else{
            
              $model->SORT = $model->PARENT;
          }
          // $model->DESTINATION_TO = $sendto;

            if($model->save()){
              self::Sendmail($model->ID); // call function send mail
            }
            return $this->redirect('index');
        }else{
            return $this->renderAjax('detail_pilot', [
                'model' => $model,
                'dropemploy'=>self::get_aryEmploye(),
                'pilot'=>self::get_aryParent()
            ]);
        }

     }


    
     
    public function actionCreate($id)
    {
		
		$model = new Pilotproject();
		
		if ($model->load(Yii::$app->request->post())){
                $model->PARENT = $id;
                $model->SORT = $id;
                $model->PILOT_ID = '';
                $model->ACTUAL_DATE1 = date('Y-m-d h:i:s');
                // $model->ACTUAL_DATE2 = "";
                $model->DEP_ID =  Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;		
				$model->CREATED_BY= Yii::$app->user->identity->username;		
				$model->UPDATED_TIME = date('Y-m-d h:i:s'); 				
				$model->save();
				if($model->save()){
					
				return $this->redirect('index');
				} 
		}else {
           
			return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }	
    }

     
    // public function actionCreateparent()
    // {
      
    //     $model = new Pilotproject();
        
    //     if ($model->load(Yii::$app->request->post())){

    //             $sql = Pilotproject::find()->count();
                                                
    //             $model->SORT = $sql+1;
    //             $model->PARENT = 0;
    //             $model->DEP_ID =  Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
    //             $dep_id = $model->DEP_ID;
    //             $model->ACTUAL_DATE1 = date('Y-m-d h:i:s');
    //             // $model->ACTUAL_DATE2 = "";
    //             $pilot_id = Yii::$app->ambilkonci->getpilot($dep_id);
    //                // print_r($pilot_id );
    //                // die();
    //             $model->PILOT_ID = $pilot_id;              
    //             $model->CREATED_BY= Yii::$app->user->identity->username;     
    //             $model->UPDATED_TIME = date('Y-m-d h:i:s');               
    //             $model->save();
    //             // print_r($model);
    //             // die();

           
                    
    //                  return $this->redirect('index');
                
    //     }else {
           
    //         return $this->renderAjax('_form', [
    //             'model' => $model,
    //         ]);
    //     }   
    // }

    /**
    *array employe
    **/
    public function get_aryEmploye()
    {
        $emp = \lukisongroup\hrd\models\Employe::find()->where('STATUS<>3')->all();
        return $dropemploy = ArrayHelper::map($emp,'EMP_EMAIL', function ($emp, $defaultValue) {
          return $emp['EMP_NM'] . ' ' . $emp['EMP_NM_BLK'];
    });
    }

    /**
    *array employe
    **/
    public function get_aryDep_sub()
    {
        $dep = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
        $emp = \lukisongroup\hrd\models\Employe::find()->where('STATUS<>3 and DEP_ID="'.$dep.'"')->all();
        return $dropemploy = ArrayHelper::map($emp,'DEP_SUB_ID', function ($emp, $defaultValue) {
          return $emp['deptNm'] . '-' . $emp['EMP_NM'];
    });
    }

    /**
        *array parent
    **/
    public function get_aryParent()
    {
         $dep = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
        return ArrayHelper::map(Pilotproject::find()->where('PARENT = 0 AND STATUS<>1 AND TEMP_EVENT <> 0 AND TEMP_EVENT <>2')->andwhere(['DEP_ID'=>$dep])->all(),'ID','PILOT_NM');
    }

    /**
     * validasi ajax in page form_pilot
     * @author wawan
     * @since 1.1.0
     * @return mixed
     */
      public function actionValid()
      {
        # code...
        $post = Yii::$app->request->post();
        if($post['Pilotproject']['parentpilot'] == 1)
        {
          $model = new Pilotproject();
          $model->scenario = "parent";
        }else{
          $model = new Pilotproject();
          $model->scenario = "child";
        }

        if(Yii::$app->request->isAjax && $model->load($_POST))
        {
          Yii::$app->response->format = 'json';
          return ActiveForm::validate($model);
        }
      }


      public function actionModalRow(){

        return $this->renderAjax('tambah_row', [
            ]);
      }

      public function actionTambahRow($tgl){

         $dep_id = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
         $created = Yii::$app->getUserOpt->Profile_user()->emp->EMP_EMAIL;
         // $sql = Pilotproject::find()->where(['DEP_ID'=>$dep_id])->max('SORT');

         // $max = Pilotproject::find()->orderBy(['ID' => SORT_DESC])->max('ID');

         // if(count($sql) == 0){
         //    $sort = 0;
         //    $parent = 0;
         // }else{
         //    $sort = $sql;
         //    $parent = $sql;
         // }                              

         //  $connection = Yii::$app->db_widget;

         //    $connection->createCommand()->insert('sc0001', [
         //                  'PARENT' => $parent,
         //                  'DEP_ID' => $dep_id,
         //                  'CREATED_BY'=>Yii::$app->getUserOpt->Profile_user()->emp->EMP_EMAIL,
         //                  'TEMP_EVENT'=>2
         //              ])->execute();


         //     return $this->redirect('index');

         $model = new Pilotproject();

         $model->PARENT = 0;
         $model->DEP_ID = $dep_id;
         $model->CREATED_BY = $created;
         $model->TEMP_EVENT = 2;
		 //$model->PILOT_NM = 'New Event';
		 //$model->PLAN_DATE1 = Yii::$app->formatter->asDatetime($tgl, 'php:Y-m-d H:i:s');
         //$model->PLAN_DATE2 = Yii::$app->formatter->asDatetime($tgl, 'php:Y-m-d H:i:s');
         $model->save();

         $update_model = self::findModel($model->ID);
         $update_model->SORT = $model->ID;
         $update_model->save();

           $sql ="SELECT ID as id,PILOT_NM as title ,DEP_ID as dep_id,CREATED_BY as createby
                FROM sc0001 where ID ='".$model->ID."'";

                $test = Yii::$app->db_widget->createCommand($sql)->queryOne();

         echo json_encode($test);

          // return $this->redirect('index');


      }

       /**
     * validasi ajax in page form_pilot
     * @author wawan
     * @since 1.1.0
     * @return mixed
     */
      public function actionValidPilot()
      {
        # code...
        $post = Yii::$app->request->post();
        if($post['Pilotproject']['parentpilot'] == 1)
        {
          $model = new Pilotproject();
          $model->scenario = "parentrooms";
        }else{
          $model = new Pilotproject();
          $model->scenario = "childrooms";
        }

        if(Yii::$app->request->isAjax && $model->load($_POST))
        {
          Yii::$app->response->format = 'json';
          return ActiveForm::validate($model);
        }
      }

    /**
    * Creates a new Pilotproject model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
     public function actionCreateparent($tgl1,$tgl2)
    {
      
        $model = new Pilotproject();

        $post =Yii::$app->request->post();
        $val = $post['Pilotproject']['parentpilot'];
        $sendto = $post['Pilotproject']['Sendto'];

        $gv_id = Yii::$app->getUserOpt->Profile_user()->emp->GF_ID;
        
        if ($model->load(Yii::$app->request->post())){
            $model->DEP_ID =  Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
            // if($model->TYPE == 0)
            // {
            //   $model->DEP_ID = 'none';
            // }else{
            //   $model->DEP_ID =  Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
            // }
            
            if($val == 1)
            {
                $newdata = implode(",",$model->USER_CC);

                $model->USER_CC = $newdata;

                $newdata1 = implode(",",$model->DEP_SUB_ID);

                $model->DEP_SUB_ID = $newdata1;
                // $model->PLAN_DATE1 = $tgl1;
                // $model->PLAN_DATE2 = $tgl2;
                $pilot_id = Yii::$app->ambilkonci->getpilot($model->DEP_ID);
                $model->PILOT_ID = $pilot_id;

                $model->PARENT = 0;
                $sql = Pilotproject::find()->max('ID');                               
                $model->SORT = $sql+1;
            }else{
                $newdata = implode(",",$model->USER_CC);

                $model->USER_CC = $newdata;
                // $model->PLAN_DATE1 = $tgl1;
                // $model->PLAN_DATE2 = $tgl2;
                $model->SORT = $model->PARENT;
                $model->PILOT_ID = '';
            }
             $model->DESTINATION_TO =  $sendto; 
           
            $model->CREATED_BY= Yii::$app->user->identity->username;     
            $model->UPDATED_TIME = date('Y-m-d h:i:s');               

               $transaction = Pilotproject::getDb()->beginTransaction();
                    try {
                          $model->save();
                        // ...other DB operations...
                        $transaction->commit();
                    } catch(\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }      

            return $this->redirect('index');
                
        }else {
           
            return $this->renderAjax('form_pilot', [
                'model' => $model,
                'parent' => self::get_aryParent(),
                'dropemploy'=>self::get_aryEmploye(),
                'tgl'=>$tgl1,
                'tgl_1'=> $tgl2,
                'model1'=>$model1,
                'dep'=>self::get_aryDep_sub()
            ]);
        }   
    }



    // public function actionJsonCalendar()
    // {
    //     $dep_id = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
    //     $emp_id = Yii::$app->getUserOpt->Profile_user()->emp->EMP_ID;
    //     $sub_dep = Yii::$app->getUserOpt->Profile_user()->emp->DEP_SUB_ID;

    //     $calendar= new ArrayDataProvider([
    //         'allModels'=>Yii::$app->db_widget->createCommand("         
    //         SELECT  ID as id, SORT as sort,STATUS as status,PARENT as parent,PLAN_DATE1 as start,PLAN_DATE2 as end,PILOT_NM as title from sc0001 where DEP_SUB_ID LIKE'%".$sub_dep."%' OR CREATED_BY='".Yii::$app->user->identity->username."' OR DESTINATION_TO ='".$emp_id."' OR USER_CC LIKE'%".$emp_id."%'
    //         ")->queryAll()
    //     ]);
      
    //     //FIELD HARUS [id,start,end,title]        
    //     $eventCalendar=$calendar->allModels; 
    //     //print_r($eventCalendarPlan);
    //     //die();
    //     header('Content-type: application/json');       
    //     echo Json::encode($eventCalendar);
    //     Yii::$app->end();
    // }

    /**
     * Updates an existing Pilotproject model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdatePilot($id,$tgl_awal,$tgl_end,$sort)
    {
        $model = $this->findModel($id);

        $dep_id = $model->DEP_ID;
        // $emp_id = $model->DESTINATION_TO;

        // $dep_id = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;

        $emp_id = Yii::$app->getUserOpt->Profile_user()->emp->EMP_ID;

        $created = Yii::$app->user->identity->id;

        // $cari_atasan = self::findAtasan($emp_id,$dep_id);

         // $cari_atasan = self::findAtasan($dep_id,$emp_id);

        // $is_parent = self::findParentIs($sort);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->renderAjax('update_pilot', [
                'model' => $model,
                'cari_atasan'=>$cari_atasan,
                'created'=>$created,
                'is_parent'=>$is_parent,
                'sort'=>$sort
            ]);
        }
    }


    public function actionDropChild($id,$tgl1,$tgl2){

        $model = Pilotproject::findOne(['ID'=>$id]);

        $model->PLAN_DATE1 = $tgl1;
        $model->PLAN_DATE2 = $tgl2;

        $model->save();

    }


public function actionSaveEvent(){
     if (Yii::$app->request->isAjax) {
            $request= Yii::$app->request;
            $event=$request->post('event');
            $color=$request->post('color');

            $dep_id = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
            $created = Yii::$app->getUserOpt->Profile_user()->emp->EMP_EMAIL;
            // $sql = Pilotproject::find()->where(['DEP_ID'=>$dep_id])->max('SORT');

            // $max = Pilotproject::find()->max('ID');
            // if(count($sql) == 0){ 
            //   $parent = 0;
            //   $sort = $max;
            // }else{
            //   $parent = $sql;
            //   $sort = $sql;

            // } 

              $update_event = new PilotEvent();
              $update_event->COLOR = 1;
              $update_event->NM_EVENT = $event;
              $update_event->COLOR = $color;
              $update_event->DEP_ID = $dep_id;
              $update_event->CREATED_BY = $created;
              $update_event->CREATED_AT = date('Y-m-d h:i:s'); 
            
              $update_event->save();   

            // $model = new Pilotproject();
            // $model->DEP_ID = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
            // $model->CREATED_BY =  Yii::$app->getUserOpt->Profile_user()->emp->EMP_EMAIL;
            // // $pilot_id = Yii::$app->ambilkonci->getpilot($model->DEP_ID);
            // // $model->PILOT_ID = $pilot_id;   
            // $model->TEMP_EVENT = 0;  
            // $model->PARENT = 0;
            // $model->PILOT_NM = $event;
            // $model->COLOR = $color;
            // $model->save();


           $update_model = PilotEvent::find()->where(['ID'=>$update_event->ID]);
           $update_model->SORT = $model->ID;
           $update_model->save();

            return true;
        }

    }

  // send mail function
    public function Sendmail($id){

      $data_pilot = self::findModel($id);

       $contentMailAttach = '<div><h1>hello world<h1> </div>';

       $contentMailAttachBody = '<div> <h1>hello world<h1></div>';

       if(count($data_pilot->CREATED_BY) != 0 && count($data_pilot->USER_CC) != 0)
       {
          /* KIRIM ATTACH emaiL */
          $to=[$data_pilot->CREATED_BY,$data_pilot->USER_CC,$data_pilot->DESTINATION_TO];
        \Yii::$app->kirim_email->pdf($contentMailAttach,'Pilot Project',$to,'Pilot-Project',$contentMailAttachBody);
       }
        
    }


    public function actionCountEvent()
    {
        $dep_id = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
        $sql = Pilotproject::find()->where(['DEP_ID'=>$dep_id,'TEMP_EVENT'=>2])->count();
        echo json_encode($sql);
    }

    /**
     * Deletes an existing Pilotproject model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($ID,$PILOT_ID)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pilotproject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Pilotproject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID)
    {
        if (($model = Pilotproject::findOne(['ID'=>$ID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Pilotproject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Pilotproject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findDep($emp_id)
    {
        $emp = Employe::find()->where('EMP_ID LIKE "'.$emp_id.'" AND STATUS<>3 ')->one();

        return $emp->DEP_ID;

    }

     /**
     * Finds the Pilotproject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Pilotproject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findAtasan($emp_id,$dep_id)
    {

       $dep_id1 = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;


       if($dep_id1 == $dep_id )
       {

        $emp = Employe::find()->where('EMP_ID="'.$emp_id.'" AND DEP_ID="'.$dep_id.'" AND GF_ID<=4')->one();

        if(count($emp) != 0)
        {
            return 'Atasan';
        }else{
            return 'Bukan Atasan';
        }
      }else{
        return 'Bukan Atasan';
      }

    }

    /**
     * Finds the Pilotproject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Pilotproject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // protected function findParentIs($dep_id,$sort)
    // {
    //     $parent = Pilotproject::find()->where(['DEP_ID'=>$dep_id,'SORT'=>$sort])->one();

    //     if($parent->STATUS == 0)
    //     {
    //         return 'open';
    //     }else{
    //         return 'close';
    //     }

    // }

    protected function findParentIs($sort)
    {
        $parent = Pilotproject::find()->where(['SORT'=>$sort])->one();

        if($parent->STATUS == 0)
        {
            return 'open';
        }else{
            return 'close';
        }

    }
	
	
	public function actionTest(){
		
		return $this->render('test');
	}
	
	public function actionResources($id)
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		return [
			new Resource(["id" => "a", "title" => "Auditorium A"]),
			new Resource(["id" => "b", "title" => "Auditorium B", "eventColor" => "green"]),
			new Resource(["id" => "c", "title" => "Auditorium C", "eventColor" => "orange"]),
			new Resource([
				"id" => "d", "title" => "Auditorium D", "children" => [
					new Resource(["id" => "d1", "title" => "Room D1"]),
					new Resource(["id" => "d2", "title" => "Room D2"]),
				],
			]),
			new Resource(["id" => "e", "title" => "Auditorium E"]),
			new Resource(["id" => "f", "title" => "Auditorium F", "eventColor" => "red"]),
			new Resource(["id" => "g", "title" => "Auditorium G"]),
			new Resource(["id" => "h", "title" => "Auditorium H"]),
			new Resource(["id" => "i", "title" => "Auditorium I"]),
			new Resource(["id" => "j", "title" => "Auditorium J"]),
			new Resource(["id" => "k", "title" => "Auditorium K"]),
			new Resource(["id" => "l", "title" => "Auditorium L"]),
			new Resource(["id" => "m", "title" => "Auditorium M"]),
			new Resource(["id" => "n", "title" => "Auditorium N"]),
			new Resource(["id" => "o", "title" => "Auditorium O"]),
			new Resource(["id" => "p", "title" => "Auditorium P"]),
			new Resource(["id" => "q", "title" => "Auditorium Q"]),
			new Resource(["id" => "r", "title" => "Auditorium R"]),
			new Resource(["id" => "s", "title" => "Auditorium S"]),
			new Resource(["id" => "t", "title" => "Auditorium T"]),
			new Resource(["id" => "u", "title" => "Auditorium U"]),
			new Resource(["id" => "v", "title" => "Auditorium V"]),
			new Resource(["id" => "w", "title" => "Auditorium W"]),
			new Resource(["id" => "x", "title" => "Auditorium X"]),
			new Resource(["id" => "y", "title" => "Auditorium Y"]),
			new Resource(["id" => "z", "title" => "Auditorium Z"]),
		];
	}
	
	
	
	
	
	public function actionSetDataSelect($start,$end)
    {
		/* return $this->renderAjax('_formTest',[
			'start'=>$start,
			'end'=>$end
		]); */
		$model = new Pilotproject();

        $post =Yii::$app->request->post();
        $val = $post['Pilotproject']['parentpilot'];
        // $val_parent = $post['Pilotproject']['parent'];
        // $val_dest = $post['Pilotproject']['destination'];

        $gv_id = Yii::$app->getUserOpt->Profile_user()->emp->GF_ID;
        if ($model->load(Yii::$app->request->post())){

            if($val == 1){
                $dep_id = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
                $pilot_id = Yii::$app->ambilkonci->getpilot($dep_id);
                $model->PILOT_ID = $pilot_id;     
                $model->PARENT = 0;
                // $sql = Pilotproject::find()->max('ID');                               
                // $model->SORT = $sql+1;
            }else{
                $model->SORT = $model->PARENT;
                $model->PILOT_ID = '';
            }

            $model->DEP_ID = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
            $model->CREATED_BY =  Yii::$app->getUserOpt->Profile_user()->emp->EMP_EMAIL;
            // $model->DESTINATION_TO = $val_dest;
            // $model->PARENT = $val_parent;
            $model->save();


            if($val == 1)
            {
              $update_model = self::findModel($model->ID);

              $update_model->SORT = $model->ID;

              $update_model->save();
            }

        
        // if ($model->load(Yii::$app->request->post())){
        //     $model->DEP_ID =  Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
        //     // if($model->TYPE == 0)
        //     // {
        //     //   $model->DEP_ID = 'none';
        //     // }else{
        //     //   $model->DEP_ID =  Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
        //     // }


            
        //     if($val == 1)
        //     {
        //         $newdata = implode(",",$model->USER_CC);

        //         $model->USER_CC = $newdata;

        //         $newdata1 = implode(",",$model->DEP_SUB_ID);

        //         $model->DEP_SUB_ID = $newdata1;
        //         // $model->PLAN_DATE1 = $tgl1;
        //         // $model->PLAN_DATE2 = $tgl2;
        //         $pilot_id = Yii::$app->ambilkonci->getpilot($model->DEP_ID);
        //         $model->PILOT_ID = $pilot_id;     
        //         $model->PARENT = 0;
        //         $sql = Pilotproject::find()->max('ID');                               
        //         $model->SORT = $sql+1;
        //     }else{
        //         $newdata = implode(",",$model->USER_CC);

        //         $model->USER_CC = $newdata;
        //         // $model->PLAN_DATE1 = $tgl1;
        //         // $model->PLAN_DATE2 = $tgl2;
        //         $model->SORT = $model->PARENT;
        //         $model->PILOT_ID = '';
        //     }
           
        //     $model->CREATED_BY= Yii::$app->user->identity->username;     
        //     $model->UPDATED_TIME = date('Y-m-d h:i:s');               

        //        $transaction = Pilotproject::getDb()->beginTransaction();
        //             try {
        //                   $model->save();
        //                 // ...other DB operations...
        //                 $transaction->commit();
        //             } catch(\Exception $e) {
        //                 $transaction->rollBack();
        //                 throw $e;
        //             }      

            return $this->redirect('index');
                
        }else {
           
            return $this->renderAjax('form_pilot', [
                'model' => $model,
                'parent' => self::get_aryParent(),
                'dropemploy'=>self::get_aryEmploye(),
                'tgl'=>$start,
                'tgl_1'=> $end,
                'model1'=>$model1,
                'dep'=>self::get_aryDep_sub()
            ]);
        } 
	}
	
	public function actionChangeDataDrop($id,$start,$end){

		echo "ID=".$id." START=".$start." EBD=".$end;
        $model = Pilotproject::findOne(['ID'=>$id]);

        $model->PLAN_DATE1 = Yii::$app->formatter->asDatetime($start, 'php:Y-m-d H:i:s');
        $model->PLAN_DATE2 = Yii::$app->formatter->asDatetime($end, 'php:Y-m-d H:i:s');

       $model->save();

    }
		
	public function actionDragableReceive($start,$end,$title,$color){
		 $dep_id = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
		// $update_event = Pilotproject::find()->where(['PILOT_NM'=>$title,'TEMP_EVENT'=>0,'DEP_ID'=>$dep_id])->one();
    $update_event = new Pilotproject();
		$update_event->COLOR = $color;
    $update_event->PILOT_NM = $title;
    $update_event->PLAN_DATE1 =Yii::$app->formatter->asDatetime($start, 'php:Y-m-d H:i:s'); 
    $update_event->PLAN_DATE2 =Yii::$app->formatter->asDatetime($end, 'php:Y-m-d H:i:s');
    $update_event->DEP_ID = $dep_id;
    $update_event->save();

    $update_model = self::findModel($update_event->ID);
    $update_model->SORT = $update_event->ID;
    $update_model->save();


		// $update_event->PLAN_DATE1 = $start;
  //   $update_event->PLAN_DATE2 = $start;
		     
		
		$delete_event = Yii::$app->db_widget->createCommand('delete from sc0001 where TEMP_EVENT = 2 and DEP_ID="'.$dep_id.'" limit 1')->execute();
		
		
		// $model = new Pilotproject();

  //       $post =Yii::$app->request->post();
  //       $val = $post['Pilotproject']['parentpilot'];

  //       $gv_id = Yii::$app->getUserOpt->Profile_user()->emp->GF_ID;
        
  //       if ($model->load(Yii::$app->request->post())){
  //           $model->DEP_ID =  Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
  //           // if($model->TYPE == 0)
  //           // {
  //           //   $model->DEP_ID = 'none';
  //           // }else{
  //           //   $model->DEP_ID =  Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
  //           // }
            
  //           if($val == 1)
  //           {
  //               $newdata = implode(",",$model->USER_CC);

  //               $model->USER_CC = $newdata;

  //               $newdata1 = implode(",",$model->DEP_SUB_ID);

  //               $model->DEP_SUB_ID = $newdata1;
  //               // $model->PLAN_DATE1 = $tgl1;
  //               // $model->PLAN_DATE2 = $tgl2;
  //               $pilot_id = Yii::$app->ambilkonci->getpilot($model->DEP_ID);
  //               $model->PILOT_ID = $pilot_id;     
  //               $model->PARENT = 0;
  //               $sql = Pilotproject::find()->max('ID');                               
  //               $model->SORT = $sql+1;
  //           }else{
  //               $newdata = implode(",",$model->USER_CC);

  //               $model->USER_CC = $newdata;
  //               // $model->PLAN_DATE1 = $tgl1;
  //               // $model->PLAN_DATE2 = $tgl2;
  //               $model->SORT = $model->PARENT;
  //               $model->PILOT_ID = '';
  //           }
           
  //           $model->CREATED_BY= Yii::$app->user->identity->username;     
  //           $model->UPDATED_TIME = date('Y-m-d h:i:s');               

  //              $transaction = Pilotproject::getDb()->beginTransaction();
  //                   try {
  //                         $model->save();
  //                       // ...other DB operations...
  //                       $transaction->commit();
  //                   } catch(\Exception $e) {
  //                       $transaction->rollBack();
  //                       throw $e;
  //                   }      

  //           return $this->redirect('index');
                
  //       }else {
           
  //           return $this->renderAjax('form_pilot', [
  //               'model' => $model,
  //               'parent' => self::get_aryParent(),
  //               'dropemploy'=>self::get_aryEmploye(),
  //               'tgl'=>$start,
  //               'tgl_1'=> $end,
  //               'model1'=>$model1,
  //               'dep'=>self::get_aryDep_sub()
  //           ]);
  //       } 
    }
	
	public function actionDragableDrop($start,$end,$object){
		//id new increment
		echo " START=".$start." END=".$end," color=".$object;
        //$model = Pilotproject::findOne(['ID'=>$id]);

        //$model->PLAN_DATE1 = $start;
        //$model->PLAN_DATE2 = $end;

       // $model->save();

    }
	
	/**
	* FULLCALENDAR UPDATE EVENT/RESOURCE.
	* even change	: First loading
	* Status		: Fixed.
	* Issue			: akan berat jika data sudah banyak, herus get data from month/3month.
	* Locate : load.
	* @since 1.1
	* author wawan, update by piter novian [ptr.nov@gmail.com].
	*/
	public function actionRenderDataEvents($claster,$start,$end)
    {            
        $end_1 = strtotime($end);
        $dep_id1 = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
        $emp_email = Yii::$app->getUserOpt->Profile_user()->emp->EMP_EMAIL;
        $gf_id = Yii::$app->getUserOpt->Profile_user()->emp->GF_ID;
		
            if($gf_id <= 4)
            {
			   $sql = "select STATUS as status, COLOR as color, ID as resourceId, PLAN_DATE1 as start , PLAN_DATE2 as end, PILOT_NM as title from sc0001 where DEP_ID = '".$dep_id1."' and TEMP_EVENT <>0 and ((date(PLAN_DATE1)  BETWEEN '".$start."'  AND '".$end."') or (date(PLAN_DATE2)  BETWEEN '".$start."'  AND '".$end."'))";
			}else{
				$sql = "select STATUS as status, COLOR as color, ID as resourceId, PLAN_DATE1 as start , PLAN_DATE2 as end, PILOT_NM as title from sc0001 where DEP_ID = '".$emp_email."' and TEMP_EVENT <>0 and ((date(PLAN_DATE1)  BETWEEN '".$start."'  AND '".$end."') or (date(PLAN_DATE2)  BETWEEN '".$start."'  AND '".$end."'))";
            }
        $aryEvent =  Yii::$app->db_widget->createCommand($sql)->queryAll();	
		return Json::encode($aryEvent);
	}

  

	/**
	* FULLCALENDAR UPDATE EVENT/RESOURCE.
	* even change	: First loading
	* Status		: Fixed.
	* Issue			: akan berat jika data sudah banyak, herus get data from month/3month.
	* Locate : load.
	* @since 1.1
	* author wawan, update by piter novian [ptr.nov@gmail.com].
	*/
	public function actionRenderDataResources()
    {
         $dep_id1 = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
         $emp_email = Yii::$app->getUserOpt->Profile_user()->emp->EMP_EMAIL;
         $gf_id = Yii::$app->getUserOpt->Profile_user()->emp->GF_ID;
         if( $gf_id <= 4)
         {
           
            $sql ="SELECT b.ID as id, b.PILOT_NM as title ,a.PILOT_NM as srcparent ,b.DEP_ID as dep_id,b.CREATED_BY as createby
                FROM sc0001 AS a 
                INNER JOIN sc0001 AS b 
                WHERE a.ID=b.SORT and b.DEP_ID='".$dep_id1."'and b.TEMP_EVENT <>0 ORDER BY  a.PLAN_DATE1,b.TEMP_EVENT ASC";
        }else{
             
             $sql ="SELECT b.ID as id, b.PILOT_NM as title ,a.PILOT_NM as srcparent ,b.DEP_ID as dep_id,b.CREATED_BY as createby
                FROM sc0001 AS a 
                INNER JOIN sc0001 AS b 
                WHERE a.ID=b.SORT and b.DESTINATION_TO='".$emp_email."'and b.TEMP_EVENT <>0  ORDER BY  a.PLAN_DATE1,b.TEMP_EVENT ASC ";
        }
              
          
        $ary = Yii::$app->db_widget->createCommand($sql)->queryAll();		
		return Json::encode($ary);
	}
	
	/**
	* FULLCALENDAR UPDATE EVENT/RESOURCE.
	* even change	: go to date
	* Status		: Fixed.
	* ========== BACA ================
	* Template Day, digunakan untuk mengambil data daily dari tanggal, serult event/resource.
	* Locate : button rooms.
	* @since 1.1
	* author wawan, update by piter novian [ptr.nov@gmail.com].
	*/
	public function actionUpdateDataResources($start)
    {
         $dep_id1 = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
         $emp_email = Yii::$app->getUserOpt->Profile_user()->emp->EMP_EMAIL;
         $gf_id = Yii::$app->getUserOpt->Profile_user()->emp->GF_ID;
         if( $gf_id <= 4)
         {
           
            $sql ="SELECT b.ID as id, b.PILOT_NM as title ,a.PILOT_NM as srcparent ,b.DEP_ID as dep_id,b.CREATED_BY as createby
                FROM sc0001 AS a 
                INNER JOIN sc0001 AS b 
                WHERE a.ID=b.SORT and b.DEP_ID='".$dep_id1."'and b.TEMP_EVENT <>0 and ('".$start."' BETWEEN date(a.PLAN_DATE1) AND date(a.PLAN_DATE2)) ORDER BY a.PLAN_DATE1,b.TEMP_EVENT ASC";
        }else{
             
             $sql ="SELECT b.ID as id, b.PILOT_NM as title ,a.PILOT_NM as srcparent ,b.DEP_ID as dep_id,b.CREATED_BY as createby
                FROM sc0001 AS a 
                INNER JOIN sc0001 AS b 
                WHERE a.ID=b.SORT and b.DESTINATION_TO='".$emp_email."'and b.TEMP_EVENT <>0 and date(a.PLAN_DATE1)='".$start."' ORDER BY  a.PLAN_DATE1, b.TEMP_EVENT ASC ";
        }
              
          
        $ary = Yii::$app->db_widget->createCommand($sql)->queryAll();

		
		return Json::encode($ary);
	}	
	
	/**
	* Status : Dev test.
	*/
	public function actionRoomFormAjaxValidation(){
		$modelParentPilotProject = new Pilotproject();	
		$modelParentPilotProject->scenario = "parentrooms";	
		if(Yii::$app->request->isAjax){
			$modelParentPilotProject->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($modelParentPilotProject));
		}
	}
	
	/**
	* Button Rooms for Create Parent
	* Action Modal, BeforeSumbil form, cookie and refresh fullcalendar.
	* Status : Fixed.
	* ========== BACA ================
	* CREATE/UPDATE Parent Utama.
	* Locate : button rooms.
	* 1. Parent Utama tidak bisa diubah ke child, karena parent sudah atau akan ada pengkut/flowed child.
	* 2. Ditampilkan pada menu select untuk child sesuai tanggal (lebih kecil atau sama dengan) / tgllebih besar probidden.
	* 3. Parent Utama bisa untuk Public atau Private.
	* 4. Show day, akan ditampilkan semua detail sesuai date plan1 dan plan2 dari parent utama.
	* 5. Closing untuk actual harus lebih besar dari tgl plan1, dan bisa lebih besar atau lebih kecil dari tglplan2.
	* 6. PARENT_TREE: 0=child; 1=Parent Utama ; 2=Patent sub1; 2=Patent sub2, dst.
	* @since 1.1
	* author piter novian [ptr.nov@gmail.com].
	*/
	public function actionRoomForm(){
		$modelParentPilotProject = new Pilotproject();	
		$modelParentPilotProject->scenario = "parentrooms";	
		$rsltPost = Yii::$app->request->post();
		if ($modelParentPilotProject->load(Yii::$app->request->post())){
			if($modelParentPilotProject->validate()){
				$modelParentPilotProject->PARENT = 0;
				$modelParentPilotProject->PATENT_TREE=1;
				$modelParentPilotProject->ENABLE_ACTUAL=2;
				//$modelParentPilotProject->PLAN_DATE1 = Yii::$app->formatter->asDatetime($rsltPost['Pilotproject']['PLAN_DATE1'] .' 00:00:01', 'php:Y-m-d H:i:s');
				//$modelParentPilotProject->PLAN_DATE2 = Yii::$app->formatter->asDatetime($rsltPost['Pilotproject']['PLAN_DATE2'] .' 00:00:01', 'php:Y-m-d H:i:s');
				//$modelParentPilotProject->$rsltPost['Pilotproject']['DESTINATION_TO'];		
				$modelParentPilotProject->DEP_ID = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
				$modelParentPilotProject->CREATED_BY =  Yii::$app->getUserOpt->Profile_user()->emp->EMP_EMAIL;
				$modelParentPilotProject->CREATED_BY= Yii::$app->user->identity->username;		
				$modelParentPilotProject->UPDATED_TIME = date('Y-m-d h:i:s');   	
				$connection = Yii::$app->db_widget;
				$transaction = $connection->beginTransaction();
					try {
						$modelParentPilotProject->save();
							 $execute = Yii::$app->db_widget->createCommand()->update('sc0001',['SORT'=>$modelParentPilotProject->ID],'ID="'.$modelParentPilotProject->ID.'"')->execute(); 
							//.... other SQL executions
							$transaction->commit();
					} catch (\Exception $e) {
							$transaction->rollBack();
							throw $e;
					}
					
				//if ($modelParentPilotProject->save()) {
				$tanggalRetuen = Yii::$app->formatter->asDatetime($rsltPost['Pilotproject']['PLAN_DATE1'], 'php:Y-m-d');	
				setcookie('PilotprojectParent_cookie1',$tanggalRetuen);	
				//}	
			}
		}else{
			return $this->renderAjax('_formRooms', [
				'model' => $modelParentPilotProject,
				'data'=>self::get_aryParent(),
				'dropemploy'=>self::get_aryEmploye(),
			]);
		}
		return Json::encode('success');
	}
	/**
	* Status : Dev test.
	*/
	public function actionRoomFormModal(){
		$modelParentPilotProject = new Pilotproject();	
		return $this->renderAjax('_formRooms', [
			'model' => $modelParentPilotProject,
			'data'=>self::get_aryParent(),
			'dropemploy'=>self::get_aryEmploye(),
		]);
	
		
		
		/* if (!$parentPilotProject->load(Yii::$app->request->post())) {	
			return $this->renderAjax('_formRooms', [
				'model' => $parentPilotProject,
				'data'=>self::get_aryParent(),
				'dropemploy'=>self::get_aryEmploye(),
			]);
		}else{
			//if(Yii::$app->request->isAjax && $parentPilotProject->load($_POST)){
				//$parentPilotProject->load(Yii::$app->request->post());	
				//if(\yii\widgets\ActiveForm::validate($parentPilotProject)){
				//	return Json::encode(\yii\widgets\ActiveForm::validate($parentPilotProject));	
				//}else{
					//$rsltPost = \Yii::$app->request->post();
					// if ($rsltPost['sttsave']==true){
						//$parentPilotProject->saved();
						
					//};				
						//$tanggalRetuen = Yii::$app->formatter->asDatetime($rsltPost['PilotprojectParent']['pARENT_TGLPLAN1'], 'php:Y-m-d');
					//	setcookie('PilotprojectParent_cookie1',$tanggalRetuen);		
					//return Json::encode(['value'=>$tanggalRetuen]);
					//$parentPilotProject->load(Yii::$app->request->post());
					if ($parentPilotProject->auth_saved()){
							$rsltPost = \Yii::$app->request->post();
							$tanggalRetuen = Yii::$app->formatter->asDatetime($rsltPost['PilotprojectParent']['pARENT_TGLPLAN1'], 'php:Y-m-d');	
							setcookie('PilotprojectParent_cookie1',$tanggalRetuen);	
					}
					return Json::encode(['value'=>$tanggalRetuen]);
					//localStorage.clear();
					
				//}
			//}					
			
			
		}  */
	}
	
	
	
    /* public function actionRoomForm(){

         $model = new Pilotproject();
         $post =Yii::$app->request->post();
         $val = $post['Pilotproject']['parentpilot'];
         // $val_parent = $post['Pilotproject']['parent'];
         // $val_dest = $post['Pilotproject']['destination'];

        if ($model->load(Yii::$app->request->post())){

            if($val == 1){
                $dep_id = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
                $pilot_id = Yii::$app->ambilkonci->getpilot($dep_id);
                $model->PILOT_ID = $pilot_id;     
                $model->PARENT = 0;
                // $sql = Pilotproject::find()->max('ID');                               
                // $model->SORT = $sql+1;
            }else{
                $model->SORT = $model->PARENT;
                $model->PILOT_ID = '';
            }

            $model->DEP_ID = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
            $model->CREATED_BY =  Yii::$app->getUserOpt->Profile_user()->emp->EMP_EMAIL;
            // $model->DESTINATION_TO = $val_dest;
            // $model->PARENT = $val_parent;
            $model->save();


            if($val == 1)
            {
              $update_model = self::findModel($model->ID);

              $update_model->SORT = $model->ID;

              $update_model->save();
            }

             return $this->redirect('index');
           
        }else{
          return $this->renderAjax('_formRooms', [
               'model'=>$model,
               'data'=>self::get_aryParent(),
               'dropemploy'=>self::get_aryEmploye(),
            ]);
        }

    } */


    public function actionJsonevent(){

      $dep = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;

     $sql = 'select COLOR as color, NM_EVENT as title,ID as id from sc0001a where DEP_ID="'.$dep.'"';

      $data = Yii::$app->db_widget->createCommand($sql)->queryAll();

        echo json_encode($data);

    }


	public function actionSendCalTest(){
		$from_name = "postman";        
		$from_address = "postman@lukison.com";        
		$to_name = "piter";        
		$to_address = "piter@lukison.com";        
		$startTime = "11/10/2016 18:00:00";        
		$endTime = "11/10/2016 19:00:00";        
		$subject = "Meeting";        
		$description = "Tese calendar Event";        
		$location = "HO Lukison ";

		Yii::$app->emailevent->sendIcalEvent(
			$from_name, 
			$from_address, 
			$to_name, 
			$to_address, 
			$startTime, 
			$endTime, 
			$subject, 
			$description, 
			$location
		);
	}
	
  
	
	// public function actionRoomForm(){

	// 	 if ($model->load(Yii::$app->request->post())){
 //            $model->DEP_ID =  Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;                 
 //            $model->CREATED_BY= Yii::$app->user->identity->username;     
 //            $model->UPDATED_TIME = date('Y-m-d h:i:s');               

 //               $transaction = Pilotproject::getDb()->beginTransaction();
 //                    try {
 //                          $model->save();
 //                        // ...other DB operations...
 //                        $transaction->commit();
 //                    } catch(\Exception $e) {
 //                        $transaction->rollBack();
 //                        throw $e;
 //                    }      

 //            return $this->redirect('index');
                
 //        }else { 
	// 		$model = new \yii\base\DynamicModel(['klikparent','srcparent']);
	// 		$model->addRule(['klikparent','srcparent'], 'safe');
	// 		if(Yii::$app->request->isAjax && $model->load($_POST)){
	// 		  Yii::$app->response->format = 'json';
	// 		  return ActiveForm::validate($model);
	// 		}else{
	// 			if ($model->load(Yii::$app->request->post())) {
	// 				$hsl = Yii::$app->request->post();
	// 				$tgl = $hsl['DynamicModel']['srcparent'];
	// 				return $this->redirect(['index', 'tgl'=>$tgl]);
	// 			}else{			
	// 				return $this->renderAjax('_formRooms', [
	// 				'model'=>$model,
	// 				]);
	// 			}
	// 		}
                  
		//} # code...
        /* $post = Yii::$app->request->post();
        if($post['Pilotproject']['parentpilot'] == 1)
        {
          $model = new Pilotproject();
          $model->scenario = "parent";
        }else{
          $model = new Pilotproject();
          $model->scenario = "child";
        }

        if(Yii::$app->request->isAjax && $model->load($_POST))
        {
          Yii::$app->response->format = 'json';
          return ActiveForm::validate($model);
        } */
    // }
	
	/**
	* Status : Dev test. wawan
	*/
	public function actionTestDataEvents()
    {
		$aryEvent=[
			["id"=>"135","title"=>"jadi dah sync","srcparent"=>"wawkakak","dep_id"=>"IT","createby"=>"none"],
			["id"=>"139","title"=>"wawan","srcparent"=>"wwww","dep_id"=>"IT","createby"=>"none"],
			["id"=>"142","title"=>"radumta","srcparent"=>"test1asdasd","dep_id"=>"IT","createby"=>"none"],
			["id"=>"202","title"=>"test1","srcparent"=>"asdasd","dep_id"=>"IT","createby"=>"none"],
			["id"=>"204","title"=>"test2","srcparent"=>"dasd","dep_id"=>"IT","createby"=>"none"],
			["id"=>"206","title"=>"sip","srcparent"=>"asdsadasds","dep_id"=>"IT","createby"=>"none"]		
		];
		
		//return $aryEvent;
		return  json_encode($aryEvent);
	}
	
	
	
	/**
	* Status : Dev test. ptr.nov
	*/
	public function actionChartGrantPilotproject(){	
		$dataParenCustomer= new ArrayDataProvider([
			'key' => 'CUST_KD',
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('ParentChildCountCustomer')")->queryAll(),
			'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
				return $db_esm->createCommand("
					SELECT x1.label,x1.value
					FROM
						(SELECT #x1.CUST_KD,x1.CUST_GRP,
								 x1.CUST_NM as label,
								(SELECT COUNT(x2.CUST_KD) FROM c0001 x2 WHERE x2.CUST_GRP=x1.CUST_KD LIMIT 1 ) as value
						FROM c0001 x1
						WHERE x1.CUST_KD=x1.CUST_GRP) x1 
					ORDER BY x1.value DESC;
				")->queryAll();
			}, 60),
			'pagination' => [
				'pageSize' => 200,
			]
		]);		
		//return  json_encode($dataParenCustomer->getModels());
		return $dataParenCustomer->getModels();
	}
	
	
	
	
	/**
	* FUSIONCHAT GANTT PLAN ACTUAL 
	* Status : Fixed, Dept.
	* ========== BACA ================
	* UPDATE
	* Locate : Tab View Pilot Project.
	* 1. update Source : chart,categories
	* @since 1.1
	* author piter novian [ptr.nov@gmail.com].
	*/
	public function actionChartGanttPlanActual(){
		//***kategory Month
		$monthCtg= new ActiveDataProvider([
            'query' => Cnfmonth::find()->asArray(),
			'pagination' => [
					'pageSize' => 24,
				],			 
        ]);
		$a= ArrayHelper::toArray($monthCtg->getModels());
		$monthCategory=Json::encode($a);

		//***kategory Week
		$weekCtg= new ActiveDataProvider([
            'query' => Cnfweek::find(),
			'pagination' => [
					'pageSize' => 200,
			],			 
        ]);	
		$weekCategory=Json::encode($weekCtg->getModels());
		
		//***get Data Pilotproject
		$_modalPilot= new ActiveDataProvider([
			'query' => Pilotproject::find()->Where(['CREATED_BY'=>Yii::$app->user->identity->username]),
			'pagination' => [
					'pageSize' => 200,
				],				 
		]);
		
		//***Task
		foreach($_modalPilot->getModels() as $row => $value){
			$taskCtg[]=[
				'label'=>$value['PILOT_NM'],
				'id'=>strval($value['ID']),
			];					
			$taskPIC[]=[
				'label'=>$value['CREATED_BY'],
			];	
			$task[]=[
				"label"=> "Planned",
				"processid"=> strval($value['ID']),
				"start"=> Yii::$app->formatter->asDatetime($value['PLAN_DATE1'], 'php:d/m/Y'),
				"end"=> Yii::$app->formatter->asDatetime($value['PLAN_DATE2'], 'php:d/m/Y'),
				"id"=> strval($value['ID'])."-1",
				"color"=> "#008ee4",
				"height"=> "32%",
				"toppadding"=> "12%"
			];
		};	 
		
		$cntTask=sizeof($taskCtg);
		$maxRow=$cntTask<=26?(26-$cntTask):$cntTask;
		/* if($cntTask==0){
			$maxRow=29;
		}elseif($cntTask<=29){
			$maxRow=29-$cntTask;
		}else{
			$maxRow=$cntTask;
		} */
		
		for ($x = 0; $x <= $maxRow; $x++) {
			$taskCtgKosong[]=[
				'label'=>'',
				'id'=>''
			];	 
		}		 
		$mrgTaskCtg=ArrayHelper::merge($taskCtg,$taskCtgKosong);
		
		for ($x = 0; $x <= $maxRow; $x++) {
			$taskPICKosong[]=[
				'label'=>''
			];	 
		}
		$mrgtaskPIC=ArrayHelper::merge($taskPIC,$taskPICKosong);
		
		$rslt='{
			"chart": {
				"subcaption": "Pilot Project Planned vs Actual",                
				"dateformat": "dd/mm/yyyy",
				"outputdateformat": "ddds mns yy",
				"ganttwidthpercent": "70",
				"ganttPaneDuration": "50",
				"ganttPaneDurationUnit": "d",
				"flatScrollBars": "0",				
				"fontsize": "14",				
				"plottooltext": "$processName{br} $label starting date $start{br}$label ending date $end",
				"theme": "fint"
			},
			"categories": [							
				{
					"bgcolor": "#33bdda",
					"align": "middle",
					"fontcolor": "#ffffff",						
					"fontsize": "12",
					"category": '.$monthCategory.'
				},
				{
					"bgcolor": "#ffffff",
					"fontcolor": "#1288dd",
					"fontsize": "11",
					"isbold": "1",
					"align": "center",
					"category": '.$weekCategory.'
				}
			],
			"processes": {
				"headertext": "Pilot Task",
				"fontcolor": "#000000",
				"fontsize": "10",
				"isanimated": "0",
				"bgcolor": "#6baa01",
				"headervalign": "middle",
				"headeralign": "center",
				"headerbgcolor": "#6baa01",
				"headerfontcolor": "#ffffff",
				"headerfontsize": "12",
				"width":"200",
				"align": "left",
				"isbold": "1",
				"bgalpha": "25",
				"process": '.Json::encode($mrgTaskCtg).'
			},
			"datatable": {
                "headervalign": "bottom",
                "datacolumn": [
                    {
                        "headertext": "PIC",
                        "fontcolor": "#000000",
						"fontsize": "10",
						"isanimated": "0",
						"bgcolor": "#6baa01",
						"headervalign": "middle",
						"headeralign": "center",
						"headerbgcolor": "#6baa01",
						"headerfontcolor": "#ffffff",
						"headerfontsize": "12",
						"width":"150",
						"align": "left",
						"isbold": "1",
						"bgalpha": "25",				
                        "text": '.Json::encode($mrgtaskPIC).'
                    }
                ]
            },
			"tasks": {
				"task":'.Json::encode($task).'
			}
			
		}';
		
		return $rslt;
		
	}
	
	/**
	* Status : Dev test. ptr.nov
	*/
	public function actionChartTest1(){
		
	 $chartGrantData='{
		"chart": {
                "subcaption": "Pilot Project Planned vs Actual",                
                "dateformat": "dd/mm/yyyy",
                "outputdateformat": "ddds mns yy",
                "ganttwidthpercent": "70",
                "ganttPaneDuration": "50",
                "ganttPaneDurationUnit": "d",	
				"height":"500%",
				"fontsize": "14",				
                "plottooltext": "$processName{br} $label starting date $start{br}$label ending date $end",
                "theme": "fint"
            },
		"categories": [
			{
				"bgcolor": "#33bdda",
				"category": [
					{
						"start": "1/4/2014",
						"end": "30/6/2014",
						"label": "Months",
						"align": "middle",
						"fontcolor": "#ffffff",
						"fontsize": "14"
					}
				]
			},
			{
				"bgcolor": "#33bdda",
				"align": "middle",
				"fontcolor": "#ffffff",
				"fontsize": "12",
				"category": [
					{
						"start": "1/4/2014",
						"end": "30/4/2014",
						"label": "April"
					},
					{
						"start": "1/5/2014",
						"end": "31/5/2014",
						"label": "May"
					},
					{
						"start": "1/6/2014",
						"end": "30/6/2014",
						"label": "June"
					}
				]
			},
			{
				"bgcolor": "#ffffff",
				"fontcolor": "#1288dd",
				"fontsize": "10",
				"isbold": "1",
				"align": "center",
				"category": [
					{
						"start": "1/4/2014",
						"end": "5/4/2014",
						"label": "Week 1"
					},
					{
						"start": "6/4/2014",
						"end": "12/4/2014",
						"label": "Week 2"
					},
					{
						"start": "13/4/2014",
						"end": "19/4/2014",
						"label": "Week 3"
					},
					{
						"start": "20/4/2014",
						"end": "26/4/2014",
						"label": "Week 4"
					},
					{
						"start": "27/4/2014",
						"end": "3/5/2014",
						"label": "Week 5"
					},
					{
						"start": "4/5/2014",
						"end": "10/5/2014",
						"label": "Week 6"
					},
					{
						"start": "11/5/2014",
						"end": "17/5/2014",
						"label": "Week 7"
					},
					{
						"start": "18/5/2014",
						"end": "24/5/2014",
						"label": "Week 8"
					},
					{
						"start": "25/5/2014",
						"end": "31/5/2014",
						"label": "Week 9"
					},
					{
						"start": "1/6/2014",
						"end": "7/6/2014",
						"label": "Week 10"
					},
					{
						"start": "8/6/2014",
						"end": "14/6/2014",
						"label": "Week 11"
					},
					{
						"start": "15/6/2014",
						"end": "21/6/2014",
						"label": "Week 12"
					},
					{
						"start": "22/6/2014",
						"end": "28/6/2014",
						"label": "Week 13"
					}
				]
			}
		],
		"datatable": {
                "headervalign": "bottom",
                "datacolumn": [
                    {
                        "headertext": "PIC",
                        "fontcolor": "#000000",
						"fontsize": "10",
						"isanimated": "1",
						"bgcolor": "#6baa01",
						"headervalign": "middle",
						"headeralign": "center",
						"headerbgcolor": "#6baa01",
						"headerfontcolor": "#ffffff",
						"headerfontsize": "16",
						"width":"150",
						"align": "left",
						"isbold": "1",
						"bgalpha": "25",				
                        "text": [
                            {
                                "label": " "
                            },
                            {
                                "label": "John"
                            },
                            {
                                "label": "David"
                            },
                            {
                                "label": "Mary"
                            },
                            {
                                "label": "John"
                            },
                            {
                                "label": "Andrew & Harry"
                            },                            
                            {
                                "label": "John & Harry"
                            },
                            {
                                "label": " "
                            },
                            {
                                "label": "Neil & Harry"
                            },
                            {
                                "label": "Neil & Harry"
                            },
                            {
                                "label": "Chris"
                            },
                            {
                                "label": "John & Richard"
                            }
                        ]
                    }
                ]
            },
		"processes": {
			"headertext": "Pilot Task",
			"fontsize": "12",
			"fontcolor": "#000000",
			"fontsize": "10",
			"isanimated": "1",
			"bgcolor": "#6baa01",
			"headervalign": "middle",
			"headeralign": "center",
			"headerbgcolor": "#6baa01",
			"headerfontcolor": "#ffffff",
			"headerfontsize": "16",
			"width":"200",
			"align": "left",
			"isbold": "1",
			"bgalpha": "25",
			"process": [
				{
					"label": "Clear site",
					"id": "1"
				},
				{
					"label": "Excavate Foundation",
					"id": "2",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Concrete Foundation",
					"id": "3",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Footing to DPC",
					"id": "4",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Drainage Services",
					"id": "5",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Backfill",
					"id": "6",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Ground Floor",
					"id": "7"
				},
				{
					"label": "Walls on First Floor",
					"id": "8"
				},
				{
					"label": "First Floor Carcass",
					"id": "9",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "First Floor Deck",
					"id": "10",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Roof Structure",
					"id": "11"
				},
				{
					"label": "Roof Covering",
					"id": "12"
				},
				{
					"label": "Rainwater Gear",
					"id": "13"
				},
				{
					"label": "Windows",
					"id": "14"
				},
				{
					"label": "External Doors",
					"id": "15"
				},
				{
					"label": "Connect Electricity",
					"id": "16"
				},
				{
					"label": "Connect Water Supply",
					"id": "17",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Install Air Conditioning",
					"id": "18",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Interior Decoration",
					"id": "19",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Fencing And signs",
					"id": "20"
				},
				{
					"label": "Exterior Decoration",
					"id": "21",
					"hoverbandcolor": "#e44a00",
					"hoverbandalpha": "40"
				},
				{
					"label": "Setup racks",
					"id": "22"
				}
			]
		},		
		"tasks": {
			"task": [
				{
					"label": "Planned",
					"processid": "1",
					"start": "9/4/2014",
					"end": "12/4/2014",
					"id": "1-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "1",
					"start": "9/4/2014",
					"end": "12/4/2014",
					"id": "1",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "2",
					"start": "13/4/2014",
					"end": "23/4/2014",
					"id": "2-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "2",
					"start": "13/4/2014",
					"end": "25/4/2014",
					"id": "2",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Delay",
					"processid": "2",
					"start": "23/4/2014",
					"end": "25/4/2014",
					"id": "2-2",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 2 days."
				},
				{
					"label": "Planned",
					"processid": "3",
					"start": "23/4/2014",
					"end": "30/4/2014",
					"id": "3-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "3",
					"start": "26/4/2014",
					"end": "4/5/2014",
					"id": "3",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Delay",
					"processid": "3",
					"start": "3/5/2014",
					"end": "4/5/2014",
					"id": "3-2",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 1 days."
				},
				{
					"label": "Planned",
					"processid": "4",
					"start": "3/5/2014",
					"end": "10/5/2014",
					"id": "4-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "4",
					"start": "4/5/2014",
					"end": "10/5/2014",
					"id": "4",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "5",
					"start": "6/5/2014",
					"end": "11/5/2014",
					"id": "5-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "5",
					"start": "6/5/2014",
					"end": "10/5/2014",
					"id": "5",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "6",
					"start": "4/5/2014",
					"end": "7/5/2014",
					"id": "6-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "6",
					"start": "5/5/2014",
					"end": "11/5/2014",
					"id": "6",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Delay",
					"processid": "6",
					"start": "7/5/2014",
					"end": "11/5/2014",
					"id": "6-2",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 4 days."
				},
				{
					"label": "Planned",
					"processid": "7",
					"start": "11/5/2014",
					"end": "14/5/2014",
					"id": "7-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "7",
					"start": "11/5/2014",
					"end": "14/5/2014",
					"id": "7",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "8",
					"start": "16/5/2014",
					"end": "19/5/2014",
					"id": "8-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "8",
					"start": "16/5/2014",
					"end": "19/5/2014",
					"id": "8",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "9",
					"start": "16/5/2014",
					"end": "18/5/2014",
					"id": "9-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "9",
					"start": "16/5/2014",
					"end": "21/5/2014",
					"id": "9",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Delay",
					"processid": "9",
					"start": "18/5/2014",
					"end": "21/5/2014",
					"id": "9-2",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 3 days."
				},
				{
					"label": "Planned",
					"processid": "10",
					"start": "20/5/2014",
					"end": "23/5/2014",
					"id": "10-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "10",
					"start": "21/5/2014",
					"end": "24/5/2014",
					"id": "10",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Delay",
					"processid": "10",
					"start": "23/5/2014",
					"end": "24/5/2014",
					"id": "10-2",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 1 days."
				},
				{
					"label": "Planned",
					"processid": "11",
					"start": "25/5/2014",
					"end": "27/5/2014",
					"id": "11-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "11",
					"start": "25/5/2014",
					"end": "27/5/2014",
					"id": "11",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "12",
					"start": "28/5/2014",
					"end": "1/6/2014",
					"id": "12-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "12",
					"start": "28/5/2014",
					"end": "1/6/2014",
					"id": "12",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "13",
					"start": "4/6/2014",
					"end": "6/6/2014",
					"id": "13-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "13",
					"start": "4/6/2014",
					"end": "6/6/2014",
					"id": "13",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "14",
					"start": "4/6/2014",
					"end": "4/6/2014",
					"id": "14-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "14",
					"start": "4/6/2014",
					"end": "4/6/2014",
					"id": "14",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "15",
					"start": "4/6/2014",
					"end": "4/6/2014",
					"id": "15-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "15",
					"start": "4/6/2014",
					"end": "4/6/2014",
					"id": "15",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "16",
					"start": "2/6/2014",
					"end": "7/6/2014",
					"id": "16-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "16",
					"start": "2/6/2014",
					"end": "7/6/2014",
					"id": "16",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "17",
					"start": "5/6/2014",
					"end": "10/6/2014",
					"id": "17-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "17",
					"start": "5/6/2014",
					"end": "17/6/2014",
					"id": "17",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Delay",
					"processid": "17",
					"start": "10/6/2014",
					"end": "17/6/2014",
					"id": "17-2",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 7 days."
				},
				{
					"label": "Planned",
					"processid": "18",
					"start": "10/6/2014",
					"end": "12/6/2014",
					"id": "18-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Delay",
					"processid": "18",
					"start": "18/6/2014",
					"end": "20/6/2014",
					"id": "18",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 8 days."
				},
				{
					"label": "Planned",
					"processid": "19",
					"start": "15/6/2014",
					"end": "23/6/2014",
					"id": "19-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "19",
					"start": "16/6/2014",
					"end": "23/6/2014",
					"id": "19",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "20",
					"start": "23/6/2014",
					"end": "23/6/2014",
					"id": "20-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "20",
					"start": "23/6/2014",
					"end": "23/6/2014",
					"id": "20",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Planned",
					"processid": "21",
					"start": "18/6/2014",
					"end": "21/6/2014",
					"id": "21-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "21",
					"start": "18/6/2014",
					"end": "23/6/2014",
					"id": "21",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				},
				{
					"label": "Delay",
					"processid": "21",
					"start": "21/6/2014",
					"end": "23/6/2014",
					"id": "21-2",
					"color": "#e44a00",
					"toppadding": "56%",
					"height": "32%",
					"tooltext": "Delayed by 2 days."
				},
				{
					"label": "Planned",
					"processid": "22",
					"start": "24/6/2014",
					"end": "28/6/2014",
					"id": "22-1",
					"color": "#008ee4",
					"height": "32%",
					"toppadding": "12%"
				},
				{
					"label": "Actual",
					"processid": "22",
					"start": "25/6/2014",
					"end": "28/6/2014",
					"id": "22",
					"color": "#6baa01",
					"toppadding": "56%",
					"height": "32%"
				}
			]
		},
		"connectors": [
			{
				"connector": [
					{
						"fromtaskid": "1",
						"totaskid": "2",
						"color": "#008ee4",
						"thickness": "2",
						"fromtaskconnectstart_": "1"
					},
					{
						"fromtaskid": "2-2",
						"totaskid": "3",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "3-2",
						"totaskid": "4",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "3-2",
						"totaskid": "6",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "7",
						"totaskid": "8",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "7",
						"totaskid": "9",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "12",
						"totaskid": "16",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "12",
						"totaskid": "17",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "17-2",
						"totaskid": "18",
						"color": "#008ee4",
						"thickness": "2"
					},
					{
						"fromtaskid": "19",
						"totaskid": "22",
						"color": "#008ee4",
						"thickness": "2"
					}
				]
			}
		],
		"milestones": {
			"milestone": [
				{
					"date": "2/6/2014",
					"taskid": "12",
					"color": "#f8bd19",
					"shape": "star",
					"tooltext": "Completion of Phase 1"
				}
			]
		},
		"legend": {
			"item": [
				{
					"label": "Planned",
					"color": "#008ee4"
				},
				{
					"label": "Actual",
					"color": "#6baa01"
				},
				{
					"label": "Slack (Delay)",
					"color": "#e44a00"
				}
			]
		}
	 }';
		return $chartGrantData;
		
	}

	/**
	* Status : Dev test.  ptr.nov
	*/
	public function actionChartTest(){	
		$dataParenCustomer1= new ArrayDataProvider([
			'key' => 'CUST_KD',
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('ParentChildCountCustomer')")->queryAll(),
			'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
				return $db_esm->createCommand("
					SELECT x1.label,x1.value
					FROM
						(SELECT #x1.CUST_KD,x1.CUST_GRP,
								 x1.CUST_NM as label,
								(SELECT COUNT(x2.CUST_KD) FROM c0001 x2 WHERE x2.CUST_GRP=x1.CUST_KD LIMIT 1 ) as value
						FROM c0001 x1
						WHERE x1.CUST_KD=x1.CUST_GRP) x1 
					ORDER BY x1.value DESC;
				")->queryAll();
			}, 60),
			'pagination' => [
				'pageSize' => 200,
			]
		]);		
			$chartdata='{
				"chart": {
				 "caption":"Summary Customers Category Detail",
				 "xAxisName":"Category Name",
				 "yAxisName":"Count ",
				 "theme":"fint",
				 "is2D":"0",
				 "showValues":"1",
				 "palettecolors":"#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",
				 "bgColor":"#ffffff",
				 "showBorder":"0",
				 "showCanvasBorder":"0"
				} , 
				"data": '.json_encode($dataParenCustomer1->getModels()).'	
			}';
		
		
		//return  json_encode($dataParenCustomer1->getModels());
		return $chartdata;
	}
}
