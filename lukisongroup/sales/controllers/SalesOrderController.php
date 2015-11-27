<?php

namespace lukisongroup\sales\controllers;

use Yii;
use lukisongroup\sales\models\Salesorder;
use lukisongroup\sales\models\SalesorderSearch;
use lukisongroup\sales\models\Soatribute;
use lukisongroup\sales\models\Salesorderstatus;

use lukisongroup\sales\models\Sodetail;
use lukisongroup\sales\models\SodetailSearch;
use lukisongroup\hrd\models\Employe;


use lukisongroup\sales\models\Barang;
use lukisongroup\sales\models\Barangumum;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use yii\db\Query;
use mPDF;

/**
 * RequestorderController implements the CRUD actions for Requestorder model.
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
     * Lists all Requestorder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalesorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	
    /**
     * Displays a single Requestorder model.
     * @param string $id
     * @return mixed
     */
    public function actionView($kd)
    {
    	$ro = new Salesorder();
		$reqro = Salesorder::find()->where(['KD_RO' => $kd])->one();
		$detro = $reqro->detro;
        $employ = $reqro->employe;
    	
        return $this->render('view', [
            'reqro' => $reqro,
            'detro' => $detro,
            'employ' => $employ,
        ]);
        
    }
	
    /**
     * Creates a new Requestorder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   
    public function actionCreate()
    {
		$connection = \Yii::$app->db2;
		$cons = \Yii::$app->db_esm;
		
        $model = new Salesorder();
        $reqorder = new Soatribute();
        $rodetail = new Sodetail();
        $rostatus = new Salesorderstatus();
		
		$empId = Yii::$app->user->identity->EMP_ID;
		$dt = Employe::find()->where(['EMP_ID'=>$empId])->all();
		
//			------------ TAHUN.BULAN.TANGGAL.RO.NO URUT (4DIGIT)   == > 2015.06.30.RO.0001				
		$qwe = Salesorder::find()->select('ID')->orderBy(['ID' => SORT_DESC])->limit(1)->all();
		if(count($qwe) == 0){ $lastKd = 0; } else { $lastKd = $qwe[0]['ID']; }
		
		$nKD = $lastKd +1;
		$pnjg = strlen($nKD);
		if($pnjg == 1){ $kd = "000".$nKD; }
		else if($pnjg == 2){ $kd = "00".$nKD; }
		else if($pnjg == 3){ $kd = "0".$nKD; }
		else if($pnjg >= 4 ){ $kd = $nKD; }
		
		$kode = date('Y.m.d').'.SO.'.$kd;
		
		$model->KD_RO = $kode;
		$model->ID_USER = $empId;
		$model->KD_DEP = $dt[0]['DEP_ID'];
		$model->KD_CORP = $dt[0]['EMP_CORP_ID'];
		$model->CREATED_AT = date("Y-m-d H:i:s");
		

		$jab = $dt[0]['DEP_ID'];
        $que = "SELECT EMP_ID FROM a0001 WHERE (DEP_ID='$jab' ) AND (GF_ID='3') AND EMP_STS<>'3'";
        $modelss = $connection->createCommand($que);
        $users = $modelss->queryAll();

        if(count($users) != 0){
    		foreach($users as $usr){ 
                $isi[] = ['KD_RO'=>$kode,'ID_USER'=>$usr['EMP_ID'],'STATUS'=>'0'];
            }

            $model->save(); 
    		$cons->createCommand()->batchInsert( Salesorderstatus::tableName(), ['KD_RO', 'ID_USER', 'STATUS'], $isi )->execute();	
            return $this->redirect(['buatro','id'=>$kode]);
		}
		
        return $this->redirect([' ']);
	//	print_r(Yii::$app->user->identity);
    }
	
	public function actionBuatro()	
    {
        $model = new Salesorder();
        $reqorder = new Soatribute();
        $sodetail = new Sodetail();
		
		return $this->render('create', [
			'model' => $model,
			'reqorder' => $reqorder,
			'sodetail' => $sodetail,
		]);
    }
	
    public function actionSimpan($id)
    {
        $sodetail = new Sodetail();
		$hsl = Yii::$app->request->post();
        $created = $hsl['Sodetail']['CREATED_AT'];
        $nmBarang = $hsl['Sodetail']['NM_BARANG'];
        $kdRo = $hsl['Sodetail']['KD_RO'];
        $kdBarang = $hsl['Sodetail']['KD_BARANG'];
        $qty = $hsl['Sodetail']['QTY'];
        $note = $hsl['Sodetail']['NOTE'];

        $ck = Sodetail::find()->where(['KD_BARANG'=>$kdBarang, 'KD_RO'=>$kdRo])->andWhere('STATUS <> 3')->one();

        if(count($ck) == 1){
            \Yii::$app->getSession()->setFlash('error', '<br/><br/><p class="bg-danger" style="padding:15px"><b>Barang Sudah di Masukkan</b></p>');
            return $this->redirect(['buatro','id'=>$id]);
        } else {

            $kdBrg = $hsl['Sodetail']['KD_BARANG'];
            $ckBrg = explode('.', $kdBrg);
            if($ckBrg[0] == 'BRG'){
                $kdUnit = Barang::find('KD_UNIT')->where(['KD_BARANG'=>$kdBrg])->one();
            } else if($ckBrg[0] == 'BRGU') {
                $kdUnit = Barangumum::find('KD_UNIT')->where(['KD_BARANG'=>$kdBrg])->one();
            }

            $sodetail->UNIT = $kdUnit->KD_UNIT;
            $sodetail->CREATED_AT = $created;
            $sodetail->NM_BARANG = $nmBarang;
            $sodetail->KD_RO = $kdRo;
            $sodetail->KD_BARANG = $kdBarang;
            $sodetail->QTY = $qty;
            $sodetail->NOTE = $note;

    		$sodetail->save();

            \Yii::$app->getSession()->setFlash('error', '<br/><br/><p class="bg-success" style="padding:15px"><b>Barang berhasil di Masukkan</b></p>');
    		return $this->redirect(['buatro','id'=>$id]);
        }
    }
	
    public function actionHapus($kode,$id)
    {
		new Sodetail();
		$ro = Sodetail::findOne($id);
		$ro->STATUS = 3;
		$ro->save();

       //$this->findModel($id)->delete();
		return $this->redirect(['buatro','id'=>$kode]);
    }

	public function actionProses($kd)
    {
		
		$empId = Yii::$app->user->identity->EMP_ID;
		$dt = Employe::find()->where(['EMP_ID'=>$empId])->all();

		if($dt[0]['GF_ID'] != '3'){ return $this->redirect(['/purchasing/request-order/']); }

        $rostat = Salesorderstatus::find()->where(['KD_RO' => $kd,'ID_USER' => $empId])->one();

        if(count($rostat) == 1){
            $rostat->delete();
        }
		
    	$ro = new Salesorder();
		$reqro = Salesorder::find()->where(['KD_RO' => $kd])->one();
		$detro = $reqro->detro;
        $employ = $reqro->employe;
    	

        return $this->render('proses', [
            'reqro' => $reqro,
            'detro' => $detro,
            'employ' => $employ,
        ]);
    }
	
	public function actionSimpanproses()
    {
        //$rodetails = new Rodetail();
		$ts = Yii::$app->request->post();
		if(count($ts) == 0){ return $this->redirect([' ']); }
		$kd = $ts['kd'];
		
		foreach($ts['ck'] as $ts){
			$rodetail  = Sodetail::findOne($ts);
			$rodetail->STATUS = 1;
			if($rodetail->save()){
				$reqro = Salesorder::find()->where(['KD_RO' => $kd])->one();
				$reqro->STATUS = 1;
				$reqro->save();
			}
		}
		return $this->redirect(['proses', 'kd' => $kd]);
	
//		$rodetail->save();
    }
	
	/*
    public function actionSimpan()
    {
        $model = new Requestorder();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
*/
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
	
    public function actionHapusro($id)
    {
        \Yii::$app->db_esm->createCommand()
            ->update('s0001', ['status'=>3], ['KD_RO'=>$id])
            ->execute();

//		Rodetail::findModel($id)->delete();
//        $this->findModel($id)->delete();

		return $this->redirect(['index']);
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

	
	
	public function actionCetakpdf($kd){
    	$ro = new Salesorder();
		$reqro = Salesorder::find()->where(['KD_RO' => $kd])->one();
		$detro = $reqro->detro;
        $employ = $reqro->employe;
    	
		$mpdf=new mPDF();
		$mpdf->WriteHTML($this->renderPartial( 'pdfTester', [
            'reqro' => $reqro,
            'detro' => $detro,
            'employ' => $employ,
        ]));
        $mpdf->Output();
        exit;
		//return $this->renderPartial('mpdf');
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
        if (($model = Salesorder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
