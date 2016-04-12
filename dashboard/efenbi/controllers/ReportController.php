<?php

namespace dashboard\efenbi\controllers;

use Yii;
use yii\web\Controller;
use kartik\helpers\Html;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

use lukisongroup\dashboard\models\RptesmGraph;

class ReportController extends Controller
{	
	public function actionIndex()
    {
		 if (\Yii::$app->user->isGuest) {
            return $this->render('../../../views/site/index_nologin'
            );
        }else{		
		
			/* CUSTOMER CATEHORI COUNT [modern,general,horeca,other]*/
			$dataProvider_CustPrn= new ArrayDataProvider([
				'key' => 'PARENT_ID',
				'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('count_kategory_customer_parent')")->queryAll(),
				'pagination' => [
					'pageSize' => 50,
					]
			]);			
			$model_CustPrn=$dataProvider_CustPrn->getModels();
			$count_CustPrn=$dataProvider_CustPrn->getCount();
			
			/* COUNTER SALESMAN VISIT */
			$dataCntrVisit=Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_customer_visit('COUNTER_DAILY','". date('Y-m-d')."','','')")->queryAll();
			$CntrVisit=$dataCntrVisit[0]['CNT_DAY']!=''? $dataCntrVisit[0]['CNT_DAY']:0;
			
			return $this->render('index',[
				/*COUNTER VISIT DAILY*/
				'CntrVisit'=>$CntrVisit,
				/* CUSTOMER CATEHORI COUNT [modern,general,horeca,other]*/
				'model_CustPrn'=>$model_CustPrn,
				'count_CustPrn'=>$count_CustPrn,  						// Condition  validation model_CustPrn offset array -ptr.nov-
				/*CHART*/
				'dataEsmStockAll'=>$this->graphEsmStockAll(),
				'graphEsmStockPerSku'=>$this->graphEsmStockPerSku()
			]);
		};	
    }
	
	/* ========== ESM-STOCK-ALL ============
	 * Chart Type LINE 
	 * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
	 * =====================================
	*/
	protected function graphEsmStockAll(){
		$AryDataProvider= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_customer_visit('GRAPH_COUNTER_DAILY','". date('Y-m-d')."','','')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProvider=Json::encode($AryDataProvider->getModels());		
		$prn='{
			"chart": {
				caption: "VISIT PROCESS",           
				 theme: "fint",					 
                showValues: "1",
                showZeroPlane: "1",                                
                zeroPlaneColor:"#003366",
                zeroPlaneAlpha: "100",
                zeroPlaneThickness: "3",
                divLineIsDashed: "0",
                divLineAlpha: "40",
				xAxisName: "time",
                yAxisName: "Visit",
				showValues: "1" , 			//MENAMPILKAN VALUE 
				showBorder: "1", 				//Border side Out 
				showCanvasBorder: "0",		//Border side inside
				showAlternateHGridColor: "0",	//
				bgcolor: "#ffffff"
			                  
                 
            },
			
			"data":'.$dataProvider.'
		}';
		return $prn;
	}
	
	/* ========== ESM-STOCK-PER-SKU =========
	 * Chart Type MSLINE
	 * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
	 * =======================================
	*/
	protected function graphEsmStockPerSku(){		
		/*Category*/
		$AryDataProviderCtg= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("CALL ESM_GRAPH_stock_per_sku('kategory_label','')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			],
		]);
		$dataProviderCtg=$AryDataProviderCtg->getModels();
		$resultCtg=Json::encode($dataProviderCtg);
		
		/*Item Value 1*/
		$AryDataProviderVal1= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL ESM_GRAPH_stock_per_sku('value','BRG.ESM.2016.01.0001')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal1=$AryDataProviderVal1->getModels();
		$resultVal1=Json::encode($dataProviderVal1); 
		
		/*Item Value 2*/
		$AryDataProviderVal2= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL ESM_GRAPH_stock_per_sku('value','BRG.ESM.2016.01.0002')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal2=$AryDataProviderVal2->getModels();
		$resultVal2=Json::encode($dataProviderVal2); 
		
		/*Item Value 3*/
		$AryDataProviderVal3= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL ESM_GRAPH_stock_per_sku('value','BRG.ESM.2016.01.0003')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal3=$AryDataProviderVal3->getModels();
		$resultVal3=Json::encode($dataProviderVal3); 
		
		/*Item Value 4*/
		$AryDataProviderVal4= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL ESM_GRAPH_stock_per_sku('value','BRG.ESM.2016.01.0004')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal4=$AryDataProviderVal4->getModels();
		$resultVal4=Json::encode($dataProviderVal4); 
		
		/*Item Value 5*/
		$AryDataProviderVal5= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL ESM_GRAPH_stock_per_sku('value','BRG.ESM.2016.01.0005')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal5=$AryDataProviderVal5->getModels();
		$resultVal5=Json::encode($dataProviderVal5); 
		
		$prn='{
			"chart": {
				"caption": "UPDATE ESM STOCK PER SKU",
				"showValues": "1" , 
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "paletteColors": "#FF0033,#0B2536,#0075c2,#9E466B,#C5E323",
                "bgcolor": "#ffffff",
                "showBorder": "1",
                "showShadow": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "legendBorderAlpha": "1",
                "legendShadow": "1",
                "showAxisLines": "0",
                "showAlternateHGridColor": "0",
                "divlineThickness": "1",
                "divLineIsDashed": "1",
                "divLineDashLen": "1",
                "divLineGapLen": "1"			
            },
			"categories": [{
				"category":'.$resultCtg.'
			}],
			"dataset": [
				 {
                    "seriesname": "MAXI Cassava Chips Balado",
                    "data": '.$resultVal1.'
                }, 
                {
                    "seriesname": "MAXI Talos Chips Black Paper",
                    "data":'.$resultVal2.'
                },
				{
                    "seriesname": "MAXI Talos Roasted Corn",
                    "data":'.$resultVal3.'
                },
				{
                    "seriesname": "MAXI Cassava Crackers Hot Spicy",
                    "data": '.$resultVal4.'
                },
				{
                    "seriesname": "MAXI mixed Roots",
                    "data": '.$resultVal5.'
                }
			]
		}';
		return $prn;
	}
}
