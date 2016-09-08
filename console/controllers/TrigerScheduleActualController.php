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


class TrigerScheduleActualController extends Controller
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
		//$tglIn=date("Y-m-d");
		//Hari ke delapan dari hari ini
		$rslt_tgl=date("Y-m-d",strtotime("+8 days")); 
		Yii::$app->db_esm->createCommand("
					call CRONJOB_PLAN_TO_ACTUAL_ERP('".$rslt_tgl."','".$rslt_tgl."')
		")->execute();
	}
}
?>