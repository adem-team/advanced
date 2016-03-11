<?php
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use lukisongroup\assets\AppAssetFusionChart;
AppAssetFusionChart::register($this);
//use lukisongroup\dashboard\models\FusionCharts; 
$xaxis=88;
$canvasEndY=300;

?>

<div class="row" style="padding-left:15px; padding-right:15px;">
	<!-- KIRI !-->
	<div class="col-lg-4 col-md-4">
		<div class="row">		
			<!-- pie3d | KUE CHART!-->
			<div id="chart-kue"></div>			
			<div id="chart-msbar2d"></div>			
			<div id="chart-sparkwinloss"></div>			
		</div>
	</div>
	
	<div class="col-lg-4 col-md-4">
		<div class="row">
			<!-- column2d !-->
			<div id="chart-column2d"></div>			
			<div id="chart-bar2d"></div>			
			<div id="chart-column2d-x"></div>			
			<div id="chart-container-img"></div>			
		</div>
	</div>	
	
	<div class="col-lg-4 col-md-4">
		<div class="row">
			<!-- piramid !-->
			<div id="chart-piramid"></div>
			<div id="chart-stackedbar2d"></div>
			<div id="chart-msline"></div>
		</div>
	</div>
</div>

<?php
$this->registerJs("

	/*KUE CHART*/
	FusionCharts.ready(function () {
		var kueChartCustomer = new FusionCharts({
			type: 'pie3d',
			renderAt: 'chart-kue',
			width: '100%',
			height: '300',
			dataFormat: 'json',
			dataSource: {
				'chart': {
					'caption': 'Age profile of website visitors',
					'subCaption': 'Last Year',
					'startingAngle': '120',
					'showLabels': '0',
					'showLegend': '1',
					'enableMultiSlicing': '0',
					'slicingDistance': '15',
					//To show the values in percentage
					'showPercentValues': '1',
					'showPercentInTooltip': '0',
				   'theme': 'fint'
				},
				'data': [{
					'label': 'Teenage',
					'value': '1250400'
				}, {
					'label': 'Adult',
					'value': '1463300'
				}, {
					'label': 'Mid-age',
					'value': '1050700'
				}, {
					'label': 'Senior',
					'value': '491000'
				}]
			}
		});
		kueChartCustomer.render();
	});
	
	/*column2d*/
	FusionCharts.ready(function () {
		// Create a new instance of FusionCharts for rendering inside an HTML
		// `<div>` element with id `my-chart-container`.
		var myChart = new FusionCharts({
			type: 'column2d',
			width: '100%',
			//height: '100%',			
			renderAt: 'chart-column2d',
			dataFormat: 'json',
			dataSource: {
				chart: {
					caption: 'Harrys SuperMart',
					//subCaption: 'Top 5 stores in last month by revenue',
					subcaption: 'Daily Actual Total Stock sell-out',
					subcaptionFontBold: '0',
					subcaptionFontSize: '14',
					numberPrefix: '',
					yaxismaxvalue: '900000',
					
					borderAlpha: '20',
					bgColor: '#ffffff',
					usePlotGradientColor: '0',
					plotBorderAlpha: '10', 
					showAlternateHGridColor: '0',
					showXAxisLine: '1'						
				},
				data:[{
					label: 'Bakersfield Central',
					value: '880000'
				},
				{
					label: 'Garden Groove harbour',
					value: '730000'
				},
				{
					label: 'Los Angeles Topanga',
					value: '590000'
				},
				{
					label: 'Compton-Rancho Dom',
					value: '520000'
				},
				{
					label: 'Daly City Serramonte',
					value: '330000'
				}]
			}
		});
		// Render the chart.
		myChart.render();
	});
	
	
	/*piramid*/
	FusionCharts.ready(function () {
		var myPiramidChart = new FusionCharts({
			type: 'pyramid',
			width: '100%',
			//height: '100%',
			dataFormat: 'jsonurl',			
			renderAt: 'chart-piramid',
			dataFormat: 'json',
			dataSource: {
				chart: {
					theme: 'fint',
					caption: 'The Global Wealth Pyramid',
					captionOnTop: '0',
					captionPadding: '25',
					alignCaptionWithCanvas: '1',
					subcaption: 'Credit Suisse 2013',
					subCaptionFontSize: '12',
					borderAlpha: '20',
					is2D: '1',
					bgColor: '#ffffff',
					showValues: '1',
					showLegend: '1',
					numberPrefix: '$',
					numberSuffix: 'M',
					showPercentValues: '1',
					//chartLeftMargin: '40'
				},
				data: [
						  {
							 label: 'Top 32 mn (0.7%)',
							 value: '98.7'
						  },
						  {
							 label: 'Next 361 mn (7.7%)',
							 value: '101.8'
						  },
						  {
							 label: 'Next 1.1 bn (22.9%)',
							 value: '33'
						  },
						  {
							 label: 'Last 3.2 bn (68.7%)',
							 value: '7.3'
						  }
				   ]
			}
		});
		// Render the chart.
		myPiramidChart.render();
    });
	
	
	/*msbar2d | CUSTOMER DAERAH KONSUMSI RODAK TERBANYAK*/
	FusionCharts.ready(function () {
		var revenueChart = new FusionCharts({
			type: 'msbar2d',
			renderAt: 'chart-msbar2d',
			width: '100%',
			height: '420',
			dataFormat: 'json',
			dataSource: {
				'chart': {
					'caption': 'Split of Sales by Product Category',
					'subCaption': 'In top 5 stores last month',
					'yAxisname': 'Sales (In USD)',
					'numberPrefix': '$',
					'paletteColors': '#0075c2,#1aaf5d',
					'bgColor': '#ffffff',
					'showBorder': '0',
					'showHoverEffect':'1',
					'showCanvasBorder': '0',
					'usePlotGradientColor': '0',
					'plotBorderAlpha': '10',
					'legendBorderAlpha': '0',
					'legendShadow': '0',
					'placevaluesInside': '1',
					'valueFontColor': '#ffffff',
					'showXAxisLine': '1',
					'xAxisLineColor': '#999999',
					'divlineColor': '#999999',               
					'divLineIsDashed': '1',
					'showAlternateVGridColor': '0',
					'subcaptionFontBold': '0',
					'subcaptionFontSize': '14'
				},            
				'categories': [
					{
						'category': [
							{
								'label': 'Bakersfield Central'
							}, 
							{
								'label': 'Garden Groove harbour'
							}, 
							{
								'label': 'Los Angeles Topanga'
							}, 
							{
								'label': 'Compton-Rancho Dom'
							}, 
							{
								'label': 'Daly City Serramonte'
							}
						]
					}
				],            
				'dataset': [
					{
						'seriesname': 'Food Products',
						'data': [
							{
								'value': '17000'
							}, 
							{
								'value': '19500'
							}, 
							{
								'value': '12500'
							}, 
							{
								'value': '14500'
							}, 
							{
								'value': '17500'
							}
						]
					}, 
					{
						'seriesname': 'Non-Food Products',
						'data': [
							{
								'value': '25400'
							}, 
							{
								'value': '29800'
							}, 
							{
								'value': '21800'
							}, 
							{
								'value': '19500'
							}, 
							{
								'value': '11500'
							}
						]
					}
				],
				'trendlines': [
					{
						'line': [
							{
								'startvalue': '15000',
								'color': '#0075c2',
								'valueOnRight': '1',
								'displayvalue': 'Avg. for{br}Food'
							},
							{
								'startvalue': '22000',
								'color': '#1aaf5d',
								'valueOnRight': '1',
								'displayvalue': 'Avg. for{br}Non-food'
							}
						]
					}
				]
			}
		}).render();    
	});
	
	/*bar2d*/
	FusionCharts.ready(function () {
		var topStores = new FusionCharts({
			type: 'bar2d',
			renderAt: 'chart-bar2d',
			width: '100%',
			height: '300',
			dataFormat: 'json',
			dataSource: {
				'chart': {
					'caption': 'Top 5 Stores by Sales',
					'subCaption': 'Last month',
					'yAxisName': 'Sales (In USD)',
					'numberPrefix': '$',
					'paletteColors': '#0075c2',
					'bgColor': '#ffffff',
					'showBorder': '0',
					'showCanvasBorder': '0',
					'usePlotGradientColor': '0',
					'plotBorderAlpha': '10',
					'placeValuesInside': '1',
					'valueFontColor': '#ffffff',
					'showAxisLines': '1',
					'axisLineAlpha': '25',
					'divLineAlpha': '10',
					'alignCaptionWithCanvas': '0',
					'showAlternateVGridColor': '0',
					'captionFontSize': '14',
					'subcaptionFontSize': '14',
					'subcaptionFontBold': '0',
					'toolTipColor': '#ffffff',
					'toolTipBorderThickness': '0',
					'toolTipBgColor': '#000000',
					'toolTipBgAlpha': '80',
					'toolTipBorderRadius': '2',
					'toolTipPadding': '5'
				},
				
				'data': [
					{
						'label': 'Bakersfield Central',
						'value': '880000'
					}, 
					{
						'label': 'Garden Groove harbour',
						'value': '730000'
					}, 
					{
						'label': 'Los Angeles Topanga',
						'value': '590000'
					}, 
					{
						'label': 'Compton-Rancho Dom',
						'value': '520000'
					}, 
					{
						'label': 'Daly City Serramonte',
						'value': '330000'
					}
				]
			}
		})
		.render();
	});
	
",$this::POS_READY);

$this->registerJs("
	/*stackedbar2d*/
	FusionCharts.ready(function () {
		var revenueChart = new FusionCharts({
			type: 'stackedbar2d',
			renderAt: 'chart-stackedbar2d',
			width: '100%',
			height: '400',
			dataFormat: 'json',
			dataSource: {
				'chart': {
					'caption': 'Product-wise quarterly revenue in current year',
					'subCaption': 'Harrys SuperMart',
					'xAxisname': 'Quarter',
					'yAxisName': 'Revenue (In USD)',
					'numberPrefix': '$',
					'paletteColors': '#0075c2,#1aaf5d',
					'bgColor': '#ffffff',
					'borderAlpha': '20',
					'showCanvasBorder': '0',
					'usePlotGradientColor': '0',
					'plotBorderAlpha': '10',
					'legendBorderAlpha': '0',
					'legendShadow': '0',
					'valueFontColor': '#ffffff',                
					'showXAxisLine': '1',
					'xAxisLineColor': '#999999',
					'divlineColor': '#999999',               
					'divLineIsDashed': '1',
					'showAlternateVGridColor': '0',
					'subcaptionFontBold': '0',
					'subcaptionFontSize': '14',
					'showHoverEffect':'1'					
				},
				'categories': [
					{
						'category': [
							{
								'label': 'Q1'
							},
							{
								'label': 'Q2'
							},
							{
								'label': 'Q3'
							},
							{
								'label': 'Q4'
							}
						]
					}
				],
				'dataset': [
					{
						'seriesname': 'Food Products',
						'data': [
							{
								'value': '121000'
							},
							{
								'value': '135000'
							},
							{
								'value': '123500'
							},
							{
								'value': '145000'
							}
						]
					},
					{
						'seriesname': 'Non-Food Products',
						'data': [
							{
								'value': '131400'
							},
							{
								'value': '154800'
							},
							{
								'value': '98300'
							},
							{
								'value': '131800'
							}
						]
					}
				]
			}
		});
		revenueChart.render();		
	});	 
	
	/*sparkwinloss | WIN LOST*/
	 FusionCharts.ready(function () {
		var winLossChart = new FusionCharts({
			type: 'sparkwinloss',
			renderAt: 'chart-sparkwinloss',
			width: '100%',
			height: '300',
			dataFormat: 'json',
			dataSource: {
				'chart': {
					'theme': 'fint',
					'caption': 'Bobby Fischer (vs. Spassky)',
					'subcaption': 'World Chess Championship 1972',
					'subCaptionFontSize': '11',
					'numberPrefix': '$',
					'chartBottomMargin': '20',
					//Configuring win color (In this case success)
					'winColor': '#00cc33',
					//Configuring loss color (In this case failure)
					'lossColor': '#cc0000',
					//Configuring draw color
					'drawColor': '#0075c2'
				},
				'dataset': [
					{
						'data': [
							{ 'value': 'L' },
							{ 'value': 'L' },
							{ 'value': 'W' },
							{ 'value': 'D' },	
							{ 'value': 'W' },	
							{ 'value': 'W' },	
							{ 'value': 'D' },	
							{ 'value': 'W' },	
							{ 'value': 'D' },	
							{ 'value': 'W' },	
							{ 'value': 'L' },	
							{ 'value': 'D' },	
							{ 'value': 'W' },	
							{ 'value': 'D' },	
							{ 'value': 'D' },	
							{ 'value': 'D' },	
							{ 'value': 'D' },	
							{ 'value': 'D' },	
							{ 'value': 'D' },	
							{ 'value': 'D' },	
							{ 'value': 'W' }
						]
					}
				]
			}
		})
		.render();
	}); 
	
	/**/
	FusionCharts.ready(function () {
    var wVstrsChart = new FusionCharts({
        type: 'column2d',
        renderAt: 'chart-column2d-x',
        //id: 'myChart',
        width: '100%',
        height: '300',
        dataFormat: 'json',
        dataSource: {
            'chart': {
                'caption': 'Website Visitors WoW Growth',
                'subcaption': 'Last 10 weeks',
                'xAxisName': 'Week',
                'yAxisName': 'Growth',
                'numberSuffix': '%',
                'theme': 'fint',
                'showValues': '0',
                //Show Zero plane
                'showZeroPlane': '1',                                
                //Customize Zero Plane Properties 
                'zeroPlaneColor':'#003366',
                'zeroPlaneAlpha': '100',
                'zeroPlaneThickness': '3',
                'divLineIsDashed': '0',
                'divLineAlpha': '40'
            },
            'data': [
                {
                    'label': 'Week 1',
                    'value': '14.5'
                }, 
                {
                    'label': 'Week 2',
                    'value': '-6.5'
                }, 
                {
                    'label': 'Week 3',
                    'value': '9.8'
                }, 
                {
                    'label': 'Week 4',
                    'value': '9.2'
                }, 
                {
                    'label': 'Week 5',
                    'value': '-7.45'
                }, 
                {
                    'label': 'Week 6',
                    'value': '-3.19'
                }, 
                {
                    'label': 'Week 7',
                    'value': '-11.78'
                }, 
                {
                    'label': 'Week 8',
                    'value': '3.32'
                }, 
                {
                    'label': 'Week 9',
                    'value': '8.57'
                }, 
                {
                    'label': 'Week 10',
                    'value': '16.95'
                }
            ]
        }
    }).render();
});
	
	/*msline | SALES*/
FusionCharts.ready(function () {
    var visitChart = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-msline',
		width: '100%',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            'chart': {
                'caption': 'Number of visitors last week',
                'subCaption': 'Bakersfield Central vs Los Angeles Topanga',
                'captionFontSize': '14',
                'subcaptionFontSize': '14',
                'subcaptionFontBold': '0',
                'paletteColors': '#0075c2,#1aaf5d',
                'bgcolor': '#ffffff',
                'showBorder': '0',
                'showShadow': '0',
                'showCanvasBorder': '0',
                'usePlotGradientColor': '0',
                'legendBorderAlpha': '0',
                'legendShadow': '0',
                'showAxisLines': '0',
                'showAlternateHGridColor': '0',
                'divlineThickness': '1',
                'divLineIsDashed': '1',
                'divLineDashLen': '1',
                'divLineGapLen': '1',
                'xAxisName': 'Day',
                'showValues': '0'               
            },
            'categories': [
                {
                    'category': [
                        { 'label': 'Mon' }, 
                        { 'label': 'Tue' }, 
                        { 'label': 'Wed' },
                        {
                            'vline': 'true',
                            'lineposition': '0',
                            'color': '#6baa01',
                            'labelHAlign': 'center',
                            'labelPosition': '0',
                            'label': 'National holiday',
                            'dashed':'1'
                        },
                        { 'label': 'Thu' }, 
                        { 'label': 'Fri' }, 
                        { 'label': 'Sat' }, 
                        { 'label': 'Sun' }
                    ]
                }
            ],
            'dataset': [
                {
                    'seriesname': 'Bakersfield Central',
                    'data': [
                        { 'value': '15123' }, 
                        { 'value': '14233' }, 
                        { 'value': '25507' }, 
                        { 'value': '9110' }, 
                        { 'value': '15529' }, 
                        { 'value': '20803' }, 
                        { 'value': '19202' }
                    ]
                }, 
                {
                    'seriesname': 'Los Angeles Topanga',
                    'data': [
                        { 'value': '13400' }, 
                        { 'value': '12800' }, 
                        { 'value': '22800' }, 
                        { 'value': '12400' }, 
                        { 'value': '15800' }, 
                        { 'value': '19800' }, 
                        { 'value': '21800' }
                    ]
                }
            ], 
            'trendlines': [
                {
                    'line': [
                        {
                            'startvalue': '17022',
                            'color': '#6baa01',
                            'valueOnRight': '1',
                            'displayvalue': 'Average'
                        }
                    ]
                }
            ]
        }
    }).render();
});
	

	
	
",$this::POS_READY);











?>