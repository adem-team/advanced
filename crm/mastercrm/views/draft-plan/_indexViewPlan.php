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

$ptr_spiner=Spinner::widget(['id'=>'spn-plan','preset' => 'large', 'align' => 'center', 'color' => 'blue']);	
$JSCode = <<<EOF
	function(start, end) {
		var title = prompt('Event Title:');
		var eventData;
		var dateTime1 = new Date(start);
		var dateTime2 = new Date(end);
		tgl1 = moment(dateTime1).format("YYYY-MM-DD HH:mm:ss");
		tgl2 = moment(dateTime2).format("YYYY-MM-DD HH:mm:ss");
		if (title) {
			$.ajax({
				url:'/sistem/personalia/jsoncalendar_add',
				type: 'POST',
				data:'title=' + title + '&start='+ tgl1 + '&end=' + tgl2,
				dataType:'json',
				success: function(result){
			//alert('ok')
				  $.pjax.reload({container:'#calendar-user'});
				  //$.pjax.reload({container:'#gv-schedule-id'});
				}
			});
			/* calendar.fullCalendar('renderEvent', {
					title:title,
					start:start,
					end:end
				},
				true
			); */

		   /*  eventData = {
				title: title,
				start: start,
				end: end
			};
			//$('#w0').fullCalendar('renderEvent', eventData, true);
			*/
		}

		//$('#w0').fullCalendar('unselect');
		//$('#w0').fullCalendar('unselect');
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
		// alert('Event: ' + calEvent.id);
		var tgl = calEvent.start;
		var tgl1 = new Date(tgl);
		var id = moment(tgl1).format("YYYY-MM-DD");
		var grp =  calEvent.grp;
		//alert(grp);
		 $.get("/mastercrm/draft-plan/get-data-plan?id="+id+"&grp="+grp, function( data ) {
            	 var peopleHTML = "";
            	 var data = $.parseJSON(data);
				 var i=1;
            	// console.log(data.custTbl['CUST_NM']); 
			      // Loop through Object and create peopleHTML
			      for (var key in data) {
			        if (data.hasOwnProperty(key)) {
			          peopleHTML += "<tr>";
			            peopleHTML += "<td>" + i + "</td>";
			            peopleHTML += "<td>" + data[key]["TGL"] + "</td>";
			            peopleHTML += "<td>" + data[key].custTbl['CUST_NM'] + "</td>";
			            peopleHTML += "<td>" + data[key].tbllayer["LAYER_NM"] + "</td>";
			          peopleHTML += "</tr>";
					  i=i+1;
			        }
			      }
		 		 // Replace table’s tbody html with peopleHTML
      			$("#detail tbody").html(peopleHTML);
            });

		

		//alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
		//alert('View: ' + view.name);
		// change the border color just for fun
		$(this).css('border-color', 'red');
	}
EOF;


	/*
	 * VIEW SCHEDULE PLAN 
	 * @author ptrnov  [ptr.nov@gmail.com]
	 * @since 1.2
	*/
	$calenderPlan=yii2fullcalendar\yii2fullcalendar::widget([
		'id'=>'scdl-plan',
		'options' => [
			'lang' => 'id',
			//'firstDay' => ['default' => '6'],
		//... more options to be defined here!
		],
		// 'events'=> $events,
		'ajaxEvents' => Url::to(['/mastercrm/draft-plan/jsoncalendar-plan']),
		'clientOptions' => [
			'selectable' => true,
			'selectHelper' => true,
			'droppable' => true,
			'editable' => true,
			'firstDay' =>'0',
			//'drop' => new JsExpression($JSDropEvent),
			'selectHelper'=>true,
			//'select' => new JsExpression($JSCode),
			'eventClick' => new JsExpression($JSEventClick),
			//'defaultDate' => date('Y-m-d')
		],
		//'ajaxEvents' => Url::toRoute(['/site/jsoncalendar'])
	]);
	
	$btn_exportPlan = Html::a('<i class="fa fa-file-excel-o"></i> Export Excel',
							'/mastercrm/draft-plan/export-modal?flag=1',
							[		
								'data-toggle'=>"modal",		
								'data-target'=>"#modal-export-plan",		
								'class' => 'btn btn-info btn-sm'		
						   ]
						);
	
	
	
	
	
	$vwScdlPlan= Html::panel(
					['heading' => $btn_exportPlan, 'body' =>$ptr_spiner.$calenderPlan],
					Html::TYPE_DANGER
				);
	
   
   
	$info = "<div id =detail><table class='table'><thead>
      <tr>
        <th>#</th>
        <th>TGL Masuk</th>
        <th>Customers</th>
        <th>LAYER LEVEL</th>
      </tr>
    </thead> <tbody>
    </tbody>
  </table></div>";
	$viewDetailPlan= Html::panel(
					['heading' => 'DETAIl GROUP PLAN', 'body' =>$info],
					Html::TYPE_DANGER
				);	
?>
<div class="row">
	<div class="col-sm-7 col-md-7 col-lg-7">
		<?=$vwScdlPlan?>
	</div>
	<div class="col-sm-5 col-md-5 col-lg-5">
		<?=$viewDetailPlan?>
	</div>
</div>

<?php		
 $this->registerJs("		
          $.fn.modal.Constructor.prototype.enforceFocus = function(){};		
          $('#modal-export-plan').on('show.bs.modal', function (event) {		
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
         'id' => 'modal-export-plan',		
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-file-excel-o"></div><div><h4 class="modal-title"> SCHEDULE PLAN</h4></div>',	
		 'size' => Modal::SIZE_SMALL,	
         'headerOptions'=>[		
                 'style'=> 'border-radius:5px; background-color: rgba(90, 171, 255, 0.7)',		
         ],		
     ]);		
     Modal::end();


	$this->registerJs("		
		//$(document).ready(function() {
			//$(window).load(function(){
				// var s= document.getElementById('spn-plan');
					 // s.hidden=false;
				// if(!window.onload) {
					// var s= document.getElementById('spn-plan');
					 // s.hidden=true;
				// }
			//});
			// $(document).ajaxStart('scdl-plan',function(){
					 // var s= document.getElementById('spn-plan');
					 // s.hidden=false;			 
			 // }).ajaxStop('scdl-plan',function(){				
					// var s= document.getElementById('spn-plan');
					 // s.hidden=true;				
			 // });	
		//});		
		$(document).on('ajaxStop', function() {
			var s= document.getElementById('spn-plan');
			s.hidden=true;
		});
     ",$this::POS_READY);		




?>