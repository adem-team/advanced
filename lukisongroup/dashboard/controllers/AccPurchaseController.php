<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\dashboard\controllers;

/* VARIABLE BASE YII2 Author: -YII2- */
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter; 	
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use \DateTime;



use lukisongroup\widget\models\Chat;
use lukisongroup\widget\models\ChatSearch;
use lukisongroup\widget\models\ChatroomSearch;
use lukisongroup\dashboard\models\AccPurchaseSearch;
		
class AccPurchaseController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(['prodak']),
                'actions' => [
                    //'delete' => ['post'],
					'save' => ['post'],
                ],
            ],
        ];
    }

	/**
     * ACTION INDEX | Session Login
     * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	public function beforeAction(){
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
	
    /**
     * ACTION INDEX
     */
    public function actionIndex()
    {
		/*	variable content View Employe Author: -ptr.nov- */
       // $searchModel_Dept = new DeptSearch();
		//$dataProvider_Dept = $searchModel_Dept->search(Yii::$app->request->queryParams);
		
		return $this->render('index');
    }
	
	public function actionChat()
    {
		$searchmodel1 = new ChatroomSearch();
        $dataprovider1 = $searchmodel1->search(Yii::$app->request->queryParams);
        $dataprovider1->pagination->pageSize=2;
         
        $searchModel1 = new ChatSearch();
        $dataProvider1 = $searchModel1->searchonline(Yii::$app->request->queryParams);
        $dataProvider1->pagination->pageSize=2;
        
        $searchModel = new ChatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=5;
       

        
        //$model = new LoginForm();
		//$this->sideMenu = 'alg_purchasing';
		//$model = Employe::findOne('LG.2015.0000');
		//$js='$("#chating").modal("show")';
		//$this->getView()->registerJs($js);
		return $this->render('@lukisongroup/widget/views/chat/index',[
			//'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchmodel1' => $searchmodel1,
            'dataprovider1' => $dataprovider1,
            'searchModel1' => $searchModel1,
            'dataProvider1' => $dataProvider1,
			'ctrl_chat'=>'alg_sales',
		]);		      
    }
	
	
	
	public function actionPurchase()
    {
		$date=new DateTime();
		$thn=strlen($date->format('Y'));
		$bln=strlen($date->format('m'));
		$hri=strlen($date->format('d'));
		$dateRlt=$thn."-".$bln."-".$hri;
		$searchModel = new AccPurchaseSearch([
			//'tgllog'=>Yii::$app->ambilKonvesi->tglSekarang()
		]);
				
		/*REKAP ABSENSI*/
		//Field Label
		$dataProviderField = $searchModel->dailyFieldTglRange();
		//Value row
		$dataProvider = $searchModel->searchDailyTglRange(Yii::$app->request->queryParams);
        return $this->render('purchase', [
			/*Daily Absensi*/
			'searchModel'=>$searchModel,
			'dataProviderField'=>$dataProviderField,
			'dataProvider'=>$dataProvider			
        ]);
    }
	
	public function actionStockcard()
    {
		$date=new DateTime();
		$thn=strlen($date->format('Y'));
		$bln=strlen($date->format('m'));
		$hri=strlen($date->format('d'));
		$dateRlt=$thn."-".$bln."-".$hri;
		$searchModel = new AccPurchaseSearch([
			//'tgllog'=>Yii::$app->ambilKonvesi->tglSekarang()
		]);
				
		/*REKAP ABSENSI*/
		//Field Label
		$dataProviderField = $searchModel->dailyFieldTglRange();
		//Value row
		$dataProvider = $searchModel->searchDailyTglRange(Yii::$app->request->queryParams);
        return $this->render('stockcard', [
			/*Daily Absensi*/
			'searchModel'=>$searchModel,
			'dataProviderField'=>$dataProviderField,
			'dataProvider'=>$dataProvider			
        ]);
    }
	
	public function actionCostcenter()
    {
		$date=new DateTime();
		$thn=strlen($date->format('Y'));
		$bln=strlen($date->format('m'));
		$hri=strlen($date->format('d'));
		$dateRlt=$thn."-".$bln."-".$hri;
		$searchModel = new AccPurchaseSearch([
			//'tgllog'=>Yii::$app->ambilKonvesi->tglSekarang()
		]);
				
		/*REKAP ABSENSI*/
		//Field Label
		$dataProviderField = $searchModel->dailyFieldTglRange();
		//Value row
		$dataProvider = $searchModel->searchDailyTglRange(Yii::$app->request->queryParams);
        return $this->render('costcenter', [
			/*Daily Absensi*/
			'searchModel'=>$searchModel,
			'dataProviderField'=>$dataProviderField,
			'dataProvider'=>$dataProvider			
        ]);
    }
	
	public function actionSo()
    {
		$date=new DateTime();
		$thn=strlen($date->format('Y'));
		$bln=strlen($date->format('m'));
		$hri=strlen($date->format('d'));
		$dateRlt=$thn."-".$bln."-".$hri;
		$searchModel = new AccPurchaseSearch([
			//'tgllog'=>Yii::$app->ambilKonvesi->tglSekarang()
		]);
				
		/*REKAP ABSENSI*/
		//Field Label
		$dataProviderField = $searchModel->dailyFieldTglRange();
		//Value row
		$dataProvider = $searchModel->searchDailyTglRange(Yii::$app->request->queryParams);
        return $this->render('so', [
			/*Daily Absensi*/
			'searchModel'=>$searchModel,
			'dataProviderField'=>$dataProviderField,
			'dataProvider'=>$dataProvider			
        ]);
    }
	
	public function actionRo()
    {
		$date=new DateTime();
		$thn=strlen($date->format('Y'));
		$bln=strlen($date->format('m'));
		$hri=strlen($date->format('d'));
		$dateRlt=$thn."-".$bln."-".$hri;
		$searchModel = new AccPurchaseSearch([
			//'tgllog'=>Yii::$app->ambilKonvesi->tglSekarang()
		]);
				
		/*REKAP ABSENSI*/
		//Field Label
		$dataProviderField = $searchModel->dailyFieldTglRange();
		//Value row
		$dataProvider = $searchModel->searchDailyTglRange(Yii::$app->request->queryParams);
        return $this->render('ro', [
			/*Daily Absensi*/
			'searchModel'=>$searchModel,
			'dataProviderField'=>$dataProviderField,
			'dataProvider'=>$dataProvider			
        ]);
    }
}
