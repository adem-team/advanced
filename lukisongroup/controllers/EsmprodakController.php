<?php

namespace lukisongroup\controllers;

use Yii;
use app\models\esm\Maxiprodak;
use app\models\esm\MaxiprodakSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\ContentNegotiator;
use yii\web\Response;
//use yii\web\Request;
//use yii\web\Response;
//use yii\rest\Controller;

/**
 * MaxiprodakController implements the CRUD actions for Maxiprodak model.
 */
class EsmprodakController extends Controller
{
    public function behaviors()
    {
        return [

            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    //'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Maxiprodak models.
     * @return mixed
     */
    public function actionIndex()
    {
        //Yii::$app->response->format = Response::FORMAT_JSON;
        $searchModel = new MaxiprodakSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       //echo  \yii\helpers\Json::encode($dataProvider->getModels());
        return $this->render('Index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Maxiprodak model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
        //echo  \yii\helpers\Json::encode($this->findModel($id));
    }

    /**
     * Creates a new Maxiprodak model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Maxiprodak();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->BRG_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Maxiprodak model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->BRG_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Maxiprodak model.
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
     * Finds the Maxiprodak model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Maxiprodak the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Maxiprodak::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
