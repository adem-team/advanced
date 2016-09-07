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

class PostmanDailySalesmdController extends Controller
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
		$tglIn='2016-09-07';
		/* DAILY REPORT INVENTORY SALES */
		$dailySalesReport= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>Yii::$app->db_esm->createCommand("	
				# x1 = Schadule Detail; x2 = Sales Order; x3 = customer;x4 = barang; x5 = Visit Memo; x6 = Alias customer; x7 = Alias barang; x8 = USER PROFILE
				SELECT x1.TGL,
			x8.NM_FIRST,
			x1.CUST_ID AS CUST_ID_ESM,
			x6.KD_ALIAS AS CUST_ID_DISTRIBUTOR,
			x1.CUST_NM,
			x2.KD_BARANG AS KD_BARANG_ESM, 
			x7.KD_ALIAS As ID_BARANG_DISTRIBUTOR,
			x4.NM_BARANG, 
					SUM(CASE WHEN x2.SO_TYPE=5 THEN x2.SO_QTY ELSE 0 END) as STOCK,
					SUM(CASE WHEN x2.SO_TYPE=8 THEN x2.SO_QTY ELSE 0 END) as RETURN_INV,
					SUM(CASE WHEN x2.SO_TYPE=9 THEN x2.SO_QTY ELSE 0 END) as REQUEST_INV,
					SUM(CASE WHEN x2.SO_TYPE=6 THEN x2.SO_QTY ELSE 0 END) as SELL_IN,
					SUM(CASE WHEN x2.SO_TYPE=7 THEN x2.SO_QTY ELSE 0 END) as SELL_OUT,					
					x5.ISI_MESSAGES
					FROM c0002rpt_cc_time x1 INNER JOIN so_t2 x2 ON  x2.TGL=x1.TGL AND x2.CUST_KD=x1.CUST_ID 
					LEFT JOIN b0001 x4 on x4.KD_BARANG=x2.KD_BARANG		
					LEFT JOIN c0014 x5 on x5.TGL=x1.TGL AND x5.KD_CUSTOMER=x1.CUST_ID AND x5.ID_USER=x1.USER_ID
					LEFT JOIN c0002 x6 on x6.KD_CUSTOMERS=x1.CUST_ID
					LEFT JOIN b0002 x7 on x7.KD_BARANG=x2.KD_BARANG
					LEFT JOIN dbm_086.user_profile x8 on x8.ID_USER=x1.USER_ID
					WHERE  x1.TGL='".$tglIn."'
					GROUP BY x1.CUST_ID,x2.KD_BARANG	
					ORDER BY x1.USER_ID,x1.CUST_ID
			")->queryAll(),
		]);	
		$apDailySalesReport=$dailySalesReport->allModels;
		$excel_DailySalesReport = Postman4ExcelBehavior::excelDataFormat($apDailySalesReport);
		$excel_ceilsDailySalesReport = $excel_DailySalesReport['excel_ceils'];
		
		/* DAILY REPORT SALES QUALITY TIME  */
		$dailySalesQt= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>Yii::$app->db_esm->createCommand("
				#call ERP_CUSTOMER_VISIT_CRONJOB_kwalitas_time('ALL_HEAD2','55','2016-08-18')
				SELECT 
					TGL,SALES_NM,
					CUST_ID,CUST_NM,	
					ABSEN_MASUK,ABSEN_KELUAR,	
					CUST_CHKIN AS CHEKIN, CUST_CHKOUT AS CHECKOUT,LIVE_TIME AS VISIT_TIME, JRK_TEMPUH AS DISTANCE,
					(CASE WHEN STS=0 THEN 'CC' ELSE (CASE WHEN STATUS_EC>0 THEN 'EC' ELSE 'AC' END) END) as STATUS,
					SCDL_GRP_NM AS AREA
				FROM c0002rpt_cc_time WHERE TGL='".$tglIn."'
				ORDER BY USER_ID,CUST_CHKIN,CUST_CHKOUT
			")->queryAll(),
		]);				
		$apSalesQT=$dailySalesQt->allModels;
		$excel_DailySalesQT = Postman4ExcelBehavior::excelDataFormat($apSalesQT);
		$excel_ceilsSalesQT = $excel_DailySalesQT['excel_ceils'];
		
		/* DAILY REPORT EXPIRED DATE  */
		$dailySalesExpired= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("
				SELECT 
						DATE_FORMAT(x1.TGL_KJG,'%Y:%m:%d') AS TGL_KJG,
						x6.SALES_NM,
						x1.CUST_ID,
						#x4.KD_ALIAS,
						x3.CUST_NM,
						x1.BRG_ID,x5.KD_ALIAS,x2.NM_BARANG,
						x1.QTY,x1.DATE_EXPIRED
				FROM c0012 x1
				LEFT JOIN b0001 x2 on x2.KD_BARANG=x1.BRG_ID
				LEFT JOIN c0001 x3 on x3.CUST_KD=x1.CUST_ID
				LEFT JOIN c0002 x4 on x4.KD_CUSTOMERS=x1.CUST_ID
				LEFT JOIN b0002 x5 on x5.KD_BARANG=x1.BRG_ID
				LEFT JOIN (	SELECT u1.id as USER_ID, u1.username as  USER_NM, u2.NM_FIRST as SALES_NM
								FROM dbm001.user u1 
								LEFT JOIN dbm_086.user_profile u2 on u2.ID_USER=u1.id
								WHERE u1.POSITION_SITE='CRM' AND u1.POSITION_LOGIN=1 AND u1.POSITION_ACCESS=2
							) x6 on x6.USER_ID=x1.USER_ID
				WHERE x1.TGL_KJG like '".$tglIn."%'
				GROUP BY x1.DATE_EXPIRED,x1.BRG_ID,x1.CUST_ID
				ORDER BY x1.USER_ID,x1.CUST_ID,x1.BRG_ID,x1.DATE_EXPIRED
			")->queryAll(),
		]);				
		$apSalesExpired=$dailySalesExpired->allModels;
		$excel_DailySalesExpired = Postman4ExcelBehavior::excelDataFormat($apSalesExpired);
		$excel_ceilsSalesExpired = $excel_DailySalesExpired['excel_ceils'];
		
		$excel_content = [
			 [ 	/* DAILY REPORT INVENTORY SALES */
				'sheet_name' => 'DAILY REPORT INVENTORY',
                'sheet_title' => [
					['TGL','SALESMD','CUST_ID_ESM','CUST_ID_DIST','CUST_NM','KD_BARANG_ESM','ID_BARANG_DIST','NM_BARANG',
					'STOCK/Pcs','RETURE/Pcs','REQUEST.ORDER/Pcs','SELL.IN/Pcs','SELL.OUT/Pcs','NOTE']
				],
			    'ceils' => $excel_ceilsDailySalesReport,
                'freezePane' => 'A2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),            
				'headerStyle'=>[					
					[
						'TGL' => ['align'=>'center'],
						'SALESMD' => ['align'=>'center'],
						'CUST_ID_ESM' =>['align'=>'center'],
						'CUST_ID_DIST' => ['align'=>'center'],
						'CUST_NM' =>['align'=>'center'],
						'KD_BARANG_ESM' => ['align'=>'center'],
						'ID_BARANG_DIST' =>['align'=>'center'],
						'NM_BARANG' => ['align'=>'center'],
						'STOCK/Pcs' =>['align'=>'center'],          
						'RETURE/Pcs' =>['align'=>'center'],              
						'REQUEST.ORDER/Pcs' => ['align'=>'center'],           
						'SELL.IN/Pcs' => ['align'=>'center'],          
						'SELL.OUT/Pcs' => ['align'=>'center'],          
						'NOTE' => ['align'=>'center']   
					]
					
				],
				'contentStyle'=>[
					[						
						'TGL' => ['align'=>'center'],
						'SALESMD' => ['align'=>'left'],
						'CUST_ID_ESM' =>['align'=>'center'],
						'CUST_ID_DIST' => ['align'=>'center'],
						'CUST_NM' =>['align'=>'left'],
						'KD_BARANG_ESM' => ['align'=>'center'],
						'ID_BARANG_DIST' =>['align'=>'center'],
						'NM_BARANG' => ['align'=>'left'],
						'STOCK/Pcs' =>['align'=>'right'],          
						'RETURE/Pcs' =>['align'=>'right'],              
						'REQUEST.ORDER/Pcs' => ['align'=>'right'],           
						'SELL.IN/Pcs' => ['align'=>'right'],          
						'SELL.OUT/Pcs' => ['align'=>'right'],          
						'NOTE' => ['align'=>'left']   
						]
				], 
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
			[	/* DAILY REPORT SALES QUALITY TIME  */
				'sheet_name' => 'DAILY REPORT QUALITY TIME',
                'sheet_title' => [
					['DATE','SALES.NAME','CUSTOMERS.ID','CUSTOMERS','START.ABSENSI','END.ABSENSI','CHECK.IN','CHECK.OUT','VISIT.TIME','DISTANCE','STATUS','AREA']
				],					
			    'ceils' => $excel_ceilsSalesQT,
                'freezePane' => 'A2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
				'headerStyle'=>[					
					[
						'DATE' => ['align'=>'center'],
						'SALES.NAME' =>['align'=>'center'], 
						'CUSTOMERS.ID' =>['align'=>'center'],
						'CUSTOMERS' =>['align'=>'center'],
						'START.ABSENSI' => ['align'=>'center'],
						'END.ABSENSI' =>['align'=>'center'],
						'CHECK.IN' => ['align'=>'center'],
						'CHECK.OUT' => ['align'=>'center'],
						'VISIT.TIME' => ['align'=>'center'],
						'DISTANCE' =>['align'=>'center'],
						'STATUS' => ['align'=>'center'],
						'AREA' => ['align'=>'center']
					]
					
				],
				'contentStyle'=>[
					[						
						'DATE' => ['align'=>'center'],
						'SALES.NAME' =>['align'=>'left'], 
						'CUSTOMERS.ID' =>['align'=>'center'],
						'CUSTOMERS' =>['align'=>'left'],
						'START.ABSENSI' => ['align'=>'center'],
						'END.ABSENSI' =>['align'=>'center'],
						'CHECK.IN' => ['align'=>'center'],
						'CHECK.OUT' => ['align'=>'center'],
						'VISIT.TIME' => ['align'=>'center'],
						'DISTANCE' =>['align'=>'center'],
						'STATUS' => ['align'=>'center'],
						'AREA' => ['align'=>'left']				
					]
				],            
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
			[	/* DAILY REPORT EXPIRED DATE  */
				'sheet_name' => 'DAILY REPORT EXPIRED DATE',
                'sheet_title' => [
					['DATE','SALES.NAME','CUSTOMERS.ID','CUSTOMERS','KD_BARANG_ESM','ID_BARANG_DIST','NM_BARANG','QTY','DATE_EXPIRED']
				],				
			    'ceils' => $excel_ceilsSalesExpired,
                'freezePane' => 'A2',
                'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
				'headerStyle'=>[					
					[
						'DATE' => ['align'=>'center'],
						'SALES.NAME' =>['align'=>'center'], 
						'CUSTOMERS.ID' =>['align'=>'center'],
						'CUSTOMERS' =>['align'=>'center'],
						'KD_BARANG_ESM' => ['align'=>'center'],
						'ID_BARANG_DIST' =>['align'=>'center'],
						'NM_BARANG' => ['align'=>'center'],
						'QTY' => ['align'=>'center'],
						'DATE_EXPIRED' => ['align'=>'center']
					]
					
				],
				'contentStyle'=>[
					[						
						'DATE' => ['align'=>'center'],
						'SALES.NAME' =>['align'=>'left'], 
						'CUSTOMERS.ID' =>['align'=>'center'],
						'CUSTOMERS' =>['align'=>'left'],
						'KD_BARANG_ESM' => ['align'=>'center'],
						'ID_BARANG_DIST' =>['align'=>'center'],
						'NM_BARANG' => ['align'=>'left'],
						'QTY' => ['align'=>'right'],
						'DATE_EXPIRED' => ['align'=>'center']		
					]
				],            
               'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],
		];		
		$excel_file = "PostmanDailySalesMd";
		$this->export4excel($excel_content, $excel_file,0); 
	}
	
	/*SEND EMAIL*/
	public function  actionSend(){
		
		/*Content template*/
		$cusCount=Yii::$app->db_esm->createCommand("
			SELECT count(u1.id) as CNT_ALL
			FROM dbm001.user u1 
			LEFT JOIN dbm_086.user_profile u2 on u2.ID_USER=u1.id
			WHERE u1.POSITION_SITE='CRM' AND u1.POSITION_LOGIN=1 AND u1.POSITION_ACCESS=2 AND u1.username LIKE 'salesmd%'
		")->queryAll();
			
		/*path & Name File*/
		//$rootyii=dirname(dirname(__DIR__)).'/cronjob/';
		$rootyii='/var/www/advanced/lukisongroup/cronjob/tmp_cronjob/';
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
			->setTo(['piter@lukison.com'])
			//->setTo(['hrd@lukison.com'])
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