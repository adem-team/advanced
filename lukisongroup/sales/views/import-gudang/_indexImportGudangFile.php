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


	/**
	* GRIDVIEW DATA EXCEL FROM FILE
	* @return mixed
	* @author piter [ptr.nov@gmail.com]
	*/
	$gvImportFile=GridView::widget([
		'id'=>'gv-arryFile-gudang-id',
		'dataProvider' => $getArryFile,
		//'filterModel' => $searchModel,
		'columns'=>$gvColumnAryFile,						
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
						Html::a('<i class="fa fa-clone"></i> '.Yii::t('app', 'Get Format1'),'/sales/import-data/export_format',
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