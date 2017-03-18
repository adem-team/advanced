<?php

namespace lukisongroup\efenbi\rasasayang\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use lukisongroup\efenbi\rasasayang\models\ItemFormula;
use lukisongroup\efenbi\rasasayang\models\ItemFormulaSearch;
use lukisongroup\efenbi\rasasayang\models\ItemFormulaDetail;
use lukisongroup\efenbi\rasasayang\models\ItemFormulaDetailSearch;

/**
 * ItemFormulaController implements the CRUD actions for ItemFormula model.
 */
class ItemFormulaController extends Controller
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
     * Lists all ItemFormula models.
     * @return mixed
     */
    public function actionIndex()
    {		
		$searchModel = new ItemFormulaSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$paramCari = Yii::$app->request->queryParams;
		if($paramCari){
			$formulaID=ItemFormula::find()->select(['FORMULA_ID'])->where(['ID'=>$paramCari['id']])->asArray()->one();
			// print_r($formulaID['']);
			// die();
			$searchModelDetail = new ItemFormulaDetailSearch($formulaID);
			$dataProviderDetail = $searchModelDetail->search(Yii::$app->request->queryParams);
		}else{
			$searchModelDetail = new ItemFormulaDetailSearch();
			$dataProviderDetail = $searchModelDetail->search(Yii::$app->request->queryParams);
		}

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider, 
			'searchModelDetail' => $searchModelDetail,
            'dataProviderDetail' => $dataProviderDetail,
        ]);
    }

    /**
     * Displays a single ItemFormula model.
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
     * Creates a new ItemFormula model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ItemFormula();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ITEM_GRP_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ItemFormula model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ITEM_GRP_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ItemFormula model.
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
     * Finds the ItemFormula model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ItemFormula the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ItemFormula::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
