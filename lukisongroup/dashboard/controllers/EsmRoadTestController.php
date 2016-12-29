<?php

namespace lukisongroup\dashboard\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\Response;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\filters\ContentNegotiator;
use yii\filters\AccessControl;

use lukisongroup\roadsales\models\SalesRoadHeader;
use lukisongroup\roadsales\models\SalesRoadHeaderSearch;
use lukisongroup\roadsales\models\SalesRoadImage;
use lukisongroup\roadsales\models\SalesRoadImageSearch;
use lukisongroup\roadsales\models\SalesRoadReport;
use lukisongroup\roadsales\models\SalesRoadList;
use lukisongroup\roadsales\models\SalesRoadListSearch;

use app\models\dashboard\RptEsm;
use app\models\dashboard\RptEsmSearch;
use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\master\models\Barang;
use lukisongroup\master\models\BarangSearch;
use lukisongroup\master\models\ValidationLoginPrice;

class EsmRoadTestController extends Controller
{
	//\Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
     public function behaviors(){
        return ArrayHelper::merge(parent::behaviors(), [
			'bootstrap'=> [
				'class' => ContentNegotiator::className(),
				'formats' => [
					'application/json' => Response::FORMAT_JSON,'charset' => 'UTF-8',
					
				],
				'languages' => [
					'en',
					'de',
				],
			],
			'corsFilter' => [
				'class' => \yii\filters\Cors::className(),
				'cors' => [
					// restrict access to
					'Origin' => ['http://lukisongroup.com','http://www.lukisongroup.com','http://labtest1-erp.int'],
					'Access-Control-Request-Method' => ['POST', 'PUT','GET'],
					// Allow only POST and PUT methods
					'Access-Control-Request-Headers' => ['X-Wsse'],
					// Allow only headers 'X-Wsse'
					'Access-Control-Allow-Credentials' => true,
					// Allow OPTIONS caching
					'Access-Control-Max-Age' => 3600,
					// Allow the X-Pagination-Current-Page header to be exposed to the browser.
					'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
				]		
			],
        ]);		
    }
	
	/**
     * Before Action Index
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	   public function beforeAction($action){
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
     * Lists all Barang models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$searchModel = new BarangSearch();
        //$dataProvider = $searchModel->searchBarangESM(Yii::$app->request->queryParams);
         return $this->render('dashboard', [
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        ]); 
    }

	
	function actionChart(){
		$request = Yii::$app->request;		
		$tgl= $request->get('tgl');
		$tglParam=$tgl!=''?$tgl:date('Y-m-d');
		$bulan = date('F - Y', strtotime($tglParam));
		//RANGE DATE FOR SET CATEGORY 
		$ctg=Yii::$app->arrayBantuan->ArrayDayOfMonth($tglParam);
		
		//ROAD LIST CASE - FOR SET SERIALNAME DATASET
		$searchModelSeriesname = new SalesRoadListSearch();
        $dataProviderSeriesname = $searchModelSeriesname->search(Yii::$app->request->queryParams);
		$dataSet=$dataProviderSeriesname->getModels();
		
		//VALUE - DATASET CHART
		$queryDataValue= Yii::$app->db_esm->createCommand("
			call SALES_ROAD_rpt1('GROUP_ALL','69','".$tglParam."')
		")->queryAll();		
		$apDataValue= new ArrayDataProvider([
			//'key' => 'ID',
			'allModels'=>$queryDataValue,
			'pagination' => [
				'pageSize' => 500,
			]
		]);
		$dataValue=$apDataValue->getModels(); 
				
		//SET DATASET/SERINAME CHART
		foreach($dataSet as $key1 => $value1){
			$nilaiData[]='';
			unset($dataSeachRslt);
			foreach($ctg as $key2 => $value2){
				$nilaiData[]=['value'=>$value2['label']];
				$search=['tgl'=>$value2['TGL'],'case_id'=>$value1['ID'],'user_id'=>'69'];
				//$dataPencarian[]=Yii::$app->arrayBantuan->findWhere($resultDetail, $search);
				//$dataPencarianTest[]=Yii::$app->arrayBantuan->findWhere($resultDetail,$search);
				$dataPencarian=Yii::$app->arrayBantuan->findWhere($dataValue,$search);
				if($dataPencarian!=false){
					$dataSeachRslt[]=$dataPencarian;
				}
				else{
					$dataSeachRslt[]=[	
						"case_id"=> $value1['ID'],					
						"user_id"=> $value2['user_id'],
						"tgl"=> $value2['TGL'],						
						"label"=> $value1['CASE_NAME'],
						"value"=> 0					
					];
				}
				//$dataPencarian=array_intersect_key($dataProvider->getModels(), $search);
				// if (array_key_exists($value2['label'], $dataProvider->getModels())) {			
				
			// }
			}
			$aryDataSet[]=[	'seriesname'=>$value1['CASE_NAME'],
								'data'=>$dataSeachRslt
							];
			
		}		
		
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " Sales Activity Visits",
				"subCaption": "The focus of activities Salesman",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": '.'"'.Yii::$app->arrayBantuan->ArrayPaletteColors().'"'.',
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",
				"showCanvasBorder": "0",
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "0",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "1",
				"divLineDashLen": "1",
				"divLineGapLen": "1",
				"xAxisName": '.'"'.$bulan.'"'.',
				"showValues": "1"                      
			},
			"categories": [
				{
					"category": '.Json::encode($ctg).'
				}
			],
			"dataset": '.Json::encode($aryDataSet).'
			
		}';
		return  $rsltSrc;
		/*
		 * NOTE 	: CHECK  beforeAction for array disply.
		 * Error 	: Response content must not be an array, use Json::encode($aryDataSet)
		*/
	}
	
	/**
     * SALES VISIT ACTIVITY
     * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
	 * ARRAY RETURN mengunakan "beforeAction".
	 * Pritty Jeson tanpa mengunakan "beforeAction".
     */
	public function actionVisit(){
		$request = Yii::$app->request;		
		$tgl= $request->get('tgl');
		$tglParam=$tgl!=''?$tgl:date('Y-m-d');
		$bulan = date('F - Y', strtotime($tglParam));
		//***get count data visiting
		$_visiting= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT 	x1.TGL, month(x1.TGL) AS bulan,DATE_FORMAT(x1.TGL,'%d') as TGL_NO,LEFT(COMPONEN_hari(x1.TGL),2) as hari, 
						x1.CCval,x1.ACval,x2.ECval,x1.CASEval,x2.ACval_COMPARE			
				FROM
				(	SELECT 
					sum(CASE WHEN  a1.CUST_ID <> '' AND a1.STATUS_CASE<>1 THEN  1 ELSE 0 END) AS CCval,
					sum(CASE WHEN a1.CUST_ID <> '' AND a1.STATUS= 1 THEN  1 ELSE 0 END) AS ACval,
					sum(CASE WHEN a1.CUST_ID <> '' AND a1.STATUS_CASE=1 THEN  1 ELSE 0 END) AS CASEval,a1.TGL
					FROM c0002scdl_detail a1 LEFT JOIN c0001 a2 ON a2.CUST_KD=a1.CUST_ID
					WHERE a1.STATUS<>3 AND a2.CUST_NM not LIKE 'customer demo%'
					GROUP BY  a1.TGL
				) x1 LEFT JOIN
				(	SELECT sum(CASE WHEN  ID IS NOT NULL THEN  1 ELSE 0 END) AS ACval_COMPARE,
							sum(CASE WHEN STATUS_EC IS NOT NULL THEN  1 ELSE 0 END) AS ECval,TGL
					FROM c0002rpt_cc_time x1
					WHERE CUST_NM not LIKE 'customer demo%'	
					GROUP BY TGL
				) x2 on x2.TGL=x1.TGL
				#WHERE MONTH(x1.TGL)=10 AND x1.TGL <= CURDATE()
				WHERE MONTH(x1.TGL)=month('".$tglParam."') AND x1.TGL <= CURDATE()
			")->queryAll(), 
			'pagination' => [
					'pageSize' => 200,
			],				 
		]);
		$_modelVisiting=ArrayHelper::toArray($_visiting->getModels());		
		foreach($_modelVisiting as $row => $value){			
			//$hari[]=["label"=>$value['hari']."-".$value['TGL_NO']."-".$value['bulan']];					
			$hari[]=["label"=> $value['TGL_NO']];					
			$cc[]=["value"=> strval($value['CCval'])];					
			$ac[]=["value"=>strval($value['ACval'])];					
			$ec[]=["value"=> strval($value['ECval'])];					
			$case[]=["value"=> strval($value['CCval']+$value['CASEval'])];
			$acSum[] =$value['ACval'];
			$ecSum[] =$value['ECval'];
		};
		//***get AVG AC FROM data visiting
		$cntAC=count($acSum);
		$sumAC =array_sum($acSum);
		$avgAC=($sumAC/$cntAC);
		$avgACnm="AvgAC (".number_format($avgAC,2).")";
		//***get AVG EC FROM data visiting
		$cntEC=count($ecSum);
		$sumEC =array_sum($ecSum);
		$avgEC=($sumEC/$cntEC);
		$avgECnm="AvgEC (".number_format($avgEC,2).")";
		
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " Sales Activity Visits",
				"subCaption": "The focus of activities Salesman",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": "#cc0000,#1e86e5,#16ce87,#b7843d",
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",
				"showCanvasBorder": "0",
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "0",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "1",
				"divLineDashLen": "1",
				"divLineGapLen": "1",
				"xAxisName": '.'"'.$bulan.'"'.',
				"showValues": "0"               
			},
			"categories": [
				{
					"category": '.Json::encode($hari).'
				}
			],
			"dataset": [
				{
					"seriesname": "CC",
					"data":'.Json::encode($cc).'
				}, 
				{
					"seriesname": "AC",
					"data":'.Json::encode($ac).'
				},
				{
					"seriesname": "EC",
					"data":'.Json::encode($ec).'
				},
				{
					"seriesname": "CASE",
					"data":'.Json::encode($case).'
				}
			],
			"trendlines": [
                {
                    "line": [
                        {
                            "startvalue": "'.$avgAC.'",
                            "color": "#0b0d0f",
                            "valueOnRight": "1",
                            "displayvalue":"'.$avgACnm.'"
                        },
						{
                            "startvalue": "'.$avgEC.'",
                            "color": "#0b0d0f",
                            "valueOnRight": "1",
                            "displayvalue": "'.$avgECnm.'"
                        }
                    ]
                }
            ]
			
		}';
		
		return json::decode($rsltSrc);			// not user "beforeAction".
		//return $rsltSrc;							// use "beforeAction".
		//return Json::encode($rsltSrc);
	}
	
	
	public function actionCoba(){
		$searchModel = new SalesRoadHeaderSearch([
			'USER_ID'=>'34'
		]);
		
		        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->searchAryChart(Yii::$app->request->queryParams);
		$listImg=$dataProvider->getModels();
		//print_r($listImg[0]->CASE_NM);
		
		/**
		 * FILE WITH OTHER FILED DATA ARRAY 
		 * @author ptr.nov [ptr.nov@gmail.com]
		 * @since 1.2
		 * FOREACH FIELD DATA ARRAY 
		 * ADD FILED NO Array
		 * RESULT ROW DATA.
		 */
		foreach ($listImg as $key1 => $nilai1){
			$val=explode(",",$listImg[$key1]['CASE_ID']);
			foreach ($val as $key2 => $nilai2){
					$resultDetail[]=['USER_ID'=>$listImg[$key1]['USER_ID'],'TGL'=>$listImg[$key1]['CREATED_AT'],'CASE_ID'=>$nilai2];					
			};
			
		}	
	
		// $dataProvider2= new ArrayDataProvider([
			// 'key' => 'USER_ID',
			// 'allModels'=>$resultDetail,
			// 'sort' => [
				// 'attributes' => ['TGL'],
			// ],
			// 'pagination' => [
				// 'pageSize' => 500,
			// ]
		// ]); 
		
		// foreach($resultDetail as $key => $value){
			// $model = new SalesRoadReport();
			// $model->TGL = $value['TGL'];				//date("Y-m-d");;
			// $model->CASE_ID = $value['CASE_ID'];		//'123';
			// $model->CREATED_AT = $value['TGL'];			//date("Y-m-d H:m:s");;
			// $model->CREATED_BY = $value['USER_ID'];		//'123';
			// $model->save();
		// }
		
		
		//print_r($result);
		//$resultX = ArrayHelper::index($result, null, 'user');
		//print_r($dataProvider2->getCount());
		// $groupBy1=self::array_group_by($dataProvider2->getModels(),'TGL');
		// $groupBy2=self::array_group_by($groupBy1,'USER_ID');
		// $groupBy3=self::array_group_by($groupBy2,'CASE_NM');
		//$aryRslt=self::sortArrayByKey($groupBy2,'USER_ID'	,true,false);
		//print_r($groupBy3);
		//return  json_encode($groupBy3);
		//return count($dataProvider2->getModels(), COUNT_RECURSIVE);
		
		// if (in_array("Irix", $os)) {
			// echo "Got Irix";
		// }
		
		

		print_r($resultDetail);
		
	}
	
	
	
	
	
	//ROAD LIST FIND
    protected function findModelList($id)
    {
        if (($model = SalesRoadList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	/**
	 * =================================
	 * ==== PROCEDURE REFRENCE =========
	 * ====   SALES_ROAD_rpt1  =========
	 * =================================
	*/
	/*
		BEGIN
			DECLARE fnsh INTEGER DEFAULT 0;
			DECLARE Suser_id INTEGER DEFAULT NULL;
			DECLARE Scase_id,Scase_nm TEXT DEFAULT NULL;
			DECLARE STgl DATE DEFAULT NULL;
			DEClARE HeaderCursor CURSOR FOR SELECT group_concat(CASE_ID) AS CASE_ID
																				 ,CREATED_BY AS USER_ID
																				 ,DATE_FORMAT(CREATED_AT,'%Y-%m-%d') AS CREATED_AT
																				 ,group_concat(CASE_NM) AS CASE_NM				 		 
																	FROM c0022Header
																	WHERE MONTH(TGL)=DATE_FORMAT(IN_TGL,'%m')AND YEAR(TGL)=DATE_FORMAT(IN_TGL,'%Y')
																	GROUP BY CREATED_BY;
			DECLARE CONTINUE HANDLER FOR NOT FOUND SET fnsh = 1;
			#DROP DINAMIK TMP TABLE.
			#DROP TABLE IF EXISTS temp_explode; 
			SET @tblNm := CONCAT('tmpTblRoad_',IN_USER);
				SET @SQL_TBL_DROP := CONCAT("DROP TABLE IF EXISTS ",@tblNm,"; "); 
				PREPARE stmt FROM @SQL_TBL_DROP; 
				EXECUTE stmt;
				DEALLOCATE PREPARE stmt; 
			#CREATTE DINAMIK TMP TABLE.
		  #CREATE TEMPORARY TABLE temp_explode (id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, case_id VARCHAR(40),user_id VARCHAR(40),tgl VARCHAR(40)); 
			SET @SQL_TBL_CREATED := CONCAT("CREATE TEMPORARY TABLE ",@tblNm," (id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, case_id VARCHAR(40),user_id VARCHAR(40),tgl VARCHAR(40))"); 
				PREPARE stmt FROM @SQL_TBL_CREATED; 
				EXECUTE stmt;
				DEALLOCATE PREPARE stmt;

			#CONTINUE LOOP DATA.
			OPEN HeaderCursor;
				GetForeach: LOOP
				FETCH HeaderCursor INTO Scase_id,Suser_id,STgl,Scase_nm;
				IF fnsh = 1 THEN 
					LEAVE GetForeach;
				END IF;
						SET @usr=CONCAT("'),(",Suser_id,"),('",STgl,"')),(('");
						#SET @usr=CONCAT("'),(",Suser_id,")),(('");
						SET @sql := CONCAT("INSERT INTO ",@tblNm,"(case_id,user_id,tgl) VALUES ((", REPLACE(QUOTE(Scase_id), ",",@usr), '),(',Suser_id,'),("',STgl,'"))');  
						#SET @sql := CONCAT("INSERT INTO temp_explode (case_id,user_id) VALUES ((", REPLACE(QUOTE(Scase_id), ",","'),(1)),(('"), '),(',Suser_id,'))');  
						#SET @sql := CONCAT('INSERT INTO temp_explode (case_id) VALUES (', REPLACE(QUOTE(Scase_id), ',',"'),('"), ')');  
						#SET @sql := CONCAT('INSERT INTO temp_explode (case_id,user_id) VALUES ((', REPLACE(QUOTE(Scase_id), ',', '\'),(1)), ((\''), '),(1))');  
						#SET @sql := CONCAT('INSERT INTO temp_explode (user_id,case_id) VALUES ("',Suser_id,'",(', REPLACE(QUOTE(Scase_id), ',', '\'), (\''), '))');  
						#SET @sql := CONCAT('INSERT INTO temp_explode (case_id,user_id) VALUES ("', Scase_id,'","', Suser_id,'")');  
						PREPARE stmt FROM @sql; 
						EXECUTE stmt;
						DEALLOCATE PREPARE stmt; 
						#SELECT Scase_id,Suser_id,STgl,Scase_nm;

				END LOOP GetForeach;
			CLOSE HeaderCursor;
			
			#SELECT @sql;

			#===============================
		  #==== CHART LINE REQUREMENT ====
		  #===============================
			#PARAMETER(MENU,IN_USER,IN_TGL )
		  #SALES_ROAD_rpt1('DEFAULT','69','2016-12-01')
		  #SALES_ROAD_rpt1('GROUP_ALL','69','2016-12-01')
		  #SALES_ROAD_rpt1('GROUP_USER','69','2016-12-01')
			IF MENU='DEFAULT' THEN
				SELECT * FROM tmpTblRoad_69;
			END IF;

			IF MENU='GROUP_ALL' THEN
				SELECT x1.case_id,x1.user_id,x1.tgl,x2.CASE_NAME as label, COUNT(x1.case_id) AS value 
				FROM tmpTblRoad_69 x1 LEFT JOIN c0022List x2 on x2.ID=x1.case_id
				GROUP BY x1.tgl,x1.case_id
				ORDER BY x1.case_id,x1.tgl;
			END IF;

			IF MENU='GROUP_USER' THEN
				SELECT x1.case_id,x1.user_id,x1.tgl,x2.CASE_NAME as label, COUNT(x1.case_id) AS value 
				FROM tmpTblRoad_69 x1 LEFT JOIN c0022List x2 on x2.ID=x1.case_id
				WHERE x1.user_id=IN_USER 
				GROUP BY x1.user_id,x1.case_id,x1.tgl
				ORDER BY x1.user_id,x1.case_id,x1.tgl; 
			END IF;

		END
	*/
	
	
}

