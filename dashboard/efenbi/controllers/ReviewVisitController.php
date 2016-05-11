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


use dashboard\efenbi\models\Scheduledetail;
use dashboard\efenbi\models\ScheduledetailSearch;
use dashboard\efenbi\models\Schedulegroup;
use dashboard\efenbi\models\CustomerVisitImage;



class ReviewVisitController extends Controller
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
	
	public function actionIndex()
    {
		 if (\Yii::$app->user->isGuest) {
            return $this->render('../../../views/site/index_nologin'
            );
        }else{		
			/*SALESMAN VISIT REPORT*/
			$searchModel = new ScheduledetailSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataGroup =  ArrayHelper::map(Schedulegroup::find()->orderBy('SCDL_GROUP_NM')->asArray()->all(), 'ID','SCDL_GROUP_NM');
			
			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'nmGroup'=>$dataGroup,
			]);		
		}
	}
	
	
}
