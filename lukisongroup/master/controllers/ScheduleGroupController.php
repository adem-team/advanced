<?php

namespace lukisongroup\master\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use lukisongroup\master\models\Schedulegroup;
use lukisongroup\master\models\SchedulegroupSearch;

use lukisongroup\master\models\Customers;
use lukisongroup\master\models\CustomersSearch;
use yii\helpers\ArrayHelper;

/**
 * ScheduleGroupController implements the CRUD actions for Schedulegroup model.
 */
class ScheduleGroupController extends Controller
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
     * Lists all Schedulegroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SchedulegroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		      $searchModelCustGrp = new CustomersSearch();
          $dpListCustGrp = $searchModelCustGrp->searchCustGrp(Yii::$app->request->queryParams);

          $aryStt= [
              ['STATUS' => 0, 'STT_NM' => 'DISABLE'],
              ['STATUS' => 1, 'STT_NM' => 'ENABLE'],
          ];
          $valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');

          $query = Schedulegroup::find()->all();

          $data =  ArrayHelper::map($query, 'ID', 'SCDL_GROUP_NM');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			      'dpListCustGrp'=>$dpListCustGrp,
              'data' =>  $data,
              'valStt' => $valStt
        ]);
    }

    /**
     * Displays a single Schedulegroup model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Schedulegroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Schedulegroup();

        if ($model->load(Yii::$app->request->post())) {

          if($model->validate())
          {
            $model->CREATE_BY = Yii::$app->user->identity->username;
            $model->CREATE_AT =  date("Y-m-d H:i:s");
            $model->save();
          }

            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateGroup($CUST_KD)
    {
        $model = Customers::find()->where(['CUST_KD'=>$CUST_KD])->one();

        if (Yii::$app->request->isAjax) {
          $request= Yii::$app->request;
          $nama=$request->post('name');
          // print_r($nama);
          // die();
          //\Yii::$app->response->format = Response::FORMAT_JSON;
          $model->SCDL_GROUP = $nama;

          //$ro->NM_BARANG=''
          if($model->save())
          {
            echo 1;
          }
          else{
            echo 0;
          }
          // return true;
        }




    }

    /**
     * Updates an existing Schedulegroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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

    /**
     * Deletes an existing Schedulegroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Schedulegroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Schedulegroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Schedulegroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
