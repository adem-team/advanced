<?php

namespace lukisongroup\controllers;

use Yii;
use app\models\maxi\distributor;
use app\models\maxi\distributorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DistributorController implements the CRUD actions for distributor model.
 */
class MaxidistributorController extends Controller
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
     * Lists all distributor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new distributorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single distributor model.
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
     * Creates a new distributor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new distributor();
		$ts = Yii::$app->request->post();
	//	$pst = $model->load($ts);
	
  //      if ($pst && $model->save()) {
        if($ts) {
			date_default_timezone_set('Asia/Jakarta');
		
			Yii::$app->db2->createCommand()->insert('a0001', [
                    'DBTR_NM' =>  $_POST['distributor']['DBTR_NM'],
                    'DBTR_PIC' =>  $_POST['distributor']['DBTR_PIC'],
                    'DBTR_ALMT' =>  $_POST['distributor']['DBTR_ALMT'],
                    'DBTR_ID_TLP' =>  $_POST['distributor']['DBTR_ID_TLP'],
                    'DBTR_JOIN' =>  date("Y-m-d"),
                    'DBTR_STT' =>  '1',
                ])->execute();
				
                $insert_id = Yii::$app->db2->getLastInsertID();
                return $this->redirect(['view', 'id' =>  $insert_id]);
		//	print_r($ts);
		//	echo $nmBrg;
//            return $this->redirect(['view', 'id' => $model->DBTR_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing distributor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->DBTR_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing distributor model.
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
     * Finds the distributor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return distributor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = distributor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
