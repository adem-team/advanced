<?php

namespace lukisongroup\sistem\controllers;

use yii\web\Controller;

class UserProfileController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
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
            return $this->renderAjax('_signature_form'
			/* , [
                'roDetail' => $roDetail,
				'roHeader' => $roHeader,
            ] */
			);	
		
    }
}
