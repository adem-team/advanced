<?php

namespace lukisongroup\widget\controllers;

use yii\web\Controller;
use Yii;

class ArsipFileController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /*
      *convert base 64 image
      *@author:wawan since 1.0
    */
    public function saveimage($base64)
    {
      $base64 = str_replace('data:image/jpg;base64,', '', $base64);
      $base64 = base64_encode($base64);
      $base64 = str_replace(' ', '+', $base64);

      return $base64;

    }

    public function actionFileUpload()
    {	$fileName = 'attach';

    	$id = $_POST['folder_id'];

		    $file1 = \yii\web\UploadedFile::getInstanceByName($fileName);
		  
		     $data = $this->saveimage(file_get_contents($file1->tempName)); //call function saveimage using base64
		       $connection = Yii::$app->db;
	           $connection->createCommand()->Insert('files_01', [
						    'folder_id' => $id,
						    'base64' => $data,
						])->execute();

            echo \yii\helpers\Json::encode($file);
		
		 return false;
    	
    }

    public function actionViewImage()
    {
    	 return $this->renderAjax('display_image');
    }
   
}
