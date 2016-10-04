<?php

namespace lukisongroup\sales\controllers;

use Yii;
use kartik\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\widgets\Spinner;
use \moonland\phpexcel\Excel;

use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\Response;
use scotthuangzl\export2excel\Export2ExcelBehavior;

use lukisongroup\sales\models\UserFile;
use lukisongroup\sales\models\UserFileSearch;
use lukisongroup\sales\models\TempData;
use lukisongroup\sales\models\TempDataSearch;

use lukisongroup\sales\models\AliasCustomer;
use lukisongroup\sales\models\AliasProdak;
use lukisongroup\sales\models\ImportViewSearch;
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Barang;
//use lukisongroup\master\models\Customersalias;


// use lukisongroup\sales\models\Sot2;
// use lukisongroup\sales\models\Sot2Search;

/**
 * SalesDetailController implements the CRUD actions for Sot2 model.
 */
class ImportDataController extends Controller
{
    public function behaviors()
    {
        return [
			/*EXCEl IMPORT*/
			'export2excel' => [
				'class' => Export2ExcelBehavior::className(),
			],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

	/*EXCEl IMPORT*/
	public function actions()
    {
        return [
            /* 'error' => [
                'class' => 'yii\web\ErrorAction',
            ], */
            /* 'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ], */
            //new add download action
            'download' => [
                'class' => 'scotthuangzl\export2excel\DownloadAction',
            ],
        ];
    }
	private function aryCustID(){
		$dataCust =  ArrayHelper::map(Customers::find()->orderBy('CUST_NM')->asArray()->all(), 'CUST_KD','CUST_NM');
		return $dataCust;
	}

	private function aryBrgID(){
		$dataCust =  ArrayHelper::map(Barang::find()->where(['KD_CORP'=>'ESM','KD_TYPE'=>'01','KD_KATEGORi'=>'01'])->orderBy('NM_BARANG')->asArray()->all(), 'KD_BARANG','NM_BARANG');
		return $dataCust;
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
                   return true;
               }
            } else {
                return true;
            }
    }

	 /**
     * IMPORT DATA EXCEL
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
     */
    public function actionIndex()
    {
		$paramFile=Yii::$app->getRequest()->getQueryParam('id');
		//echo $paramCari;
		$model = new UserFile();

		$username=  Yii::$app->user->identity->username;
		$user_id=['USER_ID'=>$username];
		/*IMPORT VALIDATION*/
		$searchModel = new TempDataSearch($user_id);
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		/*VIEW IMPORT*/
		$searchModelViewImport = new ImportViewSearch();
		$dataProviderViewImport = $searchModelViewImport->search(Yii::$app->request->queryParams);
		//echo $this->actionExport_format();
		return $this->render('index',[
			/*VIEW ARRAY FILE*/
			'getArryFile'=>$this->getArryFile($paramFile),
			'fileName'=>$paramFile,
			'gvColumnAryFile'=>$this->gvColumnAryFile(),
			/*GRID VALIDATE*/
			'gvValidateColumn'=>$this->gvValidateColumn(),
			//'gvValidateArrayDataProvider'=>$this->gvValidateArrayDataProvider(),
			'gvValidateArrayDataProvider'=>$dataProvider,
			'searchModelValidate'=>$searchModel,
			'modelFile'=>$model,
			/*VIEW IMPORT*/
			'gvRows'=>$this->gvRows(),
			'searchModelViewImport'=>$searchModelViewImport,
			'dataProviderViewImport'=>$dataProviderViewImport,
		]);
    }

    /**
     * Displays a single Sot2 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sot2 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sot2();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Sot2 model.
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
     * Deletes an existing Sot2 model.
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
     * Finds the Sot2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Sot2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sot2::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	public function actionUpload(){
		$model = new UserFile();
		if ($model->load(Yii::$app->request->post()) ) {
			if($model->validate()){
				$model->USER_ID = Yii::$app->user->identity->username;
				$exportFile = $model->uploadFile();
				if ($model->save()) {
				 //upload only if valid uploaded file instance found
					 if ($exportFile !== false) {
						$path = $model->getImageFile();
						$exportFile->saveAs($path);
						return $this->redirect(['index','id'=>$model->FILE_NM]);
					}
				}
			}
		}
	}


	/**=====================================
     * GET ARRAY FROM FILE
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * =====================================
     */
	public function getArryFile($paramFile){
			$fileData=$paramFile!=''?$paramFile:'default_import_sales.xlsx';
			$fileName=Yii::$app->basePath . '/web/upload/sales_import/'.$fileData;
			$config='';
			//$data = \moonland\phpexcel\Excel::import($fileName, $config);

			$data = \moonland\phpexcel\Excel::widget([
				'id'=>'export',
				'mode' => 'import',
				'fileName' => $fileName,
				'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
				'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
				'getOnlySheet' => 'IMPORT FORMAT STOCK', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
				]);

			//print_r($data);
			$aryDataProvider= new ArrayDataProvider([
				//'key' => 'ID',
				'allModels'=>$data,
				 'pagination' => [
					'pageSize' => 1000,
				]
			]);

			//return Spinner::widget(['preset' => 'medium', 'align' => 'center', 'color' => 'blue','hidden'=>false]);
			return $aryDataProvider;
	}
	/*
	 * HEADER GRID DINAMIK | FORM GET ARRAY FILE
	 * Arry Setting Attribute
	 * @author ptrnov [ptr.nov@gmail.com]
	 * @since 1.2
	*/
	private function gvAttribute(){
		$aryField= [
			['ID' =>0, 'ATTR' =>['FIELD'=>'DATE','SIZE' => '10px','label'=>'DATE','align'=>'center']],
			['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_KD','SIZE' => '10px','label'=>'CUST_KD','align'=>'left']],
			['ID' =>2, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '20px','label'=>'CUST_NM','align'=>'left']],
			['ID' =>3, 'ATTR' =>['FIELD'=>'SKU_ID','SIZE' => '20px','label'=>'SKU_ID','align'=>'left']],
			['ID' =>4, 'ATTR' =>['FIELD'=>'SKU_NM','SIZE' => '20px','label'=>'SKU_NM','align'=>'left']],
			['ID' =>5, 'ATTR' =>['FIELD'=>'QTY_PCS','SIZE' => '20px','label'=>'QTY_PCS','align'=>'right']],
			['ID' =>6, 'ATTR' =>['FIELD'=>'DIS_REF','SIZE' => '20px','label'=>'DIS_REF','align'=>'right']],
		];
		$valFields = ArrayHelper::map($aryField, 'ID', 'ATTR');

		return $valFields;
	}

	/**
     * GRID ROWS | FORM GET ARRAY FILE
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
     */
	public function gvColumnAryFile() {
		$attDinamik =[];
		foreach($this->gvAttribute() as $key =>$value[]){
			$attDinamik[]=[
				'attribute'=>$value[$key]['FIELD'],
				'label'=>$value[$key]['label'],
				//'format' => 'html',
				/* 'value'=>function($model)use($value,$key){
					if ($value[$key]['FIELD']=='EMP_IMG'){
						 return Html::img(Yii::getAlias('@HRD_EMP_UploadUrl') . '/'. $model->EMP_IMG, ['width'=>'20']);
					}
				}, */
				//'filterType'=>$gvfilterType,
				//'filter'=>$gvfilter,
				//'filterWidgetOptions'=>$filterWidgetOpt,
				//'filterInputOptions'=>$filterInputOpt,
				'hAlign'=>'right',
				'vAlign'=>'middle',
				//'mergeHeader'=>true,
				'noWrap'=>true,
				'headerOptions'=>[
						'style'=>[
						'text-align'=>'center',
						'width'=>$value[$key]['FIELD'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>$value[$key]['align'],
						//'width'=>'12px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(13, 127, 3, 0.1)',
					]
				],
				//'pageSummaryFunc'=>GridView::F_SUM,
				//'pageSummary'=>true,
				'pageSummaryOptions' => [
					'style'=>[
							'text-align'=>'right',
							//'width'=>'12px',
							'font-family'=>'tahoma',
							'font-size'=>'8pt',
							'text-decoration'=>'underline',
							'font-weight'=>'bold',
							'border-left-color'=>'transparant',
							'border-left'=>'0px',
					]
				],
			];
		}
		return $attDinamik;
	}


	/**=====================================
     * GET ARRAY FROM FILE | TO VALIDATE
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * =====================================
     */
	 /*GRID HEADER COLUMN*/
	 private function gvValidateAttribute(){
		$aryField= [
			['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'Date','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '10px','label'=>'Customer','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>2, 'ATTR' =>['FIELD'=>'ITEM_NM','SIZE' => '10px','label'=>'SKU NM','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>3, 'ATTR' =>['FIELD'=>'QTY_PCS','SIZE' => '10px','label'=>'QTY.PCS','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>4, 'ATTR' =>['FIELD'=>'DIS_REF_NM','SIZE' => '10px','label'=>'DIS_REF','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			/*REFRENSI ALIAS*/
			['ID' =>5, 'ATTR' =>['FIELD'=>'CUST_KD_ALIAS','SIZE' => '10px','label'=>'CUST_KD','align'=>'left','warna'=>'255, 154, 48, 1']],
			['ID' =>6, 'ATTR' =>['FIELD'=>'CUST_KD','SIZE' => '10px','label'=>'CUST ALIAS','align'=>'left','warna'=>'255, 154, 48, 1']],
			['ID' =>7, 'ATTR' =>['FIELD'=>'ITEM_ID_ALIAS','SIZE' => '10px','label'=>'SKU ID','align'=>'left','warna'=>'255, 255, 48, 4']],
			['ID' =>8, 'ATTR' =>['FIELD'=>'ITEM_ID','SIZE' => '10px','label'=>'SKU.ID.ALIAS','align'=>'left','warna'=>'255, 255, 48, 4']],
			['ID' =>9, 'ATTR' =>['FIELD'=>'DIS_REF','SIZE' => '10px','label'=>'DIS_REF','align'=>'left','warna'=>'215, 255, 48, 1']],
		];
		$valFields = ArrayHelper::map($aryField, 'ID', 'ATTR');

		return $valFields;
	}
	/*GRID ARRAY DATA PROVIDER*/
	// private function gvValidateArrayDataProvider(){
		// $user= Yii::$app->user->identity->username;
		// $data=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_TEMP_view('STOCK','".$user."')")->queryAll();
		// $aryDataProvider= new ArrayDataProvider([
			// 'key' => 'ID',
			// 'allModels'=>$data,
			 // 'pagination' => [
				// 'pageSize' => 500,
			// ]
		// ]);

		// return $aryDataProvider;
	// }
	/*GRID ROWS VALIDATE*/
	public function gvValidateColumn() {
		$actionClass='btn btn-info btn-xs';
		$actionLabel='Update';
		$attDinamik =[];
		$attDinamik[]=[
			'class'=>'kartik\grid\ActionColumn',
			'dropdown' => true,
			'template' => '{cust}{prodak}',
			//'template' => '{cust}{prodak}{customer}',
			'dropdownOptions'=>['class'=>'pull-left dropdown','style'=>['disable'=>true]],
			'dropdownButton'=>[
				'class' => $actionClass,
				'label'=>$actionLabel,
				//'caret'=>'<span class="caret"></span>',
			],
			'buttons' => [
				'cust' =>function($url, $model, $key){
						return  '<li>' .Html::a('<span class="fa fa-random fa-dm"></span>'.Yii::t('app', 'Set Alias Customer'),
													['/sales/import-data/alias_cust','id'=>$model['ID']],[
													'id'=>'alias-cust-id',
													'data-toggle'=>"modal",
													'data-target'=>"#alias-cust",
													]). '</li>' . PHP_EOL;
				},
				'prodak' =>function($url, $model, $key){
						return  '<li>' . Html::a('<span class="fa fa-retweet fa-dm"></span>'.Yii::t('app', 'Set Alias Prodak'),
													['/sales/import-data/alias_prodak','id'=>$model['ID']],[
													'id'=>'alias-prodak-id',
													'data-toggle'=>"modal",
													'data-target'=>"#alias-prodak",
													]). '</li>' . PHP_EOL;
				},
				/* 'customer' =>function($url, $model, $key){
						return  '<li>' . Html::a('<span class="fa fa-retweet fa-dm"></span>'.Yii::t('app', 'new Customer'),
													['/sales/import-data/new_customer','id'=>$model['ID']],[
													'data-toggle'=>"modal",
													'data-target'=>"#alias-prodak",
													]). '</li>' . PHP_EOL;
				},	 */
			],
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'height'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],

		];

		foreach($this->gvValidateAttribute() as $key =>$value[]){
			$attDinamik[]=[
				'attribute'=>$value[$key]['FIELD'],
				'label'=>$value[$key]['label'],
				'filter'=>true,
				'hAlign'=>'right',
				'vAlign'=>'middle',
				//'mergeHeader'=>true,
				'noWrap'=>true,
				'headerOptions'=>[
						'style'=>[
						'text-align'=>'center',
						'width'=>$value[$key]['FIELD'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(97, 211, 96, 0.3)',
						'background-color'=>'rgba('.$value[$key]['warna'].')',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>$value[$key]['align'],
						//'width'=>'12px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(13, 127, 3, 0.1)',
					]
				],
				//'pageSummaryFunc'=>GridView::F_SUM,
				//'pageSummary'=>true,
				// 'pageSummaryOptions' => [
					// 'style'=>[
							// 'text-align'=>'right',
							'width'=>'12px',
							// 'font-family'=>'tahoma',
							// 'font-size'=>'8pt',
							// 'text-decoration'=>'underline',
							// 'font-weight'=>'bold',
							// 'border-left-color'=>'transparant',
							// 'border-left'=>'0px',
					// ]
				// ],
			];
		}
		return $attDinamik;
	}


	/**====================================
     * IMPORT DATA EXCEL >> TEMP VALIDATION
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.2
	 * ====================================
     */
	public function actionImport_temp_validation(){
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			$username=  Yii::$app->user->identity->username;
			$pos='WEB_LUKISONGROUP';
			$data=$this->getArryFile($id)->getModels();
			//'STOCK','2016-01-23','O041','ROBINSON MALL TATURA PALU','EF001','MAXI Cassava Crackers Hot Spicy','1','admin'
			$stt=0;
			foreach($data as $key => $value){

				//$cmd->reset();
				$tgl=$value['DATE'];
				$cust_kd= $value['CUST_KD'];
				$cust_nm= $value['CUST_NM'];
				$item_kd= $value['SKU_ID'];
				$item_nm=$value['SKU_NM'];
				$qty=$value['QTY_PCS'];
				$dis_ref=$value['DIS_REF'];
				$user_id=$username;
				//$result='('."'".$a."','".$b."')";

				/*DELETE TEMPORARY FIRST EXECUTE*/
				if ($stt==0){
					$cmd1=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_TEMP_create(
									'STOCK_DELETE','','','','','','','','','".$user_id."'
								);
						");
					$cmd1->execute();
				};
				//print_r($result);
				$cmd=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_TEMP_create(
								'STOCK','".$tgl."','".$cust_kd."','".$cust_nm."','".$item_kd."','".$item_nm."','".$qty."','".$dis_ref."','".$pos."','".$user_id."'
						);
				");
				$cmd->execute();
				//$spinnerVal=false;
				$stt=$stt+1;
			}
			//return '[{'.$tgl.'}]';
			return true;
		}
	}

	/**====================================
     * EXPORT FORMAT
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.2
	 * ====================================
     */
	public function actionExport_format(){
		$data_format=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_format()")->queryAll();

		 $DataProviderFormat= new ArrayDataProvider([
			 'key' => 'ID',
			  'allModels'=>$data_format,
			   'pagination' => [
				 'pageSize' => 10,
			 ]
		 ]);
		 $aryDataProviderFormat=$DataProviderFormat->allModels;

		/* PR
		 * $model->field dan $model['field']
		*/

		$searchModelX = new TempDataSearch();
		$dataProviderX = $searchModelX->search(Yii::$app->request->queryParams);
		$dataProvider1= $dataProviderX->getModels();
		$dataProvider2= $dataProviderX->getModels();
		$dataProvider3= $dataProviderX->getModels();


		//if (Yii::$app->request->isAjax) {
		/* echo  \moonland\phpexcel\Excel::widget([
				'id'=>'export',
				'isMultipleSheet' => true,
				 'models' => [
					'sheet1' => $dataProvider1,
					//'sheet2' => $dataProvider2,
					//'sheet3' => $dataProvider3
				],
				'mode' => 'export',
				'fileName'=>'FORMAT IMPORT STOCK',
				'setFirstTitle'=>true,//'IMPORT STOCK',
				//default value as 'export'
				'properties'=>[
					//'sheet1.name'=>'ere'
				],
				'columns' => [
					'sheet1' => [
						[
							'attribute'=>'TGL',
							'header' => 'DATE',
							'format' => 'date',

						],
						[
							'attribute'=>'CUST_KD_ALIAS',
							'header' => 'CUST_KD',
							'format' => 'text',
						],
						[
							'attribute'=>'ITEM_ID_ALIAS',
							'header' => 'SKU_KD',
							'format' => 'text',
						],
					],
				],
				// 'columns' => [
					// 'sheet1' => [
						// 'column1'=>'TGL',
						// 'column2'=>'CUST_KD_ALIAS',
						// 'column3'=>'ITEM_ID_ALIAS'
					// ],
					//'sheet1' => ['column1'=>'TGL','column2'=>'CUST_KD_ALIAS','column3'=>'ITEM_ID_ALIAS'],
					//'sheet2' => ['column1'=>'TGL','column2'=>'CUST_KD_ALIAS','column3'=>'ITEM_ID_ALIAS'],
					//'sheet3' => ['column1'=>'TGL','column2'=>'CUST_KD_ALIAS','column3'=>'ITEM_ID_ALIAS']
				// ],
					//without header working, because the header will be get label from attribute label.
				//'header' => [
					// 'sheet1' => ['column1' => 'Header Column 1','column2' => 'Header Column 2', 'column3' => 'Header Column 3']
					// 'sheet2' => ['column1' => 'Header Column 1','column2' => 'Header Column 2', 'column3' => 'Header Column 3'],
					// 'sheet3' => ['column1' => 'Header Column 1','column2' => 'Header Column 2', 'column3' => 'Header Column 3']
				 //],
				////'sheet1' => ['TGL','CUST_KD_ALIAS','ITEM_ID_ALIAS'],

			]);	 */
			//return true;
			//return $this->redirect('index');
			//echo $data1;
			//if(Yii::$app->request->referrer){
			//			return $this->redirect(Yii::$app->request->referrer);
			//		}else{
			//			return $this->goHome();
			//		}
		//}

		$excel_data = Export2ExcelBehavior::excelDataFormat($aryDataProviderFormat);
        $excel_title = $excel_data['excel_title'];
        $excel_ceils = $excel_data['excel_ceils'];
		$excel_content = [
			 [
				'sheet_name' => 'IMPORT FORMAT STOCK',
                'sheet_title' => ['DATE','CUST_KD','CUST_NM','SKU_ID','SKU_NM','QTY_PCS','DIS_REF'], //$excel_ceils,//'sad',//[$excel_title],
			    'ceils' => $excel_ceils,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					 'TGL' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_KD' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'SKU_ID' => Export2ExcelBehavior::getCssClass('header'),
                     'SKU_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'QTY_PCS' => Export2ExcelBehavior::getCssClass('header'),
                     'DIS_REF' => Export2ExcelBehavior::getCssClass('header'),
                ], //define each column's cssClass for header line only.  You can set as blank.
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'IMPORTANT NOTE ',
                'sheet_title' => ["Important Note For Import Stock Customer"],
                'ceils' => [
					["1.pastikan tidak merubah format hanya menambahkan data, karena import versi 1.2 masih butuhkan pengembangan validasi"],
                    ["2.Berikut beberapa format nama yang tidak di anjurkan di ganti:"],
                    ["  A. Nama dari Sheet1: IMPORT FORMAT STOCK "],
					["  B. Nama Header seperti column : DATE,CUST_KD,CUST_NM,SKU_ID,SKU_NM,QTY_PCS,DIS_REF"],
					["3.Refrensi."],
					["  'IMPORT FORMAT STOCK'= Nama dari Sheet1 yang aktif untuk di import "],
					["  'DATE'= Tanggal dari data stok yang akan di import "],
					["  'CUST_KD'= Kode dari customer, dimana setiap customer memiliki kode sendiri sendiri sesuai yang mereka miliki "],
					["  'CUST_NM'= Nama dari customer "],
					["  'SKU_ID'=  Kode dari Item yang mana customer memiliku kode items yang berbeda beda "],
					["  'SKU_NM'=  Nama dari Item, sebaiknya disamakan dengan nama yang dimiliki lukisongroup"],
					["  'QTY_PCS'= Quantity dalam unit PCS "],
					["  'DIS_REF'= Kode dari pendistribusian, contoh pendistribusian ke Distributor, Subdisk, Agen dan lain-lain"],
				],
			],

		];

		 $excel_file = "StockImportFormat";
			 $this->export2excel($excel_content, $excel_file);





	}
	/**====================================
     * DELETE & CLEAR >> TEMP VALIDATION
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.2
	 * ====================================
     */
	public function actionClear_temp_validation(){
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$user_id=$request->post('id');
			$username=  Yii::$app->user->identity->username;
				/*DELETE STORED FIRST EXECUTE*/
				$cmd_clear=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_TEMP_create(
									'STOCK_DELETE','','','','','','','','','".$username."'
								);
						");
				$cmd_clear->execute();

			return true;
		}

	}

	/**====================================
     * Action SEND DATA TO STORED LIVE
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.2
	 * ====================================
     */
	public function actionSend_temp_validation(){
		if (Yii::$app->request->isAjax) {
			$username=  Yii::$app->user->identity->username;
			$data_view=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_TEMP_view('STOCK','".$username."')")->queryAll();

			$viewDataProvider= new ArrayDataProvider([
				'key' => 'ID',
				 'allModels'=>$data_view,
				  'pagination' => [
					 'pageSize' => 1000,
				]
			]);
			$dataImport=$viewDataProvider->allModels;
			// print_r($viewDataProvider->allModels);
			// die();

			foreach($dataImport as $key => $value){
				//$cmd->reset();
				$tgl=$value['TGL'];
				$cust_kd= $value['CUST_KD_ALIAS'];
				$item_kd= $value['ITEM_ID_ALIAS'];
				$item_qty= $value['QTY_PCS'];
				$import_live=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_LIVE_create(
									'STOCK','".$tgl."','".$cust_kd."','".$item_kd."','".$item_qty."','WEB_IMPORT','".$username."'
								)");
				$import_live->execute();
				$stt=1;
			}
			/*Delete After Import*/
			$cmd_del=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_TEMP_create(
									'STOCK_DELETE','','','','','','','','','".$username."'
								);
						");
			$cmd_del->execute();
			return true;
		}else{
			return $this->redirect(['index']);
		}
		return $this->redirect(['index']);
	}

	/**====================================
     * Action Set Alias Customer
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.2
	 * ====================================
     */
	public function actionAlias_cust($id){
		$AliasCustomer = new AliasCustomer();
		$tempDataImport = TempData::find()->where(['ID' =>$id])->one();
		return $this->renderAjax('alias_customer',[
			'AliasCustomer'=>$AliasCustomer,
			'tempDataImport'=>$tempDataImport,
			'aryCustID'=>$this->aryCustID(),
			//'test'=>Yii::$app->request->referrer
		]);
	}
	public function actionAlias_cust_save(){
		$AliasCustomer = new AliasCustomer;
		/*Ajax Load*/
		if(Yii::$app->request->isAjax){
			$AliasCustomer->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($AliasCustomer));
		}else{	/*Normal Load*/
			if($AliasCustomer->load(Yii::$app->request->post())){
			   //$aliasCustomer->alias_customer_save();
				if ($AliasCustomer->alias_customer_save()){
					//$hsl = \Yii::$app->request->post();
					// $kdpo = $hsl['AliasCustomer']['kdpo'];
					// $this->Sendmail2($kdpo);
					 //$paramFile=Yii::$app->getRequest()->getQueryParam('id');
					// $paramFile=Yii::$app->request->referrer;
					//return $this->redirect(['index', 'id'=>$paramFile]);
					//return Yii::$app->request->referrer;
					//return true;
					if(Yii::$app->request->referrer){
						return $this->redirect(Yii::$app->request->referrer);
					}else{
						return $this->goHome();
					}
				}
			}
		}
	}
	/**====================================
     * Action Set Alias Product
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.2
	 * ====================================
     */
	public function actionAlias_prodak($id){
		$AliasProdak = new AliasProdak();
		$tempDataImport = TempData::find()->where(['ID' =>$id])->one();
		return $this->renderAjax('alias_prodak',[
			'AliasProdak'=>$AliasProdak,
			'tempDataImport'=>$tempDataImport,
			'aryBrgID'=>$this->aryBrgID()
		]);
	}
	public function actionAlias_prodak_save(){
		$AliasProdak = new AliasProdak();
		/*Ajax Load*/
		if(Yii::$app->request->isAjax){
			$AliasProdak->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($AliasProdak));
		}else{
			/*Normal Load*/
			if($AliasProdak->load(Yii::$app->request->post())){
			 	if ($AliasProdak->alias_barang_save()){
					if(Yii::$app->request->referrer){
						return $this->redirect(Yii::$app->request->referrer);
					}else{
						return $this->goHome();
					}
				}
			}
		}
	}


	/**=====================================
     * VIEW IMPORT DATA STORAGE
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * =====================================
     */
	 /*GRID HEADER COLUMN*/
	 private function gvHeadColomn(){
		$aryField= [
			/*MAIN DATA*/
			['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'Date','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_KD_ALIAS','SIZE' => '10px','label'=>'CUST.KD','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>2, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '10px','label'=>'CUSTOMER','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>3, 'ATTR' =>['FIELD'=>'NM_BARANG','SIZE' => '10px','label'=>'SKU','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>4, 'ATTR' =>['FIELD'=>'SO_QTY','SIZE' => '10px','label'=>'QTY.PCS','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>5, 'ATTR' =>['FIELD'=>'NM_DIS','SIZE' => '10px','label'=>'DISTRIBUTION','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>6, 'ATTR' =>['FIELD'=>'SO_TYPE','SIZE' => '10px','label'=>'TYPE','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>7, 'ATTR' =>['FIELD'=>'USER_ID','SIZE' => '10px','label'=>'IMPORT.BY','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			/*REFRENSI DATA*/
			['ID' =>8, 'ATTR' =>['FIELD'=>'UNIT_BARANG','SIZE' => '10px','label'=>'UNIT','align'=>'left','warna'=>'255, 255, 48, 4']],
			['ID' =>9, 'ATTR' =>['FIELD'=>'UNIT_QTY','SIZE' => '10px','label'=>'UNIT.QTY','align'=>'left','warna'=>'255, 255, 48, 4']],
			['ID' =>10, 'ATTR' =>['FIELD'=>'UNIT_BERAT','SIZE' => '10px','label'=>'WEIGHT','align'=>'left','warna'=>'255, 255, 48, 4']],
			['ID' =>11, 'ATTR' =>['FIELD'=>'HARGA_PABRIK','SIZE' => '10px','label'=>'FACTORY.PRICE','align'=>'right','warna'=>'255, 255, 48, 4']],
			['ID' =>12, 'ATTR' =>['FIELD'=>'HARGA_DIS','SIZE' => '10px','label'=>'DIST.PRICE','align'=>'right','warna'=>'255, 255, 48, 4']],
			['ID' =>13, 'ATTR' =>['FIELD'=>'HARGA_SALES','SIZE' => '10px','label'=>'SALES.PRICE','align'=>'right','warna'=>'255, 255, 48, 4']],
			/*SUPPORT DATA ID*/
			['ID' =>14, 'ATTR' =>['FIELD'=>'CUST_KD','SIZE' => '10px','label'=>'CUST.KD_ALIAS','align'=>'left','warna'=>'255, 255, 48, 4']],
			['ID' =>15, 'ATTR' =>['FIELD'=>'KD_BARANG','SIZE' => '10px','label'=>'SKU.ID.ALIAS','align'=>'left','warna'=>'255, 255, 48, 4']],
			['ID' =>16, 'ATTR' =>['FIELD'=>'KD_DIS','SIZE' => '10px','label'=>'KD_DIS','align'=>'left','warna'=>'215, 255, 48, 1']],
		];
		$valFields = ArrayHelper::map($aryField, 'ID', 'ATTR');

		return $valFields;
	}
	public function gvRows() {
		$actionClass='btn btn-info btn-xs';
		$actionLabel='Update';
		$attDinamik =[];
		foreach($this->gvHeadColomn() as $key =>$value[]){
			$attDinamik[]=[
				'attribute'=>$value[$key]['FIELD'],
				'label'=>$value[$key]['label'],
				'filter'=>true,
				'hAlign'=>'right',
				'vAlign'=>'middle',
				//'mergeHeader'=>true,
				'noWrap'=>true,
				'headerOptions'=>[
						'style'=>[
						'text-align'=>'center',
						'width'=>$value[$key]['FIELD'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(97, 211, 96, 0.3)',
						'background-color'=>'rgba('.$value[$key]['warna'].')',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>$value[$key]['align'],
						//'width'=>'12px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(13, 127, 3, 0.1)',
					]
				],
				//'pageSummaryFunc'=>GridView::F_SUM,
				//'pageSummary'=>true,
				// 'pageSummaryOptions' => [
					// 'style'=>[
							// 'text-align'=>'right',
							'width'=>'12px',
							// 'font-family'=>'tahoma',
							// 'font-size'=>'8pt',
							// 'text-decoration'=>'underline',
							// 'font-weight'=>'bold',
							// 'border-left-color'=>'transparant',
							// 'border-left'=>'0px',
					// ]
				// ],
			];
		}
		return $attDinamik;
	}












}
