<?php

namespace lukisongroup\sistem\controllers;

use \yii;
use yii\web\Controller;
use lukisongroup\hrd\models\Employe;			/* TABLE CLASS JOIN */
use lukisongroup\hrd\models\EmployeSearch;	/* TABLE CLASS SEARCH */

class UserProfileController extends Controller
{
    public function actionIndex()
    {
		$model = $this->findModel(Yii::$app->user->identity->EMP_ID);
		//print_r($model->SIGSVGBASE30);
        return $this->render('index',[
			'model'=> $model,
		]);
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
	
	public function actionCreate()
    {		
            return $this->renderAjax('_signature_form'
			/* , [
                'roDetail' => $roDetail,
				'roHeader' => $roHeader,
            ] */
			);	
		
    }
	
	public function actionSimpanSignature()
    {		
		$hsl = \Yii::$app->request->post();
		$model = $this->findModel($hsl['Employe']['EMP_ID']);
			
		if ($model->load(Yii::$app->request->post())){	
			//$hsl = \Yii::$app->request->post();
			$model->UPDATED_BY=Yii::$app->user->identity->username;
			$model->SIGSVGBASE64=$hsl['Employe']['SIGSVGBASE64'];
			$model->SIGSVGBASE30=$hsl['Employe']['SIGSVGBASE30'];
			$model->save();
			if($model->save()) {				
				return $this->render('index',[
					'model'=> $model,
				]);
			}
		}else{
			return $this->render('_signature_form',[
                '$model' => $model
            ] );	
		}
    }
	
	/**
     * CLASS TABLE FIND PrimaryKey
     * Example:  Employe::find()
     */
    protected function findModel($id)
    {
        if (($model = Employe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
