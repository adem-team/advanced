<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use lukisongroup\master\models\Schedulegroup;
use lukisongroup\master\models\Customers;

use lukisongroup\assets\MapAsset;       			  /* CLASS ASSET CSS/JS/THEME Author: -wawan-*/
MapAsset::register($this);

$this->sideCorp = 'PT.Effembi Sukses Makmur';         /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_customers';                    /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Group');          /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;        /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

	 /*
	 * GRIDVIEW GROUP LIST
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */	 
	 $gvGroupListLocation=$this->render('_indexGroupList',[
		'dataProvider' => $dataProvider,
		'searchModel' => $searchModel,
	 ]);
	 
	  /*
	 * GRIDVIEW GROUP LIST DETAIL
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */	 
	 $gvCustGroupListDetail=$this->render('_indexGroupListDetail',[
		'dpListCustGrp' => $dpListCustGrp,
		'searchModel' => $searchModel,
		'field_cust' =>$field_cust
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
		<!-- LIST GROUP LOCALTION !-->
		<div class="col-md-5" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
			<?=$gvGroupListLocation?>
		</div>
		<!-- GROUP CUSTOMER LIST !-->
		<div class="col-md-7">

			<?php
				//echo $gvCustGroupList;
			?>
			<?=$gvCustGroupListDetail?>
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
		 $.getJSON('/master/customers/map', function(json) {

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
					 url: '/master/schedule-group/create-group?CUST_KD=' + idx,
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
											 $.getJSON('/master/customers/map', function(json) {

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
