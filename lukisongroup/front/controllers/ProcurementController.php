<?php

namespace lukisongroup\front\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use lukisongroup\front\models\Procurement_itemSearch;

class ProcurementController extends Controller
{
    /* public function actionIndex()
    {
        return $this->render('index');
    } */
	
	 public function actionIndex()
    {
        $searchModel = new Procurement_itemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
