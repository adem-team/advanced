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

use lukisongroup\purchasing\models\ro\Requestorder;
use lukisongroup\purchasing\models\ro\RequestorderSearch;
use lukisongroup\purchasing\models\ro\Rodetail;
use lukisongroup\purchasing\models\ro\RodetailSearch;

use lukisongroup\purchasing\models\ro\AdditemValidation;
use lukisongroup\purchasing\models\ro\AddNewitemValidation;

use lukisongroup\purchasing\models\ro\Auth1Model;
use lukisongroup\purchasing\models\ro\Auth2Model;
use lukisongroup\purchasing\models\ro\Auth3Model;

use lukisongroup\hrd\models\Employe;
//use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Tipebarang;
use yii\data\ActiveDataProvider;
use lukisongroup\sistem\models\Userlogin;
use lukisongroup\purchasing\models\ro\Validateitem;
// use lukisongroup\hrd\models\Employe;

/**
 * RequestorderController implements the CRUD actions for Requestorder model.
 */
class RequestOrderController extends Controller
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
    public function actionIndex()
    {
		//Check componen generate kode RO
		//print_r(\Yii::$app->ambilkonci->getRoCode());


		//function getPermission(){
			//return Yii::$app->getUserOpt->Modul_akses(1);

		//}
		//$getPermission=Yii::$app->getUserOpt->Modul_akses(1);
		$searchModel = new RequestorderSearch();
		/*  if (isset($_GET['param'])){
			  $dataProvider = $searchModel->searchChildRo(Yii::$app->request->queryParams,$_GET['param']);
		}else{
			$dataProvider = $searchModel->searchChildRo(Yii::$app->request->queryParams);
		}  */

		//$searchModel->KD_RO ='2015.12.04.RO.0070';
		$dataProvider = $searchModel->searchRo(Yii::$app->request->queryParams);
		$dataProviderInbox = $searchModel->searchRoInbox(Yii::$app->request->queryParams);
		$dataProviderOutbox = $searchModel->searchRoOutbox(Yii::$app->request->queryParams);
    $profile=Yii::$app->getUserOpt->Profile_user();
    $datachecked = Requestorder::find()->where("PARENT_ROSO = 0 AND STATUS = 101 AND STATUS <> 3 AND USER_CC='".$profile->emp->EMP_ID."'")
                                        ->count();
    $datacreate = Requestorder::find()->where("PARENT_ROSO = 0 AND STATUS <> 3 AND STATUS = 0 AND ID_USER = '".$profile->emp->EMP_ID."'")
                                        ->count();
    $dataapprove = Requestorder::find()->where("PARENT_ROSO = 0 AND STATUS = 102 AND  STATUS <>3 AND KD_DEP='".$profile->emp->DEP_ID."' OR STATUS = 5")
                                        ->count();
    $dataAprrove = new ActiveDataProvider([
                    'query' => Requestorder::find()->where("PARENT_ROSO = 0 AND STATUS = 102 AND STATUS<>3  AND KD_DEP='".$profile->emp->DEP_ID."'OR STATUS = 5"),
                        'pagination' => [
                          'pageSize' => 5,
                                      ],
                              ]);
    $dataChecked = new ActiveDataProvider([
                                'query' => Requestorder::find()->where("PARENT_ROSO = 0 AND  STATUS = 101 AND USER_CC='".$profile->emp->EMP_ID."'"),
                                  'pagination' => [
                                        'pageSize' => 5,
                                                    ],
                                            ]);
    $dataCreate = new ActiveDataProvider([
                                'query' => Requestorder::find()->where("PARENT_ROSO = 0 AND STATUS <> 3 AND STATUS = 0 AND ID_USER = '".$profile->emp->EMP_ID."'"),
                                  'pagination' => [
                                        'pageSize' => 5,
                                                    ],
                                            ]);

		  return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
			'dataProviderInbox' =>$dataProviderInbox,
			'dataProviderOutbox' =>$dataProviderOutbox,
      'datachecked'=>  $datachecked,
      'datacreate'=>$datacreate,
      'dataCreate'=>$dataCreate,
      'dataapprove'=>$dataapprove,
      'dataAprrove'=>$dataAprrove,
      'dataChecked' => $dataChecked
			//'getPermission'=> $getPermission,
        ]);


    }

    /**
     * Creates a new Requestorder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
    public function actionCreate()
    {
      $model = new \yii\base\DynamicModel(['NEW']);
      $model->addRule(['NEW'], 'required');
		  $roDetail = new Rodetail();
		// $roHeader = new Requestorder();
      return $this->renderAjax('_form', [
                'roDetail' => $roDetail,
                  'model'=> $model
				        // 'roHeader' => $roHeader,
            ]);

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
			$roHeader = Requestorder::find()->where(['KD_RO' => $kd])->one();
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

			return $this->renderAjax('additem', [
				'roHeader' => $roHeader,
				'roDetail' => $roDetail,
				'dataProvider'=>$detroProvider,
			]);

    }


	/**
     * Add Item Barang to SAVED | AJAX
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionAdditem_saved(){
		//$roDetail = new Rodetail();
		$roDetail = new AdditemValidation();

		if(Yii::$app->request->isAjax){
			$roDetail->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($roDetail));
		}else{
			if($roDetail->load(Yii::$app->request->post())){
				if($roDetail->additem_saved()){
					$hsl = \Yii::$app->request->post();
					$kdro = $hsl['AdditemValidation']['kD_RO'];
					return $this->redirect(['/purchasing/request-order/edit?kd='.$kdro]);
				}
				//Request Result
			/*	$hsl = \Yii::$app->request->post();
				$kdRo = $hsl['Rodetail']['KD_RO'];
				$kdBarang = $hsl['Rodetail']['KD_BARANG'];
				$nmBarang = Barang::findOne(['KD_BARANG' => $kdBarang]);
				$kdUnit = $hsl['Rodetail']['UNIT'];
				$rqty = $hsl['Rodetail']['RQTY'];
				$note = $hsl['Rodetail']['NOTE'];

					//Request Put
					$roDetail->CREATED_AT = date('Y-m-d H:i:s');
					$roDetail->KD_RO = $kdRo;
					$roDetail->KD_BARANG = $kdBarang;
					$roDetail->NM_BARANG = $nmBarang->NM_BARANG;
					$roDetail->UNIT = $kdUnit;
					$roDetail->RQTY = $rqty;
					$roDetail->NOTE = $note;
					$roDetail->STATUS = 0;
					$roDetail->save();
				return $this->redirect(['/purchasing/request-order/edit?kd='.$kdRo]);*/
			}
		}
	}

	/**
	 * Edit Form - Add New Item Barang | Tambah Barang
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	 */
    public function actionAddNewItem($kd)
    {
			$roDetail = new Rodetail();
			$roHeader = Requestorder::find()->where(['KD_RO' => $kd])->one();
			$detro = $roHeader->detro;
			$employ = $roHeader->employe;
			$dept = $roHeader->dept;
      $model = new \yii\base\DynamicModel(['addNEW']);
      $model->addRule(['addNEW'], 'required');
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
        'model'=>$model,
				'roDetail' => $roDetail,
				'dataProvider'=>$detroProvider,
			]);

    }

	public function actionItemDetailView($kdro,$kdbrg){

		$brgDetail = Barang::find()->where(['KD_BARANG'=>$kdbrg])->One();
		$roHeader = Requestorder::find()->where(['KD_RO' => $kdro])->one();
		$roDetail = $roHeader->detro;
		return $this->renderAjax('detailviewitem', [
				'brgDetail' => $brgDetail,
				'roDetail' => $roDetail,
		]);
	}



	/**
     * Add Item Barang to SAVED | AJAX
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionAddNewItem_saved(){
		//$roDetail = new Rodetail();
		$roDetail = new AddNewitemValidation();

		if(Yii::$app->request->isAjax){
			$roDetail->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($roDetail));
		}else{
			if($roDetail->load(Yii::$app->request->post())){
				if($roDetail->addnewitem_saved()){
					$hsl = \Yii::$app->request->post();
					$kdro = $hsl['AddNewitemValidation']['kD_RO'];
					return $this->redirect(['/purchasing/request-order/edit?kd='.$kdro]);
				}
			}
		}
	}


  public function actionItemSaved(){
		//$roDetail = new Rodetail();
		$roDetail = new Validateitem();

		if(Yii::$app->request->isAjax){
			$roDetail->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($roDetail));
		}else{
			if($roDetail->load(Yii::$app->request->post())){
				if($roDetail->newsaved()){
					$hsl = \Yii::$app->request->post();
					// $kdro = $hsl['Rodetail']['KD_RO'];
          	$kdro = $roDetail->newsaved()->KD_RO;
            // print_r(	$kdro);
            // die();
					return $this->redirect(['/purchasing/request-order/edit?kd='.$kdro]);
				}
			}
		}
	}


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

	/*
	 * actionSimpanfirst() <- actionCreate()
	 * First Create RO |  Requestorder | Rodetail
	 * Add: component Yii::$app->getUserOpt->Profile_user()
	 * Add: component \Yii::$app->ambilkonci->getRoCode();
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
	**/
	public function actionSimpanfirst(){

				// $cons = \Yii::$app->db_esm;
				$roHeader = new Requestorder();
				//$reqorder = new Roatribute();
				$roDetail = new Rodetail();
        $BARANG = new Barang();
				$profile= Yii::$app->getUserOpt->Profile_user();
        // $corp = Yii::$app->getUserOpt->Profile_user()->EMP_ID;
        // $Corp1 = Employe::find()->where(['KD_CORP'=>$corp])->asArray()->one();
        $corp = Yii::$app->getUserOpt->Profile_user()->emp->EMP_CORP_ID;


				//if($roDetail->load(Yii::$app->request->post()) && $roDetail->validate()){
			if($roDetail->load(Yii::$app->request->post())){


				 $hsl = \Yii::$app->request->post();
          // $radio =  $hsl['DynamicModel']['NEW'];
          $radio =  $hsl['new'];
            // print_r($radio);
            // die();
            $selectCorp = $corp;
            if($radio == 2 )
            {
              // rodetail
              	$kdBarang = $roDetail->KD_BARANG;
                $nmBarang = Barang::findOne(['KD_BARANG' => $kdBarang]);
                $GneratekodeRo=\Yii::$app->ambilkonci->getRoCode($selectCorp);
                $roDetail->KD_RO = $GneratekodeRo;
                $roDetail->PARENT_ROSO=0;
                $roDetail->KD_CORP = $selectCorp;
                $roDetail->CREATED_AT = date('Y-m-d H:i:s');
                $roDetail->NM_BARANG = $nmBarang->NM_BARANG;
                $roDetail->KD_BARANG = $kdBarang;
                $roDetail->SQTY = $roDetail->RQTY;
                $roDetail->HARGA= $nmBarang->HARGA_SPL;
                $roDetail->STATUS = 0;
                $roDetail->save();
                      // getErrors()
                // print_r($roDetail->getErrors());
                // die();
                // roheader
                $roHeader->PARENT_ROSO=0; // RO=0
                $roHeader->KD_RO =$GneratekodeRo;
                $roHeader->CREATED_AT = date('Y-m-d H:i:s');
                $roHeader->TGL = date('Y-m-d');
                $roHeader->ID_USER = $profile->emp->EMP_ID;
                $roHeader->EMP_NM = $profile->emp->EMP_NM .' ' .$profile->emp->EMP_NM_BLK;
                $roHeader->KD_CORP = $selectCorp;
                $roHeader->KD_DEP = $profile->emp->DEP_ID;
                //$roHeader->SIG1_SVGBASE64 = $profile->emp->SIGSVGBASE64;
                //$roHeader->SIG1_SVGBASE30 = $profile->emp->SIGSVGBASE30;
                $roHeader->STATUS = 0;

                $roHeader->PARENT_ROSO=0; // RO=0
                $roHeader->KD_RO =$GneratekodeRo;
                $roHeader->CREATED_AT = date('Y-m-d H:i:s');
                $roHeader->TGL = date('Y-m-d');
                $roHeader->ID_USER = $profile->emp->EMP_ID;
                $roHeader->EMP_NM = $profile->emp->EMP_NM .' ' .$profile->emp->EMP_NM_BLK;
                $roHeader->KD_CORP = $selectCorp;
                $roHeader->KD_DEP = $profile->emp->DEP_ID;
                //$roHeader->SIG1_SVGBASE64 = $profile->emp->SIGSVGBASE64;
                //$roHeader->SIG1_SVGBASE30 = $profile->emp->SIGSVGBASE30;
                $roHeader->STATUS = 0;
                $roHeader->save();

            }
            else
            {
              // barang
              $kdcorp = $BARANG->KD_CORP =  $roDetail->KD_CORP;
              $kdType = Yii::$app->esmcode->kdTipe();
              $kdUnit = Yii::$app->esmcode->kdUnit();
              $nw1 = Yii::$app->esmcode->kdKategori();
              $kdKategori = $BARANG->KD_KATEGORI =  $nw1;
              $kdPrn = 0;
              $kdbrg =  Yii::$app->esmcode->kdbarangUmum($kdPrn,$kdcorp,$kdType,$kdKategori,$kdUnit);
              $BARANG->KD_BARANG = $kdbrg;
              $BARANG->NM_BARANG = $roDetail->NM_BARANG ;
              $BARANG->HARGA_SPL =  $roDetail->HARGA;
              $BARANG->STATUS = 1;
              $BARANG->KD_SUPPLIER = 'SPL.LG.0000';
              $BARANG->KD_KATEGORI = 39;
              $BARANG->KD_UNIT = $roDetail->UNIT;
              $BARANG->KD_TYPE = 30;
              $BARANG->CREATED_BY = Yii::$app->user->identity->username;
              $BARANG->CREATED_AT = date('Y-m-d H:i:s');
              $BARANG->save();

              // rodetail
              $GneratekodeRo=\Yii::$app->ambilkonci->getRoCode($selectCorp);
              $roDetail->KD_RO = $GneratekodeRo;
              $roDetail->PARENT_ROSO=0;
              $roDetail->KD_CORP = $selectCorp;
              $roDetail->CREATED_AT = date('Y-m-d H:i:s');
              $roDetail->NM_BARANG = $hsl['Rodetail']['NM_BARANG'];
              $roDetail->KD_BARANG = $kdbrg ;
              // $roDetail->UNIT = 'none';
              $roDetail->SQTY =   $roDetail->RQTY;
              $roDetail->STATUS = 0;
              $roDetail->save();
            //   print_r($BARANG->getErrors());
            // die();

            // roheader
              $roHeader->PARENT_ROSO=0; // RO=0
              $roHeader->KD_RO =$GneratekodeRo;
              $roHeader->CREATED_AT = date('Y-m-d H:i:s');
              $roHeader->TGL = date('Y-m-d');
              $roHeader->ID_USER = $profile->emp->EMP_ID;
              $roHeader->EMP_NM = $profile->emp->EMP_NM .' ' .$profile->emp->EMP_NM_BLK;
              $roHeader->KD_CORP = $selectCorp;
              $roHeader->KD_DEP = $profile->emp->DEP_ID;
              //$roHeader->SIG1_SVGBASE64 = $profile->emp->SIGSVGBASE64;
              //$roHeader->SIG1_SVGBASE30 = $profile->emp->SIGSVGBASE30;
              $roHeader->STATUS = 0;

              $roHeader->PARENT_ROSO=0; // RO=0
              $roHeader->KD_RO =$GneratekodeRo;
              $roHeader->CREATED_AT = date('Y-m-d H:i:s');
              $roHeader->TGL = date('Y-m-d');
              $roHeader->ID_USER = $profile->emp->EMP_ID;
              $roHeader->EMP_NM = $profile->emp->EMP_NM .' ' .$profile->emp->EMP_NM_BLK;
              $roHeader->KD_CORP = $selectCorp;
              $roHeader->KD_DEP = $profile->emp->DEP_ID;
              //$roHeader->SIG1_SVGBASE64 = $profile->emp->SIGSVGBASE64;
              //$roHeader->SIG1_SVGBASE30 = $profile->emp->SIGSVGBASE30;
              $roHeader->STATUS = 0;
              $roHeader->save();
            //   print_r($roHeader->getErrors());
            //  die();
            }

				// //$roHeader->SIG1_SVGBASE64 = $profile->emp->SIGSVGBASE64;
				// //$roHeader->SIG1_SVGBASE30 = $profile->emp->SIGSVGBASE30;
				// $roHeader->STATUS = 0;
				// 	$transaction = $cons->beginTransaction();
				// 	try {
				// 		if (!$roDetail->save()) {
				// 				$transaction->rollback();
				// 				return false;
				// 		}
        //
				// 		if (!$roHeader->save()) {
				// 				$transaction->rollback();
				// 				return false;
				// 		}
				// 		$transaction->commit();
				// 	} catch (Exception $ex) {
				// 		//print_r("error");
				// 		$transaction->rollback();
				// 		return false;
				// 	}
					//return $this->redirect(['index','param'=>$getkdro]);
					//return $this->redirect(['index?RequestorderSearch[KD_RO]='.$getkdro]);
					return $this->redirect(['/purchasing/request-order/edit?kd='.$GneratekodeRo]);
			}else{
				return $this->redirect(['index']);
		}

	}

	/**
     * Add Request Detail
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionTambah($kd)
    {
		$searchModel = new RodetailSearch();
        $dataProvider = $searchModel->searchChildRo(Yii::$app->request->queryParams,$kd);
		$roHeader = Requestorder::find()->where(['KD_RO' => $kd])->one();
		$roDetail = new Rodetail();
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

	/*
	 * actionSimpansecondt() <- actionTambah($kd)
	 * First Create RO |Rodetail
	 * Add: component Yii::$app->getUserOpt->Profile_user()
	 * Add: component \Yii::$app->ambilkonci->getRoCode();
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
	**/
	public function actionSimpantambah(){
		$roDetail = new Rodetail();
		if($roDetail->load(Yii::$app->request->post()) && $roDetail->validate()){
			$hsl = \Yii::$app->request->post();
			$kdro = $hsl['Rodetail']['KD_RO'];
			$kdBarang = $hsl['Rodetail']['KD_BARANG'];
			$nmBarang = Barang::findOne(['KD_BARANG' => $kdBarang]);
			$kdUnit = $hsl['Rodetail']['UNIT'];
			$rqty = $hsl['Rodetail']['RQTY'];
			$note = $hsl['Rodetail']['NOTE'];

			/*
			 * Detail Request Order
			**/
			$roDetail->KD_RO = $kdro;
			$roDetail->CREATED_AT = date('Y-m-d H:i:s');
			$roDetail->NM_BARANG = $nmBarang->NM_BARANG;
			$roDetail->KD_BARANG = $kdBarang;
			$roDetail->UNIT = $kdUnit;
			$roDetail->RQTY = $rqty;
			$roDetail->NOTE = $note;
			$roDetail->STATUS = 0;
			$roDetail->save();

			return $this->redirect(['index?RequestorderSearch[KD_RO]='.$kdro]);
		}else{
			return $this->redirect(['index']);
		}
	}

	 /**
     * View Requestorder & Detail
     * @param string $id
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
    public function actionView($kd)
    {
    	$ro = new Requestorder();
		$roHeader = Requestorder::find()->where(['KD_RO' => $kd])->one();
		if(count($roHeader['KD_RO'])<>0){
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
		/*
		 * Init Models
		 * @author ptrnov  <piter@lukison.com>
		 * @since 1.1
		**/
		$roHeader = Requestorder::find()->where(['KD_RO' =>$kd])->one();
		if(count($roHeader['KD_RO'])<>0){
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

			/*
			 * Process Editable Row [Columm SQTY]
			 * @author ptrnov  <piter@lukison.com>
			 * @since 1.1
			**/
			if (Yii::$app->request->post('hasEditable')) {
				$id = Yii::$app->request->post('editableKey');
				$model = Rodetail::findOne($id);
				$out = Json::encode(['output'=>'', 'message'=>'']);
				$post = [];
				$posted = current($_POST['Rodetail']);
				$post['Rodetail'] = $posted;
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
					if (isset($posted['NOTE'])) {
					   // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
						$output = $model->NOTE;
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
    $roHeader = Requestorder::find()->where(['KD_RO' => $kd])->one(); /*Noted check by status approval =1 header table | chek error record jika kosong*/
		$detro = $roHeader->detro;
    $employ = $roHeader->employe;
		$dept = $roHeader->dept;
		if ($v==101){
			$filterPdf="KD_RO='".$kd."' AND (STATUS='101' OR STATUS='10')";
		}elseif($v!=101){
			$filterPdf="KD_RO='".$kd."' AND STATUS<>'3'";
		}
		$roDetail = Rodetail::find()->where($filterPdf)->all();

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
			'options' => ['title' => 'Form Request Order','subject'=>'ro'],
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
    	$roHeader = Requestorder::find()->where(['KD_RO' => $kd])->one(); /*Noted check by status approval =1 header table | chek error record jika kosong*/
		$detro = $roHeader->detro;
        $employ = $roHeader->employe;
		$dept = $roHeader->dept;
		/* if ($v==101){
			$filterPdf="KD_RO='".$kd."' AND (STATUS='101' OR STATUS='10')";
		}elseif($v!=101){
			$filterPdf="KD_RO='".$kd."' AND STATUS<>'3'";
		} */
		$roDetail = Rodetail::find()->where(['KD_RO'=>$kd])->all();

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
			'options' => ['title' => 'Form Request Order','subject'=>'ro'],
			 // call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>['Copyright@LukisonGroup '.date("r")],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		return $pdf->render();
	}

  public function actionSaveNewAdd()
  {
    $rodetail = new Rodetail();
  	$barangNew = new Barang();
    // $roDetail = new AdditemValidation();
    $profile= Yii::$app->getUserOpt->Profile_user();
    $corp = Yii::$app->getUserOpt->Profile_user()->emp->EMP_CORP_ID;
  if($roDetail->load(Yii::$app->request->post())){

    
    $hsl = \Yii::$app->request->post();
     // $radio =  $hsl['DynamicModel']['NEW'];
     $radio =  $hsl['newadd'];

     if($radio == 1)
     {

        // $kdro = $hsl['AdditemValidation']['kD_RO'];
        // $kdbrg = $hsl['AdditemValidation']['kD_BARANG'];
      //  if($roDetail->validate()) {
   			$barangNew= new Barang();
        $roDetail = new AdditemValidation();

        print_r( $kdbrg);
        die();
        $kondisiTrue = Rodetail::find()->where("KD_RO='".$kdro. "' AND KD_BARANG='".$kdbrg."' AND STATUS<>3")->one();
        if($kondisiTrue)
        {
          die();
        }
        else{
          echo "succes";
        }

   			// 	$this->kD_BARANG= Yii::$app->esmcode->kdbarangUmum(0,$this->kD_CORP,$this->kD_TYPE,$this->kD_KATEGORI,$this->uNIT);
   			// 	$barangNew->KD_BARANG =$roDetail->kD_BARANG;
   			// 	$barangNew->NM_BARANG = $this->nM_BARANG;
   			// 	$barangNew->KD_UNIT = $this->uNIT;
   			// 	$barangNew->HARGA_SPL = $this->hARGA;
   			// 	$barangNew->PARENT = 0;
   			// 	$barangNew->KD_CORP = $this->kD_CORP;
   			// 	$barangNew->KD_TYPE = $this->kD_TYPE;
   			// 	$barangNew->KD_KATEGORI = $this->kD_KATEGORI;
   			// 	$barangNew->KD_SUPPLIER = $this->kD_SUPPLIER;
   			// 	$barangNew->STATUS = 1;
   			// 	$barangNew->CREATED_BY = Yii::$app->user->identity->username;
   			// 	$barangNew->CREATED_AT = date('Y-m-d H:i:s');
   			// 	$barangNew->UPDATED_BY = Yii::$app->user->identity->username;
   			// 	if($barangNew->validate()){
   			// 		$barangNew->save();
   			// 		$rodetail = new Rodetail();
   			// 		$rodetail->CREATED_AT = date('Y-m-d H:i:s');
   			// 		$rodetail->KD_RO = $this->kD_RO; 		//required
   			// 		$rodetail->KD_CORP = $this->kD_CORP; 	//required
   			// 		$rodetail->PARENT_ROSO=0; // RO=1 		//required
   			// 		$rodetail->KD_BARANG = $this->kD_BARANG;
   			// 		$rodetail->NM_BARANG = $this->nM_BARANG;
   			// 		$rodetail->UNIT = $this->uNIT;
   			// 		$rodetail->RQTY = $this->rQTY;
   			// 		$rodetail->SQTY = $this->rQTY;
   			// 		$rodetail->NOTE = $this->nOTE;
   			// 		$rodetail->HARGA= $this->hARGA;
   			// 		$rodetail->STATUS = 0;

  //  }
 }
    //  print_r($radio);
    //  die();

  }
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
			$roDetail = Rodetail::findOne($id);
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
			$roDetail = Rodetail::findOne($id);
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
			$roDetail = Rodetail::findOne($id);
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
		new Rodetail();
		$ro = Rodetail::findOne($id);
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
		//$ro = new Requestorder();
		$roHeader = Requestorder::find()->where(['KD_RO' =>$kd])->one();
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

		/*
		 * Process Editable Row [Columm SQTY]
		 * @author ptrnov  <piter@lukison.com>
		 * @since 1.1
		**/
		if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            $model = Rodetail::findOne($id);
			$out = Json::encode(['output'=>'', 'message'=>'']);
            $post = [];
            $posted = current($_POST['Rodetail']);
            $post['Rodetail'] = $posted;
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
				if (isset($posted['NOTE'])) {
                   // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
					$output = $model->NOTE;
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
        ]);

    }

    public function Sendmail($kd,$empid)
    {
      // $profile=Yii::$app->getUserOpt->Profile_user();
      // $dep = $profile->emp->DEP_ID;
      // $datamanager = Employe::find()->where(['DEP_ID'=>$dep,'JOBGRADE_ID'=>'M'])->asArray()->one();
      // $datamanager['EMP_EMAIL'];
      // print_r(  $datamanager['EMP_EMAIL']);
      // die();

      // $email = Yii::$app->user->identity->email;
      $roHeader = Requestorder::find()->where(['KD_RO' => $kd])->one(); /*Noted check by status approval =1 header table | chek error record jika kosong*/
      $detro = $roHeader->detro;
      // $dataemail = Userlogin::find()->where(['EMP_ID'=>$empid])->asArray()->one();
      // print_r($email);
      // die();

      $employ = $roHeader->employe;
      $dept = $roHeader->dept;
      $roDetail = Rodetail::find()->where(['KD_RO'=>$kd])->all();

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
    $to=['purchasing@lukison.com'];

    \Yii::$app->kirim_email->pdf($contentMail,'RO',$to,'Request-Order',$content);

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
		$roHeader = Requestorder::find()->where(['KD_RO' =>$kd])->one();
		$employe = $roHeader->employe;
			return $this->renderAjax('sign-auth1', [
				'roHeader' => $roHeader,
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
					$kdro = $hsl['Auth1Model']['kdro'];
          $userid =  $hsl['Auth1Model']['empID'];
          $this->Sendmail($kdro,$userid);
					return $this->redirect(['/purchasing/request-order/view','kd'=>$kdro]);
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
		$roHeader = Requestorder::find()->where(['KD_RO' =>$kd])->one();
		$employe = $roHeader->employe;
			return $this->renderAjax('sign-auth2', [
				'roHeader' => $roHeader,
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
					$kdro = $hsl['Auth2Model']['kdro'];
					return $this->redirect(['/purchasing/request-order/review','kd'=>$kdro]);
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
		$roHeader = Requestorder::find()->where(['KD_RO' =>$kd])->one();
		$employe = $roHeader->employe;
			return $this->renderAjax('sign-auth3', [
				'roHeader' => $roHeader,
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
					$kdro = $hsl['Auth3Model']['kdro'];
					return $this->redirect(['/purchasing/request-order/review','kd'=>$kdro]);
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
		$model = Requestorder::find()->where(['KD_RO' =>$kd])->one();
		$model->STATUS=3;
		$model->save();

		$model = Rodetail::find()->where(['KD_RO' =>$kd])->one();
		$model->STATUS=3;
		$model->save();
		return Yii::$app->getResponse()->redirect(['/purchasing/request-order/index']);
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
    protected function findModel($id)
    {
        if (($model = Requestorder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
