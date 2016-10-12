<?php

namespace lukisongroup\widget\controllers;

use Yii;
use lukisongroup\widget\models\Pilotproject;
use lukisongroup\widget\models\PilotEvent;
use lukisongroup\hrd\models\Employe;
use lukisongroup\esm\models\Kategoricus;
use lukisongroup\widget\models\PilotprojectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;
use yii\filters\ContentNegotiator;

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

      public function actionTambahRow(){

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
	
	public function actionRenderDataEvents($start,$end)
    {
            
        $end_1 = strtotime($end);
        $dep_id1 = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
         $emp_email = Yii::$app->getUserOpt->Profile_user()->emp->EMP_EMAIL;
         $gf_id = Yii::$app->getUserOpt->Profile_user()->emp->GF_ID;

            if($gf_id <= 4)
            {
                $sql = "select STATUS as status, COLOR as color, ID as resourceId, PLAN_DATE1 as start , PLAN_DATE2 as end, PILOT_NM as title from sc0001 where DEP_ID = '".$dep_id1."' and TEMP_EVENT <>0 and PLAN_DATE1 != 'null'";

                // $sql = "select ID as resourceId, PLAN_DATE1 as start , PLAN_DATE2 as end, PILOT_NM as title from sc0001 where DEP_ID = '".$dep_id1."' and UNIX_TIMESTAMP(PLAN_DATE2) ='".$end_1."'";
            }else{
                $sql = "select STATUS as status, COLOR as color, ID as resourceId, PLAN_DATE1 as start , PLAN_DATE2 as end, PILOT_NM as title from sc0001 where DESTINATION_TO = '".$emp_email."'and TEMP_EVENT <>0 and PLAN_DATE1 != 'null'";

            }
      // $aryEvent = Pilotproject::find()->orderBy('SORT')->all();

        

        $aryEvent =  Yii::$app->db_widget->createCommand($sql)->queryAll();
		// $aryEvent=[
		// 		['id' => '1', 'resourceId' => 'b', 'start' => '2016-05-07T02:00:00', 'end' => '2016-05-07T07:00:00', 'title' => 'event 1'],
		// 		['id' => '2', 'resourceId' => 'c', 'start' => '2016-05-07T05:00:00', 'end' => '2016-05-07T22:00:00', 'title' => 'event 2'],
		// 		['id' => '3', 'resourceId' => 'd', 'start' => '2016-05-06', 'end' => '2016-05-08', 'title' => 'event 3'],
		// 		['id' => '4', 'resourceId' => 'e', 'start' => '2016-05-07T03:00:00', 'end' => '2016-05-07T08:00:00', 'title' => 'event 4'],
		// 		['id' => '5', 'resourceId' => 'f', 'start' => '2016-05-07T00:30:00', 'end' => '2016-05-07T02:30:00', 'title' => 'event 5'],
		// ];
		
		return Json::encode($aryEvent);
	}

  

	public function actionGroupDataResources()
    {
		return 'Discriptions';
		return 'Discriptions';
	}
	
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
                WHERE a.ID=b.SORT and b.DEP_ID='".$dep_id1."'and b.TEMP_EVENT <>0 ORDER BY b.TEMP_EVENT ASC";
        }else{
             
             $sql ="SELECT b.ID as id, b.PILOT_NM as title ,a.PILOT_NM as srcparent ,b.DEP_ID as dep_id,b.CREATED_BY as createby
                FROM sc0001 AS a 
                INNER JOIN sc0001 AS b 
                WHERE a.ID=b.SORT and b.DESTINATION_TO='".$emp_email."'and b.TEMP_EVENT <>0 ORDER BY b.TEMP_EVENT ASC ";
        }
              
          
        $ary = Yii::$app->db_widget->createCommand($sql)->queryAll();

		
		return Json::encode($ary);
	}

    public function actionRoomForm(){

        $model = new Pilotproject();
         $post =Yii::$app->request->post();
         $val = $post['Pilotproject']['parentpilot'];

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

    }


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
	
	
	
	
	
	
	
	
	
}
