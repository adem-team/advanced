<?php
use \Yii;
use dashboard\sistem\models\Userlogin;
/*
 * Login Dashboard user Permission
 * login user account berdasarkan POSITION_LOGIN
 * 1 = PT. Efenbi Sukses Makmur
 * 2 = PT. Sarana Sinar Surya
 * 3 = Customer
 * 4 = Distributor
 * 5 = Factory/Pabrik
 * 6 = Outsorce
 * Logic if (POSITION_LOGIN==1){}
*/

/* $model = Userlogin::findOne(Yii::$app->user->identity->id); */
 $model=Yii::$app->getUserDashBoard->Profile_user();
 //print_r($model);
if (count($model)<>0){
	//$Val_Corp='none'
	if($model->POSITION_LOGIN==1){
		include('_index_efembi.php');
		//Yii::$app->controller->redirect('/efenbi/report');
		//Yii::$app->controller->redirect('_index_efembi.php');


		
	}elseif($model->POSITION_LOGIN==2){
		include('_index_foodtown.php');
	}elseif($model->POSITION_LOGIN==3){
		include('_index_customer.php');
	}elseif($model->POSITION_LOGIN==4){
		include('_index_distributor.php');
	}elseif($model->POSITION_LOGIN==5){
		include('_index_factory.php');
	}elseif($model->POSITION_LOGIN==6){
		include('_index_outsource.php');
	}
}

//include('_index_salespromo.php');
//include('_index_salesman.php');
//include('_index_customer.php');

?>