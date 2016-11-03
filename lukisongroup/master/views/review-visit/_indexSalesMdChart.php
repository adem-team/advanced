<?php
use kartik\helpers\Html;	
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\bootstrap\Modal;
use ptrnov\fusionchart\Chart;
use ptrnov\fusionchart\ChartAsset;
ChartAsset::register($this);

	$btn_srchChart = Html::button(Yii::t('app', 'Search Date'),
						['value'=>url::to(['ambil-tanggal-chart']),
						'id'=>'modalButtonChartTgl',
						'class'=>"btn btn-info btn-sm"						
					  ]);
					  
	$mslineCustomerVisit= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/rpt-esm-chart-salesmd/visit',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'msline',//msline//'bar3d',//'gantt',					//Chart Type 
		'renderid'=>'msline-salesmd-visit',								//unix name render
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
	]);	 
	
	$mslineCustomerVisitStock= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/rpt-esm-chart-salesmd/visit-stock',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'mscolumn3d',//msline//'bar3d',//'gantt',										//Chart Type 
		'renderid'=>'msline-salesmd-visit-stock',						//unix name render
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
	]);	 
	
	$mslineCustomerVisitRequest= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/rpt-esm-chart-salesmd/visit-request',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'mscolumn3d',//msline//'bar3d',//'gantt',										//Chart Type 
		'renderid'=>'msline-salesmd-visit-request',						//unix name render
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
	]);	 
	
	$mslineCustomerVisitSellout= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/rpt-esm-chart-salesmd/visit-sellout',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'mscolumn3d',//msline//'bar3d',//'gantt',										//Chart Type 
		'renderid'=>'msline-salesmd-visit-sellout',						//unix name render
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
	]);
?>


<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt; padding-top:-150px">
		<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">
			<div class="row" style="padding-bottom:10px" >
				<?php
					echo $btn_srchChart;					
				?>				
			</div>
		</div>	
		<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">
			<div class="row" >
				<?php
					 echo Html::panel(
						[
							'heading' => false,
							'body'=> $mslineCustomerVisit,
						],
						Html::TYPE_INFO
					);
				?>
				
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">
			<div class="row" >		
				<?php
					 echo Html::panel(
						[
							'heading' => false,
							'body'=> $mslineCustomerVisitStock,
						],
						Html::TYPE_INFO
					);
				?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">
			<div class="row" >		
				<?php
					 echo Html::panel(
						[
							'heading' => false,
							'body'=> $mslineCustomerVisitRequest,
						],
						Html::TYPE_INFO
					);
				?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">
			<div class="row" >		
				<?php
					 echo Html::panel(
						[
							'heading' => false,
							'body'=> $mslineCustomerVisitSellout,
						],
						Html::TYPE_INFO
					);
				?>
			</div>
		</div>
		<button id="print">Print</button>
</div>
<?php
	$this->registerJs("		
		$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
		$(document).on('click','#modalButtonChartTgl', function(ehead){ 			  
			$('#modal-chart-tgl').modal('show')
			.find('#modalContentChartTgl')
			.load(ehead.target.value);
		});		  
			 
	",$this::POS_READY);
	 
     Modal::begin([		
         'id' => 'modal-chart-tgl',		
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-search"></div><div><h4 class="modal-title"> SEARCH DATE</h4></div>',	
		 'size' => Modal::SIZE_SMALL,	
         'headerOptions'=>[		
                 'style'=> 'border-radius:5px; background-color: rgba(90, 171, 255, 0.7)',		
         ],		
     ]);		
		echo "<div id='modalContentChartTgl'></div>";
     Modal::end();
	 
	//$("#msline-salesmd-visit").updateFusionCharts({dataSource: 'jsonURL', dataFormat: 'MyNewChart.json’});

?>