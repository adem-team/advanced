<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\controllers\hrd;

/* VARIABLE BASE YII2 Author: -YII2- */
	use Yii;
	use yii\web\Controller;
	use yii\web\NotFoundHttpException;
	use yii\filters\VerbFilter;

/* VARIABLE PRIMARY JOIN/SEARCH/FILTER/SORT Author: -ptr.nov- */
	use lukisongroup\models\hrd\Employe;			/* TABLE CLASS JOIN */
	use lukisongroup\models\hrd\EmployeSearch;	/* TABLE CLASS SEARCH */
	use lukisongroup\models\hrd\Deptsub;
	use lukisongroup\models\hrd\Jobgrademodul;
    use yii\helpers\Json;

/* VARIABLE SIDE MENU Author: -Eka- */
	//use lukisongroup\models\system\side_menu\M1000;			/* TABLE CLASS */
	//use lukisongroup\models\system\side_menu\M1000Search;	/* TABLE CLASS SEARCH */
/* CLASS SIDE MENU Author: -ptr.nov- */
	use yii\web\UploadedFile;
	
/**
 * HRD | CONTROLLER EMPLOYE .
 */
class EmployeController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(['Employe','Pendidikan']),
                'actions' => [
                    //'delete' => ['post'],
					'save' => ['post'],
                ],
            ],
        ];
    }

    /**
     * ACTION INDEX
     */
	/* -- Created By ptr.nov --*/
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
		/*	variable content View Side Menu Author: -Eka- */
		//set menu side menu index - Array Jeson Decode
       // $side_menu=M1000::find()->findMenu('sss_berita_acara')->one()->jval;
        //$side_menu=json_decode($side_menu,true);
		
		/*	variable content View Employe Author: -ptr.nov- */
        $searchModel = new EmployeSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		 
		/*	variable content View Additional Author: -ptr.nov- */ 
		//$searchFilter = $searchModel->searchALL(Yii::$app->request->queryParams);
        $searchModel1 = new EmployeSearch();
        $dataProvider1 = $searchModel->search_resign(Yii::$app->request->queryParams);
		
		/*SHOW ARRAY YII Author: -Devandro-*/
		//print_r($dataProvider->getModels());
		
		/*SHOW ARRAY JESON Author: -ptr.nov-*/
		//echo  \yii\helpers\Json::encode($dataProvider->getModels());
        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $EMP_ID = Yii::$app->request->post('editableKey');
            $model = Employe::findOne($EMP_ID);

            // store a default json response as desired by editable
            $out = Json::encode(['output'=>'', 'message'=>'']);

            // fetch the first entry in posted data (there should
            // only be one entry anyway in this array for an
            // editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $post = [];
            $posted = current($_POST['Employe']);
            $post['Employe'] = $posted;

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
                if (isset($posted['EMP_NM'])) {
                   // $output =  Yii::$app->formatter->asDecimal($model->EMP_NM, 2);
                    $output =$model->EMP_NM;
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
		//$generate_key_emp= Yii::$app->ambilkonci->getKey_Employe('GSN');
		//print_r($generate_key_emp);
		 $model = $this->findModel('ALG.2015.000056');
		return $this->render('index', [
			//'side_menu'=>$side_menu,			/* Content variable Array -SideMenu- */
            'searchModel' => $searchModel, 		/* Content variable Array -Filter Search- */
            'dataProvider' => $dataProvider,	/* Content variable Array -Class Table Join- */
            'searchModel1' => $searchModel1,
            'dataProvider1' => $dataProvider1,  /* Content variable Array Aditional -Class Table Join- */
			 'model' => $model,
        ]);
    }

    /**
	 * ACTION VIEW -> $id=PrimaryKey
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())){
			$model->UPDATED_BY=Yii::$app->user->identity->username;
			$upload_file=$model->uploadFile();
			var_dump($model->validate());
			if($model->validate()){
				if($model->save()) {
					if ($upload_file !== false) {
						$path=$model->getUploadedFile();
						$upload_file->saveAs($path);
					}
					//return $this->redirect(['view', 'id' => $model->EMP_ID]);
					return $this->redirect(['index']);
				} 
			}
		}else {
			 $js1="$('#view-emp').on('show.bs.modal', function (event) {
		        var button = $(event.relatedTarget)
		        var modal = $(this)
		        var title = button.data('title') 				
		        var href = button.attr('href') 
		        modal.find('.modal-title').html(title)
		        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
		            .done(function( data ) {
		                modal.find('.modal-body').html(data)						
					});				
				})";
				$this->enableCsrfValidation = false; 
			//$js='$("#view-emp").modal("show")';
			//$this->getView(['index'])->registerJs($js);
            //return $this->render('view', [
            //return $this->renderAjax('_view', [

            return $this->renderAjax('_view', [
                'model' => $model,				
            ]);
        }
    }
	
	/*
	public function actionViewedit($id)
    {
        $model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())){
			$model->UPDATED_BY=Yii::$app->user->identity->username;
			$upload_file=$model->uploadFile();
			var_dump($model->validate());
			if($model->validate()){
				if($model->save()) {
					if ($upload_file !== false) {
						$path=$model->getUploadedFile();
						$upload_file->saveAs($path);
					}
					//return $this->redirect(['view', 'id' => $model->EMP_ID]);
					return $this->redirect(['index']);
				} 
			}
		}else {
            //return $this->render('view', [
            return $this->renderAjax('_view_edit', [
                'model' => $model,
            ]);
        }
    }
	*/
    /**
     * ACTION CREATE note | $id=PrimaryKey -> TRIGER FROM VIEW  -ptr.nov-
     */
    public function actionCreate()
    {		
        $model = new Employe();

        if ($model->load(Yii::$app->request->post())){			
			$upload_file=$model->uploadFile();
			var_dump($model->validate());
			if($model->validate()){
				if($model->save()) {
					$model->CREATED_BY=Yii::$app->user->identity->username;
					$model->save();
					if ($upload_file !== false) {
						$path=$model->getUploadedFile();
						$upload_file->saveAs($path);
					}
					//return $this->redirect(['view', 'id' => $model->EMP_ID]);	
					return $this->redirect(['index']);	
				} 
			}
		}else {
			//$js='$("#create-emp").modal("show")';
			//$this->getView()->registerJs($js);
            //return $this->render('create', [
            //return $this->renderAjax('create', [
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * ACTION UPDATE -> $id=PrimaryKey
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->EMP_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * ACTION DELETE -> $id=PrimaryKey | CHANGE STATUS -> lihat Standart table status | Jangan dihapus dari record
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		$model->STATUS = 3;
		$model->UPDATED_BY = Yii::$app->user->identity->username;
		$model->save();
		
        return $this->redirect(['index']);
    }

    /**
     * CLASS TABLE FIND PrimaryKey
     * Example:  Employe::find()
     */
    protected function findModel($id)
    {
        if (($model = Employe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

/*
    public function actionEditableDemo() {
        $model = new Employe; // your model can be loaded here

        // Check if there is an Editable ajax request
        if (isset($_POST['hasEditable'])) {
            // use Yii's response format to encode output as JSON
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            // read your posted model attributes
            if ($model->load($_POST)) {
                // read or convert your posted information
                $value = $model->EMP_NM;

                // return JSON encoded output in the below format
                return ['output'=>$value, 'message'=>''];

                // alternatively you can return a validation error
                // return ['output'=>'', 'message'=>'Validation error'];
            }
            // else if nothing to do always return an empty JSON encoded output
            else {
                return ['output'=>'', 'message'=>''];
            }
        }

        // Else return to rendering a normal view
        //return $this->render('view', ['model'=>$model]);
    }
	*/
	
	   /*GENERATE CODE EMPLOYE DEPDROP*/
	   public function actionSubcat() {
            $out = [];
            if (isset($_POST['depdrop_parents'])) {
                $parents = $_POST['depdrop_parents'];
                //print_r($parents);
                if ($parents != null) {
                    $cat_id = $parents[0];
					//$generate_key_emp= Yii::$app->ambilkonci->getKey_Employe($cat_id);
                    $generate_key_emp1= Yii::$app->ambilkonci->getKey_Employe($cat_id);
                    //$out = self::getSubCatList($cat_id);
                    // the getSubCatList function will query the database based on the
                    // cat_id and return an array like below:
                   // $out = self::getSubCatList1($cat_id);
                    $data=[
                            'out'=>[
                                //['id'=>$generate_key_emp1, 'name'=> $generate_key_emp1],
                                ['id'=> $generate_key_emp1, 'name'=>$generate_key_emp1, 'options'=> ['style'=>['color'=>'red'],'disabled'=>false]],
                                //['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                                ],
                            'selected'=>$generate_key_emp1,
                        ];
                   // $selected = self::getSubcat($cat_id);

                    echo Json::encode(['output'=>$data['out'], 'selected'=>$data['selected']]);
                    return;
                }
            }
            echo Json::encode(['output'=>'', 'selected'=>'']);
        }
		
		/*DEPARTMENT - SUB DEPARTMENT DEPDROP*/
		public function actionSubdept() {
             $out = [];
			if (isset($_POST['depdrop_parents'])) {
				$parents = $_POST['depdrop_parents'];
				if ($parents != null) {					
					$DEP_ID = $parents[0];
					$param1 = null;
					if (!empty($_POST['depdrop_params'])) {
						$params = $_POST['depdrop_params'];
						$param1 = $params[0]; // get the value of sub dept =js value/html							
					}					
										
					$model = Deptsub::find()->asArray()->where(['DEP_ID'=>$DEP_ID])->all();
					
						foreach ($model as $key => $value) {
							   $out[] = ['id'=>$value['DEP_SUB_ID'],'name'=> $value['DEP_SUB_NM']];
						   }					
						
					   echo json_encode(['output'=>$out, 'selected'=>$param1]);
					   return;
				   }
			   }
			   echo Json::encode(['output'=>'', 'selected'=>'']);
        }
		
		/* JOBGRADE DEPDROP*/
		public function actionGrading() {
             $out = [];
			if (isset($_POST['depdrop_parents'])) {
				$parents = $_POST['depdrop_parents'];
				if ($parents != null) {
					$GRP_FNC = $parents[0];	
					$GRP_SEQ = $parents[1];
					$grd_param1 = null;
					if (!empty($_POST['depdrop_params'])) {
						$params = $_POST['depdrop_params'];
						$grd_param1 = $params[0]; // get the value of grading_id  = js/html value								}
					}
					
					$model = Jobgrademodul::find()->asArray()->where(['GF_ID'=>$GRP_FNC,'SEQ_ID'=>$GRP_SEQ])->all();					
						foreach ($model as $key => $value) {
							   $out[] = ['id'=>$value['JOBGRADE_ID'],'name'=> $value['JOBGRADE_NM']];
						   }
						   
					   echo json_encode(['output'=>$out, 'selected'=>$grd_param1]);
					   //echo json_encode(['output'=>$out, 'selected'=>'']);
					    
					   return;
				   }
			   }
			   echo Json::encode(['output'=>'', 'selected'=>'']);
        }
	
}
