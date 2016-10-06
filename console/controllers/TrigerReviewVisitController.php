<?php
namespace console\controllers;

use Yii;
use zyx\phpmailer\Mailer;
use yii\base\DynamicModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Request;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;
use yii\console\Controller;			// Untuk console 
//use yii\console\Controller;		// Untuk app view 
//use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


class TrigerReviewVisitController extends Controller
{
    public function behaviors()
    {
        return [
			'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ]
        ];
    }

	/*
	 * TRIGER REPORTING CUSTOMER -> REVIEW VISIT
	 * TRIGER
	*/
	public function actionTriger(){
		$tglIn=date("Y-m-d");
		Yii::$app->db_esm->createCommand("
					call CRONJOB_CUSTOMERCALL_TIMEVISIT('".$tglIn."')
		")->execute();
	}
}
?>