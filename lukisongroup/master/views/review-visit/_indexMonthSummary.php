<?php
use kartik\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\detail\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
//use kartik\editable\Editable;
use kartik\grid\GridView;
use kartik\tabs\TabsX;
use kartik\money\MaskMoney;
use lukisongroup\assets\Profile;
Profile::register($this);
use lukisongroup\assets\AppAssetDahboardDatamaster;
AppAssetDahboardDatamaster::register($this);
?>

<div class="container-fluid w3-content pale-blue" style="max-width:1400px;margin-top:10px;font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<!-- The Grid -->
	<div class="row">
		<!-- Left Column -->
		<div class="col-lg-3">
			<!-- Profile -->
			<div class="w3-card-2 w3-round w3-pale-blue">
				<div class="w3-container">
					 <h4 class="w3-center">My Profile</h4>
					 <p class="w3-center"><img src="http://lukisongroup.com/addasset/profile/img_avatar3.png" class="w3-circle" style="height:106px;width:106px" alt="Avatar"></p>
					 <hr>
					 <p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> Designer, UI</p>
					 <p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> London, UK</p>
					 <p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i> April 1, 1988</p>
				</div>
			</div>
			<br>
		</div>  
		<div class="col-lg-9">
			<span class="w3-right w3-opacity">4 week</span><br>
			<hr class="w3-clear">
			<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
				<!-- NOO!-->
				<div class="panel w3-red">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6 col-lg-3 col-md-3">
								<i class="fa fa-group fa-2x"></i>
							</div>							
							<div class="col-xs-12 col-lg-12 col-md-12 text-right">
								<!-- <div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div> !-->
								<?php echo $cntAktifEmp!=''? $cntAktifEmp:'0';; ?> 								
								<div>NOO - New Outlet</div>
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
			<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
				<!-- NOO!-->
				<div class="panel w3-yellow">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6 col-lg-3 col-md-3">
								<i class="fa fa-cubes fa-2x"></i>
							</div>							
							<div class="col-xs-12col-lg-12 col-md-12 text-right">
								<!-- <div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div> !-->
								<?php echo $cntAktifEmp!=''? $cntAktifEmp:'0'; ?> 								
								<div>Sales Target</div>
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
			<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
				<!-- NOO!-->
				<div class="panel w3-blue-grey">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6 col-lg-3 col-md-3">
								<i class="fa fa-volume-control-phone fa-2x"></i>
							</div>							
							<div class="col-xs-12 col-lg-12 col-md-12 text-right">
								<!-- <div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div> !-->
								<?php echo $cntAktifEmp!=''? $cntAktifEmp:'0';; ?> 								
								<div>Call Rate</div>
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
			<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
				<!-- NOO!-->
				<div class="panel panel-green">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6 col-lg-3 col-md-3">
								<i class="fa fa-file-image-o fa-2x"></i>
							</div>							
							<div class="col-xs-12col-lg-12 col-md-12 text-right">
								<!-- <div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div> !-->
								<?php echo $cntAktifEmp!=''? $cntAktifEmp:'0';; ?> 								
								<div>Product Display</div>
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
	<div class="col-lg-12">
			asdsa
	  <div>
	<div class="row">
		<!-- Left Column -->
		<div class="col-lg-3">
		asd
		</div>
	</div>
</div> 
	  