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

use lukisongroup\hrd\models\Machine;
use lukisongroup\hrd\models\Key_list;
use lukisongroup\hrd\models\Employe;
use lukisongroup\assets\AppAssetFusionChart;
AppAssetFusionChart::register($this);

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
	var dateTime2 = new Date(end);
	var dateTime1 = new Date(start);
	tgl1 = moment(dateTime1).format("YYYY-MM-DD HH:mm:ss");
	tgl2 = moment(dateTime2).format("YYYY-MM-DD HH:mm:ss");
	$('#modalTitle').val(tgl2);
	$('#modalTitle2').val(tgl1);
	$('#modalBody').html(tgl2);
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
	 $('#modalTitle').html(calEvent.start);
	$('#modalBody4').html(calEvent.id);
	$('#modalTitle3').val(tgl1);
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

	/**
     * Setting
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	function tombolSetting(){
		$title1 = Yii::t('app', 'Setting');
		$options1 = [ 'id'=>'setting',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-setting",
					  //'class' => 'btn btn-default',
					  'style' => 'text-align:left',
		];
		$icon1 = '<span class="fa fa-cogs fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/setting']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/**
     * New|Change|Reset| Password Login
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	function tombolPasswordUtama(){
		$title1 = Yii::t('app', 'Password');
		$options1 = [ 'id'=>'password',
					  'data-toggle'=>"modal",
					  'data-target'=>"#profile-password",
					  //'class' => 'btn btn-default',
					 // 'style' => 'text-align:left',
		];
		$icon1 = '<span class="fa fa-shield fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/password-utama-view']);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/**
     * Create Signature
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	function tombolSignature(){
		$title1 = Yii::t('app', 'Signature');
		$options1 = [ 'id'=>'signature',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-signature",
					  //'class' => 'btn btn-default',
		];
		$icon1 = '<span class="fa fa-pencil-square-o fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/signature']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/**
     * Persinalia Employee
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	function tombolPersonalia(){
		$title1 = Yii::t('app', 'My Personalia');
		$options1 = [ 'id'=>'personalia',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-personalia",
					  'class' => 'btn btn-primary',
		];
		$icon1 = '<span class="fa fa-group fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/personalia']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/**
     * Performance Employee
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	function tombolPerformance(){
		$title1 = Yii::t('app', 'My Performance');
		$options1 = [ 'id'=>'performance',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-performance",
					  'class' => 'btn btn-danger',
		];
		$icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/performance']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}
	/**
     * Logoff
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	function tombolLogoff(){
		$title1 = Yii::t('app', 'Logout');
		$options1 = [ 'id'=>'logout',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-logout",
					  //'class' => 'btn btn-default',
		];
		$icon1 = '<span class="fa fa-power-off fa-lg"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/logoff']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}


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
						//'select' =>'confirm-permission-alert',
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
								//'showFooter'=>false,
					],
					'toolbar'=> [
						''//'{items}',
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
				echo Yii::$app->controller->renderPartial('_head_chart',[
							//'model_CustPrn'=>$model_CustPrn,
							//'count_CustPrn'=>$count_CustPrn
				]);
			?>
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
		<div class="col-sm-8 col-md-8 col-lg-8" >
			<div  class="row" style="margin-left:5px">
					<!-- IJIN !-->
					<?php
						echo Yii::$app->controller->renderPartial('_button_ijin',[
								//'model_CustPrn'=>$model_CustPrn,
								//'count_CustPrn'=>$count_CustPrn
						]);
					?>
					<!-- CUTI !-->
					<div class="btn-group pull-left">
						<button type="button" class="btn btn-info">CUTI</button>
						<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						  <ul class="dropdown-menu" role="menu">
							<li><?php echo tombolSetting(); ?></li>
							<li><?php echo tombolPasswordUtama();?></li>
							<li><?php echo tombolSignature(); ?></li>
							<li><?php //echo tombolPersonalia(); ?></li>
							<li><?php //echo tombolPerformance(); ?></li>
							<li class="divider"></li>
								<ul>as</ul>
							<li><?php echo tombolLogoff();?></li>
						  </ul>
					</div>
					<!-- CUTI !-->
					<div class="btn-group pull-left">
						<button type="button" class="btn btn-info">KEHADIRAN</button>
						<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						  <ul class="dropdown-menu" role="menu">
							<li><?php echo tombolSetting(); ?></li>
							<li><?php echo tombolPasswordUtama();?></li>
							<li><?php echo tombolSignature(); ?></li>
							<li><?php //echo tombolPersonalia(); ?></li>
							<li><?php //echo tombolPerformance(); ?></li>
							<li class="divider"></li>
							<li><?php echo tombolLogoff();?></li>
						  </ul>
					</div>
			</div>
		</div>
		<div class="col-sm-8 col-md-8 col-lg-8" style="margin-top:15px" >
				<?php
					echo Yii::$app->controller->renderPartial('_form_cuti',[
								'model'=>$model,
								//'count_CustPrn'=>$count_CustPrn
						]);
				?>

		</div>

</div>
<?php
	/*
	 * Button Modal Confirm PERMISION DENAID
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	$this->registerJs("

			 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
				 $('#ModulEvent').on('beforeSubmit',function(){
					 var form = $(this);
					$.ajax({
							url: '/sistem/personalia/save-event',
							type: 'POST',
							// data:'name='+name,
							data : form.serialize(),
							dataType: 'json',
							success: function(result) {
								if (result == 1){
												 $(document).find('#myModal').modal('hide');

											 }

													}

												});
												return false;
										});
		",$this::POS_READY);
	Modal::begin([
			'id' => 'confirm-permission-alert',
			//'header' =>['id'=>'modelHeader'],
			//'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/warning/denied.png',  ['class' => 'pnjg', 'style'=>'width:40px;height:40px;']).'</div><div style="margin-top:10px;"><h4><b>Permmission Confirm !</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			// 'headerOptions'=>[
				// 'id'=>'modelHeader',
				// 'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
			// ]
		]);
		/* echo  '<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
                <h4 id="modalTitle" class="modal-title"></h4>
            </div>
			 <div id="modalBody" class="modal-body"></div>
			'; */
		$form = ActiveForm::begin([
			'id'=>$modelEvent->formName(),
					// 'options'=>['enctype'=>'multipart/form-data'], // important,
					// 'method' => 'post',
					'action' => ['/sistem/personalia/save-event'],
				]);
				echo $form->field($modelEvent, 'title')->textInput([
					// 'value'=>$_GET['modalTitle'],

						'id'=>'modalTitle'

				]);//->lebel('Title');
				echo $form->field($modelEvent, 'MODUL_ID')->dropDownList($aryModulID,[
					'id'=>'modelevent-modul_id',
					//'prompt'=>$model->cabOne['CAB_NM'],
				])->label('Attendance Parent');

				echo $form->field($modelEvent, 'MODUL_PRN')->widget(DepDrop::classname(),[
					'type'=>DepDrop::TYPE_SELECT2,
					'data' => $droptype,
					'options' => ['id'=>'modelevent-modul_prn'],
					'pluginOptions' => [
						'depends'=>['modelevent-modul_id'],
						'url'=>Url::to(['/sistem/personalia/modul-child']), /*Parent=0 barang Umum*/
						'initialize'=>true,
					],
				])->label('Attendance Child');


				// echo FileInput::widget([
					// 'name'=>'import_file',
					 // 'name' => 'attachment_48[]',
					// 'options'=>[
						// 'multiple'=>true
					// ],
					// 'pluginOptions' => [
						// 'uploadUrl' => Url::to(['/sales/import-data/upload']),
						// 'showPreview' => false,
						// 'showUpload' => false,
						// 'showCaption' => true,
						// 'showRemove' => true,
						// 'uploadExtraData' => [
							// 'album_id' => 20,
							// 'cat_id' => 'Nature'
						// ],
						// 'maxFileCount' => 10
					// ]
				// ]);
			echo '<div style="text-align:right; padding-top:10px">';
			echo Html::submitButton('Upload',['class' => 'btn btn-success']);
			echo '</div>';
		ActiveForm::end();
	Modal::end();
?>
