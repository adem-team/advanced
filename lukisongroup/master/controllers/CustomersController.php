<?php

namespace lukisongroup\master\controllers;

use Yii;
use lukisongroup\master\models\KategoricusSearch;
use lukisongroup\master\models\DistributorSearch;
use lukisongroup\master\models\Kategoricus;
use lukisongroup\master\models\KotaSearch;
use lukisongroup\master\models\Kota;
use lukisongroup\master\models\ProvinceSearch;
use lukisongroup\master\models\Province;
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\CustomersSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use lukisongroup\master\models\Customersalias;
use lukisongroup\master\models\CustomersaliasSearch;
use yii\widgets\ActiveForm;
use lukisongroup\master\models\ValidationLoginPrice;

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
       // city data
        $searchmodelkota = new KotaSearch();
        $dataproviderkota = $searchmodelkota->search(Yii::$app->request->queryParams);

        // province data
        $searchmodelpro = new ProvinceSearch();
        $dataproviderpro = $searchmodelpro->search(Yii::$app->request->queryParams);

        $searchModel1 = new KategoricusSearch();
        $dataProviderkat  = $searchModel1->searchparent(Yii::$app->request->queryParams);

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
			'searchModel1' => $searchModel1,
			'dataProviderkat'  =>$dataProviderkat ,
      'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
      'searchmodelkota' => $searchmodelkota,
      'searchmodelpro' => $searchmodelpro,
      'dataproviderpro' =>  $dataproviderpro,
      'dataproviderkota' => $dataproviderkota,

        ]);
	}


    /**
     * Displays a single Customer model.
     * @param string $id
     * @return mixed
     */
    public function actionViewkota($id)
    {
        return $this->renderAjax('viewkota', [
            'model' => $this->findModelkota($id),
        ]);
    }

	 public function actionViewpro($id)
    {
        return $this->renderAjax('viewpro', [
            'model' => $this->findModelpro($id),
        ]);
    }


	  public function actionViewcust($id)
    {
        return $this->render('viewcus', [
            'model' => $this->findModelcust($id),
        ]);
    }

    public function actionView($id)
    {
        return $this->renderAjax('viewkat', [
            'model' => $this->findModel($id),
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

           return $this->redirect(['viewcust','id'=>$model->CUST_KD]);
         }
         else {
           # code...
           return $this->render('_formaddmap', [
             'id'=>$id,
               'model' => $model,
           ]);
         }
     }

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

     public function actionCreatekota()
    {
        $model = new Kota();

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
            return $this->renderAjax('_formkota', [
                'model' => $model,
            ]);
        }
    }


    public function actionCreate($id)
    {

        $model = new Kategoricus();

        $cus = Kategoricus::find()->where(['CUST_KTG'=> $id ])->one();
        $par = $cus['CUST_KTG'];

        if ($model->load(Yii::$app->request->post()) ) {

          $model->CUST_KTG_PARENT = $par;

				if($model->validate())
				{
            $model->STATUS = 1;
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

            // return $this->redirect(['index']);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

 // data json map
    public function actionMap()
    {
            $conn = Yii::$app->db3;
            $hasil = $conn->createCommand("SELECT ALAMAT, CUST_NM,MAP_LAT,MAP_LNG from c0001")->queryAll();
            echo json_encode($hasil);

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




     public function actionCreateparent()
    {
        $model = new Kategoricus();

        if ($model->load(Yii::$app->request->post()) ) {
          $data = Kategoricus::find()->count();
          if($data == 0)
          {

              $model->CUST_KTG_PARENT = 1;
          }
          else{
              $datax = Kategoricus::find()->MAX('CUST_KTG');

                $model->CUST_KTG_PARENT = $datax+1;
          }

       	    if($model->validate())
            {


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
              // print_r($model);
              //   die();
            // return $this->redirect(['index']);
        } else {
            return $this->renderAjax('_formparent', [
                'model' => $model,
            ]);
        }
    }


    public function actionCreatecustomers()
    {
        $model = new Customers();

    if ($model->load(Yii::$app->request->post()) ) {
        $kdcity = $model->CITY_ID;
			  $kdpro = $model->PROVINCE_ID;
			  $kode = Yii::$app->ambilkonci->getkeycustomers($kdpro,$kdcity);
			  $model->CUST_KD = $kode;
			if($model->validate())
			{
				$model->CORP_ID = Yii::$app->getUserOpt->Profile_user()->emp->EMP_CORP_ID;
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
            ]);
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
        $model = $this->findModelcust($id);

        if ($model->load(Yii::$app->request->post()) ) {

			    if($model->validate())
            {
              $model->UPDATED_AT = date("Y-m-d H:i:s");
						  $model->UPDATED_BY = Yii::$app->user->identity->username;
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
            return $this->renderAjax('_formcustomer', [
                'model' => $model,
            ]);
        }
    }

	public function actionUpdatekota($id)
    {
        $model = $this->findModelkota($id);

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
            return $this->renderAjax('_formkota', [
                'model' => $model,
            ]);
        }
    }

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
	  // public function actionDeletepro($id)
    // {
     	// $model = Province::find()->where(['PROVINCE_ID'=>$id])->one();
		// $model->STATUS = 3;
		// $model->save();
        // return $this->redirect(['index']);
    // }

	  // public function actionDeletekota($id)
    // {
     	// $model = Kota::find()->where(['CITY_ID'=>$id])->one();
		// $model->STATUS = 3;
		// $model->save();
        // return $this->redirect(['index']);
    // }

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
	  protected function findModelkota($id)
    {
        if (($model = Kota::findOne($id)) !== null) {
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



    protected function findModel($id)
    {
        if (($model = Kategoricus::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
