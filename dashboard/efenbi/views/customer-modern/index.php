<?php
use kartik\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;

use dashboard\assets\AppAssetFusionChart;
AppAssetFusionChart::register($this);


$this->sideCorp = 'PT. ESM';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'effenbi_dboard';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;     


	$valCustAll=$count_CustPrn>0?$model_CustPrn[0]['COUNT_ALL_CUST']:0;
	$valCustModern=$count_CustPrn>0?$model_CustPrn[1]['COUNT_CUST']:0;
	$valCustGeneral=$count_CustPrn>0?$model_CustPrn[2]['COUNT_CUST']:0;
	$valCustHoreca=$count_CustPrn>0?$model_CustPrn[3]['COUNT_CUST']:0;
	$valCustOther=$count_CustPrn>0?$model_CustPrn[4]['COUNT_CUST']:0;
?>
<div class="container-fluid" style="padding-left: 20px; padding-right: 20px" >
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">			
			<div class="row">
				<!-- KIRI !-->
				<div class="col-lg-4 col-md-4" style="padding-top:10px">
					<div id="chart-piramid"></div>
				</div>
				<!-- KANAN !-->
				<div class="col-lg-8 col-md-8" style="padding-top:10px">
					<?php
						 echo Html::panel(
							[
							//'heading' => '<a class="btn btn-info btn-xs full-right" href="/efenbi/report"><< BACK MENU </a> All Customer Category',
								'body'=> '<div id="chart-cust-parent" style="height:200px"></div> <div id="chart-cust-active-call"  style="height:200px"></div>',
							],
							Html::TYPE_INFO
						);
					?>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12 full-right">	
			<div class="row">
				<!-- KIRI !-->
				<div class="col-lg-4 col-md-4" style="padding-top:10px">
					<?php
						 echo Html::panel(
							[
								'heading' => 'Monthly Top 5 Plan & Actual Visited',
								'body'=> '<div id="chart-top5-plan-actual"></div>',
							],
							Html::TYPE_INFO
						);
					?>
				</div>		
				<div class="col-lg-4 col-md-4" style="padding-top:10px">
					<?php
						 echo Html::panel(
							[
								'heading' => 'Monthly Top 5 Inventory Visited',
								'body'=> '<div id="chart-top5-inventory"></div>',
							],
							Html::TYPE_INFO
						);
					?>
				</div>		
				<div class="col-lg-4 col-md-4" style="padding-top:10px">
					<?php
						 echo Html::panel(
							[
								'heading' => 'Monthly Top 5 Salesman Visited',
								//'heading' => 'Monthly Top 5 Reauest Order Visited',
								'body'=> '<div id="chart-top5-request-order"></div>',
							],
							Html::TYPE_INFO
						);
					?>
				</div>		
			</div>
		</div>
	</div>
</div>

<?php
	$this->registerJs('
		/* 
		 * GRAPH PIRAMIT ALL CUSTOMER
		 * @author piter [ptr.nov@gmail.com]
		 * @since 1.1
		*/
		$(document).ready(function () {
			var myPiramidChart = new FusionCharts({
				type: "pyramid",
				width: "100%",
				//height: "100%",
				dataFormat: "jsonurl",			
				renderAt: "chart-piramid",
				dataFormat: "json",
				dataSource: {
					chart: {
						//theme: "fint",
						caption: "All Customer Category",
						//subcaption: "Credit Suisse 2013",
						//captionOnTop: "1",
						//captionPadding: "25",
						//alignCaptionWithCanvas: "1",						
						//subCaptionFontSize: "12",
						borderAlpha: "1",
						is2D: "0",
						bgColor: "#ffffff",
						showValues: "0",
						showLegend: "1",
						numberPrefix: "$",
						numberSuffix: "M",
						showPercentValues: "1",
						//chartLeftMargin: "40"
					},
					data: [
							  {
								 label: "Modern",
								 value: "'.$valCustModern.'"
							  },
							  {
								 label: "Horeca",
								 value: "'.$valCustHoreca.'"
							  },
							  {
								 label: "General",
								 value: "'.$valCustGeneral.'"
							  },
							  {
								 label: "Other",
								 value: "'.$valCustOther.'"
							  }
					   ]
				}
			});
			myPiramidChart.render();
		});
	',$this::POS_READY);
?>
<?php
	$this->registerJs('
		/* 
		 * GRAPH CUSTOMER PARENT
		 * @author piter [ptr.nov@gmail.com]
		 * @since 1.1
		*/
		$(document).ready(function () {
		var myChartCustParent = new FusionCharts({
			type: "column2d",
			width: "100%",
			height: "80%",			
			renderAt: "chart-cust-parent",
			dataFormat: "json",
			dataSource: {
				chart: {
					caption: "Customers Modern Parent",
					//subcaption: "Daily Actual Total Stock sell-out",
					subcaptionFontBold: "0",
					subcaptionFontSize: "14",
					numberPrefix: "",
					yaxismaxvalue: "500",	
					"palettecolors": "#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",					
					borderAlpha: "20",
					bgColor: "#ffffff",
					usePlotGradientColor: "0",
					plotBorderAlpha: "10", 
					showAlternateHGridColor: "0",
					showXAxisLine: "1"						
				},
				data: '.$resultCountChildParen.'			    
			}
		});
		myChartCustParent.render();
	});
		
		
	',$this::POS_READY);
?>

<?php
	$this->registerJs('
		/* 
		 * GRAPH MODERN CUSTOMER ACTIVE
		 * @author piter [ptr.nov@gmail.com]
		 * @since 1.1
		*/
		$(document).ready(function () {
			var ChartSalesCompare = new FusionCharts({
				type: "msline",
				renderAt: "chart-cust-active-call",
				width: "100%",
				height: "80%",
				dataFormat: "json",
				dataSource: '.$cac.'
			}).render();
		});
	',$this::POS_READY);
?>

<?php
	$this->registerJs('
		$(document).ready(function () {
			/* 
			 * GRAPH MODERN CUSTOMER TOP 5 SCHADULE & VISITING
			 * @author piter [ptr.nov@gmail.com]
			 * @since 1.1
			*/
			var top5PlanActual = new FusionCharts({
				type: "msbar2d",
				renderAt: "chart-top5-plan-actual",
				width: "100%",
				height: "420",
				dataFormat: "json",
				dataSource: {
					"chart": {
						//"caption": "Top % Plan & Actual Visited",
						//"subCaption": "In top 5 stores last month",
						//"yAxisname": "Sales (In USD)",
						"numberPrefix": "$",
						"paletteColors": "#0075c2,#1aaf5d",
						"bgColor": "#ffffff",
						"showBorder": "0",
						"showHoverEffect":"1",
						"showCanvasBorder": "0",
						"usePlotGradientColor": "0",
						"plotBorderAlpha": "10",
						"legendBorderAlpha": "0",
						"legendShadow": "0",
						"placevaluesInside": "1",
						"valueFontColor": "#ffffff",
						"showXAxisLine": "1",
						"xAxisLineColor": "#999999",
						"divlineColor": "#999999",               
						"divLineIsDashed": "1",
						"showAlternateVGridColor": "0",
						"subcaptionFontBold": "0",
						"subcaptionFontSize": "14"
					},            
					"categories": [
						{
							"category": [
								{
									"label": "Bakersfield Central"
								}, 
								{
									"label": "Garden Groove harbour"
								}, 
								{
									"label": "Los Angeles Topanga"
								}, 
								{
									"label": "Compton-Rancho Dom"
								}, 
								{
									"label": "Daly City Serramonte"
								}
							]
						}
					],            
					"dataset": [
						{
							"seriesname": "Food Products",
							"data": [
								{
									"value": "17000"
								}, 
								{
									"value": "19500"
								}, 
								{
									"value": "12500"
								}, 
								{
									"value": "14500"
								}, 
								{
									"value": "17500"
								}
							]
						}, 
						{
							"seriesname": "Non-Food Products",
							"data": [
								{
									"value": "25400"
								}, 
								{
									"value": "29800"
								}, 
								{
									"value": "21800"
								}, 
								{
									"value": "19500"
								}, 
								{
									"value": "11500"
								}
							]
						}
					],
					/* "trendlines": [
						{
							"line": [
								{
									"startvalue": "15000",
									"color": "#0075c2",
									"valueOnRight": "1",
									"displayvalue": "Avg. for{br}Food"
								},
								{
									"startvalue": "22000",
									"color": "#1aaf5d",
									"valueOnRight": "1",
									"displayvalue": "Avg. for{br}Non-food"
								}
							]
						}
					] */
				}
			}).render(); 
			
			/* 
			 * GRAPH MODERN CUSTOMER TOP 5 INVENTORY
			 * @author piter [ptr.nov@gmail.com]
			 * @since 1.1
			*/
			var top5Inventory = new FusionCharts({
				type: "bar2d",
				renderAt: "chart-top5-inventory",
				width: "100%",
				height: "300",
				dataFormat: "json",
				dataSource: {
					"chart": {
						//"caption": "Top 5 Stores by Sales",
						//"subCaption": "Last month",
						//"yAxisName": "Sales (In USD)",
						"numberPrefix": "$",
						"paletteColors": "#0075c2",
						"bgColor": "#ffffff",
						"showBorder": "0",
						"showCanvasBorder": "0",
						"usePlotGradientColor": "0",
						"plotBorderAlpha": "10",
						"placeValuesInside": "1",
						"valueFontColor": "#ffffff",
						"showAxisLines": "1",
						"axisLineAlpha": "25",
						"divLineAlpha": "10",
						"alignCaptionWithCanvas": "0",
						"showAlternateVGridColor": "0",
						"captionFontSize": "14",
						"subcaptionFontSize": "14",
						"subcaptionFontBold": "0",
						"toolTipColor": "#ffffff",
						"toolTipBorderThickness": "0",
						"toolTipBgColor": "#000000",
						"toolTipBgAlpha": "80",
						"toolTipBorderRadius": "2",
						"toolTipPadding": "5"
					},
					
					"data": [
						{
							"label": "Bakersfield Central",
							"value": "880000"
						}, 
						{
							"label": "Garden Groove harbour",
							"value": "730000"
						}, 
						{
							"label": "Los Angeles Topanga",
							"value": "590000"
						}, 
						{
							"label": "Compton-Rancho Dom",
							"value": "520000"
						}, 
						{
							"label": "Daly City Serramonte",
							"value": "330000"
						}
					]
				}
			}).render();
			
			/* 
			 * GRAPH MODERN CUSTOMER TOP 5 Request Ouder
			 * @author piter [ptr.nov@gmail.com]
			 * @since 1.1
			*/
			var top5RequestOrder = new FusionCharts({
				type: "bar2d",
				renderAt: "chart-top5-request-order",
				width: "100%",
				height: "300",
				dataFormat: "json",
				dataSource: {
					"chart": {
						//"caption": "Top 5 Stores by Sales",
						//"subCaption": "Last month",
						//"yAxisName": "Sales (In USD)",
						"numberPrefix": "$",
						"paletteColors": "#0075c2",
						"bgColor": "#ffffff",
						"showBorder": "0",
						"showCanvasBorder": "0",
						"usePlotGradientColor": "0",
						"plotBorderAlpha": "10",
						"placeValuesInside": "1",
						"valueFontColor": "#ffffff",
						"showAxisLines": "1",
						"axisLineAlpha": "25",
						"divLineAlpha": "10",
						"alignCaptionWithCanvas": "0",
						"showAlternateVGridColor": "0",
						"captionFontSize": "14",
						"subcaptionFontSize": "14",
						"subcaptionFontBold": "0",
						"toolTipColor": "#ffffff",
						"toolTipBorderThickness": "0",
						"toolTipBgColor": "#000000",
						"toolTipBgAlpha": "80",
						"toolTipBorderRadius": "2",
						"toolTipPadding": "5"
					},
					
					"data": [
						{
							"label": "Bakersfield Central",
							"value": "880000"
						}, 
						{
							"label": "Garden Groove harbour",
							"value": "730000"
						}, 
						{
							"label": "Los Angeles Topanga",
							"value": "590000"
						}, 
						{
							"label": "Compton-Rancho Dom",
							"value": "520000"
						}, 
						{
							"label": "Daly City Serramonte",
							"value": "330000"
						}
					]
				}
			}).render();
			
		});
		
		
	',$this::POS_READY);
?>


