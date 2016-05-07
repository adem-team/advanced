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

class AnzSalesController extends Controller
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
			$dataProvider= new ArrayDataProvider([
				//'key' => 'PARENT_ID',
				'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_VISIT_header1('ALL_HEAD1')")->queryAll(),
				'pagination' => [
					'pageSize' => 5,
					]
			]);			
			//$dataProviderX=$dataProvider->getModels();
			//$count_CustPrn=$dataProvider_CustPrn->getCount();
			
			/* COUNTER SALESMAN VISIT */
			//$dataCntrVisit=Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_customer_visit_winloss('COUNTER_DAILY','". date('Y-m-d')."','','')")->queryAll();
			//$CntrVisit=$dataCntrVisit[0]['CNT_DAY']!=''? $dataCntrVisit[0]['CNT_DAY']:0;
			
			return $this->render('index',[
				'dataProviderX'=>$dataProvider,
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
		
	
}
