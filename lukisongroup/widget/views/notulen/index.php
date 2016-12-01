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
use ptrnov\fullcalendar\FullcalendarScheduler;

 

$JSCode = <<<EOF
	function(start, end) {
		// var title = prompt('Event Title:');
		var eventData;
		var dateTime1 = new Date(start);
		var dateTime2 = new Date(end);
		tgl1 = moment(dateTime1).format("YYYY-MM-DD HH:mm:ss");
		tgl2 = moment(dateTime2).format("YYYY-MM-DD HH:mm:ss");
		// if (title) {
			$.fn.modal.Constructor.prototype.enforceFocus = function(){};
			$.get('/widget/notulen/create',{'start':tgl1,'end':tgl2},function(data){
						$('#modal-notulen').modal('show')
						.find('#modalContentNotulen')
						.html(data);
		});
			// $.ajax({
			// 	url:'/sistem/personalia/jsoncalendar_add',
			// 	type: 'POST',
			// 	data:'title=' + title + '&start='+ tgl1 + '&end=' + tgl2,
			// 	dataType:'json',
			// 	success: function(result){
			// //alert('ok')
			// 	  $.pjax.reload({container:'#calendar-user'});
			// 	  //$.pjax.reload({container:'#gv-schedule-id'});
			// 	}
			// });
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
		// }

		//$('#w0').fullCalendar('unselect');
		//$('#w0').fullCalendar('unselect');
	}
EOF;

if(getPermission()->BTN_CREATE){

	$JSCode;

	}else{
		$JSCode = <<<EOF
	function(start, end) {
		$('#confirm-permission-alert').modal('show')
	}
EOF;

	}
	
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
		alert('Event: ' + calEvent.id);
	   // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
		//alert('View: ' + view.name);
		// change the border color just for fun
		$(this).css('border-color', 'red');
	}
EOF;

	/*
	 * VIEW SCHEDULE PLAN 
	 * @author ptrnov  [ptr.nov@gmail.com]
	 * @since 1.2
	*/
	$fcNutulen=FullcalendarScheduler::widget([		
		'header'        => [
			'left'   => 'plus,today, prev,next',
			'center' => 'title',
			'right'  => 'month,listWeek',//'month,timelineOneDays,listWeek ',
		],
		'options'=>[
			'id'=> 'alendar-notulen',															//set it, if used FullcalendarScheduler more the one on page.
			'language'=>'id',
		],		
		'optionsEventUrl'=>[
			'events' => Url::to(['/widget/notulen/json-calendar-event']),						//should be set data event "your Controller link" 	
			'resources'=>[],						//should be set "your Controller link" 								//harus kosong, depedensi dengan button prev/next get resources
			'changeDropUrl'=>[],					//should be set "your Controller link" to get(start,end) from select. You can use model for scenario.
			'dragableReceiveUrl'=>[],				//dragable, new data, star date, end date, id form increment db
			'dragableDropUrl'=>[],					//dragable, new data, star date, end date, id form increment db
		],		
		'clientOptions' => [			
			'firstDay' =>'0',
			'theme'=> true,
			'timezone'=> 'local',															//local timezone, wajib di gunakan.
			'selectHelper' => true,			
			'editable' => true,
			'selectable' => true,
			'select' => new JsExpression($JSCode),										// don't set if used "modalSelect"
			'eventClick' => new JsExpression($JSCode),
			'droppable' => true,
			'firstDay' =>'0',
			'defaultView'=> 'month',
			// 'views'=> [
				// 'timelineOneDays' => [
					// 'type'     => 'timeline',
					// 'duration' => [
						// 'days' => 1,
					// ],
				// ], 			
			// ],			
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
	
	/*
	 * MEMO CALENDAR 
	 * PERIODE 23-22
	 * @author ptrnov  [ptr.nov@gmail.com]
	 * @since 1.2
	*/
	/* $calenderNutulen=yii2fullcalendar\yii2fullcalendar::widget([
		'id'=>'calendar-notulen',
		'options' => [
			'lang' => 'id',
			//'firstDay' => ['default' => '6'],
		//... more options to be defined here!
		],
		// 'events'=> $events,
		// 'ajaxEvents' => Url::to(['/sistem/personalia/jsoncalendar']),
		'clientOptions' => [
			'selectable' => true,
			'selectHelper' => true,
			'droppable' => true,
			'editable' => true,
			'firstDay' =>'0',
			//'drop' => new JsExpression($JSDropEvent),
			'selectHelper'=>true,
			'select' => new JsExpression($JSCode),
			// 'eventClick' => new JsExpression($JSEventClick),
			'eventClick' => new JsExpression($JSCode),
			//'defaultDate' => date('Y-m-d')
		],
		//'ajaxEvents' => Url::toRoute(['/site/jsoncalendar'])
	]); */

	$panelNutulen=Html::panel(
		['heading' => 'NOTULEN CLENDER ', 'body' =>$fcNutulen],
		Html::TYPE_PRIMARY
	);


/*
	 * Declaration Componen User Permission
	 * Function getPermission
	 * Modul Name[9=notulen]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses('9')){
			return Yii::$app->getUserOpt->Modul_akses('9');
		}else{
			return false;
		}
	}

	/*
	 * Tombol Modul View
	 * permission View [BTN_VIEW==1]
	*/
	function tombolView($url, $model){
		if(getPermission()){
			if(getPermission()->BTN_VIEW){
				$title = Yii::t('app', 'View');
				$options = [ 'id'=>'notulen-view'];
				$icon = '<span class="glyphicon glyphicon-zoom-in"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/widget/notulen/view','id'=>$model->id]);
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
			}
		}
	}


/*
	 * Tombol Modul Review
	 * permission Review [BTN_REVIEW==1]
	*/
	function tombolReview($url, $model){
		if(getPermission()){
			if(getPermission()->BTN_REVIEW){
				$title = Yii::t('app', 'Review');
				$options = [ 'id'=>'notulen-review'];
				$icon = '<span class="glyphicon glyphicon-zoom-in"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/widget/notulen/review','id'=>$model->id]);
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
			}
		}
	}

	
	

	/*
	 * LIST MEMO CALENDAR 
	 * PERIODE 23-22
	 * @author ptrnov  [piter@lukison.com]
	 * @since 1.2
	*/
	$actionClass='btn btn-info btn-xs';
	$actionLabel='Update';
	$attDinamikNotulen =[];				
	/*GRIDVIEW ARRAY FIELD HEAD*/
	$headColomnNotulen=[
		['ID' =>0, 'ATTR' =>['FIELD'=>'title','SIZE' => '300px','label'=>'TITLE','align'=>'left','warna'=>'159, 221, 66, 1']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'start','SIZE' => '20px','label'=>'DATE START','align'=>'left','warna'=>'159, 221, 66, 1']],				
		['ID' =>2, 'ATTR' =>['FIELD'=>'end','SIZE' => '20px','label'=>'DATE END','align'=>'left','warna'=>'159, 221, 66, 1']],
		
	];
	$gvHeadColomnNotulen = ArrayHelper::map($headColomnNotulen, 'ID', 'ATTR');
	/*GRIDVIEW NUMBER*/
	$attDinamikNotulen[]=[
		/* Attribute Serial No */
			'class'=>'kartik\grid\SerialColumn',
			'width'=>'5px',
			'header'=>'No.',
			'hAlign'=>'center',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'5px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'5px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
				]
			],
			'pageSummaryOptions' => [
				'style'=>[
					'border-right'=>'0px',
				]
			]
	];
	
	/*GRIDVIEW ARRAY ROWS*/
	foreach($gvHeadColomnNotulen as $key =>$value[]){
		$attDinamikNotulen[]=[		
			'attribute'=>$value[$key]['FIELD'],
			'label'=>$value[$key]['label'],
			'filter'=>true,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			//'mergeHeader'=>true,
			'noWrap'=>true,			
			'headerOptions'=>[		
					'style'=>[									
					'text-align'=>'center',
					'width'=>$value[$key]['SIZE'],
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(97, 211, 96, 0.3)',
					'background-color'=>'rgba('.$value[$key]['warna'].')',
				]
			],  
			'contentOptions'=>[
				'style'=>[
					'width'=>$value[$key]['SIZE'],
					'text-align'=>$value[$key]['align'],
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(13, 127, 3, 0.1)',
				]
			],
			//'pageSummaryFunc'=>GridView::F_SUM,
			//'pageSummary'=>true,
			// 'pageSummaryOptions' => [
				// 'style'=>[
						// 'text-align'=>'right',		
						//'width'=>'12px',
						// 'font-family'=>'tahoma',
						// 'font-size'=>'8pt',	
						// 'text-decoration'=>'underline',
						// 'font-weight'=>'bold',
						// 'border-left-color'=>'transparant',		
						// 'border-left'=>'0px',									
				// ]
			// ],	
		];	
	};
	
	/*GRIDVIEW ARRAY ACTION*/
	$attDinamikNotulen[]=[
		'class'=>'kartik\grid\ActionColumn',
		'dropdown' => true,
		'template' => '{view}{review}',
		'dropdownOptions'=>['class'=>'pull-right dropdown','style'=>['disable'=>true]],
		'dropdownButton'=>[
			'class' => $actionClass,
			'label'=>$actionLabel,
			//'caret'=>'<span class="caret"></span>',
		],
		'buttons' => [
			'view' =>function($url, $model, $key){
					return tombolView($url, $model);
			},
			'review'=>function($url, $model, $key){
					return tombolReview($url, $model);
					}				
		],
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(159, 221, 66, 1)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'height'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		],
	];
	
	/*SET  GRID VIEW LIST EVENT*/
	$gvNutulen= GridView::widget([
		'dataProvider' => $dataProviderNotulen,
		'filterModel' => $searchModelNotulen,
		'filterRowOptions'=>['style'=>'background-color:rgba(255, 221, 66, 1); align:center'],
		'columns' => $attDinamikNotulen,
		'floatOverflowContainer'=>true,
		'floatHeader'=>true,
		/* [
			['class' => 'yii\grid\SerialColumn'],
			'start',
			'end',
			'title',
			['class' => 'yii\grid\ActionColumn'],
		], */
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'absen-rekap',
			],
		],
		'panel' => [
					'heading'=>"<span class='fa fa-edit'><b> LIST NOTULEN</b></span>",
					'type'=>'info',
					'showFooter'=>false,
		],
		'toolbar'=> [
			//'{items}',
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>true,
	]); 

	
?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
    <div  class="row" style="margin-top:15px">       
		<div class="col-sm-8 col-md-8 col-lg-8">
			<?=$gvNutulen?>
		</div>
		 <div class="col-sm-4 col-md-4 col-lg-4" >
			<?=$panelNutulen?>
			<div style="font-family:tahoma,arial, sans-serif;font-size:9pt; color:red;"><b style="font-size:12pt;">*</b><b style="font-size:8pt;"> Klik Tanggal, untuk memulai Notulen baru</b></div>
		</div>
		<div class="col-sm-12 col-md-12 col-lg-12">
			<?php
			
				// print_r($dataProviderNotulen);
			?>
		</div>
	</div>
</div>
<?php
// $this->registerJs("
// $('#calendar-notulen').fullCalendar({
                      
//             firstDay: 6,
// 			editable: true,
//  });
//  ",$this::POS_HEAD);


/*modal*/
Modal::begin([
    'id' => 'modal-notulen',
    'header' => '<div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>NOTULEN</b></h5></div>',
    'size' => Modal::SIZE_SMALL,
    'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
    ],
  ]);
	echo "<div id='modalContentNotulen'></div>";
	Modal::end(); 
 ?>

 <?php
	/*
	 * Button Modal Confirm PERMISION DENAID
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
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
		echo "<div>You do not have permission for this module.
				<dl>
					<dt>Contact : itdept@lukison.com</dt>
				</dl>
			</div>";
	Modal::end();

?>