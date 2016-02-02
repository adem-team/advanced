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
use lukisongroup\assets\AppAssetDahboardHrmPersonalia;
AppAssetDahboardHrmPersonalia::register($this);
//use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
//AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/

$this->sideCorp = 'PT.Lukisongroup';                          /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'umum_datamaster';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'LG - Barang Umum Dashboard');          /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

				
?>


<div class="row" style="padding-left:15px; padding-right:15px; height:500px">
	<div class="col-lg-3 col-md-6">
		<!-- Panel Bootstrap 1!-->
		<div class="panel panel-red">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-group fa-2x"></i>
					</div>
					
					<div class="col-xs-9 text-right">
						<!--<div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div>!-->
						50
						<div>Items Product</div>
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
		<div class="panel panel-green">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-file-photo-o fa-2x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<!--<div class="huge" ng-repeat="nilai in Employe_Summary">{{nilai.emp_probation}}</div>!-->100
						<div>Items Umum</div>
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
						<i class="fa fa-shopping-cart fa-2x"></i>
					</div>
					<div class="col-xs-9 text-right">
					100
						<div>Items Type</div>
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
		<div class="panel panel-yellow">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-support fa-2x"></i>
					</div>
					<div class="col-xs-9 text-right">
					100
						<div>Items Category</div>
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
	<div class="col-md-12" ng-app="ChartAllDashboardHrmPersonalia" ng-controller="CtrlChart">
		<!--Chart Type Pie PT.Sarana Sinar Surya !-->
		<div class="col-sm-3">
			<fusioncharts 
				width="270" 
				height="300"
				type="pie3d",
				datasource="{{sss_pie_myDatasource}}"
			></fusioncharts>			
		</div>
		<!--Chart Type Pie PT.Arhta Lipat Ganda !-->
		<div class="col-sm-3">
			<fusioncharts 
				width="270" 
				height="300"
				type="pie3d",
				datasource="{{lipat_pie_myDatasource}}"
			></fusioncharts>			
		</div>
		<!--Chart Type Pie PT.Effembi Sukses Makmur !-->
		<div class="col-sm-3">
			<fusioncharts 
				width="270" 
				height="300"
				type="pie3d",
				datasource="{{esm_pie_myDatasource}}"
			></fusioncharts>			
		</div>
		<!--Chart Type Pie PT.Effembi Sukses Makmur !-->
		<div class="col-sm-3">
			<fusioncharts 
				width="270" 
				height="300"
				type="pie3d",
				datasource="{{esm_pie_myDatasource}}"
			></fusioncharts>			
		</div>
	</div>
</div>
