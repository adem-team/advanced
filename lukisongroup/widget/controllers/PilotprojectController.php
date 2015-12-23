<?php

namespace lukisongroup\widget\controllers;

use Yii;
use lukisongroup\widget\models\Pilotproject;
use lukisongroup\esm\models\Kategoricus;
use lukisongroup\widget\models\PilotprojectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PilotprojectController implements the CRUD actions for Pilotproject model.
 */
class PilotprojectController extends Controller
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
     * Lists all Pilotproject models.
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
        $searchModel = new PilotprojectSearch();
        $dataProviderDept = $searchModel->searchDept(Yii::$app->request->queryParams);
		$dataProviderEmp = $searchModel->searchEmp(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProviderDept' => $dataProviderDept,
			'dataProviderEmp' => $dataProviderEmp,
        ]);
    }

    /**
     * Displays a single Pilotproject model.
     * @param string $id
     * @return mixed
     */
    //public function actionView($ID,$PILOT_ID)
    //{
    //    return $this->render('view', [
    //        'model' => $this->findModel($ID,$PILOT_ID),
    //    ]);
    //}
    public function actionView($id,$PILOT_ID)
    {
		$model = $this->findModel($id,$PILOT_ID);
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
    /**
     * Creates a new Pilotproject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
		
		$model = new Pilotproject();
		
		if ($model->load(Yii::$app->request->post())){
                $model->PARENT = $id;
                $model->SORT = $id;
                $model->PILOT_ID = '';
                $model->DEP_ID =  Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;		
				$model->CREATED_BY= Yii::$app->user->identity->username;		
				$model->UPDATED_TIME= date('Y-m-d h:i:s'); 				
				$model->save();
				if($model->save()){
					
				return $this->redirect('index');
				} 
		}else {
           
			return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }	
    }

     
    public function actionCreateparent()
    {
       
        $model = new Pilotproject();
        
        if ($model->load(Yii::$app->request->post())){

                $sql = Pilotproject::find()->count();
                                                
                $model->SORT = $sql+1;
                $model->PARENT = 0;
                $model->DEP_ID =  Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
                $dep_id = $model->DEP_ID;
                $pilot_id = Yii::$app->esmcode->getpilot($dep_id);
                   // print_r($pilot_id );
                   // die();
                $model->PILOT_ID = $pilot_id;              
                $model->CREATED_BY=Yii::$app->user->identity->username;     
                $model->UPDATED_TIME=date('Y-m-d h:i:s');               
                $model->save();
                // print_r($model);
                // die();

           
                    
                     return $this->redirect('index');
                
        }else {
           
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }   
    }

    /**
     * Updates an existing Pilotproject model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($ID,$PILOT_ID)
    {
        $model = $this->findModel($ID,$PILOT_ID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Pilotproject model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($ID,$PILOT_ID)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pilotproject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Pilotproject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID,$PILOT_ID)
    {
        if (($model = Pilotproject::findOne(['ID'=>$ID,'PILOT_ID'=>$PILOT_ID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
