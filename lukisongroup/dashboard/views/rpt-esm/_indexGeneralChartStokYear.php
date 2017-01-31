<?php
use kartik\helpers\Html;	
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\bootstrap\Modal;
use ptrnov\fusionchart\Chart;


	$btn_srchChart = Html::button(Yii::t('app', 'Search Date'),
		['value'=>url::to(['ambil-tanggal-chart']),
		'id'=>'modalButtonDashboardChartTgl',
		'class'=>"btn btn-info btn-sm"						
	]);
	//DISTRIBUTOR STOCK YEARLY 
	$distStockGudang= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/rpt-esm-chart-salesmd/dist-all-stock-gudang',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'msline',//msline//'bar3d',//'gantt',				//Chart Type 
		'renderid'=>'msline-distributor-stockgudang',					//unix name render
		'autoRender'=>true,
		'width'=>'100%',
		'height'=>'400px'
	]);	 
	
?>
<?=$distStockGudang?>
<?php
	$this->registerJs("		
		$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
		$(document).on('click','#modalButtonDashboardChartTgl', function(ehead){ 			  
			$('#modal-dashboard-chart-tgl').modal('show')
			.find('#modalContentChartTgl')
			.load(ehead.target.value);
		});		  
			 
	",$this::POS_READY);
	 
     Modal::begin([		
         'id' => 'modal-dashboard-chart-tgl',		
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-search"></div><div><h4 class="modal-title"> SEARCH DATE</h4></div>',	
		 'size' => Modal::SIZE_SMALL,	
         'headerOptions'=>[		
                 'style'=> 'border-radius:5px; background-color: rgba(90, 171, 255, 0.7)',		
         ],		
     ]);		
		echo "<div id='modalContentChartTgl'></div>";
     Modal::end();
?>