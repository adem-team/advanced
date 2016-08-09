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
use lukisongroup\master\models\DraftPlanDetail;
use lukisongroup\master\models\DraftPlanGroupSearch;
use lukisongroup\sistem\models\UserloginSearch;
use lukisongroup\master\models\DraftGeoSub;
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
        return ArrayHelper::map(DraftPlanDetail::find()->where('STATUS<>1')->all(),'CUST_ID','custNm');
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
	 * @author ptrnov 
     * @since 1.2.1
     */
	public function actionSendDraft()
    {   
         /*model draftplan*/
        $data_draft = DraftPlan::find()->all();
        //$dynamick =  new DraftPlan();

         /*converting obejct to array*/
        $data = ArrayHelper::toArray($data_draft, [
			'lukisongroup\master\models\DraftPlan' => [
				// 'SCDL_GROUP' => function ($dynamick) {
						// return $dynamick->IdDinamikScdl;
					// },
				'IdDinamikScdl',//SCDL_GROUP
				'GEO_ID',
				'LayerNm',	
				'DAY_ID',
				'DAY_VALUE',
				'CUST_KD',
				'ODD_EVEN'
			],
		]);


		//print_r($data);
		
		/* GET ROW DATE OF WEEK*/
		foreach ($data as $key => $value) {
            if($value['IdDinamikScdl'] != 'NotSet'){

              
				//$aryScdlPlan = Jadwal::getArrayDateCust('2018',$value['LayerNm'],$value['ODD_EVEN'],$value['DAY_VALUE'],$value['IdDinamikScdl'],$value['CUST_KD'],'');
				$aryScdlPlan = Jadwal::getArrayDateCust($value['YEAR'],$value['LayerNm'],$value['ODD_EVEN'],$value['DAY_VALUE'],$value['IdDinamikScdl'],$value['CUST_KD'],'');
			

		
				//INSERT BIT To TABEL c0002scdl_plan_detail |MODEL DraftPlanDetail
				foreach ($aryScdlPlan as $val) {
					$this->conn_esm()->CreateCommand()->batchInsert('c0002scdl_plan_detail', 
								['CUST_ID','TGL','SCDL_GROUP','ODD_EVEN'], 
								[[$val['custId'],$val['tg'],$val['scdlGrp'],$val['currenWeek']]
					])->execute();
				}
			
				/*INSERT GROUP To TABEL c0002scdl_plan_header | MODEL DraftPlanHeader */
				$this->conn_esm()->CreateCommand("
								INSERT INTO c0002scdl_plan_header (
									SELECT NULL,TGL,SCDL_GROUP,NOTE,NULL,0,NULL,NULL,NULL,NULL,NULL FROM c0002scdl_plan_detail
									GROUP BY SCDL_GROUP,TGL
								)		
				")->execute(); 
			
			}
		}	
		
      return $this->redirect(['index?tab=1']); 
    }
	
	
	/**
     * finds draftplan models.
     * @var $dynamick draftplan.
     * @var $data converting obejct to array.
     * save c0002scdl_plan_group via batch insert.
     * if success redirect page index
     * @return mixed
	 * @author ptrnov 
     * @since 1.3.0
     */
	public static function sendMaintain($id)
    {   
         /*model draftplan*/
        //$dataDraftMaintain = DraftPlan::find()->where(['ID'=>$id])->one();
        $dataDraftMaintain = self::findModel($id);
         // $dataDraftMaintain = DraftPlan::find()->joinwith('plandetail')->where(['c0002scdl_plan.ID'=>$id])->one();
        //$dynamick =  new DraftPlan();

         /*converting obejct to array*/
        $dataField = ArrayHelper::toArray($dataDraftMaintain, [
			'lukisongroup\master\models\DraftPlan' => [
				'IdDinamikScdl',//SCDL_GROUP
				'GEO_ID',
				'LayerNm',	
				'DAY_ID',
				'DAY_VALUE',
				'CUST_KD',
				'ODD_EVEN',
				'YEAR',
			],
		]);
        
		
		/* GET ROW DATE OF WEEK*/
		//foreach ($dataField as $key => $value) {
            if($dataField['IdDinamikScdl'] != 'NotSet'){
				//$aryScdlPlan = Jadwal::getArrayDateCust('2018',$value['LayerNm'],$value['ODD_EVEN'],$value['DAY_VALUE'],$value['IdDinamikScdl'],$value['CUST_KD'],'');
				$aryScdlPlan = Jadwal::getArrayDateCust($dataField['YEAR'],$dataField['LayerNm'],$dataField['ODD_EVEN'],$dataField['DAY_VALUE'],$dataField['IdDinamikScdl'],$dataField['CUST_KD'],'');

		
           $ary_scdlplndetail = self::findCount($dataField['CUST_KD']);
				//INSERT BIT To TABEL c0002scdl_plan_detail |MODEL DraftPlanDetail
                if($ary_scdlplndetail == 0)
                {
				foreach ($aryScdlPlan as $val) {

					self::conn_esm()->CreateCommand()->batchInsert('c0002scdl_plan_detail', 
								['CUST_ID','TGL','SCDL_GROUP','ODD_EVEN'], 
								[[$val['custId'],$val['tg'],$val['scdlGrp'],$val['currenWeek']]
					])->execute();
                    }
				}
			
				//INSERT GROUP To TABEL c0002scdl_plan_header | MODEL DraftPlanHeader 
				self::conn_esm()->CreateCommand("
								INSERT INTO c0002scdl_plan_header (
									SELECT NULL,TGL,SCDL_GROUP,NOTE,NULL,0,NULL,NULL,NULL,NULL,NULL FROM c0002scdl_plan_detail
									GROUP BY SCDL_GROUP,TGL
								)		
				")->execute(); 
			
			}
		//}	
		
      //return $this->redirect(['index?tab=0']); 
      return 'index';
	  //return $dataField;
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
		
		/*GROUP SETTING*/
		$searchModelGrp = new DraftPlanGroupSearch();
        $dataProviderGrp = $searchModelGrp->search(Yii::$app->request->queryParams);

		/*GROUP USER*/
		$searchModelUser = new UserloginSearch();
        $dataProviderUser = $searchModelUser->search(Yii::$app->request->queryParams);

       
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
			'dataProviderUser'=>$dataProviderUser
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


	/*
	 * SETUP CUSTOMER SCHEDULE FIRST DAY
	*/
    public function actionSetScdlFday($id)
    {
        //$view_info = Customers::find()->where(['CUST_KD'=>$id])->one();

        $model =  DraftPlan::find()->where(['ID'=>$id])->one();
		$view_info = $model->custTbl; //Customers::find()->where(['CUST_KD'=>$id])->one();
       
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

            $model->DAY_VALUE = $day_value->DAY_VALUE; //THE REAL DAY VALUE

            $model->ODD_EVEN = $odd_even;

            $model->save();
            $rslt=self::sendMaintain($id);
			//print_r(self::sendMaintain(248));
            //return $this->redirect(['index']);
            return $this->redirect([$rslt]);
         }else{

          //return $this->renderAjax('_setScheduleFirstDay', [
          return $this->renderAjax('_setScheduleFirstDay', [
            'view_info' => $view_info,
            'model'=>$model,
            'model_day'=>$model_day,
            'opt'=>$opt
        ]);
      }
    }


    /*
     * Delete DrafplanDetail Customers
    */
    public function actionPilihDelete()
    {
       $model = new DraftPlanDetail();
       $model->scenario = 'delete';

         if ($model->load(Yii::$app->request->post())) {

            self::DeleteDetail($model->CUST_ID);

            return $this->redirect(['index?tab=1']); 

         }else{
          return $this->renderAjax('_pilihdelete', [
            'model'=>$model,
            'cus'=>self::get_arycusdetail()
        ]);
      }
    }

    /*
     * Approve DrafplanDetail Customers
    */
    public function actionPilihApprove()
    {
       $model = new DraftPlanDetail();
       $model->scenario = 'approve';

         if ($model->load(Yii::$app->request->post())) {

            if(self::findCountStatus($model->CUST_ID) == 0)
            {
                self::Approve($model->CUST_ID);
            }else{
                 self::ApproveValidasi($model->CUST_ID);
                 self::Approve($model->CUST_ID);
            }

            return $this->redirect(['index?tab=1']); 

         }else{
          return $this->renderAjax('_pilihapprove', [
            'model'=>$model,
            'cus'=>self::get_arycusdetail()
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

		$ary= [
			['YEAR' => '2015'],
			['YEAR' => '2016'],
			['YEAR' => '2017'],
		];
        $opt = ArrayHelper::map($ary, 'YEAR', 'YEAR');

        if ($model->load(Yii::$app->request->post())) {
			$hsl = \Yii::$app->request->post();	
			$tahun = $hsl['DraftPlan']['YEAR'];

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
                      $batch = $conn->CreateCommand()->batchInsert('c0002scdl_plan', ['CUST_KD', 'GEO_ID','LAYER_ID','YEAR'], [
                    [$value->CUST_KD,$value->GEO,$value->LAYER,$tahun],
                ])->execute();
                }
            }else{


            /*get customers*/
            $get_customers = Customers::find()->where(['GEO'=>$model->GEO_ID])->all();

            /*batch insert*/
            foreach ($get_customers as $key => $value) {
                # code...
                  $batch = $conn->CreateCommand()->batchInsert('c0002scdl_plan', ['CUST_KD', 'GEO_ID','LAYER_ID','YEAR'], [
                [$value->CUST_KD,$value->GEO,$value->LAYER,$tahun],
            ])->execute();
            }
        }
          
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'geo'=>$geo,
				'opt'=>$opt
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
     * Finds the DraftPlandetail count  model based on its CUST_KD value.
     * @param string $CUST_KD
     * @return @var ary_scdlplndetail
     */
    protected function findCount($custId)
    {
       $ary_scdlplndetail = DraftPlanDetail::find()->where(['CUST_ID'=>$custId,'STATUS' => 0])->count();

       return $ary_scdlplndetail;
    }


     /**
     * Finds the DraftPlandetail count  model based on its CUST_KD value.
     * @param string $CUST_KD
     * @return @var ary_scdlplndetail
     */
    protected function findCountStatus($custId)
    {
       $ary_scdlplndetail = DraftPlanDetail::find()->where(['CUST_ID'=>$custId,'STATUS' => 1])->count();

       return $ary_scdlplndetail;
    }


      /**
     * Delete All
     * @param string $custId
     */
    protected function DeleteDetail($custId)
    {
        DraftPlanDetail::deleteAll(['CUST_ID'=>$custId]);
    }


     /**
     * update STATUS 1
     * @param string $custId
     */
    protected function Approve($custId)
    {
       $this->conn_esm()->CreateCommand('UPDATE c0002scdl_plan_detail SET STATUS=1 WHERE CUST_ID="'.$custId.'" AND STATUS = 0')->execute();
       
    }


    /**
     * update STATUS 2
     * @param string $custId
     */
    protected function ApproveValidasi($custId)
    {
            # code...
        $this->conn_esm()->CreateCommand('UPDATE c0002scdl_plan_detail SET STATUS=2 WHERE CUST_ID="'.$custId.'" And STATUS = 1')->execute();
       
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
