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

	$signatureFrm=$this->render('_signature');
	$items=[
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Profile','content'=>'',
			//'active'=>true,
		],
		
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Signature','content'=>$signatureFrm,
			'id'=>'siq',
		],
	];

	
	echo TabsX::widget([
		'id'=>'tab-emp',
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		//'height'=>'tab-height-xs',
		'bordered'=>true,
		'encodeLabels'=>false,
		//'align'=>TabsX::ALIGN_LEFT,

	]);