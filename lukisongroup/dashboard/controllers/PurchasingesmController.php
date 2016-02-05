<?php
namespace lukisongroup\dashboard\controllers;


use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use lukisongroup\purchasing\models\pr\PurchaseorderSearch;
use lukisongroup\purchasing\models\pr\Purchaseorder;
use lukisongroup\purchasing\models\pr\NewPoValidation;

class PurchasingesmController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

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
          $searchModel = new PurchaseorderSearch();
          $dataProvider = $searchModel->searchpoesm(Yii::$app->request->queryParams);
          // print_r(  $dataProvider);
          // die();


         $poHeader = new Purchaseorder();
         /*Model Validasi Generate Code*/
         $poHeaderVal = new NewPoValidation();

          return $this->render('index', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,
              'poHeader'=>$poHeader,
              'poHeaderVal'=>  $poHeaderVal

          ]);
      }
    }













 ?>
