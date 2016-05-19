<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\widget\controllers;

/* VARIABLE BASE YII2 Author: -YII2- */
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use lukisongroup\widget\models\Chat;
use lukisongroup\widget\models\ChatSearch;
use lukisongroup\widget\models\ChatroomSearch;
/* VARIABLE PRIMARY JOIN/SEARCH/FILTER/SORT Author: -ptr.nov- */
//use app\models\hrd\Dept;			/* TABLE CLASS JOIN */
//use app\models\hrd\DeptSearch;		/* TABLE CLASS SEARCH */

/**
 * HRD | CONTROLLER EMPLOYE .
 */
class ChatController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
					//'save' => ['post'],
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
     * ACTION INDEX
     */

    public function actionIndex()
    {
		/*MODEL CHAT MESSAGE*/
        $searchModelMsg = new ChatSearch();
        $dataProviderMsg = $searchModelMsg->search(Yii::$app->request->queryParams);
        $dataProviderMsg->pagination->pageSize=100;
		/*MODEL CHAT GROUP*/
        $searchmodelGrp = new ChatroomSearch();
        $dataproviderGrp = $searchmodelGrp->search(Yii::$app->request->queryParams);
        $dataproviderGrp->pagination->pageSize=100;
        /*MODEL CHAT USER*/
        $searchModelUser = new ChatSearch();
        $dataProviderUser = $searchModelUser->searchonline(Yii::$app->request->queryParams);
        $dataProviderUser->pagination->pageSize=100;


        return $this->render('index', [
			/*RENDER CHAT MESSAGE*/
            'searchModelMsg' => $searchModelMsg,
            'dataProviderMsg' => $dataProviderMsg,
			/*RENDER CHAT GROUP*/
            'searchmodelGrp' => $searchmodelGrp,
            'dataproviderGrp' => $dataproviderGrp,
			/*RENDER CHAT USER*/
            'searchModelUser' => $searchModelUser,
            'dataProviderUser' => $dataProviderUser,
			/*MENU DEFAULT*/
			'ctrl_chat'=>'mdefault',
        ]);
    }


	 public function actionCreateajax($id)
    {
        $model = new Chat();

        if ($model->load(Yii::$app->request->post())) {
            $model->GROUP = $id;
			$model->CREATED_BY = Yii::$app->user->identity->id;;
			$model->MESSAGE_STS = 0;
			$model->MESSAGE_SHOW = 0;
//             $model->image = \yii\web\UploadedFile::getInstance($model, 'file');
//            $model->file->saveAs('upload/'.'Gambarmenu'.'.'.$model->file->extension);
//            $model->MESSAGE_ATTACH = '/upload/'.'Gambarmenu'.'.'.$model->file->extension;
//            $image = $model->uploadImage();
              if($model->save())
              {
                  echo 1;
//                  if ($image !== false) {
//				$path = $model->getImageFile();
//				$image->saveAs($path);
//
//                                print_r($image);
////                                die();
//			}
              }
              else{
                  echo 0;
              }
//            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays a single Chat model.
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
     * Creates a new Chat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

   /*  public function actionCreate()
    {
           $model = new Chat();

        if (Yii::$app->request->isAjax) {

           $data = Yii::$app->request->post();

			$id = $data['id'];
			$mes = $data['mes'];


		 $model->MESSAGE = $mes;
		 $model->GROUP = $id;


//           print_r($img);
//           $model->image = $img;



            if($model->save())
            {
               echo 1;
            }
			else {
     echo  0;
 }/
        }








//    return [
////        'search' => $search,
//        'code' => 100,
//    ];
  } */
//            return $this->redirect(['index']);
//        }
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }




    /**
     * Updates an existing Chat model.
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
     * Deletes an existing Chat model.
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
     * Finds the Chat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Chat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
