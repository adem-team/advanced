<?php
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
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

//print_r($dataEsmStockAll);
/* $this->registerJs('
	setTimeout(function(){ 
			$("#chart-sales-inventory").load(location.href + "#chart-sales-inventory");			
	}, 3100);
',$this::POS_READY); */

$this->registerJs('
	/* 
	 * GRAPH ESM ALL STOCK PER SKU 
	 * @author piter ]ptr.nov@gmail.com]
	 * @since 1.1
	*/
	FusionCharts.ready(function () {
		var ratingsSalesStock = new FusionCharts({
			id: "chart-sales-stock-id",
			type: "msline",
			renderAt: "chart-sales-inventory",
			width: "100%",
			height: "300",
			dataFormat: "json",
			dataSource: {			
				"chart": {
					"caption": "UPDATE SALESMAN STOCK",
					"showValues": "1" , 
					"captionFontSize": "14",
					"subcaptionFontSize": "14",
					"subcaptionFontBold": "0",
					"paletteColors": "#FF0033,#0B2536,#0075c2,#9E466B,#C5E323",
					"bgcolor": "#ffffff",
					"showBorder": "1",
					"showShadow": "0",
					"showCanvasBorder": "0",
					"usePlotGradientColor": "0",
					"legendBorderAlpha": "1",
					"legendShadow": "1",
					"showAxisLines": "0",
					"showAlternateHGridColor": "0",
					"divlineThickness": "1",
					"divLineIsDashed": "1",
					"divLineDashLen": "1",
					"divLineGapLen": "1"			
				},
				'.$dataSalesInventory.'
			}
		});

		ratingsSalesStock.render();
	});		
',$this::POS_READY);
?>