<?php

namespace lukisongroup\master\controllers;

use Yii;
use lukisongroup\master\models\SopSalesHeader;
use lukisongroup\master\models\SopSalesDetail;
use lukisongroup\master\models\SopSalesType;
use lukisongroup\master\models\Kategoricus;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\master\models\SopSalesHeaderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\helpers\Json;

/**
 * SopSalesController implements the CRUD actions for SopSalesHeader model.
 */
class SopSalesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

        /**
     * Before Action Index
     * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
    public function beforeAction($action){
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
     * Lists all SopSalesHeader models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SopSalesHeaderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

          if(Yii::$app->request->post('hasEditable'))
        {
            $ID = \Yii::$app->request->post('editableKey');
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = SopSalesHeader::findOne($ID);
           
            $out = Json::encode(['output'=>'', 'message'=>'']);

            // fetch the first entry in posted data (there should
            // only be one entry anyway in this array for an
            // editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $post = [];
            $posted = current($_POST['SopSalesHeader']);
            $post['SopSalesHeader'] = $posted;


            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model


                // custom output to return to be displayed as the editable grid cell
                // data. Normally this is empty - whereby whatever value is edited by
                // in the input by user is updated automatically.
                $output = '';
         
          
            if (isset($posted['TGL'])) {
    
                    $model->save();
                    $output = $model->TGL;
                }
                if (isset($posted['BOBOT_PERCENT'])) {
                    $model->save();
                    $output = $model->BOBOT_PERCENT;                 
                }
                if (isset($posted['TARGET_MONTH'])) {
                    $model->save();

               
                    $output = $model->TARGET_MONTH;                  
                }
                if (isset($posted['TARGET_DAY'])) {
                    $model->save();
                    $output = $model->TARGET_DAY;                 
                }
                if (isset($posted['TARGET_UNIT'])) {
                    $model->save();
                    $output = $model->TARGET_DAY;                 
                }
                if (isset($posted['TTL_DAYS'])) {
                    $model->save();
                    $output = $model->TTL_DAYS;                 
                }

        }
    
              

                // specific use case where you need to validate a specific
                // editable column posted when you have more than one
                // EditableColumn in the grid view. We evaluate here a
                // check to see if buy_amount was posted for the Book model
                // similarly you can check if the name attribute was posted as well

                $out = Json::encode(['output'=>$output, 'message'=>'']);


            // return ajax json encoded response and exit
            echo $out;

            return;
          }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
             'unit'=>self::ary_unit(),
             'typesales'=>self::ary_typesales(),
             'child'=>self::ary_child(),
        ]);
    }

    public function ary_typesales(){
        return ArrayHelper::map(SopSalesType::find()->all(), 'SOP_TYPE','SOP_NM');
    }

    public function ary_parent(){
        return ArrayHelper::map(Kategoricus::find()->where('CUST_KTG = CUST_KTG_PARENT')->all(), 'CUST_KTG','CUST_KTG_NM');
    }
     public function ary_child(){
        return ArrayHelper::map(Kategoricus::find()->where('CUST_KTG <> CUST_KTG_PARENT')->all(), 'CUST_KTG','CUST_KTG_NM');
    }

    


    /**
     * Depdrop Kategoricus
     * @author wawan
     * @since 1.1.0
     * @return mixed
     */
   public function actionLisdata() {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $id = $parents[0];

            $model = Kategoricus::find()->asArray()->where(['CUST_KTG_PARENT'=>$id])
                                                     ->andwhere('CUST_KTG_PARENT <> CUST_KTG')
                                                    ->all();
                                                    // print_r($model);
                                                    // die();
            //$out = self::getSubCatList($cat_id);
            // the getSubCatList function will query the database based on the
            // cat_id and return an array like below:
            // [
            //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
            //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
            // ]
            foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['CUST_KTG_NM'],'name'=> $value['CUST_KTG_NM']];
               }

               echo json_encode(['output'=>$out, 'selected'=>'']);
               return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
   }

    /**
     * Displays a single SopSalesHeader model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SopSalesHeader model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SopSalesHeader();

        if ($model->load(Yii::$app->request->post())) {
            $tgl = $model->TGL!= '' ? $model->TGL : Yii::$app->formatter->asDate('now', 'php:Y-m-d');;
             $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'data_type_sales'=>self::ary_typesales(),
                'data_parent_kategori'=>self::ary_parent()
            ]);
        }
    }

    public function ary_scoreresult(){
        $score = [
            ['nilai' => 1,'score'=>'0-80'],
            ['nilai' => 2,'score'=>'81-90'],
            ['nilai' => 3,'score'=>'91-100'],

        ];
         return ArrayHelper::map($score, 'nilai','score');
    }

    public function ary_unit(){
      return ArrayHelper::map(Unitbarang::find()->all(), 'NM_UNIT','NM_UNIT'); 
    }

    /**
     * Creates a new SopSalesHeader model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateDetailSop($id)
    {
        $model = new SopSalesDetail();

        if ($model->load(Yii::$app->request->post())) {
            $model->CREATE_BY = Yii::$app->user->identity->username;
            $model->CREATE_AT = date("Y-m-d H:i:s");
            $model->SOP_ID = $id;
             $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create_sop_detail', [
                'model' => $model,
                'score'=>self::ary_scoreresult(),
               
            ]);
        }
    }

    /**
     * Updates an existing SopSalesHeader model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing SopSalesHeader model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActivHeader($id)
    {
        $model = $this->findModel($id);

        $model->STT_DEFAULT = 1;

        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SopSalesHeader model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SopSalesHeader the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SopSalesHeader::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
