<?php

namespace crm\mastercrm\controllers;

use Yii;
use crm\mastercrm\models\KategoricusSearch;
use crm\mastercrm\models\Kategoricus;
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
class KategoriCustomersCrmController extends Controller
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


    public function actionIndex()
    {

      if(Helper::checkRoute('index')){
        $searchModel1 = new KategoricusSearch();
        $dataProviderkat  = $searchModel1->searchparent(Yii::$app->request->queryParams);

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
			'searchModel1' => $searchModel1,
			'dataProviderkat'  =>$dataProviderkat ,
		]);
  }else{
    Yii::$app->user->logout();
    $this->redirect(array('/site/login'));
  }
	}



    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }



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
            return $this->renderAjax('_form_child', [
                'model' => $model,
            ]);
        }
    }





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
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }






    public function actionUpdate($id)
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

    public function actionUpdateCust($id)
    {
        $model = $this->findModelcust($id);
        $datacus = Customers::find()->where('CUST_GRP = CUST_KD')->asArray()->all();
        $parent = ArrayHelper::map($datacus,'CUST_KD', 'CUST_NM');
        $dropparentkategori = ArrayHelper::map(Kategoricus::find()->where('CUST_KTG_PARENT = CUST_KTG')
                                                                   ->asArray()
                                                                   ->all(),'CUST_KTG', 'CUST_KTG_NM');
        $readonly = Customers::find()->where(['CUST_KD'=>$id])->asArray()->one(); // data for view type
        if ($model->load(Yii::$app->request->post()) ) {

        $tanggal = \Yii::$app->formatter->asDate($model->JOIN_DATE,'Y-M-d');
        $model->JOIN_DATE = $tanggal;
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
            return $this->renderAjax('update', [
                'model' => $model,
                'parent'=>$parent,
                'dropparentkategori'=>$dropparentkategori,
                'readonly'=>$readonly
            ]);
        }
    }

    public function actionUpdatekat($id)
    {
        $readonly = Customers::find()->where(['CUST_KD'=>$id])->asArray()->one(); // data for view
        $model = $this->findModelcust($id);
        $model->scenario = "updatekat";
        $dropparentkategori = ArrayHelper::map(Kategoricus::find()->where('CUST_KTG_PARENT = CUST_KTG')
                                                                   ->asArray()
                                                                   ->all(),'CUST_KTG', 'CUST_KTG_NM');
        if ($model->load(Yii::$app->request->post()) ) {

        $tanggal = \Yii::$app->formatter->asDate($model->JOIN_DATE,'Y-M-d');
        $model->JOIN_DATE = $tanggal;
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
            return $this->renderAjax('type', [
                'model' => $model,
                'dropparentkategori'=>$dropparentkategori,
                'readonly'=>$readonly
            ]);
        }
    }







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
	  protected function findModelkota($id)
    {
        if (($model = Kota::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelalias($id)
    {
        if (($model = Customersalias::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	 protected function findModelcust($id)
    {
        if (($model = Customers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    protected function findModel($id)
    {
        if (($model = Kategoricus::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
