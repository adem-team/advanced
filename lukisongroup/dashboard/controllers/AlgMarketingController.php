<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\dashboard\controllers;

/* VARIABLE BASE YII2 Author: -YII2- */
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter; 	
use yii\helpers\Html;
use yii\helpers\Url;
use zyx\phpmailer\Mailer;
//use yii\swiftmailer\Mailer;
use yii\widgets\ActiveForm;
use yii\base\DynamicModel;
use lukisongroup\widget\models\Chat;
use lukisongroup\widget\models\ChatSearch;
use lukisongroup\widget\models\ChatroomSearch;

class AlgMarketingController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(['prodak']),
                'actions' => [
                    //'delete' => ['post'],
					'save' => ['post'],
                ],
            ],
        ];
    }

	/**
     * ACTION INDEX | Session Login
     * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	public function beforeAction($action){
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
	
    /**
     * ACTION INDEX
     */
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
		 ->setTo('piter@lukison.com')
		 ->setSubject('daily test email')
		 ->setTextBody($ok)
		 ->send();
		  
		
		/* \Yii::$app->mailer->compose()
		->setFrom('postman@lukison.com')
		->setTo('piter@lukison.com')
		->setSubject('test subject')
		->send(); */
		
    }
	
	public function actionChat()
    {
        $searchmodel1 = new ChatroomSearch();
        $dataprovider1 = $searchmodel1->search(Yii::$app->request->queryParams);
        $dataprovider1->pagination->pageSize=2;
         
        $searchModel1 = new ChatSearch();
        $dataProvider1 = $searchModel1->searchonline(Yii::$app->request->queryParams);
        $dataProvider1->pagination->pageSize=2;
        
        $searchModel = new ChatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=5;
       
		return $this->render('@lukisongroup/widget/views/chat/index',[
			//'model' => $model,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchmodel1' => $searchmodel1,
            'dataprovider1' => $dataprovider1,
            'searchModel1' => $searchModel1,
            'dataProvider1' => $dataProvider1,
			'ctrl_chat'=>'alg_marketing',
		]);
    }
}
