<?php

namespace lukisongroup\sistem\controllers;

use \yii;
use yii\web\Controller;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\Pjax;
use lukisongroup\sistem\models\SignatureForm;
use lukisongroup\hrd\models\Employe;			/* TABLE CLASS JOIN */
use lukisongroup\hrd\models\EmployeSearch;	/* TABLE CLASS SEARCH */

class UserProfileController extends Controller
{
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
	
    public function actionIndex()
    {
		$model = $this->findModel(Yii::$app->user->identity->EMP_ID);
		//print_r($model->SIGSVGBASE30);
        return $this->render('index',[
			'model'=> $model,
		]);
    }
	
	/*
	 * View | Create Signature Password
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	public function actionSignature()
    {
		$model = $this->findModel(Yii::$app->user->identity->EMP_ID);
		//print_r($model->SIGSVGBASE30);
        return $this->render('_signature',[
			'model'=> $model,
		]);
    }
	
	/*
	 * Index Signature Password
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	public function actionSignatureSaved()
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
	
	/*
	 * Form Signature Password
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	public function actionPasswordSignatureForm()
    {	
		$modelform = new SignatureForm();
		return $this->renderAjax('_signupPassword',[
					'modelform'=>$modelform,
			]);	
	}
	/*
	 * Validation | Saved Entry Signature Password
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	public function actionPasswordSignatureSaved()
    {	
		$modelform = new SignatureForm();
		
		/*
		 * Ajax validate Old password Signature
		 * @author ptrnov  <piter@lukison.com>
		 * @since 1.1
		*/
		if(Yii::$app->request->isAjax){
			$modelform->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($modelform));
		}
				
		if($modelform->load(Yii::$app->request->post())){						
			if ($modelform->addpassword()) {
				$model = $this->findModel(Yii::$app->user->identity->EMP_ID);
				return $this->redirect('signature',[
					'model'=>$model,
				]);
				
			}else{
				 $model = $this->findModel(Yii::$app->user->identity->EMP_ID);
				return $this->redirect('signature',[
					'model'=>$model,
				]); 				
			}			
		}
	
		
		/*Versi 0.1*/
		/* 
		$model = Employe::find()->where(['EMP_ID' => Yii::$app->user->identity->EMP_ID])->one();
		if($model->load(Yii::$app->request->post())){
				$hsl = \Yii::$app->request->post();			
				$passmd5 = $hsl['Employe']['SIGPASSWORD'];
				$oldpassmd5 = $hsl['Employe']['SIGPASSWORD'];
				$modelform = new SignatureForm();
				$modelform->password=$passmd5;			
				if ($modelform->addpassword()) {
					return $this->renderAjax('_signupPassword',[
						'model'=>$model,
					]);
				}			
		}else{		  
		   return $this->renderAjax('_signupPassword',[
					'model'=>$model,
			]);		
		}
		 */
		/* Ver 0.0*/
		/* $model = Employe::find()->where(['EMP_ID' => Yii::$app->user->identity->EMP_ID])->one();
		if($model->load(Yii::$app->request->post())){
			$hsl = \Yii::$app->request->post();
			
			$passmd5 = $hsl['Employe']['SIGPASSWORD'];
			//$model->SIGPASSWORD = 
			$model->setPassword_signature($passmd5); //Yii::$app->security->generatePasswordHash($passmd5);
			//$model->SIGPASSWORD = Yii::$app->security->generatePasswordHash($passmd5);
			$model->save();			
		}else{		
			return $this->renderAjax('_signupPassword',[
				'model'=>$model,
			]);
		} */
		
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
