<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use kartik\widgets\ActiveForm;

$this->sideCorp = 'Modul HRM';                            	   /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_modul';                            	   /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'DetailView Group Function');     /* title pada header page */

$attribute = [		
		//GROUP FUNCTION ID - Author: -ptr.nov-
		[
			'attribute' =>	'GF_ID',
			'options'=>['readonly'=>true],
		],
		//GROUP FUNCTION NAME - Author: -ptr.nov-
		[
			'attribute' =>	'GF_NM',
		],
		
		//GROUP FUNCTION DESCRIPTION - Author: -ptr.nov-		
		[
			'attribute' =>	'GF_DCRP',
			'type'=>DetailView::INPUT_TEXTAREA,
		],
		//SORT - Author: -ptr.nov-
		[
			'attribute' =>	'SORT',
		],
	];

	$form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]);
		echo DetailView::widget([
			'id'=>'dv-function',
			'model' => $model,
			//'pjax'=>true,
			'condensed'=>true,
			'hover'=>true,
			'mode'=>DetailView::MODE_VIEW,
			'panel'=>[
				'heading'=>'GROUP FUNCTION',
				'type'=>DetailView::TYPE_INFO,
			],	
			
				'attributes'=>$attribute,
			
			
			'deleteOptions'=>[
				'url'=>['deletestt', 'id' => $model->GF_ID],
				'data'=>[
					'confirm'=>Yii::t('app', 'Are you sure you want to delete this record?'),
					'method'=>'post',
				],
			],										
		]);		
	ActiveForm::end();	
?>

