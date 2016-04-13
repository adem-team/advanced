<?php

namespace lukisongroup\purchasing\controllers;

use Yii;
use lukisongroup\purchasing\models\stck\StockRcvd;
use lukisongroup\purchasing\models\stck\TipeStock;
use lukisongroup\purchasing\models\stck\StockRcvdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * StockRcvdController implements the CRUD actions for StockRcvd model.
 */
class StockRcvdController extends Controller
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
     * Lists all StockRcvd models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StockRcvdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StockRcvd model.
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
     * Creates a new StockRcvd model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StockRcvd();
		$searchModel = new StockRcvdSearch();
        $dataProvider = $searchModel->searchRcvd(Yii::$app->request->queryParams);
        // * data tipe for form stock rcvd

        $tipe = ArrayHelper::map(TipeStock::find()->asArray()->all(), 'ID', 'NOTE');
        // $brg = ArrayHelper::map(::find()->asArray()->all(), 'ID', 'NOTE');
        // $tipe = TipeStock::find()->asArray()->all();

		if ($model->load(Yii::$app->request->post())) {
       $model->save();
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
				        'searchModel' => $searchModel,
				        'dataProvider' => $dataProvider,
                'tipe'=>$tipe
            ]);
        }
    }

    /**
     * Updates an existing StockRcvd model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing StockRcvd model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StockRcvd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return StockRcvd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StockRcvd::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
