<?php
namespace console\controllers;

use Yii;
use zyx\phpmailer\Mailer;
use yii\base\DynamicModel;
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\web\Request;
use yii\console\Request;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;
use yii\console\Controller;			// Untuk console 
//use yii\console\Controller;		// Untuk app view 
//use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use ptrnov\postman4excel\Postman4ExcelBehavior;

use lukisongroup\marketing\models\SalesPromoSearch;

class PostmanSalesPromoController extends Controller
{
    public function behaviors()
    {
        return [
			'export4excel' => [
				'class' => Postman4ExcelBehavior::className(),
				//'downloadPath'=>Yii::getAlias('@lukisongroup').'/cronjob/',
				'downloadPath'=>'/var/www/backup/promo/',
				'widgetType'=>'CUSTOMPATH',
				'columnAutoSize'=>true,
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
	 * EXPORT EXCEL - SALES PROMO.
	 * export_data
	 * STATUS: 0=RUNNING/Current; 1=FINISH; 2=PANDING; 3=PLANING.
	*/
	public function actionExport(){	
		//Search STATUS
		$searchModelPlaning = new SalesPromoSearch(['STATUS'=>'3']);					
		$searchModelPanding = new SalesPromoSearch(['STATUS'=>'2']);					
		$searchModelFinish = new SalesPromoSearch(['STATUS'=>'1']);					
		$searchModelCurrent = new SalesPromoSearch(['STATUS'=>'0']);		
		//Data Provider.
		$dataProviderPlaning = $searchModelPlaning->searchPrint($params);
		$dataProviderPanding = $searchModelPanding->searchPrint($params);
		$dataProviderFinish = $searchModelFinish->searchPrint($params);
		$dataProviderCurrent = $searchModelCurrent->searchPrint($params);
		//Models
		$modelFieldClassPlaning=$dataProviderPlaning->getModels();
		$modelFieldClassPanding=$dataProviderPanding->getModels();
		$modelFieldClassFinish=$dataProviderFinish->getModels();
		$modelFieldClassCurrent=$dataProviderCurrent->getModels();		
		//GET- Array Field Difinition Model Class.
		$aryFieldPlaning=ArrayHelper::toArray($modelFieldClassPlaning);
		$aryFieldPanding=ArrayHelper::toArray($modelFieldClassPanding);
		$aryFieldFinish=ArrayHelper::toArray($modelFieldClassFinish);
		$aryFieldCurrent=ArrayHelper::toArray($modelFieldClassCurrent);
		
		
		//Excute - Export Excel.
		$tglIn=date("Y-m-d");
		$excel_content = [
			[
				'sheet_name' => 'PLANING-PROMO',					
				'sheet_title' => [
					['CUST_NM','STATUS','PERIODE_START','PERIODE_END','DATE_FINISH','OVERDUE','PROMO','MEKANISME','KOMPENSASI','KETERANGAN','CREATED_BY','CREATED_AT']
				],
				'ceils' =>$aryFieldPlaning,
				'freezePane' => 'A2',
				'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
				'columnGroup'=>['CUST_NM'],
				'autoSize'=>false,
				'headerStyle'=>[					
					[
						'CUST_NM' => ['font-size'=>'8','align'=>'center','width'=>'28.14','valign'=>'center','wrap'=>true],
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
						'DATE_FINISH' =>['font-size'=>'8','align'=>'center'],
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
			],
			[
				'sheet_name' => 'PANDING-PROMO',					
				'sheet_title' => [
					['CUST_NM','STATUS','PERIODE_START','PERIODE_END','DATE_FINISH','OVERDUE','PROMO','MEKANISME','KOMPENSASI','KETERANGAN','CREATED_BY','CREATED_AT']
				],
				'ceils' =>$aryFieldPanding,
				'freezePane' => 'A2',
				'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
				'columnGroup'=>['CUST_NM'],
				'autoSize'=>false,
				'headerStyle'=>[					
					[
						'CUST_NM' => ['font-size'=>'8','align'=>'center','width'=>'28.14','valign'=>'center','wrap'=>true],
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
						'DATE_FINISH' =>['font-size'=>'8','align'=>'center'],
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
			],
			[
				'sheet_name' => 'FINISH-PROMO',					
				'sheet_title' => [
					['CUST_NM','STATUS','PERIODE_START','PERIODE_END','DATE_FINISH','OVERDUE','PROMO','MEKANISME','KOMPENSASI','KETERANGAN','CREATED_BY','CREATED_AT']
				],
				'ceils' =>$aryFieldFinish,
				'freezePane' => 'A2',
				'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
				'columnGroup'=>['CUST_NM'],
				'autoSize'=>false,
				'headerStyle'=>[					
					[
						'CUST_NM' => ['font-size'=>'8','align'=>'center','width'=>'28.14','valign'=>'center','wrap'=>true],
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
						'DATE_FINISH' =>['font-size'=>'8','align'=>'center'],
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
			],
			[
				'sheet_name' => 'CURRENT-PROMO',					
				'sheet_title' => [
					['CUST_NM','STATUS','PERIODE_START','PERIODE_END','DATE_FINISH','OVERDUE','PROMO','MEKANISME','KOMPENSASI','KETERANGAN','CREATED_BY','CREATED_AT']
				],
				'ceils' =>$aryFieldCurrent,
				'freezePane' => 'A2',
				'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
				'columnGroup'=>['CUST_NM'],
				'autoSize'=>false,
				'headerStyle'=>[					
					[
						'CUST_NM' => ['font-size'=>'8','align'=>'center','width'=>'28.14','valign'=>'center','wrap'=>true],
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
						'DATE_FINISH' =>['font-size'=>'8','align'=>'center'],
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
			],			
		];
		$excel_file = "PostmanSalesPromo"."-".$tglIn;
		$this->export4excel($excel_content, $excel_file,0);  
	}
	/**
	 * SALE PROMO - SEND EMAIL.
	 * Author 	: ptr.nov@gmail.com.
	 * Event	: Weekly or Event have last week of rows data.
	 * Update	: 16/02/2017.
	 * TABEL	: 
	 * PLSQL	: 
	 * Query	: 
	 * PR		: Check remainder pengiriman seminggu sebelum habis overdue.
	*/
	/*SEND EMAIL*/
	public function  actionSend(){
		
		$searchModel = new SalesPromoSearch();					
		$dataProvider = $searchModel->searchPrint($param);
		$aryFieldSalesPromo=ArrayHelper::toArray($dataProvider->getModels());			//Set To Array to get name column.
		$arySTATUS=ArrayHelper::getColumn($aryFieldSalesPromo,'STATUS');				//Split By colomn 'STATUS'.
		$valCountStatus=array_count_values($arySTATUS);									//grouping  By colomn 'STATUS'.
			
		/*path & Name File*/
		//$rootyii=dirname(dirname(__DIR__)).'/cronjob/';
		//$rootyii='/var/www/advanced/lukisongroup/cronjob/tmp_cronjob/';
		$rootyii='/var/www/backup/promo/';
		//$folder=$rootyii.'/cronjob/'.$filename;
		//$baseRoot = Yii::getAlias('@webroot') . "/uploads/temp/";
		$tglIn=date("Y-m-d");
		$filename = 'PostmanSalesPromo'."-".$tglIn;
		//$filenameAll=$baseRoot.$filename;
		$filenameAll=$rootyii.$filename.'.xlsx';
		
		if (file_exists($filenameAll)) {
			
			/* Get Content*/
			$contentBody= $this->renderPartial('_postmanBody',['valCountStatus'=>$valCountStatus]);	
			
			/* Send Mail*/
			Yii::$app->mailer->compose()
			->setFrom(['postman@lukison.com' => 'LG-ERP-POSTMAN'])
			//->setTo(['it-dept@lukison.com'])
			//->setTo(['piter@lukison.com'])
			->setTo(['sales_esm@lukison.com','marketing_esm@lukison.com'])
			->setSubject('WEEKLY SALES PROMO')
			->setHtmlBody($contentBody)//$contentBody)
			->attach($filenameAll,[$filename,'xlsx'])
			->send(); 		
		} else {
			echo "The file $filenameAll does not exist";
		}	
	}	
}
?>