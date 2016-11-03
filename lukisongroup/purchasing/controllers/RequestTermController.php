<?php

namespace lukisongroup\purchasing\controllers;

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

/* namespace models*/
use lukisongroup\purchasing\models\rqt\Requesttermheader;
use lukisongroup\purchasing\models\rqt\RequesttermheaderSearch;
use lukisongroup\purchasing\models\rqt\DetailListSearch;
use lukisongroup\purchasing\models\rqt\DetailList;
use lukisongroup\purchasing\models\rqt\Rtdetail;
use lukisongroup\purchasing\models\rqt\Arsipterm;
use lukisongroup\purchasing\models\data_term\Termheader;
use lukisongroup\purchasing\models\data_term\Termdetail;
use lukisongroup\purchasing\models\rqt\RtdetailSearch;

use lukisongroup\purchasing\models\rqt\AdditemValidation;
use lukisongroup\purchasing\models\rqt\AddNewitemValidation;

use lukisongroup\purchasing\models\rqt\Auth1Model;
use lukisongroup\purchasing\models\rqt\Auth2Model;
use lukisongroup\purchasing\models\rqt\Auth3Model;

use lukisongroup\hrd\models\Employe;
//use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Tipebarang;
use yii\data\ActiveDataProvider;
use lukisongroup\sistem\models\Userlogin;
use lukisongroup\purchasing\models\rqt\Validateitem;
use lukisongroup\hrd\models\Dept;
use lukisongroup\hrd\models\Corp;
use yii\web\UploadedFile;
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Terminvest;

// use lukisongroup\hrd\models\Employe;

/**
 * RequestorderController implements the CRUD actions for Requestorder model.
 */
class RequestTermController extends Controller
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
        // component user
		    $profile=Yii::$app->getUserOpt->Profile_user();

        /*inbox tab ||index*/
    		$searchModel = new RequesttermheaderSearch();
        $dataProviderInbox = $searchModel->searchRtInbox(Yii::$app->request->queryParams);

        /*outbox tab ||index*/
        $searchmodel = new RequesttermheaderSearch();
        $dataProviderOutbox = $searchmodel->searchRtOutbox(Yii::$app->request->queryParams);

        /*history tab ||index*/
        $searchmodelHistory = new RequesttermheaderSearch();
        $dataproviderHistory = $searchmodelHistory->searchRthistory(Yii::$app->request->queryParams);


        // data for search index Rt//
        $AryCorp = ArrayHelper::map(Corp::find()->all(), 'CORP_ID', 'CORP_NM');
        $Combo_Dept = ArrayHelper::map(Dept::find()->orderBy('SORT')->asArray()->all(), 'DEP_NM','DEP_NM');
        // ** //

        $datachecked = Requesttermheader::find()->where("STATUS = 101 AND STATUS <> 3 AND USER_CC='".$profile->emp->EMP_ID."'")
                                                ->count();
        $datacreate = Requesttermheader::find()->where("STATUS <> 3 AND STATUS = 0 AND ID_USER = '".$profile->emp->EMP_ID."'")
                                            ->count();
        $dataapprove = Requesttermheader::find()->where("STATUS = 102 AND  STATUS <>3 AND KD_DEP='".$profile->emp->DEP_ID."' OR STATUS = 5")
                                            ->count();
        $dataAprrove = new ActiveDataProvider([
                            'query' => Requesttermheader::find()->where("STATUS = 102 AND STATUS<>3  AND KD_DEP='".$profile->emp->DEP_ID."'OR STATUS = 5"),
                            'pagination' => [
                              'pageSize' => 5,
                                      ],
                                  ]);
        $dataChecked = new ActiveDataProvider([
                                    'query' => Requesttermheader::find()->where("STATUS = 101 AND USER_CC='".$profile->emp->EMP_ID."'"),
                                      'pagination' => [
                                            'pageSize' => 5,
                                                        ],
                                                ]);
        $dataCreate = new ActiveDataProvider([
                                    'query' => Requesttermheader::find()->where("STATUS <> 3 AND STATUS = 0 AND ID_USER = '".$profile->emp->EMP_ID."'"),
                                      'pagination' => [
                                            'pageSize' => 5,
                                                        ],
                                                ]);

  		  return $this->render('index', [
        'searchModel' => $searchModel,
  			'dataProviderInbox' =>$dataProviderInbox,
        'searchmodel' => $searchmodel,
  			'dataProviderOutbox' =>$dataProviderOutbox,
        'searchmodelHistory' => $searchmodelHistory,
        'dataproviderHistory' => $dataproviderHistory,
        'datachecked'=>  $datachecked,
        'datacreate'=>$datacreate,
        'dataCreate'=>$dataCreate,
        'dataapprove'=>$dataapprove,
        'dataAprrove'=>$dataAprrove,
        'dataChecked' => $dataChecked,
        'Combo_Dept'=>$Combo_Dept,
        'AryCorp'=>$AryCorp
          ]);


    }

    public function aryData_Customers($cust_kd){ 
        return ArrayHelper::map(Customers::find()->where('STATUS<>3')->andwhere(['CUST_GRP'=>$cust_kd])->all(), 'CUST_NM','CUST_NM');
  }
  public function aryData_invest($term_id){
     return ArrayHelper::map(Termdetail::find()->where(['STATUS'=>2,'TERM_ID'=>$term_id])->all(), 'INVES_ID','namainvest');
  }

    public function actionListAll($kd,$term_id,$cust_kd){
        $model = new DetailList();
       
         if ($model->load(Yii::$app->request->post()) ) {
             $model->TERM_ID = $term_id;
            $model->KD_RIB = $kd;
           $model->save();
           
        
            return $this->redirect(['/purchasing/request-term/edit?kd='.$model->KD_RIB]);
        } else {
            return $this->renderAjax('list_store', [
                'model' => $model,
                'items' => self::aryData_Customers($cust_kd),
                'list_store'=>self::aryData_invest($term_id),
            ]);
        }

    }

    public function ary_cus_term()
    {
       $sql = 'SELECT td.CUST_NM,th.TERM_ID,th.CUST_KD_PARENT FROM `t0000header` th INNER JOIN c0001 td on th.CUST_KD_PARENT = td.CUST_KD where th.`STATUS` = 1';
       $connent = Yii::$app->db_esm;
       $execute = $connent->createCommand($sql)->queryAll();

       $customers = ArrayHelper::map($execute,
                  function ($customers, $defaultValue) {
                      return $customers['TERM_ID'] . '-' . $customers['CUST_KD_PARENT'];
                  },'CUST_NM'
          );

      return $customers;
    }

    public function ary_invets()
    {
      /* array*/
      $data_invest = ArrayHelper::map(Terminvest::find()->all(),'ID','INVES_TYPE');
      return $data_invest;
    }

    /**
     * Creates a new Requestorder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
    public function actionCreate()
    {

		  $model = new Requesttermheader(); //t0001header
      $model->scenario = 'simpan';
      $radiorqt = Yii::$app->request->post();
      $term_invest = new Rtdetail(); //t0001detail


      if ($model->load(Yii::$app->request->post())&&$term_invest->load(Yii::$app->request->post())) {

        $radioterm = $radiorqt['Requesttermheader']['NEW'];
        if($radioterm == 1)
        {
          $kode = Yii::$app->ambilkonci->getRtiCode($model->KD_CORP);
          $model->KD_RIB = $kode;

        }else{
          $kode = Yii::$app->ambilkonci->getRtbCode($model->KD_CORP);
          $model->KD_RIB = $kode;

        }

        $explode = explode('-',$model->CUST_ID_PARENT);
        $model->CUST_ID_PARENT = $explode[1];
        $model->TERM_ID = $explode[0];
        $model->CREATED_AT = date('Y-m-d');
        $model->ID_USER = Yii::$app->getUserOpt->Profile_user()->EMP_ID;
        $model->KD_DEP = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
        $model->save();


        $term_invest->KD_RIB = $model->KD_RIB;
        $term_invest->INVESTASI_TYPE = $term_invest->ID_INVEST;
        $term_invest->CREATED_AT = date('Y-m-d');
        $term_invest->CREATED_BY = Yii::$app->user->identity->username;
        $term_invest->PERIODE_START  = $model->PERIOD_START;
        $term_invest->PERIODE_END =  $model->PERIOD_END;
        // $term_invest->ID_INVEST = $term_invest->ID_INVEST;
        $term_invest->TERM_ID = $cari_term ;
        if($term_invest->save())
        {
            $cari_account = Termdetail::find()->where(['TERM_ID'=>$model->TERM_ID,'INVES_ID'=>$term_invest->ID_INVEST])->andwhere(['<>','STATUS',2])->one();
            if(!$cari_account)
            {
              $termdetail = new Termdetail();
              $termdetail->CUST_KD_PARENT = $model->CUST_ID_PARENT;
              $termdetail->INVES_ID = $term_invest->INVESTASI_TYPE;
              $termdetail->INVES_TYPE =  $termdetail->INVES_ID;
              $termdetail->TERM_ID = $model->TERM_ID;
              $termdetail->CORP_ID = $model->KD_CORP;
              $termdetail->STATUS  = 2;
              $termdetail->CREATE_BY  = Yii::$app->user->identity->username;
              $termdetail->CREATE_AT = date('Y-m-d');
              $termdetail->PERIODE_START  = $model->PERIOD_START;
              $termdetail->PERIODE_END =  $model->PERIOD_END;
              $termdetail->save();
            }
            
        }

        	return $this->redirect(['/purchasing/request-term/edit?kd='.$model->KD_RIB]);
      } else {
      return $this->renderAjax('_form', [
                'model' => $model,
                'term_invest'=>$term_invest,
                'cus_data'=>self::ary_cus_term(),
                'corp'=>Yii::$app->getUserOpt->Profile_user()->emp->EMP_CORP_ID,
                'data_invest'=>self::ary_invets()
            ]);

    }
  }

  public function actionDisplayImage($kd)
  {
   

    return $this->renderAjax('display_image',[
                            'kd'=>$kd
      ]);

  }

  public function actionAddNewInvest($kd,$term_id,$cust_kd)
  {
    # code...
       $model = new Rtdetail();
       $model->scenario = 'simpan';
    if ($model->load(Yii::$app->request->post())) {
          $model->TERM_ID = $term_id; 
          $model->KD_RIB = $kd;
          $model->ID_INVEST = $model->INVESTASI_TYPE;
          if($model->save())
          {

             $cari_account = Termdetail::find()->where(['TERM_ID'=>$model->TERM_ID,'INVES_ID'=>$model->ID_INVEST])->andwhere(['<>','STATUS',2])->one();
             if(!$cari_account)
             {
                   $termdetail = new Termdetail();
                    $termdetail->CUST_KD_PARENT = $cust_kd;
                    $termdetail->INVES_ID = $model->INVESTASI_TYPE;
                    $termdetail->INVES_TYPE =  $termdetail->INVES_ID;
                    $termdetail->TERM_ID = $model->TERM_ID;
                    $termdetail->CORP_ID = Yii::$app->getUserOpt->Profile_user()->emp->EMP_CORP_ID;
                    $termdetail->STATUS  = 2;
                    $termdetail->CREATE_BY  = Yii::$app->user->identity->username;
                    $termdetail->CREATE_AT = date('Y-m-d');
                    $termdetail->save();
             }

             
          }
        return $this->redirect(['/purchasing/request-term/edit?kd='.$model->KD_RIB]);
    } else {
    return $this->renderAjax('_new_invest', [
              'model' => $model,
              'data_invest'=>self::ary_invets()
          ]);
        }

  }

    public function actionValid()
    {
      # code...
        $model = new rtDetail();
      if(Yii::$app->request->isAjax && $model->load($_POST))
      {
        Yii::$app->response->format = 'json';
        return ActiveForm::validate($model);
      }
    }





	/**
     * Edit Form - Add Item Barang | Tambah Barang
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
    public function actionAdditem($kd)
    {
			//$roDetail = new Rodetail();
			$roDetail = new AdditemValidation();
			$roHeader = Requesttermheader::find()->where(['KD_RO' => $kd])->one();
			$employ = $roHeader->employe;
			$dept = $roHeader->dept;

			/*
			 * Convert $roHeader->detro to ArrayDataProvider | Identity 'key' => 'ID',
			 * @author ptrnov  <piter@lukison.com>
			 * @since 1.1
			**/
			 $detroProvider = new ArrayDataProvider([
				'key' => 'ID',
				'allModels'=>$detro,
				'pagination' => [
					'pageSize' => 10,
				],
			]);

			return $this->renderAjax('additem', [
				'roHeader' => $roHeader,
				'roDetail' => $roDetail,
				'dataProvider'=>$detroProvider,
			]);

    }


	/**
	 * Edit Form - Add New Item Barang | Tambah Barang
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	 */
    public function actionAddNewItem($kd)
    {
			$roDetail = new AdditemValidation();
			$roHeader = Requesttermheader::find()->where(['KD_RO' => $kd])->one();
			$detro = $roHeader->detro;
			$employ = $roHeader->employe;
			$dept = $roHeader->dept;
      // $model = new \yii\base\DynamicModel(['addNEW']);
      // $model->addRule(['addNEW'], 'required');
      // addnewitem
      		// [['kD_RO','nM_BARANG','kD_KATEGORI','kD_SUPPLIER','kD_TYPE','uNIT','rQTY','hARGA'], 'required'],

          // additem
          // [['kD_BARANG'], 'findcheck'],
          // [['kD_RO','kD_BARANG','uNIT','rQTY'], 'required'],

			/*
			 * Convert $roHeader->detro to ArrayDataProvider | Identity 'key' => 'ID',
			 * @author ptrnov  <piter@lukison.com>
			 * @since 1.1
			**/
			 $detroProvider = new ArrayDataProvider([
				'key' => 'ID',
				'allModels'=>$detro,
				'pagination' => [
					'pageSize' => 10,
				],
			]);

			return $this->renderAjax('addnewitem', [
				'roHeader' => $roHeader,
        // 'model'=>$model,
				'roDetail' => $roDetail,
				'dataProvider'=>$detroProvider,
			]);

    }

	public function actionItemDetailView($kdro){

		$roHeader = Rtdetail::find()->where(['KD_RIB' => $kdro])->one();
		// $roDetail = $roHeader->detro;
		return $this->renderAjax('detailviewitem', [
				'roDetail' => $roHeader,
		]);
	}



	/**
     * Add Item Barang to SAVED | AJAX
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionAddNewItem_saved(){
		//$roDetail = new Rodetail();
		$roDetail = new AdditemValidation();

		if(Yii::$app->request->isAjax){
			$roDetail->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($roDetail));
		}else{
			if($roDetail->load(Yii::$app->request->post())){
				if($roDetail->addnewitem_saved()){
					$hsl = \Yii::$app->request->post();
					$kdro = $hsl['AddNewitemValidation']['kD_RO'];
					return $this->redirect(['/purchasing/request-term/edit?kd='.$kdro]);
				}
			}
		}
	}


  // public function actionItemSaved(){
	// 	//$roDetail = new Rodetail();
	// 	$roDetail = new Validateitem();
  //
	// 	if(Yii::$app->request->isAjax){
	// 		$roDetail->load(Yii::$app->request->post());
	// 		return Json::encode(\yii\widgets\ActiveForm::validate($roDetail));
	// 	}else{
	// 		if($roDetail->load(Yii::$app->request->post())){
	// 			if($roDetail->newsaved()){
	// 				$hsl = \Yii::$app->request->post();
	// 				// $kdro = $hsl['Rodetail']['KD_RO'];
  //         	$kdro = $roDetail->newsaved()->KD_RO;
  //           // print_r(	$kdro);
  //           // die();
	// 				return $this->redirect(['/purchasing/request-order/edit?kd='.$kdro]);
	// 			}
	// 		}
	// 	}
	// }


   /**
     * DepDrop | CORP-TYPE - KAT
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionCorpType() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$corp_id = $parents[0];
				$model = Tipebarang::find()->asArray()->where(['CORP_ID'=>$corp_id,'PARENT'=>0])->all();
				foreach ($model as $key => $value) {
					   $out[] = ['id'=>$value['KD_TYPE'],'name'=> $value['NM_TYPE']];
				   }

				   echo json_encode(['output'=>$out, 'selected'=>'']);
				   return;
			   }
		   }
		   echo Json::encode(['output'=>'', 'selected'=>'']);
	}

	/**
     * DepDrop |TYPE - KAT
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
    */
	public function actionTypeKat() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$corp_id = $parents[0];
				$type_id = $parents[1];
				$model = Kategori::find()->asArray()->where(['CORP_ID'=>$corp_id,'KD_TYPE'=>$type_id,'PARENT'=>0])->all();
				foreach ($model as $key => $value) {
					   $out[] = ['id'=>$value['KD_KATEGORI'],'name'=> $value['NM_KATEGORI']];
				   }

				   echo json_encode(['output'=>$out, 'selected'=>'']);
				   return;
			   }
		   }
		   echo Json::encode(['output'=>'', 'selected'=>'']);
	}


	/**
     * actionBrgkat() select2 Kategori mendapatkan barang
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionBrgkat() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$kat_id = $parents[0];
				$model = Barang::find()->asArray()->where(['KD_KATEGORI'=>$kat_id,'PARENT'=>0])->all();
				foreach ($model as $key => $value) {
					   $out[] = ['id'=>$value['KD_BARANG'],'name'=> $value['NM_BARANG']];
				   }

				   echo json_encode(['output'=>$out, 'selected'=>'']);
				   return;
			   }
		   }
		   echo Json::encode(['output'=>'', 'selected'=>'']);
	}

	/**
     * actionBrgkat() select2 barang mendapatkan unit barang
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionBrgunit() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			    $ids = $_POST['depdrop_parents'];
				$kat_id = empty($ids[0]) ? null : $ids[0];
				$brg_id = empty($ids[1]) ? null : $ids[1];
				if ($brg_id != null) {
					$brgu = new Barang();
					$model = Barang::find()->where("KD_BARANG='". $brg_id. "'")->one();
					$brgUnit = $model->unit;
					//foreach ($brgUnit as $value) {
						   //$out[] = ['id'=>$value['UNIT'],'name'=> $value['NM_UNIT']];
						   $out[] = ['id'=>$brgUnit->KD_UNIT,'name'=> $brgUnit->NM_UNIT];
						   //$out[] = ['id'=>'E07','name'=> $value->NM_UNIT];
					 // }

					   echo json_encode(['output'=>$out, 'selected'=>'']);
					   return;
				   }
		   }
		   echo Json::encode(['output'=>'', 'selected'=>'']);
	}

	
	/**
     * Add Request Detail
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionTambah($kd)
    {
		$searchModel = new RtdetailSearch();
        $dataProvider = $searchModel->searchChildRo(Yii::$app->request->queryParams,$kd);
		$roHeader = Requesttermheader::find()->where(['KD_RO' => $kd])->one();
		$roDetail = new Rtdetail();
            return $this->renderAjax('_update', [
						'roHeader' => $roHeader,
						'roDetail' => $roDetail,
						'detro' => $roHeader->detro,
						'searchModel'=>$searchModel,
						'dataProvider'=>$dataProvider
					]);
    }

    // public function actionValid()
    // {
    //   # code...
    //   $roDetail = new AdditemValidation();
    // if(Yii::$app->request->isAjax && $roDetail->load($_POST))
    // {
    //   Yii::$app->response->format = 'json';
    //   return ActiveForm::validate($roDetail);
    //   }
    // }

	

	 /**
     * View Requestorder & Detail
     * @param string $id
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
    public function actionView($kd)
    {
    	$ro = new Requesttermheader();
		$roHeader = Requesttermheader::find()->where(['KD_RIB' => $kd])->one();

     /*inbox tab ||index*/
        $searchModel1 = new DetailListSearch();
        $dataProviderList = $searchModel1->search(Yii::$app->request->queryParams,$kd);

		if(count($roHeader['KD_RIB'])<>0){
			$detro = $roHeader->detro;
			$employ = $roHeader->employe;
			$dept = $roHeader->dept;

			/*
			 * Convert $roHeader->detro to ArrayDataProvider | Identity 'key' => 'ID',
			 * @author ptrnov  <piter@lukison.com>
			 * @since 1.1
			**/
			$detroProvider = new ArrayDataProvider([
				'key' => 'ID',
				'allModels'=>$detro,
				'pagination' => [
					'pageSize' => 10,
				],
			]);

			return $this->render('view', [
				'roHeader' => $roHeader,
				'detro' => $detro,
				'employ' => $employ,
				'dept' => $dept,
				'dataProvider'=>$detroProvider,
        'dataProviderList'=>$dataProviderList
			]);
		}else{
			return $this->redirect('index');
		}
    }

	/**
     * Prosess Edit RO | Change Colomn Row | Tambah Row
     * @param string $id
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionEdit($kd)
    {

        /*inbox tab ||index*/
        $searchModel1 = new DetailListSearch();
        $dataProviderList = $searchModel1->search(Yii::$app->request->queryParams,$kd);
		/*
		 * Init Models
		 * @author ptrnov  <piter@lukison.com>
		 * @since 1.1
		**/
		$roHeader = Requesttermheader::find()->where(['KD_RIB' =>$kd])->one();
		if(count($roHeader['KD_RIB'])<>0){
			$detro = $roHeader->detro;
      // print_r($detro);
      // die();
			$employ = $roHeader->employe;
			$dept = $roHeader->dept;

			/*
			 * Convert $roHeader->detro to ArrayDataProvider | Identity 'key' => 'ID',
			 * @author ptrnov  <piter@lukison.com>
			 * @since 1.1
			**/
			$detroProvider = new ArrayDataProvider([
				'key' => 'ID',
				'allModels'=>$detro,
				'pagination' => [
					'pageSize' => 10,
				],
			]);

			/*
			 * Process Editable Row [Columm SQTY]
			 * @author ptrnov  <piter@lukison.com>
			 * @since 1.1
			**/
			if (Yii::$app->request->post('hasEditable')) {
				$id = Yii::$app->request->post('editableKey');
				$model = Rtdetail::findOne($id);
        $termdetail = Termdetail::find()->where(['TERM_ID'=>$model->TERM_ID,'INVES_ID'=>$model->ID_INVEST,'STATUS'=>2])->one();
				$out = Json::encode(['output'=>'', 'message'=>'']);
				$post = [];
				$posted = current($_POST['Rtdetail']);
				$post['Rtdetail'] = $posted;
				if ($model->load($post)) {
					$model->save();
					$output = '';
					if (isset($posted['RQTY'])) {
						$output = $model->RQTY;
					}
					if (isset($posted['SQTY'])) {
						$output = $model->SQTY;
					}
					if (isset($posted['HARGA'])) {
					   $output =  Yii::$app->formatter->asDecimal($model->HARGA, 2);
					}
					if (isset($posted['INVESTASI_PROGRAM'])) {
					   // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
						$output = $model->INVESTASI_PROGRAM;
					}
          if (isset($posted['NOMER_INVOCE'])) {
            $output = $model->NOMER_INVOCE;
          }
          if (isset($posted['NOMER_FAKTURPAJAK'])) {
            $output = $model->NOMER_FAKTURPAJAK;
          }
          if (isset($posted['PERIODE_START'])) {
            $output = $model->PERIODE_START;
          }
           if (isset($posted['PERIODE_END'])) {
            $output = $model->PERIODE_START;
          }
           if (isset($posted['PPN'])) {
            $output = $model->PPN;
            $termdetail->PPN = $model->PPN;
            $termdetail->save();
          }
          if (isset($posted['PPH23'])) {
            $output = $model->PPH23;
            $termdetail->PPH23 = $model->PPH23;
            $termdetail->save();
          }
					$out = Json::encode(['output'=>$output, 'message'=>'']);
				}
				// return ajax json encoded response and exit
				echo $out;
				return;
			}

			/*
			 * Render Approved View
			 * @author ptrnov  <piter@lukison.com>
			 * @since 1.1
			**/
			return $this->render('edit', [
				'roHeader' => $roHeader,
				'detro' => $detro,
				'employ' => $employ,
				'dept' => $dept,
				'dataProvider'=>$detroProvider,
        'dataProviderList'=>$dataProviderList
			]);
		}else{
			return $this->redirect('index');
		}
    }

	/**
     * Cetak PDF Approvad
     * @param string $id
     * @return mixed
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionCetakpdf($kd,$v){
    $roHeader = Requesttermheader::find()->where(['KD_RIB' => $kd])->one(); /*Noted check by status approval =1 header table | chek error record jika kosong*/
		$detro = $roHeader->detro;
    $employ = $roHeader->employe;
		$dept = $roHeader->dept;
		if ($v==101){
			$filterPdf="KD_RIB='".$kd."' AND (STATUS='101' OR STATUS='10')";
		}elseif($v!=101){
			$filterPdf="KD_RIB='".$kd."' AND STATUS<>'3'";
		}
		$roDetail = Rtdetail::find()->where($filterPdf)->all();

		/* PR Filter Status Output to Grid print*/
		$dataProvider = new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$roDetail,//$detro,
			'pagination' => [
				'pageSize' => 20,
			],
		]);

		//PR
		//$dataProviderFilter = $dataProvider->getModels();

		/* $StatusFilter = ["101","10"];
        $test1 = ArrayHelper::where($dataProviderFilter, function($key, $StatusFilter) {
             return is_string($value);
        });
		print_r($test1); */

		$content = $this->renderPartial( 'pdfview', [
            'roHeader' => $roHeader,
            'detro' => $detro,
            'employ' => $employ,
			'dept' => $dept,
			'dataProvider' => $dataProvider,
        ]);

		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_PORTRAIT,
			// stream to browser inline
			'destination' => Pdf::DEST_BROWSER,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			//D:\xampp\htdocs\advanced\lukisongroup\web\widget\pdf-asset
			'cssFile' => '@lukisongroup/web/widget/pdf-asset/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:12px}',
			 // set mPDF properties on the fly
			'options' => ['title' => 'Form Request Term','subject'=>'rqt'],
			 // call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>['Copyright@LukisonGroup '.date("r")],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		return $pdf->render();
	}




	/**
     * Tmp Cetak PDF Approvad
     * @param string $id
     * @return mixed
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionTempCetakpdf($kd,$v){
    	  $roHeader = Requesttermheader::find()->where(['KD_RIB' => $kd])->one(); /*Noted check by status approval =1 header table | chek error record jika kosong*/
		    $detro = $roHeader->detro;
        $employ = $roHeader->employe;
		    $dept = $roHeader->dept;
    		/* if ($v==101){
    			$filterPdf="KD_RO='".$kd."' AND (STATUS='101' OR STATUS='10')";
    		}elseif($v!=101){
    			$filterPdf="KD_RO='".$kd."' AND STATUS<>'3'";
    		} */
		  $roDetail = Rtdetail::find()->where(['KD_RIB'=>$kd])->all();

  		/* PR Filter Status Output to Grid print*/
  		$dataProvider = new ArrayDataProvider([
  			'key' => 'ID',
  			'allModels'=>$roDetail,//$detro,
  			'pagination' => [
  				'pageSize' => 20,
  			],
  		]);

		$content = $this->renderPartial( 'pdfview_tmp', [
            'roHeader' => $roHeader,
            'detro' => $detro,
            'employ' => $employ,
      			'dept' => $dept,
      			'dataProvider' => $dataProvider,
        ]);

		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_PORTRAIT,
			// stream to browser inline
			'destination' => Pdf::DEST_BROWSER,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			//D:\xampp\htdocs\advanced\lukisongroup\web\widget\pdf-asset
			'cssFile' => '@lukisongroup/web/widget/pdf-asset/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:12px}',
			 // set mPDF properties on the fly
			'options' => ['title' => 'Form Request term','subject'=>'rt'],
			 // call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>['Copyright@LukisonGroup '.date("r")],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		return $pdf->render();
	}


	/**
	 * On Approval View
	 * Approved_rodetail | Rodetail->ID |  $roDetail->STATUS = 101;
	 * Approved = 1
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionApproved_rodetail()
    {
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			//\Yii::$app->response->format = Response::FORMAT_JSON;
			$roDetail = Rtdetail::findOne($id);
	    $roDetail->STATUS = 1;
			//$ro->NM_BARANG=''
			$roDetail->save();
			return true;
		}
   }

	/**
	 * On Approval View
	 * Reject_rodetail | Rodetail->ID |  $roDetail->STATUS = 4;
	 * Reject = 4
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionReject_rodetail()
    {
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			$roDetail = Rtdetail::findOne($id);
			$roDetail->STATUS = 4;
			$roDetail->save();
			return true;
		}
     }

	/**
	 * On Approval View
	 * Canclet_rodetail | Rodetail->ID |  $roDetail->STATUS = 4;
	 * Cancel = 0
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionCancel_rodetail()
    {
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			$roDetail = Rtdetail::findOne($id);
			$roDetail->STATUS = 0;
			$roDetail->save();
			return true;
		}
     }
	/**
     * Hapus Ro
     * @param string $id
     * @return mixed
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionHapus_item($kode,$id)
    {
		new Rtdetail();
		$ro = Rtdetail::findOne($id);
		$ro->STATUS = 3;
		$ro->save();

       //$this->findModel($id)->delete();
		return $this->redirect(['buatro','id'=>$kode]);
    }

	/**
     * Action Prosess Approval Colomn Row
     * @param string $id
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionReview($kd)
    {
		/*
		 * Init Models
		 * @author ptrnov  <piter@lukison.com>
		 * @since 1.1
		**/

     /*inbox tab ||index*/
        $searchModel1 = new DetailListSearch();
        $dataProviderList = $searchModel1->search(Yii::$app->request->queryParams,$kd);


		//$ro = new Requestorder();
		$roHeader = Requesttermheader::find()->where(['KD_RIB' =>$kd])->one();
		$detro = $roHeader->detro;
		$employ = $roHeader->employe;
		$dept = $roHeader->dept;

    $roDetail = Rtdetail::find()->where(['KD_RIB' =>$kd])->one();

		/*
		 * Convert $roHeader->detro to ArrayDataProvider | Identity 'key' => 'ID',
		 * @author ptrnov  <piter@lukison.com>
		 * @since 1.1
		**/
		$detroProvider = new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$detro,
			'pagination' => [
				'pageSize' => 10,
			],
		]);

		/*
		 * Process Editable Row [Columm SQTY]
		 * @author ptrnov  <piter@lukison.com>
		 * @since 1.1
		**/
		if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            $model = Rtdetail::findOne($id);
      			$out = Json::encode(['output'=>'', 'message'=>'']);
            $post = [];
            $posted = current($_POST['Rtdetail']);
            $post['Rtdetail'] = $posted;
            if ($model->load($post)) {
                $model->save();
				$output = '';
                if (isset($posted['RQTY'])) {
                    $output = $model->RQTY;
                }
				if (isset($posted['SQTY'])) {
					$output = $model->SQTY;
                }
				if (isset($posted['HARGA'])) {
                   $output =  Yii::$app->formatter->asDecimal($model->HARGA, 2);
                }
				if (isset($posted['INVESTASI_PROGRAM'])) {
                   // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
					        $output = $model->INVESTASI_PROGRAM;
                }
        if (isset($posted['NOMER_INVOCE'])) {
                           // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
                  $output = $model->NOMER_INVOCE;
                }
        if (isset($posted['NOMER_FAKTURPAJAK'])) {
                                   // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
                  $output = $model->NOMER_FAKTURPAJAK;
              }
                $out = Json::encode(['output'=>$output, 'message'=>'']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

		/*
		 * Render Approved View
		 * @author ptrnov  <piter@lukison.com>
		 * @since 1.1
		**/
		return $this->render('review', [
            'roHeader' => $roHeader,
            'detro' => $detro,
            'employ' => $employ,
      			'dept' => $dept,
      			'dataProvider'=>$detroProvider,
            'roDetail'=>$roDetail,
            'dataProviderList'=>$dataProviderList
        ]);

    }

    // function for email sign-auth1 author :wawan
    public function Sendmail($kd,$empid)
    {
      // element email
      $profile = Yii::$app->getUserOpt->Profile_user(); // create ro
      $user = $profile->username; //user create email
      $dep_id = $profile->emp->DEP_ID;
      $gf_id = $profile->emp->GF_ID;
      $usercc = Userlogin::find()->where(['EMP_ID'=>$empid])->asArray()->one(); // usercc
      $approve = Employe::find()->where("DEP_ID='".$dep_id."'AND GF_ID <=3")->asArray()->one();//approve ro

      $roHeader = Requesttermheader::find()->where(['KD_RO' => $kd])->one(); /*Noted check by status approval =1 header table | chek error record jika kosong*/
      $detro = $roHeader->detro;
      $employ = $roHeader->employe;
      $dept = $roHeader->dept;
      $roDetail = Rtdetail::find()->where(['KD_RO'=>$kd])->all();

    /* PR Filter Status Output to Grid print*/
    $dataProvider = new ArrayDataProvider([
      'key' => 'ID',
      'allModels'=>$roDetail,//$detro,
      'pagination' => [
        'pageSize' => 20,
      ],
    ]);

    //PR
    //$dataProviderFilter = $dataProvider->getModels();

    /* $StatusFilter = ["101","10"];
        $test1 = ArrayHelper::where($dataProviderFilter, function($key, $StatusFilter) {
             return is_string($value);
        });
    print_r($test1); */

      $content = $this->renderPartial( 'pdfview', [
            'roHeader' => $roHeader,
            'detro' => $detro,
            'employ' => $employ,
            'dept' => $dept,
            'dataProvider' => $dataProvider,
        ]);

        $contentMail= $this->renderPartial('sendmailcontent',[
          'roHeader' => $roHeader,
          'detro' => $detro,
          'employ' => $employ,
          'dept' => $dept,
          'dataProvider' => $dataProvider,
        ]);

		/*Body Notify*/
		$contentMailAttachBody= $this->renderPartial('postman_body',[
			'roHeader' => $roHeader,
			'dataProvider' => $dataProvider,
		]);

    $pdf = new Pdf([
      // set to use core fonts only
      'mode' => Pdf::MODE_CORE,
      // A4 paper format
      'format' => Pdf::FORMAT_A4,
      // portrait orientation
      'orientation' => Pdf::ORIENT_PORTRAIT,
      // stream to browser inline
      'destination' => Pdf::DEST_BROWSER,
      // your html content input
      'content' => $content,
      // format content from your own css file if needed or use the
      // enhanced bootstrap css built by Krajee for mPDF formatting
      //D:\xampp\htdocs\advanced\lukisongroup\web\widget\pdf-asset
      'cssFile' => '@lukisongroup/web/widget/pdf-asset/kv-mpdf-bootstrap.min.css',
      // any css to be embedded if required
      'cssInline' => '.kv-heading-1{font-size:12px}',
       // set mPDF properties on the fly
      'options' => ['title' => 'Form Request Order','subject'=>'ro'],
       // call mPDF methods on the fly
      'methods' => [
        'SetHeader'=>['Copyright@LukisonGroup '.date("r")],
        'SetFooter'=>['{PAGENO}'],
      ]
    ]);
    $to=[$user,$usercc['username'],$approve['EMP_EMAIL']];

    \Yii::$app->kirim_email->pdf($contentMail,'RO',$to,'Request-Order',$contentMailAttachBody);

    }


    // function for email sign-auth2(checked) author :wawan
    //connect  sign-auth2-save2
    public function Sendmail2($kd,$empid)
    {

      $roHeader = Requesttermheader::find()->where(['KD_RO' => $kd])->one(); /*Noted check by status approval =1 header table | chek error record jika kosong*/
      $detro = $roHeader->detro;
      $employ = $roHeader->employe;
      $dept = $roHeader->dept;
      $roDetail = Rtdetail::find()->where(['KD_RO'=>$kd])->all();


      // element email author :wawan
      $profile = Yii::$app->getUserOpt->Profile_user(); // profile
      $usercc = $profile->username; // send email usercc
      $user = Userlogin::find()->where(['EMP_ID'=>$roHeader->SIG1_ID])->asArray()->one();
      $usersign1 = $user['username']; // send mail user create ro
      $caridep_id = Employe::find()->where(['EMP_ID'=>$user['EMP_ID']])->asArray()->one();
      // $approve = Employe::find()->where(['DEP_ID'=>$caridep_id['DEP_ID']])->andwhere('GF_ID<=3')->asArray()->one();
      $approve = Employe::find()->where("DEP_ID='".$caridep_id['DEP_ID']."'AND GF_ID <=3")->asArray()->one();//approve ro
      $dep_head = $approve['EMP_EMAIL']; // send mail  deph_head approve ro


    /* PR Filter Status Output to Grid print*/
    $dataProvider = new ArrayDataProvider([
      'key' => 'ID',
      'allModels'=>$roDetail,//$detro,
      'pagination' => [
        'pageSize' => 20,
      ],
    ]);

    //PR
    //$dataProviderFilter = $dataProvider->getModels();

    /* $StatusFilter = ["101","10"];
        $test1 = ArrayHelper::where($dataProviderFilter, function($key, $StatusFilter) {
             return is_string($value);
        });
    print_r($test1); */

      $content = $this->renderPartial( 'pdfview', [
            'roHeader' => $roHeader,
            'detro' => $detro,
            'employ' => $employ,
            'dept' => $dept,
            'dataProvider' => $dataProvider,
        ]);

        $contentMail= $this->renderPartial('sendmailcontent',[
          'roHeader' => $roHeader,
          'detro' => $detro,
          'employ' => $employ,
          'dept' => $dept,
          'dataProvider' => $dataProvider,
        ]);

    /*Body Notify*/
    $contentMailAttachBody= $this->renderPartial('postman_body',[
      'roHeader' => $roHeader,
      'dataProvider' => $dataProvider,
    ]);

    $pdf = new Pdf([
      // set to use core fonts only
      'mode' => Pdf::MODE_CORE,
      // A4 paper format
      'format' => Pdf::FORMAT_A4,
      // portrait orientation
      'orientation' => Pdf::ORIENT_PORTRAIT,
      // stream to browser inline
      'destination' => Pdf::DEST_BROWSER,
      // your html content input
      'content' => $content,
      // format content from your own css file if needed or use the
      // enhanced bootstrap css built by Krajee for mPDF formatting
      //D:\xampp\htdocs\advanced\lukisongroup\web\widget\pdf-asset
      'cssFile' => '@lukisongroup/web/widget/pdf-asset/kv-mpdf-bootstrap.min.css',
      // any css to be embedded if required
      'cssInline' => '.kv-heading-1{font-size:12px}',
       // set mPDF properties on the fly
      'options' => ['title' => 'Form Request Order','subject'=>'ro'],
       // call mPDF methods on the fly
      'methods' => [
        'SetHeader'=>['Copyright@LukisonGroup '.date("r")],
        'SetFooter'=>['{PAGENO}'],
      ]
    ]);


    // aditiya@lukison.com
    // $to=[$dataemail['email'],$email,'purchasing@lukison.com',$datamanager['EMP_EMAIL']];
    $to=[$usersign1,$usercc,$dep_head];

    \Yii::$app->kirim_email->pdf($contentMail,'RO',$to,'Request-Order',$contentMailAttachBody);

    }



    // function for email sign-auth3(approve) author :wawan
    //connect  sign-auth3-save3
    public function Sendmail3($kd,$empid)
    {

      $roHeader = Requesttermheader::find()->where(['KD_RO' => $kd])->one(); /*Noted check by status approval =1 header table | chek error record jika kosong*/
      $detro = $roHeader->detro;
      $employ = $roHeader->employe;
      $dept = $roHeader->dept;
      $roDetail = Rtdetail::find()->where(['KD_RO'=>$kd])->all();


      // element email author :wawan
      $profile = Yii::$app->getUserOpt->Profile_user(); // profile
      $user_dephead = $profile->username; // email dephead
      $user = Userlogin::find()->where(['EMP_ID'=>$roHeader->SIG1_ID])->asArray()->one();
      $usersign1 = $user['username']; // send mail user create ro
      $cari = Employe::find()->where(['EMP_ID'=>$roHeader->SIG2_ID])->asArray()->one();
      $cari_usercc = Employe::find()->where(['DEP_ID'=>$cari['DEP_ID']])->andwhere('GF_ID<=3')->asArray()->one();
      $usercc = $cari_usercc['EMP_EMAIL']; // email usercc


    /* PR Filter Status Output to Grid print*/
    $dataProvider = new ArrayDataProvider([
      'key' => 'ID',
      'allModels'=>$roDetail,//$detro,
      'pagination' => [
        'pageSize' => 20,
      ],
    ]);

    //PR
    //$dataProviderFilter = $dataProvider->getModels();

    /* $StatusFilter = ["101","10"];
        $test1 = ArrayHelper::where($dataProviderFilter, function($key, $StatusFilter) {
             return is_string($value);
        });
    print_r($test1); */

      $content = $this->renderPartial( 'pdfview', [
            'roHeader' => $roHeader,
            'detro' => $detro,
            'employ' => $employ,
            'dept' => $dept,
            'dataProvider' => $dataProvider,
        ]);

        $contentMail= $this->renderPartial('sendmailcontent',[
          'roHeader' => $roHeader,
          'detro' => $detro,
          'employ' => $employ,
          'dept' => $dept,
          'dataProvider' => $dataProvider,
        ]);

    /*Body Notify*/
    $contentMailAttachBody= $this->renderPartial('postman_body',[
      'roHeader' => $roHeader,
      'dataProvider' => $dataProvider,
    ]);

    $pdf = new Pdf([
      // set to use core fonts only
      'mode' => Pdf::MODE_CORE,
      // A4 paper format
      'format' => Pdf::FORMAT_A4,
      // portrait orientation
      'orientation' => Pdf::ORIENT_PORTRAIT,
      // stream to browser inline
      'destination' => Pdf::DEST_BROWSER,
      // your html content input
      'content' => $content,
      // format content from your own css file if needed or use the
      // enhanced bootstrap css built by Krajee for mPDF formatting
      //D:\xampp\htdocs\advanced\lukisongroup\web\widget\pdf-asset
      'cssFile' => '@lukisongroup/web/widget/pdf-asset/kv-mpdf-bootstrap.min.css',
      // any css to be embedded if required
      'cssInline' => '.kv-heading-1{font-size:12px}',
       // set mPDF properties on the fly
      'options' => ['title' => 'Form Request Order','subject'=>'ro'],
       // call mPDF methods on the fly
      'methods' => [
        'SetHeader'=>['Copyright@LukisonGroup '.date("r")],
        'SetFooter'=>['{PAGENO}'],
      ]
    ]);


    // aditiya@lukison.com
    // $to=[$dataemail['email'],$email,'purchasing@lukison.com',$datamanager['EMP_EMAIL']];
    $to=[$usersign1,$usercc,$user_dephead];

    \Yii::$app->kirim_email->pdf($contentMail,'RO',$to,'Request-Order',$contentMailAttachBody);

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



    public function actionUploadTerm($id,$trm_id)
    {

      $arsip = new Arsipterm();

    if ($arsip->load(Yii::$app->request->post())) {
          $data = UploadedFile::getInstances($arsip, 'IMG_BASE64');


          $base64 = self::saveimage(file_get_contents($data[0]->tempName)); //call function
         
          $arsip->IMG_BASE64 = $base64;
          $arsip->TERM_ID = $trm_id;
          $arsip->KD_RIB = $id;
          $arsip->save();
     
              return $this->redirect(['/purchasing/request-term/edit?kd='.$arsip->KD_RIB]);
        } else {
            return $this->renderAjax('arsip_term', [
                    'arsip' => $arsip,
                  ]);
        }

    }




	/*
	 * SIGNARURE AUTH1 | VIEW CREATED
	 * Status = 101
	 * Class Model Requestorder->Status = 101 [Approvad]
	 * Class Model Rodetail->Status 	= 101 [Approvad]
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	**/
	public function actionSignAuth1View($kd){
		$auth1Mdl = new Auth1Model();
		$rtHeader = Requesttermheader::find()->where(['KD_RIB' =>$kd])->one();
		$employe = $rtHeader->employe;
			return $this->renderAjax('sign-auth1', [
				'rtHeader' => $rtHeader,
				'employe' => $employe,
				'auth1Mdl' => $auth1Mdl,
			]);
	}
	/*SIGNARURE AUTH1 | SAVE */
	public function actionSignAuth1Save(){
		$auth1Mdl = new Auth1Model();
		/*Ajax Load*/
		if(Yii::$app->request->isAjax){
			$auth1Mdl->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($auth1Mdl));
		}else{	/*Normal Load*/
			if($auth1Mdl->load(Yii::$app->request->post())){
				if ($auth1Mdl->auth1_saved()){
					$hsl = \Yii::$app->request->post();
					$kdrib = $hsl['Auth1Model']['kdrib'];
          $user =  $hsl['Auth1Model']['empID'];
          // $this->Sendmail($kdro,$user); //email auth1
					return $this->redirect(['/purchasing/request-term/view','kd'=>$kdrib]);
				}
			}
		}
	}

	/*
	 * SIGNARURE AUTH2 | VIEW CREATED
	 * Status = 102
	 * Class Model Requestorder->Status = 102 [Approvad]
	 * Class Model Rodetail->Status 	= 102 [Approvad]
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	**/
	public function actionSignAuth2View($kd){
		$auth2Mdl = new Auth2Model();
		$rtHeader = Requesttermheader::find()->where(['KD_RIB' =>$kd])->one();
		$employe = $rtHeader->employe;
			return $this->renderAjax('sign-auth2', [
				'rtHeader' => $rtHeader,
				'employe' => $employe,
				'auth2Mdl' => $auth2Mdl,
			]);
	}
	/*SIGNARURE AUTH2 | SAVE */
	public function actionSignAuth2Save(){
		$auth2Mdl = new Auth2Model();
		/*Ajax Load*/
		if(Yii::$app->request->isAjax){
			$auth2Mdl->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($auth2Mdl));
		}else{	/*Normal Load*/
			if($auth2Mdl->load(Yii::$app->request->post())){
				if ($auth2Mdl->auth2_saved()){
					$hsl = \Yii::$app->request->post();
					$kdrib = $hsl['Auth2Model']['kdrib'];
          $user =  $hsl['Auth1Model']['empID'];
          // $this->Sendmail2($kdrib,$user); //email auth2
					return $this->redirect(['/purchasing/request-term/review','kd'=>$kdrib]);
				}
			}
		}
	}

	/*
	 * SIGNARURE AUTH3 | VIEW APPROVED
	 * Status = 103
	 * Class Model Requestorder->Status = 103 [Approvad]
	 * Class Model Rodetail->Status 	= 103 [Approvad]
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	**/
	public function actionSignAuth3View($kd){
		$auth3Mdl = new Auth3Model();
    $rtHeader = Requesttermheader::find()->where(['KD_RIB' =>$kd])->one();
    $employe = $rtHeader->employe;
			return $this->renderAjax('sign-auth3', [
				'rtHeader' => $rtHeader,
				'employe' => $employe,
				'auth3Mdl' => $auth3Mdl,
			]);
	}
	/*SIGNARURE AUTH3 | SAVE */
	public function actionSignAuth3Save(){
		$auth3Mdl = new Auth3Model();
		/*Ajax Load*/
		if(Yii::$app->request->isAjax){
			$auth3Mdl->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($auth3Mdl));
		}else{	/*Normal Load*/
			if($auth3Mdl->load(Yii::$app->request->post())){
				if ($auth3Mdl->auth3_saved()){
					$hsl = \Yii::$app->request->post();
					$kdrib = $hsl['Auth3Model']['kdrib'];
          $user =  $hsl['Auth1Model']['empID'];
          // $this->Sendmail3($kdro,$user); ////email auth3
					return $this->redirect(['/purchasing/request-term/review','kd'=>$kdrib]);
				}
			}
		}
	}


	/**
     * Updates an existing Requestorder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdateNote($id)
    {
        $model = $this->findModel($id);

        $term_id = $model->TERM_ID;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/purchasing/request-term/edit?kd='.$id]);
        } else {
            return $this->renderAjax('note', [
                'model' => $model,
                'header'=>$term_id
            ]);
        }
    }


      /**
     * Updates an existing Requestorder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

	/*
	 * Hapus RO |Header|Detail|
	 * STATUS =3 [DELETE]
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	**/
    public function actionHapusro($kd)
    {
		$model = Requesttermheader::find()->where(['KD_RO' =>$kd])->one();
		$model->STATUS=3;
		$model->save();

		$model = Rtdetail::find()->where(['KD_RO' =>$kd])->one();
		$model->STATUS=3;
		$model->save();
		return Yii::$app->getResponse()->redirect(['/purchasing/request-term/index']);
    }

    /**
     * Deletes an existing Requestorder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionCreatepo()
    {
        return $this->render('createpo');
    }

    /**
     * Finds the Requestorder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Requestorder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModeldetail($id)
    {
        if (($model = Rtdetail::find(['KD_RIB'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Requesttermheader model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Requestorder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Requesttermheader::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
