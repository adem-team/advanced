<?php
use kartik\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;

use dashboard\assets\AppAssetFusionChart;
AppAssetFusionChart::register($this);


$this->sideCorp = 'PT. ESM';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'effenbi_dboard';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


	$valCustAll=$count_CustPrn>0?$model_CustPrn[0]['COUNT_ALL_CUST']:0;
	$valCustModern=$count_CustPrn>0?$model_CustPrn[1]['COUNT_CUST']:0;
	$valCustGeneral=$count_CustPrn>0?$model_CustPrn[2]['COUNT_CUST']:0;
	$valCustHoreca=$count_CustPrn>0?$model_CustPrn[3]['COUNT_CUST']:0;
	$valCustOther=$count_CustPrn>0?$model_CustPrn[4]['COUNT_CUST']:0;
?>



<?php
	   $contentCustomer=Yii::$app->controller->renderPartial('_efenbi_chart_customer',[
			'CntrVisit'=>$CntrVisit,
			'model_CustPrn'=>$model_CustPrn,
			'count_CustPrn'=>$count_CustPrn,
			'graphSchaduleWinLoss'=>$graphSchaduleWinLoss,
			'graphEsmStockPerSku'=>$graphEsmStockPerSku
	]);   
	   $contentSalesInventory=Yii::$app->controller->renderPartial('_efenbi_chart_sales_inventory',[
			'dataSalesInventory'=>$dataSalesInventory
	]);   	
	 $this->registerJs('
			/*
			 * AUTO LOAD
			 * @author piter [ptr.nov@gmail.com]
			 * @since 1.2
			*/
			jQuery(document).ready(function($)
				{	
					
	
					$(function() {
                        startRefresh();
                    });

                    //auto reload data
                    function startRefresh() {
                        //setTimeout(startRefresh,500000);
						//$("#cnt-sales-visits-id").load(location.href + " #cnt-sales-visits-id");
                       //$("#chart-visit-cnt-id").load(location.href + "#chart-visit-cnt-id");	
						//$("#sales-inventory").load(location.href + "#sales-inventory");
						//Custommer All
						setTimeout(function(){ document.getElementById("cust-all-id").innerHTML="'.$valCustAll.'"}, 3000);
						//Custommer Modern		
						setTimeout(function(){ document.getElementById("cust-medern-id").innerHTML="'.$valCustModern.'"}, 3000);
						//Custommer General
						setTimeout(function(){ document.getElementById("cust-general-id").innerHTML="'.$valCustGeneral.'"}, 3000);
						//Custommer Horeca
						setTimeout(function(){ document.getElementById("cust-horeca-id").innerHTML="'.$valCustHoreca.'"}, 3000);
						//Custommer Other
						setTimeout(function(){ document.getElementById("cust-other-id").innerHTML="'.$valCustOther.'"}, 3000);
					
						setTimeout(function(){
							$("#sales-inventory").load(location.href + "#sales-inventory");	
						},30000);					
						
						//window.addEventListener("load", ubahData()); 	
						
                    }
					
					
					
				}); 

			
			
					
			
				
',$this::POS_READY); 
	
	
?>

<!--<div class="container-fluid" style="padding-left: 20px; padding-right: 20px;background-color:black;padding-top:0" >!-->
<div class="container-fluid" style="padding-left: 20px; padding-right: 20px" >
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">
					<?php
					//print_r($dataSalesInventory);
					  echo Html::panel(
						[
							'heading' => '<div>SALESMAN  VISIT</div>',
							//'body'=>'<div style="background-color:black">'.$contentCustomer.'</div>',
							'body'=>$contentCustomer,
							'options'=>[
								//'style'=>'background-color:black',
							],
						],
						Html::TYPE_INFO
					); 
					  
					 echo Html::panel(
						[
							'heading' => '<div>INVENTORY</div>',
							//'body'=>'<div style="background-color:black">'.$contentCustomer.'</div>',
							'body'=>$contentSalesInventory,
							'options'=>[
								//'style'=>'background-color:black',
							],
						],
						Html::TYPE_INFO
					); 
					?>
			</div>
		</div>
 </div>

