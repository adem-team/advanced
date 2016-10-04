<?php

namespace lukisongroup\master\controllers;

use Yii;
use lukisongroup\master\models\Barangalias;
use lukisongroup\master\models\Barang;
use lukisongroup\master\models\BarangaliasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BarangaliasController implements the CRUD actions for Barangalias model.
 */
class BarangaliasController extends Controller
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
     * Lists all Barangalias models.
     * @return mixed
     */
  
    public function actionProduct() {
     $out = [];
     if (isset($_POST['depdrop_parents'])) {
         $parents = $_POST['depdrop_parents'];
         if ($parents != null) {
             $id = $parents[0];

             $model = Barang::find()->asArray()->where(['PARENT'=>$id])
                                               ->andwhere('STATUS <> 3')
                                               ->all();
                                                     // print_r($model);
                                                     // die();
             //$out = self::getSubCatList($cat_id);
             // the getSubCatList function will query the database based on the
             // cat_id and return an array like below:
             // [
             //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
             //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
             // ]
             foreach ($model as $key => $value) {
                    $out[] = ['id'=>$value['KD_BARANG'],'name'=> $value['NM_BARANG']];
                }

                echo json_encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }


    /**
     * Displays a single Barangalias model.
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
     * Creates a new Barangalias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Barangalias();

        if ($model->load(Yii::$app->request->post()) ) {
          $model->CREATED_AT = date('Y-m-d');
          $model->CREATED_BY = Yii::$app->user->identity->username;
          $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Barangalias model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
          $model->UPDATE_AT = date('Y-m-d');
          $model->UPDATE_BY = Yii::$app->user->identity->username;
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Barangalias model.
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
     * Finds the Barangalias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Barangalias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Barangalias::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
