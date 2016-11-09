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

use app\models\hrd\Dept;
use lukisongroup\master\models\Distributor;

	$dropDist = ArrayHelper::map(Distributor::find()->all(), 'KD_DISTRIBUTOR', 'NM_DISTRIBUTOR');
	$aryField= [
		/*MAIN DATA*/
		['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '50px','label'=>'Date','align'=>'center','vAlign'=>'middle','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>false,'filterType'=>false,'mergeHeader'=>false,'filterColspn'=>0]],
		['ID' =>1, 'ATTR' =>['FIELD'=>'NM_BARANG','SIZE' => '250px','label'=>'SKU NM','align'=>'left','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>false,'filterColspn'=>7]],
		['ID' =>2, 'ATTR' =>['FIELD'=>'SO_QTY','SIZE' => '50px','label'=>'QTY.PCS','align'=>'right','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>true,'filterColspn'=>0]],		
		['ID' =>3, 'ATTR' =>['FIELD'=>'UNIT_BARANG','SIZE' => '50px','label'=>'UNIT','align'=>'center','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>true,'filterColspn'=>0]],
		['ID' =>4, 'ATTR' =>['FIELD'=>'kartonqty','SIZE' => '50px','label'=>'QTY.KARTON','align'=>'right','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>true,'filterColspn'=>0]],
		['ID' =>5, 'ATTR' =>['FIELD'=>'beratunit','SIZE' => '50px','label'=>'WEIGHT.GRAM','align'=>'right','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>true,'filterColspn'=>0]],
		['ID' =>6, 'ATTR' =>['FIELD'=>'HARGA_DIS','SIZE' => '50px','label'=>'DIST.PRICE','align'=>'right','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>true,'filterColspn'=>0]],
		['ID' =>7, 'ATTR' =>['FIELD'=>'subtotaldist','SIZE' => '50px','label'=>'SUB.TTL','align'=>'right','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>true,'filterColspn'=>0]],
		['ID' =>8, 'ATTR' =>['FIELD'=>'disNm','SIZE' => '100px','label'=>'DISTRIBUTION','align'=>'left','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>$dropDist,'filterType'=>'GridView::FILTER_SELECT2','mergeHeader'=>false,'filterColspn'=>0]],		
		['ID' =>9, 'ATTR' =>['FIELD'=>'USER_ID','SIZE' => '50px','label'=>'IMPORT.BY','align'=>'left','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>false,'filterColspn'=>0]],
	];
	$valFields = ArrayHelper::map($aryField, 'ID', 'ATTR');
	
	$actionClass='btn btn-info btn-xs';
	$actionLabel='Update';
	$attDinamik =[];
	foreach($valFields as $key =>$value[]){
		$attDinamik[]=[
			'attribute'=>$value[$key]['FIELD'],
			'label'=>$value[$key]['label'],
			'filterType'=>$value[$key]['filterType'],
			'filter'=>$value[$key]['filter'],
			'filterOptions'=>[
				'style'=>'background-color:rgba('.$value[$key]['warnaFilter'].'); align:center',
				'colspan'=>$value[$key]['filterColspn'],
			 ],
			'filterWidgetOptions'=>[
				'pluginOptions'=>[
					'allowClear'=>true,
					'contentOptions'=>[
						'style'=>[
						  'text-align'=>'left',
						  'font-family'=>'tahoma, arial, sans-serif',
						  'font-size'=>'8pt',
						]
					]
				],
			],
			'hAlign'=>'right',
			'vAlign'=>$value[$key]['vAlign'],
			'mergeHeader'=>$value[$key]['mergeHeader'],
			'noWrap'=>true,
			'headerOptions'=>[
					'style'=>[
					'text-align'=>'center',
					'width'=>$value[$key]['SIZE'],
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(97, 211, 96, 0.3)',
					'background-color'=>'rgba('.$value[$key]['warna'].')',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>$value[$key]['align'],
					'width'=>$value[$key]['SIZE'],
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(13, 127, 3, 0.1)',
				]
			],
		];
	};
	
	$gvListImport=GridView::widget([
		'id'=>'gv-data-latest-gudang',
		'dataProvider' => $dataProviderViewImport,
		'filterModel' => $searchModelViewImport,
		'columns'=>$attDinamik,					
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-data-latest-gudang',
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
			'heading'=>'<h3 class="panel-title">Lates Data Import </h3>',
			'type'=>'info',
			'before'=> Html::a('<i class="fa fa-remove"></i> '.
								Yii::t('app', 'Clear',['modelClass' => 'Clear',]),'',[
									'id'=>'clear',
									'data-pjax' => true,
									'data-toggle-clear'=>'1',
									'class' => 'btn btn-danger btn-sm'
								]
						).' '.
						Html::a('<i class="fa fa-database"></i> '.Yii::t('app', 'Send Data',
							['modelClass' => 'Kategori',]),'',[												
									'id'=>'fix',
									'data-pjax' => true,
									'data-toggle-fix'=>'1',
								'class' => 'btn btn-success btn-sm'
							]
						),								
						
			'showFooter'=>false,
		],
	]); 
?>
<?=$gvListImport?>