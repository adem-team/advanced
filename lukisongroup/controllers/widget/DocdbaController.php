<?php

namespace lukisongroup\controllers\widget;

use Yii;
use lukisongroup\models\widget\doc\Docdba;
use lukisongroup\models\widget\doc\DocdbaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DocdbaController implements the CRUD actions for Docdba model.
 */
class DocdbaController extends Controller
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
     * Lists all Docdba models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocdbaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Docdba model.
     * @param string $ID
     * @param string $MDL_ID
     * @return mixed
     */
    public function actionView($ID, $MDL_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID, $MDL_ID),
        ]);
    }

    /**
     * Creates a new Docdba model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Docdba();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'MDL_ID' => $model->MDL_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Docdba model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $ID
     * @param string $MDL_ID
     * @return mixed
     */
    public function actionUpdate($ID, $MDL_ID)
    {
        $model = $this->findModel($ID, $MDL_ID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'MDL_ID' => $model->MDL_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Docdba model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $ID
     * @param string $MDL_ID
     * @return mixed
     */
    public function actionDelete($ID, $MDL_ID)
    {
        $this->findModel($ID, $MDL_ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Docdba model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $ID
     * @param string $MDL_ID
     * @return Docdba the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID, $MDL_ID)
    {
        if (($model = Docdba::findOne(['ID' => $ID, 'MDL_ID' => $MDL_ID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
