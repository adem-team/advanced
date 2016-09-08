<?php

namespace crm\mastercrm\controllers;

use Yii;
use yii\web\Controller;
use kartik\helpers\Html;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use crm\mastercrm\models\ReviewHeaderSearch;
use crm\mastercrm\models\CustomercallTimevisitSearch;

class ReviewVisitController extends Controller
{	
	public function actionIndex()
    {
		if (\Yii::$app->user->isGuest) {
            return $this->render('../../../views/site/index_nologin');
        }else{	

			//Get value tgl from $tab
			$tgl=Yii::$app->getRequest()->getQueryParam('tgl');
			$setTgl=$tgl!=''?$tgl:date('Y-m-d');
						
			/**
			 * Syncronize Report Customercall Time
			 */
			if($this->checkRpt($setTgl)==0 or $this->checkRpt($setTgl)==1){			
				$searchModel = new ReviewHeaderSearch([
					'TGL'=>$setTgl
				]);
				$dataProvider = $searchModel->searchHeaderReview(Yii::$app->request->queryParams);				
				return $this->render('index',[
					'dataProviderHeader1'=>$dataProvider,
					'searchModelHeader1'=>$searchModel,
				]);
			}else{
				return $this->redirect(['index?tgl='.$setTgl]);
			}
		};	
    }
	public function actionAmbilTanggal()
	{
		$model = new \yii\base\DynamicModel(['tanggal']);
		$model->addRule(['tanggal'], 'safe');
		if ($model->load(Yii::$app->request->post())) {
			$hsl = Yii::$app->request->post();
			$tgl = $hsl['DynamicModel']['tanggal'];
			return $this->redirect(['index', 'tgl'=>$tgl]);
		}else{			
			return $this->renderAjax('_indexform', [
			'model'=>$model,
			]);
		}
	}
	
	
	/**
	 * NEW METHOD REPORT 
	 * CHECK REPORT EXCUTE OR READY
	 * Table c0002rpt_cc_time.
	 * Procdure REPORT_CUSTOMERCALL_TIMEVISIT(TGL).
	 * @author Piter Novian [ptr.nov@gmail.com]
	 * @since 2.0
	*/
	private function checkRpt($tgl){
		$data=\Yii::$app->db_esm->createCommand("
					call REPORT_CUSTOMERCALL_TIMEVISIT('".$tgl."')
				")->execute();//->queryAll();
		return $data;
	}
	
	
	public function actionDisplyImage($tgl,$user_id)
    {
		//print_r($tgl);
		//die();
		$searchModelViewImg = new CustomercallTimevisitSearch(['TGL'=>$tgl,'USER_ID'=>$user_id]);
		$dataProviderViewImg=$searchModelViewImg->search(Yii::$app->request->queryParams);
		$listImg=$dataProviderViewImg->getModels();
		//if (Yii::$app->request->isAjax) {
			// $request= Yii::$app->request;
			// $id=$request->post('id');
			// $roDetail = Purchasedetail::findOne($id);
			// $roDetail->STATUS = 3;
			// $roDetail->save();
			// return true;
			$model = new \yii\base\DynamicModel(['tanggal']);
			$model->addRule(['tanggal'], 'safe');
			return $this->renderAjax('_viewImageModal', [
				'model'=>$listImg,
			]);
			
		//}
    }
	
	
}
