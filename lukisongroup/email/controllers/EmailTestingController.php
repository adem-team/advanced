<?php

namespace lukisongroup\email\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\Url;
use zyx\phpmailer\Mailer;
use yii\widgets\ActiveForm;
use yii\base\DynamicModel;

class EmailTestingController extends Controller
{
	public function beforeAction(){
			if (Yii::$app->user->isGuest)  {
				 Yii::$app->user->logout();
                   $this->redirect(array('/site/login'));  //
			}
            // Check only when the user is logged in
            if (!Yii::$app->user->isGuest)  {
               if (Yii::$app->session['userSessionTimeout']< time() ) {
                   // timeout
                   Yii::$app->user->logout();
                   $this->redirect(array('/site/login'));  //
               } else {
                   //Yii::$app->user->setState('userSessionTimeout', time() + Yii::app()->params['sessionTimeoutSeconds']) ;
				   Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
                   return true; 
               }
            } else {
                return true;
            }
    }
	
   public function actionIndex()
    {
		/*	variable content View Employe Author: -ptr.nov- 
       // $searchModel_Dept = new DeptSearch();
		//$dataProvider_Dept = $searchModel_Dept->search(Yii::$app->request->queryParams);
		Yii::$app->Mailer->compose()
		->setFrom('lg-postman@lukison.com')
		->setTo('piter@lukison.com')
		->setSubject('Message subject')
		->setTextBody('Plain text content')
		//->setHtmlBody('<b>HTML content</b>')
		->send();
		//return $this->render('index');
		*/
		
		$form = ActiveForm::begin();
		$model = new DynamicModel([
			'TextBody', 'Subject'
		]);
		 $model->addRule(['TextBody', 'Subject'], 'required');
		$ok='Test LG ERP FROM HOME .... GOOD NIGHT ALL, SEE U LATER ';
		
		 $form->field($model, 'Subject')->textInput();
		  ActiveForm::end(); 
		  Yii::$app->mailer->compose()
		 ->setFrom(['postman@lukison.com' => 'LG-ERP-POSTMAN'])
		 //->setTo(['piter@lukison.com'])
		 //->setTo(['it-dept@lukison.com'])
		 ->setTo(['ptr.nov@gmail.com'])
		 ->setSubject('ERP TEST EMAIL')
		 ->setTextBody($ok)
		 ->send();
		 
		
    }
	
}
	
	
  
