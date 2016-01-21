<?php

namespace lukisongroup\master\controllers;

use Yii;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\KategoriSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * KategoriController implements the CRUD actions for Kategori model.
 */
class KategoriController extends Controller
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
     * Lists all Kategori models.
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
        $searchModel = new KategoriSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
             $PK = unserialize(Yii::$app->request->post('editableKey'));
             $model = $this->findModel($PK['ID'],$PK['KD_KATEGORI']);

            // store a default json response as desired by editable
            $out = Json::encode(['output'=>'', 'message'=>'']);

            // fetch the first entry in posted data (there should
            // only be one entry anyway in this array for an
            // editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $post = [];
            $posted = current($_POST['Kategori']);
            $post['Kategori'] = $posted;

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
                if (isset($posted['NM_KATEGORI'])) {
                   // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
                    $output =$model->NM_KATEGORI;
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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kategori model.
     * @param string $id
     * @param string $kd_kategori
     * @return mixed
     */
    public function actionView($ID, $KD_KATEGORI)
    {
		$ck = Kategori::find()->where(['ID'=>$ID, 'KD_KATEGORI'=>$KD_KATEGORI])->one();
		if(count($ck) == 0){
			return $this->redirect(['index']);
		}
		if($ck->STATUS !== 3){
			return $this->renderAjax('view', [
				'model' => $this->findModel($ID, $KD_KATEGORI),
			]);
		} else {
			return $this->redirect(['index']);
		}
    }

    /**
     * Creates a new Kategori model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Kategori();


         {
			
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSimpan()
    {
        $model = new Kategori();

		if($model->load(Yii::$app->request->post())){
                  
                    
                    $ck = Kategori::find()->max('KD_KATEGORI');
                    $nwa = $ck+1;
                    $nw = str_pad( $nwa, "2", "0", STR_PAD_LEFT );
                    $model->KD_KATEGORI = $nw;
                    $model->CREATED_BY = Yii::$app->user->identity->username;
                    $model->CREATED_AT = date('Y-m-d H:i:s');
                    $model->save();
                    
//                    print_r($model);
//                    die();
                    
		return $this->redirect(['index']);
                    
                }
	else{
            return ActiveForm::validate($model);
        }	
    }

    /**
     * Updates an existing Kategori model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @param string $kd_kategori
     * @return mixed
     */
    public function actionUpdate($ID, $KD_KATEGORI)
    {
        $model = $this->findModel($ID, $KD_KATEGORI);
        
        
        if ($model->load(Yii::$app->request->post())) {
//                $data = Kategori::find()->where(['ID'=>$ID, 'KD_KATEGORI'=>$KD_KATEGORI])->one();
//                $ktgr = $data['STATUS'];
//        
//		$baris = Kategori::find()->where(['ID'=>$ID, 'KD_KATEGORI'=>$KD_KATEGORI])->count();
//	
//		if($ktgr == 3 && $baris == 0 ){
//			return $this->redirect(['master/kategori']);
//		}
//                else{
//        }
                    if($model->validate())
                    {
                        
                        
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
     * Deletes an existing Kategori model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @param string $kd_kategori
     * @return mixed
     */
    public function actionDelete($ID, $KD_KATEGORI)
    {
		$model = Kategori::find()->where(['ID'=>$ID, 'KD_KATEGORI'=>$KD_KATEGORI])->one();
		$model->STATUS = 3;
		$model->UPDATED_BY = Yii::$app->user->identity->username;
		$model->save();  // equivalent to $model->update();
		
        //$this->findModel($ID, $KD_KATEGORI)->delete();
        return $this->redirect(['/master/kategori/']);
    }

    /**
     * Finds the Kategori model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @param string $kd_kategori
     * @return Kategori the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID, $KD_KATEGORI)
    {
        if (($model = Kategori::find()->where(['ID'=>$ID, 'KD_KATEGORI'=>$KD_KATEGORI])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
