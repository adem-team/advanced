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

class PostmanDailySalesmdController extends Controller
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
	
	/*
	 * EXPORT DATA CUSTOMER TO EXCEL
	 * export_data
	*/
	public function actionExport(){
		
		/* DAILY REPORT INVENTORY SALES */
		$dailySalesReport= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>Yii::$app->db_esm->createCommand("	
				# x1 = Schadule Detail; x2 = Sales Order; x3 = customer;x4 = barang; x5 = Visit Memo; x6 = Alias customer; x7 = Alias barang; x8 = USER PROFILE
				SELECT x1.TGL,x8.NM_FIRST,x1.CUST_ID AS CUST_ID_ESM,x6.KD_ALIAS AS CUST_ID_DISTRIBUTOR,x3.CUST_NM,x2.KD_BARANG AS KD_BARANG_ESM, x7.KD_ALIAS As ID_BARANG_DISTRIBUTOR,x4.NM_BARANG, 
					SUM(CASE WHEN x2.SO_TYPE=5 THEN x2.SO_QTY ELSE 0 END) as STOCK,
					SUM(CASE WHEN x2.SO_TYPE=6 THEN x2.SO_QTY ELSE 0 END) as SELL_IN,
					SUM(CASE WHEN x2.SO_TYPE=7 THEN x2.SO_QTY ELSE 0 END) as SELL_OUT,
					SUM(CASE WHEN x2.SO_TYPE=8 THEN x2.SO_QTY ELSE 0 END) as RETURN_INV,
					SUM(CASE WHEN x2.SO_TYPE=9 THEN x2.SO_QTY ELSE 0 END) as REQUEST_INV,
					SUM(CASE WHEN x2.SO_TYPE=10 THEN '0000-00-00' ELSE '0000-00-00' END) as ED,
					 x5.ISI_MESSAGES
					FROM c0002scdl_detail x1 INNER JOIN so_t2 x2 ON  x2.TGL=x1.TGL AND x2.CUST_KD=x1.CUST_ID 
					LEFT JOIN c0001 x3 on x3.CUST_KD=x1.CUST_ID
					LEFT JOIN b0001 x4 on x4.KD_BARANG=x2.KD_BARANG		
					LEFT JOIN c0014 x5 on x5.TGL=x1.TGL AND x5.KD_CUSTOMER=x1.CUST_ID AND x5.ID_USER=x1.USER_ID
					LEFT JOIN c0002 x6 on x6.KD_CUSTOMERS=x1.CUST_ID
					LEFT JOIN b0002 x7 on x7.KD_BARANG=x2.KD_BARANG
					LEFT JOIN dbm_086.user_profile x8 on x8.ID=x1.USER_ID
					WHERE  x1.TGL='2016-07-27'
					GROUP BY x1.CUST_ID,x2.KD_BARANG	
			")->queryAll(),
		]);	
		$apDailySalesReport=$dailySalesReport->allModels;
		$excel_DailySalesReport = Export2ExcelBehavior::excelDataFormat($apDailySalesReport);
		$excel_ceilsDailySalesReport = $excel_DailySalesReport['excel_ceils'];
		
		$dailySalesQt= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>Yii::$app->db_esm->createCommand("call ERP_CUSTOMER_VISIT_CRONJOB_kwalitas_time('ALL_HEAD2','59','2016-07-27')")->queryAll(),
		]);				
		$apSalesQT=$dailySalesQt->allModels;
		$excel_DailySalesQT = Export2ExcelBehavior::excelDataFormat($apSalesQT);
		$excel_ceilsSalesQT = $excel_DailySalesQT['excel_ceils'];
					
		$excel_content = [
			 [  //QUANTITY
				//'sheet_name' => 'DAILY REPORT QUANTITY OF SALES MD',
				'sheet_name' => 'DAILY REPORT INVENTORY',
                'sheet_title' => [
					'TGL','SALESMD','CUST_ID_ESM','CUST_ID_DISTRIBUTOR','CUST_NM','KD_BARANG_ESM','ID_BARANG_DIST','NM_BARANG',
					'STOCK/PCS','SELL_IN/PCS','SELL_OUT/PCS','RETURE/PCS','REQUEST ORDER/PCS','EXPIRED DATE/PCS','NOTE'
				],
			    'ceils' => $excel_ceilsDailySalesReport,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					 'TGL' => Export2ExcelBehavior::getCssClass('header'),
                     'SALESMD' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_ID_ESM' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_ID_DISTRIBUTOR' => Export2ExcelBehavior::getCssClass('header'),
					 'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),              
                     'KD_BARANG_ESM' => Export2ExcelBehavior::getCssClass('header'),  
                     'ID_BARANG_DIST' => Export2ExcelBehavior::getCssClass('header'),  
                     'NM_BARANG' => Export2ExcelBehavior::getCssClass('header'),
                     'STOCK' => Export2ExcelBehavior::getCssClass('header'),              
                     'SELL_IN' => Export2ExcelBehavior::getCssClass('header'),              
                     'SELL_OUT' => Export2ExcelBehavior::getCssClass('header'),              
                     'REQUEST ORDER' => Export2ExcelBehavior::getCssClass('header'),              
                     'EXPIRED DATE' => Export2ExcelBehavior::getCssClass('header'),              
                     'NOTE' => Export2ExcelBehavior::getCssClass('header'),              
                ],
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
			],
			[	//QUALITAS SALES TIME
				'sheet_name' => 'DAILY REPORT QUALITY TIME',
                'sheet_title' => [
					'SALES MD','CUSTOMERS','CHECK IN','CHECK OUT','VISIT TIME','DISTANCE','START ABSENSI','END ABSENSI'
				],
			    'ceils' => $excel_ceilsSalesQT,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					 'SALES MD' => Export2ExcelBehavior::getCssClass('header'),
                     'CUSTOMERS' => Export2ExcelBehavior::getCssClass('header'),
                     'CHECK IN' => Export2ExcelBehavior::getCssClass('header'),
                     'CHECK OUT' => Export2ExcelBehavior::getCssClass('header'),
					 'VISIT TIME' => Export2ExcelBehavior::getCssClass('header'),              
                     'DISTANCE' => Export2ExcelBehavior::getCssClass('header'),  
                     'START ABSENSI' => Export2ExcelBehavior::getCssClass('header'),  
                     'END ABSENSI' => Export2ExcelBehavior::getCssClass('header'),    
                ],
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
			],			
		];		
		$excel_file = "PostmanDailySalesMd";
		$this->export2excel($excel_content, $excel_file,0); 
	}
	
	/*SEND EMAIL*/
	public function  actionSend(){
		
		/*Content template*/
		$cusCount=Yii::$app->db_esm->createCommand("SELECT COUNT(CUST_KD) as CNT_ALL FROM `c0001` WHERE CUST_KD<>CUST_GRP")->queryAll();
			
		/*path & Name File*/
		//$rootyii=dirname(dirname(__DIR__)).'/cronjob/';
		$rootyii='/var/www/advanced/lukisongroup/cronjob/temp/';
		//$folder=$rootyii.'/cronjob/'.$filename;
		//$baseRoot = Yii::getAlias('@webroot') . "/uploads/temp/";
		$filename = 'PostmanDailySalesMd';
		//$filenameAll=$baseRoot.$filename;
		$filenameAll=$rootyii.$filename.'.xlsx';
		
		if (file_exists($filenameAll)) {
			
			/* Get Content*/
			$contentBody= $this->renderPartial('_postmanBodyDailySales',[
				'cusCount'=>$cusCount
			]);	
			
			/* Send Mail*/
			Yii::$app->mailer->compose()
			->setFrom(['postman@lukison.com' => 'LG-ERP-POSTMAN'])
			//->setTo(['it-dept@lukison.com'])
			//->setTo(['piter@lukison.com'])
			->setTo(['sales_esm@lukison.com','marketing_esm@lukison.com'])
			->setSubject('POSTMAN - DAILY REPORT SALES MD')
			->setHtmlBody($contentBody)
			->attach($filenameAll,[$filename,'xlsx'])
			->send(); 		
		} else {
			//echo "The file $filenameAll does not exist";
		}	
	}
	
	
	
}
?>