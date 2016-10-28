<?php
use kartik\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use yii\db\ActiveRecord;
use yii\data\ArrayDataProvider;
use dosamigos\gallery\Gallery;

$gridColumns = [
	[ #serial column
		'class'=>'kartik\grid\SerialColumn',
		'contentOptions'=>['class'=>'kartik-sheet-style'],
		'width'=>'10px',
		'header'=>'No.',
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'10px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
	],
	[
		'attribute' => 'TGL',
		'label'=>'TGL',
		'hAlign'=>'center',
		'vAlign'=>'middle',
		'filter'=>false,
		'noWrap'=>true,
		'mergeHeader'=>true,
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'50px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'50px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
	],
	[
		'attribute' => 'NM_CUSTOMER',
		'label'=>'CUSTOMER',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'150px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'left',
			  'width'=>'150px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
	],
	[
		'attribute' => 'NM_USER',
		'label'=>'SALES',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'100px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'left',
			  'width'=>'100px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
	],
	[
		'attribute' => 'ISI_MESSAGES',
		'label'=>'ISSUE NOTE',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'500px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'left',
			  'width'=>'500px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
	],
];

$issueMemo= GridView::widget([
	'id'=>'gv-dashboard-issue',
	'dataProvider' => $dataProviderIssue,
	'filterModel' => $searchModelIssue,
	'columns' => $gridColumns,
	'pjax'=>true,
	'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-dashboard-issue',
		],
	],
	'summary'=>false,
	'panel' => [
		'heading'=>false,//'<div style="float:left;margin-right:10px" class="fa fa-2x fa-bicycle"></div><div><h4 class="modal-title">Store Issue</h4></div>'.' '.'<div style="float:right; margin-top:-22px;margin-right:0px;">'.$btn_srch.'</div>', 
		'type'=>'success',
		'before'=> Html::a('<i class="fa fa-calendar"></i> '.Yii::t('app', 'Set Date',
				   ['modelClass' => 'DraftPlan',]),'/master/review-visit/button-set-date',[
					  'data-toggle'=>"modal",
					  'data-target'=>"#modal-button-set-date-issue",
					  'class' => 'btn btn-info'
				   ]),
	],
	'toolbar'=> [
		//['content'=>toMenuAwal().toExportExcel()],
		''//'{items}',
	],
]); 
	/**
	* Button Set Date
	*/
	$this->registerJs("		
		$('#modal-button-set-date-issue').on('show.bs.modal', function (event) {
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
		'id' => 'modal-button-set-date-issue',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-search-plus"></div><div><h4 class="modal-title">SEARCH DATE</h4></div>',
		'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(129, 220, 238, 1)',
		],
	]);
	Modal::end(); 
?>
<?=$issueMemo?>
<div id='test'>
