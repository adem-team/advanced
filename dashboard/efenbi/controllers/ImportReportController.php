<?php

namespace dashboard\efenbi\controllers;

use Yii;
use yii\web\Controller;
use kartik\helpers\Html;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;


use lukisongroup\dashboard\models\RptesmGraph;

class ImportReportController extends Controller
{	

	public function behaviors()    {
        return ArrayHelper::merge(parent::behaviors(), [
			'corsFilter' => [
				'class' => \yii\filters\Cors::className(),
				'cors' => [
					// restrict access to
					'Origin' => ['*'],
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
	
	/*JSON MAP*/
	public function actionMap()
    {
            $conn = Yii::$app->db3;
            $hasil = $conn->createCommand("SELECT c.SCDL_GROUP,c.CUST_KD, c.ALAMAT, c.CUST_NM,c.MAP_LAT,c.MAP_LNG,b.SCDL_GROUP_NM from c0001 c
                                          left join c0007 b on c.SCDL_GROUP = b.ID")->queryAll();

            //  $hasil = $conn->createCommand("SELECT * from c0001 ")->queryAll();

            echo json_encode($hasil);

    }

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
			$dataCntrVisit=Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_customer_visit_winloss('COUNTER_DAILY','". date('Y-m-d')."','','')")->queryAll();
			$CntrVisit=$dataCntrVisit[0]['CNT_DAY']!=''? $dataCntrVisit[0]['CNT_DAY']:0;
			
			return $this->render('index');
		};	
    }
	
	/* ========== ESM-STOCK-ALL ============
	 * Chart Type LINE 
	 * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
	 * =====================================
	*/
	protected function graphSchaduleWinLoss(){
		$AryDataProvider= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_customer_visit_winloss('GRAPH_COUNTER_DAILY','". date('Y-m-d')."','','')")->queryAll(),
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_customer_visit_winloss('GRAPH_COUNTER_DAILY','2016-04-03','','')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProvider=Json::encode($AryDataProvider->getModels());		
		$prn=$dataProvider;
		return $prn;
	}
	
	/* ========= ESM-STOCK + SELL OUT ALL ====
	 * Chart Type MSLINE
	 * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
	 * =======================================
	*/
	public function graphEsmSalesInventory(){		
		/*Category*/
		$AryDataProviderCtg= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('kategory_label','')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			],
		]);
		$dataProviderCtg=$AryDataProviderCtg->getModels();
		$resultCtg=Json::encode($dataProviderCtg);
		
		/*Item Value 1*/
		$AryDataProviderVal1= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_stock','BRG.ESM.2016.01.0001')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal1=$AryDataProviderVal1->getModels();
		$resultVal1=Json::encode($dataProviderVal1); 
		
		/*Item Value 2*/
		$AryDataProviderVal2= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_stock','BRG.ESM.2016.01.0002')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal2=$AryDataProviderVal2->getModels();
		$resultVal2=Json::encode($dataProviderVal2); 
		
		/*Item Value 3*/
		$AryDataProviderVal3= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_stock','BRG.ESM.2016.01.0003')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal3=$AryDataProviderVal3->getModels();
		$resultVal3=Json::encode($dataProviderVal3); 
		
		/*Item Value 4*/
		$AryDataProviderVal4= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_stock','BRG.ESM.2016.01.0004')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal4=$AryDataProviderVal4->getModels();
		$resultVal4=Json::encode($dataProviderVal4); 
		
		/*Item Value 5*/
		$AryDataProviderVal5= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_stock','BRG.ESM.2016.01.0005')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal5=$AryDataProviderVal5->getModels();
		$resultVal5=Json::encode($dataProviderVal5); 
		
		
		/*SELL OUT ALL*/
		$AryDataProviderValSellOutAll= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_sell_out_all','')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderSellOutAll=$AryDataProviderValSellOutAll->getModels();
		$resultValSellOutAll=Json::encode($dataProviderSellOutAll); 
		
		$prn='{
			"chart": {				
				"caption":"SALESMAN DAILY STOCK",     											 
				"plotgradientcolor": "",
				"bgcolor": "FFFFFF",
				"showalternatehgridcolor": "0",
				"divlinecolor": "CCCCCC",
				"showvalues": "0",
				"showcanvasborder": "0",
				"canvasborderalpha": "0",
				"canvasbordercolor": "CCCCCC",
				"canvasborderthickness": "1",
				"yaxismaxvalue": "30000",
				"captionpadding": "30",
				"yaxisvaluespadding": "15",
				"legendshadow": "0",
				"legendborderalpha": "0",
				"palettecolors": "#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",
				"showplotborder": "0",
				"showborder": "0"				
			},
			"categories": [
				{"category":'.$resultCtg.'}
			]
			,
			"dataset": [
				{
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
				}
			],
			"lineset": [					
				{
					"seriesname": "Sell Out",
					"showValues": "0",
					"data": '.$resultValSellOutAll.'
				}, 						
					
			]
		}';
		return $prn;
	}
	
	/*SALESMAN REPORT*/
	public function actionViewSalesman(){
		return $this->render('_view_sales');		
	}
	
	/*STOCK REPORT*/
	public function actionViewStock(){
		return $this->render('_view_stock');		
	}	
	
}
