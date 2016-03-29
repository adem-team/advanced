<?php

namespace lukisongroup\sistem\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \DateTime;
use yii\helpers\Json;
use yii\web\Request;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use lukisongroup\hrd\models\AbsenDaily;
use lukisongroup\hrd\models\AbsenDailySearch;
use lukisongroup\hrd\models\Kar_finger;
use lukisongroup\hrd\models\ModulEvent;
use lukisongroup\hrd\models\ModulEventSearch;
use lukisongroup\hrd\models\ModulPersonalia;

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


	private function aryModulID(){
		$dataModul =  ArrayHelper::map(ModulPersonalia::find()->where('MODUL_PRN=0')->orderBy('MODUL_NM')->asArray()->all(), 'ID','MODUL_NM');
		return $dataModul;
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
     * Lists all Absensi models.
     * @return mixed
     */
    public function actionIndex()
    {
		//print_r($this->aryModulID());
		//die();
		if (!Yii::$app->user->isGuest){
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
			$dataProvider = $searchModel->searchDailyTglRangeUser(Yii::$app->request->queryParams);
			/*EVENT SEARCH*/
			$searchModelEvent = new ModulEventSearch();
			$dataProviderEvent = $searchModelEvent->searchPersonal(Yii::$app->request->queryParams);

      // print_r($searchModelEvent);
      // die();
			/*EVENT MODEL FORM*/
			$modelEvent = new ModulEvent();
			/*Model View Ijin,cuti,Absensi*/
			// $model =  ModulPersonalia::find()->where([ID=>'15'])->one();
      $searchModelpersonalia = new ModulEventSearch();
      $dataProviderpersonali = $searchModelpersonalia->searchPersonalia(Yii::$app->request->queryParams);

			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
        'searchModelpersonalia'=>$searchModelpersonalia,
        'dataProviderpersonali'=>$dataProviderpersonali,

				/*Daily Absensi*/
				'searchModel'=>$searchModel,
				'dataProviderField'=>$dataProviderField,
				'dataProvider'=>$dataProvider,
				/*EVENT SEARCH*/
				'searchModelEvent'=>$searchModelEvent,
				'dataProviderEvent'=>$dataProviderEvent,
				'modelEvent'=>$modelEvent,
				/*Modul*/
				'aryModulID'=>$this->aryModulID(),
				/*Model View*/
				'model'=>$model,
			]);
		}else{
			 Yii::$app->user->logout();
		}
    }

	 /**
	 * EVENT CALENDAR
     * [actionJsoncalendar description]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @param  [type] $_     [description]
     * @return [type]        [description]
	 * @author piter [ptr.nov@gmail.com]
	 * @since	1.2
     */
	/*SHOW JSON*/
    public function actionJsoncalendar($start=NULL,$end=NULL,$_=NULL){
    //public function actionJsoncalendar(){
        $events = array();
		$eventCalendar= ModulEvent::find()->all();
		//print_r($eventCalendar);
		//die();
        //Demo
        $Event = new \yii2fullcalendar\models\Event();
		//FIELD HARUS [id,start,end,title]
        header('Content-type: application/json');
        echo Json::encode($eventCalendar);
        Yii::$app->end();
    }
	/*INSERT AJAX*/
	public function actionJsoncalendar_add(){
		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$model =  new ModulEvent;
			$end=$request->post('end');
			$start=$request->post('start');
			$title=$request->post('title');
			$model->start = $start;
			$model->end = $end;
			$model->title = $title;
			$model->USER_ID =Yii::$app->user->identity->EMP_ID;
			// $model->CREATE_AT = date('Y-m-d H:i:s');
			$model->UPDATE_BY = Yii::$app->user->identity->username;
			$model->save();
			return true;
		}

	}

	/**
     * DepDrop CHILD MODUL
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	public function actionModulChild() {
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$modul_prn = $parents[0];
				$model = ModulPersonalia::find()->asArray()->where(['MODUL_PRN'=>$modul_prn])->all();
				foreach ($model as $key => $value) {
					   $out[] = ['id'=>$value['ID'],'name'=> $value['MODUL_NM']];
				   }

				   echo json_encode(['output'=>$out, 'selected'=>'']);
				   return;
			   }
		   }
		   echo Json::encode(['output'=>'', 'selected'=>'']);
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

    public function actionSaveEvent()
    {
      if (Yii::$app->request->isAjax) {
  			$request= Yii::$app->request;
        $profile= Yii::$app->getUserOpt->Profile_user();
        $tgl2 = $request->post('title');
        $modulid =  $request->post('modulid');
        $tgl1 = $request->post('tgl1');
        $mdl_parent = $request->post('parent');
        // echo $title;

  			$model = new ModulEvent();
        $model->MODUL_ID = $modulid;
        $model->MODUL_PRN = $mdl_parent;
        $model->start = $tgl1;
        $model->end = $tgl2;
        $model->CREATE_BY = $profile->emp->EMP_ID ;
        $model->CREATE_AT = date('Y-m-d H:i:s') ;
        $model->USER_ID = $profile->emp->EMP_ID;
        // $model->

  			$model->save();
  			return true;
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
