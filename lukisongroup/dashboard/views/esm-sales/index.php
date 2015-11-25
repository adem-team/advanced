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
use lukisongroup\assets\AppAssetDahboardEsmSales;
AppAssetDahboardEsmSales::register($this);

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_sales';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/
?>

<div id="dasboard-item"  ng-app="ChartAllDashboardEsmSales" ng-controller="CtrlChart"class="row">

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
								<div class="huge" ng-repeat="nilai in Sales_Summary">{{nilai.sales_mt}}</div>
								<div>MT Customer Sell</div>
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
								<div class="huge" ng-repeat="nilai in Sales_Summary">{{nilai.sales_gt}}</div>
								<div>GT Customer Sell</div>
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
								<div class="huge" ng-repeat="nilai in Sales_Summary">{{nilai.sales_horeca}}</div>
								<div>Horeca Customer Sell</div>
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
								<div class="huge" ng-repeat="nilai in Sales_Summary">{{nilai.sales_other}}</div>
								<div>Other Sell</div>
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
			<!-- Chart column2d PT.Effembi Sukses Makmur - Sell-Out MT !-->
			<div class="col-sm-6">	
				<fusioncharts 
					width= 100%
					type="column2d"
					datasource="{{SalesItem_Mt}}"
				>
				</fusioncharts>				   
			</div>
			<!-- Chart column2d PT.Effembi Sukses Makmur - Sell-Out GT !-->
			<div class="col-sm-6">	
				<fusioncharts 
					width= 100%
					type="column2d"
					datasource="{{SalesItem_Gt}}"
				>
				</fusioncharts>				   
			</div>

		</div>
    </div>	
	<div class="col-md-12" style="padding-left:25px; padding-right:20px">
		<div class="row">
			<!-- Chart column2d PT.Effembi Sukses Makmur - Sell-Out Horeca!-->
			<div class="col-sm-6">	
				<fusioncharts 
					width= 100%
					type="column2d"
					datasource="{{SalesItem_Horeca}}"
				>
				</fusioncharts>				   
			</div>
			<!-- Chart column2d PT.Effembi Sukses Makmur - Sell-Out Others !-->
			<div class="col-sm-6">	
				<fusioncharts 
					width= 100%
					type="column2d"
					datasource="{{SalesItem_Others}}"
				>
				</fusioncharts>				   
			</div>

		</div>
    </div>	
</div>	