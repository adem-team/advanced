<?php

namespace lukisongroup\warehouse\controllers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;


use lukisongroup\warehouse\models\MssqlRcvd;

class DefaultController extends Controller
{
    public function actionIndex()
    {
		/* $model1 = MssqlRcvd::find()->asArray()->All();
		$model2 = MssqlRcvd::find()->asArray()->where(['ID'=>'1'])->All();
		$model3 = MssqlRcvd::find();
		
		//$model4 = MssqlRcvd::find()->where(['ID'=>'1'])->All(); //Error
		//$model5 = MssqlRcvd::find()->All();					//Error
		
		$sql = 'SELECT * FROM [sss].db_test';
		$model7 = MssqlRcvd::findBySql($sql)->asArray()->All();
		$model8 = MssqlRcvd::findBySql($sql)->asArray()->One();	
		
		$model9 = MssqlRcvd::find()->asArray()->One();	
		$model10=Yii::$app->mssql_ft->createCommand("select * from sss.db_test")->queryAll();
		//Procedure.
		$model11=Yii::$app->mssql_ft->createCommand("EXEC sss.test")->queryAll();
		print_r($model11); */
		
		
		
        //	return $this->render('index');
		//$model = $this->findModel('1');
		// print_r($model);
		
		/* $query = new Query;
		// compose the query
		$query->select('ID, NAMA')
			->from('ms')
			->limit(10);
		// build and execute the query
		$rows = $query->all(); */
		
		// $sql = 'SELECT * FROM ms';
		//$model = MssqlRcvd::findBySql($sql)->one();  
    }
	
	
	public function actionMssql()
    {
		$model1 = MssqlRcvd::find()->asArray()->All();
		$model2 = MssqlRcvd::find()->asArray()->where(['ID'=>'1'])->All();
		$model3 = MssqlRcvd::find();
		
		//$model4 = MssqlRcvd::find()->where(['ID'=>'1'])->All(); //Error
		//$model5 = MssqlRcvd::find()->All();					//Error
		
		$sql = 'SELECT * FROM [sss].db_test';
		$model7 = MssqlRcvd::findBySql($sql)->asArray()->All();
		$model8 = MssqlRcvd::findBySql($sql)->asArray()->One();	
		
		$model9 = MssqlRcvd::find()->asArray()->One();	
		$model10=Yii::$app->mssql_ft->createCommand("select * from sss.db_test")->queryAll();
		//Procedure.
		$model11=Yii::$app->mssql_ft->createCommand("EXEC sss.test")->queryAll();
		print_r($model11);
	}
	
	 /**
     * Finds the HeaderDetailRcvd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HeaderDetailRcvd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MssqlRcvd::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    } 
}
