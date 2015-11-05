<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;



$this->sideCorp = 'Master Data Umum';                  	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                   	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Type Barang');

         ?>   

<div class="tipebarang-index">

	<?php 
	 // Html::button('Tipe barang', ['value'=>$url,'class' => 'btn btn-success','id'=>'btn']) ;

		$gridColumns = [
			['class' => 'yii\grid\SerialColumn'],
                        'KD_TYPE',
//			'NM_TYPE',
                       ['class'=>'kartik\grid\EditableColumn',
                        'attribute' =>'NM_TYPE', 
                        ],
                    
			'NOTE:ntext',
                        
				[
					'attribute' => 'STATUS',
					'value' => function ($model) {
						return $model->STATUS == 1 ? 'Aktif' : 'Tidak Aktif';
					},
				],

			 [
            'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                        'header'=>'Action',
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
                                                                ['view','ID'=>$model->ID,'KD_TYPE'=>$model->KD_TYPE],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-tipbrg",
                                                                'data-title'=> $model->ID,
                                                                ]);
                            },
                            'update' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px; margin-left:25px">update </button>',
                                                                ['update','ID'=>$model->ID,'KD_TYPE'=>$model->KD_TYPE],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modaltip",
                                                                'data-title'=> $model->KD_TYPE,
                                                                ]);
                            },
                              'delete' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-danger btn-xs" style="width:50px; margin-left:25px">delete </button>',
                                                                ['delete','ID'=>$model->ID,'KD_TYPE'=>$model->KD_TYPE],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modalTip",
                                                                'data-title'=> $model->KD_TYPE,
                                                                ]);
                            },
                ],
            ],
		];


	 // Yii::$app->gv->grview($gridColumns,$dataProvider,$searchModel, 'Tipe Barang', 'tipe-barang','');//$this->title);
	
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
						['modelClass' => 'Tipebarang',]),'/master/tipebarang/create',[
							'data-toggle'=>"modal",
								'data-target'=>"#modal-tipe",							
									'class' => 'btn btn-success'						
												]),
				'showFooter'=>false,
			],		
			
			'export' =>['target' => GridView::TARGET_BLANK],
			'exportConfig' => [
				GridView::PDF => [ 'filename' => 'tipebarang'.'-'.date('ymdHis') ],
				GridView::EXCEL => [ 'filename' => 'tipebarang'.'-'.date('ymdHis') ],
			],
		]);
?>

</div>
<?php
$this->registerJs("
        $('#modal-tipbrg').on('show.bs.modal', function (event) {
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
        $('#modaltip').on('show.bs.modal', function (event) {
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
        $('#modalTip').on('show.bs.modal', function (event) {
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
        $('#modal-tipe').on('show.bs.modal', function (event) {
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
        'id' => 'modal-tipe',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
      Modal::begin([
        'id' => 'modalTip',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
      Modal::begin([
        'id' => 'modal-tipbrg',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
      Modal::begin([
        'id' => 'modaltip',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
?>
