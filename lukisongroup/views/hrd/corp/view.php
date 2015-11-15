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
$this->title = Yii::t('app', 'Detail View Coorporation');       /* title pada header page */

	$attribute = [
		[
			'attribute' =>'CORP_ID',
			//'inputWidth'=>'20%'
		],	
		[
			'attribute' =>	'CORP_NM',
			//'inputWidth'=>'40%'					
		],
		[
			'attribute' =>	'CORP_DCRP',			
			'type'=>DetailView::INPUT_TEXTAREA, 			
		],
		[
			'attribute' =>	'SORT',
			//'inputWidth'=>'40%'
		],			
	];
	echo DetailView::widget([
		'id'=>'dv-corp',
		'model' => $model,				
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'panel'=>[
			'heading'=>$model->CORP_ID . '| '.$model->CORP_NM,
			'type'=>DetailView::TYPE_INFO,
		],	
		'attributes'=>$attribute,
		'deleteOptions'=>[
				'url'=>['deletestt', 'id' => $model->CORP_ID],
				'data'=>[
					'confirm'=>Yii::t('app', 'Are you sure you want to delete this record?'),
					'method'=>'post',
				],
			],		
	]);			
?>


