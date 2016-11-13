<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Json;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use kartik\tabs\TabsX;
use yii\widgets\ListView;

$this->title = 'Sales Order';
$this->params['breadcrumbs'][] = $this->title;
$this->sideCorp = 'Sales Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_customers';                     /* kd_menu untuk list menu pada sidemenu, get from table of database */
?>

<div style="padding:10px;">
	<?php
	
		$inboxSo= Yii::$app->controller->renderPartial('_indexInbox',[
			'apSoHeaderInbox'=>$apSoHeaderInbox
		]);
		$outboxSo= Yii::$app->controller->renderPartial('_indexOutbox',[
			'apSoHeaderOutbox'=>$apSoHeaderOutbox,
		]);
		$historySo= Yii::$app->controller->renderPartial('_indexHistory',[
			'apSoHeaderHistory'=>$apSoHeaderHistory,
		]);
		
		$items=[
			[
				'label'=>'<i class="fa fa-sign-out fa-lg"></i>  Inbox','content'=>$inboxSo, 
				'active'=>true,
			],
			[
				'label'=>'<i class="fa fa-sign-in fa-lg"></i>  Outbox','content'=>$outboxSo,				
			],
			[
				'label'=>'<i class="fa fa-sign-in fa-lg"></i>  Historical','content'=>$historySo,				
			]			
		];
		echo TabsX::widget([
			'id'=>'tab-index-ro',
			'items'=>$items,
			'position'=>TabsX::POS_ABOVE,
			//'height'=>'tab-height-xs',
			'bordered'=>true,
			'encodeLabels'=>false,
			//'align'=>TabsX::ALIGN_LEFT,
		]);
	?>
</div>
