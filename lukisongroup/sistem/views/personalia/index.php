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
/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\sistem\models\AbsensiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->sideCorp = 'User Profile';                          /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'profile';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Profile');          /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


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
			url:'/master/schedule-header/jsoncalendar_add',
			type: 'POST',
			data:'title=' + title + '&start='+ tgl1 + '&end=' + tgl2,
			dataType:'json',
			success: function(result){
        alert('ok')
			  $.pjax.reload({container:'#gv-schedule-id'});
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
    alert('Event: ' + calEvent.title);
    alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
    alert('View: ' + view.name);
    // change the border color just for fun
    $(this).css('border-color', 'red');
}
EOF;


?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
    <div  class="row" style="margin-top:15px">
        <div class="col-sm-4 col-md-4 col-lg-4" style="margin-top:15px">
			<?php
				$events = array();
				//Testing
				$Event = new \yii2fullcalendar\models\Event();
				$Event->id = 1;
				$Event->title = 'Testing';
				$Event->start = date('Y-m-d\Th:m:s\Z');
				$events[] = $Event;

				$Event = new \yii2fullcalendar\models\Event();
				$Event->id = 2;
				$Event->title = 'pergi ke mana';
				$Event->start = date('Y-m-d\Th:m:s\Z',strtotime('tomorrow 6am'));
				$events[] = $Event;

				$calenderRt=yii2fullcalendar\yii2fullcalendar::widget([
					'id'=>'calendar',
					'options' => [
					'lang' => 'id',
					//... more options to be defined here!
					],
					// 'events'=> $events,
					'ajaxEvents' => Url::to(['/master/schedule-header/jsoncalendar']),
					'clientOptions' => [
						'selectable' => true,
						'selectHelper' => true,
						'droppable' => true,
						'editable' => true,
						//'drop' => new JsExpression($JSDropEvent),
						'selectHelper'=>true,
						'select' => new JsExpression($JSCode),
						//'eventClick' => new JsExpression($JSEventClick),
						//'defaultDate' => date('Y-m-d')
					],
					//'ajaxEvents' => Url::toRoute(['/site/jsoncalendar'])
				]);
				
				echo Html::panel(
					['heading' => 'CLENDER', 'body' =>$calenderRt],
					Html::TYPE_DANGER
				);
			?>
		</div>
		<div class="col-sm-8 col-md-8 col-lg-8" >
			<?php Pjax::begin(); ?>    
			<?= GridView::widget([
					'dataProvider' => $dataProvider,
					'filterModel' => $searchModel,
					'columns' => [
						['class' => 'yii\grid\SerialColumn'],

						'idno',
						'TerminalID',
						'UserID',
						'FunctionKey',
						'Edited',
						// 'UserName',
						// 'FlagAbsence',
						// 'DateTime',
						// 'tgl',
						// 'waktu',

						['class' => 'yii\grid\ActionColumn'],
					],
				]); 
			?>
			<?php Pjax::end(); ?>			
		</div>
	</div>
</div>

