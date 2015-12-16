<?php
use kartik\tabs\TabsX;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;


	$signatureFrm=$this->render('_signature',[
		'model'=> $model,
	]);
	$EmpProfile=$this->render('_profile');
	$items=[
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Signature','content'=>$signatureFrm,
			'id'=>'siq',
			'active'=>true,
		],
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Profile','content'=>$EmpProfile,
			//'active'=>true,
		],
		
		
	];

	echo TabsX::widget([
			'id'=>'tab-sig',
			'items'=>$items,
			'position'=>TabsX::POS_ABOVE,
			'bordered'=>true,
			'encodeLabels'=>false,
			//'align'=>TabsX::ALIGN_LEFT,

		]);
	?>
