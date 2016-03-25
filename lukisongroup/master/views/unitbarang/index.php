<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

$this->sideCorp = 'Prodak Unit';                  /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Unit Prodak');      /* title pada header page */

	$aryStt= [
		  ['STATUS' => 0, 'STT_NM' => 'DISABLE'],		  
		  ['STATUS' => 1, 'STT_NM' => 'ENABLE'],
	];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');

$gridColumns = [
	[
		'class'=>'kartik\grid\SerialColumn',
		'contentOptions'=>['class'=>'kartik-sheet-style'],
		'width'=>'10px',
		'header'=>'No.',
		'headerOptions'=>[				
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(62, 0, 44, 0.2)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		], 		
	],
	[
		'attribute' =>'NM_UNIT',
		'label'=>'Unit Name',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[				
			'style'=>[
				'text-align'=>'center',
				'width'=>'200px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(62, 0, 44, 0.2)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'200px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		], 				
	],  
    [
		'attribute' =>'QTY',
		'label'=>'Qty.Unit',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[				
			'style'=>[
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(62, 0, 44, 0.2)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		], 				
	],         
    [
		'attribute' =>'WEIGHT',
		'label'=>'Weight.Pcs',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[				
			'style'=>[
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(62, 0, 44, 0.2)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		], 				
	],        
	[
		'attribute' =>'SIZE',
		'label'=>'Size.Unit',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[				
			'style'=>[
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(62, 0, 44, 0.2)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		], 				
	],
	[
		'attribute' => 'STATUS',
		'filter' => $valStt,	
		'format' => 'raw',						
		'hAlign'=>'center',
		'value'=>function($model){
		   if ($model->STATUS == 1) {
				return Html::a('<i class="fa fa-edit"></i> &nbsp;Enable', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
			} else if ($model->STATUS == 0) {
				return Html::a('<i class="fa fa-close"></i> &nbsp;Disable', '',['class'=>'btn btn-danger btn-xs', 'title'=>'Deactive']);
			} 
		},
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[				
			'style'=>[
				'text-align'=>'center',
				'width'=>'80px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(62, 0, 44, 0.2)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'80px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		], 	
	],	
	[
		'class'=>'kartik\grid\ActionColumn',
		'dropdown' => true,
		'template' => '{view}{update}',
		'dropdownOptions'=>['class'=>'pull-right dropup'],
		'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
		'buttons' => [
			'view' =>function($url, $model, $key){
					return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
												['view','id'=>$model->ID],[
												'data-toggle'=>"modal",
												'data-target'=>"#modal-view",
												'data-title'=> $model->KD_UNIT,
												]). '</li>' . PHP_EOL;
			},
			'update' =>function($url, $model, $key){
					return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Edit'),
												['update','id'=>$model->ID],[
												'data-toggle'=>"modal",
												'data-target'=>"#modal-edit",
												'data-title'=> $model->KD_UNIT,
												]). '</li>' . PHP_EOL;
			},			
		],
		'headerOptions'=>[				
			'style'=>[
				'text-align'=>'center',
				'width'=>'150px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(62, 0, 44, 0.2)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'150px',
				'height'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		], 		
	],
]; 
?>
<div class="container-full">
	<div style="padding-left:15px; padding-right:15px">		
		<?= $grid = GridView::widget([
				'id'=>'unit-grd-index',
				'dataProvider'=> $dataProvider,
				'filterModel' => $searchModel,
				'filterRowOptions'=>['style'=>'background-color:rgba(62, 0, 44, 0.2); align:center'],
				'columns' => $gridColumns,
				'pjax'=>true,
				'pjaxSettings'=>[
					'options'=>[
						'enablePushState'=>false,
						'id'=>'unit-grd-index',
					   ],						  
				],
				'hover'=>true, //cursor select
				'responsive'=>true,
				'responsiveWrap'=>true,
				'bordered'=>true,
				'striped'=>'4px',
				'autoXlFormat'=>true,
				'toolbar' => [
					'{export}',
				],
				'panel' => [
					'heading'=>'<h3 class="panel-title">ITEMS UNIT</h3>',
					'type'=>'warning',
					'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Unit ',
							['modelClass' => 'Kategori',]),'/master/unitbarang/create',[
								'data-toggle'=>"modal",
									'data-target'=>"#modal-create",							
										'class' => 'btn btn-success'						
													]),
					'showFooter'=>false,
				],		
				'export' =>['target' => GridView::TARGET_BLANK],
				'exportConfig' => [
					GridView::PDF => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
					GridView::EXCEL => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
				],
			]);
		?>
	</div>
</div>

<?php

	$this->registerJs("
         $('#modal-create').on('show.bs.modal', function (event) {
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
        'id' => 'modal-create',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Item Unit</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(62, 0, 44, 0.2)',	
		],
    ]);
    Modal::end();
	
	$this->registerJs("
         $('#modal-view').on('show.bs.modal', function (event) {
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
        'id' => 'modal-view',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-eye"></div><div><h4 class="modal-title">View Item Unit</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(62, 0, 44, 0.2)',	
		],
    ]);
    Modal::end();
	
	$this->registerJs("
		 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
         $('#modal-edit').on('show.bs.modal', function (event) {
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
        'id' => 'modal-edit',
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-edit"></div><div><h4 class="modal-title">Edit Item Unit</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(62, 0, 44, 0.2)',	
		],
    ]);
    Modal::end();


?>
