<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use kartik\widgets\ActiveForm;

$this->sideCorp = 'Modul HRM';                          /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_modul';                          /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Detail View Seqmen');     /* title pada header page */

$attribute = [		
		//JOBGRADE_ID - Author: -ptr.nov-
		[
			'attribute' =>	'SEQ_ID',
			'options'=>['readonly'=>true],
		],
		//JOBGRADE NAME - Author: -ptr.nov-
		[
			'attribute' =>	'SEQ_NM',
		],
		
		//DESCRIPTION - Author: -ptr.nov-		
		[
			'attribute' =>	'SEQ_DCRP',
			'type'=>DetailView::INPUT_TEXTAREA,
		],
		//SORT - Author: -ptr.nov-
		[
			'attribute' =>	'SORT',
		],
	];

	$form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]);
		echo DetailView::widget([
			'id'=>'dv-seqmen',
			'model' => $model,
			//'pjax'=>true,
			'condensed'=>true,
			'hover'=>true,
			'mode'=>DetailView::MODE_VIEW,
			'panel'=>[
				'heading'=>'SEQMENT',
				'type'=>DetailView::TYPE_INFO,
			],	
			
				'attributes'=>$attribute,
			
			
			'deleteOptions'=>[
				'url'=>['deletestt', 'id' => $model->SEQ_ID],
				'data'=>[
					'confirm'=>Yii::t('app', 'Are you sure you want to delete this record?'),
					'method'=>'post',
				],
			],										
		]);		
	ActiveForm::end();	
?>

