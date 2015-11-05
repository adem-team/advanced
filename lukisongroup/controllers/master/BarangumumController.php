<?php
namespace lukisongroup\controllers\master;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use lukisongroup\models\master\Barangumum;
use lukisongroup\models\master\BarangumumSearch;




//use app\models\UploadForm;
//use yii\web\UploadedFile;
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
          $searchModel = new BarangumumSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
          
           if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
             $PK = unserialize(Yii::$app->request->post('editableKey'));
             $model = $this->findModel($PK['ID'],$PK['KD_BARANG']);

            // store a default json response as desired by editable
            $out = Json::encode(['output'=>'', 'message'=>'']);

            // fetch the first entry in posted data (there should
            // only be one entry anyway in this array for an
            // editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $post = [];
            $posted = current($_POST['Barangumum']);
            $post['Barangumum'] = $posted;

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
                if (isset($posted['NM_BARANG'])) {
                   // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
                    $output =$model->NM_BARANG;
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
     * Displays a single Barangumum model.
     * @param string $id
     * @param string $kd_barang
     * @return mixed
     */
    
//    action view and update mix
    public function actionView($ID, $KD_BARANG)
    {
         $model = $this->findModel($ID, $KD_BARANG);

//        if ($model->load(Yii::$app->request->post())){
//			
//			$image = $model->uploadImage();
//			if ($model->save()) {
//				// upload only if valid uploaded file instance found
//				if ($image !== false) {
//					$path = $model->getImageFile();
//					$image->saveAs($path);
//				}
//                                return $this->redirect(['index']);
//			}
//                  else{
//                      $jscript = "$('#view-emp').on('show.bs.modal', function (event) {
//		        var button = $(event.relatedTarget)
//		        var modal = $(this)
//		        var title = button.data('title') 				
//		        var href = button.attr('href') 
//		        modal.find('.modal-title').html(title)
//		        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
//				$.post(href)
//		            .done(function( data ) {
//		                modal.find('.modal-body').html(data)						
//					});				
//				})";
//				$this->enableCsrfValidation = false;
//                  }
//        }
        return $this->renderAjax('view', [
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


         {
			
            return $this->renderAjax('create', [
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
		

        $kd = Yii::$app->mastercode->barangumum($kdCorp,$kdType,$kdKategori,$kdUnit);
        
/*
		$ck = Barangumum::find()->select('KD_BARANG')->where(['KD_CORP' => $kdCorp])->andWhere('STATUS <> 3')->orderBy(['ID'=>SORT_DESC])->one();
		if(count($ck) == 0){ $nkd = 1; } else { $kd = explode('.',$ck->KD_BARANG); $nkd = $kd[5]+1; }
		
		$kd = "BRG.".$kdCorp.".".$kdType.".".$kdKategori.".".$kdUnit.".".str_pad( $nkd, "4", "0", STR_PAD_LEFT );
*/
		
		$model->KD_BARANG = $kd;
                $model->CREATED_BY = Yii::$app->user->identity->username;
                $model->CREATED_AT = date('Y-m-d H:i:s');
		
		$image = $model->uploadImage();
		if ($model->save()) {
			// upload only if valid uploaded file instance found
			if ($image !== false) {
				$path = $model->getImageFile();
				$image->saveAs($path);
			}
		}
	
		
		return $this->redirect(['/master/barangumum']);
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
//                         print_r($model);
//                                die();
            return $this->redirect(['master/barangumum']);
        } else {
            return $this->renderAjax('update', [
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
