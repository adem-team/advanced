<?php
use kartik\icons\Icon;
use kartik\tabs\TabsX;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\rating\StarRating;
use kartik\builder\Form;
use lukisongroup\models\widget\Pilotproject;
use kartik\helpers\Html;
use lukisongroup\assets\AppAssetChart;  	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
AppAssetChart::register($this);


	/**
	  * Js Ajax request cUrl Json Data
	  *
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	  * getUrl: http://api.lukisongroup.int/chart/pilotps?access-token=azLSTAYr7Y7TLsEAML-LsVq9cAXLyAWa&id_user=1&pilih=0
	  * id_user=1 [user id login]
	  * pilih=0 [0=department;1=user aktif]
	  * @link https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	  * @see https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	 */
	$this->registerJs('FusionCharts.ready(function () {
			var  jsonData1= $.ajax({
			  //url: "http://api.lukisongroup.int/chart/pilotps?access-token=azLSTAYr7Y7TLsEAML-LsVq9cAXLyAWa",
			  url: "http://api.lukisongroup.com/chart/pilotps?access-token=azLSTAYr7Y7TLsEAML-LsVq9cAXLyAWa",
			  type: "GET",
			  dataType:"json",
			  data:"id_user='. Yii::$app->user->identity->id.'&pilih=0", /*[0=Dept,1=user]*/
			  async: false
			  }).responseText;		  
			  var myData1 = jsonData1;
			  
			var chart1 = new FusionCharts({
				type: "gantt",
				renderAt: "chart1-container",
				width: "100%",
				height: "830",
				dataFormat: "json",
				dataSource: myData1
			})
			
			.render();
		});
	',$this::POS_READY);

	/**
	  * Js Ajax request cUrl Json Data
	  *
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	  * getUrl: http://api.lukisongroup.int/chart/pilotps?access-token=azLSTAYr7Y7TLsEAML-LsVq9cAXLyAWa&id_user=1&pilih=1
	  * id_user=1 [user id login]
	  * pilih=1 [0=department;1=user aktif]
	  * @link https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	  * @see https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	 */
	$this->registerJs('FusionCharts.ready(function () {
			var  jsonData2= $.ajax({
			  //url: "http://api.lukisongroup.int/chart/pilotps?access-token=azLSTAYr7Y7TLsEAML-LsVq9cAXLyAWa",
			  url: "http://api.lukisongroup.com/chart/pilotps?access-token=azLSTAYr7Y7TLsEAML-LsVq9cAXLyAWa",
			  type: "GET",
			  dataType:"json",
			  data:"id_user='. Yii::$app->user->identity->id.'&pilih=1", /*[0=Dept,1=user]*/
			  async: false
			  }).responseText;		  
			  var myData2 = jsonData2;
			  
			var chart2 = new FusionCharts({
				type: "gantt",
				renderAt: "chart2-container",
				width: "100%",
				height: "830",
				dataFormat: "json",
				dataSource: myData2
			})
			
			.render();
		});
	',$this::POS_READY);
	
	/**
	  * Js Ajax Render HTML FusionCharts id='chart1-container'
	  *
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	  * @link https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	  * @see https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	 */	
	$dsp1='
		<div class="row">
			<div class="col-sm-12" id="chart1-container">FusionCharts will render here</div>	
		</div>
	';
	
	/**
	  * Js Ajax Render HTML FusionCharts id='chart1-container'
	  *
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	  * @link https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	  * @see https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	 */	
	$dsp2='
		<div class="row">
			<div class="col-sm-12" id="chart2-container">FusionCharts will render here</div>	
		</div>
	';
	
	/**
	  * GridView CRUD Pilot Project Department ActiveRecord Data
	  *
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	  * id_user=1 [user id login]
	  * pilih=1 [0=department;1=user aktif]
	  * @link https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	  * @see https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	 */	
	$gv_pilotDept= GridView::widget([
		'id'=>'gv-pilot-dept',
        'dataProvider' => $dataProviderDept,
        'filterModel' => $searchModel,		
	    'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
				 'label'=>'Header',
				 'attribute'=>'SORT',
				 'vAlign'=>'middle',
				 'value'=>function ($model, $key, $index, $widget) { 
					$Proj_sort = Pilotproject::find()->where(['ID'=>$model->SORT])->one();
					return $Proj_sort->PILOT_NM;
				},
				'filter'=>ArrayHelper::map(Pilotproject::find()->where('ID=SORT')->asArray()->all(), 'ID', 'PILOT_NM'),
				'group'=>true,
			],
			[
				'label'=>'Sechedule',
				'attribute'=>'PILOT_NM',
				'vAlign'=>'middle',
			],
		    [
				'attribute'=>'PLAN_DATE1',
				'filterType'=> GridView::FILTER_DATE,
				'vAlign'=>'middle',
			],
		    [
				'attribute'=>'PLAN_DATE2',
				'filterType'=> GridView::FILTER_DATE,
				'vAlign'=>'middle',
			],
			/*
			[
				'attribute'=>'BOBOT',
				'format' => 'Html',
				'value'=>function ($model, $key, $index, $widget) {
							return StarRating::widget([ 'name' => 'rating_1',]);
						},
						
				
			],
			*/
		    [
				'attribute'=>'ACTUAL_DATE1',
				'filterType'=> GridView::FILTER_DATE,
				'vAlign'=>'middle',
			],
		    [
				'attribute'=>'ACTUAL_DATE2',
				'filterType'=> GridView::FILTER_DATE,
				'vAlign'=>'middle',
			],
		    [
				'label'=>'Discription',
				'attribute'=>'DSCRP',
				'mergeHeader'=>true,
				'vAlign'=>'middle',
				'value'=>function ($model, $key, $index, $widget) {
					if ($model->DSCRP <>'') {
						return substr($model->DSCRP , 0, 30) . ' ...'; //Author -ptr.nov- limit disply text 
					} else {
						return '';
					}
				}			
			],
			[
				'label'=>'Status',
				'attribute'=>'STATUS',	
				'format' => 'html', 
				'hAlign'=>'center',
				'vAlign'=>'middle',
				'value'=>function($model){
                           if ($model->STATUS == 0) {
								return Html::a('<i class="fa fa-edit"></i> &nbsp;&nbsp;&nbsp;&nbsp;Open', '',['class'=>'btn btn-success btn-sm', 'title'=>'Open']);
							} else if ($model->STATUS == 1) {
								return Html::a('<i class="fa fa-close"></i> &nbsp;&nbsp;&nbsp;&nbsp;Close', '',['class'=>'btn btn-danger btn-sm', 'title'=>'Closing']);
							} 
                        },
				'filter'=>['0'=>'Open','1'=>'Close'],	 //Author -ptr.nov Manual Filter value			
			],
            [
				'class' => 'yii\grid\ActionColumn', 
					'template' => '{view} {create}',
					'header'=>'Action',
					'buttons' => [
						'view' =>function($url, $model, $key){
								return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',['/widget/pilotproject/view','id'=>$model->ID,'PILOT_ID'=>$model->PILOT_ID],[
															'data-toggle'=>"modal",
															'data-target'=>"#gv-pilotp-view",
															'data-title'=> $model->PILOT_ID,
															]);
						},
						
						'create' =>function($url, $model, $key){
								return  Html::a('<button type="button" class="btn btn-success btn-xs" style="width:50px">Create</button>',['/widget/pilotproject/create'],[
															'data-toggle'=>"modal",
															'data-target'=>"#gv-pilotp-create",
															'data-title'=> $model->PILOT_ID,
															]);
						}
						
					],		
			],
        ],
		/*
		'beforeHeader'=>[
			[
				'columns'=>[
					['content'=>'Header Before 1', 'options'=>['colspan'=>5, 'class'=>'text-center warning']], 
					['content'=>'Header Before 2', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
					['content'=>'Header Before 3', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
				],
				'options'=>['class'=>'skip-export'] // remove this row from export
			]
		],
		*/
		//'floatHeaderOptions'=>50,
		'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'gv-pilot',                
               ],
        ],
		'toolbar'=> [
			['content'=>
				Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', '', 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) .' ' .
				Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], ['data-pjax'=>0, 'class'=>'btn btn-default', ''])
			],
			'{export}',
			'{toggleData}',
		],
		'panel'=>['type'=>'info', 'heading'=>'Pilot Project'],
		'hover'=>true, //cursor select
		'responsive'=>true,
		//'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>true,
		'autoXlFormat'=>true,
		'export'=>[//export like view grid --ptr.nov-
			'fontAwesome'=>true,
			'showConfirmAlert'=>false,
			//'target'=>GridView::TARGET_BLANK
		],
    ]); 
	
	/**
	  * GridView CRUD Pilot Project Employe ActiveRecord Data
	  *
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	  * id_user=1 [user id login]
	  * pilih=1 [0=department;1=user aktif]
	  * @link https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	  * @see https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	 */	
	$gv_pilotEmp= GridView::widget([
		'id'=>'gv-pilot-emp',
        'dataProvider' => $dataProviderEmp,
        'filterModel' => $searchModel,		
	    'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
				 'label'=>'Header',
				 'attribute'=>'SORT',
				 'value'=>function ($model, $key, $index, $widget) { 
					$Proj_sort = Pilotproject::find()->where(['ID'=>$model->SORT])->one();
					return $Proj_sort->PILOT_NM;
				},
				'filter'=>ArrayHelper::map(Pilotproject::find()->where('ID=SORT')->asArray()->all(), 'ID', 'PILOT_NM'),
				'group'=>true,
			],
			[
				'label'=>'Sechedule',
				'attribute'=>'PILOT_NM',
			],
		    [
				'attribute'=>'PLAN_DATE1',
				'filterType'=> GridView::FILTER_DATE,
			],
		    [
				'attribute'=>'PLAN_DATE2',
				'filterType'=> GridView::FILTER_DATE,
			],
			/*
			[
				'attribute'=>'BOBOT',
				'format' => 'Html',
				'value'=>function ($model, $key, $index, $widget) {
							return StarRating::widget([ 'name' => 'rating_1',]);
						},
						
				
			],
			*/
		    [
				'attribute'=>'ACTUAL_DATE1',
				'filterType'=> GridView::FILTER_DATE,
			],
		    [
				'attribute'=>'ACTUAL_DATE2',
				'filterType'=> GridView::FILTER_DATE,
			],
		    [
				'label'=>'Discription',
				'attribute'=>'DSCRP',
				'mergeHeader'=>true,
				'value'=>function ($model, $key, $index, $widget) {
					if ($model->DSCRP <>'') {
						return substr($model->DSCRP , 0, 30) . ' ...'; //Author -ptr.nov- limit disply text 
					} else {
						return '';
					}
				}			
			],
			[
				'label'=>'Status',
				'attribute'=>'STATUS',	
				'format' => 'html', 
				'hAlign'=>'center',
				'value'=>function($model){
                           if ($model->STATUS == 0) {
								return Html::a('<i class="fa fa-edit"></i> &nbsp;&nbsp;&nbsp;&nbsp;Open', '',['class'=>'btn btn-success btn-sm', 'title'=>'Open']);
							} else if ($model->STATUS == 1) {
								return Html::a('<i class="fa fa-close"></i> &nbsp;&nbsp;&nbsp;&nbsp;Close', '',['class'=>'btn btn-danger btn-sm', 'title'=>'Closing']);
							} 
                        },
				'filter'=>['0'=>'Open','1'=>'Close'],	 //Author -ptr.nov Manual Filter value			
			],
            [
				'class' => 'yii\grid\ActionColumn',
				'header'=>'Action',			
			],
        ],
		/*
		'beforeHeader'=>[
			[
				'columns'=>[
					['content'=>'Header Before 1', 'options'=>['colspan'=>5, 'class'=>'text-center warning']], 
					['content'=>'Header Before 2', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
					['content'=>'Header Before 3', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
				],
				'options'=>['class'=>'skip-export'] // remove this row from export
			]
		],
		*/
		//'floatHeaderOptions'=>50,
		'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'gv-pilot',                
               ],
        ],
		'toolbar'=> [
			['content'=>
				Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', '', 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) .' ' .
				Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], ['data-pjax'=>0, 'class'=>'btn btn-default', ''])
			],
			'{export}',
			'{toggleData}',
		],
		'panel'=>['type'=>'info', 'heading'=>'Pilot Project'],
		'hover'=>true, //cursor select
		'responsive'=>true,
		//'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>true,
		'autoXlFormat'=>true,
		'export'=>[//export like view grid --ptr.nov-
			'fontAwesome'=>true,
			'showConfirmAlert'=>false,
			//'target'=>GridView::TARGET_BLANK
		],
    ]); 
	
	
	/**
	  * Tab Items Display 
	  *
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	  * @link https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	  * @see https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	 */	
	$items=[
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Department Pilot Schedule','content'=>$dsp1,
			//'active'=>true,

		],	
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Pilot Data Department','content'=>$gv_pilotDept,
		],
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Employe Pilot Schedule','content'=>$dsp2,
			//'active'=>true,

		],			
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Pilot Data Employee','content'=>$gv_pilotEmp,
		],		
	];

	/**
	  * TAB Widget 
	  *
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	  * @link https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	  * @see https://github.com/C12D/advanced/blob/master/lukisongroup/view/widget/pilotp/index.php
	 */	
	echo TabsX::widget([
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		//'height'=>'tab-height-xs',
		'bordered'=>true,
		'encodeLabels'=>false,
		//'align'=>TabsX::ALIGN_LEFT,
	]);	
	
	 $this->registerJs("
		    $('#gv-pilotp-view').on('show.bs.modal', function (event) {
		        var button = $(event.relatedTarget)
		        var modal = $(this)
		        var title = button.data('title') 
		        var href = button.attr('href') 
		        //modal.find('.modal-title').html(title)
		        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
		        $.post(href)
		            .done(function( data ) {
		                modal.find('.modal-body').html(data)
		            });
		        })
		",$this::POS_READY);
		
	Modal::begin([
		    'id' => 'gv-pilotp-view',
		    'header' => '<h4 class="modal-title">LukisonGroup</h4>',
	]);
	Modal::end();
	
	

	$this->registerJs("
		    $('#gv-pilotp-create').on('show.bs.modal', function (event) {
		        var button = $(event.relatedTarget)
		        var modal = $(this)
		        var title = button.data('title') 
		        var href = button.attr('href') 
		        //modal.find('.modal-title').html(title)
		        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
		        $.post(href)
		            .done(function( data ) {
		                modal.find('.modal-body').html(data)
		            });
		        })
		",$this::POS_READY);
		
	Modal::begin([
		    'id' => 'gv-pilotp-create',
		    'header' => '<h4 class="modal-title">LukisonGroup</h4>',
	]);
	Modal::end();
?>

