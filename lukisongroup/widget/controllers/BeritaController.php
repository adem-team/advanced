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

/* namespace models */
use lukisongroup\widget\models\Berita;
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
     * @param integer $ID
     * @param string $KD_BERITA
     * @return mixed
     */
    public function actionDetailBerita($KD_BERITA)
    {
      $model = Berita::find()->where(['KD_BERITA' => $KD_BERITA])->one();
        return $this->render('view_detailberita', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Berita model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Berita();

        /* data departement using select 2 */
        $datadep = ArrayHelper::map(Dept::find()->where('DEP_STS <>3')->asArray()->all(), 'DEP_ID', 'DEP_NM');

        /* componen user */
        $profile = Yii::$app->getUserOpt->profile_user()->emp;
        $emp_img = $profile->EMP_IMG;
        if ($model->load(Yii::$app->request->post())) {
          $post = Yii::$app->request->post();
          $checkbox = $post['Berita']['alluser'];

          /* generate kode berita*/
          $GneratekodeBerita=\Yii::$app->ambilkonci->getBeritaCode();

          $model->KD_BERITA = $GneratekodeBerita;
          //componen
          $model->KD_CORP =  	Yii::$app->getUserOpt->Profile_user()->emp->EMP_CORP_ID;
		      $model->KD_DEP = 	 Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;
	        $model->CREATED_BY = Yii::$app->user->identity->EMP_ID;
          if($checkbox == 1)
          {
            $employe = employe::find()->where('STATUS<>3')->all();
            foreach ($employe as $key => $value) {
              # code...
              $connection = Yii::$app->db_widget;
              $connection->createCommand()->batchInsert('bt0001',['KD_BERITA','JUDUL','ISI','KD_CORP','KD_DEP','CREATED_BY','USER_CC'],[[$model->KD_BERITA,$model->JUDUL,$model->ISI,$model->KD_CORP,$model->KD_DEP,$model->CREATED_BY,$value['EMP_ID']]])->execute();
                 }
            }else{
                $model->save();
            }
			       return $this->redirect(['detail-berita', 'ID' => $model->ID, 'KD_BERITA' => $model->KD_BERITA]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'datadep'=>$datadep,
                'emp_img'=>$emp_img,
            ]);
        }
    }

    public function actionJoinComment($KD_BERITA)
    {
        $model = new Commentberita();

        /* componen user */
        $profile = Yii::$app->getUserOpt->profile_user()->emp;
        $emp_img = $profile->EMP_IMG;
        if ($model->load(Yii::$app->request->post())) {
          $model->KD_BERITA = $KD_BERITA;
          $model->EMP_IMG = $emp_img;

          //componen
          $model->ID_USER = Yii::$app->user->identity->id;
		      $model->CREATED_AT = date('Y-m-d h:i:s');
	        $model->CREATED_BY = Yii::$app->user->identity->EMP_ID;
		      $model->save();
			    return $this->redirect(['detail-berita','KD_BERITA' => $model->KD_BERITA]);
        } else {
            return $this->renderAjax('commentar', [
                'model' => $model,
                'emp_img'=>$emp_img
            ]);
        }
    }




    public function actionValidBeritaAcara()
    {
      # code...
        $model = new Berita();
      if(Yii::$app->request->isAjax && $model->load($_POST))
      {
        Yii::$app->response->format = 'json';
        return ActiveForm::validate($model);
      }
    }

    /**
     * Updates an existing Berita model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $ID
     * @param string $KD_BERITA
     * @return mixed
     */
    public function actionUpdate($ID, $KD_BERITA)
    {
        $model = $this->findModel($ID, $KD_BERITA);

        if ($model->load(Yii::$app->request->post()) ) {

			$model->UPDATE_AT = date('Y-m-d h:i:s');

			 $model->save();
            return $this->redirect(['view', 'ID' => $model->ID, 'KD_BERITA' => $model->KD_BERITA]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

/* get user cc usage depdrop */
    public function getusercc($id)
    {
          $out = [];
          $model = Employe::find()->asArray()
                                  ->where(['DEP_ID'=>$id])
                                  ->andwhere('STATUS<>3')
                                  ->all();
          foreach ($model as $key => $value) {
                $out[] = ['id'=>$value['EMP_ID'],'name'=> $value['EMP_NM']];
         }
         return $out;
    }

/* depdrop author : wawan*/
    public function actionCariUserBerita() {

    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $id = $parents[0];
             $out = $this->getusercc($id); //call function getusercc
            echo Json::encode(['output'=>$out, 'selected'=>'']);
            return;
        }
    }
    echo Json::encode(['output'=>'', 'selected'=>'']);
}




    /**
     * Deletes an existing Berita model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $ID
     * @param string $KD_BERITA
     * @return mixed
     */
    public function actionDelete($ID, $KD_BERITA)
    {
        $this->findModel($ID, $KD_BERITA)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Berita model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID
     * @param string $KD_BERITA
     * @return Berita the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($KD_BERITA)
    {
        if (($model = Berita::find()->where(['KD_BERITA' => $KD_BERITA])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
