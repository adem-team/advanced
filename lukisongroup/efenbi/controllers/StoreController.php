<?php

namespace lukisongroup\efenbi\controllers;

use Yii;
use lukisongroup\efenbi\models\Store;
use lukisongroup\efenbi\models\StoreSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StoreController implements the CRUD actions for Store model.
 */
class StoreController extends Controller
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
	/*
	* Declaration Component User Permission
	* Function getPermission
	* Modul Name[11=Calendar Promo]
	* Permission LINK URL.
	*/
	public function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses('11')){
			return Yii::$app->getUserOpt->Modul_akses('11');
		}else{
			return false;
		}
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
			   //Modul permission URL, author -ptr.nov@gail.com-
			   if(self::getPermission()->BTN_CREATE OR self::getPermission()->BTN_VIEW){
					return true;
			   }else{
				   $this->redirect(array('/site/validasi'));
			   }
		   }
		} else {
			return true;
		}
    }
    /**
     * Lists all Store models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StoreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Store model.
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
     * Creates a new Store model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Store();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Store model.
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
     * Deletes an existing Store model.
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
     * Finds the Store model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Store the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Store::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
