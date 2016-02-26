<?php

namespace lukisongroup\master\controllers;

use Yii;
use lukisongroup\master\models\Termcustomers;
use lukisongroup\hrd\models\Jobgrade;
use lukisongroup\master\models\Termgeneral;
use lukisongroup\master\models\Terminvest;
use lukisongroup\master\models\TermbudgetSearch;
use lukisongroup\master\models\Termbudget;
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

    /**
     * Lists all Termcustomers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TermcustomersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Termcustomers model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

      $searchModel = new TermcustomersSearch();
      $dataProvider = $searchModel->searchcusbyid(Yii::$app->request->queryParams,$id);

      $searchModel1 = new TermbudgetSearch();
      $dataProvider1 = $searchModel1->searchbudget(Yii::$app->request->queryParams,$id);


      // $data

        return $this->render('view', [
            'model' => $this->findModel($id),
            // 'searchModel'=>   $searchModel,
            'dataProvider' =>  $dataProvider,
            'searchModel1'=>   $searchModel1,
            'dataProvider1' =>  $dataProvider1
        ]);
    }

    public function actionViewTermCus($id)
    {

      $searchModel = new TermcustomersSearch();
      $dataProvider = $searchModel->searchcusbyid(Yii::$app->request->queryParams,$id);

      $searchModel1 = new TermbudgetSearch();
      $dataProvider1 = $searchModel1->searchbudget(Yii::$app->request->queryParams,$id);


      // $data

        return $this->render('viewterm', [
            'model' => $this->findModel($id),
            // 'searchModel'=>   $searchModel,
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
      $budget = new Termbudget();
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

      return  $this->redirect(['view','id'=> $model->ID_TERM]);

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

      return  $this->redirect(['view','id'=> $model->ID_TERM]);

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

      return  $this->redirect(['view','id'=> $model->ID_TERM]);

      }
      else {
          return $this->renderAjax('growth', [
              'model' => $model,

          ]);
      }

    }

    public function actionSetInternal($id)
    {
      # code...
      $model = Termcustomers::find()->where(['ID_TERM'=>$id])->one();

      if ($model->load(Yii::$app->request->post())) {
        if($model->validate())
        {

            $model->save();
        }

      return  $this->redirect(['view','id'=> $model->ID_TERM]);

      }
      else {
          return $this->renderAjax('_ttd', [
              'model' => $model,

          ]);
      }

    }

    public function actionSetCus($id)
    {
      # code...
      $model = Termcustomers::find()->where(['ID_TERM'=>$id])->one();

      if ($model->load(Yii::$app->request->post())) {
        if($model->validate())
        {

            $model->save();
        }

      return  $this->redirect(['view','id'=> $model->ID_TERM]);

      }
      else {
          return $this->renderAjax('_ttd2', [
              'model' => $model,

          ]);
      }

    }

    public function actionSetDist($id)
    {
      # code...
      $model = Termcustomers::find()->where(['ID_TERM'=>$id])->one();

      if ($model->load(Yii::$app->request->post())) {
        if($model->validate())
        {

            $model->save();
        }

      return  $this->redirect(['view','id'=> $model->ID_TERM]);

      }
      else {
          return $this->renderAjax('ttd3', [
              'model' => $model,

          ]);
      }

    }



    public function actionPeriode($id)
    {
      # code...
        $model = Termcustomers::find()->where(['ID_TERM'=>$id])->one();
        if ($model->load(Yii::$app->request->post())) {
          if($model->validate())
          {

              $model->save();
          }

        return  $this->redirect(['view','id'=> $model->ID_TERM]);

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

        if ($model->load(Yii::$app->request->post())) {
          if($model->validate())
          {

              $model->save();
          }


        return  $this->redirect(['view','id'=> $model->ID_TERM]);

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

        return  $this->redirect(['view','id'=> $model->ID_TERM]);

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
          if($budget->validate())
          {
            $budget->CREATE_AT = date("Y-m-d H:i:s");
            $budget->CREATE_BY = Yii::$app->user->identity->username;
            $budget->save();

          }
          // print_r($model->getErrors());
        //  die();

            return $this->redirect(['view','id'=>$budget->ID_TERM]);

        }
        else {
            return $this->renderAjax('budget', [
                'budget' => $budget,
                'id'=>$id

            ]);
        }

    }

    public function actionCreateGeneral($id)
    {
      # code...
        $model = Termcustomers::find()->where(['ID_TERM'=>$id])->one();

        if ($model->load(Yii::$app->request->post())) {

          if($model->validate())
          {

            $model->save();


          }
        //   print_r($model->getErrors());
        //  die();

            return $this->redirect(['view','id'=>$id]);

        }
        else {
            return $this->renderAjax('term', [
                'model' => $model,


            ]);
        }

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

      $term = Termgeneral::find()->where(['ID'=>$data['GENERAL_TERM']])->asArray()
                                                          ->one();

      $datadis = Distributor::find()->where(['KD_DISTRIBUTOR'=> $data->DIST_KD])
                                    ->asArray()
                                    ->one();
      $datacorp = Corp::find()->where(['CORP_ID'=> $data->PRINCIPAL_KD])
                                                                  ->asArray()
                                                                  ->one();
      $sql = "SELECT c.INVES_TYPE,c.ID_TERM,c.BUDGET_VALUE,c.PERIODE_START,c.PERIODE_END,b.TARGET_VALUE from c0005 c LEFT JOIN c0003 b on c.ID_TERM = b.ID_TERM   where c.ID_TERM='".$id."'";
      $data1 = Termbudget::findBySql($sql)->all();
      $sqlsum = "SELECT SUM(BUDGET_VALUE) as BUDGET_VALUE from c0005 where ID_TERM='".$id."'";
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
        'term'=>$term,
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

    /**
     * Deletes an existing Termcustomers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Termcustomers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Termcustomers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Termcustomers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
