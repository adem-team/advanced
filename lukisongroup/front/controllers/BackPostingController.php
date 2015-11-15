<?php

namespace lukisongroup\front\controllers;

use Yii;
use lukisongroup\front\models\Posting;
use lukisongroup\front\models\PostingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use lukisongroup\front\models\Child;
use lukisongroup\front\models\Grandchild;
/**
 * PostingController implements the CRUD actions for Posting model.
 */
class BackPostingController extends Controller
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
     * ACTION INDEX | Session Login
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
     * Lists all Posting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Posting model.
     * @param integer $id
     * @return mixed
     */
   public function actionView($ID)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($ID),
        ]);
    }


    /**
     * Creates a new Posting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Posting;
 
        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
               $imagename=$model->JUDUL; 
               $model->file=UploadedFile::getInstance($model,'file');
               if($model->file<>'')
               {
               $model->file->saveAs('uploads/'.$imagename.'.'.$model->file->extension);
               $model->IMAGE='uploads/'.$imagename.'.'.$model->file->extension;
               }
               $model->save();
              //return $this->redirect(['/posting/posting']);
              return $this->redirect(['index']);
            } else {
                // error in saving model
            }
        return $this->renderAjax('create', [
            'model'=>$model,
        ]);
    }
    public function actionGetChild() {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $cat_id = $parents[0];
            $model = Child::find()->asArray()->where(['PARENT_ID'=>$cat_id])->all();
            foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['CHILD_ID'],'name'=> $value['CHILD_NAME']];
               }
 
               echo json_encode(['output'=>$out, 'selected'=>'']);
               return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
   }
   public function actionGetGrandchild() {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $ids = $_POST['depdrop_parents'];
        $cat_id = $ids[0];
        $subcat_id =$ids[0];
        if ($cat_id != null) {
          // $data = Grandchild::getProdList($cat_id, $subcat_id);
            $model = Grandchild::find()->asArray()->where(['PARENT_ID'=>$cat_id,'CHILD_ID'=>$subcat_id])->all();
           foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['GRANDCHILD'],'name'=> $value['GRANDCHILD']];
               }
             
           
            echo json_encode(['output'=>$out, 'selected'=>'']);
           return;
        }
    }
    echo Json::encode(['output'=>'', 'selected'=>'']);
}
   public function actionCreated()
    {
       $model = new Posting;
 
        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();

 
            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($image !== false) {
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                }
                 //return $this->redirect(['/posting/posting']);
                 return $this->redirect(['index']);
            } else {
                // error in saving model
            }
        }
        return $this->renderAjax('create', [
            'model'=>$model,
        ]);
     
    }
    /**
     * Updates an existing Posting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($ID)
    {
        $model = $this->findModel($ID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['/posting/posting']);
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Posting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($ID)
    {
        $this->findModel($ID)->delete();

        //return $this->redirect(['/posting/posting']);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Posting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Posting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Posting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
