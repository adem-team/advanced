<?php

namespace lukisongroup\widget\controllers;

use Yii;
use lukisongroup\widget\models\Chatroom;
use lukisongroup\widget\models\ChatroomSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChatroomController implements the CRUD actions for Chatroom model.
 */
class ChatroomController extends Controller
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
     * Lists all Chatroom models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChatroomSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Chatroom model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Chatroom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   public function actionCreate()
    {
        $model = new Chatroom();

        if ($model->load(Yii::$app->request->post())) {
            $model->PARENT = 0 ;
            $sql = Chatroom::find()->count();
            $model->SORT = $sql+1;
           
            
            $query = Chatroom::find()->select('GROUP_ID')->orderBy(['GROUP_ID'=>SORT_DESC])
            						  ->one();
            						 
            						 
            $baris = count($query);

			

                    if( $baris == 0)
                    { 
                        $nomerkd = 1; 
                    }
                    else{
                        $kd = explode('.',$query->GROUP_ID);
                        $nomerkd = $kd[1]+1;
                        
                    }
                  
             $digit = str_pad( $nomerkd, 3, 0, STR_PAD_LEFT );
             $kode = 'G'.'.'.$digit;
             $model->GROUP_ID = $kode; 
             $model->save();
            return $this->redirect('index');
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }
	
	 /**
     * Creates a new member.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    public function actionCreatemember($id)
    {
        $model = new Chatroom();
        
        if($model->load(Yii::$app->request->post()))
        {
            $model->SORT = $id;
			$model->PARENT = $id;
            $model->save();
            
         return $this->redirect('index');
            
        }
        else{
             return $this->renderAjax('_formmember', [
                'model' => $model,
            ]);
        }
        
    }
    

    /**
     * Updates an existing Chatroom model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
			
			
			 $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Chatroom model.
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
     * Finds the Chatroom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chatroom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chatroom::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
