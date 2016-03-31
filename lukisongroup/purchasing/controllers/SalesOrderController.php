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

use lukisongroup\purchasing\models\so\Salesorder;
use lukisongroup\purchasing\models\so\SalesorderSearch;
use lukisongroup\purchasing\models\so\Sodetail;
use lukisongroup\purchasing\models\so\SodetailSearch;
use lukisongroup\purchasing\models\so\AdditemValidation;

use lukisongroup\purchasing\models\so\Auth1Model;
use lukisongroup\purchasing\models\so\Auth2Model;
use lukisongroup\purchasing\models\so\Auth3Model;

use lukisongroup\hrd\models\Employe;
//use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Tipebarang;
use yii\data\ActiveDataProvider;


/**
 * SalesorderController implements the CRUD actions for Salesorder model.
 */
class SalesOrderController extends Controller
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

		/*  if (isset($_GET['param'])){
			  $dataProvider = $searchModel->searchChildRo(Yii::$app->request->queryParams,$_GET['param']);
		}else{
			$dataProvider = $searchModel->searchChildRo(Yii::$app->request->queryParams);
		}  */

		//$searchModel->KD_RO ='2015.12.04.RO.0070';

		// $dataProvider = $searchModel->searchSo(Yii::$app->request->queryParams);
		  // return $this->render('index', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
			//'getPermission'=> $getPermission,
        // ]);

		$searchModel = new SalesorderSearch();

		$dataProvider = $searchModel->searchSo(Yii::$app->request->queryParams);
		$dataProviderInbox = $searchModel->searchSoInbox(Yii::$app->request->queryParams);
		$dataProviderOutbox = $searchModel->searchSoOutbox(Yii::$app->request->queryParams);
    $profile=Yii::$app->getUserOpt->Profile_user();
    $datacheckedso = Salesorder::find()->where("PARENT_ROSO = 1 AND STATUS = 101 AND STATUS <> 3 AND USER_CC='".$profile->emp->EMP_ID."'")
                                        ->count();
    $datacreateso = Salesorder::find()->where("PARENT_ROSO = 1 AND STATUS <> 3 AND STATUS = 0 AND ID_USER = '".$profile->emp->EMP_ID."'")
                                        ->count();
    $dataapprove = Salesorder::find()->where("PARENT_ROSO = 1 AND STATUS = 102 AND  STATUS <> 3 AND KD_DEP='".$profile->emp->DEP_ID."' OR STATUS = 5")
                                        ->count();

    $dataAprroveso = new ActiveDataProvider([
                    'query' => Salesorder::find()->where("PARENT_ROSO = 1 AND STATUS = 102 AND STATUS<>3  AND KD_DEP='".$profile->emp->DEP_ID."'OR STATUS = 5"),
                        'pagination' => [
                          'pageSize' => 5,
                                    ],
                              ]);
    $dataCheckedso = new ActiveDataProvider([
                                'query' => Salesorder::find()->where("PARENT_ROSO = 1 AND  STATUS = 101 AND USER_CC='".$profile->emp->EMP_ID."'"),
                                  'pagination' => [
                                        'pageSize' => 5,
                                                    ],
                                            ]);
    $dataCreateso = new ActiveDataProvider([
                                'query' => Salesorder::find()->where("PARENT_ROSO = 1 AND STATUS <> 3 AND STATUS = 0 AND ID_USER = '".$profile->emp->EMP_ID."'"),
                                  'pagination' => [
                                        'pageSize' => 5,
                                                    ],
                                            ]);

		  return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
			'dataProviderInbox' =>$dataProviderInbox,
			'dataProviderOutbox' =>$dataProviderOutbox,
      'dataapprove'=>$dataapprove,
      'datacheckedso'=>$datacheckedso,
      'dataAprroveso'=>$dataAprroveso,
      'dataCheckedso'=>$dataCheckedso,
      'dataCreateso'=>$dataCreateso,
      'datacreateso'=>$datacreateso,

			//'getPermission'=> $getPermission,
        ]);

    }

    /**
     * Creates a new Salesorder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
    public function actionCreate()
    {
		$roDetail = new Sodetail();
		$roHeader = new Salesorder();
            return $this->renderAjax('_form', [
                'roDetail' => $roDetail,
				'roHeader' => $roHeader,
            ]);

    }

	/**
     * Edit Form - Add Item Barang | Tambah Barang
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
    public function actionAdditem($kd)
    {
			//$roDetail = new Sodetail();
			$roDetail = new AdditemValidation();
			$roHeader = Salesorder::find()->where(['KD_RO' => $kd])->one();
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
		//$roDetail = new Sodetail();
		$roDetail = new AdditemValidation();

		if(Yii::$app->request->isAjax){
			$roDetail->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($roDetail));
		}else{
			if($roDetail->load(Yii::$app->request->post())){
				if($roDetail->additem_saved()){
					$hsl = \Yii::$app->request->post();
					$kdro = $hsl['AdditemValidation']['kD_RO'];
					return $this->redirect(['/purchasing/sales-order/edit?kd='.$kdro]);
				}
				//Request Result
			/*	$hsl = \Yii::$app->request->post();
				$kdRo = $hsl['Sodetail']['KD_RO'];
				$kdBarang = $hsl['Sodetail']['KD_BARANG'];
				$nmBarang = Barang::findOne(['KD_BARANG' => $kdBarang]);
				$kdUnit = $hsl['Sodetail']['UNIT'];
				$rqty = $hsl['Sodetail']['RQTY'];
				$note = $hsl['Sodetail']['NOTE'];

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
				return $this->redirect(['/purchasing/sales-order/edit?kd='.$kdRo]);*/
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
				$model = Tipebarang::find()->asArray()->where(['CORP_ID'=>$corp_id,'PARENT'=>1])->all();
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
				$model = Kategori::find()->asArray()->where(['CORP_ID'=>$corp_id,'KD_TYPE'=>$type_id,'PARENT'=>1])->all();
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
				$model = Barang::find()->asArray()->where(['KD_KATEGORI'=>$kat_id,'PARENT'=>1])->all();
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
	 * First Create RO |  Salesorder | Sodetail
	 * Add: component Yii::$app->getUserOpt->Profile_user()
	 * Add: component \Yii::$app->ambilkonci->getRoCode();
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
	**/
	public function actionSimpanfirst(){

				$cons = \Yii::$app->db_esm;
				$roHeader = new Salesorder();
				//$reqorder = new Roatribute();
				$roDetail = new Sodetail();
				$profile= Yii::$app->getUserOpt->Profile_user();

				//if($roDetail->load(Yii::$app->request->post()) && $roDetail->validate()){
			if($roDetail->load(Yii::$app->request->post())){
				$hsl = \Yii::$app->request->post();
				$userCorp = $hsl['Sodetail']['KD_CORP'];
				$kdUnit = $hsl['Sodetail']['UNIT'];
				$kdBarang = $hsl['Sodetail']['KD_BARANG'];
				$nmBarang = Barang::findOne(['KD_BARANG' => $kdBarang]);
				$rqty = $hsl['Sodetail']['RQTY'];
				$note = $hsl['Sodetail']['NOTE'];

				$GneratekodeSo=\Yii::$app->ambilkonci->getSoCode($userCorp);

				/*
				 * Detail Sales Order
				**/
				$roDetail->KD_RO = $GneratekodeSo; //Sales Order Kode
				$roDetail->PARENT_ROSO=1; // SO=1 //required
				$roDetail->UNIT = $kdUnit;
				$roDetail->CREATED_AT = date('Y-m-d H:i:s');
				$roDetail->NM_BARANG = $nmBarang->NM_BARANG;
				$roDetail->KD_BARANG = $kdBarang;
				$roDetail->RQTY = $rqty;
				$roDetail->SQTY = $rqty;
				$roDetail->HARGA= $nmBarang->HARGA_PABRIK;
				$roDetail->NOTE = $note;
				$roDetail->STATUS = 0;

				/*
				 * Header Request Order
				**/
				//$getkdro=\Yii::$app->ambilkonci->getSoCode();
				$roHeader->PARENT_ROSO=1; // SO=1
				$roHeader->KD_RO =$GneratekodeSo;
				$roHeader->CREATED_AT = date('Y-m-d H:i:s');
				$roHeader->TGL = date('Y-m-d');
				$roHeader->ID_USER = $profile->emp->EMP_ID;
				$roHeader->EMP_NM = $profile->emp->EMP_NM .' ' .$profile->emp->EMP_NM_BLK;
				//$roHeader->EMP_NM = $profile->emp->EMP_NM .' ' .$profile->emp->EMP_NM_BLK;
				$roHeader->KD_CORP = $userCorp;
				$roHeader->KD_DEP = $profile->emp->DEP_ID;
				//$roHeader->SIG1_SVGBASE64 = $profile->emp->SIGSVGBASE64;
				//$roHeader->SIG1_SVGBASE30 = $profile->emp->SIGSVGBASE30;
				$roHeader->STATUS = 0;
					$transaction = $cons->beginTransaction();
					try {
						if (!$roDetail->save()) {
								$transaction->rollback();
								return false;
						}

						if (!$roHeader->save()) {
								$transaction->rollback();
								return false;
						}
						$transaction->commit();
					} catch (Exception $ex) {
						//print_r("error");
						$transaction->rollback();
						return false;
					}
					//return $this->redirect(['index','param'=>$getkdro]);
					//return $this->redirect(['index?SalesorderSearch[KD_RO]='.$getkdro]);
					return $this->redirect(['/purchasing/sales-order/edit?kd='.$GneratekodeSo]);
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
		$searchModel = new SodetailSearch();
        $dataProvider = $searchModel->searchChildRo(Yii::$app->request->queryParams,$kd);
		$roHeader = Salesorder::find()->where(['KD_RO' => $kd])->one();
		$roDetail = new Sodetail();
            return $this->renderAjax('_update', [
						'roHeader' => $roHeader,
						'roDetail' => $roDetail,
						'detro' => $roHeader->detro,
						'searchModel'=>$searchModel,
						'dataProvider'=>$dataProvider
					]);
    }

	/*
	 * actionSimpansecondt() <- actionTambah($kd)
	 * First Create RO |Sodetail
	 * Add: component Yii::$app->getUserOpt->Profile_user()
	 * Add: component \Yii::$app->ambilkonci->getRoCode();
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
	**/
	public function actionSimpantambah(){
		$roDetail = new Sodetail();
		if($roDetail->load(Yii::$app->request->post()) && $roDetail->validate()){
			$hsl = \Yii::$app->request->post();
			$kdro = $hsl['Sodetail']['KD_RO'];
			$kdBarang = $hsl['Sodetail']['KD_BARANG'];
			$nmBarang = Barang::findOne(['KD_BARANG' => $kdBarang]);
			$kdUnit = $hsl['Sodetail']['UNIT'];
			$rqty = $hsl['Sodetail']['RQTY'];
			$note = $hsl['Sodetail']['NOTE'];

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

			return $this->redirect(['index?SalesorderSearch[KD_RO]='.$kdro]);
		}else{
			return $this->redirect(['index']);
		}
	}

	 /**
     * View Salesorder & Detail
     * @param string $id
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
    public function actionView($kd)
    {
    	$ro = new Salesorder();
		$roHeader = Salesorder::find()->where(['KD_RO' => $kd])->one();
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
		$roHeader = Salesorder::find()->where(['KD_RO' =>$kd])->one();
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
				$model = Sodetail::findOne($id);
				$out = Json::encode(['output'=>'', 'message'=>'']);
				$post = [];
				$posted = current($_POST['Sodetail']);
				$post['Sodetail'] = $posted;
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
    	$roHeader = Salesorder::find()->where(['KD_RO' => $kd])->one(); /*Noted check by status approval =1 header table | chek error record jika kosong*/
		$detro = $roHeader->detro;
        $employ = $roHeader->employe;
		$dept = $roHeader->dept;
		if ($v==101){
			$filterPdf="KD_RO='".$kd."' AND (STATUS='101' OR STATUS='10')";
		}elseif($v!=101){
			$filterPdf="KD_RO='".$kd."' AND STATUS<>'3'";
		}
		$roDetail = Sodetail::find()->where($filterPdf)->all();

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
    	$roHeader = Salesorder::find()->where(['KD_RO' => $kd])->one(); /*Noted check by status approval =1 header table | chek error record jika kosong*/
		$detro = $roHeader->detro;
        $employ = $roHeader->employe;
		$dept = $roHeader->dept;
		/* if ($v==101){
			$filterPdf="KD_RO='".$kd."' AND (STATUS='101' OR STATUS='10')";
		}elseif($v!=101){
			$filterPdf="KD_RO='".$kd."' AND STATUS<>'3'";
		} */
		//$roDetail = Sodetail::find()->where($filterPdf)->all();
		$roDetail = Sodetail::find()->where(['KD_RO'=>$kd])->all();

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

	/**
	 * On Approval View
	 * Approved_rodetail | Sodetail->ID |  $roDetail->STATUS = 101;
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
			$roDetail = Sodetail::findOne($id);
			$roDetail->STATUS = 1;
			//$ro->NM_BARANG=''
			$roDetail->save();
			return true;
		}
   }

	/**
	 * On Approval View
	 * Reject_rodetail | Sodetail->ID |  $roDetail->STATUS = 4;
	 * Reject = 4
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionReject_rodetail()
    {
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			$roDetail = Sodetail::findOne($id);
			$roDetail->STATUS = 4;
			$roDetail->save();
			return true;
		}
     }

	/**
	 * On Approval View
	 * Canclet_rodetail | Sodetail->ID |  $roDetail->STATUS = 4;
	 * Cancel = 0
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionCancel_rodetail()
    {
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			$roDetail = Sodetail::findOne($id);
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
		new Sodetail();
		$ro = Sodetail::findOne($id);
		$ro->STATUS = 3;
		$ro->save();

       //$this->findModel($id)->delete();
		return $this->redirect(['buatro','id'=>$kode]);
    }

	/**
     * Action REVIEW | Prosess Checked and Approval
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
		//$ro = new Salesorder();
		$roHeader = Salesorder::find()->where(['KD_RO' =>$kd])->one();
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
            $model = Sodetail::findOne($id);
			$out = Json::encode(['output'=>'', 'message'=>'']);
            $post = [];
            $posted = current($_POST['Sodetail']);
            $post['Sodetail'] = $posted;
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

	/*
	 * SIGNARURE AUTH1 | VIEW CREATED
	 * Status = 101
	 * Class Model Salesorder->Status = 101 [Approvad]
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	**/
	public function actionSignAuth1View($kd){
		$auth1Mdl = new Auth1Model();
		$roHeader = Salesorder::find()->where(['KD_RO' =>$kd])->one();
		$employe = $roHeader->employe;
			return $this->renderAjax('sign-auth1', [
				'roHeader' => $roHeader,
				'employe' => $employe,
				'auth1Mdl' => $auth1Mdl,
			]);
	}

  public function Sendmail($kd)
  {
    // $profile=Yii::$app->getUserOpt->Profile_user();
    // $dep = $profile->emp->DEP_ID;
    // $datamanager = Employe::find()->where(['DEP_ID'=>$dep,'JOBGRADE_ID'=>'M'])->asArray()->one();
    // $datamanager['EMP_EMAIL'];
    // print_r(  $datamanager['EMP_EMAIL']);
    // die();

    // $email = Yii::$app->user->identity->email;
    $roHeader = Salesorder::find()->where(['KD_RO' => $kd])->one(); /*Noted check by status approval =1 header table | chek error record jika kosong*/
    $detro = $roHeader->detro;
    // $dataemail = Userlogin::find()->where(['EMP_ID'=>$empid])->asArray()->one();
    // print_r($email);
    // die();

    $employ = $roHeader->employe;
    $dept = $roHeader->dept;
    $roDetail =Sodetail::find()->where(['KD_RO'=>$kd])->all();

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
  $to=['sales_order@lukison.com'];

  \Yii::$app->kirim_email->pdf($contentMail,'SO',$to,'Sales-Order',$content);

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
          // $empid = $hsl['Auth1Model']['empID'];
          $this->Sendmail($kdro);
					return $this->redirect(['/purchasing/sales-order/view','kd'=>$kdro]);
				}
			}
		}
	}

	/*
	 * SIGNARURE AUTH2 | VIEW CREATED
	 * Status = 102
	 * Class Model Salesorder->Status = 102 [Approvad]
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	**/
	public function actionSignAuth2View($kd){
		$auth2Mdl = new Auth2Model();
		$roHeader = Salesorder::find()->where(['KD_RO' =>$kd])->one();
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
          // $empid = $hsl['Auth1Model']['empID'];
          $this->Sendmail($kdro);
					return $this->redirect(['/purchasing/sales-order/review','kd'=>$kdro]);
				}
			}
		}
	}

	/*
	 * SIGNARURE AUTH3 | VIEW APPROVED
	 * Status = 103
	 * Class Model Salesorder->Status = 103 [Approvad]
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	**/
	public function actionSignAuth3View($kd){
		$auth3Mdl = new Auth3Model();
		$roHeader = Salesorder::find()->where(['KD_RO' =>$kd])->one();
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
          // $empid = $hsl['Auth1Model']['empID'];
          $this->Sendmail($kdro);
					return $this->redirect(['/purchasing/sales-order/review','kd'=>$kdro]);
				}
			}
		}
	}


	/**
     * Updates an existing Salesorder model.
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
		$model =Salesorder::find()->where(['KD_RO' =>$kd])->one();
		$model->STATUS=3;
		$model->save();

		$model =Sodetail::find()->where(['KD_RO' =>$kd])->one();
		$model->STATUS=3;
		$model->save();
		return Yii::$app->getResponse()->redirect(['/purchasing/sales-order/index']);
    }

    /**
     * Deletes an existing Salesorder model.
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
     * Finds the Salesorder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Salesorder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Salesorder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
