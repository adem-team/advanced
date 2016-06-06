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
use lukisongroup\master\models\Terminvest;
use lukisongroup\master\models\Customers;
use lukisongroup\purchasing\models\data_term\TermheaderSearch;
use lukisongroup\purchasing\models\data_term\TermdetailSearch;
use lukisongroup\purchasing\models\data_term\Termdetail;
use lukisongroup\purchasing\models\data_term\Requesttermheader;
use lukisongroup\purchasing\models\data_term\PostAccount;
use lukisongroup\purchasing\models\data_term\RtdetailSearch;
use lukisongroup\purchasing\models\data_term\Rtdetail;

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


    public function actionDeleteActual($id,$kd)
    {

      $model = Rtdetail::find()->where(['KD_RIB'=>$kd])->one();
      $model->STATUS = 3;
      $model->save();
      return $this->redirect(['actual-review','id'=>$id]);
    }



    public function actionCreateTermData()
    {
      $model = new Termheader();
      # code...
      if ($model->load(Yii::$app->request->post()) ) {
          $model->TERM_ID = Yii::$app->ambilkonci->getkdTermData();
          $model->CREATED_AT = date("Y-m-d H:i:s");
          $model->CREATED_BY = Yii::$app->user->identity->username;
          $model->save();
          return $this->redirect(['review', 'id'=>$model->TERM_ID]);
      }else {
        return $this->renderAjax('new_term', [
            'model' => $model,
        ]);
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
			'dataProviderRdetail'=>$dataProviderRdetail,
      'searchModelRdetail'=>$searchModelRdetail
		]);
		/*
		 * NOTED VIEWS FILES:
		 * review-> _reviewData  -> button [Actual Investment]  -> [contreoller]actionActualReview ->actual_review
		*/
	}


/**
  *save account using list_box||_account
  *@author wawan
*/
  public function actionAccountInvestment($id){
      $model = new PostAccount();

       $model->term_id = $id;

      if ($model->load(Yii::$app->request->post())) {
            $model->saveAccount();

        return $this->redirect(['review', 'id'=>$model->term_id]);
      }


            $invets = Yii::$app->db_esm->createCommand("SELECT * FROM `c0006` c6  WHERE NOT EXISTS (SELECT INVES_ID FROM `t0000detail` `td` WHERE td.INVES_ID = c6.ID and td.TERM_ID ='".$id."')")->queryAll();
            $items = ArrayHelper::map($invets, 'ID', 'INVES_TYPE');

        return $this->renderAjax('_account',[
              'model'=>$model,
              'items'=>$items
        ]);
      }


      /**
        *update request  term detail and header
        *@author wawan
      */
    public function actionUpdateTerm($id,$kd_term){
          $model = Rtdetail::find()->where(['KD_RIB'=>$id])->one();
          $model_header = Requesttermheader::find()->where(['KD_RIB'=>$id])->one();
          $cari_header_term = TermHeader::find()->where(['TERM_ID'=>$kd_term])->one();
          $cari_customers = Customers::find()->where(['CUST_GRP'=>$cari_header_term->CUST_KD_PARENT])->one();


          if ($model->load(Yii::$app->request->post())&&$model_header->load(Yii::$app->request->post())) {


              $model->save();
              $model_header->save();

              return $this->redirect(['actual-review', 'id'=>$model_header->TERM_ID]);
            }else {
              # code...
              return $this->renderAjax('edit_actual',[
                    'model'=>$model,
                    'model_header'=>$model_header,
                    'cari_customers'=>$cari_customers
              ]);
            }
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
			if($ActualModel->load(Yii::$app->request->post())){
				if ($ActualModel->actualmodel_saved()){
          // $hsl = \Yii::$app->request->post();
				}

			}
			return $this->redirect(['actual-review', 'id'=>$ActualModel->temId]);
		}

    }
}
