<?php
/*
 * By ptr.nov
 * Load Config CSS/JS
 */
/* YII CLASS */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* TABLE CLASS DEVELOPE -> |DROPDOWN,PRIMARYKEY-> ATTRIBUTE */
use lukisongroup\models\hrd\Modulset;
/*	KARTIK WIDGET -> Penambahan componen dari yii2 dan nampak lebih cantik*/
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;

use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/

/*Title page Modul*/
$this->sideMenu = 'hrd_employee';
$this->title = Yii::t('app', 'Modul HRD');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
	/*MODUL HRD Author: -ptr.nov */
	//print_r($dataProvider);
	echo GridView::widget([
		'dataProvider' => $dataProvider_Mdlhrd,
		'filterModel' => $searchModel_Mdlhrd,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'MDL_ID',
			'MDL_NM',
			'MDL_DCRP',
			'SORT',
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view}',
			],
		],
		'panel'=>[
			'heading' =>false,// $hdr,//<div class="col-lg-4"><h8>'. $hdr .'</h8></div>',
			'type' =>GridView::TYPE_SUCCESS,//TYPE_WARNING, //TYPE_DANGER, //GridView::TYPE_SUCCESS,//GridView::TYPE_INFO, //TYPE_PRIMARY, TYPE_INFO
			'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create {modelClass}',
			['modelClass' => 'Modul HRD',]),
			['create'], ['class' => 'btn btn-success']),
		],
		'hover'=>true, //cursor selec
		'responsive'=>true,
		'bordered'=>true,
		'striped'=>true,
	]);
?>

