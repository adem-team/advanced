<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\controllers\hrd;

/* VARIABLE BASE YII2 Author: -YII2- */
	use Yii;
	use yii\web\Controller;
	use yii\web\NotFoundHttpException;
	use yii\filters\VerbFilter;
/* VARIABLE PRIMARY JOIN/SEARCH/FILTER/SORT Author: -ptr.nov- */
	use lukisongroup\models\hrd\Dept;			/* TABLE CLASS JOIN */
	use lukisongroup\models\hrd\DeptSearch;		/* TABLE CLASS SEARCH */
	
/**
 * HRD | CONTROLLER EMPLOYE .
 */
class DeptController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(['Dept']),
                'actions' => [
                    //'delete' => ['post'],
					'save' => ['post'],
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
		/*	variable content View Employe Author: -ptr.nov- */
        $searchModel_Dept = new DeptSearch();
		$dataProvider_Dept = $searchModel_Dept->search(Yii::$app->request->queryParams);
		
		return $this->render('index', [
			'searchModel_Dept'=>$searchModel_Dept,
			'dataProvider_Dept'=>$dataProvider_Dept,
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
        $model = new Dept();
        if ($model->load(Yii::$app->request->post())){		
				$model->CREATED_BY=Yii::$app->user->identity->username;		
				$model->UPDATED_TIME=date('Y-m-d h:i:s'); 				
				$model->save();
				if($model->save()){
					 //return $this->redirect(['view', 'id' => $model->ID]);	
					 return $this->redirect('index');
				} 
		}else {
           	return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }			
    }

    /*Index Delete data by Status */
	public function actionDeletestt($id)
    {
      	$model = $this->findModel($id);
		$model->DEP_STS = 3;
		$model->UPDATED_BY = Yii::$app->user->identity->username;
		$model->save();
		
        return $this->redirect(['index']);
    }
	
    protected function findModel($id)
    {
        if (($model = Dept::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	
}
