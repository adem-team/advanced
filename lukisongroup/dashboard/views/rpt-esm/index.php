<?php

use kartik\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;

use lukisongroup\assets\AppAssetFusionChart;
AppAssetFusionChart::register($this);



//include("fusioncharts.php");
$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = '';                                    /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Reporting - PT.  Efembi Sukses Makmur');           /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/
?>

<div class="panel panel-default">
    
			<?php
			
				$content1='test ahhhhhhhhhhhhhhhhhhh';
				//$content2=$modelCustPrn[1]['PARENT_NM'];
				$content3=Yii::$app->controller->renderPartial('chart_customer',[
							'model_CustPrn'=>$model_CustPrn,
							'count_CustPrn'=>$count_CustPrn
				]);
				
				$exampleChart=Yii::$app->controller->renderPartial('fusionchart_example');
				
				$items=[
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> ESM Dashboard','content'=>$content3,
						'active'=>true,
						
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> SDM','content'=>$exampleChart,
						//active'=>true
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> Seles Order','content'=>'asdasd',//$content1,
						//active'=>true
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> Distributor','content'=>'asdasd',//$content1,
						//active'=>true
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> Customer','content'=>'asdasd',//$content1,
						//active'=>true
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i> Asset','content'=>'asdasd',//$content1,
						//active'=>true
					],
				];
			
				echo TabsX::widget([
						'items'=>$items,
						'position'=>TabsX::POS_ABOVE,
						//'height'=>TabsX::SIZE_TINY,
						'height'=>'100%',
						//'height'=>'200%',
						//'bordered'=>false,
						'encodeLabels'=>false,
						'align'=>TabsX::ALIGN_LEFT,						
					]);											
				?>
</div>