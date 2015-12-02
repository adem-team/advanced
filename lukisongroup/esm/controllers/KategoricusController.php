<?php

namespace lukisongroup\esm\controllers;

use Yii;
use lukisongroup\esm\models\Kategoricus;
use lukisongroup\esm\models\Customerskat;
use lukisongroup\esm\models\KategoricusSearch;
use lukisongroup\esm\models\KotaSearch;
use lukisongroup\esm\models\Kota;
use lukisongroup\esm\models\ProvinceSearch;
use lukisongroup\esm\models\Province;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KategoricusController implements the CRUD actions for Kategoricus model.
 */
class KategoricusController extends Controller
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
     * Lists all Kategoricus models.
     * @return mixed
     */
     public function actionIndex()
    {
//        customers data
        $searchModelcus = new \lukisongroup\esm\models\CustomerskatSearch();
        $dataProvider1 = $searchModelcus->searchcus(Yii::$app->request->queryParams);
        
//        kategori data
        $searchModel = new KategoricusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		// city data
		$searchmodelkota = new KotaSearch();
		$dataproviderkota = $searchmodelkota->search(Yii::$app->request->queryParams);
		
		// province data
		$searchmodelpro = new ProvinceSearch();
		$dataproviderpro = $searchmodelpro->search(Yii::$app->request->queryParams);
		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelcus' => $searchModelcus,
			'searchmodelkota' => $searchmodelkota,
			'searchmodelpro' => $searchmodelpro,
			'dataproviderpro' =>  $dataproviderpro,
            'dataProvider1' => $dataProvider1,
			'dataproviderkota' => $dataproviderkota,
        ]);
    }
    
  

    /**
     * Displays a single Kategori model.
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
        return $this->renderAjax('viewcus', [
            'model' => $this->findModel1($id),
        ]);
    }
	
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Kategori model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	   public function actionCreateprovnce()
    {
        $model = new Province();

        if ($model->load(Yii::$app->request->post()) ) {
				
				if($model->validate())
				{
				
						$model->save();
				}
          
            return $this->redirect(['index']);
		}
         else {
            return $this->renderAjax('_formprovince', [
                'model' => $model,
            ]);
        }
    }
	
	
    public function actionCreate()
    {
        $model = new Kategoricus();

        if ($model->load(Yii::$app->request->post()) ) {
			$chk = Yii::$app->request->post('parentid');
			if($chk == 1)
			{
				    if($model->validate())
            {
                $model->CUST_KTG_PARENT = 0;
                $model->CREATED_BY =  Yii::$app->user->identity->username;
                $model->CREATED_AT = date("Y-m-d H:i:s");
                $model->save();
            }
			}
			else{
				
				if($model->validate())
				{
					    $model->CREATED_BY =  Yii::$app->user->identity->username;
						$model->CREATED_AT = date("Y-m-d H:i:s");
						$model->save();
				}
			
				
				
				
			}
		
                
        
          
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }
	
	
    public function actionLis($id)
    {
 
        
        $countJob = Kategoricus::find()
                ->where(['CUST_KTG_PARENT' =>$id])
                ->count();
 
        $job = Kategoricus::find()
                 ->where(['CUST_KTG_PARENT' =>$id])
				 ->andwhere('CUST_KTG_PARENT <> 0')
                ->all();
        
        
        
        if($countJob>0){
            echo "<option> Select  </option>";
            foreach($job as $post){
                
                echo "<option value='".$post->CUST_KTG."'>".$post->CUST_KTG_NM."</option>";
            }
        }
        else{
            echo "<option> - </option>";
        }
  
    }
    
    
    
     // public function actionCreate()
    // {
        // $model = new Kategoricus();

        // if ($model->load(Yii::$app->request->post()) ) {
            
                // if($model->validate())
            // {
               
                // $model->CREATED_BY =  Yii::$app->user->identity->username;
                // $model->CREATED_AT = date("Y-m-d H:i:s");
                // $model->save();
            // }
            
            // return $this->redirect(['index']);
        // } else {
            // return $this->render('create', [
                // 'model' => $model,
            // ]);
        // }
    // }
    
    
     public function actionCreatecustomers()
    {
        $model = new Customerskat();

        if ($model->load(Yii::$app->request->post()) ) {
			$kdpro = $model->PROVINCE_ID;
			$kdcity =  $model->CITY_ID;
			$kddis = $model->KD_DISTRIBUTOR;
             $kdis = explode('.',$kddis);
		
            
            $query = Customerskat::find()->select('CUST_KD')->where('STATUS <> 3')->orderBy(['CUST_KD'=>SORT_DESC])->one();
			
                    if(count($query) == 0)
                 { 
                        $nomerkd= 1; 
                } else { 
                      $kd = explode('.',$query->CUST_KD); 
                      $nomerkd = $kd[3]+1;
                
                     }
					 
					 // print_r( str_pad( $nomerkd, "6", "0", STR_PAD_LEFT ));
			// die();
                     $tgl = date('Y.m.d');
                     $kode = "CUS.".$kdis[1]."."."CGK.".$tgl."."."-"."0".$kdpro."-".$kdcity.".".str_pad( $nomerkd, "9", "0", STR_PAD_LEFT );
		$model->CUST_KD = $kode;
		
              
                if($model->validate())
            {
				$model->CORP_ID = Yii::$app->getUserOpt->Profile_user()->emp->EMP_CORP_ID;
                $model->CREATED_BY =  Yii::$app->user->identity->username;
                $model->CREATED_AT = date("Y-m-d H:i:s");
                $model->save();
            }
           
            
            return $this->redirect(['index']);
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
			
			$chk = Yii::$app->request->post('parentid');
			if($chk == 1)
			{
				    if($model->validate())
            {
                $model->CUST_KTG_PARENT = 0;
				$model->UPDATED_AT = date("Y-m-d H:i:s");
				$model->UPDATED_BY = Yii::$app->user->identity->username;
                $model->save();
            }
			}
			else{
				
				if($model->validate())
				{
					   $model->UPDATED_AT = date("Y-m-d H:i:s");
						$model->UPDATED_BY = Yii::$app->user->identity->username;
						$model->save();
				}
				
				
			}
			
           return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }
	
	 public function actionUpdatecus($id)
    {
        $model = $this->findModel1($id);

        if ($model->load(Yii::$app->request->post()) ) {
			
			    if($model->validate())
                    {
                         $model->UPDATED_AT = date("Y-m-d H:i:s");
						$model->UPDATED_BY = Yii::$app->user->identity->username;
                        
                        $model->save();
                    }
		
             return $this->redirect(['index']);
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
                    
                        
                        $model->save();
                    }
		
             return $this->redirect(['index']);
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
                 
                        
                        $model->save();
                    }
		
             return $this->redirect(['index']);
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
    
		
		$model = Customerskat::find()->where(['CUST_KD'=>$Id])->one();
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
	
	 protected function findModel1($id)
    {
        if (($model = Customerskat::findOne($id)) !== null) {
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