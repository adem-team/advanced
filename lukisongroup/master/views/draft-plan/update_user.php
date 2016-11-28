<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model modulprj\master\models\IjinDetail */


	/*user info*/
	$userviewinfo=DetailView::widget([
		'model' => $model_userlogin,
		'attributes' => [
			[
				'attribute' =>'username',
				'label'=>'user login name',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			[
				'attribute' =>'USER_ALIAS',
				'label'=>'user alias',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			[
				'attribute' =>'avatar',
				'label'=>'status',
				'format'=>'raw',
			    'value'=>$model_userlogin->status != 1 ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			[
				'attribute' =>'access_token',
				'label'=>'nama user',
			    'value'=>$model_userlogin->salesNm,
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],

			
		],
	]);

	
	/*update user */
	$update_user = [
		[
			'group'=>true,
			'label'=>false,
			'rowOptions'=>['class'=>'info'],
			'groupOptions'=>['class'=>'text-left'] //text-center 
		],
		[ 	//username
			'attribute' =>'username',
			'label'=>'user login name',
		],
		
		[ 	//status
			'attribute' =>'status',
			'label'=>'status',
			 'value'=>$model_userlogin->status != 1 ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>',
			'labelColOptions' => ['style' => 'text-align:right;width: 15px'],
			'format'=>'html',
			'type'=>DetailView::INPUT_SELECT2,
			'widgetOptions'=>[
				'data'=>$ary_status,
				'options'=>['placeholder'=>'Select ...'],
				'pluginOptions'=>['allowClear'=>true],
			],	
		]	
	
	];



	/*update user_profile */
	$update_user_profile = [
		[
			'group'=>true,
			'label'=>false,
			'rowOptions'=>['class'=>'info'],
			'groupOptions'=>['class'=>'text-left'] //text-center 
		],
		[ 	//NM_FIRST
			'attribute' =>'NM_FIRST',
			'label'=>'name',
		],
		
		[ 	//TLP_HOME
			'attribute' =>'TLP_HOME',
			'label'=>'Telpon',
		]	
	
	];



	/*Detail data View Editing*/
	$detail_data_view=DetailView::widget([
		'id'=>'detail-data-view-user-id',
		'model' => $model_userlogin,
		'attributes'=>$update_user,
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',
		'panel'=>[
					'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b> Detail User Login</b></h6></div>',
					'type'=>DetailView::TYPE_INFO,
				],
		// 'saveOptions'=>[ 
		// 	'id' =>'saveBtn',
		// 	'value'=>'/master/customers/viewcust?id='.$model->CUST_KD,
		// 	'params' => ['custom_param' => true],
		// ],		
	]);


	/*Detail data View Editing*/
	$detail_data_view_profile=DetailView::widget([
		'id'=>'detail-data-view-user-profile-id',
		'model' => $model_userprofile,
		'attributes'=>$update_user_profile,
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',
		'panel'=>[
					'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b> Detail User Login</b></h6></div>',
					'type'=>DetailView::TYPE_INFO,
				],
		// 'saveOptions'=>[ 
		// 	'id' =>'saveBtn',
		// 	'value'=>'/master/customers/viewcust?id='.$model->CUST_KD,
		// 	'params' => ['custom_param' => true],
		// ],		
	]);


	

	
	
	
	
?>
<div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="row" >
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<?= $userviewinfo ?>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			 <?= $detail_data_view ?>
		</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?= $detail_data_view_profile ?>
			</div>
		</div>
</div>
