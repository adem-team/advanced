<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use lukisongroup\front\models\Child;
use lukisongroup\front\models\Parents;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\grandchild\models\GrandchildSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->sideMenu = 'umum_adminweb'; 
$this->title = 'Grandchildren';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grandchild-index">

    <?php
            $gridColumns = [

            ['class' => 'yii\grid\SerialColumn'], 
        
            'ParentsName',
            'ChildName', 
            'GRANDCHILD', 
           
             [
            'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                        'header'=>'Action',
                        'buttons' => [
                            'update' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px; margin-left:25px">update </button>',
                                                                ['update','GRANDCHILD_ID'=>$model->GRANDCHILD_ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-grandchild-update",
                                                                'data-title'=> $model->GRANDCHILD_ID,
                                                                ]);
                            },
                            'delete' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-danger btn-xs" style="width:50px; margin-left:25px">delete </button>',
                                                                ['delete','GRANDCHILD_ID'=>$model->GRANDCHILD_ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#delete-grandchild",
                                                                'data-title'=> $model->GRANDCHILD_ID,
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
				'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Tambah SubCategory ',
				['modelClass' => 'grandchild',]),'/front/back-grandchild/create',[
					'data-toggle'=>"modal",
					'data-target'=>"#modal-create-grandchild",                            
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
         $('#modal-create-grandchild').on('show.bs.modal', function (event) {
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
         $('#modal-grandchild-update').on('show.bs.modal', function (event) {
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
        $('#delete-grandchild').on('show.bs.modal', function (event) {
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
        'id' => 'modal-create-grandchild',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    Modal::begin([
        'id' => 'modal-grandchild-update',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
     Modal::begin([
        'id' => 'delete-grandchild',
        
    ]);
    Modal::end();
    
      
     
?>





</div>
