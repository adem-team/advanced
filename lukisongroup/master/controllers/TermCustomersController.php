<?php

namespace lukisongroup\master\controllers;

use Yii;
use lukisongroup\master\models\Termcustomers;
use lukisongroup\hrd\models\Jobgrade;
use lukisongroup\master\models\Termgeneral;
use lukisongroup\master\models\Terminvest;
use lukisongroup\master\models\TermbudgetSearch;
use lukisongroup\master\models\Termbudget;
use lukisongroup\master\models\Auth1Model;
use lukisongroup\master\models\Auth2Model;
use lukisongroup\master\models\Auth3Model;
use lukisongroup\master\models\TermgeneralSearch;
use lukisongroup\master\models\TermcustomersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use kartik\mpdf\Pdf;
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Distributor;
use lukisongroup\hrd\models\Corp;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
/**
 * TermCustomersController implements the CRUD actions for Termcustomers model.
 */
class TermCustomersController extends Controller
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

    public function saveimage($base64)
    {
      $base64 = str_replace('data:image/jpg;base64,', '', $base64);
      $base64 = base64_encode($base64);
      $base64 = str_replace(' ', '+', $base64);

      return $base64;

    }


    public function actionUpload($id)
{
    $fileName = 'file';
    // $uploadPath = 'upload/hrd/Employee';
    $model = new Termgeneral();

    if (isset($_FILES[$fileName])) {
        $file = \yii\web\UploadedFile::getInstanceByName($fileName);

        $data = $this->saveimage(file_get_contents( $file->tempName));
           $model->ID_TERM = $id;
           $model->ISI_TERM = $data;


        if ($model->save()) {
            //Now save file data to database

            echo \yii\helpers\Json::encode($file);
        }
    }

    return false;
}



    /**
     * Lists all Termcustomers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TermcustomersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $aryStt= [
            ['STATUS' => 0, 'STT_NM' => 'New'],
            ['STATUS' => 100, 'STT_NM' => 'Proses'],
            ['STATUS' => 101, 'STT_NM' => 'Checked'],
            ['STATUS' => 102, 'STT_NM' => 'Aprroved'],
        ];
        $valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'valStt'=>$valStt,

        ]);
    }


    public function actionPoNote($ID)
    {
      # code...
      $model = Termcustomers::find()->where(['ID_TERM' =>$ID])->one();

      if ($model->load(Yii::$app->request->post())) {
        if($model->validate())
        {
            $model->save();
        }
        if(Yii::$app->getUserOpt->profile_user()->emp->DEP_ID == 'ACT'&&Yii::$app->getUserOpt->Modul_akses('3')->BTN_CREATE==1)
        {
            return $this->redirect(['review-act','id'=>$model->ID_TERM]);
        }
        else{

            return  $this->redirect(['view','id'=> $model->ID_TERM]);
        }
      } else {
          return $this->renderAjax('note', [
              'model' => $model,
          ]);
      }
    }

    public function actionPoNoteUpdate($ID)
    {
      # code...
      $model = Termcustomers::find()->where(['ID_TERM' =>$ID])->one();

      if ($model->load(Yii::$app->request->post())) {
        if($model->validate())
        {
            $model->save();
        }
          return  $this->redirect(['review-act-update','id'=> $model->ID_TERM]);

      } else {
          return $this->renderAjax('note', [
              'model' => $model,
          ]);
      }
    }

    public function actionInvoce($id)
    {
      # code...
      $model = Termcustomers::find()->where(['ID_TERM' =>$id])->one();

      if ($model->load(Yii::$app->request->post())) {
        if($model->validate())
        {
            $model->save();
        }


        return $this->redirect(['review-act','id'=>$model->ID_TERM]);

      } else {
          return $this->renderAjax('invoce', [
              'model' => $model,
          ]);
      }
    }


    public function actionInvoceUpdate($id)
    {
      # code...
      $model = Termcustomers::find()->where(['ID_TERM' =>$id])->one();

      if ($model->load(Yii::$app->request->post())) {
        if($model->validate())
        {
            $model->save();
        }


        return $this->redirect(['review-act-update','id'=>$model->ID_TERM]);

      } else {
          return $this->renderAjax('invoce', [
              'model' => $model,
          ]);
      }
    }

    public function actionFakturPajak($id)
    {
      # code...
      $model = Termcustomers::find()->where(['ID_TERM' =>$id])->one();

      if ($model->load(Yii::$app->request->post())) {
        if($model->validate())
        {
            $model->save();
        }
            return $this->redirect(['review-act','id'=>$model->ID_TERM]);

      } else {
          return $this->renderAjax('pajak', [
              'model' => $model,
          ]);
      }
    }

    public function actionFakturPajakUpdate($id)
    {
      # code...
      $model = Termcustomers::find()->where(['ID_TERM' =>$id])->one();

      if ($model->load(Yii::$app->request->post())) {
        if($model->validate())
        {
            $model->save();
        }
            return $this->redirect(['review-act-update','id'=>$model->ID_TERM]);

      } else {
          return $this->renderAjax('pajak', [
              'model' => $model,
          ]);
      }
    }

    /**
     * Displays a single Termcustomers model.
     * @param integer $id
     * @return mixed
     */

     /**  review sales
           pengajuan Budget pertama kali
     */
    public function actionView($id)
    {

      $searchModel = new TermcustomersSearch();
      $dataProvider = $searchModel->searchcusbyid(Yii::$app->request->queryParams,$id);

      $searchModel1 = new TermbudgetSearch();
      $dataProvider1 = $searchModel1->searchbudget(Yii::$app->request->queryParams,$id);

      $sql1 = "SELECT SUM(BUDGET_ACTUAL) as Total from c0005 where  (ID_TERM='" .$id. "' AND STATUS =1) OR (STATUS =0 AND ID_TERM='" .$id. "')";
      $modelnewaprov = Yii::$app->db3->createCommand($sql1)->queryscalar();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelnewaprov'=>$modelnewaprov,
            'dataProvider' =>  $dataProvider,
            'searchModel1'=>   $searchModel1,
            'dataProvider1' =>  $dataProvider1
        ]);
    }

// review accounting jika accounting create Ro-term sendiri
    public function actionReviewAct($id)
    {

      $searchModel1 = new TermbudgetSearch();
      $dataProvider1 = $searchModel1->searchbudget(Yii::$app->request->queryParams,$id);
      $model = Termcustomers::find()->where(['ID_TERM'=>$id])->one();

      $sql = "SELECT SUM(BUDGET_PLAN) as Total from c0005 where  (ID_TERM='" .$id. "' AND STATUS =1) OR (STATUS =0 AND ID_TERM='" .$id. "')";
      $model2 = Yii::$app->db3->createCommand($sql)->queryscalar();
      $sql1 = "SELECT SUM(BUDGET_ACTUAL) as Total from c0005 where  (ID_TERM='" .$id. "' AND STATUS =1) OR (STATUS =0 AND ID_TERM='" .$id. "')";
      $modelnewaprov = Yii::$app->db3->createCommand($sql1)->queryscalar();


        if (Yii::$app->request->post('hasEditable')) {
          $id = Yii::$app->request->post('editableKey');
          $model = Termbudget::findOne($id);
          $out = Json::encode(['output'=>'', 'message'=>'']);
          $post = [];
          $posted = current($_POST['Termbudget']);

          $post['Termbudget'] = $posted;
          if ($model->load($post)) {
              $model->save();
              $output = '';
          if (isset($posted['BUDGET_ACTUAL'])) {
              $output = $model->BUDGET_ACTUAL;
            }
            if (isset($posted['KD_COSCENTER'])) {
                $output = $model->KD_COSCENTER;
              }
              $out = Json::encode(['output'=>$output, 'message'=>'']);
            echo $out;
            return;
        }
      }
        $term = new Termgeneral();
        return $this->render('review-act', [
            'model'=> $model,
            'model2'=>$model2,
            'modelnewaprov'=>$modelnewaprov ,
            'searchModel1'=>   $searchModel1,
            'dataProvider1' =>  $dataProvider1,
            'term'=>$term,
        ]);
    }



    // review Director
        public function actionReviewDrc($id)
        {

          $searchModel = new TermcustomersSearch();
          $dataProvider = $searchModel->searchcusbyid(Yii::$app->request->queryParams,$id);

          $searchModel1 = new TermbudgetSearch();
          $dataProvider1 = $searchModel1->searchbudget(Yii::$app->request->queryParams,$id);

          $sql = "SELECT SUM(BUDGET_PLAN) as Total from c0005 where  (ID_TERM='" .$id. "' AND STATUS =1) OR (STATUS =0 AND ID_TERM='" .$id. "')";
          $model2 = Yii::$app->db3->createCommand($sql)->queryscalar();

          $sql1 = "SELECT SUM(BUDGET_ACTUAL) as Total from c0005 where  (ID_TERM='" .$id. "' AND STATUS =1) OR (STATUS =0 AND ID_TERM='" .$id. "')";
          $modelnewaprov = Yii::$app->db3->createCommand($sql1)->queryscalar();

            if (Yii::$app->request->post('hasEditable')) {
              $id = Yii::$app->request->post('editableKey');
              $model = Termbudget::findOne($id);
              $out = Json::encode(['output'=>'', 'message'=>'']);
              $post = [];
              $posted = current($_POST['Termbudget']);

              $post['Termbudget'] = $posted;
              if ($model->load($post)) {
                  $model->save();
                  $output = '';
              if (isset($posted['BUDGET_ACTUAL'])) {
                  $output = $model->BUDGET_ACTUAL;
                }
                if (isset($posted['KD_COSCENTER'])) {
                    $output = $model->KD_COSCENTER;
                  }
                  $out = Json::encode(['output'=>$output, 'message'=>'']);
                echo $out;
                return;
            }
          }
            return $this->render('review-drc', [
                'model' => $this->findModel($id),
                'model2' => $model2,
                'modelnewaprov'=>$modelnewaprov,
                // 'searchModel'=>   $searchModel,
                'dataProvider' =>  $dataProvider,
                'searchModel1'=>   $searchModel1,
                'dataProvider1' =>  $dataProvider1
            ]);
        }

        public function actionSignAuth1View($id){
         $auth1Mdl = new Auth1Model();
         $model = Termcustomers::find()->where(['ID_TERM' =>$id])->one();
        //  $employe = $model->employe;

           return $this->renderAjax('sign-auth1', [
             'model' => $model,
            //  'employe' => $employe,
             'auth1Mdl' => $auth1Mdl,
           ]);

       }

       /*
        * SIGNATURE AUTH2 | SIGN CHECKED PO
        * $poHeader->STATUS =102
        * @author ptrnov  <piter@lukison.com>
           * @since 1.1
           */
      public function actionSignAuth2View($id){
         $auth2Mdl = new Auth2Model();
         $model = Termcustomers::find()->where(['ID_TERM' =>$id])->one();
        //  $employe = $poHeader->employe;
           return $this->renderAjax('sign-auth2', [
             'model' => $model,
            //  'employe' => $employe,
             'auth2Mdl' => $auth2Mdl,
           ]);
       }

       public function actionSignAuth1Save(){
         $auth1Mdl = new Auth1Model();
         /*Ajax Load*/
         if(Yii::$app->request->isAjax){
           $auth1Mdl->load(Yii::$app->request->post());
           return Json::encode(\yii\widgets\ActiveForm::validate($auth1Mdl));
         }else{	/*Normal Load*/
           if($auth1Mdl->load(Yii::$app->request->post())){
             if ($auth1Mdl->auth1_saved()){
               $hsl = \Yii::$app->request->post();
               $kd = $hsl['Auth1Model']['id'];
               if(Yii::$app->getUserOpt->profile_user()->emp->DEP_ID == 'ACT'&&Yii::$app->getUserOpt->Modul_akses('3')->BTN_CREATE==1)
               {
                   return $this->redirect(['review-act','id'=>$kd]);
               }
               else{

                   return  $this->redirect(['view','id'=>$kd]);
               }
             }
           }
         }
      }


       public function actionSignAuth2Save(){
         $auth2Mdl = new Auth2Model();
         /*Ajax Load*/
         if(Yii::$app->request->isAjax){
           $auth2Mdl->load(Yii::$app->request->post());
           return Json::encode(\yii\widgets\ActiveForm::validate($auth2Mdl));
         }else{	/*Normal Load*/
           if($auth2Mdl->load(Yii::$app->request->post())){
             if ($auth2Mdl->auth2_saved()){
               $hsl = \Yii::$app->request->post();
               $kd = $hsl['Auth2Model']['id'];
               return $this->redirect(['review-act', 'id'=>$kd]);
             }
           }
         }
      }

      /*
       * SIGNATURE AUTH3 | SIGN APPROVAL PO
       * $poHeader->STATUS =103
       * @author ptrnov  <piter@lukison.com>
         * @since 1.1
        */
      public function actionSignAuth3View($id){
        $auth3Mdl = new Auth3Model();
        $model = Termcustomers::find()->where(['ID_TERM' =>$id])->one();
        // $employe = $poHeader->employe;
          return $this->renderAjax('sign-auth3', [
            'model' => $model,
            // 'employe' => $employe,
            'auth3Mdl' => $auth3Mdl,
          ]);
      }
      public function actionSignAuth3Save(){
        $auth3Mdl = new Auth3Model();
        /*Ajax Load*/
        if(Yii::$app->request->isAjax){
          $auth3Mdl->load(Yii::$app->request->post());
          return Json::encode(\yii\widgets\ActiveForm::validate($auth3Mdl));
        }else{	/*Normal Load*/
          if($auth3Mdl->load(Yii::$app->request->post())){
            if ($auth3Mdl->auth3_saved()){
              $hsl = \Yii::$app->request->post();
              $kd = $hsl['Auth3Model']['id'];
              return $this->redirect(['review-drc', 'id'=>$kd]);
            }
          }
        }
    }




// approved
    public function actionApprovedRoTerm()
    {
      if (Yii::$app->request->isAjax) {
  			$request= Yii::$app->request;
  			$id=$request->post('id');
  			$model = Termbudget::findOne($id);
  			$model->STATUS = 1;
  			$model->save();
  			return true;
  		}
    }

    public function actionRejectRoTerm()
    {
      if (Yii::$app->request->isAjax) {
        $request= Yii::$app->request;
        $id=$request->post('id');

      	$model = Termbudget::findOne($id);
        $model->STATUS = 3;
        //$ro->NM_BARANG=''
        $model->save();
        return true;
      }
    }

    public function actionCancel()
    {
      if (Yii::$app->request->isAjax) {
        $request= Yii::$app->request;
        $id=$request->post('id');

        $model = Termbudget::findOne($id);
        $model->STATUS = 0;
        //$ro->NM_BARANG=''
        $model->save();
        return true;
      }
    }




    public function actionViewTermCus($id)
    {

      $searchModel = new TermcustomersSearch();
      $dataProvider = $searchModel->searchcusbyid(Yii::$app->request->queryParams,$id);

      $searchModel1 = new TermbudgetSearch();
      $dataProvider1 = $searchModel1->searchbudget(Yii::$app->request->queryParams,$id);
      $sql1 = "SELECT SUM(BUDGET_ACTUAL) as Total from c0005 where  (ID_TERM='" .$id. "' AND STATUS =1) OR (STATUS =0 AND ID_TERM='" .$id. "')";
      $modelnewaprov = Yii::$app->db3->createCommand($sql1)->queryscalar();



      // $data

        return $this->render('viewterm', [
            'model' => $this->findModel($id),
            'modelnewaprov'=>$modelnewaprov,
            // 'searchModel'=>   $searchModel,
            'dataProvider' =>  $dataProvider,
            'searchModel1'=>   $searchModel1,
            'dataProvider1' =>  $dataProvider1
        ]);
    }

    public function actionViewAct($id)
    {

      $searchModel = new TermcustomersSearch();
      $dataProvider = $searchModel->searchcusbyid(Yii::$app->request->queryParams,$id);

      $searchModel1 = new TermbudgetSearch();
      $dataProvider1 = $searchModel1->searchbudget(Yii::$app->request->queryParams,$id);

      $sql = "SELECT SUM(BUDGET_PLAN) as Total from c0005 where  (ID_TERM='" .$id. "' AND STATUS =1) OR (STATUS =0 AND ID_TERM='" .$id. "')";
      $model2 = Yii::$app->db3->createCommand($sql)->queryscalar();
      $sql1 = "SELECT SUM(BUDGET_ACTUAL) as Total from c0005 where  (ID_TERM='" .$id. "' AND STATUS =1) OR (STATUS =0 AND ID_TERM='" .$id. "')";
      $modelnewaprov = Yii::$app->db3->createCommand($sql1)->queryscalar();
      // $data

        return $this->render('view-act', [
            'model' => $this->findModel($id),
            'model2'=>$model2,
            'modelnewaprov'=>$modelnewaprov,
            'dataProvider' =>  $dataProvider,
            'searchModel1'=>   $searchModel1,
            'dataProvider1' =>  $dataProvider1
        ]);
    }

    public function actionViewDrc($id)
    {

      $searchModel = new TermcustomersSearch();
      $dataProvider = $searchModel->searchcusbyid(Yii::$app->request->queryParams,$id);

      $searchModel1 = new TermbudgetSearch();
      $dataProvider1 = $searchModel1->searchbudget(Yii::$app->request->queryParams,$id);

      $sql = "SELECT SUM(BUDGET_PLAN) as Total from c0005 where  (ID_TERM='" .$id. "' AND STATUS =1) OR (STATUS =0 AND ID_TERM='" .$id. "')";
      $model2 = Yii::$app->db3->createCommand($sql)->queryscalar();
      $sql1 = "SELECT SUM(BUDGET_ACTUAL) as Total from c0005 where  (ID_TERM='" .$id. "' AND STATUS =1) OR (STATUS =0 AND ID_TERM='" .$id. "')";
      $modelnewaprov = Yii::$app->db3->createCommand($sql1)->queryscalar();
      // $data

        return $this->render('view-drc', [
            'model' => $this->findModel($id),
            'model2'=>$model2,
            'modelnewaprov'=>$modelnewaprov,
            'dataProvider' =>  $dataProvider,
            'searchModel1'=>   $searchModel1,
            'dataProvider1' =>  $dataProvider1
        ]);
    }




    public function actionValid()
    {
      # code...
      $model = new Termcustomers();
    if(Yii::$app->request->isAjax && $model->load($_POST))
    {
      Yii::$app->response->format = 'json';
      return ActiveForm::validate($model);
      }
    }




    public function actionValidInves()
    {
      # code...
      $budget = new Termbudget(['scenario'=>'insret']);
    if(Yii::$app->request->isAjax && $budget->load($_POST))
    {
      Yii::$app->response->format = 'json';
      return ActiveForm::validate($budget);
      }
    }


    public function actionPihak($id)
    {
      # code...
      $model = Termcustomers::find()->where(['ID_TERM'=>$id])->one();

      if ($model->load(Yii::$app->request->post())) {
        if($model->validate())
        {

            $model->save();
        }

        if(Yii::$app->getUserOpt->profile_user()->emp->DEP_ID == 'ACT'&& Yii::$app->getUserOpt->Modul_akses('3')->BTN_CREATE==1)
        {
            return $this->redirect(['review-act','id'=>$model->ID_TERM]);
        }
        else{

            return  $this->redirect(['view','id'=> $model->ID_TERM]);
        }

      }
      else {
          return $this->renderAjax('_pihak', [
              'model' => $model,

          ]);
      }

    }

    public function actionRabate($id)
    {
      # code...
      $model = Termcustomers::find()->where(['ID_TERM'=>$id])->one();

      if ($model->load(Yii::$app->request->post())) {
        if($model->validate())
        {

            $model->save();
        }

        if(Yii::$app->getUserOpt->profile_user()->emp->DEP_ID == 'ACT'&& Yii::$app->getUserOpt->Modul_akses('3')->BTN_CREATE==1)
        {
            return $this->redirect(['review-act','id'=>$model->ID_TERM]);
        }
        else{

            return  $this->redirect(['view','id'=> $model->ID_TERM]);
        }

      }
      else {
          return $this->renderAjax('_rabate', [
              'model' => $model,

          ]);
      }

    }



    public function actionGrowth($id)
    {
      # code...
      $model = Termcustomers::find()->where(['ID_TERM'=>$id])->one();

      if ($model->load(Yii::$app->request->post())) {
        if($model->validate())
        {

            $model->save();
        }

        if(Yii::$app->getUserOpt->profile_user()->emp->DEP_ID == 'ACT'&& Yii::$app->getUserOpt->Modul_akses('3')->BTN_CREATE==1)
        {
            return $this->redirect(['review-act','id'=>$model->ID_TERM]);
        }
        else{

            return  $this->redirect(['view','id'=> $model->ID_TERM]);
        }

      }
      else {
          return $this->renderAjax('growth', [
              'model' => $model,

          ]);
      }

    }




    public function actionPeriode($id)
    {
      # code...
        $model = Termcustomers::find()->where(['ID_TERM'=>$id])->one();
        if ($model->load(Yii::$app->request->post())) {

          $tanggal = \Yii::$app->formatter->asDate($model->PERIOD_START,'Y-M-d');
          $tanggalend = \Yii::$app->formatter->asDate($model->PERIOD_END,'Y-M-d');
          $model->PERIOD_START = $tanggal;
          $model->PERIOD_END = $tanggalend;

          if($model->validate())
          {

              $model->save();
          }

        if(Yii::$app->getUserOpt->profile_user()->emp->DEP_ID == 'ACT'&&Yii::$app->getUserOpt->Modul_akses('3')->BTN_CREATE==1)
        {
            return $this->redirect(['review-act','id'=>$model->ID_TERM]);
        }
        else{

            return  $this->redirect(['view','id'=> $model->ID_TERM]);
        }


        }
        else {
            return $this->renderAjax('_periode', [
                'model' => $model,

            ]);
        }
    }



    public function actionTop($id)
    {
      # code...
        $model = Termcustomers::find()->where(['ID_TERM'=>$id])->one();
        $post = Yii::$app->request->post();

        if ($model->load(Yii::$app->request->post())) {
          $datatop = $post['Termcustomers']['term'];

           $datasavetop = $datatop != "Potong Tagihan" ?  "Transfer ".$model->TOP : "Potong Tagihan";
           $model->TOP = $datasavetop;
          if($model->validate())
          {

              $model->save();
          }

          if(Yii::$app->getUserOpt->profile_user()->emp->DEP_ID == 'ACT'&& Yii::$app->getUserOpt->Modul_akses('3')->BTN_CREATE==1)
          {
              return $this->redirect(['review-act','id'=>$model->ID_TERM]);
          }
          else{

              return  $this->redirect(['view','id'=> $model->ID_TERM]);
          }

        }
        else {
            return $this->renderAjax('_top', [
                'model' => $model,

            ]);
        }
    }





    public function actionTarget($id)
    {
      # code...
        $model = Termcustomers::find()->where(['ID_TERM'=>$id])->one();
        if ($model->load(Yii::$app->request->post())) {
          $model->TARGET_TEXT =  Yii::$app->mastercode->terbilang($model->TARGET_VALUE);
          if($model->validate())
          {

              $model->save();
          }

          if(Yii::$app->getUserOpt->profile_user()->emp->DEP_ID == 'ACT' && Yii::$app->getUserOpt->Modul_akses('3')->BTN_CREATE==1)
          {
              return $this->redirect(['review-act','id'=>$model->ID_TERM]);
          }
          else{

              return  $this->redirect(['view','id'=> $model->ID_TERM]);
          }

        }
        else {
            return $this->renderAjax('target', [
                'model' => $model,

            ]);
        }
    }




    public function actionCreateBudget($id)
    {
      # code...
        $budget = new  Termbudget();
        $profile= Yii::$app->getUserOpt->Profile_user();

        if ($budget->load(Yii::$app->request->post())) {


          $budget->CORP_ID = $profile->emp->EMP_CORP_ID;
          $tanggal = \Yii::$app->formatter->asDate($budget->PERIODE_START,'Y-M-d');
          $tanggalend = \Yii::$app->formatter->asDate($budget->PERIODE_END,'Y-M-d');
          $budget->PERIODE_START = $tanggal;
          $budget->PERIODE_END = $tanggalend;
          if($budget->validate())
          {

            $budget->CREATE_AT = date("Y-m-d H:i:s");
            $budget->CREATE_BY = Yii::$app->user->identity->username;
            $budget->save();

          }

            return $this->redirect(['view','id'=>$budget->ID_TERM]);

        }
        else {
            return $this->renderAjax('budget', [
                'budget' => $budget,
                'id'=>$id

            ]);
        }

    }

    public function actionCreateBudgetAct($id)
    {
      # code...
        $budget = new  Termbudget();
        $profile= Yii::$app->getUserOpt->Profile_user();

        if ($budget->load(Yii::$app->request->post())) {


          $budget->CORP_ID = $profile->emp->EMP_CORP_ID;
          $tanggal = \Yii::$app->formatter->asDate($budget->PERIODE_START,'Y-M-d');
          $tanggalend = \Yii::$app->formatter->asDate($budget->PERIODE_END,'Y-M-d');
          $budget->PERIODE_START = $tanggal;
          $budget->PERIODE_END = $tanggalend;
          if($budget->validate())
          {

            $budget->CREATE_AT = date("Y-m-d H:i:s");
            $budget->CREATE_BY = Yii::$app->user->identity->username;
            $budget->save();

          }

            return $this->redirect(['review-act','id'=>$budget->ID_TERM]);

        }
        else {
            return $this->renderAjax('budget', [
                'budget' => $budget,
                'id'=>$id

            ]);
        }

    }


    public function actionCetakpdfAct($id)
    {
      # code...
      $data = Termcustomers::find()->where(['ID_TERM'=>$id])->one();
      $datainternal = Jobgrade::find()->where(['JOBGRADE_ID'=>$data['JOBGRADE_ID']])->asArray()
                                                                                    ->one();
      $datacus = Customers::find()->where(['CUST_KD'=> $data->CUST_KD])
                              ->asArray()
                              ->one();

      // $term = Termgeneral::find()->where(['ID'=>$data['GENERAL_TERM']])->asArray()
      //                                                     ->one();

      $datadis = Distributor::find()->where(['KD_DISTRIBUTOR'=> $data->DIST_KD])
                                    ->asArray()
                                    ->one();
      $datacorp = Corp::find()->where(['CORP_ID'=> $data->PRINCIPAL_KD])
                                                                  ->asArray()
                                                                  ->one();
      $sql = "SELECT c.INVES_TYPE,c.ID_TERM,c.BUDGET_PLAN,c.BUDGET_ACTUAL,c.PERIODE_START,c.PERIODE_END,b.TARGET_VALUE from c0005 c LEFT JOIN c0003 b on c.ID_TERM = b.ID_TERM   where c.ID_TERM='".$id."'";
      $data1 = Termbudget::findBySql($sql)->all();
      $sqlsum = "SELECT SUM(BUDGET_PLAN) as BUDGET_PLAN,SUM(BUDGET_ACTUAL) as BUDGET_ACTUAL from c0005 where ID_TERM='".$id."'";
      $datasum = Termbudget::findBySql($sqlsum)->one();
      $sql1 = "SELECT SUM(BUDGET_ACTUAL) as Total from c0005 where  (ID_TERM='" .$id. "' AND STATUS =1) OR (STATUS =0 AND ID_TERM='" .$id. "')";
      $modelnewaprov = Yii::$app->db3->createCommand($sql1)->queryscalar();

     $dataProvider = new ArrayDataProvider([
       'key' => 'ID_TERM',
       'allModels'=>$data1,
       'pagination' => [
         'pageSize' => 20,
       ],
        ]);

      $content = $this->renderPartial( '_pdf_act', [
        'data' => $data,
        'datainternal'=>$datainternal,
        'datacus'=>  $datacus,
        'datadis'=>$datadis,
        'datacorp'=>$datacorp,
        // 'term'=>$term,
        'datasum'=>$datasum,
        'dataProvider'=>$dataProvider,
        'modelnewaprov'=>$modelnewaprov

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
        'options' => ['title' => 'Term-Customers','subject'=>'Term'],
         // call mPDF methods on the fly
        'methods' => [
          'SetHeader'=>['Copyright@LukisonGroup '.date("r")],
          'SetFooter'=>['{PAGENO}'],
        ]
      ]);
      return $pdf->render();
    }



    public function actionCetakpdf($id)
    {
      # code...
      $data = Termcustomers::find()->where(['ID_TERM'=>$id])->one();
      $datainternal = Jobgrade::find()->where(['JOBGRADE_ID'=>$data['JOBGRADE_ID']])->asArray()
                                                                                    ->one();
      $datacus = Customers::find()->where(['CUST_KD'=> $data->CUST_KD])
                              ->asArray()
                              ->one();

      // $term = Termgeneral::find()->where(['ID'=>$data['GENERAL_TERM']])->asArray()
      //                                                     ->one();

      $datadis = Distributor::find()->where(['KD_DISTRIBUTOR'=> $data->DIST_KD])
                                    ->asArray()
                                    ->one();
      $datacorp = Corp::find()->where(['CORP_ID'=> $data->PRINCIPAL_KD])
                                                                  ->asArray()
                                                                  ->one();
      $sql = "SELECT c.INVES_TYPE,c.ID_TERM,c.BUDGET_PLAN,c.BUDGET_ACTUAL,c.PERIODE_START,c.PERIODE_END,b.TARGET_VALUE from c0005 c LEFT JOIN c0003 b on c.ID_TERM = b.ID_TERM   where c.ID_TERM='".$id."'";
      $data1 = Termbudget::findBySql($sql)->all();
      $sqlsum = "SELECT SUM(BUDGET_PLAN) as BUDGET_PLAN,SUM(BUDGET_ACTUAL) as BUDGET_ACTUAL from c0005 where ID_TERM='".$id."'";
      $datasum = Termbudget::findBySql($sqlsum)->one();

     $dataProvider = new ArrayDataProvider([
       'key' => 'ID_TERM',
       'allModels'=>$data1,
       'pagination' => [
         'pageSize' => 20,
       ],
        ]);

      $content = $this->renderPartial( '_pdf', [
        'data' => $data,
        'datainternal'=>$datainternal,
        'datacus'=>  $datacus,
        'datadis'=>$datadis,
        'datacorp'=>$datacorp,
        // 'term'=>$term,
        'datasum'=>$datasum,
        'dataProvider'=>$dataProvider

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
        'options' => ['title' => 'Term-Customers','subject'=>'Term'],
         // call mPDF methods on the fly
        'methods' => [
          'SetHeader'=>['Copyright@LukisonGroup '.date("r")],
          'SetFooter'=>['{PAGENO}'],
        ]
      ]);
      return $pdf->render();
    }



    /**
     * Creates a new Termcustomers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Termcustomers();

        if ($model->load(Yii::$app->request->post())) {
          $model->ID_TERM = Yii::$app->ambilkonci->getkdTerm();
          if($model->validate())
          {
              $model->CREATED_AT = date("Y-m-d H:i:s");
              $model->CREATED_BY = Yii::$app->user->identity->username;
              $model->save();

          }
            return $this->redirect(['view','id'=>$model->ID_TERM]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateAct()
    {

        $model = new Termcustomers();

        if ($model->load(Yii::$app->request->post())) {
          $model->ID_TERM = Yii::$app->ambilkonci->getkdTerm();
          if($model->validate())
          {
              $model->CREATED_AT = date("Y-m-d H:i:s");
              $model->CREATED_BY = Yii::$app->user->identity->username;
              $model->save();

          }
            return $this->redirect(['review-act','id'=>$model->ID_TERM]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Updates an existing Termcustomers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
          if($model->validate())
  				{
  					  $model->UPDATED_AT = date("Y-m-d H:i:s");
  						$model->UPDATED_BY = Yii::$app->user->identity->username;
              $model->save();
          }
            return $this->redirect(['view', 'id' => $model->ID_TERM]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionPpn($id)
    {
        $Model = $this->findModelbudget($id);
        if ($Model->load(Yii::$app->request->post())) {
          if($Model->validate())
  				{

              $Model->save();

          }
            return $this->redirect(['review-act', 'id' => $Model->ID_TERM]);
        } else {
            return $this->renderAjax('ppn', [
                'Model' => $Model,
            ]);
        }

    }

    public function actionPph($id)
    {
        $Model = $this->findModelbudget($id);

        if ($Model->load(Yii::$app->request->post())) {
          $checkbox = Yii::$app->request->post('pph');
          if($checkbox == 1)
          {
            $Model->PPH23 = 0.00;
          }
          if($Model->validate())
          {

              $Model->save();
              // print_r  ($Model->save());
              // die();
          }
            return $this->redirect(['review-act', 'id' => $Model->ID_TERM]);
        } else {
            return $this->renderAjax('pph', [
                'Model' => $Model,
            ]);
        }

    }





    /**
     * Deletes an existing Termcustomers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();
    //
    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the Termcustomers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Termcustomers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     protected function findModelbudget($id)
     {
         if (($Model = Termbudget::find()->where(['ID_TERM'=>$id])->one()) !== null) {
             return $Model;
         } else {
             throw new NotFoundHttpException('The requested page does not exist.');
         }
     }

    protected function findModel($id)
    {
        if (($model = Termcustomers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
