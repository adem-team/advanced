

<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;



//$this->sideCorp = 'Master Data Umum';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
//$this->sideMenu = 'umum_datamaster';               /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'VisiMisi');

    




?>
  
     <?php
     
$gridColumns = [

            ['class' => 'yii\grid\SerialColumn'],
                       
//                    'ID',
            'VISIMISI_TITEL',
            'TGL',
            'VISIMISI_ISI:ntext',
            'VISIMISI_DCRPT:ntext',
            // 'VISIMISI_IMG',
            // 'SET_ACTIVE',
            // 'CORP_ID',
            // 'DEP_ID',
            // 'DEP_SUB_ID',
            // 'GF_ID',
            // 'SEQ_ID',
            // 'JOBGRADE_ID',
            // 'CREATED_BY',
            // 'UPDATED_BY',
            // 'UPDATED_TIME',
            // 'STATUS',
          
			
			['class' => 'yii\grid\ActionColumn', 
					'template' => '{view}{update}',
                                        'contentOptions'=>[
                                            'style'=>'width:200px'
                                        ],
					'header'=>'Action',
					'buttons' => [
						'view'=>function($url, $model, $key){
								return Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px;">View </button>',
                                                                       
                                                                    ['view','id'=>$model->ID],
                                                                        [   
                                                                            'data-toggle'=>"modal",
                                                                            'data-target'=>"#modal-view",													
                                                                            'data-title'=> $model->ID,
									]);
                                                                },
                                                'update'=>function($url, $model, $key){
								return Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px;  margin-left:10px">Update </button>',
                                                                    ['update','id'=>$model->ID],
                                                                        [
                                                                            'data-toggle'=>"modal",
                                                                            'data-target'=>"#modal-form",
                                                                              'id'=>'modl2',
                                                                            'data-title'=> $model->ID,
									]);
                                                                },
                                                  
                                                    ],
                                                                            
			],
            
        ];
      
                                                
                                          
?>
        
      

<div class="barangumum-index" style="padding:10px;">
    

  <?= $grid = GridView::widget([
                        
			'dataProvider'=> $dataProvider,
			'filterModel' => $searchModel,
			'columns' => $gridColumns,
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
						['modelClass' => 'Visi',]),'/hrd/visi/create',[
							'data-toggle'=>"modal",
								'data-target'=>"#modal-form",
                                                                     'id'=>'modl',
									'class' => 'btn btn-success'						
												]),								
                            
                            
				'showFooter'=>false,
			],		
			
			'export' =>['target' => GridView::TARGET_BLANK,
                                    ],
                                      
			'exportConfig' => [
                        
				GridView::PDF => [
                                    'filename' => 'Regulasi'.'-'.date('ymdHis'),
                                 
//                                    'columns'=>$column,
                                 
                                           
          
          ],
				GridView::EXCEL => [ 'filename' => 'Regulasi'.'-'.date('ymdHis') ],
			],
		]);
       

?>


</div>
<?php

//js
$this->registerJs("
      
        $('#modal-view').on('show.bs.modal', function (event) {
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
       $.fn.modal.Constructor.prototype.enforceFocus = function(){};
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


?>
   
            <!--modal-->
            
               <?php
                  Modal::begin([
                            'id' => 'modal-view',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4> ',     
                             ]);
                
               
                    Modal::end();
            
                
             
                 Modal::begin([
                            'id' => 'modal-form',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                             ]);
                Modal::end();
                
                ?>
             
         </div>
    













  '