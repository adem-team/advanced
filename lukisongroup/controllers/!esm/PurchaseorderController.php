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

    /**
     * Displays a single Purchaseorder model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
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
            $model->save();
        }
        return $this->redirect(['create', 'kdpo' => $model->KD_PO]);
    }

    public function actionSimpan()
    {
        $cons = \Yii::$app->db_esm;
		$tes = Yii::$app->request->post();
//		$ttl = count($tes['selection']);
        $kdpo = $tes['kdpo'];

        foreach ($tes['selection'] as $key => $isi) {
            $pp = explode('_',$isi);
            $rd = Rodetail::find()->where(['ID'=>$pp[1]])->one();
            $ckpo = Purchasedetail::find()->where(['KD_BARANG'=> $rd->KD_BARANG, 'KD_PO'=>$kdpo, 'UNIT'=>$rd->UNIT])->one();


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
                    'KD_RO'=> $pp[0], 
                    'ID_DET_RO'=> $pp[1],
                    'ID_DET_PO'=> $id,
                    'QTY'=> $rd->QTY, 
                    'UNIT'=> $rd->UNIT,
                    'STATUS'=>1,
                    ]
                )->execute();
            } else {
                $command = $cons->createCommand();
                $command->insert('p0021', [
                    'KD_PO'=> $kdpo, 
                    'KD_RO'=> $pp[0], 
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
        return $this->redirect(['create','kdpo'=>$kdpo]);
    }

    public function actionSpo($kdpo)
    {
//        echo $kdpo;
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



    public function actionCreate($kdpo)
    {
        $model = new Purchaseorder();

        $qq = Purchaseorder::find()->where(['KD_PO'=>$kdpo])->count();

        if($qq == 0){ return $this->redirect([' ']); }
        if($kdpo == ''){ return $this->redirect([' ']); }
        if($kdpo == null){ return $this->redirect([' ']); }


        $que = Requestorder::find()->where('STATUS <> 3 and STATUS <> 0')->all();

        $searchModel = new RequestorderSearch();
        $dataProvider = $searchModel->cari(Yii::$app->request->queryParams);

        $podet = Purchasedetail::find()->where(['KD_PO'=>$kdpo])->all();

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
	
public function actionDetail($kd_ro,$kdpo)
{
    /*
    $searchModel = new RodetailSearch([
        'KD_RO' => $kd_ro,  // Tambahkan ini
        'STATUS' => 1  // Tambahkan ini
    ]);
	*/
//    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 
    $podet = Rodetail::find()->where(['KD_RO'=>$kd_ro, 'STATUS'=>1])->all();
    return $this->renderAjax('_detail', [  // ubah ini
        'po' => $podet,
        'kdpo' => $kdpo,
        'kd_ro' => $kd_ro,
    ]);
}
    /**
     * Updates an existing Purchaseorder model.
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
