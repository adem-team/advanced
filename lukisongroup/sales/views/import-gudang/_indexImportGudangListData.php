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

	$aryField= [
		/*MAIN DATA*/
		['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'Date','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_KD_ALIAS','SIZE' => '10px','label'=>'CUST.KD','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '10px','label'=>'CUSTOMER','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>3, 'ATTR' =>['FIELD'=>'NM_BARANG','SIZE' => '10px','label'=>'SKU','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>4, 'ATTR' =>['FIELD'=>'SO_QTY','SIZE' => '10px','label'=>'QTY.PCS','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>5, 'ATTR' =>['FIELD'=>'NM_DIS','SIZE' => '10px','label'=>'DISTRIBUTION','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>6, 'ATTR' =>['FIELD'=>'SO_TYPE','SIZE' => '10px','label'=>'TYPE','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>7, 'ATTR' =>['FIELD'=>'USER_ID','SIZE' => '10px','label'=>'IMPORT.BY','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		/*REFRENSI DATA*/
		['ID' =>8, 'ATTR' =>['FIELD'=>'UNIT_BARANG','SIZE' => '10px','label'=>'UNIT','align'=>'left','warna'=>'255, 255, 48, 4']],
		['ID' =>9, 'ATTR' =>['FIELD'=>'UNIT_QTY','SIZE' => '10px','label'=>'UNIT.QTY','align'=>'left','warna'=>'255, 255, 48, 4']],
		['ID' =>10, 'ATTR' =>['FIELD'=>'UNIT_BERAT','SIZE' => '10px','label'=>'WEIGHT','align'=>'left','warna'=>'255, 255, 48, 4']],
		['ID' =>11, 'ATTR' =>['FIELD'=>'HARGA_PABRIK','SIZE' => '10px','label'=>'FACTORY.PRICE','align'=>'right','warna'=>'255, 255, 48, 4']],
		['ID' =>12, 'ATTR' =>['FIELD'=>'HARGA_DIS','SIZE' => '10px','label'=>'DIST.PRICE','align'=>'right','warna'=>'255, 255, 48, 4']],
		['ID' =>13, 'ATTR' =>['FIELD'=>'HARGA_SALES','SIZE' => '10px','label'=>'SALES.PRICE','align'=>'right','warna'=>'255, 255, 48, 4']],
		/*SUPPORT DATA ID*/
		['ID' =>14, 'ATTR' =>['FIELD'=>'CUST_KD','SIZE' => '10px','label'=>'CUST.KD_ALIAS','align'=>'left','warna'=>'255, 255, 48, 4']],
		['ID' =>15, 'ATTR' =>['FIELD'=>'KD_BARANG','SIZE' => '10px','label'=>'SKU.ID.ALIAS','align'=>'left','warna'=>'255, 255, 48, 4']],
		['ID' =>16, 'ATTR' =>['FIELD'=>'KD_DIS','SIZE' => '10px','label'=>'KD_DIS','align'=>'left','warna'=>'215, 255, 48, 1']],
	];
	$valFields = ArrayHelper::map($aryField, 'ID', 'ATTR');
	
	$actionClass='btn btn-info btn-xs';
	$actionLabel='Update';
	$attDinamik =[];
	foreach($valFields as $key =>$value[]){
		$attDinamik[]=[
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
					//'width'=>'12px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(13, 127, 3, 0.1)',
				]
			],
		];
	};
	
	$gvListImport=GridView::widget([
		'id'=>'gv-list-importdata-gudang',
		'dataProvider' => $dataProviderViewImport,
		'filterModel' => $searchModelViewImport,
		'columns'=>$attDinamik,					
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-list-importdata-gudang',
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
			'heading'=>'<h3 class="panel-title">LIST DATA</h3>',
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