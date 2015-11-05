<?php

namespace lukisongroup\controllers\master;

use Yii;
use lukisongroup\models\master\Tipebarang;
use lukisongroup\models\master\TipebarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipebarangController implements the CRUD actions for Tipebarang model.
 */
class TipebarangController extends Controller
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

    /**
     * Lists all Tipebarang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TipebarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tipebarang model.
     * @param string $id
     * @param string $kd_type
     * @return mixed
     */
    public function actionView($ID, $KD_TYPE)
    {
		
		$ck = Tipebarang::find()->where(['ID'=>$ID, 'KD_TYPE'=>$KD_TYPE])->one();
		if(count($ck) == 0){
			return $this->redirect(['index']);
		}
		if($ck->STATUS != 3){
			return $this->render('view', [
				'model' => $ck,
			]);
		} else {
			return $this->redirect(['index']);
		}
    }

    /**
     * Creates a new Tipebarang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tipebarang();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'KD_TYPE' => $model->KD_TYPE]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSimpan()
    {
        $model = new Tipebarang();

		$model->load(Yii::$app->request->post());
		$ck = Tipebarang::find()->where('STATUS <> 3')->max('KD_TYPE');
		$nw = $ck+1;
		$nw = str_pad( $nw, "2", "0", STR_PAD_LEFT );
		$model->KD_TYPE = $nw;
		$model->save();
		return $this->redirect(['view', 'ID' => $model->ID, 'KD_TYPE' => $model->KD_TYPE]);
    }
    /**
     * Updates an existing Tipebarang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @param string $kd_type
     * @return mixed
     */
    public function actionUpdate($ID, $KD_TYPE)
    {
//        $model = $this->findModel($ID, $KD_TYPE);

		$model = Tipebarang::find()->where(['ID'=>$ID, 'KD_TYPE'=>$KD_TYPE])->one();
		if(count($model) == 0){
			return $this->redirect(['index']);
		}
		if($model->STATUS == 3){
			return $this->redirect(['index']);
		}
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'KD_TYPE' => $model->KD_TYPE]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tipebarang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @param string $kd_type
     * @return mixed
     */
    public function actionDelete($ID, $KD_TYPE)
    {
		
		$model = Tipebarang::find()->where(['ID'=>$ID, 'KD_TYPE'=>$KD_TYPE])->one();
		$model->STATUS = 3;
		$model->UPDATED_BY = Yii::$app->user->identity->username;
		$model->save();  // equivalent to $model->update();
		
//        $this->findModel($ID, $KD_TYPE)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tipebarang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @param string $kd_type
     * @return Tipebarang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID, $KD_TYPE)
    {
        if (($model = Tipebarang::findOne(['ID' => $ID, 'KD_TYPE' => $KD_TYPE])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
