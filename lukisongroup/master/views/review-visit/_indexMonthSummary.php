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
	<div class="w3-row">
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
		<div class="w3-container w3-card-2 w3-white w3-round w3-margin"><br>
			<span class="w3-right w3-opacity">4 week</span><br>
			<div class="col-lg-3 col-md-6">
				<!-- Employe Aktif!-->
				<div class="panel panel-green">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-2 col-lg-1">
								<i class="fa fa-group fa-2x"></i>
							</div>							
							<div class="col-xs-2 col-lg-1 text-right">
								<!-- <div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div> !-->
								<?php echo $cntAktifEmp!=''? $cntAktifEmp:'0';; ?> 								
								<div>NOO</div>
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
			<div class="col-lg-3 col-md-6">
				<!-- Employe Aktif!-->
				<div class="panel panel-green">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-2 col-lg-1">
								<i class="fa fa-group fa-2x"></i>
							</div>							
							<div class="col-xs-2 col-lg-1 text-right">
								<!-- <div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div> !-->
								<?php echo $cntAktifEmp!=''? $cntAktifEmp:'0';; ?> 								
								<div>NOO</div>
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
			<div class="col-lg-3 col-md-6">
				<!-- Employe Aktif!-->
				<div class="panel panel-green">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-2 col-lg-1">
								<i class="fa fa-group fa-2x"></i>
							</div>							
							<div class="col-xs-3 col-lg-2 text-right">
								<!-- <div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div> !-->
								<?php echo $cntAktifEmp!=''? $cntAktifEmp:'0';; ?> 								
								<div>NOO</div>
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
			<div class="col-lg-3 col-md-6">
				<!-- Employe Aktif!-->
				<div class="panel panel-green">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-2 col-lg-1">
								<i class="fa fa-group fa-2x"></i>
							</div>							
							<div class="col-xs-2 col-lg-1 text-right">
								<!-- <div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div> !-->
								<?php echo $cntAktifEmp!=''? $cntAktifEmp:'0';; ?> 								
								<div>NOO</div>
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
			<hr class="w3-clear">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
			  <div class="w3-row-padding" style="margin:0 -16px">
				<div class="w3-half">
				  <img src="img_lights.jpg" style="width:100%" alt="Northern Lights" class="w3-margin-bottom">
				</div>
				<div class="w3-half">
				  <img src="img_nature.jpg" style="width:100%" alt="Nature" class="w3-margin-bottom">
			  </div>
			</div>
			<button type="button" class="w3-btn w3-theme-d1 w3-margin-bottom"><i class="fa fa-thumbs-up"></i> &nbsp;Like</button> 
			<button type="button" class="w3-btn w3-theme-d2 w3-margin-bottom"><i class="fa fa-comment"></i> &nbsp;Comment</button> 
      </div>
	</div> 
</div> 
	  