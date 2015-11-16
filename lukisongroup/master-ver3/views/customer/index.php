<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
//use lukisongroup\assets\AppAsset1;
//AppAsset1::register($this);
//use kartik\grid\GridView;

$this->sideCorp = 'Master Data Umum';                  /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Customer');

//url


     
?>
<div class="customer-index">

    
            
 <?php
 
$gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                         'CUST_KD',
                            ['class'=>'kartik\grid\EditableColumn',
                            'attribute' => 'CUST_NM'], 
//                         'CUST_NM',
                         'ALAMAT:ntext',
                          'PIC',
                          'TLP1',
		
	 [ 'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                        'header'=>'Action',
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
                                                                ['view','id'=>$model->CUST_KD],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-cus",
                                                                'data-title'=> $model->CUST_KD,
                                                                ]);
                            },
                              'update' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">Update </button>',
                                                                ['update','id'=>$model->CUST_KD],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-Cus",
                                                                'data-title'=> $model->CUST_KD,
                                                                ]);
                            },
                              'delete' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-danger btn-xs" style="width:50px">Danger </button>',
                                                                ['delete','id'=>$model->CUST_KD],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-cus1",
                                                                'data-title'=> $model->CUST_KD,
                                                                ]);
                            },
                ],
            ],
	 
			
        
];
             

//                             'CUST_KD',
//                             'CUST_NM',
//                             'ALAMAT:ntext',
//                             'PIC',
//                             'TLP1',
     
      ?>

  <?= $grid = GridView::widget([
			'dataProvider'=> $dataProvider,
			'filterModel' => $searchModel,
			'columns' => $gridColumns,
			'pjax'=>true,
                        'pjaxSettings'=>[
                        'options'=>[
	                'enablePushState'=>false,
	                'id'=>'active',
                            ],
                          ],
			'toolbar' => [
				'{export}',
			],
			'panel' => [
				'heading'=>'<h3 class="panel-title">'.Html::encode($this->title).'</h3>',
				'type'=>'warning',
				'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
						['modelClass' => 'customer',]),'/master/customer/create',[
							'data-toggle'=>"modal",
								'data-target'=>"#modal-CUS",							
									'class' => 'btn btn-success'						
												]),	
				'showFooter'=>false,
			],
			'export' =>['target' => GridView::TARGET_BLANK],
			'exportConfig' => [
				GridView::PDF => [ 'filename' => 'customer'.'-'.date('ymdHis') ],
				GridView::EXCEL => [ 'filename' => 'customer'.'-'.date('ymdHis') ],
			],
		]);
?>

          

</div>
<?php



$this->registerJs("
        $('#modal-cus').on('show.bs.modal', function (event) {
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
        $('#modal-cus1').on('show.bs.modal', function (event) {
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
        $('#modal-Cus').on('show.bs.modal', function (event) {
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
        $('#modal-CUS').on('show.bs.modal', function (event) {
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
        'id' => 'modal-cus',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
     Modal::begin([
        'id' => 'modal-cus1',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
     Modal::begin([
        'id' => 'modal-Cus',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
     Modal::begin([
        'id' => 'modal-CUS',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
?>

