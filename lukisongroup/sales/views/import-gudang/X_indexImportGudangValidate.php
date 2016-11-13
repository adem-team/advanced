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
		['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'Date','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '10px','label'=>'Customer','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'ITEM_NM','SIZE' => '10px','label'=>'SKU NM','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>3, 'ATTR' =>['FIELD'=>'QTY_PCS','SIZE' => '10px','label'=>'QTY.PCS','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>4, 'ATTR' =>['FIELD'=>'DIS_REF_NM','SIZE' => '10px','label'=>'DIS_REF','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		/*REFRENSI ALIAS*/
		['ID' =>5, 'ATTR' =>['FIELD'=>'CUST_KD_ALIAS','SIZE' => '10px','label'=>'CUST_KD','align'=>'left','warna'=>'255, 154, 48, 1']],
		['ID' =>6, 'ATTR' =>['FIELD'=>'CUST_KD','SIZE' => '10px','label'=>'CUST ALIAS','align'=>'left','warna'=>'255, 154, 48, 1']],
		['ID' =>7, 'ATTR' =>['FIELD'=>'ITEM_ID_ALIAS','SIZE' => '10px','label'=>'SKU ID','align'=>'left','warna'=>'255, 255, 48, 4']],
		['ID' =>8, 'ATTR' =>['FIELD'=>'ITEM_ID','SIZE' => '10px','label'=>'SKU.ID.ALIAS','align'=>'left','warna'=>'255, 255, 48, 4']],
		['ID' =>9, 'ATTR' =>['FIELD'=>'DIS_REF','SIZE' => '10px','label'=>'DIS_REF','align'=>'left','warna'=>'215, 255, 48, 1']],
	];
	$valFields = ArrayHelper::map($aryField, 'ID', 'ATTR');
	
	$actionClass='btn btn-info btn-xs';
	$actionLabel='Update';
	$attDinamik =[];
	$attDinamik[]=[
		'class'=>'kartik\grid\ActionColumn',
		'dropdown' => true,
		'template' => '{cust}{prodak}',
		//'template' => '{cust}{prodak}{customer}',
		'dropdownOptions'=>['class'=>'pull-left dropdown','style'=>['disable'=>true]],
		'dropdownButton'=>[
			'class' => $actionClass,
			'label'=>$actionLabel,
			//'caret'=>'<span class="caret"></span>',
		],
		'buttons' => [
			'cust' =>function($url, $model, $key){
					return  '<li>' .Html::a('<span class="fa fa-random fa-dm"></span>'.Yii::t('app', 'Set Alias Customer'),
												['/sales/import-data/alias_cust','id'=>$model['ID']],[
												'id'=>'alias-cust-id',
												'data-toggle'=>"modal",
												'data-target'=>"#alias-cust",
												]). '</li>' . PHP_EOL;
			},
			'prodak' =>function($url, $model, $key){
					return  '<li>' . Html::a('<span class="fa fa-retweet fa-dm"></span>'.Yii::t('app', 'Set Alias Prodak'),
												['/sales/import-data/alias_prodak','id'=>$model['ID']],[
												'id'=>'alias-prodak-id',
												'data-toggle'=>"modal",
												'data-target'=>"#alias-prodak",
												]). '</li>' . PHP_EOL;
			},
			/* 'customer' =>function($url, $model, $key){
					return  '<li>' . Html::a('<span class="fa fa-retweet fa-dm"></span>'.Yii::t('app', 'new Customer'),
												['/sales/import-data/new_customer','id'=>$model['ID']],[
												'data-toggle'=>"modal",
												'data-target'=>"#alias-prodak",
												]). '</li>' . PHP_EOL;
			},	 */
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
			//'pageSummaryFunc'=>GridView::F_SUM,
			//'pageSummary'=>true,
			// 'pageSummaryOptions' => [
				// 'style'=>[
						// 'text-align'=>'right',
						'width'=>'12px',
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
		
	$gvValidateFile=GridView::widget([
		'id'=>'gv-validate-gudang-id',
		'dataProvider' => $gvValidateArrayDataProvider,
		'filterModel' => $searchModelValidate,
		'columns'=>$attDinamik,	
		'rowOptions' => function($model, $key, $index, $grid){
				if ($model->CUST_KD=='NotSet' or $model->ITEM_NM=='NotSet'){
					return ['class' => 'danger'];
				};
		},					
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-validate-gudang-id',
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
			'heading'=>'<h3 class="panel-title">VALIDATION IMPORT DATA</h3>',
			'type'=>'warning',
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
<?=$gvValidateFile?>
