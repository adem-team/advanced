<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use ptrnov\fullcalendar\FullcalendarScheduler;


 /* $JSCode = <<<EOF
	function( start, end, jsEvent, view) {
		//alert('Event: ' + jsEvent.title);
		//alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
		//$.get('/widget/pilotproject/createparent',{'tgl1':tgl1,'tgl2':tgl2},function(data){
		$.get('/fullcalendar/test/test-form',function(data){
						$('#modal-select').modal('show')
						.find('#modalContent')
						.html(data);
		});
	}
EOF; */

$JSEventClick = <<<EOF
	function(calEvent, jsEvent, view) {
		alert('test');
	}
EOF;

$JSaddButtonRooms = <<<EOF
	function() {
		alert('test');
	}
EOF;
/* $JSDropEvent = <<<EOF
function(event, element, view) {
    var child = event.parent;
    var status = event.status;

    var dateTime2 = new Date(event.end);
	var dateTime1 = new Date(event.start);
	var tgl1 = moment(dateTime1).format("YYYY-MM-DD");
	var tgl2 = moment(dateTime2).subtract(1, "days").format("YYYY-MM-DD");
	alert(tgl1);
    var id = event.id;
    if(child != 0 && status != 1){
    	$.get('/widget/pilotproject/drop-child',{'id':id,'tgl1':tgl1,'tgl2':tgl2});
    }

}
EOF; */
	$wgCalendar=FullcalendarScheduler::widget([		
		'modalSelect'=>[
			/**
			 * modalSelect for cell Select
			 * 'clientOptions' => ['selectable' => true]					//makseure set true.
			 * 'clientOptions' => ['select' => function or JsExpression] 	//makseure disable/empty. if set it, used JsExpressio to callback.			
			 * @author piter novian [ptr.nov@gmail.com]		 				//"https://github.com/ptrnov/yii2-fullcalendar".
			*/
			'id' => 'modal-select',											//set it, if used FullcalendarScheduler more the one on page.
			'id_content'=>'modalContent',									//set it, if used FullcalendarScheduler more the one on page.
			'headerLabel' => 'Model Header Label',							//your modal title,as your set.	
			'modal-size'=>'modal-lg'										//size of modal (modal-xs,modal-sm,modal-sm,modal-lg).
		],
		'header'        => [
			'left'   => 'details, today prev,next',
			'center' => 'title',
			'right'  => 'timelineOneDays,agendaWeek,month,listWeek',
		],
		'options'=>[
			'id'=> 'calendar_test',															//set it, if used FullcalendarScheduler more the one on page.
			'language'=>'id',
		],
		'optionsEventUrl'=>[
			'events' => Url::to(['/widget/pilotproject/event-calendar-schedule']),			//should be set "your Controller link" 	
			'resources'=> Url::to(['/widget/pilotproject/resource-calendar-schedule']),		//should be set "your Controller link" 
			'eventDropUrl'=>'/widget/pilotproject/drop-calendar-schedule',					//should be set "your Controller link" to get(start,end) from select. You can use model for scenario.
			'eventSelectUrl'=>'/widget/pilotproject/test-form',								//should be set "your Controller link" to get(start,end) from select. You can use model for scenario			
			'eventDragableUrl'=>'/fullcalendar/test/dragable',								//dragable, new data, star date, end date, id form increment db
		],		
		'clientOptions' => [
			'customButtons'=>[ //additional button
				'details'=>[
					'text'=>'Rooms',
						'click'=>new JsExpression($JSaddButtonRooms)
				]
			],
			'language'=>'id',
			'selectHelper' => true,			
			'editable' => true,
			'selectable' => true,
			//'select' => new JsExpression($JSCode),										// don't set if used "modalSelect"
			'eventClick' => new JsExpression($JSEventClick),
			'droppable' => true,
			//'eventDrop' => new JsExpression($JSDropEvent),
			'now' => '2016-05-07 06:00:00',
			'firstDay' =>'0',
			'theme'=> true,
			'aspectRatio'       => 1.8,
			'scrollTime'        => '00:00', // undo default 6am scrollTime
			'defaultView'       => 'timelineMonth',//'timelineDay',//agendaDay',
			'views'             => [
				'timelineOneDays' => [
					'type'     => 'timeline',
					'duration' => [
						'days' => 2,
					],
				], 
			
			],
			'resourceAreaWidth'=>'30%',
			'resourceLabelText' => 'Discriptions',
			'resourceGroupField'=> 'srcparent',
			'resourceColumns'=>[					
					[
						'labelText'=>'Rooms',
						'field'=> 'title',
						'width'=>'150px',
						'align'=>'center',
					],
					[
						'labelText'=> 'Department',
						'field'=> 'title',
						'width'=>'150px',
					],
					[
						'labelText'=> 'CreateBy',
						'field'=> 'createby',
						'width'=>'100px',
					]
			],			
		],	
	
	]);
	
/* 	Modal::begin([
		'headerOptions' => ['id' => 'modalHeader'],
		'id' => 'modal-select',
		// 'size' => 'modal-sm',
		//keeps from closing modal with esc key or by clicking out of the modal.
		// user must click cancel or X to close
		// 'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
	]);
	echo "<div id='modalContent'></div>";
	Modal::end(); */

?>


<?php
 $this->registerJs("
	/* $('.resourceHeader').click(function(){
      var   resourceId=$(this).attr('id');
      //write a code to get all the events of selected resource 
      //and render it on calendar
     }); 	 */
		/* $(function() { // document ready
			 $('#external-events .fc-event').each(function() {

				// store data so the calendar knows to render an event upon drop
				$(this).data('event', {
					title: $.trim($(this).text()), // use the element's text as the event title
					stick: true // maintain when user navigates (see docs on the renderEvent method)
				});

				// make the event draggable using jQuery UI
				$(this).draggable({
					zIndex: 999,
					revert: true,      // will cause the event to go back to its
					revertDuration: 0  //  original position after the drag
				});

			}); 
		)}; */
",$this::POS_BEGIN);


/*
 * Triger timeout button triger with timeout.
 * @author piter novian [ptr.nov@gmail.com] 
*/	
 $this->registerJs("	
	/* $(document).ready(function() {
		$('#tab-project-id').click(function(){
			setTimeout(function(){				
				var idx = $('ul li.active').index();
				//alert(idx);
				if (idx==5){
					//alert(idx);
					var elem = document.getElementById('calendar_test');
					var list = elem.getElementsByTagName('button')[3];
						//list.onmouseover = function() {
						//list.className='ui-state-hover';
						//list.focus();
						setTimeout(function(){
							list.click();
						},100);
				}
			},100);
		});	
	}); */
 ",$this::POS_READY);

?>
<div  class="row" style="margin-top:0px,font-family: verdana, arial, sans-serif ;font-size: 8pt"> 
	<div  class="col-xs-12 col-sm-12 col-dm-2 col-lg-2">
	<div class="row">
		 <section class="content">
			<div class="box box-solid">
				<div class="box-header with-border">
				  <h5>Create Event</h5>
				</div>
				<div class="box-body">
				  <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
					<!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
					<ul class="fc-color-picker" id="color-chooser">
					  <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
					  <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
					  <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
					  <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
					  <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
					  <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
					  <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
					  <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
					  <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
					  <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
					  <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
					  <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
					  <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
					</ul>
				  </div>
				  <!-- /btn-group -->
				  <div class="input-group">
					<input id="new-event" type="text" class="form-control" placeholder="Event Title">

					<div class="input-group-btn">
					  <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Add</button>
					</div>
					<!-- /btn-group -->
				  </div>
				  <!-- /input-group -->
				</div>
			</div>
			<div class="box-body">
				<div id='external-events'>
					<h5>Draggable Events</h5>
					<div class='external-event bg-green '>My Event 1</div>
					<div class='external-event bg-yellow'>My Event 2</div>
					<div class='external-event bg-aqua'>My Event 3</div>
					<div class='external-event bg-light-blue'>My Event 4</div>
					<div class='external-event bg-red'>My Event 5</div>
					<p>
						<input type='checkbox' id='drop-remove' />
						<label for='drop-remove'>remove after drop</label>
					</p>
				</div>
			</div>
		 </section>
		</div>
	</div>
	<div  class="col-xs-12 col-sm-12 col-dm-10 col-lg-10">
		<div class="row">
			<?php echo $wgCalendar;?>
		</div>
	</div>
</div>

	

