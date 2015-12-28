<?php

namespace lukisongroup\email\controllers;

use Yii;
use yii\web\Controller;
//use yii\helpers\Html;
//use yii\helpers\Url;
use zyx\phpmailer\Mailer;
//use yii\widgets\ActiveForm;
//use yii\base\DynamicModel;
use yii\filters\VerbFilter;


class EmailTestingController extends Controller
{
	
	 public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['post'],
					'save' => ['post'],
                ],
            ],
        ];
    }
	
	/**
     * Run SomeModel::some_method for a period of time
     * @param string $from
     * @param string $to
     * @return int exit code
     */
   	
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
        return $this->render('index');
    }
	
	public function actionSendmail()
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
		
		//$form = ActiveForm::begin();
			//$model = new DynamicModel([
			//	'TextBody', 'Subject'
			//]);
			//$model->addRule(['TextBody', 'Subject'], 'required');
			$ok_html='HTML <h1><b>LG-POSTMAN ERP FROM HOME</b></h1> .... GOOD NIGHT ALL, SEE U LATER, check Attach';	
			$ok_text='Test LG-POSTMAN ERP FROM HOME> .... GOOD NIGHT ALL, SEE U LATER, check Attach';
		    $path='@lukisongroup/web/upload/hrd/Employee/1436076377.jpg';
			//$
			//$form->field($model, 'Subject')->textInput();
			
		//ActiveForm::end(); 
		//$path_atch='D:\xampp\htdocs\advanced\lukisongroup\web\upload\hrd\Employee';
		//$path_atch='/var/www/advanced/lukisongroup/web/upload/hrd/Employee/';
		$path_atch='/var/www/advanced/lukisongroup/web/upload/hrd/Employee/';
		$opt=['fileName'=>'1436076377.jpg','contentType'=>'image/jpg','encoding'=>'base64','disposition'=>'attachment'];
		//$opt=['1436076377','jpg'];
		Yii::$app->mailer->compose()
		 ->setFrom(['postman@lukison.com' => 'LG-POSTMAN'])
		 ->setTo(['it-dept@lukison.com'])
		 ->setCc(['ptr.nov@gmail.com'])
		 ->setBcc(['piter@lipat.co.id'])		 
		 ->setSubject('ERP TEST EMAIL')
		 ->setHtmlBody($ok_html);
		 //->attach($path_atch,['fileName'=>'1436076377','contentType'=>'jpg','encoding'=>'base64','disposition'=>'attachment'])
		 //->attach('@lukisongroup/web/upload/hrd/Employee/',['fileName'=>'1436076377.jpg','contentType'=>'image/jpg'])
		 //->attach($path)
		//->attach()
		 //->setTextBody($ok)
		 Yii::$app->mailer->compose()->attach('/var/www/advanced/lukisongroup/web/upload/hrd/Employee/',['1436076377','image/jpg']);
		 Yii::$app->mailer->compose()->send();
		 
		
    }
	
}
	
	
  
