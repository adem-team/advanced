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


//use lukisongroup\dashboard\models\RptesmGraph;
use dashboard\efenbi\models\Scheduledetail;
use dashboard\efenbi\models\ScheduledetailSearch;
use dashboard\efenbi\models\Schedulegroup;
use dashboard\efenbi\models\CustomerVisitImage;



class ReportController extends Controller
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
            //$conn = Yii::$app->db3;
            //$hasil = Yii::$app->db3->createCommand("SELECT c.SCDL_GROUP,c.CUST_KD, c.ALAMAT, c.CUST_NM,c.MAP_LAT,c.MAP_LNG,b.SCDL_GROUP_NM from c0001 c
             //                             left join c0007 b on c.SCDL_GROUP = b.ID")->queryAll();
			$hasil = Yii::$app->db3->cache(function ($db3) {
				return $db3->createCommand("SELECT c.SCDL_GROUP,c.CUST_KD, c.ALAMAT, c.CUST_NM,c.MAP_LAT,c.MAP_LNG,b.SCDL_GROUP_NM from c0001 c
                                          left join c0007 b on c.SCDL_GROUP = b.ID")->queryAll();
			}, 60);

            //  $hasil = $conn->createCommand("SELECT * from c0001 ")->queryAll();

            echo json_encode($hasil);

    }

	public function actionIndex()
    {
		//print_r($this->graphSchaduleWinLoss());
		//die();
		 if (\Yii::$app->user->isGuest) {
            return $this->render('../../../views/site/index_nologin'
            );
        }else{		
			
			/* CUSTOMER CATEHORI COUNT [modern,general,horeca,other]*/
			$dataProvider_CustPrn= new ArrayDataProvider([
				'key' => 'PARENT_ID',
				//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('count_kategory_customer_parent')")->queryAll(),
				'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
					return $db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('count_kategory_customer_parent')")->queryAll();
				}, 60),
				'pagination' => [
					'pageSize' => 50,
					]
			]);			
			$model_CustPrn=$dataProvider_CustPrn->getModels();
			$count_CustPrn=$dataProvider_CustPrn->getCount();
			
			/* COUNTER SALESMAN VISIT */
			//$dataCntrVisit=Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_customer_visit_winloss('COUNTER_DAILY','". date('Y-m-d')."','','')")->queryAll();
			$dataCntrVisit=Yii::$app->db_esm->cache(function ($db_esm) {
				return $db_esm->createCommand("CALL DASHBOARD_ESM_SALES_customer_visit_winloss('COUNTER_DAILY','". date('Y-m-d')."','','')")->queryAll();
			}, 60);
			$CntrVisit=$dataCntrVisit[0]['CNT_DAY']!=''? $dataCntrVisit[0]['CNT_DAY']:0;
			
			return $this->render('index',[
				/*COUNTER VISIT DAILY*/
				'CntrVisit'=>$CntrVisit,
				/* CUSTOMER CATEHORI COUNT [modern,general,horeca,other]*/
				'model_CustPrn'=>$model_CustPrn,
				'count_CustPrn'=>$count_CustPrn,  						// Condition  validation model_CustPrn offset array -ptr.nov-
				/*CHART*/
				'graphSchaduleWinLoss'=>$this->graphSchaduleWinLoss(),				
				/*CHART SALES INVENTORY */
				'dataSalesInventory'=>$this->graphEsmSalesInventory()				
			]);
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
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_customer_visit_winloss('GRAPH_COUNTER_DAILY','". date('Y-m-d')."','','')")->queryAll(),
			'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
					return $db_esm->createCommand("CALL DASHBOARD_ESM_SALES_customer_visit_winloss('GRAPH_COUNTER_DAILY','". date('Y-m-d')."','','')")->queryAll();
			}, 60),
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_customer_visit_winloss('GRAPH_COUNTER_DAILY','2016-04-03','','')")->queryAll(),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProvider=$AryDataProvider->getModels();		
		$resultWinLost=Json::encode($dataProvider);	
		$prn='{
				"chart": {				
					caption: "VISIT PROCESS",           
					// theme: "fint",					 
					showValues: "1",
					showZeroPlane: "1",       
					paletteColors: "#FF0033,#0B2536,#0075c2,#9E466B,#C5E323",
					usePlotGradientColor: "0",					
					zeroPlaneColor:"#003366",
					zeroPlaneAlpha: "100",
					zeroPlaneThickness: "3",
					divLineIsDashed: "1",
					divLineAlpha: "40",
					xAxisName: "time",
					yAxisName: "Visit",
					showValues: "1" , 			//MENAMPILKAN VALUE 
					showBorder: "1", 				//Border side Out 
					showCanvasBorder: "0",		//Border side inside
					//paletteColors: "#0075c2",	// WARNA GARIS	
					showAlternateHGridColor: "0",	//
					bgcolor: "#ffffff"
			    }, 
				"dataset": [{
					 "data":'.$resultWinLost.'
				}]              
			}';		
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
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('kategory_label','')")->queryAll(),
			'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
				return $db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('kategory_label','')")->queryAll();
			}, 60),
			 'pagination' => [
				'pageSize' => 100,
			],
		]);
		$dataProviderCtg=$AryDataProviderCtg->getModels();
		$resultCtg=Json::encode($dataProviderCtg);
		
		/*Item Value 1*/
		$AryDataProviderVal1= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_stock','BRG.ESM.2016.01.0001')")->queryAll(),
			'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
				return $db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_stock','BRG.ESM.2016.01.0001')")->queryAll();
			}, 60),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal1=$AryDataProviderVal1->getModels();
		$resultVal1=Json::encode($dataProviderVal1); 
		
		/*Item Value 2*/
		$AryDataProviderVal2= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_stock','BRG.ESM.2016.01.0002')")->queryAll(),
			'allModels'=>
			Yii::$app->db_esm->cache(function ($db_esm) {
				return $db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_stock','BRG.ESM.2016.01.0002')")->queryAll();
			}, 60),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal2=$AryDataProviderVal2->getModels();
		$resultVal2=Json::encode($dataProviderVal2); 
		
		/*Item Value 3*/
		$AryDataProviderVal3= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_stock','BRG.ESM.2016.01.0003')")->queryAll(),
			'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
				return $db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_stock','BRG.ESM.2016.01.0003')")->queryAll();
			}, 60),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal3=$AryDataProviderVal3->getModels();
		$resultVal3=Json::encode($dataProviderVal3); 
		
		/*Item Value 4*/
		$AryDataProviderVal4= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_stock','BRG.ESM.2016.01.0004')")->queryAll(),
			'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
				return $db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_stock','BRG.ESM.2016.01.0004')")->queryAll();
			}, 60),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal4=$AryDataProviderVal4->getModels();
		$resultVal4=Json::encode($dataProviderVal4); 
		
		/*Item Value 5*/
		$AryDataProviderVal5= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_stock','BRG.ESM.2016.01.0005')")->queryAll(),
			'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
				return $db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_stock','BRG.ESM.2016.01.0005')")->queryAll();
			}, 60),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderVal5=$AryDataProviderVal5->getModels();
		$resultVal5=Json::encode($dataProviderVal5); 
		
		
		/*SELL OUT ALL*/
		$AryDataProviderValSellOutAll= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_sell_out_all','')")->queryAll(),
			'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
				return $db_esm->createCommand("CALL DASHBOARD_ESM_SALES_inventory('value_sell_out_all','')")->queryAll();
			}, 60),
			 'pagination' => [
				'pageSize' => 100,
			]
		]);
		$dataProviderSellOutAll=$AryDataProviderValSellOutAll->getModels();
		$resultValSellOutAll=Json::encode($dataProviderSellOutAll); 
		
		$prn='{
			"chart": {				
				"caption":"MONTHLY  STOCK",     											 
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
							"data": '.$resultVal1.',
							"link": "JavaScript:showAlert(asdasd)"
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
	
	/*SALESMAN VISIT REPORT*/
	public function actionViewVisit(){
		$searchModel = new ScheduledetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataGroup =  ArrayHelper::map(Schedulegroup::find()->orderBy('SCDL_GROUP_NM')->asArray()->all(), 'ID','SCDL_GROUP_NM');
	    
		return $this->render('_view_visit', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'nmGroup'=>$dataGroup,
        ]);		
	}
	
	/*SALESMAN REPORT*/
	public function actionViewSalesman(){
		return $this->render('_view_sales');		
	}
	
	/*STOCK REPORT*/
	public function actionViewStock(){
		return $this->render('_view_stock');		
	}	
	
	/* TOTAl CHILD OF PARENT CUSTOMER */
	public function CountChildCustomer(){		
		$countChildParen= new ArrayDataProvider([
			'key' => 'CUST_KD',
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('ParentChildCountCustomer')")->queryAll(),
			'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
				return $db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('ParentChildCountCustomer')")->queryAll();
			}, 60),
			'pagination' => [
				'pageSize' => 50,
				]
		]);		
		//print_r(json_encode($resultCountChildParen));
		//print_r(json_decode($resultCountChildParen));
		//die(); 
		return Json::encode($countChildParen->getModels());
	}	
		
	/*STOCK ALL CUSTOMER*/
	public function actionViewAllCustomer(){
		/* CUSTOMER CATEHORI COUNT [modern,general,horeca,other]*/
		$dataProvider_CustPrn= new ArrayDataProvider([
			//'key' => 'PARENT_ID',
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('count_kategory_customer_parent')")->queryAll(),
			'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
				return $db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('count_kategory_customer_parent')")->queryAll();
			}, 60),
			'pagination' => [
				'pageSize' => 50,
				]
		]);			
		$model_CustPrn=$dataProvider_CustPrn->getModels();
		$count_CustPrn=$dataProvider_CustPrn->getCount();
		
		
		//print_r($this->CountChildCustomer());
		//die();
		return $this->render('_view_all_customer',[
			/* CUSTOMER CATEHORI COUNT [modern,general,horeca,other]*/
			'model_CustPrn'=>$model_CustPrn,
			'count_CustPrn'=>$count_CustPrn,  						// Condition  validation model_CustPrn offset array -ptr.nov-
			'resultCountChildParen'=>$this->CountChildCustomer()
				
		]);		
	}
	
	/*STOCK MEDERN CUSTOMER*/
	public function actionViewModernCustomer(){
		return $this->render('_view_modern_customer');		
	}
	
	/*STOCK GENERAL CUSTOMER*/
	public function actionViewGeneralCustomer(){
		return $this->render('_view_general_customer');		
	}
	
	/*STOCK HORECA CUSTOMER*/
	public function actionViewHorecaCustomer(){
		return $this->render('_view_horeca_customer');		
	}
	
	/*STOCK OTHER CUSTOMER*/
	public function actionViewOtherCustomer(){
		return $this->render('_view_other_customer');		
	}	
	
}
