<?php

namespace lukisongroup\purchasing\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;

use lukisongroup\purchasing\models\pr\Purchaseorder;
use lukisongroup\purchasing\models\pr\PurchaseorderSearch;

use lukisongroup\purchasing\models\pr\Purchasedetail;
use lukisongroup\purchasing\models\pr\Podetail;
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
//use lukisongroup\purchasing\models\pr\SendPoQtyValidation;

use lukisongroup\purchasing\models\ro\Requestorder;
use lukisongroup\purchasing\models\ro\RequestorderSearch;
use lukisongroup\purchasing\models\ro\Rodetail;
use lukisongroup\purchasing\models\ro\RodetailSearch;

use lukisongroup\purchasing\models\so\SalesorderSearch;


use lukisongroup\purchasing\models\Statuspo;

use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Unitbarang;

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
    
	/*
	 * Index Po | Purchaseorder| Purchasedetail
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
    public function actionIndex()
    {
        $searchModel = new PurchaseorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $poHeader = new Purchaseorder();
		/*Model Validasi Generate Code*/
		$poHeaderVal = new NewPoValidation();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'poHeader' => $poHeader,
			'poHeaderVal'=>$poHeaderVal,
        ]);
    }

	
	/*
	 * View Po | Purchaseorder| Purchasedetail
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
		$poDetailQry= "SELECT ID,KD_PO,KD_RO,KD_BARANG,NM_BARANG,UNIT,NM_UNIT,UNIT_QTY,UNIT_WIGHT,SUM(QTY) AS QTY,HARGA,STATUS,STATUS_DATE,NOTE
						FROM `p0002` WHERE KD_PO='" .$kd. "' GROUP BY KD_BARANG,UNIT,HARGA";
		$poDetail=Purchasedetail::findBySql($poDetailQry)->all();		
		$dataProvider = new ArrayDataProvider([
			'key' => 'KD_PO',
			'allModels'=>$poDetail,		
			'pagination' => [
				'pageSize' => 20,
			],
		]);
		
		return $this->render( 'view', [
			'poHeader' => $poHeader,
            'poDetail' => $poDetail,
            //'detro' => $detro,
            //'employ' => $employ,
			//'dept' => $dept,
			'dataProvider' => $dataProvider,
        ]);
    }
	
	
	/*
	 * Review Po for Signature or  Approved |Purchaseorder| Purchasedetail
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
						$pqtyTaken= "SELECT SUM(QTY) as QTY FROM p0002 WHERE KD_RO='" .$roDetail->KD_RO. "' AND KD_BARANG='" .$roDetail->KD_BARANG ."' GROUP BY KD_BARANG";
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
		
		return $this->render( 'review', [
			'poHeader' => $poHeader,
            'poDetail' => $poDetail,
            //'detro' => $detro,
            //'employ' => $employ,
			//'dept' => $dept,
			'dataProvider' => $dataProvider,
        ]);
    }
	
	/*
	 * Create PO
	 * PO Generate | PO Normal | PO Plus
	 * ID_SUPPLIER=null| SHIPPING=Null | BILLING=Null | ETD=Null | ETA=Null | SUMMARY [DISCOUNT|TAX|DELEVERY]
	 * GRID | EDITING =[HARGA|QTY|UNIT] -> VALIDATION HARGA | QTY [Tidak boleh lebih dari SQTY], (RO to PO ->HARGA = Manual Input), SO(SO to PO -> Harga=Harga Otomatis dari SO) 
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
    public function actionCreate($kdpo)
    {
        $searchModel = new RequestorderSearch();
        $dataProviderRo = $searchModel->cariHeaderRO_SendPO(Yii::$app->request->queryParams);
		 
		$searchModel = new SalesorderSearch();
        $dataProviderSo = $searchModel->cariSO(Yii::$app->request->queryParams);
	
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
						$pqtyTaken= "SELECT SUM(QTY) as QTY FROM p0002 WHERE KD_RO='" .$roDetail->KD_RO. "' AND KD_BARANG='" .$roDetail->KD_BARANG."' GROUP BY KD_BARANG";
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
				}
				
				$out = Json::encode(['output'=>$output, 'message'=>'']);
			}
			// return ajax json encoded response and exit
			echo $out;
			return;
		}
		
        return $this->render('create', [
            'searchModel' => $searchModel,
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
	
	/*
	 * Create PO | Generate PO | 
	 * PO PLUS ['POA.'.date('ymdhis')] -> POA DENGAN LIMIT HARGA
	 * PO Normal ['PO.'.date('ymdhis')] -> PO Dengan Persetujuan orderby | RequestOrder|SalesOrder
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
					//$kdPo =$poHeaderVal->PO_RSLT
					return $this->redirect(['create', 'kdpo'=>$poHeaderVal->PO_RSLT]);
					//echo "test";
				}														
			}
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
     * actionBrgkat() select2 Kategori mendapatkan barang
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionBrgkat() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$prn_id = $parents[0];
				$model = Kategori::find()->asArray()->where(['PARENT'=>$prn_id])->all();
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
	 * Action ChekBook Grid RO to PO | _detail
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	 * @categoty : AJAX
	*/
	public function actionCk() {
		
		if (Yii::$app->request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			$request= Yii::$app->request;
			$dataKeySelect=$request->post('keysSelect');
			$dataKdPo=$request->post('kdpo');			
			$dataKdRo=$request->post('kdRo');
			$dataKdBrg=$request->post('kdBrg');			
			 /* Before Action -> 0 */
			 $AryKdRo = ArrayHelper::map	(Rodetail::find()->where(['KD_RO'=>$dataKdRo])->andWhere('STATUS=101')->all(),'ID','ID');
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
							$poDetail=Purchasedetail::find()->where(['KD_PO'=>$dataKdPo,'KD_RO'=>$dataKdRo,'KD_BARANG'=>$roDetail->KD_BARANG])->one();
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
											$pqtyTaken= "SELECT SUM(QTY) as QTY FROM p0002 WHERE KD_RO='" .$dataKdRo. "' AND KD_BARANG='" .$roDetail->KD_BARANG."' GROUP BY KD_BARANG";	
											$countQtyTaken=Purchasedetail::findBySql($pqtyTaken)->one();
											if($countQtyTaken){
												$qtyInPo=$countQtyTaken->QTY!=''? $countQtyTaken->QTY :0;
											}else{
												$qtyInPo=0;
											}
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
										//$poDetailModel->STATUS_DATE =date;//\Yii::$app->formatter->asDate(date,'Y-M-d hh:mm:ss');	
										$roDetail->save();											
									$poDetailModel->save();
								
							}else{
								$res = array('status' => false); /* sudah ada Data pada Purchasedetail |KD_RO&KD_BARANG */								
							}
					} 		
			};
				//$res = array('status' => 't');
			return $res; 
		}	
	}

	
	
	
    public function actionSimpan()
    {
        $cons = \Yii::$app->db_esm;
		$tes = Yii::$app->request->post();
        $kdpo = $tes['kdpo'];
        $kdro = $tes['kdro'];

        $status = '';
        foreach ($tes['selection'] as $key => $isi) {
            $pp = explode('_',$isi);
            $rd = Rodetail::find()->where(['ID'=>$pp[1]])->one();
            $ckpo = Purchasedetail::find()->where(['KD_BARANG'=> $rd->KD_BARANG, 'KD_PO'=>$kdpo, 'UNIT'=>$rd->UNIT])->andWhere('STATUS <> 3')->one();


            if(count($ckpo) == 0){
                $command = $cons->createCommand();

                $command->insert('p0002', [
                    'KD_PO'=> $kdpo, 
                    'QTY'=> $rd->SQTY, 
                    'UNIT'=> $rd->UNIT,
                    'STATUS'=> 0,
                    'KD_BARANG'=> $rd->KD_BARANG,
                ] )->execute();

                $id = $cons->getLastInsertID();
                $command->insert('p0021', [
                    'KD_PO'=> $kdpo, 
                    'KD_RO'=> $tes['kdro'], 
                    'ID_DET_RO'=> $pp[1],
                    'ID_DET_PO'=> $id,
                    'QTY'=> $rd->SQTY, 
                    'UNIT'=> $rd->UNIT,
                    'STATUS'=>1,
                    ]
                )->execute();
            } else {

                $dpo = Podetail::find()->where(['ID_DET_PO'=>$ckpo->ID, 'KD_RO'=>$kdro])->andWhere('STATUS <> 3')->one();

                if(count($dpo) == 1){ 
                    $status .= '<p class="bg-danger" style="padding:15px;" >RO "<b>'.$kdro.'</b>" dengan kode barang " <b>'.$rd->KD_BARANG.'</b> " Sudah ada di dalam list.<br/> silahkan ubah jumlah Quantity barangnya.</p>';
                } else {

                    $command = $cons->createCommand();
                    $command->insert('p0021', [
                        'KD_PO'=> $kdpo, 
                        'KD_RO'=> $tes['kdro'], 
                        'ID_DET_RO'=> $pp[1],
                        'ID_DET_PO'=> $ckpo->ID,
                        'QTY'=> $rd->SQTY, 
                        'UNIT'=> $rd->UNIT,
                        'STATUS'=>1,
                        ]
                    )->execute();
                    
                    $ttl = $rd->SQTY + $ckpo->QTY;
                    $idpo = $ckpo->ID;
                    $command->update('p0002', ['QTY'=>$ttl], "ID='$idpo'")->execute();
                }
            }
        }

        \Yii::$app->getSession()->setFlash('error', $status);
        return $this->redirect(['create','kdpo'=>$kdpo]);
    }

    public function actionSpo($kdpo)
    {
        $cons = \Yii::$app->db_esm;
        $post = Yii::$app->request->post();
        $ttl = count($post['qty']);

        $hsl = 0;
        $idpo = $post['idpo'];
        for($a=0; $a<=$ttl-1; $a++){
            $qty = $post['sqty'][$a];
            $ket = $post['ket'][$a];
            $id = $post['id'][$a];

            $hsl = $hsl + $qty;

           $command = $cons->createCommand();
           $command->update('p0021', ['QTY'=>$qty, 'NOTE'=>$ket], "ID='$id'")->execute();
        }
        $command->update('p0002', ['QTY'=>$hsl], "ID='$idpo'")->execute();

        return $this->redirect(['create','kdpo'=>$kdpo]);
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



    public function actionCreatepo()
    {
        $post = Yii::$app->request->post();
        $coall = count($post['hargaBarang']);

        $kdpo = $post['kdpo'];

        for ($i=0; $i < $coall ; $i++) { 
            $kdBrg = $post['kdBarang'][$i];
            $harga = $post['hargaBarang'][$i];

            $ckBrg = explode('.', $kdBrg);
            if($ckBrg[0] == 'BRG'){
                $nmBrg = Barang::find('NM_BARANG')->where(['KD_BARANG'=>$kdBrg])->one();
                $nmBrg->HARGA = $harga;
                $nmBrg->save();
            } else if($ckBrg[0] == 'BRGU') {
                $nmBrg = Barang::find('NM_BARANG')->where(['KD_BARANG'=>$kdBrg])->one();
                $nmBrg->HARGA = $harga;
                $nmBrg->save();
            }

            $detpo = Purchasedetail::find('ID')->where(['KD_BARANG'=>$kdBrg, 'KD_PO'=>$kdpo])->one();

            $cons = \Yii::$app->db_esm;
            $command = $cons->createCommand();
            $command->update('p0002', ['HARGA'=>$harga], "ID='$detpo->ID'")->execute();

        }

        $po = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();  
        $po->STATUS = '101';
        $po->PAJAK = $post['pajak'];
        $po->DISC = $post['disc'];
        $po->NOTE = $post['note'];
        $po->ETA = $post['eta'];
        $po->ETD = $post['etd'];
        $po->SHIPPING = $post['shipping'];
        $po->BILLING = $post['billing'];
        $po->DELIVERY_COST = $post['delvCost'];
        $po->save();

        return $this->redirect([' ']);

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
					return $this->redirect(['create', 'kdpo'=>$kdpo]);
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
					return $this->redirect(['create', 'kdpo'=>$kdpo]);
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
		return $this->renderAjax('_form_ponote', [
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
	 * PDF | Purchaseorder| Purchasedetail
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
    public function actionCetakpdf($kdpo)
    {
		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
		//$poDetail = Purchasedetail::find()->where(['KD_PO'=>$kdpo])->all(); 
		$poDetailQry= "SELECT ID,KD_PO,KD_RO,KD_BARANG,NM_BARANG,UNIT,NM_UNIT,UNIT_QTY,UNIT_WIGHT,SUM(QTY) AS QTY,HARGA,STATUS,STATUS_DATE,NOTE
						FROM `p0002` WHERE KD_PO='" .$kdpo. "' GROUP BY KD_BARANG,NM_UNIT,HARGA";
		$poDetail=Purchasedetail::findBySql($poDetailQry)->all();		
        $dataProvider = new ArrayDataProvider([
			'key' => 'KD_PO',
			'allModels'=>$poDetail,		
			'pagination' => [
				'pageSize' => 20,
			],
		]);
		
		$content = $this->renderPartial( 'pdf', [
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

	
	/*
	 * TMP PDF | Purchaseorder| Purchasedetail
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
    public function actionTempCetakpdf($kdpo)
    {
		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
		//$poDetail = Purchasedetail::find()->where(['KD_PO'=>$kdpo])->all(); 
		$poDetailQry= "SELECT ID,KD_PO,KD_RO,KD_BARANG,NM_BARANG,UNIT,NM_UNIT,UNIT_QTY,UNIT_WIGHT,SUM(QTY) AS QTY,HARGA,STATUS,STATUS_DATE,NOTE
						FROM `p0002` WHERE KD_PO='" .$kdpo. "' GROUP BY KD_BARANG,NM_UNIT,HARGA";
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
	
    public function actionConfirm($kdpo)
    {        
       /*  $hsl = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
        if($hsl->APPROVE_BY == ''){
            $hsl->APPROVE_BY = Yii::$app->user->identity->EMP_ID;
            $hsl->APPROVE_AT = date('Y-m-d H:i:s');
            $hsl->STATUS = 102;
            $hsl->save();
    
            return $this->redirect(['view','kd'=>$kdpo]);

        } else {
            return $this->redirect(['view','kd'=>$kdpo]);
        } */
    }


    public function actionConfirmdir($kdpo)
    {        
        /* $hsl = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
        if($hsl->APPROVE_DIR == ''){
            $hsl->APPROVE_DIR = Yii::$app->user->identity->EMP_ID;
            $hsl->TGL_APPROVE = date('Y-m-d H:i:s');
            $hsl->STATUS = 1;
            $hsl->save();
    
            return $this->redirect(['view','kd'=>$kdpo]);

        } else {
            return $this->redirect(['view','kd'=>$kdpo]);
        } */
    }



    /**
     * Deletes an existing Purchaseorder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
