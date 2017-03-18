<?php

namespace lukisongroup\efenbi\rasasayang\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use ptrnov\postman4excel\Postman4ExcelBehavior;

use lukisongroup\efenbi\rasasayang\models\Locate;
use lukisongroup\efenbi\rasasayang\models\Store;
use lukisongroup\efenbi\rasasayang\models\StoreSearch;

		
/**
 * StoreController implements the CRUD actions for Store model.
 */
class StoreController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
			/*EXCEl IMPORT*/
			'export4excel' => [
				'class' => Postman4ExcelBehavior::className(),
				//'downloadPath'=>Yii::getAlias('@lukisongroup').'/cronjob/',
				//'downloadPath'=>'/var/www/backup/ExternalData/',
				'widgetType'=>'download',
			], 
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
	/*
	* Declaration Component User Permission
	* Function getPermission
	* Modul Name[11=Calendar Promo]
	* Permission LINK URL.
	*/
	public function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses('11')){
			return Yii::$app->getUserOpt->Modul_akses('11');
		}else{
			return false;
		}
	}  
	/**
     * Before Action Index
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function beforeAction($action){
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
			   //Modul permission URL, author -ptr.nov@gail.com-
			   //if(self::getPermission()->BTN_CREATE OR self::getPermission()->BTN_VIEW){
					return true;
			   // }else{
				   // $this->redirect(array('/site/validasi'));
			   // }
		   }
		} else {
			return true;
		}
    }
    /**
     * Lists all Store models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StoreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	/*
	 * EXPORT EXCEL - SALES PROMO.
	 * export_data
	 * STATUS: 0=RUNNING/Current; 1=FINISH; 2=PANDING; 3=PLANING.
	*/
	public function actionExport(){	
		$tglIn=date("Y-m-d");
			
		//Search STATUS
		$searchModel = new StoreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);				
		//Models
		$model=$dataProvider->getModels();
		//Models
		$aryStore=ArrayHelper::toArray($model);			
		
		// print_r($aryStore);
		// die();
		//Excute - Export Excel.		
		$excel_content = [
			[
				'sheet_name' => 'RasaSayang-Store',					
				'sheet_title' => [
					['OUTLET_BARCODE','OUTLET_NM','LOCATE','LOCATE_SUB','ALAMAT','PIC','TLP','STATUS','CREATE_BY','CREATE_AT','UPDATE_BY,UPDATE_AT']
				],
				'ceils' =>$aryStore,
				'freezePane' => 'A2',
				'headerColor' => Postman4ExcelBehavior::getCssClass("header"),
				'columnGroup'=>[''],
				'autoSize'=>false,
				'headerStyle'=>[					
					[
						'OUTLET_BARCODE' => ['font-size'=>'8','align'=>'center','width'=>'28.14','valign'=>'center','wrap'=>true],
						'OUTLET_NM' => ['font-size'=>'8','align'=>'center','width'=>'8.14','valign'=>'center'],							
						'LOCATE' =>['font-size'=>'8','align'=>'center','width'=>'11','valign'=>'center'],
						'LOCATE_SUB' =>['font-size'=>'8','align'=>'center','width'=>'11','valign'=>'center'],
						'ALAMAT' =>['font-size'=>'8','align'=>'center','width'=>'11','valign'=>'center'],
						'PIC' => ['font-size'=>'8','align'=>'center','width'=>'7','valign'=>'center'],
						'TLP' =>['font-size'=>'8','align'=>'center','width'=>'29.29','wrap'=>true,'valign'=>'center',], 
						'STATUS' =>['font-size'=>'8','align'=>'center','width'=>'34.14','wrap'=>true,'valign'=>'center',],
						'CREATE_BY' => ['font-size'=>'8','align'=>'center','width'=>'34.14','wrap'=>true,'valign'=>'center',],
						'CREATE_AT' => ['font-size'=>'8','align'=>'center','width'=>'34.14','wrap'=>true,'valign'=>'center',],					
						'UPDATE_BY' => ['font-size'=>'8','align'=>'center','width'=>'14.86','valign'=>'center'],						
						'UPDATE_AT' => ['font-size'=>'8','align'=>'center','width'=>'15','valign'=>'center']
					]
					
				],
				'contentStyle'=>[
					[						
						'OUTLET_BARCODE' => ['font-size'=>'8','align'=>'left',],
						'OUTLET_NM' => ['font-size'=>'8','align'=>'left'],							 
						'LOCATE' =>['font-size'=>'8','align'=>'center'],
						'LOCATE_SUB' =>['font-size'=>'8','align'=>'center'],
						'ALAMAT' =>['font-size'=>'8','align'=>'center'],
						'PIC' => ['font-size'=>'8','align'=>'center'],
						'TLP' =>['font-size'=>'8','align'=>'left'],
						'STATUS' =>['font-size'=>'8','align'=>'left'],
						'KOMPENSASI' => ['font-size'=>'8','align'=>'left'],
						'CREATE_BY' => ['font-size'=>'8','align'=>'left'],
						'CREATED_BY' => ['font-size'=>'8','align'=>'left'],						
						'UPDATE_BY' => ['font-size'=>'8','align'=>'center'],						
						'UPDATE_AT' => ['align'=>'left']									
					]
				],            
				'oddCssClass' => Postman4ExcelBehavior::getCssClass("odd"),
				'evenCssClass' => Postman4ExcelBehavior::getCssClass("even"),
			],			
		];
		$excel_file = "RasaSayang-Store"."-".$tglIn;
		$this->export4excel($excel_content, $excel_file,0);  
	}
	
    /**
     * Displays a single Store model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->ID]);
            return $this->redirect(['index']);
        } else {
           return $this->renderAjax('view', [
                'model' => $model,
            ]);
        }
    }

	  /**
     * Displays a single Store model.
     * @param integer $id
     * @return mixed
     */
    public function actionReview($id)
    {	//View aja.
        // return $this->renderAjax('view', [
            // 'model' => $this->findModel($id),
        // ]);
		$model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->ID]);
            return $this->redirect(['index']);
        } else {
           return $this->renderAjax('review', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new Store model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		//Generate Code
		$maxID=Store::find()->max('ID');
		$newID=str_pad($maxID+1,4,"0",STR_PAD_LEFT);
		
        $model = new Store();
		
		$model->OUTLET_BARCODE = $newID;
		$model->CREATE_BY =  Yii::$app->user->identity->username;
		$model->CREATE_AT = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }
	
	/**
     * Depdrop Sub Locate
     * @author Piter
     * @since 1.1.0
     * @return mixed
     */
   public function actionLocateSub() {
    $out = [];
		if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$id = $parents[0];
				$model = Locate::find()->asArray()->where(['PARENT'=>$id])->all();														
														
				foreach ($model as $key => $value) {
				   $out[] = ['id'=>$value['ID'],'name'=> $value['LOCATE_NAME']];
			    } 
				echo json_encode(['output'=>$out, 'selected'=>'']);
				return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
   }
   

    /**
     * Updates an existing Store model.
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
     * Deletes an existing Store model.
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
     * Finds the Store model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Store the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Store::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
