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
use lukisongroup\master\models\KategoricusSearch;
use lukisongroup\master\models\Kategoricus;


	
/**
 * CustomersKategoriController implements the CRUD actions for Customers model.
 */
class CustomersKategoriController extends Controller
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
     * ESM INDEX Kategori Customers
     * Lists all Kategoricus models.
     * @author wawan
     * @since 1.1.0
     */
  public function actionEsmIndexKategori()
    {

      $searchModel1 = new KategoricusSearch();
      $dataProviderkat  = $searchModel1->searchparent(Yii::$app->request->queryParams);


      /*Tambahal menu side Dinamik */
      $sideMenu_control='esm_customers';
      return $this->render('index-kategori', [
        'sideMenu_control'=> $sideMenu_control,
        'searchModel1' => $searchModel1,
        'dataProviderkat'  =>$dataProviderkat ,

      ]);
  }



    /**
     * Updates an existing Kategori model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */

  public function actionUpdateKate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {


        if($model->validate())
        {
            $model->UPDATED_AT = date("Y-m-d H:i:s");
            $model->UPDATED_BY = Yii::$app->user->identity->username;
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
            return $this->renderAjax('_form_child', [
                'model' => $model,
            ]);
        }
    }



    /**
     * Displays a single Barang model.
     * @author wawan
     * @since 1.1.0
     * @param string $ID
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('viewkat', [
            'model' => $this->findModel($id),
        ]);
    }
    



    /**
     * Create  Kategoricus model.
     * Create child Kategoricus By parent.
     * @author wawan
     * @since 1.1.0
     * @param string $id
     * @return mixed
     */
    public function actionCreate($id)
    {

        $model = new Kategoricus();

        $cus = Kategoricus::find()->where(['CUST_KTG'=> $id ])->one();
        $par = $cus['CUST_KTG'];

        if ($model->load(Yii::$app->request->post()) ) {

          $model->CUST_KTG_PARENT = $par;

				if($model->validate())
				{
            $model->STATUS = 1;
					  $model->CREATED_BY =  Yii::$app->user->identity->username;
						$model->CREATED_AT = date("Y-m-d H:i:s");
            if($model->save())
            {
              echo 1;
            }
            else{
              echo 0;
            }

				}

            // return $this->redirect(['index']);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

 


    /**
     * Create  Kategoricus model.
     * Create  parent Kategoricus.
     * @author wawan
     * @since 1.1.0
     * @return mixed
     */
     public function actionCreateparent()
    {
        $model = new Kategoricus();

        if ($model->load(Yii::$app->request->post()) ) {
          $data = Kategoricus::find()->count();
          if($data == 0)
          {

              $model->CUST_KTG_PARENT = 1;
          }
          else{
              $datax = Kategoricus::find()->MAX('CUST_KTG');

                $model->CUST_KTG_PARENT = $datax+1;
          }

       	    if($model->validate())
            {


                $model->CREATED_BY =  Yii::$app->user->identity->username;
                $model->CREATED_AT = date("Y-m-d H:i:s");
                if($model->save())
                {
                  echo 1;
                }
                else{
                  echo 0;
                }

            }
        } else {
            return $this->renderAjax('_formparent', [
                'model' => $model,
            ]);
        }
    }



    /**
     * Deletes an existing Kategori model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
     	$model = Kategoricus::find()->where(['CUST_KTG'=>$id])->one();
		  $model->STATUS = 3;
		  $model->save();
        return $this->redirect(['index']);
    }



    /**
     * Finds the Kategoricus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kategoricus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kategoricus::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
