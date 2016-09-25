<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use ptrnov\fullcalendar\FullcalendarScheduler;

//  function buildTree( $ar, $pid = 0 ) {
//     $op = array();
//     foreach( $ar as $item ) {
//         if( $item['PARENT'] == $pid ) {
//             $op[] = [
//                 'id' => $item['ID'],
//                 'title' => $item['PILOT_NM']
//                 ];
           
//             // using recursion
//             $children =  buildTree( $ar, $item['ID'] );
//             if( $children ) {
//                 $op['children'] = $children;
//             }
//         }
//     }
//     return $op;
// }

// $sql = 'select PARENT,ID ,PILOT_NM,CREATED_BY as title from sc0001 ORDER BY SORT';
//         $ary = Yii::$app->db_widget->createCommand($sql)->queryAll();

//   $aryResource = buildTree($ary, $pid = 0);
  // print_r($aryResource);
  // die();
  

/* $personalUser=Yii::$app->getUserOpt->Profile_user();
print_r($personalUser	); */
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
		//alert('test');
		$.get('/widget/pilotproject/room-form',function(data){
						$('#modal-rooms').modal('show')
						.find('#modalContentRooms')
						.html(data);
		});
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
			//'events' => Url::to(['/widget/pilotproject/render-data-events']),			//should be set data event "your Controller link" 	
			//'resources'=> Url::to(['/widget/pilotproject/render-data-resources']),		//should be set "your Controller link" 
			'eventSelectUrl'=>'/widget/pilotproject/set-data-select',					//should be set "your Controller link" to get(start,end) from select. You can use model for scenario			
			'changeDropUrl'=>'/widget/pilotproject/change-data-drop',					//should be set "your Controller link" to get(start,end) from select. You can use model for scenario.
			'dragableReceiveUrl'=>'/widget/pilotproject/dragable-receive',				//dragable, new data, star date, end date, id form increment db
			'dragableDropUrl'=>'/widget/pilotproject/dragable-drop',					//dragable, new data, star date, end date, id form increment db
		],		
		'clientOptions' => [
			'customButtons'=>[ //additional button
				'details'=>[
					'text'=>'Rooms',
						'click'=>new JsExpression($JSaddButtonRooms)
				]
			],
			 'timezone'=> 'local',
			//'language'=>'id',
			 // 'locale'=>'id',
			// 'isRTL'=> true,
			//'ignoreTimezone'=> false,
			//'timezone'=>'currentTimezone',
			'selectHelper' => true,			
			'editable' => true,
			'selectable' => true,
			//'select' => new JsExpression($JSCode),										// don't set if used "modalSelect"
			'eventClick' => new JsExpression($JSEventClick),
			'droppable' => true,
			//'eventDrop' => new JsExpression($JSDropEvent),
			//'now' => \Yii::$app->ambilKonvesi->convert($model->start,'datetime'),//'2016-05-07 06:00:00',
			'firstDay' =>'0',
			'theme'=> true,
			'aspectRatio'       => 1.8,
			//'scrollTime'        => '00:00', // undo default 6am scrollTime
			'defaultView'       => 'timelineMonth',//'timelineDay',//agendaDay',
			'views'             => [
				'timelineOneDays' => [
					'type'     => 'timeline',
					'duration' => [
						'days' => 2,
					],
				], 
			
			],
			//'resources'=> \yii\helpers\Url::to(['pilotproject/render-data-resources', 'id' => 1]),
			//'events'=> \yii\helpers\Url::to(['pilotproject/render-data-events', 'id' => 2]),
			// 'resourceAreaWidth'=>'30%',
			// 'resourceLabelText' => 'Discriptions',
			 'resourceGroupField'=> 'srcparent',
			// 'resourceColumns'=>[					
			// 		[
			// 			'labelText'=>'Rooms',
			// 			'field'=> 'title',
			// 			'width'=>'150px',
			// 			'align'=>'left',
			// 		],
			// 		[
			// 			'labelText'=> 'Department',
			// 			'field'=> 'title',
			// 			'width'=>'150px',
			// 			'align'=>'center',
			// 		],
			// 		[
			// 			'labelText'=> 'CreateBy',
			// 			'field'=> 'createby',
			// 			'width'=>'100px',
			// 			'align'=>'center',
			// 		]
			// ],			
		],	
	
	]);
	
 	Modal::begin([
		'header'=>'Rooms',
		'id' => 'modal-rooms',
		'size' => 'modal-sm',
		//keeps from closing modal with esc key or by clicking out of the modal.
		// user must click cancel or X to close
		// 'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
	]);
	echo "<div id='modalContentRooms'></div>";
	Modal::end(); 

?>


<?php
 $this->registerJs("
	/* ADDING EVENTS */
    var currColor = '#3c8dbc'; //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn');
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css('color');
      //Add color effect to button
      $('#add-new-event').css({'background-color': currColor, 'eventColor': currColor});
    });

	$('#add-new-event').click(function (e) {
      e.preventDefault();
      //Get value and make sure it is not null
      var val = $('#new-event').val();
      if (val.length == 0) {
        return;
      }

      //Create events
      var event = $('<div />');
      event.css({'background-color': currColor, 'eventColor': currColor, 'color': '#fff'}).addClass('external-event');
      event.html(val);
      $('#external-events').prepend(event);

      //Add draggable funtionality
      ini_events(event);

      //Remove event from text input
      $('#new-event').val('');
    });	
",$this::POS_END);


/*
 * Triger timeout button triger with timeout.
 * @author piter novian [ptr.nov@gmail.com] 
*/	
 $this->registerJs("	
document.addEventListener('DOMContentLoaded', function(event) {
		// $(document).ready(function() {
			$('#tab-project-id').click(function(){
				setTimeout(function(){				
					var idx = $('ul li.active').index();
					//alert(idx);
					if (idx==0){
						//alert(idx);
						var elem = document.getElementById('calendar_test');
						var list = elem.getElementsByTagName('button')[4];
							//list.onmouseover = function() {
							//list.className='ui-state-hover';
							//list.focus();
							setTimeout(function(){
								list.click();
							},100);
					}
				},100);
			});	
		//});
	}
 ",$this::POS_READY);

?>
<div  class="row" style="margin-top:0px,font-family: verdana, arial, sans-serif ;font-size: 8pt"> 
	<div  class="col-xs-12 col-sm-12 col-dm-2 col-lg-2">
	<div class="row">
		 <section class="content">
			<div class="box box-solid">
				<div class="box-body">
					
						<h5>Draggable Events</h5>
						<div id='external-events'>
						<div class='external-event bg-green '>My Event 1</div>
						<div class='external-event bg-yellow'>My Event 2</div>
						<div class='external-event bg-aqua'>My Event 3</div>
						<div class='external-event bg-light-blue'>My Event 4</div>
						<div class='external-event bg-red'>My Event 5</div>
						<div class='external-event bg-aqua'>My Event 3</div>
						<div class='external-event bg-light-blue'>My Event 4</div>
						<div class='external-event bg-red'>My Event 5</div>
						
						<p>
							<input type='checkbox' id='drop-remove' />
							<label for='drop-remove'>remove after drop</label>
						</p>
					</div>
				</div>
			</div>
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
		 </section>
		</div>
	</div>
	<div  class="col-xs-12 col-sm-12 col-dm-10 col-lg-10">
		<div class="row">
			<?php echo $wgCalendar;?>
		</div>
	</div>
</div>

	

