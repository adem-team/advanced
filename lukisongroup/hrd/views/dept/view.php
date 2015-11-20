<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use lukisongroup\models\hrd\Dept;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\icons\Icon;
use kartik\widgets\Growl;

$this->sideCorp = 'Modul HRM';                        			/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_modul';                        			/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Detail View Department');         /* title pada header page */

	$attribute = [
		[
			'attribute' =>'DEP_ID',
			//'inputWidth'=>'20%'
		],	
		[
			'attribute' =>	'DEP_NM',
			//'inputWidth'=>'40%'					
		],
		[
			'attribute' =>	'DEP_DCRP',
			'format'=>'raw',
			//'value'=>'DEP_DCRP',
			'type'=>DetailView::INPUT_TEXTAREA, 
			'widgetOptions'=>[
				'data'=>'DEP_DCRP',
				'options'=>['placeholder'=>'Position Description ...'],
				'pluginOptions'=>['allowClear'=>true],
			],
		],
		[
			'attribute' =>	'SORT',
			//'inputWidth'=>'40%'
		],			
	];
	echo DetailView::widget([
		'id'=>'dv-dept',
		'model' => $model,				
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'panel'=>[
			'heading'=>$model->DEP_ID . '| '.$model->DEP_NM,
			'type'=>DetailView::TYPE_INFO,
		],	
		'attributes'=>$attribute,
		'deleteOptions'=>[
				'url'=>['deletestt', 'id' => $model->DEP_ID],
				'data'=>[
					'confirm'=>Yii::t('app', 'Are you sure you want to delete this record?'),
					'method'=>'post',
				],
			],		
	]);			
?>

