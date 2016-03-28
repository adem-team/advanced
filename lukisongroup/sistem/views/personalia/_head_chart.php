<?php
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use lukisongroup\assets\AppAssetFusionChart;
AppAssetFusionChart::register($this);
//use lukisongroup\dashboard\models\FusionCharts; 

?>

<div  class="row">
	<div class="col-sm-3 col-md-3 col-lg-3">
		<div class="panel  panel-red">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-3">
						<i class="fa fa-book fa-3x"></i>
					</div>
					<div class="col-lg-9 text-right">
						<!--<div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div>!-->
						<div class="huge"><?php echo '12';//$count_CustPrn>0?$model_CustPrn[0]['COUNT_CUST']:0;?> </div>
						<div><?php //echo $count_CustPrn>0?'Customers '.$model_CustPrn[0]['PARENT_NM']:'None';?></div>
					</div>
				</div>
			</div>
			<a href="/master/barang">
				<div class="panel-footer">
					<span class="pull-left">Cuti Sekarang</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-sm-3 col-md-3 col-lg-3">
		<div class="panel  panel-red">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-3">
						<i class="fa fa-bookmark fa-3x"></i>
					</div>
					<div class="col-lg-9 text-right">
						<!--<div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div>!-->
						<div class="huge"><?php echo '12';//$count_CustPrn>0?$model_CustPrn[0]['COUNT_CUST']:0;?> </div>
						<div><?php //echo $count_CustPrn>0?'Customers '.$model_CustPrn[0]['PARENT_NM']:'None';?></div>
					</div>
				</div>
			</div>
			<a href="/master/barang">
				<div class="panel-footer">
					<span class="pull-left">Cuti Lalu</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-sm-3 col-md-3 col-lg-3">
		<div class="panel  panel-red">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-3">
						<i class="fa fa-clone fa-3x"></i>
					</div>
					<div class="col-lg-9 text-right">
						<!--<div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div>!-->
						<div class="huge"><?php echo '12';//$count_CustPrn>0?$model_CustPrn[0]['COUNT_CUST']:0;?> </div>
						<div><?php //echo $count_CustPrn>0?'Customers '.$model_CustPrn[0]['PARENT_NM']:'None';?></div>
					</div>
				</div>
			</div>
			<a href="/master/barang">
				<div class="panel-footer">
					<span class="pull-left">Sisa Cuti</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-sm-3 col-md-3 col-lg-3">
		<div class="panel  panel-red">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-3">
						<i class="fa fa-users fa-3x"></i>
					</div>
					<div class="col-lg-9 text-right">
						<!--<div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div>!-->
						<div class="huge"><?php echo '12';//$count_CustPrn>0?$model_CustPrn[0]['COUNT_CUST']:0;?> </div>
						<div><?php //echo $count_CustPrn>0?'Customers '.$model_CustPrn[0]['PARENT_NM']:'None';?></div>
					</div>
				</div>
			</div>
			<a href="/master/barang">
				<div class="panel-footer">
					<span class="pull-left">penggunaan Cuti</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
</div>
