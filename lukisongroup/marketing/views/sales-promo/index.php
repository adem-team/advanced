<?php
use kartik\helpers\Html;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use kartik\widgets\Spinner;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use yii\web\View;

use lukisongroup\marketing\models\SalesPromo;
$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_marketing';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Marketing Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;  




	$aryStt= [
			  ['STATUS' => 0, 'STT_NM' => 'RUNNING'],		  
			  ['STATUS' => 1, 'STT_NM' => 'FINISH'],
			  ['STATUS' => 2, 'STT_NM' => 'PANDING'],
			  ['STATUS' => 3, 'STT_NM' => 'PLANING'],
		];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');
	//INCLUDE MODAL JS AND CONTENT 
	$this->registerJs($this->render('modal_salespromo.js'),View::POS_READY);
	echo $this->render('modal_salespromo'); //echo difinition
	
	//Check Limited Access.
	//print_r(Yii::$app->getUserOpt->Modul_aksesDeny('11'));

	//print_r(gvContain('header','center','50',$bColor));
	$bColor='rgba(255, 255, 48, 4)';
	$gvAttributePromo=[
		[
			'class'=>'kartik\grid\SerialColumn',
			'contentOptions'=>['class'=>'kartik-sheet-style'],
			'width'=>'10px',
			'header'=>'No.',
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','30px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','30px',''),
		],
		//CUSTOMER
		[
			'attribute'=>'CUST_NM',
			'label'=>'Cutomer',
			'filterType'=>GridView::FILTER_SELECT2,
			'filterWidgetOptions'=>[
				'pluginOptions' =>Yii::$app->gv->gvPliginSelect2(),
			],
			'filterInputOptions'=>['placeholder'=>'Select'], // wajib to clear button x
			'filter'=>ArrayHelper::map(SalesPromo::find()->asArray()->all(), 'CUST_NM','CUST_NM'),
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','200px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','200px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','200px',''),
			
		],
		//PROMO NAME
		[
			'attribute'=>'PROMO',
			'label'=>'Promotion',
			'filter'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','200px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','200px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','200px',''),
			
		],
		//PERIODE TGL START
		[
			'attribute'=>'TGL_START',
			//'label'=>'Periode Start',
			'filterType'=>GridView::FILTER_DATE,
			'filterWidgetOptions'=>[
				'pluginOptions' =>Yii::$app->gv->gvPliginDate(),
			],
			'filter'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','50px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','50px',''),			
		],
		//PERIODE TGL END
		[
			'attribute'=>'TGL_END',
			//'label'=>'Periode End',
			'filterType'=>GridView::FILTER_DATE,
			'filterWidgetOptions'=>[
				'pluginOptions' =>Yii::$app->gv->gvPliginDate(),
				'layout'=>'{picker}{remove}{input}'
			],
			'filter'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','50px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','50px',''),			
		],
		//PERIODE TGL FINISH
		[
			'attribute'=>'TGL_FINISH',
			//'label'=>'Finish',
			'filterType'=>GridView::FILTER_DATE,
			'filterWidgetOptions'=>[
				'pluginOptions' =>Yii::$app->gv->gvPliginDate(),
				'layout'=>'{picker}{remove}{input}'
			],
			'filter'=>true,
			'value'=>function($model){
				if ($model->TGL_FINISH!=''){
					return $model->TGL_FINISH;
				}else{
					return '';
				}
			},
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','50px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','50px',''),			
		],
		//'STATUS',
		[
			'attribute'=>'STATUS',
			'label'=>'Status',
			'filterType'=>GridView::FILTER_SELECT2,
			'filterWidgetOptions'=>[
				'pluginOptions' =>Yii::$app->gv->gvPliginSelect2(),
			],
			'filterInputOptions'=>['placeholder'=>'Select'],
			'filter'=>$valStt,//Yii::$app->gv->gvStatusArray(),
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','50px'),
			'hAlign'=>'right',
			'vAlign'=>'top',
			'mergeHeader'=>false,
			'noWrap'=>false,
			'format' => 'raw',	
			'value'=>function($model){
				 if ($model->STATUS == 0) {
				  return Html::a('
					<span class="fa-stack fa-xl">
					  <i class="fa fa-circle-thin fa-stack-2x"  style="color:#25ca4f"></i>
					  <i class="fa fa-check fa-stack-1x" style="color:#0f39ab"></i>
					</span>','',['title'=>'Running']);
				} else if ($model->STATUS == 1) {
				  return Html::a('<span class="fa-stack fa-xl">
					  <i class="fa fa-circle-thin fa-stack-2x"  style="color:#25ca4f"></i>
					  <i class="fa fa-close fa-stack-1x" style="color:#ee0b0b"></i>
					</span>','',['title'=>'Finish']);
				}	else if ($model->STATUS == 2) {
				  return Html::a('<span class="fa-stack fa-xl">
					  <i class="fa fa-circle-thin fa-stack-2x"  style="color:#25ca4f"></i>
					  <i class="fa fa-pause fa-stack-1x" style="color:#ee0b0b"></i>
					</span>','',['title'=>'Panding']);
				}	else if ($model->STATUS == 3) {
				  return Html::a('<span class="fa-stack fa-xl">
					  <i class="fa fa-circle-thin fa-stack-2x"  style="color:#25ca4f"></i>
					  <i class="fa fa-thumb-tack fa-stack-1x" style="color:#0f39ab"></i>
					</span>','',['title'=>'Planing']);
				}
			},
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','50',''),
			
		],
		//OVEDRUE
		[
			'attribute'=>'RunOverdue',
			'label'=>'Overdue',
			'filter'=>false,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>true,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','50px',''),
			
		],//CREATED_BY
		/* [
			'attribute'=>'CREATED_BY',
			'label'=>'Create.By',
			'filter'=>false,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>true,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','80px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','80px',''),
			
		], */
		
		//ACTION
		[
			'class' => 'kartik\grid\ActionColumn',
			'template' => '{view}{edit}{reminder}{deny}',
			'header'=>'Action',
			'dropdown' => true,
			'dropdownOptions'=>[
				'class'=>'pull-right dropdown',
				'style'=>'width:60px;background-color:#E6E6FA'				
			],
			'dropdownButton'=>[
				'label'=>'Action',
				'class'=>'btn btn-default btn-xs',
				'style'=>'width:100%;'		
			],
			'buttons' => [
				'view' =>function ($url, $model){
				  return  tombolView($url, $model);
				},
				'edit' =>function($url, $model,$key){
					if($model->STATUS!=1){ //Jika sudah close tidak bisa di edit.
						return  tombolReview($url, $model);
					}					
				},
				'reminder' =>function($url, $model,$key){
					return  tombolRemainder($url, $model);
				},
				'deny' =>function($url, $model,$key){
					return  tombolDeny($url, $model);
				}

			],
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','10px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','10px',''),
		]
	];
	/* 'columns' => [
		['class' => 'yii\grid\SerialColumn'],

		'ID',
		'CUST_ID',
		'CUST_NM',
		'PROMO:ntext',
		'TGL_START',
		// 'TGL_END',
		// 'OVERDUE',
		// 'MEKANISME:ntext',
		// 'KOMPENSASI:ntext',
		// 'KETERANGAN:ntext',
		// 'STATUS',
		// 'CREATED_BY',
		// 'CREATED_AT',
		// 'UPDATED_BY',
		// 'UPDATED_AT',

		['class' => 'yii\grid\ActionColumn'],
	], */
		
	$gvSalesPromo=GridView::widget([
		'id'=>'gv-sales-promo',
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns'=>$gvAttributePromo,//$attDinamik,					
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-sales-promo',
		    ],						  
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
		'panel'=>[''],
		'toolbar' => [
			''
		],
		'panel' => [
			'heading'=>'
				<span class="fa-stack fa-sm">
				  <i class="fa fa-circle-thin fa-stack-2x" style="color:#25ca4f"></i>
				  <i class="fa fa-calendar fa-stack-1x"></i>
				</span> Promotion Calendar',  
			'type'=>'info',
			'before'=> tombolCreate().' '.tombolRefresh().' '.tombolExportExcel(),
			'showFooter'=>false,
		],
		'floatOverflowContainer'=>true,
		'floatHeader'=>true,
	]); 
	
?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="col-xs-12 col-sm-12 col-lg-12" style="font-family: tahoma ;font-size: 9pt;">
		<div class="row">
			<?=$gvSalesPromo?>
		</div>
	</div>
</div>

