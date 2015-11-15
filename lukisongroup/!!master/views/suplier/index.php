<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use lukisongroup\models\esm\perusahaan;
use yii\bootstrap\Modal;
//use lukisongroup\models\hrd\Corp;

$this->sideCorp = 'Master Data Umum';                  	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                   	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Supplier');	    /* title pada header page */
?>

<div class="suplier-index">

<?php 
	$gridColumns = [
		['class' => 'yii\grid\SerialColumn'],
          
            'KD_SUPPLIER',
             ['class'=>'kartik\grid\EditableColumn',
                        'attribute' =>'NM_SUPPLIER', 
                        ],
            'ALAMAT:ntext',
            'KOTA',
			'nmgroup',
		['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}{delete}',
                    'contentOptions'=>[
                                            'style'=>'width:200px'
                                        ],
                        'header'=>'Action',
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
                                                                ['view','ID'=>$model->ID,'KD_SUPPLIER'=>$model->KD_SUPPLIER],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-Sup",
                                                                'data-title'=> $model->ID,
                                                               ]);
                                                            },
                            'update' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px;margin-left:10px">Update </button>',
                                                                ['update','ID'=>$model->ID,'KD_SUPPLIER'=>$model->KD_SUPPLIER],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-sup1",
                                                                'data-title'=> $model->ID,
                                                               ]);
                                                            },
                              'delete' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-danger btn-xs" style="width:50px;margin-left:10px">delete </button>',
                                                                ['delete','ID'=>$model->ID,'KD_SUPPLIER'=>$model->KD_SUPPLIER],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-sup2",
                                                                'data-title'=> $model->ID,
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
	                'id'=>'activetype',
	                ],
	        ],
			'toolbar' => [
				'{export}',
			],
			'panel' => [
				'heading'=>'<h3 class="panel-title">'. Html::encode($this->title).'</h3>',
				'type'=>'warning',
				'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Tambah ',
						['modelClass' => 'Suplier',]),'/master/suplier/create',[
							'data-toggle'=>"modal",
								'data-target'=>"#modal-sup",							
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
<?php

$this->registerJs("
        $('#modal-sup').on('show.bs.modal', function (event) {
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
        $('#modal-Sup').on('show.bs.modal', function (event) {
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
        $('#modal-sup1').on('show.bs.modal', function (event) {
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
        $('#modal-sup2').on('show.bs.modal', function (event) {
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
        'id' => 'modal-sup2',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
     Modal::begin([
        'id' => 'modal-sup1',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
     Modal::begin([
        'id' => 'modal-Sup',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
     Modal::begin([
        'id' => 'modal-sup',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
?>

