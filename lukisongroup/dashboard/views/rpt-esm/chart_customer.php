<div class="row" style="padding-left:15px; padding-right:15px;">
	<!-- KIRI !-->
	<div class="col-lg-3 col-md-3">
		<div class="row">		
			<!-- CUSTOMER TTL 1!-->
			<div class="panel"  style="background-color:rgba(174, 255, 0, 0.6)">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-3">
							<i class="fa fa-users fa-4x"></i>
						</div>
						
						<div class="col-lg-9 text-right">
							<!--<div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div>!-->
							<div class="huge"><?php echo $modelCustPrn[0]['COUNT_CUST']; ?> </div>
							<div><?php echo 'Customers '.$modelCustPrn[0]['PARENT_NM']; ?></div>
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
							<div class="huge"><?php echo $modelCustPrn[0]['COUNT_CUST']; ?> </div>
							<div><?php echo 'Customers '.$modelCustPrn[0]['PARENT_NM']; ?></div>
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
							<div class="huge"><?php echo $modelCustPrn[1]['COUNT_CUST']; ?> </div>
							<div><?php echo 'Customers '.$modelCustPrn[1]['PARENT_NM']; ?></div>
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
		<div class="panel panel-yellow">
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
							<div class="huge"><?php echo $modelCustPrn[2]['COUNT_CUST']; ?> </div>
							<div><?php echo 'Customers '.$modelCustPrn[2]['PARENT_NM']; ?></div>
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
							<div class="huge"><?php echo $modelCustPrn[2]['COUNT_CUST']; ?> </div>
							<div><?php echo 'Customers '.$modelCustPrn[2]['PARENT_NM']; ?></div>
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
							<div class="huge"><?php echo $modelCustPrn[2]['COUNT_CUST']; ?> </div>
							<div><?php echo 'PRODAK '.$modelCustPrn[2]['PARENT_NM']; ?></div>
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