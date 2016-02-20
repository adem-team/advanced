<?php
namespace lukisongroup\master\controllers;

use Yii;
use lukisongroup\master\models\Suplier;
use lukisongroup\master\models\SuplierSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

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
        $searchModel = new SuplierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
          if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
             $PK = unserialize(Yii::$app->request->post('editableKey'));
             $model = $this->findModel($PK['ID'],$PK['KD_SUPPLIER']);

            // store a default json response as desired by editable
            $out = Json::encode(['output'=>'', 'message'=>'']);

            // fetch the first entry in posted data (there should
            // only be one entry anyway in this array for an
            // editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $post = [];
            $posted = current($_POST['Suplier']);
            $post['Suplier'] = $posted;

            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model
                $model->save();

                // custom output to return to be displayed as the editable grid cell
                // data. Normally this is empty - whereby whatever value is edited by
                // in the input by user is updated automatically.
                $output = '';

                // specific use case where you need to validate a specific
                // editable column posted when you have more than one
                // EditableColumn in the grid view. We evaluate here a
                // check to see if buy_amount was posted for the Book model
                if (isset($posted['NM_SUPPLIER'])) {
                   // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
                    $output =$model->NM_SUPPLIER;
                }

                // similarly you can check if the name attribute was posted as well
                // if (isset($posted['name'])) {
                //   $output =  ''; // process as you need
                // }
                $out = Json::encode(['output'=>$output, 'message'=>'']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
          }
		/*Tambahal menu side Dinamik */
		$sideMenu_control='umum_datamaster';
        return $this->render('index', [
			'sideMenu_control'=> $sideMenu_control,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	/*ESM Supplier*/
	public function actionEsmIndex()
    {
        $searchModel = new SuplierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
          if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
             $PK = unserialize(Yii::$app->request->post('editableKey'));
             $model = $this->findModel($PK['ID'],$PK['KD_SUPPLIER']);

            // store a default json response as desired by editable
            $out = Json::encode(['output'=>'', 'message'=>'']);

            // fetch the first entry in posted data (there should
            // only be one entry anyway in this array for an
            // editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $post = [];
            $posted = current($_POST['Suplier']);
            $post['Suplier'] = $posted;

            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model
                $model->save();

                // custom output to return to be displayed as the editable grid cell
                // data. Normally this is empty - whereby whatever value is edited by
                // in the input by user is updated automatically.
                $output = '';

                // specific use case where you need to validate a specific
                // editable column posted when you have more than one
                // EditableColumn in the grid view. We evaluate here a
                // check to see if buy_amount was posted for the Book model
                if (isset($posted['NM_SUPPLIER'])) {
                   // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
                    $output =$model->NM_SUPPLIER;
                }

                // similarly you can check if the name attribute was posted as well
                // if (isset($posted['name'])) {
                //   $output =  ''; // process as you need
                // }
                $out = Json::encode(['output'=>$output, 'message'=>'']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
          }
		/*Tambahal menu side Dinamik */
		$sideMenu_control='esm_produk';
        return $this->render('index', [
			'sideMenu_control'=> $sideMenu_control,
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
			return $this->renderAjax('view', [
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
                if($model->validate())
                {
		$crp = $model->KD_CORP;
		
		$kd = Yii::$app->mastercode->kdsupplier($crp);
        
		$model->KD_SUPPLIER = $kd;
                $model->CREATED_BY = Yii::$app->user->identity->username;
                $model->CREATED_AT = date('Y-m-d H:i:s');
		$model->save();
                }
		return $this->redirect(['index']);
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
            return $this->renderAjax('create', [
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

        if ($model->load(Yii::$app->request->post()) ) {
            if($model->validate())
            {
            $model->UPDATED_BY = Yii::$app->user->identity->username;
           
             $model->save();
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
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
