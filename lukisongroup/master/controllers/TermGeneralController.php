<?php

namespace lukisongroup\master\controllers;

use Yii;
use lukisongroup\master\models\Termgeneral;
use lukisongroup\master\models\TermgeneralSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * TermGeneralController implements the CRUD actions for Termgeneral model.
 */
class TermGeneralController extends Controller
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
     * Lists all Termgeneral models.
     * @return mixed
     */
    public function actionIndex()
    {
        // $data = Termgeneral::find()->where('ID')->one();
        $searchModel = new TermgeneralSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data'=>$data
        ]);
    }

    /**
     * Displays a single Termgeneral model.
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
     * Creates a new Termgeneral model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */



    public function actionCreate()
    {
        $model = new Termgeneral();

        if ($model->load(Yii::$app->request->post()) ) {

           $model->image = UploadedFile::getInstance($model, 'image');

           $data = $this->saveimage(file_get_contents($model->image->tempName));

           $model->ISI_TERM =$data ;
           $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }



    /**
     * Updates an existing Termgeneral model.
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
              $model->UPDATE_AT = date("Y-m-d H:i:s");
              $model->UPDATE_BY = Yii::$app->user->identity->username;
              $model->save();
          }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Termgeneral model.
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
     * Finds the Termgeneral model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Termgeneral the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Termgeneral::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
