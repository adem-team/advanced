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
				//'columnAutoSize'=>false,
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
		$model = $this->findModel($id);
		//$model->scenario = "create";
		if ($model->load(Yii::$app->request->post())){
			$request=\Yii::$app->request->post();
			$dataStatus=$request['SalesPromo']['STATUS'];
			if($dataStatus==1){
				$model->TGL_FINISH = date("Y-m-d");  //STATUS=FINISH, SET TGL_FINISH.
			}			
			$model->UPDATED_AT = date("Y-m-d H:i:s");
			$model->UPDATED_BY =  Yii::$app->user->identity->username;
			if($model->save()){
				return $this->redirect(['/marketing/sales-promo','id'=>$id]);
			};
		}else{
			return $this->renderAjax('review', [
			'model' => $this->findModel($id),
			]);
		}
		
        // return $this->renderAjax('review', [
            // 'model' => $this->findModel($id),
        // ]);
    }
	public function actionTest(){
		$ary=[
			'0'=>['nama'=>'piter','tempat'=>'palembang','alamat'=>'duta bintaro'],			
			'1'=>['nama'=>'syaka','tempat'=>'tangerang','alamat'=>'regensi'],
			'2'=>['nama'=>'piter','tempat'=>'palembang','alamat'=>'duta bintaro'],
			'3'=>['nama'=>'syaka','tempat'=>'tangerang','alamat'=>'regensi'],		
			'4'=>['nama'=>'piter','tempat'=>'tangerang','alamat'=>'regensi'],			
			'5'=>['nama'=>'syaka','tempat'=>'palembang','alamat'=>'regensi']			
		];
		$data=$this->full2sorting($ary,['tempat']);
		print_r($data);// ArrayHelper::toArray($ary);
		
	}
	
	/**
	 * 2 Sorting for Grouping.
	 * author	: ptr.nov@gmail.com
	 * update	: 14/02/2017
	*/
	private function full2sorting($array,$column=[]){
		foreach($column as $rows =>$value){
			$val[]=$value;		
		}
		if(count($column)==1){
			$arySortColumn0=self::array_sorting($array,$val[0], SORT_ASC);
		}elseif(count($column)==2){	
			$arySortColumn0=self::array_sorting($array,$val[0], SORT_ASC);
			$arySortColumn1=self::array_sorting($array,$val[1], SORT_ASC);
			array_multisort($arySortColumn0,SORT_ASC,$arySortColumn1,SORT_ASC,$array);
		}
		return $arySortColumn0;
	}
	
	private function array_sorting($array, $on, $order=SORT_ASC)
	{
		$new_array = array();
		$sortable_array = array();

		if (count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) {
							$sortable_array[$k] = $v2;
						}
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}

			switch ($order) {
				case SORT_ASC:
					asort($sortable_array);
				break;
				case SORT_DESC:
					arsort($sortable_array);
				break;
			}

			foreach ($sortable_array as $k => $v) {
				$new_array[$k] = $array[$k];
			}
		}
	
		//refresh row increment.
		foreach ($new_array as $row =>$value){
			$reversIncrement[]=$value;			
		}
		return $reversIncrement;
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
				if ($dataStatus!=4){
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
				$dataProvider = $searchModel->searchPrint(Yii::$app->request->queryParams);
				$modelClassArray=$dataProvider->getModels();
				$aryFieldSalesPromo=ArrayHelper::toArray($modelClassArray);				//Array Field & Function Fields
				/* $adpPromo=new ArrayDataProvider([
					'allModels'=>$aryFieldSalesPromo,//Yii::$app->arrayBantuan->array_sort($aryFieldSalesPromo, 'CUST_NM', SORT_ASC),
					'sort'=>[
						'attributes'=>['CUST_NM']
					]
				]); */
				$arySort=Yii::$app->arrayBantuan->array_sort($aryFieldSalesPromo, 'CUST_NM', SORT_ASC);
				
				// print_r($f);
				 // die();
							
				$rsltExcel = Postman4ExcelBehavior::excelDataFormat($aryFieldSalesPromo);
				$rsltExcel_ceil = $rsltExcel['excel_ceils'];
				$rsltExcel1 = Postman4ExcelBehavior::excelDataFormat(['0'=>['A'=>'12','B'=>'123']]);
				$rsltExcel_ceil1 = $rsltExcel1['excel_ceils'];
				$excel_content = [
					[
						'sheet_name' => 'KALENDER PROMO',					
						'sheet_title' => [
							//['asd'],
							['CUST_NM','STATUS','PERIODE_START','PERIODE_END','DATE_FINISH','OVERDUE','PROMO','MEKANISME','KOMPENSASI','KETERANGAN','CREATED_BY','CREATED_AT']
						],
						'ceils' =>$aryFieldSalesPromo,
						'freezePane' => 'A2',						
						'columnGroup'=>['CUST_NM'],
						'autoSize'=>true,
						'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
						'headerStyle'=>[					
							[
								'CUST_NM' => ['font-size'=>'8','align'=>'center','valign'=>'center','wrap'=>true],
								'STATUS' => ['font-size'=>'8','align'=>'center','width'=>'8.14','valign'=>'center'],							
								'PERIODE_START' =>['font-size'=>'8','align'=>'center','width'=>'11','valign'=>'center'],
								'PERIODE_END' =>['font-size'=>'8','align'=>'center','width'=>'11','valign'=>'center'],
								'DATE_FINISH' =>['font-size'=>'8','align'=>'center','width'=>'11','valign'=>'center'],
								'OVERDUE' => ['font-size'=>'8','align'=>'center','width'=>'7','valign'=>'center'],
								'PROMO' =>['font-size'=>'8','align'=>'center','width'=>'29.29','wrap'=>true,'valign'=>'center',], 
								'MEKANISME' =>['font-size'=>'8','align'=>'center','width'=>'34.14','wrap'=>true,'valign'=>'center',],
								'KOMPENSASI' => ['font-size'=>'8','align'=>'center','width'=>'34.14','wrap'=>true,'valign'=>'center',],
								'KETERANGAN' => ['font-size'=>'8','align'=>'center','width'=>'34.14','wrap'=>true,'valign'=>'center',],					
								'CREATED_BY' => ['font-size'=>'8','align'=>'center','width'=>'14.86','valign'=>'center'],						
								'CREATED_AT' => ['font-size'=>'8','align'=>'center','width'=>'15','valign'=>'center'],						
								//'UPDATED_BY' => ['align'=>'center']							
							]							
						],
						'contentStyle'=>[
							[						
								'CUST_NM' => ['font-size'=>'8','align'=>'left',],
								'STATUS' => ['font-size'=>'8','align'=>'left'],							 
								'PERIODE_START' =>['font-size'=>'8','align'=>'center'],
								'PERIODE_END' =>['font-size'=>'8','align'=>'center'],
								'TGL_FINISH' =>['font-size'=>'8','align'=>'center'],
								'OVERDUE' => ['font-size'=>'8','align'=>'center'],
								'PROMO' =>['font-size'=>'8','align'=>'left'],
								'MEKANISME' =>['font-size'=>'8','align'=>'left'],
								'KOMPENSASI' => ['font-size'=>'8','align'=>'left'],
								'KETERANGAN' => ['font-size'=>'8','align'=>'left'],
								'CREATED_BY' => ['font-size'=>'8','align'=>'left'],						
								'CREATED_AT' => ['font-size'=>'8','align'=>'center'],						
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
