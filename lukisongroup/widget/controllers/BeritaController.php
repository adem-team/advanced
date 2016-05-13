<?php

namespace lukisongroup\widget\controllers;

/* extensions */
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* namespace models */
use lukisongroup\widget\models\Berita;
use lukisongroup\widget\models\BeritaNotify;
use lukisongroup\widget\models\Commentberita;
use lukisongroup\widget\models\BeritaSearch;
use lukisongroup\hrd\models\Dept;
use lukisongroup\hrd\models\Employe;

/**
 * BeritaController implements the CRUD actions for Berita model.
 */
class BeritaController extends Controller
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
       * Before Action Index
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
     * Lists all Berita models.
     * @return mixed
     */
    public function actionIndex()
    {
        /* outbox dataprovider*/
        $searchModelOutbox = new BeritaSearch();
        $dataProviderOutbox = $searchModelOutbox->searchBeritaOutbox(Yii::$app->request->queryParams);

        /* inbox dataprovider */
        $searchModelInbox = new BeritaSearch();
        $dataProviderInbox = $searchModelInbox->searchBeritaInbox(Yii::$app->request->queryParams);

          /* History dataprovider */
        $searchModelHistory = new BeritaSearch();
        $dataProviderHistory = $searchModelHistory->searchBeritaClose(Yii::$app->request->queryParams);



        return $this->render('index', [
            'searchModelOutbox' => $searchModelOutbox,
            'dataProviderOutbox' => $dataProviderOutbox,
            'searchModelInbox'  => $searchModelInbox,
            'dataProviderInbox' => $dataProviderInbox,
            'searchModelHistory' => $searchModelHistory,
            'dataProviderHistory' => $dataProviderHistory
        ]);
    }

    /**
     * Displays a single Berita model.
     * @param string $KD_BERITA
     * @return mixed
     */
    public function actionDetailBerita($KD_BERITA)
    {
      //componen
      $profile = Yii::$app->getUserOpt->profile_user()->emp;
      $profile_login = Yii::$app->getUserOpt->profile_user();
      $id = $profile->EMP_ID;
      $nama = $profile_login->username;

      $model = Berita::find()->where(['KD_BERITA' => $KD_BERITA])->one();
      $connection = Yii::$app->db_widget;
	    $command =  $connection->createCommand('UPDATE bt0001notify set TYPE = 0 where KD_BERITA="'.$KD_BERITA.'" AND ID_USER="'.$id.'"');
      $command->execute();

        return $this->render('view_detailberita', [
            'model' => $model,
            'id'=>$id,
            'nama'=>$nama
        ]);
    }

    /**
     * Creates a new Berita model.
     * If creation is successful, the browser will be redirected to the 'detail-berita' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Berita();
        /* data departement using select 2 */
        $datadep = ArrayHelper::map(Dept::find()->where('DEP_STS <>3')->asArray()->all(), 'DEP_ID', 'DEP_NM');

        /* data Employe using select 2 */
        $dataemploye = ArrayHelper::map(Employe::find()->where('EMP_STS <>3')->asArray()->all(), 'EMP_ID', 'EMP_NM');

        /* componen user */
        $profile = Yii::$app->getUserOpt->profile_user()->emp;
        $emp_img = $profile->EMP_IMG;

        /* foto profile */
        if($emp_img == '')
        {
         $foto_profile = Html::img(Yii::getAlias('@web').'/upload/hrd/Employee/default.jpg', ['width'=>'130','height'=>'130', 'align'=>'center' ,'class'=>'img-thumbnail']);
        }else{
         $foto_profile = Html::img(Yii::getAlias('@web').'/upload/hrd/Employee/'.$emp_img, ['width'=>'130','height'=>'130', 'align'=>'center' ,'class'=>'img-thumbnail']);
        }

          /* proses save */
        if ($model->load(Yii::$app->request->post())) {

          /*  not usage
              *checkbox using filter author : wawan
              *if checkbox equal 1 then kd_dep result 0
          */
          // $post = Yii::$app->request->post();
          // $checkbox = $post['Berita']['alluser'];
          // if($checkbox == 1)
          // {
          //   $model->KD_DEP = '0';
          // }

          /* generate kode berita*/
          $GneratekodeBerita=\Yii::$app->ambilkonci->getBeritaCode();

          $model->KD_BERITA = $GneratekodeBerita;

          //componen
          $model->KD_CORP =  	Yii::$app->getUserOpt->Profile_user()->emp->EMP_CORP_ID;
	        $model->CREATED_BY = Yii::$app->user->identity->EMP_ID;
          // print_r($model->USER_CC);
          // die();


          if($model->save())
          {


              $departement = Berita::find()->where(['KD_BERITA'=>$model->KD_BERITA])->asArray()->one();

                /* connection db widget */
                $connection = Yii::$app->db_widget;

                $date =  date('Y-m-d');

                $connection->createCommand()
                          ->insert('bt0001notify', [
                                  'KD_BERITA' =>$model->KD_BERITA,
                                   'ID_USER' =>$model->USER_CC,
                                    'CREATED_BY' => $model->CREATED_BY,
                                    'CREATED_AT' => $date,
                                    ])->execute();

            }

              return $this->redirect(['detail-berita','KD_BERITA' => $model->KD_BERITA]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'datadep'=>$datadep,
                'emp_img'=>$emp_img,
                'foto_profile'=>$foto_profile,
                'dataemploye'=>$dataemploye
            ]);
        }
    }




    /** author :wawan
     * Creates a new Commentberita model.
     * If creation is successful,update bt0001notify type equal 1 and the browser will be redirected to the 'detail-berita' page.
     * @param string $KD_BERITA
     * @return mixed
     */
    public function actionJoinComment($KD_BERITA)
    {
        $model = new Commentberita();

        /* componen user */
        $profile = Yii::$app->getUserOpt->profile_user()->emp;
        $emp_img = $profile->IMG_BASE64;

        /* foto profile */
        if(count($emp_img) == 0)
        {
         $foto_profile = Html::img(Yii::getAlias('@web').'/upload/hrd/Employee/default.jpg', ['width'=>'130','height'=>'130', 'align'=>'center' ,'class'=>'img-thumbnail']);
        }else{
         $foto_profile =Html::img('data:image/jpg;base64,'.$emp_img,['width'=>'130','height'=>'130', 'align'=>'center' ,'class'=>'img-thumbnail']);
        }

        /* proses save */
        if ($model->load(Yii::$app->request->post())) {
          $model->KD_BERITA = $KD_BERITA;
          $model->EMP_IMG = $emp_img;

          //componen
          $model->ID_USER = Yii::$app->user->identity->id;
		      $model->CREATED_AT = date('Y-m-d h:i:s');
	        $model->CREATED_BY = Yii::$app->user->identity->EMP_ID;
		      if($model->save())
          {
            /* update read or unread  notifikasion */
            $notifupdateread = BeritaNotify::updateAll(['TYPE' => 1], ['KD_BERITA'=>$model->KD_BERITA]);

          }
			    return $this->redirect(['detail-berita','KD_BERITA' => $model->KD_BERITA]);
        } else {
            return $this->renderAjax('commentar', [
                'model' => $model,
                'emp_img'=>$emp_img,
                'foto_profile'=>$foto_profile
            ]);
        }
    }



    /* ajax validation  author:wawan*/
    public function actionValidBeritaAcara()
    {
      # code...
        $model = new Berita();
      if(Yii::$app->request->isAjax && $model->load($_POST))
      {
        /* not usage
        if checkbox equal false then scenario validation false
            else checkbox equal true then scenario validation true
        */
        // if($_POST['Berita']['alluser'] == 0){
        //     $model->scenario = 'false';
        // }else{
        //     $model->scenario = 'true';
        // }
        Yii::$app->response->format = 'json';
        return ActiveForm::validate($model);
      }
    }

    /** author wawan
     * close Berita model.
     * If close is successful, delete bt0001notify and return true.
     * @return mixed
     */
     public function actionCloseBerita()
       {
   		if (Yii::$app->request->isAjax) {
   			$request= Yii::$app->request;
   			$id=$request->post('id');
        $connection = Yii::$app->db_widget;

        $connection->createCommand()
	            ->update('bt0001', ['STATUS' => 0], 'KD_BERITA="'.$id.'"')
	            ->execute();

        $close = $connection->createCommand('DELETE FROM bt0001notify WHERE KD_BERITA=:kd_berita');
        $close->bindParam(':kd_berita', $kd_berita);
        $kd_berita = $id;
        $close->execute();
   			return true;
   		}
      }

/* get user cc usage depdrop not used anymore */
    // public function getusercc($id)
    // {
    //       $out = [];
    //       $model = Employe::find()->asArray()
    //                               ->where(['DEP_ID'=>$id])
    //                               ->andwhere('STATUS<>3')
    //                               ->all();
    //       foreach ($model as $key => $value) {
    //             $out[] = ['id'=>$value['EMP_ID'],'name'=> $value['EMP_NM']];
    //      }
    //      return $out;
    // }

/* not used anymore depdrop author : wawan*/
//     public function actionCariUserBerita() {
//
//     if (isset($_POST['depdrop_parents'])) {
//         $parents = $_POST['depdrop_parents'];
//         if ($parents != null) {
//             $id = $parents[0];
//              $out = $this->getusercc($id); //call function getusercc
//             echo Json::encode(['output'=>$out, 'selected'=>'']);
//             return;
//         }
//     }
//     echo Json::encode(['output'=>'', 'selected'=>'']);
// }


    /**
     * Finds the Berita model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID
     * @return Berita the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID)
    {
        if (($model = Berita::findOne(['ID' => $ID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
