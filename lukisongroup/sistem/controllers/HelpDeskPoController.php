<?php

namespace lukisongroup\sistem\controllers;

use Yii;
use lukisongroup\sistem\models\HelpDeskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class HelpDeskPoController extends Controller
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

    /**
       * Before Action Index
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
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


      /*
    	 * Index Helpdesk
    	 * @author wawan
    	 * @since 1.0
    	*/
        public function actionIndex()
        {
            $searchModelCancel = new HelpDeskSearch();
            $dataProviderCancel = $searchModelCancel->searchproses(Yii::$app->request->queryParams);
            $searchmodelChecked = new HelpDeskSearch();
            $dataproviderChecked = $searchmodelChecked->searchchecked(Yii::$app->request->queryParams);
            $searchmodelApproved = new HelpDeskSearch();
            $dataproviderApproved = $searchmodelApproved->searchapproval(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModelCancel' => $searchModelCancel,
                'dataProviderCancel' => $dataProviderCancel,
                'searchmodelChecked' => $searchmodelChecked,
                'dataproviderChecked' => $dataproviderChecked,
                'searchmodelApproved' => $searchmodelApproved,
                'dataproviderApproved' => $dataproviderApproved,
            ]);
        }



  }
 ?>
