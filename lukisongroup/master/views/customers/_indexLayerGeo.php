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
		['ID' =>0, 'ATTR' =>['FIELD'=>'GEO_ID','SIZE' => '10px','label'=>'GEO_ID','align'=>'left']],		  
		['ID' =>1, 'ATTR' =>['FIELD'=>'GEO_NM','SIZE' => '20px','label'=>'GEO_NM','align'=>'left']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'GEO_DCRIP','SIZE' => '10px','label'=>'DCRIPT','align'=>'left']],
		['ID' =>3, 'ATTR' =>['FIELD'=>'START_LAT','SIZE' => '10px','label'=>'START.LAT','align'=>'left']],
		['ID' =>4, 'ATTR' =>['FIELD'=>'START_LONG','SIZE' => '10px','label'=>'START.LONG','align'=>'left']],
		['ID' =>5, 'ATTR' =>['FIELD'=>'CUST_MAX_NORMAL','SIZE' => '10px','label'=>'CUST.MAX','align'=>'left']],
		['ID' =>6, 'ATTR' =>['FIELD'=>'CUST_MAX_LAYER','SIZE' => '10px','label'=>'CUST.MAX.LAYER','align'=>'left']],
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
	
	/*ACTION ATTRIBUTE*/
	$attDinamik[]=[
		'class'=>'kartik\grid\ActionColumn',
		'dropdown' => true,
		//'template' => '{view}{edit0}{edit1}{edit2}{edit3}{lihat}',
		'template' => '{view}',
		'dropdownOptions'=>['class'=>'pull-left dropdown'],
		'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
		'buttons' => [				
			'edit0' =>function($url, $model, $key){
					return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Set Identity'),
												['/master/employe/edit-identity','id'=>$model->GEO_ID],[
												'data-toggle'=>"modal",
												'data-target'=>"#edit-title",
												'data-title'=> $model->GEO_ID,
												]). '</li>' . PHP_EOL;
			},
			'edit1' =>function($url, $model, $key){
					return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Set Title'),
												['/master/employe/edit-titel','id'=>$model->GEO_ID],[
												'data-toggle'=>"modal",
												'data-target'=>"#edit-title",
												'data-title'=> $model->GEO_ID,
												]). '</li>' . PHP_EOL;
			},
			'edit2' =>function($url, $model, $key){
					return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Set Profile'),
												['/master/employe/edit','id'=>$model->GEO_ID],[
												'data-toggle'=>"modal",
												'data-target'=>"#edit-profile",
												'data-title'=> $model->GEO_ID,
												]). '</li>' . PHP_EOL;
			},
			'edit3' =>function($url, $model, $key) {
					//$gF=getPermissionEmp()->GF_ID;
					//if ($gF<=4){
						return  '<li>' . Html::a('<span class="fa fa-money fa-dm"></span>'.Yii::t('app', 'Set Payroll'),
												['/master/employe/edit','id'=>$model->GEO_ID],[
												'data-toggle'=>"modal",
												'data-target'=>"#edit-payroll",
												]). '</li>' . PHP_EOL;
					//}
			},
			'view' =>function($url, $model, $key){
					return  '<li>' .Html::button('<span class="fa fa-eye fa-dm"></span>  '.Yii::t('app', 'View'),
												['value'=>url::to(['/master/employe/view','id'=>$model->GEO_ID]),
												'id'=>'modalButton',													
												'style'=>['width'=>'100%','text-align'=>'left','border'=>0, 'background-color'=>'white', 'padding-left'=>'20px'],
												]). '</li>' . PHP_EOL; 
												
												/* return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),'',
												['value'=>url::to(['/master/employe/view?id='.$model->GEO_ID]),
												//['value'=>url::to(['/master/employe/view','id'=>$model->GEO_ID]),
												'id'=>'modalButton',
												//'data-toggle'=>"modal",
												//'data-target'=>"#modal-view",
												'data-title'=> $model->GEO_ID,
												//'data-ajax'=>true,
												]). '</li>' . PHP_EOL;  */
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
		
	$emp_active= GridView::widget([
		'id'=>'active-emp',
		'dataProvider' => $dataProviderGeo,
		'filterModel' => $searchModelGeo,
		'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],				
		'columns' =>$attDinamik,
		'toolbar' => [
			'{export}',
		],	
		'panel'=>[
			//'heading'=>'<h3 class="panel-title">Employee List</h3>',
			'heading'=>false,
			'type'=>'warning',
			'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create Geografis ',
									['modelClass' => 'Kategori',]),'#',[
										'data-toggle'=>"modal",
										'data-target'=>"#modal-create",
										'class' => 'btn btn-success btn-sm'
									]
						).' '.
						Html::a('<i class="fa fa-history "></i> '.Yii::t('app', 'Refresh'),
									'/master/customers/esm-index-geo',
									[
									  // 'id'=>'refresh-cust',
									   'class' => 'btn btn-info btn-sm',
									   //'data-pjax'=>false,
									]
						).' '.
						Html::a('<i class="fa fa-file-excel-o"></i> '.Yii::t('app', 'Export'),
									'/export/layer',
									[
										//'id'=>'export-data',
										//'data-pjax' => true,
										'class' => 'btn btn-info btn-sm'
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
				['label' => '<span class="fa fa-cogs fa-md"></span>Alias Customers', 'url' => '/master/customers/login-alias','linkOptions'=>['id'=>'performance','data-toggle'=>'modal','data-target'=>'#formlogin']],
				'<li class="divider"></li>',
				['label' => 'Properties', 'items' => [
					['label' => '<span class="fa fa-flag fa-md"></span>Kota', 'url' => '/master/customers/esm-index-city'],
					['label' => '<span class="fa fa-flag-o fa-md"></span>Province', 'url' => '/master/customers/esm-index-provinsi'],
					['label' => '<span class="fa fa-table fa-md"></span>Category', 'url' => '/master/customers/esm-index-kategori'],
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

