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
use lukisongroup\hrd\models\Employe;

$aryMachine = ArrayHelper::map(Machine::find()->all(),'TerminalID','MESIN_NM');
$aryKeylist = ArrayHelper::map(Key_list::find()->all(),'FunctionKey','FunctionKeyNM');
$aryEmploye = ArrayHelper::map(Employe::find()->where("STATUS<>3 AND EMP_STS<>3")->all(), function($model, $defaultValue) {
																								return $model->EMP_NM.'-'.$model->EMP_NM_BLK;
																							},function($model, $defaultValue) {
																								return $model->EMP_NM.'-'.$model->EMP_NM_BLK;
																							}
			);

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_purchasing';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Purchasing Dashboard');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

	/* $aryFlag= [
		  ['ID' =>0, 'DESCRIP' => 'Online'],		  
		  ['ID' =>1, 'DESCRIP' => 'Offline'],
		  ['ID' =>2, 'DESCRIP' => 'USB']
	];	
	$valFlag = ArrayHelper::map($aryFlag, 'DESCRIP', 'DESCRIP'); 
 */

	$attDinamik =[];
	$hdrLabel1=[];
	//$hdrLabel2=[];
	$getHeaderLabelWrap=[];
	

	/*
	 * Terminal ID | Mashine
	 * Colomn 1
	*/
	$attDinamik[]=[		
		'attribute'=>'TerminalID','label'=>'Source Machine',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'filter'=>$aryMachine,
		'filterOptions'=>[
			'style'=>'background-color:rgba(240, 195, 59, 0.4); align:center;',
			'vAlign'=>'middle',
		],
		'value'=>function($model){
			$nmMachine=Machine::find()->where(['TerminalID'=>$model['TerminalID']])->one();
			return $nmMachine!=''?$nmMachine['MESIN_NM']:'Unknown';
		},
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'20px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(240, 195, 59, 0.4)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'20px',
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
					'width'=>'20px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',	
					'text-decoration'=>'underline',
					'font-weight'=>'bold',
					'border-left-color'=>'transparant',		
					'border-left'=>'0px',									
			]
		],											
		//'footer'=>true,			
	];
	$hdrLabel1[] =[	
		'content'=>'Employee Data',
		'options'=>[
			'noWrap'=>true,
			'colspan'=>2,
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
	 * Employe name
	 * Colomn 2
	*/
	$attDinamik[]=[		
		'attribute'=>'EMP_NM','label'=>'Employee',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'filter'=>$aryEmploye,
		'filterOptions'=>[
			'style'=>'background-color:rgba(240, 195, 59, 0.4); align:center;',
			'vAlign'=>'middle',
		],
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(240, 195, 59, 0.4)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'10px',
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
					'width'=>'10px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',	
					'text-decoration'=>'underline',
					'font-weight'=>'bold',
					'border-left-color'=>'transparant',		
					'border-left'=>'0px',									
			]
		],											
		//'footer'=>true,			
	];
	/* $hdrLabel1[] =[	
		'content'=>'Employee Data',
		'options'=>[
			'noWrap'=>true,
			'colspan'=>1,
			'class'=>'text-center info',								
			'style'=>[
				 'text-align'=>'center',
				 'width'=>'20px',
				 'font-family'=>'tahoma',
				 'font-size'=>'8pt',
				 'background-color'=>'rgba(240, 195, 59, 0.4)',								
			 ]
		 ],
	];  */
	
	
	
	/*
	* === REKAP =========================
	* Key-FIND : AttDinamik-Clalender
	* @author ptrnov [piter@lukison.com]
	* @since 1.2
	* ===================================
	*/
	foreach($dataProviderField as $key =>$value)
	{	
		$i=2;
		$kd = explode('.',$key);
		if($key!='EMP_NM' AND $key!='TerminalID' AND $kd[0]!='OTIN' AND $kd[0]!='OTOUT'){			
			if ($kd[0]=='IN'){$lbl='IN';} elseif($kd[0]=='OUT'){$lbl='OUT';}else {$lbl='';};
				$attDinamik[]=[		
					'attribute'=>$key,
					'label'=>$lbl,					
					/* function(){
							return html::encode($lbl);
					}, */
					'hAlign'=>'right',
					'vAlign'=>'middle',
					'value'=>function($model)use($key){
						return $model[$key]!=''?$model[$key]:'x';
					},
					/* 'filter'=>function()use($kd[1]){
						$date = '2011/10/14'; 
						$day = date('l', strtotime($date));
						echo $day;
					}, */
					//'filter'=>$kd[0]=='IN'? date('l', strtotime($kd[1])):'',
					/*'filterOptions'=>[
					 'colspan'=>$kd[0]=='IN'? 2:'0',
						'style'=>'background-color:rgba(97, 211, 96, 0.3); align:center;',
						'vAlign'=>'middle',
					], */
					'mergeHeader'=>true,
					'noWrap'=>true,			
					'headerOptions'=>[		
						//'colspan'=>$kd[0]=='IN'? true:false,			
						//'colspan'=>$kd[0]=='IN'? $i:'0',
						//'headerHtmlOptions'=>array('colspan'=>'2'),
						'style'=>[									
							'text-align'=>'center',
							//'width'=>'12px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'8pt',
							'background-color'=>'rgba(97, 211, 96, 0.3)',
						]
					],  
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'center',
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
			
				if($kd[0]=='IN'){
					$hdrLabel1[] =[	
						'content'=>$kd[1],
						'options'=>[
							'noWrap'=>true,
							'colspan'=>2,
							'class'=>'text-center info',								
							'style'=>[
								 'text-align'=>'center',
								 //'width'=>'24px',
								 'font-family'=>'tahoma',
								 'font-size'=>'8pt',
								 'background-color'=>'rgba(0, 95, 218, 0.3)',								
							 ]
						 ],
					];		
				}
		}
		
		$i=$i+1;
	}
	
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
	$gvAbsenLog=GridView::widget([
		'id'=>'absen-rekap',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,		
		'beforeHeader'=>$getHeaderLabelWrap,
		//'showPageSummary' => true,
		'columns' =>$attDinamik,
		//'floatHeader'=>true,
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'absen-rekap',
			],
		],
		 'panel' => [
					'heading'=>'<h3 class="panel-title">PURCHASE REPORT</h3>',
					'type'=>'warning',
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
		'perfectScrollbar'=>true,
		//'autoXlFormat'=>true,
		//'export' => false,		
	]);
	
	
?>


<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;margin-right:5px">
	<?php 
		/* $items=[
			[
				'label'=>'<i class="glyphicon glyphicon-home"></i> Daily Absensi','content'=>$gvAbsenLog,
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
		echo $gvAbsenLog;
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


