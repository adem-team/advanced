<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\bootstrap\Modal;


$this->sideCorp = 'Master Data Umum';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';               /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Barang ');

    




?>
  
     <?php
     
$gridColumns = [

            ['class' => 'yii\grid\SerialColumn'],
                          'KD_BARANG',
            ['class'=>'kartik\grid\EditableColumn',
                'attribute' => 'NM_BARANG'],    
                          'HARGA',
                          'HPP',
                         'BARCODE',
     [
				
               'attribute' => 'IMAGE',
               'format' => 'html',
               'value'=>function($data){
                            return Html::img(Yii::$app->urlManager->baseUrl.'/upload/barangumum/' . $data->IMAGE, ['width'=>'100']);
                        },
            ],  
   
                         'NOTE',
          
			
			['class' => 'yii\grid\ActionColumn', 
					'template' => '{view}{update}{delete}',
                                        'contentOptions'=>[
                                            'style'=>'width:200px'
                                        ],
					'header'=>'Action',
					'buttons' => [
						'view'=>function($url, $model, $key){
								return Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px;">View </button>',
                                                                       
                                                                    ['view','ID'=>$model->ID,'KD_BARANG'=>$model->KD_BARANG],
                                                                        [   
                                                                            'data-toggle'=>"modal",
                                                                            'data-target'=>"#modal-bumum",													
                                                                            'data-title'=> $model->ID,
									]);
                                                                },
                                                'update'=>function($url, $model, $key){
								return Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px;  margin-left:10px">Update </button>',
                                                                    ['update','ID'=>$model->ID,'KD_BARANG'=>$model->KD_BARANG],
                                                                        [
                                                                            'data-toggle'=>"modal",
                                                                            'data-target'=>"#modal-barangumum",													
                                                                            'data-title'=> $model->ID,
									]);
                                                                },
                                                  'delete'=>function($url, $model, $key){
								return Html::a('<button type="button" class="btn btn-danger btn-xs" style="width:50px; margin-left:10px">Delete </button>',
                                                                    ['delete','ID'=>$model->ID,'KD_BARANG'=>$model->KD_BARANG],
                                                                        [
                                                                            'data-toggle'=>"modal",
                                                                            'data-target'=>"#modal-Umum",													
                                                                            'data-title'=> $model->ID,
									]);
                                                                },
                                                    ],
                                                                            
			],
            
        ];
      
        
//     ];  
     echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
         'dropdownOptions' => ['class' => 'btn btn-warning'],
         'columnSelectorOptions' => ['attribute'=>'HARGA'],
         'filename' => 'barangumum'.'-'.date('ymdHis'),
          'target' => ExportMenu::TARGET_BLANK,
       
          
                 
             
    ]);
                                                
                                          
?>
        
      

<div class="barangumum-index" style="padding:10px;">
    

  <?= $grid = GridView::widget([
                        
			'dataProvider'=> $dataProvider,
			'filterModel' => $searchModel,
			'columns' => $gridColumns,
                        'rowOptions' => function($data) { 
                                         if($data->STATUS == 'tidak aktif')
                                         {
                                             return ['class'=>'danger'];
                                         }
                                        else {
                                            return ['class'=>'success'];
                                        }
                            
                                   },
			'responsive'=>true,
                        'resizableColumns'=>true,
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
				'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
						['modelClass' => 'Barangumum',]),'/master/barangumum/create',[
							'data-toggle'=>"modal",
								'data-target'=>"#modal-barangumum",
                                                                     'id'=>'modl',
									'class' => 'btn btn-success'						
												]),								
                            
                            
				'showFooter'=>false,
			],		
			
			'export' =>['target' => GridView::TARGET_BLANK,
                                    ],
                                      
			'exportConfig' => [
                        
				GridView::PDF => [
                                    'filename' => 'barangumum'.'-'.date('ymdHis'),
                                 
//                                    'columns'=>$column,
                                 
                                           
          
          ],
				GridView::EXCEL => [ 'filename' => 'barangumum'.'-'.date('ymdHis') ],
			],
		]);
       

?>


</div>
<?php

//js
$this->registerJs("
     
        $('#modal-Umum').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            var title = button.data('title') 
            var href = button.attr('href') 
            modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
            $.post(href)
                .done(function( data ) {
                    modal.find('.modal-body').html(data)
                });
            })
    ",$this::POS_READY);

$this->registerJs("
        $('#modal-bumum').on('show.bs.modal', function (event) {
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
       $.fn.modal.Constructor.prototype.enforceFocus = function(){};
        $('#modal-barangumum').on('show.bs.modal', function (event) {
            
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


?>
   
            <!--modal-->
            
               <?php
                  Modal::begin([
                            'id' => 'modal-barangumum',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4> ',
                        
                           
                            'headerOptions'=>[
                                    'style'=>'background-color:blue;'
                            ],
                   
                                 
                             ]);
                
               
                    Modal::end();
            
                
             
                  Modal::begin([
                            'id' => 'modal-bumum',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                             ]);
                Modal::end();
                 Modal::begin([
                            'id' => 'modal-Umum',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                             ]);
                Modal::end();
                
                ?>
             
         </div>
    


