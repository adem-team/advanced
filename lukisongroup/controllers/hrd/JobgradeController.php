<?php

namespace lukisongroup\controllers\hrd;

use Yii;
use lukisongroup\models\hrd\Jobgrade;
use lukisongroup\models\hrd\JobgradeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JobgradeController implements the CRUD actions for Jobgrade model.
 */
class JobgradeController extends Controller
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

   /* -- Created Session Time Author By ptr.nov --*/
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
        $searchModel = new JobgradeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($ID, $JOBGRADE_ID)
    {
		/*
        return $this->render('view', [
            'model' => $this->findModel($ID, $JOBGRADE_ID),
        ]);
		*/
		$model = $this->findModel($ID, $JOBGRADE_ID);
		if ($model->load(Yii::$app->request->post())){
			$model->UPDATED_BY=Yii::$app->user->identity->username;
			if($model->validate()){
				if($model->save()){					
					return $this->redirect(['index']);					
				} 
			}
		}else {
            return $this->renderAjax('view', [
            //return $this->render('_view', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreate()
    {
        $model = new Jobgrade();
		/*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'JOBGRADE_ID' => $model->JOBGRADE_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
		*/
		
		if ($model->load(Yii::$app->request->post())){		
				$model->CREATED_BY=Yii::$app->user->identity->username;		
				$model->UPDATED_TIME=date('Y-m-d h:i:s'); 				
				$model->save();
				if($model->save()){
					 //return $this->redirect(['view', 'id' => $model->ID]);	
					 return $this->redirect('index');
				} 
		}else {
            //return $this->render('_form', [ 
			return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }	
		
    }

    public function actionUpdate($ID, $JOBGRADE_ID)
    {
        $model = $this->findModel($ID, $JOBGRADE_ID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'JOBGRADE_ID' => $model->JOBGRADE_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    
   /*Index Delete data by Status */
	public function actionDeletestt($ID, $JOBGRADE_ID)
    {
      	$model = $this->findModel($ID, $JOBGRADE_ID);
		$model->JOBGRADE_STS = 3;
		$model->UPDATED_BY = Yii::$app->user->identity->username;
		$model->save();
		
        return $this->redirect(['index']);
    }
    /**
     * Finds the Jobgrade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID
     * @param string $JOBGRADE_ID
     * @return Jobgrade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID, $JOBGRADE_ID)
    {
        if (($model = Jobgrade::findOne(['ID' => $ID, 'JOBGRADE_ID' => $JOBGRADE_ID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
