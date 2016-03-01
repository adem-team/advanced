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
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\editable\Editable;

use lukisongroup\hrd\models\Machine;
use lukisongroup\hrd\models\Key_list;

$aryMachine = ArrayHelper::map(Machine::find()->all(),'TerminalID','MESIN_NM');
$aryKeylist = ArrayHelper::map(Key_list::find()->all(),'FunctionKey','FunctionKeyNM');


$this->sideCorp = 'PT. Lukisongroup';                                   /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_absensi';                                       /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'HRM - Absensi	 Dashboard');             /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                          /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

	$aryFlag= [
		  ['ID' =>0, 'DESCRIP' => 'Online'],		  
		  ['ID' =>1, 'DESCRIP' => 'Offline'],
		  ['ID' =>2, 'DESCRIP' => 'USB']
	];	
	$valFlag = ArrayHelper::map($aryFlag, 'DESCRIP', 'DESCRIP'); 



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
				$nmMachine=Machine::find()->where(['TerminalID'=>$model['TerminalID']])->one();
				return $nmMachine!=''?$nmMachine['MESIN_NM']:'Unknown';
			},
			'label'=>'Finger.Machine',
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
			'attribute' => 'NAMA',
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
		[  	//col-4
			//Finger.Key
			'attribute' => 'FunctionKey',//'Keys_nm',
			'label'=>'Key',
			'filter'=>$aryKeylist,
			'value' => function($model){
				$nmKeylist=Key_list::find()->where(['FunctionKey'=>$model['FunctionKey']])->one();
				return $nmKeylist!=''? $nmKeylist['FunctionKeyNM']:'unknown';
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
		[  	//col-5
			//DateTime
			'attribute' => 'DateTime',
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
					'text-align'=>'center',
					'width'=>'100px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		[  	//col-6
			//FlagAbsence
			'attribute' => 'FlagAbsence',
			'label'=>'Key',
			'noWrap'=>false,
			'filter'=>$valFlag,			
			'hAlign'=>'left',
			'vAlign'=>'middle',
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
					'text-align'=>'center',
					'width'=>'80px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			],
		],
		[	//col-7
			'class'=>'kartik\grid\ActionColumn',
			'dropdown' => true,
			'template' => '{karfinger}{edit}{delete}',
			'dropdownOptions'=>['class'=>'pull-right dropup'],
			'buttons' => [
					'karfinger' =>function($url, $model, $key){
							return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'Employee Finger'),
														[	
															'/hrd/absen-maintain/finger-emp',
															'm'=>$model['TerminalID'],
															'f'=>$model['FingerPrintID']
														
														],[	
														'data-toggle'=>"modal",
														'data-target'=>"#modal-view",														
														'data-title'=> 'RT0'.$model['FingerPrintID'],
														]). '</li>' . PHP_EOL;
					},
					'edit' =>function($url, $model, $key){
							return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Edit'),
														['/dashboard/warga-data-rt/edit','id'=>$model['FingerPrintID']],[	
														'data-toggle'=>"modal",
														'data-target'=>"#modal-edit",														
														'data-title'=> 'RT0'.$model['FingerPrintID'],
														]). '</li>' . PHP_EOL;					
					},
					'delete' =>function($url, $model, $key){
						return  '<li>' .Html::a('<span class="fa fa-remove fa-dm"></span>'.Yii::t('app', 'delete'),
													['/dashboard/warga-data-rt/delete','id'=>$model['FingerPrintID']],[
													'data-method'=>'post',
													//'data-toggle'=>"modal",
													//'data-target'=>"#modal-del",
													//'data-title'=>$model->KK_NM,
													'data-confirm'=>'Anda yakin ingin menghapus data warga '. $model['FingerPrintID'].' ?',
													]). '</li>' . PHP_EOL;
					},					
			],
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'40px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'40px',
					'height'=>'10px',
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
					'heading'=>'<h3 class="panel-title">EMPLOYEE MAINTAIN LOG FINGER</h3>',
					'type'=>'warning',
					/*'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Customer ',
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
        <div class="col-sm-8 col-md-8 col-lg-8" style="padding-left:25px;padding-right:25px;">
            <?php            		
				echo $gvAbsenLog;
            ?>
        </div>		
    </div>
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


