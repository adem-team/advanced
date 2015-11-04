<?php

namespace lukisongroup\controllers\hrd;

use Yii;
use lukisongroup\models\hrd\Groupfunction;
use lukisongroup\models\hrd\GroupfunctionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GroupfunctionController implements the CRUD actions for Groupfunction model.
 */
class GroupfunctionController extends Controller
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
        $searchModel = new GroupfunctionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

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
            return $this->renderAjax('view', [           
                'model' => $model,
            ]);
        }
    }

    public function actionCreate()
    {
        $model = new Groupfunction();

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

    
	/*Index Delete data by Status */
	public function actionDeletestt($id)
    {
      	$model = $this->findModel($id);
		$model->STATUS = 3;
		$model->UPDATED_BY = Yii::$app->user->identity->username;
		$model->save();
		
        return $this->redirect(['index']);
    }
	
    protected function findModel($id)
    {
        if (($model = Groupfunction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
