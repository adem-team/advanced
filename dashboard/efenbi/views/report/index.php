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
?>



<?php
	$contentCustomer=Yii::$app->controller->renderPartial('_efenbi_chart_customer',[
			'CntrVisit'=>$CntrVisit,
			'model_CustPrn'=>$model_CustPrn,
			'count_CustPrn'=>$count_CustPrn,
			'dataEsmStockAll'=>$dataEsmStockAll,
			'graphEsmStockPerSku'=>$graphEsmStockPerSku
	]);
?>

<!--<div class="container-fluid" style="padding-left: 20px; padding-right: 20px;background-color:black;padding-top:0" >!-->
<div class="container-fluid" style="padding-left: 20px; padding-right: 20px" >
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">
					<?php
					 echo Html::panel(
						[
							'heading' => '<div>DASHBOARD - Saleman Visit</div>',
							//'body'=>'<div style="background-color:black">'.$contentCustomer.'</div>',
							'body'=>$contentCustomer,
							'options'=>[
								//'style'=>'background-color:black',
							],
						],
						Html::TYPE_INFO
					);
					?>
			</div>
		</div>
       <div class="row" >
			
		</div>
 </div>

