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

<div class="container-fluid" >
	<div class="row">
		<div class="col-dm-12" ng-app="app">
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
		<!-- Chat box -->
		<div class="col-lg-9">
			<!-- Chat box -->
			  <div class="box box-success">
				<div class="box-header">
				  <i class="fa fa-comments-o"></i>

				  <h3 class="box-title">Chat</h3>

				  <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
					<div class="btn-group" data-toggle="btn-toggle">
					  <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i>
					  </button>
					  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
					</div>
				  </div>
				</div>
				<div class="box-body chat" id="chat-box">
				  <!-- chat item -->
				  <div class="item">
					<img src="dist/img/user4-128x128.jpg" alt="user image" class="online">

					<p class="message">
					  <a href="#" class="name">
						<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>
						Mike Doe
					  </a>
					  I would like to meet you to discuss the latest news about
					  the arrival of the new theme. They say it is going to be one the
					  best themes on the market
					</p>
					<div class="attachment">
					  <h4>Attachments:</h4>

					  <p class="filename">
						Theme-thumbnail-image.jpg
					  </p>

					  <div class="pull-right">
						<button type="button" class="btn btn-primary btn-sm btn-flat">Open</button>
					  </div>
					</div>
					<!-- /.attachment -->
				  </div>
				  <!-- /.item -->
				  <!-- chat item -->
				  <div class="item">
					<img src="dist/img/user3-128x128.jpg" alt="user image" class="offline">

					<p class="message">
					  <a href="#" class="name">
						<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:15</small>
						Alexander Pierce
					  </a>
					  I would like to meet you to discuss the latest news about
					  the arrival of the new theme. They say it is going to be one the
					  best themes on the market
					</p>
				  </div>
				  <!-- /.item -->
				  <!-- chat item -->
				  <div class="item">
					<img src="dist/img/user2-160x160.jpg" alt="user image" class="offline">

					<p class="message">
					  <a href="#" class="name">
						<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:30</small>
						Susan Doe
					  </a>
					  I would like to meet you to discuss the latest news about
					  the arrival of the new theme. They say it is going to be one the
					  best themes on the market
					</p>
				  </div>
				  <!-- /.item -->
				</div>
				<!-- /.chat -->
				<div class="box-footer">
				  <div class="input-group">
					<input class="form-control" placeholder="Type message...">

					<div class="input-group-btn">
					  <button type="button" class="btn btn-success"><i class="fa fa-plus"></i></button>
					</div>
				  </div>
				</div>
			  </div>
			  <!-- /.box (chat box) -->
		<div>
	</div>
</div>