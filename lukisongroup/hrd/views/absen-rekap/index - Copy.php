<?php
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use app\models\hrd\Dept;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;

$this->sideCorp = 'PT. Lukisongroup';                                   /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_absensi';                                       /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'HRM - Absensi	 Dashboard');             /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                          /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


	/*
	 * COLUMN MAINTAIN ABSENSI
	 * @author ptrnov  [piter@lukison.com]
	 * @since 1.2
	*/
	$clmMaintain=[
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
		[  	//col-3
			//Finger-Machine
			'attribute' => 'TerminalID',			
			'label'=>'Finger-Machine',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'group'=>true,
			'groupedRow'=>true,
			'noWrap'=>true,
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
					'text-align'=>'center',
					'width'=>'100px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		[  	//col-6
			//DateTime
			'attribute' => 'DateTime',
			'label'=>'DateTime',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'group'=>true,
			//'groupedRow'=>true,
			'noWrap'=>true,
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
		[  	//col-1
			//Employee-ID
			'attribute' => 'EMP_ID',
			'label'=>'Employee-ID',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'group'=>true,
			//'groupedRow'=>true,
			'noWrap'=>true,
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
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		[  	//col-2
			//Employee-Name
			'attribute' => 'EMP_NM',
			'label'=>'Employee-Name',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'120px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'120px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		
		
		[  	//col-5
			//Finger
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
					'background-color'=>'rgba(97, 211, 96, 0.3)',
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
		[  	//col-6
			//FunctionKeyNM FROM Key Function
			'attribute' => 'FunctionKeyNM',
			'label'=>'Key-Name',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'noWrap'=>true,
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
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],		
		[  	//col-7
			//FlagAbsence
			'attribute' => 'FlagAbsence',
			'label'=>'Status',
			'hAlign'=>'left',
			'vAlign'=>'middle',
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
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
	];

	
	$gvAbsenmaintain=GridView::widget([
		'id'=>'gv-maintain-id',
        'dataProvider' => $absenMaintain,
        //'filterModel' => $searchModel,
		'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
		'showPageSummary' => true,
		'columns' =>$clmMaintain,
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-maintain-id',
		   ],
		],
		'panel' => [
					'heading'=>'<h3 class="panel-title">LOG ABSENSI</h3>',
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
?>


<div class="body-content">
    <div class="row" style="padding-left: 5px; padding-right: 5px">
        <<div class="col-sm-12 col-md-2 col-lg-12" style="padding-left:80px; padding-right:80px">
            <?php
				echo $gvAbsenmaintain;
            ?>
        </div>
    </div>
</div>