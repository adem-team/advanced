<?php

namespace crm\salesman\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use crm\salesman\models\Sot2;
use crm\salesman\models\Sot2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mdm\admin\components\Helper;

// use crm\master\models\Barang;
/**
 * SalesDetailController implements the CRUD actions for Sot2 model.
 */
class SalesDailyCrmController extends Controller
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
     * Lists all Customers models.
     * @return mixed
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
     * PLSQL ! GET DATA SALES
     * @author ptrnov [piter@lukison.com]
     * @since 2.1
     */
	public function getScripts(){
		return Yii::$app->db_esm->createCommand("CALL so_1()")->queryAll();
	}
	/* public function getScriptsa(){
		return Yii::$app->db_esm->createCommand('call so_1()')->queryColumn();
	} */
	/* public function getEsmbrg(){
		return Yii::$app->db_esm->createCommand('call BarangMaxi_Colomn()')->queryAll();
	} */

    /**
     * Lists all Sot2 models.
     * @return mixed
     */
    public function actionIndex()
    {
		 if(Helper::checkRoute('index')){

		/**
		 * PLSQL ! Array Data Provider
		 * @author ptrnov [piter@lukison.com]
		 * @since 2.1
		 */
		$plsql_so_1= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$this->getScripts(),
			 'pagination' => [
				'pageSize' => 20,
			]
		]);

		/**
		 * PLSQL ! Column Label
		 * @author ptrnov [piter@lukison.com]
		 * @since 2.1
		 */
		$attributeField=$plsql_so_1->allModels[0]; //get label Array 0
		//print_r($attributeField);

        $searchModel = new Sot2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderX' => $plsql_so_1,
			'attributeField'=>$attributeField,
			//'brgEsmProdak'=>$brgEsmProdak,
			//'brgEsmProdak'=>$this->getEsmbrg(),
			//'clmKdBarang'=>$clmKdBarang,

        ]);
    }else{
         Yii::$app->user->logout();
           $this->redirect(array('/site/login'));  //
    }
    }

    /**
     * Displays a single Sot2 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sot2 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sot2();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Sot2 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing Sot2 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sot2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Sot2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sot2::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
