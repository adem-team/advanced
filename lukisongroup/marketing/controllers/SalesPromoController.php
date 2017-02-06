<?php

namespace lukisongroup\marketing\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use ptrnov\postman4excel\Postman4ExcelBehavior;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use lukisongroup\marketing\models\SalesPromo;
use lukisongroup\marketing\models\SalesPromoSearch;
use lukisongroup\master\models\Customers;

/**
 * SalesPromoController implements the CRUD actions for SalesPromo model.
 */
class SalesPromoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
 		return [
            // 'export2excel' => [
                // 'class' => Postman4ExcelBehavior::className(),
            // ],
			'export4excel' => [
				'class' => Postman4ExcelBehavior::className(),
				'downloadPath'=>Yii::getAlias('@lukisongroup').'/export/tmp/',
				'widgetType'=>'download',
				'columnAutoSize'=>false,
			], 
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ]
        ];
    }
	/*
	* Declaration Component User Permission
	* Function getPermission
	* Modul Name[11=Calendar Promo]
	* Permission LINK URL.
	*/
	public function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses('11')){
			return Yii::$app->getUserOpt->Modul_akses('11');
		}else{
			return false;
		}
	}  
	/**
     * Before Action Index
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
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
			   //Modul permission URL, author -ptr.nov@gail.com-
			   if(self::getPermission()->BTN_CREATE OR self::getPermission()->BTN_VIEW){
					return true;
			   }else{
				   $this->redirect(array('/site/validasi'));
			   }
		   }
		} else {
			return true;
		}
    }
	
    /**
     * Lists all SalesPromo models.
     * @return mixed
     */
    public function actionIndex()
    {	
		/* $paramCari=Yii::$app->getRequest()->getQueryParam('id');
		if($paramCari!=''){
			//print_r($paramCari);
			//$cari=['id'=>$paramCari];
			$url = Url::toRoute(['/marketing/sales-promo/view','id'=>$paramCari]);
			//print_r($url);
			
			$js='
				//$(document).on("click","#modalButtonCustomers", function(ehead){ 
			    $(document).on("click","#button-view-pasien-id", function(ehead){ 			  
					$("#view-pasien-id").modal("show")
					.find("#modalContentpasienview").html("<i class=\"fa fa-2x fa-spinner fa-spin\"></i>")
					.load(ehead.target.value);
				});
				})
			';
			$this->getView()->registerJs($js);
		};  */
		$paramCari=Yii::$app->getRequest()->getQueryParam('id');
		if($paramCari){
			 $searchModel = new SalesPromoSearch(['ID'=>$paramCari]);
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		}else{
			 $searchModel = new SalesPromoSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		}
       

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single SalesPromo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
	/**
     * Displays a single SalesPromo model.
     * @param integer $id
     * @return mixed
     */
    public function actionReview($id)
    {
		
        return $this->renderAjax('review', [
            'model' => $this->findModel($id),
        ]);
    }
	
	/**
     * Dynamic Model model.
     * Export Excel
     */
    public function actionExportExcel()
    {
		$model = new \yii\base\DynamicModel(['STATUS']);
		$model->addRule(['STATUS'], 'required');
		
		if (!$model->load(Yii::$app->request->post())){
			//Show Form.
			return $this->renderAjax('_formExport', [
				'model'=>$model				
			]);
		}else{
			//Validation.
			if(Yii::$app->request->isAjax){
				$model->load(Yii::$app->request->post());
				return Json::encode(\yii\widgets\ActiveForm::validate($model));
			};
			if ($model->load(Yii::$app->request->post())){
				//get request post
				$request=\Yii::$app->request->post();
				$dataStatus=$request['DynamicModel']['STATUS'];
				if ($dataStatus!=3){
					$valStatus=$dataStatus;
				}else{
					$valStatus='';
				}
				//print_r($dataStatus);
				//die();
				
				/**
				 * DIIRECT DATA FROM MODEL SEARCH TO FUNCTION:  function fields().
				 * ALL FUNCTION MODEL.
				 * Untuk API array to Json sangat cocok.
				*/
				//$modelClassArray=SalesPromo::find()->all();							//Tidak bisa di gunakan jika sudah mengunakan  Fungsian COMMAND SQL [SELECT/WHERE/DLL]
				$searchModel = new SalesPromoSearch(['STATUS'=>$valStatus]);					//search yang bagus untuk semua function di model.[gunakan model search untuk sql command].
				$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
				$modelClassArray=$dataProvider->getModels();
				$aryFieldSalesPromo=ArrayHelper::toArray($modelClassArray);				//Array Field & Function Fields
				//print_r($aryFieldSalesPromo);
				//die();
							
				$rsltExcel = Postman4ExcelBehavior::excelDataFormat($aryFieldSalesPromo);
				$rsltExcel_ceil = $rsltExcel['excel_ceils'];
				$excel_content = [
					[
						'sheet_name' => 'KALENDER PROMO',					
						'sheet_title' => [
							['CUST_NM','STATUS','TGL_START','TGL_END','OVERDUE','PROMO','MEKANISME','KOMPENSASI','KETERANGAN','CREATED_BY','CREATED_AT']
						],
						'ceils' =>$rsltExcel_ceil,
						'freezePane' => 'A2',
						'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
						'headerStyle'=>[					
							[
								'CUST_NM' => ['align'=>'center','width'=>'32.29','valign'=>'center','wrap'=>true],
								'STATUS' => ['align'=>'center','width'=>'9.29','valign'=>'center'],							
								'TGL_START' =>['align'=>'center','width'=>'11.29','valign'=>'center'],
								'TGL_END' =>['align'=>'center','width'=>'11.29','valign'=>'center'],
								'OVERDUE' => ['align'=>'center','width'=>'10.14','valign'=>'center'],
								'PROMO' =>['align'=>'center','width'=>'33.14','wrap'=>true,'valign'=>'center',], 
								'MEKANISME' =>['align'=>'center','width'=>'47.14','wrap'=>true,'valign'=>'center',],
								'KOMPENSASI' => ['align'=>'center','width'=>'47.14','wrap'=>true,'valign'=>'center',],
								'KETERANGAN' => ['align'=>'center','width'=>'47.14','wrap'=>true,'valign'=>'center',],					
								'CREATED_BY' => ['align'=>'center','width'=>'23.71','valign'=>'center'],						
								'CREATED_AT' => ['align'=>'center','width'=>'20.57','valign'=>'center'],						
								//'UPDATED_BY' => ['align'=>'center']							
							]
							
						],
						'contentStyle'=>[
							[						
								'CUST_NM' => ['align'=>'left',],
								'STATUS' => ['align'=>'left'],							 
								'TGL_START' =>['align'=>'center'],
								'TGL_END' =>['align'=>'center'],
								'OVERDUE' => ['align'=>'center'],
								'PROMO' =>['align'=>'left'],
								'MEKANISME' =>['align'=>'left'],
								'KOMPENSASI' => ['align'=>'left'],
								'KETERANGAN' => ['align'=>'left'],
								'CREATED_BY' => ['align'=>'left'],						
								'CREATED_AT' => ['align'=>'center'],						
								//'UPDATED_BY' => ['align'=>'left']									
							]
						],            
						'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
						'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
					]
				];
				//$excel_file = "CustomerDataERPPilih".'-'.date('Ymd-his');
				$excel_file = "SalesPromo";
				//$this->export2excel($excel_content, $excel_file,1);
				$this->export4excel($excel_content, $excel_file); 
			}
		}
    }
	
	/**
     * Displays a single SalesPromo model.
     * @param integer $id
     * @return mixed
     */
    public function actionRemainder($id)
    {
		
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SalesPromo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SalesPromo();
		$model->scenario = "create";
        if ($model->load(Yii::$app->request->post())) {
			$model->CREATED_BY =  Yii::$app->user->identity->username;
			$model->CREATED_AT = date("Y-m-d H:i:s");
			$model->save();
            return $this->redirect(['index', 'id' => $model->ID]);
        } else {
             //return $this->renderAjax('create', [
             return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }
	public function actionValid()
     {
        # code...
        // $post = Yii::$app->request->post();
        // if($post['Customers']['parentnama'] == 1)
        // {
          // $model = new Customers();
          // $model->scenario = "create";
        // }else{
          // $model = new Customers();
          // $model->scenario = "parentcreate";
        // }

        $model = new SalesPromo();
		$model->scenario = "create";
        if(Yii::$app->request->isAjax && $model->load($_POST))        {
          Yii::$app->response->format = 'json';
          return ActiveForm::validate($model);
        }
    }
	  
    /**
     * Updates an existing SalesPromo model.
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
     * Deletes an existing SalesPromo model.
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
     * Depdrop child customers
     * @author wawan
     * @since 1.1.0
     * @return mixed
     */
   public function actionLisChildCus() {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $id = $parents[0];

            $model = Customers::find()->asArray()->where(['CUST_GRP'=>$id])
                                                     ->andwhere('STATUS <> 3')
                                                    ->all();
                                                    // print_r($model);
                                                    // die();
            //$out = self::getSubCatList($cat_id);
            // the getSubCatList function will query the database based on the
            // cat_id and return an array like below:
            // [
            //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
            //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
            // ]
            foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['CUST_KD'],'name'=> $value['CUST_NM']];
               }

               echo json_encode(['output'=>$out, 'selected'=>'']);
               return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
   }
   
   /**
     * Depdrop child customers
     * @author wawan
     * @since 1.1.0
     * @return mixed
     */
   public function actionLisChildCusnm() {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $id1 = $parents[0];
            $id2 = $parents[1];
            $model = Customers::find()->asArray()->where(['CUST_KD'=>$id2])
                                                     ->andwhere('STATUS <> 3')
                                                    ->all();
                                                    // print_r($model);
                                                    // die();
													
            //$out = self::getSubCatList($cat_id);
            // the getSubCatList function will query the database based on the
            // cat_id and return an array like below:
            // [
            //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
            //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
            // ]
            foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['CUST_NM'],'name'=> $value['CUST_NM']];
				   $selected = $value['CUST_NM'];
               }
			// $selected = $account['id'];
               echo json_encode(['output'=>$out, 'selected'=> $selected ]);
               return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
   }
   
    /**
     * Finds the SalesPromo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalesPromo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalesPromo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
