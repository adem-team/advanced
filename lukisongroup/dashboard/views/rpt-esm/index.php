<?php

use kartik\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;

// use lukisongroup\assets\AppAssetFusionChart;
// AppAssetFusionChart::register($this);



//include("fusioncharts.php");
$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = '';                                    /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Reporting - PT.  Efembi Sukses Makmur');           /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/
?>

   
<?php
	/**
	* MAP CUSTOMER.
	* Status : Fixed.
	* Customer Visit, Stock.
	* Author piter novian [ptr.nov@gmail.com]
	*/   
	$_indexMap=$this->render('_indexMap');
	
	/**
	 * Chart Sales MD.
	 * Status : Fixed.
	 * Customer Visit, Stock.
	 * Author piter novian [ptr.nov@gmail.com]
	*/
	$_indexSalesMd=$this->render('_indexSalesMd');

	/**
	 * Chart Component Saless.
	 * Status : Fixed.
	 * Customer Visit, Stock.
	 * Author piter novian [ptr.nov@gmail.com]
	*/
	$_indexComponent=Yii::$app->controller->renderPartial('chart_customer',[
		'model_CustPrn'=>$model_CustPrn,
		'count_CustPrn'=>$count_CustPrn,
		'dataEsmStockAll'=>$dataEsmStockAll,
		'graphEsmStockPerSku'=>$graphEsmStockPerSku
	]);
				
	
	
				$content1='test ahhhhhhhhhhhhhhhhhhh';
				//$content2=$modelCustPrn[1]['PARENT_NM'];
				
				$sideMenu_control='esm_customers';

				$exampleChart=Yii::$app->controller->renderPartial('fusionchart_example');
				
				$items=[
					[
						'label'=>'<i class="fa fa-map-marker fa-md"></i> Map','content'=>$_indexMap,
						'active'=>true,
					],					
					[
						'label'=>'<i class="fa fa-chain fa-md"></i> Seles','content'=>$_indexSalesMd,
					],
					[
						'label'=>'<i class="fa fa-truck fa-md"></i> PO Distributor','content'=>'',
					],
					[
						'label'=>'<i class="fa fa-rocket fa-md"></i> PO NKA','content'=>'',
					],
					[
						'label'=>'<i class="fa fa-university fa-md"></i> PO Supplier','content'=>'',
					],
					[
						'label'=>'<i class="fa fa-sitemap fa-md"></i> Component','content'=>$_indexComponent,	
					],
					[
						'label'=>'<i class="fa fa-calendar-o fa-md"></i> Schaduling','content'=>'',	
					],
					[
						'label'=>'<i class="fa fa-book fa-md"></i> Trading Terms','content'=>'',	
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> Example Chat','content'=>$exampleChart,
					]
				];
			
				$tabDdashboardEsm= TabsX::widget([
						'id'=>'id-tab-dashboard-esm',
						'items'=>$items,
						'position'=>TabsX::POS_ABOVE,
						//'height'=>TabsX::SIZE_TINY,
						'height'=>'100%',
						//'height'=>'200%',
						'bordered'=>false,
						'encodeLabels'=>false,
						'align'=>TabsX::ALIGN_LEFT,						
					]);											
				?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt; padding-top:-150px">
	<div class="row">
		<div  class="col-lg-12" >		
			<?=$tabDdashboardEsm?>
		</div>
	</div>
</div>