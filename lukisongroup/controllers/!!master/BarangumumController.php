<?php
namespace lukisongroup\controllers\master;

use Yii;
use lukisongroup\models\master\Barangumum;
use lukisongroup\models\master\BarangumumSearch;
use lukisongroup\models\master\Barangumumupload;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

//use app\models\UploadForm;
	use yii\web\UploadedFile;
/**
 * BarangumumController implements the CRUD actions for Barangumum model.
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
     * Lists all Barangumum models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BarangumumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Barangumum model.
     * @param string $id
     * @param string $kd_barang
     * @return mixed
     */
    public function actionView($ID, $KD_BARANG)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID, $KD_BARANG),
        ]);
    }

    /**
     * Creates a new Barangumum model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Barangumum();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'KD_BARANG' => $model->KD_BARANG]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSimpan()
    {
        $model = new Barangumum();
	//	$bupload = new Barangumumupload();
		
		$model->load(Yii::$app->request->post());
		
		$kdBrg = $model->KD_BARANG;	
		$kdCorp = $model->KD_CORP;	
		$kdType = $model->KD_TYPE;	
		$kdKategori = $model->KD_KATEGORI;	
		$kdUnit = $model->KD_UNIT;	
		
		$ck = Barangumum::find()->select('KD_BARANG')->where(['KD_CORP' => $kdCorp])->andWhere('STATUS <> 3')->orderBy(['ID'=>SORT_DESC])->one();
		if(count($ck) == 0){ $nkd = 1; } else { $kd = explode('.',$ck->KD_BARANG); $nkd = $kd[5]+1; }
		
		$kd = "BRG.".$kdCorp.".".$kdType.".".$kdKategori.".".$kdUnit.".".str_pad( $nkd, "4", "0", STR_PAD_LEFT );

		
		$model->KD_BARANG = $kd;
		
		$image = $model->uploadImage();
		if ($model->save()) {
			// upload only if valid uploaded file instance found
			if ($image !== false) {
				$path = $model->getImageFile();
				$image->saveAs($path);
			}
		}
	
		
		return $this->redirect(['view', 'ID' => $model->ID, 'KD_BARANG' => $model->KD_BARANG]);
//		echo  $hsl['barangumum']['KD_BARANG'];
    }

    /**
     * Updates an existing Barangumum model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @param string $kd_barang
     * @return mixed
     */
    public function actionUpdate($ID, $KD_BARANG)
    {
        $model = $this->findModel($ID, $KD_BARANG);

        if ($model->load(Yii::$app->request->post())){
			
			$image = $model->uploadImage();
			if ($model->save()) {
				// upload only if valid uploaded file instance found
				if ($image !== false) {
					$path = $model->getImageFile();
					$image->saveAs($path);
				}
			}
            return $this->redirect(['view', 'ID' => $model->ID, 'KD_BARANG' => $model->KD_BARANG]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Barangumum model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @param string $kd_barang
     * @return mixed
     */
    public function actionDelete($ID, $KD_BARANG)
    {
		$model = Barangumum::find()->where(['ID'=>$ID, 'KD_BARANG'=>$KD_BARANG])->one();
		$model->STATUS = 3;
		$model->UPDATED_BY = Yii::$app->user->identity->username;
		$model->save();
//   $this->findModel($ID, $KD_BARANG)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Barangumum model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @param string $kd_barang
     * @return Barangumum the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID, $KD_BARANG)
    {
        if (($model = Barangumum::findOne(['ID' => $ID, 'KD_BARANG' => $KD_BARANG])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
