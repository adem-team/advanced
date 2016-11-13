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


$JSEventClick = <<<EOF
	/**
	* Click Event Add, drag new event.
	* depedence with eventReceive (set url, harus di reload. refetchResources, refetchEvents).
	* Status : Fixed.
	* author wawan, update piter novian [ptr.nov@gmail.com]
	*/	
	function(date,calEvent, jsEvent, event,view) {
		var rsltTgl = moment(date).format('YYYY-MM-DD');
		var weekNilai = (date).format('W');
		//alert(tgl1+ ' ' + week);
		if(weekNilai!=""){
			if(weekNilai % 2==0){
				rslt='Genap';
			}else{
				rslt='Ganjil';
			}
		}else{
			rslt="NotSet";
		}
		//alert(rslt);
		var elem = document.getElementById("id-ganjilgenap"); 
		elem.value = rslt; 
		var elemTgl = document.getElementById("id-tgl"); 
		elemTgl.value = rsltTgl; 
		var elemWeek = document.getElementById("id-week"); 
		elemWeek.value = weekNilai; 
	}
EOF;

	/*
	 * VIEW SCHEDULE PLAN 
	 * @author ptrnov  [ptr.nov@gmail.com]
	 * @since 1.2
	*/
	$wgCalendar=FullcalendarScheduler::widget([		
		'header'        => [
			'left'   => 'plus,today, prev,next, details, group, excel-export',
			'center' => 'title',
			'right'  => 'month',
		],
		'options'=>[
			'id'=> 'modal-view-button',															//set it, if used FullcalendarScheduler more the one on page.
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
			'editable' => true,
			'selectable' => true,
			'select' => new JsExpression($JSEventClick),										// don't set if used "modalSelect"
			'eventClick' => new JsExpression($JSEventClick),
			//'rerenderEvents'=> new JsExpression($JsBeforeRender), 
			//'eventAfterRender'=> new JsExpression($Jseventcolor),
			//'eventAfterAllRender'=> new JsExpression($afterAllRender),
			'droppable' => true,
			'firstDay' =>'0',
			'theme'=> true,
			'aspectRatio'       => 1.8,
			//'scrollTime'        => '00:00', 												// undo default 6am scrollTime, not used, customize
			'defaultView'       => 'month',												// 'timelineDay',//agendaDay',not used, customize
			//'defaultView'       => 'timelineDay',//agendaDay',
		]	
	
	]);
	
?>
<?=$wgCalendar?>
<div>
<dl>
	<dt style="width:80px; float:left;">Date</dt>
	<dd>: <input type="text" id="id-tgl"></dd>
	<dt style="width:80px; float:left;">Week-At</dt>
	<dd>: <input type="text" id="id-week"> </dd>
	<dt style="width:80px; float:left;">Week Of</dt>
	<dd>: <input type="text" id="id-ganjilgenap"> </dd>
	
	
	
</dl>
</div>



