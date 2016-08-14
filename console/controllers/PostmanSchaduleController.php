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

class PostmanSchaduleController extends Controller
{
    public function behaviors()
    {
        return [
			'export4excel' => [
				'class' => Postman4ExcelBehavior::className(),
				'downloadPath'=>Yii::getAlias('@lukisongroup').'/cronjob/',
				'widgetType'=>'CRONJOB',
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
	 * EXPORT DATA CUSTOMER TO EXCEL
	 * export_data
	*/
	public function actionExport(){
		
		$tglIn='2016-08-01';
		/* HEADER/FIELD MONTHLY SCHADULE*/
		$tanggalOfMonth= new ArrayDataProvider([
			//'key' => 'ID',
			//SELECT a.USER_ID,a.SCDL_GROUP AS GRP_ID, b.SCDL_GROUP_NM as GRP_NM,a.CUST_ID,c.CUST_NM,a.LAT,a.LAG 
			/* 'allModels'=>Yii::$app->db_esm->createCommand("				
				SELECT DATE_FORMAT(a.Date,'%d') as TGL
				FROM (
						select LAST_DAY(DATE_ADD('".$tglIn."', INTERVAL 0 month)) - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as Date
						from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
						cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
						cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
				) a
				WHERE a.Date between DATE_FORMAT((DATE_SUB('".$tglIn."', INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY)), '%Y-%m-01') and LAST_DAY(DATE_ADD('".$tglIn."', INTERVAL 0 month))
				ORDER BY a.Date	
			")->queryAll(), */
			'allModels'=>Yii::$app->db_esm->createCommand("Call ERP_CUSTOMER_VISIT_SchaduleReportHeader('".$tglIn."')")->queryAll(),
		]);			
		//FIELD TGL & PEKAN
		$attributeHeader=$tanggalOfMonth->allModels; 
		
		
		foreach($attributeHeader as $key=>$value){
			$cntArray[]=$value['Pekan'];
		}		
		$counts = array_count_values($cntArray); //get count of value array
			
		
		//headeStyle1	
		$attHeaderName=['Sales','Bulan'];
		$headerStyleDinamik1a[] =[ 	
						'Sales'=>[
							'align'=>'center','color-font'=>'FFFFFF','color-background'=>'519CC6','merge'=>'0,2','width'=>'20'
						],
						'Bulan'=>[
							'align'=>'center','color-font'=>'FFFFFF','color-background'=>'519CC6','merge'=>'0,2','width'=>'20'
						]];	
		
		//SPLIT TGL BY PRKAN
		$checkPekan='';					
		foreach($attributeHeader as $key=>$value){			
			if ($checkPekan!=$value['Pekan']){
				$mergeVal=($counts[$value['Pekan']]-1).',1';
				$attHeader1Dinamik[]= 'Pekan-'.$value['Pekan'];	
				//Color Backgroud - week genap/ganjil
				if($value['Pekan'] % 2==0){
					$warnaBelakang='FFFF99';
				}elseif($value['Pekan'] % 2!=0){
					$warnaBelakang='CCFF99';
				}
				//headeStyle1 Row1				
				$headerStyleDinamik1b[] =[
					'Pekan-'.$value['Pekan']=>[
						'align'=>'center','color-font'=>'000000','color-background'=>$warnaBelakang,'merge'=>$mergeVal,'width'=>'20'
						//'align'=>'center','color-font'=>'FFFFFF','color-background'=>'519CC6','merge'=>$mergeVal,'width'=>'20'
					]
				];
				$checkPekan=$value['Pekan'];
			}else{
				$attHeader1Dinamik[]= $value['Pekan'].'-'.$key;
			}
			$val=explode(".",$value['TGL']);
			$attHeader2[]= $val[1]." ".$val[0]."";
			//headeStyle2 Row2
			$headerStyleDinamik2[] =[
				$val[1]." ".$val[0]=>[
					'align'=>'center','color-font'=>'FFFFFF','color-background'=>'519CC6','width'=>'20'
				]
			];
			//Content Style - Array
			$contentStyleDinamik[]=[
				$val[1]." ".$val[0]=>[
					'align'=>'center','color-font'=>'0000FF'
				]
			];
		};
		//PUT HRADAER ROW1 & ROW2
		$titleHeader1=array_merge($attHeaderName,$attHeader1Dinamik);
		$titleHeader2=array_merge($attHeaderName,$attHeader2);
		
		//headeStyle1-	Array Position parent from chaild array
		foreach($headerStyleDinamik1b as $key=>$val){
			$headerStyleDinamik1a[0]=array_merge($headerStyleDinamik1a[0],$headerStyleDinamik1b[$key]);			
		}
				
		//headeStyle2	
		$headerStyleDinamik2a[]=[];
		foreach($headerStyleDinamik2 as $key=>$val){
			$headerStyleDinamik2a=array_merge($headerStyleDinamik2a,$headerStyleDinamik2[$key]);			
		}		
		//HeadeStyle - Marge Array
		$headerStyleMarge=array_merge($headerStyleDinamik1a,[$headerStyleDinamik2a]);
		
		//Content Style Array Postition
		$contentStyleDinamikA[]=[];
		foreach($contentStyleDinamik as $key=>$val){
			$contentStyleDinamikA=array_merge($contentStyleDinamikA,$contentStyleDinamik[$key]);			
		}	
		
		// print_r($contentStyleDinamikA);
		// die();
		
		//row Data
		$dataScdlOfMonth= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("Call ERP_CUSTOMER_VISIT_SchaduleReport('".$tglIn."')")->queryAll()
		]);
		$schaduleProvider=$dataScdlOfMonth->allModels;
		$excelScdlData = Postman4ExcelBehavior::excelDataFormat($schaduleProvider);
		$excel_ceilsScdl = $excelScdlData['excel_ceils'];
			
		/* GROUP SCHADULE*/
		$schaduleGrpData= new ArrayDataProvider([
			//'key' => 'ID',
			//SELECT a.USER_ID,a.SCDL_GROUP AS GRP_ID, b.SCDL_GROUP_NM as GRP_NM,a.CUST_ID,c.CUST_NM,a.LAT,a.LAG 
			'allModels'=>Yii::$app->db_esm->createCommand("				
				SELECT b.SCDL_GROUP_NM as GRP_NM, b.KETERANGAN as GRP_DCRP,a.CUST_ID,c.CUST_NM,d.PROVINCE,e.CITY_NAME,e.POSTAL_CODE, a.LAT,a.LAG 
				FROM c0002scdl_detail a 
				LEFT JOIN c0007 b ON a.SCDL_GROUP=b.ID
				LEFT JOIN c0001 c on c.CUST_KD=a.CUST_ID
				LEFT JOIN c0001g1 d on d.PROVINCE_ID=c.PROVINCE_ID
				LEFT JOIN c0001g2 e on e.CITY_ID=c.CITY_ID
				WHERE a.CUST_ID<>c.CUST_GRP #Exception Customer Parent 
				GROUP BY a.CUST_ID,a.SCDL_GROUP
				ORDER BY a.SCDL_GROUP
			")->queryAll(),
		]);	
		$schaduleGrpProvider=$schaduleGrpData->allModels;
		$excelScdlGrpData = Postman4ExcelBehavior::excelDataFormat($schaduleGrpProvider);
		$excel_ceilsScdlGrp = $excelScdlGrpData['excel_ceils'];
				
		
		/* USER SALESMAN */
		$userData= new ArrayDataProvider([
			//'key' => 'ID',	
			//SELECT b.ID,a.username,b.NM_FIRST, b.NM_MIDDLE, b.KTP,ALAMAT, b.GENDER, b.EMAIL, b.HP, b.TLP_HOME 
				
			'allModels'=>Yii::$app->db_esm->createCommand("				
				SELECT b.ID_USER,a.username,b.NM_FIRST, b.NM_MIDDLE, b.KTP,ALAMAT, b.GENDER, b.EMAIL, b.HP, b.TLP_HOME 
				FROM dbm001.user a LEFT JOIN dbm_086.user_profile b on b.ID_USER=a.id
				WHERE a.POSITION_SITE='CRM' AND a.POSITION_LOGIN=1 AND a.status=10
			")->queryAll(),
		]);	
		$usrProvider=$userData->allModels;
		$excelUserData = Postman4ExcelBehavior::excelDataFormat($usrProvider);
		$excel_ceilsUser = $excelUserData['excel_ceils']; 		
		
		$excel_content = [			
			
			
			
			
			
			/* DAILY SUMMARY AC|EC */
			[
				'sheet_name' => 'DAILY SUMMARY AC|EC',
                //'sheet_title' => $attFieldAll,
                'sheet_title' => [''], 
			    //'ceils' => $excel_ceilsScdl,
                //'freezePane' => 'E2',
               //'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
                //'headerColumnCssClass' => [
					// 'USER_ID' => Postman4ExcelBehavior::getCssClass('header'),
                     //'GRP_ID' => Postman4ExcelBehavior::getCssClass('header'),
                     ///'GRP_NM' => Postman4ExcelBehavior::getCssClass('header'),
                    // 'CUST_ID' => Postman4ExcelBehavior::getCssClass('header'),
                    // 'CUST_NM' => Postman4ExcelBehavior::getCssClass('header'),
                    // 'LAT' => Postman4ExcelBehavior::getCssClass('header'),              
                    // 'LAG' => Postman4ExcelBehavior::getCssClass('header')              
                //], //define each column's cssClass for header line only.  You can set as blank.
               //'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               //'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
			/* DAILY DETAIL AC|EC */
			[
				'sheet_name' => 'DAILY DETAIL AC|EC',
                //'sheet_title' => $attFieldAll,
				'sheet_title' => [''], 
			    //'ceils' => $excel_ceilsScdl,
                //'freezePane' => 'E2',
               //'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
                //'headerColumnCssClass' => [
					// 'USER_ID' => Postman4ExcelBehavior::getCssClass('header'),
                     //'GRP_ID' => Postman4ExcelBehavior::getCssClass('header'),
                     ///'GRP_NM' => Postman4ExcelBehavior::getCssClass('header'),
                    // 'CUST_ID' => Postman4ExcelBehavior::getCssClass('header'),
                    // 'CUST_NM' => Postman4ExcelBehavior::getCssClass('header'),
                    // 'LAT' => Postman4ExcelBehavior::getCssClass('header'),              
                    // 'LAG' => Postman4ExcelBehavior::getCssClass('header')              
                //], //define each column's cssClass for header line only.  You can set as blank.
               //'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               //'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			], 
			/* USER */
			[
				'sheet_name' => 'SALES MD',
				'sheet_title' => ['ID','USERNAME','NAMA DEPAN','NAMA BELAKANG','KTP','ALAMAT','GENDER','EMAIL','HP','TLP_HOME'], 
				'ceils' => $excel_ceilsUser,
				//'freezePane' => 'E2',
				'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
				'headerColumnCssClass' => [
					'ID' => Postman4ExcelBehavior::getCssClass('header'),
					'username' => Postman4ExcelBehavior::getCssClass('header'),
					'NM_FIRST' => Postman4ExcelBehavior::getCssClass('header'),
					'NM_MIDDLE' => Postman4ExcelBehavior::getCssClass('header'),
					'KTP' => Postman4ExcelBehavior::getCssClass('header'),
					'ALAMAT' => Postman4ExcelBehavior::getCssClass('header'),              
					'GENDER' => Postman4ExcelBehavior::getCssClass('header'),              
					'EMAIL' => Postman4ExcelBehavior::getCssClass('header'),              
					'HP' => Postman4ExcelBehavior::getCssClass('header'),              
					'TLP_HOME' => Postman4ExcelBehavior::getCssClass('header')              
				], //define each column's cssClass for header line only.  You can set as blank.
			   'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
			   'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
			/* GROUP SCHADULE*/
			[
				'sheet_name' => 'LIST SCHADULE GROUP',
                'sheet_title' => ['GRP_NM ','GRP_DCRP','CUST_ID','CUST_NM','PROVINSI','KOTA','KODE POS','LAT','LAG'], 
                'ceils' => $excel_ceilsScdlGrp,
                //'freezePane' => 'E2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					 // 'USER_ID' => Postman4ExcelBehavior::getCssClass('header'),
                     //'GRP_ID' => Postman4ExcelBehavior::getCssClass('header'),
                     'GRP_NM' => Postman4ExcelBehavior::getCssClass('header'),
                     'GRP_DCRP' => Postman4ExcelBehavior::getCssClass('header'),
                     'CUST_ID' => Postman4ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Postman4ExcelBehavior::getCssClass('header'),
                     'PROVINCE' => Postman4ExcelBehavior::getCssClass('header'),              
                     'CITY_NAME' => Postman4ExcelBehavior::getCssClass('header'),  
                     'POSTAL_CODE' => Postman4ExcelBehavior::getCssClass('header'),  
					 'LAT' => Postman4ExcelBehavior::getCssClass('header'),              
                     'LAG' => Postman4ExcelBehavior::getCssClass('header')              
                ], //define each column's cssClass for header line only.  You can set as blank.
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
			/* MONTHLY SCHADULE*/			
			[ 
				'sheet_name' => 'WEEKLY SCHEDULE OF THE MONTH',
                'sheet_title' => [
							$titleHeader1,
							$titleHeader2,		
				],
                'ceils' => $excel_ceilsScdl,
               // 'freezePane' => 'A3',
               	'headerStyle'=>$headerStyleMarge,
               	'contentStyle'=>[$contentStyleDinamikA],
               	// 'contentStyle'=>[
						// [
							// 'Minggu 31-7' => [
								// 'align'=>'center','color-font'=> '000000','color-background'=>'FF0000'
							// ]
						// ]
					// ],
                'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
                'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
			
		];		
		$excel_file = "PostmanSalesSchadule";
		$this->export4excel($excel_content, $excel_file,0); 
	}
	
	/*SEND EMAIL*/
	public function  actionSend(){
		
		/*Content template*/
		//$cusCount=Yii::$app->db_esm->createCommand("SELECT COUNT(CUST_KD) as CNT_ALL FROM `c0001` WHERE CUST_KD<>CUST_GRP")->queryAll();
			
		/*path & Name File*/
		//$rootyii=dirname(dirname(__DIR__)).'/cronjob/';
		$rootyii='/var/www/advanced/lukisongroup/cronjob/temp/';
		//$folder=$rootyii.'/cronjob/'.$filename;
		//$baseRoot = Yii::getAlias('@webroot') . "/uploads/temp/";
		$filename = 'PostmanSalesSchadule';
		//$filenameAll=$baseRoot.$filename;
		$filenameAll=$rootyii.$filename.'.xlsx';
		
		if (file_exists($filenameAll)) {
			
			/* Get Content*/
			$contentBody= $this->renderPartial('_postmanBodyScdl');	
			
			/* Send Mail*/
			Yii::$app->mailer->compose()
			->setFrom(['postman@lukison.com' => 'LG-ERP-POSTMAN'])
			//->setTo(['it-dept@lukison.com'])
			//->setTo(['piter@lukison.com'])
			->setTo(['sales_esm@lukison.com','marketing_esm@lukison.com'])
			->setSubject('WEEKLY SCHADULE')
			->setHtmlBody($contentBody)
			->attach($filenameAll,[$filename,'xlsx'])
			->send(); 		
		} else {
			//echo "The file $filenameAll does not exist";
		}	
	}
	
	
	
}
?>