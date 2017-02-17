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
use lukisongroup\master\models\CustomercallTimevisitSearch;

class PostmanDailySalesmdController extends Controller
{
    public function behaviors()
    {
        return [
			'export4excel' => [
				'class' => Postman4ExcelBehavior::className(),
				//'downloadPath'=>Yii::getAlias('@lukisongroup').'/cronjob/',
				'downloadPath'=>'/var/www/backup/salesmd/excel/',
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
	 * EXPORT DATA CUSTOMER TO EXCEL
	 * export_data
	*/
	public function actionExport(){
		//Rpt Of [selasa=2;minggu=0]
		$x=date('N', strtotime(date("Y-m-d")));		
		if ($x!=2 or $x!=7){
			$tglIn=date("Y-m-d");//'2016-09-07';
			//$tglIn='2016-10-27';
			//DAILY REPORT INVENTORY SALES
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
						SUM(CASE WHEN x2.SO_TYPE=5 THEN (CASE WHEN  x2.SO_QTY<>-1 THEN x2.SO_QTY ELSE 0 END) ELSE 0 END) as STOCK,
						SUM(CASE WHEN x2.SO_TYPE=8 THEN (CASE WHEN  x2.SO_QTY<>-1 THEN x2.SO_QTY ELSE 0 END) ELSE 0 END) as RETURN_INV,
						SUM(CASE WHEN x2.SO_TYPE=9 THEN (CASE WHEN  x2.SO_QTY<>-1 THEN x2.SO_QTY ELSE 0 END) ELSE 0 END) as REQUEST_INV,
						SUM(CASE WHEN x2.SO_TYPE=6 THEN (CASE WHEN  x2.SO_QTY<>-1 THEN x2.SO_QTY ELSE 0 END) ELSE 0 END) as SELL_IN,
						SUM(CASE WHEN x2.SO_TYPE=7 THEN (CASE WHEN  x2.SO_QTY<>-1 THEN x2.SO_QTY ELSE 0 END) ELSE 0 END) as SELL_OUT,				
						x5.ISI_MESSAGES
						FROM c0002rpt_cc_time x1 INNER JOIN so_t2 x2 ON  x2.TGL=x1.TGL AND x2.CUST_KD=x1.CUST_ID 
						LEFT JOIN b0001 x4 on x4.KD_BARANG=x2.KD_BARANG		
						LEFT JOIN c0014 x5 on x5.TGL=x1.TGL AND x5.KD_CUSTOMER=x1.CUST_ID AND x5.ID_USER=x1.USER_ID
						LEFT JOIN c0002 x6 on x6.KD_CUSTOMERS=x1.CUST_ID
						LEFT JOIN b0002 x7 on x7.KD_BARANG=x2.KD_BARANG
						LEFT JOIN dbm_086.user_profile x8 on x8.ID_USER=x1.USER_ID
						WHERE  x1.TGL='".$tglIn."' AND x1.USER_ID NOT IN ('61','62')
						GROUP BY x1.CUST_ID,x2.KD_BARANG	
						ORDER BY x1.USER_ID,x1.CUST_ID
				")->queryAll(),
			]);	
			$apDailySalesReport=$dailySalesReport->allModels;
			$excel_DailySalesReport = Postman4ExcelBehavior::excelDataFormat($apDailySalesReport);
			$excel_ceilsDailySalesReport = $excel_DailySalesReport['excel_ceils'];
			
			// DAILY REPORT SALES QUALITY TIME  
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
						SCDL_GRP_NM AS AREA,
						(CASE WHEN STS_CASE=0 THEN 'PLAN' ELSE 'CASE' END) as SCDL_EVENT,
						(CASE WHEN STS_CASE_PIC='' THEN 'SYSTEM' ELSE STS_CASE_PIC END) AS AUTHORIZED 
					FROM c0002rpt_cc_time WHERE TGL='".$tglIn."' AND USER_ID NOT IN ('61','62')
					ORDER BY USER_ID,CUST_CHKIN,CUST_CHKOUT
				")->queryAll(),
			]);				
			$apSalesQT=$dailySalesQt->allModels;
			$excel_DailySalesQT = Postman4ExcelBehavior::excelDataFormat($apSalesQT);
			$excel_ceilsSalesQT = $excel_DailySalesQT['excel_ceils'];
			
			// DAILY REPORT EXPIRED DATE 
			$dailySalesExpired= new ArrayDataProvider([
				'allModels'=>Yii::$app->db_esm->createCommand("
					SELECT 
							DATE_FORMAT(x1.TGL_KJG,'%Y-%m-%d') AS TGL_KJG,
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
					WHERE x1.TGL_KJG like '".$tglIn."%' AND x1.USER_ID NOT IN ('61','62')
					GROUP BY x1.DATE_EXPIRED,x1.BRG_ID,x1.CUST_ID
					ORDER BY x1.USER_ID,x1.CUST_ID,x1.BRG_ID,x1.DATE_EXPIRED
				")->queryAll(),
			]);				
			$apSalesExpired=$dailySalesExpired->allModels;
			$excel_DailySalesExpired = Postman4ExcelBehavior::excelDataFormat($apSalesExpired);
			$excel_ceilsSalesExpired = $excel_DailySalesExpired['excel_ceils'];
			
			$excel_content = [
				  [ 	// DAILY REPORT INVENTORY SALES 
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
				[	// DAILY REPORT SALES QUALITY TIME 
					'sheet_name' => 'DAILY REPORT QUALITY TIME',
					'sheet_title' => [
						['DATE','SALES.NAME','CUSTOMERS.ID','CUSTOMERS','START.ABSENSI','END.ABSENSI','CHECK.IN','CHECK.OUT','VISIT.TIME','DISTANCE','STATUS','AREA','SCDL.EVENT','SCDL.AUTHORIZED']
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
							'AREA' => ['align'=>'center'],
							'SCDL.EVENT'=>['align'=>'center'],
							'SCDL.AUTHORIZED'=>['align'=>'center']
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
							'AREA' => ['align'=>'left'],
							'SCDL.EVENT'=>['align'=>'center'],
							'SCDL.AUTHORIZED'=>['align'=>'left']
						]
					],            
				   'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
				   'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
				],
				[	// DAILY REPORT EXPIRED DATE  
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
			$excel_file = "PostmanDailySalesMd"."-".$tglIn;
			$this->export4excel($excel_content, $excel_file,0); 
				
			/**
			 * EXPORT IMAGE64 & NAME FROM ARRAY DATA PROVIDER
			 * SET ARRAY
			 * @author Piter Novian [ptr.nov@gmail.com] 
			*/	
			$imgKosong="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";
			//==DATA ROWs
			$aryDataImg= new ArrayDataProvider([
					'allModels'=>Yii::$app->db_esm->createCommand("
						SELECT x1.TGL,x1.USER_ID,x1.USER_NM,x1.SALES_NM,x1.CUST_NM ,x1.IMG_DECODE_START,x1.IMG_DECODE_END
						FROM c0002rpt_cc_time x1 
						WHERE x1.TGL='".$tglIn."' AND x1.USER_ID NOT IN ('61','62')
						#GROUP BY x1.TGL,x1.USER_ID					
					")->queryAll(),
					'pagination' => [
						'pageSize' => 1000,
					]
				]);
			//print_r($aryDataImg->getModels());
			
			//SET GROUPING USER_ID
			$dataGroup=self::array_group_by($aryDataImg->getModels(),'USER_ID');
			
			//FOREACH GROUPING BY USER_ID		
			foreach ($dataGroup as $key => $nilai){
				//FIND FILTER BY KEY USER_ID
				$filterDataGroup= \yii\helpers\ArrayHelper::filter($dataGroup, [$key]);
				//SET OUT KEY/PARENT FILTER
				$isiDataGroup=[];
				foreach($filterDataGroup as $row => $value){
					$isiDataGroup=ArrayHelper::merge($isiDataGroup,$filterDataGroup[$row]);
				};	
					$dataRow1=[];
					$dataRow2=[];
					$aryRslt=[];
					
					//DATA RESULT
					foreach($isiDataGroup as $row => $value){
						$img64row1=[
							[
								'img64'=>$value['IMG_DECODE_START']!=''?$value['IMG_DECODE_START']:$imgKosong,
								'name'=>$value['TGL'].'_'.$value['CUST_NM'].'_1START'.'-'.$value['SALES_NM'],
								'tgl'=>$value['TGL'],
								'sales_nm'=>$value['SALES_NM']
							]
						];
						$img64row2=[
							[
								'img64'=>$value['IMG_DECODE_END']!=''?$value['IMG_DECODE_END']:$imgKosong,
								'name'=>$value['TGL'].'_'.$value['CUST_NM'].'_2END'.'-'.$value['SALES_NM'],
								'tgl'=>$value['TGL'],
								'sales_nm'=>$value['SALES_NM']
							]
						];				
						$dataRow1=ArrayHelper::merge($dataRow1,$img64row1);
						$dataRow2=ArrayHelper::merge($dataRow2,$img64row2);
					};	 
					$aryRslt=ArrayHelper::merge($dataRow1,$dataRow2);
					
					/**
					 * EXPORT IMAGE64 & NAME FROM ARRAY
					 * PUT TO FILE & PATH
					 * @author Piter Novian [ptr.nov@gmail.com] 
					*/	
					//$rootPathImageZip='/var/www/advanced/lukisongroup/cronjob/tmp_cronjob/img/';
					//$rootPathImageZip=Yii::getAlias('@lukisongroup').'/cronjob/tmp_cronjob/img/';				
					$rootPathImageZip='/var/www/backup/salesmd/photo/';				
					foreach($aryRslt as $key => $value){
						$dataImgScr=$value['img64'];
						$namefile=$value['name'];
						$img = str_replace('data:image/jpg;base64,', '', $dataImgScr);
						$img = str_replace(' ', '+', $img);
						$data = base64_decode($img);
						$file = $rootPathImageZip.$namefile.'.jpg';
						$success = file_put_contents($file, $data);
					} 
					/**
					 * IMAGE FILE TO ZIP
					 * FOREACH NAME FROM ARRAY
					 * REMOVE ALL IMAGE
					 * @author Piter Novian [ptr.nov@gmail.com] 
					*/	
					$zip = new \ZipArchive();
					$tgl=$aryRslt[0]['tgl'];
					$sales_nm=$aryRslt[0]['sales_nm'];
					$zip_name = $rootPathImageZip.$tgl.'_visit_image-'.$sales_nm.'.zip'; // Zip name
					$zip->open($zip_name,  \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
					foreach ($aryRslt as $file => $value) {
						$path = $rootPathImageZip.$value['name'].'.jpg';
						if(file_exists($path)){
							$zip->addFromString(basename($path),  file_get_contents($path));  
						}else{
							echo"file does not exist";
						}
						unlink($path);
					};
					$zip->close(); 			
			}
		}			
	}
	
	/*SEND EMAIL*/
	public function  actionSend(){
		$x=date('N', strtotime(date("Y-m-d")));	 //date to string days	
		if ($x!=2 or $x!=7){ 					 //off selasa dan minggu
			$tglIn=date("Y-m-d");
			//$tglIn='2016-10-27';
			/*Content template*/
			$cusCount=Yii::$app->db_esm->createCommand("
				SELECT
					x2.TGL,x2.SALES_NM,x2.AREA
					,sum(x2.STS_CC) as TTL_CC
					,sum(x2.STS_AC) as TTL_AC
					,sum(x2.STS_EC) as TTL_EC
					,sum(CASE WHEN x2.SALES_NM<>'' THEN 1 ELSE 0 END) as TTL_SALES
					#
				FROM
					(	SELECT
							x1.TGL,x1.SALES_NM,x1.AREA
							,sum(CASE WHEN x1.CUST_ID<>'' THEN 1 ELSE 0 END) as STS_CC
							,sum(CASE WHEN x1.STATUS='AC' THEN 1 ELSE 0 END) as STS_AC
							,sum(CASE WHEN x1.STATUS='EC' THEN 1 ELSE 0 END) as STS_EC
						FROM
							(	SELECT 
									TGL,SALES_NM,
									CUST_ID,CUST_NM,	
									ABSEN_MASUK,ABSEN_KELUAR,	
									CUST_CHKIN AS CHEKIN, CUST_CHKOUT AS CHECKOUT,LIVE_TIME AS VISIT_TIME, JRK_TEMPUH AS DISTANCE,
									(CASE WHEN STS=0 THEN 'CC' ELSE (CASE WHEN STATUS_EC>0 THEN 'EC' ELSE 'AC' END) END) as STATUS,
									SCDL_GRP_NM AS AREA,
									(CASE WHEN STS_CASE=0 THEN 'PLAN' ELSE 'CASE' END) as SCDL_EVENT,
									(CASE WHEN STS_CASE_PIC='' THEN 'SYSTEM' ELSE STS_CASE_PIC END) AS AUTHORIZED 
								FROM c0002rpt_cc_time WHERE TGL='".$tglIn."' AND USER_ID NOT IN ('61','62')
								ORDER BY USER_ID,CUST_CHKIN,CUST_CHKOUT
							) x1 GROUP BY x1.SALES_NM
					) x2
			")->queryAll();
			
			
			$dataList= new ArrayDataProvider([
				'allModels'=>Yii::$app->db_esm->createCommand("
					SELECT x1.TGL,x1.USER_ID,x1.USER_NM,x1.SALES_NM
					FROM c0002rpt_cc_time x1 
					WHERE x1.TGL='".$tglIn."' AND x1.USER_ID NOT IN ('61','62')
					GROUP BY x1.TGL,x1.USER_ID					
				")->queryAll(),
			]); 		
			
			/**
			 * MAP ATTACH 
			 * EXISTING ATTACH xlsx,zip
			 * @author Piter Novian [ptr.nov@gmail.com] 
			*/	
			//$rootPathExcel='/var/www/advanced/lukisongroup/cronjob/tmp_cronjob/';			
			//$rootPathImageZip='/var/www/advanced/lukisongroup/cronjob/tmp_cronjob/img/';
			//$rootPathExcel=Yii::getAlias('@lukisongroup').'/cronjob/tmp_cronjob/';	
			$rootPathExcel='/var/www/backup/salesmd/excel/';
			$rootPathImageZip='/var/www/backup/salesmd/photo/';				
			//$rootPathImageZip=Yii::getAlias('@lukisongroup').'/cronjob/tmp_cronjob/img/';				
			$filename = "PostmanDailySalesMd"."-".$tglIn;
			if ($dataList){
				$listImg=$dataList->getModels();				
				$filenameAll[]=[
						'path'=>$rootPathExcel.$filename.'.xlsx',
						'filename'=>$filename,
						'type'=>'xlsx'
					];
				foreach($listImg as $row => $value){
					$fileAttach[]=[
						'path'=>$rootPathImageZip.$value['TGL'].'_visit_image-'.$value['SALES_NM'].'.zip',
						'filename'=>$value['TGL'].'_visit_image-'.$value['SALES_NM'],
						'type'=>'zip'
					];					
					
				};	
				$filenameAll=ArrayHelper::merge($filenameAll,$fileAttach);				
			}; 
			//print_r($filenameAll);
				
			/**
			 * SEND EMAIL
			 * EXISTING ATTACH xlsx,zip
			 * @author Piter Novian [ptr.nov@gmail.com] 
			*/	
			//Get Content
			$contentBody= $this->renderPartial('_postmanBodyDailySales',[
				'cusCount'=>$cusCount
			]);	
				
			// Send-to,Subject,Body
			Yii::$app->mailer->compose()
			->setFrom(['postman@lukison.com' => 'LG-ERP-POSTMAN'])
			//->setTo(['it-dept@lukison.com'])
			//->setTo(['piter@lukison.com'])
			//->setTo(['hrd@lukison.com'])
			->setTo(['sales_esm@lukison.com','marketing_esm@lukison.com','dpi@lukison.com'])
			//->setTo(['timbul.siregar@lukison.com'])
			->setSubject('POSTMAN - DAILY REPORT SALES MD')
			//->setSubject('test');
			->setHtmlBody($contentBody);
			// Array data Attach, checking exiting file
			foreach($filenameAll as $row => $value){
				if (file_exists($value['path'])) {
					Yii::$app->mailer->compose()->attach($value['path'],[$value['filename'],$value['type']]);
				}
			}	 	
			Yii::$app->mailer->compose()->send(); 		 
		}
	}
	
	/**
	 * ARRAY GROUPING 
	 * @author Piter Novian [ptr.nov@gmail.com] 
	*/	
	private static function array_group_by($arr, $key)
	{
		if (!is_array($arr)) {
			trigger_error('array_group_by(): The first argument should be an array', E_USER_ERROR);
		}
		if (!is_string($key) && !is_int($key) && !is_float($key)) {
			trigger_error('array_group_by(): The key should be a string or an integer', E_USER_ERROR);
		}
		// Load the new array, splitting by the target key
		$grouped = [];
		foreach ($arr as $value) {
			$grouped[$value[$key]][] = $value;
		}
		// Recursively build a nested grouping if more parameters are supplied
		// Each grouped array value is grouped according to the next sequential key
		if (func_num_args() > 2) {
			$args = func_get_args();
			foreach ($grouped as $key => $value) {
				$parms = array_merge([$value], array_slice($args, 2, func_num_args()));
				$grouped[$key] = call_user_func_array('array_group_by', $parms);
			}
		}
		return $grouped;
	}
	
}
?>