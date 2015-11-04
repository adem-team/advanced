<?php
namespace lukisongroup\controllers\master;

use Yii;
use lukisongroup\models\master\Suplier;
use lukisongroup\models\master\SuplierSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SuplierController implements the CRUD actions for Suplier model.
 */
class SuplierController extends Controller
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
     * Lists all Suplier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SuplierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Suplier model.
     * @param string $id
     * @param string $kd_supplier
     * @return mixed
     */
    public function actionView($ID, $KD_SUPPLIER)
    {
		$ck = Suplier::find()->where(['ID'=>$ID, 'KD_SUPPLIER'=>$KD_SUPPLIER])->one();
		if(count($ck) == 0){
			return $this->redirect(['index']);
		}
		if($ck->STATUS != 3){
			return $this->render('view', [
				'model' => $this->findModel($ID, $KD_SUPPLIER),
			]);
		} else {
			return $this->redirect(['index']);
		}
    }

    public function actionSimpan()
    {
        $model = new Suplier();
		$model->load(Yii::$app->request->post());
		$crp = $model->KD_CORP;
		
		$ck = Suplier::find()->where('STATUS <> 3')->where(['KD_CORP'=>$crp])->max('KD_SUPPLIER');
		if(count($ck) != 0){
			$nw = explode('.',$ck);
			$nm = $nw[2]+1;
		}else{
			$nm =1;
		}
		
		$nn = str_pad($nm, "5", "0", STR_PAD_LEFT );
		
		$kd = 'SPL.'.$crp."." .$nn;
		$model->KD_SUPPLIER = $kd;
		$model->save();
		return $this->redirect(['view', 'ID' => $model->ID, 'KD_SUPPLIER' => $model->KD_SUPPLIER]);
    }
    /**
     * Creates a new Suplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Suplier();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'KD_SUPPLIER' => $model->KD_SUPPLIER]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Suplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @param string $kd_supplier
     * @return mixed
     */
    public function actionUpdate($ID, $KD_SUPPLIER)
    {
        $model = $this->findModel($ID, $KD_SUPPLIER);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'KD_SUPPLIER' => $model->KD_SUPPLIER]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Suplier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @param string $kd_supplier
     * @return mixed
     */
    public function actionDelete($ID, $KD_SUPPLIER)
    {
		
		$model = Suplier::find()->where(['ID'=>$ID, 'KD_SUPPLIER'=>$KD_SUPPLIER])->one();
		$model->STATUS = 3;
		$model->UPDATED_BY = Yii::$app->user->identity->username;
		$model->save();  // equivalent to $model->update();
		
//        $this->findModel($ID, $KD_SUPPLIER)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Suplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @param string $kd_supplier
     * @return Suplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID, $KD_SUPPLIER)
    {
        if (($model = Suplier::findOne(['ID' => $ID, 'KD_SUPPLIER' => $KD_SUPPLIER])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
