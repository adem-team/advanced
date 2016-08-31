<?php

namespace lukisongroup\dashboard\controllers;

use Yii;
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\Response;

class EsmCustomersController extends Controller
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
	
	/* CHART PARENT CUSTOMER */
	public function CountChildCustomer(){		
		$countChildParen= new ArrayDataProvider([
			'key' => 'CUST_KD',
			//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('ParentChildCountCustomer')")->queryAll(),
			'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
				return $db_esm->createCommand("
					SELECT x1.label,x1.value
					FROM
						(SELECT #x1.CUST_KD,x1.CUST_GRP,
								 x1.CUST_NM as label,
								(SELECT COUNT(x2.CUST_KD) FROM c0001 x2 WHERE x2.CUST_GRP=x1.CUST_KD LIMIT 1 ) as value
						FROM c0001 x1
						WHERE x1.CUST_KD=x1.CUST_GRP) x1 
					ORDER BY x1.value DESC;
				")->queryAll();
			}, 60),
			'pagination' => [
				'pageSize' => 200,
			]
		]);		
		//print_r(json_encode($countChildParen->getModels()));
		//print_r(json_decode($resultCountChildParen));
		//die(); 
		//return Json::encode($countChildParen->getModels());
		return $countChildParen->getModels();
	}	
	
	/* Value Customer Active */
	public function ValueCustomerActiveCall(){		
		$dataCAC= new ArrayDataProvider([
			'key' => 'TGL_STATUS',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_VISIT_detail_status('all_value_parent_cust_active')")->queryAll(),
			'pagination' => [
				'pageSize' => 500,
				]
		]);		
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
	
	/* Category Customer Active */
	public function CtgCustomerActiveCall(){		
		$dataCAC= new ArrayDataProvider([
			'key' => 'TGL_STATUS',
			'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_VISIT_detail_status('all_ctg_cust_active')")->queryAll(),
			'pagination' => [
				'pageSize' => 500,
				]
		]);		
		/*SET Models*/
		$modelCAC_ctg=$dataCAC->getModels();
		return Json::encode($modelCAC_ctg);	
	}
	
	public function actionIndex()
    {
		// print_r($this->CtgCustomerActiveCall());
		// die();
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
				'cac_val'=>$this->ValueCustomerActiveCall(),
				'cac_ctg'=>$this->CtgCustomerActiveCall()
					
			]);		
		};	
    }	
}

