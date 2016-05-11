<?php
namespace lukisongroup\master\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

use lukisongroup\master\models\Scheduledetail;
use lukisongroup\master\models\ScheduledetailSearch;
use lukisongroup\master\models\Schedulegroup;
use lukisongroup\master\models\CustomerVisitImage;

class ScheduleDetailController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
	
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
	
	private function aryGroupID(){
		$dataGroup =  ArrayHelper::map(Schedulegroup::find()->orderBy('SCDL_GROUP_NM')->asArray()->all(), 'ID','SCDL_GROUP_NM');
		return $dataGroup;
	}
	
	
    /**
     * Lists all Scheduledetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ScheduledetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'nmGroup'=>$this->aryGroupID(),
        ]);
    }

    /**
     * Displays a single Scheduledetail model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

	public function actionImg1($id)
	{
		$model = CustomerVisitImage::find()->where(['ID_DETAIL'=>$id])->one();
		return $this->renderAjax('image1', [
				'model' => $model,
			]);
	}
	
	public function actionImg2($id)
	{
		$model = CustomerVisitImage::find()->where(['ID_DETAIL'=>$id])->one();
		return $this->renderAjax('image2', [
				'model' => $model,
			]);
	}
	
    /**
     * Creates a new Scheduledetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Scheduledetail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Scheduledetail model.
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
     * Deletes an existing Scheduledetail model.
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
     * Finds the Scheduledetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Scheduledetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Scheduledetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
