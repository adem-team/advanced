<?php

namespace lukisongroup\master\controllers;

use Yii;
use lukisongroup\master\models\Termcustomers;
use lukisongroup\master\models\Termgeneral;
use lukisongroup\master\models\Terminvest;
use lukisongroup\master\models\TerminvestSearch;
use lukisongroup\master\models\Termbudget;
use lukisongroup\master\models\TermgeneralSearch;
use lukisongroup\master\models\TermcustomersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TermCustomersController implements the CRUD actions for Termcustomers model.
 */
class TermCustomersController extends Controller
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
     * Lists all Termcustomers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TermcustomersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Termcustomers model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

      $searchModel = new TermgeneralSearch();
      $dataProvider = $searchModel->searchtermgeneral(Yii::$app->request->queryParams,$id);

      $searchModel1 = new TerminvestSearch();
      $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel'=>   $searchModel,
            'dataProvider' =>  $dataProvider,
            'searchModel1'=>   $searchModel1,
            'dataProvider1' =>  $dataProvider1
        ]);
    }

    /**
     * Creates a new Termcustomers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $general = new Termgeneral();

        $model = new Termcustomers();

        $inves = new Terminvest();

        $BUDGET = new Termbudget();

        if ($model->load(Yii::$app->request->post()) && $inves->load(Yii::$app->request->post()) && $general->load(Yii::$app->request->post()) || $BUDGET->load(Yii::$app->request->post()) ) {
          $model->ID_TERM = Yii::$app->ambilkonci->getkdTerm();
          if($model->validate())
          {
              $model->CREATED_AT = date("Y-m-d H:i:s");
              $model->CREATED_BY = Yii::$app->user->identity->username;
              $model->save();
          }
              $inves->CREATE_AT = date("Y-m-d H:i:s");
              $inves->CREATE_BY = Yii::$app->user->identity->username;
              $inves->save();

              $general->ID_TERM = $model->ID_TERM;
              $general->CREATE_AT = date("Y-m-d H:i:s");
              $general->CREATE_BY = Yii::$app->user->identity->username;
              $general->save();

              $BUDGET->CREATE_AT = date("Y-m-d H:i:s");
              $BUDGET->CREATE_BY = Yii::$app->user->identity->username;
              $BUDGET->save();
            return $this->redirect(['view','id'=>$model->ID_TERM]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'general'=> $general,
                'inves'=> $inves,

            ]);
        }
    }

    /**
     * Updates an existing Termcustomers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
          if($model->validate())
  				{
  					  $model->UPDATED_AT = date("Y-m-d H:i:s");
  						$model->UPDATED_BY = Yii::$app->user->identity->username;
              $model->save();
          }
            return $this->redirect(['view', 'id' => $model->ID_TERM]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Termcustomers model.
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
     * Finds the Termcustomers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Termcustomers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Termcustomers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
