<?php

namespace lukisongroup\dashboard\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\dashboard\RptEsm;
use app\models\dashboard\RptEsmSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\filters\ContentNegotiator;
use yii\web\Response;

use lukisongroup\dashboard\models\RptesmGraph;

/**
 * DashboardController implements the CRUD actions for Dashboard model.
 */
class RptEsmChartSalesmdController extends Controller
{
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
			]
        ]);		
    }

	/**
     * DAILY CUSTOMER VISIT.
     * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
     */
	public function actionVisit(){
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
				WHERE MONTH(x1.TGL)=10 AND x1.TGL <= CURDATE()
			")->queryAll(), 
			'pagination' => [
					'pageSize' => 200,
			],				 
		]);
		$_modelVisiting=ArrayHelper::toArray($_visiting->getModels());		
		foreach($_modelVisiting as $row => $value){			
			$hari[]=["label"=>$value['hari']."-".$value['TGL_NO']."-".$value['bulan']];					
			$cc[]=["value"=> strval($value['CCval'])];					
			$ac[]=["value"=>strval($value['ACval'])];					
			$ec[]=["value"=> strval($value['ECval'])];					
			$case[]=["value"=> strval($value['CASEval'])];
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
				"caption": " Daily Customers Visits",
				"subCaption": "Custommer Call, Active Customer, Efictif Customer",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": "#cc0000,#e7ff1f,#16ce87,#1e86e5",
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
				"xAxisName": "Day",
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
		
		return json::decode($rsltSrc);
		//return $avgAc;
	}
	
	/**
     * DAILY STOCK VISIT.
     * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
     */
	public function actionVisitStock(){
		//***get count data visiting
		$_visitingStock= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT x1.TGL,month(x1.TGL) AS bulan,DATE_FORMAT(x1.TGL,'%d') as TGL_NO,LEFT(COMPONEN_hari(x1.TGL),2) as hari, 
					x2.KD_BARANG ,x4.NM_BARANG, 
					SUM(CASE WHEN x2.SO_TYPE=5 AND x2.SO_QTY>=0 THEN x2.SO_QTY ELSE 0 END) as STOCK,
					SUM(CASE WHEN x2.SO_TYPE=6 AND x2.SO_QTY>=0 THEN x2.SO_QTY ELSE 0 END) as SELL_IN,
					SUM(CASE WHEN x2.SO_TYPE=7 AND x2.SO_QTY>=0 THEN x2.SO_QTY ELSE 0 END) as SELL_OUT,
					SUM(CASE WHEN x2.SO_TYPE=8 AND x2.SO_QTY>=0 THEN x2.SO_QTY ELSE 0 END) as RETURN_INV,
					SUM(CASE WHEN x2.SO_TYPE=9 AND x2.SO_QTY>=0 THEN x2.SO_QTY ELSE 0 END) as REQUEST_INV
				FROM c0002scdl_detail x1 INNER JOIN so_t2 x2 ON  x2.TGL=x1.TGL AND x2.CUST_KD=x1.CUST_ID LEFT JOIN c0001 x3 on x3.CUST_KD=x1.CUST_ID
				LEFT JOIN b0001 x4 on x4.KD_BARANG=x2.KD_BARANG
				WHERE  month(x1.TGL)=10  
				GROUP BY x1.TGL,x2.KD_BARANG
			")->queryAll(), 
			'pagination' => [
					'pageSize' => 200,
			],				 
		]);
		$_modelVisitingStock=ArrayHelper::toArray($_visitingStock->getModels());
		//
		foreach($_modelVisitingStock as $row => $value){			
			$hari[]=["label"=>$value['hari']."-".$value['TGL_NO']."-".$value['bulan']];	
			if ($value['KD_BARANG']=='BRG.ESM.2016.01.0001'){
				$stockProdak1[]=["value"=>$value['STOCK']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0003'){
				$stockProdak2[]=["value"=>$value['STOCK']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0004'){
				$stockProdak3[]=["value"=>$value['STOCK']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0005'){
				$stockProdak4[]=["value"=>$value['STOCK']];	
			};		
		};
		//Grouping Array for CATEGORY CHART
		$a='';
		foreach($hari as $key => $value){
			if($a!=$value['label']){
				$hariCtg[]=["label"=>$value['label']];
				$a=$value['label'];
			}
		};	
			
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " Daily Stock Update",
				"subCaption": "Maxi Product",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": "#cc0000,#e7ff1f,#16ce87,#1e86e5",
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
				"xAxisName": "Day",
				"showValues": "0"               
			},
			"categories": [
				{
					"category": '.Json::encode($hariCtg).'
				}
			],
			"dataset": [
				{
					"seriesname": "Cassava Chips Balado",
					"data":'.Json::encode($stockProdak1).'
				}, 
				{
					"seriesname": "Talos Roasted Corn",
					"data":'.Json::encode($stockProdak2).'
				},
				{
					"seriesname": "Cassava Crackers Hot Spicy",
					"data":'.Json::encode($stockProdak3).'
				},
				{
					"seriesname": "mixed Roots",
					"data":'.Json::encode($stockProdak4).'
				}
			]			
		}';
		
		return json::decode($rsltSrc);
		//return $keyHari;
	}
	
	
	public function actionVisitTest(){
		$rsltSrc='{
            "chart": {
                "caption": " Daily visits to customers",
                "subCaption": "Custommer Call, Active Customer, Efictif Customer",
                "captionFontSize": "12",
                "subcaptionFontSize": "10",
                "subcaptionFontBold": "0",
                "paletteColors": "#cc0000,#e7ff1f,#16ce87,#1e86e5",
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
                "xAxisName": "Day",
                "showValues": "0"               
            },
            "categories": [
                {
                    "category": [
                        { "label": "Mon" }, 
                        { "label": "Tue" }, 
                        { "label": "Wed" },                    
                        { "label": "Thu" }, 
                        { "label": "Fri" }, 
                        { "label": "Sat" }, 
                        { "label": "Sun" }
                    ]
                }
            ],
            "dataset": [
                {
                    "seriesname": "Bakersfield Central",
                    "data": [
                        { "value": "15123" }, 
                        { "value": "14233" }, 
                        { "value": "25507" }, 
                        { "value": "9110" }, 
                        { "value": "15529" }, 
                        { "value": "20803" }, 
                        { "value": "19202" }
                    ]
                }, 
                {
                    "seriesname": "Los Angeles Topanga",
                    "data": [
                        { "value": "13400" }, 
                        { "value": "12800" }, 
                        { "value": "22800" }, 
                        { "value": "12400" }, 
                        { "value": "15800" }, 
                        { "value": "19800" }, 
                        { "value": "21800" }
                    ]
                }
            ], 
            "trendlines": [
                {
                    "line": [
                        {
                            "startvalue": "17022",
                            "color": "#6baa01",
                            "valueOnRight": "1",
                            "displayvalue": "Average"
                        }
                    ]
                }
            ]
        }';
		
		return json::decode($rsltSrc);
		
	}
	
	
	public function actionVisitStockTest(){
		$rsltSrc='{
			"chart": {
				"palette": "3",
				"caption": "Worldwide sales report of mobile devices",
				"subcaption": "Samsung & Nokia",
				"yaxisname": "Sales in million units",
				"plotgradientcolor": " ",
				"numbersuffix": "M",
				"showvalues": "0",
				"divlinealpha": "30",
				"labelpadding": "10",
				"plottooltext": "
					$seriesname
					Year :  $label 
					Sales : $datavalue
				",
				"legendborderalpha": "0",
				"showborder": "0"
			},
			"categories": [
				{
					"category": [
						{
							"label": "2010"
						},
						{
							"label": "2011"
						},
						{
							"label": "2012"
						},
						{
							"label": "2013"
						},
						{
							"label": "2014"
						},
						{
							"label": "2015"
						},
						{
							"label": "2016
		(Project
		ed)"
						}
					]
				}
			],
			"dataset": [
				{
					"seriesname": "Samsung",
					"color": "A66EDD",
					"data": [
						{
							"value": "281.07"
						},
						{
							"value": "315.05"
						},
						{
							"value": "384.63"
						},
						{
							"value": "444.45"
						},
						{
							"value": "405.94"
						},
						{
							"value": "401.37"
						},
						{
							"value": "390.76",
							"dashed": "1"
						}
					]
				},
				{
					"seriesname": "Nokia/Microsoft",
					"color": "F6BD0F",
					"data": [
						{
							"value": "461.32"
						},
						{
							"value": "422.48"
						},
						{
							"value": "333.93"
						},
						{
							"value": "250.81"
						},
						{
							"value": "179.38"
						},
						{
							"value": "126.61"
						},
						{
							"value": "95.85",
							"dashed": "1"
						}
					]
				}
			]
		}
		
		';
	}
	
	
	
	/**
	 * ARRAY GROUPING Serialize
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
