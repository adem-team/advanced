<?php

namespace lukisongroup\purchasing\controllers;

use yii;
use yii\web\Request;
use yii\db\Query;
//use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use lukisongroup\purchasing\models\sa\Salesorder;
use lukisongroup\purchasing\models\sa\SalesorderSearch;

use lukisongroup\purchasing\models\sa\Sadetail;
use lukisongroup\purchasing\models\sa\SadetailSearch;


use lukisongroup\purchasing\models\sa\LoginForm;
use lukisongroup\purchasing\models\sa\AdditemValidation;

use lukisongroup\hrd\models\Employe;
use lukisongroup\esm\models\Barang;
use lukisongroup\master\models\Kategori;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\Pjax;



use kartik\mpdf\Pdf;
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
		$searchModel = new SalesorderSearch();
		/*  if (isset($_GET['param'])){
			  $dataProvider = $searchModel->searchChildRo(Yii::$app->request->queryParams,$_GET['param']);
		}else{
			$dataProvider = $searchModel->searchChildRo(Yii::$app->request->queryParams);
		}  */
        
		//$searchModel->KD_SA ='2015.12.04.RO.0070';
		$dataProvider = $searchModel->searchSa(Yii::$app->request->queryParams);
		  return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
		$Detailsa = new Sadetail();	
		$saHeader = new Salesorder();
            return $this->renderAjax('_form', [
                'Detailsa' => $Detailsa,
				'saHeader' => $saHeader,
            ]);	
		
    }
	
	/**
     * Edit Form - Add Item Barang | Tambah Barang
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */   
    public function actionAdditem($kd)
    {
			//$Detailsa = new Sadetail();
			$Detailsa = new AdditemValidation();
			$saHeader = Salesorder::find()->where(['KD_SA' => $kd])->one();		
			$detsa = $saHeader->detsa;
			$employ = $saHeader->employe;
			$dept = $saHeader->dept;
			
			/*
			 * Convert $saHeader->detsa to ArrayDataProvider | Identity 'key' => 'ID',
			 * @author ptrnov  <piter@lukison.com>
			 * @since 1.1    
			**/
			 $detsaProvider = new ArrayDataProvider([
				'key' => 'ID',
				'allModels'=>$detsa,			
				'pagination' => [
					'pageSize' => 10,
				],
			]);
			
			return $this->renderAjax('additem', [         
				'saHeader' => $saHeader, 
				'Detailsa' => $Sadetail,			
				'dataProvider'=>$detsaProvider,
			]); 
			
    }
	/**
     * Add Item Barang to SAVED | AJAX
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionAdditem_saved(){
		//$Detailsa = new Sadetail();	
		$Detailsa = new AdditemValidation();
		
		if(Yii::$app->request->isAjax){
			$Detailsa->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($Detailsa));
		}else{
			if($Detailsa->load(Yii::$app->request->post())){
				if($Detailsa->additem_saved()){
					$hsl = \Yii::$app->request->post();	
					$kdro = $hsl['AdditemValidation']['kD_RO'];					
					return $this->redirect(['/purchasing/sales-order/edit?kd='.$kdro]);
				}
				//Request Result
			/*	$hsl = \Yii::$app->request->post();
				$kdRo = $hsl['Sadetail']['KD_SA'];
				$kdBarang = $hsl['Sadetail']['KD_BARANG'];
				$nmBarang = Barang::findOne(['KD_BARANG' => $kdBarang]);
				$kdUnit = $hsl['Sadetail']['UNIT'];
				$rqty = $hsl['Sadetail']['RQTY'];			
				$note = $hsl['Sadetail']['NOTE'];
				
					//Request Put
					$Detailsa->CREATED_AT = date('Y-m-d H:i:s');
					$Detailsa->KD_SA = $kdRo;
					$Detailsa->KD_BARANG = $kdBarang;
					$Detailsa->NM_BARANG = $nmBarang->NM_BARANG;
					$Detailsa->UNIT = $kdUnit;			
					$Detailsa->RQTY = $rqty;
					$Detailsa->NOTE = $note;
					$Detailsa->STATUS = 0;
					$Detailsa->save();				
				return $this->redirect(['/purchasing/sales-order/edit?kd='.$kdRo]);*/
			} 
		}
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
	 * First Create RO |  Salesorder | Sadetail
	 * Add: component Yii::$app->getUserOpt->Profile_user()
	 * Add: component \Yii::$app->ambilkonci->getRoCode();
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
	**/
	public function actionSimpanfirst(){				
						
				$cons = \Yii::$app->db_esm;				
				$saHeader = new Salesorder();				
				//$reqorder = new Roatribute();
				$Detailsa = new Sadetail();
				$profile= Yii::$app->getUserOpt->Profile_user();
				
				//if($Detailsa->load(Yii::$app->request->post()) && $Detailsa->validate()){		
			if($Detailsa->load(Yii::$app->request->post())){		
				$hsl = \Yii::$app->request->post();				
				$kdUnit = $hsl['Sadetail']['UNIT'];
				$kdBarang = $hsl['Sadetail']['KD_BARANG'];
				$nmBarang = Barang::findOne(['KD_BARANG' => $kdBarang]);
				$rqty = $hsl['Sadetail']['RQTY'];
				$note = $hsl['Sadetail']['NOTE'];
				
				/*
				 * Detail Request Order
				**/
				$Detailsa->KD_SA = \Yii::$app->ambilkonci->getRoCode();
				$Detailsa->UNIT = $kdUnit;
				$Detailsa->CREATED_AT = date('Y-m-d H:i:s');
				$Detailsa->NM_BARANG = $nmBarang->NM_BARANG;
				$Detailsa->KD_BARANG = $kdBarang;
				$Detailsa->RQTY = $rqty;
				$Detailsa->NOTE = $note;
				$Detailsa->STATUS = 0;
				
				/*
				 * Header Request Order
				**/
				$getkdro=\Yii::$app->ambilkonci->getRoCode();
				$saHeader->KD_SA =$getkdro;
				$saHeader->CREATED_AT = date('Y-m-d H:i:s');
				$saHeader->TGL = date('Y-m-d');
				$saHeader->ID_USER = $profile->emp->EMP_ID;
				$saHeader->EMP_NM = $profile->emp->EMP_NM .' ' .$profile->emp->EMP_NM_BLK;
				$saHeader->KD_CORP = $profile->emp->EMP_CORP_ID;
				$saHeader->KD_DEP = $profile->emp->DEP_ID;
				$saHeader->SIG1_SVGBASE64 = $profile->emp->SIGSVGBASE64;
				$saHeader->SIG1_SVGBASE30 = $profile->emp->SIGSVGBASE30;
				$saHeader->STATUS = 0;
					$transaction = $cons->beginTransaction();
					try {
						if (!$Detailsa->save()) {
								$transaction->rollback();
								return false;
						}
						
						if (!$saHeader->save()) {
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
					//return $this->redirect(['index?SalesorderSearch[KD_SA]='.$getkdro]);
					return $this->redirect(['/purchasing/sales-order/view?kd='.$getkdro]);
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
		$searchModel = new SadetailSearch();
        $dataProvider = $searchModel->searchChildRo(Yii::$app->request->queryParams,$kd);
		$saHeader = Salesorder::find()->where(['KD_SA' => $kd])->one();
		$Detailsa = new Sadetail();	
            return $this->renderAjax('_update', [                
						'saHeader' => $saHeader,
						'Detailsa' => $Sadetail,
						'detsa' => $saHeader->detsa,						
						'searchModel'=>$searchModel,
						'dataProvider'=>$dataProvider
					]);			
    }	
	
	/*
	 * actionSimpansecondt() <- actionTambah($kd)
	 * First Create RO |Sadetail
	 * Add: component Yii::$app->getUserOpt->Profile_user()
	 * Add: component \Yii::$app->ambilkonci->getRoCode();
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
	**/
	public function actionSimpantambah(){
		$Detailsa = new Sadetail();
		if($Detailsa->load(Yii::$app->request->post()) && $Detailsa->validate()){
			$hsl = \Yii::$app->request->post();	
			$kdro = $hsl['Sadetail']['KD_SA'];				
			$kdBarang = $hsl['Sadetail']['KD_BARANG'];
			$nmBarang = Barang::findOne(['KD_BARANG' => $kdBarang]);
			$kdUnit = $hsl['Sadetail']['UNIT'];
			$rqty = $hsl['Sadetail']['RQTY'];
			$note = $hsl['Sadetail']['NOTE'];
			
			/*
			 * Detail Request Order
			**/
			$Detailsa->KD_SA = $kdro;
			$Detailsa->CREATED_AT = date('Y-m-d H:i:s');				
			$Detailsa->NM_BARANG = $nmBarang->NM_BARANG;
			$Detailsa->KD_BARANG = $kdBarang;
			$Detailsa->UNIT = $kdUnit;
			$Detailsa->RQTY = $rqty;
			$Detailsa->NOTE = $note;
			$Detailsa->STATUS = 0;
			$Detailsa->save();
			
			return $this->redirect(['index?SalesorderSearch[KD_SA]='.$kdro]);
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
		$saHeader = Salesorder::find()->where(['KD_SA' => $kd])->one();
		if(count($saHeader['KD_SA'])<>0){
			$detsa = $saHeader->detsa;
			$employ = $saHeader->employe;
			$dept = $saHeader->dept;
			
			/*
			 * Convert $saHeader->detsa to ArrayDataProvider | Identity 'key' => 'ID',
			 * @author ptrnov  <piter@lukison.com>
			 * @since 1.1    
			**/
			$detsaProvider = new ArrayDataProvider([
				'key' => 'ID',
				'allModels'=>$detsa,			
				'pagination' => [
					'pageSize' => 10,
				],
			]);
			
			return $this->render('view', [
				'saHeader' => $saHeader,
				'detsa' => $detsa,
				'employ' => $employ,
				'dept' => $dept,
				'dataProvider'=>$detsaProvider,
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
		$saHeader = Salesorder::find()->where(['KD_SA' =>$kd])->one();
		if(count($saHeader['KD_SA'])<>0){
			$detsa = $saHeader->detsa;
			$employ = $saHeader->employe;
			$dept = $saHeader->dept;
			
			/*
			 * Convert $saHeader->detsa to ArrayDataProvider | Identity 'key' => 'ID',
			 * @author ptrnov  <piter@lukison.com>
			 * @since 1.1    
			**/
			$detsaProvider = new ArrayDataProvider([
				'key' => 'ID',
				'allModels'=>$detsa,			
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
				$model = Sadetail::findOne($id);
				$out = Json::encode(['output'=>'', 'message'=>'']);
				$post = [];
				$posted = current($_POST['Sadetail']);
				$post['Sadetail'] = $posted;
				if ($model->load($post)) {
					$model->save();
					$output = '';
					if (isset($posted['RQTY'])) {
						$output = $model->RQTY;
					}
					if (isset($posted['SQTY'])) {
						$output = $model->SQTY;
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
			return $this->render('edit', [
				'saHeader' => $saHeader,
				'detsa' => $detsa,
				'employ' => $employ,
				'dept' => $dept,
				'dataProvider'=>$detsaProvider,
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
    	$saHeader = Salesorder::find()->where(['KD_SA' => $kd])->one(); /*Noted check by status approval =1 header table | chek error record jika kosong*/
		$detsa = $saHeader->detsa;
        $employ = $saHeader->employe;
		$dept = $saHeader->dept;
		if ($v==101){
			$filterPdf="KD_SA='".$kd."' AND (STATUS='101' OR STATUS='10')";
		}elseif($v!=101){
			$filterPdf="KD_SA='".$kd."' AND STATUS<>'3'";
		}
		$Detailsa = Sadetail::find()->where($filterPdf)->all();
		
		/* PR Filter Status Output to Grid print*/
		$dataProvider = new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$Detailsa,//$detsa,			
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
            'saHeader' => $saHeader,
            'detsa' => $detsa,
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
	 * Approved_Sadetail | Sadetail->ID |  $Detailsa->STATUS = 101;
	 * Approved = 101
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionApproved_sadetail()
    {
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			//\Yii::$app->response->format = Response::FORMAT_JSON;
			$Detailsa = Sadetail::findOne($id);
			$Detailsa->STATUS = 101;
			//$ro->NM_BARANG=''
			$Detailsa->save();
			return true;
		}
   }
	
	/**
	 * On Approval View
	 * Reject_Sadetail | Sadetail->ID |  $Sadetail->STATUS = 4;
	 * Reject = 4
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionReject_sadetail()
    {
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			$Detailsa = Sadetail::findOne($id);
			$Detailsa->STATUS = 4;
			$Detailsa->save();
			return true;
		}
     }
	
	/**
	 * On Approval View
	 * Canclet_Sadetail | Sadetail->ID |  $Sadetail->STATUS = 4;
	 * Cancel = 0
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionCancel_sadetail()
    {
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			$Detailsa = Sadetail::findOne($id);
			$Detailsa->STATUS = 0;
			$Detailsa->save();
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
		new Sadetail();
		$ro = Sadetail::findOne($id);
		$ro->STATUS = 3;
		$ro->save();

       //$this->findModel($id)->delete();
		return $this->redirect(['buatro','id'=>$kode]);
    }
	
	/**
     * Action Prosess Approval Colomn Row
     * @param string $id
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionApproved($kd)
    {
		/*
		 * Init Models
		 * @author ptrnov  <piter@lukison.com>
		 * @since 1.1    
		**/
		//$ro = new Salesorder();
		$saHeader = Salesorder::find()->where(['KD_SA' =>$kd])->one();
		$detsa = $saHeader->detsa;
		$employ = $saHeader->employe;
		$dept = $saHeader->dept;
		
		/*
		 * Convert $saHeader->detsa to ArrayDataProvider | Identity 'key' => 'ID',
		 * @author ptrnov  <piter@lukison.com>
		 * @since 1.1    
		**/
		$detsaProvider = new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$detsa,			
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
            $model = Sadetail::findOne($id);
			$out = Json::encode(['output'=>'', 'message'=>'']);
            $post = [];
            $posted = current($_POST['Sadetail']);
            $post['Sadetail'] = $posted;
            if ($model->load($post)) {
                $model->save();
				$output = '';
                if (isset($posted['RQTY'])) {
                    $output = $model->RQTY;
                }
				if (isset($posted['SQTY'])) {
					$output = $model->SQTY;
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
		return $this->render('approved', [
            'saHeader' => $saHeader,
            'detsa' => $detsa,
            'employ' => $employ,
			'dept' => $dept,
			'dataProvider'=>$detsaProvider,
        ]);		
		
    }
	
	public function actionApproved_authorize($kd){		
		$saFormlogin = new LoginForm();					
		$saHeader = Salesorder::find()->where(['KD_SA' =>$kd])->one();
		$employe = $saHeader->employe;			
			return $this->renderAjax('login_signature', [
				'saHeader' => $saHeader,
				'employe' => $employe,
				'saFormlogin' => $saFormlogin,
			]);
	}
	
	/*
	 * Sign Approval Status = 101
	 * Class Model Salesorder->Status = 101 [Approvad]
	 * Class Model Sadetail->Status 	= 101 [Approvad]
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1    
	**/
	//public function actionApproved_sign(){
	public function actionApprovedAuthorizeSave(){
		$saFormlogin = new LoginForm();		
		/*Ajax Load*/
		if(Yii::$app->request->isAjax){
			$saFormlogin->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($saFormlogin));
		}else{	/*Normal Load*/	
			if($saFormlogin->load(Yii::$app->request->post())){
				if ($saFormlogin->loginformsa_saved()){
					$hsl = \Yii::$app->request->post();
					$kdro = $hsl['LoginForm']['kdro'];
					return $this->redirect(['/purchasing/sales-order/approved','kd'=>$kdro]);
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
		$model =Salesorder::find()->where(['KD_SA' =>$kd])->one();
		$model->STATUS=3;
		$model->save();
		
		$model =Sadetail::find()->where(['KD_SA' =>$kd])->one();
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
