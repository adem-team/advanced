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
		['ID' =>0, 'ATTR' =>['FIELD'=>'DATE','SIZE' => '10px','label'=>'DATE','align'=>'center']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_KD','SIZE' => '10px','label'=>'CUST_KD','align'=>'left']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '20px','label'=>'CUST_NM','align'=>'left']],
		['ID' =>3, 'ATTR' =>['FIELD'=>'SKU_ID','SIZE' => '20px','label'=>'SKU_ID','align'=>'left']],
		['ID' =>4, 'ATTR' =>['FIELD'=>'SKU_NM','SIZE' => '20px','label'=>'SKU_NM','align'=>'left']],
		['ID' =>5, 'ATTR' =>['FIELD'=>'QTY_PCS','SIZE' => '20px','label'=>'QTY_PCS','align'=>'right']],
		['ID' =>6, 'ATTR' =>['FIELD'=>'DIS_REF','SIZE' => '20px','label'=>'DIS_REF','align'=>'right']],
	];
	$valFields = ArrayHelper::map($aryField, 'ID', 'ATTR');
	$attDinamik =[];
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
					'background-color'=>'rgba(97, 211, 96, 0.3)',
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
	
	/**
	* GRIDVIEW DATA EXCEL FROM FILE
	* @return mixed
	* @author piter [ptr.nov@gmail.com]
	*/
	$gvImportFile=GridView::widget([
		'id'=>'gv-arryFile-gudang-id',
		'dataProvider' => $getArryFile,
		//'filterModel' => $searchModel,
		'columns'=>$attDinamik,						
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-arryFile-gudang-id',
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
			'heading'=>'<h3 class="panel-title">IMPORT FILES STOCK</h3>',
			'type'=>'danger',
			'before'=> Html::a('<i class="fa fa-upload"></i> '.Yii::t('app', 'Import File',
								['modelClass' => 'Kategori',]),'',[
									'data-toggle'=>"modal",
									'data-target'=>"#file-import",
									'class' => 'btn btn-danger btn-sm'
								]
						).' '.								
						Html::a('<i class="fa fa-check-square"></i> '.
								Yii::t('app', 'Check',['modelClass' => 'check',]),'',[
									'id'=>'approved',
									'data-pjax' => true,
									'data-toggle-approved'=>$fileName,
									'class' => 'btn btn-success btn-sm'
								]
						).' '.
						Html::a('<i class="fa fa-clone"></i> '.Yii::t('app', 'Get Format1'),'/sales/import-gudang/export_format',
									[
										'id'=>'export-x-id',
										'data-pjax' => true,
										'class' => 'btn btn-info btn-sm'
									]
						),										
			'showFooter'=>false,
		],
	]); 
?>
<?=$gvImportFile?>