<?php
use \Yii;
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use app\models\hrd\Dept;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\editable\Editable;

use lukisongroup\hrd\models\Machine;
use lukisongroup\hrd\models\Key_list;
use lukisongroup\hrd\models\Employe;

$aryMachine = ArrayHelper::map(Machine::find()->all(),'TerminalID','MESIN_NM');
$aryKeylist = ArrayHelper::map(Key_list::find()->all(),'FunctionKey','FunctionKeyNM');
$aryEmploye = ArrayHelper::map(Employe::find()->where("STATUS<>3 AND EMP_STS<>3")->all(), function($model, $defaultValue) {
																								return $model->EMP_NM.'-'.$model->EMP_NM_BLK;
																							},function($model, $defaultValue) {
																								return $model->EMP_NM.'-'.$model->EMP_NM_BLK;
																							}
			);

$this->sideCorp = 'ESM-Trading Terms';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_trading_term';               /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Trading Terms ');   

	$aryStatus= [
		  ['STATUS' =>0, 'DESCRIP' => 'New'],		  
		  ['STATUS' =>1, 'DESCRIP' => 'Approved'],
		  ['STATUS' =>2, 'DESCRIP' => 'Reject']
	];	
	$valStatus = ArrayHelper::map($aryStatus, 'STATUS', 'DESCRIP'); 
 

 
	/*
	 * STATUS FLOW DATA
	 * 1. NEW		= 0 	| Create First
	 * 2. APPROVED	= 1 	| Approved
	 * 3. REJECT	= 101	| Reject
	*/
	function statusTerm($model){
		if($model['STATUS']==0){
			/*New*/
			return Html::a('<i class="fa fa-square-o fa-md"></i> New', '#',['class'=>'btn btn-info btn-xs', 'style'=>['width'=>'100px'],'title'=>'New']);
		}elseif($model['STATUS']==1){
			/*Approved*/
			return Html::a('<i class="fa fa-check-square-o fa-md"></i>Approved', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Approved']);
		}elseif ($model['STATUS']==3){
			/*REJECT*/
			return Html::a('<i class="fa fa-remove fa-md"></i>Reject ', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Reject']);
		};
	}
 
	$attDinamik =[];
	$hdrLabel1=[];
	//$hdrLabel2=[];
	$getHeaderLabelWrap=[];
	

	/*
	 * ID_TERM
	 * Colomn 0
	*/
	$attDinamik[]=[		
		'attribute'=>'ID_TERM',
		'label'=>'ID_TERM',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'filter'=>true,
		'filterOptions'=>[
			'style'=>'background-color:rgba(0, 95, 218, 0.3); align:center;',
			'vAlign'=>'middle',
		],
		'value'=>function($model){			
			return $model!=''?$model['NM_TERM'] .' '. Yii::$app->formatter->asDate($model['PERIOD_START'],'Y') . ' ,Periode : '.$model['PERIOD_START'].'-'.$model['PERIOD_END']:'1';
		},
		'group'=>true,
		//'groupedRow'=>true,
		//'subGroupOf'=>-1,
		//'groupOddCssClass'=>'kv-grouped-row',
		//'groupEvenCssClass'=>'kv-grouped-row',
		//'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10%',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(240, 195, 59, 0.4)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'10%',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(13, 127, 3, 0.1)',
			]
		],
		//'pageSummaryFunc'=>GridView::F_SUM,
		//'pageSummary'=>true,
		'pageSummaryOptions' => [
			'style'=>[
					'text-align'=>'right',		
					'font-family'=>'tahoma',
					'font-size'=>'8pt',	
					'text-decoration'=>'underline',
					'font-weight'=>'bold',
					'border-left-color'=>'transparant',		
					'border-left'=>'0px',									
			]
		],											
		//'footer'=>true,
		'groupHeader'=>function($model, $key, $index, $widget){ 			
			return [
				'mergeColumns'=>[[3,6]],		
				'content'=>[             // content to show in each summary cell
					//1=>$model['NM_TERM'],
					0=>'TARGET ',
					1=>$model['TARGET_VALUE'],
					2=>'RABATE ',
					3=>$model['RABATE_CNDT'],	
					7=>'GROWTH',
					8=>$model['GROWTH'],						
				],
				'contentFormats'=>[ 
					1=>['format'=>'number', 'decimals'=>2],
					3=>['format'=>'number','decimals'=>2],
					8=>['format'=>'number','decimals'=>2],
				],
				'contentOptions'=>[      // content html attributes for each summary cell
					0=>['style'=>'font-weight:bold;text-align:right;background-color:rgba(174, 255, 0, 0.4)'],
					1=>['style'=>'font-weight:bold;text-align:left;background-color:rgba(174, 255, 0, 0.4)'],  //Target Value
					2=>['style'=>'font-weight:bold;text-align:right;background-color:rgba(174, 255, 0, 0.4)'],
					3=>['style'=>'font-weight:bold;text-align:right;background-color:rgba(174, 255, 0, 0.4)'],					
					4=>['style'=>'font-weight:bold;text-align:right;background-color:rgba(174, 255, 0, 0.4)'],
					5=>['style'=>'font-weight:bold;text-align:right;background-color:rgba(174, 255, 0, 0.4)'],
					6=>['style'=>'font-weight:bold;text-align:right;background-color:rgba(174, 255, 0, 0.4)'],
					7=>['style'=>'font-weight:bold;text-align:right;background-color:rgba(174, 255, 0, 0.4)'],
					8=>['style'=>'font-weight:bold;text-align:right;background-color:rgba(174, 255, 0, 0.4)'],
					//6=>['style'=>'text-align:right;background-color:rgba(108, 95, 58, 0.3)'],
				],
			];
		},
		'groupFooter'=>function($model, $key, $index, $widget){ 			
			return [
				'mergeColumns'=>[[1,3]],		
				'content'=>[             // content to show in each summary cell
					//1=>$model['NM_TERM'],
					1=>'Summary Total',					
					4=>GridView::F_SUM,
					5=>GridView::F_SUM,
					6=>GridView::F_SUM,
					7=>GridView::F_SUM,
				],
				'contentFormats'=>[ 
					4=>['format'=>'number','decimals'=>2],
					5=>['format'=>'number', 'decimals'=>2],
					6=>['format'=>'number','decimals'=>2],
					7=>['format'=>'number','decimals'=>2],
				],
				'contentOptions'=>[      // content html attributes for each summary cell
					0=>['style'=>'font-weight:bold;text-align:right;background-color:rgba(53, 48, 26, 0.2)'],
					1=>['style'=>'font-weight:bold;text-align:right;background-color:rgba(53, 48, 26, 0.2)'],
					3=>['style'=>'font-weight:bold;text-align:right;background-color:rgba(53, 48, 26, 0.2)'],
					4=>['style'=>'font-weight:bold;text-align:right;background-color:rgba(53, 48, 26, 0.1)'],
					5=>['style'=>'font-weight:bold;text-align:right;background-color:rgba(53, 48, 26, 0.1)'],
					6=>['style'=>'font-weight:bold;text-align:right;background-color:rgba(53, 48, 26, 0.1)'],
					7=>['style'=>'text-align:right;background-color:rgba(53, 48, 26, 0.1)'],
					8=>['style'=>'text-align:right;background-color:rgba(53, 48, 26, 0.1)'],
				],
				'options'=>[	
					'style'=>[
						'font-weight:bold;'
					]
				], 		
			];
		},
	];	
	
	$hdrLabel1[] =[	
		'content'=>'TRAIDE INVESTMENT',
		'options'=>[
			'noWrap'=>true,
			'colspan'=>4,
			'class'=>'text-center info',								
			'style'=>[
				 'text-align'=>'center',
				 'width'=>'20px',
				 'font-family'=>'tahoma',
				 'font-size'=>'8pt',
				 'background-color'=>'rgba(0, 95, 218, 0.3)',								
			 ]
		 ],
	];
		
	/*
	 * INVES_TYPE
	 * Colomn 1
	*/
	$attDinamik[]=[		
		'attribute'=>'INVES_TYPE',
		//'label'=>'Trade Investment',
		'label'=>'Items Trade Investment',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'filter'=>$aryEmploye,
		'filterOptions'=>[
			'style'=>'background-color:rgba(0, 95, 218, 0.3); align:center;',
			'vAlign'=>'middle',
		],
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'15%',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(240, 195, 59, 0.4)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'15%',
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
					'font-family'=>'tahoma',
					'font-size'=>'8pt',	
					'text-decoration'=>'underline',
					'font-weight'=>'bold',
					'border-left-color'=>'transparant',		
					'border-left'=>'0px',									
			]
		],											
	];	
	
	/*
	 * BUDGET_SOURCE
	 * Colomn 2
	*/
	$attDinamik[]=[		
		'attribute'=>'BUDGET_SOURCE',
		'label'=>'Source',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'filter'=>$aryEmploye,
		'filterOptions'=>[
			'style'=>'background-color:rgba(0, 95, 218, 0.3); align:center;',
			'vAlign'=>'middle',
		],
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'15%',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(240, 195, 59, 0.4)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'15%',
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
					'font-family'=>'tahoma',
					'font-size'=>'8pt',	
					'text-decoration'=>'underline',
					'font-weight'=>'bold',
					'border-left-color'=>'transparant',		
					'border-left'=>'0px',									
			]
		],											
	];
	
	/*
	 * PERIODE_INVEST
	 * Colomn 3
	*/
	$attDinamik[]=[		
		'attribute'=>'PERIODE_INVEST',
		'label'=>'Periode',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'filter'=>$aryEmploye,
		'filterOptions'=>[
			'style'=>'background-color:rgba(0, 95, 218, 0.3); align:center;',
			'vAlign'=>'middle',
		],
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10%',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(240, 195, 59, 0.4)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'10%',
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
					'font-family'=>'tahoma',
					'font-size'=>'8pt',	
					'text-decoration'=>'underline',
					'font-weight'=>'bold',
					'border-left-color'=>'transparant',		
					'border-left'=>'0px',									
			]
		],											
	];
	/*
	 * BUDGET_PLAN
	 * Colomn 4
	*/
	$attDinamik[]=[		
		'attribute'=>'BUDGET_PLAN',
		'label'=>'Plan',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'filter'=>$aryEmploye,
		'filterOptions'=>[
			'style'=>'background-color:rgba(0, 95, 218, 0.3); align:center;',
			'vAlign'=>'middle',
		],
		'format'=>['decimal', 2],
		'noWrap'=>true,
		//'mergeHeader'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'13%',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(240, 195, 59, 0.4)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'13%',
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
					'font-family'=>'tahoma',
					'font-size'=>'8pt',	
					'text-decoration'=>'underline',
					'font-weight'=>'bold',
					'border-left-color'=>'transparant',		
					'border-left'=>'0px',									
			]
		],											
	];
	
	/*
	 * BUDGET_PLAN PERCENT
	 * Colomn 5
	*/
	$attDinamik[]=[		
		'class'=>'kartik\grid\FormulaColumn',
		'header'=>'%',
		'label'=>'Customer',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'filter'=>$aryEmploye,
		'filterOptions'=>[
			'style'=>'background-color:rgba(0, 95, 218, 0.3); align:center;',
			'vAlign'=>'middle',
		],
		/* 'value'=>function($model){
			return $model['CUST_NM'];
		}, */
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'5%',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(240, 195, 59, 0.4)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'5%',
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
					'font-family'=>'tahoma',
					'font-size'=>'8pt',	
					'text-decoration'=>'underline',
					'font-weight'=>'bold',
					'border-left-color'=>'transparant',		
					'border-left'=>'0px',									
			]
		],											
	]; 
	$hdrLabel1[] =[	
		'content'=>'PLAN BUDGET',
		'options'=>[
			'noWrap'=>true,
			'colspan'=>2,
			'class'=>'text-center info',								
			'style'=>[
				 'text-align'=>'center',
				 'font-family'=>'tahoma',
				 'font-size'=>'8pt',
				 'background-color'=>'rgba(0, 95, 218, 0.3)',								
			 ]
		 ],
	]; 
	
	/*
	 * BUDGET_VALUE ACTUAL
	 * Colomn 6
	*/
	$attDinamik[]=[		
		'attribute'=>'BUDGET_ACTUAL',
		'label'=>'Actual',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'filter'=>$aryEmploye,
		'filterOptions'=>[
			'style'=>'background-color:rgba(0, 95, 218, 0.3); align:center;',
			'vAlign'=>'middle',
		],
		'format'=>['decimal', 2],
		'noWrap'=>true,
		//'mergeHeader'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'13%',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(240, 195, 59, 0.4)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'13%',
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
					'width'=>'15%',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',	
					'text-decoration'=>'underline',
					'font-weight'=>'bold',
					'border-left-color'=>'transparant',		
					'border-left'=>'0px',									
			]
		],											
	];
	/*
	 * BUDGET_ACTUAL PERCENT
	 * Colomn 7
	*/
	$attDinamik[]=[		
		'class'=>'kartik\grid\FormulaColumn',
		'header'=>'%',
		'label'=>'Customer',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'filter'=>$aryEmploye,
		'filterOptions'=>[
			'style'=>'background-color:rgba(0, 95, 218, 0.3); align:center;',
			'vAlign'=>'middle',
		],
		/* 'value'=>function($model){
			return $model['CUST_NM'];
		}, */
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'5%',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(240, 195, 59, 0.4)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'5%',
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
					'font-family'=>'tahoma',
					'font-size'=>'8pt',	
					'text-decoration'=>'underline',
					'font-weight'=>'bold',
					'border-left-color'=>'transparant',		
					'border-left'=>'0px',									
			]
		],											
	]; 
	$hdrLabel1[] =[	
		'content'=>'ACTUAL BUDGET',
		'options'=>[
			'noWrap'=>true,
			'colspan'=>2,
			'class'=>'text-center info',								
			'style'=>[
				 'text-align'=>'center',
				 'font-family'=>'tahoma',
				 'font-size'=>'8pt',
				 'background-color'=>'rgba(0, 95, 218, 0.3)',								
			 ]
		 ],
	]; 
	/*
	 * STATUS
	 * Colomn 8
	*/
	$attDinamik[]=[		
		'attribute'=>'STATUS',
		'label'=>'Status',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'filter'=>$valStatus,
		'filterOptions'=>[
			'style'=>'background-color:rgba(0, 95, 218, 0.3); align:center;',
			'vAlign'=>'middle',
		],
		'format' => 'html',
		'value'=>function ($model, $key, $index, $widget) {
			return statusTerm($model);
		},
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'15%',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(240, 195, 59, 0.4)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'15%',
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
					'font-family'=>'tahoma',
					'font-size'=>'8pt',	
					'text-decoration'=>'underline',
					'font-weight'=>'bold',
					'border-left-color'=>'transparant',		
					'border-left'=>'0px',									
			]
		],											
	];
	$hdrLabel1[] =[	
		'content'=>'',
		'options'=>[
			'noWrap'=>true,
			'colspan'=>1,
			'class'=>'text-center info',								
			'style'=>[
				 'text-align'=>'center',
				 'font-family'=>'tahoma',
				 'font-size'=>'8pt',
				 'background-color'=>'rgba(0, 95, 218, 0.3)',								
			 ]
		 ],
	]; 
	$hdrLabel1_ALL =[
		'columns'=>array_merge($hdrLabel1),
	];
	$getHeaderLabelWrap =[
		'rows'=>$hdrLabel1_ALL
	];
	/*
	 * LOG ABSENSI
	 * @author ptrnov  [piter@lukison.com]
	 * @since 1.2
	*/
	$gvTermRpt=GridView::widget([
		'id'=>'term-rpt',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,		
		'beforeHeader'=>$getHeaderLabelWrap,		
		'showPageSummary' => true,
		'columns' =>$attDinamik,
		//'floatHeader'=>true,
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'term-rpt',
			],
		],
		 'panel' => [
					'heading'=>'<h3 class="panel-title">CUSTOMERS TERM REPORT</h3>',
					'type'=>'info',
					// 'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Customer ',
							// ['modelClass' => 'Kategori',]),'/master/barang/create',[
								// 'data-toggle'=>"modal",
									// 'data-target'=>"#modal-create",
										// 'class' => 'btn btn-success'
													// ]), 
					'showFooter'=>false,
		],
		'toolbar'=> [
			//'{items}',
		],  
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>true,
		//'perfectScrollbar'=>true,
		//'autoXlFormat'=>true,
		//'export' => false,		
	]);
	
	
?>


<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;margin-right:5px">
	<?php 
		/* $items=[
			[
				'label'=>'<i class="glyphicon glyphicon-home"></i> Daily Absensi','content'=>$gvTermRpt,
				'contentOptions'=>[
					'style'=>[
						//'text-align'=>'center',
						'bordered'=>true,
						'width'=>'100%',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(13, 127, 3, 0.1)',
					]
				],
				//'active'=>true,
			],		
			[
				'label'=>'<i class="glyphicon glyphicon-home"></i> OverTime','content'=>'',
			],		
			[
				'label'=>'<i class="glyphicon glyphicon-home"></i> Absensi Rekap','content'=>'',
			],
		];	 */
		echo $gvTermRpt;
		/* echo TabsX::widget([
			'id'=>'tab-emp',
			'items'=>$items,
			'position'=>TabsX::POS_ABOVE,
			//'height'=>'tab-height-xs',
			//'width'=>'tab-height-xs',
			//'bordered'=>true,
			'encodeLabels'=>false,
			//'align'=>TabsX::ALIGN_LEFT,
		]); */
	?>   
</div>
<?php
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
      	'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Masukan Data Warga</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(0, 95, 218, 0.3)',	
		],
    ]);
    Modal::end();

	$this->registerJs("
		$.fn.modal.Constructor.prototype.enforceFocus = function(){};
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
      	'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">View Data Warga</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(0, 95, 218, 0.3)',	
		],
    ]);
    Modal::end();
	
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
	 Modal::begin([
        'id' => 'modal-edit',
      	'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Edit Data Warga</h4></div>',
		'headerOptions'=>[								
				'style'=> 'border-radius:5px; background-color: rgba(0, 95, 218, 0.3)',	
		],
    ]);
    Modal::end();
?>



<?php
/* $this->registerJs("
		$(document).on('click', '[data-toggle-approved]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-approved');
			$.ajax({
					url: '/hrd/absen-log/cari?int=1',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							// Success
							$.pjax.reload({container:'#absenlog'});
						} else {
							// Fail
						}
					}
				});

		});
	",$this::POS_READY); */
?>


