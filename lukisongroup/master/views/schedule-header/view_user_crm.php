<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model modulprj\master\models\IjinDetail */

$pass = Yii::$app->getSecurity()->decryptByPassword($model->password_hash, $model->password_hash);

	/*user_crm info*/
	$cusviewinfo=DetailView::widget([
		'model' => $model,
		'attributes' => [
			[
				'attribute' =>'username',
				'label'=>'Nama login',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			[
				'attribute' =>'username',
				'value'=>$model->userprofile->NM_FIRST.' '.$model->userprofile->NM_MIDDLE,
				'label'=>'Nama User',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			[
				'attribute' =>'auth_key',
				'value'=>$model->userprofile->ALAMAT,
				'label'=>'Alamat',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			[
				'attribute' =>'email',
				'label'=>'Email:',
				'labelColOptions' => ['style' => 'text-align:right;width: 30%']
			],
			[ 	//STATUS
			'attribute' =>'status',
			'format'=>'raw',
			'value'=>$model->status != 1 ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>',
	
	]
			
		],
	]);


	/*data detail*/
	$data_detail = [
		[
			'group'=>true,
			'label'=>false,
			'rowOptions'=>['class'=>'info'],
			'groupOptions'=>['class'=>'text-left'] //text-center 
		],
		[ 	//TLP HOME
			'attribute' =>'TLP_HOME',
			'label'=>'TLP HOME:',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 15px']
		],
		[ 	//EMAIL
			'attribute' =>'EMAIL',
			'label'=>'email',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 15px']
		],
		[ 	//HP
			'attribute' =>'HP',
			'label'=>'No Handphone',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 15px']
		],

		[ 	//KTP
			'attribute' =>'KTP',
			'label'=>'FAX',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 15px']
		],
			[ 	//KTP
			'attribute' =>'ALAMAT',
			'label'=>'Alamat',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 15px']
		],
		[ 	//STATUS
			'attribute' =>'STATUS',
			'format'=>'raw',
			'value'=>$user_profile_crm->STATUS ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>',
			'type'=>DetailView::INPUT_SWITCH,
        	'widgetOptions' => [
            'pluginOptions' => [
                'onText' => 'Aktif',
                'offText' => 'Tidak Aktif',
            ]
        ],
          'valueColOptions'=>['style'=>'width:30%']
	]
	];

	/*Detail data View Editing*/
	$detail_data_view=DetailView::widget([
		'id'=>'detail-data-view-id-crm-user',
		'model' => $user_profile_crm,
		'attributes'=>$data_detail,
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',
		'panel'=>[
					'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b> Detail User</b></h6></div>',
					'type'=>DetailView::TYPE_INFO,
				],
		'saveOptions'=>[ 
			'id' =>'saveBtn',
			'value'=>'/master/schedule-header/view-user-crm?id='.$user_profile_crm->ID,
			'params' => ['custom_param' => true],
		],		
	]);
	

	
	
	
	
	
	
?>
<div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="row" >
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<?= $cusviewinfo ?>
		</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<?= $detail_data_view ?>
		</div>
	</div>
</div>
