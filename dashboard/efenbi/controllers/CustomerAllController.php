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

class CustomerAllController extends Controller
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
	
	/* TOTAl CHILD OF PARENT CUSTOMER */
	public function CountChildCustomer(){		
		$countChildParen= new ArrayDataProvider([
			'key' => 'CUST_KD',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('ParentChildCountCustomer')")->queryAll(),
			'pagination' => [
				'pageSize' => 50,
				]
		]);		
		//print_r(json_encode($resultCountChildParen));
		//print_r(json_decode($resultCountChildParen));
		//die(); 
		return Json::encode($countChildParen->getModels());
	}	
	
	/* Count Customer Active */
	public function CountCustomerActiveCall(){		
		$dataCAC= new ArrayDataProvider([
			'key' => 'TGL_STATUS',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_VISIT_detail_status('all_value_parent_count_visit')")->queryAll(),
			'pagination' => [
				'pageSize' => 500,
				]
		]);		
		//print_r(json_encode($resultCountChildParen));
		//print_r(json_decode($resultCountChildParen));
		//die(); 
		/*SET Models*/
		$modelCAC=$dataCAC->getModels();
		/*SET GROUP*/
		$modelGrp = ArrayHelper::map($modelCAC,'CUST_GRP','label');
		foreach($modelGrp as $key1 ){								
			$dataX=[];
			foreach($modelCAC as $key2 =>$value[]){
				if ($key1==$value[$key2]['label']){
					$dataX[]=['value'=>$value[$key2]['value']];					
				}				
			};
			$data[]=['seriesname'=>$key1,'data'=> $dataX];
		}
		//return Json::encode($dataCAC->getModels());
		return Json::encode($data);
		
		
		
	}
	
	public function actionIndex()
    {
		//print_r($this->CountCustomerActiveCall());
		//die();
		if (\Yii::$app->user->isGuest) {
            return $this->render('../../../views/site/index_nologin'
            );
        }else{		
		
			/* CUSTOMER CATEHORI COUNT [modern,general,horeca,other]*/
			$dataProvider_CustPrn= new ArrayDataProvider([
				//'key' => 'PARENT_ID',
				'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('count_kategory_customer_parent')")->queryAll(),
				'pagination' => [
					'pageSize' => 50,
					]
			]);			
			$model_CustPrn=$dataProvider_CustPrn->getModels();
			$count_CustPrn=$dataProvider_CustPrn->getCount();		
			
			//print_r($this->CountChildCustomer());
			//die();
			return $this->render('index',[
				/* CUSTOMER CATEHORI COUNT [modern,general,horeca,other]*/
				'model_CustPrn'=>$model_CustPrn,
				'count_CustPrn'=>$count_CustPrn,  						
				/*STOCK ALL CUSTOMER*/
				'resultCountChildParen'=>$this->CountChildCustomer(),
				'cac'=>$this->CountCustomerActiveCall()
					
			]);		
		};	
    }	
}
