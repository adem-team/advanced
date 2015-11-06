<?php

namespace crm\salespromo\controllers;

use yii\web\Controller;

class TopDailyController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
