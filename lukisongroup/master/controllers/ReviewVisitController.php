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
use yii\web\Request;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use lukisongroup\master\models\ReviewHeaderSearch;
use lukisongroup\master\models\CustomercallTimevisitSearch;
use lukisongroup\master\models\ReviewInventorySearch;
use lukisongroup\master\models\Issuemd;
use lukisongroup\master\models\IssuemdSearch;

class ReviewVisitController extends Controller
{	

	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action){
            if (Yii::$app->user->isGuest)  {
                 Yii::$app->user->logout();
                   $this->redirect(array('/site/login'));  //
            }
            // Check only when the user is logged in
            if (!Yii::$app->user->isGuest)  {
               if (Yii::$app->session['userSessionTimeout']< time() ) {
                   // timeout
                   Yii::$app->user->logout();
                   $this->redirect(array('/site/login'));  //
               } else {
                   //Yii::$app->user->setState('userSessionTimeout', time() + Yii::app()->params['sessionTimeoutSeconds']) ;
                   Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
                   return true;
               }
            } else {
                return true;
            }
    }
	
	public function actionIndex()
    {
		Yii::$app->response->getHeaders()->set('Vary', 'Accept');
		//Yii::$app->response->format = Response::FORMAT_JSON;
		
		if (\Yii::$app->user->isGuest) {
            return $this->render('../../../views/site/index_nologin');
        }else{	
			$model = new \yii\base\DynamicModel(['tgl']);
			$model->addRule(['tgl'], 'safe');
			$hsl = Yii::$app->request->post();
		    $tgl = $hsl['DynamicModel']['tgl'];
			setcookie('issuememoTglVal',$tgl);	
			$setTglCookie=$_COOKIE['issuememoTglVal'];
			$tglParam=$setTglCookie!=''?$setTglCookie:date('Y-m-d');
			
			/* if ($model->load(Yii::$app->request->post())) {
				$hsl = Yii::$app->request->post();
				$tgl = $hsl['DynamicModel']['tgl'];
				$setTgl=$tgl1!=''?$tgl1:date('Y-m-d');
				$tglParam=$tgl!=''?$tgl:$setTgl;
				
				//if($this->checkRpt($setTgl)==0 or $this->checkRpt($setTgl)==1){			
				$searchModel = new ReviewHeaderSearch([
					'TGL'=>$tglParam
				]);
				$searchModelIssue = new IssuemdSearch([
					'TGL'=>$tglParam,//'2016-10-28'
				]);
				
				$dataProvider = $searchModel->searchHeaderReview(Yii::$app->request->queryParams);				
				$dataProviderIssue = $searchModelIssue->search(Yii::$app->request->queryParams);				
				return $this->render('index',[
					'dataProviderHeader1'=>$dataProvider,
					'searchModelHeader1'=>$searchModel,
					'searchModelIssue' => $searchModelIssue,
					'dataProviderIssue' => $dataProviderIssue
				]);
			}else{ */
				//$tgl1=Yii::$app->getRequest()->getQueryParam('tgl');
				//$tglParam1=$tgl1!=''?$tgl1:date('Y-m-d');
				//$tglParam=$setTglCookie!=''?$setTglCookie:$tglParam1;
				
				/**
				* Syncronize Report Customercall Time
				*/
				if($this->checkRpt($tglParam)==0 or $this->checkRpt($tglParam)==1){			
					$searchModel = new ReviewHeaderSearch([
						'TGL'=>$tglParam
					]);
					$searchModelIssue = new IssuemdSearch([
						'TGL'=>$tglParam,//'2016-10-28'
					]);
					
					$dataProvider = $searchModel->searchHeaderReview(Yii::$app->request->queryParams);				
					$dataProviderIssue = $searchModelIssue->search(Yii::$app->request->queryParams);				
					return $this->render('index',[
						'dataProviderHeader1'=>$dataProvider,
						'searchModelHeader1'=>$searchModel,
						'searchModelIssue' => $searchModelIssue,
						'dataProviderIssue' => $dataProviderIssue
					]);
				}		
		
		
			//if (Yii::$app->request->post('tgl')) {
				//$tglpost = Yii::$app->request->post('tgl');
				// $tglpost=Yii::$app->getRequest()->getQueryParam('tgl');
				// setcookie('issuememoVal',$tglpost);	
				// $cookies = Yii::$app->request->cookies;
				// $cookVal =$cookies->get('issuememoVal');
				//Yii::$app->response->format = Response::FORMAT_JSON;
				// $tgl1=Yii::$app->request->post('tgl');
				// $tglParam=$tgl1!=''?$tgl1:'2016-10-28';//date('Y-m-d');
				// $setTgl=$_COOKIE['issuememoVal']!=0?$_COOKIE['issuememoVal']:$tglParam;
				
				//setcookie('issuememoValxx',1);	
				//echo $setTgl;
				//return;
			//}
			//else{
				//$tgl1=Yii::$app->getRequest()->getQueryParam('tgl');
				//$setTgl=$tgl1!=''?$tgl1:'2016-10-28';//date('Y-m-d');
				
			//};
			//$setTgl=$tglpost!=''?$tglpost:$tglParam;
		
			//if (Yii::$app->request->isAjax) {
				// if(isset($_POST['tgl']){
					 // $tglpost = $_POST['tgl'];
				// }else{
					// $tgl1=Yii::$app->getRequest()->getQueryParam('tgl');
					// $tglParam=$tgl1!=''?$tgl1:date('Y-m-d');
				// };
				//$model = new \yii\base\DynamicModel(['tgl']);
				//$model->load(Yii::$app->request->post());
				// $hsl = Yii::$app->request->get();
				// $tgl1=Yii::$app->getRequest()->getQueryParam('tgl');
				// $tglParam=$tgl1!=''?$tgl1:'2016-10-28';//date('Y-m-d');
				// $tglpost=$hsl['tgl'];
				// $setTgl=$tglpost!=''?$tglpost:$tglParam;
				
				//$setTgl=$tglpost!=''?$tglpost:date('Y-m-d');
				/*$searchModel = new ReviewHeaderSearch([
					'TGL'=>$setTgl
				]);
				 $searchModelIssue = new IssuemdSearch([
					'TGL'=>$setTgl,//'2016-10-28'
				]);
				
				$dataProvider = $searchModel->searchHeaderReview(Yii::$app->request->queryParams);				
				$dataProviderIssue = $searchModelIssue->search(Yii::$app->request->queryParams);				
				return $this->render('index',[
					'dataProviderHeader1'=>$dataProvider,
					'searchModelHeader1'=>$searchModel,
					'searchModelIssue' => $searchModelIssue,
					'dataProviderIssue' => $dataProviderIssue
				]); */
			//}else{
				//Get value tgl from $tab
				
				//
				
			//};		
				
			//}else{
			//	return $this->redirect(['index?tgl='.$setTgl]);
			//}
		};	
    }
	
	public function actionAmbilTanggal()
	{
		// $model = new \yii\base\DynamicModel(['tanggal']);
		// $model->addRule(['tanggal'], 'safe');
		// if ($model->load(Yii::$app->request->post())) {
			// $hsl = Yii::$app->request->post();
			// $tgl = $hsl['DynamicModel']['tanggal'];
			// return $this->redirect(['index', 'tgl'=>$tgl]);
		// }else{			
			// return $this->renderAjax('_indexform', [
			// 'model'=>$model,
			// ]);
		// }
		$model = new \yii\base\DynamicModel(['tgl']);
		$model->addRule(['tgl'], 'required');
		if (!$model->load(Yii::$app->request->post())){
			return $this->renderAjax('_indexform', [
			'model'=>$model,
			]);
		}else{
			if(Yii::$app->request->isAjax){
				$model->load(Yii::$app->request->post());
				return Json::encode(\yii\widgets\ActiveForm::validate($model));
			}
		}
	}
	
	/**
	 * ISSUE NOTE -> CHECK DATE
	 * @author Piter Novian [ptr.nov@gmail.com]
	 * @since 2.0
	*/
	public function actionAmbilTanggalIssue()
	{
		$model = new \yii\base\DynamicModel(['tgl']);
		$model->addRule(['tgl'], 'required');
		if (!$model->load(Yii::$app->request->post())){
			return $this->renderAjax('_indexformIssue', [
			'model'=>$model,
			]);
		}else{
			if(Yii::$app->request->isAjax){
				$model->load(Yii::$app->request->post());
				return Json::encode(\yii\widgets\ActiveForm::validate($model));
			}
		}
	}
	
	/**
	 * CHART -> CHECK DATE
	 * @author Piter Novian [ptr.nov@gmail.com]
	 * @since 2.0
	*/
	public function actionAmbilTanggalChart()
	{
		$model = new \yii\base\DynamicModel(['tgl']);
		$model->addRule(['tgl'], 'required');
		if (!$model->load(Yii::$app->request->post())){
			return $this->renderAjax('_indexformChart', [
			'model'=>$model,
			]);
		}else{
			if(Yii::$app->request->isAjax){
				$model->load(Yii::$app->request->post());
				return Json::encode(\yii\widgets\ActiveForm::validate($model));
			}
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
	 * IMAGE - DOWNLOAD
	 * @author Piter Novian [ptr.nov@gmail.com]
	 * @since 2.0
	*/
	public function actionDownloadImage($tgl,$user_id)
    {		
		$searchModelViewImg = new CustomercallTimevisitSearch(['TGL'=>$tgl,'USER_ID'=>$user_id]);
		$dataProviderViewImg=$searchModelViewImg->search(Yii::$app->request->queryParams);
		$listImg=$dataProviderViewImg->getModels();
		$imgKosong="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";
			$data=[];
			$dataRow1=[];
			$dataRow2=[];
			foreach($listImg as $row => $value){
				$img64row1=[
					[
						'img64'=>$value['IMG_DECODE_START']!=''?$value['IMG_DECODE_START']:$imgKosong,
						'name'=>$value['TGL'].'_'.$value['CUST_NM'].'_1START'.'-'.$value['SALES_NM'],
						'tgl'=>$value['TGL'],
						'sales_nm'=>$value['SALES_NM']
					]
				];
				$img64row2=[
					[
						'img64'=>$value['IMG_DECODE_END']!=''?$value['IMG_DECODE_END']:$imgKosong,
						'name'=>$value['TGL'].'_'.$value['CUST_NM'].'_2END'.'-'.$value['SALES_NM'],
						'tgl'=>$value['TGL'],
						'sales_nm'=>$value['SALES_NM']
					]
				];
				
				$dataRow1=ArrayHelper::merge($dataRow1,$img64row1);
				$dataRow2=ArrayHelper::merge($dataRow2,$img64row2);
			};	
			$data=ArrayHelper::merge($dataRow1,$dataRow2);	
			
			return $this->render('_download', [
					'model'=>$data,
			]);
		
		/*  $model = new \yii\base\DynamicModel(['pathDes']);
		$model->addRule(['pathDes'], 'safe');
		if ($model->load(Yii::$app->request->post())) {
			$hsl = Yii::$app->request->post();
			$valPath = $hsl['DynamicModel']['pathDes'];	
			//$log=shell_exec('sudo zip -r /var/www/advanced/lukisongroup/cronjob/temp.zip /var/www/advanced/lukisongroup/cronjob/temp/ 2>&1');
			//$log=exec("ls -l /var/www/advanced/lukisongroup/cronjob/temp 2>&1");
			//\yii\helpers\VarDumper::dump($log, 10, 1);
			//print_r("<pre>$log</pre>"); 
			//self::downloadJpg('test',$dataScr);
			//return $valPath;
			//return $this->redirect(['index']);
		}else{			
			return $this->renderAjax('_formImgDownload', [
				'model'=>$model,
			]);
		} */
	}
	
	private static function downloadJpg($fileNm,$base64){		
		//$file = uniqid() . '.jpg';	
		$file = $fileNm .'.jpg';
		$img = str_replace('data:image/jpg;base64,', '', $base64);
		header('Content-Description: File Transfer');
		Header("Content-Type:image/jpeg");
        Header("Accept-Ranges: bytes");
		Header("Content-Disposition: attachment; filename=" . basename($file));
		echo base64_decode($img); 
		return true;
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
	
	/**
	 * Button Search Set Date
	 * @author piter
	 * @since 1.1.0
	 * @return date
	*/
	public function actionButtonSetDate(){
		return $this->renderAjax('_formButtonSetDate', [
			'model' => $modelSyncActual,
		]);
    }
	public function actionIssueMemo($tgl){
		
		//$tgl=Yii::$app->getRequest()->getQueryParam('tgl');
		$setTgl=$tgl!=''?$tgl:date('Y-m-d');
		
		$searchModelIssueMemo= new IssuemdSearch([
			'TGL'=>$tgl//'2016-10-27'//$setTgl
		]);
		
		$dataProviderIssue = $searchModelIssueMemo->search(Yii::$app->request->queryParams);	
		$searchModelIssue = new IssuemdSearch([
			'TGL'=>'2016-10-28'
		]);
		
		$dataProvider = $searchModel->searchHeaderReview(Yii::$app->request->queryParams);				
		$dataProviderIssue = $searchModelIssue->search(Yii::$app->request->queryParams);				
		return $this->render('index',[
			'searchModelIssue' => $searchModelIssue,
			'dataProviderIssue' => $dataProviderIssue
		]);




		
		// $adpIssue= new ArrayDataProvider([
			// 'allModels'=>$dataProviderIssue->,
			// 'pagination' => [
				// 'pageSize' => 1000,
			// ]
		// ]);
		
		//$rslt= ArrayHelper::toArray($adpIssue);	
		/* $posts = Issuemd::find()->where(['TGL'=>$setTgl])->all();
		$data = ArrayHelper::toArray($posts, [
			'lukisongroup\master\models\Issuemd' => [
				'TGL',
				'NM_CUSTOMER',
				'NM_USER',
				'ISI_MESSAGES'
				// the key name in array result => property name
				//'createTime' => 'created_at',
				// the key name in array result => anonymous function
				//'length' => function ($post) {
					//return strlen($post->content);
				//},
			],
		]); */
	
		//print_r(ArrayHelper::toArray($dataProviderIssue->getModels()));
		/*  \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $data; */
	}
}
