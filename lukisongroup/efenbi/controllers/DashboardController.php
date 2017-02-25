<?php

namespace lukisongroup\efenbi\controllers;

use yii\web\Controller;

class DashboardController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
		//return "Dashboard efenbi";
    }
}
