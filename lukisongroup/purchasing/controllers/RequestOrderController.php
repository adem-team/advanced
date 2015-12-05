<?php

namespace lukisongroup\purchasing\controllers;

use yii;
use lukisongroup\purchasing\models\Requestorder;
use lukisongroup\purchasing\models\RequestorderSearch;
use lukisongroup\purchasing\models\Roatribute;
use lukisongroup\purchasing\models\Requestorderstatus;

use lukisongroup\purchasing\models\Rodetail;
use lukisongroup\purchasing\models\RodetailSearch;
use lukisongroup\hrd\models\Employe;


use lukisongroup\esm\models\Barang;
use lukisongroup\master\models\Barangumum;
use lukisongroup\master\models\Kategori;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

use yii\db\Query;
use mPDF;

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
        $searchModel = new RequestorderSearch();
		/*  if (isset($_GET['param'])){
			  $dataProvider = $searchModel->searchChildRo(Yii::$app->request->queryParams,$_GET['param']);
		}else{
			$dataProvider = $searchModel->searchChildRo(Yii::$app->request->queryParams);
		}  */
        
		//$searchModel->KD_RO ='2015.12.04.RO.0070';
		$dataProvider = $searchModel->searchRo(Yii::$app->request->queryParams);
		  return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
		$roDetail = new Rodetail();	
		$roHeader = new Requestorder();
            return $this->renderAjax('_form', [
                'roDetail' => $roDetail,
				'roHeader' => $roHeader,
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
				$kat_id = $parents[0];
				$model = Barangumum::find()->asArray()->where(['KD_KATEGORI'=>$kat_id])->all();
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
					$brgu = new Barangumum();
					$model = Barangumum::find()->where("KD_BARANG='". $brg_id. "'")->one();
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
						
				$cons = \Yii::$app->db_esm;				
				$roHeader = new Requestorder();				
				//$reqorder = new Roatribute();
				$roDetail = new Rodetail();
				$profile= Yii::$app->getUserOpt->Profile_user();
				
		if($roDetail->load(Yii::$app->request->post()) && $roDetail->validate()){		
				$hsl = \Yii::$app->request->post();				
				$kdUnit = $hsl['Rodetail']['UNIT'];
				$kdBarang = $hsl['Rodetail']['KD_BARANG'];
				$nmBarang = Barangumum::findOne(['KD_BARANG' => $kdBarang]);
				$rqty = $hsl['Rodetail']['RQTY'];
				$note = $hsl['Rodetail']['NOTE'];
				
				/*
				 * Detail Request Order
				**/
				$roDetail->KD_RO = \Yii::$app->ambilkonci->getRoCode();
				$roDetail->UNIT = $kdUnit;
				$roDetail->CREATED_AT = date('Y-m-d H:i:s');
				$roDetail->NM_BARANG = $nmBarang->NM_BARANG;
				$roDetail->KD_BARANG = $kdBarang;
				$roDetail->RQTY = $rqty;
				$roDetail->NOTE = $note;
				$roDetail->STATUS = 0;
				
				/*
				 * Header Request Order
				**/
				$getkdro=\Yii::$app->ambilkonci->getRoCode();
				$roHeader->KD_RO =$getkdro;
				$roHeader->CREATED_AT = date('Y-m-d H:i:s');
				$roHeader->TGL = date('Y-m-d H:i:s');
				$roHeader->ID_USER = $profile->emp->EMP_ID;
				$roHeader->EMP_NM = $profile->emp->EMP_NM .' ' .$profile->emp->EMP_NM_BLK;
				$roHeader->KD_CORP = $profile->emp->EMP_CORP_ID;
				$roHeader->KD_DEP = $profile->emp->DEP_ID;
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
							/* return $this->render('index', [
								'searchModel' => $searchModel,
								'dataProvider' => $dataProvider,
							]); */
					} catch (Exception $ex) {
						$transaction->rollback();
						return false;						   
					}
					//return $this->redirect(['index','param'=>$getkdro]);			
					return $this->redirect(['index?RequestorderSearch[KD_RO]='.$getkdro]);
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
			$nmBarang = Barangumum::findOne(['KD_BARANG' => $kdBarang]);
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
     * View Requestorder
     * @param string $id
     * @return mixed
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
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
     * Cetak PDF
     * @param string $id
     * @return mixed
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
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
     * Hapus Ro
     * @param string $id
     * @return mixed
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionHapus($kode,$id)
    {
		new Rodetail();
		$ro = Rodetail::findOne($id);
		$ro->STATUS = 3;
		$ro->save();

       //$this->findModel($id)->delete();
		return $this->redirect(['buatro','id'=>$kode]);
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
	
	
	/**
     * Prosess Persetujuan Manager
     * @param string $id
     * @return mixed
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionProses($kd)
    {
		
		$empId = Yii::$app->user->identity->EMP_ID;
		$dt = Employe::find()->where(['EMP_ID'=>$empId])->all();

		if($dt[0]['GF_ID'] != '3'){ return $this->redirect(['/purchasing/request-order/']); }

        $rostat = Requestorderstatus::find()->where(['KD_RO' => $kd,'ID_USER' => $empId])->one();

        if(count($rostat) == 1){
            $rostat->delete();
        }
		
    	$ro = new Requestorder();
		$reqro = Requestorder::find()->where(['KD_RO' => $kd])->one();
		$detro = $reqro->detro;
        $employ = $reqro->employe;
    	

        return $this->render('proses', [
            'reqro' => $reqro,
            'detro' => $detro,
            'employ' => $employ,
        ]);
    }
	
	
	/**
     * Prosess Agree Manager
     * @param string $id
     * @return mixed
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
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
	
		//$rodetail->save();
    }
	
	
				
    /* public function actionSimpan($id)
    {
        $rodetail = new Rodetail();
		$hsl = Yii::$app->request->post();

        $created = $hsl['Rodetail']['CREATED_AT'];
        $nmBarang = $hsl['Rodetail']['NM_BARANG'];
        $kdRo = $hsl['Rodetail']['KD_RO'];
        $kdBarang = $hsl['Rodetail']['KD_BARANG'];
        $qty = $hsl['Rodetail']['QTY'];
        $note = $hsl['Rodetail']['NOTE'];

        $ck = Rodetail::find()->where(['KD_BARANG'=>$kdBarang, 'KD_RO'=>$kdRo])->andWhere('STATUS <> 3')->one();

        if(count($ck) == 1){
            \Yii::$app->getSession()->setFlash('error', '<br/><br/><p class="bg-danger" style="padding:15px"><b>Barang Sudah di Masukkan</b></p>');
            return $this->redirect(['buatro','id'=>$id]);
        } else {

            $kdBrg = $hsl['Rodetail']['KD_BARANG'];
            $ckBrg = explode('.', $kdBrg);
            if($ckBrg[0] == 'BRG'){
                $kdUnit = Barang::find('KD_UNIT')->where(['KD_BARANG'=>$kdBrg])->one();
            } else if($ckBrg[0] == 'BRGU') {
                $kdUnit = Barangumum::find('KD_UNIT')->where(['KD_BARANG'=>$kdBrg])->one();
            }

            $rodetail->UNIT = $kdUnit->KD_UNIT;
            $rodetail->CREATED_AT = $created;
            $rodetail->NM_BARANG = $nmBarang;
            $rodetail->KD_RO = $kdRo;
            $rodetail->KD_BARANG = $kdBarang;
            $rodetail->QTY = $qty;
            $rodetail->NOTE = $note;

    		$rodetail->save();

            \Yii::$app->getSession()->setFlash('error', '<br/><br/><p class="bg-success" style="padding:15px"><b>Barang berhasil di Masukkan</b></p>');
    		return $this->redirect(['buatro','id'=>$id]);
        }
    } */
	
    

	
	
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
