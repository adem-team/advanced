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
				'theme'=>'fint',								//Theme
				'is2D'=>"0",
				'showValues'=> "1",
				'palettecolors'=> "#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",
				'bgColor'=> "#ffffff",							//color Background / warna latar 
				'showBorder'=> "0",								//border box outside atau garis kotak luar
				'showCanvasBorder'=> "0",						//border box inside atau garis kotak dalam	
		],
	]);	 
	
	$kategoriCustomrt= Chart::Widget([
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
	]);	 	
?>

<div class="container-fluid" style="padding-left: 10px; padding-right: 10px" >
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">			
			<div class="row">				
				<!-- KIRI !-->
				<div class="col-lg-7 col-md-7" style="padding-top:10px">
					<?php
						 echo Html::panel(
							[
							'heading' => false,
								'body'=> $parentCustomrt,
							],
							Html::TYPE_INFO
						);						
					?>
				</div>
				<!-- KANAN !-->
				<div class="col-lg-5 col-md-5" style="padding-top:10px">
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
