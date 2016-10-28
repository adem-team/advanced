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
use ptrnov\fullcalendar\FullcalendarScheduler;

$this->registerCss("
	.fc-center h2 {
		padding-top: 5px !important;
		font-size: 12px;
		text-overflow: ellipsis;
	}
");

$JSEventClickIssue = <<<EOF
	function(date,calEvent, jsEvent, event,view) {
		var rsltTgl = moment(date).format('YYYY-MM-DD');
		//alert(rsltTgl);
		//$.pjax.reload({container:'#gv-dashboard-issue'});
		/* $.get('/master/review-visit/issue-memo', function(data){
					//coba =  JSON.parse(data);
					console.log(data[1]);
				});  */
		$.ajax({
			url: '/master/review-visit/issue-memo',
			type: 'GET',
			data:'tgl='+rsltTgl,
			dataType: 'json',
			success: function(data) {
				//$.pjax.reload({container:'#gv-po-detail'});
				// $.each(data[1], function (i,listData) {
					
					
					// dataprovider[i]=listData;
				// });
				//console.log(data);
				'$datatest='+data;
				$('test').reload;
			}
		});
		// var elemWeek = document.getElementById("id-week"); 
		// elemWeek.value = weekNilai; 
	}
EOF;
	
	/*
	 * VIEW SCHEDULE PLAN 
	 * @author ptrnov  [ptr.nov@gmail.com]
	 * @since 1.2
	*/
	$wgBtnCalendar=FullcalendarScheduler::widget([		
		'header'        => [
			'left'   => 'plus,today, prev,next',
			'center' => 'title',
			'right'  => 'month',
		],
		'options'=>[
			'id'=> 'fc-button-set-date-issue',															//set it, if used FullcalendarScheduler more the one on page.
			'language'=>'id',
		],
		'optionsEventUrl'=>[
			'events' => [],							//should be set data event "your Controller link" 	
			'resources'=>[],						//should be set "your Controller link" 								//harus kosong, depedensi dengan button prev/next get resources
			'changeDropUrl'=>[],					//should be set "your Controller link" to get(start,end) from select. You can use model for scenario.
			'dragableReceiveUrl'=>[],				//dragable, new data, star date, end date, id form increment db
			'dragableDropUrl'=>[],					//dragable, new data, star date, end date, id form increment db
		],		
		'clientOptions' => [
			'theme'=> true,
			'timezone'=> 'local',															//local timezone, wajib di gunakan.
			'selectHelper' => true,			
			'editable' => false,
			'selectable' => true,
			'select' => new JsExpression($JSEventClickIssue),										// don't set if used "modalSelect"
			'eventClick' => new JsExpression($JSEventClickIssue),
			'droppable' => false,
			'firstDay' =>'0',
			'defaultView'=> 'month',												// 'timelineDay',//agendaDay',not used, customize
		]		
	]);

	/*Triger FC SHOE*/
	$this->registerJs("	
			var elem = document.getElementById('fc-button-set-date-issue');
			var list = elem.getElementsByTagName('button')[3];
			setTimeout(function(){
				list.click();
			},50);

	",$this::POS_READY); 
?>
<?=$wgBtnCalendar?>





