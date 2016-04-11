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
			<div class="panel panel-warning">
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
		<div class="panel panel-danger text-center">
			<div class="panel-heading">
				<div class="row">			
						<!--<div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div>!-->
						<div ><h1><?php echo $count_CustPrn>1?$model_CustPrn[1]['COUNT_CUST']:0; ?></h1> </div>				
				</div>
			</div>
			<div class="panel-footer">Daily visits</div>			
		</div>
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
			<div id="chart-daily-visit"></div>		
				
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
	<div class="col-lg-12 col-md-12">
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
			<div id="chart-esm-stock-per-sku"><!-- Fusion Charts will render here--></div>
			
				
	</div>
</div>

<?php

print_r($dataEsmStockAll);

$this->registerJs('

	/* 
	 * GRAPH ESM ALL STOCK
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.1
	*/
	FusionCharts.ready(function () {
		var ratingsChart = new FusionCharts({
			type: "line",
			renderAt: "chart-daily-visit",
			width: "100%",
			height: "250",
			dataFormat: "json",
			dataSource: '.$dataEsmStockAll.'
		});

		ratingsChart.render();
	});
	
	
	/* 
	 * GRAPH ESM ALL STOCK PER SKU 
	 * @author piter ]ptr.nov@gmail.com]
	 * @since 1.1
	*/
	FusionCharts.ready(function () {
		var ratingsChart1 = new FusionCharts({
			type: "msline",
			renderAt: "chart-esm-stock-per-sku",
			width: "100%",
			height: "300",
			dataFormat: "json",
			dataSource: '.$graphEsmStockPerSku.'
		});

		ratingsChart1.render();
	});
	
	
',$this::POS_READY);
?>