<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;
use yii\helpers\Url;
use kartik\nav\NavX;

$this->params['breadcrumbs'][] = $this->title;
$this->sideCorp = 'Customers';                 				 /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = $sideMenu_control;//'umum_datamaster';   	 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Customers'); 

	/*
	 * PENGUNAAN DALAM GRID
	 * Arry Setting Attribute
	 * @author ptrnov [ptr.nov@gmail.com]
	 * @since 1.2
		foreach($valFields as $key =>$value[])
		{
			print_r($value[0]['FIELD'].','.$value[0]['SIZE']);		//SATU
			print_r($value[$key]['FIELD'].','.$value[0]['SIZE']);	//ARRAY 0-end		
		} 
	*/	
	$aryField= [
		['ID' =>0, 'ATTR' =>['FIELD'=>'LAYER_ID','SIZE' => '10px','label'=>'LAYER_ID','align'=>'left']],		  
		['ID' =>1, 'ATTR' =>['FIELD'=>'LAYER_NM','SIZE' => '20px','label'=>'LAYER_NM','align'=>'left']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'DCRIPT','SIZE' => '10px','label'=>'DCRIPT','align'=>'left']]
	];	
	$valFields = ArrayHelper::map($aryField, 'ID', 'ATTR'); 		
	

	/*
	 * GRIDVIEW COLUMN
	 * @author ptrnov [ptr.nov@gmail.com]
	 * @since 1.2
	*/	
	$attDinamik =[];
	/*NO ATTRIBUTE*/
	$attDinamik[] =[			
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
	];
	
	
	
	
	/*OTHER ATTRIBUTE*/
	foreach($valFields as $key =>$value[]){
		$filterWidgetOpt='';
		//$filterInputOpt='';
		if ($value[$key]['FIELD']=='depNm'){				
			//$gvfilterType=GridView::FILTER_SELECT2;
			//$gvfilterType=false;
			$gvfilter =$aryDeptId;
			/* $filterWidgetOpt=[				
				'pluginOptions'=>['allowClear'=>true],	
				//'placeholder'=>'Any author'					
			]; */
			//$filterInputOpt=['placeholder'=>'Any author'];
		}elseif($value[$key]['FIELD']=='cabNm'){
			$gvfilterType=false;
			$gvfilter =$aryCbgId;
		}elseif($value[$key]['FIELD']=='gfNm'){
			$gvfilterType=false;
			$gvfilter =$aryGfId;
		}elseif($value[$key]['FIELD']=='stsKerjaNm'){
			$gvfilterType=false;
			$gvfilter =$arySttId;
		}elseif($value[$key]['FIELD']=='gradingNm'){
			$gvfilterType=false;
			$gvfilter=$aryGradingId;
		}
		elseif($value[$key]['FIELD']=='timeTableNm'){
			$gvfilterType=false;
			$gvfilter=$aryTimeTableId;
		} /*elseif($value[$key]['FIELD']=='KAR_TGLM'){
			$gvfilterType=GridView::FILTER_DATE_RANGE;
			$gvfilter=true;
			$filterWidgetOpt=[
				//'attribute' =>'KAR_TGLM',
				'presetDropdown'=>TRUE,
				'convertFormat'=>true,
					'pluginOptions'=>[
						'format'=>'Y-m-d',
						'separator' => '-',
						'opens'=>'left'
					],
			];
		} */else{
			$gvfilterType=false;
			$gvfilter=true;
			$filterWidgetOpt=false;		
			//$filterInputOpt=false;						
		};				
			
		$attDinamik[]=[		
			'attribute'=>$value[$key]['FIELD'],
			'label'=>$value[$key]['label'],
			'filterType'=>$gvfilterType,
			'filter'=>$gvfilter,
			'filterWidgetOptions'=>$filterWidgetOpt,	
			//'filterInputOptions'=>$filterInputOpt,				
			'hAlign'=>'right',
			'vAlign'=>'middle',
			//'mergeHeader'=>true,
			'noWrap'=>true,			
			'headerOptions'=>[		
					'style'=>[									
					'text-align'=>'center',
					'width'=>$value[$key]['FIELD'],
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],  
			'contentOptions'=>[
				'style'=>[
					'text-align'=>$value[$key]['align'],
					//'width'=>'12px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(13, 127, 3, 0.1)',
				]
			],
			//'pageSummaryFunc'=>GridView::F_SUM,
			//'pageSummary'=>true,
			'pageSummaryOptions' => [
				'style'=>[
						'text-align'=>'right',		
						//'width'=>'12px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',	
						'text-decoration'=>'underline',
						'font-weight'=>'bold',
						'border-left-color'=>'transparant',		
						'border-left'=>'0px',									
				]
			],	
		];	
	};

	/*ACTION ATTRIBUTE*/
	$attDinamik[]=[
		'class'=>'kartik\grid\ActionColumn',
		'dropdown' => true,
		//'template' => '{view}{edit0}{edit1}{edit2}{edit3}{lihat}',
		'template' => '{view}{edit}{delete}',
		'dropdownOptions'=>['class'=>'pull-right dropdown'],
		'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
		'buttons' => [				
			'edit' =>function($url, $model, $key){
					return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Edit'),
												['/master/customers/edit-layers','id'=>$model->LAYER_ID],[
												'data-toggle'=>"modal",
												'data-target'=>"#edit-layers",
												'data-title'=> $model->LAYER_ID,
												]). '</li>' . PHP_EOL;
			},
			'delete' =>function($url, $model, $key){
					return  '<li>' . Html::a('<span class="fa fa-trash fa-dm"></span>'.Yii::t('app', 'delete'),
												['/master/customers/delete-layers','id'=>$model->LAYER_ID]
												). '</li>' . PHP_EOL;
			},
			'view' =>function($url, $model, $key){
					return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>  '.Yii::t('app', 'View'),
												['/master/customers/view-layers','id'=>$model->LAYER_ID],[
												'data-toggle'=>"modal",
												'data-target'=>"#view-layers",
												'data-title'=> $model->LAYER_ID,													
												]). '</li>' . PHP_EOL; 
												
										
			},
		],
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'height'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		],
	
	];			
		
	$emp_active= GridView::widget([
		'id'=>'active-emp',
		'dataProvider' => $dataProviderLayer,
		'filterModel' => $searchModellayer,
		'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],				
		'columns' =>$attDinamik,
		'toolbar' => [
			'{export}',
		],	
		'panel'=>[
			//'heading'=>'<h3 class="panel-title">Employee List</h3>',
			'heading'=>false,
			'type'=>'warning',
			'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create Layer ',
									['modelClass' => 'Kategori',]),'/master/customers/tambah-layers',[
										'data-toggle'=>"modal",
										'data-target'=>"#modal-create",
										'class' => 'btn btn-success btn-xs'
									]
						).' '.
						Html::a('<i class="fa fa-history "></i> '.Yii::t('app', 'Refresh'),
									'/master/customers/esm-index-layer',
									[
									  // 'id'=>'refresh-cust',
									   'class' => 'btn btn-info btn-xs',
									   //'data-pjax'=>false,
									]
						).' '.
						Html::a('<i class="fa fa-file-excel-o"></i> '.Yii::t('app', 'Export'),
									'/export/layer',
									[
										//'id'=>'export-data',
										//'data-pjax' => true,
										'class' => 'btn btn-info btn-xs'
									]
						),
						'showFooter'=>false,
		],
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'active-emp',
			],
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'bordered'=>true,
		'striped'=>true,
		//'autoXlFormat'=>true,
		'export'=>[//export like view grid --ptr.nov-
			'fontAwesome'=>true,
			'showConfirmAlert'=>false,
			'target'=>GridView::TARGET_BLANK
		],
		//'floatHeader'=>false,
		 'floatHeaderOptions'=>['scrollingTop'=>'200'] 
	]);

?>
<?php
	 $navmenu= NavX::widget([
		'options'=>['class'=>'nav nav-tabs'],
		'encodeLabels' => false,
		'items' => [
			['label' => 'MENU', 'active'=>true, 'items' => [
				['label' => '<span class="fa fa-user fa-md"></span>Customers', 'url' => '/master/customers/esm-index'],
				['label' => '<span class="fa fa-cogs fa-md"></span>Alias Customers', 'url' => '/master/customers/index-alias'],
				'<li class="divider"></li>',
				['label' => 'Properties', 'items' => [
					['label' => '<span class="fa fa-flag fa-md"></span>Kota', 'url' => '/master/kota-customers/esm-index-city'],
					['label' => '<span class="fa fa-flag-o fa-md"></span>Province', 'url' => '/master/customers/esm-index-provinsi'],
					['label' => '<span class="fa fa-table fa-md"></span>Category', 'url' => '/master/customers-kategori/esm-index-kategori'],
					['label' => '<span class="fa fa-table fa-md"></span>Geografis', 'url' => '/master/customers/esm-index-geo'],
					['label' => '<span class="fa fa-table fa-md"></span>Layers', 'url' => '/master/customers/esm-index-layer'],
					['label' => '<span class="fa fa-table fa-md"></span>Layers Mutasi', 'url' => '/master/customers/esm-index-layermutasi'],
					'<li class="divider"></li>',
					['label' => '<span class="fa fa-map-marker fa-md"></span>Customers Map', 'url' => '/master/customers/esm-map'],
				]],
			]],

		]
	]);
?>
<div class="content">
  <div  class="row" style="padding-left:3px">
		<div class="col-sm-12 col-md-12 col-lg-12" >
		  <!-- Menu !-->
		  <?php
				echo $navmenu;
		  ?>
		  <!-- Customers !-->
		</div>
		<div class="col-sm-12">
			<?php
				echo $emp_active;
			?>
		</div>
	</div>
</div>


<?php
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
  'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">New Layers</h4></div>',
  'headerOptions'=>[
      'style'=> 'border-radius:5px; background-color: rgba(126, 189, 188, 0.9)',
  ],
]);
Modal::end();

$this->registerJs("
  $.fn.modal.Constructor.prototype.enforceFocus = function(){};

  $('#edit-layers').on('show.bs.modal', function (event) {
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
  'id' => 'edit-layers',
  'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">New Layers</h4></div>',
  'headerOptions'=>[
      'style'=> 'border-radius:5px; background-color: rgba(126, 189, 188, 0.9)',
  ],
]);
Modal::end();

$this->registerJs("
  $.fn.modal.Constructor.prototype.enforceFocus = function(){};

  $('#view-layers').on('show.bs.modal', function (event) {
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
  'id' => 'view-layers',
  'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">New Layers</h4></div>',
  'headerOptions'=>[
      'style'=> 'border-radius:5px; background-color: rgba(126, 189, 188, 0.9)',
  ],
]);
Modal::end();

