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
use yii\bootstrap\Modal;
use \moonland\phpexcel\Excel;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\Response;

use lukisongroup\sales\models\UserFileGudang;
use lukisongroup\sales\models\UserFileGudangSearch;
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
		$username=  Yii::$app->user->identity->username;
		$user_id=['USER_ID'=>$username];
		$paramFile=Yii::$app->getRequest()->getQueryParam('id');
		if ($paramFile){
			$errorModal=self::setDataImport($paramFile);
			$data_view=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_TEMP_view('STOCK','".$username."')")->queryAll();
			//print_r($data_view);
			//die();
			if($errorModal==1){
				$js='$("#error-msg-stockgudang").modal("show")';
				$this->getView()->registerJs($js);
			}elseif(!$data_view){
				$js='$("#nodata-msg-stockgudang").modal("show")';
				$this->getView()->registerJs($js);
			}
		}else{			
			//DELETE STOCK GUDANG | SO_TYPE=1
			$cmd_clear=Yii::$app->db_esm->createCommand("
					DELETE FROM so_t2_tmp_file WHERE USER_ID='".$username."'  AND SO_TYPE=1;
			");
			$cmd_clear->execute();
		};
		
		//echo $paramCari;
		$model = new UserFileGudang();

		
		/*IMPORT VALIDATION*/
		$searchModel = new TempDataSearch($user_id);
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		/*VIEW IMPORT*/
		$searchModelViewImport = new ImportViewSearch();
		$dataProviderViewImport = $searchModelViewImport->searchViewLatesGudang(Yii::$app->request->queryParams);
		$dataProviderAllDataImport = $searchModelViewImport->searchViewHistoryGudang(Yii::$app->request->queryParams);
		//echo $this->actionExport_format();
		//print_r($dataProvider->getModels());
		return $this->render('index',[
			/*VIEW ARRAY FILE*/
			'getArryFile'=>$dataProvider,//self::setDataImport($paramFile),//$this->getArryFile($paramFile),
			'fileName'=>$paramFile,
			/*GRID VALIDATE*/
			'gvValidateArrayDataProvider'=>$dataProvider,
			'searchModelValidate'=>$searchModel,
			'modelFile'=>$model,
			/*Latest Dadta IMPORT*/
			'searchModelViewImport'=>$searchModelViewImport,
			'dataProviderViewImport'=>$dataProviderViewImport,
			/*Latest Dadta IMPORT*/
			'searchModelViewImport'=>$searchModelViewImport,
			'dataProviderAllDataImport'=>$dataProviderAllDataImport,
			'errorModal'=>$errorModal
		]);
    }

     /**
     * UPLOAD FILE 
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
     */
	public function actionUpload(){
		$model = new UserFileGudang();
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

	/**
	 * PREPARE BEFORE SEND
	 * GET DATA FROM ArrayFile set to Temp Data.
	 * TYPE : STOCK-GUDANG=1
	*/
	private function setDataImport($paramFile){
		$data=$this->getArryFile($paramFile)->getModels();
		$username=  Yii::$app->user->identity->username;
		
		//Validate Import Bukan STOCK-GUDANG
		$intCheck=0;
		$validateStockGudang=0;
		foreach($data as $key => $value){
			$nilai=$value['STATUS']=='stock-gudang'?1:0;
			$validateStockGudang=$validateStockGudang +$nilai ;
			$intCheck=$intCheck+1;
		}
		
		//print_r ($validateStockGudang);
		//die();
		if ($validateStockGudang==$intCheck){
			$stt=0;
			// print_r($data);
			// die();
			foreach($data as $key => $value){

				//$cmd->reset();
				$tgl=$value['DATE'];
				$cust_kd= $value['CUST_KD'];
				$cust_nm= $value['CUST_NM'];
				$item_kd= $value['SKU_ID'];
				$item_nm=$value['SKU_NM'];
				$qty=$value['QTY_PCS'];
				$price=$value['PRICE_PCS'];
				$dis_ref=$value['DIS_REF'];
				$user_id=$username;
				//$result='('."'".$a."','".$b."')";

				/*DELETE TEMPORARY FIRST EXECUTE*/
				if ($stt==0){
					$cmd1=Yii::$app->db_esm->createCommand("
							#CALL ESM_SALES_IMPORT_TEMP_create('STOCK_DELETE','','','','','','','','','".$user_id."');
							DELETE FROM so_t2_tmp_file WHERE USER_ID='".$username."'  AND SO_TYPE=1;
						");
					$cmd1->execute();
				};
				//print_r($result);
				$cmd=Yii::$app->db_esm->createCommand("
					CALL ESM_SALES_IMPORT_TEMP_create(
						'STOCK_GUDANG','".$tgl."','','','".$item_kd."','".$item_nm."','".$qty."','".$price."','".$dis_ref."','".$pos."','".$user_id."'
					);
				");
				$cmd->execute();
				//$spinnerVal=false;
				$stt=$stt+1;
			}
			return 0;
		}else{
			return 1;
		}
		
	}

	/**=====================================
     * GET ARRAY FROM FILE
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * =====================================
     */
	public function getArryFile($paramFile){
		
			$pathDefault='/var/www/backup/ExternalData/default_format/';
			$pathImport='/var/www/backup/ExternalData/import_gudang/';
			$fileData=$paramFile!=''?$pathImport.$paramFile:$pathDefault.'default_import_gudang.xlsx';
			//$fileName='/var/www/backup/ExternalData/import_gudang/'.$fileData;
			$config='';
			//$data = \moonland\phpexcel\Excel::import($fileName, $config);

			$data = \moonland\phpexcel\Excel::widget([
				'id'=>'export-gudang',
				'mode' => 'import',
				'fileName' => $fileData,
				'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
				'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
				'getOnlySheet' => 'STOCK-GUDANG', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
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
     * EXPORT FORMAT
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.2
	 * ====================================
     */
	public function actionExport_format(){
		 $DataProviderFormat= new ArrayDataProvider([
			 'key' => 'ID',
			  'allModels'=>Yii::$app->db_esm->createCommand("
					#CALL ESM_SALES_IMPORT_format()
					#SELECT DATE,CUST_KD,CUST_NM,SKU_ID,SKU_NM,QTY_PCS,DIS_REF,STATUS FROM so_t2_format WHERE STATUS='stock-gudang';
					SELECT DATE,SKU_ID,SKU_NM,QTY_PCS,HARGA_PCS,DIS_REF,STATUS FROM so_t2_format WHERE STATUS='stock-gudang';
			  ")->queryAll(),
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
				'sheet_name' => 'STOCK-GUDANG',
                'sheet_title' => [
					//['DATE','CUST_KD','CUST_NM','SKU_ID','SKU_NM','QTY_PCS','DIS_REF','STATUS']
					['DATE','SKU_ID','SKU_NM','QTY_PCS','PRICE_PCS','DIS_REF','STATUS']
				],
			    'ceils' => $excel_ceils,
                'freezePane' => 'A2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
                'headerStyle'=>[					
					[
						'DATE' =>['align'=>'center'],
						//'CUST_KD' =>['align'=>'center'],
						//'CUST_NM' => ['align'=>'center'],
						'SKU_ID' => ['align'=>'center'],
						'SKU_NM' => ['align'=>'center'],
						'QTY_PCS' =>['align'=>'center'],
						'PRICE_PCS' => ['align'=>'center'],
						'DIS_REF' => ['align'=>'center'],
						'STATUS' => ['align'=>'center']
					]
						
				],
				'contentStyle'=>[
					[						
						'DATE' =>['align'=>'center'],
						//'CUST_KD' =>['align'=>'left'],
						//'CUST_NM' => ['align'=>'left'],
						'SKU_ID' => ['align'=>'left'],
						'SKU_NM' => ['align'=>'left'],
						'QTY_PCS' =>['align'=>'right'],
						'PRICE_PCS' => ['align'=>'right'],
						'DIS_REF' => ['align'=>'left'],
						'STATUS' => ['align'=>'center','color-font'=>'ee4343']
					]
				],
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'CATATAN',
                'sheet_title' => ["CATATAN IMPORT DATA STOCK GUDANG"],
                'ceils' => [
					["1.Pastikan format sesuai dengan yang sudah di download."],
                    ["2.Format yang tidak boleh di ganti:"],
                    ["  A. NAMA SHEET1: STOCK-GUDANG "],
					["  B. NAMA HEADER COLUMN : DATE,SKU_ID,SKU_NM,QTY_PCS,DIS_REF"],
					["3.Refrensi."],
					["  'Sheet1 adalah data yang akan di import,sedangkan Sheet2 hanya berupa catatan format"],
					["  'DATE'= Tanggal dari data stok yang akan di import "],
					["  'SKU_ID'=  Kode dari Prodak Item ESM, tambahkan/edit jika kode alias customer berlum ada, sesuaikan dengan kode customer pada distributor "],
					["  'SKU_NM'=  Nama dari Prodak Item"],
					["  'QTY_PCS'= Quantity dalam unit PCS "],
					["  'PRICE'= harga per PCS "],
					["  'DIS_REF'= Kode dari pendistribusian, contoh pendistribusian ke Distributor, Subdisk, Agen dan lain-lain"],
					["4.Refrensi Kode."],
					["  'DIS.001'= PT. Cahaya Inti Putra Sejahtera"],
					["  'stock-gudang'= Import data Gudang"],					
				],
			],

		];
		$excel_file = "ImportFormat-StockGudang";
		$this->export4excel($excel_content, $excel_file,0);
	}
	
	/**====================================
     * Action SEND DATA TO STORED LIVE
     * TYPE : STOCK-GUDANG=1
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.2
	 * ====================================
     */
	public function actionSendFix(){
		$username=  Yii::$app->user->identity->username;
		$data_view=Yii::$app->db_esm->createCommand("
			#CALL ESM_SALES_IMPORT_TEMP_view('STOCK','".$username."')
			SELECT ID,TGL,ITEM_ID_ALIAS,ITEM_NM,QTY_PCS,HARGA_PCS,QTY_UNIT,DIS_REF,DIS_REF_NM,SO_TYPE,POS,USER_ID
			FROM so_t2_tmp_file			
			WHERE USER_ID='".$username."' AND SO_TYPE=1
		")->queryAll();
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		if (Yii::$app->request->isAjax && $data_view) {			
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
				
				//Validation column
				$sttValidationColumn=0;
				foreach($dataImport as $key => $value){
					if($value['TGL']=='NotSet' or $value['ITEM_ID_ALIAS']=='NotSet' or $value['ITEM_NM']=='NotSet' or $value['QTY_PCS']=='NotSet' or $value['DIS_REF']=='NotSet' or $value['HARGA_PCS']=='' ){
						$sttValidationColumn=1;
					}
				}
				//print_r($sttValidationColumn);
				//die();
				if($sttValidationColumn!=1){
					foreach($dataImport as $key => $value){
						//$cmd->reset();
						$tgl=$value['TGL'];
						$cust_kd= $value['CUST_KD_ALIAS'];
						$item_kd= $value['ITEM_ID_ALIAS'];
						$item_qty= $value['QTY_PCS'];
						$item_price= $value['HARGA_PCS'];
						$dis_id= $value['DIS_REF'];
						$import_live=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_LIVE_create(
											'STOCKG_GUDANG','".$tgl."','".$cust_kd."','".$item_kd."','".$item_qty."','".$item_price."','WEB_IMPORT','".$dis_id."','".$username."'
										)");
						$import_live->execute();
						//$stt=1;
					}
					/*Delete After Import*/
					/* $cmd_del=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_TEMP_create(
											'STOCK_DELETE','','','','','','','','','".$username."'
										);
								");
					$cmd_del->execute(); */
					$rslt='sukses';
				}else{
					$rslt='validasi';
				}
				//return true;
		}else{
			//return $this->redirect(['index']);
			//return false;
			$rslt='nodata';
		}
		//return $this->redirect(['index']);
		return $rslt;
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
	
	/**====================================
     * EXPORT DATA GUDANG
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.2
	 * ====================================
     */
	public function actionExport_datagudang(){
		$searchModelViewImport = new ImportViewSearch();
		$dataProvidergudang= $searchModelViewImport->searchViewHistoryGudang(Yii::$app->request->queryParams);
		$dataProviderAllDataImport= new ArrayDataProvider([
			  'allModels'=>$dataProvidergudang->getModels(),
			   'pagination' => [
				 'pageSize' => 10,
			 ]
		 ]);
		 //$modelDataExport=$dataProviderAllDataImport->allModels;
		print_r($dataProviderAllDataImport);
		
	}
	
}
