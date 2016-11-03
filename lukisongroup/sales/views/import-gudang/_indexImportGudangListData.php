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

	$gvListImport=GridView::widget([
		'id'=>'gv-list-importdata-gudang',
		'dataProvider' => $dataProviderViewImport,
		'filterModel' => $searchModelViewImport,
		'columns'=>$gvRows,					
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