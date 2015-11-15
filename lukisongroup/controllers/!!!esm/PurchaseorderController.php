<?php

namespace lukisongroup\controllers\esm;

use Yii;
use lukisongroup\models\esm\po\Purchaseorder;
use lukisongroup\models\esm\po\PurchaseorderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use lukisongroup\models\esm\po\Purchasedetail;
use lukisongroup\models\esm\po\Podetail;

use lukisongroup\models\esm\ro\Requestorder;
use lukisongroup\models\esm\ro\RequestorderSearch;
use lukisongroup\models\esm\ro\Rodetail;
use lukisongroup\models\esm\ro\RodetailSearch;

use lukisongroup\models\esm\po\Statuspo;

use lukisongroup\models\esm\Barang;
use lukisongroup\models\master\Barangumum;

use mPDF;
/**
 * PurchaseorderController implements the CRUD actions for Purchaseorder model.
 */
class PurchaseorderController extends Controller
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
     * Lists all Purchaseorder models.
     * @return mixed
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

    public function actionView($kd)
    {
        return $this->render('view', [
            'model' => Purchaseorder::find()->where(['KD_PO'=>$kd])->one(),
        ]);
    }
	
    public function actionCreate($kdpo)
    {
        $model = new Purchaseorder();

        $qq = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->count();

        if($qq == 0){ return $this->redirect([' ']); }
        if($kdpo == ''){ return $this->redirect([' ']); }
        if($kdpo == null){ return $this->redirect([' ']); }


        $que = Requestorder::find()->where('STATUS <> 3 and STATUS <> 0')->all();

        $searchModel = new RequestorderSearch();
        $dataProvider = $searchModel->caripo(Yii::$app->request->queryParams);

        $podet = Purchasedetail::find()->where(['KD_PO'=>$kdpo])->andWhere('STATUS <> 3')->all();

        $quer = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one();  
        return $this->render('create', [
            'model' => $model,
            'que' => $que,
            'quer' => $quer,
            'podet' => $podet,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
            $model->CREATE_BY = Yii::$app->user->identity->username;
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
                    'QTY'=> $rd->QTY, 
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
                    'QTY'=> $rd->QTY, 
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
                        'QTY'=> $rd->QTY, 
                        'UNIT'=> $rd->UNIT,
                        'STATUS'=>1,
                        ]
                    )->execute();
                    
                    $ttl = $rd->QTY + $ckpo->QTY;
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
            $qty = $post['qty'][$a];
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
        $podet = Rodetail::find()->where(['KD_RO'=>$kd_ro, 'STATUS'=>1])->all();
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

    public function actionCetakpdf($kdpo)
    {
        $mpdf=new mPDF();
        $mpdf->WriteHTML($this->renderPartial( 'pdf', [
            'model' => Purchaseorder::find()->where(['KD_PO'=>$kdpo])->one(),
        ]));
        $mpdf->Output();
        exit;
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
