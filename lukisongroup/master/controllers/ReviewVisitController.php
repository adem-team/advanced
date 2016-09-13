<?php

namespace lukisongroup\master\controllers;

use Yii;
use yii\web\Controller;
use kartik\helpers\Html;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use kartik\tabs\TabsX;
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
	
	/**
	 * IMAGE - DETAIL DISPLY 
	 * @author Piter Novian [ptr.nov@gmail.com]
	 * @since 2.0
	*/
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
	
	/**
	 * WEEKLY - DETAIL STOCK 
	 * Methode : Tab Link
	 * Senen dikurang 2 Hari = sabtu
	 * Hanya untuk menghitung hari minggu ke belakang
	 * example tanggal 	2016-09-05(senen) AND 2016-09-11(minggu), input 2016-09-12
	 * @author Piter Novian [ptr.nov@gmail.com]
	 * @since 2.0
	*/
	public function actionTabWeeklyStock(){
		if (\Yii::$app->user->isGuest) {
            return $this->render('../../../views/site/index_nologin');
        }else{	
			$day = date('2016-09-12');
			$weekDayStart = date('Y-m-d', strtotime('monday this week',strtotime('-2 days'.$day)));
			$weekDayEnd = date('Y-m-d', strtotime('sunday  this week',strtotime('-2 days'.$day)));
			//echo $weekDayStart .' AND '.$weekDayEnd.' ,hari:'.$day.' ,week:'.$week;				
			
			/* $searchModelStock= new ReviewInventorySearch([
				'TGL7'=>$weekDayStart,'TGL'=>$weekDayEnd,'SO_TYPE'=>'5'
				//'TGL7'=>'2016-09-05','TGL'=>'2016-09-10','USER_ID'=>'59','SO_TYPE'=>'5'
			]); */
			$searchModelStock= new ReviewInventorySearch([
				'SO_TYPE'=>'5' // SO_TYPE=STOCK
			]);
			$aryDataStock = $searchModelStock->searchWeekly(Yii::$app->request->queryParams,$weekDayStart,$weekDayEnd);	
			
			$dataModelStock=$aryDataStock->allModels; 											//Set ArrayProvider to Array	
			$dataMapStock =  ArrayHelper::map($dataModelStock, 'NM_BARANG','SO_QTY','CUST_NM');	//Get index string	
			$dataIndexStock =  ArrayHelper::index($dataModelStock, 'CUST_NM');					//Get index string	
			$StockMergeRowColumn= ArrayHelper::merge($dataIndexStock,$dataMapStock);			//index string Merge / Like Join index	
			$StockIndexVal=array_values($StockMergeRowColumn); 									//index string to int
			//$aryProviderDetailStock ='';
			$aryProviderDetailStock= new ArrayDataProvider([
				'allModels'=>$StockIndexVal,
				'pagination' => [
					'pageSize' => 1000,
				]
			]);
				
			$getHeaderStck=[];
			foreach($StockIndexVal as $key => $value){
				$getHeaderStck=ArrayHelper::merge($getHeaderStck,$StockIndexVal[$key]);
			};
			
			/**
			 * Foreach to get All column Then remove Column selected
			 * @author piter novian [ptr.nov@gmail.com]
			*/
			$splitHeaderStck=[];
			foreach($getHeaderStck as $ky => $value){
				//$splitHeaderStck=ArrayHelper::merge($splitHeaderStck, array_splice($getHeaderStck, 3, 2));
				$splitHeaderStck=ArrayHelper::merge($splitHeaderStck, array_diff_key($getHeaderStck,[
					//'TGL'=>'','USER_ID'=>'','SCDL_GROUP'=>'','KD_BARANG'=>'','NM_BARANG'=>'','SO_TYPE'=>'','SO_QTY'=>''
					'USER_ID'=>'','SCDL_GROUP'=>'','KD_BARANG'=>'','NM_BARANG'=>'','SO_TYPE'=>'','SO_QTY'=>''
				]));
			};			
			$aryProviderHeaderStock=$splitHeaderStck;	
			
			$htmlRender= $this->renderAjax('_indexWeeklyStock',[
				'dataProvider'=>$aryDataStock,
				'searchModelStock'=>$searchModelStock,				
				'aryProviderDetailStock'=>$aryProviderDetailStock,		
				'aryProviderHeaderStock'=>$aryProviderHeaderStock			
			]);

			//return $htmlRender;
			return Json::encode($htmlRender);
		}
	}
	
	/**
	 * WEEKLY - DETAIL REQUEST ORDER
	 * Methode : Tab Link
	 * Senen dikurang 2 Hari = sabtu
	 * Hanya untuk menghitung hari minggu ke belakang
	 * example tanggal 	2016-09-05(senen) AND 2016-09-11(minggu), input 2016-09-12
	 * @author Piter Novian [ptr.nov@gmail.com]
	 * @since 2.0
	*/
	public function actionTabWeeklyRo(){
		if (\Yii::$app->user->isGuest) {
            return $this->render('../../../views/site/index_nologin');
        }else{	
			$day = date('2016-09-12');
			$weekDayStart = date('Y-m-d', strtotime('monday this week',strtotime('-2 days'.$day)));
			$weekDayEnd = date('Y-m-d', strtotime('sunday  this week',strtotime('-2 days'.$day)));
			//echo $weekDayStart .' AND '.$weekDayEnd.' ,hari:'.$day.' ,week:'.$week;				
		
			$searchModelRo= new ReviewInventorySearch([
				'SO_TYPE'=>'9' // SO_TYPE=REQUEST ORDER
			]);
			$aryDataRo = $searchModelRo->searchWeekly(Yii::$app->request->queryParams,$weekDayStart,$weekDayEnd);	
			
			$dataModelRo=$aryDataRo->allModels; 											//Set ArrayProvider to Array	
			$dataMapRo =  ArrayHelper::map($dataModelRo, 'NM_BARANG','SO_QTY','CUST_NM');	//Get index string	
			$dataIndexRo =  ArrayHelper::index($dataModelRo, 'CUST_NM');					//Get index string	
			$RoMergeRowColumn= ArrayHelper::merge($dataIndexRo,$dataMapRo);			//index string Merge / Like Join index	
			$RoIndexVal=array_values($RoMergeRowColumn); 									//index string to int
			//$aryProviderDetailRo ='';
			$aryProviderDetailRo= new ArrayDataProvider([
				'allModels'=>$RoIndexVal,
				'pagination' => [
					'pageSize' => 1000,
				]
			]);
				
			$getHeaderRo=[];
			foreach($RoIndexVal as $key => $value){
				$getHeaderRo=ArrayHelper::merge($getHeaderRo,$RoIndexVal[$key]);
			};
			
			/**
			 * Foreach to get All column Then remove Column selected
			 * @author piter novian [ptr.nov@gmail.com]
			*/
			$splitHeaderRo=[];
			foreach($getHeaderRo as $ky => $value){
				//$splitHeaderRo=ArrayHelper::merge($splitHeaderRo, array_splice($getHeaderRo, 3, 2));
				$splitHeaderRo=ArrayHelper::merge($splitHeaderRo, array_diff_key($getHeaderRo,[
					//'TGL'=>'','USER_ID'=>'','SCDL_GROUP'=>'','KD_BARANG'=>'','NM_BARANG'=>'','SO_TYPE'=>'','SO_QTY'=>''
					'USER_ID'=>'','SCDL_GROUP'=>'','KD_BARANG'=>'','NM_BARANG'=>'','SO_TYPE'=>'','SO_QTY'=>''
				]));
			};			
			$aryProviderHeaderRo=$splitHeaderRo;	
			
			$htmlRender= $this->renderAjax('_indexWeeklyRo',[
				'dataProvider'=>$aryDataRo,
				'searchModelRo'=>$searchModelRo,				
				'aryProviderDetailRo'=>$aryProviderDetailRo,		
				'aryProviderHeaderRo'=>$aryProviderHeaderRo			
			]);

			//return $htmlRender;
			return Json::encode($htmlRender);
		}
	}
	
	/**
	 * WEEKLY - DETAIL REQUEST ORDER
	 * Methode : Tab Link
	 * Senen dikurang 2 Hari = sabtu
	 * Hanya untuk menghitung hari minggu ke belakang
	 * example tanggal 	2016-09-05(senen) AND 2016-09-11(minggu), input 2016-09-12
	 * @author Piter Novian [ptr.nov@gmail.com]
	 * @since 2.0
	*/
	public function actionTabWeeklySellIN(){
		if (\Yii::$app->user->isGuest) {
            return $this->render('../../../views/site/index_nologin');
        }else{	
			$day = date('2016-09-12');
			$weekDayStart = date('Y-m-d', strtotime('monday this week',strtotime('-2 days'.$day)));
			$weekDayEnd = date('Y-m-d', strtotime('sunday  this week',strtotime('-2 days'.$day)));
			//echo $weekDayStart .' AND '.$weekDayEnd.' ,hari:'.$day.' ,week:'.$week;				
		
			$searchModelRo= new ReviewInventorySearch([
				'SO_TYPE'=>'9' // SO_TYPE=REQUEST ORDER
			]);
			$aryDataRo = $searchModelRo->searchWeekly(Yii::$app->request->queryParams,$weekDayStart,$weekDayEnd);	
			
			$dataModelRo=$aryDataRo->allModels; 											//Set ArrayProvider to Array	
			$dataMapRo =  ArrayHelper::map($dataModelRo, 'NM_BARANG','SO_QTY','CUST_NM');	//Get index string	
			$dataIndexRo =  ArrayHelper::index($dataModelRo, 'CUST_NM');					//Get index string	
			$RoMergeRowColumn= ArrayHelper::merge($dataIndexRo,$dataMapRo);			//index string Merge / Like Join index	
			$RoIndexVal=array_values($RoMergeRowColumn); 									//index string to int
			//$aryProviderDetailRo ='';
			$aryProviderDetailRo= new ArrayDataProvider([
				'allModels'=>$RoIndexVal,
				'pagination' => [
					'pageSize' => 1000,
				]
			]);
				
			$getHeaderRo=[];
			foreach($RoIndexVal as $key => $value){
				$getHeaderRo=ArrayHelper::merge($getHeaderRo,$RoIndexVal[$key]);
			};
			
			/**
			 * Foreach to get All column Then remove Column selected
			 * @author piter novian [ptr.nov@gmail.com]
			*/
			$splitHeaderRo=[];
			foreach($getHeaderRo as $ky => $value){
				//$splitHeaderRo=ArrayHelper::merge($splitHeaderRo, array_splice($getHeaderRo, 3, 2));
				$splitHeaderRo=ArrayHelper::merge($splitHeaderRo, array_diff_key($getHeaderRo,[
					//'TGL'=>'','USER_ID'=>'','SCDL_GROUP'=>'','KD_BARANG'=>'','NM_BARANG'=>'','SO_TYPE'=>'','SO_QTY'=>''
					'USER_ID'=>'','SCDL_GROUP'=>'','KD_BARANG'=>'','NM_BARANG'=>'','SO_TYPE'=>'','SO_QTY'=>''
				]));
			};			
			$aryProviderHeaderRo=$splitHeaderRo;	
			
			$htmlRender= $this->renderAjax('_indexWeeklyRo',[
				'dataProvider'=>$aryDataRo,
				'searchModelRo'=>$searchModelRo,				
				'aryProviderDetailRo'=>$aryProviderDetailRo,		
				'aryProviderHeaderRo'=>$aryProviderHeaderRo			
			]);

			//return $htmlRender;
			return Json::encode($htmlRender);
		}
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
		/**
		 * Senen dikurang 2 Hari = sabtu
		 * Hanya untuk menghitung hari minggu ke belakang
		 * example tanggal 	2016-09-05(senen) AND 2016-09-11(minggu), input 2016-09-12
		*/
		$day = date('2016-09-12');
		$weekDayStart = date('Y-m-d', strtotime('monday this week',strtotime('-2 days'.$day)));
		$weekDayEnd = date('Y-m-d', strtotime('sunday  this week',strtotime('-2 days'.$day)));
		//echo $weekDayStart .' AND '.$weekDayEnd.' ,hari:'.$day.' ,week:'.$week;		
		
		$searchModelStock= new ReviewInventorySearch([
			'TGL7'=>$weekDayStart,'TGL'=>$weekDayEnd,'SO_TYPE'=>'5'
			//'TGL7'=>'2016-09-05','TGL'=>'2016-09-10','USER_ID'=>'59','SO_TYPE'=>'5'
		]);
		$aryDataStock = $searchModelStock->searchWeekly(Yii::$app->request->queryParams);	
		
		$dataModelStock=$aryDataStock->allModels; 											//Set ArrayProvider to Array	
		$dataMapStock =  ArrayHelper::map($dataModelStock, 'NM_BARANG','SO_QTY','CUST_NM');	//Get index string	
		$dataIndexStock =  ArrayHelper::index($dataModelStock, 'CUST_NM');					//Get index string	
		$StockMergeRowColumn= ArrayHelper::merge($dataIndexStock,$dataMapStock);			//index string Merge / Like Join index	
		$StockIndexVal=array_values($StockMergeRowColumn); 									//index string to int
		//$aryProviderDetailStock ='';
		$aryProviderDetailStock= new ArrayDataProvider([
			'allModels'=>$StockIndexVal,
			'pagination' => [
				'pageSize' => 1000,
			]
		]);
			
		$getHeaderStck=[];
		foreach($StockIndexVal as $key => $value){
			$getHeaderStck=ArrayHelper::merge($getHeaderStck,$StockIndexVal[$key]);
		};
		
		/**
		 * Foreach to get All column Then remove Column selected
		 * @author piter novian [ptr.nov@gmail.com]
		*/
		$splitHeaderStck=[];
		foreach($getHeaderStck as $ky => $value){
			//$splitHeaderStck=ArrayHelper::merge($splitHeaderStck, array_splice($getHeaderStck, 3, 2));
			$splitHeaderStck=ArrayHelper::merge($splitHeaderStck, array_diff_key($getHeaderStck,[
				//'TGL'=>'','USER_ID'=>'','SCDL_GROUP'=>'','KD_BARANG'=>'','NM_BARANG'=>'','SO_TYPE'=>'','SO_QTY'=>''
				'USER_ID'=>'','SCDL_GROUP'=>'','KD_BARANG'=>'','NM_BARANG'=>'','SO_TYPE'=>'','SO_QTY'=>''
			]));
		};			
		$aryProviderHeaderStock=$splitHeaderStck;	
		
		return $this->render('indexTest1',[
			'dataProvider'=>$aryDataStock,			
			'aryProviderDetailStock'=>$aryProviderDetailStock,		
			'aryProviderHeaderStock'=>$aryProviderHeaderStock			
		]);
	}
}
