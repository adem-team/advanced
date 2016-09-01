<?php

namespace lukisongroup\dashboard\controllers;

use Yii;
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\Response;

class EsmCustomersController extends Controller
{	
	public function actionIndex()
    {
		if (\Yii::$app->user->isGuest) {
            return $this->render('../../../views/site/index_nologin');
        }else{			
			/**
			* SUMMARY CUSTOMER PARENT
			* Detail Children Count
			* Author by Piter Novian [ptr.nov@gmail.com]
			*/
			$dataParenCustomer= new ArrayDataProvider([
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
			$parenCustomer=$dataParenCustomer->getModels();
			
			/**
			* SUMMARY PARENT KATEGORI
			* Author by Piter Novian [ptr.nov@gmail.com]
			*/
			$dataParentKategori= new ArrayDataProvider([
				//'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('count_kategory_customer_parent')")->queryAll(),
				'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
					return $db_esm->createCommand("
						SELECT x1.CUST_KTG,x1.CUST_KTG_NM,(SELECT COUNT(CUST_KD)from c0001 WHERE STATUS<>3 AND CUST_KTG=x1.CUST_KTG) AS CUST_CNT
						FROM c0001k x1
						WHERE x1.CUST_KTG=x1.CUST_KTG_PARENT
					")->queryAll();
				}, 60), 
				'pagination' => [
					'pageSize' => 50,
<<<<<<< HEAD
					]
			]);		
			
			$model_CustPrn=$dataProvider_CustPrn->getModels();
			$count_CustPrn=$dataProvider_CustPrn->getCount();		
=======
				]
			]);		
			$parentKategori= $dataParentKategori->getModels();
			
			/**
			* SUMMARY KATEGORY DETAIL COUNT
			* Detail customer Category
			* Author by Piter Novian [ptr.nov@gmail.com]
			*/
			$dataChartCountKategori= new ArrayDataProvider([
				'allModels'=>Yii::$app->db_esm->cache(function ($db_esm) {
					return $db_esm->createCommand("
						SELECT a1.CUST_KTG,a1.KTG_NM,(SELECT COUNT(CUST_KD)from c0001 WHERE STATUS<>3 AND CUST_TYPE=a1.CUST_KTG) AS CUST_CNT
						FROM
							(SELECT x1.CUST_KTG,CONCAT(x2.CUST_KTG_NM,' ',x1.CUST_KTG_NM) AS KTG_NM
								FROM c0001k x1 INNER JOIN 
									(
										 SELECT CUST_KTG,CUST_KTG_NM,CUST_KTG_PARENT 
										 FROM c0001k 
										 WHERE CUST_KTG=CUST_KTG_PARENT
									) x2 on x1.CUST_KTG_PARENT=x2.CUST_KTG
								WHERE x1.CUST_KTG<>x1.CUST_KTG_PARENT
							  ORDER BY x1.CUST_KTG_PARENT
							) a1	
					")->queryAll();
				}, 60),
				'pagination' => [
					'pageSize' => 200,
				]
			]);		
			$ChartCountKategori= $dataChartCountKategori->getModels();
>>>>>>> e02eec9ee56de2edd082b1f2c48c368917fc2ec6
			
			//RENDER INDEX
			return $this->render('index',[
<<<<<<< HEAD
				/* CUSTOMER CATEHORI COUNT [modern,general,horeca,other]*/
				'model_CustPrn'=>$model_CustPrn,
				'count_CustPrn'=>$count_CustPrn,
				'dataProvider_CustPrn'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_SALES_custromer_ktg('count_kategory_customer_parent')")->queryAll(),
				/*STOCK ALL CUSTOMER*/
				'resultCountChildParen'=>$this->CountChildCustomer(),
				'cac_val'=>$this->ValueCustomerActiveCall(),
				'cac_ctg'=>$this->CtgCustomerActiveCall()
					
=======
				'ChartCountKategori'=>$ChartCountKategori,
				'parenCustomer'=>$parenCustomer,
				'parentKategori'=>$parentKategori					
>>>>>>> e02eec9ee56de2edd082b1f2c48c368917fc2ec6
			]);		
		};	
    }	
}

