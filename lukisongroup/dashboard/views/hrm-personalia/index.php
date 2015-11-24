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

$this->sideCorp = 'PT. Lukisongroup';                                   	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_personalia';                                       	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'HRM - Personalia Dashboard');             		/* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                          	/* belum di gunakan karena sudah ada list sidemenu, on plan next*/

				
?>


<div id="dasboard-item" ng-app="ChartAllDashboardHrmPersonalia"  class="row">

	<div class="col-md-12" style="padding-left:25px; padding-right:25px">
		<div class="row">
			<div class="col-lg-3 col-md-6">
				<!-- Panel Bootstrap 1!-->
				<div class="panel panel-red">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-group fa-5x"></i>
							</div>
							
							<div class="col-xs-9 text-right">
								<div class="huge">26</div>
								<div>Total Employee</div>
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
								<i class="fa fa-file-photo-o   fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge">12</div>
								<div>Probation</div>
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
								<div class="huge">124</div>
								<div>Contract</div>
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
								<i class="fa fa-support fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge">13</div>
								<div>Tetap</div>
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
	<div  ng-controller="CtrlChart" class="col-md-12" style="padding-left:25px; padding-right:20px">
		<div class="row">
			<!-- Chart Line Sektor Support !-->
			<!--<div class="col-sm-6"  ng-init="load()">	!-->
			<div class="col-sm-6" >	
<!--
			 {{7+7}}
						 
			{{attrs_support}}			
			{{catg_support}}
			{{dataset_support}} 
				!-->
				<fusioncharts
					width= 100%,
					type="msline",
					chart='{{support_attrs}}',
					categories='{{support_catg}}',
					dataset='{{support_dataset}}'
				>
				</fusioncharts>			   
			</div>
			<!-- Chart Line Sektor Bisnis !-->
			<div class="col-sm-6">				
				<fusioncharts
					width= 100%
					type="msline"
					chart="{{bisnis_attrs}}"
					categories="{{bisnis_catg}}"
					dataset="{{bisnis_dataset}}"
				>
				</fusioncharts>					   
			</div>

		</div>
    </div>
	<div ng-controller="CtrlChart" class="col-md-12" style="padding-left:25px; padding-right:20px">
		<div class="row">
			<!--Chart Type Pie PT.Sarana Sinar Surya !-->
			<div class="col-sm-4">
				<fusioncharts 
					width="400" 
					height="300"
					type="pie3d",
					datasource="{{sss_pie_myDatasource}}"
				></fusioncharts>			
			</div>
			<!--Chart Type Pie PT.Arhta Lipat Ganda !-->
			<div class="col-sm-4">
				<fusioncharts 
					width="400" 
					height="300"
					type="pie3d",
					datasource="{{lipat_pie_myDatasource}}"
				></fusioncharts>			
			</div>
			<!--Chart Type Pie PT.Effembi Sukses Makmur !-->
			<div class="col-sm-4">
				<fusioncharts 
					width="400" 
					height="300"
					type="pie3d",
					datasource="{{esm_pie_myDatasource}}"
				></fusioncharts>			
			</div>
		</div>
	</div>
</div>	
	
	
	
				