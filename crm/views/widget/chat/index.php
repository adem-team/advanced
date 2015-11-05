<?php
use Yii;
use lukisongroup\assets\AppAssetChating;  	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
AppAssetChating::register($this);

//$this->sideCorp = 'LG Widget';                                   /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = $ctrl_chat;                           /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Chating');     			/* title pada header page */
$this->params['breadcrumbs'][] = $this->title;          /* belum di gunakan karena sudah ada list sidemenu, on plan next*/
/*
	$form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]);

	$coba= DetailView::widget([
		'model' => $model,
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'panel'=>[
			'heading'=>$model->EMP_NM . ' '.$model->EMP_NM_BLK,
			'type'=>DetailView::TYPE_INFO,
		],	
		
			'attributes'=>['EMP_ID',],
		
		
		'deleteOptions'=>[
			'url'=>['delete', 'id' => $model->EMP_ID],
			'data'=>[
				'confirm'=>Yii::t('app', 'Are you sure you want to delete this record?'),
				'method'=>'post',
			],
		],
		
	]);		
ActiveForm::end();
	
    Modal::begin([
        'id' => 'chating',
        'header' => '<h4>Hello world</h4>'
    ]);
	
	        echo $coba;
		
    Modal::end();
 
 */
?>

<div class="container" ng-app="app">

<div  ng-controller="Shell1" ng-init="userInit(uid='piter','123')">
	
		<div class="chat-container" ng-controller="Shell as vm">
		<irontec-simple-chat
			messages="vm.messages"
			username="vm.username"
			input-placeholder-text="You can write here"
			submit-button-text="Send your message"
			title="Lukisongroup Chating"
			theme="material"
			submit-function="vm.sendMessage"
			visible="true">
		</irontec-simple-chat>
	  </div>
	
</div>
</div>
