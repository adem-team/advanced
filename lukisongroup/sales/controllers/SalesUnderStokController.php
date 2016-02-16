<?php

namespace lukisongroup\sales\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use lukisongroup\sales\models\Sot2;
use lukisongroup\sales\models\Sot2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use lukisongroup\master\models\Barang;
/**
 * SalesDetailController implements the CRUD actions for Sot2 model.
 */
class SalesUnderStokController extends Controller
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
     * PLSQL ! GET DATA SALES 
     * @author ptrnov [piter@lukison.com]
     * @since 2.1
     */
	public function getScripts(){
		return Yii::$app->db_esm->createCommand("CALL esm_account_stock()")->queryAll();                
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
		$plsql_so_label= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$this->getScripts(),
			 'pagination' => [
				'pageSize' => 500,
			]
		]);
		$attributeField=$plsql_so_label->allModels[0]; //get label Array 0
		$attDinamik=[];
		foreach($attributeField as $key =>$value)
		{
			$attDinamik[]=[$key];
		}
		//print_r($attDinamik);
		
		
		$plsql_so_1= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>$this->getScripts(),
			// 'sort' => [
				// 'attributes' => $attDinamik,
			// ],
			 'pagination' => [
				'pageSize' => 500,
			]
		]);
		
		// $plsql_so_detail= new ArrayDataProvider([
			// 'key' => 'ID',
			// 'allModels'=>$this->getScriptsDetail(),
			 // 'pagination' => [
				// 'pageSize' => 500,
			// ]
		// ]);
		
		
		
		
		/**
		 * PLSQL ! Column Label
		 * @author ptrnov [piter@lukison.com]
		 * @since 2.1
		 */
		$attributeField=$plsql_so_1->allModels[0]; //get label Array 0
		// $attDinamik=[];
		// foreach($attributeField as $key =>$value)
		// {
			// $attDinamik[]=[$key];
		// }
		// print_r($attDinamik);
		
		// $attributeField1=$plsql_so_detail->allModels[0];
		// print_r($plsql_so_1->getModels());
		$tes1=$plsql_so_1->getModels();
        $searchModel = new Sot2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		
		
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderX' => $plsql_so_1,
			//'dataProviderX1' => $plsql_so_detail,
			'attributeField'=>$attributeField,
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
