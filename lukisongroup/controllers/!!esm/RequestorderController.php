<?php

namespace lukisongroup\controllers\esm;

use Yii;
use lukisongroup\models\esm\ro\Requestorder;
use lukisongroup\models\esm\ro\RequestorderSearch;
use lukisongroup\models\esm\ro\Roatribute;
use lukisongroup\models\esm\ro\Requestorderstatus;

use lukisongroup\models\esm\ro\Rodetail;
use lukisongroup\models\esm\ro\RodetailSearch;
use lukisongroup\models\hrd\Employe;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use yii\db\Query;
use mPDF;

/**
 * RequestorderController implements the CRUD actions for Requestorder model.
 */
class RequestorderController extends Controller
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
     * Lists all Requestorder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RequestorderSearch();
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
    	$ro = new Requestorder();
		$reqro = Requestorder::find()->where(['KD_RO' => $kd])->one();
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
		
        $model = new Requestorder();
        $reqorder = new Roatribute();
        $rodetail = new Rodetail();
        $rostatus = new Requestorderstatus();
		
		$empId = Yii::$app->user->identity->EMP_ID;
		$dt = Employe::find()->where(['EMP_ID'=>$empId])->all();
		
//			------------ TAHUN.BULAN.TANGGAL.RO.NO URUT (4DIGIT)   == > 2015.06.30.RO.0001				
		$qwe = Requestorder::find()->select('ID')->orderBy(['ID' => SORT_DESC])->limit(1)->all();
		if(count($qwe) == 0){ $lastKd = 0; } else { $lastKd = $qwe[0]['ID']; }
		
		$nKD = $lastKd +1;
		$pnjg = strlen($nKD);
		if($pnjg == 1){ $kd = "000".$nKD; }
		else if($pnjg == 2){ $kd = "00".$nKD; }
		else if($pnjg == 3){ $kd = "0".$nKD; }
		else if($pnjg >= 4 ){ $kd = $nKD; }
		
		$kode = date('Y.m.d').'.RO.'.$kd;
		
		$model->KD_RO = $kode;
		$model->ID_USER = $empId;
		$model->KD_DEP = $dt[0]['DEP_ID'];
		$model->KD_CORP = $dt[0]['EMP_CORP_ID'];
		$model->CREATED_AT = date("Y-m-d H:i:s");
		
		$jab = $dt[0]['DEP_ID'];
		$que = "SELECT EMP_ID FROM a0001 WHERE (DEP_ID='GA' OR DEP_ID='$jab' ) AND (JAB_ID='MGR' OR JAB_ID='SVR') AND EMP_STS<>'3'";
		$modelss = $connection->createCommand($que);
		$users = $modelss->queryAll();

        if(count($users) != 0){
    		foreach($users as $usr){ 
                $isi[] = ['KD_RO'=>$kode,'ID_USER'=>$usr['EMP_ID'],'STATUS'=>'0'];
            }

            $model->save(); 
    		$cons->createCommand()->batchInsert( Requestorderstatus::tableName(), ['KD_RO', 'ID_USER', 'STATUS'], $isi )->execute();	
            return $this->redirect(['buatro','id'=>$kode]);
		}
        return $this->redirect([' ']);
	//	print_r(Yii::$app->user->identity);
    }
	
	public function actionBuatro()	
    {
        $model = new Requestorder();
        $reqorder = new Roatribute();
        $rodetail = new Rodetail();
		
		return $this->render('create', [
			'model' => $model,
			'reqorder' => $reqorder,
			'rodetail' => $rodetail,
		]);
    }
	
    public function actionSimpan($id)
    {
        $rodetail = new Rodetail();
		$hsl = $rodetail->load(Yii::$app->request->post());
		$rodetail->save();
		return $this->redirect(['buatro','id'=>$id]);
    }
	
    public function actionHapus($kode,$id)
    {
		new Rodetail();
		$ro = Rodetail::findOne($id);
		$ro->STATUS = 3;
		$ro->save();

       //$this->findModel($id)->delete();
		return $this->redirect(['buatro','id'=>$kode]);
    }

	public function actionProses($kd)
    {
		
		$empId = Yii::$app->user->identity->EMP_ID;
		$dt = Employe::find()->where(['EMP_ID'=>$empId])->all();
		if($dt[0]['JAB_ID'] != 'MGR'){ return $this->redirect(['esm/requestorder']); }

        $rostat = Requestorderstatus::find()->where(['KD_RO' => $kd,'ID_USER' => $empId])->one();
        if(count($rostat) == 0){
            return $this->redirect([' ']);
        }
		
    	$ro = new Requestorder();
		$reqro = Requestorder::find()->where(['KD_RO' => $kd])->one();
		$detro = $reqro->detro;
        $employ = $reqro->employe;
    	
		//$ro = new Requestorderstatus();
        $rostat->STATUS =  1;
		$rostat->save();

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
			$rodetail  = Rodetail::findOne($ts);
			$rodetail->STATUS = 1;
			if($rodetail->save()){
				$reqro = Requestorder::find()->where(['KD_RO' => $kd])->one();
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
            ->update('r0001', ['status'=>3], ['KD_RO'=>$id])
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
    	$ro = new Requestorder();
		$reqro = Requestorder::find()->where(['KD_RO' => $kd])->one();
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
        if (($model = Requestorder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
