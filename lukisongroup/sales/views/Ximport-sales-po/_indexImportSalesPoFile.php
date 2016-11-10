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

/* 	$aryField= [
		['ID' =>0, 'ATTR' =>['FIELD'=>'DATE','SIZE' => '10px','label'=>'DATE','align'=>'center']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_KD','SIZE' => '10px','label'=>'CUST_KD','align'=>'left']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '20px','label'=>'CUST_NM','align'=>'left']],
		['ID' =>3, 'ATTR' =>['FIELD'=>'SKU_ID','SIZE' => '20px','label'=>'SKU_ID','align'=>'left']],
		['ID' =>4, 'ATTR' =>['FIELD'=>'SKU_NM','SIZE' => '20px','label'=>'SKU_NM','align'=>'left']],
		['ID' =>5, 'ATTR' =>['FIELD'=>'QTY_PCS','SIZE' => '20px','label'=>'QTY_PCS','align'=>'right']],
		['ID' =>6, 'ATTR' =>['FIELD'=>'DIS_REF','SIZE' => '20px','label'=>'DIS_REF','align'=>'right']],
		['ID' =>7, 'ATTR' =>['FIELD'=>'STATUS','SIZE' => '20px','label'=>'STATUS','align'=>'center']],
	]; */
	$aryField= [
		['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'Date','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '10px','label'=>'Customer Alias','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'CUST_NM_ALIAS','SIZE' => '10px','label'=>'Customer ','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>3, 'ATTR' =>['FIELD'=>'ITEM_NM','SIZE' => '10px','label'=>'SKU NM','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>4, 'ATTR' =>['FIELD'=>'QTY_PCS','SIZE' => '10px','label'=>'QTY.PCS','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		['ID' =>5, 'ATTR' =>['FIELD'=>'DIS_REF_NM','SIZE' => '10px','label'=>'DIS_REF','align'=>'left','warna'=>'97, 211, 96, 0.3']],
		/*REFRENSI ALIAS*/
		['ID' =>6, 'ATTR' =>['FIELD'=>'CUST_KD_ALIAS','SIZE' => '10px','label'=>'CUST_KD','align'=>'left','warna'=>'255, 154, 48, 1']],
		['ID' =>7, 'ATTR' =>['FIELD'=>'CUST_KD','SIZE' => '10px','label'=>'CUST ALIAS','align'=>'left','warna'=>'255, 154, 48, 1']],
		['ID' =>8, 'ATTR' =>['FIELD'=>'ITEM_ID_ALIAS','SIZE' => '10px','label'=>'SKU ID','align'=>'left','warna'=>'255, 154, 48, 1']],
		['ID' =>9, 'ATTR' =>['FIELD'=>'ITEM_ID','SIZE' => '10px','label'=>'SKU.ID.ALIAS','align'=>'left','warna'=>'255, 154, 48, 1']],
		['ID' =>10, 'ATTR' =>['FIELD'=>'DIS_REF','SIZE' => '10px','label'=>'DIS_REF','align'=>'left','warna'=>'255, 154, 48, 1']],
	];
	$valFields = ArrayHelper::map($aryField, 'ID', 'ATTR');
	$attDinamik =[];
	$attDinamik[] =[
		'class'=>'kartik\grid\SerialColumn',
		'contentOptions'=>['class'=>'kartik-sheet-style'],
		'width'=>'10px',
		'header'=>'No.',
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(0, 95, 218, 0.3)',
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
	
	foreach($valFields as $key =>$value[]){
		$attDinamik[]=[
			'attribute'=>$value[$key]['FIELD'],
			'label'=>$value[$key]['label'],
			//'format' => 'html',
			/* 'value'=>function($model)use($value,$key){
				if ($value[$key]['FIELD']=='EMP_IMG'){
					 return Html::img(Yii::getAlias('@HRD_EMP_UploadUrl') . '/'. $model->EMP_IMG, ['width'=>'20']);
				}
			}, */
			//'filterType'=>$gvfilterType,
			//'filter'=>$gvfilter,
			//'filterWidgetOptions'=>$filterWidgetOpt,
			//'filterInputOptions'=>$filterInputOpt,
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
			'pageSummaryOptions' => [
				'style'=>[
						'text-align'=>'right',
						//'width'=>'12px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'text-decoration'=>'underline',
						'font-weight'=>'bold',
						'border-left-color'=>'transparant',
						'border-left'=>'0px',
				]
			],
		];
	}
	
	$actionClass='btn btn-info btn-xs';
	$actionLabel='Update';
	$attDinamik[]=[
		'class'=>'kartik\grid\ActionColumn',
		'dropdown' => true,
		'template' => '{cust}{prodak}',
		//'template' => '{cust}{prodak}{customer}',
		'dropdownOptions'=>['class'=>'pull-right dropdown','style'=>['disable'=>true]],
		'dropdownButton'=>[
			'class' => $actionClass,
			'label'=>$actionLabel,
			//'caret'=>'<span class="caret"></span>',
		],
		'buttons' => [
			'cust' =>function($url, $model, $key){
					return  '<li>' .Html::a('<span class="fa fa-random fa-dm"></span>'.Yii::t('app', 'Set Alias Customer'),
												['/sales/import-sales-po/alias_cust','id'=>$model['ID']],[
												'id'=>'alias-cust-id',
												'data-toggle'=>"modal",
												'data-target'=>"#alias-cust",
												]). '</li>' . PHP_EOL;
			},
			'prodak' =>function($url, $model, $key){
					return  '<li>' . Html::a('<span class="fa fa-retweet fa-dm"></span>'.Yii::t('app', 'Set Alias Prodak'),
												['/sales/import-sales-po/alias_prodak','id'=>$model['ID']],[
												'id'=>'alias-prodak-id',
												'data-toggle'=>"modal",
												'data-target'=>"#alias-prodak",
												]). '</li>' . PHP_EOL;
			}
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
	
	/**
	* GRIDVIEW DATA EXCEL FROM FILE
	* @return mixed
	* @author piter [ptr.nov@gmail.com]
	*/
	$gvImportFile=GridView::widget([
		'id'=>'gv-arryFile-salespo-id',
		'dataProvider' => $getArryFile,
		//'filterModel' => $searchModel,
		'rowOptions' => function($model, $key, $index, $grid){
				if ($model->CUST_KD=='NotSet' or $model->ITEM_NM=='NotSet'){
					return ['class' => 'danger'];
				};
		},		
		'floatOverflowContainer'=>true,
		'floatHeader'=>true,
		//'floatHeaderOptions'=>['scrollingTop'=>'10'],
		'columns'=>$attDinamik,						
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-arryFile-salespo-id',
		   ],						  
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
		'toolbar' => [
			''
		],
		'panel' => [
			'heading'=>'<h3 class="panel-title">IMPORT PO SALES</h3>',
			'type'=>'info',
			'before'=> Html::a('<i class="fa fa-clone"></i> '.Yii::t('app', 'Download Format Import File'),'/sales/import-sales-po/export_format',
									[
										'id'=>'export-x-id',
										'data-pjax' => true,
										'class' => 'btn btn-info btn-sm'
									]
						).' '.
						Html::a('<i class="fa fa-upload"></i> '.Yii::t('app', 'Import File',
								['modelClass' => 'Kategori',]),'',[
									'data-toggle'=>"modal",
									'data-target'=>"#file-import",
									'class' => 'btn btn-success btn-sm'
								]
						).' '.	
						Html::a('<i class="fa fa-remove"></i> '.
								Yii::t('app', 'Clear',['modelClass' => 'Clear',]),'/sales/import-sales-po',[
									'id'=>'clear',
									'data-pjax' => '0',
									'class' => 'btn btn-danger btn-sm'
								]
						).' '.				
						Html::a('<i class="fa fa-check-square"></i> '.
								Yii::t('app', 'Check',['modelClass' => 'check',]),'',[
									'id'=>'check-data',
									'data-pjax' => true,
									'data-toggle-check'=>$fileName,
									'class' => 'btn btn-warning btn-sm'
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
<?=$gvImportFile?>
<?php
$this->registerJs("
		/**====================================
		 * ACTION : VALIDATION 
		 * @return mixed
		 * @author piter [ptr.nov@gmail.com]
		 * @since 1.2
		 * ====================================
		 */
		$(document).on('click', '[data-toggle-check]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-approved');
			$.ajax({
				url: '/sales/import-sales-po/import_temp_validation',
				type: 'POST',
				//contentType: 'application/json; charset=utf-8',
				data:'id='+idx,
				dataType: 'json',
				success: function(result) {
					if (result == 1){
						// Success
						$.pjax.reload({container:'#gv-validate-salespo-id'});
					} else {
						// Fail
					}
				}
			});
		});
		
		
		/**====================================
		 * ACTION : DELETE & CLEAR VALIDATION 
		 * @return mixed
		 * @author piter [ptr.nov@gmail.com]
		 * @since 1.2
		 * ====================================
		 */
		$(document).on('click', '[data-toggle-clear]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-clear');
			$.ajax({
				url: '/sales/import-sales-po/clear_temp_validation',
				type: 'POST',
				//contentType: 'application/json; charset=utf-8',
				data:'id='+idx,
				dataType: 'json',
				success: function(result) {
					if (result == 1){
						// Success
						$.pjax.reload({container:'#gv-validate-salespo-id'});
					} else {
						// Fail
					}
				}
			});

		});
	",$this::POS_READY);
?>