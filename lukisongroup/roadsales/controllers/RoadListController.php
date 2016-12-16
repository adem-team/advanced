<?php

namespace lukisongroup\roadsales\controllers;

use Yii;
use lukisongroup\roadsales\models\SalesRoadList;
use lukisongroup\roadsales\models\SalesRoadListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoadListController implements the CRUD actions for SalesRoadList model.
 */
class RoadListController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
     * Lists all SalesRoadList models.
     * @return mixed
     */
    public function actionIndex()
    {

       $paramCari=Yii::$app->getRequest()->getQueryParam('id');

     if($paramCari != ''){
        $cari=['ID'=>$paramCari];
      }else{
        $cari='';
      };

        $searchModel = new SalesRoadListSearch($cari);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SalesRoadList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SalesRoadList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SalesRoadList();

        if ($model->load(Yii::$app->request->post())) {

            $model->CREATED_BY = Yii::$app->user->identity->id;
            $model->CREATED_AT = date('Y-m-d h:i:s');       
            $model->save();
            return $this->redirect(['index', 'id' => $model->ID]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SalesRoadList model.
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

    /**
     * Deletes an existing SalesRoadList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SalesRoadList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalesRoadList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalesRoadList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
