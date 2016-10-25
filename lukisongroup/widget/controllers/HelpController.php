<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\widget\controllers;

/* VARIABLE BASE YII2 Author: -YII2- */
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter; 	
use lukisongroup\widget\models\DokumenHelp;

class HelpController extends Controller
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
		$introduction =$this->renderPartial('erp_introduction');
		$pur_penjelasan =$this->renderPartial('purchasing\CreatePo');
		$pur_permission =$this->renderPartial('purchasing\Permission');
		$ro_tutorial =$this->renderPartial('ro\ro_tutorial');
		$so_tutorial =$this->renderPartial('so\so_tutorial');
		
		
		$hrm_penjelasan =$this->renderPartial('hrm\penjelasan');
		
		
		return $this->render('index',[
			/*Introduction*/
			'introduction'=>$introduction,
			/*Purchasing*/
			'pur_penjelasan'=>$pur_penjelasan,
			'pur_permission'=>$pur_permission,
			/*HRM*/
			'hrm_penjelasan'=>$hrm_penjelasan,
			/*RO Tutorial*/
			'ro_tutorial'=>$ro_tutorial,
			/*SO Tutorial*/
			'so_tutorial'=>$so_tutorial
		]);
    
    }
	
	 /**
     * ACTION INDEX
     */
    public function actionDbHelp()
    {		
		$dbStatus =$this->renderPartial('doc-db\status');
		
		
		return $this->render('conten_db',[
			'dbStatus'=>$dbStatus,
			
		]);
    
    }
	
	 /**
     * ACTION Tips
     */
    public function actionDocTip()
    {		
		$erp_introduction =$this->renderPartial('doc-tip\erp_introduction');
		
		return $this->render('conten_tips',[
			'erp_introduction'=>$erp_introduction, 	
			
		]);
    
    }
}
