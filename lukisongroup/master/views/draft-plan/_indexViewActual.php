<?php
//use yii\helpers\Html;
use kartik\helpers\Html;
//use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use kartik\widgets\Spinner;

$ptr_spinerActual=Spinner::widget(['id'=>'spn-actual','preset' => 'large', 'align' => 'center', 'color' => 'blue']);

$JSCode = <<<EOF
	function(start, end) {
	$("#set-out-case-id").attr("href","/master/draft-plan/set-out-case")
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
		var tgl = calEvent.start;
		var tgl1 = new Date(tgl);
		var id = moment(tgl1).format("YYYY-MM-DD");
		var user  =  calEvent.id;
		var name =  calEvent.name;
		var grp =  calEvent.grp;
		var split = grp.substring(0, 4);
		var group = calEvent.scdl;
		 $.get("/master/draft-plan/get-data-actual?id="+id+"&userid="+user+"&grp="+grp, function( data ) {
            	 var peopleHTML = "";
            	 var data = $.parseJSON(data);
				 var i=1;
            	 // console.log(data); 
            	// console.log(data.scdlheader['NOTE']); 				
			      // Loop through Object and create peopleHTML
			      for (var key in data) {
					  
			        if (data.hasOwnProperty(key)) {
						var sttcase=data[key]['STATUS_CASE']!='0'?'CASE':'PLAN';
						var layernm =  data[key].tbllayer != null ?data[key].tbllayer['LAYER_NM'] : 'none';
					 peopleHTML += "<tr>";
			            peopleHTML += "<td>" + i + "</td>";
			            peopleHTML += "<td>" + data[key]["TGL"] + "</td>";
			            peopleHTML += "<td>" + data[key].cust['CUST_NM'] + "</td>";
			            //peopleHTML += "<td>" + layernm + "</td>";
			            peopleHTML += "<td>" + data[key].tbllayer['LAYER_NM'] + "</td>";
			            peopleHTML += "<td>" + sttcase + "</td>";
			          peopleHTML += "</tr>";
					  i=i+1;
			        }
			      }
		 		 // Replace table’s tbody html with peopleHTML
      			$("#actual tbody").html(peopleHTML);
            });


           $("#set-out-case-id").attr("href","/master/draft-plan/set-out-case?tgl="+id+"&username="+name+"&group="+group+"&grpid="+split+"&userid="+user);


	   // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
		//alert('View: ' + view.name);
		// change the border color just for fun
		$(this).css('border-color', 'red');
	}
EOF;


	/*
	 * VIEW SCHEDULE ACTUAL
	 * @author ptrnov  [ptr.nov@gmail.com]
	 * @since 1.2
	*/
	$calenderActual=yii2fullcalendar\yii2fullcalendar::widget([
		'id'=>'scdl-actual',
		'options' => [
			'lang' => 'id',
		],
		// 'events'=> $events,
		'ajaxEvents' => Url::to(['/master/draft-plan/jsoncalendar-actual']),
		'clientOptions' => [
			'selectable' => true,
			'selectHelper' => true,
			'droppable' => true,
			'editable' => true,
			'firstDay' =>'0',
			//'drop' => new JsExpression($JSDropEvent),
			'selectHelper'=>true,
			// 'select' => new JsExpression($JSCode),
			'eventClick' => new JsExpression($JSEventClick),
			//'defaultDate' => date('Y-m-d')
		],
		//'ajaxEvents' => Url::toRoute(['/site/jsoncalendar'])
	]);
	$btn_exportActual = Html::a('<i class="fa fa-file-excel-o"></i> Export Excel',
									'/master/draft-plan/export-modal?flag=0',
									[		
										'data-toggle'=>"modal",		
										'data-target'=>"#modal-export-actual",		
										'class' => 'btn btn-info btn-sm'		
									]
							);


	$btn_set_outcase = Html::a('<i class="fa fa-magic"></i> SET OUT CASE',
									'/master/draft-plan/set-out-valid',
									[
										'id'=>'set-out-case-id',		
										'data-toggle'=>"modal",		
										'data-target'=>"#modal-Case",		
										'class' => 'btn btn-warning btn-sm'		
									]
							);
	$btn_sync = Html::a('<i class="fa fa-exchange"></i> Syncronize a month',
									'/master/draft-plan/set-sync',
									[	'id'=>'sync-approved',
										'data-toggle'=>"modal",		
										'data-target'=>"#modal-sync",		
										'class' => 'btn btn-danger btn-sm'		
									]
							);
	$info = "<div id =actual><table class='table'><thead>
      <tr>
        <th>#</th>
        <th>TGL</th>
        <th>CUSTOMERS</th>
        <th>LAYER</th>
        <th>STATUS</th>
      </tr>
    </thead> <tbody>
    </tbody>
  </table></div>";

  $viewDetailactual= Html::panel(
					['heading' => '<div style="width:160px">DETAIl GROUP ACTUAL </div>'.' '.'<div style="float:right; margin-top:-22px;margin-right:-12px;">'.$btn_set_outcase.'</div>', 'body' =>$info],
					Html::TYPE_DANGER
				);	

	$vwScdlActual= Html::panel(
					['heading' => '<div style="width:160px">'.$btn_exportActual.'</div>'.' '.'<div style="float:right; margin-top:-32px;margin-right:0px;">'.$btn_sync.'</div>','body' =>$ptr_spinerActual.$calenderActual],
					Html::TYPE_SUCCESS
				);	
?>
<div class="row">
	<div class="col-sm-7 col-md-7 col-lg-7" style="font-family: verdana, arial, sans-serif ;font-size: 8pt">
		<?=$vwScdlActual?>
	</div>
	<div class="col-sm-5 col-md-5 col-lg-5">
		<?php echo $viewDetailactual?>
	</div>
</div>
<?php
$this->registerJs("		
         $.fn.modal.Constructor.prototype.enforceFocus = function(){};		
         $('#modal-export-actual').on('show.bs.modal', function (event) {		
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
         'id' => 'modal-export-actual',		
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-file-excel-o"></div><div><h4 class="modal-title"> SCHEDULE ACTUAL</h4></div>',
		 'size' => Modal::SIZE_SMALL,		 
         'headerOptions'=>[		
                 'style'=> 'border-radius:5px; background-color:  rgba(90, 171, 255, 0.7)',		
         ],		
     ]);		
     Modal::end();

     $this->registerJs("		
         $.fn.modal.Constructor.prototype.enforceFocus = function(){};		
         $('#modal-Case').on('show.bs.modal', function (event) {		
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
         'id' => 'modal-Case',		
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-magic"></div><div><h4 class="modal-title"> SET OUT CASE</h4></div>',
		 'size' => Modal::SIZE_SMALL,		 
         'headerOptions'=>[		
                 'style'=> 'border-radius:5px; background-color:  rgba(255, 129, 117, 1)',		
         ],		
     ]);		
     Modal::end();
	
	/*
	  * Syncronize Plan to Actual
	 */
	 $this->registerJs("		
         $.fn.modal.Constructor.prototype.enforceFocus = function(){};		
         $('#modal-sync').on('show.bs.modal', function (event) {		
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
         'id' => 'modal-sync',		
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-exchange"></div><div><h4 class="modal-title">SYNCRONIZE ACTUAL</h4></div>',
		 'size' => Modal::SIZE_SMALL,		 
         'headerOptions'=>[		
                 'style'=> 'border-radius:5px; background-color:  rgba(255, 129, 117, 1)',		
         ],		
     ]);	
	  Modal::end();
	 $this->registerJs("		
		/* $(document).ajaxStart(function(){
			$(document).ready(function() {
				 var s= document.getElementById('spn-actual');
				 s.hidden=false;
			});
		 }).ajaxStop(function(){
			$(document).ready(function() {
				var s= document.getElementById('spn-actual');
				s.hidden=true;
			});
		 });	 */
		 $(document).on('ajaxStop', function() {
				var s= document.getElementById('spn-actual');
				s.hidden=true;
		  });
     ",$this::POS_READY);
	 
	 
	 
?>
