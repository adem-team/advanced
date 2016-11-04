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
use ptrnov\postman4excel\Postman4ExcelBehavior;


class ImportGudangController extends Controller
{
    public function behaviors()
    {
        return [
			/*EXCEl IMPORT*/
			'export4excel' => [
				'class' => Postman4ExcelBehavior::className(),
				//'downloadPath'=>Yii::getAlias('@lukisongroup').'/cronjob/',
				//'downloadPath'=>'/var/www/backup/ExternalData/',
				'widgetType'=>'download',
			], 
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
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
			/*GRID VALIDATE*/
			'gvValidateArrayDataProvider'=>$dataProvider,
			'searchModelValidate'=>$searchModel,
			'modelFile'=>$model,
			/*List Data IMPORT*/
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
			//$fileName=Yii::$app->basePath . '/web/upload/sales_import/'.$fileData;
			$fileName='/var/www/backup/ExternalData/'.$fileData;
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
		 $DataProviderFormat= new ArrayDataProvider([
			 'key' => 'ID',
			  'allModels'=>Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_format()")->queryAll(),
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
		$excel_data = Postman4ExcelBehavior::excelDataFormat($aryDataProviderFormat);
        $excel_title = $excel_data['excel_title'];
        $excel_ceils = $excel_data['excel_ceils'];
		$excel_content = [
			 [
				'sheet_name' => 'IMPORT FORMAT STOCK',
                'sheet_title' => [
					['DATE','CUST_KD','CUST_NM','SKU_ID','SKU_NM','QTY_PCS','DIS_REF']
				],
			    'ceils' => $excel_ceils,
                //'freezePane' => 'E2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					 'TGL' => Postman4ExcelBehavior::getCssClass('header'),
                     'CUST_KD' => Postman4ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Postman4ExcelBehavior::getCssClass('header'),
                     'SKU_ID' => Postman4ExcelBehavior::getCssClass('header'),
                     'SKU_NM' => Postman4ExcelBehavior::getCssClass('header'),
                     'QTY_PCS' => Postman4ExcelBehavior::getCssClass('header'),
                     'DIS_REF' => Postman4ExcelBehavior::getCssClass('header'),
                ], //define each column's cssClass for header line only.  You can set as blank.
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
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
		$this->export4excel($excel_content, $excel_file,0);
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
		return $this->renderAjax('formAliasCustomer',[
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
		return $this->renderAjax('formAliasProdak',[
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


	
	











}
