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
use lukisongroup\assets\Profile;
Profile::register($this);
//use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
//AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/


$this->sideCorp = 'PT.Effembi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'sales_road';                                  	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - SALES IMAGE ROAD');          	/* title pada header page */
$this->params['breadcrumbs'][] = $this->title; 

	
	/**
	 * MODAL LINK  - CARA BARU TIDAK CONFLICT JQUERY.
	 * @author Piter Novian [ptr.nov@gmail.com].
	 * @since 2.0
	*/
	$btn_srchChart = Html::button(Yii::t('app', 'Search Date'),
						['value'=>url::to(['ambil-tanggal']),
						'id'=>'modalButtonChartTgl',
						'class'=>"btn btn-info btn-sm"						
					  ]);
	/**
	 * SPPINER LOAD.
	 * @author Piter Novian [ptr.nov@gmail.com].
	 * @since 2.0
	*/		  
	// $loadingSpinner1=Spinner::widget(['id'=>'spn1-load-road','preset' => 'large', 'align' => 'center', 'color' => 'blue']);
	// $loadingSpinner2=Spinner::widget(['id'=>'spn2-load-road','preset' => 'large', 'align' => 'center', 'color' => 'blue']);
	// $loadingSpinner3=Spinner::widget(['id'=>'spn3-load-road','preset' => 'large', 'align' => 'center', 'color' => 'blue']);
	
	
	/**
	 * CHART VENDOR - ptrnov\fusionchart\Chart.
	 * @author Piter Novian [ptr.nov@gmail.com].
	 * @since 2.0
	*/	
	$mslineSalsesVisit= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/esm-road/chart',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'stackedcolumn3d',//msline//'bar3d',//'gantt',					//Chart Type 
		'renderid'=>'msline-road-visit',								//unix name render
		'autoRender'=>true,
		'width'=>'100%',
		'height'=>'300px'
		
	]);	 		
	
	/**
	 * CHART VENDOR - ptrnov\fusionchart\Chart.
	 * @author Piter Novian [ptr.nov@gmail.com].
	 * @since 2.0
	*/	
	$pieSalsesVisit= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/esm-road/pie',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'pie3d',//msline//'bar3d',//'gantt',					//Chart Type 
		'renderid'=>'pie-road-sales',								//unix name render
		'autoRender'=>true,
		'width'=>'100%',
		'height'=>'300px',
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

	/**
	 * CHART VENDOR - ptrnov\fusionchart\Chart.
	 * @author Piter Novian [ptr.nov@gmail.com].
	 * @since 2.0
	*/	
	$barSalsesVisit= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/esm-road/pie',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'bar3d',//msline//'bar3d',//'gantt',					//Chart Type 
		'renderid'=>'bar-road-sales',								//unix name render
		'autoRender'=>true,
		'width'=>'100%',
		'height'=>'450px',
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

<div id="loaderPtr"></div>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt; padding-top:-150px">
    <div  class="row" style="padding-left: 5px; padding-right: 5px">	
        <div class="col-sm-12 col-md-12 col-lg-12">
			<?=$btn_srchChart?>
			<div class="w3-card-2 w3-round w3-white w3-center" style="margin-top:5px">
				<div class="panel-heading">
					<div class="row">						
						<div style="min-height:300px"><div style="height:300px"><?=$mslineSalsesVisit?></div></div><div class="clearfix"></div>
					</div>
					
				</div>	
			</div>		
        </div>
		<div class="col-sm-12 col-md-12 col-lg-12 ">			
			<div class="w3-card-2 w3-round w3-white w3-center" style="margin-top:5px;">
				<div class="panel-heading">
					<div class="row">						
						<div style="min-height:300px"><div style="height:300px"><?=$pieSalsesVisit?></div></div><div class="clearfix"></div>
					</div>						
				</div>	
			</div>			
       
			<div class="w3-card-2 w3-round w3-white w3-center" style="margin-top:5px">
				<div class="panel-heading">
					<div class="row">						
						<div style="min-height:450px"><div style="height:450px"><?=$barSalsesVisit?></div></div><div class="clearfix"></div>
					</div>						
				</div>	
			</div>							   
        </div>
    </div>
</div>

<?php
	/**
	 * MODAL LINK  - CARA BARU TIDAK CONFLICT JQUERY.
	 * @author Piter Novian [ptr.nov@gmail.com].
	 * @since 2.0
	*/
	$this->registerJs("		
		$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
		$(document).on('click','#modalButtonChartTgl', function(ehead){ 			  
			$('#modal-cari-tgl').modal('show')
			.find('#modalContentCariTgl')
			.load(ehead.target.value);
		});		  
			 
	",$this::POS_READY);
	 
     Modal::begin([		
         'id' => 'modal-cari-tgl',		
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-search"></div><div><h4 class="modal-title"> SEARCH DATE</h4></div>',	
		 'size' => Modal::SIZE_SMALL,	
         'headerOptions'=>[		
                 'style'=> 'border-radius:5px; background-color: rgba(90, 171, 255, 0.7)',		
         ],		
     ]);		
		echo "<div id='modalContentCariTgl'></div>";
     Modal::end();
	 
	 /**
	 * SPINNER -LOADING JQUERY STOP & RUN EVENT.
	 * @author Piter Novian [ptr.nov@gmail.com].
	 * @since 2.0
	*/
	$this->registerJs("	
		/* $(document).ready(function() {
			var spnr1= document.getElementById('spn1-load-road');
			var spnr2= document.getElementById('spn2-load-road');
			var spnr3= document.getElementById('spn3-load-road');
			$(document).bind('ajaxStart', function(){
				spnr1.hidden=false;
				spnr2.hidden=false;
				spnr3.hidden=false;
			});
			setTimeout(function(){			 
				spnr1.hidden=true;
				spnr2.hidden=true;
				spnr3.hidden=true;
			}, 1);
		});
		//Sppiner Event load Ajax -> Modal
		$(document).on('ajaxStop', function() {
			var spnr1= document.getElementById('spn1-load-road');
			var spnr2= document.getElementById('spn2-load-road');
			var spnr3= document.getElementById('spn3-load-road');
			spnr1.hidden=true;
			spnr2.hidden=true;
			spnr3.hidden=true;
		});  */
		
		// $(document).on('msline-road-visit', function() {
			// var s= document.getElementById('spn1-load-road1');
			// s.hidden=false;
		// }); 
		
		// $(document).load(function() {
			// var s= document.getElementById('spn1-load-road');
				 // s.show=true;
		// });
	
		// $(window).on('load',function(){ 
			// var s= document.getElementById('spn1-load-road');
			 // s.hidden=false;
		// });
		 // $(document).ajaxStart(function(){
			
				 // var s= document.getElementById('spn1-load-road');
				 // s.hidden=false;
			
		 // });
		
		 // $(document).ready(function() {
			// var s= document.getElementById('spn1-load-road');
			// s.hidden=false;
			// setTimeout(function(){
			 // var s= document.getElementById('spn1-load-road');
			// s.hidden=true;
			// }, 2000);
		// });
		// $(document.body).before(function() {							
			// var s= document.getElementById('spn1-load-road');
				// s.hidden=false; 
			
		// });    
		
		// $(window).bind('load', function() {
		   // var s= document.getElementById('spn1-load-road');
					// s.hidden=false;
		// });
		
		/* $(window).ready('load', function() { 
			var s= document.getElementById('spn1-load-road');
			s.hidden=false;
			setTimeout(function(){
			var s= document.getElementById('spn1-load-road');
			s.hidden=true;
			}, 2000);
		});   */

		
		
		// document.onreadystatechange = function () {
		  // if (document.readyState == 'interactive') {
			// var s= document.getElementById('spn1-load-road');
				// s.hidden=true;
		  // }
		// }	
			
			
			
		 // });	
		 
		 // $(document).on('load',function() {
				// var s= document.getElementById('spn1-load-road');
				// s.hidden=false;
		 // });
		 
		
     ",$this::POS_READY);
?>