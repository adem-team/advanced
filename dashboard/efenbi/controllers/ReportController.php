<?php

namespace dashboard\efenbi\controllers;

use yii\web\Controller;

class ReportController extends Controller
{
    public function actionIndex()
    {
		 if (\Yii::$app->user->isGuest) {
            return $this->render('../../../views/site/index_nologin'
            );
        }
        return $this->render('index');
    }
}
