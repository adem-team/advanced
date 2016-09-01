<?php
use kartik\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use ptrnov\fusionchart\Chart;
use ptrnov\fusionchart\ChartAsset;
ChartAsset::register($this);

<<<<<<< HEAD

$this->sideCorp = 'ESM-Customers';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_customers';               /* kd_menu untuk list menu pada sidemenu, get from table of database */  


	$valCustAll=$count_CustPrn>0?$model_CustPrn[0]['COUNT_ALL_CUST']:0;
	$valCustModern=$count_CustPrn>0?$model_CustPrn[1]['COUNT_CUST']:0;
	$valCustGeneral=$count_CustPrn>0?$model_CustPrn[2]['COUNT_CUST']:0;
	$valCustHoreca=$count_CustPrn>0?$model_CustPrn[3]['COUNT_CUST']:0;
	$valCustOther=$count_CustPrn>0?$model_CustPrn[4]['COUNT_CUST']:0;
	// $data1=Json::encode($model_CustPrn);
	// print_r($dataProvider_CustPrn);
	// die();
	//$parentCustomrt='';
=======
$this->sideCorp = 'ESM-Customers';              
$this->sideMenu = 'esm_customers';             

>>>>>>> e02eec9ee56de2edd082b1f2c48c368917fc2ec6
	$parentCustomrt= Chart::Widget([
		'dataArray'=>$parenCustomer,							//array scource model or manual array or sqlquery
		'dataField'=>['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'bar3d',										//Chart Type 
		'renderid'=>'chart-cust-parent',						//unix name render
		'width'=>'100%',
		'height'=>'500%',
		'chartOption'=>[				
				'caption'=>'Summary Customers Parents',			//Header Title
				'subCaption'=>'Children Count Details',			//Sub Title
				'xaxisName'=>'Parents',							//Title Bawah/ posisi x
				'yaxisName'=>'Total Child ', 					//Title Samping/ posisi y									
<<<<<<< HEAD
				'theme'=>'fint',					//Theme
=======
				'theme'=>'fint',								//Theme
>>>>>>> e02eec9ee56de2edd082b1f2c48c368917fc2ec6
				'is2D'=>"0",
				'showValues'=> "1",
				'palettecolors'=> "#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",
				'bgColor'=> "#ffffff",							//color Background / warna latar 
				'showBorder'=> "0",								//border box outside atau garis kotak luar
				'showCanvasBorder'=> "0",						//border box inside atau garis kotak dalam	
		],
	]);	 
	
	$kategoriCustomrt= Chart::Widget([
<<<<<<< HEAD
		'dataArray'=>$dataProvider_CustPrn,						//array scource model or manual array or sqlquery
		'dataField'=>['PARENT_NM','COUNT_CUST'],				//field['label','value'], normaly value is numeric
		'type'=>'pyramid',										//Chart Type 
		'renderid'=>'chart-piramid1',							//unix name render
		'width'=>'100%',
		'height'=>'300',
		'chartOption'=>[				
				'caption'=>'Summary Customers Parent',			//Header Title
				'subCaption'=>'Count Child Details',			//Sub Title
				//'xaxisName'=>'Parent',							//Title Bawah/ posisi x
				//'yaxisName'=>'Total Child ', 					//Title Samping/ posisi y									
				'theme'=>'fint',								//Theme
				//'palettecolors'=> "#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",
				'bgColor'=> "#ffffff",							//color Background / warna latar 
				'showBorder'=> "0",								//border box outside atau garis kotak luar
				'showCanvasBorder'=> "1",						//border box inside atau garis kotak dalam	
				'is2D'=>"0",									//boolean
				'showValues'=>"1",								//boolean
				'showLegend'=>"0",								//boolean
				'showPercentValues'=>"1"						//boolean
		],
=======
		'dataArray'=>$parentKategori,							//array scource model or manual array or sqlquery
		'dataField'=>['CUST_KTG_NM','CUST_CNT'],				//field['label','value'], normaly value is numeric
		'type'=>'pyramid',										//Chart Type 
		'renderid'=>'chart-piramid1',							//unix name render
		'width'=>'100%',
		'height'=>'350',
		'chartOption'=>[				
				'caption'=>'Summary Category Parent',			//Header Title
				'alignCaptionWithCanvas'=>"2",					//Aligin Caption
				'theme'=>'fint',								//Theme
				'bgColor'=> "#ffffff",							//color Background / warna latar 
				'showBorder'=> "0",								//border box outside atau garis kotak luar
				'showCanvasBorder'=> "1",						//border box inside atau garis kotak dalam	
				'is2D'=>"0",									//boolean, 3D
				'showValues'=>"1",								//boolean, show value
				'showLegend'=>"1",								//boolean, show legend
				'showPercentValues'=>"1"						//boolean,percent show
		],
	]);

	$listKategori= Chart::Widget([
		'dataArray'=>$ChartCountKategori,						//array scource model or manual array or sqlquery
		'dataField'=>['KTG_NM','CUST_CNT'],						//field['label','value'], normaly value is numeric
		'type'=>'column3d',										//Chart Type 
		'renderid'=>'chart-cust-ktg',							//unix name render
		'width'=>'100%',
		'height'=>'270%',
		'chartOption'=>[				
				'caption'=>'Summary Customers Category Detail',	//Header Title
				'xaxisName'=>'Category Name',					//Title Bawah/ posisi x
				'yaxisName'=>'Count ', 							//Title Samping/ posisi y									
				'theme'=>'fint',								//Theme
				'is2D'=>"0",
				'showValues'=> "1",
				'palettecolors'=> "#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",
				'bgColor'=> "#ffffff",							//color Background / warna latar 
				'showBorder'=> "0",								//border box outside atau garis kotak luar
				'showCanvasBorder'=> "0",						//border box inside atau garis kotak dalam	
		],
>>>>>>> e02eec9ee56de2edd082b1f2c48c368917fc2ec6
	]);	 	
?>

<div class="container-fluid" style="padding-left: 10px; padding-right: 10px" >
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">			
<<<<<<< HEAD
			<div class="row">	
			
				<!-- KANAN !-->
=======
			<div class="row">				
				<!-- KIRI !-->
>>>>>>> e02eec9ee56de2edd082b1f2c48c368917fc2ec6
				<div class="col-lg-7 col-md-7" style="padding-top:10px">
					<?php
						 echo Html::panel(
							[
<<<<<<< HEAD
							//'heading' => '<a class="btn btn-info btn-xs full-right" href="/efenbi/report"><< BACK MENU </a> All Customer Category',
=======
							'heading' => false,
>>>>>>> e02eec9ee56de2edd082b1f2c48c368917fc2ec6
								'body'=> $parentCustomrt,
							],
							Html::TYPE_INFO
						);						
					?>
				</div>
<<<<<<< HEAD
				<!-- KIRI !-->
				<div class="col-lg-5 col-md-5" style="padding-top:10px">
					<!--<div id="chart-piramid1"></div>!-->
=======
				<!-- KANAN !-->
				<div class="col-lg-5 col-md-5" style="padding-top:10px">
>>>>>>> e02eec9ee56de2edd082b1f2c48c368917fc2ec6
					<?=$kategoriCustomrt?>
				</div>
			</div>
		</div>
		<!-- FULL !-->
		<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12 full-right">			
			<?php
				 echo Html::panel(
					[
						'heading' => false,
						'body'=> $listKategori,
					],
					Html::TYPE_INFO
				);
			?>
		</div>
	</div>
</div>

<<<<<<< HEAD
<?php
	$this->registerJs('
		/* 
		 * GRAPH PIRAMIT ALL CUSTOMER
		 * @author piter [ptr.nov@gmail.com]
		 * @since 1.1
		*/
		$(document).ready(function () {
			var myPiramidChart = new FusionCharts({
				type: "pyramid",
				width: "100%",
				//height: "100%",
				dataFormat: "jsonurl",			
				renderAt: "chart-piramid",
				dataFormat: "json",
				dataSource: {
					chart: {
						//theme: "fint",
						caption: "Customer Category",
						"alignCaptionWithCanvas": "2",
						//subcaption: "Credit Suisse 2013",
						//captionOnTop: "1",
						//captionPadding: "25",
						//alignCaptionWithCanvas: "1",						
						//subCaptionFontSize: "12",
						borderAlpha: "1",
						is2D: "0",
						//bgColor: "#ffffff", //ok
						//showValues: "1",
						showLegend: "1",
						//numberPrefix: "$",
						//numberSuffix: "M",
						showPercentValues: "1",
						//chartLeftMargin: "40"
					},
					data: [
							  {
								 label: "Modern",
								 value: "'.$valCustModern.'"
							  },
							  {
								 label: "Horeca",
								 value: "'.$valCustHoreca.'"
							  },
							  {
								 label: "General",
								 value: "'.$valCustGeneral.'"
							  },
							  {
								 label: "Other",
								 value: "'.$valCustOther.'"
							  }
					   ]
				}
			});
			myPiramidChart.render();
		});
	',$this::POS_READY);
?>

<?php
	$this->registerJs('
		/* 
		 * GRAPH MODERN CUSTOMER PARENT VS SALES COMPARE
		 * @author piter [ptr.nov@gmail.com]
		 * @since 1.1
		*/
		$(document).ready(function () {
			var ChartSalesCompare = new FusionCharts({
				type: "msline",
				renderAt: "chart-cust-active-call",
				width: "100%",
				height: "80%",
				dataFormat: "json",
				dataSource: {
					"chart": {
						"caption": "Customer Active Call",
						//"subCaption": "Customers Modern",
						//"subCaption": "Sales Compare",
						"captionFontSize": "14",
						"subcaptionFontSize": "14",
						"subcaptionFontBold": "0",
						"palettecolors": "#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",
						"bgcolor": "#ffffff",
						"showBorder": "1",
						"showShadow": "0",
						"showCanvasBorder": "0",
						"usePlotGradientColor": "0",
						"legendBorderAlpha": "0",
						"legendShadow": "0",
						"showAxisLines": "0",
						"showAlternateHGridColor": "0",
						"divlineThickness": "1",
						"divLineIsDashed": "1",
						"divLineDashLen": "1",
						"divLineGapLen": "1",
						"xAxisName": "Day",
						"showValues": "0", 
						"showXAxisLine": "1",
						"plotBorderAlpha": "10",
						borderAlpha: "20",
						bgColor: "#ffffff",
						usePlotGradientColor: "0",
						plotBorderAlpha: "10", 
						showAlternateHGridColor: "0",
						showXAxisLine: "1",
						
					},
					"categories": [
						{
							"category": '.$cac_ctg.',
							/* [
								{ "label": "Mon" }, 
								{ "label": "Tue" }, 
								{ "label": "Wed" },
								{
									"vline": "true",
									"lineposition": "0",
									"color": "#6baa01",
									"labelHAlign": "center",
									"labelPosition": "0",
									"label": "National holiday",
									"dashed":"1"
								},
								{ "label": "Thu" }, 
								{ "label": "Fri" }, 
								{ "label": "Sat" }, 
								{ "label": "Sun" }
							] */
						}
					],
					"dataset": '.$cac_val.',
						/* [
							{
								"seriesname": "Bakersfield Central",
								"data": [
									{ "value": "15123" }, 
									{ "value": "14233" }, 
									{ "value": "25507" }, 
									{ "value": "9110" }, 
									{ "value": "15529" }, 
									{ "value": "20803" }, 
									{ "value": "19202" }
								]
							}, 
							{
								"seriesname": "Los Angeles Topanga",
								"data": [
									{ "value": "13400" }, 
									{ "value": "12800" }, 
									{ "value": "22800" }, 
									{ "value": "12400" }, 
									{ "value": "15800" }, 
									{ "value": "19800" }, 
									{ "value": "21800" }
								]
							}
						],  */
					"trendlines": [
						{
							"line": [
								{
									"startvalue": "17022",
									"color": "#6baa01",
									"valueOnRight": "1",
									"displayvalue": "Average"
								}
							]
						}
					]
				}
			}).render();
		});
	',$this::POS_READY);
?>


=======
>>>>>>> e02eec9ee56de2edd082b1f2c48c368917fc2ec6


