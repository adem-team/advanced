<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

$this->sideCorp = 'Modul HRM';                      /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_modul';                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Group Function');     /* title pada header page */

	$gvGrading = GridView::widget([
		'id'=>'gv-function',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'GF_ID',
            'GF_NM',
            'GF_DCRP',
			'SORT',
            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view}',
						'header'=>'Action',
						'buttons' => [
							'view' =>function($url, $model, $key){
									return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:35px">View </button>',['view','id'=>$model->GF_ID],[
																'data-toggle'=>"modal",
																'data-target'=>"#modal-function",
																'data-title'=> $model->GF_ID,
																]);
							},
				],
			],
		],
		'panel'=>[			
				'type' =>GridView::TYPE_SUCCESS,
				'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
						['modelClass' => 'Group Function',]),'/hrd/groupfunction/create',[  
															'data-toggle'=>"modal",
															'data-target'=>"#modal-function",
															'class' => 'btn btn-success'
															])
		],
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-function',
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
	
	echo $gvGrading;
	
	$this->registerJs("
		$('#modal-function').on('show.bs.modal', function (event) {
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
		'id' => 'modal-function',
		'header' => '<h4 class="modal-title">LukisonGroup</h4>',
	]);
	Modal::end();
	
?>

