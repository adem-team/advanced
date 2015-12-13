<?php
use kartik\tabs\TabsX;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use lukisongroup\assets\AppAssetJquerySignature_1_1_2create;
AppAssetJquerySignature_1_1_2create::register($this); 

$items=[
	[
		'label'=>'<i class="glyphicon glyphicon-home"></i>Struktur Organisasi','content'=>'asdasdsadasd',
	],
	[
		'label'=>'<i class="glyphicon glyphicon-home"></i>VisiMisi','content'=>'asdasdsadasd',
	],
	[
		'label'=>'<i class="glyphicon glyphicon-home"></i>Regulations','content'=>'asdasdsadasd',
	],
	[
		'label'=>'<i class="glyphicon glyphicon-home"></i>Jobsdesk','content'=>'asdasdasd',
	],
	[
		'label'=>'<i class="glyphicon glyphicon-home"></i>Attendance','content'=>'asdasdasd',
	],
	[
		'label'=>'<i class="glyphicon glyphicon-home"></i>Mutation','content'=>'asdasdasd',                
	],
];

echo TabsX::widget([
	'items'=>$items,
	'position'=>TabsX::POS_ABOVE,
	//'height'=>'tab-height-xs',
	'bordered'=>true,
	'encodeLabels'=>false,
	//'align'=>TabsX::ALIGN_LEFT,

]);