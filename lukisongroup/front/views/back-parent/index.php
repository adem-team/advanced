<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\back\models\ParentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->sideMenu = 'umum_adminweb'; 
$this->title = 'Parents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parents-index">
            <?php
            $gridColumns = [


            ['class' => 'yii\grid\SerialColumn'],
            'attribute' => 'parent', 
           
             [
            'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                        'header'=>'Action',
                        'buttons' => [
                            'update' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px; margin-left:25px">update </button>',
                                                                ['update','parent_id'=>$model->parent_id,'parent'=>$model->parent],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-view-update",
                                                                'data-title'=> $model->parent,
                                                                ]);
                            },
                            'delete' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-danger btn-xs" style="width:50px; margin-left:25px">delete </button>',
                                                                ['delete','parent_id'=>$model->parent_id],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#delete-parent",
                                                                'data-title'=> $model->parent_id,
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
				'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Tambah Menu ',
				['modelClass' => 'parents',]),'/front/back-parent/create',[
					'data-toggle'=>"modal",
					'data-target'=>"#modal-create-parent",                            
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
         $('#modal-create-parent').on('show.bs.modal', function (event) {
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
         $('#modal-view-parent').on('show.bs.modal', function (event) {
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
         $('#modal-view-update').on('show.bs.modal', function (event) {
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
        $('#delete-parent').on('show.bs.modal', function (event) {
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
        'id' => 'modal-create-parent',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
     Modal::begin([
        'id' => 'modal-view-parent',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
     Modal::begin([
        'id' => 'modal-view-update',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
    Modal::begin([
    'id' => 'delete-parent',
    'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
      
     
?>





</div>
<?php
$menuItemsNoLogin[] = ['label' =>'Home', 'url' => ['/site/index']];
                        $menuItemsNoLogin[] = [
                            'label' =>'About', 'url' => ['/site/profile/index'],
                                'items' => [
                                    ['label' => 'Lukison Group', 'url' => '#',
                                        'items' => [
                                            ['label' =>'Profile', 'url' => '/front/profile?id=lg'],
                                            ['label' => 'Product', 'url' => '/front/product?id=lg'],
                                            ['label' => 'Teams', 'url' => '/front/teams?id=lg'],
                                        ]
                                    ],
                                    ['label' => 'Sarana Sinar Surya', 'url' => '#',
                                        'items' => [
                                                ['label' =>'Profile', 'url' => '/front/profile?id=sss'],
                                                ['label' => 'Product', 'url' => '/front/product?id=sss'],
                                                ['label' =>'Teams', 'url' => '/front/teams?id=sss'],
                                        ]
                                    ],
                                    ['label' => 'Effembi Sukses Makmur', 'url' => '#',
                                        'items' => [
                                                ['label' => 'Profile', 'url' => '/front/profile?id=esm'],
                                                ['label' =>'Product', 'url' => '/front/product?id=sss'],
                                                ['label' => 'Teams', 'url' => '/front/teams?id=sss'],
                                        ]
                                    ],
                                    ['label' => 'Arta Lipat Ganda', 'url' => '#',
                                        'items' => [
                                            ['label' =>'Profile', 'url' => '/front/profile?id=alg'],
                                            ['label' => 'Product', 'url' => '/front/product?id=alg'],
                                            ['label' => 'Teams', 'url' => '/front/teams?id=alg'],
                                        ]
                                    ],
                                ],
                        ];
                        $menuItemsNoLogin[] = ['label' => 'Events', 'url' => ['/front/event/index']];
                        $menuItemsNoLogin[] = ['label' => 'Karir', 'url' => ['/front/karir/index']];
                        $menuItemsNoLogin[] = ['label' => 'Contact Us', 'url' => ['/front/contact/index']];
                        $menuItemsNoLogin[] = [
                            'label' =>'Catalog', 'url' => ['/site/loginc'],
                                'items' => [
                                    ['label' => 'e-Procurement', 'url' => '/front/procurement/index'],
                                    ['label' => 'e-Recruitment', 'url' => '/front/recruitment/index'],
                                ],
                        ];
                        $menuItemsNoLogin[] = ['label' => '<div class="btn">LOGIN</div>', 'url' => ['/site/login'],];
                        ?>
                       