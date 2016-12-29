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
	$_indexGeneral=$this->render('_indexGeneral');
	
	/**
	 * Chart Sales MD.
	 * Status : Fixed.
	 * Customer Visit, Stock.
	 * Author piter novian [ptr.nov@gmail.com]
	*/
	$_indexSalesMd=$this->render('_indexSalesMd',[
		'searchModelIssue' => $searchModelIssue,
		'dataProviderIssue' => $dataProviderIssue
	]);

	/**
	 * Chart Distributor PO.
	 * Status 	: Fixed.
	 * Issue	: PO Online/ import PO manual / Po MTI/NKA
	 * Author piter novian [ptr.nov@gmail.com]
	*/
	$_indexDistibutor=$this->render('_indexDistibutor');
	
	/**
	 * Chart NKA PO.
	 * Status 	: Fixed.
	 * Issue	: PO Online/ import PO detail. NKA
	 * Author piter novian [ptr.nov@gmail.com]
	*/
	$_indexNKAPo=$this->render('_indexNKA');
	
	/**
	 * Chart Supplier PO.
	 * Status 	: Fixed.
	 * Issue	: PO under Purchasing.
	 * Author piter novian [ptr.nov@gmail.com]
	*/
	$_indexSupplierPo=$this->render('_indexSupplierPo');
	
	/**
	 * Chart TRAIDINg TERM.
	 * Status 	: Dev.
	 * Issue	: Inputan Term, Data sales.
	 * Author piter novian [ptr.nov@gmail.com]
	*/
	$_indexTerm=$this->render('_indexTerm');
	
	/**
	 * Chart Sales Schedule Visit.
	 * Status 	: Dev.
	 * Issue	: Outomaicly Setting 1 week.
	 * Author piter novian [ptr.nov@gmail.com]
	*/
	$_indexScdl=$this->render('_indexScdl');
	
	
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
						'label'=>'<i class="fa fa-balance-scale fa-2x"></i> Balance','content'=>$_indexGeneral,
						'active'=>true,
					],					
					[
						'label'=>'<i class="fa fa-university fa-2x"></i> PO Supplier','content'=>$_indexSupplierPo,
					],
					[
						'label'=>'<i class="fa fa-truck fa-2x"></i> Distributor Stock','content'=>$_indexDistibutor,
					],
					[
						'label'=>'<i class="fa fa-chain fa-2x"></i> Seles MD','content'=>$_indexSalesMd,
					],
					[
						'label'=>'<i class="fa fa-rocket fa-2x"></i> PO NKA','content'=>$_indexNKAPo,
					],					
					[
						'label'=>'<i class="fa fa-book fa-2x"></i> Trading Terms','content'=>$_indexTerm,	
					],
					[
						'label'=>'<i class="fa fa-calendar-o fa-2x"></i> Schaduling','content'=>$_indexScdl,	
					],
					[
						'label'=>'<i class="fa fa-sitemap fa-2x"></i> Component','content'=>$_indexComponent,	
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