<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

$this->sideCorp = 'ESM Distributor';                  /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_datamaster';                   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Distributor');    /* title pada header page */
?>

<div class="distributor-index">
    <?php $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],

            'KD_DISTRIBUTOR',
            'NM_DISTRIBUTOR',
            'ALAMAT:ntext',
            'PIC',
       	 [
            'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
                        'header'=>'Action',
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
                                                                ['view','id'=>$model->ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-view",
                                                                'data-title'=> $model->KD_DISTRIBUTOR,
                                                                ]);
                            },
                            'update' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px; margin-left:25px">update </button>',
                                                                ['update','id'=>$model->ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-form",
                                                                'data-title'=> $model->KD_DISTRIBUTOR,
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
	                'id'=>'activebarang',
                            ],
                         ],
			'toolbar' => [
				'{export}',
			],
			'panel' => [
				'heading'=>'<h3 class="panel-title">'. Html::encode($this->title).'</h3>',
				'type'=>'warning',
				'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Tambah  Distributor ',
						['modelClass' => 'Kategori',]),'/esm/distributor/create',[
							'data-toggle'=>"modal",
								'data-target'=>"#modal-form",							
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
		
         $('#modal-form').on('show.bs.modal', function (event) {
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
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
     Modal::begin([
        'id' => 'modal-form',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();


?>
</div>

</div>
