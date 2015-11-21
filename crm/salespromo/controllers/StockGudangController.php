<?php

namespace crm\salespromo\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use crm\sistem\models\UserloginSearch;
use lukisongroup\master\models\Customer;
use crm\salespromo\models\Stock_gudang;
use crm\salespromo\models\Stock_gudangSearch;

/**
 * StockGudangController implements the CRUD actions for Stock_gudang model.
 */
class StockGudangController extends Controller
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
     * ACTION INDEX
     */
	/* -- Created By ptr.nov --*/
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
	/* protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='afspgudang')
		{
			echo ActiveForm::validate($model);
			Yii::app()->end();
		}
	} */
	
    /**
     * Lists all Stock_gudang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Stock_gudangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Stock_gudang model.
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
     * Creates a new Stock_gudang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
    public function actionCreate()
    {
        $model = new Stock_gudang();
		
		return $this->renderAjax('_form', [
                'model' => $model,
				]);
	}	
	
	/*
	 * Action Simpan | Customer Stock | User login | Profile
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	public function actionSimpan()
    {
        $model = new Stock_gudang();
		
		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				$user_attr=Yii::$app->getUserOptcrm->Profile_user();
					$model->CORP_ID =  $user_attr->userprofile->CORP_ID;
					$model->KD_DISTRIBUTOR =  $user_attr->userprofile->KD_DISTRIBUTOR;
					$model->KD_SUBDIST =  $user_attr->userprofile->KD_SUBDIST;
					$model->KD_OUTSRC =  $user_attr->userprofile->KD_OUTSRC;
					$model->CREATED_BY = $user_attr->username;
					$model->CREATED_AT = date('Y-m-d H:i:s');
					$model->save();
					return $this->redirect('index');
			} else {			
				return ActiveForm::validate($model);
			}
		}
    }

    /**
     * Updates an existing Stock_gudang model.
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
     * Deletes an existing Stock_gudang model.
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
     * Finds the Stock_gudang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stock_gudang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stock_gudang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionCustList($q = null, $CUST_KD = null) {
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $out = ['results' => ['CUST_KD' => '', 'text' => '']];
    if (!is_null($q)) {
        $query = new Query;
        $query->select('CUST_KD, CUST_NM AS text')
            ->from('customer')
            ->where(['like', 'CUST_NM', $q])
            ->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['results'] = array_values($data);
    }
    elseif ($id > 0) {
        $out['results'] = ['id' => $CUST_KD, 'text' => Customer::find($id)->CUST_NM];
    }
    return $out;
}
}
