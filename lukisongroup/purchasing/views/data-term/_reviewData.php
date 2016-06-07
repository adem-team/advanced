<?php
use kartik\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use yii\db\ActiveRecord;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;

use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Termcustomers;
use lukisongroup\master\models\Distributor;
use lukisongroup\hrd\models\Corp;
use lukisongroup\purchasing\models\data_term\Rtdetail;


//print_r($dataProviderBudget->getModels());

//echo $model[0]->NmDis;


	/*
	 * Tombol List Acount INVESTMENT
	 * No Permission
	*/
	function tombolInvest($id_term){
		$title = Yii::t('app', 'Account Investment');
		$options = ['id'=>'account-invest',
					'data-toggle'=>"modal",
					'data-target'=>"#account-invest-plan",
					'class' => 'btn btn-info btn-sm'
		];
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/data-term/account-investment','id'=>$id_term]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	/*
	 * Tombol List Acount INVESTMENT
	 * No Permission
	*/
	function tombolActual($id_term){
		$title = Yii::t('app', 'Actual Investment');
		$options = ['id'=>'actual-invest',
					'class' => 'btn btn-info btn-sm'
		];
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/data-term/actual-review','id'=>$id_term]);
		$content = Html::a($label,$url, $options);
		return $content;
	}


	/*==PLAN BUDGET|ACTUAL BUDGET==*/
	$attDinamik =[];
	/*GRIDVIEW ARRAY FIELD HEAD*/
	$headColomnEvent=[
		['ID' =>0, 'ATTR' =>['FIELD'=>'Namainvest','SIZE' => '50px','label'=>'Trade Investment','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'PERIODE_START','SIZE' => '10px','label'=>'Periode','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'BUDGET_PLAN','SIZE' => '10px','label'=>'Budget Plan','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>3, 'ATTR' =>['FIELD'=>'STATUS','SIZE' => '10px','label'=>'%','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>4, 'ATTR' =>['FIELD'=>'BUDGET_ACTUAL','SIZE' => '10px','label'=>'Budget Actual','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>5, 'ATTR' =>['FIELD'=>'STATUS','SIZE' => '10px','label'=>'%','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
	];
	$gvHeadColomn = ArrayHelper::map($headColomnEvent, 'ID', 'ATTR');
	/*GRIDVIEW SERIAL ROWS*/
	$attDinamik[] =[
		'class'=>'kartik\grid\SerialColumn',
		//'contentOptions'=>['class'=>'kartik-sheet-style'],
		'width'=>'10px',
		'header'=>'No.',
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(249,215,100,1)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
			]
		],
	];
	/*GRIDVIEW ARRAY ROWS*/
	foreach($gvHeadColomn as $key =>$value[]){
		$attDinamik[]=[
			'attribute'=>$value[$key]['FIELD'],
			'label'=>$value[$key]['label'],
			'filterType'=>$value[$key]['filterType'],
			'filter'=>$value[$key]['filter'],
			'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
			'hAlign'=>'right',
			'vAlign'=>'middle',
			//'mergeHeader'=>true,
			'noWrap'=>true,
			'group'=>$value[$key]['GRP'],
			'format'=>$value[$key]['FORMAT'],
			'headerOptions'=>[
					'style'=>[
					'text-align'=>'center',
					'width'=>$value[$key]['FIELD'],
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(74, 206, 231, 1)',
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
		];
	};
	/*GRIDVIEW EXPAND*/
	$attDinamik[]=[
		'class'=>'kartik\grid\ExpandRowColumn',
		'width'=>'50px',
		'header'=>'Detail',
		'expandOneOnly'=>true,
		'detailRowCssClass'=>GridView::TYPE_DEFAULT,
		'value'=>function ($model, $key, $index, $column) {
			return GridView::ROW_COLLAPSED;
		},
		// 'detail'=>function ($model, $key, $index, $column) use($dataProviderBudget){
		// 	/* RENDER */
		// 	return Yii::$app->controller->renderPartial('_reviewDataExpand',[
		// 		'dataProviderBudget'=>$dataProviderBudget,
		// 	]);
		// },
		'detail'=>function ($model, $key, $index, $column)use($dataProviderBudgetdetail){
			/* RENDER */
			$query = Rtdetail::find()->JoinWith('termdet',true,'left JOIN')
																						 ->where(['t0001detail.TERM_ID'=>$model->TERM_ID])
																						 ->andwhere(['like','t0001detail.KD_RIB','RID'])
																						  ->andwhere(['like','t0001detail.KD_RIB','RI'])
																						 ->andwhere(['t0001detail.INVESTASI_TYPE'=>$model->INVES_ID]);
																						//  ->where(['like','t0001detail.KD_RIB','RI']);
				 $dataProviderBudgetdetail_inves = new ActiveDataProvider([
																'query' => $query,
																]);
			return Yii::$app->controller->renderPartial('_reviewDataExpand',[
				'dataProviderBudgetdetail'=>$dataProviderBudgetdetail,
				'dataProviderBudgetdetail_inves'=>$dataProviderBudgetdetail_inves,
				'dataProviderBudget'=>$dataProviderBudget,
				'id'=>$model->ID
			]);
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(74, 206, 231, 1)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'height'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(231, 183, 108, 0.2)',
			]
		],
	];
	/*GRIDVIEW ARRAY ACTION*/
	/* $actionClass='btn btn-info btn-xs';
	$actionLabel='Action';
	$attDinamik[]=[
		'class'=>'kartik\grid\ActionColumn',
		'dropdown' => true,
		'template' => '{view1}',
		'dropdownOptions'=>['class'=>'pull-right dropup','style'=>['disable'=>true]],
		'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
		'dropdownButton'=>[
			'class' => $actionClass,
			'label'=>$actionLabel,
			'caret'=>'<span class="caret"></span>',
		],
		 'buttons' => [
			'view1' =>function($url, $model, $key){
					return  '<li>' .Html::a('<span class="fa fa-search-plus fa-dm"></span>'.Yii::t('app', 'Review'),
												['/purchasing/plan-term/review','id'=>$model->CUST_KD_PARENT],[
												'id'=>'img1-id',
												'data-toggle'=>"modal",
												//'data-target'=>"#img1-visit",
												]). '</li>' . PHP_EOL;
			}
		],
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(249, 215, 100, 1)',
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
	]; */

	/*GRID VIEW BASE*/
	$gvDetalPlanActual= GridView::widget([
		'id'=>'plan-term-budget',
		'dataProvider' => $dataProviderBudget,
		//'filterModel' => $searchModel,
		//'filterRowOptions'=>['style'=>'background-color:rgba(74, 206, 231, 1); align:center'],
		/* 'beforeHeader'=>[
			[
				'columns'=>[
					['content'=>'ITEMS TRAIDE INVESTMENT', 'options'=>['colspan'=>3,'class'=>'text-center info',]],
					['content'=>'PLAN BUDGET', 'options'=>['colspan'=>2, 'class'=>'text-center info']],
					['content'=>'ACTUAL BUDGET', 'options'=>['colspan'=>2, 'class'=>'text-center info']],
					['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center info']],
					//['content'=>'Action Status ', 'options'=>['colspan'=>1,  'class'=>'text-center info']],
				],
			]
		], */
		'columns' => $attDinamik,
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
				'id'=>'plan-term-budget',
			],
		],
		'panel' => [
					'heading'=>'<h3 class="panel-title" style="font-family: verdana, arial, sans-serif ;font-size: 9pt;">TERM PLAN</h3>',
					'type'=>'info',
					//'showFooter'=>false,
		],
		'summary'=>false,
		'toolbar'=>false,
		'panel'=>false,
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
	]);

?>

<div class="row" style="font-family: tahoma ;font-size: 9pt;padding-top:10px">
	<!-- PARTIES/PIHAK !-->
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="font-family: tahoma ;font-size: 8pt">
		<div>
			<?php //echo pihak($model); ?>
		</div>
		<dl>
			<dt><u><b>PARTIES/PIHAK BERSANGKUTAN :</b></u></dt>

			<dd>1 :	<?= $model->NmCustomer ?></dd>


			<dd>2 :	<?= $model->Nmprincipel ?></dd>


			<dd>3 :	<?= $model->NmDis ?></dd>
		</dl>
	</div>

	<!-- PERIODE/JANGKA WAKTU !-->
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="font-family: tahoma ;font-size: 8pt">
		<div>
			<?php //echo periode($model); ?>
		</div>
		<dl>
			<dt><u><b>PERIODE/JANGKA WAKTU :</b></u></dt>
			<dt style="width:80px; float:left;"> Dari: </dt>
			<dd>:	<?=$model->PERIOD_START ?></dd>

			<dt style="width:80px; float:left;">Sampai:</dt>
			<dd>:	<?=$model->PERIOD_END ?></dd>
		</dl>
	</div>

	<!-- TARGET !-->
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="font-family: tahoma ;font-size: 8pt">
		<div>
			<?php //echo target($model); ?>
		</div>
		<dl>
			<dt style="width:80px;"><u><b>TARGET :</b></u></dt>
			<dd style="width:80px"> Rp.<?=$model->TARGET_VALUE?></dd>
			<dd><?=$model->TARGET_TEXT ?> Rupiah</dd>

		</dl>
	</div>
	<!-- BUDGET !-->
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" style="font-family: tahoma ;font-size: 8pt">
		<div>
			<?php //echo target($model); ?>
		</div>
		<dl>
			<dt style="width:80px;"><u><b>BUDGET :</b></u></dt><dd></dd>
			<dt style="width:120px; float:left;"> Budget Awal</dt>
			<dd>: 1.000.000.000.000 <?=$model->TARGET_VALUE?> </dd>
			<dt style="width:120px; float:left;"> Budget Tambahan</dt>
			<dd>: 1000.<?=$model->TARGET_VALUE?></dd>
			<dt style="width:120px; float:left;" > Budget Sisa</dt>
			<dd>: 1000.<?=$model->TARGET_VALUE?></dd>
		</dl>
	</div>
</div>

<div style="font-family: tahoma ;font-size: 8pt;padding-top:10px;float:none">
	<!-- GRID VIEW DETAIL PLAN AND ACTUAL !-->
	<?php
		//print_r($model[0]->TERM_ID);
	?>
	<div style="margin-bottom:5px;margin-right:5px; float:left"><?=tombolInvest($model['TERM_ID']);?></div>
	<div style="margin-bottom:5px"><?=tombolActual($model->TERM_ID);?></div>
	<?=$gvDetalPlanActual;?>
</div>
<?php
$this->registerJs("
	 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
	 $('#account-invest-plan').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var modal = $(this)
		var title = button.data('title')
		var href = button.attr('href')
		//modal.find('.modal-title').html(title)
		modal.find('.modal-body').html('<i class=\"fa fa-dolar fa-spin\"></i>')
		$.post(href)
			.done(function( data ) {
				modal.find('.modal-body').html(data)
			});
		})
",$this::POS_READY);
	Modal::begin([
			'id' => 'account-invest-plan',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Account</b></h4></div>',
		// 'size' => Modal::SIZE_LARGE,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
		]
	]);
	Modal::end();
