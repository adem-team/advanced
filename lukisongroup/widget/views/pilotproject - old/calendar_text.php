<?php

// use yii\helpers\Html;
use kartik\helpers\Html;
//use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use kartik\widgets\Spinner;



$JSCode = <<<EOF

// author wawan
function(start, end) {
	var dateTime2 = new Date(end);
	var dateTime1 = new Date(start);
	// var tgl1 = moment(dateTime1).format("YYYY-MM-DD HH:mm:ss");
	// var tgl2 = moment(dateTime2).format("YYYY-MM-DD HH:mm:ss");
	var tgl1 = moment(dateTime1).format("YYYY-MM-DD");
	var tgl2 = moment(dateTime2).subtract(1, "days").format("YYYY-MM-DD");


	// var tgl1 = moment(dateTime1).format("DD/MM/yyyy hh:mm");
	// var tgl2 = moment(dateTime2).format("DD/MM/yyyy hh:mm");
	$('#tglakhir').val(tgl2);
	$('#tglawal').val(tgl1);
    // $('#confirm-permission-alert').modal();
		$.get('/widget/pilotproject/createparent',{'tgl1':tgl1,'tgl2':tgl2},function(data){
						$('#modal').modal('show')
						.find('#modalContent')
						.html(data);
		});
}
EOF;

$JSDropEvent = <<<EOF
function(event, element, view) {
    var child = event.parent;
    var status = event.status;

    var dateTime2 = new Date(event.end);
	var dateTime1 = new Date(event.start);
	var tgl1 = moment(dateTime1).format("YYYY-MM-DD");
	var tgl2 = moment(dateTime2).subtract(1, "days").format("YYYY-MM-DD");

    var id = event.id;
    if(child != 0 && status != 1){
    	$.get('/widget/pilotproject/drop-child',{'id':id,'tgl1':tgl1,'tgl2':tgl2});
    }

}
EOF;


$JSEventClick = <<<EOF
function(calEvent, jsEvent, view) {


$(this).css('border-color', 'red');

		var datetime = calEvent.start;
		var tgl1 = new Date(datetime);
		var tgl_awal = moment(tgl1).format("YYYY-MM-DD");

		var datetime2 = calEvent.end;
		var tgl2 = new Date(datetime2);
		var tgl_end = moment(tgl2).format("YYYY-MM-DD");

		var id = calEvent.id;
		var sort = calEvent.sort;

		var stt = calEvent.status;

    // $('#confirm-permission-alert').modal();
		if(stt != 1)
		{
		$.get('/widget/pilotproject/update-pilot',{'tgl_awal':tgl_awal,'tgl_end':tgl_end,'id':id,'sort':sort },function(data){
						$('#modal').modal('show')
						.find('#modalContent')
						.html(data);
		});
	}else{
		$('#confirm-permission-alert').modal();
	}

}
EOF;

$Jseventcolor = <<<EOF
function (event, element, view) {
var status1 = event.status;

	if(status1 == 1)
	{
		 element.css('background-color', 'red');
	}else{
		 element.css('background-color', 'blue');
	}
}
 
EOF;


Modal::begin([
	'headerOptions' => ['id' => 'modalHeader'],
	'id' => 'modal',
	// 'size' => 'modal-sm',
	//keeps from closing modal with esc key or by clicking out of the modal.
	// user must click cancel or X to close
	// 'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
Modal::end();

/**
	 * VIEW EMPLOYE PLAN 
	 * @author wawan
	 * @since 1.1.0
	*/
	$calenderPlan=yii2fullcalendar\yii2fullcalendar::widget([
		'id'=>'pilot-test-id',
		'options' => [
			'lang' => 'id',
			
			//'firstDay' => ['default' => '6'],
		//... more options to be defined here!
		],
		// 'events'=> $events,
		
	 'clientOptions' => [
			'resourceLabelText'=> 'Rooms',
			'selectable' => true,
			'selectHelper' => true,
			'droppable' => true,
			'editable' => true,
			'eventDrop' => new JsExpression($JSDropEvent),
			'selectHelper'=>true,
			'select' => new JsExpression($JSCode),
			'eventClick' => new JsExpression($JSEventClick),
			'eventAfterRender'=> new JsExpression($Jseventcolor),
			//'defaultDate' => date('Y-m-d')
		],
		//'ajaxEvents' => Url::toRoute(['/site/jsoncalendar'])
		'ajaxEvents' => Url::to(['/widget/pilotproject/json-calendar']),
	]);

	$vwScdlPlan= Html::panel(
					['heading' => 'Calender', 'body' =>$calenderPlan],
					Html::TYPE_DANGER
				);

?>

<?php

/*
	 * Button Modal Confirm PERMISION DENAID
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	$this->registerJs("
			$('#confirm-permission-alert').on('show.bs.modal', function (event) {
				}),
	",$this::POS_READY);
	Modal::begin([
			'id' => 'confirm-permission-alert',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/warning/denied.png',  ['class' => 'pnjg', 'style'=>'width:40px;height:40px;']).'</div><div style="margin-top:10px;"><h4><b>Permmission Confirm !</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
			]
		]);
		echo "<div>Sorry Pilot Is Close.
				<dl>
					<dt>Contact : itdept@lukison.com</dt>
				</dl>
			</div>";
	Modal::end();


?>
	<div class="row">
	<div class="col-sm-7 col-md-7 col-lg-7">
		<?=$vwScdlPlan?>
	</div>
	<div class="col-sm-5 col-md-5 col-lg-5">
		<!-- viewDetailPlan?> -->
	</div>
</div>