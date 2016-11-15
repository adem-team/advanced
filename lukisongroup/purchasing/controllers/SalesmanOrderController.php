<?php

namespace lukisongroup\purchasing\controllers;

use yii;
use yii\web\Request;
use yii\db\Query;
//use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\mpdf\Pdf;
use zyx\phpmailer\Mailer;
use yii\data\ActiveDataProvider;

use lukisongroup\purchasing\models\salesmanorder\SoHeaderSearch;
use lukisongroup\purchasing\models\salesmanorder\SoDetailSearch;
use lukisongroup\purchasing\models\salesmanorder\SoT2;


/**
 * CUSTOMER - SALESMAN ORDER 
 * @author ptrnov [piter@lukison.com]
 * @since 1.2
 *
*/
class SalesmanOrderController extends Controller
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
	/**
     * Before Action Index
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
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

   /**
     * Index
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
    public function actionIndex()
    {		
		$searchModelHeader = new SoHeaderSearch();
		$dataProvider = $searchModelHeader->searchHeader(Yii::$app->request->queryParams);		
		return $this->render('index', [
			'apSoHeaderInbox'=>$dataProvider,
			'apSoHeaderOutbox'=>$dataProvider,
			'apSoHeaderHistory'=>$dataProvider
        ]);

    }  

	/**
     * Action REVIEW | Prosess Checked and Approval
     * @param string $id
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionReview($id,$stt)
    {		
		if ($stt==0){
			//CREATE KODE_REF
			$modelSoT2 = SoT2::find()->where("ID='".$id."' AND SO_TYPE=10")->one();
			$getSoType=10;
			$getTGL=$modelSoT2->TGL;
			$getCUST_KD=$modelSoT2->CUST_KD;
			$getUSER_ID=$modelSoT2->USER_ID;	
		    //PR create Generate Code. Tabel so_0001.
			//Save kode generate  Tabel so_0001.
			//Update SoT2 KODE_REF where ($getSoType,getTGL,getCUST_KD,getUSER_ID).
			//Editing editable : SUBMIT_QTY,SUBMIT_PRICE
		}else{
			//VIEW KODE_REF
			$modelSoT2 = SoT2::find()->where("KODE_REF='".$id."' AND SO_TYPE=10")->one();
			$getSoType=10;
			$getTGL=$modelSoT2->TGL;
			$getCUST_KD=$modelSoT2->CUST_KD;
			$getUSER_ID=$modelSoT2->USER_ID;
		}
		
		echo "TGL=".$modelSoT2->TGL;
		echo "CUST_KD=".$modelSoT2->CUST_KD;
		echo "USER_ID=".$modelSoT2->USER_ID;
		
		$searchModelDetail= new SoDetailSearch([
			'TGL'=>$getTGL,
			'CUST_KD'=>$getCUST_KD,
			'USER_ID'=>$getUSER_ID,
		]); 
		$aryProviderSoDetail = $searchModelDetail->searchDetail(Yii::$app->request->queryParams);
		return $this->render('_actionReview',[
			'aryProviderSoDetail'=>$aryProviderSoDetail,
		]); 
		
		

    }

}
