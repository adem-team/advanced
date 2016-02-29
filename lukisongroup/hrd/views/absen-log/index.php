<?php
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
//use app\models\hrd\Dept;
use kartik\grid\GridView;
//use kartik\widgets\ActiveForm;
//use kartik\tabs\TabsX;
//use kartik\date\DatePicker;
//use kartik\builder\Form;
use yii\widgets\Pjax;

use lukisongroup\hrd\models\Machine;
use lukisongroup\hrd\models\Key_list;

$aryMachine = ArrayHelper::map(Machine::find()->all(),'TerminalID','MESIN_NM');
$aryKeylist = ArrayHelper::map(Key_list::find()->all(),'FunctionKey','FunctionKeyNM');


$this->sideCorp = 'PT. Lukisongroup';                                   /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_absensi';                                       /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'HRM - Absensi	 Dashboard');             /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                          /* belum di gunakan karena sudah ada list sidemenu, on plan next*/




	/*
	 * COLUMN LOG ABSENSI
	 * @author ptrnov  [piter@lukison.com]
	 * @since 1.2
	*/
	$clmLog=[
		[	//COL-0
			/* Attribute Serial No */
			'class'=>'kartik\grid\SerialColumn',
			'width'=>'10px',
			'header'=>'No.',
			'hAlign'=>'center',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
				]
			],
			'pageSummaryOptions' => [
				'style'=>[
						'border-right'=>'0px',
				]
			]
		],
		[  	//col-1
			//Finger Machine
			'attribute' =>'TerminalID',// 'machine_nm',
			'filter'=>$aryMachine,
			'value'=>function($model){
				$nmMachine=Machine::find()->where(['TerminalID'=>$model->TerminalID])->one();
				return $nmMachine!=''?$nmMachine->MESIN_NM:'Unknown';
			},
			'label'=>'Finger Machine',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'90px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'90px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		[  	//col-2
			//CUSTOMER GRAOUP NAME
			'attribute' => 'FingerPrintID',
			'label'=>'Finger',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		[  	//col-3
			//Employee-Name
			'attribute' => 'UserName',
			'label'=>'Employee-Name',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'80px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
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
		[  	//col-3
			//Finger.Key
			'attribute' => 'FunctionKey',//'Keys_nm',
			'label'=>'Key',
			'filter'=>$aryKeylist,
			'value' => function($model){
				$nmKeylist=Key_list::find()->where(['FunctionKey'=>$model->FunctionKey])->one();
				return $nmKeylist!=''? $nmKeylist->FunctionKeyNM:'unknown';
			},
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		[  	//col-4
			//DateTime
			'attribute' => 'tgllog',
			'label'=>'DateTime',
			'noWrap'=>true,
			'filterType' => GridView::FILTER_DATE,
            'filterWidgetOptions' => [
					'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',					 
                    'autoclose' => true,
                    'todayHighlight' => true,
					//'format' => 'dd-mm-yyyy hh:mm',
					'autoWidget' => false,
					//'todayBtn' => true,
                ]
            ],
			'hAlign'=>'left',
			'vAlign'=>'middle',
			
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'100px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
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
		
	];
		
	
	/*
	 * COLUMN LOG TERLAMBAT
	 * @author ptrnov  [piter@lukison.com]
	 * @since 1.2
	*/
	$clmLate=[
		[	//COL-0
			/* Attribute Serial No */
			'class'=>'kartik\grid\SerialColumn',
			'width'=>'10px',
			'header'=>'No.',
			'hAlign'=>'center',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
				]
			],
			'pageSummaryOptions' => [
				'style'=>[
						'border-right'=>'0px',
				]
			]
		],
		[  	//col-1
			//Finger Machine
			'attribute' => 'TerminalID',
			'filter'=>$aryMachine,
			'value'=>function($model){
				$nmMachine=Machine::find()->where(['TerminalID'=>$model->TerminalID])->one();
				return $nmMachine!=''?$nmMachine->MESIN_NM:'Unknown';
			},
			'label'=>'Finger Machine',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'100px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'100px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		[  	//col-2
			//CUSTOMER GRAOUP NAME
			'attribute' => 'FingerPrintID',
			'label'=>'Finger',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		[  	//col-3
			//Employee-Name
			'attribute' => 'UserName',
			'label'=>'Employee-Name',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'80px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
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
		[  	//col-3
			//Finger.Key
			'attribute' =>'FunctionKey',// 'Keys_nm',
			'filter'=>$aryKeylist,
			'value' => function($model){
				$nmKeylist=Key_list::find()->where(['FunctionKey'=>$model->FunctionKey])->one();
				return $nmKeylist!=''? $nmKeylist->FunctionKeyNM:'unknown';
			},
			'label'=>'Key',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		 [  	//col-4
			//DateTime
			'attribute' => 'tgllate',
			'label'=>'DateTime',
			'noWrap'=>true,
			'filterType' => GridView::FILTER_DATE,
            'filterWidgetOptions' => [				
                'pluginOptions' => [
					'id'=>'sa',
                    'format' => 'yyyy-mm-dd',
                    'autoclose' => true,
                    'todayHighlight' => true,
					'autoWidget' => true,
					//'todayBtn' => true,
                ]
            ],
			'hAlign'=>'left',
			'vAlign'=>'middle',			
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'100px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
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
		
	];
	
	
	/*
	 * LOG ABSENSI
	 * @author ptrnov  [piter@lukison.com]
	 * @since 1.2
	*/
	$gvAbsenLog=GridView::widget([
		'id'=>'absenlog',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'filterRowOptions'=>['style'=>'background-color:rgba(0, 95, 218, 0.3); align:center'],
		'showPageSummary' => true,
		'columns' =>$clmLog,
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'absenlog',
		   ],
		],
		'panel' => [
					'heading'=>'<h3 class="panel-title">EMPLOYEE LOG FINGER</h3>',
					/* 'type'=>'warning',
					'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Customer ',
							['modelClass' => 'Kategori',]),'/master/barang/create',[
								'data-toggle'=>"modal",
									'data-target'=>"#modal-create",
										'class' => 'btn btn-success'
													]), */
					'showFooter'=>false,
		],
		'toolbar'=> [
			//'{items}',
		], 
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,		
	]);
	
	
	/*
	 * LOG ABSENSI
	 * @author ptrnov  [piter@lukison.com]
	 * @since 1.2
	*/
	$gvAbsenLate=GridView::widget([
		'id'=>'telat',
        'dataProvider' => $dataProviderLate,
        'filterModel' => $searchModelLate,
		'filterRowOptions'=>['style'=>'background-color:rgba(0, 95, 218, 0.3); align:center'],
		'showPageSummary' => true,
		'columns' =>$clmLate,
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'telat',
			],
		],
		'panel' => [
					'heading'=>'<h3 class="panel-title">EMPLOYEE LATE</h3>',
					'type'=>'danger',
					 /*
					'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Customer ',
							['modelClass' => 'Kategori',]),'/master/barang/create',[
								'data-toggle'=>"modal",
									'data-target'=>"#modal-create",
										'class' => 'btn btn-success'
													]), */
					'showFooter'=>false,
		],
		'toolbar'=> [
			//'{items}',
		], 
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,		
	]);
?>


<div class="body-content">
    <div class="row" style="padding-left: 5px; padding-right: 5px">
        <div class="col-sm-6 col-md-6 col-lg-6" style="padding-left:15px;">
            <?php            		
				echo $gvAbsenLog;
            ?>
        </div>
		<div class="col-sm-6 col-md-6 col-lg-6" style="padding-right:15px">
            <?php            		
				echo $gvAbsenLate;
            ?>
        </div>
    </div>
</div>




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


