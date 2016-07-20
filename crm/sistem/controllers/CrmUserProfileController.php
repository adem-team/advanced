<?php

namespace crm\sistem\controllers;

/* extensions */
use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use zyx\phpmailer\Mailer;
use yii\helpers\ArrayHelper;

/* namespace models*/
use crm\mastercrm\models\Distributor;
use crm\sistem\models\ValidationLoginFormCrm;
use crm\sistem\models\Userprofile;

class CrmUserProfileController extends Controller
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
			$fileLink="data_userprofile";
		  $profile=Yii::$app->getUserOptcrm->Profile_user()->userprofile; //component Crm

			$id = Yii::$app->getUserOptcrm->Profile_user()->id; //component Crm

       return $this->render('index',[
			      'profile'=> $profile,
						'id'=>$id,
						 'fileLink'=>$fileLink
		      ]);

    }

/*
		*author : wawan
		*create new user profile if creation succes,redirect index */
		public function actionCreateAddProfile()
		{
			$model = new Userprofile();

			if ($model->load(Yii::$app->request->post())){
				$base64File = \yii\web\UploadedFile::getInstance($model, 'image');
							$File64 = $this->saveimage(file_get_contents($base64File->tempName));
					$model->IMG_BASE64 =$File64;
					$model->ID = Yii::$app->getUserOptcrm->Profile_user()->id;
					$model->CREATED_BY=Yii::$app->user->identity->username;
					$model->UPDATED_TIME=date('Y-m-d h:i:s');
			       $model->save();
				 	return $this->redirect('index');
			}else {
					return $this->renderAjax('_form_add-profile', [
							'model' => $model,
					]);
			}
		}

		/*
		*author : wawan
		*update  user profile if creation succes,redirect index */
		public function actionTempat($id)
		{
			 $profile=Yii::$app->getUserOptcrm->Profile_user()->userprofile; //component Crm
			$model = Userprofile::find()->where(['id'=>$id])->one();

			if ($model->load(Yii::$app->request->post())){
			       $model->save();
				 	return $this->redirect('index');
			}else {
					return $this->renderAjax('_set_informasi', [
							'model' => $model,
							'profile'=>$profile
					]);
			}
		}


		/*
		*author : wawan
		*update  user profile if creation succes,redirect index */
		public function actionPribadiEdit($id)
		{
			 $profile=Yii::$app->getUserOptcrm->Profile_user()->userprofile; //component Crm
			$model = Userprofile::find()->where(['id'=>$id])->one();

			if ($model->load(Yii::$app->request->post())){
			       $model->save();
				 	return $this->redirect('index');
			}else {
					return $this->renderAjax('_set_pribadi', [
							'model' => $model,
							'profile'=>$profile
					]);
			}
		}




		/*
				*author : wawan
				*create update user profile if creation succes,redirect index */
				public function actionSettingProfile($id)
				{
					$model =  Userprofile::find()->where(['ID'=>$id])->one();
					$distributor = ArrayHelper::map(Distributor::find()->where('STATUS <>3')->all(), 'KD_DISTRIBUTOR', 'NM_DISTRIBUTOR');
					$username = Yii::$app->getUserOptcrm->Profile_user()->username; //component Crm

					if ($model->load(Yii::$app->request->post())){
							$model->CREATED_BY = $username;
							$model->UPDATED_TIME = date('Y-m-d h:i:s');
							$base64File = \yii\web\UploadedFile::getInstance($model, 'image');
							$File64 = $this->saveimage(file_get_contents($base64File->tempName));
							$model->IMG_BASE64 = 'data:'.$base64File->type.';charset=utf-8;base64,'.$File64;
							$model->save();

						 return $this->redirect('index');
			}else {
							return $this->renderAjax('set_profile', [
									'model' => $model,
									'distributor'=>$distributor
							]);
					}
				}



	public function actionPribadi()
    {
		$ttlheader="INFORMASI PRIBADI";
		$fileLink="_empPribadi";
		$modelUpload = new FileManage();
		$model = $this->findModel(Yii::$app->user->identity->EMP_ID);
		//print_r($model->SIGSVGBASE30);
        return $this->render('index',[
			'ttlheader'=>$ttlheader,
			'fileLink'=>$fileLink,
			'model'=> $model,
			'modelUpload'=>$modelUpload
		]);
    }

	/*
	 * FORM LOGIN UTAMA | FORM CHANGE PASSWORD
	 * @author wawan
	 * @since 1.0
	*/
	public function actionPasswordUtamaView()
    {
		$validationFormLogin = new ValidationLoginFormCrm();
    $profile=Yii::$app->getUserOptcrm->Profile_user()->userprofile; //component Crm
		return $this->renderAjax('_changePasswordUtama',[
					'validationFormLogin'=>$validationFormLogin,
          'profile'=>$profile
			]);
	}
	/*
	 * FORM LOGIN UTAMA | SAVE PASSWORD
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	public function actionPasswordUtamaSave()
    {
		$validationFormLogin = new ValidationLoginFormCrm();

		/*
		 * Ajax validate Old password Signature
		 * @author wawan
		 * @since 1.0
		*/
		if(Yii::$app->request->isAjax){
			$validationFormLogin->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($validationFormLogin));
		}

		if($validationFormLogin->load(Yii::$app->request->post())){
			if ($validationFormLogin->addpassword()) {
			  $profile=Yii::$app->getUserOptcrm->Profile_user()->userprofile; //component Crm
				$newPassword=$validationFormLogin->repassword;
				$dataHtml =$this->renderPartial('NotifyChangePassword',[
								//'model'=>$model,
								'newPassword'=>$newPassword
							]);
				if($profile->EMAIL!=''){
					 Yii::$app->mailer->compose()
					 ->setFrom(['postman@lukison.com' => 'LG-ERP-POSTMAN'])
					 //->setTo(['piter@lukison.com'])
					 //->setTo(['it-dept@lukison.com'])
					 ->setTo($profile->EMAIL)
					 ->setSubject('Change Login Password')
					 ->setHtmlBody($dataHtml)
					 ->send();
				}
				return $this->redirect('index');
			}else{
				//  $model = $this->findModel(Yii::$app->user->identity->EMP_ID);
				return $this->redirect('index');
			}
		}
	}

	/*
	 * View | Create Signature Password
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	public function actionSignature()
    {
		$model = $this->findModel(Yii::$app->user->identity->EMP_ID);

		$paramFile=Yii::$app->getRequest()->getQueryParam('id');



		$paramID =$paramFile!=false?$paramFile:'0';
		if ($paramFile==true){
			$modelUpload = FileManage::find()->where(['ID'=>$paramID])->One();
		}else{
			$modelUpload = new FileManage();
		}
		//$modelUpload = new FileManage();

		//print_r($model->SIGSVGBASE30);
        return $this->render('_signature',[
			'model'=> $model,
			'modelUpload'=>$modelUpload
		]);
    }

/* base 64 convert function author:wawan*/
	public function saveimage($base64)
    {
      $base64 = str_replace('data:image/jpg;charset=utf-8;base64,', '', $base64);
      $base64 = base64_encode($base64);
      $base64 = str_replace(' ', '+', $base64);

      return $base64;

    }

	public function actionUploadInput()
    {
		//$fileName = 'file';

		$model = new FileManage();
		if ($model->load(Yii::$app->request->post()) ) {
			//if($model->validate()){
				$model->USER_ID = Yii::$app->user->identity->username;
				$model->FILE_PATH = 'signature';
				$exportFile = $model->uploadFile();
				//$base64File = \yii\web\UploadedFile::getInstance($model, 'uploadDataFile');
				// $dateFile=\yii\web\UploadedFile::getInstanceByName($fileName);

				$exportFile64 = $this->saveimage(file_get_contents($exportFile->tempName));
				$model->FILE_NM64 = 'data:image/jpg;charset=utf-8;base64,'.$exportFile64;
				//print_r($exportFile64);
				//die();
				if ($model->save()) {
					//upload only if valid uploaded file instance found
					if ($exportFile !== false) {
						$path = $model->getImageFile();
						$exportFile->saveAs($path);





						return $this->redirect(['signature','id'=>$model->ID]);
					}
				}
			//}
		}
	}

	public function actionUploadSignatureFile()
    {
		$model = new FileManage();

		if ($model->load(Yii::$app->request->post()) ) {
			//if($model->validate()){
				$model->USER_ID = Yii::$app->user->identity->username;
				$model->FILE_PATH = 'signature';
				$exportFile = $model->uploadFile();
				//$base64File = \yii\web\UploadedFile::getInstance($model, 'uploadDataFile');
				// $dateFile=\yii\web\UploadedFile::getInstanceByName($fileName);

				$exportFile64 = $this->saveimage(file_get_contents($exportFile->tempName));
				$exportFile64Image='data:image/jpg;charset=utf-8;base64,'.$exportFile64;
				$model->FILE_NM64 = $exportFile64Image;
				//print_r($exportFile64);
				//die();
				if ($model->save()) {
					//upload only if valid uploaded file instance found
					if ($exportFile !== false) {
						$path = $model->getImageFile();
						$exportFile->saveAs($path);
						$employeUpdate =Employe::find()->where(['EMP_ID'=>Yii::$app->user->identity->EMP_ID])->one();
						$employeUpdate->SIGSVGBASE64=$exportFile64Image;
						$employeUpdate->save();
						return $this->redirect(['index']);
					}
				}
			//}
		}
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

		$paramFile=Yii::$app->getRequest()->getQueryParam('id');

		$paramID =$paramFile!=false?$paramFile:'0';
		if ($paramFile==true){
			$modelUpload = FileManage::find()->where(['ID'=>$paramID])->One();
		}else{
			$modelUpload = new FileManage();
		}



		if ($model->load(Yii::$app->request->post())){
			//$hsl = \Yii::$app->request->post();
			$model->UPDATED_BY=Yii::$app->user->identity->username;
			$model->SIGSVGBASE64=$hsl['Employe']['SIGSVGBASE64'];
			$model->SIGSVGBASE30=$hsl['Employe']['SIGSVGBASE30'];
			$model->save();
				if($model->save()) {
					return $this->render('_signature',[
						'model'=> $model,
						'modelUpload'=>$modelUpload
					]);
				}
		}else{
			return $this->render('_signature_form',[
                'model' => $model
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


		$modelUpload = new FileManage();

		if(Yii::$app->request->isAjax){
			$modelform->load(Yii::$app->request->post());
			return Json::encode(\yii\widgets\ActiveForm::validate($modelform));
		}

		if($modelform->load(Yii::$app->request->post())){
			if ($modelform->addpassword()) {
				$model = $this->findModel(Yii::$app->user->identity->EMP_ID);
				$newPassword=$modelform->repassword;
				$dataHtml =$this->renderPartial('NotifyChangePasswordSignature',[
								//'model'=>$model,
								'newPassword'=>$newPassword
							]);
							// die();
				if($model->EMP_EMAIL!=''){
					 Yii::$app->mailer->compose()
					 ->setFrom(['postman@lukison.com' => 'LG-ERP-POSTMAN'])
					 //->setTo(['piter@lukison.com'])
					 //->setTo(['it-dept@lukison.com'])
					 ->setTo($model->EMP_EMAIL)
					 ->setSubject('Change Signature Password')
					 ->setHtmlBody($dataHtml)
					 ->send();
				}
				return $this->redirect('signature',[
					// 'model'=>$model,
					// 'modelUpload'=>$modelUpload,
				]);

				// return $this->render('_signature',[
				// 	'model'=>$model,
				// 	'modelUpload'=>$modelUpload,
				// ]);

			}else{
				 $model = $this->findModel(Yii::$app->user->identity->EMP_ID);
				return $this->redirect('signature',[
					// 'model'=>$model,
					// 'modelUpload'=>$modelUpload,
				]);
				// return $this->render('_signature',[
				// 	'model'=>$model,
				// 	'modelUpload'=>$modelUpload,
				// ]);
			}
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

}
