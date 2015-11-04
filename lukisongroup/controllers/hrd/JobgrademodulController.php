<?php

namespace lukisongroup\controllers\hrd;

use Yii;
use lukisongroup\models\hrd\Jobgrademodul;
use lukisongroup\models\hrd\JobgrademodulSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\datecontrol\DateControl;

/**
 * JobgrademodulController implements the CRUD actions for Jobgrademodul model.
 */
class JobgrademodulController extends Controller
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
	
	/*Index render normal*/
    public function actionIndex()
    {
		 $model = new Jobgrademodul(); //create
        $searchModel = new JobgrademodulSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			// 'model'=> $model,
        ]);
    }
	
	/*Index render Ajax*/
    public function actionCreate()
    {
        $model = new Jobgrademodul();
		
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
	
	/*Index View untuk Delete status -> actionDeletestt */
	public function actionViewdel($id)
    {
		$model = $this->findModel($id);
		return $this->renderAjax('_view_delete', [
            //return $this->render('_view_delete', [
                'model' => $model,
            ]);
       
    }
	
	/*Index View untuk update */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())){
			$model->UPDATED_BY=Yii::$app->user->identity->username;
			if($model->validate()){
				if($model->save()){					
					return $this->redirect(['index']);					
				} 
			}
		}else {
            return $this->renderAjax('_view', [
            //return $this->render('_view', [
                'model' => $model,
            ]);
        }
    }
	
	/*Index Delete data by Status */
	public function actionDeletestt($ID)
    {
      	$model = $this->findModel($ID);
		$model->JOBGRADE_STS = 3;
		$model->UPDATED_BY = Yii::$app->user->identity->username;
		$model->save();
		
        return $this->redirect(['index']);
    }
   

    /**
     * Updates an existing Jobgrademodul model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
	
	/* Find Model self $this */
    protected function findModel($id)
    {
        if (($model = Jobgrademodul::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
