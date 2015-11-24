<?php

namespace lukisongroup\widget\controllers;

use Yii;
use lukisongroup\widget\models\Berita;
use lukisongroup\widget\models\BeritaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BeritaController implements the CRUD actions for Berita model.
 */
class BeritaController extends Controller
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
     * Lists all Berita models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BeritaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Berita model.
     * @param integer $ID
     * @param string $KD_BERITA
     * @return mixed
     */
    public function actionView($ID, $KD_BERITA)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID, $KD_BERITA),
        ]);
    }

    /**
     * Creates a new Berita model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Berita();

        if ($model->load(Yii::$app->request->post())  ) {
            
			
			$query = Berita::find()->select('KD_BERITA')->orderBy(['KD_BERITA'=> SORT_DESC])->limit(1)->all();
		if(count($query) == 0)
		{
			$lastKd = 0;
		}
		else { 
			$lastKd = $query[0]['KD_BERITA'];
			}
		
		$nKD = $lastKd +1;
		$pnjg = strlen($nKD);
		if($pnjg == 1){
						$kd = "000".$nKD;
			}
		else if($pnjg == 2)
		{		 $kd = "00".$nKD;
	
			}
		else if($pnjg == 3)
		{
			$kd = "0".$nKD;
			}
		else if($pnjg >= 4 )
		{ $kd = $nKD;
		}
		
		
		$kode = 'B.'. date('Y.m.d').'.'.$kd;
		$model->KD_BERITA = $kode;
		$model->KD_CORP =  Yii::$app->user->identity->EMP_CORP_ID;
		$model->KD_CAB = 
		$model->KD_DEP = Yii::$app->user->identity->DEP_ID
		
		
		
		;
			// $db = \Yii::$app->db_sss;
			// $sql ="select count(KD_BERITA) from a1000";
			// $baris = $db->createCommand($sql)->queryScalar();
			
			// if($baris == 0)
			// {
				// $model->KD_BERITA = "B201511000001";
			// }
			// else{
						// $sql = $db->createCommand("SELECT CONCAT('B',DATE_FORMAT(NOW(),'%Y%m'),LPAD((RIGHT(max(KD_BERITA),4)+1),6,'0')) from a1000");
						// $beritacode = $sql->queryScalar();
			
						// $model->KD_BERITA = $beritacode ; 
			// }
			
			$model->CREATED_BY = Yii::$app->user->identity->username;
			


			$model->save();
			
		

			
			
					
			
			
			
			
			
			return $this->redirect(['view', 'ID' => $model->ID, 'KD_BERITA' => $model->KD_BERITA]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Berita model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $ID
     * @param string $KD_BERITA
     * @return mixed
     */
    public function actionUpdate($ID, $KD_BERITA)
    {
        $model = $this->findModel($ID, $KD_BERITA);

        if ($model->load(Yii::$app->request->post()) ) {
			
			$model->UPDATE_AT = date('Y-m-d h:i:s'); 	
			
			 $model->save();
            return $this->redirect(['view', 'ID' => $model->ID, 'KD_BERITA' => $model->KD_BERITA]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Berita model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $ID
     * @param string $KD_BERITA
     * @return mixed
     */
    public function actionDelete($ID, $KD_BERITA)
    {
        $this->findModel($ID, $KD_BERITA)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Berita model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID
     * @param string $KD_BERITA
     * @return Berita the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID, $KD_BERITA)
    {
        if (($model = Berita::findOne(['ID' => $ID, 'KD_BERITA' => $KD_BERITA])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
