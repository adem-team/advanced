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
use lukisongroup\purchasing\models\salesmanorder\SoStatus;
use lukisongroup\purchasing\models\salesmanorder\Auth2Model;
use lukisongroup\purchasing\models\salesmanorder\Auth3Model;
use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Customers;




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
	
	/*
	* Declaration Componen User Permission
	* Function getPermission
	* Modul Name[8=SO2]
	*/
	public function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses('8')){
			return Yii::$app->getUserOpt->Modul_akses('8');
		}else{
			return false;
		}
	}     

	/**
	* Index
	* @author ptrnov  <piter@lukison.com>
	* @since 1.1
	* STATUS : FIX
	*/
    public function actionIndex()
    {	
        if(self::getPermission()->BTN_CREATE){
			$searchModelHeader = new SoHeaderSearch();
			$dataProvider = $searchModelHeader->searchHeader(Yii::$app->request->queryParams);    
			$dataProviderInbox = $searchModelHeader->searchHeaderInbox(Yii::$app->request->queryParams);    
			$dataProviderOutbox = $searchModelHeader->searchHeaderOutbox(Yii::$app->request->queryParams);    
			$dataProviderHistory = $searchModelHeader->searchHeaderHistory(Yii::$app->request->queryParams);    
			return $this->render('index', [
				'apSoHeaderInbox'=>$dataProviderInbox,
				'apSoHeaderOutbox'=>$dataProviderOutbox,
				'apSoHeaderHistory'=>$dataProviderHistory
			]);
        }else{
           $this->redirect(array('/site/validasi'));  //
        }
    }

	/**
     * Action REVIEW | Prosess Checked and Approval
     * @param string $id
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
	 * STATUS : FIX
     */
	public function actionReview($id,$stt){
		if(self::getPermission()->BTN_REVIEW){		
			if ($stt==0){
				//CREATE HEADER KD_SO
				$modelSoT2 = SoT2::find()->with('cust')->where("ID='".$id."' AND SO_TYPE=10")->one();
				$getSoType=10;
				$getTGL=$modelSoT2->TGL;
				$setTGL=$modelSoT2->WAKTU_INPUT_INVENTORY;
				$getCUST_KD=$modelSoT2->CUST_KD;
				$getUSER_ID=$modelSoT2->USER_ID;
				
				$connect = Yii::$app->db_esm;
				$kode = Yii::$app->ambilkonci->getSMO($getUSER_ID);
				$transaction = $connect->beginTransaction();
				try {		
					//SO HEADER
					$connect->createCommand()->insert('so_0001', 
							[
								'KD_SO'=>$kode,
								'TGL' =>$setTGL,
								'USER_SIGN1' =>$getUSER_ID,
								'CUST_ID'=>$getCUST_KD,
								'CREATE_AT'=>date('Y-m-d h:i:s'),
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
				$soHeaderData = SoHeader::find()->where(['KD_SO'=>$kode])->one(); 
				$this->redirect(['/purchasing/salesman-order/review','id'=>$soHeaderData->ID,'stt'=>1]); 

				//PR create Generate Code dari komponent. Tabel so_0001.
				//Save kode generate  Tabel so_0001.
				//Update SoT2 KODE_REF where ($getSoType,getTGL,getCUST_KD,getUSER_ID).
				//Editing editable : SUBMIT_QTY,SUBMIT_PRICE
			}else{
				//VIEW KODE_REF
				//$modelSoT2 = SoT2::find()->with('cust')->where("KODE_REF='".$id."' AND SO_TYPE=10")->one();	
				
				//$soHeaderData = SoHeader::find()->with('cust')->where(['ID'=>$id])->one(); 		
				$soHeaderData = SoHeader::find()->where(['ID'=>$id])->one(); 
				$modelSoT2 = SoT2::find()->where("KODE_REF='".$soHeaderData->KD_SO."' AND SO_TYPE=10")->one();					
				$getSoType=10;
				$getTGL=$modelSoT2->TGL;
				$getCUST_KD=$modelSoT2->CUST_KD;
				$getUSER_ID=$modelSoT2->USER_ID;
				$getKd_SO=$soHeaderData->KD_SO;
				//print_r($soHeaderData);
				//die();
				// $status_sign = SoStatus::find()->where(['KD_SO'=>$id])->count();
				
				$searchModelDetail= new SoDetailSearch([
					// 'TGL'=>$getTGL,
					'KODE_REF'=>$getKd_SO,
					'CUST_KD'=>$getCUST_KD,
					'USER_ID'=>$getUSER_ID,
				]); 
				$aryProviderSoDetail = $searchModelDetail->searchDetail(Yii::$app->request->queryParams);
				
				 //print_r($aryProviderSoDetail->getModels());
				 //die();
				
				// Process Editable Row [Columm SQTY]
				// @author ptrnov  <piter@lukison.com>
				// @since 1.1				
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
					'kode_SO'=>$soHeaderData->KD_SO,
					'cust_kd'=>$soHeaderData->CUST_ID,
					'cust_nmx'=>$soHeaderData->cust->CUST_NM,
					'tgl'=>$soHeaderData->TGL,
					'user_id'=>$soHeaderData->USER_SIGN1,
					'searchModelDetail'=>$searchModelDetail,
					'model_cus'=>$soHeaderData->cust,
					'model_dest'=>$soHeaderData->dest,
					'soHeaderData'=>$soHeaderData,
					'id_so'=>$id
					// 'status'=>$status_sign
				]); 
			}
		}else{
			$this->redirect(array('/site/validasi'));  //
		} 
	}
	
	public function actionCreateSales()
    {
      	$model = new SoHeader();

      	$model_status = new SoStatus();

		# code...
		if ($model->load(Yii::$app->request->post())){

			#explode USER_SIGN1
			$user_explode = explode('-', $model->USER_SIGN1);

			# SoHeader
			$kode = Yii::$app->ambilkonci->getSMO($user_explode[0]);
			$model->KD_SO = $kode;
			$model->STT_PROCESS = 0;
			$model->CREATE_BY = Yii::$app->user->identity->id;
			$model->CREATE_AT = date('Y-m-d h:i:s');

			# SoStatus
			$model_status->KD_SO = $kode;
			$model_status->ID_USER = $user_explode[0];
			$model_status->STT_PROCESS = 0;
			$transaction = self::Esm_connent()->beginTransaction();
			try{
				# SoHeader

				$model->save();

				# SoStatus

				$model_status->save();

				// ...other DB operations...
				$transaction->commit();
			} catch(\Exception $e) {
				$transaction->rollBack();
				throw $e;
			}
			$soHeaderData = SoHeader::find()->where(['KD_SO'=>$kode])->one(); 
			$this->redirect(['/purchasing/salesman-order/review','id'=>$soHeaderData->ID,'stt'=>1]); 
		  //return $this->redirect(['/purchasing/salesman-order/review-new','id'=>$model->KD_SO,'stt'=>1,'cust_kd'=>$model->CUST_ID,'user_id'=>$model_status->ID_USER,'tgl'=>$model->TGL]);
		}else {
			return $this->renderAjax('new_so', [
				'model' => $model,
				'data_cus' => self::get_aryCustomers(), #array customers
				'data_user'=>self::get_aryUser_id(),
				// 'data_user' => self
				// 'kode_som'=>$id
			]);
		} 
    }
	
	/**
	* Add Items
	* @param string $id
	* @author wawan update by ptrnov  <piter@lukison.com>
	* @since 1.1
	*/
	//public function actionCreateNewAdd($cust_kd,$user_id,$id,$cust_nm,$tgl)
	public function actionCreateNewAdd($id)
    {
		$soHeaderData = SoHeader::find()->where(['ID'=>$id])->one();
		$model = new SoT2();
		# code...
		if ($model->load(Yii::$app->request->post()) ) {
			$explode = explode(',', $model->KD_BARANG);
			$setUser = explode('-', $soHeaderData->USER_SIGN1);
			$model->NM_BARANG = $explode[1];
			$model->KD_BARANG = $explode[0];
			$model->CUST_KD = $soHeaderData->CUST_ID;
			$model->USER_ID = $setUser[0];
			$model->CUST_NM = $soHeaderData->custNm;
			$model->KODE_REF = $soHeaderData->KD_SO;
			$model->SO_TYPE = 10;
			$model->POS ='WEB';
			$model->WAKTU_INPUT_INVENTORY =  date("Y-m-d H:i:s"); #set datetime
			$model->TGL =  date_format(date_create($soHeaderData->TGL),"Y-m-d");
			$model->save();
			return $this->redirect(['/purchasing/salesman-order/review','id'=>$id,'stt'=>1]); ;
		}else {
		return $this->renderAjax('new_items', [
			'model' => $model,
			'data_barang' => self::get_aryBarang(), #array barang
			'kode_som'=>$soHeaderData->KD_SO
		]);
		}
    }	
	
	/**
	* Validation Alias Barang
	* @author waawan update ptrnov  <piter@lukison.com>
	* @since 1.1
	*/
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
	
	/**
	* Action REVIEW | Prosess Checked and Approval
	* @param string $id
	* @author ptrnov  <piter@lukison.com>
	* @since 1.1
	*/
	/* public function actionReviewNew($id,$stt,$cust_kd,$user_id,$tgl)
	{			
		//VIEW KODE_REF
		$soHeaderData = SoHeader::find()->with('cust')->where(['KD_SO'=>$id])->one(); 

		// $status_sign = SoStatus::find()->where(['KD_SO'=>$id])->count();		
		$getSoType=10;
		$getTGL=$tgl;
		$getCUST_KD=$cust_kd;
		$getUSER_ID=$user_id;
		
		$searchModelDetail= new SoDetailSearch([
			// 'TGL'=>$getTGL,
			'KODE_REF'=>$id,
			'CUST_KD'=>$getCUST_KD,
			'USER_ID'=>$getUSER_ID,
		]); 
		$aryProviderSoDetail = $searchModelDetail->searchDetail(Yii::$app->request->queryParams);

		
		// Process Editable Row [Columm SQTY]
		// @author ptrnov  <piter@lukison.com>
		// @since 1.1
		
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
			'kode_som'=>$id,
			'cust_kd'=>$getCUST_KD,
			'cust_nmx'=>$soHeaderData->cust->CUST_NM,
			'tgl'=>$getTGL,
			'user_id'=>$getUSER_ID,
			'searchModelDetail'=>$searchModelDetail,
			'model_cus'=>$soHeaderData->cust,
			'soHeaderData'=>$soHeaderData,
			// 'status'=>$status_sign
		]); 
	} */
	
	


    public function get_aryBarang()
    {
		$sql = Barang::find()->where('KD_CORP="ESM" AND PARENT= 1 AND STATUS<>3')->all();
		return ArrayHelper::map($sql,function ($sql, $defaultValue) {
			return $sql->KD_BARANG . ',' . $sql->NM_BARANG; 
		},'NM_BARANG');
    }

    public function get_aryCustomers()
    {
    	$sql = (new \yii\db\Query())
    			->select(['CUST_KD', 'CUST_NM'])
   				 ->from('dbc002.c0001')
   				 ->where('CUST_KD = CUST_GRP AND STATUS<>3')
    			 ->all();

      return ArrayHelper::map($sql, 'CUST_KD','CUST_NM');
    }


    public function get_aryUser_id(){
    	$sql = (new \yii\db\Query())
    			->select(['u.id as id', 'u.username as username','u.USER_ALIAS as USER_ALIAS','up.NM_FIRST as NM_FIRST'])
   				 ->from('dbm001.user u')
   				 ->leftJoin('dbm_086.user_profile up','u.id = up.ID_USER')
   				 ->where(['u.status'=>10,'u.POSITION_SITE'=>'CRM','u.POSITION_LOGIN'=>1,'u.POSITION_ACCESS'=>2])
    			 ->all();

		return ArrayHelper::map($sql,function ($sql, $defaultValue) {
            return $sql['id'] . '-' . $sql['USER_ALIAS'];
		},function ($sql, $defaultValue) {
			return $sql['username'] . '-' . $sql['NM_FIRST']; 
		});
    }


    public function actionApprovedSoDetail(){
    	if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			//\Yii::$app->response->format = Response::FORMAT_JSON;
			$soDetail = SoT2::findOne($id);
			$soDetail->STATUS = 1;
			//$ro->NM_BARANG=''
			$soDetail->save();
			return true;
		}
    }

    public function actionRejectSoDetail(){
    	if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			//\Yii::$app->response->format = Response::FORMAT_JSON;
			$soDetail = SoT2::findOne($id);
			$soDetail->STATUS = 4;
			//$ro->NM_BARANG=''
			$soDetail->save();
			return true;
		}
    }


    public function actionDeleteSoDetail(){
    	if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$id=$request->post('id');
			//\Yii::$app->response->format = Response::FORMAT_JSON;
			$soDetail = SoT2::findOne($id);
			$soDetail->STATUS = 3;
			//$ro->NM_BARANG=''
			$soDetail->save();
			return true;
		}
    }


	/**
	* Depdrop child customers
	* @author wawan
	* @since 1.1.0
	* @return mixed
	*/
	public function actionLisChildCus() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$id = $parents[0];

				$model = Customers::find()->asArray()->where(['CUST_GRP'=>$id])
														 ->andwhere('STATUS <> 3')
														->all();
														
				//$out = self::getSubCatList($cat_id);
				// the getSubCatList function will query the database based on the
				// cat_id and return an array like below:
				// [
				//    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
				//    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
				// ]
				foreach ($model as $key => $value) {
					   $out[] = ['id'=>$value['CUST_KD'],'name'=> $value['CUST_NM']];
				   }

				   echo json_encode(['output'=>$out, 'selected'=>'']);
				   return;
			}
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
   }



   


    public function actionValidAliasHeader()
    {
		$model = new SoHeader();
		$model->scenario = "create";
		if(Yii::$app->request->isAjax && $model->load($_POST))
		{
			Yii::$app->response->format = 'json';
			return ActiveForm::validate($model);
		}
    }


     public function actionValidSign2()
    {
		$model = new Auth2Model();
		if(Yii::$app->request->isAjax && $model->load($_POST))
		{
			Yii::$app->response->format = 'json';
			return ActiveForm::validate($model);
		}
    }

       public function actionValidSign3()
    {
		$model = new Auth3Model();
		if(Yii::$app->request->isAjax && $model->load($_POST))
		{
			Yii::$app->response->format = 'json';
			return ActiveForm::validate($model);
		}
    }

    public function actionSoNoteReview($id)
    {
      $model = $this->findModelHeader($id);
      # code...
      if ($model->load(Yii::$app->request->post()) ) {
      	
          $model->save();
           //return $this->redirect(['/purchasing/salesman-order/review-new','id'=>$model->KD_SO,'stt'=>1,'cust_kd'=>$model->CUST_ID,'user_id'=>$model->USER_SIGN1,'tgl'=>$model->TGL]);
           return $this->redirect(['/purchasing/salesman-order/review','id'=>$model->ID,'stt'=>1]);
      }else {
        return $this->renderAjax('so_note', [
            'model' => $model,
        ]);
      }
    }

	public function actionSoDestinationReview($id_so){
		$model = $this->findModelHeader($id_so);
		# code...
		if ($model->load(Yii::$app->request->post()) ) {
			$model->save();
			return $this->redirect(['/purchasing/salesman-order/review','id'=>$model->ID,'stt'=>1]);
		}else {
			return $this->renderAjax('so_destination', [
				'model' => $model,
			]);
		}
	}

     public function actionSignAuth2($kdso)
    {
      $model = new Auth2Model();
      $model_header =  $this->findModelHeader($kdso);

      $model_status = new SoStatus();

      $profile=Yii::$app->getUserOpt->Profile_user();
      $id = $profile->id;
      # code...
      if ($model->load(Yii::$app->request->post()) ) {

      	 $transaction = self::Esm_connent()->beginTransaction();
      	  try{
      	  	 # SoHeader
      	  	 $model_header->STT_PROCESS = $model->status;
      	  	 $model_header->USER_SIGN2 = $id;
      	  	 $model_header->TGL_SIGN2 = date('Y-m-d h:i:s');
      	  	 $model_header->save();



      	  	 # SoStatus
      	  	 $model_status->KD_SO = $model->kdso;
      	  	 $model_status->STT_PROCESS = $model->status;
      	  	 $model_status->ID_USER = $id;
      	  	 $model_status->save();
      	  	// ...other DB operations...
				$transaction->commit();
			} catch(\Exception $e) {
				$transaction->rollBack();
				throw $e;
			}
      	

     		 return $this->redirect(['/purchasing/salesman-order/review','id'=>$kdso,'stt'=>1]);
      }else {
        return $this->renderAjax('sign_2', [
            'model' => $model,
            'kode_som'=>$kdso
        ]);
      }
    }


    public function actionSignAuth3($kdso)
    {
      $model = new Auth3Model();

       $model_header =  $this->findModelHeader($kdso);

      $model_status = new SoStatus();

      $profile=Yii::$app->getUserOpt->Profile_user();
      $id = $profile->id;
      # code...
      if ($model->load(Yii::$app->request->post()) ) {
      	

      	 $transaction = self::Esm_connent()->beginTransaction();
      	  try{
      	  	 # SoHeader
      	  	 $model_header->STT_PROCESS = $model->status;
      	  	 $model_header->USER_SIGN3 = $id;
      	  	 $model_header->TGL_SIGN2 = date('Y-m-d h:i:s');
      	  	 $model_header->save();



      	  	 # SoStatus
      	  	 $model_status->KD_SO = $model->kdso;
      	  	 $model_status->STT_PROCESS = $model->status;
      	  	 $model_status->ID_USER = $id;
      	  	 $model_status->save();
      	  	// ...other DB operations...
				$transaction->commit();
			} catch(\Exception $e) {
				$transaction->rollBack();
				throw $e;
			}
     
           return $this->redirect(['/purchasing/salesman-order/review','id'=>$kdso,'stt'=>1]);
      }else {
        return $this->renderAjax('sign_3', [
            'model' => $model,
            'kode_som'=>$kdso
        ]);
      }
    }


     

    public function actionSoShipingReview($cust_kd,$id_so,$user_id,$tgl)
    {
       $model = $this->findModelCust($cust_kd);
      # code...
      if ($model->load(Yii::$app->request->post()) ) {
      	
          $model->save();

           //return $this->redirect(['/purchasing/salesman-order/review-new','id'=>$kode_so,'stt'=>1,'cust_kd'=>$cust_kd,'user_id'=>$user_id,'tgl'=>$tgl]);
           return $this->redirect(['/purchasing/salesman-order/review','id'=>$id_so,'stt'=>1]);
      }else {
        return $this->renderAjax('so_shiping', [
            'model' => $model,
            'kode_som'=>$kode_so
        ]);
      }
    }

    public function actionSoNoteTopReview($kdso)
    {
       $model = $this->findModelHeader($kdso);
      # code...
      if ($model->load(Yii::$app->request->post()) ) {

      	    $hsl = \Yii::$app->request->post();
			$topType=$model->TOP_TYPE = $hsl['SoHeader']['TOP_TYPE'];
			$topDuration =$hsl['SoHeader']['TOP_DURATION'];
			$model->TOP_TYPE =$topType;
			$model->TOP_DURATION = $topType=='Credit' ? $topDuration:'';
      	
          $model->save();
         //return $this->redirect(['/purchasing/salesman-order/review-new','id'=>$model->KD_SO,'stt'=>1,'cust_kd'=>$model->CUST_ID,'user_id'=>$model->USER_SIGN1,'tgl'=>$model->TGL]);
         return $this->redirect(['/purchasing/salesman-order/review','id'=>$model->ID,'stt'=>1]);
      }else {
        return $this->renderAjax('sonote_top', [
            'model' => $model,
            'kode_som'=>$kdso
        ]);
      }
    }


    public function Esm_connent()
    {
    	return Yii::$app->db_esm;
    }


    

   
	public function actionSoEditReview($id){

		$model = $this->findModelHeader($id);
		  # code...
		  if ($model->load(Yii::$app->request->post()) ) {
			
			  $model->save();
			   //return $this->redirect(['/purchasing/salesman-order/review-new','id'=>$model->KD_SO,'stt'=>1,'cust_kd'=>$model->CUST_ID,'user_id'=>$model->USER_SIGN1,'tgl'=>$model->TGL]);
			   return $this->redirect(['/purchasing/salesman-order/review','id'=>$model->ID,'stt'=>1]);
		  }else {
			return $this->renderAjax('so_tgl_kirim', [
				'model' => $model,
				'kode_som'=>$id
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


	/**
     * Finds the soheder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return soheder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelHeader($id)
    {
        if (($model = SoHeader::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Customers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Customers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelCust($id)
    {
        if (($model = Customers::findOne($id)) !== null) {
       // if (($model = Customers::find->where(['CUST_KD'=>$id]))) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
