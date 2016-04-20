<?php
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
/* use dashboard\assets\AppAssetLazyLoad;
AppAssetLazyLoad::register($this); */
use dashboard\assets\AppAssetFusionChart;
AppAssetFusionChart::register($this);

//use lukisongroup\dashboard\models\FusionCharts; 

// $xaxis=0;
// $canvasEndY=200;

global $xaxis;
global $canvasEndY;
	$valCustAll=$count_CustPrn>0?$model_CustPrn[0]['COUNT_ALL_CUST']:0;
	$valCustModern=$count_CustPrn>0?$model_CustPrn[1]['COUNT_CUST']:0;
	$valCustGeneral=$count_CustPrn>0?$model_CustPrn[2]['COUNT_CUST']:0;
	$valCustHoreca=$count_CustPrn>0?$model_CustPrn[3]['COUNT_CUST']:0;
	$valCustOther=$count_CustPrn>0?$model_CustPrn[4]['COUNT_CUST']:0;
?>

<div id="xxx" class="row" style="padding-left:15px; padding-right:15px;">
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
							<div id="cust-all-id" class="huge"><h2></h2></div>
							<div><?php echo 'All Customers';?></div>
						</div>
					</div>
				</div>
				<a href="/efenbi/customer-all">
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
							<div  id="cust-medern-id" class="huge"><h2><?php //echo $count_CustPrn>0?$model_CustPrn[1]['COUNT_CUST']:0; ?><h2></div>
							<div><?php echo $count_CustPrn>0? $model_CustPrn[1]['PARENT_NM']:'None'; ?></div>
						</div>
					</div>
				</div>
				<a href="/efenbi/customer-modern">
					<div class="panel-footer">
						<span class="pull-left">Modern Details</span>
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
							<div  id="cust-general-id" class="huge"><h4><?php //echo $count_CustPrn>0?$model_CustPrn[2]['COUNT_CUST']:0; ?> <h4></div>
							<div><?php echo $count_CustPrn>1? $model_CustPrn[2]['PARENT_NM']:'None';?></div>
						</div>
					</div>
				</div>
				<a href="/efenbi/customer-general">
					<div class="panel-footer">
						<span class="pull-left">General Details</span>
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
						<!--<div class="col-lg-6 col-md-6 text-center"  id="cnt-visit-tes"><h1><?php //echo $CntrVisit; ?></h1> </div>
						<div class="col-lg-6 col-md-6 text-center"  id="cnt-visit-tes"><h1><?php //echo $CntrVisit; ?></h1> </div>!-->
						<div id="cnt-sales-visits-id"><h1><B><?php echo $CntrVisit; ?></B></h1> </div>							
				</div>
			</div>
			<div class="panel-footer"><b>DAILY VISIT</b></div>			
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
			<a class="btn btn-warning btn-xs" href="/efenbi/review-visit">Detail >></a>	
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
							<div  id="cust-horeca-id" class="huge"><h4><?php //echo $count_CustPrn>0?$model_CustPrn[3]['COUNT_CUST']:0; ?></h4></div>
							<div><?php echo $count_CustPrn>2? $model_CustPrn[3]['PARENT_NM']:'None'; ?></div>
						</div>
					</div>
				</div>
				<a href="/efenbi/customer-horeca">
					<div class="panel-footer">
						<span class="pull-left">Horeca Details</span>
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
							<div id="cust-other-id" class="huge"><h4><?php //echo $model_CustPrn[4]['COUNT_CUST']!=''?$model_CustPrn[4]['COUNT_CUST']:0; ?> </h4></div>
							<div><?php echo 'Others';?></div>
						</div>
					</div>
				</div>
				<a href="/efenbi/customer-other">
					<div class="panel-footer">
						<span class="pull-left">Others Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
			<!-- SALESMAN!-->
			<div class="panel " style="background-color:rgba(174, 255, 0, 0.6)">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-3">
							<i class="fa fa-cubes fa-4x"></i>
						</div>						
						<div class="col-lg-9 text-right">
							<!--<div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div>!-->
							<div class="huge"><h4><?php echo $count_CustPrn>2?$model_CustPrn[2]['COUNT_CUST']:0; ?></h4></div>
							<div><?php $count_CustPrn>2? 'Salesman '.$model_CustPrn[2]['PARENT_NM']:'None'; ?></div>
						</div>
					</div>
				</div>
				<a href="/efenbi/review-salesman">
					<div class="panel-footer">
						<span class="pull-left">Salesman Details</span>
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

$this->registerJs('
	/* 
	 * GRAPH ESM ALL STOCK
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.1
	*/
	$(document).ready(function () {
		
		var data = '.$graphSchaduleWinLoss.';
		 if(FusionCharts("chart-visit-cnt-id")){
			FusionCharts("chart-visit-cnt-id").dispose();
		}  
		var ratingsChart = new FusionCharts({
			id: "chart-visit-cnt-id",
			//type: "line",
			type: "column2d",
			renderAt: "chart-daily-visit",
			width: "100%",
			height: "250",
			//updateInterval:"5",
			//refreshInterval:"5",
			dataFormat: "json",
			dataSource: {
				"chart": {				
					caption: "VISIT PROCESS",           
					// theme: "fint",					 
					showValues: "1",
					showZeroPlane: "1",       
					paletteColors: "#FF0033,#0B2536,#0075c2,#9E466B,#C5E323",
					usePlotGradientColor: "0",					
					zeroPlaneColor:"#003366",
					zeroPlaneAlpha: "100",
					zeroPlaneThickness: "3",
					divLineIsDashed: "1",
					divLineAlpha: "40",
					xAxisName: "time",
					yAxisName: "Visit",
					showValues: "1" , 			//MENAMPILKAN VALUE 
					showBorder: "1", 				//Border side Out 
					showCanvasBorder: "0",		//Border side inside
					//paletteColors: "#0075c2",	// WARNA GARIS	
					showAlternateHGridColor: "0",	//
					bgcolor: "#ffffff"
			    }, 
				"dataset": [{
					 "data":data
				}],              
			},
			

		});

		ratingsChart.render();
	}); 
	
	
	
	
	
',$this::POS_READY);
?>