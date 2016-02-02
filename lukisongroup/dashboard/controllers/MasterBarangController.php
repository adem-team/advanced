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
use lukisongroup\widget\models\Chat;
use lukisongroup\widget\models\ChatSearch;
use lukisongroup\widget\models\ChatroomSearch;
use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\master\models\Suplier;
use lukisongroup\master\models\Distributor;
use lukisongroup\master\models\Customers;


class MasterBarangController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(['barang']),
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
		/*CNT Barang Prodak*/
		$cntBrgProdak="SELECT COUNT(KD_BARANG) As KD_BARANG FROM b0001 WHERE PARENT=1";
		$cntBrgPrdk=Barang::findBySql($cntBrgProdak)->one();
		/*CNT Barang Umum*/
		$cntBrgUmum="SELECT COUNT(KD_BARANG) As KD_BARANG FROM b0001 WHERE PARENT=0";
		$cntBrgUmn=Barang::findBySql($cntBrgUmum)->one();
		/*CNT Barang Type*/
		$cntType="SELECT  COUNT(NM_TYPE) as NM_TYPE FROM b1001";
		$cntTyp=Tipebarang::findBySql($cntType)->one();
		/*CNT Barang Kategori*/
		$cntCategory="SELECT COUNT(NM_KATEGORI) as NM_KATEGORI FROM b1002";
		$cntCtg=Kategori::findBySql($cntCategory)->one();
		/*CNT Barang Unit*/
		$cntUnit="SELECT COUNT(KD_UNIT) as KD_UNIT FROM ub0001";
		$cntUnt=Unitbarang::findBySql($cntUnit)->one();
		/*CNT Supplier*/
		$cntSupplier="SELECT COUNT(KD_SUPPLIER) as KD_SUPPLIER FROM s1000";
		$cntSpl=Suplier::findBySql($cntSupplier)->one();
		/*CNT Distributor*/
		$cntDistributor="SELECT COUNT(KD_DISTRIBUTOR) as KD_DISTRIBUTOR FROM d0001";
		$cntDist=Distributor::findBySql($cntDistributor)->one();
		/*CNT Customer*/
		$cntCustomer="SELECT COUNT(CUST_KD) as CUST_KD FROM c0001";
		$cntCst=Customers::findBySql($cntCustomer)->one();
		
		
		//print_r($cntBrgPrdk->KD_BARANG);
		return $this->render('index',[
			'cntBrgPrdk'=>$cntBrgPrdk->KD_BARANG,
			'cntBrgUmn'=>$cntBrgUmn->KD_BARANG,
			'cntTyp'=>$cntTyp->NM_TYPE,
			'cntCtg'=>$cntCtg->NM_KATEGORI,
			'cntUnt'=>$cntUnt->KD_UNIT,
			'cntSpl'=>$cntSpl->KD_SUPPLIER,
			'cntDist'=>$cntDist->KD_DISTRIBUTOR,
			'cntCst'=>$cntCst->CUST_KD,
		]);
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
        
		return $this->render('@lukisongroup/widget/views/chat/index',[
			//'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchmodel1' => $searchmodel1,
            'dataprovider1' => $dataprovider1,
            'searchModel1' => $searchModel1,
            'dataProvider1' => $dataProvider1,
			'ctrl_chat'=>'umum_datamaster',
		]);     
    }
}
