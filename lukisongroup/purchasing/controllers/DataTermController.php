<?php

namespace lukisongroup\purchasing\controllers;

/*extensions*/
use yii;
use yii\web\Request;
use yii\db\Query;
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
use yii\web\UploadedFile;

/* namespace models */
use lukisongroup\purchasing\models\data_term\Termheader;
use lukisongroup\purchasing\models\rqt\Arsipterm;
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
use lukisongroup\hrd\models\Corp;
use lukisongroup\master\models\Distributor;


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


    /*delete */
    public function actionDeleteActual($id,$kd)
    {

      $model = Rtdetail::find()->where(['KD_RIB'=>$kd])->one();
      $model->STATUS = 3;
      $model->save();
      return $this->redirect(['actual-review','id'=>$id]);
    }


    /*customers parent array*/
  public function aryData_Customers(){ 
    return ArrayHelper::map(Customers::find()->where('CUST_KD = CUST_GRP')->andwhere('STATUS<>3')->all(), 'CUST_KD','CUST_NM');
  }

  /*Distributor array*/
  public function aryData_Dis(){ 
    return ArrayHelper::map( Distributor::find()->where('STATUS<>3')
                              ->all(), 'KD_DISTRIBUTOR','NM_DISTRIBUTOR');
  }

   /*Corp array*/
  public function aryData_Corp(){ 
    return ArrayHelper::map(Corp::find()->all(), 'CORP_ID','CORP_NM');
  }


    /**
      *create models Termheader
      *if successful redirect review
      * @author wawan
      * @since 1.1.0 
    */
    public function actionCreateTermData()
    {
      $model = new Termheader();
      # code...
      if ($model->load(Yii::$app->request->post()) ) {
          $model->TERM_ID = Yii::$app->ambilkonci->getkdTermData(); # set kode term_id
          $model->CREATED_AT = date("Y-m-d H:i:s"); #set datetime
          $model->CREATED_BY = Yii::$app->user->identity->username; #set username
          $model->STATUS = 1; # default status running
          $model->save();
          return $this->redirect(['review', 'id'=>$model->TERM_ID,'cus_kd'=>$model->CUST_KD_PARENT]);
      }else {
        return $this->renderAjax('new_term', [
            'model' => $model,
            'parent_customers' => self::aryData_Customers(), #array parent customers
            'data_distributor' => self::aryData_Dis(), #array distributor
            'data_corp' => self::aryData_Corp(), #array corp
        ]);
      }
    }

      /*
      *convert base 64 image
      *@author:wawan since 1.0
    */
    public function saveimage($base64)
    {
      $base64 = str_replace('data:image/jpg;base64,', '', $base64);
      $base64 = base64_encode($base64);
      $base64 = str_replace(' ', '+', $base64);

      return $base64;

    }


     public function actionUploadTerm($trm_id,$cus_kd)
    {

      $arsip = new Arsipterm();

    if ($arsip->load(Yii::$app->request->post())) {
          $data = UploadedFile::getInstances($arsip, 'IMG_BASE64');


          $base64 = self::saveimage(file_get_contents($data[0]->tempName)); //call function
         
          $arsip->IMG_BASE64 = $base64;
          $arsip->TERM_ID = $trm_id;
          $arsip->save();
     
          return $this->redirect(['review', 'id'=>$trm_id,'cus_kd'=>$cus_kd]);
        } else {
            return $this->renderAjax('arsip_data_term', [
                    'arsip' => $arsip,
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
	public function actionReview($id,$cus_kd){
		 /*TERM PLAN HEADER*/
		$searchModel = new TermheaderSearch();
		$dataProvider = $searchModel->searchcusbyid(Yii::$app->request->queryParams,$id);
		// $modelRslt=$dataProvider->getModels();
		// print_r($modelRslt->TERM_ID);
    $modelRslt = Termheader::find()->where(['TERM_ID'=>$id])->one();
		/*BUDGET SEARCH*/
		$searchModelBudget= new TermdetailSearch();
		$dataProviderBudget = $searchModelBudget->searchbudget(Yii::$app->request->queryParams,$id);

    $searchModelBudgetdetail= new TermdetailSearch();
		$dataProviderBudgetdetail = $searchModelBudgetdetail->searchbudgetdetail(Yii::$app->request->queryParams,$id);

    $searchModelBudgetdetail_inves = new TermdetailSearch();
    $dataProviderBudgetdetail_inves = $searchModelBudgetdetail_inves->searchbudgetdetailinves(Yii::$app->request->queryParams,$id);
		return $this->render('review',[
			'dataProvider'=>$dataProvider,
			'model'=>$modelRslt,
			'dataProviderBudget'=>$dataProviderBudget,
      'dataProviderBudgetdetail'=>$dataProviderBudgetdetail,
      'cus_kd'=>$cus_kd,
      'dataProviderBudgetdetail_inves'=>$dataProviderBudgetdetail_inves
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
		// $modelRslt=$dataProvider->getModels();
    $modelRslt = Termheader::find()->where(['TERM_ID'=>$id])->one();
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
  public function actionAccountInvestment($id,$cus_kd){
      $model = new PostAccount();

       $model->cus_kd = $cus_kd;
       $model->term_id = $id;

      if ($model->load(Yii::$app->request->post())) {
            $model->saveAccount();

        return $this->redirect(['review', 'id'=>$model->term_id,'cus_kd'=>$cus_kd]);
      }


            $invets = Yii::$app->db_esm->createCommand("SELECT * FROM `c0006` c6  WHERE NOT EXISTS (SELECT INVES_ID FROM `t0000detail` `td` WHERE td.INVES_ID = c6.ID and td.TERM_ID ='".$id."')")->queryAll();
            $items = ArrayHelper::map($invets, 'ID', 'INVES_TYPE');
            // print_r($items);
            // die();

        return $this->renderAjax('_account',[
              'model'=>$model,
              'items'=>$items
        ]);
      }


 public function actionUpdateTarget($id,$cus_kd)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
          $model->TARGET_TEXT =  Yii::$app->mastercode->terbilang($model->TARGET_VALUE);
          $model->UPDATE_AT = date('Y-m-d');
          $model->UPDATE_BY = Yii::$app->user->identity->username;
          $model->save();
              return $this->redirect(['review', 'id'=>$model->TERM_ID,'cus_kd'=>$model->CUST_KD_PARENT]);
        } else {
            return $this->renderAjax('set_target', [
                'model' => $model,
                'cus_data'=>self::aryData_Customers(),
                'cus_dis'=>self::aryData_Dis()
            ]);
        }
    }


    public function actionUpdateTgl($id,$cus_kd)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
          $model->UPDATE_AT = date('Y-m-d');
          $model->UPDATE_BY = Yii::$app->user->identity->username;
          $model->save();
              return $this->redirect(['review', 'id'=>$model->TERM_ID,'cus_kd'=>$model->CUST_KD_PARENT]);
        } else {
            return $this->renderAjax('set_tanggal', [
                'model' => $model,
                'cus_data'=>self::aryData_Customers(),
                'cus_dis'=>self::aryData_Dis()
            ]);
        }
    }

     public function actionUpdatePihak($id,$cus_kd)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
          $model->UPDATE_AT = date('Y-m-d');
          $model->UPDATE_BY = Yii::$app->user->identity->username;
          $model->save();
              return $this->redirect(['review', 'id'=>$model->TERM_ID,'cus_kd'=>$model->CUST_KD_PARENT]);
        } else {
            return $this->renderAjax('set_pihak', [
                'model' => $model,
                'cus_data'=>self::aryData_Customers(),#array parent customers
                'cus_dis'=>self::aryData_Dis(), #array parent distributor
                'corp'=>self::aryData_Corp() #array corp
            ]);
        }
    }

     public function actionUpdateBudget($id,$cus_kd)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
          $model->UPDATE_AT = date('Y-m-d');
          $model->UPDATE_BY = Yii::$app->user->identity->username;
          $model->save();
              return $this->redirect(['review', 'id'=>$model->TERM_ID,'cus_kd'=>$model->CUST_KD_PARENT]);
        } else {
            return $this->renderAjax('set_budget', [
                'model' => $model,
                'cus_data'=>self::aryData_Customers(),
                'cus_dis'=>self::aryData_Dis()
            ]);
        }
    }


    /**
     * Finds the Termheader model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Termheader the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Termheader::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
