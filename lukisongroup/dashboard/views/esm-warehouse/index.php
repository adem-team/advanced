<?php
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use app\models\hrd\Dept;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;
use lukisongroup\assets\AppAssetDahboardEsmWarehouse;
AppAssetDahboardEsmWarehouse::register($this);

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                           /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_warehouse';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Warehouse Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                          /* belum di gunakan karena sudah ada list sidemenu, on plan next*/
?>

<div id="dasboard-item"  ng-app="ChartAllDashboardEsmWh" ng-controller="CtrlChartEsmWh"class="row">

	<div class="col-md-12" style="padding-left:25px; padding-right:25px">
		<div class="row">
			<div class="col-lg-3 col-md-6">
				<!-- Panel Bootstrap 1!-->
				<div class="panel panel-green">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-group fa-5x"></i>
							</div>							
							<div class="col-xs-9 text-right">
								<div class="huge" ng-repeat="nilai in Wh_Summary">{{nilai.stock_factory}}</div>
								<div>Factory Stock</div>
							</div>
						</div>
					</div>
					<a href="#">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<!-- Panel Bootstrap 2!-->
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-yellow">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-file-photo-o   fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge" ng-repeat="nilai in Wh_Summary">{{nilai.stock_distributor}}</div>
								<div>Distributor Stock</div>
							</div>
						</div>
					</div>
					<a href="#">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<!-- Panel Bootstrap 3!-->
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-shopping-cart fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge" ng-repeat="nilai in Wh_Summary">{{nilai.stock_subdist}}</div>
								<div>SubDistributor Stock</div>
							</div>
						</div>
					</div>
					<a href="#">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<!-- Panel Bootstrap 4!-->
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-red">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-support fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge" ng-repeat="nilai in Wh_Summary">{{nilai.stock_customer}}</div>
								<div>Customer Stock</div>
							</div>
						</div>
					</div>
					<a href="#">
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
	<div class="col-md-12" style="padding-left:25px; padding-right:20px">
		<div class="row">
			<!-- Chart column2d PT.Effembi Sukses Makmur - Pabrik Gudang !-->
			<div class="col-sm-6">			
				<fusioncharts 
					width= 100%
					type="column2d"
					datasource="{{WhFactoryItem}}"
				>
				</fusioncharts>				   
			</div>
			<!-- Chart column2d PT.Effembi Sukses Makmur - Distributor Gudang !-->
			<div class="col-sm-6">	
				<fusioncharts 
					width= 100%
					type="column2d"
					datasource="{{WhDistributorItem}}"
				>
				</fusioncharts>				   
			</div>

		</div>
    </div>	
	<div class="col-md-12" style="padding-left:25px; padding-right:20px">
		<div class="row">
			<!-- Chart column2d PT.Effembi Sukses Makmur - Subdisk Gudang !-->
			<div class="col-sm-6">	
				<fusioncharts 
					width= 100%
					type="column2d"
					datasource="{{WhSubdistItem}}"
				>
				</fusioncharts>				   
			</div>
			<!-- Chart column2d PT.Effembi Sukses Makmur - Customer Gudang !-->
			<div class="col-sm-6">	
				<fusioncharts 
					width= 100%
					type="column2d"
					datasource="{{WhCustomerItem}}"
				>
				</fusioncharts>				   
			</div>

		</div>
    </div>	
</div>	