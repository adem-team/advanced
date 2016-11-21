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
use kartik\export\ExportMenu;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
use kartik\widgets\DepDrop;

$JSCode = <<<EOF

function(start, end) {
	var dateTime2 = new Date(end);
	var dateTime1 = new Date(start);
	tgl1 = moment(dateTime1).format("YYYY-MM-DD HH:mm:ss");
	tgl2 = moment(dateTime2).format("YYYY-MM-DD HH:mm:ss");
	$('#modalTitle').val(tgl2);
	// $('#modalTitle').val(tgl2);
	$('#tglawal').val(tgl1);
	// $('#tglawal').html(calEvent.start);
	// $('#modalBody').html(tgl2);
    $('#confirm-permission-alert').modal();
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
	//  $('#modalTitle').html(calEvent.end);
		// 	$('#tglawal').html(calEvent.start);
	// $('#modalBody4').html(calEvent.id);
	// $('#tglawal').val(tgl1);
    $('#confirm-permission-alert').modal();



	//$.fn.modal.Constructor.prototype.enforceFocus = function() {};
	// $('#confirm-permission-alert').on('show.bs.modal', function (event) {
		// var button = $(event.relatedTarget)
		// var modal = $(this)
		// var title = button.data('title')
		// var href = button.attr('href')
		// modal.find('.modal-title').html(title)
		// modal.find('.modal-body').html('')
		// $.post(href)
			// .done(function( data ) {
				// modal.find('.modal-body').html(data)
			// });
		// }),
}
EOF;

/*
 * EVENT CALENDAR ABSENSI
 * PERIODE 23-22
 * @author ptrnov  [piter@lukison.com]
 * @since 1.2
*/
$calenderInput=yii2fullcalendar\yii2fullcalendar::widget([
	'id'=>'calendar-user',
	'options' => [
		'lang' => 'id',
		//... more options to be defined here!
	],
	'ajaxEvents' => Url::to(['/sistem/personalia/jsoncalendar']),
	'clientOptions' => [
		'selectable' => true,
		'selectHelper' => true,
		'droppable' => true,
		'editable' => true,
		//'drop' => new JsExpression($JSDropEvent),
		'selectHelper'=>true,
		//'select' =>'confirm-permission-alert',
		'select' => new JsExpression($JSCode),
		'eventClick' => new JsExpression($JSEventClick),
		//'defaultDate' => date('Y-m-d')
	],
	//'ajaxEvents' => Url::toRoute(['/site/jsoncalendar'])
]);
?>
<?=$calenderInput?>