<?php

namespace crm\salespromo\controllers;

use yii\web\Controller;

class TopMonthlyController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
