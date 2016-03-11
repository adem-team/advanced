<?php
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use lukisongroup\assets\AppAssetFusionChart;
AppAssetFusionChart::register($this);
//use lukisongroup\dashboard\models\FusionCharts; 

// $xaxis=0;
// $canvasEndY=200;

global $xaxis;
global $canvasEndY;


?>

<div class="row" style="padding-left:15px; padding-right:15px;">
	<!-- KIRI !-->
	<div class="col-lg-3 col-md-3">
		<div class="row">		
			<!-- CUSTOMER TTL 1!-->
			<div class="panel  panel-green">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-3">
							<i class="fa fa-users fa-4x"></i>
						</div>
						
						<div class="col-lg-9 text-right">
							<!--<div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div>!-->
							<div class="huge"><?php echo $count_CustPrn>0?$model_CustPrn[0]['COUNT_ALL_CUST']:0;?> </div>
							<div><?php echo 'All Customers';?></div>
						</div>
					</div>
				</div>
				<a href="/master/barang">
					<div class="panel-footer">
						<span class="pull-left">View Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
			<!-- MODERN !-->
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-3">
							<i class="fa fa-list-alt fa-4x"></i>
						</div>
						
						<div class="col-lg-9 text-right">
							<!--<div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div>!-->
							<div class="huge"><?php echo $count_CustPrn>0?$model_CustPrn[0]['COUNT_CUST']:0; ?> </div>
							<div><?php echo $count_CustPrn>0?'Customers '.$model_CustPrn[0]['PARENT_NM']:'None'; ?></div>
						</div>
					</div>
				</div>
				<a href="/master/barangumum">
					<div class="panel-footer">
						<span class="pull-left">View Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
			<!-- GENERAL!-->
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-3">
							<i class="fa fa-exchange  fa-4x"></i>
						</div>
						
						<div class="col-lg-9 text-right">
							<!--<div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div>!-->
							<div class="huge"><?php echo $count_CustPrn>1?$model_CustPrn[1]['COUNT_CUST']:0; ?> </div>
							<div><?php echo $count_CustPrn>1? 'Customers '.$model_CustPrn[1]['PARENT_NM']:'None';?></div>
						</div>
					</div>
				</div>
				<a href="/master/unitbarang">
					<div class="panel-footer">
						<span class="pull-left">View Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
	</div>
	<!-- TENGAH !-->
	<div class="col-lg-6 col-md-6">
		<!-- <div class="panel panel-yellow">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-bar-chart fa-3x"></i>
						</div>
						<div class="col-xs-9 text-right">
							
							<div>Sales</div>
						</div>
					</div>
				</div>
				<a href="/master/unitbarang">
					<div class="panel-footer">
						<span class="pull-left">View Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
		</div>
			<div id="chart-container">Fusion Charts will render here</div>-->
			<div id="chart-chips-month"><!-- Fusion Charts will render here--></div>
			<div id="chart-container1"><!-- Fusion Charts will render here--></div>
			<div id="chart-image1"><!-- Fusion Charts will render here--></div>
			
			
	</div>
	
	<!-- KANAN !-->
	<div class="col-lg-3 col-md-3">
		<div class="row">		
			<!-- HORECA!-->
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-3">
							<i class="fa fa-cutlery fa-4x"></i>
						</div>
						
						<div class="col-lg-9 text-right">
							<!--<div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div>!-->
							<div class="huge"><?php echo $count_CustPrn>2?$model_CustPrn[2]['COUNT_CUST']:0; ?> </div>
							<div><?php echo $count_CustPrn>2? 'Customers '.$model_CustPrn[2]['PARENT_NM']:'None'; ?></div>
						</div>
					</div>
				</div>
				<a href="/master/unitbarang">
					<div class="panel-footer">
						<span class="pull-left">View Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
			<!-- OTHER!-->
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-3">
							<i class="fa fa-link fa-4x"></i>
						</div>
						
						<div class="col-lg-9 text-right">
							<!--<div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div>!-->
							<div class="huge"><?php echo $count_CustPrn>2?$model_CustPrn[2]['COUNT_CUST']:0; ?> </div>
							<div><?php echo $count_CustPrn>2? 'Customers '.$model_CustPrn[2]['PARENT_NM']:'None'; ?></div>
						</div>
					</div>
				</div>
				<a href="/master/unitbarang">
					<div class="panel-footer">
						<span class="pull-left">View Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
			<!-- PRODAK SKU!-->
			<div class="panel " style="background-color:rgba(174, 255, 0, 0.6)">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-3">
							<i class="fa fa-cubes fa-4x"></i>
						</div>
						
						<div class="col-lg-9 text-right">
							<!--<div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div>!-->
							<div class="huge"><?php echo $count_CustPrn>2?$model_CustPrn[2]['COUNT_CUST']:0; ?> </div>
							<div><?php $count_CustPrn>2? 'Customers '.$model_CustPrn[2]['PARENT_NM']:'None'; ?></div>
						</div>
					</div>
				</div>
				<a href="/master/unitbarang">
					<div class="panel-footer">
						<span class="pull-left">View Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>

<?php
$this->registerJs("
FusionCharts.ready(function () {
    var kueChartCustomer = new FusionCharts({
			type: 'pie3d',
			renderAt: 'chart-kue-customer',
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

	FusionCharts.ready(function () {
		// Create a new instance of FusionCharts for rendering inside an HTML
		// `<div>` element with id `my-chart-container`.
		var myChart = new FusionCharts({
			type: 'column2d',
			width: '100%',
			height: '250',			
			renderAt: 'chart-container',
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
	
	
	/*PIRAMID*/
	FusionCharts.ready(function () {
		var myPiramidChart = new FusionCharts({
			type: 'pyramid',
			//width: '100%',
			//height: '100%',
			dataFormat: 'jsonurl',			
			renderAt: 'chart-piramid-customer',
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
	
	
	/* BARANG ESM | chart-chips-month*/
	FusionCharts.ready(function () {
    var revenueChart = new FusionCharts({
        type: 'line',
        renderAt: 'chart-chips-month',
        width: '100%',
        height: '300',
        dataFormat: 'json',
        dataSource: {
            'chart': {
                'caption': 'Top 5 Chips Brands Of The Month',
               // 'subCaption': 'Last Year',
				'caption': 'Top Employees',
                'subcaption': 'Last six months',
                'xAxisName': 'Month',
                'yAxisName': 'Rating',
                'yaxisminvalue': '0',
                'yaxismaxvalue': '10',
                //'yAxisValuesPadding': '10',
                //'valuePosition' : 'above',
                //'numDivlines': '5',
                //'lineAlpha': '1',
               // 'anchorAlpha': '50',
                //Theme
                'theme':'fint'                
            },
            
            'data': [
                {
                    'label': 'cassava_chips0',
                    'value': '10	',
					'displayValue' :'Martha, 6.7',
                    'tooltext' :'December : Martha, 6.7',
					'anchorImageUrl':'http://lukisongroup.com/img_setting/graph/casava_cracker2.png',
                }, 
                {
                    'label': 'cassava_chips1',
                    'value': '87000',
					'displayValue' :'Martha, 6.7',
                    'tooltext' :'December : Martha, 6.7',
					'anchorImageUrl':'http://lukisongroup.com/img_setting/graph/casava_cracker2.png'
                }, 
                {
                    'label': 'cassava_chips2',
                    'value': '83000',
					'displayValue' :'Martha, 6.7',
                    'tooltext' :'December : Martha, 6.7',
					'anchorImageUrl':'http://lukisongroup.com/img_setting/graph/casava_cracker2.png'
                }, 
                {
                    'label': 'cassava_chips3',
                    'value': '80000',
					'displayValue' :'Martha, 6.7',
                    'tooltext' :'December : Martha, 6.7',
					'anchorImageUrl':'http://lukisongroup.com/img_setting/graph/casava_cracker2.png'
                }
            ]
        }
    }).render();
});
	
	FusionCharts.ready(function () {
    var ratingsChart = new FusionCharts({
        type: 'line',
        renderAt: 'chart-container1',
        width: '500',
        height: '300',
        dataFormat: 'json',
        dataSource: {
            'chart': {
                'caption': 'Top Employees',
                'subcaption': 'Last six months',
                'xAxisName': 'Month',
                'yAxisName': 'Rating',
                'yaxisminvalue': '0',
                'yaxismaxvalue': '10',
                'yAxisValuesPadding': '15',
                'valuePosition' : 'below',
                'numDivlines': '5',
                'lineAlpha': '1',
                'anchorAlpha': '100',
                //Theme
                'theme':'fint'
            },
            'data': [
                {
                    'label': 'July',
                    'value': '7.8',
                    'displayValue' :'John, 7.8',
                    'tooltext' :'July : John, 7.8',
                    'anchorImageUrl':'http://static.fusioncharts.com/sampledata/userimages/1.png'
                    
                }, 
                {
                    'label': 'August',
                    'value': '6.9',
                    'displayValue' :'Mac, 6.9',
                    'tooltext' :'August : Mac, 6.9',
                   	'anchorImageUrl':'http://lukisongroup.com/img_setting/graph/casava_cracker2.png'
                }, 
                {
                    'label': 'September',
                    'value': '8',
                    'displayValue' :'Phillips, 8',
                    'tooltext' :'September : Phillips, 8',
                    'anchorImageUrl':'http://static.fusioncharts.com/sampledata/userimages/3.png'
                }, 
                {
                    'label': 'October',
                    'value': '7.5',
                    'displayValue' :'Terrin, 7.5',
                    'tooltext' :'October : Terrin, 7.5',
                    'anchorImageUrl':'http://static.fusioncharts.com/sampledata/userimages/4.png'
                }, 
                {
                    'label': 'November',
                    'value': '7.7',
                    'displayValue' :'Tom, 7.7',
                    'tooltext' :'November : Tom, 7.7',
                    'anchorImageUrl':'http://static.fusioncharts.com/sampledata/userimages/5.png'
                }, 
                {
                    'label': 'December',
                    'value': '6.7',
                    'displayValue' :'Martha, 6.7',
                    'tooltext' :'December : Martha, 6.7',
                    'anchorImageUrl':'http://static.fusioncharts.com/sampledata/userimages/6.png'
                }
            ]
        }
    });

    ratingsChart.render();
});
	
FusionCharts.ready(function () {
    var revenueChart = new FusionCharts({
        type: 'column2d',
        renderAt: 'chart-image1',
        width: '400',
        height: '300',
        dataFormat: 'json',
        dataSource: {
            'chart': {
                'caption': 'Top 4 Chocolate Brands Sold',
                'subCaption': 'Last Year',
                'xAxisName': 'Brand',
                'yAxisName': 'Amount (In USD)',
                'yAxisMaxValue': '120000',
                'numberPrefix': '$',
                'theme': 'fint',
                'PlotfillAlpha' :'0',
                'placeValuesInside' : '0',
                'rotateValues' : '0',
				'showValues': '0',
                'valueFontColor' : '#333333'
                
            },
            'annotations': {
                'width': '500',
                'height': '300',
                'autoScale': '1',
                'groups': [
                    {
                        'items': [
                            {
                                'id': 'butterFinger-icon',
                                'type': 'image',
                                'url': 'http://lukisongroup.com/img_setting/graph/CASSAVA_CHIPS.png',
                                'x': '$xaxis.label.0.x- 30',
                                'y': '$canvasEndY - 150',
                                'xScale' : '50',
                                'yScale' : '40',
                            },
                            {
                                'id': 'tom-user-icon',
                                'type': 'image',
                                'url': 'http://lukisongroup.com/img_setting/graph/CASSAVA_CHIPS.png',
                                'x': '$xaxis.label.1.x - 26',
                                'y': '$canvasEndY - 141',
                                'xScale' : '48',
                                'yScale' : '38'
                            },
                            {
                                'id': 'Milton-user-icon',
                                'type': 'image',
                                'url': 'http://lukisongroup.com/img_setting/graph/CASSAVA_CHIPS.png',
                                'x': '$xaxis.label.2.x - 22',
                                'y': '$canvasEndY - 134',
                                'xScale' : '43',
                                'yScale' : '36'
                            },
                            {
                                'id': 'Brian-user-icon',
                                'type': 'image',
                                'url': 'http://lukisongroup.com/img_setting/graph/CASSAVA_CHIPS.png',
                                'x': '$xaxis.label.3.x - 22',
                                'y': '$canvasEndY - 131',
                                'xScale' : '43',
                                'yScale' : '35'
                            }
                        ]
                    }
                ]
            },
            'data': [
                {
                    'label': 'Butterfinger',
                    'value': '92000'
                }, 
                {
                    'label': 'Snickers',
                    'value': '87000'
                }, 
                {
                    'label': 'Coffee Crisp',
                    'value': '83000'
                }, 
                {
                    'label': '100 Grand',
                    'value': '80000'
                }
            ]
        }
    }).render();
});
	
	
	
	
	
	
	
	
	
	
	
	
",$this::POS_READY);
?>