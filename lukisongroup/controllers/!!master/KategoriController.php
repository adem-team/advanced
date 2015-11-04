<?php

namespace lukisongroup\controllers\master;

use Yii;
use lukisongroup\models\master\Kategori;
use lukisongroup\models\master\KategoriSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KategoriController implements the CRUD actions for Kategori model.
 */
class KategoriController extends Controller
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
     * Lists all Kategori models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KategoriSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kategori model.
     * @param string $id
     * @param string $kd_kategori
     * @return mixed
     */
    public function actionView($ID, $KD_KATEGORI)
    {
		$ck = Kategori::find()->where(['ID'=>$ID, 'KD_KATEGORI'=>$KD_KATEGORI])->one();
		if(count($ck) == 0){
			return $this->redirect(['index']);
		}
		if($ck->STATUS != 3){
			return $this->render('view', [
				'model' => $this->findModel($ID, $KD_KATEGORI),
			]);
		} else {
			return $this->redirect(['index']);
		}
    }

    /**
     * Creates a new Kategori model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Kategori();
/*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'KD_KATEGORI' => $model->KD_KATEGORI]);
        } else {
			*/
            return $this->render('create', [
                'model' => $model,
            ]);
  //      }
    }

    public function actionSimpan()
    {
        $model = new Kategori();

		$model->load(Yii::$app->request->post());
		$ck = Kategori::find()->where('STATUS <> 3')->max('KD_KATEGORI');
		$nw = $ck+1;
		$nw = str_pad( $nw, "2", "0", STR_PAD_LEFT );
		$model->KD_KATEGORI = $nw;
		$model->save();
		return $this->redirect(['view', 'ID' => $model->ID, 'KD_KATEGORI' => $model->KD_KATEGORI]);
    }

    /**
     * Updates an existing Kategori model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @param string $kd_kategori
     * @return mixed
     */
    public function actionUpdate($ID, $KD_KATEGORI)
    {
      //  $model = $this->findModel($ID, $KD_KATEGORI);

		$model = Kategori::find()->where(['ID'=>$ID, 'KD_KATEGORI'=>$KD_KATEGORI])->one();
		if(count($model) == 0){
			return $this->redirect(['index']);
		}
		if($model->STATUS == 3){
			return $this->redirect(['index']);
		}
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'KD_KATEGORI' => $model->KD_KATEGORI]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Kategori model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @param string $kd_kategori
     * @return mixed
     */
    public function actionDelete($ID, $KD_KATEGORI)
    {
		$model = Kategori::find()->where(['ID'=>$ID, 'KD_KATEGORI'=>$KD_KATEGORI])->one();
		$model->STATUS = 3;
		$model->UPDATED_BY = Yii::$app->user->identity->username;
		$model->save();  // equivalent to $model->update();
		
        //$this->findModel($ID, $KD_KATEGORI)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Kategori model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @param string $kd_kategori
     * @return Kategori the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID, $KD_KATEGORI)
    {
        if (($model = Kategori::findOne(['ID' => $ID, 'KD_KATEGORI' => $KD_KATEGORI])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
