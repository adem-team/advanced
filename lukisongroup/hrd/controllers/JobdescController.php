<?php

namespace lukisongroup\hrd\controllers;

use Yii;
use lukisongroup\hrd\models\Jobdesc;
use lukisongroup\hrd\models\JobdescSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JobdescController implements the CRUD actions for Jobdesc model.
 */
class JobdescController extends Controller
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
     * Lists all Jobdesc models.
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
        $searchModel = new JobdescSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Jobdesc model.
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
     * Creates a new Jobdesc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Jobdesc();

        if ($model->load(Yii::$app->request->post()) ) {
			if($model->validate())
			{
				    $model->CREATED_BY = Yii::$app->user->identity->username;  
					$image = $model->uploadImage();
		if ($model->save()) {
			// upload only if valid uploaded file instance found
			if ($image !== false) {
				$path = $model->getImageFile();
				$image->saveAs($path);
			}
                        
		
                }
				
                }
			
        
//            print_r($model);
//            die();
            return $this->redirect(['/hrd/jobdesc/']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }
    
    
    

    /**
     * Updates an existing Jobdesc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
			if($model->validate())
			{
				     $model->UPDATED_BY = Yii::$app->user->identity->username;
					$model->UPDATED_TIME = date('Y-m-d H:i:s');
						$image = $model->uploadImage();
					if ($model->save()) {
			// upload only if valid uploaded file instance found
			if ($image !== false) {
				$path = $model->getImageFile();
				$image->saveAs($path);
			}
                        
		
                }
                }
			
       
         
            return $this->redirect(['/hrd/jobdesc/']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Jobdesc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
       $data = \lukisongroup\hrd\models\Jobdesc::find()->where(['ID'=>$id])->one();
		$data->STATUS = 3;
		$data->UPDATED_BY = Yii::$app->user->identity->username;
		$data->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Jobdesc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Jobdesc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Jobdesc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
