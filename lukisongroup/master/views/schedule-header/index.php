<?php
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use lukisongroup\sistem\models\Userlogin;
use kartik\detail\DetailView;

$this->sideCorp = 'PT.Effembi Sukses Makmur';                          /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_customers';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Produk');          /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                     /* belum di gunakan karena sudah ada list sidemenu, on plan next*/



$JSCode = <<<EOF

// author wawan
function(start, end) {
	var dateTime2 = new Date(end);
	var dateTime1 = new Date(start);
	// var tgl1 = moment(dateTime1).format("YYYY-MM-DD HH:mm:ss");
	// var tgl2 = moment(dateTime2).format("YYYY-MM-DD HH:mm:ss");
	var tgl1 = moment(dateTime1).format("YYYY-MM-DD");
	var tgl2 = moment(dateTime2).subtract(1, "days").format("YYYY-MM-DD");


	// var tgl1 = moment(dateTime1).format("DD/MM/yyyy hh:mm");
	// var tgl2 = moment(dateTime2).format("DD/MM/yyyy hh:mm");
	$('#tglakhir').val(tgl2);
	$('#tglawal').val(tgl1);
    // $('#confirm-permission-alert').modal();
		$.get('/master/schedule-header/create-group',{'tgl1':tgl1,'tgl2':tgl2},function(data){
						$('#modal').modal('show')
						.find('#modalContent')
						.html(data);
		});
}
EOF;
$JSDropEvent = <<<EOF
function(date) {
    alert("Dropped on " + date.format());
    if ($('#drop-remove').is(':checked')) {
        // if so, remove the element from the "Draggable Events" list
        $(this).remove();
    }
}
EOF;
$JSEventClick = <<<EOF
function(calEvent, jsEvent, view) {
// $('#confirm-permission-alert').modal();

}
EOF;

$Jseventcolor = <<<EOF
function (event, element, view) {
 var dateTime2 = new Date(event.end);
 var dateTime1 = new Date(event.start);
var tgl1 = moment(dateTime1).format("YYYY-MM-DD");
var tgl2 = moment(dateTime2).subtract(1, "days").format("YYYY-MM-DD");
var now = Date();
var now1 = moment(now).format("YYYY-MM-DD");
// var d = new Date();
// var now1 = Date.parse(d)/1000;

// var tgl1 = Date.parse(event.start)/1000;
// var tgl2 = Date.parse(event.end)/1000;


 if(tgl1 < now1 && tgl2 < now1)
 {
 	 //event.color = "#FFB347"; //Em andamento
      element.css('background-color', 'red');
 } else if(tgl1 > now1 && tgl2 > now1){
 	  element.css('background-color', 'green');
} else{
	 element.css('background-color', 'blue');}
}
EOF;

// function (event, element, view) {
//         var dataHoje = new Date();
//         if (event.start < dataHoje && event.end > dataHoje) {
//             //event.color = "#FFB347"; //Em andamento
//             element.css('background-color', '#FFB347');
//         } else if (event.start < dataHoje && event.end < dataHoje) {
//             //event.color = "#77DD77"; //Concluído OK
//             element.css('background-color', '#77DD77');
//         } else if (event.start > dataHoje && event.end > dataHoje) {
//             //event.color = "#AEC6CF"; //Não iniciado
//             element.css('background-color', '#AEC6CF');
//         }
//     },


Modal::begin([
	'headerOptions' => ['id' => 'modalHeader'],
	'id' => 'modal',
	'size' => 'modal-sm',
	//keeps from closing modal with esc key or by clicking out of the modal.
	// user must click cancel or X to close
	// 'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
Modal::end();

/*modal*/
Modal::begin([
    'id' => 'modal-view_cus-crm',
    'header' => '<div style="float:left;margin-right:10px" class="fa fa-user"></div><div><h5 class="modal-title"><b>VIEW User</b></h5></div>',
    'size' => Modal::SIZE_LARGE,
    'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
    ],
  ]);
  echo "<div id='modalContentcrm'></div>";
  Modal::end();

	/*
	 * GRIDVIEW USER LIST  : author wawan
     */
	$gvUser=GridView::widget([
		'id'=>'gv-user-list-id',
    'dataProvider' => $dataProviderUser,
    'filterModel' => $searchModelUser,
		'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
    // 'rowOptions' => function ($model, $key, $index, $grid) {
    //    return ['id' => $model->id,'onclick' => '$.pjax.reload({
    //         url: "'.Url::to(['/master/schedule-header/index']).'?ScheduleheaderSearch[USER_ID]="+this.id,
    //         container: "#gv-schedule-id",
    //         timeout: 100,
    //     });'];
    //   },
		 'rowOptions'   => function ($model, $key, $index, $grid) {
       return ['id' => $model->id,'onclick' => 'detail(this,'.$model->id.'); return false;'];
      },
        'columns' => [
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
				//username
				'attribute' => 'username',
				'label'=>'User',
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
			[  	//col-2
				//USER POSITION_SITE
				'attribute' => 'POSITION_SITE',
				'label'=>'Site Login',
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
			[  	//col-3
				//USER POSITION_LOGIN
				'attribute' => 'POSITION_LOGIN',
				'label'=>'Position Login',
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
				'class'=>'kartik\grid\ActionColumn',
				'dropdown' => true,
				'template' => '{view}',
				'dropdownOptions'=>['class'=>'pull-right dropup'],
				'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
				'buttons' => [
						 'view' =>function($url, $model, $key){
					          return  Html::button(Yii::t('app', 'View User Crm'),
					            ['value'=>url::to(['view-user-crm','id'=>$model->id]),
					            'id'=>'modalButtoncrm',
					            'class'=>"btn btn-default btn-xs",      
					            'style'=>['width'=>'170px', 'height'=>'25px','border'=> 'none'],
					          ]);
      },      
						// 'edit' =>function($url, $model, $key){
						// 		return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Create Kode Alias'),
						// 									['createalias','id'=>$model->id],[
						// 									'data-toggle'=>"modal",
						// 									'data-target'=>"#modal-create",
						// 									'data-title'=>'',// $model->KD_BARANG,
						// 									]). '</li>' . PHP_EOL;
						// },
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
						'text-align'=>'center',
						'width'=>'150px',
						'height'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],

			],
        ],
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-user-list-id',
		   ],
		],
		'panel' => [
					'heading'=>'<h3 class="panel-title">USER LIST</h3>',
					'type'=>'warning',
					'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add User ',
							['modelClass' => 'Kategori',]),'/master/schedule-header/create-user',[
								'data-toggle'=>"modal",
									'data-target'=>"#modal-create",
										'class' => 'btn btn-success'
													]),
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
	 * GRIDVIEW USER LIST  : author wawan
     */
	// $info=GridView::widget([
	// 	'id'=>'gv-user-id',
 //    'dataProvider' => $dataProvider1,
 //    // 'filterModel' => $searchModelUser,
	// 	'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
 //        'columns' => [
 //            [	//COL-0
	// 			/* Attribute Serial No */
	// 			'class'=>'kartik\grid\SerialColumn',
	// 			'width'=>'10px',
	// 			'header'=>'No.',
	// 			'hAlign'=>'center',
	// 			'headerOptions'=>[
	// 				'style'=>[
	// 					'text-align'=>'center',
	// 					'width'=>'10px',
	// 					'font-family'=>'tahoma',
	// 					'font-size'=>'8pt',
	// 					'background-color'=>'rgba(0, 95, 218, 0.3)',
	// 				]
	// 			],
	// 			'contentOptions'=>[
	// 				'style'=>[
	// 					'text-align'=>'center',
	// 					'width'=>'10px',
	// 					'font-family'=>'tahoma',
	// 					'font-size'=>'8pt',
	// 				]
	// 			],
	// 			'pageSummaryOptions' => [
	// 				'style'=>[
	// 						'border-right'=>'0px',
	// 				]
	// 			]
	// 		],
	// 		[  	//col-1
	// 			//username
	// 			'attribute' => 'username',
	// 			'label'=>'User',
	// 			'hAlign'=>'left',
	// 			'vAlign'=>'middle',
	// 			'headerOptions'=>[
	// 				'style'=>[
	// 					'text-align'=>'center',
	// 					'width'=>'100px',
	// 					'font-family'=>'tahoma, arial, sans-serif',
	// 					'font-size'=>'9pt',
	// 					'background-color'=>'rgba(97, 211, 96, 0.3)',
	// 				]
	// 			],
	// 			'contentOptions'=>[
	// 				'style'=>[
	// 					'text-align'=>'left',
	// 					'width'=>'100px',
	// 					'font-family'=>'tahoma, arial, sans-serif',
	// 					'font-size'=>'9pt',
	// 				]
	// 			],
	// 		],
	// 		[  	//col-2
	// 			//USER POSITION_SITE
	// 			'attribute' => 'POSITION_SITE',
	// 			'label'=>'Site Login',
	// 			'hAlign'=>'left',
	// 			'vAlign'=>'middle',
	// 			'headerOptions'=>[
	// 				'style'=>[
	// 					'text-align'=>'center',
	// 					'width'=>'100px',
	// 					'font-family'=>'tahoma, arial, sans-serif',
	// 					'font-size'=>'9pt',
	// 					'background-color'=>'rgba(97, 211, 96, 0.3)',
	// 				]
	// 			],
	// 			'contentOptions'=>[
	// 				'style'=>[
	// 					'text-align'=>'left',
	// 					'width'=>'100px',
	// 					'font-family'=>'tahoma, arial, sans-serif',
	// 					'font-size'=>'9pt',
	// 				]
	// 			],
	// 		],
	// 		[  	//col-3
	// 			//USER POSITION_LOGIN
	// 			'attribute' => 'POSITION_LOGIN',
	// 			'label'=>'Position Login',
	// 			'hAlign'=>'left',
	// 			'vAlign'=>'middle',
	// 			'headerOptions'=>[
	// 				'style'=>[
	// 					'text-align'=>'center',
	// 					'width'=>'100px',
	// 					'font-family'=>'tahoma, arial, sans-serif',
	// 					'font-size'=>'9pt',
	// 					'background-color'=>'rgba(97, 211, 96, 0.3)',
	// 				]
	// 			],
	// 			'contentOptions'=>[
	// 				'style'=>[
	// 					'text-align'=>'left',
	// 					'width'=>'100px',
	// 					'font-family'=>'tahoma, arial, sans-serif',
	// 					'font-size'=>'9pt',
	// 				]
	// 			],
	// 		],
           
 //        ],
	// 	'pjax'=>true,
	// 	'pjaxSettings'=>[
	// 	'options'=>[
	// 		'enablePushState'=>false,
	// 		'id'=>'gv-user-id',
	// 	   ],
	// 	],
	// 	'panel' => [
	// 	// 			'heading'=>'<h3 class="panel-title">USER LIST</h3>',
	// 	// 			'type'=>'warning',
	// 	// 			'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add User ',
	// 	// 					['modelClass' => 'Kategori',]),'/master/schedule-header/create-user',[
	// 	// 						'data-toggle'=>"modal",
	// 	// 							'data-target'=>"#modal-create",
	// 	// 								'class' => 'btn btn-success'
	// 	// 											]),
	// 				'showFooter'=>false,
	// 	],
	// 	'toolbar'=> [
	// 		//'{items}',
	// 	],
	// 	'hover'=>true, //cursor select
	// 	'responsive'=>true,
	// 	'responsiveWrap'=>true,
	// 	'bordered'=>true,
	// 	'striped'=>'4px',
	// 	'autoXlFormat'=>true,
	// 	'export' => false,
 //    ]);




	/*
	 * GRIDVIEW SCHEDULE HEADER
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	$gvScdlHeader=GridView::widget([
		'id'=>'gv-schedule-id',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
        'columns' => [
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
        //USER_ID
        'attribute' => 'user.username',
        'label'=>'Nama',
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
			[  	//col-1
				//SCDL_GROUP
				'attribute' => 'scdlgroup.SCDL_GROUP_NM',
				'label'=>'Schadule Group',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				 'filterType'=>GridView::FILTER_SELECT2,
      			 'filter' => $datagroup_nm,
      			  'filterWidgetOptions'=>[
			        'pluginOptions'=>[
						'allowClear'=>true,
						'contentOptions'=>[
							'style'=>[
							  'text-align'=>'left',
							  'font-family'=>'tahoma, arial, sans-serif',
							  'font-size'=>'8pt',
							]
						]
					],
				  ],
      			'filterInputOptions'=>['placeholder'=>'Group Name'],
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
			[  	//col-2
				//TANGGAL
				'attribute' => 'TGL1',
				'label'=>'Tanggal kunjungan Dari-Sampai',
        'value'=>function($model){
        return   $model->TGL1.' - '.$model->TGL2;
        },
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
				'class'=>'kartik\grid\ActionColumn',
				'dropdown' => true,
				'template' => '{view}',
				'dropdownOptions'=>['class'=>'pull-right dropup'],
				'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
				'buttons' => [
						// 'view' =>function($url, $model, $key){
						// 		return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
						// 									['view-user-crm','id'=>$model->ID],[
						// 									'data-toggle'=>"modal",
						// 									'data-target'=>"#modal-create",
						// 									]). '</li>' . PHP_EOL;
						// },
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
						'text-align'=>'center',
						'width'=>'150px',
						'height'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],

			],
        ],
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-schedule-id',
		   ],
		],
		// 'panel' => [
		// 			'heading'=>'<h3 class="panel-title">USER LIST</h3>',
		// 			'type'=>'warning',
		// 			'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Group ',
		// 					['modelClass' => 'Kategori',]),'/master/barang/create',[
		// 						'data-toggle'=>"modal",
		// 							'data-target'=>"#modal-create",
		// 								'class' => 'btn btn-success'
		// 											]),
		// 			'showFooter'=>false,
		// ],
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
<?php
	$calenderRt=yii2fullcalendar\yii2fullcalendar::widget([
	  'id'=>'calendar',
	  'options' => [
		'lang' => 'id',
		//... more options to be defined here!
	  ],
	   'events'=> $events,
	  'ajaxEvents' => Url::to(['/master/schedule-header/jsoncalendar']),
	  'clientOptions' => [
			'selectable' => true,
			'selectHelper' => true,
			'droppable' => true,
			'editable' => true,
			//'drop' => new JsExpression($JSDropEvent),
			'selectHelper'=>true,
			'select' => new JsExpression($JSCode),
			'eventClick' => new JsExpression($JSEventClick),
			'eventAfterRender'=> new JsExpression($Jseventcolor),
			//'defaultDate' => date('Y-m-d')
		],
		//'ajaxEvents' => Url::toRoute(['/site/jsoncalendar'])

	]);

?>
<div class="raw">
	<div class="panel panel-info">
		<div class="box direct-chat direct-chat">
		 <!-- box-header -->
			<div class="box-header with-border"  >
				<h3 class="box-title" style="font-family:tahoma, arial, sans-serif;font-size:10pt;text-align:center;color:blue" ><?php echo "<b>CUSTOMER SCHADULE</b>";?></h3>
				<div class="box-tools pull-left">
					<!--<span data-toggle="tooltip" title="3 New Messages" class="badge bg-green">3</span>-->
					<button class="btn btn-box-tool" data-toggle="tooltip" title="show/hide" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-toggle="tooltip" title="Detail" data-widget="chat-pane-toggle"><i class="fa fa-navicon"></i></button>
					<!-- <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
				</div>
			</div><!-- /.box-header -->
			<div class="box-body">
				<!-- Conversations are loaded here -->
				<div class="direct-chat-messages" style="height:1200px">
					<!-- Message. Default to the left -->
						 <div class="raw">
							<div class="col-md-4">
								<?php
									echo $gvUser;
								?>
							</div>
							<div class="col-md-8">
								<div  class="row">
									<div class="col-md-12">
										<div  class="row">
											<div class="col-md-6">
												<?php
													echo Html::panel(
															['heading' => 'Calendar Visit	', 'body' =>$calenderRt,
																'options' => [
																'style'=>['height'=>'150px'],
																],
															],
															Html::TYPE_INFO

														);
												?>
											</div>
											<div class="col-md-6">
												<?php
												$info = "<div id =detail></div>";
												// $render = $this->render('data_user_profile',[
												// 	'dataProvider1'=>$dataProvider1,'searchModel1'=>$searchModel1
												// 	]);
													echo Html::panel(
															['heading' => 'User Profile', 'body' =>$info,
																'options' => [
																'style'=>['height'=>'150px'],
																],
															],
															Html::TYPE_INFO

														);
												?>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<?php
											 echo $gvScdlHeader;
										?>
									</div>
								</div>
							</div>
						</div>
					<!-- Message to the right -->
				</div><!--/.direct-chat-messages-->
				<!-- Contacts are loaded here -->
				<div class="direct-chat-contacts" style="height:1200px; color:black;background-color:white">
					<ul class="contacts-list">
						<li>
							<div class="raw">
							<?php 
								$gvScdlRpt=$this->render('_indexSchaduleReport',[
									'aryDataProviderRptScdl'=>$aryDataProviderRptScdl,
									'attributeField'=>$attributeField
								]);
							?>
							<?=$gvScdlRpt?>
							</div>
						</li><!-- End Contact Item -->
					</ul><!-- /.contatcts-list -->
				</div><!-- /.direct-chat-pane -->
			</div><!-- /.box-body -->
		</div><!--/.direct-chat -->
	</div>

</div>



<?php

$this->registerJs('
        function detail(obj,idx){
        	$.pjax.reload({
            url: "'.Url::to(['/master/schedule-header/index']).'?ScheduleheaderSearch[USER_ID]="+idx,
	            container: "#gv-schedule-id",
	            timeout: 100,
        });
          
            // get content via ajax
            $.get("'.\yii\helpers\Url::to(['/master/schedule-header/get-data']).'?id="+idx, function( data ) {
            	var profile = JSON.parse(data);
            	if(profile.STATUS == 1)
            	{
            		var valuests = "Aktif";
            		var clas = "info";
            	}else{
            		var valuests = " Tidak Aktif";
            		var clas = "danger";
            	}
            	 var out = "<table class=table table-hover>";
            	     	out += "<thead>";
            	     	out += "<tr>";
            	     	out += "</tr>";
            	      	out += "</thead>";
            	       	out += "<tbody>";
     					out +="<tr class=info>"; 
                       	out +="<td>Nama Profile </td>"; 	
	                    out +="<td>"+profile.NM_FIRST+"</td>";
	                    out += "</tr>";
	                    out +="<tr class=info>"; 
                       	out +="<td>No Telp </td>"; 	
	                    out +="<td>"+profile.TLP_HOME+"</td>";
	                    out += "</tr>";
	                    out +="<tr class="+clas+">"; 
                       	out +="<td>Status </td>"; 	
	                    out +="<td>"+valuests+"</td>";
	                    out += "</tr>";
            	   		out += "</tbody>";
            	        out += "</table>";
            	 document.getElementById("detail").innerHTML = out;
               // $.pjax.reload({container:"#detail",timeout:2e3});
            }).fail(function() {
                alert( "error" );
              });
            // $(trDetail).append(tdDetail); // add td to tr
            // $(tr).after(trDetail);  // add tr to table
        }
     
', \yii\web\View::POS_HEAD) 

// $this->registerJs('
//     jQuery(document).on("pjax:success", "#gv-schedule-id",  function(event){
//             $.pjax.reload({container:"#gv-user-id",timeout:2e3})
//           }
//         );
//    ');

?>



<?php

/*
   * PROCESS EXCEPTION VIEW EDITING
   * @author wawan [aditiya@lukison.com]
   * @since 1.0
   */
  $this->registerJs("
  $(document).ready(function () {

    if(localStorage.getItem('sts')==null){
      //alert(sts);
      localStorage.setItem('sts','hidden');
    };
    
    var stt  = localStorage.getItem('sts');
    var viewaction = localStorage.getItem('view');
    var nilaiValue = localStorage.getItem('nilai');
    localStorage.setItem('sts','hidden');
   
    /*
     * FIRST SHOW MODAL
     * @author wawan [aditiya@lukison.com]
    */
    $(document).on('click','#modalButtoncrm', function(ehead){ 
      
        //e.preventDefault();     
        localStorage.clear();
        localStorage.setItem('nilai',ehead.target.value);     
        localStorage.setItem('sts','show');
        $('#modal-view_cus-crm').modal('show')
        .find('#modalContentcrm')
        .load(ehead.target.value);
    });
    
    
    /*
     * STATUS SHOW IF EVENT BUTTON SAVED
     * @author wawan [aditiya@lukison.com]
    */
    $(document).on('click','#saveBtn', function(e){ 
      localStorage.setItem('sts','show');
     
    }); 
  
    
    /*
     * STATUS HIDDEN IF EVENT MODAL HIDE
     * @author wawan [aditiya@lukison.com]
    */
    $('#modal-view_cus-crm').on('hidden.bs.modal', function () {
      localStorage.setItem('sts','hidden');
    });
    
    /*
     * CALL BACK SHOW MODAL
     * @author wawan [aditiya@lukison.com]
    */  
    setTimeout(function(){
      $('#modal-view_cus-crm').modal(stt)
      .find('#modalContentcrm')
      .load(nilaiValue);
    }, 1000);  
  });
  ",$this::POS_READY);


// save via ajax : author wawan
// $this->registerJs("
//      $.fn.modal.Constructor.prototype.enforceFocus = function(){};
//        $('#Scheduleheader').on('beforeSubmit',function(){
// 				 var val = $('#scheduleheader-scdl_group').val();
// 				 var val1 = $('#scheduleheader-user_id').val();
// 				 if(val == '' && val1 == '')
// 				 {
// 					 	alert('your check field dont exist');
// 				 }
// 				 else{
// 					 var tgl2 = $('#tglakhir').val();
// 					 var tgl1 = $('#tglawal').val();
// 					 var scdl_group = $('#scheduleheader-scdl_group').val();
// 					 var user_id = $('#scheduleheader-user_id').val();
// 					 var note = $('#note').val();
// 					$.ajax({
// 							url: '/master/schedule-header/jsoncalendar_add',
// 							type: 'POST',
// 							data: {tgl2 :tgl2,scdl_group :scdl_group,tgl1:tgl1,user_id:user_id,note:note},
// 							dataType: 'json',
// 							success: function(result) {
// 								if (result == 1){
// 													$(document).find('#confirm-permission-alert').modal('hide');
// 													$.pjax.reload({container:'#gv-schedule-id'});
// 												 $('form#Scheduleheader').trigger('reset');
// 												 $.pjax.reload({container:'#calendar'});
// 											 }
// 							 else{
// 								 alert('maaf untuk tanggal ini sudah di booking');
// 										$('form#Scheduleheader').trigger('reset');
// 									 //  $(document).find('#confirm-permission-alert').modal('hide');
// 											 // $.pjax.reload({container:'#gv-schedule-id'});
// 											 // $.pjax.reload({container:'#calendar'});
// 							 }

// 									}

// 							});

// 				 }

//           return false;
//         });
//   ",$this::POS_READY);

// author wawan
Modal::begin([
    'id' => 'confirm-permission-alert',
    'size' => Modal::SIZE_SMALL,
  ]);
  $form = ActiveForm::begin([
            'id'=>$model->formName(),
      ]);
      echo $form->field($model, 'TGL1')->Hiddeninput(['id'=>'tglawal'])->label(false);

      echo $form->field($model, 'TGL2')->Hiddeninput(['id'=>'tglakhir'])->label(false);

      echo $form->field($model, 'SCDL_GROUP')->widget(Select2::classname(), [
          'data' => $datagroup,
          'options' => ['placeholder' => 'Select Group ...'],
          'pluginOptions' => [
              'allowClear' => true
              ],
          ]);

      echo $form->field($model, 'USER_ID')->widget(Select2::classname(), [
              'data' => $datauser,
              'options' => ['placeholder' => 'Select User ...'],
              'pluginOptions' => [
                  'allowClear' => true
                  ],
              ]);
      echo $form->field($model, 'NOTE')->Textarea(['rows'=>2,'id'=>'note'])->label('KETERANGAN');


    echo '<div style="text-align:right; padding-top:10px">';
    echo Html::submitButton('save',['class' => 'btn btn-success']);
    echo '</div>';
  ActiveForm::end();

Modal::end();

// create user crm via modal : author wawan
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
	'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">User</h4></div>',
	'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
	],
	]);
	Modal::end();


?>
