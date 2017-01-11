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
use kartik\widgets\Spinner;	
use ptrnov\fusionchart\Chart;


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

class EsmRoadController extends Controller
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
		//$loading=Spinner::widget(['id'=>'spn1-load-road','preset' => 'large', 'align' => 'center', 'color' => 'blue']);
		/*  $js='
			//document.getElementById("page").style.display = "none";
           //document.getElementById("spn1-load-road").style.diplay = "none";
		 
			';
		
            $this->getView()->registerJs($js); */
        //$searchModel = new BarangSearch();
        //$dataProvider = $searchModel->searchBarangESM(Yii::$app->request->queryParams);
        return $this->render('dashboard', [
			//$loading=>$loading,
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        ]); 
		
    }

	/**
	 * CARI TANGGAL -> CHECK DATE
	 * @author Piter Novian [ptr.nov@gmail.com]
	 * @since 2.0
	*/
	public function actionAmbilTanggal()
	{
		$model = new \yii\base\DynamicModel(['tgl_detail','USER_ID']);
		$model->addRule(['tgl_detail','USER_ID'], 'required');
		if (!$model->load(Yii::$app->request->post())){
			return $this->renderAjax('_indexform', [
				'model'=>$model,
				'arySalesUser'=>self::arySalesUser()
			]);
		}else{
			if(Yii::$app->request->isAjax){
				$model->load(Yii::$app->request->post());
				return Json::encode(\yii\widgets\ActiveForm::validate($model));
			}
		}
	}
	
	public function arySalesUser(){

    	$sql = (new \yii\db\Query())
    			->select(['u.id as id', 'u.username as username','up.NM_FIRST as NM_FIRST'])
   				 ->from('dbm001.user u')
   				 ->leftJoin('dbm_086.user_profile up','u.id = up.ID_USER')
   				 ->where(['u.status'=>10,'u.POSITION_SITE'=>'ERP','u.POSITION_LOGIN'=>0,'u.POSITION_ACCESS'=>1])
    			 ->all();

      return ArrayHelper::map($sql,'id',function ($sql, $defaultValue) {
			return $sql['username'] . '-' . $sql['NM_FIRST']; 
		});

    }
	
	/**
     * ROAD SALES - DAY OF MONTH.
     * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
	 * ARRAY RETURN mengunakan "beforeAction".
	 * Pritty Jeson tanpa mengunakan "beforeAction".
     */
	function actionChart(){
		//INPUT DATA 
		$request = Yii::$app->request;		
		$tgl= $request->get('tgl');
		$userIdParam= '69';//$request->get('id')==0?0:$request->get('id');
		$tglParam=$tgl!=''?$tgl:date('Y-m-d');
		$bulan = date('F - Y', strtotime($tglParam));
		if ($userIdParam!=0){
			$qrySrc="call SALES_ROAD_rpt1('GROUP_USER','".$userIdParam."','".$tglParam."')";
		}else{
			$qrySrc="call SALES_ROAD_rpt1('GROUP_ALL','".$userIdParam."','".$tglParam."')";
		};
				
		//RANGE DATE FOR SET CATEGORY 
		$ctg=Yii::$app->arrayBantuan->ArrayDayOfMonth($tglParam);
		
		//ROAD LIST CASE - FOR SET SERIALNAME DATASET
		$searchModelSeriesname = new SalesRoadListSearch();
        $dataProviderSeriesname = $searchModelSeriesname->search(Yii::$app->request->queryParams);
		$dataSet=$dataProviderSeriesname->getModels();
		
		//DATA VALUE - DATASET CHART		
		$queryDataValue= Yii::$app->db_esm->createCommand($qrySrc)->queryAll();			
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
     * ROAD SALES - MONTHLY CHART PIE
     * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
	 * ARRAY RETURN mengunakan "beforeAction".
	 * Pritty Jeson tanpa mengunakan "beforeAction".
     */
	function actionPie(){
		//INPUT DATA 
		$request = Yii::$app->request;		
		$tgl= $request->get('tgl');
		$userIdParam= '69';//$request->get('id')==0?0:$request->get('id');
		$tglParam=$tgl!=''?$tgl:date('Y-m-d');
		$bulan = date('F - Y', strtotime($tglParam));
		if ($userIdParam!=0){
			$qrySrcPie="call SALES_ROAD_rpt1('MONTH_GROUP_USER','".$userIdParam."','".$tglParam."')";
		}else{
			$qrySrcPie="call SALES_ROAD_rpt1('MONTH_GROUP_ALL','".$userIdParam."','".$tglParam."')";
		};
				
		//ROAD LIST CASE - FOR SET SERIALNAME DATASET
		$searchModelSeriesname = new SalesRoadListSearch();
        $dataProviderSeriesname = $searchModelSeriesname->search(Yii::$app->request->queryParams);
		$dataSet=$dataProviderSeriesname->getModels();
		
		//DATA VALUE - DATASET CHART		
		$queryDataValue= Yii::$app->db_esm->createCommand($qrySrcPie)->queryAll();			
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
				$nilaiData[]=['value'=>$value2['label']];
				$search=['case_id'=>$value1['ID'],'user_id'=>'69'];
				$dataPencarian=Yii::$app->arrayBantuan->findWhere($dataValue,$search);
				if($dataPencarian!=false){
					$dataSeachRslt=$dataPencarian;
				}
				else{
					$dataSeachRslt=[	
						//"case_id"=> $value1['ID'],					
						//"user_id"=> $value2['user_id'],
						//"tgl"=> $value2['TGL'],						
						"label"=> $value1['CASE_NAME'],
						"value"=> "0"					
					];
				}
				
			$aryDataSet[]=$dataSeachRslt;
			
		}		
		
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " Percent Road Case",
				"subCaption": '.'"'.$bulan.'"'.',
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": '.'"'.Yii::$app->arrayBantuan->ArrayPaletteColors().'"'.',
				"bgColor": "#ffffff",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showBorder": "0",
				"use3DLighting": "0",
				"showShadow": "0",
				"enableSmartLabels": "1",
				"startingAngle": "0",
				"showPercentValues": "1",
				"showPercentInTooltip": "0",
				"decimals": "1",
				"toolTipColor": "#ffffff",
				"toolTipBorderThickness": "0",
				"toolTipBgColor": "#000000",
				"toolTipBgAlpha": "80",
				"toolTipBorderRadius": "2",
				"toolTipPadding": "5",
				"showHoverEffect": "1",
				"showLegend": "1",
				"legendBgColor": "#ffffff",
				"legendItemFontSize": "10",
				"legendItemFontColor": "#666666",
				"useDataPlotColorForLabels": "1"       
			},
			"data": '.Json::encode($aryDataSet).'
			
		}';
		return  $rsltSrc;
		/*
		 * NOTE 	: CHECK  beforeAction for array disply.
		 * Error 	: Response content must not be an array, use Json::encode($aryDataSet)
		*/
	}
	
	
	/**
     * ROAD SALES - MONTHLY CHART BAR
     * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
	 * ARRAY RETURN mengunakan "beforeAction".
	 * Pritty Jeson tanpa mengunakan "beforeAction".
     */
	function actionBar(){
		//INPUT DATA 
		$request = Yii::$app->request;		
		$tgl= $request->get('tgl');
		$userIdParam= '69';//$request->get('id')==0?0:$request->get('id');
		$tglParam=$tgl!=''?$tgl:date('Y-m-d');
		$bulan = date('F - Y', strtotime($tglParam));
		if ($userIdParam!=0){
			$qrySrcPie="call SALES_ROAD_rpt1('MONTH_GROUP_USER','".$userIdParam."','".$tglParam."')";
		}else{
			$qrySrcPie="call SALES_ROAD_rpt1('MONTH_GROUP_ALL','".$userIdParam."','".$tglParam."')";
		};
				
		//ROAD LIST CASE - FOR SET SERIALNAME DATASET
		$searchModelSeriesname = new SalesRoadListSearch();
        $dataProviderSeriesname = $searchModelSeriesname->search(Yii::$app->request->queryParams);
		$dataSet=$dataProviderSeriesname->getModels();
		
		//DATA VALUE - DATASET CHART		
		$queryDataValue=Yii::$app->db_esm->createCommand($qrySrcPie)->queryAll();			
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
				$nilaiData[]=['value'=>$value2['label']];
				$search=['case_id'=>$value1['ID'],'user_id'=>'69'];
				$dataPencarian=Yii::$app->arrayBantuan->findWhere($dataValue,$search);
				if($dataPencarian!=false){
					$dataSeachRslt=$dataPencarian;
				}
				else{
					$dataSeachRslt=[	
						//"case_id"=> $value1['ID'],					
						//"user_id"=> $value2['user_id'],
						//"tgl"=> $value2['TGL'],						
						"label"=> $value1['CASE_NAME'],
						"value"=> "0"					
					];
				}
				
			$aryDataSet[]=$dataSeachRslt;
			
		}		
		
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " Percent Road Case",
				"subCaption": '.'"'.$bulan.'"'.',
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": '.'"'.Yii::$app->arrayBantuan->ArrayPaletteColors().'"'.',
				"bgColor": "#ffffff",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showBorder": "0",
				"use3DLighting": "0",
				"showShadow": "0",
				"enableSmartLabels": "1",
				"startingAngle": "0",
				"showPercentValues": "1",
				"showPercentInTooltip": "0",
				"decimals": "1",
				"toolTipColor": "#ffffff",
				"toolTipBorderThickness": "0",
				"toolTipBgColor": "#000000",
				"toolTipBgAlpha": "80",
				"toolTipBorderRadius": "2",
				"toolTipPadding": "5",
				"showHoverEffect": "1",
				"showLegend": "1",
				"legendBgColor": "#ffffff",
				"legendItemFontSize": "10",
				"legendItemFontColor": "#666666",
				"useDataPlotColorForLabels": "1"       
			},
			"data": '.Json::encode($aryDataSet).'
			
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
	
	
	//ROAD LIST FIND
    protected function findModelList($id)
    {
        if (($model = SalesRoadList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}



