<?php

namespace crm\mastercrm\controllers;

use Yii;
use crm\mastercrm\models\KotaSearch;
use crm\mastercrm\models\Kota;
use crm\mastercrm\models\ProvinceSearch;
use crm\mastercrm\models\Province;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use mdm\admin\components\Helper;

/**
 * CustomersController implements the CRUD actions for Customers model.
 */
class ProvinsiCustomersCrmController extends Controller
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
     * Lists all Customers models.
     * @return mixed
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


    public function actionIndex()
    {

    if(Helper::checkRoute('index')){
        $searchModel = new ProvinceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

           if(Yii::$app->request->post('hasEditable'))
        {
            $ID = \Yii::$app->request->post('editableKey');
            $model = Customers::findOne($ID);
            $out = Json::encode(['output'=>'', 'message'=>'']);

            // fetch the first entry in posted data (there should
            // only be one entry anyway in this array for an
            // editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $post = [];
            $posted = current($_POST['Customers']);
            $post['Customers'] = $posted;



            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model
                $model->save();

                // custom output to return to be displayed as the editable grid cell
                // data. Normally this is empty - whereby whatever value is edited by
                // in the input by user is updated automatically.
                $output = '';

                // specific use case where you need to validate a specific
                // editable column posted when you have more than one
                // EditableColumn in the grid view. We evaluate here a
                // check to see if buy_amount was posted for the Book model
                if (isset($posted['CUST_KD_ALIAS'])) {
                   // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
                    $output =$model->CUST_KD_ALIAS;
                }

                // similarly you can check if the name attribute was posted as well
                // if (isset($posted['name'])) {
                //   $output =  ''; // process as you need
                // }
                $out = Json::encode(['output'=>$output, 'message'=>'']);


            // return ajax json encoded response and exit
            echo $out;

            return;
          }

        }

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
    }else{
        Yii::$app->user->logout();
        $this->redirect(array('/site/login'));  //
    }
	}


	 public function actionViewpro($id)
    {
        return $this->renderAjax('viewpro', [
            'model' => $this->findModelpro($id),
        ]);
    }

      public function actionCreateprovnce()
    {
        $model = new Province();

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
            return $this->renderAjax('_formprovince', [
                'model' => $model,
            ]);
        }
    }




	public function actionUpdatepro($id)
    {
        $model = $this->findModelpro($id);

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
            return $this->renderAjax('_formprovince', [
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



    /**
     * Finds the Kategoricus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kategoricus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
	  protected function findModelpro($id)
    {
        if (($model = Province::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
