<?php

namespace console\controllers;
//namespace console\Controller;
use Yii;
use yii\console\Controller;
use zyx\phpmailer\Mailer;
use yii\widgets\ActiveForm;
use yii\base\DynamicModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Request;
/* use yii\filters\AccessControl;
use Yii\web\User;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException; */

class MakefileController extends Controller{
	
	//public $defaultAction = 'buat';
	
	//public $interactive = true;
	
	
	public function actionBuat(){		
		$rootyii=dirname(dirname(__DIR__));
		//$rootyii=realpath(dirname(__DIR__).'/../../');
		$filename = 'aa.text';
		$folder=$rootyii.'/cronjob/'.$filename;
		$f=fopen($folder, 'w');
		$fw=fwrite($f, 'now:' .$filename );
		fclose($f);  
		
		/* $form = ActiveForm::begin();
		$model = new DynamicModel([
			'TextBody', 'Subject'
		]);
		 $model->addRule(['TextBody', 'Subject'], 'required'); */
		//$ok='Test LG ERP FROM HOME .... GOOD NIGHT ALL, SEE U LATER ';
		$ok=$this->renderPartial('_postmanBody');
		
		 //$form->field($model, 'Subject')->textInput();
		  //ActiveForm::end(); 
		  Yii::$app->mailer->compose()
		 ->setFrom(['postman@lukison.com' => 'LG-ERP-POSTMAN'])
		 //->setTo(['piter@lukison.com'])
		 ->setTo(['piter@lukison.com'])
		 ->setSubject('DAILY ERP TEST EMAIL')
		 ->setTextBody($ok)
		 ->send(); 
	}
}