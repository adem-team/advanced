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

use lukisongroup\purchasing\models\data_term\Termheader;
use lukisongroup\purchasing\models\data_term\TermheaderSearch;
use lukisongroup\purchasing\models\data_term\TermdetailSearch;
use lukisongroup\purchasing\models\data_term\RtdetailSearch;

use lukisongroup\purchasing\models\data_term\ActualModel;

class DataTermController extends Controller
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
		$searchModel = new TermheaderSearch();		
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('index',[
			'dataProvider'=>$dataProvider
		]);
	}
	
	/*
	 * VIEW TERM
	 * Hanya untuk melihat sebatas view
	*/
	public function actionView($id){
		 /*TERM PLAN HEADER*/
		$searchModel = new TermheaderSearch();		
		$dataProvider = $searchModel->searchcusbyid(Yii::$app->request->queryParams,$id);
		$modelRslt=$dataProvider->getModels();
		/*BUDGET SEARCH*/
		$searchModelBudget= new TermdetailSearch();
		$dataProviderBudget = $searchModelBudget->searchbudget(Yii::$app->request->queryParams,$id);
		return $this->render('view',[
			'dataProvider'=>$dataProvider,
			'model'=>$modelRslt,
			'dataProviderBudget'=>$dataProviderBudget
		]);
		/*
		 * NOTED VIEWS FILES:
		 * view-> _viewData  -> _viewDataExpand[_viewDataExpandActual,_viewDataExpandPlan]
		 *        _viewChart []
		*/
	}
	
	/*
	 * REVIEW TERM
	 * Data term yang bisa di update [budget plan | budget actual -> button Actual investment ]
	 * Rwview by Marketing/Accounting/Direction
	*/
	public function actionReview($id){
		 /*TERM PLAN HEADER*/
		$searchModel = new TermheaderSearch();		
		$dataProvider = $searchModel->searchcusbyid(Yii::$app->request->queryParams,$id);
		$modelRslt=$dataProvider->getModels();
		print_r($modelRslt->TERM_ID);
		/*BUDGET SEARCH*/
		$searchModelBudget= new TermdetailSearch();
		$dataProviderBudget = $searchModelBudget->searchbudget(Yii::$app->request->queryParams,$id);
		return $this->render('review',[
			'dataProvider'=>$dataProvider,
			'model'=>$modelRslt,
			'dataProviderBudget'=>$dataProviderBudget
		]);
		/*
		 * NOTED VIEWS FILES:
		 * review-> _reviewData  -> _reviewDataExpand[_reviewDataExpandActual,_reviewDataExpandPlan]
		 *          _reviewChart []
		*/
	}
	
	/*
	 * ACTUAL BUGDET
	 * Manual Input = by condition | Direct input
	 * [Default harus melalui request investment]
	 * Accounting Input semua perngeluaran investasi per Account
	*/
	public function actionActualReview($id){
		 /*TERM PLAN HEADER*/
		$searchModel = new TermheaderSearch();		
		$dataProvider = $searchModel->searchcusbyid(Yii::$app->request->queryParams,$id);
		$modelRslt=$dataProvider->getModels();
		/*BUDGET SEARCH*/
		$searchModelBudget= new TermdetailSearch();
		$dataProviderBudget = $searchModelBudget->searchbudget(Yii::$app->request->queryParams,$id);
		
		$searchModelRdetail= new RtdetailSearch();
		$dataProviderRdetail = $searchModelRdetail->search(Yii::$app->request->queryParams,$id);
		
		return $this->render('actual_review',[
			'dataProvider'=>$dataProvider,
			'model'=>$modelRslt,
			'dataProviderBudget'=>$dataProviderBudget,
			'dataProviderRdetail'=>$dataProviderRdetail
		]);
		/*
		 * NOTED VIEWS FILES:
		 * review-> _reviewData  -> button [Actual Investment]  -> [contreoller]actionActualReview ->actual_review
		*/
	}
	
	public function actionActualReviewAdd($id){
		/* $model = new Termcustomers();

        if ($model->load(Yii::$app->request->post())) {
          $model->ID_TERM = Yii::$app->ambilkonci->getkdTerm();
          if($model->validate())
          {
              $model->CREATED_AT = date("Y-m-d H:i:s");
              $model->CREATED_BY = Yii::$app->user->identity->username;
              $model->save();

          }
            return $this->redirect(['review-act','id'=>$model->ID_TERM]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        } */
		
		$termHeader=Termheader::find()->where(['TERM_ID'=>$id])->one();
		
		/*Model Scnario*/
		$actualModel = new ActualModel();
		
		return $this->renderAjax('actual_form',[
			'term_id'=>$id,
			'termHeader'=>$termHeader,
			'actualModel'=>$actualModel
		]);
	}
	
	public function actionActualReviewSave(){
		$ActualModel = new ActualModel();
		/*Ajax Load*/
		if(Yii::$app->request->isAjax){
			$ActualModel->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($ActualModel));
		}else{	
			//if($ActualModel->load(Yii::$app->request->post())){
			//	if ($ActualModel->actualmodel_saved()){

					$hsl = \Yii::$app->request->post();
					$temIdRst = $hsl['ActualModel']['temId'];
					
			//	}
			//} 
			return $this->redirect(['actual-review', 'id'=>$temIdRst]);
		} 
		
    }
}