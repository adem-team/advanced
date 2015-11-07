<?php

namespace crm\salespromo\controllers;

use yii\web\Controller;

class SalesDailyController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
