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
use kartik\mpdf\Pdf;

/* namespace models */
use lukisongroup\widget\models\Berita;
use lukisongroup\widget\models\BeritaImage;
use lukisongroup\widget\models\BeritaNotify;
use lukisongroup\widget\models\Commentberita;
use lukisongroup\widget\models\BeritaSearch;
use lukisongroup\hrd\models\Dept;
use lukisongroup\hrd\models\Employe;
use lukisongroup\hrd\models\Corp;

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

        /* filter corp */
        $selectCorp = ArrayHelper::map(Corp::find()->where('CORP_STS<>3')->all(), 'CORP_ID', 'CORP_NM');

        /* filter Dept */
        $selectdept = ArrayHelper::map(Dept::find()->where('DEP_STS<>3')->all(), 'DEP_ID', 'DEP_NM');

        /* filter Status */
        $aryStt= [
      		  ['STATUS' => 0, 'STT_NM' => 'UNREAD'],
      		  ['STATUS' => 1, 'STT_NM' => 'READ'],
      	];
      	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');

        return $this->render('index', [
            'searchModelOutbox' => $searchModelOutbox,
            'dataProviderOutbox' => $dataProviderOutbox,
            'searchModelInbox'  => $searchModelInbox,
            'dataProviderInbox' => $dataProviderInbox,
            'searchModelHistory' => $searchModelHistory,
            'dataProviderHistory' => $dataProviderHistory,
            'selectCorp'=>$selectCorp,
            'selectdept'=>$selectdept,
            'valStt'=>$valStt
        ]);
    }

    /**@author : wawan
     * Displays a single Berita model.
     * bt0001notify update TYPE equal 0 after action DetailBerita
     * @param string $KD_BERITA
     * @return mixed
     */
    public function actionDetailBerita($KD_BERITA)
    {
      //componen
      $profile = Yii::$app->getUserOpt->profile_user()->emp;
      $id = $profile->EMP_ID;

      $model = Berita::find()->where(['KD_BERITA' => $KD_BERITA])->one();
      $connection = Yii::$app->db_widget;
      /* note next development */
	    $command =  $connection->createCommand('UPDATE bt0001notify set TYPE = 0 where KD_BERITA="'.$KD_BERITA.'" AND ID_USER="'.$id.'"');
      $command->execute();

        return $this->render('view_detailberita', [
            'model' => $model,
            'id'=>$id
        ]);
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

    /* *upload ajax using dropzone js || _form
       *@author : wawan
    */
        public function actionUploadBeritaAcara()
    {
        $fileName = 'file';
        $model = new beritaimage();

        if (isset($_FILES[$fileName])) {
            $file = \yii\web\UploadedFile::getInstanceByName($fileName);

            //componen
            $profile = Yii::$app->getUserOpt->profile_user()->emp;
            $id = $profile->EMP_ID;

            $data = $this->saveimage(file_get_contents($file->tempName)); //call function saveimage using base64
            $model->ID_USER = $id;
            $model->CREATED_BY = $id;
            $model->ATTACH64 = $data;
            $model->TYPE = 1;
            if ($model->save()) {
                //Now save file data to database
                echo \yii\helpers\Json::encode($file);
            }
        }

        return false;
    }

    /* upload ajax using dropzone js||commentar
      *@author : wawan
    */
        public function actionUploadJoin($KD_BERITA)
    {
        $fileName = 'file';
        $model = new beritaimage();
        $cariemp_inberita = Berita::find()->where(['KD_BERITA'=>$KD_BERITA])->asArray()->one();

        if (isset($_FILES[$fileName])) {
            $file = \yii\web\UploadedFile::getInstanceByName($fileName);

            //componen
            $profile = Yii::$app->getUserOpt->profile_user()->emp;
            $id = $profile->EMP_ID;

            $data = $this->saveimage(file_get_contents($file->tempName)); //call function saveimage using base64
            $model->KD_BERITA = $KD_BERITA;
            $model->ID_USER = $id;
            $model->CREATED_BY = $cariemp_inberita['CREATED_BY'];
            $model->ATTACH64 = $data;
            $model->TYPE = 0;
            if ($model->save()) {
                //Now save file data to database
                echo \yii\helpers\Json::encode($file);
            }
        }

        return false;
    }

    public function actionPrintBeritaAcara($kd_berita)
    {
      # code...
      /* seacrh news */
      $model = Berita::findOne(['KD_BERITA'=>$kd_berita]);

      /* search employe */
      $queryCariEmploye = employe::find()->where(['EMP_ID'=>$model->CREATED_BY])->andwhere('STATUS<>3')->one();
      $ttdbase64 = $queryCariEmploye->SIGSVGBASE64;
      $emp_nm = $queryCariEmploye->EMP_NM.' '.$queryCariEmploye->EMP_NM_BLK;

      $content = $this->renderPartial( '_print_berita', [
        'model'=>$model,
        'emp_nm'=>$emp_nm,
        'ttdbase64'=>$ttdbase64

          ]);

      $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE,
        // A4 paper format
        'format' => Pdf::FORMAT_A4,
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT,
        // stream to browser inline
        'destination' => Pdf::DEST_BROWSER,
        // your html content input
        'content' => $content,
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting
        //D:\xampp\htdocs\advanced\lukisongroup\web\widget\pdf-asset
        'cssFile' => '@lukisongroup/web/widget/pdf-asset/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:12px}',
         // set mPDF properties on the fly
        'options' => ['title' => 'Berita Acara','subject'=>'Berita'],
         // call mPDF methods on the fly
        'methods' => [
          'SetHeader'=>['Copyright@LukisonGroup '.date("r")],
          'SetFooter'=>['{PAGENO}'],
        ]
      ]);
      return $pdf->render();
    }

    /**
     * Creates a new Berita model.
     *if save successful,then save on bt0001notify
     * If creation is successful, the browser will be redirected to the 'detail-berita' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Berita();
        /* image berita*/
        $beritaimage = new BeritaImage();

        /* data departement using select 2 */
        $datadep = ArrayHelper::map(Dept::find()->where('DEP_STS <>3')->asArray()->all(), 'DEP_ID', 'DEP_NM');

        /* data Employe using select 2 */
        $dataemploye = ArrayHelper::map(Employe::find()->where('EMP_STS <>3')->asArray()->all(), 'EMP_ID', 'EMP_NM');

        /* componen user */
        $profile = Yii::$app->getUserOpt->profile_user()->emp;
        $emp_img = $profile->EMP_IMG;
        $emp_img_base64 = $profile->IMG_BASE64;

        /* foto profile */
        if($emp_img_base64 == '')
        {
         $foto_profile = Html::img(Yii::getAlias('@web').'/upload/hrd/Employee/default.jpg', ['width'=>'130','height'=>'130', 'align'=>'center' ,'class'=>'img-thumbnail']);
        }else{
         $foto_profile = Html::img('data:image/jpg;base64,'.$emp_img_base64, ['width'=>'130','height'=>'130', 'align'=>'center' ,'class'=>'img-thumbnail']);
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
          $model->CREATED_ATCREATED_BY = date('Y-m-d h:i:s');


          if($model->save())
          {

            $update_image_upload = BeritaImage::updateAll(['KD_BERITA' => $model->KD_BERITA], 'ID_USER="'.$profile->EMP_ID.'"AND KD_BERITA = ""');

            /* connection db widget */
            $connection = Yii::$app->db_widget;

            /* date for field CREATED_AT */
            $date =  date('Y-m-d');

            /* search employee */
            $search_depemploye = Employe::find()->where(['DEP_ID'=>$model->KD_DEP])->asArray()->all();

            /* batch insert for many value*/
            foreach ($search_depemploye as $key => $value) {
              # code...
              $connection->createCommand()
                         ->batchInsert('bt0001notify',['KD_BERITA','ID_USER','CREATED_BY','CREATED_AT'],
                                  [[$model->KD_BERITA,$value['EMP_ID'],$profile->EMP_ID,$date]])->execute();

            }

            /*explode string to array using function explode php*/
            $emp_id = explode(",",$model->USER_CC);

            /* foreach array using save Bt001notify */
            foreach ($emp_id as $value) {
            $notifusercc = new BeritaNotify();
              # code...
              $notifusercc->KD_BERITA = $model->KD_BERITA;
              $notifusercc->ID_USER = $value ;
              $notifusercc->CREATED_BY = $profile->EMP_ID;
              $notifusercc->CREATED_AT = $date;
              $notifusercc->save();
            }


        }

              return $this->redirect(['detail-berita','KD_BERITA' => $model->KD_BERITA]);
        } else {
          /* delete image if KD_BERITA equal null */
          $deleteupload = BeritaImage::deleteAll(['KD_BERITA'=>'','ID_USER'=>$profile->EMP_ID]);

            return $this->renderAjax('create', [
                'model' => $model,
                'datadep'=>$datadep,
                'beritaimage'=>$beritaimage,
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
        $emp_img = $profile->EMP_IMG;
        $emp_img_base64 = $profile->IMG_BASE64;

        /* foto profile */
        if($emp_img_base64 == '')
        {
         $emp_img_base64 = "default.jpg";
         $foto_profile = Html::img(Yii::getAlias('@web').'/upload/hrd/Employee/default.jpg', ['width'=>'130','height'=>'130', 'align'=>'center' ,'class'=>'img-thumbnail']);
        }else{
          $emp_img_base64 = $profile->IMG_BASE64;
         $foto_profile = Html::img('data:image/jpg;base64,'.$emp_img_base64, ['width'=>'130','height'=>'130', 'align'=>'center' ,'class'=>'img-thumbnail']);
        }

        /* proses save */
        if ($model->load(Yii::$app->request->post())) {
          $model->KD_BERITA = $KD_BERITA;
          $model->EMP_IMG = $emp_img_base64;

          //componen
          $model->ID_USER = Yii::$app->user->identity->EMP_ID;
		      $model->CREATED_AT = date('Y-m-d h:i:s');
	        $model->CREATED_BY = Yii::$app->user->identity->EMP_ID;

		      if($model->save())
          {

            $condition = ['and',
            ['ID_USER'=>$profile->EMP_ID],
            ['KD_BERITA'=> $model->KD_BERITA],
            ['TYPE'=> 0],
          ];
              $update_image = BeritaImage::updateAll(['CREATED_AT' => $model->CREATED_AT],$condition);

            /* update read or unread  notifikasion */
            $notifupdateread = BeritaNotify::updateAll(['TYPE' => 1], ['KD_BERITA'=>$model->KD_BERITA]);

          }
			    return $this->redirect(['detail-berita','KD_BERITA' => $model->KD_BERITA]);
        } else {
            return $this->renderAjax('commentar', [
                'model' => $model,
                'emp_img'=>$emp_img,
                'foto_profile'=>$foto_profile,
                'KD_BERITA'=>$KD_BERITA
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
