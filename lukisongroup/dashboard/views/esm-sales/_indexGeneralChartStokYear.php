<?php
use kartik\helpers\Html;	
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\bootstrap\Modal;
use ptrnov\fusionchart\Chart;

	$btn_srchChart = Html::button(Yii::t('app', 'Search Date'),
		['value'=>url::to(['ambil-tanggal-chart']),
		'id'=>'modalButtonDashboardChartTgl',
		'class'=>"btn btn-info btn-sm"						
	]);
	//DISTRIBUTOR STOCK YEARLY 
	$distStockGudang= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/rpt-esm-chart-salesmd/dist-all-stock-gudang',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'msline',//msline//'bar3d',//'gantt',				//Chart Type 
		'renderid'=>'msline-distributor-stockgudang',					//unix name render
		'autoRender'=>true,
		'width'=>'100%',
		'height'=>'300px'
	]);	 
	
?>
<div class="w3-card-2 w3-round w3-white w3-center">
	<div class="panel-heading">
		<div class="row">
			<div style="min-height:300px"><div style="height:300px"><?=$distStockGudang?></div></div><div class="clearfix"></div>
		</div>
	</div>	
</div>			

