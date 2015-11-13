<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

$this->sideCorp = 'Modul HRM';                        /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_modul';                        /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Coorporation');         /* title pada header page */
?>

<?php
  $gvDept= GridView::widget([
		'id'=>'gv-corp',
		'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'CORP_ID',
            'CORP_NM',
			'CORP_DCRP',
            'SORT',            
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view}',
						'header'=>'Action',
						'buttons' => [
							'view' =>function($url, $model, $key){
									return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:35px">View </button>',['view','id'=>$model->CORP_ID],[
																'data-toggle'=>"modal",
																'data-target'=>"#modal-corp",
																'data-title'=> $model->CORP_ID,
																]);
							},
				],
			],
		],
		'panel'=>[			
				'type' =>GridView::TYPE_SUCCESS,
				'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
						['modelClass' => 'Coorporation',]),'/hrd/corp/create',[  
															'data-toggle'=>"modal",
															'data-target'=>"#modal-corp",
															'class' => 'btn btn-success'
															])
		],
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-corp',
			],
		],
		'hover'=>true, //cursor select
		//'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export'=>[//export like view grid --ptr.nov-
			'fontAwesome'=>true,
			'showConfirmAlert'=>false,
			'target'=>GridView::TARGET_BLANK
		],
	]);
	echo $gvDept;
	
	$this->registerJs("
		$('#modal-corp').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var modal = $(this)
			var title = button.data('title') 
			var href = button.attr('href') 
			//modal.find('.modal-title').html(title)
			modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
			$.post(href)
				.done(function( data ) {
					modal.find('.modal-body').html(data)
				});
			})
	",$this::POS_READY);
	
	Modal::begin([
		'id' => 'modal-corp',
		'header' => '<h4 class="modal-title">LukisonGroup</h4>',
	]);
	Modal::end();
?>

