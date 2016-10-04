<?php

namespace lukisongroup\master\controllers;

use Yii;
use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\TipebarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;


/**
 * TipebarangController implements the CRUD actions for Tipebarang model.
 */
class TipebarangController extends Controller
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
     * Lists all Tipebarang models.
     * @return mixed
	 *
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
        $searchModel = new TipebarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
             $PK = unserialize(Yii::$app->request->post('editableKey'));
             $model = $this->findModel($PK['ID'],$PK['KD_TYPE']);

            // store a default json response as desired by editable
            $out = Json::encode(['output'=>'', 'message'=>'']);

            // fetch the first entry in posted data (there should
            // only be one entry anyway in this array for an
            // editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $post = [];
            $posted = current($_POST['Tipebarang']);
            $post['Tipebarang'] = $posted;

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
                if (isset($posted['NM_TYPE'])) {
                   // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
                    $output =$model->NM_TYPE;
                }

                // similarly you can check if the name attribute was posted as well
                // if (isset($posted['name'])) {
                //   $output =  ''; // process as you need
                // }
                $out = Json::encode(['output'=>$output, 'message'=>'']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
          }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tipebarang model.
     * @param string $id
     * @param string $kd_type
     * @return mixed
     */
    public function actionView($ID, $KD_TYPE)
    {
		
		$ck = Tipebarang::find()->where(['ID'=>$ID, 'KD_TYPE'=>$KD_TYPE])->one();
		if(count($ck) == 0){
			return $this->redirect(['index']);
		}
		if($ck->STATUS != 3){
			return $this->renderAjax('view', [
				'model' => $ck,
			]);
		} else {
			return $this->redirect(['index']);
		}
    }

    /**
     * Creates a new Tipebarang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tipebarang();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'KD_TYPE' => $model->KD_TYPE]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSimpan()
    {
        $model = new Tipebarang();
        
		$model->load(Yii::$app->request->post());
        $nw = Yii::$app->esmcode->kdTipe();
		$model->KD_TYPE = $nw;
             if($model->validate())
             {
                $model->CREATED_AT = date('Y-m-d H:i:s');
                $model->CREATED_BY = Yii::$app->user->identity->username;
		$model->save();
             }
                   
		return $this->redirect(['index']);
    }
    /**
     * Updates an existing Tipebarang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @param string $kd_type
     * @return mixed
     */
    public function actionUpdate($ID, $KD_TYPE)
    {
//        $model = $this->findModel($ID, $KD_TYPE);

		$model = Tipebarang::find()->where(['ID'=>$ID, 'KD_TYPE'=>$KD_TYPE])->one();
		if(count($model) == 0){
			return $this->redirect(['index']);
		}
		if($model->STATUS == 3){
			return $this->redirect(['index']);
		}
		
        if ($model->load(Yii::$app->request->post()) ) {
            if($model->validate())
            {
            $model->UPDATED_BY = Yii::$app->user->identity->username;
            $model->save();
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tipebarang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @param string $kd_type
     * @return mixed
     */
    public function actionDelete($ID, $KD_TYPE)
    {
		
		$model = Tipebarang::find()->where(['ID'=>$ID, 'KD_TYPE'=>$KD_TYPE])->one();
		$model->STATUS = 3;
		$model->UPDATED_BY = Yii::$app->user->identity->username;
		$model->save();  // equivalent to $model->update();
		
//        $this->findModel($ID, $KD_TYPE)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tipebarang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @param string $kd_type
     * @return Tipebarang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID, $KD_TYPE)
    {
        if (($model = Tipebarang::findOne(['ID' => $ID, 'KD_TYPE' => $KD_TYPE])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
