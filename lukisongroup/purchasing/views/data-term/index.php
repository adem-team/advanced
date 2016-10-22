<?php
/* extensions */
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


$this->sideCorp = 'ESM-Trading Terms';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_trading_term';               /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Trading Terms ');

/*
 * Tombol Create
 * permission create term
*/
function tombolCreate(){
			$title1 = Yii::t('app', 'NEW TERM');
			$options1 = [ 'id'=>'term-create',
							'data-toggle'=>"modal",
							'data-target'=>"#new-term",
							'class' => 'btn btn-success btn-sm',
			];
			$icon1 = '<span class="fa fa-plus fa-lg"></span>';
			$url = Url::toRoute(['/purchasing/data-term/create-term-data']);
			$label1 = $icon1 . ' ' . $title1;
			$content = Html::a($label1,$url,$options1);
			return $content;
		 }

	/*
	 * Declaration Componen User Permission
	 * Function getPermission
	 * Modul Name[6=TERM_DATA]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses('6')){
			return Yii::$app->getUserOpt->Modul_akses('6');
		}else{
			return false;
		}
	}

	/*
	 * Tombol Modul View
	 * permission View [BTN_VIEW==1]
	 * Check By User login
	*/
	function tombolView($url, $model){
		if(getPermission()){
			if(getPermission()->BTN_VIEW==1){
				$title = Yii::t('app', 'View');
				$options = [ 'id'=>'term-date-view'];
				$icon = '<span class="fa fa-search-plus"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/purchasing/data-term/view','id'=>$model->TERM_ID]);
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
			}
		}
	}

	/*
	 * Tombol Modul Review
	 * permission View [BTN_VIEW==1]
	 * Check By User login
	*/
	function tombolReview($url, $model){
		if(getPermission()){
			// if(getPermission()->BTN_REVIEW==1){
				$title = Yii::t('app', 'Review');
				$options = [ 'id'=>'term-date-review'];
				$icon = '<span class="glyphicon glyphicon-zoom-in"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/purchasing/data-term/review','id'=>$model->TERM_ID,'cus_kd'=>$model->CUST_KD_PARENT]);
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
			// }
		}
	}

	/*DISCRIPTION STATUS TERM*/
	function statusTerm($model){
		if($model->STATUS == 0){
			return Html::a('<i class="glyphicon glyphicon-retweet"></i> New', '#',['class'=>'btn btn-warning btn-xs', 'style'=>['width'=>'100px'],'title'=>'Detail']);
		}elseif ($model->STATUS==1){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> Running', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==2){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> Closed', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}
    else{
			return Html::a('<i class="glyphicon glyphicon-question-sign"></i> Unknown', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		};
	}


	/*
	 * GRID VIEW PLAN TREM
	 * @author ptrnov  [piter@lukison.com]
	 * @since 1.2
	*/
	$attDinamik =[];
	/*GRIDVIEW ARRAY FIELD HEAD*/
	$headColomnEvent=[
		['ID' =>0, 'ATTR' =>['FIELD'=>'NmCustomer','SIZE' => '50px','label'=>'CUSTOMER PARENT','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'PERIOD_START','SIZE' => '10px','label'=>'tanggal term di buat ','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'PERIOD_END','SIZE' => '10px','label'=>'tanggal term  berakhir','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>3, 'ATTR' =>['FIELD'=>'Nmprincipel','SIZE' => '10px','label'=>'PRINCIPAL','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>4, 'ATTR' =>['FIELD'=>'NmDis','SIZE' => '10px','label'=>'DISTRIBUTOR','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		//['ID' =>4, 'ATTR' =>['FIELD'=>'STATUS','SIZE' => '10px','label'=>'STATUS','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
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
	/*STATUS TERM*/
	$attDinamik[] =[
		'label'=>'STATUS',
		'mergeHeader'=>true,
		'format' => 'raw',
		'hAlign'=>'center',
		'value' => function ($model) {
						return statusTerm($model);
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'80px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(249, 215, 100, 1)',
			]
		],
	];
	/*GRIDVIEW ARRAY ACTION*/
	$actionClass='btn btn-info btn-xs';
	$actionLabel='Action';
	$attDinamik[]=[
		'class'=>'kartik\grid\ActionColumn',
		'dropdown' => true,
		'template' => '{view}{review}',
		'dropdownOptions'=>['class'=>'pull-right dropup','style'=>['disable'=>true]],
		'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
		'dropdownButton'=>[
			'class' => $actionClass,
			'label'=>$actionLabel,
			'caret'=>'<span class="caret"></span>',
		],
		 'buttons' => [
				/* View PO | Permissian All */
  				'view' => function ($url, $model) {
  								return tombolView($url, $model);
  						  },
				'review' => function ($url, $model) {
  								return tombolReview($url, $model);
  						  }
			/* 'view1' =>function($url, $model, $key){
					return  '<li>' .Html::a('<span class="fa fa-search-plus fa-dm"></span>'.Yii::t('app', 'Review'),
												['/purchasing/data-term/review','id'=>$model->TERM_ID],[
												'id'=>'img1-id',
												'data-toggle'=>"modal",
												//'data-target'=>"#img1-visit",
												]). '</li>' . PHP_EOL ;
			}*/
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
	];
	/*GRID VIEW BASE*/
	$gvPlanTerm= GridView::widget([
		'id'=>'plan-term',
		'dataProvider' => $dataProvider,
		//'filterModel' => $searchModel,
		//'filterRowOptions'=>['style'=>'background-color:rgba(74, 206, 231, 1); align:center'],
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
				'id'=>'plan-term',
			],
		],
		'panel' => [
					'heading'=>'<h3 class="panel-title" style="font-family: verdana, arial, sans-serif ;font-size: 9pt;">TERM DATA</h3>',
					'type'=>'info',
					//'showFooter'=>false,
		],
		'toolbar'=> [
		 ['content'=>tombolCreate()],
	 ],
		// 'hover'=>true, //cursor select
		 'responsive'=>true,
		// 'responsiveWrap'=>true,
		// 'bordered'=>true,
		// 'striped'=>true,
	]);
?>
<div class="content" >
	<!-- HEADER !-->
	<div  class="row" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;padding-bottom:20px;">
		<!-- HEADER !-->
		<div class="col-md-12">
			<?php
				echo $gvPlanTerm;
			?>
		</div>
	</div>
</div><!-- Body !-->

<?php
/*
 * JS  CREATED
 * @author wawan
 * @since 1.2
*/
$this->registerJs("
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
		$('#new-term').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var modal = $(this)
			var title = button.data('title')
			var href = button.attr('href')
			modal.find('.modal-title').html(title)
			modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
			$.post(href)
				.done(function( data ) {
					modal.find('.modal-body').html(data)
				});
			}),
",$this::POS_READY);

Modal::begin([
		'id' => 'new-term',
		'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>New Term</b></h4></div>',
		// 'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
		]
	]);
Modal::end();
