<?php

namespace lukisongroup\master\controllers;

use Yii;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/*namespace models*/
use lukisongroup\master\models\DistributorSearch;
use lukisongroup\master\models\ProvinceSearch;
use lukisongroup\master\models\Province;
use lukisongroup\master\models\Kota;
use lukisongroup\master\models\Kategoricus;
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\CustomersSearch;
use lukisongroup\master\models\Customersalias;
use lukisongroup\master\models\CustomersaliasSearch;
use lukisongroup\master\models\ValidationLoginPrice;
use lukisongroup\master\models\Distributor;
use lukisongroup\master\models\DraftLayer;
use lukisongroup\master\models\DraftLayerSearch;
use lukisongroup\master\models\DraftGeo;
use lukisongroup\master\models\DraftGeoSearch;
use lukisongroup\master\models\DraftLayerMutasiSearch;
use lukisongroup\master\models\ScheduledetailSearch;


/**
 * CustomersController implements the CRUD actions for Customers model.
 */
class CustomersController extends Controller
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
     * @since 1.1.0
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

/*draft layer array*/
	public function aryData_layer(){ 
		return ArrayHelper::map(DraftLayer::find()->all(), 'LAYER_ID','LAYER_NM');
	}

  /*draft geo array*/
	public function aryData_Geo(){ 
		return ArrayHelper::map(DraftGeo::find()->Where("GEO_ID<>1")->all(), 'GEO_ID','GEO_NM');
	}

	/*customers parent array*/
	public function aryData_Customers(){ 
		return ArrayHelper::map(Customers::find()->where('CUST_KD = CUST_GRP')->andwhere('STATUS<>3')->all(), 'CUST_GRP','CUST_NM');
	}

  /*customers Child array*/
  public function aryData_CustomersChild(){ 
    return ArrayHelper::map(Customers::find()->where('STATUS<>3')->all(), 'CUST_KD','CUST_NM');
  }
	
	/*Distributor  array*/
	public function aryData_Dis(){ 
		return ArrayHelper::map( Distributor::find()->where('STATUS<>3')
                              ->all(), 'KD_DISTRIBUTOR','NM_DISTRIBUTOR');
	}


/**
     * INDEX 
     * Lists all  Customers models.
     * @author wawan
     * @since 1.1.0
     */
    public function actionIndex()
    {

      $datacus = Customers::find()->where('CUST_GRP = CUST_KD AND STATUS<>3')->asArray()->all();
    $parent = ArrayHelper::map($datacus,'CUST_KD', 'CUST_NM');

		//*search individual*/
      $paramCari=Yii::$app->getRequest()->getQueryParam('id');
    
    /*search group*/
    $paramCari_prn=Yii::$app->getRequest()->getQueryParam('id_prn');
    
    // if parent not equal null then search parent
      if ($paramCari_prn !=''){
        $cari=['CUST_GRP'=>$paramCari_prn];
      }elseif($paramCari != ''){
        $cari=['CUST_KD'=>$paramCari];
      }else{
        $cari='';
      };

        $searchModel = new CustomersSearch($cari);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

           if(Yii::$app->request->post('hasEditable'))
        {
            $ID = \Yii::$app->request->post('editableKey');
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = Customers::findOne($ID);
           
            $out = Json::encode(['output'=>'', 'message'=>'']);

            // fetch the first entry in posted data (there should
            // only be one entry anyway in this array for an
            // editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $post = [];
            $posted = current($_POST['Customers']);
            $post['Customers'] = $posted;


            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model


                // custom output to return to be displayed as the editable grid cell
                // data. Normally this is empty - whereby whatever value is edited by
                // in the input by user is updated automatically.
                $output = '';
         
          
            if (isset($posted['CUST_KD'])) {
                /*save parent customers*/
                $parent_model = Customers::find()->where(['CUST_KD'=>$ID])->one();
                    $parent_model->CUST_GRP = $posted['CUST_KD'];
                    $parent_model->save();

                    /* output parent*/
                    $output = $parent_model->CUST_GRP;
                   
                }
                if (isset($posted['LAYER'])) {
                    $model->save();
                    $output = $model->LAYER;                 
                }
                if (isset($posted['GEO'])) {
                    $model->save();

               
                    $output = $model->GEO;                  
                }
				if (isset($posted['DC_STATUS'])) {
                    $model->save();
                    $output = $model->DC_STATUS;                 
                }

        }
    
              

                // specific use case where you need to validate a specific
                // editable column posted when you have more than one
                // EditableColumn in the grid view. We evaluate here a
                // check to see if buy_amount was posted for the Book model
                // similarly you can check if the name attribute was posted as well

                $out = Json::encode(['output'=>$output, 'message'=>'']);


            // return ajax json encoded response and exit
            echo $out;

            return;
          }

		/*Tambahal menu side Dinamik */
		$sideMenu_control='umum_datamaster';
		return $this->render('index', [
			'sideMenu_control'=> $sideMenu_control,
			'parent'=> $parent,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'data_layer'=>$this->aryData_layer(),
			'data_group'=>$this->aryData_Geo(),
		]);
	}

  
   /**
     * delete using ajax.
     * @author wawan
     * @since 1.1.0
     * @return mixed
     */
   public function actionDeleteErp(){

            if (Yii::$app->request->isAjax) {

                Yii::$app->response->format = Response::FORMAT_JSON;
                $request= Yii::$app->request;
                $dataKeySelect=$request->post('keysSelect');
                foreach ($dataKeySelect as $key => $value) {
              
                    $model = Customers::find()->where(['CUST_KD'=>$value])->one();
                    $model->STATUS = 3;
                    $model->save();   
             }
             
         }
         
     return true;
   
       }


  /**
     * ESM INDEX 
     * Lists all  Customers models.
     * @author wawan
     * @since 1.1.0
     */
	public function actionEsmIndex()
    {
		$datacus = Customers::find()->where("CUST_GRP = CUST_KD AND CUST_KD<>'CUS.2016.000637'")->asArray()->all();
		$parent = ArrayHelper::map($datacus,'CUST_KD', 'CUST_NM');

		
	/*search individual*/
      $paramCari=Yii::$app->getRequest()->getQueryParam('id');
	  
	  /*search group*/
	  $paramCari_prn=Yii::$app->getRequest()->getQueryParam('id_prn');
	  
	  // if parent not equal null then search parent
      if ($paramCari_prn !=''){
        $cari=['CUST_GRP'=>$paramCari_prn];
      }elseif($paramCari != ''){
		    $cari=['CUST_KD'=>$paramCari];
			}else{
        $cari='';
      };

        $searchModel = new CustomersSearch($cari);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

           if(Yii::$app->request->post('hasEditable'))
        {
            $ID = \Yii::$app->request->post('editableKey');
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = Customers::findOne($ID);
           
            $out = Json::encode(['output'=>'', 'message'=>'']);

            // fetch the first entry in posted data (there should
            // only be one entry anyway in this array for an
            // editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $post = [];
            $posted = current($_POST['Customers']);
            $post['Customers'] = $posted;


            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model


                // custom output to return to be displayed as the editable grid cell
                // data. Normally this is empty - whereby whatever value is edited by
                // in the input by user is updated automatically.
                $output = '';
				 
				  
				    if (isset($posted['CUST_KD'])) {
                /*save parent customers*/
                $parent_model = Customers::find()->where(['CUST_KD'=>$ID])->one();
                    $parent_model->CUST_GRP = $posted['CUST_KD'];
                    $parent_model->save();

                    /* output parent*/
                    $output = $parent_model->CUST_GRP;
                   
                }
                if (isset($posted['LAYER'])) {
                    $model->save();
                    $output = $model->LAYER;                 
                }
                if (isset($posted['GEO'])) {
                    $model->save();

               
                    $output = $model->GEO;                  
                }
				if (isset($posted['DC_STATUS'])) {
                    $model->save();
                    $output = $model->DC_STATUS;                 
                }

			  }
		
              

                // specific use case where you need to validate a specific
                // editable column posted when you have more than one
                // EditableColumn in the grid view. We evaluate here a
                // check to see if buy_amount was posted for the Book model
                // similarly you can check if the name attribute was posted as well

                $out = Json::encode(['output'=>$output, 'message'=>'']);


            // return ajax json encoded response and exit
            echo $out;

            return;
          }

        

		/*Tambahal menu side Dinamik */
		$sideMenu_control='esm_customers';
		return $this->render('index', [
			'sideMenu_control'=> $sideMenu_control,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		  'parent'=> $parent,
  		'data_layer'=>$this->aryData_layer(),
  		'config_layer'=>$config_layer,
  		'data_group'=>$this->aryData_Geo(),
		]);
	}


  
 
   /**
     * ESM INDEX Geo
     * Lists all DraftGeo models.
     * @author wawan
     * @since 1.1.0
     */
  public function actionEsmIndexGeo()
    {

      $searchModelGeo= new DraftGeoSearch();
      $dataProviderGeo  = $searchModelGeo->search(Yii::$app->request->queryParams);


    /*Tambahal menu side Dinamik */
    $sideMenu_control='esm_customers';
    return $this->render('_indexLayerGeo', [
      'sideMenu_control'=> $sideMenu_control,
      'searchModelGeo' => $searchModelGeo,
      'dataProviderGeo'  =>$dataProviderGeo ,

    ]);
  }
  

  
  
   /**
     * ESM INDEX LAYER
     * Lists all DraftLayer models.
     * @author wawan
     * @since 1.1.0
     */
  public function actionEsmIndexLayer()
    {

      $searchModellayer= new DraftLayerSearch();
      $dataProviderLayer  = $searchModellayer->search(Yii::$app->request->queryParams);


    /*Tambahal menu side Dinamik */
    $sideMenu_control='esm_customers';
    return $this->render('_indexLayer', [
      'sideMenu_control'=> $sideMenu_control,
      'searchModellayer' => $searchModellayer,
      'dataProviderLayer'  =>$dataProviderLayer ,

    ]);
  }
  

   /**
     * ESM INDEX LAYER MUTASI
     * Lists all DraftLayerMutasi models.
     * @author wawan
     * @since 1.1.0
     */
  public function actionEsmIndexLayermutasi()
    {

      $searchModelLayerMutasi= new DraftLayerMutasiSearch();
      $dataProviderLayerMutasi  = $searchModelLayerMutasi->search(Yii::$app->request->queryParams);


    /*Tambahal menu side Dinamik */
    $sideMenu_control='esm_customers';
    return $this->render('_indexLayerMutasi', [
      'sideMenu_control'=> $sideMenu_control,
      'searchModelLayerMutasi' => $searchModelLayerMutasi,
      'dataProviderLayerMutasi'  =>$dataProviderLayerMutasi ,

    ]);
  }



   /**
     * ESM INDEX Provinsi
     * Lists all  Province models.
     * @author wawan
     * @since 1.1.0
     */
  public function actionEsmIndexProvinsi()
    {

      // province data
      $searchmodelpro = new ProvinceSearch();
      $dataproviderpro = $searchmodelpro->search(Yii::$app->request->queryParams);


    /*Tambahal menu side Dinamik */
    $sideMenu_control='esm_customers';
    return $this->render('index-province', [
      'sideMenu_control'=> $sideMenu_control,
      'searchmodelpro' => $searchmodelpro,
      'dataproviderpro' =>  $dataproviderpro,

    ]);
  }

  

  /**
     * ESM INDEX Map
     * Lists all  Map.
     * @author wawan
     * @since 1.1.0
     */
  public function actionEsmMap()
    {

    /*Tambahal menu side Dinamik */
    $sideMenu_control='esm_customers';
    return $this->render('index-map', [
      'sideMenu_control'=> $sideMenu_control,

    ]);
  }



  /**
      * Display Single model province.
       * @author wawan
       * @since 1.1.0
       * @param string $id
       * @return mixed

  */
	 public function actionViewpro($id)
    {
        return $this->renderAjax('viewpro', [
            'model' => $this->findModelpro($id),
        ]);
    }

  /**
         * Display Single model province.
         * Display Single model Distributor.
         * Display Single model Kategoricus.
         * update Customers.
         * @author wawan
         * @since 1.1.0
         * @param string $id
         * @return mixed

    */
	  public function actionViewcust($id)
    {
        /*province data*/
        $valpro = ArrayHelper::map(Province::find()->asArray()->all(),'PROVINCE_ID','PROVINCE');

        /*distributor data*/
        $datadis_view = ArrayHelper::map(Distributor::find()->where('STATUS<>3')
                              ->all(),'KD_DISTRIBUTOR','NM_DISTRIBUTOR');

        $kategori_view = ArrayHelper::map(Kategoricus::find()->where('CUST_KTG_PARENT = CUST_KTG')
                                                                   ->asArray()
                                                                   ->all(),'CUST_KTG', 'CUST_KTG_NM');
          $model = $this->findModelcust($id);
       
        if ($model->load(Yii::$app->request->post())){
          $model->UPDATED_AT = date("Y-m-d H:i:s");
          $model->UPDATED_BY =  Yii::$app->user->identity->username;
           
      //$model->save(false);
      if($model->save()){
        //$model->refresh();
        
        return $this->redirect(['/master/customers/esm-index','id_prn'=>$model->CUST_GRP]);
         //Yii::$app->session->setFlash('kv-detail-success', 'Success Message');
      };
    }else{
      return $this->renderAjax('_view_cus', [
            'model' => $model,
            'valpro'=>$valpro,
            'datadis_view'=>$datadis_view,
            'kategori_view'=>$kategori_view
        ]);
    }
    }

  /**
         * Display Single model Customers Alias.
         * @author wawan
         * @since 1.1.0
         * @param string $id
         * @return mixed

    */
    public function actionViewAlias($id)
    {
        return $this->renderAjax('view_alias', [
            'model' => $this->findModelalias($id),
        ]);
    }



	// public function actionAliasCodeView($id)
 //    {
 //      $model = new Customersalias();
 //      $searchModel = new CustomersaliasSearch();
 //      $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);



 //      $id = Customers::find()->where(['CUST_KD'=>$id])->one();
 //      $nama = $id->CUST_NM;
 //      if ($model->load(Yii::$app->request->post()) ) {
 //        $model->CREATED_AT = date('Y-m-d');
 //        $model->CREATED_BY = Yii::$app->user->identity->username;
 //        $model->KD_PARENT = 1;
 //        if($model->save())
 //        {
 //          echo 1;

 //        }
 //        else{
 //          echo 0;
 //        }
 //      } else {
 //          return $this->renderAjax('_aliascus', [
 //              'model' => $model,
 //              'id'=>$id,
 //              'nama'=>$nama,
 //              'searchModel'=>$searchModel,
 //              'dataProvider'=>$dataProvider
 //          ]);
 //      }
 //    }




   //  public function actionCreateAliasCustomers($id)
   //  {
   //      $model = new Customersalias();
   //      $id = Customers::find()->where(['CUST_KD'=>$id])->one();
   //      $nama = $id->CUST_NM;
   //      if ($model->load(Yii::$app->request->post()) ) {
   //        $model->CREATED_AT = date('Y-m-d');
   //        $model->CREATED_BY = Yii::$app->user->identity->username;
   //        $model->KD_PARENT = 1;
   //        if($model->save())
   //        {
   //          echo 1;
   //        }
   //        else{
   //          echo 0;
   //        }
   //      } else {
   //          return $this->renderAjax('alias_customers', [
   //              'model' => $model,
   //              'id'=>$id,
   //              'nama'=>$nama,
   //          ]);
   //      }
   //  }

   //  public function actionValidAlias()
   //  {
   //    # code...
   //      $model = new Customersalias();
   //    if(Yii::$app->request->isAjax && $model->load($_POST))
   //    {
   //      Yii::$app->response->format = 'json';
   //      return ActiveForm::validate($model);
   //    }
   //  }
    // public function actionLoginAlias()
    // {
      // # code...
      // $ValidationLoginPrice = new ValidationLoginPrice();
      // return $this->renderAjax('login_alias', [
        // 'ValidationLoginPrice' => $ValidationLoginPrice,
      // ]);
    // }

   //  public function actionLoginCek(){
   //    $ValidationLoginPrice = new ValidationLoginPrice();
   //    /*Ajax Load*/
   //    if(Yii::$app->request->isAjax){
   //      $ValidationLoginPrice->load(Yii::$app->request->post());
   //      return Json::encode(\yii\widgets\ActiveForm::validate($ValidationLoginPrice));
   //    }else{	/*Normal Load*/
   //      if($ValidationLoginPrice->load(Yii::$app->request->post())){
   //        if ($ValidationLoginPrice->Validationlogin()){
   //          return $this->redirect(['/master/customers/index-alias']);
   //        }
   //      }
   //    }
   //  }
   
   
   /*create alias customers */
   public function actionTambahAliasCustomers()
   {
	   $model = new Customersalias();

    if ($model->load(Yii::$app->request->post()) ) {
			if($model->validate())
			{
				$model->CREATED_BY =  Yii::$app->user->identity->username;
				$model->CREATED_AT = date("Y-m-d H:i:s");
				$model->save();

        return $this->redirect(['index-alias']);

			}
        } else {
            return $this->renderAjax('formalias', [
                'model' => $model,
				        'cus_data'=>self::aryData_Customers(),
				        'cus_dis'=>self::aryData_Dis()
            ]);
        }
   }


    /*create layer*/
   public function actionTambahLayers()
   {
     $model = new DraftLayer();

    if ($model->load(Yii::$app->request->post()) ) {
      
        $model->save();

        return $this->redirect(['esm-index-layer']);

      
        } else {
            return $this->renderAjax('_form_layers', [
                'model' => $model,
            ]);
        }
   }
   
    /**
     * INDEX 
     * Lists all  Customersalias models.
     * @author wawan
     * @since 1.1.0
     */
    public function actionIndexAlias()
    {
      # code...
      $searchModel = new CustomersaliasSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	   $sideMenu_control='esm_customers';
      return $this->render('index_alias', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,
			       'sideMenu_control'=>$sideMenu_control,
              'cus_data'=>self::aryData_Customers(), #array parent customers
              'cus_dis'=>self::aryData_Dis(), #array distributor
              'child'=>self::aryData_CustomersChild() #array customers child
          ]);
    }

    public function actionPriceLogout(){
  		$this->redirect('index');
  	}


    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreateMap($id)
     {
       # code...
       $model = Customers::find()->where(['CUST_KD'=>$id])->one();

       if ($model->load(Yii::$app->request->post()) ) {

         if($model->validate())
         {

           $model->save();
        }
        // print_r($model->getErrors());
        // die();

           return $this->redirect('esm-index');
         }
         else {
           # code...
		  
           return $this->render('_formaddmap', [
             'id'=>$id,
               'model' => $model
           ]);
         }
     }


    /**
     * Create  Province model.
     * @author wawan
     * @since 1.1.0
     * @param string $id
     * @return mixed
     */

      public function actionCreateprovnce()
    {
        $model = new Province();

        if ($model->load(Yii::$app->request->post()) ) {

				if($model->validate())
				{

					if($model->save())
          {
                echo 1;
          }
          else{
                echo 0;
          }
				}

            // return $this->redirect(['index']);
		}
         else {
            return $this->renderAjax('_formprovince', [
                'model' => $model,
            ]);
        }
    }
  

	/**
     * List all map customers.
     * @author wawan
     * @since 1.1.0
     * @response json
     * @return mixed
     */
    public function actionMap()
    {
            $conn = Yii::$app->db3;
            $hasil = $conn->createCommand("SELECT c.SCDL_GROUP,c.CUST_KD, c.ALAMAT, c.CUST_NM,c.MAP_LAT,c.MAP_LNG,b.SCDL_GROUP_NM from c0001 c
                                          left join c0007 b on c.SCDL_GROUP = b.ID")->queryAll();


            echo json_encode($hasil);

    }


      public function actionDrop()
      {
              $conn = Yii::$app->db3;

              $datadrop = $conn->createCommand("SELECT * from c0007")->queryAll();
              //  echo "<option>" . $row['admin_first_name'] . " " . $row['admin_last_name'] . "</option>";
              echo json_encode($datadrop);
              // echo json_encode($datadrop);

      }

/**
     * Depdrop Kategoricus
     * @author wawan
     * @since 1.1.0
     * @return mixed
     */
   public function actionLisdata() {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $id = $parents[0];

            $model = Kategoricus::find()->asArray()->where(['CUST_KTG_PARENT'=>$id])
                                                     ->andwhere('CUST_KTG_PARENT <> CUST_KTG')
                                                    ->all();
                                                    // print_r($model);
                                                    // die();
            //$out = self::getSubCatList($cat_id);
            // the getSubCatList function will query the database based on the
            // cat_id and return an array like below:
            // [
            //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
            //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
            // ]
            foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['CUST_KTG'],'name'=> $value['CUST_KTG_NM']];
               }

               echo json_encode(['output'=>$out, 'selected'=>'']);
               return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
   }
   
    public function actionValidAliasCustomers()
    {
      # code...
      $model = new Customersalias();
	  $model->scenario = "create";
    if(Yii::$app->request->isAjax && $model->load($_POST))
    {
      Yii::$app->response->format = 'json';
      return ActiveForm::validate($model);
      }
    }

     public function actionValidAliasUpdate()
    {
      # code...
      $model = new Customersalias();
      $model->scenario = "update";
    if(Yii::$app->request->isAjax && $model->load($_POST))
    {
      Yii::$app->response->format = 'json';
      return ActiveForm::validate($model);
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
                                                    // print_r($model);
                                                    // die();
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


    /**
     * Depdrop Customers
     * @author wawan
     * @since 1.1.0
     * @return mixed
     */
   public function actionLisCus() {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $id = $parents[0];

            $model = Customers::find()->asArray()->where(['CUST_TYPE'=>$id])
                                                     ->andwhere('CUST_GRP = CUST_KD')
                                                     ->andwhere('CUST_TYPE != "" ')
                                                    ->all();
                                                    // print_r($model);
                                                    // die();
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

  /**
     * Depdrop Customers
     * @author wawan
     * @param string $id
     * @since 1.1.0
     * @return mixed
     */
   public function actionLisCusBox($id) {

        $model = Customers::find()->asArray()->where(['CUST_TYPE'=>$id])
                                                     ->andwhere('CUST_GRP = CUST_KD')
                                                     ->andwhere('CUST_TYPE != "" ')
                                                    ->all();
            $items = ArrayHelper::map($model, 'CUST_KD', 'CUST_NM');
            foreach ($model as $key => $value) {
                   // $out[] = [$value['CUST_KD'] => $value['CUST_NM']];
                   // <option value="volvo">Volvo</option>
     $out [] = "<option value=".$value['CUST_KD'].">".$value['CUST_NM']."</option>";
               }

               echo json_encode($out);
             
    
   }

 /**
     * Depdrop Kota
     * @author wawan
     * @param string $id
     * @since 1.1.0
     * @return mixed
     */
    public function actionLisarea() {
    $out = [];

    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $id = $parents[0];

            $model = Kota::find()->asArray()->where(['PROVINCE_ID'=>$id])
                                                    // ->andwhere('CUST_KTG_PARENT <> 0')
                                                    ->all();
                                                    // print_r($model);
                                                    // die();
            //$out = self::getSubCatList($cat_id);
            // the getSubCatList function will query the database based on the
            // cat_id and return an array like below:
            // [
            //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
            //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
            // ]
            foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['CITY_ID'],'name'=> $value['CITY_NAME']];
               }

               echo json_encode(['output'=>$out, 'selected'=>'']);
               return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
   }



 

    /**
     * Create  Customers model.
     * @author wawan
     * @since 1.1.0
     * @param string $id
     * @return mixed
     */

    public function actionCreatecustomers()
    {
        $model = new Customers();
        $model->scenario = "create";
        $datacus = Customers::find()->where("CUST_GRP = CUST_KD AND CUST_KD <>'CUS.2016.000637' AND STATUS<>3")->asArray()->all();
        $parent = ArrayHelper::map($datacus,'CUST_KD', 'CUST_NM');

    if ($model->load(Yii::$app->request->post()) ) {
        $post =Yii::$app->request->post();
        $val = $post['Customers']['parentnama'];
        $kdcity = $model->CITY_ID;
			  $kdpro = $model->PROVINCE_ID;
        if($val == 1)
        {
          	$kode = Yii::$app->ambilkonci->getkeycustomers($kdpro,$kdcity);
            $model->CUST_KD = $kode;
            $model->CUST_GRP = $kode;
        }
        else{
          $kode = Yii::$app->ambilkonci->getkeycustomers($kdpro,$kdcity);
          $model->CUST_KD = $kode;

        }
        
        $tanggal = \Yii::$app->formatter->asDate($model->JOIN_DATE,'Y-M-d');
        $model->JOIN_DATE = $tanggal;
			if($model->validate())
			{
				$model->CORP_ID = Yii::$app->getUserOpt->Profile_user()->emp->EMP_CORP_ID;
				$model->CREATED_BY =  Yii::$app->user->identity->username;
				$model->CREATED_AT = date("Y-m-d H:i:s");

	      $model->save();

        return $this->redirect(['esm-index','id'=>$model->CUST_KD]);

			}
        } else {
            return $this->renderAjax('_formcustomer', [
                'model' => $model,
                'parent'=>$parent
            ]);
        }
      }

  /**
     * validasi ajax in page _formcustomer
     * @author wawan
     * @param string $id
     * @since 1.1.0
     * @return mixed
     */
      public function actionValid()
      {
        # code...
        $post = Yii::$app->request->post();
        if($post['Customers']['parentnama'] == 1)
        {
          $model = new Customers();
          $model->scenario = "create";
        }else{
          $model = new Customers();
          $model->scenario = "parentcreate";
        }

          // $model = new Customers();
        if(Yii::$app->request->isAjax && $model->load($_POST))
        {
          Yii::$app->response->format = 'json';
          return ActiveForm::validate($model);
        }
      }


    /**
     * Updates an existing Kategori model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {


				if($model->validate())
				{
					  $model->UPDATED_AT = date("Y-m-d H:i:s");
						$model->UPDATED_BY = Yii::$app->user->identity->username;
					if($model->save())
          {
            echo 1;
          }
          else{
            echo 0;
          }
				}

          //  return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionMapDetail($cust_kd)
    {
         $model_customers = $this->findModelcust($cust_kd);

         $lock_map = $model_customers->LOCK_MAP;


        $searchModel = new ScheduledetailSearch();
        $dataProvider = $searchModel->searchmapdetail(Yii::$app->request->queryParams);


            return $this->renderAjax('map_detail', [
                'model_customers' => $model_customers,
                'dataProvider'=>$dataProvider,
                'searchModelx'=>$searchModel,
                'lock_map'=>$lock_map
            ]);
    }


    public function actionEditLayers($id){
         $model = $this->findModellayers($id);

          if ($model->load(Yii::$app->request->post()) ) {

              $model->save();

               return $this->redirect(['esm-index-layer']);

          }else{
              return $this->renderAjax('_edit_layers', [
                'model' => $model,
            ]);

          }
    }


    public function actionViewLayers($id){
         $model = $this->findModellayers($id);

          if ($model->load(Yii::$app->request->post()) ) {
               $model->save();
                return $this->redirect(['esm-index-layer']);
          }else{
             return $this->renderAjax('view_layers', [
                'model' => $model,
            ]);
          }
    }


    public function actionDeleteLayers($id){
         $model = $this->findModellayers($id);
         
         $model->delete();

         return $this->redirect(['esm-index-layer']);


    }



   /**
     * update detail map using ajax.
     * @author wawan
     * @since 1.1.0
     * @return mixed
     */
   public function actionUpdateDetailMap(){

            if (Yii::$app->request->isAjax) {

                Yii::$app->response->format = Response::FORMAT_JSON;
                $request= Yii::$app->request;
                $data_latlg=$request->post('val');
                $explode = explode(',',$data_latlg);


                $model = $this->findModelcust($explode[0]);

                $model->MAP_LAT = $explode[1];
                $model->MAP_LNG = $explode[2];
                $model->LOCK_MAP = 1;

                $model->save();

             
         }
         
     return true;
   
       }

    // public function actionUpdateCust($id)
    // {
    //     $model = $this->findModelcust($id);
    //     $datacus = Customers::find()->where('CUST_GRP = CUST_KD')->asArray()->all();
    //     $parent = ArrayHelper::map($datacus,'CUST_KD', 'CUST_NM');
    //     $dropparentkategori = ArrayHelper::map(Kategoricus::find()->where('CUST_KTG_PARENT = CUST_KTG')
    //                                                                ->asArray()
    //                                                                ->all(),'CUST_KTG', 'CUST_KTG_NM');
    //     $readonly = Customers::find()->where(['CUST_KD'=>$id])->asArray()->one(); // data for view type
    //     if ($model->load(Yii::$app->request->post()) ) {

    //     $tanggal = \Yii::$app->formatter->asDate($model->JOIN_DATE,'Y-M-d');
    //     $model->JOIN_DATE = $tanggal;
    //     if($model->validate())
    //     {
    //         $model->UPDATED_AT = date("Y-m-d H:i:s");
    //         $model->UPDATED_BY = Yii::$app->user->identity->username;
    //       if($model->save())
    //       {
    //         echo 1;
    //       }
    //       else{
    //         echo 0;
    //       }
    //     }

    //       //  return $this->redirect(['index']);
    //     } else {
    //         return $this->renderAjax('update', [
    //             'model' => $model,
    //             'parent'=>$parent,
    //             'dropparentkategori'=>$dropparentkategori,
    //             'readonly'=>$readonly
    //         ]);
    //     }
    // }

    // public function actionUpdatekat($id)
    // {
    //     $readonly = Customers::find()->where(['CUST_KD'=>$id])->asArray()->one(); // data for view
    //     $model = $this->findModelcust($id);
    //     $model->scenario = "updatekat";
    //     $dropparentkategori = ArrayHelper::map(Kategoricus::find()->where('CUST_KTG_PARENT = CUST_KTG')
    //                                                                ->asArray()
    //                                                                ->all(),'CUST_KTG', 'CUST_KTG_NM');
    //     if ($model->load(Yii::$app->request->post()) ) {

    //     $tanggal = \Yii::$app->formatter->asDate($model->JOIN_DATE,'Y-M-d');
    //     $model->JOIN_DATE = $tanggal;
    //     if($model->validate())
    //     {
    //         $model->UPDATED_AT = date("Y-m-d H:i:s");
    //         $model->UPDATED_BY = Yii::$app->user->identity->username;
    //       if($model->save())
    //       {
    //         echo 1;

    //       }
    //       else{
    //         echo 0;
    //       }
    //     }

    //       //  return $this->redirect(['index']);
    //     } else {
    //         return $this->renderAjax('type', [
    //             'model' => $model,
    //             'dropparentkategori'=>$dropparentkategori,
    //             'readonly'=>$readonly
    //         ]);
    //     }
    // }

    public function actionUpdateAlias($id)
    {
        $model = Customersalias::find()->where(['KD_CUSTOMERS'=>$id])->one();

        // $model->scenario = 'update';

           // if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
           //  Yii::$app->response->format = Response::FORMAT_JSON;
           //  return ActiveForm::validate($model);
        

        if ($model->load(Yii::$app->request->post()) ) {
          // if ($model->validate()) {
                // all inputs are valid
              $model->UPDATED_AT = date('Y-m-d');
              $model->UPDATED_BY = Yii::$app->user->identity->username;
              $model->save();
            // } 
           
         
            return $this->redirect(['index-alias']);
        } else {
            return $this->renderAjax('alias_customers', [
                'model' => $model,
                'cus_data'=>self::aryData_Customers(),
                'cus_dis'=>self::aryData_Dis()
            ]);
        }
    }

	 // public function actionUpdatecus($id)
  //   {
  //       $readonly = Customers::find()->where(['CUST_KD'=>$id])->asArray()->one(); // data for view
  //       $model = $this->findModelcust($id);
  //       $model->scenario = "detail";
  //       $dropparentkategori = ArrayHelper::map(Kategoricus::find()->where('CUST_KTG_PARENT = CUST_KTG')
  //                                                                  ->asArray()
  //                                                                  ->all(),'CUST_KTG', 'CUST_KTG_NM');
  //     	$droppro = ArrayHelper::map(Province::find()->asArray()->all(),'PROVINCE_ID','PROVINCE');

  //       $dropdis = ArrayHelper::map(\lukisongroup\master\models\Distributor::find()->all(), 'KD_DISTRIBUTOR', 'NM_DISTRIBUTOR');


  //       if ($model->load(Yii::$app->request->post()) ) {

		// 	    if($model->validate())
  //           {
  //             $model->UPDATED_AT = date("Y-m-d H:i:s");
		// 				  $model->UPDATED_BY = Yii::$app->user->identity->username;
  //             // $model->save();

		// 			         if($model->save())
  //                  {
  //                    echo 1;

  //                   }
  //                 else{
  //                     echo 0;
  //                   }
  //           }
  //           // print_r($model->save());
  //           // die();

  //           //  return $this->redirect(['index']);
  //       } else {
  //           return $this->renderAjax('set_detail', [
  //               'model' => $model,
  //               'dropparentkategori'=>$dropparentkategori,
  //               'droppro'=>$droppro,
  //               'dropdis'=>$dropdis,
  //               'readonly'=>$readonly
  //           ]);
  //       }
  //   }


	public function actionUpdatepro($id)
    {
        $model = $this->findModelpro($id);

        if ($model->load(Yii::$app->request->post()) ) {

			    if($model->validate())
              {
                      if($model->save())
                      {
                        echo 1;
                      }
                      else{
                        echo 0;
                      }
            }

            //  return $this->redirect(['index']);
        } else {
            return $this->renderAjax('_formprovince', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Kategori model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */

    public function actionDelete($id)
    {
     	$model = Kategoricus::find()->where(['CUST_KTG'=>$id])->one();
		  $model->STATUS = 3;
		  $model->save();
        return $this->redirect(['index']);
    }


	   public function actionDeletecus($id)
    {


		$model = Customers::find()->where(['CUST_KD'=>$id])->one();

		$model->STATUS = 3;
		$model->save();

        return $this->redirect(['index']);
    }

    public function actionDeleteAlias($id)
    {
        $model = Customersalias::find()->where(['ID'=>$id])->one();
        $model->delete();
       return $this->redirect(['index-alias']);
    }


  
    /**
     * Finds the Kategoricus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kategoricus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
	  protected function findModelpro($id)
    {
        if (($model = Province::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	

    protected function findModelalias($id)
    {
        if (($model = Customersalias::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	 protected function findModelcust($id)
    {
        if (($model = Customers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


     protected function findModellayers($id)
    {
        if (($model = DraftLayer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    
}
