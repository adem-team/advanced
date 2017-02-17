<?php
namespace console\controllers;

use Yii;
use zyx\phpmailer\Mailer;
use yii\base\DynamicModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Request;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;
use yii\console\Controller;			// Untuk console 
//use yii\console\Controller;		// Untuk app view 
//use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use ptrnov\postman4excel\Postman4ExcelBehavior;

class PostmanCustomerController extends Controller
{
    public function behaviors()
    {
        return [
			'export4excel' => [
				'class' => Postman4ExcelBehavior::className(),
				//'downloadPath'=>Yii::getAlias('@lukisongroup').'/cronjob/',
				'downloadPath'=>'/var/www/backup/customer/',
				'widgetType'=>'CUSTOMPATH',
			], 
			'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ]
        ];
    }

	// public function actions()
    // {
        // return [           
            // 'download' => [
                // 'class' => 'scotthuangzl\export2excel\DownloadAction',
            // ],
        // ];
    // } 
	
	// public function actionIndex(){
		// return $this->render('index');
	// }
	/*
	 * EXPORT DATA CUSTOMER TO EXCEL
	 * export_data
	*/
	public function actionExport(){	
		/* DELETED CUSTOMER */
		$cusDelDataProvider= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT a.UPDATED_BY AS DELETE_BY,a.UPDATED_AT AS DELETE_AT,a.CUST_KD,
						(CASE WHEN g.KD_ALIAS!='' THEN g.KD_ALIAS ELSE 'Kosong' END) as DIST_ID,
						a.CUST_NM,
						(CASE WHEN b.CUST_KTG_NM!='' THEN b.CUST_KTG_NM ELSE 'Kosong' END) as TYPE_NM,		
						(CASE WHEN f.LAYER_NM!='' THEN f.LAYER_NM ELSE 'Kosong' END) as LAYER_GRADE,
						(CASE WHEN e.GEO_NM!='' THEN CONCAT(e.GEO_NM,'-',e.GEO_DCRIP) ELSE 'Kosong' END) as GEO_MAINTAIN,
						(CASE WHEN a.ALAMAT!='' THEN a.ALAMAT ELSE 'Kosong' END) as ALAMAT,
						(CASE WHEN c.PROVINCE!='' THEN c.PROVINCE ELSE 'Kosong' END) as PROVINCE,
						(CASE WHEN d.CITY_NAME!='' THEN  d.CITY_NAME ELSE 'Kosong' END) as CITY_NAME,
						(CASE WHEN d.POSTAL_CODE!='' THEN  d.POSTAL_CODE ELSE 'Kosong' END) as POSTAL_CODE,
						(CASE WHEN a.TLP1!='' THEN  a.TLP1 ELSE 'Kosong' END) as PHONE,
						(CASE WHEN a.PIC!='' THEN a.PIC ELSE 'Kosong' END) as CP
				FROM c0001 a LEFT JOIN c0001k b ON b.CUST_KTG=a.CUST_TYPE
				LEFT JOIN c0001g1 c on c.PROVINCE_ID=a.PROVINCE_ID
				LEFT JOIN c0001g2 d on  d.CITY_ID=a.CITY_ID
				LEFT JOIN c0002scdl_geo e on e.GEO_ID=a.GEO
				LEFT JOIN c0002scdl_layer f on f.LAYER_ID=a.LAYER
				LEFT JOIN c0002 g ON g.KD_CUSTOMERS=a.CUST_KD
				WHERE a.STATUS=3 AND (a.UPDATED_AT BETWEEN DATE_SUB(CURRENT_DATE(),INTERVAL 7 day) AND CURRENT_DATE())
				ORDER BY a.UPDATED_AT DESC	
			")->queryAll(), 
		]);	
		$aryCusDelDataProvider=$cusDelDataProvider->allModels;	
		
		
		/* UPDATE CUSTOMER */
		$cusEditDataProvider= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT a.UPDATED_BY AS UPDATE_BY,a.UPDATED_AT AS UPDATE_AT,a.CUST_KD,
						(CASE WHEN g.KD_ALIAS!='' THEN g.KD_ALIAS ELSE 'Kosong' END) as DIST_ID,
						a.CUST_NM,
						(CASE WHEN b.CUST_KTG_NM!='' THEN b.CUST_KTG_NM ELSE 'Kosong' END) as TYPE_NM,		
						(CASE WHEN f.LAYER_NM!='' THEN f.LAYER_NM ELSE 'Kosong' END) as LAYER_GRADE,
						(CASE WHEN e.GEO_NM!='' THEN CONCAT(e.GEO_NM,'-',e.GEO_DCRIP) ELSE 'Kosong' END) as GEO_MAINTAIN,
						(CASE WHEN a.ALAMAT!='' THEN a.ALAMAT ELSE 'Kosong' END) as ALAMAT,
						(CASE WHEN c.PROVINCE!='' THEN c.PROVINCE ELSE 'Kosong' END) as PROVINCE,
						(CASE WHEN d.CITY_NAME!='' THEN  d.CITY_NAME ELSE 'Kosong' END) as CITY_NAME,
						(CASE WHEN d.POSTAL_CODE!='' THEN  d.POSTAL_CODE ELSE 'Kosong' END) as POSTAL_CODE,
						(CASE WHEN a.TLP1!='' THEN  a.TLP1 ELSE 'Kosong' END) as PHONE,
						(CASE WHEN a.PIC!='' THEN a.PIC ELSE 'Kosong' END) as CP
				FROM c0001 a LEFT JOIN c0001k b ON b.CUST_KTG=a.CUST_TYPE
				LEFT JOIN c0001g1 c on c.PROVINCE_ID=a.PROVINCE_ID
				LEFT JOIN c0001g2 d on  d.CITY_ID=a.CITY_ID
				LEFT JOIN c0002scdl_geo e on e.GEO_ID=a.GEO
				LEFT JOIN c0002scdl_layer f on f.LAYER_ID=a.LAYER
				LEFT JOIN c0002 g ON g.KD_CUSTOMERS=a.CUST_KD
				WHERE a.STATUS<>3 AND (a.UPDATED_AT BETWEEN DATE_SUB(CURRENT_DATE(),INTERVAL 7 day) AND CURRENT_DATE())
				ORDER BY a.UPDATED_AT DESC	
			")->queryAll(), 
		]);	
		$aryCusEditDataProvider=$cusEditDataProvider->allModels;
		
		/* NEW CUSTOMER */
		$cusNewDataProvider= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT a.CREATED_BY AS CREATE_BY,a.CREATED_AT AS CREATE_AT,a.CUST_KD,
						(CASE WHEN g.KD_ALIAS!='' THEN g.KD_ALIAS ELSE 'Kosong' END) as DIST_ID,
						a.CUST_NM,
						(CASE WHEN b.CUST_KTG_NM!='' THEN b.CUST_KTG_NM ELSE 'Kosong' END) as TYPE_NM,		
						(CASE WHEN f.LAYER_NM!='' THEN f.LAYER_NM ELSE 'Kosong' END) as LAYER_GRADE,
						(CASE WHEN e.GEO_NM!='' THEN CONCAT(e.GEO_NM,'-',e.GEO_DCRIP) ELSE 'Kosong' END) as GEO_MAINTAIN,
						(CASE WHEN a.ALAMAT!='' THEN a.ALAMAT ELSE 'Kosong' END) as ALAMAT,
						(CASE WHEN c.PROVINCE!='' THEN c.PROVINCE ELSE 'Kosong' END) as PROVINCE,
						(CASE WHEN d.CITY_NAME!='' THEN  d.CITY_NAME ELSE 'Kosong' END) as CITY_NAME,
						(CASE WHEN d.POSTAL_CODE!='' THEN  d.POSTAL_CODE ELSE 'Kosong' END) as POSTAL_CODE,
						(CASE WHEN a.TLP1!='' THEN  a.TLP1 ELSE 'Kosong' END) as PHONE,
						(CASE WHEN a.PIC!='' THEN a.PIC ELSE 'Kosong' END) as CP
				FROM c0001 a LEFT JOIN c0001k b ON b.CUST_KTG=a.CUST_TYPE
				LEFT JOIN c0001g1 c on c.PROVINCE_ID=a.PROVINCE_ID
				LEFT JOIN c0001g2 d on  d.CITY_ID=a.CITY_ID
				LEFT JOIN c0002scdl_geo e on e.GEO_ID=a.GEO
				LEFT JOIN c0002scdl_layer f on f.LAYER_ID=a.LAYER
				LEFT JOIN c0002 g ON g.KD_CUSTOMERS=a.CUST_KD
				WHERE a.STATUS<>3 AND (a.CREATED_AT BETWEEN DATE_SUB(CURRENT_DATE(),INTERVAL 7 day) AND CURRENT_DATE())
				ORDER BY a.CREATED_AT DESC	
			")->queryAll(), 
		]);	
		$aryCusNewDataProvider=$cusNewDataProvider->allModels;
		
		
		/* ALL CUSTOMER */
		$cusAllDataProvider= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT a.CUST_KD as CUST_ID,
						(CASE WHEN g.KD_ALIAS!='' THEN g.KD_ALIAS ELSE 'Kosong' END) as DIST_ID,
						a.CUST_NM,
						(CASE WHEN b.CUST_KTG_NM!='' THEN b.CUST_KTG_NM ELSE 'Kosong' END) as TYPE_NM,		
						(CASE WHEN f.LAYER_NM!='' THEN f.LAYER_NM ELSE 'Kosong' END) as LAYER_GRADE,
						(CASE WHEN e.GEO_NM!='' THEN CONCAT(e.GEO_NM,'-',e.GEO_DCRIP) ELSE 'Kosong' END) as GEO_MAINTAIN,
						(CASE WHEN a.ALAMAT!='' THEN a.ALAMAT ELSE 'Kosong' END) as ALAMAT,
						(CASE WHEN c.PROVINCE!='' THEN c.PROVINCE ELSE 'Kosong' END) as PROVINCE,
						(CASE WHEN d.CITY_NAME!='' THEN  d.CITY_NAME ELSE 'Kosong' END) as CITY_NAME,
						(CASE WHEN d.POSTAL_CODE!='' THEN  d.POSTAL_CODE ELSE 'Kosong' END) as POSTAL_CODE,
						(CASE WHEN a.TLP1!='' THEN  a.TLP1 ELSE 'Kosong' END) as PHONE,
						(CASE WHEN a.PIC!='' THEN a.PIC ELSE 'Kosong' END) as CP
				FROM c0001 a LEFT JOIN c0001k b ON b.CUST_KTG=a.CUST_TYPE
				LEFT JOIN c0001g1 c on c.PROVINCE_ID=a.PROVINCE_ID
				LEFT JOIN c0001g2 d on  d.CITY_ID=a.CITY_ID
				LEFT JOIN c0002scdl_geo e on e.GEO_ID=a.GEO
				LEFT JOIN c0002scdl_layer f on f.LAYER_ID=a.LAYER
				LEFT JOIN c0002 g ON g.KD_CUSTOMERS=a.CUST_KD
				WHERE a.STATUS<>3
				ORDER BY a.CUST_NM ASC		
			")->queryAll(), 
		]);	
		$aryCusAllDataProvider=$cusAllDataProvider->allModels;
		
		/* 22=NKA*/
		$cusDataProviderNKA= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT a.CUST_KD,
						(CASE WHEN g.KD_ALIAS!='' THEN g.KD_ALIAS ELSE 'Kosong' END) as DIST_ID,
						a.CUST_NM,
						(CASE WHEN b.CUST_KTG_NM!='' THEN b.CUST_KTG_NM ELSE 'Kosong' END) as TYPE_NM,		
						(CASE WHEN f.LAYER_NM!='' THEN f.LAYER_NM ELSE 'Kosong' END) as LAYER_GRADE,
						(CASE WHEN e.GEO_NM!='' THEN CONCAT(e.GEO_NM,'-',e.GEO_DCRIP) ELSE 'Kosong' END) as GEO_MAINTAIN,
						(CASE WHEN a.ALAMAT!='' THEN a.ALAMAT ELSE 'Kosong' END) as ALAMAT,
						(CASE WHEN c.PROVINCE!='' THEN c.PROVINCE ELSE 'Kosong' END) as PROVINCE,
						(CASE WHEN d.CITY_NAME!='' THEN  d.CITY_NAME ELSE 'Kosong' END) as CITY_NAME,
						(CASE WHEN d.POSTAL_CODE!='' THEN  d.POSTAL_CODE ELSE 'Kosong' END) as POSTAL_CODE,
						(CASE WHEN a.TLP1!='' THEN  a.TLP1 ELSE 'Kosong' END) as PHONE,
						(CASE WHEN a.PIC!='' THEN a.PIC ELSE 'Kosong' END) as CP
				FROM c0001 a LEFT JOIN c0001k b ON b.CUST_KTG=a.CUST_TYPE
				LEFT JOIN c0001g1 c on c.PROVINCE_ID=a.PROVINCE_ID
				LEFT JOIN c0001g2 d on  d.CITY_ID=a.CITY_ID
				LEFT JOIN c0002scdl_geo e on e.GEO_ID=a.GEO
				LEFT JOIN c0002scdl_layer f on f.LAYER_ID=a.LAYER
				LEFT JOIN c0002 g ON g.KD_CUSTOMERS=a.CUST_KD
				WHERE a.STATUS<>3 AND a.CUST_KTG='1' AND a.CUST_TYPE='22' #AND CUST_KD<>CUST_GRP
				ORDER BY a.CUST_NM ASC		
			")->queryAll(), 
		]);	
		$aryCusDataProviderNKA=$cusDataProviderNKA->allModels;
		
		/*15=MTI*/
		$cusDataProviderMTI= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>Yii::$app->db_esm->createCommand("
				SELECT a.CUST_KD,
						(CASE WHEN g.KD_ALIAS!='' THEN g.KD_ALIAS ELSE 'Kosong' END) as DIST_ID,
						a.CUST_NM,
						(CASE WHEN b.CUST_KTG_NM!='' THEN b.CUST_KTG_NM ELSE 'Kosong' END) as TYPE_NM,		
						(CASE WHEN f.LAYER_NM!='' THEN f.LAYER_NM ELSE 'Kosong' END) as LAYER_GRADE,
						(CASE WHEN e.GEO_NM!='' THEN CONCAT(e.GEO_NM,'-',e.GEO_DCRIP) ELSE 'Kosong' END) as GEO_MAINTAIN,
						(CASE WHEN a.ALAMAT!='' THEN a.ALAMAT ELSE 'Kosong' END) as ALAMAT,
						(CASE WHEN c.PROVINCE!='' THEN c.PROVINCE ELSE 'Kosong' END) as PROVINCE,
						(CASE WHEN d.CITY_NAME!='' THEN  d.CITY_NAME ELSE 'Kosong' END) as CITY_NAME,
						(CASE WHEN d.POSTAL_CODE!='' THEN  d.POSTAL_CODE ELSE 'Kosong' END) as POSTAL_CODE,
						(CASE WHEN a.TLP1!='' THEN  a.TLP1 ELSE 'Kosong' END) as PHONE,
						(CASE WHEN a.PIC!='' THEN a.PIC ELSE 'Kosong' END) as CP
				FROM c0001 a LEFT JOIN c0001k b ON b.CUST_KTG=a.CUST_TYPE
				LEFT JOIN c0001g1 c on c.PROVINCE_ID=a.PROVINCE_ID
				LEFT JOIN c0001g2 d on  d.CITY_ID=a.CITY_ID
				LEFT JOIN c0002scdl_geo e on e.GEO_ID=a.GEO
				LEFT JOIN c0002scdl_layer f on f.LAYER_ID=a.LAYER
				LEFT JOIN c0002 g ON g.KD_CUSTOMERS=a.CUST_KD
				WHERE  a.STATUS <>3 AND a.CUST_KTG='1' AND a.CUST_TYPE='15' #AND CUST_KD<>CUST_GRP
				ORDER BY a.CUST_NM ASC					
			")->queryAll(),
		]);			
		$aryCusDataProviderMTI=$cusDataProviderMTI->allModels;
		
		/*OTHERS*/		
		$cusDataProvideOTHER= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>Yii::$app->db_esm->createCommand("
				SELECT a.CUST_KD,
						(CASE WHEN g.KD_ALIAS!='' THEN g.KD_ALIAS ELSE 'Kosong' END) as DIST_ID,
						a.CUST_NM,
						(CASE WHEN b.CUST_KTG_NM!='' THEN b.CUST_KTG_NM ELSE 'Kosong' END) as TYPE_NM,		
						(CASE WHEN f.LAYER_NM!='' THEN f.LAYER_NM ELSE 'Kosong' END) as LAYER_GRADE,
						(CASE WHEN e.GEO_NM!='' THEN CONCAT(e.GEO_NM,'-',e.GEO_DCRIP) ELSE 'Kosong' END) as GEO_MAINTAIN,
						(CASE WHEN a.ALAMAT!='' THEN a.ALAMAT ELSE 'Kosong' END) as ALAMAT,
						(CASE WHEN c.PROVINCE!='' THEN c.PROVINCE ELSE 'Kosong' END) as PROVINCE,
						(CASE WHEN d.CITY_NAME!='' THEN  d.CITY_NAME ELSE 'Kosong' END) as CITY_NAME,
						(CASE WHEN d.POSTAL_CODE!='' THEN  d.POSTAL_CODE ELSE 'Kosong' END) as POSTAL_CODE,
						(CASE WHEN a.TLP1!='' THEN  a.TLP1 ELSE 'Kosong' END) as PHONE,
						(CASE WHEN a.PIC!='' THEN a.PIC ELSE 'Kosong' END) as CP
				FROM c0001 a LEFT JOIN c0001k b ON b.CUST_KTG=a.CUST_TYPE
				LEFT JOIN c0001g1 c on c.PROVINCE_ID=a.PROVINCE_ID
				LEFT JOIN c0001g2 d on  d.CITY_ID=a.CITY_ID
				LEFT JOIN c0002scdl_geo e on e.GEO_ID=a.GEO
				LEFT JOIN c0002scdl_layer f on f.LAYER_ID=a.LAYER
				LEFT JOIN c0002 g ON g.KD_CUSTOMERS=a.CUST_KD
				WHERE a.STATUS <>3 AND a.CUST_TYPE not in ('15','22') 
				ORDER BY a.CUST_NM ASC	
			")->queryAll(),
		]);			
		$aryCusDataProviderOTHER=$cusDataProvideOTHER->allModels;
		
		/*SOURCE ALL CUSTOMER*/
		$excel_dataAll = Postman4ExcelBehavior::excelDataFormat($aryCusAllDataProvider);
		//$excel_title = $excel_dataNKA['excel_title'];
		$excel_ceilsAll = $excel_dataAll['excel_ceils'];
		
		/*SOURCE NKA  CUSTOMER*/
		$excel_dataNKA = Postman4ExcelBehavior::excelDataFormat($aryCusDataProviderNKA);
		//$excel_title = $excel_dataNKA['excel_title'];
		$excel_ceilsNKA = $excel_dataNKA['excel_ceils'];
		
		/*SOURCE MTI  CUSTOMER*/
		$excel_dataMTI = Postman4ExcelBehavior::excelDataFormat($aryCusDataProviderMTI);      
        $excel_ceilsMTI = $excel_dataMTI['excel_ceils'];
		
		/*SOURCE UNKNOWN  CUSTOMER*/
		$excel_dataOTHER= Postman4ExcelBehavior::excelDataFormat($aryCusDataProviderOTHER);      
        $excel_ceilsOTHER = $excel_dataOTHER['excel_ceils'];
		
		/*SOURCE DELETE  CUSTOMER*/
		$excel_dataDEL= Postman4ExcelBehavior::excelDataFormat($aryCusDelDataProvider);      
        $excel_ceilsDEL = $excel_dataDEL['excel_ceils'];
		
		/*SOURCE UPDATE  CUSTOMER*/
		$excel_dataEDIT= Postman4ExcelBehavior::excelDataFormat($aryCusEditDataProvider);      
        $excel_ceilsEDIT = $excel_dataEDIT['excel_ceils'];
		
		/*SOURCE NEW  CUSTOMER*/
		$excel_dataNEW= Postman4ExcelBehavior::excelDataFormat($aryCusNewDataProvider);      
        $excel_ceilsNEW = $excel_dataNEW['excel_ceils'];		
		
		$excel_content = [
			[
				'sheet_name' => 'ALL CUSTOMER',
                'sheet_title' => [
					['CUST_ID','DIST_ID','CUST_NM','TYPE','LAYER','GEO.MAINTAIN','ALAMAT','PROVINSI','KOTA','KODE.POS','PHONE','CONTACT.PERSON'],
				],
			    'ceils' => $aryCusAllDataProvider,//excel_ceilsAll,
                'freezePane' => 'A2',
				'columnGroup'=>['CUST_ID'],
				'autoSize'=>false,
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
				'headerStyle'=>[					
					[
						'CUST_ID' =>['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'DIST_ID' =>['font-size'=>'8','width'=>'10','valign'=>'center','align'=>'center'],
						'CUST_NM' => ['font-size'=>'8','width'=>'28','valign'=>'center','align'=>'center','wrap'=>true],
						'TYPE' => ['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'LAYER' => ['font-size'=>'8','width'=>'6','valign'=>'center','align'=>'center'],
						'GEO.MAINTAIN' =>['font-size'=>'8','width'=>'25','valign'=>'center','align'=>'center'],
						'ALAMAT' => ['font-size'=>'8','width'=>'60','valign'=>'center','align'=>'center','wrap'=>true],
						'PROVINSI' => ['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'], 
						'KOTA' => ['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'],
						'KODE.POS' => ['font-size'=>'8','width'=>'7','valign'=>'center','align'=>'center'],
						'PHONE' => ['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'CONTACT.PERSON' => ['font-size'=>'8','width'=>'16','valign'=>'center','align'=>'center']
					]
						
				],
				'contentStyle'=>[
					[						
						'CUST_ID' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'DIST_ID' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'CUST_NM' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'TYPE' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'LAYER' => ['font-size'=>'8','valign'=>'center','align'=>'center'],
						'GEO.MAINTAIN' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'ALAMAT' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'PROVINSI' => ['font-size'=>'8','valign'=>'center','align'=>'left'], 
						'KOTA' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'KODE.POS' => ['font-size'=>'8','valign'=>'center','align'=>'center'],
						'PHONE' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'CONTACT.PERSON' => ['font-size'=>'8','valign'=>'center','align'=>'left']
					]
				],
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'MODERN-NKA',
                'sheet_title' => [
					['CUST_ID','DIST_ID','CUST_NM','TYPE','LAYER','GEO.MAINTAIN','ALAMAT','PROVINSI','KOTA','KODE.POS','PHONE','CONTACT.PERSON'],
				],
			    'ceils' => $excel_ceilsNKA,
                'freezePane' => 'A2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
                'headerStyle'=>[					
					[
						'CUST_ID' =>['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'DIST_ID' =>['font-size'=>'8','width'=>'10','valign'=>'center','align'=>'center'],
						'CUST_NM' => ['font-size'=>'8','width'=>'28','valign'=>'center','align'=>'center','wrap'=>true],
						'TYPE' => ['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'LAYER' => ['font-size'=>'8','width'=>'6','valign'=>'center','align'=>'center'],
						'GEO.MAINTAIN' =>['font-size'=>'8','width'=>'25','valign'=>'center','align'=>'center'],
						'ALAMAT' => ['font-size'=>'8','width'=>'60','valign'=>'center','align'=>'center','wrap'=>true],
						'PROVINSI' => ['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'], 
						'KOTA' => ['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'],
						'KODE.POS' => ['font-size'=>'8','width'=>'7','valign'=>'center','align'=>'center'],
						'PHONE' => ['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'CONTACT.PERSON' => ['font-size'=>'8','width'=>'16','valign'=>'center','align'=>'center']
					]
						
				],
				'contentStyle'=>[
					[						
						'CUST_ID' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'DIST_ID' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'CUST_NM' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'TYPE' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'LAYER' => ['font-size'=>'8','valign'=>'center','align'=>'center'],
						'GEO.MAINTAIN' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'ALAMAT' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'PROVINSI' => ['font-size'=>'8','valign'=>'center','align'=>'left'], 
						'KOTA' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'KODE.POS' => ['font-size'=>'8','valign'=>'center','align'=>'center'],
						'PHONE' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'CONTACT.PERSON' => ['font-size'=>'8','valign'=>'center','align'=>'left']
					]
				],
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'MODERN-MTI',
				'sheet_title' => [
					['CUST_ID','DIST_ID','CUST_NM','TYPE','LAYER','GEO.MAINTAIN','ALAMAT','PROVINSI','KOTA','KODE.POS','PHONE','CONTACT.PERSON'],
				],
				'ceils' => $excel_ceilsMTI,
                'freezePane' => 'A2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
                'headerStyle'=>[					
					[
						'CUST_ID' =>['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'DIST_ID' =>['font-size'=>'8','width'=>'10','valign'=>'center','align'=>'center'],
						'CUST_NM' => ['font-size'=>'8','width'=>'28','valign'=>'center','align'=>'center','wrap'=>true],
						'TYPE' => ['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'LAYER' => ['font-size'=>'8','width'=>'6','valign'=>'center','align'=>'center'],
						'GEO.MAINTAIN' =>['font-size'=>'8','width'=>'25','valign'=>'center','align'=>'center'],
						'ALAMAT' => ['font-size'=>'8','width'=>'60','valign'=>'center','align'=>'center','wrap'=>true],
						'PROVINSI' => ['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'], 
						'KOTA' => ['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'],
						'KODE.POS' => ['font-size'=>'8','width'=>'7','valign'=>'center','align'=>'center'],
						'PHONE' => ['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'CONTACT.PERSON' => ['font-size'=>'8','width'=>'16','valign'=>'center','align'=>'center']
					]
						
				],
				'contentStyle'=>[
					[						
						'CUST_ID' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'DIST_ID' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'CUST_NM' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'TYPE' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'LAYER' => ['font-size'=>'8','valign'=>'center','align'=>'center'],
						'GEO.MAINTAIN' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'ALAMAT' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'PROVINSI' => ['font-size'=>'8','valign'=>'center','align'=>'left'], 
						'KOTA' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'KODE.POS' => ['font-size'=>'8','valign'=>'center','align'=>'center'],
						'PHONE' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'CONTACT.PERSON' => ['font-size'=>'8','valign'=>'center','align'=>'left']
					]
				],
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'UNKNOWN',
				'sheet_title' => [
					['CUST_ID','DIST_ID','CUST_NM','TYPE','LAYER','GEO.MAINTAIN','ALAMAT','PROVINSI','KOTA','KODE.POS','PHONE','CONTACT.PERSON'],
				],
				'ceils' => $excel_ceilsOTHER,
                'freezePane' => 'A2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
                'headerStyle'=>[					
					[
						'CUST_ID' =>['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'DIST_ID' =>['font-size'=>'8','width'=>'10','valign'=>'center','align'=>'center'],
						'CUST_NM' => ['font-size'=>'8','width'=>'28','valign'=>'center','align'=>'center','wrap'=>true],
						'TYPE' => ['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'LAYER' => ['font-size'=>'8','width'=>'6','valign'=>'center','align'=>'center'],
						'GEO.MAINTAIN' =>['font-size'=>'8','width'=>'25','valign'=>'center','align'=>'center'],
						'ALAMAT' => ['font-size'=>'8','width'=>'60','valign'=>'center','align'=>'center','wrap'=>true],
						'PROVINSI' => ['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'], 
						'KOTA' => ['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'],
						'KODE.POS' => ['font-size'=>'8','width'=>'7','valign'=>'center','align'=>'center'],
						'PHONE' => ['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'CONTACT.PERSON' => ['font-size'=>'8','width'=>'16','valign'=>'center','align'=>'center']
					]
						
				],
				'contentStyle'=>[
					[						
						'CUST_ID' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'DIST_ID' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'CUST_NM' => ['font-size'=>'8','valign'=>'center','align'=>'left','wrap'=>true],
						'TYPE' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'LAYER' => ['font-size'=>'8','valign'=>'center','align'=>'center'],
						'GEO.MAINTAIN' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'ALAMAT' => ['font-size'=>'8','valign'=>'center','align'=>'left','wrap'=>true],
						'PROVINSI' => ['font-size'=>'8','valign'=>'center','align'=>'left'], 
						'KOTA' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'KODE.POS' => ['font-size'=>'8','valign'=>'center','align'=>'center'],
						'PHONE' => ['font-size'=>'8','valign'=>'center','align'=>'left'],
						'CONTACT.PERSON' => ['font-size'=>'8','valign'=>'center','align'=>'left']
					]
				],
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'DELETE',
				'sheet_title' => [
					['DELETE.BY','DELETE.AT','CUST.ID','DIST.ID','CUST.NM','TYPE','LAYER','GEO.MAINTAIN','ALAMAT','PROVINSI','KOTA','KODE.POS','PHONE','CONTACT.PERSON'],
				],
				'ceils' => $excel_ceilsDEL,
                'freezePane' => 'A2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
				'headerStyle'=>[					
					[
						'DELETE.BY'=>['font-size'=>'8','width'=>'16','valign'=>'center','align'=>'center'],
						'DELETE.AT'=>['font-size'=>'8','width'=>'15','valign'=>'center','align'=>'center'],
						'CUST.ID' =>['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'DIST.ID' =>['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'],
						'CUST.NM' =>['font-size'=>'8','width'=>'28','valign'=>'center','align'=>'center','wrap'=>true],
						'TYPE' =>['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'LAYER' =>['font-size'=>'8','width'=>'6','valign'=>'center','align'=>'center'],
						'GEO.MAINTAIN' =>['font-size'=>'8','width'=>'25','valign'=>'center','align'=>'center'],
						'ALAMAT' =>['font-size'=>'8','width'=>'60','valign'=>'center','align'=>'center','wrap'=>true],
						'PROVINSI' =>['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'], 
						'KOTA' =>['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'],
						'KODE.POS' =>['font-size'=>'8','width'=>'7','valign'=>'center','align'=>'center'],
						'PHONE' =>['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'CONTACT.PERSON' =>['font-size'=>'8','width'=>'16','valign'=>'center','align'=>'center']
					]						
				],
				'contentStyle'=>[
					[						
						'DELETE.BY'=>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'DELETE.AT'=>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'CUST.ID' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'DIST.ID' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'CUST.NM' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'TYPE' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'LAYER' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'GEO.MAINTAIN' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'ALAMAT' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'PROVINSI' =>['font-size'=>'8','valign'=>'center','align'=>'left'], 
						'KOTA' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'KODE.POS' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'PHONE' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'CONTACT.PERSON' =>['font-size'=>'8','valign'=>'center','align'=>'left']
					]
				],            
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'EDITING',
				'sheet_title' => [
					['UPDATE.BY','UPDATE.AT','CUST.ID','DIST.ID','CUST.NM','TYPE','LAYER','GEO.MAINTAIN','ALAMAT','PROVINSI','KOTA','KODE.POS','PHONE','CONTACT.PERSON'],
				],
				'ceils' => $excel_ceilsEDIT,
                'freezePane' => 'A2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
                'headerStyle'=>[					
					[
						'UPDATE.BY'=>['font-size'=>'8','width'=>'16','valign'=>'center','align'=>'center'],
						'UPDATE.AT'=>['font-size'=>'8','width'=>'15','valign'=>'center','align'=>'center'],
						'CUST.ID' =>['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'DIST.ID' =>['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'],
						'CUST.NM' =>['font-size'=>'8','width'=>'28','valign'=>'center','align'=>'center','wrap'=>true],
						'TYPE' =>['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'LAYER' =>['font-size'=>'8','width'=>'6','valign'=>'center','align'=>'center'],
						'GEO.MAINTAIN' =>['font-size'=>'8','width'=>'25','valign'=>'center','align'=>'center'],
						'ALAMAT' =>['font-size'=>'8','width'=>'60','valign'=>'center','align'=>'center','wrap'=>true],
						'PROVINSI' =>['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'], 
						'KOTA' =>['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'],
						'KODE.POS' =>['font-size'=>'8','width'=>'7','valign'=>'center','align'=>'center'],
						'PHONE' =>['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'CONTACT.PERSON' =>['font-size'=>'8','width'=>'16','valign'=>'center','align'=>'center']
					]						
				],
				'contentStyle'=>[
					[						
						'UPDATE.BY'=>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'UPDATE.AT'=>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'CUST.ID' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'DIST.ID' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'CUST.NM' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'TYPE' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'LAYER' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'GEO.MAINTAIN' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'ALAMAT' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'PROVINSI' =>['font-size'=>'8','valign'=>'center','align'=>'left'], 
						'KOTA' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'KODE.POS' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'PHONE' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'CONTACT.PERSON' =>['font-size'=>'8','valign'=>'center','align'=>'left']
					]
				],
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'ADD NEW',
				'sheet_title' => [
					['CREATE.BY','CREATE.AT','CUST.ID','DIST.ID','CUST.NM','TYPE','LAYER','GEO.MAINTAIN','ALAMAT','PROVINSI','KOTA','KODE.POS','PHONE','CONTACT.PERSON'],
				],
				'ceils' => $excel_ceilsNEW,
                'freezePane' => 'A2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
				'headerStyle'=>[					
					[
						'CREATE.BY'=>['font-size'=>'8','width'=>'16','valign'=>'center','align'=>'center'],
						'CREATE.AT'=>['font-size'=>'8','width'=>'15','valign'=>'center','align'=>'center'],
						'CUST.ID' =>['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'DIST.ID' =>['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'],
						'CUST.NM' =>['font-size'=>'8','width'=>'28','valign'=>'center','align'=>'center','wrap'=>true],
						'TYPE' =>['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'LAYER' =>['font-size'=>'8','width'=>'6','valign'=>'center','align'=>'center'],
						'GEO.MAINTAIN' =>['font-size'=>'8','width'=>'25','valign'=>'center','align'=>'center'],
						'ALAMAT' =>['font-size'=>'8','width'=>'60','valign'=>'center','align'=>'center','wrap'=>true],
						'PROVINSI' =>['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'], 
						'KOTA' =>['font-size'=>'8','width'=>'12','valign'=>'center','align'=>'center'],
						'KODE.POS' =>['font-size'=>'8','width'=>'7','valign'=>'center','align'=>'center'],
						'PHONE' =>['font-size'=>'8','width'=>'13','valign'=>'center','align'=>'center'],
						'CONTACT.PERSON' =>['font-size'=>'8','width'=>'16','valign'=>'center','align'=>'center']
					]						
				],
				'contentStyle'=>[
					[						
						'CREATE.BY'=>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'CREATE.AT'=>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'CUST.ID' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'DIST.ID' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'CUST.NM' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'TYPE' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'LAYER' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'GEO.MAINTAIN' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'ALAMAT' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'PROVINSI' =>['font-size'=>'8','valign'=>'center','align'=>'left'], 
						'KOTA' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'KODE.POS' =>['font-size'=>'8','valign'=>'center','align'=>'center'],
						'PHONE' =>['font-size'=>'8','valign'=>'center','align'=>'left'],
						'CONTACT.PERSON' =>['font-size'=>'8','valign'=>'center','align'=>'left']
					]
				],
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
		];	
		$tglIn=date("Y-m-d");		
		$excel_file = "PostmanCustomer"."-".$tglIn;
		$this->export4excel($excel_content, $excel_file,0); 
	}
	
	/*SEND EMAIL*/
	public function  actionSend(){
		
		/*Content template*/
		$cusCount=Yii::$app->db_esm->createCommand("SELECT COUNT(CUST_KD) as CNT_ALL FROM `c0001` WHERE STATUS <>3")->queryAll();
			
		/*path & Name File*/
		//$rootyii=dirname(dirname(__DIR__)).'/cronjob/';
		//$rootyii='/var/www/advanced/lukisongroup/cronjob/tmp_cronjob/';
		$rootyii='/var/www/backup/customer/';
		//$folder=$rootyii.'/cronjob/'.$filename;
		//$baseRoot = Yii::getAlias('@webroot') . "/uploads/temp/";
		$tglIn=date("Y-m-d");		
		$filename = "PostmanCustomer"."-".$tglIn;
		//$filename = 'PostmanCustomer';
		//$filenameAll=$baseRoot.$filename;
		$filenameAll=$rootyii.$filename.'.xlsx';
		
		if (file_exists($filenameAll)) {
			
			/* Get Content*/
			$contentBody= $this->renderPartial('_postmanBody',[
				'cusCount'=>$cusCount
			]);	
			
			/* Send Mail*/
			Yii::$app->mailer->compose()
			->setFrom(['postman@lukison.com' => 'LG-ERP-POSTMAN'])
			//->setTo(['it-dept@lukison.com'])
			//->setTo(['piter@lukison.com'])
			//->setTo(['yosika@lukison.com','timbul.siregar@lukison.com','piter@lukison.com'])
			->setTo(['sales_esm@lukison.com','marketing_esm@lukison.com'])
			->setSubject('WEEKLY POSTMAN-CUSTOMER')
			->setHtmlBody($contentBody)
			->attach($filenameAll,[$filename,'xlsx'])
			->send(); 		
		} else {
			//echo "The file $filenameAll does not exist";
		}	
	}
	
	
	
}
?>