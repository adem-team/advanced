<?php

namespace lukisongroup\purchasing\controllers;

use yii;
use yii\web\Request;
use yii\db\Query;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\mpdf\Pdf;
use zyx\phpmailer\Mailer;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use yii\widgets\ActiveForm;

use lukisongroup\purchasing\models\salesmanorder\SoHeaderSearch;
use lukisongroup\purchasing\models\salesmanorder\SoDetailSearch;
use lukisongroup\purchasing\models\salesmanorder\SoT2;
use lukisongroup\purchasing\models\salesmanorder\SoHeader;
use lukisongroup\master\models\Barang;


/**
 * CUSTOMER - SALESMAN ORDER 
 * @author ptrnov [piter@lukison.com]
 * @since 1.2
 *
*/
class SalesmanOrderController extends Controller
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

   /**
     * Index
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
    public function actionIndex()
    {		
		$searchModelHeader = new SoHeaderSearch();
		$dataProvider = $searchModelHeader->searchHeader(Yii::$app->request->queryParams);		
		return $this->render('index', [
			'apSoHeaderInbox'=>$dataProvider,
			'apSoHeaderOutbox'=>$dataProvider,
			'apSoHeaderHistory'=>$dataProvider
        ]);

    }  


    public function get_aryBarang()
    {
		$sql = Barang::find()->where('KD_CORP="ESM" AND PARENT= 1 AND STATUS<>3')->all();
		return ArrayHelper::map($sql,function ($sql, $defaultValue) {
			return $sql->KD_BARANG . ',' . $sql->NM_BARANG; 
		},'NM_BARANG');
    }


    public function actionValidAliasBarang()
    {
		$model = new SoT2();
		$model->scenario = "create";
		if(Yii::$app->request->isAjax && $model->load($_POST))
		{
			Yii::$app->response->format = 'json';
			return ActiveForm::validate($model);
		}
    }


    public function actionCreateNewAdd($cust_kd,$user_id,$id,$cust_nm,$tgl)
    {
      $model = new SoT2();
      # code...
      if ($model->load(Yii::$app->request->post()) ) {
      	  $explode = explode(',', $model->KD_BARANG);
      	  $model->NM_BARANG = $explode[1];
      	  $model->KD_BARANG = $explode[0];
          $model->CUST_KD = $cust_kd; # set cust_kd
          $model->USER_ID = $user_id;
          $model->CUST_NM = $cust_nm;
          $model->KODE_REF = $id;
          $model->SO_TYPE = 10;
          $model->POS ='WEB';
          $model->WAKTU_INPUT_INVENTORY =  date("Y-m-d H:i:s"); #set datetime
          $model->TGL =  $tgl; #set date
          $model->save();
          return $this->redirect(['/purchasing/salesman-order/review','id'=>$id,'stt'=>1]); ;
      }else {
        return $this->renderAjax('new_som', [
            'model' => $model,
            'data_barang' => self::get_aryBarang(), #array barang
            'kode_som'=>$id
        ]);
      }
    }

	/**
     * Action REVIEW | Prosess Checked and Approval
     * @param string $id
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionReview($id,$stt)
    {		
		if ($stt==0){
			//CREATE KODE_REF
			$modelSoT2 = SoT2::find()->where("ID='".$id."' AND SO_TYPE=10")->one();
			$getSoType=10;
			$getTGL=$modelSoT2->TGL;
			$setTGL=$modelSoT2->WAKTU_INPUT_INVENTORY;
			$getCUST_KD=$modelSoT2->CUST_KD;
			$getUSER_ID=$modelSoT2->USER_ID;
		
			$connect = Yii::$app->db_esm;
			$kode = Yii::$app->ambilkonci->getSMO();
			$transaction = $connect->beginTransaction();
			try {		
				//SO HEADER
				$connect->createCommand()->insert('so_0001', 
						[
							'KD_SO'=>$kode,
							'TGL' =>$setTGL,
							'USER_SIGN1' =>$getUSER_ID,
						])->execute();
				//SO DETAIL -  STOCK
				$connect->createCommand()->update('so_t2', 
						['KODE_REF'=>$kode], 
						[
							'SO_TYPE'=>$getSoType,
							'TGL'=>$getTGL,
							'CUST_KD'=>$getCUST_KD,
							'USER_ID'=>$getUSER_ID
						])->execute();
				//STATUS PROCESS
				$connect->createCommand()->insert('so_0002', 
						[
							'KD_SO'=>$kode,
							'ID_USER' =>$getUSER_ID,
							'STT_PROCESS' =>'0',
						])->execute();						
				// ...other DB operations...
				$transaction->commit();
			} catch(\Exception $e) {
				$transaction->rollBack();
				throw $e;
			}
            $this->redirect(['/purchasing/salesman-order/review','id'=>$kode,'stt'=>1]);      	
		    //PR create Generate Code dari komponent. Tabel so_0001.
			//Save kode generate  Tabel so_0001.
			//Update SoT2 KODE_REF where ($getSoType,getTGL,getCUST_KD,getUSER_ID).
			//Editing editable : SUBMIT_QTY,SUBMIT_PRICE
		}else{
			//VIEW KODE_REF
			$modelSoT2 = SoT2::find()->with('cust')->where("KODE_REF='".$id."' AND SO_TYPE=10")->one();	
			$soHeaderData = SoHeader::find()->where(['KD_SO'=>$id])->one(); 		
			$getSoType=10;
			$getTGL=$modelSoT2->TGL;
			$getCUST_KD=$modelSoT2->CUST_KD;
			$getUSER_ID=$modelSoT2->USER_ID;
			
			$searchModelDetail= new SoDetailSearch([
				// 'TGL'=>$getTGL,
				'KODE_REF'=>$id,
				'CUST_KD'=>$getCUST_KD,
				'USER_ID'=>$getUSER_ID,
			]); 
			$aryProviderSoDetail = $searchModelDetail->searchDetail(Yii::$app->request->queryParams);

			/*
			* Process Editable Row [Columm SQTY]
			* @author ptrnov  <piter@lukison.com>
			* @since 1.1
			**/
			if (Yii::$app->request->post('hasEditable')) {
				$id = Yii::$app->request->post('editableKey');
				$model = SoT2::findOne($id);
				$out = Json::encode(['output'=>'', 'message'=>'']);
				$post = [];
				$posted = current($_POST['SoT2']);
				$post['SoT2'] = $posted;
				if ($model->load($post)) {
					$model->save();
					$output = '';
					if (isset($posted['SUBMIT_PRICE'])) {
						$output = $model->SUBMIT_PRICE;
					}
					if (isset($posted['SUBMIT_QTY'])) {
						$output = $model->SUBMIT_QTY;
					}
					if (isset($posted['TGL'])) {
						$output = $model->TGL;
					}
					$out = Json::encode(['output'=>$output, 'message'=>'']);
				}
				// return ajax json encoded response and exit
				echo $out;
				return;
			}

			return $this->render('_actionReview',[
				'aryProviderSoDetail'=>$aryProviderSoDetail,
				'kode_SO'=>$modelSoT2->KODE_REF,
				'cust_kd'=>$getCUST_KD,
				'tgl'=>$getTGL,
				'user_id'=>$getUSER_ID,
				'searchModelDetail'=>$searchModelDetail,
				'model_cus'=>$modelSoT2->cust,
				'soHeaderData'=>$soHeaderData
			]); 
		}
	}

	public function actionCetakpdf($id){
		$modelSoT2 = SoT2::find()->with('cust')->where("KODE_REF='".$id."' AND SO_TYPE=10")->one();	
		$soHeaderData = SoHeader::find()->where(['KD_SO'=>$id])->one(); 		
		$getSoType=10;
		$getTGL=$modelSoT2->TGL;
		$getCUST_KD=$modelSoT2->CUST_KD;
		$getUSER_ID=$modelSoT2->USER_ID;
		
		$searchModelDetail= new SoDetailSearch([
			// 'TGL'=>$getTGL,
			'KODE_REF'=>$id,
			'CUST_KD'=>$getCUST_KD,
			'USER_ID'=>$getUSER_ID,
		]); 
		$aryProviderSoDetail = $searchModelDetail->searchDetail(Yii::$app->request->queryParams);
		
		
		$content= $this->renderPartial( 'pdf', [
			'soHeaderData'=>$soHeaderData,
			'aryProviderSoDetail' => $aryProviderSoDetail,
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
		/* KIRIM ATTACH emaiL */
		//$to=['piter@lukison.com'];
		//\Yii::$app->kirim_email->pdf($contentMailAttach,'PO',$to,'Purchase-Order',$contentMailAttachBody);

		return $pdf->render();
	}
}
