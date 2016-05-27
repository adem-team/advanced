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
use yii\widgets\ActiveForm;

use lukisongroup\purchasing\models\trmplan\Termplan;
use lukisongroup\purchasing\models\trmplan\TermplanSearch;
use lukisongroup\purchasing\models\trmplan\TermbudgetSearch;
class PlanTermController extends Controller
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
     * Index
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
    public function actionIndex(){
		$searchModel = new TermplanSearch();		
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('index',[
			'dataProvider'=>$dataProvider
		]);
	}
	
	 public function actionReview($id){
		 /*TERM PLAN HEADER*/
		$searchModel = new TermplanSearch();		
		$dataProvider = $searchModel->searchcusbyid(Yii::$app->request->queryParams,$id);
		$modelRslt=$dataProvider->getModels();
		/*BUDGET SEARCH*/
		$searchModelBudget= new TermbudgetSearch();
		$dataProviderBudget = $searchModelBudget->searchbudget(Yii::$app->request->queryParams,$id);
		return $this->render('review',[
			'dataProvider'=>$dataProvider,
			'model'=>$modelRslt,
			'dataProviderBudget'=>$dataProviderBudget
		]);
	}
	
}