<?php
use kartik\helpers\Html;
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

	
	
	//print_r(gvContain('header','center','50','rgba(255, 255, 48, 4)'));
	$gvRcvdAttribute=[
		//TGL
		[
			'attribute'=>'TGL',
			'label'=>'Date',
			'filterType'=>GridView::FILTER_DATE,
			'filterWidgetOptions'=>[
				'pluginOptions' =>Yii::$app->gv->gvPliginDate(),
			],
			'filter'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50','rgba(255, 255, 48, 4)'),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','50',''),			
		],
		//TGL
		[
			'attribute'=>'NM_BARANG',
			'label'=>'SKU.NM',
			'filterType'=>GridView::FILTER_SELECT2,
			'filterWidgetOptions'=>[
				'pluginOptions' =>Yii::$app->gv->gvPliginSelect2(),
			],
			'filter'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50','rgba(255, 255, 48, 4)'),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','50',''),
			
		],
		/* ['class' => 'yii\grid\SerialColumn'],

		'ID',
		'TGL',
		'KD_SJ',
		'KD_SO',
		'KD_INVOICE', */
		// 'KD_FP',
		// 'ETD',
		// 'ETA',
		// 'KD_BARANG',
		// 'NM_BARANG',
		// 'QTY_UNIT',
		// 'QTY_PCS',
		// 'HARGA',
		// 'DISCOUNT',
		// 'PAJAK',
		// 'DELIVERY_COST',
		// 'NOTE:ntext',
		// 'CREATE_BY',
		// 'CREATE_AT',
		// 'UPDATE_BY',
		// 'UPDATE_AT',

		//['class' => 'yii\grid\ActionColumn'],
	];
	$gvRcvd=GridView::widget([
		'id'=>'gv-rcvd-wh',
		'dataProvider' => $dataProviderRcvd,
        'filterModel' => $searchModelRcvd,
		'columns'=>$gvRcvdAttribute,					
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-rcvd-wh',
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
			'heading'=>'GUDANG -  RECEIVED <i class="fa fa fa-level-down fa-1x"></i>', 
			'type'=>'info',
			'before'=> Html::a('<i class="fa fa-edit"></i> '.Yii::t('app', 'Input Recive'),'/sales/import-gudang/export_datagudang',
									[
										'id'=>'export-datagudang-id',
										'data-pjax' => true,
										'class' => 'btn btn-info btn-sm'
									]
						),						
			'showFooter'=>false,
		],
		'floatOverflowContainer'=>true,
		'floatHeader'=>true,
	]);  
	
	
	
?>
<?=$gvRcvd?>


