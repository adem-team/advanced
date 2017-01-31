<?php
use kartik\helpers\Html;	
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\bootstrap\Modal;
use ptrnov\fusionchart\Chart;


	//DISTRIBUTOR SALES PO
	$distSalesPo= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/rpt-esm-chart-salesmd/dist-sales-po',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'msline',//msline//'bar3d',//'gantt',				//Chart Type 
		'renderid'=>'msline-distributor-sales-po',					//unix name render
		'autoRender'=>true,
		'width'=>'100%',
		'height'=>'400px',
	]);	 
	
?>
<?=$distSalesPo?>
