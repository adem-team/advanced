<?php

namespace crm\salespromo\controllers;

use yii\web\Controller;

class LowDailyController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
