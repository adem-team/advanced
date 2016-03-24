<?php

namespace lukisongroup\sistem\controllers;

use Yii;
use lukisongroup\sistem\models\Mdlpermission;
use lukisongroup\sistem\models\MdlpermissionSearch;
use lukisongroup\sistem\models\UserloginSearch;
use lukisongroup\sistem\models\Userlogin;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MdlpermissionController implements the CRUD actions for Mdlpermission model.
 */
class ModulPermissionController extends Controller
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
     * Lists all Mdlpermission models and Modul Erp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserloginSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModelpermision = new MdlpermissionSearch();
        $dataProviderpermision = $searchModelpermision->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelpermision'=>$searchModelpermision,
            'dataProviderpermision'=>$dataProviderpermision
        ]);
    }

    /**
     * Displays a single Mdlpermission model.
     * @param string $id
     * @return mixed
     */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    public function save()
    {
      # code...

      $data = Mdlpermission::find()->asArray()->all();
      $temp = [];
      foreach ($data as $hasil) {
      //     # code...
        // ;
         $temp[] = $hasil['MODUL_ID'];


        }
      return $temp;
    }

    /**
     * Creates a new Mdlpermission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Userlogin();
          $model->scenario = 'createuser';

        if ($model->load(Yii::$app->request->post()) ) {
            $datax = $this->save();


            if($model->save())
            {

            }

            return $this->redirect('index');
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Mdlpermission model.
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
     * Deletes an existing Mdlpermission model.
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
     * Finds the Mdlpermission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Mdlpermission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mdlpermission::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
