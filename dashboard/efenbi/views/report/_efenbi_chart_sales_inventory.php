<?php
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* use lukisongroup\assets\AppAssetFusionChart;
AppAssetFusionChart::register($this); */

global $xaxis;
global $canvasEndY;

 $this->registerJs('
			
			
			function ubahData() {
				
					/* var  jsonData2= $.ajax({
					url: "http://dashboard.lukisongroup.int/efenbi/report/inventori-sales",
					type: "GET",
					dataType:"json",
					async: false,
					}).responseText;		  
					var myData2 = jsonData2; */
					
					var chartReference = FusionCharts("sales-inventory");
					
				
					//chartReference.setChartData(jsonData2,"JSON");
					chartReference.setChartData('.$dataSalesInventory.',"JSON");
					
			}
				
			/* setTimeout(function () {ubahData();	
			},500) */; 
			
				
',$this::POS_READY); 
 
?>

<div class="row" style="padding-left:15px; padding-right:15px;">
	<!-- TENGAH !-->
	<div class="col-lg-12 col-md-12">
		<div id="chart-sales-inventory"></div>
		<a class="btn btn-warning btn-xs" href="/efenbi/review-stock">Detail >></a>
	</div>
	<div class="col-lg-12 col-md-12">
	
	 </div>
</div>

<?php
	/* 
	 * GRAPH ESM ALL STOCK
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.1
	*/
	$this->registerJs('	
	
	//$(document).ready(function () {
		//setTimeout(function () {
				/*var  jsonData1= $.ajax({
					 url: "http://dashboard.lukisongroup.int/efenbi/report/inventori-sales",
					type: "GET",
					dataType:"json",
					async: false,
					}).responseText;		  
					var myData1 = jsonData1; */
					if(FusionCharts("sales-inventory")){
						FusionCharts("sales-inventory").dispose();
					}   
					var salesStockChart = new FusionCharts({
					id:"sales-inventory",
					type: "msstackedcolumn2dlinedy",
					//type: "mscolumn2D",
					renderAt: "chart-sales-inventory",
					width: "100%",
					height: "250",					
					dataFormat: "json",
					dataSource: '.$dataSalesInventory.' 
					//dataSource: myData1 
				}).render();
			
				
			/* setTimeout(function () {changeMonth();
				
			},4000); */
	//	});
	
	',$this::POS_READY); 

?>