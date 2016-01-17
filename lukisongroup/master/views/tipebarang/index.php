<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
$this->sideCorp = 'Master Data Umum';                  	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                   	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Type Barang');

	$aryParent= [
		  ['PARENT' => 0, 'PAREN_NM' => 'UMUM'],		  
		  ['PARENT' => 1, 'PAREN_NM' => 'PRODAK'],
	];	
	$valParent = ArrayHelper::map($aryParent, 'PARENT', 'PAREN_NM');
	$aryStt= [
		  ['STATUS' => 0, 'STT_NM' => 'DISABLE'],		  
		  ['STATUS' => 1, 'STT_NM' => 'ENABLE'],
	];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');
//$Combo_Corp = ArrayHelper::map(Corp::find()->orderBy('SORT')->asArray()->all(), 'CORP_NM','CORP_NM');
?>   

	<?php 
	 // Html::button('Tipe barang', ['value'=>$url,'class' => 'btn btn-success','id'=>'btn']) ;

		$gridColumns = [
			[
				'class'=>'kartik\grid\SerialColumn',
				'contentOptions'=>['class'=>'kartik-sheet-style'],
				'width'=>'10px',
				'header'=>'No.',
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'verdana, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(62, 0, 44, 0.2)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				], 		
			],	        
            [
				'attribute' =>'PARENT',
				'label'=>'Parent',
				'filter' => $valParent,				
				'value'=>function($model, $key, $index, $widget){
					if($model->PARENT==1){
						return 'PRODAK';
					}else{
						return 'UMUM';
					}
					
				},
				'group'=>true,
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'150px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(62, 0, 44, 0.2)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'150px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				], 
			], 
			 /*  [
				'attribute' =>'KD_TYPE',
			], */     
			[
				'attribute' =>'NM_TYPE',
				'label'=>'Type',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'200px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(62, 0, 44, 0.2)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'200px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				], 				
			],
			[
				'attribute' =>'NOTE',
				'label'=>'Note',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'600px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(62, 0, 44, 0.2)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'600px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				], 
			],                       
			[
				'attribute' => 'STATUS',
				'filter' => $valStt,	
				'format' => 'raw',						
				'hAlign'=>'center',
				'value'=>function($model){
				   if ($model->STATUS == 1) {
						return Html::a('<i class="fa fa-edit"></i> &nbsp;Enable', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
					} else if ($model->STATUS == 0) {
						return Html::a('<i class="fa fa-close"></i> &nbsp;Disable', '',['class'=>'btn btn-danger btn-xs', 'title'=>'Deactive']);
					} 
				},
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'80px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(62, 0, 44, 0.2)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'80px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				], 	
			],
			[
				'class'=>'kartik\grid\ActionColumn',
				'dropdown' => true,
				'template' => '{view}{update}{delete}',
				'dropdownOptions'=>['class'=>'pull-right dropup'],									
				'buttons' => [
					'view' =>function($url, $model, $key){
                                    return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
                                                                ['view','ID'=>$model->ID,'KD_TYPE'=>$model->KD_TYPE],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-view",
                                                                'data-title'=> $model->ID,
                                                                ]). '</li>' . PHP_EOL;
                            },
                            'update' =>function($url, $model, $key){
                                    return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Edit'),
                                                                ['update','ID'=>$model->ID,'KD_TYPE'=>$model->KD_TYPE],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-edit",
                                                                'data-title'=> $model->KD_TYPE,
                                                                ]). '</li>' . PHP_EOL;
                            },
                            'delete' =>function($url, $model, $key){
                                    return  '<li>' .Html::a('<span class="fa fa-remove fa-dm"></span>'.Yii::t('app', 'delete'),
                                                                ['delete','ID'=>$model->ID,'KD_TYPE'=>$model->KD_TYPE],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-del",
                                                                'data-title'=> $model->KD_TYPE,
                                                                ]). '</li>' . PHP_EOL;
                            },
				],
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'150px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(62, 0, 44, 0.2)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'150px',
						'height'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				], 			
			],
		];


	 // Yii::$app->gv->grview($gridColumns,$dataProvider,$searchModel, 'Tipe Barang', 'tipe-barang','');//$this->title);
	
	?>
<div class="container-full">
	<div style="padding-left:15px; padding-right:15px">	
		<?= $grid = GridView::widget([
			'id'=>'type-grd-index',
			'dataProvider'=> $dataProvider,
			'filterModel' => $searchModel,
			'filterRowOptions'=>['style'=>'background-color:rgba(62, 0, 44, 0.2); align:center'],
			'columns' => $gridColumns,
			'pjax'=>true,
			'pjaxSettings'=>[
				'options'=>[
					'enablePushState'=>false,
					'id'=>'type-grd-index',
				   ],						  
			],
			'hover'=>true, //cursor select
			'responsive'=>true,
			'responsiveWrap'=>true,
			'bordered'=>true,
			'striped'=>'4px',
			'autoXlFormat'=>true,
			'toolbar' => [
				'{export}',
			],
			'panel' => [
				'heading'=>'<h3 class="panel-title">ITEMS TYPE</h3>',
				'type'=>'warning',
				'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Type',
						['modelClass' => 'Tipebarang',]),'/master/tipebarang/create',[
							'data-toggle'=>"modal",
								'data-target'=>"#modal-create",							
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
</div>


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
        $('#modal-edit').on('show.bs.modal', function (event) {
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
        $('#modal-del').on('show.bs.modal', function (event) {
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
        $('#modal-create').on('show.bs.modal', function (event) {
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
        'id' => 'modal-create',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Type</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(62, 0, 44, 0.2)',	
		],
    ]);
    Modal::end();
    
    Modal::begin([
        'id' => 'modal-del',
        'header' => '<h4 class="modal-title">Delete Items Type</h4>',
    ]);
    Modal::end();
    
    Modal::begin([
        'id' => 'modal-view',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-eye"></div><div><h4 class="modal-title">View Type</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(62, 0, 44, 0.2)',	
		],		
    ]);
    Modal::end();
    
      Modal::begin([
        'id' => 'modal-edit',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-edit"></div><div><h4 class="modal-title">View Type</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(62, 0, 44, 0.2)',	
		],
    ]);
    Modal::end();
?>
