<?php

namespace lukisongroup\hrd\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \DateTime;
use lukisongroup\hrd\models\AbsenDaily;
use lukisongroup\hrd\models\AbsenDailySearch;
use lukisongroup\hrd\models\Kar_finger;


class AbsenOtController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['post'],
					'save' => ['post'],
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
	
    public function actionIndex()
    {
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
			/*Daily Absensi*/
			'searchModel'=>$searchModel,
			'dataProviderField'=>$dataProviderField,
			'dataProvider'=>$dataProvider			
        ]);
    }

	/*
	 * Set Finger to EmpID | Employe 
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	public function actionFingerEmp($m,$f)
    {
		
		$modelView = Personallog::find()->where(['TerminalID'=>$m,'FingerPrintID'=>$f])->one();
        $model = new Kar_finger();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           return $this->redirect(['index']);
        } else {
            return $this->renderAjax('_form_karfinger', [
                'model' => $model,
				'modelView'=>$modelView
            ]);
       }
    }
	
	public function actionFingerEmpSave()
    {
		if (!Yii::$app->user->isGuest){
			$model = new Kar_finger();

			if($model->load(Yii::$app->request->post())){                  
						//$model->CREATED_BY = Yii::$app->user->identity->username;
						//$model->CREATED_AT = date('Y-m-d H:i:s');
						$model->save();    
				return $this->redirect(['index']);
						
			}else{
				return ActiveForm::validate($model);
			}	
		}
    }
	
	
	
	
	
	
	
	/**
     * Displays a single Sot2 model.
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
     * Creates a new Sot2 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sot2();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Sot2 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing Sot2 model.
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
     * Finds the Sot2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Sot2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sot2::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
