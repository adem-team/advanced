<?php

namespace lukisongroup\hrd\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class AbsenLogController extends Controller
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
     * PLSQL ! GET ABSENSI
     * @author ptrnov [piter@lukison.com]
     * @since 2.1
     */
	public function getScriptsMaintain($int){
		//return Yii::$app->db2->createCommand("CALL absensi_grid('inout_monitoring=2016-02-01=2016-02-22=0=0=0=0=0')")->queryAll();                
		return Yii::$app->db2->createCommand("CALL absensi_monitoring(".$int.")")->queryAll();                
	}
	
	// public function getScriptsDetail(){
		// return Yii::$app->db_esm->createCommand("CALL esm_account_stock_detail()")->queryAll();                
	// }
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
		//print_r($this->getScripts());
		
		/**
		 * PLSQL ! Array Data Provider
		 * @author ptrnov [piter@lukison.com]
		 * @since 2.1
		 */
		/* $absenMaintain= new ArrayDataProvider([
			'key' => 'idno',
			'allModels'=>$this->getScriptsMaintain(0),
			 'pagination' => [
				'pageSize' => 500,
			]
		]); */
		
        /* return $this->render('index', [
           // 'searchModel' => $searchModel,
            'absenMaintain' => $absenMaintain,
            //'dataProviderX' => $plsql_so_1,
			//'dataProviderX1' => $plsql_so_detail,
			//'attributeField'=>$attributeField,
			//'attributeField1'=>$attributeField1,
			//'brgEsmProdak'=>$brgEsmProdak,
			//'brgEsmProdak'=>$this->getEsmbrg(),
			//'clmKdBarang'=>$clmKdBarang,
			
        ]); */
		
		$this->redirect(['cari','int'=>0]);
    }

	public function actionCari($int)
    {
		//print_r($this->getScripts());
		
		/**
		 * PLSQL ! Array Data Provider
		 * @author ptrnov [piter@lukison.com]
		 * @since 2.1
		 */
		$absenMaintain= new ArrayDataProvider([
			'key' => 'idno',
			'allModels'=>$this->getScriptsMaintain($int),
			 'pagination' => [
				'pageSize' => 500,
			]
		]);
		
        return $this->render('index', [
           // 'searchModel' => $searchModel,
            'absenMaintain' => $absenMaintain,
            //'dataProviderX' => $plsql_so_1,
			//'dataProviderX1' => $plsql_so_detail,
			//'attributeField'=>$attributeField,
			//'attributeField1'=>$attributeField1,
			//'brgEsmProdak'=>$brgEsmProdak,
			//'brgEsmProdak'=>$this->getEsmbrg(),
			//'clmKdBarang'=>$clmKdBarang,
			
        ]);
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
