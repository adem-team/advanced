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

class PostmanSchaduleController extends Controller
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
		
		/* 22=NKA*/
		$tanggalOfMonth= new ArrayDataProvider([
			//'key' => 'ID',
			//SELECT a.USER_ID,a.SCDL_GROUP AS GRP_ID, b.SCDL_GROUP_NM as GRP_NM,a.CUST_ID,c.CUST_NM,a.LAT,a.LAG 
			'allModels'=>Yii::$app->db_esm->createCommand("				
				SET @selesai = LAST_DAY(DATE_ADD(CURDATE(), INTERVAL 0 month));
				SET @mulai = DATE_FORMAT((DATE_SUB(@selesai, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY)), '%Y-%m-01');
				SELECT DATE_FORMAT( a.Date,'%Y-%m-%d') as TGL
				FROM (
						select @selesai - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as Date
						from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
						cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
						cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
				) a
				WHERE a.Date between @mulai and @selesai
				ORDER BY a.Date	
			")->queryAll(),
		]);	
		
		$attributeField=$tanggalOfMonth->allModels[0];
		
		
		$schaduleGrpData= new ArrayDataProvider([
			//'key' => 'ID',
			//SELECT a.USER_ID,a.SCDL_GROUP AS GRP_ID, b.SCDL_GROUP_NM as GRP_NM,a.CUST_ID,c.CUST_NM,a.LAT,a.LAG 
			'allModels'=>Yii::$app->db_esm->createCommand("				
				SELECT b.SCDL_GROUP_NM as GRP_NM,a.CUST_ID,c.CUST_NM,a.LAT,a.LAG 
				FROM c0002scdl_detail a 
				LEFT JOIN c0007 b ON a.SCDL_GROUP=b.ID
				LEFT JOIN c0001 c on c.CUST_KD=a.CUST_ID
				WHERE a.CUST_ID<>c.CUST_GRP #Exception Customer Parent 
				GROUP BY a.CUST_ID,a.SCDL_GROUP
				ORDER BY a.SCDL_GROUP;		
			")->queryAll(),
		]);	
		
		
		$schaduleGrpProvider=$schaduleGrpData->allModels;
		$excelScdlGrpData = Export2ExcelBehavior::excelDataFormat($schaduleGrpProvider);
		$excel_ceilsScdlGrp = $excelScdlGrpData['excel_ceils'];
				
		$excel_content = [
			 [
				'sheet_name' => 'LIST SCHADULE GROUP',
                'sheet_title' => ['GRP_NM','CUST_ID','CUST_NM','LAT','LAG'], 
               // 'sheet_title' => ['USER_ID','GRP_ID','GRP_NM','CUST_ID','CUST_NM','LAT','LAG'], 
			    'ceils' => $excel_ceilsScdlGrp,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					// 'USER_ID' => Export2ExcelBehavior::getCssClass('header'),
                     //'GRP_ID' => Export2ExcelBehavior::getCssClass('header'),
                     'GRP_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_ID' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'LAT' => Export2ExcelBehavior::getCssClass('header'),              
                     'LAG' => Export2ExcelBehavior::getCssClass('header')              
                ], //define each column's cssClass for header line only.  You can set as blank.
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
			],
		];		
		$excel_file = "PostmanSchaduleGroup";
		$this->export2excel($excel_content, $excel_file,0); 
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
		$filename = 'PostmanSchaduleGroup';
		//$filenameAll=$baseRoot.$filename;
		$filenameAll=$rootyii.$filename.'.xlsx';
		
		if (file_exists($filenameAll)) {
			
			/* Get Content*/
			$contentBody= $this->renderPartial('_postmanBodyScdl');	
			
			/* Send Mail*/
			Yii::$app->mailer->compose()
			->setFrom(['postman@lukison.com' => 'LG-ERP-POSTMAN'])
			->setTo(['it-dept@lukison.com'])
			//->setTo(['piter@lukison.com'])
			//->setTo(['sales_esm@lukison.com','marketing_esm@lukison.com'])
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