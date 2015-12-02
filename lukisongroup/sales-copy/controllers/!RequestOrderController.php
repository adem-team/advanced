<?php

namespace lukisongroup\purchasing\controllers;

use Yii;
use app\master\models\MasterCustomer;
use app\master\models\MasterCustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterCustomerController implements the CRUD actions for MasterCustomer model.
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
     * Lists all MasterCustomer models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$searchModel = new MasterCustomerSearch();
        //$cust = array_merge(Yii::$app->request->post(),Yii::$app->request->queryParams);
        //$dataProvider = $searchModel->search($cust);

        return $this->render('index'//, [
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        //]
		);
    }

    /**
     * Displays a single MasterCustomer model.
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
     * Creates a new MasterCustomer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		/*
        $model = new MasterCustomer();

        if ($model->load(Yii::$app->request->post())) {
//            print_r(Yii::$app->request->post('parentid'));
//            die();
          
              $tr = Yii::$app->db->beginTransaction();
            try{
                
//               $cek=\Yii::$app->db->createCommand("select CustomerID from MasterCustomer where CustomerID='".$model->CustomerID."'")->queryScalar();
//               if($cek == $model->CustomerID )
//               {
//                   
//                Yii::$app->getSession()->setFlash('error', 'CustomerID Dengan ID '.$model->CustomerID.'  sudah Ada,Terima Kasih');
//                return $this->redirect('./index.php?r=master/master-customer/create');
//               }
              if(Yii::$app->request->post('parentid') == NULL)
            {
                $model->ParentID = Yii::$app->request->post('parent');
            } else {
                
                $model->ParentID = $model->CustomerID;
            }
                $model->IDAbsenType = Yii::$app->request->post('absen');
                $model->UserCrt = Yii::$app->user->getId();            
                $model->DateCrt = new \yii\db\Expression(' getdate() ');
                if($model->validate()){
                    $model->save();
                    $tr->commit();
                    return $this->redirect(['master-customer/index', 'id' => $model->CustomerID]);
                
                }else{
                    Yii::$app->session->setFlash('error', $model->getErrors()); 
                     $tr->rollback();
                    return $this->render('create', ['model' => $model,]);
                }
            } catch (Exception $ex) {
                 $tr->rollback();
                 Yii::$app->session->setFlash('error', $ex->getMessage()); 
                 return $this->render('create', ['model' => $model,]);
//                echo 'Error Save CostCal: ',  $ex->getMessage(), "\n";
            }
          
          
        } else {
			*/
            return $this->render('create'//, [
                //'model' => $model,
           // ]
			);
       // }
    }

    /**
     * Updates an existing MasterCustomer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            
            $model->UserUpdate= Yii::$app->user->getId();
            $model->DateUpdate=date('Y-m-d h:i:s');
            $model->IDAbsenType = Yii::$app->request->post('absen');
            $model->save();
            return $this->redirect('./index.php?r=master/master-customer');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MasterCustomer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the MasterCustomer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MasterCustomer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterCustomer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
