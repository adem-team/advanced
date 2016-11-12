<?php
use kartik\helpers\Html;
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
use dosamigos\gallery\Gallery;

	$items = [];
		foreach ($modelCustImg as $key => $value) {
		   $items[] = [
						'src'=>'data:image/pdf;base64,'.$value['IMG_NM_BASE64'],
						'imageOptions'=>['width'=>"120px",'height'=>"120px",'class'=>'img-rounded'], //setting image display
				];
		}
	$itemCustimge= Gallery::widget(['items' =>  $items]);
	echo Html::panel(
		[
			'heading' => "<i class='fa fa-info-circle fa-1x'></i> ATTACH FILE ",
			'body'=>$itemCustimge,
		],
		Html::TYPE_INFO
	);
?>
