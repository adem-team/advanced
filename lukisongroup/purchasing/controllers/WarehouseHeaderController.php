<?php

namespace lukisongroup\purchasing\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use lukisongroup\purchasing\models\warehouse\HeaderDetailRcvd;
use lukisongroup\purchasing\models\warehouse\HeaderDetailRcvdSearch;
use lukisongroup\purchasing\models\warehouse\HeaderDetailRelease;
use lukisongroup\purchasing\models\warehouse\HeaderDetailReleaseSearch;


/**
 * HeaderDetailRcvdController implements the CRUD actions for HeaderDetailRcvd model.
 */
class WarehouseHeaderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
	
    /**
     * Lists all HeaderDetailRcvd models.
     * @return mixed
     */
    public function actionIndex()
    {
		//RCVD
		$searchModelRcvd = new HeaderDetailRcvdSearch();
        $dataProviderRcvd = $searchModelRcvd->search(Yii::$app->request->queryParams);

    	//RELEASE
		$searchModelRelease = new HeaderDetailReleaseSearch();
        $dataProviderRelease = $searchModelRelease->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModelRcvd' => $searchModelRcvd,
            'dataProviderRcvd' => $dataProviderRcvd,
			'searchModelRelease' => $searchModelRelease,
            'dataProviderRelease' => $dataProviderRelease,
        ]);
    }

    /**
     * Displays a single HeaderDetailRcvd model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HeaderDetailRcvd model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HeaderDetailRcvd();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing HeaderDetailRcvd model.
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
     * Deletes an existing HeaderDetailRcvd model.
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
     * Finds the HeaderDetailRcvd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HeaderDetailRcvd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HeaderDetailRcvd::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
