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
								'body'=> '<div id="chart-cust-parent" style="height:200px"></div> <div id="chart-Sales-compare"></div>',
							],
							Html::TYPE_INFO
						);
					?>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12 full-right">			
			<?php
				 echo Html::panel(
					[
						'heading' => 'SALES COMPARE',
						'body'=> '<div id="chart-Sales-compare"></div>',
					],
					Html::TYPE_INFO
				);
			?>
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
					caption: "Modern Parent Customers",
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
		 * GRAPH MODERN CUSTOMER PARENT VS SALES COMPARE
		 * @author piter [ptr.nov@gmail.com]
		 * @since 1.1
		*/
		$(document).ready(function () {
			var ChartSalesCompare = new FusionCharts({
				type: "msline",
				renderAt: "chart-Sales-compare",
				width: "100%",
				height: "80%",
				dataFormat: "json",
				dataSource: {
					"chart": {
						"caption": "Sales Compare",
						//"subCaption": "Customers Modern",
						//"subCaption": "Sales Compare",
						"captionFontSize": "14",
						"subcaptionFontSize": "14",
						"subcaptionFontBold": "0",
						"palettecolors": "#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",
						"bgcolor": "#ffffff",
						"showBorder": "1",
						"showShadow": "0",
						"showCanvasBorder": "0",
						"usePlotGradientColor": "0",
						"legendBorderAlpha": "0",
						"legendShadow": "0",
						"showAxisLines": "0",
						"showAlternateHGridColor": "0",
						"divlineThickness": "1",
						"divLineIsDashed": "1",
						"divLineDashLen": "1",
						"divLineGapLen": "1",
						"xAxisName": "Day",
						"showValues": "0", 
						"showXAxisLine": "1",
						"plotBorderAlpha": "10",
						borderAlpha: "20",
						bgColor: "#ffffff",
						usePlotGradientColor: "0",
						plotBorderAlpha: "10", 
						showAlternateHGridColor: "0",
						showXAxisLine: "1",
						
					},
					"categories": [
						{
							"category": [
								{ "label": "Mon" }, 
								{ "label": "Tue" }, 
								{ "label": "Wed" },
								{
									"vline": "true",
									"lineposition": "0",
									"color": "#6baa01",
									"labelHAlign": "center",
									"labelPosition": "0",
									"label": "National holiday",
									"dashed":"1"
								},
								{ "label": "Thu" }, 
								{ "label": "Fri" }, 
								{ "label": "Sat" }, 
								{ "label": "Sun" }
							]
						}
					],
					"dataset": [
						{
							"seriesname": "Bakersfield Central",
							"data": [
								{ "value": "15123" }, 
								{ "value": "14233" }, 
								{ "value": "25507" }, 
								{ "value": "9110" }, 
								{ "value": "15529" }, 
								{ "value": "20803" }, 
								{ "value": "19202" }
							]
						}, 
						{
							"seriesname": "Los Angeles Topanga",
							"data": [
								{ "value": "13400" }, 
								{ "value": "12800" }, 
								{ "value": "22800" }, 
								{ "value": "12400" }, 
								{ "value": "15800" }, 
								{ "value": "19800" }, 
								{ "value": "21800" }
							]
						}
					], 
					"trendlines": [
						{
							"line": [
								{
									"startvalue": "17022",
									"color": "#6baa01",
									"valueOnRight": "1",
									"displayvalue": "Average"
								}
							]
						}
					]
				}
			}).render();
		});
	',$this::POS_READY);
?>




