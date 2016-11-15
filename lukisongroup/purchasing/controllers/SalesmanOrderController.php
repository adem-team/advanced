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
	public function actionReview()
    {
		/*
		 * Render Approved View
		 * @author ptrnov  <piter@lukison.com>
		 * @since 1.1
		**/
		
		
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('kd');
			return true;
			/* return $this->renderAjax('_actionReview',[
				'dataProvider'=>$id,
			]); */
		}

    }

}
