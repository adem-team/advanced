<?php
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use app\models\hrd\Dept;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;
use yii\helpers\Json;
use yii\web\Response;
use lukisongroup\assets\AppAssetFusionChart;
AppAssetFusionChart::register($this);
	
?>

<?php
	
	
	/* echo Html::panel(
		['heading' => 'Employee Properties', 'body' =>$kedua],
		Html::TYPE_SUCCESS
	); */

?>

<div style="backgroud:black">
    <div class="row" style="padding-left: 5px; padding-right: 5px">
        <div class="col-sm-6 col-md-6 col-lg-6 ">			
			<?php
				$content_cc_support=Yii::$app->controller->renderPartial('_graph_cc_support',[
					// 'model_CustPrn'=>$model_CustPrn,
					// 'count_CustPrn'=>$count_CustPrn
				]);
				echo Html::panel([
					//'heading' => 'Cost Center Support', 
					'body' => $content_cc_support
				],
					Html::TYPE_INFO
				);
			?>
		</div>
		<div class="col-sm-6 col-md-6 col-lg-6 ">
			<?php
				$content_cc_bisnis=Yii::$app->controller->renderPartial('_graph_cc_bisnis',[
					// 'model_CustPrn'=>$model_CustPrn,
					// 'count_CustPrn'=>$count_CustPrn
				]); 
				echo Html::panel([
					//'heading' => 'Cost Center Businis', 
					'body' => $content_cc_bisnis
				],
					Html::TYPE_INFO
				);
			?>
		</div>
    </div>
</div>
