<?php

namespace lukisongroup\sistem\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \DateTime;

use lukisongroup\hrd\models\AbsenDaily;
use lukisongroup\hrd\models\AbsenDailySearch;
use lukisongroup\hrd\models\Kar_finger;
use lukisongroup\sistem\models\Absensi;
use lukisongroup\sistem\models\AbsensiSearch;
/**
 * PersonaliaController implements the CRUD actions for Absensi model.
 */
class PersonaliaController extends Controller
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
     * Lists all Absensi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AbsensiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$date=new DateTime();
		$thn=strlen($date->format('Y'));
		$bln=strlen($date->format('m'));
		$hri=strlen($date->format('d'));
		$dateRlt=$thn."-".$bln."-".$hri;
		$searchModel = new AbsenDailySearch([
			//'tgllog'=>Yii::$app->ambilKonvesi->tglSekarang()
		]);
				
		/*REKAP ABSENSI*/
		//Field Label
		$dataProviderField = $searchModel->dailyFieldTglRange();
		//Value row
		$dataProvider = $searchModel->searchDailyTglRange(Yii::$app->request->queryParams);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			/*Daily Absensi*/
			'searchModel'=>$searchModel,
			'dataProviderField'=>$dataProviderField,
			'dataProvider'=>$dataProvider	
        ]);
    }

    /**
     * Displays a single Absensi model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Absensi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Absensi();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idno]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Absensi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idno]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Absensi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Absensi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Absensi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Absensi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	/**=====================================
     * VIEW IMPORT DATA STORAGE
     * @return mixed
	 * @author piter [ptr.nov@gmail.com]
	 * =====================================
     */
	 /*GRID HEADER COLUMN*/
	 private function gvHeadColomnEvent(){		
		$aryField= [	
			/*MAIN DATA*/
			['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'Date','align'=>'left','warna'=>'97, 211, 96, 0.3']],				
			['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_KD_ALIAS','SIZE' => '10px','label'=>'CUST.KD','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>2, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '10px','label'=>'CUSTOMER','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>3, 'ATTR' =>['FIELD'=>'NM_BARANG','SIZE' => '10px','label'=>'SKU','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>4, 'ATTR' =>['FIELD'=>'SO_QTY','SIZE' => '10px','label'=>'QTY.PCS','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>5, 'ATTR' =>['FIELD'=>'NM_DIS','SIZE' => '10px','label'=>'DISTRIBUTION','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>6, 'ATTR' =>['FIELD'=>'SO_TYPE','SIZE' => '10px','label'=>'TYPE','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>7, 'ATTR' =>['FIELD'=>'USER_ID','SIZE' => '10px','label'=>'IMPORT.BY','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			/*REFRENSI DATA*/
			['ID' =>8, 'ATTR' =>['FIELD'=>'UNIT_BARANG','SIZE' => '10px','label'=>'UNIT','align'=>'left','warna'=>'255, 255, 48, 4']],
			['ID' =>9, 'ATTR' =>['FIELD'=>'UNIT_QTY','SIZE' => '10px','label'=>'UNIT.QTY','align'=>'left','warna'=>'255, 255, 48, 4']],
			['ID' =>10, 'ATTR' =>['FIELD'=>'UNIT_BERAT','SIZE' => '10px','label'=>'WEIGHT','align'=>'left','warna'=>'255, 255, 48, 4']],
			['ID' =>11, 'ATTR' =>['FIELD'=>'HARGA_PABRIK','SIZE' => '10px','label'=>'FACTORY.PRICE','align'=>'right','warna'=>'255, 255, 48, 4']],
			['ID' =>12, 'ATTR' =>['FIELD'=>'HARGA_DIS','SIZE' => '10px','label'=>'DIST.PRICE','align'=>'right','warna'=>'255, 255, 48, 4']],
			['ID' =>13, 'ATTR' =>['FIELD'=>'HARGA_SALES','SIZE' => '10px','label'=>'SALES.PRICE','align'=>'right','warna'=>'255, 255, 48, 4']],
			/*SUPPORT DATA ID*/
			['ID' =>14, 'ATTR' =>['FIELD'=>'CUST_KD','SIZE' => '10px','label'=>'CUST.KD_ALIAS','align'=>'left','warna'=>'255, 255, 48, 4']],
			['ID' =>15, 'ATTR' =>['FIELD'=>'KD_BARANG','SIZE' => '10px','label'=>'SKU.ID.ALIAS','align'=>'left','warna'=>'255, 255, 48, 4']],			
			['ID' =>16, 'ATTR' =>['FIELD'=>'KD_DIS','SIZE' => '10px','label'=>'KD_DIS','align'=>'left','warna'=>'215, 255, 48, 1']],	
		];	
		$valFields = ArrayHelper::map($aryField, 'ID', 'ATTR'); 
			
		return $valFields;
	}	
	public function gvRowsEvent() {
		$actionClass='btn btn-info btn-xs';
		$actionLabel='Update';
		$attDinamik =[];
		foreach($this->gvHeadColomnEvent() as $key =>$value[]){
			$attDinamik[]=[		
				'attribute'=>$value[$key]['FIELD'],
				'label'=>$value[$key]['label'],
				'filter'=>true,
				'hAlign'=>'right',
				'vAlign'=>'middle',
				//'mergeHeader'=>true,
				'noWrap'=>true,			
				'headerOptions'=>[		
						'style'=>[									
						'text-align'=>'center',
						'width'=>$value[$key]['FIELD'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(97, 211, 96, 0.3)',
						'background-color'=>'rgba('.$value[$key]['warna'].')',
					]
				],  
				'contentOptions'=>[
					'style'=>[
						'text-align'=>$value[$key]['align'],
						//'width'=>'12px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(13, 127, 3, 0.1)',
					]
				],					
			];	
		}
		return $attDinamik;
	}
	
	
	
	
}
