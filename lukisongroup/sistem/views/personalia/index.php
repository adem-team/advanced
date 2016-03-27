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

use lukisongroup\hrd\models\Machine;
use lukisongroup\hrd\models\Key_list;
use lukisongroup\hrd\models\Employe;

$aryMachine = ArrayHelper::map(Machine::find()->all(),'TerminalID','MESIN_NM');
$aryKeylist = ArrayHelper::map(Key_list::find()->all(),'FunctionKey','FunctionKeyNM');
$aryEmploye = ArrayHelper::map(Employe::find()->where("STATUS<>3 AND EMP_STS<>3")->all(), function($model, $defaultValue) {
																								return $model->EMP_NM.'-'.$model->EMP_NM_BLK;
																							},function($model, $defaultValue) {
																								return $model->EMP_NM.'-'.$model->EMP_NM_BLK;
																							}
			);

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
	/*
	* === REKAP =========================
	* Key-FIND : AttDinamik-Clalender
	* @author ptrnov [piter@lukison.com]
	* @since 1.2
	* ===================================
	*/
	$attDinamik =[];
	$hdrLabel1=[];
	//$hdrLabel2=[];
	$getHeaderLabelWrap=[];
	
	/*
	 * Terminal ID | Mashine
	 * Colomn 1
	*/
	$attDinamik[]=[
		'attribute'=>'TerminalID','label'=>'Source Machine',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'filter'=>$aryMachine,
		'filterOptions'=>[
			'style'=>'background-color:rgba(240, 195, 59, 0.4); align:center;',
			'vAlign'=>'middle',
		],
		'value'=>function($model){
			$nmMachine=Machine::find()->where(['TerminalID'=>$model['TerminalID']])->one();
			return $nmMachine!=''?$nmMachine['MESIN_NM']:'Unknown';
		},
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'20px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(240, 195, 59, 0.4)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'20px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				//'background-color'=>'rgba(13, 127, 3, 0.1)',
			]
		],
		//'pageSummaryFunc'=>GridView::F_SUM,
		//'pageSummary'=>true,
		'pageSummaryOptions' => [
			'style'=>[
					'text-align'=>'right',
					'width'=>'20px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'text-decoration'=>'underline',
					'font-weight'=>'bold',
					'border-left-color'=>'transparant',
					'border-left'=>'0px',
			]
		],
		//'footer'=>true,
	];


	$hdrLabel1[] =[
		'content'=>'Employee Data',
		'options'=>[
			'noWrap'=>true,
			'colspan'=>2,
			'class'=>'text-center info',
			'style'=>[
				 'text-align'=>'center',
				 'width'=>'20px',
				 'font-family'=>'tahoma',
				 'font-size'=>'8pt',
				 'background-color'=>'rgba(0, 95, 218, 0.3)',
			 ]
		 ],
	];
	
	/*
	 * Employe name
	 * Colomn 2
	*/
	$attDinamik[]=[
		'attribute'=>'EMP_NM','label'=>'Employee',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'filter'=>$aryEmploye,
		'filterOptions'=>[
			'style'=>'background-color:rgba(240, 195, 59, 0.4); align:center;',
			'vAlign'=>'middle',
		],
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(240, 195, 59, 0.4)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				//'background-color'=>'rgba(13, 127, 3, 0.1)',
			]
		],
		//'pageSummaryFunc'=>GridView::F_SUM,
		//'pageSummary'=>true,
		'pageSummaryOptions' => [
			'style'=>[
					'text-align'=>'right',
					'width'=>'10px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'text-decoration'=>'underline',
					'font-weight'=>'bold',
					'border-left-color'=>'transparant',
					'border-left'=>'0px',
			]
		],
		//'footer'=>true,
	];
	
	
	foreach($dataProviderField as $key =>$value)
	{
		$i=2;
		$kd = explode('.',$key);
		if($key!='EMP_NM' AND $key!='TerminalID' AND $kd[0]!='OTIN' AND $kd[0]!='OTOUT'){
			if ($kd[0]=='IN'){$lbl='IN';} elseif($kd[0]=='OUT'){$lbl='OUT';}else {$lbl='';};
				$attDinamik[]=[
					'attribute'=>$key,
					'label'=>$lbl,
					/* function(){
							return html::encode($lbl);
					}, */
					'hAlign'=>'right',
					'vAlign'=>'middle',
					'value'=>function($model)use($key){
						return $model[$key]!=''?$model[$key]:'x';
					},
					/* 'filter'=>function()use($kd[1]){
						$date = '2011/10/14';
						$day = date('l', strtotime($date));
						echo $day;
					}, */
					//'filter'=>$kd[0]=='IN'? date('l', strtotime($kd[1])):'',
					/*'filterOptions'=>[
					 'colspan'=>$kd[0]=='IN'? 2:'0',
						'style'=>'background-color:rgba(97, 211, 96, 0.3); align:center;',
						'vAlign'=>'middle',
					], */
					'mergeHeader'=>true,
					'noWrap'=>true,
					'headerOptions'=>[
						//'colspan'=>$kd[0]=='IN'? true:false,
						//'colspan'=>$kd[0]=='IN'? $i:'0',
						//'headerHtmlOptions'=>array('colspan'=>'2'),
						'style'=>[
							'text-align'=>'center',
							//'width'=>'12px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'8pt',
							'background-color'=>'rgba(97, 211, 96, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'center',
							//'width'=>'12px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'8pt',
							//'background-color'=>'rgba(13, 127, 3, 0.1)',
						]
					],
					//'pageSummaryFunc'=>GridView::F_SUM,
					//'pageSummary'=>true,
					'pageSummaryOptions' => [
						'style'=>[
								'text-align'=>'right',
								//'width'=>'12px',
								'font-family'=>'tahoma',
								'font-size'=>'8pt',
								'text-decoration'=>'underline',
								'font-weight'=>'bold',
								'border-left-color'=>'transparant',
								'border-left'=>'0px',
						]
					],

				];

				if($kd[0]=='IN'){
					$hdrLabel1[] =[
						'content'=>$kd[1],
						'options'=>[
							'noWrap'=>true,
							'colspan'=>2,
							'class'=>'text-center info',
							'style'=>[
								 'text-align'=>'center',
								 //'width'=>'24px',
								 'font-family'=>'tahoma',
								 'font-size'=>'8pt',
								 'background-color'=>'rgba(0, 95, 218, 0.3)',
							 ]
						 ],
					];
				}
		}

		$i=$i+1;
	}

	$hdrLabel1_ALL =[
		'columns'=>array_merge($hdrLabel1),
	];
	$getHeaderLabelWrap =[
		'rows'=>$hdrLabel1_ALL
	];
?>

<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
    <div  class="row" style="margin-top:15px">
        <div class="col-sm-4 col-md-4 col-lg-4">
			<?php
				/*
				 * EVENT CALENDAR ABSENSI
				 * PERIODE 23-22
				 * @author ptrnov  [piter@lukison.com]
				 * @since 1.2
				*/
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
					'id'=>'calendar-user',
					'options' => [
					'lang' => 'id',
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
				
				echo Html::panel(
					['heading' => 'CLENDER', 'body' =>$calenderRt],
					Html::TYPE_DANGER
				);				
				
				/*
				 * LIST EVENT CALENDAR 
				 * PERIODE 23-22
				 * @author ptrnov  [piter@lukison.com]
				 * @since 1.2
				*/
				$actionClass='btn btn-info btn-xs';
				$actionLabel='Update';
				$attDinamikEvent =[];				
				/*GRIDVIEW ARRAY FIELD HEAD*/
				$headColomnEvent=[
					['ID' =>0, 'ATTR' =>['FIELD'=>'start','SIZE' => '10px','label'=>'DATE START','align'=>'left','warna'=>'97, 211, 96, 0.3']],				
					['ID' =>1, 'ATTR' =>['FIELD'=>'end','SIZE' => '10px','label'=>'DATE END','align'=>'left','warna'=>'97, 211, 96, 0.3']],
					['ID' =>2, 'ATTR' =>['FIELD'=>'title','SIZE' => '10px','label'=>'TITLE','align'=>'left','warna'=>'97, 211, 96, 0.3']],
				];
				$gvHeadColomnEvent = ArrayHelper::map($headColomnEvent, 'ID', 'ATTR');
				/*GRIDVIEW ARRAY ACTION*/
				$attDinamikEvent[]=[
					'class'=>'kartik\grid\ActionColumn',
					'dropdown' => true,
					'template' => '{view}{review}{delete}',
					'dropdownOptions'=>['class'=>'pull-left dropdown','style'=>['disable'=>true]],
					'dropdownButton'=>[
						'class' => $actionClass,
						'label'=>$actionLabel,
						//'caret'=>'<span class="caret"></span>',
					],
					'buttons' => [
						'view' =>function($url, $model, $key){
								return  '<li>' .Html::a('<span class="fa fa-random fa-dm"></span>'.Yii::t('app', 'Set Alias Customer'),
															['/sistem/personalia/view','id'=>$model->id],[
															'id'=>'alias-cust-id',
															'data-toggle'=>"modal",
															'data-target'=>"#alias-cust",
															]). '</li>' . PHP_EOL;
						},				
						'review' =>function($url, $model, $key){
								return  '<li>' . Html::a('<span class="fa fa-retweet fa-dm"></span>'.Yii::t('app', 'Set Alias Prodak'),
															['/sistem/personalia/view','id'=>$model->id],[
															'id'=>'alias-prodak-id',
															'data-toggle'=>"modal",
															'data-target'=>"#alias-prodak",
															]). '</li>' . PHP_EOL;
						},	
						'delete' =>function($url, $model, $key){
								return  '<li>' . Html::a('<span class="fa fa-retweet fa-dm"></span>'.Yii::t('app', 'new Customer'),
															['/sistem/personalia/view','id'=>$model->id],[
															'data-toggle'=>"modal",
															'data-target'=>"#alias-prodak",
															]). '</li>' . PHP_EOL;
						},				
					],
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'10px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'9pt',
							'background-color'=>'rgba(97, 211, 96, 0.3)',
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
				/*GRIDVIEW ARRAY ROWS*/
				foreach($gvHeadColomnEvent as $key =>$value[]){
					$attDinamikEvent[]=[		
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
				echo GridView::widget([
					'dataProvider' => $dataProviderEvent,
					'filterModel' => $searchModelEvent,
					'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
					'columns' => $attDinamikEvent,
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
								'heading'=>'<h3 class="panel-title">List Event</h3>',
								'type'=>'warning',
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
		</div>
		<div class="col-sm-8 col-md-8 col-lg-8" >
			<?php 
				/*
				 * DAILY LOG PERSONAL ABSENSI 
				 * PERIODE 23-22
				 * @author ptrnov  [piter@lukison.com]
				 * @since 1.2
				*/
				echo GridView::widget([
					'id'=>'daily-personal-rekap',
					'dataProvider' => $dataProvider,
					//'filterModel' => $searchModel,
					'beforeHeader'=>$getHeaderLabelWrap,
					//'showPageSummary' => true,
					'columns' =>$attDinamik,
					//'floatHeader'=>true,
					'pjax'=>true,
					'pjaxSettings'=>[
						'options'=>[
							'enablePushState'=>false,
							'id'=>'absen-rekap',
						],
					],
					'panel' => [
								'heading'=>'<h3 class="panel-title">DAILY ATTENDANCE PERIODE</h3>',
								'type'=>'warning',
								// 'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Customer ',
										// ['modelClass' => 'Kategori',]),'/master/barang/create',[
											// 'data-toggle'=>"modal",
												// 'data-target'=>"#modal-create",
													// 'class' => 'btn btn-success'
																// ]),
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
					//'perfectScrollbar'=>true,
					//'autoXlFormat'=>true,
					//'export' => false,
				]);
			?>
		</div>
	</div>
</div>

