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

use lukisongroup\efenbi\rasasayang\models\TransaksiType;
use lukisongroup\efenbi\rasasayang\models\Store;

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'efenbi_rasasayang';                                     		/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Marketing Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;  
// $this->registerJs($this->render('modal_item.js'),View::POS_READY);
// echo $this->render('modal_item'); //echo difinition

	$aryStt= [
	  ['STATUS' => 0, 'STT_NM' => 'Disable'],		  
	  ['STATUS' => 1, 'STT_NM' => 'Enable']
	];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');
	$valType = ArrayHelper::map(TransaksiType::find()->all(), 'ID', 'TYPE_NM');
	$valStore = ArrayHelper::map(Store::find()->all(), 'OUTLET_NM', 'OUTLET_NM');
	$bColor='rgba(52, 203, 255, 1)';
	$bColor1='rgba(251, 157, 52, 1)';
	$gvAttributeTrans=[
		//TRANS_TYPE.
		[
			'attribute'=>'TYPE_NM',
			'filterType'=>GridView::FILTER_SELECT2,
			'filterWidgetOptions'=>[
				'pluginOptions' =>Yii::$app->gv->gvPliginSelect2(),
			],
			'filterInputOptions'=>['placeholder'=>'Select'],
			'filter'=>$valType,//Yii::$app->gv->gvStatusArray(),
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','50px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColor1),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','50px',''),
			
		],
		//OUTLET_NM.
		[
			'attribute'=>'OUTLET_NM',
			'filterType'=>GridView::FILTER_SELECT2,
			'filterWidgetOptions'=>[
				'pluginOptions' =>Yii::$app->gv->gvPliginSelect2(),
			],
			'filterInputOptions'=>['placeholder'=>'Select'],
			'filter'=>$valStore,//Yii::$app->gv->gvStatusArray(),
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','150px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','150px',$bColor1),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','150px',''),
			
		],	
		[
			'class'=>'kartik\grid\SerialColumn',
			'contentOptions'=>['class'=>'kartik-sheet-style'],
			'width'=>'10px',
			'header'=>'No.',
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','10px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','10px',''),
		],
		//TRANS_ID.
		[
			'attribute'=>'TRANS_ID',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','30px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','30px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','30px',''),
			
		],	
		//TRANS_DATE
		[
			'attribute'=>'TRANS_DATE',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','120px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','120px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','120px',''),
			
		],			
		//ITEM_NM.
		[
			'attribute'=>'ITEM_NM',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','120px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','100px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','100px',''),
			
		],		
		//ITEM_QTY.
		[
			'attribute'=>'ITEM_QTY',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','30px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','30px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('right','30px',''),
			
		],		
		// 'ITEM_HARGA',
		[
			'attribute'=>'ITEM_HARGA',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','30px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','30px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('right','30px',''),
			
		],		
		// 'ITEM_DISCOUNT',
		[
			'attribute'=>'ITEM_DISCOUNT',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','30px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','30px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('right','30px',''),
			
		],		
		// 'ITEM_DISCOUNT_TIME',
		[
			'attribute'=>'ITEM_DISCOUNT_TIME',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','30px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','30px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('right','30px',''),
			
		],		
		//'STATUS',
		[
			'attribute'=>'STATUS',
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
					  <i class="fa fa-close fa-stack-1x" style="color:#0f39ab"></i>
					</span>','',['title'=>'Running']);
				} else if ($model->STATUS == 1) {
				  return Html::a('<span class="fa-stack fa-xl">
					  <i class="fa fa-circle-thin fa-stack-2x"  style="color:#25ca4f"></i>
					  <i class="fa fa-check fa-stack-1x" style="color:#ee0b0b"></i>
					</span>','',['title'=>'Finish']);
				}
			},
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','50','')			
		],
		//ACTION
		/* [
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
		] */
	];

	$gvTrans=GridView::widget([
		'id'=>'gv-trans',
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns'=>$gvAttributeTrans,				
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-trans',
		    ],						  
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>true,
		'autoXlFormat'=>true,
		'export' => false,
		'panel'=>[''],
		'toolbar' => [
			''
		],
		'panel' => [
			'heading'=>false,
			'heading'=>'BOOKING',  
			'type'=>'info',
			'showFooter'=>false,
		],
		'floatOverflowContainer'=>true,
		'floatHeader'=>true,
	]); 
	
?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="col-xs-12 col-sm-12 col-dm-12 col-lg-12" style="font-family: tahoma ;font-size: 8pt;">
		<div class="row" style="padding-right:5px" style="font-family: tahoma ;font-size: 8pt;">
			<?=$gvTrans?>
		</div>
	</div>
</div>

