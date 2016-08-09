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
use scotthuangzl\export2excel\Export2ExcelBehavior;

class PostmanCustomerController extends Controller
{
    public function behaviors()
    {
        return [
			'export2excel' => [
				'class' => Export2ExcelBehavior::className(),
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
		$excel_dataAll = Export2ExcelBehavior::excelDataFormat($aryCusAllDataProvider);
		//$excel_title = $excel_dataNKA['excel_title'];
		$excel_ceilsAll = $excel_dataAll['excel_ceils'];
		
		/*SOURCE NKA  CUSTOMER*/
		$excel_dataNKA = Export2ExcelBehavior::excelDataFormat($aryCusDataProviderNKA);
		//$excel_title = $excel_dataNKA['excel_title'];
		$excel_ceilsNKA = $excel_dataNKA['excel_ceils'];
		
		/*SOURCE MTI  CUSTOMER*/
		$excel_dataMTI = Export2ExcelBehavior::excelDataFormat($aryCusDataProviderMTI);      
        $excel_ceilsMTI = $excel_dataMTI['excel_ceils'];
		
		/*SOURCE UNKNOWN  CUSTOMER*/
		$excel_dataOTHER= Export2ExcelBehavior::excelDataFormat($aryCusDataProviderOTHER);      
        $excel_ceilsOTHER = $excel_dataOTHER['excel_ceils'];
		
		/*SOURCE DELETE  CUSTOMER*/
		$excel_dataDEL= Export2ExcelBehavior::excelDataFormat($aryCusDelDataProvider);      
        $excel_ceilsDEL = $excel_dataDEL['excel_ceils'];
		
		/*SOURCE UPDATE  CUSTOMER*/
		$excel_dataEDIT= Export2ExcelBehavior::excelDataFormat($aryCusEditDataProvider);      
        $excel_ceilsEDIT = $excel_dataEDIT['excel_ceils'];
		
		/*SOURCE NEW  CUSTOMER*/
		$excel_dataNEW= Export2ExcelBehavior::excelDataFormat($aryCusNewDataProvider);      
        $excel_ceilsNEW = $excel_dataNEW['excel_ceils'];
		
		
		
		$excel_content = [
			[
				'sheet_name' => 'ALL CUSTOMER',
                'sheet_title' => ['CUST_ID','DIST_ID','CUST_NM','TYPE','LAYER_GRADE','GEO_MAINTAIN','ALAMAT','PROVINSI','KOTA','KODE POS','PHONE','CONTACT PERSON'], //$excel_ceils,//'sad',//[$excel_title],
			    'ceils' => $excel_ceilsAll,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					 'CUST_KD' => Export2ExcelBehavior::getCssClass('header'),
                     'DIST_ID' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'TYPE_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'LAYER_GRADE' => Export2ExcelBehavior::getCssClass('header'),
                     'GEO_MAINTAIN' => Export2ExcelBehavior::getCssClass('header'),
                     'ALAMAT' => Export2ExcelBehavior::getCssClass('header'),
					 'PROVINCE' => Export2ExcelBehavior::getCssClass('header'),              
                     'CITY_NAME' => Export2ExcelBehavior::getCssClass('header'),  
                     'POSTAL_CODE' => Export2ExcelBehavior::getCssClass('header'),  
                     'PHONE' => Export2ExcelBehavior::getCssClass('header'),
                     'CP' => Export2ExcelBehavior::getCssClass('header')              
                ], //define each column's cssClass for header line only.  You can set as blank.
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'MODERN-NKA',
                'sheet_title' => ['CUST_ID','DIST_ID','CUST_NM','TYPE','LAYER_GRADE','GEO_MAINTAIN','ALAMAT','PROVINSI','KOTA','KODE POS','PHONE','CONTACT PERSON'], //$excel_ceils,//'sad',//[$excel_title],
			    'ceils' => $excel_ceilsNKA,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					 'CUST_KD' => Export2ExcelBehavior::getCssClass('header'),
                     'DIST_ID' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'TYPE_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'LAYER_GRADE' => Export2ExcelBehavior::getCssClass('header'),
                     'GEO_MAINTAIN' => Export2ExcelBehavior::getCssClass('header'),
                     'ALAMAT' => Export2ExcelBehavior::getCssClass('header'),
					 'PROVINCE' => Export2ExcelBehavior::getCssClass('header'),              
                     'CITY_NAME' => Export2ExcelBehavior::getCssClass('header'),  
                     'POSTAL_CODE' => Export2ExcelBehavior::getCssClass('header'),  
                     'PHONE' => Export2ExcelBehavior::getCssClass('header'),
                     'CP' => Export2ExcelBehavior::getCssClass('header')              
                ], //define each column's cssClass for header line only.  You can set as blank.
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'MODERN-MTI',
				'sheet_title' => ['CUST_ID','DIST_ID','CUST_NM','TYPE','LAYER_GRADE','GEO_MAINTAIN','ALAMAT','PROVINSI','KOTA','KODE POS','PHONE','CONTACT PERSON'], //$excel_ceils,//'sad',//[$excel_title],
				'ceils' => $excel_ceilsMTI,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					 'CUST_KD' => Export2ExcelBehavior::getCssClass('header'),
                     'DIST_ID' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'TYPE_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'LAYER_GRADE' => Export2ExcelBehavior::getCssClass('header'),
                     'GEO_MAINTAIN' => Export2ExcelBehavior::getCssClass('header'),
                     'ALAMAT' => Export2ExcelBehavior::getCssClass('header'),
					 'PROVINCE' => Export2ExcelBehavior::getCssClass('header'),              
                     'CITY_NAME' => Export2ExcelBehavior::getCssClass('header'),  
                     'POSTAL_CODE' => Export2ExcelBehavior::getCssClass('header'),  
                     'PHONE' => Export2ExcelBehavior::getCssClass('header'),
                     'CP' => Export2ExcelBehavior::getCssClass('header')                  
                ], //define each column's cssClass for header line only.  You can set as blank.
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'UNKNOWN',
				'sheet_title' => ['CUST_ID','DIST_ID','CUST_NM','TYPE','LAYER_GRADE','GEO_MAINTAIN','ALAMAT','PROVINSI','KOTA','KODE POS','PHONE','CONTACT PERSON'], //$excel_ceils,//'sad',//[$excel_title],
				'ceils' => $excel_ceilsOTHER,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					  'CUST_KD' => Export2ExcelBehavior::getCssClass('header'),
                     'DIST_ID' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'TYPE_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'LAYER_GRADE' => Export2ExcelBehavior::getCssClass('header'),
                     'GEO_MAINTAIN' => Export2ExcelBehavior::getCssClass('header'),
                     'ALAMAT' => Export2ExcelBehavior::getCssClass('header'),
					 'PROVINCE' => Export2ExcelBehavior::getCssClass('header'),              
                     'CITY_NAME' => Export2ExcelBehavior::getCssClass('header'),  
                     'POSTAL_CODE' => Export2ExcelBehavior::getCssClass('header'),  
                     'PHONE' => Export2ExcelBehavior::getCssClass('header'),
                     'CP' => Export2ExcelBehavior::getCssClass('header')          
                ],
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'DELETE',
				'sheet_title' => ['DELETE BY','DELETE AT','CUST_ID','DIST_ID','CUST_NM','TYPE','LAYER_GRADE','GEO_MAINTAIN','ALAMAT','PROVINSI','KOTA','KODE POS','PHONE','CONTACT PERSON'], //$excel_ceils,//'sad',//[$excel_title],
				'ceils' => $excel_ceilsDEL,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					 'DELETE_AT' => Export2ExcelBehavior::getCssClass('header'),
					 'DELETE_BY' => Export2ExcelBehavior::getCssClass('header'),
					 'CUST_KD' => Export2ExcelBehavior::getCssClass('header'),
                     'DIST_ID' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'TYPE_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'LAYER_GRADE' => Export2ExcelBehavior::getCssClass('header'),
                     'GEO_MAINTAIN' => Export2ExcelBehavior::getCssClass('header'),
                     'ALAMAT' => Export2ExcelBehavior::getCssClass('header'),
					 'PROVINCE' => Export2ExcelBehavior::getCssClass('header'),              
                     'CITY_NAME' => Export2ExcelBehavior::getCssClass('header'),  
                     'POSTAL_CODE' => Export2ExcelBehavior::getCssClass('header'),  
                     'PHONE' => Export2ExcelBehavior::getCssClass('header'),
                     'CP' => Export2ExcelBehavior::getCssClass('header')          
                ],
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'EDITING',
				'sheet_title' => ['UPDATE BY','UPDATE AT','CUST_ID','DIST_ID','CUST_NM','TYPE','LAYER_GRADE','GEO_MAINTAIN','ALAMAT','PROVINSI','KOTA','KODE POS','PHONE','CONTACT PERSON'], //$excel_ceils,//'sad',//[$excel_title],
				'ceils' => $excel_ceilsEDIT,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					 'UPDATE_AT' => Export2ExcelBehavior::getCssClass('header'),
					 'UPDATE_BY' => Export2ExcelBehavior::getCssClass('header'),
					 'CUST_KD' => Export2ExcelBehavior::getCssClass('header'),
                     'DIST_ID' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'TYPE_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'LAYER_GRADE' => Export2ExcelBehavior::getCssClass('header'),
                     'GEO_MAINTAIN' => Export2ExcelBehavior::getCssClass('header'),
                     'ALAMAT' => Export2ExcelBehavior::getCssClass('header'),
					 'PROVINCE' => Export2ExcelBehavior::getCssClass('header'),              
                     'CITY_NAME' => Export2ExcelBehavior::getCssClass('header'),  
                     'POSTAL_CODE' => Export2ExcelBehavior::getCssClass('header'),  
                     'PHONE' => Export2ExcelBehavior::getCssClass('header'),
                     'CP' => Export2ExcelBehavior::getCssClass('header')          
                ],
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'ADD NEW',
				'sheet_title' => ['CREATE BY','CREATE AT','CUST_ID','DIST_ID','CUST_NM','TYPE','LAYER_GRADE','GEO_MAINTAIN','ALAMAT','PROVINSI','KOTA','KODE POS','PHONE','CONTACT PERSON'], //$excel_ceils,//'sad',//[$excel_title],
				'ceils' => $excel_ceilsNEW,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					 'CREATE_AT' => Export2ExcelBehavior::getCssClass('header'),
					 'CREATE_BY' => Export2ExcelBehavior::getCssClass('header'),
					 'CUST_KD' => Export2ExcelBehavior::getCssClass('header'),
                     'DIST_ID' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'TYPE_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'LAYER_GRADE' => Export2ExcelBehavior::getCssClass('header'),
                     'GEO_MAINTAIN' => Export2ExcelBehavior::getCssClass('header'),
                     'ALAMAT' => Export2ExcelBehavior::getCssClass('header'),
					 'PROVINCE' => Export2ExcelBehavior::getCssClass('header'),              
                     'CITY_NAME' => Export2ExcelBehavior::getCssClass('header'),  
                     'POSTAL_CODE' => Export2ExcelBehavior::getCssClass('header'),  
                     'PHONE' => Export2ExcelBehavior::getCssClass('header'),
                     'CP' => Export2ExcelBehavior::getCssClass('header')          
                ],
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
			],
		];		
		$excel_file = "PostmanCustomer";
		$this->export2excel($excel_content, $excel_file,0); 
	}
	
	/*SEND EMAIL*/
	public function  actionSend(){
		
		/*Content template*/
		$cusCount=Yii::$app->db_esm->createCommand("SELECT COUNT(CUST_KD) as CNT_ALL FROM `c0001` WHERE STATUS <>3")->queryAll();
			
		/*path & Name File*/
		//$rootyii=dirname(dirname(__DIR__)).'/cronjob/';
		$rootyii='/var/www/advanced/lukisongroup/cronjob/temp/';
		//$folder=$rootyii.'/cronjob/'.$filename;
		//$baseRoot = Yii::getAlias('@webroot') . "/uploads/temp/";
		$filename = 'PostmanCustomer';
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
			->setTo(['yosika@lukison.com','timbul.siregar@lukison.com'])
			//->setTo(['sales_esm@lukison.com','marketing_esm@lukison.com'])
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