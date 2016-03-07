<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;


use lukisongroup\assets\MapAsset;       /* CLASS ASSET CSS/JS/THEME Author: -wawan-*/
MapAsset::register($this);


/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\SchedulegroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->sideCorp = 'PT.Effembi Sukses Makmur';                          /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_customers';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Group');          /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


	$aryStt= [
		  ['STATUS' => 0, 'STT_NM' => 'DISABLE'],
		  ['STATUS' => 1, 'STT_NM' => 'ENABLE'],
	];
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');


	/*
	 * GRIDVIEW Group CUSTOMER
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	$gvCustGroup= GridView::widget([
			'id'=>'gv-custgrp-id',
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
			'rowOptions'   => function ($model, $key, $index, $grid) {
				 return ['id' => $model->ID,'onclick' => '$.pjax.reload({
							url: "'.Url::to(['/master/schedule-group/index']).'?CustomersSearch[SCDL_GROUP]="+this.id,
							container: "#gv-custgrp-list",
							timeout: 10,
					});'];
				//  return ['data-id' => $model->USER_ID];
		 },
			'columns' => [
				[	//COL-2
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
					'attribute' => 'SCDL_GROUP_NM',
					'label'=>'Customer Groups',
					'hAlign'=>'left',
					'vAlign'=>'middle',
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'200px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'9pt',
							'background-color'=>'rgba(97, 211, 96, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'left',
							'width'=>'200px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'9pt',
						]
					],
				],
				[  	//col-2
					//CUSTOMER GRAOUP NAME
					'attribute' => 'KETERANGAN',
					'label'=>'Keterangan',
					'hAlign'=>'left',
					'vAlign'=>'middle',
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'200px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'9pt',
							'background-color'=>'rgba(97, 211, 96, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'left',
							'width'=>'200px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'9pt',
						]
					],
				],
				[	//col-3
					//STATUS
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
				[
					'class'=>'kartik\grid\ActionColumn',
					'dropdown' => true,
					'template' => '{view}{edit}',
					'dropdownOptions'=>['class'=>'pull-right dropup'],
					'buttons' => [
							'view' =>function($url, $model, $key){
									return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
																['/master/barang/view','id'=>$model->ID],[
																'data-toggle'=>"modal",
																'data-target'=>"#modal-view",
																'data-title'=> '',//$model->KD_BARANG,
																]). '</li>' . PHP_EOL;
							},
							'edit' =>function($url, $model, $key){
									return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Create Kode Alias'),
																['createalias','id'=>$model->ID],[
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
							'text-align'=>'left',
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
				'id'=>'gv-custgrp-id',
			   ],
			],
			'panel' => [
						'heading'=>'<h3 class="panel-title">GROUPING CUSTOMER LOCALTIONS</h3>',
						'type'=>'warning',
						'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Group ',
								['modelClass' => 'Kategori',]),'/master/schedule-group/create',[
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
	 * GRIDVIEW CUSTOMER LIST
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	$gvCustGroupList= GridView::widget([
		'id'=>'gv-custgrp-list',
		'dataProvider' => $dpListCustGrp,
		'filterModel' => $searchModel,
		'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
		'columns' => [
			[	//COL-2
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
				'attribute' =>'custgrp.SCDL_GROUP_NM',
				'label'=>'Customer Groups',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'200px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'200px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				  'group'=>true,
			],
			[  	//col-2
				//CUSTOMER GRAOUP NAME
				//'attribute' => 'cust_nm',
				'attribute' => 'CUST_NM',
				'label'=>'Nama Customers',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'200px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'200px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[	//col-3
				//STATUS
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
			[
				'class'=>'kartik\grid\ActionColumn',
				'dropdown' => true,
				'template' => '{view}{edit}',
				'dropdownOptions'=>['class'=>'pull-right dropup'],
				'buttons' => [
						/* 'view' =>function($url, $model, $key){
								return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
															['/master/barang/view','id'=>$model->ID],[
															'data-toggle'=>"modal",
															'data-target'=>"#modal-view",
															'data-title'=> '',//$model->KD_BARANG,
															]). '</li>' . PHP_EOL;
						},
						'edit' =>function($url, $model, $key){
								return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Create Kode Alias'),
															['createalias','id'=>$model->ID],[
															'data-toggle'=>"modal",
															'data-target'=>"#modal-create",
															'data-title'=>'',// $model->KD_BARANG,
															]). '</li>' . PHP_EOL;
						}, */
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

			],
		],
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-custgrp-list',
		   ],
		],
		'panel' => [
					'heading'=>'<h3 class="panel-title">LIST CUSTOMER GROUP</h3>',
					'type'=>'warning',
					'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Customer ',
							['modelClass' => 'Kategori',]),'/master/barang/create',[
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


?>

<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<div  class="row">
		<!-- CUSTOMER MAP !-->
		<div class="col-md-12">
			<?php
				 $map = '<div id ="map" style="width:100%;height:400px"></div>';
				 echo $map;
			?>
		</div>
	</div>
	<div  class="row" style="margin-top:15px">
		<!-- GROUP LOCALTION !-->
		<div class="col-md-5">
			<?php
				echo $gvCustGroup;
			?>
		</div>
		<!-- GROUP CUSTOMER LIST !-->
		<div class="col-md-7">

			<?php
				echo $gvCustGroupList;
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
	'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Sku</h4></div>',
	'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
	],
	]);
	Modal::end();

	$this->registerJs("
		 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
		 $('#modalmap').on('show.bs.modal', function (event) {
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


?>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
					<?php
					$form = ActiveForm::begin([
						'id'=>'mapping',
					]);
					?>
					<input type= text  name= custkd id="tes" readonly=true>

					<div class="form-group">
					  <!-- Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?> -->
					  <?= Html::submitButton('SAVE',['class' => 'btn btn-primary','id'=>'btn']); ?>
				</div>
				<?php ActiveForm::end(); ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>




<?PHP
// $this->registerJsFile('@web/js/slect.js');
// $this->registerCssFile('@web/css/slect.css');
/*js mapping */
	$this->registerJs("
		/*nampilin MAP*/
		 var map = new google.maps.Map(document.getElementById('map'),
			  {
				zoom: 12,
				center: new google.maps.LatLng(-6.229191531958687,106.65994325550469),
				mapTypeId: google.maps.MapTypeId.ROADMAP

			});

			var public_markers = [];


		/*data json*/
		 $.getJSON('/master/customers/map', function(json) {

			for (var i in public_markers)
			{
				public_markers[i].setMap(null);
			}

			$.each(json, function (i, point) {


		//set the icon
		//     if(point.CUST_NM == 'asep')
		//         {
		//             icon = 'http://labs.google.com/ridefinder/images/mm_20_red.png';
		//         }

					var marker = new google.maps.Marker({
					// icon: icon,
					position: new google.maps.LatLng(point.MAP_LAT, point.MAP_LNG),
					animation:google.maps.Animation.BOUNCE,
					map: map,
					 icon : 'http://labs.google.com/ridefinder/images/mm_20_red.png'
				});

				 public_markers[i] = marker;


				if(point.SCDL_GROUP == null)
				{

									 //
									//  $.getJSON('/master/customers/drop', function(result){
									// 	 $.each(result, function(i, data){
									// 		 var options = '';
									// 		 	 options +=	'<option value='+data.ID+'> text=' + data.SCDL_GROUP_NM + '</option>';
									// 			 var div_data='<option value='+data.ID+'>'+data.SCDL_GROUP_NM+'</option>';
									// 			  // alert(options);
									// 			  // $('#ch_user1').html('');
									// 				 $('#ch_user1').html(div_data);
									// 						 // i++;
									// 						  // $('#sel').append($('<option/>').attr('value', data.ID).text(data.SCDL_GROUP_NM));
									 //
									 //
									// 		});
									 //
									//  });

					var contentString = '<h1>' + point.ALAMAT + '</h1>'+'<p>' + point.CUST_NM + '</p>'+
															'<form method=POST action=/master/schedule-group/create-group?CUST_KD='+point.CUST_KD+'>'+
															 '<input type= text  name= custkd value='+ point.CUST_KD+' readonly=true>'+'<br>'+
															 '<select id=sel name= group>'+'<option value=1>GROUP BARAT</option>'+
																				 '<option value=2>GROUP TIMUR</option>'+
																				 '<option value=3>GROUP SELATAN</option>'+
																				 '<option value=4>GROUP UTARA</option>'+
																	'</select>'+'<br>'+
															 '<input id=btn type=submit value=save>'+
															 '</form>'


	 													 google.maps.event.addListener(public_markers[i], 'click', function () {
																 var infowindow = new google.maps.InfoWindow({
																		content: contentString
																 });
																//  infowindow.setContent('<h1>' + point.ALAMAT + '</h1>' + '<p>' + point.CUST_NM + '</p>'+ '<button type=button class=btn btn-info btn-sm id=myBtn>'+ point.CUST_NM+'</button>');
																 infowindow.open(map, public_markers[i]);
															 });
				}
				else{
						var contentString = '<h1>' + point.ALAMAT + '</h1>' + '<p>' + point.CUST_NM + '</p>'+'<p>'+ point.SCDL_GROUP_NM + '<p>' ;

						google.maps.event.addListener(public_markers[i], 'click', function (event) {
																	 var infowindow = new google.maps.InfoWindow({
																			content: contentString
																	 });
																	//  alert(point.CUST_KD);
																	$('#tes').val(point.CUST_KD);
																	 $('#myModal').modal();

																	//  infowindow.setContent('<h1>' + point.ALAMAT + '</h1>' + '<p>' + point.CUST_NM + '</p>'+ '<button type=button class=btn btn-info btn-sm id=myBtn>'+ point.CUST_NM+'</button>');
																	 infowindow.open(map, public_markers[i]);
																 });

				}





			});


		 });

		// console.trace();
     ",$this::POS_READY);


?>
