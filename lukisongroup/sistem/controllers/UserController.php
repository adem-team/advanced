<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\sistem\controllers;

/* VARIABLE BASE YII2 Author: -YII2- */
	use Yii;
	use yii\web\Controller;
	use yii\web\NotFoundHttpException;
	use yii\filters\VerbFilter;
/* CLASS USER Author: -ptr.nov- */
use lukisongroup\sistem\models\Userlogin;			/* TABLE CLASS JOIN */
use lukisongroup\sistem\models\UserloginSearch;		/* TABLE CLASS SEARCH */
use lukisongroup\sistem\models\PasswordResetRequestForm;
use lukisongroup\sistem\models\ResetPasswordForm;
use lukisongroup\sistem\models\SignupForm;
use lukisongroup\sistem\models\ContactForm;
/**
 * HRD | CONTROLLER MODUL HRD .
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(['Userlogin']),
                'actions' => [
                    //'delete' => ['post'],
					'save' => ['post'],
                ],
            ],
        ];
    }
	
	/**
     * Before Action Index
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
		/*	variable content View Modul Hrd Author: -ptr.nov- */
        $searchModel_Userlogin = new UserloginSearch();
		$dataProvider_Userlogin = $searchModel_Userlogin->search(Yii::$app->request->queryParams);
		
		return $this->render('index', [
			'searchModel_Userlogin'=>$searchModel_Userlogin,
			'dataProvider_Userlogin'=>$dataProvider_Userlogin,
        ]);
    }

    /**
	 * ACTION VIEW -> $id=PrimaryKey
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);;
		if ($model->load(Yii::$app->request->post())){
			if($model->validate()){
				if($model->save()) {
					return $this->redirect(['view', 'id' => $model->id]);	
				} 
			}
		}else {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    /**
     * ACTION CREATE note | $id=PrimaryKey -> TRIGER FROM VIEW  -ptr.nov-
     */
    public function actionCreate()
    {		
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                //if (Yii::$app->getUser()->login($user)) {  // user save signup return langsung login
                //    return $this->goHome();
                //}
                $searchModel_Userlogin = new UserloginSearch();
                $dataProvider_Userlogin = $searchModel_Userlogin->search(Yii::$app->request->queryParams);
        
                return $this->render('index', [
                    'searchModel_Userlogin'=>$searchModel_Userlogin,
                    'dataProvider_Userlogin'=>$dataProvider_Userlogin,
                ]);
            }
        }

        
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * ACTION UPDATE -> $id=PrimaryKey
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * ACTION DELETE -> $id=PrimaryKey | CHANGE STATUS -> lihat Standart table status | Jangan dihapus dari record
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * CLASS TABLE FIND PrimaryKey
     * Example:  Employe::find()
     */
    protected function findModel($id)
    {
        if (($model = Userlogin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            //if ($user = $model->signup()) {
                /*if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
				*/
				//return $this->goBack();//.'/admin'; // Return url user menu admin -ptr.nov-
				//return $this->redirect('/index.php/admin');
           // }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
	
}
