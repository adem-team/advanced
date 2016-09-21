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
			'left'   => 'today prev,next',
			'center' => 'title',
			'right'  => 'timelineOneDays,agendaWeek,month,listWeek',
		],
		'options'=>[
			'id'=> 'calendar_test',															//set it, if used FullcalendarScheduler more the one on page.
			'language'=>'id',
		],
		'optionsEventAdd'=>[
			'events' => Url::to(['/widget/pilotproject/event-calendar-schedule']),			//should be set "your Controller link" 	
			'resources'=> Url::to(['/widget/pilotproject/resource-calendar-schedule']),		//should be set "your Controller link" 
			//disable 'eventDrop' => new JsExpression($JSDropEvent),
			'eventDropUrl'=>'/widget/pilotproject/drop-calendar-schedule',								//should be set "your Controller link" to get(start,end) from select. You can use model for scenario.
			'eventSelectUrl'=>'/widget/pilotproject/test-form',								//should be set "your Controller link" to get(start,end) from select. You can use model for scenario			
			'eventDragableUrl'=>'/fullcalendar/test/dragable',								//dragable, new data, star date, end date, id form increment db
		],		
		'clientOptions' => [
			'language'=>'id',
			'selectHelper' => true,			
			'editable' => true,
			'selectable' => true,
			//'select' => new JsExpression($JSCode),										// don't set if used "modalSelect"
			'eventClick' => new JsExpression($JSEventClick),
			'droppable' => true,
			//'eventDrop' => new JsExpression($JSDropEvent),
			'now' => '2016-05-07',
			'firstDay' =>'0',
			'theme'=> true,
			'aspectRatio'       => 1.8,
			//'scrollTime'        => '00:00', // undo default 6am scrollTime
			'defaultView'       => 'timelineMonth',//'timelineDay',//agendaDay',
			'views'             => [
				'timelineOneDays' => [
					'type'     => 'timeline',
					'duration' => [
						'days' => 1,
					],
				], 
			
			],			
			'resourceLabelText' => 'Rooms',
			'resourceColumns'=>[
					[
						'labelText'=> 'Department',
						'field'=> 'title'
					],
					[
						'labelText'=> 'parent Event',
						'field'=> 'title'
					],
					[
						'labelText'=> 'CreateBy',
						'field'=> 'create_at'
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
	$(document).ready(function() {
		$('#tab-project-id').click(function(){
			setTimeout(function(){				
				var idx = $('ul li.active').index();
				//alert(idx);
				if (idx==5){
					//alert(idx);
					var elem = document.getElementById('calendar_test');
					var list = elem.getElementsByTagName('button')[0];
						//list.onmouseover = function() {
						//list.className='ui-state-hover';
						//list.focus();
						setTimeout(function(){
							list.click();
						},100);
				}
			},100);
		});	
	});
 ",$this::POS_READY);

?>
<div  class="row" style="margin-top:0px,font-family: verdana, arial, sans-serif ;font-size: 8pt"> 
	<div  class="col-xs-2 col-sm-2 col-dm-2 col-lg-2">
		<div id='external-events'>
			<h4>Draggable Events</h4>
			<div class='fc-event'>My Event 1</div>
			<div class='fc-event'>My Event 2</div>
			<div class='fc-event'>My Event 3</div>
			<div class='fc-event'>My Event 4</div>
			<div class='fc-event'>My Event 5</div>
			<p>
				<input type='checkbox' id='drop-remove' />
				<label for='drop-remove'>remove after drop</label>
			</p>
		</div>
	</div>
	<div  class="col-xs-10 col-sm-10 col-dm-10 col-lg-10">
		<?php echo $wgCalendar;?>
	</div>
</div>

	

