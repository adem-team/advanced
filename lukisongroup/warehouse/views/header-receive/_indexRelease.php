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
 $gvReleaseAttribute=[
		['class' => 'yii\grid\SerialColumn'],

		'ID',
		'TGL',
		'KD_SJ',
		'KD_SO',
		'KD_INVOICE',
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

		['class' => 'yii\grid\ActionColumn'],
	];
	$gvRelease=GridView::widget([
		'id'=>'gv-Release-wh',
		'dataProvider' => $dataProviderRelease,
        'filterModel' => $searchModelRelease,
		'columns'=>$gvReleaseAttribute,					
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-Release-wh',
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
			'heading'=>'GUDANG - RELEASE <i class="fa fa fa-level-up fa-1x"></i>', 
			'type'=>'danger',
			'before'=> Html::a('<i class="fa fa-info-circle"></i> '.Yii::t('app', 'Order List'),'/sales/import-gudang/export_datagudang',
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
<?=$gvRelease?>
