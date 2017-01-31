<?php
use kartik\helpers\Html;
use kartik\widgets\Spinner;		
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
		'height'=>'300px',
	]);	 
	//$loadingSpinner1=Spinner::widget(['id'=>'spn1-load-road','preset' => 'large', 'align' => 'center', 'color' => 'blue']);
	 
?>

<div class="w3-card-2 w3-round w3-white w3-center" style="margin-top:10px">
	<div class="panel-heading ">
		<div class="row">
			<div style="min-height:300px"><?php //$loadingSpinner1?><div style="height:300px"><?=$distSalesPo?></div></div><div class="clearfix"></div>
		</div>
	</div>	
</div>			

