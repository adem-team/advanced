<?php

namespace lukisongroup\warehouse\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use lukisongroup\warehouse\models\RcvdReleaseHeader;
use lukisongroup\warehouse\models\RcvdReleaseHeaderSearch;
use lukisongroup\warehouse\models\RcvdReleaseDetail;
use lukisongroup\warehouse\models\RcvdReleaseDetailSearch;

use lukisongroup\warehouse\models\HeaderPenerimaanSearch;
use lukisongroup\warehouse\models\HeaderDetailRcvd;
// use lukisongroup\warehouse\models\HeaderDetailRcvdSearch;
// use lukisongroup\warehouse\models\HeaderDetailRelease;
// use lukisongroup\warehouse\models\HeaderDetailReleaseSearch;


/**
 * HeaderDetailRcvdController implements the CRUD actions for HeaderDetailRcvd model.
 */
class HeaderReceiveController extends Controller
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
     * Lists all HeaderDetailRcvd models.
     * @return mixed
     */
    public function actionIndex()
    {
    	/**
		  * HEADER SEARCH RELEASE & RCVD.
		  * MODEL & MODEL SEARCH.
		  * UPDATE 	: 08/02/2017
		  * Author	: ptr.nov@gmail.com.
		*/
		$searchModelReleaseRcvdHeader = new RcvdReleaseHeaderSearch();
        $dataProviderReleaseRcvdHeader = $searchModelReleaseRcvdHeader->search(Yii::$app->request->queryParams);
		
		/**
		  * DETAIL SEARCH RELEASE & RCVD.
		  * MODEL & MODEL SEARCH.
		  * UPDATE 	: 08/02/2017
		  * Author	: ptr.nov@gmail.com.
		*/
		$searchModelReleaseRcvdDetail = new RcvdReleaseDetailSearch();
        $dataProviderReleaseRcvdDetail = $searchModelReleaseRcvdDetail->search(Yii::$app->request->queryParams);
		
		/**
		  * MANIPULASI DETAIL->HEADER RCVD
		  * Many To ONE (DETAI TO HEADER).
		  * UPDATE 	: 08/02/2017
		  * Author	: ptr.nov@gmail.com.
		*/
		$searchModelPenerimaan = new HeaderPenerimaanSearch();
        $dataProviderPenerimaan = $searchModelPenerimaan->search(Yii::$app->request->queryParams);
		
        return $this->render('index', [			
			// HEADER SEARCH RELEASE & RCVD.
			'searchModelReleaseRcvdHeader'=>$searchModelReleaseRcvdHeader,
			'dataProviderReleaseRcvdHeader'=>$dataProviderReleaseRcvdHeader,
			// DETAIL SEARCH RELEASE & RCVD.
			'searchModelReleaseRcvdDetail'=>$searchModelReleaseRcvdDetail,
			'dataProviderReleaseRcvdDetail'=>$dataProviderReleaseRcvdDetail,
			//MANIPULASI DETAIL->HEADER RCVD
         	'dataProviderPenerimaan'=>$dataProviderPenerimaan,
			'searchModelPenerimaan'=>$searchModelPenerimaan,
        ]);
    }

    /**
     * Displays a single HeaderDetailRcvd model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HeaderDetailRcvd model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HeaderDetailRcvd();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing HeaderDetailRcvd model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing HeaderDetailRcvd model.
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
     * Finds the HeaderDetailRcvd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HeaderDetailRcvd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HeaderDetailRcvd::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
