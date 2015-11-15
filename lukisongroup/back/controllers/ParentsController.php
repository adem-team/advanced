<?php

namespace lukisongroup\back\controllers;

use Yii;
use lukisongroup\back\models\Parents;
use lukisongroup\back\models\ParentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ParentsController implements the CRUD actions for Parents model.
 */
class ParentsController extends Controller
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
     * Lists all Parents models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Parents model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($parent_id,$parent)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($parent_id,$parent),
        ]);
    }

    /**
     * Creates a new Parents model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Parents();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/parents/parents']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Parents model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
     public function actionUpdate($parent_id, $parent)
    {
        $model = $this->findModel($parent_id, $parent);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/parents/parents']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Parents model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($parent_id)
    {
        $this->findModel($parent_id)->delete();

        return $this->redirect(['/parents/parents']);
    }

    /**
     * Finds the Parents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Parents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Parents::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
