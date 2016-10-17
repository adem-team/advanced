<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use ptrnov\fullcalendar\FullcalendarScheduler;
use lukisongroup\widget\models\Pilotproject;
use yii\helpers\ArrayHelper;



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


$JSSelect = <<<EOF
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
	function(calEvent, jsEvent, view) {
		var dateTime1 = new Date(calEvent.start);
		var dateTime2 = new Date(calEvent.end);
		var tgl1 = moment(dateTime1).format('YYYY-MM-DD LTS');
		var tgl2 = moment(dateTime2).subtract(1, 'days').format('YYYY-MM-DD LTS');
		$.fn.modal.Constructor.prototype.enforceFocus = function(){};
	$.get('/widget/pilotproject/detail-pilot',{'id':calEvent.resourceId},function(data){
						$('#modal-up').modal('show')
						.find('#modalContentUp')
						.html(data);
		});
	}
EOF;
$JsBefore = <<<EOF

	function() {
			//setInterval(function(){
				 $.get('http://lukisongroup.com/widget/pilotproject/render-data-resources', function(data, status){
							//var obj = new JSONObject(data);
					coba =  JSON.parse(data);
					for (var key in coba) {
						$('#calendar_test').fullCalendar('removeResource',coba[key].id);
						console.log(coba[key].id);
					};
					//alert(coba[1].id);
					//alert(coba.count);
				});
			//},50);
		
		
		//$('#calendar_test').fullCalendar('option',{
					/* header:{
						left:'plus,today, prev,next, details, group, excel-export',
						center: 'title',
						right: 'timelineOneDays,agendaWeek,month,listWeek',
					},
					views: {
						timelineOneDays: {
							type: 'timeline',
							duration: {
								days: 1,
							},
						}, 
					
					},
					defaultView:'timelineOneDays', */
					
					//event:'/widget/pilotproject/render-data-events?claster=event',
					//events:'/widget/pilotproject/render-data-events?claster=event',
					//resources:'/widget/pilotproject/render-data-resources?start='+tgl,
					//resources:'/widget/pilotproject/render-data-resources?start=2016-10-12',
					/* resources: function(start, end, timezone, callback) {
							var dateTime1 = new Date(start);
							var dateTime2 = new Date(end);
							var tgl1 = moment(dateTime1).format('YYYY-MM-DD LTS');
							var tgl2 = moment(dateTime2).subtract(1, 'days').format('YYYY-MM-DD LTS');
							$.ajax({
								url: 'http://lukisongroup.com/widget/pilotproject/render-data-resources',
								type: 'POST',								
								data: {
									//claster:'event',
									start: tgl1,
									//end: tgl2
								},
								cache: false,
								error: function(data) {
									alert(data);
								},
							}).done(function(data){
								//on success call `callback` with the data
								callback(data)
							})
						} */
				//});
		// [
			// {id:"135",title:"test1 test1 test1 test1 test1",srcparent:"test1 test1 test1 test1 test1",dep_id:"IT",createby:"none"},
			// {id:"139",title:"test1 test1 test1 test1 test1",srcparent:"test1 test1 test1 test1 test1",dep_id:"IT",createby:"none"}
		// ]	
		
		
		// [
			//your event source
			// {
				// url: '/widget/pilotproject/render-data-resources?start=2016-10-10', // use the `url` property
				// type: 'POST',
				// data: function() { // a function that returns an object
					// return {
						// dynamic_value: Math.random()
					// };
				// },
				// color: 'yellow',    // an option!
				// textColor: 'black'  // an option!
			// }
			//any other sources...
		// ] 
	
			//$('#calendar_test').fullCalendar('option', {
					//resources:'/widget/pilotproject/render-data-resources',								
			//})
		
		/* $('#calendar_test').fullCalendar('option',{
			 resources:{
				url:'/widget/pilotproject/render-data-resources?start=2016-10-10'
			 },
			 eventSources:
			  {
				 url: '/widget/pilotproject/render-data-resources',
				// type: 'POST'
				},
			
		})  */
		
		 // function(resourceObj, labelTds, bodyTds) {
			//labelTds.css('background', 'blue');
		 // }
	}
EOF;

$Jseventcolor = <<<EOF
function (event, element, view) {
var status1 = event.status;
var tgl = event.start;
	//alert(tgl);
	if(status1 == 1)
	{
		 element.html('close');
	};
		
		// $('#calendar_test').fullCalendar({
			// defaultView: 'timelineOneDays',
			// eventResourceEditable: true,
			// resources:'/widget/pilotproject/test-data-events', 
			// editable: true, // event resources editable by default
			// events: '/widget/pilotproject/render-data-events'
		// });
		
		// $('#calendar_test').fullCalendar('getResourceEvents', 'id:11'); 
		// $('#calendar_test').fullCalendar( 'getResources', 
					 // function(callback) {
						// somethingAsynchonous(function(resourceObjects) {
							// callback(resourceObjects);
					// })},  
			
			// scroll );
		//$('#calendar_test').fullCalendar('destroy');
		//$('#calendar_test').fullCalendar('render');
		
		// $('#calendar_test').fullCalendar('removeResource');
		
		// $('#calendar_test').fullCalendar( 'addResource', '/widget/pilotproject/test-data-events', scroll );
		// setInterval(function(){
		//$('#calendar_test').fullCalendar('refetchResources', '/widget/pilotproject/test-data-events');
		// },3000);
		//setTimeout(function(){
			// $('#calendar_test').fullCalendar({
				// resources: '/widget/pilotproject/test-data-events'
			// });
			
				// $('#calendar_test').fullCalendar( 'addResource','/widget/pilotproject/render-data-resources' 
					
					// , 
			
			// scroll ); 
			
		//},100);
	
		
		//setTimeout(function()
}
 
EOF;

$view = <<<EOF
	function(view, element) {
        console.log("The view's title is " + view.intervalStart.format());
        console.log("The view's title is " + view.name);
    }
EOF;

$JSaddButtonRooms = <<<EOF
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
		//alert('test');
		$.get('/widget/pilotproject/tambah-row',function(data){
			/* function(isLoading, view ) {
				//$('#calendar_test').find('.fc-loading').toggle(isLoading);
			}; */
			//$('#calendar').fullCalendar('refetchResources');
			
		 	$('#calendar_test').fullCalendar( 'addResource', 
					function(callback) {
						somethingAsynchonous(function(resourceObjects) {
							callback(resourceObjects);
					})}, 
			
			scroll );
			 
			/* $('#calendar_test').fullCalendar('option', {				
				resource:  function(callback) {
						somethingAsynchonous(function(resourceObjects) {
							callback(resourceObjects);
						});
					}
			
			});  */
			
			
			
			// setTimeout(function(){	
			// $.pjax.reload({container:'#calendar_test'});		
			// //alert(data);
			//},100);
			
			// alert(data);
			//     $('#calendar_test').fullCalendar('removeEventSource');
			 //  $('#calendar_test').fullCalendar( 'addEventSource', data ) 
             // $('#calendar_test').fullCalendar('rerenderEvents' );
			
			// $('#calendar_test').load(location.href + " #calendar_test");
			// $.pjax.reload({container:'#tes1'});
			// $("#tes1").load(#tes1);
			// $('#calendar_test').fullCalendar( 'refetchEvents' );
			// $('div#tes1').load('http://labtest1-erp.int/widget/pilotproject/index div#tes1');
			 // $('#calendar').fullCalendar('refetchEvents');
							// if(data == 'true'){
							//  $('#calendar_test').fullCalendar( 'rerenderEvents' );
							// }
						// $('#modal-row').modal('show')
						// .find('#modalContentRow')
						// .html(data);
		});
	}
EOF;

$JSaddGrp= <<<EOF
	function() {
		var calendarOptions = $('#calendar_test')
			.fullCalendar('getView').options.resourceGroupField;
			
		//alert(calendarOptions);
		$('#calendar_test').fullCalendar('option', {
			//resourceGroupField: 'srcparent',
			//if (){
				resourceGroupField: calendarOptions==''?'srcparent':'',
			//};
			//resourceGroupField:calendarOptions.resourceGroupField,
		}); 
		
		
		 // var calendarOptions = $('#calendar_test')
			 // .fullCalendar('getView')
			 // .options;
	    // calendarOptions.resourceGroupField='srcparent';
		// $('#calendar_test').fullCalendar('render'); 
		
		
	// make your changes to the calendar options
	// I wanted to change the slotDuration
	


	// $("calendar").fullCalendar({
		// eventAfterAllRender: function(){
			// $("#button").click();
		// }
	// });
	 // jQuery('#calendar_test').fullCalendar({
		// resourceGroupField: 'srcparent',
	// }); 
	//
		
		//""
		//var grp = groupValue;
		//alert(groupValue.html);
		//groupValue='resourceGroupField:srcparent';
		//$('#calendar').fullCalendar({
		//	grp='srcparent',
		//});
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
			'left'   => 'plus,today, prev,next, details, group, excel-export',
			'center' => 'title',
			'right'  => 'timelineOneDays,agendaWeek,month,listWeek',
		],
		'options'=>[
			'id'=> 'calendar_test',															//set it, if used FullcalendarScheduler more the one on page.
			'language'=>'id',
		],
		'optionsEventUrl'=>[
			'events' => Url::to(['/widget/pilotproject/render-data-events','claster'=>'event']),				//should be set data event "your Controller link" 	
			'resources'=> Url::to(['/widget/pilotproject/render-data-resources']),		//should be set "your Controller link" 
			'resources'=>[],		//should be set "your Controller link" 
			//'resources'=> Url::to(['/widget/pilotproject/render-data-resources','start'=>'2016-10-12']),		//should be set "your Controller link" 
			// 'resources'=> Url::to(['/widget/pilotproject/render-data-resources','start'=>'{moment($(#calendar_test).fullCalendar(getDate).format(YYYY-MM-DD)}']),		//should be set "your Controller link" 
			//'resources'=> Url::to(['/widget/pilotproject/render-data-resources','tgl'=>'
			//{moment($this.fullCalendar("getDate").format("YYYY-MM-DD");
			//	}
			//']),		//should be set "your Controller link" 
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
						//'click'=>new JsExpression($JSaddButton),
				]	
			],
			 'timezone'=> 'local',
			 // 'viewRender'=> new JsExpression($view),
			//'language'=>'id',
			 // 'locale'=>'id',
			// 'isRTL'=> true,
			//'ignoreTimezone'=> false,
			//'timezone'=>'currentTimezone',
			'selectHelper' => true,			
			'editable' => true,
			'selectable' => true,
			'select' => new JsExpression($JSSelect),										// don't set if used "modalSelect"
			'eventClick' => new JsExpression($JSEventClick),
			'eventBeforeRender'=> new JsExpression($JsBefore),
			'eventAfterRender'=> new JsExpression($Jseventcolor),
			'droppable' => true,
			//'eventDrop' => new JsExpression($JSDropEvent),
			//'now' => \Yii::$app->ambilKonvesi->convert($model->start,'datetime'),//'2016-05-07 06:00:00',
			'firstDay' =>'0',
			'theme'=> true,
			'aspectRatio'       => 1.8,
			//'scrollTime'        => '00:00', // undo default 6am scrollTime
			'defaultView'       => 'timelineOneDays',//'timelineDay',//agendaDay',
			'views'             => [
				'timelineOneDays' => [
					'type'     => 'timeline',
					'duration' => [
						'days' => 1,
					],
				], 
			
			],
			//'eventOverlap'=> true,
			//'resources'=> \yii\helpers\Url::to(['pilotproject/render-data-resources', 'id' => 1]),
			//'eventSources'=>new JsExpression($JsBefore),
			//'events'=> \yii\helpers\Url::to(['pilotproject/render-data-events']),
			//'renderResources'=>new JsExpression($JsBefore),
			//'resources'=>new JsExpression($JsBefore),
			//'eventSources'=>new JsExpression($JsBefore),
			'resourceAreaWidth'=>'30%',
			'resourceLabelText' => 'Discriptions',
			//'resourceEditable'=>true,
			//'resourceGroupField'=> 'srcparent',
			//'resourceGroupField'=> \yii\helpers\Url::to(['pilotproject/group-data-resources']),
			'resourceColumns'=>[					
					[
						//'group'=> true,
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
 
 $urlSrc=Url::to('/widget/pilotproject/test-data-events');
 $this->registerJs("
 
	$('#calendar_test').fullCalendar({
    eventClick: function(calEvent, jsEvent, view) {

        alert('Event: ' + calEvent.title);
        alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
        alert('View: ' + view.name);

        // change the border color just for fun
        $(this).css('border-color', 'red');

    }
});
	$('#calendar_test').click(function(){
		var elem = document.getElementById('calendar_test');
		var list = elem.getElementsByTagName('button');
		//var list = elem.getElementsByClassName('button')[2];
		//console.log(list);
		//if(list[2]){ //is prev button
		if(list[2]){ //is prev button
			//alert('prev');
				
				//alert(tgl);
				
				 $.get('http://lukisongroup.com/widget/pilotproject/render-data-resources', function(data, status){
					//var obj = new JSONObject(data);
					coba =  JSON.parse(data);
					for (var key in coba) {
						$('#calendar_test').fullCalendar('removeResource',coba[key].id);
						console.log(coba[key].id);
					};
					//alert(coba[1].id);
					//alert(coba.count);
				}); 
				
				
				/* function testAjax() {
				  return $.ajax({
					url: 'http://lukisongroup.com/widget/pilotproject/render-data-resources',
					type: 'POST',								
					success: function(data) {
					  return data; 
					}
				  });
				}
				var srcData=testAjax();
				alert(srcData.id); */
				
				
				// srcData.success(function (data) {
					  // alert(data);
					// });
				//srcData.success(data => alert(data));
				
				
				// $('#calend	ar_test').fullCalendar('removeResource')		
				// .fullCalendar( 'addResource', '/widget/pilotproject/render-data-resources?start=2016-10-12', scroll );
				
		var a = $('#calendar_test').fullCalendar('getResources');
				var b = $('#calendar_test').fullCalendar('getResourceEvents');
					
				 //p =  JSON.parse(a);
				// $('#calendar_test').fullCalendar({
					 // eventSources: [
						// '/widget/pilotproject/render-data-events?claster=event',
						// '/widget/pilotproject/render-data-resources?start=2016-10-12',						
					 // ]
				 // });
				//	alert(srcData);
				 //$('#calendar_test').fullCalendar('removeResource',a);
				 // $('#calendar_test').fullCalendar('removeResource','139');
				 // $('#calendar_test').fullCalendar('removeResource','142');
				 // $('#calendar_test').fullCalendar('removeResource','202');
				 // $('#calendar_test').fullCalendar('removeResource','204');
				 //$('#calendar_test').fullCalendar('removeResource','135');
				 
					setTimeout(function(){	
							var tglCurrent = $('#calendar_test').fullCalendar('getDate');
							var	tgl=moment(tglCurrent).format('YYYY-MM-DD');
						/* $('#calendar_test').fullCalendar('addResource',
							{id:'135',title:'test1 test1 test1 test1 test1',srcparent:'test1 test1 test1 test1 test1',dep_id:'IT',createby:'none'}
							//,
							//{id:'139',title:'test1 test1 test1 test1 test1',srcparent:'test1 test1 test1 test1 test1',dep_id:'IT',createby:'none'}
						, scroll ); */
					
						$.get('http://lukisongroup.com/widget/pilotproject/update-data-resources?start='+tgl, function(datarcvd, status){
							rcvd =  JSON.parse(datarcvd);
							for (var key in rcvd) {
								$('#calendar_test').fullCalendar('addResource',
									rcvd[key]
								, scroll );
								console.log(rcvd[1]);
							};						
						});
						
					},50);
					//$('#calendar_test').fullCalendar( 'rerenderEvents' )
					/* 	$.get('http://lukisongroup.com/widget/pilotproject/render-data-events?claster=event&start=2016-10-10&end=2016-10-11', function(dataEvent, status){
								dataEventDay=  JSON.parse(dataEvent);
								$('#calendar_test').fullCalendar('updateEvent', dataEventDay );	
								console.log(dataEventDay[1]);							
							}) */
					
					
					
					
					
				 
				/* $('#calendar_test').fullCalendar('option',{
					//event:'/widget/pilotproject/render-data-events?claster=event',
					//events:'/widget/pilotproject/render-data-events?claster=event',
					//resources:'/widget/pilotproject/render-data-resources?start='+tgl,
					resources: function(start, end, timezone, callback) {
							var dateTime1 = new Date(start);
							var dateTime2 = new Date(end);
							var tgl1 = moment(dateTime1).format('YYYY-MM-DD LTS');
							var tgl2 = moment(dateTime2).subtract(1, 'days').format('YYYY-MM-DD LTS');
							$.ajax({
								url: 'http://lukisongroup.com/widget/pilotproject/render-data-resources',
								type: 'POST',								
								data: {
									//claster:'event',
									start: tgl1,
									//end: tgl2
								},
								cache: false,
								error: function(data) {
									alert(data);
								},
							}).done(function(data){
								//on success call `callback` with the data
								callback(data)
							})
						}
				});   */
				
				//$('#calendar_test').fullCalendar('refetchResources',{
				//	resources: 
				//});
				
			//moment($('#calendar_test').fullCalendar('getDate').format('YYYY-MM-DD');
				
			
		}
	});
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

	

