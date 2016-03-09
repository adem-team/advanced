<?php
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use lukisongroup\assets\AppAssetFusionChart;
AppAssetFusionChart::register($this);
//use lukisongroup\dashboard\models\FusionCharts; 

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
							<div class="huge"><?php echo $count_CustPrn>0?$model_CustPrn[0]['COUNT_CUST']:0;?> </div>
							<div><?php echo $count_CustPrn>0?'Customers '.$model_CustPrn[0]['PARENT_NM']:'None';?></div>
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
			<div id="chart-container"><!-- Fusion Charts will render here--></div>
			<div id="chart-kue-customer"><!-- Fusion Charts will render here--></div>
			<div id="chart-piramid-customer"><!-- Fusion Charts will render here--></div>
			
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
			//height: '100%',			
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
",$this::POS_READY);
?>