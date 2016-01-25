<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use lukisongroup\master\models\Barang;
use lukisongroup\hrd\models\Corp;
use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\Kategori;

//$userCorp = ArrayHelper::map(Corp::find()->where('CORP_STS<>3')->andWhere('CORP_ID="SSS" OR CORP_ID="MM"')->all(), 'CORP_ID', 'CORP_NM');
$typeBrg = ArrayHelper::map(Tipebarang::find()->where('STATUS<>3 and PARENT=1')->groupBy('NM_TYPE')->all(), 'KD_TYPE', 'NM_TYPE');
$kat = ArrayHelper::map(Kategori::find()->where('STATUS<>3 and PARENT=1')->groupBy('NM_KATEGORI')->all(), 'KD_KATEGORI', 'NM_KATEGORI'); 

$this->sideCorp = 'Master Data';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';               /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Barang ');
	$aryStt= [
		  ['STATUS' => 0, 'STT_NM' => 'DISABLE'],		  
		  ['STATUS' => 1, 'STT_NM' => 'ENABLE'],
	];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');

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
						'background-color'=>'rgba(97, 211, 96, 0.3)',
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
			/* [
				'attribute' =>'nmcorp',
				'label'=>'Corporation',
				'filter' => $userCorp,
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'150px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'150px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				], 
			], */
			[
				'attribute' => 'tipebrg', 
				'label'=>'Type',
				'filterType'=>GridView::FILTER_SELECT2,
				'filter' => $typeBrg,	
				'filterWidgetOptions'=>[
					'pluginOptions'=>['allowClear'=>true],
				],
				'filterInputOptions'=>['placeholder'=>'Any author'],
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'150px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'150px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				], 				
			],
			[
				'attribute' => 'nmkategori',
				'label'=>'Category',
				'filterType'=>GridView::FILTER_SELECT2,
				'filter' => $kat,
				'group'=>true,				
				'filterWidgetOptions'=>[
					'pluginOptions'=>['allowClear'=>true],
				],
				'filterInputOptions'=>['placeholder'=>'Any author'],
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'groupFooter'=>function($model, $key, $index, $widget){ 
					return [
						'mergeColumns'=>[[1,11]], 
						'content'=>[             // content to show in each summary cell
							4=>'Group ' . $model->nmkategori,
							//6=>'100',
							// 5=>GridView::F_SUM,
							// 6=>GridView::F_SUM,
						],
						'contentOptions'=>[      // content html attributes for each summary cell
							4=>['style'=>'font-variant:small-caps'],
							4=>['style'=>'text-align:left'],
							//5=>['style'=>'text-align:right'],
							//6=>['style'=>'text-align:right'],
						],
						'options'=>['class'=>'danger','style'=>'font-weight:bold;']
					];
				},
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'150px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'150px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				], 				
			],
			[
				'attribute' => 'KD_BARANG',
				'label'=>'SKU',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'100px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'100px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				], 				
			],
			[
				'attribute' => 'NM_BARANG',
				'label'=>'Item Name',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'400px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'400px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				], 				
			],
			[
				'attribute' => 'unitbrg',
				'label'=>'Item Unit',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'80px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'80px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				], 				
			],
			[
				'class'=>'kartik\grid\EditableColumn',
				'attribute' => 'HARGA_PABRIK', 
				'label'=>'Pabrik',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'format'=>['decimal', 2],
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'50px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'50px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				], 				
			],
			[
				'class'=>'kartik\grid\EditableColumn',
				'attribute' => 'HARGA_LG', 
				'label'=>'Lukison',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'format'=>['decimal', 2],
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'50px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'50px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				], 				
			],
			[
				'class'=>'kartik\grid\EditableColumn',
				'attribute' => 'HARGA_DIST', 
				'label'=>'Distributor',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'format'=>['decimal', 2],
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'50px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'50px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				], 				
			],
			[
				'class'=>'kartik\grid\EditableColumn',
				'attribute' => 'HARGA_SALES', 
				'label'=>'Sales LG',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'format'=>['decimal', 2],
				'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'80px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'80px',
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
						return Html::a('<i class="fa fa-check"></i> &nbsp;Enable', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
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
						'background-color'=>'rgba(97, 211, 96, 0.3)',
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
			/* [
				'class'=>'kartik\grid\ActionColumn',
				'dropdown' => true,
				'template' => '{view}{update}{price}',
				'dropdownOptions'=>['class'=>'pull-right dropup'],									
				'buttons' => [
						'view' =>function($url, $model, $key){
								return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
															['/master/barang/view','id'=>$model->ID],[
															'data-toggle'=>"modal",
															'data-target'=>"#modal-view",
															'data-title'=> $model->KD_BARANG,
															]). '</li>' . PHP_EOL;
						},
						'update' =>function($url, $model, $key){
								return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Edit'),
															['update','id'=>$model->ID],[
															'data-toggle'=>"modal",
															'data-target'=>"#modal-edit",
															'data-title'=> $model->KD_BARANG,
															]). '</li>' . PHP_EOL;
						},
                        'price' =>function($url, $model, $key){
								return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Price List'),
															['/master/barang/update','id'=>$model->ID],[
															'data-toggle'=>"modal",
															'data-target'=>"#modal-price",
															'data-title'=> $model->KD_BARANG,
															]). '</li>' . PHP_EOL;
						},
                        
                ],
                'headerOptions'=>[				
					'style'=>[
						'text-align'=>'center',
						'width'=>'150px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
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
                
            ], */
    
        ]; 
	?>

		
<div class="container-full">
	<div style="padding-left:15px; padding-right:15px">			
		<?= $grid = GridView::widget([
				'id'=>'gv-brg-prodak',
				'dataProvider'=> $dataProvider,
				'filterModel' => $searchModel,
				'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
				'showPageSummary' => true,
				'beforeHeader'=>[
					[
						'columns'=>[
							['content'=>'Option Barang', 'options'=>['colspan'=>4,'class'=>'text-center info',]], 
							['content'=>'Details Barang', 'options'=>['colspan'=>3,'class'=>'text-center info',]], 
							['content'=>'Harga / Pcs', 'options'=>['colspan'=>5, 'class'=>'text-center info']], 
							//['content'=>'Action Status ', 'options'=>['colspan'=>1,  'class'=>'text-center info']], 
						],
					]
				], 
				'columns' => $gridColumns,
				'pjax'=>true,
					'pjaxSettings'=>[
						'options'=>[
							'enablePushState'=>false,
							'id'=>'gv-brg-prodak',
						],
					 ],
				'toolbar' => [
					'{export}',
				],
				'panel' => [
					'heading'=>'<h3 class="panel-title">Price List Production, PT.Gosend</h3>',
					'type'=>'warning',
					'before'=> Html::a('<i class="fa fa-power-off fa-lg"></i> '.Yii::t('app', 'logout ',
							['modelClass' => 'Kategori',]),'/master/barang/price-logout',[
								//'data-toggle'=>"modal",
								//	'data-target'=>"#modal-create",							
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
	</div>
</div>	
	
	
	
	
<!--

<p>
<i class="fa fa-check fa-sm" style="color:blue;" title="Aktif"></i> Aktif  &nbsp;&nbsp;&nbsp;&nbsp;
<i class="fa fa-times fa-sm" style="color:red;" title="Tidak Aktif" ></i> Tidak Aktif
</p>
!-->


<?php
	/*View*/
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
	Modal::begin([
        'id' => 'modal-view',
       'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">View Items Sku</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',	
		],
    ]);
    Modal::end();
	
	/*Edit*/
	$this->registerJs("
		 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
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
    Modal::begin([
        'id' => 'modal-edit',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-edit"></div><div><h4 class="modal-title">Edit Items Sku</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',	
		],
    ]);
	
	/*Create*/
    Modal::end();
	$this->registerJs("
		 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
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
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Sku</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',	
		],
    ]);
    Modal::end();
	
	/*Price Author*/
	$this->registerJs("
		 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
		 $('#modal-price').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var modal = $(this)
			var title = button.data('title') 
			var href = button.attr('href') 
			//modal.find('.modal-title').html(title)
			modal.find('.modal-body').html('<i class=\"fa fa-dolar fa-spin\"></i>')
			$.post(href)
				.done(function( data ) {
					modal.find('.modal-body').html(data)
				});
			})
	",$this::POS_READY);
    Modal::begin([
        'id' => 'modal-price',
        'header' => '<h4 class="modal-title">Prize Autorize</h4>',		
    ]);
    Modal::end();
	    
	
	
	
	
	