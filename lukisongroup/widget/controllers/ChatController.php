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
use yii\helpers\Json;
use yii\web\Response;

/* namespace models */
use lukisongroup\widget\models\Chat;
use lukisongroup\widget\models\ChatSearch;
use lukisongroup\widget\models\ChatroomSearch;
use lukisongroup\widget\models\Chatroom;
use lukisongroup\sistem\models\Userlogin;
/* VARIABLE PRIMARY JOIN/SEARCH/FILTER/SORT Author: -ptr.nov- */


/**
 * CHAT | CONTROLLER EMPLOYE .
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
                   $id = Yii::$app->getUserOpt->profile_user()->id;
                   $this->getofline($id);
                   $this->redirect(array('/site/login'));  //
               } else {
                 $id = Yii::$app->getUserOpt->profile_user()->id;
                 $this->getonline($id);
                   //Yii::$app->user->setState('userSessionTimeout', time() + Yii::app()->params['sessionTimeoutSeconds']) ;
                   Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
                   return true;

               }
            } else {
                return true;
            }
    }

    public function getonline($id)
    {
      # code...
      $user_login = UserLogin::findOne(['id'=>$id]);
      $user_login->ONLINE = 1;
      $user_login->save();
    }

    public function getofline($id)
    {
      # code...
      $user_login = UserLogin::findOne(['id'=>$id]);
      $user_login->ONLINE = 0;
      $user_login->save();

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

    public function actionMessage($notifOnly = false)
    {
       $MAX_CONN = 15; // 15 second
      

        $sse = new \common\components\SSE();
        try {
            $lastTime = Yii::$app->getRequest()->getHeaders()->get('last-event-id', 0);
            $profile = Yii::$app->getUserOpt->profile_user()->emp;
            $emp_id = $profile->EMP_ID;


            $lastCount = -1;
            for ($i = 0; $i <= $MAX_CONN; $i++) {
                // load message
                if (!$notifOnly) {
                  
                   $rows = Chat::find()->where('UPDATED_TIME <:ctime', [':ctime' => $lastTime])
                               ->orderBy(['UPDATED_TIME' => SORT_DESC])
                               ->asArray()
                               ->all();

                  $lastTime = microtime(true);
                  
                    $msgs = [];
                    foreach (array_reverse($rows) as $row) {
                        $self = $row['CREATED_BY'] == $emp_id;

                        if ($row['UPDATED_TIME'] < ($lastTime - 86400)) { // lebih dari sehari
                            $formatTime = date('d M H:i', $row['UPDATED_TIME']);
                            
                        } else {
                            $formatTime = date('H:i:s', $row['UPDATED_TIME']);
                          
                        }
                        $msgs[] = [
                            'self' => $self,
                            'time' => $formatTime,
                            'name' => $self ? 'Me' : $profile->EMP_NM.' '.$profile->EMP_NM_BLK,
                            'text' => $row['MESSAGE']
                        ];
                    }

                       if (count($msgs) || ($i % 4 == 2)) {
                        $sse->event('chat', ['msgs' => $msgs]);
                        $sse->flush();
                    }
                }
                sleep(1);

                 
            } 

              
        }catch (\Exception $exc) {
            $sse->event('msgerror', ['msg' => $exc->getMessage()]);
            $sse->flush();
        }
        $sse->id($lastTime);
        $sse->flush();
        exit();
    }



public function actionSendChat()
{
  # code...
  if (Yii::$app->request->isAjax) {
// componen user
    $profile = Yii::$app->getUserOpt->profile_user()->emp;
    $emp_id = $profile->EMP_ID;

    /* connection db widget */
    $connection = Yii::$app->db_widget;

    $request = Yii::$app->request;
    // $typechat = $request->post('chat');
    // $id=$request->post('id');
    $chat = $request->post('chat');
    
      # code...
      $model = new Chat();
      $model->MESSAGE = $chat;
      // $model->GROUP_ID = $id;
      $model->CREATED_BY = $emp_id;
      $model->UPDATED_TIME = time();
      $model->save();
    // }



    // print_r($model->getErrors());
    // die();
    return true;
  }
}

// public function actionMessage($notifOnly = false){
//    $MAX_CONN = 15; // 15 times
//         $sse = new \common\components\SSE();
//         try {
//             $lastTime = Yii::$app->getRequest()->getHeaders()->get('last-event-id', 0);
//             $user_id = Yii::$app->user->identity->id;
//             $lastSeen = Yii::$app->profile->lastSeen ? : 0;

//             // $chats = Chat::find()->where('[[UPDATED_TIME]]>:ctime')->orderBy(['UPDATED_TIME' => SORT_DESC])->limit(150);

//             // $chats = (new \yii\db\Query())
//             //     ->select(['UPDATED_TIME', 'MESSAGE'])
//             //     ->from(['chat'])
//             //     ->where('[[UPDATED_TIME]]>:ctime')
//             //     ->orderBy(['UPDATED_TIME' => SORT_DESC])
//             //     ->limit(150);
//               $rows = Chat::find()->where('UPDATED_TIME > :ctime', [':ctime' => $lastTime])->orderBy(['UPDATED_TIME' => SORT_DESC])->asArray()->all();
           

//             // $unread = (new \yii\db\Query())
//             //     ->from(['chat'])
//             //     ->where('[[time]]>:ctime')
//             //     ->andWhere(['<>', 'user_id', $user_id]);

//             // $lastCount = -1;
//             // for ($i = 0; $i <= $MAX_CONN; $i++) {
//             //     // message belum terbaca
//             //     $count = $unread->params([':ctime' => $lastSeen])->count();
//             //     if ($count != $lastCount || ($i % 4 == 0)) {
//             //         $lastCount = $count;
//             //         $sse->event('unread', ['count' => $count]);
//             //         $sse->flush();
//             //     }

//                 // load message
//                 // if (!$notifOnly) {
//                     // $rows = $chats->params([':ctime' => $lastTime])->asArray()->all();
                  
//                     $lastTime = microtime(true);
//                     $msgs = [];
//                     $self = Yii::$app->user->identity->username;
//                     foreach (array_reverse($rows) as $row) {
//                         // $self = $row['user_id'] == $user_id;

//                         if ($row['UPDATED_TIME'] < ($lastTime - 86400)) { // lebih dari sehari
//                             $formatTime = date('d M H:i', $row['UPDATED_TIME']);
//                         } else {
//                             $formatTime = date('H:i:s', $row['UPDATED_TIME']);
//                         }
//                         $msgs[] = [
//                             // 'self' => $self,
//                             'time' => $formatTime,
//                             // 'name' => $self ? 'Me' : "{$row['username']}({$row['user_id']})",
//                             'name' => $self,
//                             'text' => $row['MESSAGE']
//                         ];
//                     }

//                     // if (count($msgs) || ($i % 4 == 2)) {
//                     // $sse->message('This is a message at time');
//                         $sse->event('chat', ['msgs' => $msgs]);
//                         $sse->flush();

//                     // }
//                 // }
//                 sleep(1);
//             // }
//         } catch (\Exception $exc) {
//             $sse->event('msgerror', ['msg' => $exc->getMessage()]);
//             // $sse->flush();
//         }
//         $rows = Chat::find()->where('UPDATED_TIME > :ctime', [':ctime' => $lastTime])->orderBy(['UPDATED_TIME' => SORT_DESC])->asArray()->all();

//                     $lastTime = microtime(true);
//                     $msgs = [];
//                     $profile = Yii::$app->getUserOpt->profile_user()->emp;
//                     $emp_id = $profile->EMP_ID;


//         foreach (array_reverse($rows) as $row) {
//                         $self = $row['CREATED_BY'] == $emp_id;

//                         if ($row['UPDATED_TIME'] < ($lastTime - 86400)) { // lebih dari sehari
//                             $formatTime = date('d M H:i', $row['UPDATED_TIME']);
//                         } else {
//                             $formatTime = date('H:i:s', $row['UPDATED_TIME']);
//                         }
//                         $msgs[] = [
//                             'self' => $self,
//                             'time' => $formatTime,
//                             // 'name' => $self ? 'Me' : "{$row['username']}({$row['user_id']})",
//                             // 'name' => $self,
//                             'text' => $row['MESSAGE']
//                         ];
//                     }

//          // $chat = Chat::find()->asArray()->all();
//         // $sse->id($lastTime);
//          $sse->event('chat', ['msgs' => $msgs]);
//         $sse->flush();
//         exit();
// }

 // public function actionMessage()
 //    {
 //        $sse = new \common\components\SSE();
 //        $counter = rand(1, 10);
 //        $t = time();

 //        //$sse->retry(3000);
 //        while ((time() - $t) < 15) {
 //            // Every second, sent a "ping" event.

 //            $curDate = date(DATE_ISO8601);
 //            $sse->event('ping',['time' => $curDate]);

 //            // Send a simple message at random intervals.

 //            $counter--;
 //            if (!$counter) {
 //                $sse->message("This is a message at time $curDate");
 //                $counter = rand(1, 10);
 //            }

 //            $sse->flush();
 //            sleep(1);
 //        }
 //        exit();
 //    }


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
