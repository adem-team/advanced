<<<<<<< HEAD
<?php
/*
 * Login Dashboard user Permission
 * login user account berdasarkan POSITION_LOGIN
 * 0 = Salesman
 * 1 = SPG
 * 2 = Customer
 * 3 = Distributor
 * 4 = Factory/Pabrik
 * Logic if (POSITION_LOGIN==1){}
*/

//include('_index_salespromo.php');
//include('_index_salesman.php');
include('_index_customer.php');

=======
<?php
use crm\sistem\models\Userlogin;
/*
 * Login Dashboard user Permission
 * login user account berdasarkan POSITION_LOGIN
 * 1 = Salesman
 * 2 = SPG
 * 3 = Customer
 * 4 = Distributor
 * 5 = Factory/Pabrik
 * 6 = Outsorce
 * Logic if (POSITION_LOGIN==1){}
*/

/* $model = Userlogin::findOne(Yii::$app->user->identity->id); */
 $model=Yii::$app->getUserOptcrm->Profile_user();
 //print_r($model);
if (count($model)<>0){
	//$Val_Corp='none'
	if($model->POSITION_LOGIN==1){
		include('_index_salesman.php');		
	}elseif($model->POSITION_LOGIN==2){
		include('_index_salespromo.php');
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

>>>>>>> de7b95f53371a993771ac5a9bf7486f67cd4d60d
?>