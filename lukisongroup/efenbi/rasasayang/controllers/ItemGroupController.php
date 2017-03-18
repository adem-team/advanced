<?php

namespace lukisongroup\efenbi\rasasayang\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use lukisongroup\efenbi\rasasayang\models\Item;
use lukisongroup\efenbi\rasasayang\models\ItemGroup;
use lukisongroup\efenbi\rasasayang\models\ItemGroupSearch;
use lukisongroup\efenbi\rasasayang\models\Store;
use lukisongroup\efenbi\rasasayang\models\StoreSearch;


/**
 * ItemGroupController implements the CRUD actions for ItemGroup model.
 */
class ItemGroupController extends Controller
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
			  // if(self::getPermission()->BTN_CREATE OR self::getPermission()->BTN_VIEW){
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
     * Lists all ItemGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
		$storeSearchModel = new StoreSearch();
		$storeDataProvider = $storeSearchModel->search(Yii::$app->request->queryParams);
        
			
		// $paramCari[]=Yii::$app->getRequest()->getQueryParam('locate');
		// $paramCari[]=Yii::$app->getRequest()->getQueryParam('locatesub');
		$paramCari = Yii::$app->request->queryParams;
		// print_r($paramCari);
		// die();
		if($paramCari){
			$outletData = Store::find()->select(['OUTLET_BARCODE'])->where(['LOCATE'=>$paramCari['locate'],'LOCATE_SUB'=>$paramCari['locatesub']])->asArray()->all();
			// print_r($outletData[0]['OUTLET_BARCODE']);
			// die();
			$itemGroupData = ItemGroup::find()->select(['ITEM_ID'])->where(['LOCATE'=>$paramCari['locate'],'LOCATE_SUB'=>$paramCari['locatesub']])->asArray()->all();
			$iteData = Item::find()->where(['not in','ITEM_ID',$itemGroupData])->all();
			if(count($iteData)){
				foreach ($iteData as $key => $value) {
					//$strITEM_ID=(string)$value['ITEM_ID'];
					// $strITEM_ID[]= $value['ITEM_ID'] ;
					$connection = Yii::$app->db_efenbi;
					// Bung data jika 000
					//$connection->createCommand()->batchInsert('Item_group',['LOCATE','LOCATE_SUB','ITEM_ID'],[['LOCATE'=>$paramCari['locate'],'LOCATE_SUB'=>$paramCari['locatesub'],(string)$strITEM_ID]])->execute();
					$connection->createCommand()->batchInsert('Item_group',[
						'LOCATE',
						'LOCATE_SUB',
						'ITEM_ID',
						'ITEM_BARCODE',
						'OUTLET_ID',
						'CREATE_BY',
						'CREATE_AT'						
					],
					[
						[
							$paramCari['locate'],
							$paramCari['locatesub'],
							$value['ITEM_ID'],
						    $outletData[0]['OUTLET_BARCODE'].".".$value['ITEM_ID'],
							$outletData[0]['OUTLET_BARCODE'],	
							Yii::$app->user->identity->username,
							date("Y-m-d H:i:s"),						
						]
					])->execute();
				};
			}				
			// print_r($strITEM_ID);
			// die();
			$searchModel = new ItemGroupSearch(['LOCATE'=>$paramCari['locate'],'LOCATE_SUB'=>$paramCari['locatesub']]);
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);	
			// print_r(count($iteData));
			// die();
		}else{
			$searchModel = new ItemGroupSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);	
		}
		

        return $this->render('index', [
            'storeSearchModel' => $storeSearchModel,
            'storeDataProvider' => $storeDataProvider,
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ItemGroup model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
	/**
     * Displays a single ItemGroup model.
     * @param integer $id
     * @return mixed
     */
    public function actionReview($id)
    {
		
		$model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$modelCari = $this->findModel($id);
            return $this->redirect(['index','locate'=>$modelCari->LOCATE,'locatesub'=>$modelCari->LOCATE_SUB]);
        } else {
            return $this->renderAjax('review', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new ItemGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ItemGroup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect('index');
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ItemGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ITEM_GRP_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ItemGroup model.
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
     * Finds the ItemGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ItemGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ItemGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
