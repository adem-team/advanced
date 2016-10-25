<?php

namespace lukisongroup\purchasing\controllers;
/*extensions */
use Yii;
use yii\helpers\Html;
use yii\web\Request;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use yii\helpers\Url;
use zyx\phpmailer\Mailer;
use yii\web\UploadedFile;


/* namespace models */
use lukisongroup\purchasing\models\pr\Purchaseorder;
use lukisongroup\purchasing\models\pr\PurchaseorderSearch;
use lukisongroup\purchasing\models\pr\Purchasedetail;
use lukisongroup\purchasing\models\pr\FilePo;

use lukisongroup\purchasing\models\pr\DiscountValidation;
use lukisongroup\purchasing\models\pr\PajakValidation;
use lukisongroup\purchasing\models\pr\DeliveryValidation;

use lukisongroup\purchasing\models\pr\EtdValidation;
use lukisongroup\purchasing\models\pr\EtaValidation;

use lukisongroup\purchasing\models\pr\SupplierValidation;
use lukisongroup\purchasing\models\pr\ShippingValidation;
use lukisongroup\purchasing\models\pr\BillingValidation;

use lukisongroup\purchasing\models\pr\Auth1Model;
use lukisongroup\purchasing\models\pr\Auth2Model;
use lukisongroup\purchasing\models\pr\Auth3Model;

use lukisongroup\purchasing\models\pr\NewPoValidation;
use lukisongroup\purchasing\models\pr\SendPoValidation;
use lukisongroup\purchasing\models\pr\PoPlusValidation;


use lukisongroup\purchasing\models\ro\Requestorder;
use lukisongroup\purchasing\models\ro\RequestorderSearch;
use lukisongroup\purchasing\models\ro\Rodetail;
use lukisongroup\purchasing\models\ro\RodetailSearch;

use lukisongroup\purchasing\models\so\Salesorder;
use lukisongroup\purchasing\models\so\SalesorderSearch;


use lukisongroup\purchasing\models\Statuspo;

use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\master\models\Barang;

class PurchaseOrderController extends Controller
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

	/*
	 * Index Po | Purchaseorder| Purchasedetail
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
    public function actionIndex()
    {
    	
        $searchModel = new PurchaseorderSearch();
        $dataProvider = $searchModel->searchPoInbox(Yii::$app->request->queryParams);
        $searchmodel = new PurchaseorderSearch();
        $dataprovider = $searchmodel->searchpoOutbox(Yii::$app->request->queryParams);
        $searchmodelHistory = new PurchaseorderSearch();
        $dataproviderHistory = $searchmodelHistory->searchPoHistory(Yii::$app->request->queryParams);
        $poHeader = new Purchaseorder();

		    /*Model Validasi Generate Code*/
		    $poHeaderVal = new NewPoValidation();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataprovider' => $dataprovider,
            'searchmodel' => $searchmodel,
            'dataProvider' => $dataProvider,
            'searchmodelHistory' => $searchmodelHistory,
            'dataproviderHistory' => $dataproviderHistory,
            'poHeader' => $poHeader,
			      'poHeaderVal'=>$poHeaderVal,
        ]);
       
    }

	/*
	 * Generate PO
	 * PO PLUS ['POA.CORP.'.date('ymdhis')] 	-> POA DENGAN LIMIT HARGA | AUTH1
	 * PO Normal ['POB.CORP.'.date('ymdhis')] 	-> PO  DENGAN RO | AUTH1,AUTH2,AUTH3
	 * PO Prodak ['POC.CORP.'.date('ymdhis')] 	-> PO  DENGAN RO | AUTH1,AUTH2,AUTH3
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
    public function actionSimpanpo()
    {
		$poHeaderVal = new NewPoValidation;
		if(Yii::$app->request->isAjax){
			$poHeaderVal->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($poHeaderVal));
		}else{
			if($poHeaderVal->load(Yii::$app->request->post())){
				if ($poHeaderVal->generatepo_saved()){
					$hsl = \Yii::$app->request->post();
					//$kdPo =$poHeaderVal->poRSLT
					return $this->redirect(['create', 'kdpo'=>$poHeaderVal->poRSLT]);
					//echo "test";
				}
			}
		}
    }

	/*
	 * CREATE & EDIT Data PO, berdasarkan Generate PO [POA,POB,POC]
	 * ID_SUPPLIER=null| SHIPPING=Null | BILLING=Null | ETD=Null | ETA=Null | SUMMARY [DISCOUNT|TAX|DELEVERY]
	 * GRID | EDITING =[HARGA|QTY|UNIT] -> VALIDATION HARGA | QTY [Tidak boleh lebih dari SQTY], (RO to PO ->HARGA = Manual Input), SO(SO to PO -> Harga=Harga Otomatis dari SO)
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
    public function actionCreate($kdpo)
    {
        /* search header ro using to send po || RequestorderSearch */
        $searchModel1 = new RequestorderSearch();
        $dataProviderRo = $searchModel1->cariHeaderRO_SendPO(Yii::$app->request->queryParams);

        /* search header so using to send po || SalesorderSearch */
		    $searchModel = new SalesorderSearch();
        $dataProviderSo = $searchModel->cariHeaderSO_SendPO(Yii::$app->request->queryParams);

		    $poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
		    $supplier = $poHeader->suplier;
		    $bill = $poHeader->bill;
		    $ship = $poHeader->ship;
		    $employee= $poHeader->employe;

        $poDetail = Purchasedetail::find()->where(['KD_PO'=>$kdpo])->andWhere('STATUS <> 3')->all();

		$poDetailProvider = new ArrayDataProvider([
			'key' => 'ID',//'key' => 'KD_PO',
			'allModels'=>$poDetail,
			'pagination' => [
				'pageSize' => 20,
			],
		]);

		/*
		 * Edit PO Quantity | Validation max Jumlah RO/SA
		 * @author ptrnov <piter@lukison.com>
		 * @since 1.2
		*/
		if (Yii::$app->request->post('hasEditable')) {
			$id = Yii::$app->request->post('editableKey');
			Yii::$app->response->format = Response::FORMAT_JSON;
			$model = Purchasedetail::findOne($id);
			$currentQty= $model->QTY;
			$currentKdPo= $model->KD_PO;
			$currentKdRo= $model->KD_RO;
			$currentKdBrg= $model->KD_BARANG;
     $currentKdcost= $model->KD_COSTCENTER;

			/* $iendPoQtyValidation = new SendPoQtyValidation();
			$iendPoQtyValidation->findOne($id); */
			$out = Json::encode(['output'=>'', 'message'=>'']);
			$post = [];
			$posted = current($_POST['Purchasedetail']);
			$post['Purchasedetail'] = $posted;
			/* $posted = current($_POST['SendPoQtyValidation']);
			$post['SendPoQtyValidation'] = $posted; */
			if ($model->load($post)) {
				$output = '';
				/*
				 * Split PO Plus dan PO Normal
				 * PO Plus=POA.*
				 * PO Plus=POB.*
				 * @author ptrnov [piter@lukison]
				 * @since 1.2
				*/
				$kdPo = explode('.',$currentKdPo);
				if($kdPo[0]!='POA'){
					if (isset($posted['QTY'])) {

						/*
						 * QTY RO-PO VALIDATION
						 * QTY PO tidak boleh lebih dari SQTY Request Order
						*/

						/*Find SQTY RoDetail*/
						$roDetail=Rodetail::find()->where(['KD_RO'=>$currentKdRo,'KD_BARANG'=>$currentKdBrg])->one();
						//if(!$roDetail){
						$roQty=$roDetail->SQTY!=0 ? $roDetail->SQTY :0;
						//}else{$roQty=0;}


						/*Sum QTY PoDetail */
						$pqtyTaken= "SELECT SUM(QTY) as QTY FROM p0002 WHERE KD_RO='" .$roDetail->KD_RO. "' AND KD_BARANG='" .$roDetail->KD_BARANG."' AND STATUS<>3 GROUP BY KD_BARANG";
						//$pqtyTaken= 'SELECT SUM(QTY) as QTY FROM p0002 WHERE KD_RO="RO.2015.12.000001" AND KD_BARANG="BRGU.LG.03.06.E07.0001"';
						$poDetailQtySum=Purchasedetail::findBySql($pqtyTaken)->one();
						$poQty=$poDetailQtySum->QTY!=0?$poDetailQtySum->QTY:0;

						/* Calculate SQTY RO - QTY PO + Current QTY | minus current record QTY */
						$ttlPQTY=($roQty - $poQty)+$currentQty;

							if ($posted['QTY'] <= $ttlPQTY){
								$model->save();
								$output =Yii::$app->formatter->asDecimal($model->QTY,0);
							}else{
								return ['output'=>'', 'message'=>'Request Order QTY Limited, Greater than RO QTY ! please insert free Qty, Check Request Order'];
							}
					}
					if (isset($posted['HARGA'])) {

						 $model->save();
             $poDetail = Purchasedetail::findOne($id);
             $data = $poDetail->KD_BARANG;
             $barang = Barang::find()->where(['KD_BARANG'=>$data])->one();
             if($barang->PARENT==0){
               $barang->HARGA_SPL=$posted['HARGA'];
               $barang->save();
             }elseif($barang->PARENT==1){
               $barang->HARGA_PABRIK=$posted['HARGA'];
               $barang->save();
             }
						$output = Yii::$app->formatter->asDecimal($model->HARGA, 2);
					}
					if (isset($posted['UNIT'])) {
						$modelUnit=Unitbarang::find()->where('KD_UNIT="'.$posted['UNIT']. '"')->one();
						$model->NM_UNIT=$modelUnit->NM_UNIT;
						$model->UNIT_QTY=$modelUnit->QTY;
						$model->UNIT_WIGHT=$modelUnit->WEIGHT;
						$model->save();
						$output =$model->UNIT;
					}
          if (isset($posted['KD_COSTCENTER'])) {
            $model->save();
            $output =$model->KD_COSTCENTER;
          }
					/*
					if (isset($posted['NOTE'])) {
					   // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
						$output = $model->NOTE;
					} */
				}
				elseif($kdPo[0]!='PO'){
					/* PO Plus=POB.*/
					if (isset($posted['QTY'])) {
						$model->save();
						$output = Yii::$app->formatter->asDecimal($model->QTY,0);
					}
					if (isset($posted['HARGA'])) {
						$model->save();
						$output = Yii::$app->formatter->asDecimal($model->HARGA, 2);
					}
					if (isset($posted['UNIT'])) {
						$model->save();
						$output = $model->UNIT;
					}
          if (isset($posted['KD_COSTCENTER'])) {
            $model->save();
            $output = $model->KD_COSTCENTER;
          }
				}

				$out = Json::encode(['output'=>$output, 'message'=>'']);
			}
			// return ajax json encoded response and exit
			echo $out;
			return;
		}

        return $this->render('create', [
      'searchModel' => $searchModel,
      'searchModel1' => $searchModel1,
      'dataProviderRo' => $dataProviderRo,
			'dataProviderSo'=>$dataProviderSo,
			'poDetailProvider'=>$poDetailProvider,
			'poHeader'=> $poHeader,
			'supplier'=>$supplier,
			'bill' => $bill,
			'ship' => $ship,
			'employee'=>$employee,
        ]);
    }



    public function actionViewRo($kd)
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

      return $this->renderAjax('view_ro', [
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


    public function actionViewSo($kd)
    {
      $ro = new Salesorder();

      $roHeader = Salesorder::find()->where(['KD_RO'=>$kd])->one();

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

      return $this->renderAjax('view_so', [
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

    /* render ajax file for upload po || attach_po_file */
    public function actionPoAttachFile($kdpo)
    {
          return $this->renderAjax('attach_po_file', [
              'model' => $model,
              'kdpo'=>$kdpo
          ]);
    }


/* upload ajax using dropzone js author : wawan */
    public function actionUpload($kdpo)
{
    $fileName = 'file';
    $model = new FilePo();

    if (isset($_FILES[$fileName])) {
        $file = \yii\web\UploadedFile::getInstanceByName($fileName);

        $data = $this->saveimage(file_get_contents($file->tempName)); //call function saveimage using base64
        $model->KD_PO = $kdpo;
        $model->IMG_BASE64 = $data;
        if ($model->save()) {
            //Now save file data to database
            echo \yii\helpers\Json::encode($file);
        }
    }

    return false;
}


	/*
	 * View PO
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
    public function actionView($kd)
    {
        /* return $this->render('view', [
            'model' => Purchaseorder::find()->where(['KD_PO'=>$kd])->one(),
        ]); */
		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kd])->one();
        //$poDetail = Purchasedetail::find()->where(['KD_PO'=>$kd])->all();
		// $poDetailQry= "SELECT ID,KD_PO,KD_RO,KD_BARANG,NM_BARANG,UNIT,NM_UNIT,UNIT_QTY,UNIT_WIGHT,SUM(QTY) AS QTY,HARGA,STATUS,STATUS_DATE,NOTE
		// 				FROM `p0002` WHERE KD_PO='" .$kd. "' GROUP BY KD_BARANG,UNIT,HARGA";
    $poDetailQry = "SELECT p.ID,p.KD_PO,p.KD_RO,p.KD_BARANG,p.NM_BARANG,p.UNIT,p.NM_UNIT,p.UNIT_QTY,a.NM_COSTCENTER,p.KD_COSTCENTER,p.HARGA,p.STATUS,
                    p.STATUS_DATE,p.NOTE,p.UNIT_WIGHT,SUM(QTY) AS QTY FROM `p0002` p
                   LEFT JOIN p0004 a ON p.KD_COSTCENTER = a.KD_COSTCENTER
                   WHERE p.KD_PO='".$kd."' AND p.STATUS<>3 GROUP BY p.KD_BARANG,p.NM_UNIT,p.HARGA ";
		$poDetail=Purchasedetail::findBySql($poDetailQry)->all();
		$dataProvider = new ArrayDataProvider([
			'key' => 'KD_PO',
			'allModels'=>$poDetail,
			'pagination' => [
				'pageSize' => 20,
			],
		]);
		$checkPOCode = explode('.',$kd);
		if ($checkPOCode[0]=='POA'){
			return $this->render( 'view_poa', [
				'poHeader' => $poHeader,
				'poDetail' => $poDetail,
				'dataProvider' => $dataProvider,
			]);
		}elseif($checkPOCode[0]=='POB'){
			return $this->render( 'view_pob', [
				'poHeader' => $poHeader,
				'poDetail' => $poDetail,
				'dataProvider' => $dataProvider,
			]);
		}elseif($checkPOCode[0]=='POC'){
			return $this->render( 'view_poc', [
				'poHeader' => $poHeader,
				'poDetail' => $poDetail,
				'dataProvider' => $dataProvider,
			]);
		}
    }

	/*
	 * Review Po AUTH1,AUTH2,AUH3
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
    public function actionReview($kdpo)
    {
		/*
		 * Edit PO Quantity | Validation max Jumlah RO/SA
		 * @author ptrnov <piter@lukison.com>
		 * @since 1.2
		*/
		if (Yii::$app->request->post('hasEditable')) {
			$idx = Yii::$app->request->post('editableKey');
			Yii::$app->response->format = Response::FORMAT_JSON;
			$model = Purchasedetail::findOne($idx);
			$currentQty= $model->QTY;
			$currentKdPo= $model->KD_PO;
			$currentKdRo= $model->KD_RO;
			$currentKdBrg= $model->KD_BARANG;
      $currentKdcost= $model->KD_COSTCENTER;

			/* $iendPoQtyValidation = new SendPoQtyValidation();
			$iendPoQtyValidation->findOne($id); */
			$out = Json::encode(['output'=>'', 'message'=>'']);
			$post = [];
			$posted = current($_POST['Purchasedetail']);
			$post['Purchasedetail'] = $posted;
			/* $posted = current($_POST['SendPoQtyValidation']);
			$post['SendPoQtyValidation'] = $posted; */
			if ($model->load($post)) {
				$output = '';
				/*
				 * Split PO Plus dan PO Normal
				 * PO Plus=POA.*
				 * PO Plus=POB.*
				 * @author ptrnov [piter@lukison]
				 * @since 1.2
				*/
				$kdPo = explode('.',$currentKdPo);
				if($kdPo[0]!='POA'){
					if (isset($posted['QTY'])) {

						/*
						 * QTY RO-PO VALIDATION
						 * QTY PO tidak boleh lebih dari SQTY Request Order
						*/

						/*Find SQTY RoDetail*/
						$roDetail=Rodetail::find()->where(['KD_RO'=>$currentKdRo,'KD_BARANG'=>$currentKdBrg])->one();
						//if(!$roDetail){
						$roQty=$roDetail->SQTY!=0 ? $roDetail->SQTY :0;
						//}else{$roQty=0;}


						/*Sum QTY PoDetail */
						$pqtyTaken= "SELECT SUM(QTY) as QTY FROM p0002 WHERE KD_RO='" .$roDetail->KD_RO. "' AND KD_BARANG='" .$roDetail->KD_BARANG ."'  AND STATUS<>3 GROUP BY KD_BARANG";
						//$pqtyTaken= 'SELECT SUM(QTY) as QTY FROM p0002 WHERE KD_RO="RO.2015.12.000001" AND KD_BARANG="BRGU.LG.03.06.E07.0001"';
						$poDetailQtySum=Purchasedetail::findBySql($pqtyTaken)->one();
						$poQty=$poDetailQtySum->QTY!=0?$poDetailQtySum->QTY:0;

						/* Calculate SQTY RO - QTY PO + Current QTY | minus current record QTY */
						$ttlPQTY=($roQty - $poQty)+$currentQty;

							if ($posted['QTY'] <= $ttlPQTY){
								$model->save();
								$output =Yii::$app->formatter->asDecimal($model->QTY,0);
							}else{
								return ['output'=>'', 'message'=>'Request Order QTY Limited, Greater than RO QTY ! please insert free Qty, Check Request Order'];
							}
					}
					if (isset($posted['HARGA'])) {
						 $model->save();
             $poDetail = Purchasedetail::findOne($idx);
             $data = $poDetail->KD_BARANG;
             $barang = Barang::find()->where(['KD_BARANG'=>$data])->one();
             if($barang->PARENT==0){
               $barang->HARGA_SPL=$posted['HARGA'];
               $barang->save();
             }elseif($barang->PARENT==1){
               $barang->HARGA_PABRIK=$posted['HARGA'];
               $barang->save();
             }
						$output = Yii::$app->formatter->asDecimal($model->HARGA, 2);
					}
					if (isset($posted['UNIT'])) {
						$modelUnit=Unitbarang::find()->where('KD_UNIT="'.$posted['UNIT']. '"')->one();
						$model->NM_UNIT=$modelUnit->NM_UNIT;
						$model->UNIT_QTY=$modelUnit->QTY;
						$model->UNIT_WIGHT=$modelUnit->WEIGHT;
						$model->save();
						$output =$model->UNIT;
					}
          if (isset($posted['KD_COSTCENTER'])) {
            $model->save();
            $output =$model->KD_COSTCENTER;
          }
					/*
					if (isset($posted['NOTE'])) {
					   // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
						$output = $model->NOTE;
					} */
				}
				elseif($kdPo[0]!='POB' OR $kdPo[0]!='POC'){
					/* PO Plus=POB.*/
					if (isset($posted['QTY'])) {
						$model->save();
						$output = Yii::$app->formatter->asDecimal($model->QTY,0);
					}
					if (isset($posted['HARGA'])) {
						$model->save();
						$output = Yii::$app->formatter->asDecimal($model->HARGA, 2);
					}
					if (isset($posted['UNIT'])) {
						$model->save();
						$output = $model->UNIT;
					}
          if (isset($posted['KD_COSTCENTER'])) {
            $model->save();
            $output = $model->KD_COSTCENTER;
          }
				}

				$out = Json::encode(['output'=>$output, 'message'=>'']);
			}
			// return ajax json encoded response and exit
			echo $out;
			return;
		}


		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
        $poDetail = Purchasedetail::find()->where(['KD_PO'=>$kdpo])->andWhere('STATUS <> 3')->all();
		$dataProvider = new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$poDetail,
			'pagination' => [
				'pageSize' => 20,
			],
		]);

		$checkPOCode = explode('.',$kdpo);
		if ($checkPOCode[0]=='POA'){
			return $this->render( 'review_poa', [
				'poHeader' => $poHeader,
				'poDetail' => $poDetail,
				'dataProvider' => $dataProvider,
			]);
		}elseif($checkPOCode[0]=='POB'){
			return $this->render( 'review_pob', [
				'poHeader' => $poHeader,
				'poDetail' => $poDetail,
				'dataProvider' => $dataProvider,
			]);
		}elseif($checkPOCode[0]=='POC'){
			return $this->render( 'review_poc', [
				'poHeader' => $poHeader,
				'poDetail' => $poDetail,
				'dataProvider' => $dataProvider,
			]);
		}
    }

	/*
	 * PO PLUS View | Add Item
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	 * @categoty : AJAX
	*/
	public function actionPoPlusAdditemView($kdpo)
    {
		//$poDetail = new Purchasedetail();
		$poDetailValidation = new PoPlusValidation();
		     return $this->renderAjax('_form_poplus', [
              //  'poDetail' => $poDetail,
				'kdpo'=>$kdpo,
                'poDetailValidation' => $poDetailValidation,
            ]);
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
				$prn_id = $parents[1];
				$model = Tipebarang::find()->asArray()->where(['CORP_ID'=>$corp_id,'PARENT'=>$prn_id])->all();
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
				$model = Kategori::find()->asArray()->where(['CORP_ID'=>$corp_id,'KD_TYPE'=>$type_id])->all();
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
				$prn_id = $parents[1];
				$model = Barang::find()->asArray()->where(['KD_KATEGORI'=>$kat_id,'PARENT'=>$prn_id])->all();
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
     * actionBrgkat() select2 Kategori mendapatkan barang
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionCariBrg() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$kat_id = $parents[0];
				$model = Barang::find()->asArray()->where(['KD_KATEGORI'=>$kat_id])->all();
				foreach ($model as $key => $value) {
					   $out[] = ['id'=>$value['KD_BARANG'],'name'=> $value['NM_BARANG']];
				   }

				   echo json_encode(['output'=>$out, 'selected'=>'']);
				   return;
			   }
		   }
		   echo Json::encode(['output'=>'', 'selected'=>'']);
	}

	/*
	 * PO PLUS SAVE | Add Item
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	 * @categoty : AJAX
	*/
	public function actionPoplusAdditemSave()
    {
		$poDetailValidation = new PoPlusValidation();
		/*Ajax Load*/
		if(Yii::$app->request->isAjax){
			$poDetailValidation->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($poDetailValidation));
		}else{	/*Normal Load*/
			if($poDetailValidation->load(Yii::$app->request->post())){
				if ($poDetailValidation->poplus_saved()){
					$hsl = \Yii::$app->request->post();
					return $this->redirect(['/purchasing/purchase-order/create','kdpo'=>$poDetailValidation->PO_PLUS_RSLT]);
				}
			}
		}
    }

	/*
	 * Action View | _detail PO
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	 * @categoty : AJAX
	*/
	public function actionDetail($kd_ro,$kdpo)
    {
		$roDetail = Rodetail::find()->where(['KD_RO'=>$kd_ro, 'STATUS'=>1])->all();
		$roDetailProvider = new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$roDetail,
			'pagination' => [
				'pageSize' => 20,
			],
		]);

        return $this->renderAjax('_detail', [  // ubah ini
            'roDetail' => $roDetail,
			'roDetailProvider'=>$roDetailProvider,
            'kdpo' => $kdpo,
            'kd_ro' => $kd_ro,
        ]);
    }

/*
   *action checkbox approve || review
   *if keysSelect not equal zero then foreach keysSelect
   *if save succesful,return true
   *@author : wawan;
*/
    public function actionCkAprove()
    {
      	if (Yii::$app->request->isAjax) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          $request= Yii::$app->request;
          $kdRo=$request->post('kdRo');
          $dataKeySelect=$request->post('keysSelect');
            if ($dataKeySelect!=0){
            foreach ($dataKeySelect as $id) {
              # code...
              $items = Purchasedetail::find()->where(['ID'=>$id])->one();
              $items->STATUS = 1;
              $items->save();
          }
        }else{

        }
        return true;
      }
    }

    /*
      *action uncheck checkbox proses || review
      *if keysSelect equal Null then updateAll
      *if keysSelect not equal zero then foreach keysSelect
      *if save succesful,return true
      *@author : wawan;
    */
    public function actionCkProses()
    {
        if (Yii::$app->request->isAjax) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          $request= Yii::$app->request;
          $kdRo=$request->post('kdRo');
          $kdpo=$request->post('kdpo');
          $dataKeySelect=$request->post('keysSelect');
          if($dataKeySelect == "")
          {
            $poproses = Purchasedetail::updateAll(['STATUS' => 0], ['KD_PO'=>$kdpo]);
          }else{
            if ($dataKeySelect!=0){
            foreach ($dataKeySelect as $id) {
              # code...
              $items = Purchasedetail::find()->where(['ID'=>$id])->one();
              $items->STATUS = 0;
              $items->save();
            }
          }
          }
        }
        return true;
    }

	/*
	 * Action ChekBook Grid RO to PO | _detail
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	 * @categoty : AJAX
	// */
	public function actionCk() {
		if (Yii::$app->request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			$request= Yii::$app->request;
			$dataKeySelect=$request->post('keysSelect');
			$dataKdPo=$request->post('kdpo');
			$dataKdRo=$request->post('kdRo');
			$dataKdBrg=$request->post('kdBrg');
			 /* Before Action -> 0 */
			 $AryKdRo = ArrayHelper::map(Rodetail::find()->where(['KD_RO'=>$dataKdRo])->andWhere('STATUS=101')->all(),'ID','ID');
						//print_r($AryKdRo);
						$foreaceAryKdRo=$AryKdRo!=0?$AryKdRo:'Array([0]=>"0")';
						foreach ($foreaceAryKdRo as $keyRo){
							$roDetailHapus = Rodetail::findOne($keyRo);
							$roDetailHapus->TMP_CK =0;
							$roDetailHapus->save();
						}
			$res = array('status' => 'true');
			/* An Action -> 0 */
			//print_r($dataKeySelect);

			if ($dataKeySelect!=0){
					//$foreaceGvRoToPo=$dataKeySelect!=0? $dataKeySelect:'Array([0]=>"0")';
					 foreach ($dataKeySelect as $idx){
							$roDetail=Rodetail::find()->where(['KD_RO'=>$dataKdRo,'ID'=>$idx])->andWhere('STATUS=1')->one();	//STT =202
							$poDetail=Purchasedetail::find()->where('STATUS<>3 AND KD_PO="'.$dataKdPo.'" AND KD_RO="'.$dataKdRo.'" AND KD_BARANG="'.$roDetail->KD_BARANG.'"')->one();
							$poUnit=$roDetail->cunit;
							//$poBarangUmum=$roDetail->barangumum;
							if (!$poDetail){
								//$roDetail = Rodetail::findOne($idx);
								$roDetail->TMP_CK =0; /* Untuk testing Checkbook 1 | 0 */
								//$roDetail->save();
								$res = array('status' => true); /* tidak ada Data pada Purchasedetail |KD_RO&KD_BARANG */
								/*Save To Purchase detail*/
									$poDetailModel = new Purchasedetail;
										$poDetailModel->KD_PO=$dataKdPo;
										$poDetailModel->KD_RO=$dataKdRo;
										$poDetailModel->KD_BARANG= $roDetail->KD_BARANG;
										$poDetailModel->NM_BARANG=$roDetail->NM_BARANG;
										$poDetailModel->UNIT=$poUnit->KD_UNIT;
										$poDetailModel->NM_UNIT=$poUnit->NM_UNIT;
										$poDetailModel->UNIT_QTY=$poUnit->QTY;
										$poDetailModel->UNIT_WIGHT=$poUnit->WEIGHT;
											/*FORMULA*/
											$pqtyTaken= "SELECT SUM(QTY) as QTY FROM p0002 WHERE STATUS<>3 AND KD_RO='" .$dataKdRo. "' AND KD_BARANG='" .$roDetail->KD_BARANG."' GROUP BY KD_BARANG";
											$countQtyTaken=Purchasedetail::findBySql($pqtyTaken)->one();
											if($countQtyTaken){
												$qtyInPo=$countQtyTaken->QTY!=''? $countQtyTaken->QTY :0;
											}else{
												$qtyInPo=0;
											}
                      // print_r($qtyInPo);
                      // die();
											//$qtyInPo=$countQtyTaken->QTY!=''? $countQtyTaken->QTY :0;
											$actualQty=$roDetail->SQTY - $qtyInPo;
											if($actualQty>0){
												$poDetailModel->QTY=$actualQty;
											}else{
												$poDetailModel->QTY=0;
											}
											//if($roDetail->PARENT_ROSO==0){
												$poDetailModel->HARGA=$roDetail->HARGA;  //RO
											//}elseif($roDetail->PARENT_ROSO==1){
											//	$poDetailModel->HARGA=$roDetail->HARGA_PABRIK; //SO
											//}
										$poDetailModel->STATUS=0;
                    // validasi if po
                    // print_r($roDetail->KD_BARANG);
                    // die();
                    $rorqty= "SELECT SUM(RQTY) as RQTY FROM r0003 WHERE STATUS<>3 AND KD_RO='" .$dataKdRo. "' AND KD_BARANG='" .$roDetail->KD_BARANG."' GROUP BY KD_BARANG";
                    $countQtyro=Rodetail::findBySql($rorqty)->one();
                    $Rqty = $countQtyro->RQTY;
                    if($Rqty == $qtyInPo )
                    {
                        	$res = array('status' => false);
                    }
                    else{
                      $roDetail->save();
                    $poDetailModel->save();
                    }

										//$poDetailModel->STATUS_DATE =date;//\Yii::$app->formatter->asDate(date,'Y-M-d hh:mm:ss');
									// 	$roDetail->save();
									// $poDetailModel->save();

							}else{
								$res = array('status' => false); /* sudah ada Data pada Purchasedetail |KD_RO&KD_BARANG */
							}
					}
			};
				//$res = array('status' => 't');
			return $res;
		}
	}


	/*
	 * ALAMAT Supplier Edit
	 * $roHeader->KD_SUPPLIER | Ajax Request $request->post('kD_SUPPLIER');
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionSupplierView($kdpo){
		$poHeaderVal = new SupplierValidation;
		$poHeader= Purchaseorder::findOne($kdpo);
		return $this->renderAjax('_frmsupplier',[
			'poHeaderVal'=>$poHeaderVal,
			'poHeader'=>$poHeader,
		]);
	}
	public function actionSupplierSave()
    {
		$poHeaderVal = new SupplierValidation;
		if(Yii::$app->request->isAjax){
			$poHeaderVal->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($poHeaderVal));
		}else{
			if($poHeaderVal->load(Yii::$app->request->post())){
				if ($poHeaderVal->supplier_saved()){
					$hsl = \Yii::$app->request->post();
					$kdPo = $hsl['SupplierValidation']['kD_PO'];
					return $this->redirect(['create', 'kdpo'=>$kdPo]);
				}
			}
		}
    }

	/*
	 * ALAMAT Shipping Edit
	 * $roHeader->SHIPPING | Ajax Request $request->post('sHIPPING');
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionShippingView($kdpo){
		$poHeaderVal = new ShippingValidation;
		$poHeader= Purchaseorder::findOne($kdpo);
		return $this->renderAjax('_frmshipping',[
			'poHeaderVal'=>$poHeaderVal,
			'poHeader'=>$poHeader,
		]);
	}
	public function actionShippingSave()
    {
		$poHeaderVal = new ShippingValidation;
		if(Yii::$app->request->isAjax){
			$poHeaderVal->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($poHeaderVal));
		}else{
			if($poHeaderVal->load(Yii::$app->request->post())){
				if ($poHeaderVal->shipping_saved()){
					$hsl = \Yii::$app->request->post();
					$kdPo = $hsl['ShippingValidation']['kD_PO'];
					return $this->redirect(['create', 'kdpo'=>$kdPo]);
				}
			}
		}
    }

	/*
	 * ALAMAT BILLING Edit
	 * $roHeader->SHIPPING | Ajax Request $request->post('sHIPPING');
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionBillingView($kdpo){
		$poHeaderVal = new BillingValidation;
		$poHeader= Purchaseorder::findOne($kdpo);
		return $this->renderAjax('_frmbilling',[
			'poHeaderVal'=>$poHeaderVal,
			'poHeader'=>$poHeader,
		]);
	}
	public function actionBillingSave()
    {
		$poHeaderVal = new BillingValidation;
		if(Yii::$app->request->isAjax){
			$poHeaderVal->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($poHeaderVal));
		}else{
			if($poHeaderVal->load(Yii::$app->request->post())){
				if ($poHeaderVal->billing_saved()){
					$hsl = \Yii::$app->request->post();
					$kdPo = $hsl['BillingValidation']['kD_PO'];
					return $this->redirect(['create', 'kdpo'=>$kdPo]);
				}
			}
		}
    }

	/*
	 * Discount Edit
	 * $roHeader->DISCOUNT | Ajax Request $request->post('disc');
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionDiscountView($kdpo){
		$poHeaderVal = new DiscountValidation;
		$poHeader= Purchaseorder::findOne($kdpo);
		return $this->renderAjax('_frmdiscount',[
			'poHeaderVal'=>$poHeaderVal,
			'poHeader'=>$poHeader,
		]);
	}
	public function actionDiscountSave()
    {
		$poHeaderVal = new DiscountValidation;
		if(Yii::$app->request->isAjax){
			$poHeaderVal->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($poHeaderVal));
		}else{
			if($poHeaderVal->load(Yii::$app->request->post())){
				if ($poHeaderVal->discount_saved()){
					$hsl = \Yii::$app->request->post();
					$kdPo = $hsl['DiscountValidation']['kD_PO'];
					return $this->redirect(['create', 'kdpo'=>$kdPo]);
				}
			}
		}
    }

	/*
	 * Pajak Edit
	 * $roHeader->PAJAK  | Ajax $request->post('tax');
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	 public function actionPajakView($kdpo){
		$poHeaderVal = new PajakValidation;
		$poHeader= Purchaseorder::findOne($kdpo);
		return $this->renderAjax('_frmpajak',[
			'poHeaderVal'=>$poHeaderVal,
			'poHeader'=>$poHeader,
		]);
	}
	public function actionPajakSave()
    {
		$poHeaderVal = new PajakValidation;
		if(Yii::$app->request->isAjax){
			$poHeaderVal->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($poHeaderVal));
		}else{
			if($poHeaderVal->load(Yii::$app->request->post())){
				if ($poHeaderVal->discount_saved()){
					$hsl = \Yii::$app->request->post();
					$kdPo = $hsl['PajakValidation']['kD_PO'];
					return $this->redirect(['create', 'kdpo'=>$kdPo]);
				}
			}
		}
    }

	/*
	 * DELIVERY_COST Edit
	 * $roHeader->DELIVERY_COST  | Ajax $request->post('tax');
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	 public function actionDeliveryView($kdpo){
		$poHeaderVal = new DeliveryValidation;
		$poHeader= Purchaseorder::findOne($kdpo);
		return $this->renderAjax('_frmdelivery',[
			'poHeaderVal'=>$poHeaderVal,
			'poHeader'=>$poHeader,
		]);
	}
	public function actionDeliverySave(){
		$poHeaderVal = new DeliveryValidation;
		if(Yii::$app->request->isAjax){
			$poHeaderVal->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($poHeaderVal));
		}else{
			if($poHeaderVal->load(Yii::$app->request->post())){
				if ($poHeaderVal->delevery_saved()){
					$hsl = \Yii::$app->request->post();
					$kdPo = $hsl['DeliveryValidation']['kD_PO'];
					return $this->redirect(['create', 'kdpo'=>$kdPo]);
				}
			}
		}
    }

	/*
	 * ETD EDIT
	 * $roHeader->ETD  | Ajax $request->post('eTD');
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	 public function actionEtdView($kdpo){
		$poHeaderVal = new EtdValidation;
		$poHeader= Purchaseorder::findOne($kdpo);
		return $this->renderAjax('_frmetd',[
			'poHeaderVal'=>$poHeaderVal,
			'poHeader'=>$poHeader,
		]);
	}
	public function actionEtdSave(){
		$poHeaderVal = new EtdValidation;
		if(Yii::$app->request->isAjax){
			$poHeaderVal->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($poHeaderVal));
		}else{
			if($poHeaderVal->load(Yii::$app->request->post())){
				if ($poHeaderVal->etd_saved()){
					$hsl = \Yii::$app->request->post();
					$kdPo = $hsl['EtdValidation']['kD_PO'];
					return $this->redirect(['create', 'kdpo'=>$kdPo]);
				}else{
					$hsl = \Yii::$app->request->post();
					$kdPo = $hsl['EtdValidation']['kD_PO'];
					return $this->redirect(['create', 'kdpo'=>$kdPo]);
				}
			}
		}
    }


	/*
	 * ETA EDIT
	 * $roHeader->ETA  | Ajax $request->post('eTA');
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	 public function actionEtaView($kdpo){
		$poHeaderVal = new EtaValidation;
		$poHeader= Purchaseorder::findOne($kdpo);
		return $this->renderAjax('_frmeta',[
			'poHeaderVal'=>$poHeaderVal,
			'poHeader'=>$poHeader,
		]);
	}
	public function actionEtaSave(){
		$poHeaderVal = new EtaValidation;
		if(Yii::$app->request->isAjax){
			$poHeaderVal->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($poHeaderVal));
		}else{
			if($poHeaderVal->load(Yii::$app->request->post())){
				if ($poHeaderVal->eta_saved()){
					$hsl = \Yii::$app->request->post();
					$kdPo = $hsl['EtaValidation']['kD_PO'];
					return $this->redirect(['create', 'kdpo'=>$kdPo]);
				}
			}
		}
    }


	/*
	 * Auth 1 Created
	*/
    public function Sendmail($kdpo)
    {

		$poDetailQry = "SELECT p.ID,p.KD_PO,p.KD_RO,p.KD_BARANG,p.NM_BARANG,p.UNIT,p.NM_UNIT,p.UNIT_QTY,p.KD_COSTCENTER,p.HARGA,p.STATUS,
					  p.STATUS_DATE,p.NOTE,p.UNIT_WIGHT,SUM(QTY) AS QTY FROM `p0002` p
					 LEFT JOIN p0004 a ON p.KD_COSTCENTER = a.KD_COSTCENTER
					 WHERE p.KD_PO='".$kdpo."' AND p.STATUS<>3 GROUP BY p.KD_BARANG,p.NM_UNIT,p.HARGA";

		$poDetail=Purchasedetail::findBySql($poDetailQry)->all();
		$poHeader = Purchaseorder::find()->where(['KD_PO' =>$kdpo])->one();
		$dataProvider = new ArrayDataProvider([
			'key' => 'KD_PO',
			'allModels'=>$poDetail,
			'pagination' => [
			 'pageSize' => 20,
			],
		]);

		$content= $this->renderPartial( 'pdf', [
			'poHeader' => $poHeader,
			'dataProvider' => $dataProvider,
        ]);
		# code...

		/*Attachment*/
		$contentMailAttach= $this->renderPartial('sendmailcontent',[
			'poHeader' => $poHeader,
			'dataProvider' => $dataProvider,
		]);

		/*Body Notify*/
		$contentMailAttachBody= $this->renderPartial('postman_body',[
			'poHeader' => $poHeader,
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
			//'destination' => Pdf::DEST_FILE ,
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
			
		$url_dev = Url::base(true);
			if($url_dev == 'http://labtest1-erp.int')
			{
				$to =['labtest@lukison.com'];
			}else{
				$to =['purchasing@lukison.com'];
			}
		

		/* KIRIM ATTACH emaiL */
		//$to=[ 'purchasing@lukison.com'];
		\Yii::$app->kirim_email->pdf($contentMailAttach,'PO',$to,'Purchase-Order',$contentMailAttachBody);
    }


	/*
	 * Auth 2 Checked
	*/
	public function Sendmail2($kdpo)
	{

		$poDetailQry = "SELECT p.ID,p.KD_PO,p.KD_RO,p.KD_BARANG,p.NM_BARANG,p.UNIT,p.NM_UNIT,p.UNIT_QTY,p.KD_COSTCENTER,p.HARGA,p.STATUS,
					p.STATUS_DATE,p.NOTE,p.UNIT_WIGHT,SUM(QTY) AS QTY FROM `p0002` p
					 LEFT JOIN p0004 a ON p.KD_COSTCENTER = a.KD_COSTCENTER
					 WHERE p.KD_PO='".$kdpo."' AND p.STATUS<>3 GROUP BY p.KD_BARANG,p.NM_UNIT,p.HARGA";
		$poDetail=Purchasedetail::findBySql($poDetailQry)->all();
		$poHeader = Purchaseorder::find()->where(['KD_PO' =>$kdpo])->one();
		$dataProvider = new ArrayDataProvider([
			'key' => 'KD_PO',
			'allModels'=>$poDetail,
			'pagination' => [
				'pageSize' => 20,
			 ],
		]);

		$content= $this->renderPartial( 'pdf', [
			'poHeader' => $poHeader,
			'dataProvider' => $dataProvider,
		  ]);
		# code...
		$contentMailAttach= $this->renderPartial('sendmailcontent',[
			'poHeader' => $poHeader,
			'dataProvider' => $dataProvider,
		]);

		/*Body Notify*/
		$contentMailAttachBody= $this->renderPartial('postman_body',[
			'poHeader' => $poHeader,
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
			//'destination' => Pdf::DEST_FILE ,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			//D:\xampp\htdocs\advanced\lukisongroup\web\widget\pdf-asset
			'cssFile' => '@lukisongroup/web/widget/pdf-asset/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:12px}',
			 // set mPDF properties on the fly
			'options' => ['title' => 'Form Purchase Order','subject'=>'po'],
			 // call mPDF methods on the fly
			'methods' => [
			  'SetHeader'=>['Copyright@LukisonGroup '.date("r")],
			  'SetFooter'=>['{PAGENO}'],
			]
		]);
		/* KIRIM ATTACH emaiL */
		 //$to=['purchasing@lukison.com'];//,'piter@lukison.com'];

		$url_dev = Url::base(true);
			if($url_dev == 'http://labtest1-erp.int')
			{
				$to =['labtest@lukison.com'];
			}else{
				$to =['purchasing@lukison.com'];
			}

		\Yii::$app->kirim_email->pdf($contentMailAttach,'PO',$to,'Purchase-Order',$contentMailAttachBody);
	}


	/*
	 * Auth 3 Approved
	*/
	public function Sendmail3($kdpo)
	{

		$poDetailQry = "SELECT p.ID,p.KD_PO,p.KD_RO,p.KD_BARANG,p.NM_BARANG,p.UNIT,p.NM_UNIT,p.UNIT_QTY,p.KD_COSTCENTER,p.HARGA,p.STATUS,
					  p.STATUS_DATE,p.NOTE,p.UNIT_WIGHT,SUM(QTY) AS QTY FROM `p0002` p
					 LEFT JOIN p0004 a ON p.KD_COSTCENTER = a.KD_COSTCENTER
					 WHERE p.KD_PO='".$kdpo."' AND p.STATUS<>3 GROUP BY p.KD_BARANG,p.NM_UNIT,p.HARGA";

		$poDetail=Purchasedetail::findBySql($poDetailQry)->all();
		$poHeader = Purchaseorder::find()->where(['KD_PO' =>$kdpo])->one();
		$dataProvider = new ArrayDataProvider([
		'key' => 'KD_PO',
		'allModels'=>$poDetail,
		'pagination' => [
		'pageSize' => 20,
			],
		]);

		$content= $this->renderPartial( 'pdf', [
			'poHeader' => $poHeader,
			'dataProvider' => $dataProvider,
		]);
		# code...
		$contentMailAttach= $this->renderPartial('sendmailcontent',[
			'poHeader' => $poHeader,
			'dataProvider' => $dataProvider,
		]);

		/*Body Notify*/
		$contentMailAttachBody= $this->renderPartial('postman_body',[
			'poHeader' => $poHeader,
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
			//'destination' => Pdf::DEST_FILE ,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			//D:\xampp\htdocs\advanced\lukisongroup\web\widget\pdf-asset
			'cssFile' => '@lukisongroup/web/widget/pdf-asset/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:12px}',
			 // set mPDF properties on the fly
			'options' => ['title' => 'Form Purchase Order','subject'=>'po'],
			 // call mPDF methods on the fly
			'methods' => [
			  'SetHeader'=>['Copyright@LukisonGroup '.date("r")],
			  'SetFooter'=>['{PAGENO}'],
			]
		]);

			$url_dev = Url::base(true);
		
			
			if($url_dev == 'http://labtest1-erp.int')
			{
				$to =['labtest@lukison.com'];
			}else{
				$to =['purchasing@lukison.com'];
			}
		

		/* KIRIM ATTACH emaiL */
		 //$to=['purchasing@lukison.com'];//,'piter@lukison.com','ridwan@lukison.com'];
		\Yii::$app->kirim_email->pdf($contentMailAttach,'PO',$to,'Purchase-Order',$contentMailAttachBody);
	}


	/*
	 * SIGNATURE AUTH1 | SIGN CREATED PO
	 * $poHeader->STATUS =101
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	 public function actionSignAuth1View($kdpo){
		$auth1Mdl = new Auth1Model();
		$poHeader = Purchaseorder::find()->where(['KD_PO' =>$kdpo])->one();
		$employe = $poHeader->employe;

			return $this->renderAjax('sign-auth1', [
				'poHeader' => $poHeader,
				'employe' => $employe,
				'auth1Mdl' => $auth1Mdl,
			]);

	}
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
					$kdpo = $hsl['Auth1Model']['kdpo'];
					$this->Sendmail($kdpo); //call function email
					return $this->redirect(['create', 'kdpo'=>$kdpo]);
				}
			}
		}
    }

	/*
	 * SIGNATURE AUTH2 | SIGN CHECKED PO
	 * $poHeader->STATUS =102
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	 public function actionSignAuth2View($kdpo){
		$auth2Mdl = new Auth2Model();
		$poHeader = Purchaseorder::find()->where(['KD_PO' =>$kdpo])->one();
		$employe = $poHeader->employe;
			return $this->renderAjax('sign-auth2', [
				'poHeader' => $poHeader,
				'employe' => $employe,
				'auth2Mdl' => $auth2Mdl,
			]);
	}
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
					$kdpo = $hsl['Auth2Model']['kdpo'];
						 $this->Sendmail2($kdpo);//call function email
					return $this->redirect(['review', 'kdpo'=>$kdpo]);
				}
			}
		}
    }


    /*
  	 * SIGNATURE AUTH4 | SIGN CHECKED PO
  	 * $poHeader->STATUS =102
  	 * @author ptrnov  <piter@lukison.com>
       * @since 1.1
       */
  	 public function actionSignAuth4View($kdpo){
  		$auth4Mdl = new Auth4Model();
  		$poHeader = Purchaseorder::find()->where(['KD_PO' =>$kdpo])->one();
  		$employe = $poHeader->employe;
  			return $this->renderAjax('sign-auth4', [
  				'poHeader' => $poHeader,
  				'employe' => $employe,
  				'auth2Mdl' => $auth4Mdl,
  			]);
  	}
  	public function actionSignAuth4Save(){
  		$auth4Mdl = new Auth4Model();
  		/*Ajax Load*/
  		if(Yii::$app->request->isAjax){
  			$auth4Mdl->load(Yii::$app->request->post());
  			return Json::encode(\yii\widgets\ActiveForm::validate($auth4Mdl));
  		}else{	/*Normal Load*/
  			if($auth4Mdl->load(Yii::$app->request->post())){
  				if ($auth4Mdl->auth4_saved()){
  					$hsl = \Yii::$app->request->post();
  					$kdpo = $hsl['Auth4Model']['kdpo'];
  					// $this->Sendmail2($kdpo);//call function email
  					return $this->redirect(['review', 'kdpo'=>$kdpo]);
  				}
  			}
  		}
      }

	/*
	 * SIGNATURE AUTH3 | SIGN APPROVAL PO
	 * $poHeader->STATUS =103
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
    */
	public function actionSignAuth3View($kdpo){
		$auth3Mdl = new Auth3Model();
		$poHeader = Purchaseorder::find()->where(['KD_PO' =>$kdpo])->one();
		$employe = $poHeader->employe;
			return $this->renderAjax('sign-auth3', [
				'poHeader' => $poHeader,
				'employe' => $employe,
				'auth3Mdl' => $auth3Mdl,
			]);
	}
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
					$kdpo = $hsl['Auth3Model']['kdpo'];
          			$this->Sendmail3($kdpo);//call function email
					return $this->redirect(['review', 'kdpo'=>$kdpo]);
				}
			}
		}
    }

	/*
	 * PO Note
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionPoNote($kdpo){
		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
		return $this->renderAjax('_form_ponote_buat', [
			'poHeader' => $poHeader,
		]);
	}
	public function actionPoNoteSave($kdpo){
		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
		if($poHeader->load(Yii::$app->request->post())){
			$hsl = \Yii::$app->request->post();
			$poHeader->NOTE = $hsl['Purchaseorder']['NOTE'];
			$poHeader->save();
			return $this->redirect(['create', 'kdpo'=>$kdpo]);
		}
    }

	/*
	 * PO Note Term of Payment
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionPoNotetopView($kdpo){
		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
		return $this->renderAjax('_form_ponote_buat_top', [
			'poHeader' => $poHeader,
		]);
	}
	public function actionPoNotetopSave($kdpo){
		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
		if($poHeader->load(Yii::$app->request->post())){
			$hsl = \Yii::$app->request->post();
			$topType=$poHeader->TOP_TYPE = $hsl['Purchaseorder']['TOP_TYPE'];
			$topDuration =$hsl['Purchaseorder']['TOP_DURATION'];
			$poHeader->TOP_TYPE =$topType;
			$poHeader->TOP_DURATION = $topType=='Credit' ? $topDuration:'';
			$poHeader->save();
			return $this->redirect(['create', 'kdpo'=>$kdpo]);
		}
    }

	/*
	 * PO Note Review
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionPoNoteReview($kdpo){
		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
		return $this->renderAjax('_form_ponote_review', [
			'poHeader' => $poHeader,
		]);
	}
	public function actionPoNoteReviewSave($kdpo){
		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
		if($poHeader->load(Yii::$app->request->post())){
			$hsl = \Yii::$app->request->post();
			$poHeader->NOTE = $hsl['Purchaseorder']['NOTE'];
			$poHeader->save();
			return $this->redirect(['review', 'kdpo'=>$kdpo]);
		}
    }

	/*
	 * PO Note Review  erm of Payment
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionPoNotetopReview($kdpo){
		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
		return $this->renderAjax('_form_ponote_review_top', [
			'poHeader' => $poHeader,
		]);
	}
	public function actionPoNotetopReviewSave($kdpo){
		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
		if($poHeader->load(Yii::$app->request->post())){
			$hsl = \Yii::$app->request->post();
			$topType=$poHeader->TOP_TYPE = $hsl['Purchaseorder']['TOP_TYPE'];
			$topDuration =$hsl['Purchaseorder']['TOP_DURATION'];
			$poHeader->TOP_TYPE =$topType;
			$poHeader->TOP_DURATION = $topType=='Credit' ? $topDuration:'';
			$poHeader->save();
			return $this->redirect(['review', 'kdpo'=>$kdpo]);
		}
    }

	/*
	 * Print PDF
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
    public function actionCetakpdf($kdpo)
    {
		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
		//$poDetail = Purchasedetail::find()->where(['KD_PO'=>$kdpo])->all();
		// $poDetailQry= "SELECT ID,KD_PO,KD_RO,KD_BARANG,NM_BARANG,UNIT,NM_UNIT,UNIT_QTY,UNIT_WIGHT,SUM(QTY) AS QTY,HARGA,STATUS,STATUS_DATE,NOT
		// 				FROM `p0002` WHERE KD_PO='" .$kdpo. "' GROUP BY KD_BARANG,NM_UNIT,HARGA";
          $poDetailQry = "SELECT p.ID,p.KD_PO,p.KD_RO,p.KD_BARANG,p.NM_BARANG,p.UNIT,p.NM_UNIT,p.UNIT_QTY,p.KD_COSTCENTER,p.HARGA,p.STATUS,
                          p.STATUS_DATE,p.NOTE,p.UNIT_WIGHT,SUM(QTY) AS QTY FROM `p0002` p
                         LEFT JOIN p0004 a ON p.KD_COSTCENTER = a.KD_COSTCENTER
                         WHERE p.KD_PO='".$kdpo."' AND p.STATUS<>3 GROUP BY p.KD_BARANG,p.NM_UNIT,p.HARGA";

		    $poDetail=Purchasedetail::findBySql($poDetailQry)->all();
        $dataProvider = new ArrayDataProvider([
			'key' => 'KD_PO',
			'allModels'=>$poDetail,
			'pagination' => [
				'pageSize' => 20,
			],
		]);

		$content= $this->renderPartial( 'pdf', [
			'poHeader' => $poHeader,
            //'roHeader' => $roHeader,
            //'detro' => $detro,
            //'employ' => $employ,
			//'dept' => $dept,
			'dataProvider' => $dataProvider,
        ]);

		/*PR TO WAWAN*/
		/*
		 * Render partial -> Add Css -> Sendmail
		 * @author ptrnov [piter@lukison]
		 * @since 1.2
		*/
		// $contentMailAttach= $this->renderPartial('sendmailcontent',[
			// 'poHeader' => $poHeader,
			// 'dataProvider' => $dataProvider,
		// ]);

		// $contentMailAttachBody= $this->renderPartial('postman_body',[
			// 'poHeader' => $poHeader,
			// 'dataProvider' => $dataProvider,
		// ]);


		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_PORTRAIT,
			// stream to browser inline
			'destination' => Pdf::DEST_BROWSER,
			//'destination' => Pdf::DEST_FILE ,
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
		/* KIRIM ATTACH emaiL */
		//$to=['piter@lukison.com'];
		//\Yii::$app->kirim_email->pdf($contentMailAttach,'PO',$to,'Purchase-Order',$contentMailAttachBody);

		return $pdf->render();
    }



	/*.
	 * TMP PDF | Purchaseorder| Purchasedetail
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
    public function actionTempCetakpdf($kdpo)
    {
		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
		// //$poDetail = Purchasedetail::find()->where(['KD_PO'=>$kdpo])->all();
		// $poDetailQry= "SELECT ID,KD_PO,KD_RO,KD_BARANG,NM_BARANG,UNIT,NM_UNIT,UNIT_QTY,UNIT_WIGHT,SUM(QTY) AS QTY,HARGA,STATUS,STATUS_DATE,NOTE
		// 				FROM `p0002` WHERE KD_PO='" .$kdpo. "' GROUP BY KD_BARANG,NM_UNIT,HARGA";
		$poDetailQry = "SELECT p.ID,p.KD_PO,p.KD_RO,p.KD_BARANG,p.NM_BARANG,p.UNIT,p.NM_UNIT,p.UNIT_QTY,p.KD_COSTCENTER,p.HARGA,p.STATUS,
                    p.STATUS_DATE,p.NOTE,p.UNIT_WIGHT,SUM(QTY) AS QTY FROM `p0002` p
                   LEFT JOIN p0004 a ON p.KD_COSTCENTER = a.KD_COSTCENTER
                   WHERE p.KD_PO='".$kdpo."' AND p.STATUS<>3 GROUP BY p.KD_BARANG,p.NM_UNIT,p.HARGA";
		$poDetail=Purchasedetail::findBySql($poDetailQry)->all();
        $dataProvider = new ArrayDataProvider([
			'key' => 'KD_PO',
			'allModels'=>$poDetail,
			'pagination' => [
				'pageSize' => 20,
			],
		]);

		$content = $this->renderPartial( 'pdf_tmp', [
			'poHeader' => $poHeader,
            //'roHeader' => $roHeader,
            //'detro' => $detro,
            //'employ' => $employ,
			//'dept' => $dept,
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

		/* $mpdf=new mPDF();
        $mpdf->WriteHTML($this->renderPartial( 'pdf', [
            'model' => Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one(),
        ]));
        $mpdf->Output();
        exit; */
    }



    /**
     * Deletes an existing Purchaseorder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    /* public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    } */

	/**
	 * On Approval View
	 * Approved_podetail | Rodetail->ID |  $roDetail->STATUS = 101;
	 * Approved = 1
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionApproved_podetail()
    {
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			//\Yii::$app->response->format = Response::FORMAT_JSON;
			$roDetail = Purchasedetail::findOne($id);
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
	public function actionReject_podetail()
    {
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			$roDetail = Purchasedetail::findOne($id);
			$roDetail->STATUS = 4;
			$roDetail->save();
			return true;
		}
    }

	/**
	 * On Approval View
	 * Reject_rodetail | Rodetail->ID |  $roDetail->STATUS = 4;
	 * Delete = 3
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionDelete_podetail()
    {
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			$roDetail = Purchasedetail::findOne($id);
			$roDetail->STATUS = 3;
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
	public function actionCancel_podetail()
    {
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			$roDetail = Purchasedetail::findOne($id);
			$roDetail->STATUS = 0;
			$roDetail->save();
			return true;
		}
    }

    public function actionDelpo($idpo,$kdpo)
    {
        $podet = Podetail::find()->where(['KD_PO'=>$kdpo, 'ID'=>$idpo])->one();
        $po = Purchasedetail::find()->where(['KD_PO'=>$kdpo, 'ID'=>$podet->ID_DET_PO])->one();

        $sisa = $po->QTY - $podet->QTY;

        if($sisa == '0'){
            \Yii::$app->db_esm->createCommand()->update('p0002', ['QTY'=>$sisa, 'STATUS'=>'3'], "ID='$po->ID'")->execute();
        } else {
            \Yii::$app->db_esm->createCommand()->update('p0002', ['QTY'=>$sisa], "ID='$po->ID'")->execute();
        }

        $podet->STATUS = '3';
        $podet->save();

        return $this->redirect(['create', 'kdpo'=>$kdpo]);
    }

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

    /**
     * Finds the Purchaseorder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Purchaseorder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Purchaseorder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
