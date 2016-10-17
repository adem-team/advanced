<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use ptrnov\fullcalendar\FullcalendarScheduler;
use lukisongroup\widget\models\Pilotproject;
use yii\helpers\ArrayHelper;


$JSSelect = <<<EOF
	/**
	* Click Event Add, drag new event.
	* depedence with eventReceive (set url, harus di reload. refetchResources, refetchEvents).
	* Status : issue, render reload refresh, harusnya refresh fulcalendar bukan page.
	* author wawan
	*/	
	function(calEvent, jsEvent, view) {
		var dateTime1 = new Date(calEvent.start);
		var dateTime2 = new Date(calEvent.end);
		var tgl1 = moment(dateTime1).format('YYYY-MM-DD LTS');
		var tgl2 = moment(dateTime2).subtract(1, 'days').format('YYYY-MM-DD LTS');
		$.fn.modal.Constructor.prototype.enforceFocus = function(){};
		$.get('/widget/pilotproject/set-data-select',{'start':tgl1,'end':tgl2},function(data){
						$('#modal-rooms').modal('show')
						.find('#modalContentRooms')
						.html(data);
		});
	}
EOF;


$JSEventClick = <<<EOF
	/**
	* Click Event Add, drag new event.
	* depedence with eventReceive (set url, harus di reload. refetchResources, refetchEvents).
	* Status : Fixed.
	* author wawan, update piter novian [ptr.nov@gmail.com]
	*/	
	function(calEvent, jsEvent, event,view) {
		$('#calendar_test').fullCalendar('refetchEvents');
		var dateTime1 = new Date(calEvent.start);
		var dateTime2 = new Date(calEvent.end);
		var tgl1 = moment(dateTime1).format('YYYY-MM-DD LTS');
		var tgl2 = moment(dateTime2).subtract(1, 'days').format('YYYY-MM-DD LTS');
		$.fn.modal.Constructor.prototype.enforceFocus = function(){};
		//alert(calEvent.resourceId);
		$.get('/widget/pilotproject/detail-pilot',{'id':calEvent.resourceId},function(data){
						$('#modal-up').modal('show')
						.find('#modalContentUp')
						.html(data);
		});
	}
EOF;


$Jseventcolor = <<<EOF
	/**
	* View 
	* Status : unkown.
	* author wawan [wawan@lukison.com]
	*/
	function (event, element, view) {
		var status1 = event.status;
		var tgl = event.start;
			//alert(tgl);
			if(status1 == 1)
			{
				 element.html('close');
			};		
	} 
EOF;

$view = <<<EOF
	/**
	* View 
	* Status : unkown.
	* author wawan [wawan@lukison.com]
	*/
	function(view, element) {
        console.log("The view's title is " + view.intervalStart.format());
        console.log("The view's title is " + view.name);
    }
EOF;

$JSaddButtonRooms = <<<EOF
	/**
	* Add Room with Modal Class Yii. 
	* Status : Issue render refresh. harus js render.
	* author wawan [wawan@lukison.com]
	*/	
	function() {
		//alert('test');
		$.fn.modal.Constructor.prototype.enforceFocus = function(){};
		$.get('/widget/pilotproject/room-form',function(data){
						$('#modal-rooms').modal('show')
						.find('#modalContentRooms')
						.html(data);
		});
	}
EOF;

$JSaddAddRow= <<<EOF
	function() {
		/**
		* Add Row. 
		* Status : Fixed.
		* temporary from fulcalendar, jangan dengan $.get('/widget/pilotproject/tambah-row?tgl=2016-10-16',function(data){};
		* author piter novian [ptr.nov@gmail.com]
		*/	
		$('#calendar_test').fullCalendar( 'addResource', 
				function(callback) {
					somethingAsynchonous(function(data) {
						callback(data);
					})
				},scroll 
		);
			
		//$.get('/widget/pilotproject/tambah-row?tgl=2016-10-16',function(data){				
		// $('#calendar_test').fullCalendar( 'addResource', 
				// function(callback) {
					// somethingAsynchonous(function(data) {
						// callback(data);
				// })}, 
		
		// scroll );
			
		//});
		// setTimeout(function(){
			// $('#calendar_test').fullCalendar('refetchEvents');
		// },50);
	}
EOF;

$JSaddGrp= <<<EOF
	/**
	* Change Group/ungroup fullcalendar.
	* Status : Fixed.
	* JS Button click Benar	: $(document).on('click', '.fc-prev-button, .fc-next-button, .fc-today-button, .fc-timelineOneDays-button', function(){});
	* JS Button Click Salah : $('.fc-prev-button, .fc-next-button, .fc-today-button, .fc-timelineOneDays-button').click(function(){});
	* author piter novian [ptr.nov@gmail.com]
	*/	
	function () {
		var calendarOptions = $('#calendar_test')
			.fullCalendar('getView').options.resourceGroupField;	
			//alert(calendarOptions);
				
			$('#calendar_test').fullCalendar('option',{
					resourceGroupField: calendarOptions==''?'srcparent':'',
					isRTL: false, //kiri/kanan
			});			
	}
EOF;

$JSaddButtonExport = <<<EOF
	 function(){
		// var elem = document.getElementById('calendar_test');
		// var listBtn = elem.getElementsByTagName('button');
		//var listBtnUl = listBtn('ui-button ul state.active');
		// console.log(listBtn);
		
		
	// }
	//$(document).on('click','.fc-excel-export-button', function(){
		//jQuery(this).addClass('active');
		//$('.fc-timelineOneDays-button').removeClass('ui-state-active');
		$('.fc-timelineOneDays-button').addClass('fc-timelineOneDays-button ui-button ui-state-default ui-corner-left');
		//alert();
	//});
		//var elem = document.getElementById('calendar_test');
		//var listBtn = elem.getElementsByTagName('button');
		//var focused = listBtn.activeElement;
		 $('.fc-timelineOneDays-button').addClass('selected');
		//$('.fc-timelineOneDays-button').toggleClass('ui-state-active');
		 setTimeout(function(){
			if($('.fc-timelineOneDays-button').hasClass('ui-state-active')){
					//$('.fc-timelineOneDays-button').classList.toggle('ui-state-active');
	
			  // $('ui-state-active').removeClass();
			   //$('fc-agendaWeek-button ui-button ui-state-default').addClass('ui-state-default');
			   //alert('focused');
			    // var elem1 = document.getElementById('calendar_test');
				// var list1 = elem1.getElementsByClassName('fc-timelineOneDays-button');
				// console.log(list1[0].innerText);
				// list1[0].click();
			};
		},500); 
		
	}
EOF;

$afterAllRender = <<<EOF
	function(){		
			//$('.fc-timelineOneDays-button').addClass('ui-state-active');
			$('.fc-timelineOneDays-button').toggleClass('ui-state-active');
			//test();
			//$('.fc-timelineOneDays-button').toggleClass('ui-state-active');
			// var i;
			// for (i = 0; i < 10; i++) {
				// if (i === 1) { break; }
				// alert('sss');
			// }
	}
EOF;

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
			'left'   => 'plus,today, prev,next, details, group, excel-export',
			'center' => 'title',
			'right'  => 'timelineOneDays,agendaWeek,month,listWeek',
		],
		'options'=>[
			'id'=> 'calendar_test',															//set it, if used FullcalendarScheduler more the one on page.
			'language'=>'id',
		],
		'optionsEventUrl'=>[
			'events' => Url::to(['/widget/pilotproject/render-data-events','claster'=>'event']),		//should be set data event "your Controller link" 	
			//'resources'=> Url::to(['/widget/pilotproject/render-data-resources']),					//should be set "your Controller link" 
			'resources'=>[],		//should be set "your Controller link" 								//harus kosong, depedensi dengan button prev/next get resources
			// 'eventSelectUrl'=>'/widget/pilotproject/set-data-select',				//should be set "your Controller link" to get(start,end) from select. You can use model for scenario			
			'changeDropUrl'=>'/widget/pilotproject/change-data-drop',					//should be set "your Controller link" to get(start,end) from select. You can use model for scenario.
			'dragableReceiveUrl'=>'/widget/pilotproject/dragable-receive',				//dragable, new data, star date, end date, id form increment db
			'dragableDropUrl'=>'/widget/pilotproject/dragable-drop',					//dragable, new data, star date, end date, id form increment db
		],		
		'clientOptions' => [
		'theme'=> true,
			'customButtons'=>[ //additional button
				'details'=>[
					'text'=>'Rooms',
						'click'=>new JsExpression($JSaddButtonRooms),
				],
				'group'=>[
					'text'=>'Group',
						'click'=>new JsExpression($JSaddGrp),
				],
				 'plus'=>[
					'text'=>'Plus',
						'click'=>new JsExpression($JSaddAddRow),
				],
				'excel-export'=>[
					'text'=>'Excel-Export',
						'click'=>new JsExpression($JSaddButtonExport),
				]	
			],
			 'timezone'=> 'local',															//local timezone, wajib di gunakan.
			 //'timezone'=>'currentTimezone',												//not used, customize
			 //'viewRender'=> new JsExpression($view),										//not used, customize
			 //'language'=>'id',															//not used, customize
			 // 'locale'=>'id',																//not used, customize
			 // 'isRTL'=> true,																//not used, customize
			 //'ignoreTimezone'=> false,													//not used, customize			
			'selectHelper' => true,			
			'editable' => true,
			'selectable' => true,
			'select' => new JsExpression($JSSelect),										// don't set if used "modalSelect"
			'eventClick' => new JsExpression($JSEventClick),
			//'rerenderEvents'=> new JsExpression($JsBeforeRender), 
			'eventAfterRender'=> new JsExpression($Jseventcolor),
			'eventAfterAllRender'=> new JsExpression($afterAllRender),
			'droppable' => true,
			'firstDay' =>'0',
			'theme'=> true,
			'aspectRatio'       => 1.8,
			//'scrollTime'        => '00:00', 												// undo default 6am scrollTime, not used, customize
			//'defaultView'       => 'month',												// 'timelineDay',//agendaDay',not used, customize
			'defaultView'       => 'timelineDay',//agendaDay',
			'views'             => [
				'timelineOneDays' => [
					'type'     => 'timeline',
					'duration' => [
						'days' => 1,
					],
				], 
			
			],
			//'lazyFetching'=>true,															//not used, customize
			//'eventOverlap'=> true,														//not used, customize
			'resourceAreaWidth'=>'30%',
			'resourceLabelText' => 'Discriptions',
			//'resourceEditable'=>true, 													//not used, customize
			//'resourceGroupField'=> 'srcparent',											//handling button group
			'resourceColumns'=>[					
					[
						//'group'=> true,													//not used, customize
						'labelText'=>'Rooms',
						'field'=> 'title',
						'width'=>'150px',
						'align'=>'left',
					],
					[
						'labelText'=> 'Department',
						'field'=> 'dep_id',
						'width'=>'150px',
						'align'=>'center',
					],
					[
						'labelText'=> 'CreateBy',
						'field'=> 'createby',
						'width'=>'100px',
						'align'=>'center',
					]
			],			
		],	
	
	]);
	


	/*modal*/
	Modal::begin([
		'id' => 'modal-rooms',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa fa-user"></div><div><h5 class="modal-title"><b>Create Rooms</b></h5></div>',
		'size' => 'modal-dm',

		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
		],
	]);
		echo "<div id='modalContentRooms'></div>";
	Modal::end();  
	

	/*modal*/
	Modal::begin([
		'id' => 'modal-up',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa fa-user"></div><div><h5 class="modal-title"><b>Pilot Project</b></h5></div>',
		'size' => Modal::SIZE_LARGE,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
		],
	]);	
		echo "<div id='modalContentUp'></div>";
	Modal::end(); 

	/*modal*/
	// Modal::begin([
	//     'id' => 'modal-row',
	//     'header' => '<div style="float:left;margin-right:10px" class="fa fa-plus"></div><div><h5 class="modal-title"><b>Tambah Row</b></h5></div>',
	//     'size' => Modal::SIZE_SMALL,
	//     'headerOptions'=>[
	//         'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
	//     ],
	//   ]);
	// 	echo "<div id='modalContentRow'></div>";
	// 	Modal::end(); 

?>





<?php
//  $this->registerJs("
// 	/* ADDING EVENTS */
//     var currColor = '#3c8dbc'; //Red by default
//     //Color chooser button
//     var colorChooser = $('#color-chooser-btn');
//     $('#color-chooser > li > a').click(function (e) {
//       e.preventDefault();
//       //Save color
//       currColor = $(this).css('color');
//       //Add color effect to button
//       $('#add-new-event').css({'background-color': currColor, 'eventColor': currColor});
//     });

// 	$('#add-new-event').click(function (e) {
//       e.preventDefault();
//       //Get value and make sure it is not null
//       var val = $('#new-event').val();
//       if (val.length == 0) {
//         return;
//       }

//       //Create events
//       var event = $('<div />');
//       event.css({'background-color': currColor, 'eventColor': currColor, 'color': '#fff'}).addClass('external-event');
//       event.html(val);
//       $('#external-events').prepend(event);

//       //Add draggable funtionality
//       ini_events(event);

//       //Remove event from text input
//       $('#new-event').val('');
//     });	
// ",$this::POS_END);


$this->registerJs($this->render('save_external_event.js'),$this::POS_END);


	/*
	* Triger timeout button triger with timeout.
	* @author piter novian [ptr.nov@gmail.com] 
	*/	
	 $this->registerJs("	
		document.addEventListener('DOMContentLoaded', function(event) {
			//$(document).ready(function() {
				$('#tab-project-id').click(function(){
					setTimeout(function(){				
						var idx = $('ul li.active').index();
						//alert(idx);
						if (idx==0){
							//alert(idx);
							var elem = document.getElementById('calendar_test');
							var list = elem.getElementsByTagName('button')[4];
								//list.onmouseover = function() {}
								//list.className='ui-state-hover';
								//list.focus();
								setTimeout(function(){
									list.click();
								},100);
						}
					},100);
				});	
			//});
		})
	",$this::POS_READY); 
 
	
	$this->registerJs("  
		//$('.fc-prev-button, .fc-next-button, .fc-today-button, .fc-timelineOneDays-button').click(function(){
		$(document).on('click', '.fc-prev-button, .fc-next-button, .fc-today-button, .fc-timelineOneDays-button', function(){
			console.log('test button next');		
			/**
			   * Remove Resources and Add Resources fullcalendar
			   * author piter novian [ptr.nov@gmail.com]
			 */						
			setTimeout(function(){
				$.get('http://lukisongroup.com/widget/pilotproject/render-data-resources', function(data, status){
					//var obj = new JSONObject(data);
					coba =  JSON.parse(data);
					for (var key in coba) {
						$('#calendar_test').fullCalendar('removeResources',coba[key].id);
						console.log(coba[key].id);
					};
					//alert(coba[1].id);
					//alert(coba.count);
				}); 					
				var tglCurrent = $('#calendar_test').fullCalendar('getDate');
				var	tgl=moment(tglCurrent).format('YYYY-MM-DD');
				$.get('http://lukisongroup.com/widget/pilotproject/update-data-resources?start='+tgl, function(datarcvd, status){
					rcvd =  JSON.parse(datarcvd);
					for (var key in rcvd) {
						$('#calendar_test').fullCalendar('addResource',
							rcvd[key]
						, scroll );
						console.log(rcvd[1]);
					};						
				});									
					$('#calendar_test').fullCalendar('refetchEvents');
					$('#calendar_test').fullCalendar('refetchResources');
			},500);					
		});
	",$this::POS_READY);
	
	$this->registerJs(" 
	var calendar = $('#calendar_test').fullCalendar('getCalendar');

		calendar.on('dayChange', function() {
			alert('haha');
		});
		
		
		/* $('#calendar_test').fullCalendar({
			  loading: function(isLoading, view ) {
				if(isLoading) {// isLoading gives boolean value
					console.log('test load');
				} else {
					console.log('test compalte');
				}
			}
		
		}); */
	
		// $(document).hasClass('change',$('.fc-timelineOneDays-button').hasClass('ui-state-active')	, function(){
			// alert('tet');
			//if($('.fc-timelineOneDays-button').hasClass('ui-state-active')){
				
				  // var elem1 = document.getElementById('calendar_test');
				// var list1 = elem1.getElementsByClassName('fc-timelineOneDays-button');
				// console.log(list1[0].innerText);
				// list1[0].click();
				// $('.fc-timelineOneDays-button').toggleClass('ui-state-active'); 
			//};
		// })
			
			
	",$this::POS_READY);
?>
<div  class="row" style="margin-top:0px,font-family: verdana, arial, sans-serif ;font-size: 8pt"> 	
	<div  class="col-xs-12 col-sm-12 col-dm-9 col-lg-9">
		<div id="tes1" class="row">
			<?php echo $wgCalendar;?>
		</div>
	</div>
	<div  class="col-xs-12 col-sm-12 col-dm-3 col-lg-3">
		<div class="row">
			<section class="content">
				<div class="box box-solid">
				<div class="box-body">
						<h5>Draggable Events</h5>
						<div id='external-events'>
						<!-- <div class='external-event bg-green '>My Event 1</div>
						<div class='external-event bg-yellow'>My Event 2</div>
						<div class='external-event bg-aqua'>My Event 3</div>
						<div class='external-event bg-light-blue'>My Event 4</div>
						<div class='external-event bg-red'>My Event 5</div>
						<div class='external-event bg-aqua'>My Event 3</div>
						<div class='external-event bg-light-blue'>My Event 4</div>
						<div class='external-event bg-red'>My Event 5</div> -->
						
						<!-- <p>
							<input type='checkbox' id='drop-remove' />
							<label for='drop-remove'>remove after drop</label>
						</p> -->
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
</div>

	

