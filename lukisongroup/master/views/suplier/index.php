<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use lukisongroup\models\esm\perusahaan;
use yii\bootstrap\Modal;
//use lukisongroup\models\hrd\Corp;

$this->sideCorp = 'Master Data Umum';                  	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = $sideMenu_control;//'umum_datamaster';                   	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Supplier');	    /* title pada header page */

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
					'background-color'=>'rgba(126, 189, 188, 0.9)',
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
			'attribute' => 'KD_SUPPLIER',
			'label'=>'Kode Supplier',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[				
				'style'=>[
					'text-align'=>'center',
					'width'=>'120px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(126, 189, 188, 0.9)',
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
			'attribute' => 'NM_SUPPLIER',
			'label'=>'Name Supplier',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[				
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(126, 189, 188, 0.9)',
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
			'attribute' => 'ALAMAT',
			'label'=>'Address',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[				
				'style'=>[
					'text-align'=>'center',
					'width'=>'400px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(126, 189, 188, 0.9)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'400px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			], 				
		],    
		[
			'attribute' => 'KOTA',
			'label'=>'City',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[				
				'style'=>[
					'text-align'=>'center',
					'width'=>'80px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(126, 189, 188, 0.9)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'80px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			], 				
		],    
        [
			'attribute' => 'nmgroup',
			'label'=>'Register.Corp',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[				
				'style'=>[
					'text-align'=>'center',
					'width'=>'150px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(126, 189, 188, 0.9)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'150px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			], 				
		],         	
		[	'class'=>'kartik\grid\ActionColumn',
			'dropdown' => true,
			'template' => '{view}{update}{delete}',
			'dropdownOptions'=>['class'=>'pull-right dropup'],									
			'buttons' => [
					'view' =>function($url, $model, $key){
							return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
														['view','ID'=>$model->ID,'KD_SUPPLIER'=>$model->KD_SUPPLIER],[
														'data-toggle'=>"modal",
														'data-target'=>"#modal-view",
														'data-title'=> $model->ID,
													   ]). '</li>' . PHP_EOL;
													},
					'update' =>function($url, $model, $key){
							return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Edit'),
														['update','ID'=>$model->ID,'KD_SUPPLIER'=>$model->KD_SUPPLIER],[
														'data-toggle'=>"modal",
														'data-target'=>"#modal-edit",
														'data-title'=> $model->ID,
													   ]). '</li>' . PHP_EOL;
													},
					'delete' =>function($url, $model, $key){
							return  '<li>' . Html::a('<span class="fa fa-remove fa-dm"></span>'.Yii::t('app', 'Delete'),
														['delete','ID'=>$model->ID,'KD_SUPPLIER'=>$model->KD_SUPPLIER],[
														'data-toggle'=>"modal",
														'data-target'=>"#modal-delete",
														'data-title'=> $model->ID,
													   ]). '</li>' . PHP_EOL;
													},
			],
			'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'150px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(126, 189, 188, 0.9)',
					]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
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
				'id'=>'gv-spl',
				'dataProvider'=> $dataProvider,
				'filterModel' => $searchModel,
				'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.9); align:center'],
				'columns' => $gridColumns,
				'pjax'=>true,
				'pjaxSettings'=>[
					'options'=>[
						'enablePushState'=>false,
						'id'=>'gv-spl',
					],
				 ],
				'toolbar' => [
					'{export}',
				],
				'panel' => [
					'heading'=>'<h3 class="panel-title">List Supplier</h3>',
					'type'=>'warning',
					'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Supplier ',
							['modelClass' => 'Suplier',]),'/master/suplier/create',[
								'data-toggle'=>"modal",
									'data-target'=>"#modal-create",							
										'class' => 'btn btn-success'						
													]),
					'showFooter'=>false,
				],		
				
				'export' =>['target' => GridView::TARGET_BLANK],
				'exportConfig' => [
					GridView::PDF => [ 'filename' => 'Supplier'.'-'.date('ymdHis') ],
					GridView::EXCEL => [ 'filename' => 'Supplier'.'-'.date('ymdHis') ],
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

	$this->registerJs("
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

	$this->registerJs("
        $('#modal-delete').on('show.bs.modal', function (event) {
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
        'id' => 'modal-delete',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-remove"></div><div><h4 class="modal-title">Delete Supplier</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(126, 189, 188, 0.9)',	
		],
    ]);
    Modal::end();
    
     Modal::begin([
        'id' => 'modal-edit',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-edit"></div><div><h4 class="modal-title">Edit Supplier</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(126, 189, 188, 0.9)',	
		],
    ]);
    Modal::end();
    
     Modal::begin([
        'id' => 'modal-view',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-eye"></div><div><h4 class="modal-title">View Supplier</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(126, 189, 188, 0.9)',	
		],
    ]);
    Modal::end();
    
     Modal::begin([
        'id' => 'modal-create',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Supplier</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(126, 189, 188, 0.9)',	
		],
    ]);
    Modal::end();
?>

