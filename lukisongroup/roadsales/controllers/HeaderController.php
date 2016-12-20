<?php

namespace lukisongroup\roadsales\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use lukisongroup\roadsales\models\SalesRoadHeader;
use lukisongroup\roadsales\models\SalesRoadHeaderSearch;
use lukisongroup\roadsales\models\SalesRoadImage;
use lukisongroup\roadsales\models\SalesRoadImageSearch;

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
}
