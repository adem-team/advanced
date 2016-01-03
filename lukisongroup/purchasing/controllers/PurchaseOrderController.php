<?php

namespace lukisongroup\purchasing\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
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


use lukisongroup\purchasing\models\ro\Requestorder;
use lukisongroup\purchasing\models\ro\RequestorderSearch;
use lukisongroup\purchasing\models\ro\Rodetail;
use lukisongroup\purchasing\models\ro\RodetailSearch;

use lukisongroup\purchasing\models\Statuspo;

use lukisongroup\esm\models\Barang;
use lukisongroup\master\models\Barangumum;


/**
 * PurchaseorderController implements the CRUD actions for Purchaseorder model.
 */
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

    
	/*
	 * Index Po | Purchaseorder| Purchasedetail
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
    public function actionIndex()
    {
        $searchModel = new PurchaseorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Purchaseorder();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
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
        $poDetail = Purchasedetail::find()->where(['KD_PO'=>$kd])->all(); 
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
	
	
    public function actionCreate($kdpo)
    {
        $model = new Purchaseorder();

        $poCnt = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->count();
		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
		$supplier = $poHeader->suplier;
		$bill = $poHeader->bill;
		$ship = $poHeader->ship;
		
		
        if($poCnt == 0){ return $this->redirect([' ']); }
        if($kdpo == ''){ return $this->redirect([' ']); }
        if($kdpo == null){ return $this->redirect([' ']); }


        $que = Requestorder::find()->where('STATUS <> 3 and STATUS <> 0')->all();

        $searchModel = new RequestorderSearch();
        $dataProvider = $searchModel->caripo(Yii::$app->request->queryParams);

        $poDetail = Purchasedetail::find()->where(['KD_PO'=>$kdpo])->andWhere('STATUS <> 3')->all();
		$poDetailProvider = new ArrayDataProvider([
			'key' => 'KD_PO',
			'allModels'=>$poDetail,		
			'pagination' => [
				'pageSize' => 20,
			],
		]);	

        //$quer = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();  
        return $this->render('create', [
            'model' => $model,
            'que' => $que,
            //'quer' => $quer,
            'podet' => $poDetail,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'poDetailProvider'=>$poDetailProvider,
			'poHeader'=> $poHeader,
			'supplier'=>$supplier,
			'bill' => $bill,
			'ship' => $ship
        ]);
    }   
	
	
    public function actionSimpanpo()
    {
        $model = new Purchaseorder();
        $model->load(Yii::$app->request->post());

        $kdpo = 'POB-'.date('ymdhis');
        $ck = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->count();  
        if($ck == 0){
            $model->KD_PO = $kdpo;
            $model->STATUS = '100';
            $model->CREATE_AT = date("Y-m-d H:i:s");
            $model->CREATE_BY = Yii::$app->user->identity->EMP_ID;
            $model->save();
        }
        return $this->redirect(['create', 'kdpo' => $model->KD_PO]);
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

    public function actionDetail($kd_ro,$kdpo)
    {
        $podet = Rodetail::find()->where(['KD_RO'=>$kd_ro, 'STATUS'=>101])->all();
        return $this->renderAjax('_detail', [  // ubah ini
            'po' => $podet,
            'kdpo' => $kdpo,
            'kd_ro' => $kd_ro,
        ]);
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
                $nmBrg = Barangumum::find('NM_BARANG')->where(['KD_BARANG'=>$kdBrg])->one();
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
	 * PDF | Purchaseorder| Purchasedetail
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
    public function actionCetakpdf($kdpo)
    {
		$poHeader = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();
        $poDetail = Purchasedetail::find()->where(['KD_PO'=>$kdpo])->all(); 
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
