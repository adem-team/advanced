<?php
use kartik\helpers\Html;	
use ptrnov\fusionchart\Chart;
use ptrnov\fusionchart\ChartAsset;
use yii\helpers\Url;
ChartAsset::register($this);


	//DISTRIBUTOR STOCK
	/* $mslineDistGudang= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/rpt-esm-chart-salesmd/dist-stock-gudang',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'mscolumn3d',//msline//'bar3d',//'gantt',				//Chart Type 
		'renderid'=>'mscolumn3d-distributor-gudang',					//unix name render
		'autoRender'=>true,
		'width'=>'100%',
		'height'=>'400px',
		'chartOption'=>[				
			'caption'=>'Daily Customers Visits',										//Header Title
			'subCaption'=>'Custommer Call, Active Customer, Efictif Customer',			//Sub Title
			'xaxisName'=>'Parents',														//Title Bawah/ posisi x
			'yaxisName'=>'Total Child ', 												//Title Samping/ posisi y									
			'theme'=>'fint',															//Theme
			'is2D'=>"0",
			'showValues'=> "1",
			'palettecolors'=> "#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",
			'bgColor'=> "#ffffff",							//color Background / warna latar 
			'showBorder'=> "0",								//border box outside atau garis kotak luar
			'showCanvasBorder'=> "0",						//border box inside atau garis kotak dalam	
		],
	]);	 
	
	$mslineDistGudang= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/rpt-esm-chart-salesmd/dist-stock-gudang',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'mscolumn3d',//msline//'bar3d',//'gantt',				//Chart Type 
		'renderid'=>'mscolumn3d-distributor-gudang',					//unix name render
		'autoRender'=>true,
		'width'=>'100%',
		'height'=>'500%',
		'chartOption'=>[				
			'caption'=>'Daily Customers Visits',										//Header Title
			'subCaption'=>'Custommer Call, Active Customer, Efictif Customer',			//Sub Title
			'xaxisName'=>'Parents',														//Title Bawah/ posisi x
			'yaxisName'=>'Total Child ', 												//Title Samping/ posisi y									
			'theme'=>'fint',															//Theme
			'is2D'=>"0",
			'showValues'=> "1",
			'palettecolors'=> "#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",
			'bgColor'=> "#ffffff",							//color Background / warna latar 
			'showBorder'=> "0",								//border box outside atau garis kotak luar
			'showCanvasBorder'=> "0",						//border box inside atau garis kotak dalam	
		],
	]);	 
	
	$mslineDistPo= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/rpt-esm-chart-salesmd/visit-distributor-po',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'mscolumn3d',//msline//'bar3d',//'gantt',					//Chart Type 
		'renderid'=>'mscolumn3d-distributor-po-all',						//unix name render
		'autoRender'=>true,
		'width'=>'100%',
		'height'=>'500%',
		'chartOption'=>[				
			'caption'=>'Daily Customers Visits',			//Header Title
			'subCaption'=>'Custommer Call, Active Customer, Efictif Customer',			//Sub Title
			'xaxisName'=>'Parents',							//Title Bawah/ posisi x
			'yaxisName'=>'Total Child ', 					//Title Samping/ posisi y									
			'theme'=>'fint',								//Theme
			'is2D'=>"0",
			'showValues'=> "1",
			'palettecolors'=> "#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",
			'bgColor'=> "#ffffff",							//color Background / warna latar 
			'showBorder'=> "0",								//border box outside atau garis kotak luar
			'showCanvasBorder'=> "0",						//border box inside atau garis kotak dalam	
		],
	]);	  */

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
					<div style="min-height:400px"><div style="height:400px"><?=$this->render('_indexGeneralMap')?></div></div><div class="clearfix"></div>
				</div>
			</div>	
		</div>		
		
	</div>
