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
		$dataCust =  ArrayHelper::map(Barang::find()->orderBy('NM_BARANG')->asArray()->all(), 'KD_BARANG','NM_BARANG');
		return $dataCust;
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
		$searchModel = new TempDataSearch($user_id);
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
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
				'mode' => 'import', 
				'fileName' => $fileName, 
				'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
				'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
				'getOnlySheet' => 'Stock', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
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
			['ID' =>0, 'ATTR' =>['FIELD'=>'DATE','SIZE' => '10px','label'=>'Date','align'=>'center']],		  
			['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_KD','SIZE' => '10px','label'=>'Customer.ID','align'=>'left']],		  
			['ID' =>2, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '20px','label'=>'Customer','align'=>'left']],
			['ID' =>3, 'ATTR' =>['FIELD'=>'ITEM_ID','SIZE' => '20px','label'=>'Item.ID','align'=>'left']],
			['ID' =>4, 'ATTR' =>['FIELD'=>'ITEM_NM','SIZE' => '20px','label'=>'Name','align'=>'left']],
			['ID' =>5, 'ATTR' =>['FIELD'=>'QTY_PCS','SIZE' => '20px','label'=>'Qty_PCS','align'=>'right']],
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
			['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'Date','align'=>'left']],		  			
			['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_KD','SIZE' => '20px','label'=>'Cust.Id','align'=>'left']],
			['ID' =>2, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '20px','label'=>'Customer','align'=>'left']],
			['ID' =>3, 'ATTR' =>['FIELD'=>'ITEM_ID','SIZE' => '20px','label'=>'ITEM_ID','align'=>'left']],
			['ID' =>4, 'ATTR' =>['FIELD'=>'ITEM_NM','SIZE' => '20px','label'=>'ITEM_NM','align'=>'left']],
			['ID' =>5, 'ATTR' =>['FIELD'=>'QTY_PCS','SIZE' => '20px','label'=>'QTY.PCS','align'=>'left']],
			['ID' =>6, 'ATTR' =>['FIELD'=>'DIS_NM','SIZE' => '10px','label'=>'Distributor','align'=>'left']]
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
		$attDinamik =[];
		$attDinamik[]=[
			'class'=>'kartik\grid\ActionColumn',
			'dropdown' => true,
			'template' => '{cust}{prodak}',
			'dropdownOptions'=>['class'=>'pull-left dropdown'],
			'dropdownButton'=>['class' => 'btn btn-info btn-xs'],
			'buttons' => [
				'cust' =>function($url, $model, $key){
						return  '<li>' .Html::a('<span class="fa fa-random fa-dm"></span>'.Yii::t('app', 'Set Alias Customer'),
													['/sales/import-data/alias_cust','id'=>$model['ID']],[
													'data-toggle'=>"modal",
													'data-target'=>"#alias-cust",
													]). '</li>' . PHP_EOL;
				},				
				'prodak' =>function($url, $model, $key){
						return  '<li>' . Html::a('<span class="fa fa-retweet fa-dm"></span>'.Yii::t('app', 'Set Alias Prodak'),
													['/sales/import-data/alias_prodak','id'=>$model['ID']],[
													'data-toggle'=>"modal",
													'data-target'=>"#alias-prodak",
													]). '</li>' . PHP_EOL;
				},				
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
			$data=$this->getArryFile($id)->getModels();
			//'STOCK','2016-01-23','O041','ROBINSON MALL TATURA PALU','EF001','MAXI Cassava Crackers Hot Spicy','1','admin'
			$stt=0;
			foreach($data as $key => $value){
				
				//$cmd->reset();
				$tgl=$value['DATE'];
				$cust_kd= $value['CUST_KD'];
				$cust_nm= $value['CUST_NM'];
				$item_kd= $value['ITEM_ID'];
				$item_nm=$value['ITEM_NM'];
				$qty=$value['QTY_PCS'];
				$user_id=$username;
				//$result='('."'".$a."','".$b."')";
				
				/*DELETE TEMPORARY FIRST EXECUTE*/
				if ($stt==0){
					$cmd1=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_TEMP_create(
									'STOCK_DELETE','','','','','','','".$user_id."'					
								);				
						");
					$cmd1->execute();					
				};
				//print_r($result);
				$cmd=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_TEMP_create(
								'STOCK','".$tgl."','".$cust_kd."','".$cust_nm."','".$item_kd."','".$item_nm."','".$qty."','".$user_id."'					
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
									'STOCK_DELETE','','','','','','','".$username."'					
								);				
						");
				$cmd_clear->execute();		
			
			return true;
		}
		
	}
	
	/**====================================
     * Action SEND DATA TO STORED
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.2
	 * ====================================
     */
	public function actionSend_temp_validation(){
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$user_id=$request->post('id');
			
			$username=  Yii::$app->user->identity->username;
			
				/*SEND STORED FROM TMP-> EXECUTE*/
				$cmd_send=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_TEMP_create(
									'STOCK_DELETE','','','','','','','".$username."'					
								);				
						");
				$cmd_send->execute();		
			
			return true;
		}
		
	}
	
	/**====================================
     * Action Set Alias Customer
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.2
	 * ====================================
     */
	public function actionAlias_cust($id){
		$aliasCustomer = new AliasCustomer();
		$tempDataImport = TempData::find()->where(['ID' =>$id])->one();
		return $this->renderAjax('alias_customer',[
			'aliasCodeCustomer'=>$aliasCustomer,
			'tempDataImport'=>$tempDataImport,
			'aryCustID'=>$this->aryCustID(),
			'test'=>Yii::$app->request->referrer
		]);
	}
	public function actionAlias_cust_save(){
		$aliasCustomer = new AliasCustomer;
		/*Ajax Load*/
		if(Yii::$app->request->isAjax){
			$aliasCustomer->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($aliasCustomer));
		}else{	/*Normal Load*/
			if($aliasCustomer->load(Yii::$app->request->post())){
			   //$aliasCustomer->alias_customer_save();
				if ($aliasCustomer->alias_customer_save()){
					//$hsl = \Yii::$app->request->post();
					// $kdpo = $hsl['AliasCustomer']['kdpo'];
					// $this->Sendmail2($kdpo);
					 //$paramFile=Yii::$app->getRequest()->getQueryParam('id');
					 $paramFile=Yii::$app->request->referrer;
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
		$aliasProdak = new AliasProdak();
		$tempDataImport = TempData::find()->where(['ID' =>$id])->one();
		return $this->renderAjax('alias_prodak',[
			'aliasCodeProdak'=>$aliasProdak,
			'tempDataImport'=>$tempDataImport,
			'aryBrgID'=>$this->aryBrgID()
		]);
	}
	public function actionAlias_prodakSave(){
		
	}
	
}
