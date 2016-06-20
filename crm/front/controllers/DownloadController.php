<?php

namespace crm\front\controllers;

use Yii;
use yii\web\Controller;

class DownloadController extends Controller
{
    /* public function actionIndex($id)
    {
		if($id=='lg'){
			$corp="PT. Lukison Group";
		}elseif ($id=='sss'){
			$corp="PT. Sarana Sinar Surya";
		}elseif ($id=='esm'){
			$corp="PT. Effembi Sukses Makmur";
		}elseif ($id=='alg'){
			$corp="PT. Artha Lipat Ganda";
		}		
        return $this->render('index',[
			'corp_nm'=>$corp
		]); 	
    } */
	
	public function actionIndex(){
		$penjelasan =$this->renderPartial('_penjelasan');
		$linkDownload =$this->renderPartial('_downloadLink');
		$installapp =$this->renderPartial('_installapp');
		return $this->render('index',[
			'linkDownload'=>$linkDownload ,
			'penjelasan'=>$penjelasan,
			'installapp'=>$installapp,
		]);
	}
	
	public function actionAppSales(){
		$baseRoot = Yii::getAlias('@webroot') . "/download/LukisonGroup.apk";
		$fp = fopen($baseRoot, "r");
		$file_size = filesize($baseRoot);
		
		Header("Content-type: application/octet-stream");
		Header("Accept-Ranges: bytes");
		Header("Content-Disposition: attachment; filename=LG-SALES.apk");
		Header("Content-Length:" . $file_size);
		
		$buffer = 1024;
        $file_count = 0;
		
		while (!feof($fp) && $file_count < $file_size) {
            $file_con = fread($fp, $buffer);
            $file_count+=$buffer;
            echo $file_con;
        }
		
		fclose($fp);
        
        return 1;
	}
}
