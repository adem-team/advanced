<?php

namespace lukisongroup\front\controllers;

use yii\web\Controller;

class ProductController extends Controller
{
    public function actionIndex($id)
    {
		if($id=='lg'){
			$corp="PT. Lukison Group";
		}elseif ($id=='sss'){
			$corp="PT. Sarana Sinar Surya";
		}elseif ($id=='esm'){
			$corp="PT. Efenbi Sukses Makmur";
		}elseif ($id=='alg'){
			$corp="PT. Artha Lipat Ganda";
		}		
        return $this->render('index',[
			'corp_nm'=>$corp
		]);
    }
}
