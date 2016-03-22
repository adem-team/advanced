<?php

namespace lukisongroup\sales\controllers;

use Yii;
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
		
		
		return $this->render('index',[
			'getArryFile'=>$this->getArryFile($paramFile),
			//'dataFile'=>$this->getArryFIle(),
			'gvColumnAryFile'=>$this->gvColumnAryFile(),
			//'dataImport'=>$this->getArryImport(),
			/*GRID VALIDATE*/
			'gvValidateColumn'=>$this->gvValidateColumn(),
			'gvValidateArrayDataProvider'=>$this->gvValidateArrayDataProvider(),
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
					'pageSize' => 500,
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
			['ID' =>0, 'ATTR' =>['FIELD'=>'DIS_NM','SIZE' => '10px','label'=>'Distributor','align'=>'left']],		  
			['ID' =>1, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'Date','align'=>'left']],		  			
			['ID' =>2, 'ATTR' =>['FIELD'=>'CUST_KD','SIZE' => '20px','label'=>'Cust.Id','align'=>'left']],
			['ID' =>3, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '20px','label'=>'Customer','align'=>'left']],
			['ID' =>4, 'ATTR' =>['FIELD'=>'ITEM_ID','SIZE' => '20px','label'=>'ITEM_ID','align'=>'left']],
			['ID' =>5, 'ATTR' =>['FIELD'=>'ITEM_NM','SIZE' => '20px','label'=>'ITEM_NM','align'=>'left']],
			['ID' =>6, 'ATTR' =>['FIELD'=>'QTY_PCS','SIZE' => '20px','label'=>'QTY.PCS','align'=>'left']],
		];	
		$valFields = ArrayHelper::map($aryField, 'ID', 'ATTR'); 
			
		return $valFields;
	}
	/*GRID ARRAY DATA PROVIDER*/
	private function gvValidateArrayDataProvider(){
		$data=Yii::$app->db_esm->createCommand("CALL ESM_SALES_IMPORT_TEMP_view('STOCK','2016-01-23','O041','EF001','DIS.001')")->queryAll(); 
		$aryDataProvider= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$data,
			 'pagination' => [
				'pageSize' => 500,
			]
		]);
		
		return $aryDataProvider;  
	}
	/*GRID ROWS VALIDATE*/
	public function gvValidateColumn() {
		$attDinamik =[];
		foreach($this->gvValidateAttribute() as $key =>$value[]){
			$attDinamik[]=[		
				'attribute'=>$value[$key]['FIELD'],
				'label'=>$value[$key]['label'],
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
     * IMPORT DATA EXCEL >> LIVE
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * ====================================
     */
	public function getArryImport(){		
		$data=$this->getArryFIle();
		$spinnerVal=true;
		foreach($data as $key => $value){
			//$cmd->reset();
			$a= $value['PROVINCE_ID'];
			$b= $value['PROVINCE'];
			//$result='('."'".$a."','".$b."')";
			
			//print_r($result);
			$cmd=Yii::$app->db1->createCommand("CALL import_test('".$a."','".$b."');");
			//$cmd->execute();
			$spinnerVal=false;
		} 
		return Spinner::widget(['preset' => 'medium', 'align' => 'center', 'color' => 'blue','hidden'=>$spinnerVal]);
	}
	
}
