<?php

namespace lukisongroup\master\controllers;

use Yii;
use lukisongroup\master\models\DraftPlan;
use lukisongroup\master\models\DraftPlanSearch;
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\DraftGeo;
use lukisongroup\master\models\DayName;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
Use ptrnov\ salesforce\Jadwal;
use lukisongroup\master\models\DraftPlanGroup;
use lukisongroup\master\models\DraftPlanDetailSearch;


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

    public function actionSendDraft()
    {   
         /*model draftplan*/
        $data_draft = DraftPlan::find()->all();
        $dynamick =  new DraftPlan();

         /*converting obejct to array*/
        $data = ArrayHelper::toArray($data_draft, [
        'lukisongroup\master\models\DraftPlan' => [
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

 // $dua= DraftPlan::getDateVal();
 

            # code...
        // $cus = DraftPlan::find()->asArray()->all();

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
        $aryStt= [
          ['STATUS' => 0, 'STT_NM' => 'DISABLE'],
          ['STATUS' => 1, 'STT_NM' => 'ENABLE'],
        ];

        $valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');

		/*PLAN DRAFT*/
        $searchModel = new DraftPlanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		/*PLAN MAINTAIN*/
		$searchModelMaintain = new DraftPlanDetailSearch();
        $dataProviderMaintain = $searchModelMaintain->search(Yii::$app->request->queryParams);

       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'valStt'=>$valStt,
			'searchModelMaintain'=>$searchModelMaintain,
			'dataProviderMaintain'=>$dataProviderMaintain
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


    public function actionDay($id)
    {
        $view_info = Customers::find()->where(['CUST_KD'=>$id])->one();

        $model =  DraftPlan::find()->where(['CUST_KD'=>$id])->one();

        $model_day = new DayName();
          $ary= [
          ['ID' => 1, 'OPT' => 'Pekan Ganjil'],
          ['ID' => 2, 'OPT' => 'Pekan Genap'],
        ];
        $opt = ArrayHelper::map($ary, 'ID', 'OPT');

        $post = Yii::$app->request->post();

        $odd_even = $post['DayName']['OPT'];

         if ($model->load(Yii::$app->request->post())) {

            $day_value = DayName::find()->where(['DAY_ID'=>$model->DAY_ID])->one();

            $model->DAY_VALUE = $day_value->DAY_VALUE;

            $model->ODD_EVEN = $odd_even;

            $model->save();
               
            return $this->redirect(['index']);
         }else{

          return $this->renderAjax('day', [
            'view_info' => $view_info,
            'model'=>$model,
            'model_day'=>$model_day,
            'opt'=>$opt
        ]);
      }
    }

     // action depdrop
   // public function actionLisday($opt) {

   //      $model = DayName::find()->asArray()->where(['OPT'=>$opt])
   //                                                  ->all();
   //          $items = ArrayHelper::map($model, 'DAY_ID', 'DAY_NM');
   //          foreach ($model as $key => $value) {
   //                 // $out[] = [$value['CUST_KD'] => $value['CUST_NM']];
   //                 // <option value="volvo">Volvo</option>
   //   $out [] = "<option value=".$value['DAY_ID'].">".$value['DAY_NM']."</option>";
   //             }

   //             echo json_encode($out);
             
    
   // }

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

    /**
     * Creates a new DraftPlan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DraftPlan();

        /**connetion dbc002*/
        $conn = Yii::$app->db_esm;

        $cari_geo = DraftGeo::find()->where('STATUS<>3')->all();
        $geo = ArrayHelper::map($cari_geo, 'GEO_ID', 'GEO_NM');


        if ($model->load(Yii::$app->request->post())) {



            // $model->save();
            $check_exist = DraftPlan::find()->where(['GEO_ID'=>$model->GEO_ID])->one();
            if(count($check_exist) != 0)
            {
                /*delete data if exist */
                $delete_data = $conn->CreateCommand('DELETE FROM c0002scdl_plan WHERE GEO_ID='.$model->GEO_ID.'')->execute();

                 /*get customers*/
                $get_customers = Customers::find()->where(['GEO'=>$model->GEO_ID])->all();

                /*batch insert*/
                foreach ($get_customers as $key => $value) {
                    # code...
                      $batch = $conn->CreateCommand()->batchInsert('c0002scdl_plan', ['CUST_KD', 'GEO_ID','LAYER_ID'], [
                    [$value->CUST_KD,$value->GEO,$value->LAYER],
                ])->execute();
                }
            }else{


            /*get customers*/
            $get_customers = Customers::find()->where(['GEO'=>$model->GEO_ID])->all();

            /*batch insert*/
            foreach ($get_customers as $key => $value) {
                # code...
                  $batch = $conn->CreateCommand()->batchInsert('c0002scdl_plan', ['CUST_KD', 'GEO_ID','LAYER_ID'], [
                [$value->CUST_KD,$value->GEO,$value->LAYER],
            ])->execute();
            }
        }
          
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'geo'=>$geo
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
     * Deletes an existing DraftPlan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
