<?php

namespace lukisongroup\roadsales\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

use lukisongroup\roadsales\models\SalesRoadHeader;
use lukisongroup\roadsales\models\SalesRoadHeaderSearch;
use lukisongroup\roadsales\models\SalesRoadImage;
use lukisongroup\roadsales\models\SalesRoadImageSearch;
use lukisongroup\roadsales\models\SalesRoadReport;

/**
 * HeaderController implements the CRUD actions for SalesRoadHeader model.
 */
class HeaderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
     * Lists all SalesRoadHeader models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalesRoadHeaderSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->searchGroup(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	public function actionDisplyImage($tgl,$user_id)
    {
		//print_r($tgl);
		//die();
		//$searchModelViewImg = new SalesRoadImageSearch(['CREATED_AT'=>$tgl,'CREATED_BY'=>$user_id]);
		$searchModelViewImg = new SalesRoadImageSearch(['CREATED_AT'=>$tgl,'CREATED_BY'=>$user_id]);
		//$searchModelViewImg = new SalesRoadImageSearch(['CREATED_AT'=>$tgl]);
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
	
	public function actionViewDetail($tgl,$user)
    {
		//print_r($tgl);
		//die();
		//$searchModelViewImg = new SalesRoadImageSearch(['CREATED_AT'=>$tgl,'CREATED_BY'=>$user_id]);
		$searchModelViewImg = new SalesRoadImageSearch(['CREATED_AT'=>$tgl,'CREATED_BY'=>$user_id]);
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
			return $this->renderAjax('viewDetail', [
				//'model'=>$listImg,
			]);
			
		//}
    }
	
	public function actionCoba(){
		$searchModel = new SalesRoadHeaderSearch([
			'USER_ID'=>'34'
		]);
		
		        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->searchAryChart(Yii::$app->request->queryParams);
		$listImg=$dataProvider->getModels();
		//print_r($listImg[0]->CASE_NM);
		
		/**
		 * FILE WITH OTHER FILED DATA ARRAY 
		 * @author ptr.nov [ptr.nov@gmail.com]
		 * @since 1.2
		 * FOREACH FIELD DATA ARRAY 
		 * ADD FILED NO Array
		 * RESULT ROW DATA.
		 */
		foreach ($listImg as $key1 => $nilai1){
			$val=explode(",",$listImg[$key1]['CASE_ID']);
			foreach ($val as $key2 => $nilai2){
					$resultDetail[]=['USER_ID'=>$listImg[$key1]['USER_ID'],'TGL'=>$listImg[$key1]['CREATED_AT'],'CASE_ID'=>$nilai2];					
			};
			
		}	
	
		// $dataProvider2= new ArrayDataProvider([
			// 'key' => 'USER_ID',
			// 'allModels'=>$resultDetail,
			// 'sort' => [
				// 'attributes' => ['TGL'],
			// ],
			// 'pagination' => [
				// 'pageSize' => 500,
			// ]
		// ]); 
		
		// foreach($resultDetail as $key => $value){
			// $model = new SalesRoadReport();
			// $model->TGL = $value['TGL'];				//date("Y-m-d");;
			// $model->CASE_ID = $value['CASE_ID'];		//'123';
			// $model->CREATED_AT = $value['TGL'];			//date("Y-m-d H:m:s");;
			// $model->CREATED_BY = $value['USER_ID'];		//'123';
			// $model->save();
		// }
		
		
		//print_r($result);
		//$resultX = ArrayHelper::index($result, null, 'user');
		//print_r($dataProvider2->getCount());
		// $groupBy1=self::array_group_by($dataProvider2->getModels(),'TGL');
		// $groupBy2=self::array_group_by($groupBy1,'USER_ID');
		// $groupBy3=self::array_group_by($groupBy2,'CASE_NM');
		//$aryRslt=self::sortArrayByKey($groupBy2,'USER_ID'	,true,false);
		//print_r($groupBy3);
		//return  json_encode($groupBy3);
		//return count($dataProvider2->getModels(), COUNT_RECURSIVE);
		
		// if (in_array("Irix", $os)) {
			// echo "Got Irix";
		// }
		
		

		print_r($listImg);
		
	}
	
	
	
	
	
	
	
    /**
     * Displays a single SalesRoadHeader model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SalesRoadHeader model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SalesRoadHeader();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ROAD_D]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SalesRoadHeader model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ROAD_D]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SalesRoadHeader model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SalesRoadHeader model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalesRoadHeader the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalesRoadHeader::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	/**
	 * ARRAY GROUPING 
	 * @author Piter Novian [ptr.nov@gmail.com] 
	*/	
	private static function array_group_by($arr, $key)
	{
		if (!is_array($arr)) {
			trigger_error('array_group_by(): The first argument should be an array', E_USER_ERROR);
		}
		if (!is_string($key) && !is_int($key) && !is_float($key)) {
			trigger_error('array_group_by(): The key should be a string or an integer', E_USER_ERROR);
		}
		// Load the new array, splitting by the target key
		$grouped = [];
		foreach ($arr as $value) {
			$grouped[$value[$key]][] = $value;
		}
		// Recursively build a nested grouping if more parameters are supplied
		// Each grouped array value is grouped according to the next sequential key
		if (func_num_args() > 2) {
			$args = func_get_args();
			foreach ($grouped as $key => $value) {
				$parms = array_merge([$value], array_slice($args, 2, func_num_args()));
				$grouped[$key] = call_user_func_array('array_group_by', $parms);
			}
		}
		return $grouped;
	}
	
	function sortArrayByKey(&$array,$key,$string = false,$asc = true){
		if($string){
			usort($array,function ($a, $b) use(&$key,&$asc)
			{
				if($asc)    return strcmp(strtolower($a[$key]), strtolower($b[$key]));
				else        return strcmp(strtolower($b[$key]), strtolower($a[$key]));
			});
		}else{
			usort($array,function ($a, $b) use(&$key,&$asc)
			{
				if($a[$key] == $b[$key]){return 0;}
				if($asc) return ($a[$key] < $b[$key]) ? -1 : 1;
				else     return ($a[$key] > $b[$key]) ? -1 : 1;

			});
		}
	}
}
