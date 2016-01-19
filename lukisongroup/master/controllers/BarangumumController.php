<?php

namespace lukisongroup\master\controllers;

use Yii;
use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\master\models\Barang;
use lukisongroup\master\models\BarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

	use yii\web\UploadedFile;
/**
 * BarangController implements the CRUD actions for Barang model.
 */
class BarangumumController extends Controller
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
     * Before Action Index
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
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

    /**
     * Lists all Barang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BarangSearch();
        $dataProvider = $searchModel->searchBarangUmum(Yii::$app->request->queryParams);
	
	
        $model = new Barang();
		$querys = Barang::find()->from('dbc002.b0001 AS db1')->leftJoin('dbc002.b1001 AS db2', 'db1.KD_BARANG = db2.KD_TYPE')->where(['NM_TYPE' => 'FDSFDG'])->all();
		
		
/*	
	var_dump($querys);
		
		
		$query= new Query;
		$query->select('*')
				->from('dbc002.b0001 AS db1')
				->leftJoin('dbm000.b1001 AS db2', 'db1.KD_BARANG = db2.KD_TYPE')  
				->where(['db2.NM_TYPE' =>'FDSFDG']);
		$command = $query->createCommand();
		$resp = $command->queryAll();
	*/
	/*
	select * 
from dbc002.b0001 AS db1 
LEFT JOIN dbm000.b1001 AS db2
on db1.KD_BARANG = db2.KD_TYPE
WHERE db2.NM_TYPE = 'FDSFDG'
	
		$querys = Barang::find()->with('tbesm')->where(['tbesm.NM_TYPE' => 'FDSFDG'])->asArray()->all();
		*/
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
             'querys' => $querys,
        ]);
    }

    /**
     * Displays a single Barang model.
     * @param string $ID
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Barang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Barang();

        if ($model->load(Yii::$app->request->post()) ) {
				//$kdDbtr = $model->KD_DISTRIBUTOR;	
				$kdType = $model->KD_TYPE;	
				$kdKategori = $model->KD_KATEGORI;	
				$kdUnit = $model->KD_UNIT;	
				$kdPrn = $model->PARENT;
				$kd = Yii::$app->esmcode->kdbarangUmum($kdPrn,$kdType,$kdKategori,$kdUnit);

				$model->KD_BARANG = $kd;
		if($model->validate())
		{
		
				$model->CREATED_BY = Yii::$app->user->identity->username;
		
				$image = $model->uploadImage();
		if ($model->save()) {
			// upload only if valid uploaded file instance found
			if ($image !== false) {
				$path = $model->getImageFile();
				$image->saveAs($path);
			}
		}
	}
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSimpan()
    {
        $model = new Barang();
		$model->load(Yii::$app->request->post());
		
		//$kdDbtr = $model->KD_DISTRIBUTOR;	
		$kdType = $model->KD_TYPE;	
		$kdKategori = $model->KD_KATEGORI;	
		$kdUnit = $model->KD_UNIT;	
		$kdPrn = $model->PARENT;
		$kd = Yii::$app->esmcode->kdbarangUmum($kdPrn,$kdType,$kdKategori,$kdUnit);

		$model->KD_BARANG = $kd;
		if($model->validate())
		{
		
		$model->CREATED_BY = Yii::$app->user->identity->username;
		
		$image = $model->uploadImage();
		if ($model->save()) {
			// upload only if valid uploaded file instance found
			if ($image !== false) {
				$path = $model->getImageFile();
				$image->saveAs($path);
			}
		}
		}
		return $this->redirect(['index']);
    }

    /**
     * Updates an existing Barang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $ID
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			$image = $model->uploadImage();
			if ($model->save()) {
				// upload only if valid uploaded file instance found
				if ($image !== false) {
					$path = $model->getImageFile();
					$image->saveAs($path);
				}
			}
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Barang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $ID
     * @return mixed
     */
    public function actionDelete($id)
    {
     //   $this->findModel($ID)->delete();
	 
		$model = Barang::find()->where(['ID'=>$id])->one();
		$model->STATUS = 3;
		$model->UPDATED_BY = Yii::$app->user->identity->username;
		$model->save();
		
        return $this->redirect(['index']);
    }

    /**
     * Finds the Barang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $ID
     * @return Barang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID)
    {
        if (($model = Barang::findOne($ID)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
