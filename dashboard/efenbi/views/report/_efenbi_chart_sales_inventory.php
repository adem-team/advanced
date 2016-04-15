<?php
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use lukisongroup\assets\AppAssetFusionChart;
AppAssetFusionChart::register($this);

global $xaxis;
global $canvasEndY;


?>

<div class="row" style="padding-left:15px; padding-right:15px;">
	<!-- TENGAH !-->
	<div class="col-lg-12 col-md-12">
		<div id="chart-sales-inventory"></div>			
	</div>
</div>

<?php
	/* 
	 * GRAPH ESM ALL STOCK
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.1
	*/
	$this->registerJs('	
	$(document).ready(function () {
			//FusionCharts.ready(function () {
				var  jsonData1= $.ajax({
					url: "http://dashboard.lukisongroup.com/efenbi/report/inventori-sales",
					type: "GET",
					dataType:"json",
					async: false,
					}).responseText;		  
					var myData1 = jsonData1;
				  
				var salesStockChart = new FusionCharts({
					type: "line",
					renderAt: "chart-sales-inventory",
					width: "100%",
					height: "250",
					//updateInterval:"5",
					//refreshInterval:"5",
					dataFormat: "json",
					dataSource: myData1 
				}).render();	
			});
		//});
	
	',$this::POS_READY); 

?>