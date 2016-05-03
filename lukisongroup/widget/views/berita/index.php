<?php
/* extensions */
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;

/* namespace models */
use lukisongroup\widget\models\Berita;
use lukisongroup\widget\models\Commentberita;
?>

<?php
/* grid view news inbox*/
$inbox =  Yii::$app->controller->renderPartial('inbox',[
	'searchModelInbox'=>$searchModelInbox,
	'dataProviderInbox'=>$dataProviderInbox
]);

/* grid view news outbox*/
 $outbox = Yii::$app->controller->renderPartial('outbox',[
	'searchModelOutbox'=>$searchModelOutbox,
	'dataProviderOutbox'=>$dataProviderOutbox
]);

/* grid view news History*/
$History = Yii::$app->controller->renderPartial('history',[
	'searchModelHistory'=>$searchModelHistory,
	'dataProviderHistory'=>$dataProviderHistory
]);

/* items tabs author : wawan */
$items = [
		[
				'label'=>'<i class="fa fa-sign-in fa-lg"></i> Inbox',
				'content'=>$inbox,
				'active'=>true
		],
		[
				'label'=>'<i class="fa fa-sign-out fa-lg"></i> Outbox',
				'content'=>$outbox,
		],
		[
				'label'=>'<i class="glyphicon glyphicon-briefcase"></i> History',
				'content'=>$History,
		],
];


?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
    <div  class="row" style="margin-top:15px">
        <div class="col-sm-12 col-md-12 col-lg-12" >
					<?php
					// Above
					echo TabsX::widget([
    						'items'=>$items,
    						'position'=>TabsX::POS_ABOVE,
    						'encodeLabels'=>false
							]);

					 ?>
		</div>
	</div>
</div>
