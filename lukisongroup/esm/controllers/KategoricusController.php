<?php

namespace lukisongroup\esm\controllers;

use Yii;
use lukisongroup\esm\models\Kategoricus;
use lukisongroup\esm\models\Customerskat;
use lukisongroup\esm\models\KategoricusSearch;
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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelcus' => $searchModelcus,
            'dataProvider1' => $dataProvider1,
        ]);
    }
    
  

    /**
     * Displays a single Kategori model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Kategori model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateparent()
    {
        $model = new Kategoricus();

        if ($model->load(Yii::$app->request->post()) ) {
                
            if($model->validate())
            {
                $model->CUST_KTG_PARENT = 0;
                $model->CREATED_BY =  Yii::$app->user->identity->username;
                $model->CREATED_AT = date("Y-m-d H:i:s");
                $model->save();
            }
          
            return $this->redirect(['index']);
        } else {
            return $this->render('_formparent', [
                'model' => $model,
            ]);
        }
    }
	
	
    public function actionLiscus($id)
    {
 
        
        $countJob = Kategoricus::find()
                ->where(['CUST_KTG_PARENT' =>$id])
                ->count();
 
        $job = Kategoricus::find()
                 ->where(['CUST_KTG_PARENT' =>$id])
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
    
    
    
     public function actionCreate()
    {
        $model = new Kategoricus();

        if ($model->load(Yii::$app->request->post()) ) {
            
                if($model->validate())
            {
               
                $model->CREATED_BY =  Yii::$app->user->identity->username;
                $model->CREATED_AT = date("Y-m-d H:i:s");
                $model->save();
            }
            
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    
     public function actionCreatecustomers()
    {
        $model = new Customerskat();

        if ($model->load(Yii::$app->request->post()) ) {
            $kddis = Yii::$app->request->post('dis');
             $kdis = explode('.',$kddis);
            
            $query = Customers::find()->select('CUST_KD')->where('STATUS <> 3')->orderBy(['CUST_KD'=>SORT_DESC])->one();
                    if(count($query) == 0)
                 { 
                        $nomerkd= 1; 
                } else { 
                      $kd = explode('.',$query->CUST_KD); 
                      $nomerkd = $kd[3]+1;
                
                     }
                     $tgl = date('Y.m.d');
                     $kode = "CUS.".$kdis[1]."."."CGK.".$tgl.".".str_pad( $nomerkd, "4", "0", STR_PAD_LEFT );
		$model->CUST_KD = $kode;
              
                if($model->validate())
            {
               
                $model->CREATED_BY =  Yii::$app->user->identity->username;
                $model->CREATED_AT = date("Y-m-d H:i:s");
                $model->save();
            }
           
            
            return $this->redirect(['index']);
        } else {
            return $this->render('_formcustomer', [
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->CUST_KTG]);
        } else {
            return $this->render('update', [
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionDeletecus($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * Finds the Kategoricus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kategoricus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kategoricus::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
