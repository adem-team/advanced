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
				url:'/sistem/personalia/jsoncalendar_add',
				type: 'POST',
				data:'title=' + title + '&start='+ tgl1 + '&end=' + tgl2,
				dataType:'json',
				success: function(result){
			//alert('ok')
				  $.pjax.reload({container:'#calendar-user'});
				  //$.pjax.reload({container:'#gv-schedule-id'});
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
		alert('Event: ' + calEvent.id);
	   // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
		//alert('View: ' + view.name);
		// change the border color just for fun
		$(this).css('border-color', 'red');
	}
EOF;
?>

	<?php 
		/*
		 * MEMO CALENDAR 
		 * PERIODE 23-22
		 * @author ptrnov  [ptr.nov@gmail.com]
		 * @since 1.2
		*/
		$wgMemo=yii2fullcalendar\yii2fullcalendar::widget([
			'id'=>'calendar-memo',
			'options' => [
				'lang' => 'id',
				'height'=>'300px'
			//... more options to be defined here!
			],
			// 'events'=> $events,
			'ajaxEvents' => Url::to(['/sistem/personalia/jsoncalendar']),
			'clientOptions' => [
				'selectable' => true,
				'selectHelper' => true,
				'droppable' => true,
				'editable' => true,
				//'drop' => new JsExpression($JSDropEvent),
				'selectHelper'=>true,
				'select' => new JsExpression($JSCode),
				'eventClick' => new JsExpression($JSEventClick),
				//'defaultDate' => date('Y-m-d')
			],
			//'ajaxEvents' => Url::toRoute(['/site/jsoncalendar'])
		]);
		
		$calenderMemo =Html::panel(
			['heading' => 'CLENDER ', 'body' =>$wgMemo],
			Html::TYPE_DANGER
		);	
	?>
	<?php			
		/*
		 * LIST MEMO CALENDAR 
		 * PERIODE 23-22
		 * @author ptrnov  [piter@lukison.com]
		 * @since 1.2
		*/
		$actionClass='btn btn-info btn-xs';
		$actionLabel='Update';
		$attDinamikMemo =[];				
		/*GRIDVIEW ARRAY FIELD HEAD*/
		$headColomnMemo=[
			['ID' =>0, 'ATTR' =>['FIELD'=>'start','SIZE' => '10px','label'=>'DATE START','align'=>'left','warna'=>'97, 211, 96, 0.3']],				
			['ID' =>1, 'ATTR' =>['FIELD'=>'end','SIZE' => '10px','label'=>'DATE END','align'=>'left','warna'=>'97, 211, 96, 0.3']],
			['ID' =>2, 'ATTR' =>['FIELD'=>'title','SIZE' => '10px','label'=>'TITLE','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		];
		$gvHeadColomnMemo = ArrayHelper::map($headColomnMemo, 'ID', 'ATTR');
		/*GRIDVIEW ARRAY ACTION*/
		
		/*GRIDVIEW ARRAY ROWS*/
		foreach($gvHeadColomnMemo as $key =>$value[]){
			$attDinamikMemo[]=[		
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
						'width'=>$value[$key]['FIELD'],
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						//'background-color'=>'rgba(97, 211, 96, 0.3)',
						'background-color'=>'rgba('.$value[$key]['warna'].')',
					]
				],  
				'contentOptions'=>[
					'style'=>[
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
							'width'=>'12px',
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
		
		/*SHOW GRID VIEW LIST EVENT*/
		$gvMemoList=gridview::widget([
			'dataProvider' => $dataProviderMemo,
			'filterModel' => $searchModelmemo,
			'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
			'columns' => $attDinamikMemo,
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
			/* 'panel' => [
						'heading'=>'<h3 class="panel-title">List Memo</h3>',
						'type'=>'warning',
						'showFooter'=>false,
			],
			'toolbar'=> [
				//'{items}',
			], */
			'summary'=>false,
			'hover'=>true, //cursor select
			'responsive'=>true,
			'responsiveWrap'=>true,
			'bordered'=>true,
			'striped'=>true,
		]); 		
	?>	
	
	<?php
		/*RENDER INFO MEMO*/			
		$infoDetail=$this->render('_info_memo');
	?>		
			
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt">
    <div  class="row" style="margin-top:15px">     
		<div class="col-sm-4 col-md-4 col-lg-4">
			<div class="panel panel-info">
				<div class="box direct-chat direct-chat">
				 <!-- box-header -->
					<div class="box-header with-border" style="background-color:rgba(218, 229, 252, 0.6);">
						<h3 class="box-title" ><?php echo"MEMO LIST";?></h3>
						<div class="box-tools pull-left">
							<!--<span data-toggle="tooltip" title="3 New Messages" class="badge bg-green">3</span>-->
							<button class="btn btn-box-tool" data-toggle="tooltip" title="show/hide" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button class="btn btn-box-tool" data-toggle="tooltip" title="Calendar" data-widget="chat-pane-toggle"><i class="fa fa-calendar"></i></button>
							<!-- <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
						</div>
					</div><!-- /.box-header -->
					<div class="box-body">
						<!-- Conversations are loaded here -->
						<div class="direct-chat-messages" style="height:550px">
							<!-- Message. Default to the left -->
								 <div class="raw">
									<?php
										echo $gvMemoList;
									?>
								</div>
							<!-- Message to the right -->
						</div><!--/.direct-chat-messages-->
						<!-- Contacts are loaded here -->
						<div class="direct-chat-contacts" style="height:550px; color:black;background-color:rgba(90, 130, 162, 0.7)">
							<ul class="contacts-list">
								<li>
									<div class="raw">
									<?=$calenderMemo;
										//echo 'asdasd';
									?>
									</div>
								</li><!-- End Contact Item -->
							</ul><!-- /.contatcts-list -->
						</div><!-- /.direct-chat-pane -->
					</div><!-- /.box-body -->
				</div><!--/.direct-chat -->
			</div>
		</div>
		<div class="col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-info">
				<div class="panel-heading">
					<?php echo 'Memo Detail';?>
				</div>
				<div class="box-body">
				<?=$infoDetail?>	
				</div>				
			</div>
		</div>
	</div>
</div>
