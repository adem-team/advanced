<?php

namespace lukisongroup\sistem\controllers;

use Yii;
use lukisongroup\sistem\models\Mdlpermission;
use lukisongroup\sistem\models\Modulerp;
use lukisongroup\sistem\models\MdlpermissionSearch;
use lukisongroup\sistem\models\UserloginSearch;
use lukisongroup\sistem\models\Userlogin;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use lukisongroup\hrd\models\Employe;

/**
 * MdlpermissionController implements the CRUD actions for Mdlpermission model.
 */
class ModulPermissionController extends Controller
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
     * Lists all Mdlpermission models and Modul Erp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserloginSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModelpermision = new MdlpermissionSearch();
        $dataProviderpermision = $searchModelpermision->search(Yii::$app->request->queryParams);
        $params = Yii::$app->request->queryParams;
        $baris = Modulerp::find()->count();
        if(count($params) == 0)
        {

        }else {
          # code...
          if(count($params) < $baris )
          {
            $user_id = $params['MdlpermissionSearch']["USER_ID"];
            $modul = Mdlpermission::find()->select('MODUL_ID')->where(['USER_ID'=>$user_id])->asArray()->all();
            $erp = Modulerp::find()->where(['not in','MODUL_ID',$modul])->all();
            foreach ($erp as $key => $value) {
              # code...
              $connection = Yii::$app->db;
              $connection->createCommand()->batchInsert('modul_permission',['USER_ID','MODUL_ID'],[[$user_id,$value['MODUL_ID']]])->execute();
            }
          }
        }

        // print_r(count($params));
        // die();
        	if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = Mdlpermission::findOne($id);
            $out = Json::encode(['output'=>'', 'message'=>'']);

            $post = [];
            $posted = current($_POST['Mdlpermission']);
            $post['Mdlpermission'] = $posted;
            if ($model->load($post)) {
              	$output = '';

            if (isset($posted['BTN_CREATE'])) {
                $model->save();
              $output =$model->BTN_CREATE;
            }
            if (isset($posted['BTN_EDIT'])) {
              $model->save();
              $output = $model->BTN_EDIT;;
            }
            if (isset($posted['BTN_DELETE'])) {
              $model->save();
              $output = $model->BTN_DELETE;
            }
            if (isset($posted['BTN_VIEW'])) {
              $model->save();
              $output = $model->BTN_VIEW;
            }
            if (isset($posted['BTN_PROCESS1'])) {
              $model->save();
              $output = $model->BTN_PROCESS1;
            }
            if (isset($posted['BTN_PROCESS2'])) {
              $model->save();
              $output = $model->BTN_PROCESS2;
            }
            if (isset($posted['BTN_PROCESS3'])) {
              $model->save();
              $output = $model->BTN_PROCESS3;
            }
            if (isset($posted['BTN_PROCESS4'])) {
                $model->save();
              $output = $model->BTN_PROCESS4;
            }
            if (isset($posted['BTN_PROCESS5'])) {
                $model->save();
              $output = $model->BTN_PROCESS5;
            }
            if (isset($posted['BTN_SIGN1'])) {
                $model->save();
              $output = $model->BTN_SIGN1;
            }
            if (isset($posted['BTN_SIGN2'])) {
                $model->save();
              $output = $model->BTN_SIGN2;
            }
            if (isset($posted['BTN_SIGN3'])) {
                $model->save();
              $output = $model->BTN_SIGN3;
            }
            if (isset($posted['BTN_SIGN4'])) {
                $model->save();
              $output = $model->BTN_SIGN4;
            }
            if (isset($posted['BTN_SIGN5'])) {
                $model->save();
              $output = $model->BTN_SIGN5;
            }
            	$out = Json::encode(['output'=>$output, 'message'=>'']);
          }
          echo $out;
          return;
        }


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelpermision'=>$searchModelpermision,
            'dataProviderpermision'=>$dataProviderpermision
        ]);
    }






    /**
     * Creates a new Mdlpermission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
          $model = new Userlogin();
          $model->scenario = 'createuser';
          $data = ArrayHelper::map(Employe::find()->orderBy('EMP_NM')->asArray()->all(), 'EMP_ID','EMP_NM');

        if ($model->load(Yii::$app->request->post()) ) {
          $hash = Yii::$app->getSecurity()->generatePasswordHash($model->password_hash);
          $model->password_hash = $hash;
          $model->created_at = strtotime(date('Y-m-d'));
            if($model->save())
            {
              $data = Modulerp::find()->asArray()->all();
              foreach ($data as $hasil) {
                  $connection = Yii::$app->db;
                  $connection->createCommand()->batchInsert('modul_permission',['USER_ID','MODUL_ID'],[[$model->id,$hasil['MODUL_ID']]])->execute();

                }
            }

            return $this->redirect('index');
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'data'=>$data
            ]);
        }
    }

    /**
     * Updates an existing Mdlpermission model.
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

    public function actionUpdatePass($id)
    {
      # code...
      $model = $this->findModelUser($id);
      $model->scenario = 'updateuser';
      if ($model->load(Yii::$app->request->post()) ) {
        $post = Yii::$app->request->post();
        $newpass = $post['Userlogin']['new_pass'];
        $hash = Yii::$app->getSecurity()->generatePasswordHash($newpass);
        $model->password_hash = $hash;
         $model->save();
          return $this->redirect('index');
      } else {
          return $this->renderAjax('update', [
              'model' => $model,
          ]);
      }
    }

    /**
     * Deletes an existing Mdlpermission model.
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
     * Finds the Mdlpermission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Mdlpermission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mdlpermission::find()->where(['ID'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModelUser($id)
    {
        if (($model = Userlogin::find()->where(['id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
