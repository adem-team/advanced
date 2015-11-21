<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\models\master\UnitbarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Unit Barang';
$this->params['breadcrumbs'][] = $this->title;

$this->sideCorp = 'Lukison Group';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Data Master');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

?>

     

<div class="unitbarang-index">


    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php
		$gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            ['class'=>'kartik\grid\EditableColumn',
                        'attribute' =>'NM_UNIT', 
                        ],

//            'NM_UNIT',
            'SIZE',
            'WIGHT',
            'COLOR',
			
            [
            'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                        'header'=>'Action',
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
                                                                ['view','ID'=>$model->ID,'KD_UNIT'=>$model->KD_UNIT],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-unit",
                                                                'data-title'=> $model->ID,
                                                               ]);
                                                            },
                            'update' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px;margin-left:20px">Update </button>',
                                                                ['update','ID'=>$model->ID,'KD_UNIT'=>$model->KD_UNIT],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-unit1",
                                                                'data-title'=> $model->ID,
                                                               ]);
                                                            },
                              'delete' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-danger btn-xs" style="width:50px;margin-left:20px">delete </button>',
                                                                ['delete','ID'=>$model->ID,'KD_UNIT'=>$model->KD_UNIT],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-Unit",
                                                                'data-title'=> $model->ID,
                                                               ]);
                                                            },
                                  ],
                                                                    
         ],
    ]; 
	

	 // Yii::$app->gv->grview($gridColumns,$dataProvider,$searchModel, 'Unit Barang', 'unit-barang',$this->title,$url);
	
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
                'heading'=>'<h3 class="panel-title">'. Html::encode($this->title).'</h3>',
                'type'=>'warning',
                'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Tambah ',
						['modelClass' => 'Unitbarang',]),'/master/unitbarang/create',[
							'data-toggle'=>"modal",
								'data-target'=>"#modal-unit2",							
									'class' => 'btn btn-success'						
												]),
                'showFooter'=>false,
            ],      
            
            'export' =>['target' => GridView::TARGET_BLANK],
            'exportConfig' => [
                GridView::PDF => [ 'filename' => 'barangumum'.'-'.date('ymdHis') ],
                GridView::EXCEL => [ 'filename' => 'barangumum'.'-'.date('ymdHis') ],
            ],
        ]);
?>

</div>
<?php

// modal view
$this->registerJs("
        $('#modal-unit').on('show.bs.modal', function (event) {
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
        $('#modal-unit1').on('show.bs.modal', function (event) {
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
        $('#modal-Unit').on('show.bs.modal', function (event) {
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
        $('#modal-unit2').on('show.bs.modal', function (event) {
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
        'id' => 'modal-unit2',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
     Modal::begin([
        'id' => 'modal-Unit',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
     Modal::begin([
        'id' => 'modal-unit1',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
    
     Modal::begin([
        'id' => 'modal-unit',
        'header' => '<h4 class="modal-title">LukisonGroup</h4>',
    ]);
    Modal::end();
?>
