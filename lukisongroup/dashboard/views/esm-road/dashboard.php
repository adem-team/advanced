<?php
use kartik\helpers\Html;
use kartik\widgets\Spinner;	
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\bootstrap\Modal;
use ptrnov\fusionchart\Chart;
use ptrnov\fusionchart\ChartAsset;
ChartAsset::register($this);
//use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
//AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/


$this->sideCorp = 'PT.Effembi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'sales_road';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - SALES IMAGE ROAD');          				/* title pada header page */
$this->params['breadcrumbs'][] = $this->title; 

	$btn_srchChart = Html::button(Yii::t('app', 'Search Date'),
						['value'=>url::to(['ambil-tanggal-chart']),
						'id'=>'modalButtonChartTgl',
						'class'=>"btn btn-info btn-sm"						
					  ]);
	$loading=Spinner::widget(['id'=>'spn1-load-road','preset' => 'large', 'align' => 'center', 'color' => 'blue']);
	$mslineSalsesVisit= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/esm-road/chart',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'msline',//msline//'bar3d',//'gantt',					//Chart Type 
		'renderid'=>'msline-salesmd-visit',								//unix name render
		'autoRender'=>true,
		'width'=>'100%',
		'height'=>'250px',
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
    <div class="row" style="padding-left: 5px; padding-right: 5px">
	
        <div class="col-sm-12 col-md-12 col-lg-12">
            <?php
			
            echo Html::panel(
                ['heading' => 'VISIT ACTIVITIES '.$btn_srchChart, 'body' =>'<div style="min-height:250px"><div style="height:250px">'.$mslineSalsesVisit.'</div></div><div class="clearfix"></div>'],
                Html::TYPE_SUCCESS
            );
            ?>
        </div>
		<?=$loading;?>
		 <div class="col-sm-4 col-md-4 col-lg-4 ">
            <?php
            echo Html::panel(
                ['heading' => 'ACTIVITY PERCENTAGE' , 'body' => ''],
                Html::TYPE_SUCCESS
            );
            ?>
        </div>
    </div>
</div>

<?php
$this->registerJs("		
		// $(window).on('load',function(){ 
			// var s= document.getElementById('spn1-load-road');
			 // s.hidden=false;
		// });
		 // $(document).ajaxStart(function(){
			// $(document).ready(function() {
				 // var s= document.getElementById('spn1-load-road');
				 // s.hidden=false;
			// });
		 // });
		$(document).ready(function() {
			var s= document.getElementById('spn1-load-road');
			s.hidden=false;
			setTimeout(function(){
			 var s= document.getElementById('spn1-load-road');
			s.hidden=true;
			}, 3000);

		});
		
		// document.onreadystatechange = function () {
		  // if (document.readyState == 'interactive') {
			// var s= document.getElementById('spn1-load-road');
				// s.hidden=true;
		  // }
		// }	
			
			
			
		 // });	
		 // $(document).on('ajaxStop', function() {
				// var s= document.getElementById('spn1-load-road');
				// s.hidden=true;
		  // });
		  
		  
     ",$this::POS_READY);
?>