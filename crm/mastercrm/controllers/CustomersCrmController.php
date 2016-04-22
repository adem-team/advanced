<?php

namespace crm\mastercrm\controllers;

use Yii;
use lukisongroup\master\models\KategoricusSearch;
use lukisongroup\master\models\DistributorSearch;
use lukisongroup\master\models\Kategoricus;
use lukisongroup\master\models\KotaSearch;
use lukisongroup\master\models\Kota;
use crm\mastercrm\models\ProvinceSearch;
use lukisongroup\master\models\Province;
use crm\mastercrm\models\Customers;
use crm\mastercrm\models\CustomersSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use lukisongroup\master\models\Customersalias;
use lukisongroup\master\models\CustomersaliasSearch;
use yii\widgets\ActiveForm;
use lukisongroup\master\models\ValidationLoginPrice;
use yii\helpers\ArrayHelper;

/**
 * CustomersController implements the CRUD actions for Customers model.
 */
class CustomersCrmController extends Controller
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
     * Lists all Customers models.
     * @return mixed
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


    public function actionIndex()
    {


        $searchModel = new CustomersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

           if(Yii::$app->request->post('hasEditable'))
        {
            $ID = \Yii::$app->request->post('editableKey');
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
                $model->save();

                // custom output to return to be displayed as the editable grid cell
                // data. Normally this is empty - whereby whatever value is edited by
                // in the input by user is updated automatically.
                $output = '';

                // specific use case where you need to validate a specific
                // editable column posted when you have more than one
                // EditableColumn in the grid view. We evaluate here a
                // check to see if buy_amount was posted for the Book model
                if (isset($posted['CUST_KD_ALIAS'])) {
                   // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
                    $output =$model->CUST_KD_ALIAS;
                }

                // similarly you can check if the name attribute was posted as well
                // if (isset($posted['name'])) {
                //   $output =  ''; // process as you need
                // }
                $out = Json::encode(['output'=>$output, 'message'=>'']);


            // return ajax json encoded response and exit
            echo $out;

            return;
          }

        }

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}


  /*CRM INDEX map */
  public function actionCrmMap()
    {

    /*Tambahal menu side Dinamik */
    // $sideMenu_control='esm_customers';
    return $this->render('map', [
      // 'sideMenu_control'=> $sideMenu_control,

    ]);
  }






	  public function actionViewcust($id)
    {
        return $this->renderAjax('viewcus', [
            'model' => $this->findModelcust($id),
        ]);
    }


    public function actionViewAlias($id)
    {
        return $this->renderAjax('view_alias', [
            'model' => $this->findModelalias($id),
        ]);
    }

	public function actionAliasCodeView($id)
    {
      $model = new Customersalias();
      $searchModel = new CustomersaliasSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);



      $id = Customers::find()->where(['CUST_KD'=>$id])->one();
      $nama = $id->CUST_NM;
      if ($model->load(Yii::$app->request->post()) ) {
        $model->CREATED_AT = date('Y-m-d');
        $model->CREATED_BY = Yii::$app->user->identity->username;
        $model->KD_PARENT = 1;
        if($model->save())
        {
          echo 1;

        }
        else{
          echo 0;
        }
      } else {
          return $this->renderAjax('_aliascus', [
              'model' => $model,
              'id'=>$id,
              'nama'=>$nama,
              'searchModel'=>$searchModel,
              'dataProvider'=>$dataProvider
          ]);
      }
    }




    public function actionCreateAliasCustomers($id)
    {
        $model = new Customersalias();
        $id = Customers::find()->where(['CUST_KD'=>$id])->one();
        $nama = $id->CUST_NM;
        if ($model->load(Yii::$app->request->post()) ) {
          $model->CREATED_AT = date('Y-m-d');
          $model->CREATED_BY = Yii::$app->user->identity->username;
          $model->KD_PARENT = 1;
          if($model->save())
          {
            echo 1;
          }
          else{
            echo 0;
          }
        } else {
            return $this->renderAjax('alias_customers', [
                'model' => $model,
                'id'=>$id,
                'nama'=>$nama,
            ]);
        }
    }

    public function actionValidAlias()
    {
      # code...
        $model = new Customersalias();
      if(Yii::$app->request->isAjax && $model->load($_POST))
      {
        Yii::$app->response->format = 'json';
        return ActiveForm::validate($model);
      }
    }
    public function actionLoginAlias()
    {
      # code...
      $ValidationLoginPrice = new ValidationLoginPrice();
      return $this->renderAjax('login_alias', [
        'ValidationLoginPrice' => $ValidationLoginPrice,
      ]);
    }

    public function actionLoginCek(){
      $ValidationLoginPrice = new ValidationLoginPrice();
      /*Ajax Load*/
      if(Yii::$app->request->isAjax){
        $ValidationLoginPrice->load(Yii::$app->request->post());
        return Json::encode(\yii\widgets\ActiveForm::validate($ValidationLoginPrice));
      }else{	/*Normal Load*/
        if($ValidationLoginPrice->load(Yii::$app->request->post())){
          if ($ValidationLoginPrice->Validationlogin()){
            return $this->redirect(['/master/customers/index-alias']);
          }
        }
      }
    }

    public function actionIndexAlias()
    {
      # code...
      $searchModel = new CustomersaliasSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index_alias', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,
          ]);
    }

    public function actionPriceLogout(){
  		$this->redirect('esm-index');
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
               'model' => $model,
           ]);
         }
     }


 // data json map
    public function actionMap()
    {
            $conn = Yii::$app->db3;
            $hasil = $conn->createCommand("SELECT c.SCDL_GROUP,c.CUST_KD, c.ALAMAT, c.CUST_NM,c.MAP_LAT,c.MAP_LNG,b.SCDL_GROUP_NM from c0001 c
                                          left join c0007 b on c.SCDL_GROUP = b.ID")->queryAll();

            //  $hasil = $conn->createCommand("SELECT * from c0001 ")->queryAll();

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

   // action depdrop
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
                   $out[] = ['id'=>$value['POSTAL_CODE'],'name'=> $value['CITY_NAME']];
               }

               echo json_encode(['output'=>$out, 'selected'=>'']);
               return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
   }



  //   public function actionLis($id)
  //   {


  //       $countJob = Kategoricus::find()
  //               ->where(['CUST_KTG_PARENT' =>$id])
  //               ->count();

  //       $job = Kategoricus::find()
  //                ->where(['CUST_KTG_PARENT' =>$id])
		// 		 ->andwhere('CUST_KTG_PARENT <> 0')
  //               ->all();



  //       if($countJob>0){
  //           echo "<option> Select  </option>";
  //           foreach($job as $post){

  //               echo "<option value='".$post->CUST_KTG."'>".$post->CUST_KTG_NM."</option>";
  //           }
  //       }
  //       else{
  //           echo "<option> - </option>";
  //       }

  //   }




    public function actionCreatecustomers()
    {
        $model = new Customers();
        $model->scenario = "create";
        $datacus = Customers::find()->where('CUST_GRP = CUST_KD')->asArray()->all();
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
        // print_r($val);
        // die();



        $tanggal = \Yii::$app->formatter->asDate($model->JOIN_DATE,'Y-M-d');
        $model->JOIN_DATE = $tanggal;
			if($model->validate())
			{
				$model->CORP_ID = Yii::$app->getUserOptcrm->Profile_user()->userprofile->CORP_ID;
				$model->CREATED_BY =  Yii::$app->user->identity->username;
				$model->CREATED_AT = date("Y-m-d H:i:s");

				if($model->save())
        {
          echo 1;
        }
        else{
          echo 0;
        }

			}
        } else {
            return $this->renderAjax('_formcustomer', [
                'model' => $model,
                'parent'=>$parent
            ]);
        }
      }

      // validasi ajax for _formcustomer
      public function actionValid()
      {
        # code...
          $model = new Customers();
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

    public function actionUpdateCust($id)
    {
        $model = $this->findModelcust($id);
        $datacus = Customers::find()->where('CUST_GRP = CUST_KD')->asArray()->all();
        $parent = ArrayHelper::map($datacus,'CUST_KD', 'CUST_NM');
        $dropparentkategori = ArrayHelper::map(Kategoricus::find()->where('CUST_KTG_PARENT = CUST_KTG')
                                                                   ->asArray()
                                                                   ->all(),'CUST_KTG', 'CUST_KTG_NM');
        $readonly = Customers::find()->where(['CUST_KD'=>$id])->asArray()->one(); // data for view type
        if ($model->load(Yii::$app->request->post()) ) {

        $tanggal = \Yii::$app->formatter->asDate($model->JOIN_DATE,'Y-M-d');
        $model->JOIN_DATE = $tanggal;
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
            return $this->renderAjax('_updatedetail', [
                'model' => $model,
                'parent'=>$parent,
                'dropparentkategori'=>$dropparentkategori,
                'readonly'=>$readonly
            ]);
        }
    }

    public function actionUpdatekat($id)
    {
        $readonly = Customers::find()->where(['CUST_KD'=>$id])->asArray()->one(); // data for view
        $model = $this->findModelcust($id);
        $model->scenario = "updatekat";
        $dropparentkategori = ArrayHelper::map(Kategoricus::find()->where('CUST_KTG_PARENT = CUST_KTG')
                                                                   ->asArray()
                                                                   ->all(),'CUST_KTG', 'CUST_KTG_NM');
        if ($model->load(Yii::$app->request->post()) ) {

        $tanggal = \Yii::$app->formatter->asDate($model->JOIN_DATE,'Y-M-d');
        $model->JOIN_DATE = $tanggal;
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
            return $this->renderAjax('_updatekategori', [
                'model' => $model,
                'dropparentkategori'=>$dropparentkategori,
                'readonly'=>$readonly
            ]);
        }
    }

    public function actionUpdateAlias($id)
    {
        $model = Customersalias::find()->where(['KD_CUSTOMERS'=>$id])->one();

        $id = Customers::find()->where(['CUST_KD'=>$id])->one();

        $nama = $id->CUST_NM;

        if(Yii::$app->request->isAjax && $model->load($_POST))
        {
          Yii::$app->response->format = 'json';
          return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) ) {
          $model->UPDATED_AT = date('Y-m-d');
          $model->UPDATED_BY = Yii::$app->user->identity->username;
          $model->save();
            return $this->redirect(['index-alias']);
        } else {
            return $this->renderAjax('alias_customers', [
                'model' => $model,
                'id'=>$id,
                'nama'=>$nama,
            ]);
        }
    }

	 public function actionUpdatecus($id)
    {
        $readonly = Customers::find()->where(['CUST_KD'=>$id])->asArray()->one(); // data for view
        $model = $this->findModelcust($id);
        $model->scenario = "detail";
        $dropparentkategori = ArrayHelper::map(Kategoricus::find()->where('CUST_KTG_PARENT = CUST_KTG')
                                                                   ->asArray()
                                                                   ->all(),'CUST_KTG', 'CUST_KTG_NM');
      	$droppro = ArrayHelper::map(Province::find()->asArray()->all(),'PROVINCE_ID','PROVINCE');

        $dropdis = ArrayHelper::map(\lukisongroup\master\models\Distributor::find()->all(), 'KD_DISTRIBUTOR', 'NM_DISTRIBUTOR');


        if ($model->load(Yii::$app->request->post()) ) {

			    if($model->validate())
            {
              $model->UPDATED_AT = date("Y-m-d H:i:s");
						  $model->UPDATED_BY = Yii::$app->user->identity->username;
              // $model->save();

					         if($model->save())
                   {
                     echo 1;

                    }
                  else{
                      echo 0;
                    }
            }
            // print_r($model->save());
            // die();

            //  return $this->redirect(['index']);
        } else {
            return $this->renderAjax('_updatealamat', [
                'model' => $model,
                'dropparentkategori'=>$dropparentkategori,
                'droppro'=>$droppro,
                'dropdis'=>$dropdis,
                'readonly'=>$readonly
            ]);
        }
    }



    /**
     * Finds the Kategoricus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kategoricus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */


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

}