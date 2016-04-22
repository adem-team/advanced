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
	var tgl2 = moment(dateTime2).format("YYYY-MM-DD");
	// var tgl1 = moment(dateTime1).format("DD/MM/yyyy hh:mm");
	// var tgl2 = moment(dateTime2).format("DD/MM/yyyy hh:mm");
	$('#tglakhir').val(tgl2);
	$('#tglawal').val(tgl1);
    $('#confirm-permission-alert').modal();
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
  $('#tglakhir').val(tgl2);
  $('#tglawal').val(tgl1);
$('#confirm-permission-alert').modal();

}
EOF;

	/*
	 * GRIDVIEW USER LIST CRM : author wawan
     */
	$gvUser=GridView::widget([
		'id'=>'gv-user-list-id',
    'dataProvider' => $dataProviderUser,
    'filterModel' => $searchModelUser,
		'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
    'rowOptions'   => function ($model, $key, $index, $grid) {
       return ['id' => $model->id,'onclick' => '$.pjax.reload({
            url: "'.Url::to(['/master/schedule-header/index']).'?ScheduleheaderSearch[USER_ID]="+this.id,
            container: "#gv-schedule-id",
            timeout: 100,
        });'];
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
				//CUSTOMER GRAOUP NAME
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
				'template' => '{view}{edit}',
				'dropdownOptions'=>['class'=>'pull-right dropup'],
				'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
				'buttons' => [
						'view' =>function($url, $model, $key){
								return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
															['/master/barang/view','id'=>$model->id],[
															'data-toggle'=>"modal",
															'data-target'=>"#modal-view",
															'data-title'=> '',//$model->KD_BARANG,
															]). '</li>' . PHP_EOL;
						},
						'edit' =>function($url, $model, $key){
								return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Create Kode Alias'),
															['createalias','id'=>$model->id],[
															'data-toggle'=>"modal",
															'data-target'=>"#modal-create",
															'data-title'=>'',// $model->KD_BARANG,
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
				'template' => '{view}{edit}',
				'dropdownOptions'=>['class'=>'pull-right dropup'],
				'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
				'buttons' => [
						'view' =>function($url, $model, $key){
								return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
															['/master/barang/view','id'=>$model->ID],[
															'data-toggle'=>"modal",
															'data-target'=>"#modal-view",
															]). '</li>' . PHP_EOL;
						},
						'edit' =>function($url, $model, $key){
								return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Create Kode Alias'),
															['createalias','id'=>$model->ID],[
															'data-toggle'=>"modal",
															'data-target'=>"#modal-create",
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
			//'defaultDate' => date('Y-m-d')
		],
		//'ajaxEvents' => Url::toRoute(['/site/jsoncalendar'])

	]);

?>
</div>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<div  class="row">
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
								echo Html::panel(
										['heading' => 'User Profile', 'body' =>'data user ',
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
</div>

<?php

// save via ajax : author wawan
$this->registerJs("
     $.fn.modal.Constructor.prototype.enforceFocus = function(){};
       $('#Scheduleheader').on('beforeSubmit',function(){
				 var val = $('#scheduleheader-scdl_group').val();
				 var val1 = $('#scheduleheader-user_id').val();
				 if(val == '' && val1 == '')
				 {
					 	alert('your check field dont exist');
				 }
				 else{
					 var tgl2 = $('#tglakhir').val();
					 var tgl1 = $('#tglawal').val();
					 var scdl_group = $('#scheduleheader-scdl_group').val();
					 var user_id = $('#scheduleheader-user_id').val();
					 var note = $('#note').val();
					$.ajax({
							url: '/master/schedule-header/jsoncalendar_add',
							type: 'POST',
							data: {tgl2 :tgl2,scdl_group :scdl_group,tgl1:tgl1,user_id:user_id,note:note},
							dataType: 'json',
							success: function(result) {
								if (result == 1){
													$(document).find('#confirm-permission-alert').modal('hide');
													$.pjax.reload({container:'#gv-schedule-id'});
												 $('form#Scheduleheader').trigger('reset');
												 $.pjax.reload({container:'#calendar'});
											 }
							 else{
								 alert('maaf untuk tanggal ini sudah di booking');
										$('form#Scheduleheader').trigger('reset');
									 //  $(document).find('#confirm-permission-alert').modal('hide');
											 // $.pjax.reload({container:'#gv-schedule-id'});
											 // $.pjax.reload({container:'#calendar'});
							 }

									}

							});

				 }

          return false;
        });
  ",$this::POS_READY);

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
