<?php
use kartik\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use yii\db\ActiveRecord;
use yii\data\ArrayDataProvider;

?>
<div class="row" style="font-family: tahoma ;font-size: 9pt">
	<!-- PARTIES/PIHAK !-->
	<div class="col-xs-12 col-sm-12 col-md-12" style="font-family: tahoma ;font-size: 9pt">
		<?php
			$expandActual=$this->render('_viewDataExpandActual',[
				'dataProviderBudgetdetail_inves'=>$dataProviderBudgetdetail_inves
			]);
			
			$expandPlan=$this->render('_viewDataExpandPlan',[
				'dataProviderDetailBudget'=>$dataProviderDetailBudget
			]); 
			
			$items=[
				[
					'label'=>'<i class="fa fa-mortar-board fa-lg"></i>Plan budget','content'=>$expandPlan,
					// 'active'=>true,
					'options' => ['id' => 'term-detail-plan-budget'.$id],
				],
				[
					'label'=>'<i class="fa fa-bar-chart fa-lg"></i>  Actual Budget','content'=>$expandActual,
					'options' => ['id' => 'term-chart-actual-budget'.$id],
				],	
				[
					'label'=>'<i class="fa fa-bar-chart fa-lg"></i>  Chart','content'=>'',
					'options' => ['id' => 'term-chart-actual-budget'.$id],
				]			
			];
			echo TabsX::widget([
				'id'=>'tab-detail-plan-actual'.$id,
				'items'=>$items,
				'position'=>TabsX::POS_ABOVE,
				'bordered'=>true,
				'encodeLabels'=>false
			]);				
		?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12" style="font-family: tahoma ;font-size: 9pt">
		<?php
			//echo $gvDetalBudget;
		?>
	</div>
</div>
