<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;





$this->sideCorp = 'Master Data Umum';                  		/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                   		/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Kategori Barang');

     ?>

<div class="kategori-index">



		<?php
$gridColumns = [
  

	['class' => 'yii\grid\SerialColumn'],
              ['class'=>'kartik\grid\EditableColumn',
                'attribute' => 'NM_KATEGORI', 
                ],
            
		
		'NOTE:ntext',
		
	 [
            'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                        'header'=>'Action',
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
                                                                ['view','ID'=>$model->ID,'KD_KATEGORI'=>$model->KD_KATEGORI],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-katgor",
                                                                'data-title'=> $model->KD_KATEGORI,
                                                                ]);
                            },
                            'update' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px; margin-left:25px">update </button>',
                                                                ['update','ID'=>$model->ID,'KD_KATEGORI'=>$model->KD_KATEGORI],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-Kat",
                                                                'data-title'=> $model->KD_KATEGORI,
                                                                ]);
                            },
                            'delete' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-danger btn-xs" style="width:50px; margin-left:25px">delete </button>',
                                                                ['delete','ID'=>$model->ID,'KD_KATEGORI'=>$model->KD_KATEGORI],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-katgori",
                                                                'data-title'=> $model->KD_KATEGORI,
                                                                ]);
                            },
                ],
                      
                
            ],
	 
			
        
];


		?>
	 <?= $grid = GridView::widget([
			'dataProvider'=> $dataProvider,
			'filterModel' => $searchModel,
			'columns' => $gridColumns,
			'pjax'=>true,
                        'pjaxSettings'=>[
                        'options'=>[
	                'enablePushState'=>false,
	                'id'=>'activekat',
                            ],
                         ],
			'toolbar' => [
				'{export}',
			],
			'panel' => [
				'heading'=>'<h3 class="panel-title">'. Html::encode($this->title).'</h3>',
				'type'=>'warning',
				'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Tambah Kategori ',
						['modelClass' => 'Kategori',]),'/master/kategori/create',[
							'data-toggle'=>"modal",
								'data-target'=>"#modal-kat",							
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
		


<?php
$this->registerJs("
         $('#modal-katgori').on('show.bs.modal', function (event) {
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
         $('#modal-katgor').on('show.bs.modal', function (event) {
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
         $('#modal-Kat').on('show.bs.modal', function (event) {
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
         $('#modal-kat').on('show.bs.modal', function (event) {
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
        'id' => 'modal-kat',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
     Modal::begin([
        'id' => 'modal-Kat',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
       Modal::begin([
        'id' => 'modal-katgor',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
      Modal::begin([
        'id' => 'modal-katgori',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
?>





</div>
