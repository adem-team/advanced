<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\hrd\controllers;

	/* VARIABLE BASE YII2 Author: -YII2- */
	use Yii;
	use yii\helpers\Html;
	use yii\web\Controller;
	use yii\web\NotFoundHttpException;
	use yii\filters\VerbFilter;
	use yii\web\UploadedFile;
	use yii\helpers\Json;
	use yii\helpers\ArrayHelper;
	use kartik\grid\GridView;

	/* VARIABLE PRIMARY JOIN/SEARCH/FILTER/SORT Author: -ptr.nov- */
	use lukisongroup\hrd\models\Employe;			/* TABLE CLASS JOIN */
	use lukisongroup\hrd\models\EmployeSearch;	/* TABLE CLASS SEARCH */
	use lukisongroup\hrd\models\Deptsub;
	use lukisongroup\hrd\models\Jobgrademodul;
	use lukisongroup\hrd\models\ProfileSalesSearch;
	use lukisongroup\sistem\models\Userlogin;

	use lukisongroup\hrd\models\Corp;
	use lukisongroup\hrd\models\Dept;
	//use lukisongroup\hrd\models\Jabatan;
	use lukisongroup\hrd\models\Status;
	use lukisongroup\hrd\models\Jobgrade;
	use lukisongroup\hrd\models\Groupseqmen;
	use lukisongroup\hrd\models\Groupfunction;

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

	private function aryCorp(){
		return ArrayHelper::map(Corp::find()->orderBy('SORT')->asArray()->all(), 'CORP_NM','CORP_NM');
	}
	private function aryCorpID(){
		$datacorp =  ArrayHelper::map(Corp::find()->orderBy('SORT')->asArray()->all(), 'CORP_ID','CORP_NM');
		return $datacorp;
	}
	private function aryDept(){
		return ArrayHelper::map(Dept::find()->orderBy('SORT')->asArray()->all(), 'DEP_NM','DEP_NM');
	}
	private function aryDeptID(){
		return ArrayHelper::map(Dept::find()->orderBy('SORT')->asArray()->all(), 'DEP_ID','DEP_NM');
	}
	private function aryDeptSub(){
		return ArrayHelper::map(Deptsub::find()->orderBy('SORT')->asArray()->all(), 'DEP_SUB_NM','DEP_SUB_NM');
	}
	private function aryDeptSubID(){
		return ArrayHelper::map(Deptsub::find()->orderBy('SORT')->asArray()->all(), 'DEP_SUB_ID','DEP_SUB_NM');
	}
	private function aryGrpFnc(){
		return ArrayHelper::map(Groupfunction::find()->orderBy('SORT')->asArray()->all(), 'GF_NM','GF_NM');
	}
	private function aryGrpFncID(){
		return ArrayHelper::map(Groupfunction::find()->orderBy('SORT')->asArray()->all(), 'GF_ID','GF_NM');
	}
	private function arySeq(){
		return ArrayHelper::map(Groupseqmen::find()->orderBy('SEQ_NM')->asArray()->all(), 'SEQ_NM','SEQ_NM');
	}
	private function arySeqID(){
		return ArrayHelper::map(Groupseqmen::find()->orderBy('SEQ_NM')->asArray()->all(), 'SEQ_ID','SEQ_NM');
	}
	private function aryJab(){
		return ArrayHelper::map(Jobgrade::find()->orderBy('SORT')->asArray()->all(), 'JOBGRADE_NM','JOBGRADE_NM');
	}
	private function aryJabID(){
		return ArrayHelper::map(Jobgrade::find()->orderBy('SORT')->asArray()->all(), 'JOBGRADE_ID','JOBGRADE_NM');
	}
	private function aryStt(){
		return ArrayHelper::map(Status::find()->orderBy('SORT')->asArray()->all(), 'STS_NM','STS_NM');
	}
	private function arySttID(){
		return ArrayHelper::map(Status::find()->orderBy('SORT')->asArray()->all(), 'STS_ID','STS_NM');
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
		/*
		 * SEARCH FIRST AND DIRECT
		 * @author piter [ptr.nov@gmail.com]
		 * @since 1.2
		*/
		$paramCari=Yii::$app->getRequest()->getQueryParam('id');
		if ($paramCari!=''){
			$cari=['EMP_ID'=>$paramCari];
		}else{
			$cari='';
		};

		/*	variable content View Employe Author: -ptr.nov- */
    $searchModel = new EmployeSearch($cari);
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		/*	variable content View Additional Author: -ptr.nov- */
		//$searchFilter = $searchModel->searchALL(Yii::$app->request->queryParams);
        $searchModel1 = new EmployeSearch();
        $dataProvider1 = $searchModel1->search_resign(Yii::$app->request->queryParams);

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
		 //$model = $this->findModel('ALG.2015.000056');
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dinamkkColumn1'=>$this->gvColumn1(),
			'dinamkkColumn2'=>$this->gvColumn2(),
      'dataProvider' => $dataProvider,
      'searchModel1' => $searchModel1,
      'dataProvider1' => $dataProvider1,
			'aryCorpID'=>$this->aryCorpID(),
			'aryDept'=>$this->aryDept(),
			'aryDeptSub'=>$this->aryDeptSub(),
			'aryGrpFnc'=>$this->aryGrpFnc(),
			'arySeq'=>$this->arySeq(),
			'aryJab'=>$this->aryJab(),
			'aryStt'=>$this->aryStt()
        ]);
    }



		/* index salesman from crm */
		public function actionIndexSalesman()
		{
			/*
			 * SEARCH FIRST AND DIRECT
			 * @author piter [ptr.nov@gmail.com]
			 * @since 1.2
			*/
			$paramCari=Yii::$app->getRequest()->getQueryParam('id');
			if ($paramCari!=''){
				$cari=['EMP_ID'=>$paramCari];
			}else{
				$cari='';
			};

				$searchModel = new ProfileSalesSearch($cari);
			  $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			return $this->render('index_salesman_employe', [
						'searchModel' => $searchModel,
			      'dataProvider' => $dataProvider,
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
					//return $this->redirect(['index']);
					return $this->renderAjax('_view', [
						'model' => $model,
					]);
				}
			}
		}else {
			 $js1="$.fn.modal.Constructor.prototype.enforceFocus = function(){};
			 $('#view-emp').on('show.bs.modal', function (event) {
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

		/*
      *convert base 64 image
      *@author:wawan since 1.0
    */
    public function saveimage($base64)
    {
      $base64 = str_replace('data:image/jpg;base64,', '', $base64);
      $base64 = base64_encode($base64);
      $base64 = str_replace(' ', '+', $base64);

      return $base64;

    }


    /**
     * ACTION CREATE note | $id=PrimaryKey -> TRIGER FROM VIEW  -ptr.nov-
     */
    public function actionCreate()
    {
        $model = new Employe();

        if ($model->load(Yii::$app->request->post())){
			$upload_file = $model->uploadImage();
			$data_base64 = $upload_file != ''? $this->saveimage(file_get_contents($upload_file->tempName)): ''; //call function saveimage using base64
			$model->IMG_BASE64 = $data_base64;
			// var_dump($model->validate());
			if($model->validate()){
				if($model->save()) {
					$model->CREATED_BY=Yii::$app->user->identity->username;
					$model->save();
					if ($upload_file !== false) {
						$path=$model->getUploadedFile();
						$upload_file->saveAs($path);
					}
					// print_r($model->save());
					// die();
					//return $this->redirect(['view', 'id' => $model->EMP_ID]);
					return $this->redirect(['index','id'=>$model->EMP_ID]);
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
     * View & Update -> EMPLOYEE IDENTITY
     * @author piter [ptr.nov@gmail.com]
     * @since 1.2
     */
	public function actionEditIdentity($id){
        $model = $this->findModel($id);

		if (!$model->load(Yii::$app->request->post())) {
			return $this->renderAjax('_form_edit_identity', [
					'model' => $model,
				]);
		}else{

			if(Yii::$app->request->isAjax){
				$model->load(Yii::$app->request->post());
				return Json::encode(\yii\widgets\ActiveForm::validate($model));
			}else{
				if ($model->load(Yii::$app->request->post())) {
					$image = $model->uploadImage();
					$data_base64 = $image != ''? $this->saveimage(file_get_contents($image->tempName)): ''; //call function saveimage using base64
					$model->IMG_BASE64 = $data_base64;
					if ($model->save()) {
						// upload only if valid uploaded file instance found
						if ($image !== false) {
							$path = $model->getImageFile();
							$image->saveAs($path);
						}
					}
					return $this->redirect(['index','id'=>$model->EMP_ID]);
				}
			}
		}
	}


/* edit-titel */
	public function actionEditTitel($id){
        $model = $this->findModel($id);
				$datacorp =  ArrayHelper::map(Corp::find()->orderBy('SORT')->asArray()->all(), 'CORP_ID','CORP_NM');
				$datadep = ArrayHelper::map(Dept::find()->orderBy('SORT')->asArray()->all(), 'DEP_ID','DEP_NM');
				$aryGrpFnc =ArrayHelper::map(Groupfunction::find()->orderBy('SORT')->asArray()->all(), 'GF_ID','GF_NM');
				$arySeqID = ArrayHelper::map(Groupseqmen::find()->orderBy('SEQ_NM')->asArray()->all(), 'SEQ_ID','SEQ_NM');
				$emp_sts =  ArrayHelper::map(Status::find()->orderBy('SORT')->asArray()->all(), 'STS_ID','STS_NM');

		if (!$model->load(Yii::$app->request->post())) {
			return $this->renderAjax('_form_edit_title', [
					'model' => $model,
					'datacorp'=>$datacorp,
					'datadep'=>$datadep,
					'aryGrpFnc'=>$aryGrpFnc,
					'arySeqID' =>$arySeqID,
					'emp_sts'=>$emp_sts
				]);
		}else{

			if(Yii::$app->request->isAjax){
				$model->load(Yii::$app->request->post());
				return Json::encode(\yii\widgets\ActiveForm::validate($model));
			}else{
				if ($model->load(Yii::$app->request->post())) {
					//$model->save();
					$image = $model->uploadImage();
					if ($model->save()) {
						// upload only if valid uploaded file instance found
						if ($image !== false) {
							$path = $model->getImageFile();
							$image->saveAs($path);
						}
					}
					return $this->redirect(['index','id'=>$model->EMP_ID]);
				}
			}
		}
	}

	public function actionEditProfile($id){
				$model = $this->findModel($id);
		if (!$model->load(Yii::$app->request->post())) {
			return $this->renderAjax('_form_profile', [
					'model' => $model,
				]);
		}else{

			if(Yii::$app->request->isAjax){
				$model->load(Yii::$app->request->post());
				return Json::encode(\yii\widgets\ActiveForm::validate($model));
			}else{
				if ($model->load(Yii::$app->request->post())) {
					$image = $model->uploadImage();
					if ($model->save()) {
						// upload only if valid uploaded file instance found
						if ($image !== false) {
							$path = $model->getImageFile();
							$image->saveAs($path);
						}
					}
					return $this->redirect(['index','id'=>$model->EMP_ID]);
				}
			}
		}
	}

	public function actionResign($id){
				$model = $this->findModel($id);
				$emp_sts =  ArrayHelper::map(Status::find()->orderBy('SORT')->asArray()->all(), 'STS_ID','STS_NM');

		if (!$model->load(Yii::$app->request->post())) {
			return $this->renderAjax('form_resign', [
					'model' => $model,
					'emp_sts'=>$emp_sts
				]);
		}else{

			if(Yii::$app->request->isAjax){
				$model->load(Yii::$app->request->post());
				return Json::encode(\yii\widgets\ActiveForm::validate($model));
			}else{
				if ($model->load(Yii::$app->request->post())) {
					//$model->save();
					$image = $model->uploadImage();
          $date = \Yii::$app->formatter->asDate($model->EMP_RESIGN_DATE,'yyyy-mm-dd');
          $model->EMP_RESIGN_DATE = $date;
					if ($model->save()) {
							$cari_user_login = Userlogin::find()->where(['EMP_ID'=>$id])->one();
							$cari_user_login->status = 1;
							$cari_user_login->save();
						// upload only if valid uploaded file instance found
						if ($image !== false) {
							$path = $model->getImageFile();
							$image->saveAs($path);
						}
					}
					return $this->redirect(['index','id'=>$model->EMP_ID]);
				}
			}
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


	/*
	 * PENGUNAAN DALAM GRID
	 * Arry Setting Attribute
	 * @author ptrnov [ptr.nov@gmail.com]
	 * @since 1.2
		foreach($valFields as $key =>$value[])
		{
			print_r($value[0]['FIELD'].','.$value[0]['SIZE']);		//SATU
			print_r($value[$key]['FIELD'].','.$value[0]['SIZE']);	//ARRAY 0-end
		}
	*/
	private function gvAttribute(){
		$aryField= [
			//['ID' =>0, 'ATTR' =>['FIELD'=>'EMP_IMG','SIZE' => '10px','label'=>'Image','align'=>'left']],
			['ID' =>0, 'ATTR' =>['FIELD'=>'EMP_ID','SIZE' => '10px','label'=>'Employee.ID','align'=>'left']],
			['ID' =>1, 'ATTR' =>['FIELD'=>'EMP_NM','SIZE' => '20px','label'=>'Name','align'=>'left']],
			['ID' =>2, 'ATTR' =>['FIELD'=>'corpOne.CORP_NM','SIZE' => '20px','label'=>'Company','align'=>'left']],
			['ID' =>3, 'ATTR' =>['FIELD'=>'deptOne.DEP_NM','SIZE' => '20px','label'=>'Department','align'=>'left']],
			['ID' =>4, 'ATTR' =>['FIELD'=>'deptsub.DEP_SUB_NM','SIZE' => '20px','label'=>'Dept.Sub','align'=>'left']],
			['ID' =>5, 'ATTR' =>['FIELD'=>'groupfunction.GF_NM','SIZE' => '10px','label'=>'GroupFunction','align'=>'left']],
			['ID' =>6, 'ATTR' =>['FIELD'=>'groupseqmen.SEQ_NM','SIZE' => '10px','label'=>'Seqment','align'=>'left']],
			['ID' =>7, 'ATTR' =>['FIELD'=>'jobgrade.JOBGRADE_NM','SIZE' => '10px','label'=>'Greding','align'=>'left']],
			['ID' =>8, 'ATTR' =>['FIELD'=>'sttOne.STS_NM','SIZE' => '10px','label'=>'Status','align'=>'left']],
			['ID' =>9, 'ATTR' =>['FIELD'=>'EMP_JOIN_DATE','SIZE' => '10px','label'=>'Join.Date','align'=>'left']]
		];
		$valFields = ArrayHelper::map($aryField, 'ID', 'ATTR');

		return $valFields;
	}



	public function gvColumn1() {
		/*NO ATTRIBUTE*/
		$attDinamik[] =[
				'class'=>'kartik\grid\SerialColumn',
				'contentOptions'=>['class'=>'kartik-sheet-style'],
				'width'=>'10px',
				'header'=>'No.',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'verdana, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
		];

		$attDinamik[]=[
			'class'=>'kartik\grid\ActionColumn',
			'dropdown' => true,
			'template' => '{view}{edit0}{edit1}{edit2}{edit3}{lihat}',
			'dropdownOptions'=>['class'=>'pull-left dropdown'],
			'dropdownButton'=>['class' => 'btn btn-default btn-xs'],
			'buttons' => [
				'view' =>function($url, $model, $key){
						return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
													['/hrd/employe/view','id'=>$model->EMP_ID],[
													'data-toggle'=>"modal",
													'data-target'=>"#activity-emp",
													'data-title'=> $model->EMP_ID,
													]). '</li>' . PHP_EOL;
				},
				// BUTTON EMPLOYEE IDENTITY
				'edit0' =>function($url, $model, $key){
						return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Set Identity'),
													['/hrd/employe/edit-identity','id'=>$model->EMP_ID],[
													'data-toggle'=>"modal",
													'data-target'=>"#edit-identity",
													'data-title'=> $model->EMP_ID,
													]). '</li>' . PHP_EOL;
				},
				'edit1' =>function($url, $model, $key){
						return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Set Title'),
													['/hrd/employe/edit-titel','id'=>$model->EMP_ID],[
													'data-toggle'=>"modal",
													'data-target'=>"#activity-emp",
													'data-title'=> $model->EMP_ID,
													]). '</li>' . PHP_EOL;
				},
				'edit2' =>function($url, $model, $key){
						return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Set Profile'),
													['/hrd/employe/edit-profile','id'=>$model->EMP_ID],[
													'data-toggle'=>"modal",
													'data-target'=>"#edit-profile",
													'data-title'=> $model->EMP_ID,
													]). '</li>' . PHP_EOL;
				},
				'edit3' =>function($url, $model, $key) {
						//$gF=getPermissionEmp()->GF_ID;
						//if ($gF<=4){
							return  '<li>' . Html::a('<span class="fa fa-money fa-dm"></span>'.Yii::t('app', 'Set Payroll'),
													['/hrd/employe/payrol','id'=>$model->EMP_ID],[
													'data-toggle'=>"modal",
													'data-target'=>"#edit-payroll",
													]). '</li>' . PHP_EOL;
						//}
				},
			'lihat' =>function($url, $model, $key) {
					//$gF=getPermissionEmp()->GF_ID;
					//if ($gF<=4){
						return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Set Resign'),
												['/hrd/employe/resign','id'=>$model->EMP_ID],[
												'data-toggle'=>"modal",
												'data-target'=>"#edit-resign",
												]). '</li>' . PHP_EOL;
					//}
			}
		],
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'height'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],

		];
		return array_merge($attDinamik,$this->gvColumn());
	}
	public function gvColumn2() {
		$attDinamik[] =[
				'class'=>'kartik\grid\SerialColumn',
				'contentOptions'=>['class'=>'kartik-sheet-style'],
				'width'=>'10px',
				'header'=>'No.',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'verdana, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
		];
		//return array_merge($attDinamik,$this->gvColumn());
		return array_merge($attDinamik,$this->gvColumn());
	}


	/*
	 * GRIDVIEW COLUMN
	 * @author ptrnov [ptr.nov@gmail.com]
	 * @since 1.2
	*/
	public function gvColumn() {
		$attDinamik =[];
		/*Image*/
		$attDinamik[] =[
				'attribute'=>'EMP_IMG',
				'label'=>'Image',
				'format' => 'html',
				'value'=>function($model){
					// return Html::img(Yii::getAlias('@HRD_EMP_UploadUrl') . '/'. $model->EMP_IMG, ['width'=>'20']);
					 return Html::img(Yii::getAlias('@web').'/upload/hrd/Employee/'.$model->EMP_IMG,['width'=>'20']);
				},
				'width'=>'10px',
				'header'=>'No.',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'verdana, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
		];
		/*OTHER ATTRIBUTE*/
		foreach($this->gvAttribute() as $key =>$value[]){
			$filterWidgetOpt='';
			if ($value[$key]['FIELD']=='corpOne.CORP_NM'){
				//$gvfilterType=GridView::FILTER_SELECT2;
				//$gvfilterType=false;
				$gvfilter =$this->aryCorp();
				 // $filterWidgetOpt=[
					// 'pluginOptions'=>['allowClear'=>true],
					//'placeholder'=>'Any author'
				// ];
				//$filterInputOpt=['placeholder'=>'Any author'];
			}elseif($value[$key]['FIELD']=='deptOne.DEP_NM'){
				$gvfilterType=false;
				$gvfilter =$this->aryDept();
			}elseif($value[$key]['FIELD']=='deptsub.DEP_SUB_NM'){
				$gvfilterType=false;
				$gvfilter =$this->aryDeptSub();
			}elseif($value[$key]['FIELD']=='groupfunction.GF_NM'){
				$gvfilterType=false;
				$gvfilter =$this->aryGrpFnc();
			}elseif($value[$key]['FIELD']=='groupseqmen.SEQ_NM'){
				$gvfilterType=false;
				$gvfilter =$this->arySeq();
			}elseif($value[$key]['FIELD']=='jobgrade.JOBGRADE_NM'){
				$gvfilterType=false;
				$gvfilter =$this->aryJab();
			}elseif($value[$key]['FIELD']=='sttOne.STS_NM'){
				$gvfilterType=false;
				$gvfilter =$this->aryStt();
			}
			// elseif($value[$key]['FIELD']=='EMP_JOIN_DATE'){
				// $gvfilterType=GridView::FILTER_DATE_RANGE;
				// $filterWidgetOpt=[
					//'attribute' =>'EMP_JOIN_DATE',
					// 'presetDropdown'=>true,
					// 'convertFormat'=>true,
						// 'pluginOptions'=>[
							// 'format'=>'Y-m-d',
							// 'separator' => ' TO ',
							// 'opens'=>'left'
						// ],
				// ];
			// }

			/*
			elseif($value[$key]['FIELD']=='cabOne.CAB_NM'){
				$gvfilterType=false;
				$gvfilter =$this->aryCbg();
			}elseif($value[$key]['FIELD']=='jabOne.JAB_NM'){
				$gvfilterType=false;
				$gvfilter =$this->aryJab();
			}elseif($value[$key]['FIELD']=='stsOne.KAR_STS_NM'){
				$gvfilterType=false;
				$gvfilter =$this->aryStt();
			}elseif($value[$key]['FIELD']=='golonganOne.TT_GRP_NM'){
				$gvfilterType=false;
				$gvfilter=$this->aryGol();
			// }elseif($value[$key]['FIELD']=='KAR_TGLM'){
				// $gvfilterType=GridView::FILTER_DATE_RANGE;
				// $gvfilter=true;
				// $filterWidgetOpt=[
					'attribute' =>'KAR_TGLM',
					// 'presetDropdown'=>TRUE,
					// 'convertFormat'=>true,
						// 'pluginOptions'=>[
							// 'format'=>'Y-m-d',
							// 'separator' => ' TO ',
							// 'opens'=>'left'
						// ],
				// ];
			// }
			 */
			else{
				$gvfilterType=false;
				$gvfilter=true;
				$filterWidgetOpt=false;
				//$filterInputOpt=false;
			};

			$attDinamik[]=[
				'attribute'=>$value[$key]['FIELD'],
				'label'=>$value[$key]['label'],
				//'format' => 'html',
				/* 'value'=>function($model)use($value,$key){
					if ($value[$key]['FIELD']=='EMP_IMG'){
						 return Html::img(Yii::getAlias('@HRD_EMP_UploadUrl') . '/'. $model->EMP_IMG, ['width'=>'20']);
					}
				}, */
				'filterType'=>$gvfilterType,
				'filter'=>$gvfilter,
				'filterWidgetOptions'=>$filterWidgetOpt,
				//'filterInputOptions'=>$filterInputOpt,
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
						'background-color'=>'rgba(97, 211, 96, 0.3)',
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
				//'pageSummaryFunc'=>GridView::F_SUM,
				//'pageSummary'=>true,
				'pageSummaryOptions' => [
					'style'=>[
							'text-align'=>'right',
							//'width'=>'12px',
							'font-family'=>'tahoma',
							'font-size'=>'8pt',
							'text-decoration'=>'underline',
							'font-weight'=>'bold',
							'border-left-color'=>'transparant',
							'border-left'=>'0px',
					]
				],
			];
		}

		return $attDinamik;
	}


}
