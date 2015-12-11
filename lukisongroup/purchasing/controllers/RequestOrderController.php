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
use lukisongroup\assets\AppAssetJquerySignature_1_1_2;
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
    	
		
		$svgTest='
		<svg xmlns="http://www.w3.org/2000/svg" width="5cm" height="3cm">
			<g fill="#ffffff">
				
				<g fill="none" stroke="#000000" stroke-width="2">
					<polyline points="9,77.13 9,76.13 9,75.13 10,73.13 12,71.13 15,67.13 17,63.13 20,57.13 23,51.13 28,45.13 35,40.13 46,34.13 56,29.13 69,24.13 80,20.13 85,18.13 88,17.13 89,17.13 90,17.13 91,19.13 91,22.13 91,24.13 91,25.13 91,26.13 91,29.13 87,34.13 82,37.13 75,39.13 70,42.13 66,42.13 63,44.13 60,44.13 58,44.13 56,43.13 52,41.13 48,38.13 46,37.13 45,36.13 43,35.13 42,34.13 41,33.13 40,33.13 39,33.13 38,33.13"></polyline>
					<polyline points="30,19.13 29,20.13 26,24.13 24,27.13 23,29.13 23,32.13 23,35.13 24,38.13 27,42.13 29,45.13 32,49.13 38,52.13 46,55.13 56,59.13 60,59.13 70,60.13 82,60.13 91,60.13 99,59.13 104,57.13 107,56.13 109,55.13 110,55.13 111,54.13 111,53.13"></polyline>
					<polyline points="116,37.13 113,37.13 107,37.13 101,37.13 98,40.13 94,44.13 92,46.13 91,49.13 90,51.13 90,53.13 90,55.13 91,56.13 92,58.13 95,61.13 97,63.13 99,64.13 101,65.13 104,65.13 108,65.13 112,65.13 120,63.13 128,59.13 136,55.13 139,52.13 142,48.13 143,42.13 144,38.13 144,35.13 144,34.13 144,35.13 143,39.13 139,47.13 136,56.13 135,63.13 135,69.13 134,73.13 134,74.13 134,75.13 134,73.13 134,67.13 136,58.13 140,49.13 143,43.13 145,37.13 147,35.13 148,33.13 149,32.13 151,32.13 152,32.13 152,33.13 153,34.13 153,37.13 153,40.13 149,44.13 144,47.13 138,49.13 140,49.13 143,49.13 146,49.13 150,49.13 153,49.13 154,49.13"></polyline>
					<polyline points="159,43.13 159,45.13 159,47.13 159,49.13 159,51.13 159,53.13 159,54.13 159,55.13 159,53.13 159,51.13 160,46.13 161,45.13 161,43.13 162,42.13 164,42.13 165,44.13 167,45.13 168,47.13 169,48.13 169,49.13 171,49.13 172,49.13 173,49.13 177,47.13 180,44.13 181,43.13 182,42.13 182,41.13"></polyline>
					<polyline points="193,50.13 193,51.13 193,53.13 193,54.13 193,55.13 193,56.13 193,58.13 195,59.13 196,61.13 197,61.13 198,61.13 199,61.13 200,61.13 201,61.13 203,58.13 204,56.13 204,54.13 204,51.13 204,50.13 204,49.13 204,48.13 204,47.13 203,46.13 201,46.13 197,46.13 195,46.13 188,46.13 182,46.13 180,46.13 177,46.13 176,47.13 176,48.13 177,49.13 178,50.13 178,51.13 179,52.13 180,52.13 181,53.13 182,53.13 186,53.13 191,53.13 195,53.13 199,53.13 201,53.13 202,53.13 203,53.13 204,53.13 205,53.13 206,53.13 209,53.13 212,53.13 213,53.13 214,53.13 215,52.13 216,51.13 217,50.13 218,49.13 218,48.13 218,49.13 218,51.13 218,54.13 219,57.13 219,58.13 220,59.13 220,60.13 221,60.13 222,60.13 223,60.13 226,60.13 227,59.13 229,57.13 230,56.13 232,54.13 234,51.13 235,49.13 237,47.13 239,46.13 239,45.13"></polyline>
				</g>
			</g>
		</svg>		
		';
		
		
		
		
		
		
		
		
		$mpdf=new mPDF();
		$mpdf->WriteHTML($this->renderPartial( 'pdfTester', [
            'reqro' => $reqro,
            'detro' => $detro,
            'employ' => $employ,
			'svgTest'=> $svgTest,
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
