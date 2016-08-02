<?php

namespace lukisongroup\master\controllers;

use Yii;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/*namespace models*/
use lukisongroup\master\models\KotaSearch;
use lukisongroup\master\models\Kota;



/**
 * KotaCustomersController implements the CRUD actions for Customers model.
 */
class KotaCustomersController extends Controller
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
     * Before Action Index
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1.0
     */

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
     * ESM INDEX City
     * Lists all Kota models.
     * @author wawan
     * @since 1.1.0
     */
  public function actionEsmIndexCity()
    {

      // city data
       $searchmodelkota = new KotaSearch();
       $dataproviderkota = $searchmodelkota->search(Yii::$app->request->queryParams);


    /*Tambahal menu side Dinamik */
    $sideMenu_control='esm_customers';
    return $this->render('index-city', [
      'sideMenu_control'=> $sideMenu_control,
      'searchmodelkota' => $searchmodelkota,
      'dataproviderkota'  =>$dataproviderkota ,

    ]);
  }


    /**
     * Displays a single Customer model.
     * @author wawan
     * @since 1.1.0
     * @param string $id
     * @return mixed
     */
    public function actionViewkota($id)
    {
        return $this->renderAjax('viewkota', [
            'model' => $this->findModelkota($id),
        ]);
    }

    /**
    * Create Kota models.
    * @author wawan
    * @since 1.1.0
    * @return mixed
    */
    public function actionCreatekota()
    {
        $model = new Kota();

        if ($model->load(Yii::$app->request->post()) ) {

                if($model->validate())
                {

                  if($model->save())
                  {
                    echo 1;
                  }
                  else{
                    echo 0;
                  }

                }

            // return $this->redirect(['index']);
        }
         else {
            return $this->renderAjax('_formkota', [
                'model' => $model,
            ]);
        }
    }

 /**
     * Updates an existing Kota model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @since 1.1.0
     * @param string $id
     * @return mixed
     */

	public function actionUpdatekota($id)
    {
        $model = $this->findModelkota($id);

        if ($model->load(Yii::$app->request->post()) ) {

			    if($model->validate())
              {
                      if($model->save())
                      {
                        echo 1;
                      }
                      else{
                        echo 0;
                      }

              }

            //  return $this->redirect(['index']);
        } else {
            return $this->renderAjax('_formkota', [
                'model' => $model,
            ]);
        }
    }

     /**
     * Finds the Kota model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kota the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
      protected function findModelkota($id)
    {
        if (($model = Kota::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

 }