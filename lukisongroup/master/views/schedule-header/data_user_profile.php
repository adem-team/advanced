<?php
use kartik\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model modulprj\master\models\IjinDetail */


/*
	 * GRIDVIEW USER LIST  : author wawan
     */
	$info=GridView::widget([
		'id'=>'gv-user-id',
    'dataProvider' => $dataProvider1,
    // 'filterModel' => $searchModelUser,
		'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
        'columns' => [
            [	//COL-0
				/* Attribute Serial No */
				'class'=>'kartik\grid\SerialColumn',
				'width'=>'10px',
				'header'=>'No.',
				'hAlign'=>'center',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'background-color'=>'rgba(0, 95, 218, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
					]
				],
				'pageSummaryOptions' => [
					'style'=>[
							'border-right'=>'0px',
					]
				]
			],
			[  	//col-1
				//username
				'attribute' => 'username',
				'label'=>'User',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'100px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'100px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[  	//col-2
				//USER POSITION_SITE
				'attribute' => 'POSITION_SITE',
				'label'=>'Site Login',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'100px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'100px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[  	//col-3
				//USER POSITION_LOGIN
				'attribute' => 'POSITION_LOGIN',
				'label'=>'Position Login',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'100px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'100px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
           
        ],
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-user-id',
		   ],
		],
		'panel' => [
		// 			'heading'=>'<h3 class="panel-title">USER LIST</h3>',
		// 			'type'=>'warning',
		// 			'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add User ',
		// 					['modelClass' => 'Kategori',]),'/master/schedule-header/create-user',[
		// 						'data-toggle'=>"modal",
		// 							'data-target'=>"#modal-create",
		// 								'class' => 'btn btn-success'
		// 											]),
					'showFooter'=>false,
		],
		'toolbar'=> [
			//'{items}',
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
    ]);


	
	
	
	
	
	
?>
<div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="row" >
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?= $info ?>
		</div>
	</div>
</div>
