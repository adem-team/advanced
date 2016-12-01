<?php
namespace lukisongroup\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use Yii\web\User;
use yii\filters\VerbFilter;
use lukisongroup\hrd\models\Employe;
use lukisongroup\hrd\models\EmployeSearch;
use lukisongroup\sistem\models\UserloginSearch;
use yii\web\NotFoundHttpException;
use lukisongroup\sistem\models\ValidationLoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        /* Author: -ptr.nov- : Permission Allow No Login |index|error|login */
                        'actions' => ['index', 'error','login','validasi'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    public $corpOne;
    public function actionIndex()
    {
        /* Author: -ptr.nov- : Split Index Before/After Login */
        if (\Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('index_nologin', [
                'model' => $model,
            ]);
        } else {
            $ModelUser = UserloginSearch::findUserAttr(Yii::$app->user->id)->one();
            $model = $this->findModel1($ModelUser->emp->EMP_ID);
            $searchModel1 = new EmployeSearch();
            $dataProvider = $searchModel1->search_empid($ModelUser->emp->EMP_ID);
            // echo  \yii\helpers\Json::encode($dataProvider);
            //print_r($dataProvider->getModels());
            return $this->render('index', [
                'model' => $model,
                'dataProvider'=>$dataProvider->getModels(),
            ]);
        }
    }


    
	
	public function beforeAction($action)
	{

		if (!parent::beforeAction($action)) {
			return false;
		} 
		
		if ( !Yii::$app->user->isGuest)  {
			if (Yii::$app->session['userSessionTimeout'] < time()) {
				Yii::$app->user->logout();
				$this->redirect(array('/site/login'));
				//$this->redirect(['/site/ubah-password']);
			} else {
				Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);				
				return true; 
			}
		} else {
			return true;
		}
	}
	
	
	
    public function actionLogin()
    {
		Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            //return $this->render('login', [
            //    'model' => $model,
           // ]);
            $js='$("#modal_login").modal("show")';
            $this->getView()->registerJs($js);
            return $this->render('login',['model' => $model]);
        }
    }

    public function actionValidasi(){

            /* Author: -wawan- :validasi salesman-order*/
         if (\Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('index_nologin', [
                'model' => $model,
            ]);
        } else {
            $ModelUser = UserloginSearch::findUserAttr(Yii::$app->user->id)->one();
            $model = $this->findModel1($ModelUser->emp->EMP_ID);
            $searchModel1 = new EmployeSearch();
            $dataProvider = $searchModel1->search_empid($ModelUser->emp->EMP_ID);

                $js='$("#confirm-permission-alert").modal("show")';
                $this->getView()->registerJs($js);
            // echo  \yii\helpers\Json::encode($dataProvider);
            //print_r($dataProvider->getModels());
            return $this->render('index', [
                'model' => $model,
                'dataProvider'=>$dataProvider->getModels(),
            ]);
        }

    }

	/*
	 * FORM LOGIN UTAMA | FORM CHANGE PASSWORD
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	public function actionUbahPassword()
    {
		$js='$("#ubah-password-modal").modal("show")';
        $this->getView()->registerJs($js);
		$validationFormLogin = new ValidationLoginForm();
		return $this->renderAjax('_changePasswordUtama',[
					'validationFormLogin'=>$validationFormLogin,
			]);
	}
	/*
	 * FORM LOGIN UTAMA | SAVE PASSWORD
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	public function actionPasswordUtamaSave()
    {
		$validationFormLogin = new ValidationLoginForm();

		/*
		 * Ajax validate Old password Signature
		 * @author ptrnov  <piter@lukison.com>
		 * @since 1.1
		*/
		if(Yii::$app->request->isAjax){
			$validationFormLogin->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($validationFormLogin));
		}

		if($validationFormLogin->load(Yii::$app->request->post())){
			if ($validationFormLogin->addpassword()) {
				$model = $this->findModel(Yii::$app->user->identity->EMP_ID);
				$newPassword=$validationFormLogin->repassword;
				$dataHtml =$this->renderPartial('NotifyChangePassword',[
								//'model'=>$model,
								'newPassword'=>$newPassword
							]);
				if($model->EMP_EMAIL!=''){
					 Yii::$app->mailer->compose()
					 ->setFrom(['postman@lukison.com' => 'LG-ERP-POSTMAN'])
					 //->setTo(['piter@lukison.com'])
					 //->setTo(['it-dept@lukison.com'])
					 ->setTo($model->EMP_EMAIL)
					 ->setSubject('Change Login Password')
					 ->setHtmlBody($dataHtml)
					 ->send();
				}
				return $this->redirect('index');
			}else{
				 $model = $this->findModel(Yii::$app->user->identity->EMP_ID);
				return $this->redirect('index');
			}
		}
	}
	
	
	 protected  function afterLogin(){
		 
		 yii::$app->user->setState('userSessionTimeout', time() + Yii::app()->params['sessionTimeoutSeconds']); 
	 }
	
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
	protected function findModel1($id)
    {
        if (($model = Employe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
