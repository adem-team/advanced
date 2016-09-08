<?php

namespace lukisongroup\widget\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class ChatwawanController extends \yii\web\Controller
{
   // public function actions()
    // {
        // return [
            // 'error' => [
                // 'class' => 'yii\web\ErrorAction',
            // ],
        // ];
    // }
	public function actionIndex()
	{
		if (Yii::$app->request->post()) {

			$name = Yii::$app->request->post('name');
			$message = Yii::$app->request->post('message');

			return Yii::$app->redis->executeCommand('PUBLISH', [
				'channel' => 'notification',
				'message' => Json::encode(['name' => $name, 'message' => $message])
			]);

		}
		//print_r(Yii::$app->redis);
		return $this->render('index');
	}
}
