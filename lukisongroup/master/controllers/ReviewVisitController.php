<?php

namespace lukisongroup\master\controllers;

use Yii;
use yii\web\Controller;
use kartik\helpers\Html;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use lukisongroup\master\models\ReviewHeaderSearch;
use lukisongroup\master\models\CustomercallTimevisitSearch;
use lukisongroup\master\models\ReviewInventorySearch;

class ReviewVisitController extends Controller
{	
	public function actionIndex()
    {
		if (\Yii::$app->user->isGuest) {
            return $this->render('../../../views/site/index_nologin');
        }else{	

			//Get value tgl from $tab
			$tgl=Yii::$app->getRequest()->getQueryParam('tgl');
			$setTgl=$tgl!=''?$tgl:date('Y-m-d');
						
			/**
			 * Syncronize Report Customercall Time
			 */
			if($this->checkRpt($setTgl)==0 or $this->checkRpt($setTgl)==1){			
				$searchModel = new ReviewHeaderSearch([
					'TGL'=>$setTgl
				]);
				$dataProvider = $searchModel->searchHeaderReview(Yii::$app->request->queryParams);				
				return $this->render('index',[
					'dataProviderHeader1'=>$dataProvider,
					'searchModelHeader1'=>$searchModel,
				]);
			}else{
				return $this->redirect(['index?tgl='.$setTgl]);
			}
		};	
    }
	public function actionAmbilTanggal()
	{
		$model = new \yii\base\DynamicModel(['tanggal']);
		$model->addRule(['tanggal'], 'safe');
		if ($model->load(Yii::$app->request->post())) {
			$hsl = Yii::$app->request->post();
			$tgl = $hsl['DynamicModel']['tanggal'];
			return $this->redirect(['index', 'tgl'=>$tgl]);
		}else{			
			return $this->renderAjax('_indexform', [
			'model'=>$model,
			]);
		}
	}
	
	
	/**
	 * NEW METHOD REPORT 
	 * CHECK REPORT EXCUTE OR READY
	 * Table c0002rpt_cc_time.
	 * Procdure REPORT_CUSTOMERCALL_TIMEVISIT(TGL).
	 * @author Piter Novian [ptr.nov@gmail.com]
	 * @since 2.0
	*/
	private function checkRpt($tgl){
		$data=\Yii::$app->db_esm->createCommand("
					call REPORT_CUSTOMERCALL_TIMEVISIT('".$tgl."')
				")->execute();//->queryAll();
		return $data;
	}
	
	
	public function actionDisplyImage($tgl,$user_id)
    {
		//print_r($tgl);
		//die();
		$searchModelViewImg = new CustomercallTimevisitSearch(['TGL'=>$tgl,'USER_ID'=>$user_id]);
		$dataProviderViewImg=$searchModelViewImg->search(Yii::$app->request->queryParams);
		$listImg=$dataProviderViewImg->getModels();
		//if (Yii::$app->request->isAjax) {
			// $request= Yii::$app->request;
			// $id=$request->post('id');
			// $roDetail = Purchasedetail::findOne($id);
			// $roDetail->STATUS = 3;
			// $roDetail->save();
			// return true;
			$model = new \yii\base\DynamicModel(['tanggal']);
			$model->addRule(['tanggal'], 'safe');
			return $this->renderAjax('_viewImageModal', [
				'model'=>$listImg,
			]);
			
		//}
    }
	
	public function actionTab1(){
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
				
		// $dataRenderHTML=$this->renderAjax('_indexTab1',[
			// 'ChartCountKategori'=>$ChartCountKategori,
			// 'parenCustomer'=>$parenCustomer,
			// 'parentKategori'=>$parentKategori					
		// ]);
		// return Json::encode($dataRenderHTML);
		
		$dataRenderHTML=$this->render('_indexTab1',[
			'ChartCountKategori'=>$ChartCountKategori,
			'parenCustomer'=>$parenCustomer,
			'parentKategori'=>$parentKategori					
		]);
		return $dataRenderHTML;
	}
	
	public function actionTest1(){
		$searchModel= new ReviewInventorySearch([
			'TGL'=>'2016-09-07','USER_ID'=>'59','SO_TYPE'=>'5'
		]);
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);	
		
		
		return $this->render('indexTest1',[
			'dataProvider'=>$dataProvider				
		]);
	}
}
