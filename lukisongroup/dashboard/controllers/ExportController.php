<?php

namespace lukisongroup\dashboard\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\filters\ContentNegotiator;
use yii\web\Response;

use lukisongroup\dashboard\models\Foodtown;
use lukisongroup\dashboard\models\FoodtownSearch;

/**
 * FoodtownController implements the CRUD actions for Foodtown model.
 */
class ExportController extends Controller
{
	
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
     * Lists all Foodtown models.
     * @return mixed
     */
    public function actionIndex()
    {
		
        return "DOMId=<BR>height=0<BR>width=0<BR>fileName=<BR>statusMessage= Insufficient data.<BR>statusCode=0";
    }

}
