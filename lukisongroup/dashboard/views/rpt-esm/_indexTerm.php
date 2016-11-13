<?php
use kartik\helpers\Html;	
use kartik\tabs\TabsX;
use ptrnov\fusionchart\Chart;
use ptrnov\fusionchart\ChartAsset;
use yii\helpers\Url;
ChartAsset::register($this);


$indexTermTab1=$this->render('indexTermTab1');
$indexTermTab2=$this->render('indexTermTab2');

$items=[
	[
		'label'=>'<i class="fa fa-mortar-board fa-lg"></i>TERM DATA','content'=>$indexTermTab1,
		'active'=>true,
		'options' => ['id' => 'term-data'],
	],
	[
		'label'=>'<i class="fa fa-bar-chart fa-lg"></i> SELL CONTRIBUTING','content'=>$indexTermTab2,
		'options' => ['id' => 'sell-chart'],
	]
];
echo TabsX::widget([
	'id'=>'dashboard-term-plan',
	'items'=>$items,
	'sideways'=>true,
	'position'=>TabsX::POS_ABOVE,
	'encodeLabels'=>false,

]);
?>