<?php
use kartik\helpers\Html;	
use ptrnov\fusionchart\Chart;
use ptrnov\fusionchart\ChartAsset;
use yii\helpers\Url;
ChartAsset::register($this);
?>

<div class="col-sm-12 col-md-12 col-lg-12" style="margin-top:10px">
	<div class="w3-card-2 w3-round w3-white w3-center">
		<div class="panel-heading">
			<div class="row">
				<div style="min-height:400px"><div style="height:400px"><?=$this->render('_indexGeneralChartStokYear')?></div></div><div class="clearfix"></div>
			</div>
		</div>	
	</div>			
</div>	
<!--<button id="print">Print</button>!-->
<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12" style="margin-top:10px">	
	<div class="w3-card-2 w3-round w3-white w3-center">
		<div class="panel-heading">
			<div class="row">
				<!--<div style="min-height:400px"><div style="height:400px"><?php //$this->render('_indexGeneralMap')?></div></div><div class="clearfix"></div>!-->
				<div style="min-height:400px"><div style="height:400px"><?=$this->render('_indexGeneralChartSalesPOYear')?></div></div><div class="clearfix"></div>
			</div>
		</div>	
	</div>		
	
</div>
