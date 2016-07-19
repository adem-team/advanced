<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use crm\salesman\models\Schedulegroup;
use crm\mastercrm\models\Customers;
use mdm\admin\components\Helper;

use lukisongroup\assets\MapAsset;       /* CLASS ASSET CSS/JS/THEME Author: -wawan-*/
MapAsset::register($this);


/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\SchedulegroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->sideCorp = 'PT.Effembi Sukses Makmur';                          /* Title Select Company pada header pasa sidemenu/menu samping kiri */
// $this->sideMenu = 'esm_customers';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
// $this->title = Yii::t('app', 'ESM - Group');          /* title pada header page */
// $this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/



function tombolAddGroup(){
  $title1 = Yii::t('app', 'Add Group');
  $options1 = [ 'id'=>'schedule-group-crm-modal',
          'data-toggle'=>"modal",
          'data-target'=>"#modal-create",
          'class' => 'btn btn-success btn-sm',
          // 'style' => 'text-align:left',
  ];
  $icon1 = '<i class="glyphicon glyphicon-plus"></i>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/salesman/schedule-group-crm/create']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

  if(Helper::checkRoute('create')){
        $button_add_group = tombolAddGroup();
    }else{
        $button_add_group = "";
    }


function tombolAddCustomers(){
  $title1 = Yii::t('app', 'Add Customers');
  $options1 = [ 'id'=>'schedule-group-crm-add-customers',
          'data-toggle'=>"modal",
          'data-target'=>"#modal-create",
          'class' => 'btn btn-success btn-sm',
          // 'style' => 'text-align:left',
  ];
  $icon1 = '<i class="glyphicon glyphicon-plus"></i>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/salesman/schedule-group-crm/create-scdl']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

  if(Helper::checkRoute('create-scdl')){
        $button_create = tombolAddCustomers();
    }else{
        $button_create = "";
    }



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
							url: "'.Url::to(['/salesman/schedule-group-crm/index']).'?CustomersSearch[SCDL_GROUP]="+this.id,
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
					// 'template' => '{view}{edit}',
					'template' =>Helper::filterActionColumn('{view}{update}'),
					'dropdownOptions'=>['class'=>'pull-right dropup'],
					'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
					'buttons' => [
							'view' =>function($url, $model, $key){
									return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
																['/salesman/schedule-group-crm/view','id'=>$model->ID],[
																'data-toggle'=>"modal",
																'data-target'=>"#modal-view",
																'data-title'=> '',//$model->KD_BARANG,
																]). '</li>' . PHP_EOL;
							},
							'update' =>function($url, $model, $key){
									return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Update'),
																['/salesman/schedule-group-crm/update','id'=>$model->ID],[
																'data-toggle'=>"modal",
																'data-target'=>"#modal-create",
																'data-title'=>'',// $model->KD_BARANG,
																]). '</li>' . PHP_EOL;
							},
					],
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							//'width'=>'150px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'9pt',
							'background-color'=>'rgba(97, 211, 96, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'center',
							//'width'=>'150px',
							//'height'=>'10px',
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
						'before'=>$button_add_group,
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
				'template' =>Helper::filterActionColumn('{view-group}{update-group}'),
				'dropdownOptions'=>['class'=>'pull-right dropup'],
				'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
				'buttons' => [
					 'view-group' =>function($url, $model, $key){
								return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
															['/salesman/schedule-group-crm/view-group','id'=>$model->CUST_KD],[
															'data-toggle'=>"modal",
															'data-target'=>"#modal-view",
															'data-title'=> '',//$model->KD_BARANG,
															]). '</li>' . PHP_EOL;
						},
						'update-group' =>function($url, $model, $key){
								return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Update'),
															['/salesman/schedule-group-crm/update-group','id'=>$model->CUST_KD],[
															'data-toggle'=>"modal",
															'data-target'=>"#modalmap",
															'data-title'=>'',// $model->KD_BARANG,
															]). '</li>' . PHP_EOL;
						},
				],
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						//'width'=>'150px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
						//'width'=>'150px',
						//'height'=>'10px',
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
					'before'=>$button_create,

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
	'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">View Schedule Group</h4></div>',
	'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
	],
	]);
	Modal::end();

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
	'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Schedule Group</h4></div>',
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
				'id' => 'modalmap',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Change Customers Group</h4></div>',
		'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
		],
		]);
		Modal::end();


?>

<?php


 ?>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Group Customers</h4>
        </div>
        <div class="modal-body">

					<?php
					$form = ActiveForm::begin([
						'id'=>'mapping',
					]);
					?>
					<input type="hidden"  name= custkd id="tes">
					<div class="form-group">
    			<!-- <label for="pwd">Nama Customers:</label> -->
    			<input type="hidden" class="form-control" id="cusnm">
					<!-- <label for="hidden">Alamat:</label> -->
					<input type="hidden" class="form-control" id="alam" >
  				</div>
					<?php  echo '<label class="control-label">Group Name </label>';  ?>
					<?= Select2::widget([
    			'name' => 'group',
    			'data' => $data,
    			'options' => [
							'id'=>'select-group',
        			'placeholder' => 'Select Group ...',
    					],
					]) ?>



        <div class="modal-footer">
					  <?= Html::submitButton('SAVE',['class' => 'btn btn-primary','id'=>'btn']); ?>
							<?php ActiveForm::end(); ?>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>




<?PHP
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
		 $.getJSON('/mastercrm/customers-crm/map', function(json) {

			for (var i in public_markers)
			{
				public_markers[i].setMap(null);
			}

			$.each(json, function (i, point) {


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
						// var contentString = '<p>' + point.ALAMAT + '</p>' + '<p>' + point.CUST_NM + '</p>'+'<p>'+ point.SCDL_GROUP_NM + '<p>' ;
							var contentString = '<p>' + point.ALAMAT + '</p>' + '<p>' + point.CUST_NM + '</p>';

	 													 google.maps.event.addListener(public_markers[i], 'mouseover', function () {
																 var infowindow = new google.maps.InfoWindow({
																		content: contentString
																 });
																 infowindow.open(map, public_markers[i]);
															 });

															 google.maps.event.addListener(public_markers[i], 'click', function () {
																	 $('#tes').val(point.CUST_KD);
																		$('#myModal').modal();
																 });
				}
				else{
						var contentString = '<p>' + point.ALAMAT + '</p>' + '<p>' + point.CUST_NM + '</p>'+'<p>'+ point.SCDL_GROUP_NM + '<p>' ;

						google.maps.event.addListener(public_markers[i], 'mouseover', function (event) {
																	 var infowindow = new google.maps.InfoWindow({
																			content: contentString
																	 });
																	 infowindow.open(map, public_markers[i]);
																 });
					google.maps.event.addListener(public_markers[i], 'click', function (event) {
									 																		$('#tes').val(point.CUST_KD);
																											$('#cusnm').val(point.CUST_NM);
																											$('#alam').val(point.ALAMAT);
									 																		 $('#myModal').modal();
									 																	 });

				}

			});


		 });

		 $('#mapping').on('beforeSubmit',function(){
			//  e.preventDefault();
			 var idx = $('#tes').val();
			 var name = $('#select-group').val();
			 if(name == '')
			 {
				 alert('maaf tolong di pilih nama group');
				 return false;
			 }
			 else
			 {
			 $.ajax({
					 url: '/salesman/schedule-group-crm/create-group?CUST_KD=' + idx,
					//  url: '/purchasing/request-order/approved_rodetail',
					 type: 'POST',
					 //contentType: 'application/json; charset=utf-8',
					//  data:'id='+idx,
							data:'name='+name,
					 dataType: 'json',
					 success: function(result) {
						 if (result == 1){
							        $(document).find('#myModal').modal('hide');
											var map = new google.maps.Map(document.getElementById('map'),
												 {
												 zoom: 12,
												 center: new google.maps.LatLng(-6.229191531958687,106.65994325550469),
												 mapTypeId: google.maps.MapTypeId.ROADMAP

											 });
											 $.getJSON('/mastercrm/customers-crm/map', function(json) {

												for (var i in public_markers)
												{
													public_markers[i].setMap(null);
												}

												$.each(json, function (i, point) {

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
																					var contentString = '<p>' + point.ALAMAT + '</p>' + '<p>' + point.CUST_NM + '</p>'+'<p>'+ point.SCDL_GROUP_NM + '<p>' ;

																							 google.maps.event.addListener(public_markers[i], 'mouseover', function () {
																									 var infowindow = new google.maps.InfoWindow({
																										 	content: contentString
																									 });
																									 infowindow.open(map, public_markers[i]);
																								 });

																								 google.maps.event.addListener(public_markers[i], 'click', function (event) {
																																		$('#tes').val(point.CUST_KD);
																																		$('#myModal').modal();
																																	});
													}
													else{

															var contentString = '<p>' + point.ALAMAT + '</p>' + '<p>' + point.CUST_NM + '</p>'+'<p>'+ point.SCDL_GROUP_NM + '<p>' ;
															google.maps.event.addListener(public_markers[i], 'mouseover', function (event) {
																										 var infowindow = new google.maps.InfoWindow({
																												content: contentString
																										 });
																										 infowindow.open(map, public_markers[i]);
																									 });
															 google.maps.event.addListener(public_markers[i], 'click', function (event) {
																 									$('#tes').val(point.CUST_KD);
																									$('#myModal').modal();
								 																});


													}


												});


											 });

						 } else {
							 // Fail
						 }
					 }
				 });
			 }
				 return false;

		 });

		// console.trace();
     ",$this::POS_READY);


?>
