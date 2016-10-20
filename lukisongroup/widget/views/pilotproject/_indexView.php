<?php
use kartik\helpers\Html;	
use ptrnov\fusionchart\Chart;
use ptrnov\fusionchart\ChartAsset;
ChartAsset::register($this);

	
	$vwGrantPilotProject= Chart::Widget([
		'urlSource'=>'http://lukisongroup.com/widget/pilotproject/chart-test1',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'gantt',//'bar3d',//'gantt',										//Chart Type 
		'renderid'=>'chart-cust-parent',						//unix name render
		'width'=>'100%',
		'height'=>'500%',
		'chartOption'=>[				
			'caption'=>'Summary Customers Parents',			//Header Title
			'subCaption'=>'Children Count Details',			//Sub Title
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
	]);	 
?>



	<div class="row" >		
			<?php
				 echo Html::panel(
					[
						'heading' => false,
						'body'=> $vwGrantPilotProject,
					],
					Html::TYPE_INFO
				);
			?>
	</div>
